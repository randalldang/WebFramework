(function(global, undefined){
	if (!global) return;
	var Model = global.Model = function () {

	}
	
	Model.prototype.init = function() {
	
	};

	Model.prototype.loadTemplate = function(container) {
		$('#' + container).load('templates/main.tpl');
	};

	Model.prototype.getCustomer = function(data, callback) {
		$.getJSON('./web/customers.php', {id: data.id}, function(data) {
			callback({result:data, fields:['CustomerCode', 'CustomerName',
				'Status', 'CreateTime', 'LastLoginTime'], idKey: 'CustomerId'});
		})
	};

	Model.prototype.getCustomers = function(data, callback) {
		$.getJSON('./web/customers.php', {searchKey: data.searchKey, 
				cur_page: data.cur_page},function(data) {
			callback({result:data, fields:['CustomerCode', 'CustomerName',
				'Status', 'CreateTime', 'LastLoginTime'], idKey: 'CustomerId'});
		})
	};

})(window.express.admin);