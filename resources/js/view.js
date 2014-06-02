(function(global, undefined){
	if (!global) return;
	var View = global.View = function () {
		this.menuArray = [];
		this.menuLabels = {};
	}
	
	View.prototype.init = function() {
		this.initMenuLable();
		this.initMenu();
		global.eventBus.listen('navigate', $.proxy(this.handleNavigation, this));
		global.eventBus.dispatch('loadTemplate', 'dynamic-templates');
		$('.sidebar').html($('#sidebar-tmpl').render({menuArray:this.menuArray}));
		this.bindEvent();	
	};

	View.prototype.handleNavigation = function(event, params) {
		var menucode = params.menucode;
		if (!menucode) return;
		var  menu = this.getMenuBySubmenu(menucode);
		if (menu) {
			$('.breadcrumb').html($('#breadcrumb-tmpl').render({icon: menu.icon, 
				label: this.menuLabels[menu.menucode], subMenuCode: menucode,
				subMenuLabel: this.menuLabels[menucode]}));

			$('#page-content').html($('#page-content-tmpl').render({icon: menu.icon}));
		}
	};

	View.prototype.getMenuBySubmenu = function(menucode) {
		if (!menucode) return;
    
		for(var i = 0; i < this.menuArray.length; i++){
			var menu  = this.menuArray[i];
			var subMenus = menu.subMenus;
			for(var j = 0; subMenus && j < subMenus.length; j++){
				if (subMenus[j].menucode == menucode) {
					return menu;
				}
			}
		}
	};

	View.prototype.createMenuNode = function(code, icon, subMenus) {
		var menu = {};
		menu.menucode = code;
		menu.label = this.menuLabels[code];
		menu.icon = icon;
		menu.subMenus = [];
		for (var i = 0; subMenus && i < subMenus.length; i++) {
			var subMenuCode = subMenus[i];
			menu.subMenus.push({label: this.menuLabels[subMenuCode], menucode: subMenuCode});
		};
		return menu;
	};

	View.prototype.bindEvent = function() {
		$('#nav-list>li').bind('click', this.toggleSubmenu);
		$('.submenu>li').bind('click', this.navigate);
	};

	View.prototype.toggleSubmenu = function(event) {
		var target = event.currentTarget ? event.currentTarget :
			event.srcElement;
		if (target && target.nodeName.toLowerCase() == 'li') {
			$(target).toggleClass('open');
			$(target).find('.submenu').toggle();
		}
	};

	View.prototype.navigate = function(event) {
		var target = event.currentTarget ? event.currentTarget :
			event.srcElement;
		if (target && target.nodeName.toLowerCase() == 'li') {
			var menucode = $(target).attr('__menucode');
			global.eventBus.dispatch('navigate', {menucode: menucode});
			event.stopPropagation();
		}
	};

 
 /**
  * *********************Init menu data**********************
  */
	View.prototype.initMenu = function() {
		this.menuArray.push(this.createMenuNode('courier', 'fa-group', 
			['courier-stat', 'courier-list', 'courier-check', 'courier-recom',
			'courier-tracking']));
		this.menuArray.push(this.createMenuNode('customer', 'fa-child', 
			['customer-stat', 'customer-list', 'customer-share']));
		this.menuArray.push(this.createMenuNode('order', 'fa-cny', 
			['order-stat', 'order-list']));
		this.menuArray.push(this.createMenuNode('cms', 'fa-bell', ['cms-list']));
		this.menuArray.push(this.createMenuNode('advice', 'fa-thumbs-down', ['advice-list']));
		this.menuArray.push(this.createMenuNode('setting', 'fa-cog', ['client-version',
			'service-region', 'courier-company', 'order-reason']));
		this.menuArray.push(this.createMenuNode('stat', 'fa-bar-chart-o', ['stat-usage',
			'stat-umeng']));
		this.menuArray.push(this.createMenuNode('message', 'fa-weixin'));
	};

	View.prototype.initMenuLable = function() {
		this.menuLabels['courier'] = '收件人管理';
		this.menuLabels['courier-stat'] = '收件人统计';
		this.menuLabels['courier-list'] = '收件人列表';
		this.menuLabels['courier-check'] = '收件人审核';
		this.menuLabels['courier-recom'] = '收件人推荐';
		this.menuLabels['courier-tracking'] = '收件人跟踪';

		this.menuLabels['customer'] = '发件人管理';
		this.menuLabels['customer-stat'] = '发件人统计';
		this.menuLabels['customer-list'] = '发件人列表';
		this.menuLabels['customer-share'] = '发件人分享';

		this.menuLabels['order'] = '订单管理';
		this.menuLabels['order-stat'] = '订单统计';
		this.menuLabels['order-list'] = '订单列表';

		this.menuLabels['cms'] = 'CMS管理';
		this.menuLabels['cms-list'] = 'CSM列表';

		this.menuLabels['advice'] = '用户建议管理';
		this.menuLabels['advice-list'] = '用户建议列表';

		this.menuLabels['setting'] = '设置';
		this.menuLabels['client-version'] = '客户端版本';
		this.menuLabels['service-region'] = '服务范围';
		this.menuLabels['courier-company'] = '快递公司';
		this.menuLabels['order-reason'] = '订单取消原因';

		this.menuLabels['stat'] = '统计分析';
		this.menuLabels['stat-usage'] = '客户端使用统计';
		this.menuLabels['stat-umeng'] = '友盟链接';

		this.menuLabels['message'] = '消息管理';
	};

})(window.express.admin);