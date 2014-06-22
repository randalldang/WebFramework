(function(global, undefined){
	if (!global) return;
	var View = global.View = function () {
		this.menuArray = [];
		this.menuLabels = {};
		this.menuTables = {};
		this.menuCharts = {};
	}
	
	View.prototype.init = function() {
		this.initMenuLable();
		this.initMenu();
		this.initMenuTable();
		this.initMenuChart();
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

			if (this.menuTables[menucode]){
			} else if (this.menuCharts[menucode]){
				$('#page-content').highcharts(this.getMenuChart(menucode));
			} else if (menucode == 'courier-tracking'){
				var map = new BMap.Map("page-content");        
				var point = new BMap.Point(121.51561, 31.240018); 
				map.addControl(new BMap.NavigationControl());    
				map.addControl(new BMap.ScaleControl());    
				map.centerAndZoom(point, 15); 
			} else if (menucode == 'stat-umeng'){
				$('#page-content').html($('#umeng-iframe-tmpl').render());
			}
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

	View.prototype.getMenuTable = function(originData, data) {
		var dataTable = {};
		var menucode = originData.menucode;
		dataTable.menucode = menucode;
		dataTable.searchKey = originData.searchKey;
		dataTable.id = menucode + "_table";
		dataTable.thead = this.getMenuTableHead(menucode);
		dataTable.rows = this.getMenuTableRow(data);
		dataTable.pager = this.getMenuTablePagination(originData, data);
		if (!data.result.entities || data.result.entities.length == 0) {
			dataTable.emptyRow = true;
			dataTable.colspan = dataTable.thead.length;
		}
		
		if (!originData.cur_page || originData.cur_page == 1){
			dataTable.disablePre = true;
		}

		if (originData.cur_page == global.pageCount){
			dataTable.disableNext = true;
		}

		return dataTable;
	};

	View.prototype.getMenuTableHead = function(menucode) {
		var thead = [];
		var heads = this.menuTables[menucode];
		if (!heads) {
			return thead;
		}
		for (var i = 0; i < heads.length; i++) {
			thead.push({name:heads[i]});
		};
		return thead;
	};	

	View.prototype.getMenuTableRow = function(data) {
		var rows = [];
		var entities = data.result.entities;
		var fields = data.fields;

		if (entities) {
			for(var i = 0; i < entities.length; i++){
				var cols = [];
				for(var j = 0; j < fields.length; j++){
					var col = {};
					col.value = entities[i][fields[j]];
					col.id = entities[i][data.idKey];
					if (j == 0) {
						col.clickable = fields[0];
					}
					cols.push(col);
				}
				rows.push({cols: cols});
			}
		}
		return rows;
	};

	View.prototype.getMenuTablePagination = function(originData, data) {
		var pageCount = Math.ceil(parseInt(data.result.count) / 10);
		global.pageCount = pageCount;

		var pager = [];
		var cur_page = originData.cur_page ? originData.cur_page : 1;

		if (cur_page + 5 >= pageCount){
			cur_page = pageCount - 5;
		}

		if (cur_page <= 1) {
			cur_page = 1;
		}

		var displayPageCount = cur_page + 5;
		if (displayPageCount >= pageCount){
			displayPageCount = pageCount;
		}

		for(var i = cur_page; i <= displayPageCount; i++){
			var pageItem = {};
			pageItem.num = i;
			
			if ((!originData.cur_page && i == 1) || 
						(originData.cur_page && originData.cur_page == i)) {
				pageItem.active = true;
			}
			pager.push(pageItem);
		}

		return pager;
	};

	View.prototype.getMenuChart = function(menucode) {
		var chart = {};
		var menuData = this.menuCharts[menucode];
		chart.title = {text: menuData.title, x: -20};
    chart.xAxis = {categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']};
    chart.yAxis = {title: {text: '人数'}};
    chart.series = [{name: '', data: [7.0, 6.9, 9.5, 14.5, 18.2, 
    	21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]}];
    return chart;
	};

	View.prototype.bindEvent = function() {
		$('#nav-list>li').bind('click', this.toggleSubmenu);
		$('.submenu>li').bind('click', this.navigate);
		$('#nav-welcome').bind('click', function(event) {
			$(this).addClass('open');
			event.stopPropagation();
		});
		$('body').bind('click', function() {
			$('#nav-welcome').removeClass('open');
		});
		$('#logout').bind('click', function() {
			$.removeCookie("user_cookie", {path: '/'});
			window.location.href = '/express';
		});
	};

	View.prototype.bindPageContentEvent = function() {
		$('.pager-num').bind('click', this.getDataByPagination);
		$('.pager-pre').bind('click', this.getDataByPre);
		$('.pager-next').bind('click', this.getDataByNext);
		$('#search-btn').bind('click', this.getDataBySearch);
		$('.row-key').bind('click', this.getDetailInfo);
	};

	View.prototype.getDetailInfo = function(event) {
		var id = $(this).attr('entity_id');
		if (id) {
			var menucode = $('#current-menucode').val();
			global.eventBus.dispatch('navigate-detail', {menucode: menucode, 
			id: id});
		}
	};

	View.prototype.showDetailInfo = function(originData, detailJson) {
		var details = [];
		if (detailJson && detailJson.result){
			for(var i in detailJson.result) {
				details.push({label: i, value: detailJson.result[i]});
			}
		}
		$('#modal-container').html($('#modal-tmpl').render(
			{title:'收件人详情', details: details}));
		$('#detail-info-modal').modal('show');

	};

	View.prototype.getDataByPagination = function(event) {
		var cur_page = parseInt($(this).html());
		var menucode = $('#current-menucode').val();
		var searchKey = $('#search-key').val();
		global.eventBus.dispatch('navigate', {menucode: menucode, 
			cur_page: cur_page, searchKey: searchKey});
	};


	View.prototype.getDataByPre = function(event) {
		var cur_page = parseInt($('.pagination .active .pager-num').html());
		if (cur_page <= 1){
			return;
		}
		cur_page--;
		var menucode = $('#current-menucode').val();
		global.eventBus.dispatch('navigate', {menucode: menucode, cur_page: cur_page});
	};

	View.prototype.getDataByNext = function(event) {
		var cur_page = parseInt($('.pagination .active .pager-num').html());
		if (cur_page >= global.pageCount){
			return;
		}
		cur_page++;
		var menucode = $('#current-menucode').val();
		global.eventBus.dispatch('navigate', {menucode: menucode, cur_page: cur_page});
	};

	View.prototype.getDataBySearch = function(event) {
		var searchKey = $('#search-key').val().trim();
		var menucode = $('#current-menucode').val();
		global.eventBus.dispatch('navigate', {menucode: menucode, 
			searchKey: searchKey});
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

	View.prototype.renderDataTable = function(originData, result) {
		$('#page-content').html($('#data-table-tmpl').render(
					this.getMenuTable(originData, result ? result : {})));
		this.bindPageContentEvent();
	};
 
 /**
  * *********************Init menu data**********************
  */
	View.prototype.initMenu = function() {
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

	View.prototype.initMenuLable = function() {
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

	View.prototype.initMenuTable = function() {
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

	View.prototype.initMenuChart = function() {
		this.menuCharts['courier-stat'] = {title: '收件人总数'};
		this.menuCharts['customer-stat'] = {title: '发件人总数'};
		this.menuCharts['order-stat'] = {title: '订单总数'};
		this.menuCharts['stat-usage'] = {title: '活跃用户'};
	};

	View.dataTableLanguage = {
    "sProcessing":   "处理中...",
    "sLengthMenu":   "显示 _MENU_ 项结果",
    "sZeroRecords":  "没有匹配结果",
    "sInfo":         "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
    "sInfoEmpty":    "显示第 0 至 0 项结果，共 0 项",
    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
    "sInfoPostFix":  "",
    "sSearch":       "搜索:",
    "sUrl":          "",
    "sEmptyTable":     "表中数据为空",
    "sLoadingRecords": "载入中...",
    "sInfoThousands":  ",",
    "oPaginate": {
        "sFirst":    "首页",
        "sPrevious": "上页",
        "sNext":     "下页",
        "sLast":     "末页"
    },
    "oAria": {
        "sSortAscending":  ": 以升序排列此列",
        "sSortDescending": ": 以降序排列此列"
  }
}

})(window.express.admin);