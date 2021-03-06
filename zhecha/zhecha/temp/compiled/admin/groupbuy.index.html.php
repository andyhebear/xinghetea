<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>团购管理</p>
</div>
<div id="flexigrid"></div>
<script type="text/javascript">
$(function(){
	var data_url = 'index.php?app=groupbuy&act=get_xml';
    $("#flexigrid").flexigrid({
    	url: data_url,
    	colModel : [
    		{display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
			{display: '团购名称', name : 'group_name', width : 250, sortable : true, align: 'center'},
			{display: '店铺名称', name : 'store_name', width : 100, sortable : true, align: 'center'},
    		{display: '状态', name : 'state', width : 50, sortable : true, align: 'center'},
			{display: '起止时间', name : 'start_time', width : 150, sortable : true, align: 'center'},
    		{display: '结束时间', name : 'end_time', width : 150, sortable : true, align: 'center'},    		
			{display: '订购数', name : 'count', width: 50, sortable : true, align : 'center'},
			{display: '成团数', name : 'min_quantity', width: 50, sortable : true, align : 'center'},  
			{display: '浏览数', name : 'views', width: 50, sortable : true, align : 'center'},
			{display: '推荐', name : 'recommended', width: 50, sortable : true, align : 'center'} 		
    		],
        buttons : [
            {display: '<i class="fa fa-thumbs-o-up"></i>批量推荐', name : 'recommend', bclass : 'csv', title : '批量推荐', onpress : fg_operate},
            {display: '<i class="fa fa-trash"></i>批量删除', name : 'del', bclass : 'del', title : '将选定行数据批量删除', onpress : fg_operate }
        ],
		searchitems : [
			{display: '团购名称', name : 'group_name'},
            {display: '店铺名称', name : 'store_name'}
        ],
    	sortname: "group_id",
    	sortorder: "desc",
    	title: '团购列表'
    });
});
function fg_operate(name, bDiv) {
	if($('.trSelected',bDiv).length>0){
        var itemlist = new Array();
		$('.trSelected',bDiv).each(function(){
			itemlist.push($(this).attr('data-id'));
		});
		if (name == 'del') {	
            fg_delete(itemlist,'groupbuy');
		}else if(name == 'recommend'){
			fg_recommend(itemlist);
		}
    } else {
		parent.layer.alert('没有选择操作项',{icon: 0});
        return false;
    }
}
function fg_recommend(id){
	var url = 'index.php?app=groupbuy&act=recommended';
	parent.layer.confirm('设置为推荐团购可以显示出来，确认设置为推荐吗？',{icon: 3, title:'提示'},function(index){
		$.ajax({
			type: "GET",
			dataType: "json",
			url: url,
			data: "id="+id,
			success: function(data){
				if (data.done){
					parent.layer.msg(data.msg,{icon: 1,time: 500}, function(){
						window.location.reload();
					});
				} else {
					parent.layer.alert(data.msg);
				}
			}
		});
		parent.layer.close(index);
	},function(index){
		parent.layer.close(index);
	});
}
</script>
<?php echo $this->fetch('footer.html'); ?> 