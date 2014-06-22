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