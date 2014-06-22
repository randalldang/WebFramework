<script id="testTmpl" type="text/x-jsrender">
	<label>Name:</label> {{:name}}<br/>
</script>

<script id="breadcrumb-tmpl" type="text/x-jsrender">
		<li>
			<i class="fa {{:icon}}"></i>
			{{:label}}
		</li>
		<li><a href="javascript:void(0)" __menucode="{{:subMenucode}}">{{:subMenuLabel}}</a></li>
</script>

<script id="page-content-tmpl" type="text/x-jsrender">
		<i class="fa fa-5x fa-spin {{:icon}}"></i>
		敬请期待...
</script>

<script id="umeng-iframe-tmpl" type="text/x-jsrender">
		<iframe src="http://www.umeng.com/apps/4100008dd65107258db11ef4/reports" name="ument-iframe"class="umeng-iframe"></iframe>
</script>

<script id="data-table-tmpl" type="text/x-jsrender">
	<div class="search-box">
		名称：
		<input type="text" id="search-key" value="{{:searchKey}}" class="form-control">
		<input  type="hidden" id="current-menucode" value="{{:menucode}}" />
		<button type="button" id="search-btn" class="btn btn-success">查询</button> 
	</div>
	<table id="{{:id}}" class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					{{for thead}}
					<th>{{:name}}</th>
					{{/for}}
				</tr>
			</thead>
			<tbody>
				{{if emptyRow}}
					<tr>	
							<td colspan="{{:colspan}}" style="text-align:center">暂无结果</td>
				</tr>
				{{else}}
				{{for rows}}
				<tr>	
					{{for cols}}	
							{{if clickable}}
								<td><a class="row-key" entity_id="{{:id}}">{{:value}}</a></td>
							{{else}}
								<td>{{:value}}</td>
							{{/if}}						
							
					{{/for}}		
				</tr>
				{{/for}}
				{{/if}}
			</tbody>
		</table>
		{{if !emptyRow}}
		<ul class="pagination">
		  <li {{if disablePre}}class="disabled"{{/if}}><a  class="pager-pre"  href="javascript:void(0)">&laquo;</a></li>
		  {{for pager}}
		  	<li {{if active}}class="active"{{/if}}>
		  		<a class="pager-num "  href="javascript:void(0)">{{:num}}</a></li>
		  {{/for}}
		  <li {{if disableNext}}class="disabled"{{/if}}><a  class="pager-next" href="javascript:void(0)">&raquo;</a></li>
		</ul>
		{{/if}}
</script>	

<script id="modal-tmpl" type="text/x-jsrender">
	<div class="modal fade" id="detail-info-modal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">{{:title}}</h4>
	      </div>
	      <div class="modal-body">
	        <form role="form">
	        	{{for details}}
					  <div class="form-group">
					    <label>{{:label}}</label>
					    <input type="text" value="{{:value}}" class="form-control">
					  </div>
					  {{/for}}
					</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-success">保存</button>
	      </div>
	    </div>
	  </div>
	</div>
</script>