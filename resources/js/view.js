(function(global, undefined){
	if (!global) return;
	var View = global.View = function () {
		this.menu = new global.Menu(global);
		this.menu.init();
	}
	
	View.prototype.init = function() {
		global.eventBus.listen('navigate', $.proxy(this.handleNavigation, this));
		global.eventBus.dispatch('loadTemplate', 'dynamic-templates');
		this.bindEvent();	
	};

	View.prototype.handleNavigation = function(event, params) {
		var menucode = params.menucode;
		if (!menucode) return;
		var  menu = this.getMenuBySubmenu(menucode);
		if (menu) {
			$('.breadcrumb').html($('#breadcrumb-tmpl').render({icon: menu.icon, 
				label: this.menu.menuLabels[menu.menucode], subMenuCode: menucode,
				subMenuLabel: this.menu.menuLabels[menucode]}));

			if (this.menu.menuTables[menucode]){
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
    
		for(var i = 0; i < this.menu.menuArray.length; i++){
			var menu  = this.menu.menuArray[i];
			var subMenus = menu.subMenus;
			for(var j = 0; subMenus && j < subMenus.length; j++){
				if (subMenus[j].menucode == menucode) {
					return menu;
				}
			}
		}
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
		var heads = this.menu.menuTables[menucode];
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

	View.prototype.renderDataTable = function(originData, result) {
		$('#page-content').html($('#data-table-tmpl').render(
					this.getMenuTable(originData, result ? result : {})));
		this.bindPageContentEvent();
	};

})(window.express.admin);