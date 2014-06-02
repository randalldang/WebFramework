var express = window.express || {};
express.admin = {};
express.admin.eventBus = {
	dispatch: function(type, data) {
		$(this).trigger(type, data);
	},
	listen: function(type, handler, extraData) {
		$(this).bind(type, extraData, handler);
	},
	unlisten: function(type) {
		$(this).unbind(type);
	}
};

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
	};

})(window.express.admin);
