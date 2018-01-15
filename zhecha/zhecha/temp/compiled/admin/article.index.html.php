<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>文章管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=article&amp;act=add">新增</a></li>
    </ul>
</div>
<div id="flexigrid"></div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
    	url: 'index.php?app=article&act=get_xml',
    	colModel : [
    		{display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
    		{display: '排序', name : 'sort_order', width : 50, sortable : true, align: 'center'},
			{display: '标题', name : 'title', width : 250, sortable : true, align: 'center'},
    		{display: '文章分类', name : 'cate_name', width : 150, sortable : true, align: 'left'},    		
			{display: '显示', name : 'if_show', width: 50, sortable : true, align : 'center'},
			{display: '添加时间', name : 'add_time', width: 150, sortable : true, align : 'center'}   		
    		],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', title : '新增数据', onpress : fg_operate},
            {display: '<i class="fa fa-trash"></i>批量删除', name : 'del', bclass : 'del', title : '将选定行数据批量删除', onpress : fg_operate }
        ],
		searchitems : [
            {display: '标题', name : 'title'},
            {display: '文章分类', name : 'cate_name'}
        ],
    	sortname: "sort_order",
    	sortorder: "asc",
    	title: '文章列表'
    });
});
function fg_operate(name, bDiv) {
    if (name == 'del') {
        if($('.trSelected',bDiv).length>0){
            var itemlist = new Array();
			$('.trSelected',bDiv).each(function(){
				itemlist.push($(this).attr('data-id'));
			});
            fg_delete(itemlist,'article');
        } else {
            return false;
        }
    } else if (name == 'add') {
    	window.location.href = 'index.php?app=article&act=add';
    }
}
</script>
<?php echo $this->fetch('footer.html'); ?> 
