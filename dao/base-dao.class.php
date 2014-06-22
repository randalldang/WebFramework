<?php
/**
 * This is the base class used to operate the common db accesss..
 */
class BaseDao {
	
	/**
	 * Constructor function. Initialize the cache entity.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Atom function used to copy values from db row to one entity object.
	 * @param $entity object which extends Entity class.
	 * @param $table_row, the data of one row in db, it is array format, returned by db_fetch_array
	 */
	protected function initialEntity(Entity &$entity, $table_row) {
		if (NULL == $entity) {
			throw new DBException ( db_handler () ); //TODO: Update the exception.
		}
		
		$this->iniYmlSetting ( $entity );

		$fields = array_flip ( $entity->fields );
		
		foreach ( $table_row as $key => $value ) {
			$entity_property = $fields [$key];
			$entity->$entity_property = $value;
		}
	}
	
	/**
	 * Excutes the db query, this function only be used when the multipal tables need to be queried.
	 * @param mixed $tables array or string specifies tables
	 * @param mixed $cols array or string specifies fetched fields
	 * @param mixed $conditions array or string specifies conditions
	 * @param string $others other conditions like GROUP BY, ORDER BY, LIMIT...
	 * @return array $rows contains the query result.
	 */
	protected function select($db_name, $tables, $cols, $conditions, PagerOrder $pager_order = NULL) {
		$others = '';
		if (NULL != $pager_order) {
			$other_conditions = array ();
			
			if (! $this->emptyValue ( $pager_order->group_by )) {
				$other_conditions [] = $pager_order->group_by;
			}
			
			if (! $this->emptyValue ( $pager_order->order_by )) {
				$other_conditions [] = $pager_order->order_by;
			}
			
			if (! $this->emptyValue ( $pager_order->cur_page ) && ! $this->emptyValue ( $pager_order->rows_per_page )) {
				$other_conditions [] = 'LIMIT ' . ($pager_order->cur_page - 1) * $pager_order->rows_per_page . ', ' . $pager_order->rows_per_page;
			}
			
			if (count ( $other_conditions ) > 0) {
				$others = implode ( ' ', $other_conditions );
			}
		}
		
		$sql = Convert::toSqlSelect ( $tables, $cols, $conditions, $others );
		db_set_active ( $db_name );
		
		$result = db_query ( $sql );
		$total = db_num_rows ( $result );
		$rows = array ();
		for($i = 0; $i < $total; $i ++) {
			$rows [] = db_fetch_array ( $result );
		}
		
		return $rows;
	}
	
	/**
	 * Excutes the db query, this function only be used when the multipal tables need to be queried.
	 * @param string $sql the SQL query sentance.
	 */
	protected function sqlSelect($sql, $db_name) {
		db_set_active ( $db_name );
		$result = db_query ( $sql );
		$total = db_num_rows ( $result );
		$rows = array ();
		for($i = 0; $i < $total; $i ++) {
			$rows [] = db_fetch_array ( $result );
		}
		
		return $rows;
	}
	
	/**
	 * Excutes the db update, this function only be used to do update operation without return.
	 * @param string $sql the SQL query sentance.
	 * @param string $db_name
	 */
	protected function sqlUpdate($sql, $db_name) {
		db_set_active ( $db_name );
		
		$result = db_query ( $sql );
	}
	
	/**
	 * Select one single entity.
	 * @param Entity $entity object extends from Entity.
	 * @param mixed $condition array or string specifies conditions.
	 * @return Entity entity if successed, otherwise FALSE.
	 */
	protected function selectEntity(Entity $entity, $condition) {
		$this->iniYmlSetting ($entity);
		db_set_active ( $entity->connection );
	
		$sql = $this->toSelectSql ( $entity, $condition );
		$result = db_query ( $sql );
		if (FALSE != $result) {
			if (db_num_rows ( $result ) > 0) {
				$this->initialEntity ( $entity, db_fetch_array ( $result ) );
				return $entity;
			}
		}
		
		return FALSE;
	}
	
