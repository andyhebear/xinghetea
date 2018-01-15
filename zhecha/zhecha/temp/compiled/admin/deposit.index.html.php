<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>预存款管理</p>
  <ul class="subnav">
    <li><span>管理</span></li>
    <li><a class="btn1" href="index.php?app=deposit&amp;act=tradelist">交易记录</a></li>
    <li><a class="btn1" href="index.php?app=deposit&amp;act=rechargelist">充值管理</a></li>
    <li><a class="btn1" href="index.php?app=deposit&amp;act=setting">系统设置</a></li>
  </ul>
</div>
<div id="flexigrid"></div>
<script type="text/javascript">
$(function(){
	var data_url = 'index.php?app=deposit&act=get_account_xml';
    $("#flexigrid").flexigrid({
    	url: data_url,
    	colModel : [
    		{display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
			{display: '账户名', name : 'account', width : 200, sortable : true, align: 'center'},
			{display: '真实姓名', name : 'real_name', width : 100, sortable : true, align: 'center'},
    		{display: '用户名', name : 'user_name', width : 100, sortable : false, align: 'center'},
			{display: '金钱', name : 'money', width : 100, sortable : true, align: 'center'},
    		{display: '冻结', name : 'frozen', width : 100, sortable : true, align: 'center'},    		
			{display: '开启余额支付', name : 'pay_status', width: 100, sortable : true, align : 'center'},
			{display: '创建时间', name : 'add_time', width: 150, sortable : true, align : 'center'},  		
    		],
        buttons : [
            {display: '<i class="fa fa-trash"></i>批量删除', name : 'del', bclass : 'del', title : '将选定行数据批量删除', onpress : fg_operate },
			{display: '<i class="fa fa-file-excel-o"></i>导出数据', name : 'csv', bclass : 'csv', title : '将选定行数据导出CVS文件', onpress : fg_operate}
        ],
		searchitems : [
			{display: '账户名', name : 'account'},
			{display: '用户名', name : 'user_name'},
            {display: '真实姓名', name : 'real_name'}
        ],
    	sortname: "add_time",
    	sortorder: "desc",
    	title: '预存款账号列表'
    });
});
function fg_operate(name, bDiv) {
	var itemlist = new Array();
	$('.trSelected',bDiv).each(function(){
		itemlist.push($(this).attr('data-id'));
	});
	if (name == 'del') {
	   if($('.trSelected',bDiv).length==0){
		   parent.layer.alert('没有选择操作项',{icon: 0});
			return false;
	   }
       fg_delete(itemlist,'deposit');
	}
	if(name == 'csv'){
		if($('.trSelected',bDiv).length==0){
		   parent.layer.confirm('您确定要下载全部数据吗？',{icon: 3, title:'提示'},function(index){
				fg_csv(itemlist);
				parent.layer.close(index);
			},function(index){
				parent.layer.close(index);
			});
	   }else{
		   fg_csv(itemlist);
	   }
	}
}
</script>
<?php echo $this->fetch('footer.html'); ?> 