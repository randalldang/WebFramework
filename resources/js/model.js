(function(global, undefined){
	if (!global) return;
	var Model = global.Model = function () {

	}
	
	Model.prototype.init = function() {
	
	};

	Model.prototype.loadTemplate = function(container) {
		$('#' + container).load('templates/main.tpl');
	};

})(window.express.admin);