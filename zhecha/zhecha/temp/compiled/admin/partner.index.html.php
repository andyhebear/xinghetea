<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>合作伙伴</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=partner&amp;act=add">新增</a></li>
    </ul>
</div>
<div id="flexigrid"></div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
    	url: 'index.php?app=partner&act=get_xml',
    	colModel : [
    		{display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
    		{display: '标题', name : 'title', width : 200, sortable : true, align: 'center'},
			{display: '链接', name : 'link', width : 200, sortable : true, align: 'center'},
    		{display: '图片标识', name : 'logo', width : 150, sortable : true, align: 'center'},  
			{display: '排序', name : 'sort_order', width: 100, sortable : true, align : 'center'},		
			{display: '显示', name : 'if_show', width: 100, sortable : true, align : 'center'}  		
    		],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', title : '新增数据', onpress : fg_operate},
            {display: '<i class="fa fa-trash"></i>批量删除', name : 'del', bclass : 'del', title : '将选定行数据批量删除', onpress : fg_operate }
        ],
		searchitems : [
            {display: '标题', name : 'title'}
        ],
    	sortname: "sort_order",
    	sortorder: "asc",
    	title: '合作伙伴列表'
    });
});
function fg_operate(name, bDiv) {
    if (name == 'del') {
        if($('.trSelected',bDiv).length>0){
            var itemlist = new Array();
			$('.trSelected',bDiv).each(function(){
				itemlist.push($(this).attr('data-id'));
			});
            fg_delete(itemlist,'partner');
        } else {
            return false;
        }
    } else if (name == 'add') {
    	window.location.href = 'index.php?app=partner&act=add';
    }
}
</script>
<?php echo $this->fetch('footer.html'); ?> 