	/**
	 * Atom function used to select data from database table.
	 * @param $entity object extends from Entity, it is the PO object.
	 * @param mixed $condition array or string specifies conditions
	 * @param string $pager_order other conditions like GROUP BY, ORDER BY, LIMIT...
	 * @return Entity entity array or empty array.
	 */
	protected function selectEntities(Entity $entity, $condition = NULL, PagerOrder $pager_order = NULL) {
		$this->iniYmlSetting ( $entity );
		db_set_active ( $entity->connection );
		
		//If the condition is null, it will use $entity's property as the condition
		if (NULL == $condition) {
			//Construct $conditions
			foreach ( $entity->fields as $key => $value ) {
				
				if (TRUE === $entity->$key) {
					$condition [$value] = 1; // 1 means true
				} else if (FALSE === $entity->$key) {
					$condition [$value] = 0; // 0 means false.
				} else if (! $this->emptyValue ( $entity->$key )) {
					$condition [$value] = $entity->$key;
				}
			}
		}
		
		$others = '';
		if (NULL != $pager_order) {
			$other_conditions = array ();
			
			if (! $this->emptyValue ( $pager_order->group_by )) {
				$other_conditions [] = "GROUP BY " . $pager_order->group_by;
			}
			
			if (! $this->emptyValue ( $pager_order->order_by )) {
				$other_conditions [] = "ORDER BY " . $pager_order->order_by;
			}
			
			if (! $this->emptyValue ( $pager_order->cur_page ) && ! $this->emptyValue ( $pager_order->rows_per_page )) {
				$other_conditions [] = 'LIMIT ' . ($pager_order->cur_page - 1) * $pager_order->rows_per_page . ', ' . $pager_order->rows_per_page;
			}
			
			if (count ( $other_conditions ) > 0) {
				$others = implode ( ' ', $other_conditions );
			}
		}
		
		$sql = $this->toSelectSql ( $entity, $condition, $others );

		$result = db_query ( $sql );
		$entities = array ();
		
		$total = db_num_rows ( $result );
		//print_var('total: ' . $total);
		for($i = 0; $i < $total; $i ++) {
			$row = db_fetch_array ( $result );
			$item_class = get_class ( $entity );
			$item = new $item_class ( );
			
			$this->initialEntity ( $item, $row );
			$entities [] = $item;
		}
		//$log_file = "res.txt";
		//file_put_contents($log_file, "result: " . json_encode($entities) ."\r\n", FILE_APPEND);         
		

		return $entities;
	}

	/**
	 * Atom function used to get total count from database table.
	 * @param $entity object extends from Entity, it is the PO object.
	 * @param mixed $condition array or string specifies conditions
	 * @return total count
	 */
	protected function getTotal(Entity $entity, $condition = NULL) {
		$this->iniYmlSetting ( $entity );
		db_set_active ( $entity->connection );
		
		$field = "count(*)";
		$sql = Convert::toSqlSelect ($entity->table, array($field), $condition);
		$row = db_fetch_array (db_query ( $sql ));

		return intval($row[$field]);
	}
	
	/**
	 * Atom function used to insert PO entity into database table.
	 * @param Entity $entity which will be inserted into database.
	 */
	protected function insertEntity(Entity $entity) {
		$this->iniYmlSetting($entity);
		db_set_active($entity->connection);
		
		$sql = $this->toInsertSql($entity);
		//$log_file = 'log.txt';file_put_contents($log_file, date('Y-m-d h:i:s') . " ADD:\r\n" . $sql . "\r\n", FILE_APPEND);
		if (db_query ($sql)) {
			return db_last_insert_id();
		} else {
            exit;
			return - 1; //-1 means the insert operation failed.
		}
	}
	
	/**
	 * Atom function used to insert PO entities into database.
	 * @param mixed array or object which will be inserted into database.
	 */
	protected function insertEntities($entities) {
		$initialized_db = FALSE;
		
		foreach ( $entities as $entity ) {
			if (! $initialized_db) {
				$this->iniYmlSetting ( $entity );
				db_set_active ( $entity->connection );
				
				$initialized_db = TRUE;
			} else {
				$this->iniYmlSetting ( $entity );
			}
			
			$sql = $this->toInsertSql ( $entity );
			
			db_query ( $sql );
		}
		
		return db_last_insert_id ();
	}
	
	/**
	 * Atom function used to delete PO entities from database table.
	 * @param Entity $entity
	 * @param mixed array or string conditions, such as 'id = 1'...
	 */
	protected function deleteEntities(Entity $entity, $conditions) {
		$this->iniYmlSetting ( $entity );
		db_set_active ( $entity->connection );
		
		$sql = Convert::toSqlDelete ( $entity->table, $conditions );
		
		return db_query ( $sql );
	}
	
