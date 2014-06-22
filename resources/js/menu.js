(function(global, undefined){
	if (!global) return;
	var Menu = global.Menu = function () {
		this.menuArray = [];
		this.menuLabels = {};
		this.menuTables = {};
		this.menuCharts = {};
	}

	Menu.prototype.init = function() {
		this.initMenuLable();
		this.initMenu();
		this.initMenuTable();
		this.initMenuChart();
		global.eventBus.dispatch('loadTemplate', 'dynamic-templates');
		$('.sidebar').html($('#sidebar-tmpl').render({menuArray:this.menuArray}));
		this.bindEvent();	
	};

	Menu.prototype.bindEvent = function() {
		$('#nav-list>li').bind('click', this.toggleSubmenu);
		$('.submenu>li').bind('click', this.navigate);
	};

	Menu.prototype.toggleSubmenu = function(event) {
		var target = event.currentTarget ? event.currentTarget :
			event.srcElement;
		if (target && target.nodeName.toLowerCase() == 'li') {
			$(target).toggleClass('open');
			$(target).find('.submenu').toggle();
		}
	};

	Menu.prototype.navigate = function(event) {
		var target = event.currentTarget ? event.currentTarget :
			event.srcElement;
		if (target && target.nodeName.toLowerCase() == 'li') {
			var menucode = $(target).attr('__menucode');
			global.eventBus.dispatch('navigate', {menucode: menucode});
			event.stopPropagation();
		}
	};

	Menu.prototype.createMenuNode = function(code, icon, subMenus) {
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

	Menu.prototype.initMenu = function() {
		this.menuArray.push(this.createMenuNode('courier', 'fa-group', 
			['courier-stat', 'courier-list', 'courier-recom',
			'courier-tracking']));
		this.menuArray.push(this.createMenuNode('customer', 'fa-child', 
			['customer-stat', 'customer-list', 'customer-share']));
		this.menuArray.push(this.createMenuNode('order', 'fa-cny', 
			['order-stat', 'order-list']));
		this.menuArray.push(this.createMenuNode('cms', 'fa-bell', ['cms-list']));
		this.menuArray.push(this.createMenuNode('advice', 'fa-thumbs-up', ['advice-list']));
		this.menuArray.push(this.createMenuNode('setting', 'fa-cog', ['client-version',
			'service-region', 'courier-company', 'order-reason']));
		this.menuArray.push(this.createMenuNode('admin', 'fa-user', ['admin-list']));
		this.menuArray.push(this.createMenuNode('stat', 'fa-bar-chart-o', ['stat-usage',
			'stat-umeng']));
		this.menuArray.push(this.createMenuNode('message', 'fa-weixin'));
	};

	Menu.prototype.initMenuLable = function() {
		this.menuLabels['courier'] = '收件人管理';
		this.menuLabels['courier-stat'] = '收件人统计';
		this.menuLabels['courier-list'] = '收件人列表';
		this.menuLabels['courier-recom'] = '收件人推荐';
		this.menuLabels['courier-tracking'] = '收件人跟踪';

		this.menuLabels['customer'] = '发件人管理';
		this.menuLabels['customer-stat'] = '发件人统计';
		this.menuLabels['customer-list'] = '发件人列表';
		this.menuLabels['customer-share'] = '发件人分享';

		this.menuLabels['order'] = '订单管理';
		this.menuLabels['order-stat'] = '订单统计';
		this.menuLabels['order-list'] = '订单列表';

		this.menuLabels['cms'] = '通知管理';
		this.menuLabels['cms-list'] = '文案列表';

		this.menuLabels['advice'] = '用户建议管理';
		this.menuLabels['advice-list'] = '用户建议列表';

		this.menuLabels['admin'] = '管理员';
		this.menuLabels['admin-list'] = '管理员列表';

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

	Menu.prototype.initMenuTable = function() {
		this.menuTables['courier-list'] = ['登录帐号','名称','公司',
			'点部','状态'];
		this.menuTables['courier-recom'] = ['推荐人', '推荐类型',
		 '推荐用户手机', '推荐时间'];
		
		this.menuTables['customer-list'] = ['手机号码', '用户名称', '状态',
		 '注册时间', '最近登录'];
		this.menuTables['customer-share'] = ['发件人', '分享类型', '分享时间',];

		this.menuTables['order-list'] = ['发件人', '收件人', '创建时间',
		 '订单类型', '状态'];

		this.menuTables['cms-list'] = ['文档代码', '创建时间', '创建人'];

		this.menuTables['advice-list'] = ['用户', '创建时间', '状态',
		 '处理人', '处理时间'];

		this.menuTables['client-version'] = ['版本号', '客户端类型', '强制升级', '时间'];
		this.menuTables['service-region'] = ['区域名称', '状态'];
		this.menuTables['courier-company'] = ['公司名称', '公司地址', '服务电话'];
		this.menuTables['order-reason'] = ['取消原因', '显示顺序'];

		this.menuTables['admin-list'] = ['帐号', '名称', '类型', '状态'];		
	};

	Menu.prototype.initMenuChart = function() {
		this.menuCharts['courier-stat'] = {title: '收件人总数'};
		this.menuCharts['customer-stat'] = {title: '发件人总数'};
		this.menuCharts['order-stat'] = {title: '订单总数'};
		this.menuCharts['stat-usage'] = {title: '活跃用户'};
	};

})(window.express.admin);