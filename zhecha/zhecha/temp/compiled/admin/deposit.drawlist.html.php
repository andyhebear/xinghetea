<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>预存款管理</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=deposit">管理</a></li>
    <li><a class="btn1" href="index.php?app=deposit&amp;act=tradelist">交易记录</a></li>
    <li><span>提现管理</span></li>
    <li><a class="btn1" href="index.php?app=deposit&amp;act=rechargelist">充值管理</a></li>
    <li><a class="btn1" href="index.php?app=deposit&amp;act=setting">系统设置</a></li>
  </ul>
</div>
<div id="flexigrid"></div>
<script type="text/javascript">
$(function(){
	var data_url = 'index.php?app=deposit&act=get_drawlist_xml';
    $("#flexigrid").flexigrid({
    	url: data_url,
    	colModel : [
    		{display: '操作', name : 'operation', width : 120, sortable : false, align: 'left', className: 'handle'},
			{display: '创建时间', name : 'add_time', width : 150, sortable : true, align: 'center'},
			{display: '商户订单号', name : 'orderId', width : 150, sortable : true, align: 'center'},
    		{display: '交易号', name : 'tradeNo', width : 150, sortable : true, align: 'center'},
			{display: '用户名', name : 'user_name', width : 50, sortable : false, align: 'center'},
			{display: '名称', name : 'name', width : 100, sortable : false, align: 'center'},
			{display: '金额', name : 'amount', width : 80, sortable : true, align: 'center'}, 
    		{display: '提现到', name : 'card_info', width : 350, sortable : false, align: 'center'},    		
			{display: '状态', name : 'status', width: 100, sortable : true, align : 'center'}  		
    		],
        buttons : [
            {display: '<i class="fa fa-trash"></i>批量删除', name : 'del', bclass : 'del', title : '将选定行数据批量删除', onpress : fg_operate },
			{display: '<i class="fa fa-file-excel-o"></i>导出数据', name : 'csv', bclass : 'csv', title : '将选定行数据导出CVS文件', onpress : fg_operate}
        ],
		searchitems : [
			{display: '商户订单号', name : 'orderId'},
			{display: '交易号', name : 'tradeNo'},
            {display: '用户名', name : 'user_name'}
        ],
    	sortname: "add_time",
    	sortorder: "desc",
    	title: '提现记录列表'
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
       fg_delete(itemlist,'deposit','drop_draw');
	}
	if(name == 'csv'){
		if($('.trSelected',bDiv).length==0){
		   parent.layer.confirm('您确定要下载全部数据吗？',{icon: 3, title:'提示'},function(index){
				fg_csv(itemlist,'export_draw_csv');
				parent.layer.close(index);
			},function(index){
				parent.layer.close(index);
			});
	   }else{
		   fg_csv(itemlist,'export_draw_csv');
	   }
	}
}
function fg_withdraw_verify(id,content){
	parent.layer.confirm('请您认真核对提现信息，并做审核操作！'+content,{icon: 3, title:'提示',btn: ['同意', '拒绝']},function(index){
		$.ajax({
			type: "GET",
			dataType: "json",
			url: 'index.php?app=deposit&act=withdraw_verify&tradeNo='+id,
			success: function(data){
				if (data.done){
					parent.layer.alert('审核成功!',{icon:1});
					$("#flexigrid").flexReload();
				} else {
					parent.layer.alert(data.msg);
				}
			}
		});
	},function(index){
		parent.layer.prompt({
			formType: 2,
			value: '',
			title: '拒绝原因'
		}, function(value, index, elem){
			$.ajax({
				type: "GET",
				dataType: "json",
				url: 'index.php?app=deposit&act=withdraw_refuse',
				data: "tradeNo="+id+"&remark="+value,
				success: function(data){
					if (data.done){
						parent.layer.close(index);
						$("#flexigrid").flexReload();
					} else {
						parent.layer.alert(data.msg);
					}
				}
			});
		});
		parent.layer.close(index);
	});	
}
</script>
<?php echo $this->fetch('footer.html'); ?> 