	/**
	 * Atom function used to update PO entity into database.
	 * @param Entity entity.
	 * @param mixed array or string update conditions.
	 * @param bool $ignore_empty_value which indicates to ignore the empty value; if TRUE is
	 *        given, the empty properties of the Entity will be ignored when updates into db.
	 */
	protected function updateEntity(Entity $entity, $condition, $ignore_empty_value = TRUE) {
		$this->iniYmlSetting ( $entity );
		db_set_active ( $entity->connection );
		
		$sql = $this->toUpdateSql ( $entity, $condition, $ignore_empty_value );
		//$log_file = 'log.txt';file_put_contents($log_file, date('Y-m-d') . " UPDATE:\r\n" . $sql . "\r\n", FILE_APPEND);
		return db_query ( $sql );
	}
	
	/**
	 * Atom function used to initialize Yml settings.
	 * @param Entity $entity.
	 */
	protected function iniYmlSetting(Entity &$entity) {
		$class_name = get_class ( $entity );
		if ($class_name) {
			$class_name = strtolower ( $class_name );
		}
		
		
		$yml_file = var_get ( 'po_path' ) . $class_name . '.yml';
		$entity_config = Spyc::YAMLLoad ( $yml_file );
	
		$entity->connection = $entity_config ['connection'];
		$entity->table = $entity_config ['table'];
		$entity->fields = $entity_config ['fields'];
	}
	
	/**
	 * Parameter validation function.
	 * @param Entity entity which would be validated.
	 */
	protected function validateParam($entity) {
		if (null == $entity) {
			throw new Exception ( ); //TODO:
		}
	}
	
	/**
	 * Atom function used to insert PO entities from database table.
	 * @param Entity $entity
	 * return $sql
	 */
	private function toInsertSql($entity) {
		$table_name = $entity->table;
		
		//$log_file = 'log.txt';file_put_contents($log_file, date('Y-m-d') . " TABLE NAME:\r\n" . $table_name . "\r\n", FILE_APPEND);        
		

		$params = $this->convertObjToArray ( $entity, TRUE );
		$sql = Convert::toSqlInsert ( $table_name, $params );
		
		return $sql;
	}
	
	/**
	 * Atom function used to select PO entities from database table.
	 * @param Entity $entity
	 * @param String $conditions,
	 * @param string $others other conditions like GROUP BY, ORDER BY, LIMIT...
	 * @return string the generated SQL statement
	 */
	private function toSelectSql($entity, $conditions, $others = '') {
		$table_name = $entity->table;
		$cols = array_values ( $entity->fields );
		
		$sql = Convert::toSqlSelect ( $table_name, $cols, $conditions, $others );
		
		return $sql;
	}
	
	/**
	 * Atom function used to update PO entities from database table.
	 * @param Entity $entity
	 * @param String $conditions,
	 * @param Bool $ignore_empty_value,
	 * return string the generated SQL statement
	 */
	private function toUpdateSql($entity, $conditions, $ignore_empty_value = TRUE) {
		$table_name = $entity->table;
		$params = $this->convertObjToArray ( $entity, $ignore_empty_value );
		
		return Convert::toSqlUpdate ( $table_name, $params, $conditions );
	}
	
	/**
	 * Atom function used to convert PO entities to array.
	 * @param Entity $entity
	 * @param Bool $ignore_empty_value,
	 * return string
	 */
	private function convertObjToArray($entity, $ignore_empty_value = FALSE) {
		$params = array ();
		
		foreach ( $entity->fields as $key => $value ) {
			if ($ignore_empty_value) {
				
				if (NULL !== $entity->$key && '' !== $entity->$key) {
					$params ['`' . $value . '`'] = $entity->$key; //value is the db field, key is the entity property.
				} else {
				    $params ['`' . $value . '`'] = null;
				}
			} else {
				$params [$value] = $entity->$key;
			}
		}
		
		return $params;
	}
	
	/**
	 * @param String $value
	 * return True if successfully,otherwise False
	 */
	private function emptyValue($value) {
		return ('' === $value || NULL === $value) ? TRUE : FALSE;
	}
}
?>
