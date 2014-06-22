(function(global, undefined){
	var Persenter = global.Persenter = function (view, model) {
		this.view = view;
		this.model = model;
	}

	Persenter.prototype.init = function() {
		this.initListener();
		this.view.init();
		this.model.init();
	};

	Persenter.prototype.initListener = function() {
		global.eventBus.listen('loadTemplate', $.proxy(function(event, container) {
			this.model.loadTemplate(container);
		},  this));
		global.eventBus.listen('navigate', $.proxy(this.navigate, this));
		global.eventBus.listen('navigate-detail', $.proxy(this.navigateDetail, this));
	};

	Persenter.prototype.navigate = function(event, data) {
		switch (data.menucode) {
			case 'client-version': 
				this.model.getClientVersions($.proxy(this.handleDateTable, 
				this, data.menucode));
				break;
			case "service-region": 
				this.model.getServiceRegions($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "courier-company": 
				this.model.getCourierCompanies($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "order-reason": 
				this.model.getOrderReasons($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "advice-list": 
				this.model.getAdvices($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "cms-list": 
				this.model.getCmsList($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "order-list": 
				this.model.getOrders($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "customer-list": 
				this.model.getCustomers(data, $.proxy(this.handleDateTable, 
					this, data));
				break;
			case "customer-share": 
				this.model.getShares($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "courier-list": 
				this.model.getCouriers($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "courier-recom": 
				this.model.getRecommendations($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "admin-list": 
				this.model.getAdmins($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			default: break;
		}
	};

	Persenter.prototype.navigateDetail = function(event, data) {
		switch (data.menucode) {
			case 'client-version': 
				this.model.getClientVersions($.proxy(this.handleDateTable, 
				this, data.menucode));
				break;
			case "service-region": 
				this.model.getServiceRegions($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "courier-company": 
				this.model.getCourierCompanies($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "order-reason": 
				this.model.getOrderReasons($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "advice-list": 
				this.model.getAdvices($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "cms-list": 
				this.model.getCmsList($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "order-list": 
				this.model.getOrders($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "customer-list": 
				this.model.getCustomer(data, $.proxy(this.handleDetailInfo, 
					this, data));
				break;
			case "customer-share": 
				this.model.getShares($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "courier-list": 
				this.model.getCouriers($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "courier-recom": 
				this.model.getRecommendations($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			case "admin-list": 
				this.model.getAdmins($.proxy(this.handleDateTable, 
					this, data.menucode));
				break;
			default: break;
		}
	};

	Persenter.prototype.handleDateTable = function(originData, result) {
			this.view.renderDataTable(originData, result);
	};

	Persenter.prototype.handleDetailInfo = function(originData, result) {
			this.view.showDetailInfo(originData, result);
	};

})(window.express.admin);
