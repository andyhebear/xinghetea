<?php echo $this->fetch('header.html'); ?>
<style type="text/css">
.store_reply {padding:5px 0px; color:green;}
</style>
<div id="rightTop">
  <p>咨询管理</p>
</div>
<div id="flexigrid"></div>
<script type="text/javascript">
$(function(){
	var data_url = 'index.php?app=consulting&act=get_xml';
    $("#flexigrid").flexigrid({
    	url: data_url,
    	colModel : [
    		{display: '操作', name : 'operation', width : 50, sortable : false, align: 'center', className: 'handle'},
			{display: '咨询人', name : 'user_name', width : 100, sortable : true, align: 'center'},
			{display: '类型', name : 'type', width : 50, sortable : true, align: 'center'},
			{display: '咨询对象', name : 'item_name', width : 150, sortable : true, align: 'center'},
    		{display: '咨询内容', name : 'question_content', width : 250, sortable : true, align: 'center'},
			{display: '店主回复', name : 'reply_content', width : 250, sortable : true, align: 'center'},
    		{display: '店铺名称', name : 'store_name', width : 80, sortable : true, align: 'center'},    		
			{display: '咨询时间', name : 'time_post', width: 150, sortable : true, align : 'center'}	
    		],
        buttons : [
            {display: '<i class="fa fa-trash"></i>批量删除', name : 'del', bclass : 'del', title : '将选定行数据批量删除', onpress : fg_operate }
        ],
		searchitems : [
			{display: '咨询人', name : 'user_name'},
			{display: '咨询内容', name : 'question_content'},
            {display: '店铺名称', name : 'store_name'},
        ],
    	sortname: "time_post",
    	sortorder: "desc",
    	title: '咨询列表'
    });
});
function fg_operate(name, bDiv) {
	if($('.trSelected',bDiv).length>0){
        var itemlist = new Array();
		$('.trSelected',bDiv).each(function(){
			itemlist.push($(this).attr('data-id'));
		});
		if (name == 'del') {	
            fg_delete(itemlist,'consulting');
		}
    } else {
		parent.layer.alert('没有选择操作项',{icon: 0});
        return false;
    }
}
</script>
<?php echo $this->fetch('footer.html'); ?> 