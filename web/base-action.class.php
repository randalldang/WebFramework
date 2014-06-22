<?php

abstract class BaseAction {

  public function __construct() {
      $this->session = new SessionManager();
      $this->get = new GetManager();
      $this->post = new PostManager();
  }

	/**
   * Abstract function definition for each page to implement it.
   * @return void
   */
  public abstract function doGet();

  /**
   * Abstract function definition for each page to implement it.
   * @return void
   */
  public abstract function doPost();

  public function toJsonArray($entities){
      $result = array();
      if (!empty($entities)) {
          foreach($entities as $entity) {
              $result[] = $entity->toJson();
          }
      }
      return '[' . implode($result, ',') . ']';
  }

  public function toJsonPager($entityPager){
      $count = $entityPager->count;
      $entities = $entityPager->entities;
      $entityJsonArray = array();
      if (!empty($entities)) {
          foreach ($entities as $entity) {
              $entityJsonArray[] = $entity->getData();
          }
      }    

      return Json::jsonEncode(array("count" => $count,
          "entities" => $entityJsonArray));
  }

  protected function getPagerOrder(){
      $pagerOrder = new PagerOrder();
      if (is_null($this->get->cur_page)) {
        $pagerOrder->cur_page = 1;
      } else {
        $pagerOrder->cur_page = $this->get->cur_page;
      }
      if (is_null($this->get->rows_per_page)) {
        $pagerOrder->rows_per_page = 10;
      } else {
        $pagerOrder->rows_per_page = $this->get->rows_per_page;
      }

      $pagerOrder->order_by = $this->get->order_by;
      $pagerOrder->group_by = $this->get->group_by;
      $pagerOrder->total_rows = $this->get->total_rows;
      return $pagerOrder;
  }

  public function doValidation() {
      if (defined('PRIVILEGE')) {
          if (PRIVILEGE > 0) {
              $user = get_login_user();
              if (NULL != $user) {
                  $this->validation_result = TRUE;

                  return TRUE;
              } else {
                  $this->validation_result = FALSE;

                  return FALSE;
              }
          }
          $this->validation_result = TRUE;

          return TRUE;
      } else {
          $this->validation_result = TRUE;

          return TRUE;
      }
  }

  public function validationFailAction(){
    header("Location: /express");
    die();
  }
}
?>