(function(global, undefined){
	if (!global) return;
	var Model = global.Model = function () {

	}
	
	Model.prototype.init = function() {
	
	};

	Model.prototype.loadTemplate = function(container) {
		$('#' + container).load('templates/main.tpl');
	};

	Model.prototype.getClientVersions = function(callback) {
		$.getJSON('./web/app-version.php', function(data) {
			callback({result:data, fields:['Vesion', 'AppType', 
				'IsUpgrade', 'CreateTime']});
		})
	};

	Model.prototype.getServiceRegions = function(callback) {
		$.getJSON('./web/service-region.php', function(data) {
			callback({result:data, fields:['RegionName', 'status']});
		})
	};

	Model.prototype.getCourierCompanies = function(callback) {
		$.getJSON('./web/courier-company.php', function(data) {
			callback({result:data, fields:['CompanyName', 'Address', 
				'ServicePhone']});
		})
	};

	Model.prototype.getOrderReasons = function(callback) {
		$.getJSON('./web/cancel-reason.php', function(data) {
			callback({result:data, fields:['Reason', 'DisplayOrder']});
		})
	};

	Model.prototype.getAdvices = function(callback) {
		$.getJSON('./web/advice.php', function(data) {
			callback({result:data, fields:['UserId', 'CreateTime',
				'AdviceStatus', 'UpdateUserId', 'UpdateTime']});
		})
	};

	Model.prototype.getCmsList = function(callback) {
		$.getJSON('./web/cms.php', function(data) {
			callback({result:data, fields:['CMSCode', 'CreateTime',
				'CreateUserId']});
		})
	};

	Model.prototype.getOrders = function(callback) {
		$.getJSON('./web/orders.php', function(data) {
			callback({result:data, fields:['CustomerId', 'CustomerId',
				'CreateTime', 'OrderType', 'OrderStatus']});
		})
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

	Model.prototype.getShares = function(callback) {
		$.getJSON('./web/customer-share.php', function(data) {
			callback({result:data, fields:['CustomerId', 'ShareType',
				'ShareTime']});
		})
	};

	Model.prototype.getCouriers = function(callback) {
		$.getJSON('./web/couriers.php', function(data) {
			callback({result:data, fields:['CourierCode', 'CourierName',
				'CompanyId', 'BranchName', 'Status']});
		})
	};

	Model.prototype.getAdmins = function(callback) {
		$.getJSON('./web/couriers.php', function(data) {
			callback({result:data, fields:['CourierCode', 'CourierName',
				'CourierType', 'Status']});
		})
	};

	Model.prototype.getRecommendations = function(callback) {
		$.getJSON('./web/courier-recommend.php', function(data) {
			callback({result:data, fields:['RecommendId', 'RecommendType',
				'ReceiveMobile', 'RecommendTime']});
		})
	};

})(window.express.admin);