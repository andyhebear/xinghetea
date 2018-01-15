<?php

/* 运费模板控制器 */
class My_deliveryApp extends StoreadminbaseApp
{
    var $_delivery_mod;
	var $_region_mod;
	var $_store_id;

    function __construct()
    {
        $this->My_deliveryApp();
    }

    function My_deliveryApp()
    {
        parent::__construct();

        $this->_delivery_mod =& m('delivery_template');
		$this->_region_mod =& m('region');
		$this->_store_id  = intval($this->visitor->get('manage_store'));
    }

    /* 管理 */
    function index()
    {
		$page = $this->_get_page(2);
		$delivery_template = $this->_delivery_mod->find(array(
			'conditions'=>'store_id='.$this->_store_id,
			'limit'=> $page['limit'],
			'count' => true,
			'order'=>'template_id desc'
		));
		
		$page['item_count'] = $this->_delivery_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
		
		$deliverys = $this->_delivery_mod->format_template($delivery_template);
		
		
		/* 当前页面信息 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_delivery'), 'index.php?app=my_delivery',
                         LANG::get('delivery_list'));
        $this->_curitem('my_delivery');
        $this->_curmenu('delivery_list');
		
		$this->assign('deliverys', $deliverys);
		
		$this->display('my_delivery.index.html');
		
    }

	
	function add()
	{
		if(!IS_POST)
		{
			$this->assign('regions', $this->_region_mod->get_options(0));
			/* 导入jQuery的表单验证插件 */
            $this->_import_resource();
			
			$this->assign('delivery', array('plus_type'=>$this->_delivery_mod->get_plus_type()));
			
			/* 当前页面信息 */
        	$this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_delivery'), 'index.php?app=my_delivery',
                         LANG::get('delivery_add'));
        	$this->_curitem('my_delivery');
        	$this->_curmenu('delivery_add');
			
			$this->display('my_delivery.form.html');
		}
		else
		{			
			$data = array();
			$post_types = $_POST['template_types'];
			
			foreach($post_types as $type)
			{
				$post_dests .=';'.implode(',',$_POST[$type.'_dests']);
				$post_start .=';'.implode(',',$_POST[$type.'_start']);
				$post_postage .=';'.implode(',', $_POST[$type.'_postage']);
				$post_plus    .=';'.implode(',', $_POST[$type.'_plus']);
				$post_postageplus .=';'.implode(',', $_POST[$type.'_postageplus']);
			}
			
			$data = array(
				'name'						=> trim($_POST['name']),
				'store_id'					=> $this->_store_id,
				'template_types'			=> implode(';',$post_types),
				'template_dests' 			=> substr($post_dests,1),
				'template_start_standards' 	=> substr($post_start,1),
				'template_start_fees'	 	=> substr($post_postage,1),
				'template_add_standards'   	=> substr($post_plus,1),
				'template_add_fees'			=> substr($post_postageplus,1),
				'created'					=> time()
			);
			if(!$this->_check_data($data['template_start_standards']) || !$this->_check_data($data['template_start_fees']) || !$this->_check_data($data['template_add_standards']) || !$this->_check_data($data['template_add_fees'])){
				$this->show_warning('fee_and_quantity_must_number');
				return false;
			}
			
			$id = $this->_delivery_mod->add($data);
			//推送到所有店铺
			$this->batch_delivery('add', $id, $data);
			
			$this->show_message('add_ok',
                'back_list',    'index.php?app=my_delivery',
                'continue_add', 'index.php?app=my_delivery&amp;act=add'
            );
			
		}
	}
	function edit()
	{
		$template_id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		if(!$template_id){
			$this->show_warning('Hacking Attempt');
            return;
		}
		if(!IS_POST)
		{
			$delivery = $this->_delivery_mod->format_template_foredit($template_id);
			if($delivery['store_id'] != $this->_store_id) {
				$this->show_warning('Hacking Attempt');
				return;
			}
			
			$this->assign('delivery', $delivery);
			
			$this->assign('regions', $this->_region_mod->get_options(0));
			/* 导入jQuery的表单验证插件 */
			$this->_import_resource();
     
			/* 当前页面信息 */
        	$this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_delivery'), 'index.php?app=my_delivery',
                         LANG::get('delivery_edit'));
        	$this->_curitem('my_delivery');
        	$this->_curmenu('delivery_edit');
			
			$this->display('my_delivery.form.html');
		}
		else 
		{
			$template_id = empty($_GET['id']) ? 0 : intval($_GET['id']);
			if(!$template_id){
				$this->show_warning('Hacking Attempt');
				return;
			}
			
			$data = array();
			$post_types = $_POST['template_types'];
			
			foreach($post_types as $type)
			{
				$post_dests .=';'.implode(',',$_POST[$type.'_dests']);
				$post_start .=';'.implode(',',$_POST[$type.'_start']);
				$post_postage .=';'.implode(',',$_POST[$type.'_postage']);
				$post_plus    .=';'.implode(',', $_POST[$type.'_plus']);
				$post_postageplus .=';'.implode(',', $_POST[$type.'_postageplus']);
			}
			
			$data = array(
				'name'						=> trim($_POST['name']),
				'store_id'					=> $this->_store_id,
				'template_types'			=> implode(';',$post_types),
				'template_dests' 			=> substr($post_dests,1),
				'template_start_standards' 	=> substr($post_start,1),
				'template_start_fees'	 	=> substr($post_postage,1),
				'template_add_standards'   	=> substr($post_plus,1),
				'template_add_fees'			=> substr($post_postageplus,1),
			);	
			if(!$this->_check_data($data['template_start_standards']) || !$this->_check_data($data['template_start_fees']) || !$this->_check_data($data['template_add_standards']) || !$this->_check_data($data['template_add_fees'])){
				$this->show_warning('fee_and_quantity_must_number');
				return;
			}
			
			if(!$this->_delivery_mod->edit("template_id={$template_id} AND store_id={$this->_store_id}", $data)) {
				$this->show_warning('edit_error');
				return;
			}
			$this->batch_delivery('edit', $template_id, $data);
			$this->show_message('edit_ok',
                'back_list',    'index.php?app=my_delivery',
                'continue_edit', 'index.php?app=my_delivery&amp;act=edit&amp;id='.$template_id
            );
		}
	}
	function copy_tpl()
	{
		$template_id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		if(!$template_id){
			$this->show_warning('Hacking Attempt');
            return;
		}
		$delivery_template = $this->_delivery_mod->get($template_id);
		
		if($delivery_template['store_id'] != $this->_store_id) {
			$this->show_warning('Hacking Attempt');
			return;
		}
			
		$delivery_template['name'] = $delivery_template['name'] . LANG::get('copy_word');
		unset($delivery_template['template_id']);
		$id = $this->_delivery_mod->add($delivery_template);
		//推送到所有店铺
		$this->batch_delivery('add', $id, $delivery_template);
		
		$this->show_message('copy_ok',
                'back_list','index.php?app=my_delivery'
        );
		
	}
	function drop()
	{
		$template_id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		if(!$template_id){
			$this->show_warning('Hacking Attempt');
            return;
		}
		if(!$this->_delivery_mod->get(array('conditions'=>'store_id='.$this->_store_id.' AND template_id !='.$template_id,'fields'=>'template_id'))){
			$this->show_warning('no_allow_drop_last_delivery_template');
			return;
		}
		
		if(!$this->_delivery_mod->drop("template_id={$template_id} AND store_id={$this->_store_id}")) {
			$this->show_warning('drop_fail');
			return;
		}
		//删除之前推送的优惠信息
		$this->batch_delivery('drop', $template_id, '');
		$this->show_message('drop_ok',
                'back_list','index.php?app=my_delivery'
        );
	}
	
	function _check_data($data)
	{
		$data = explode(';', $data);
		
		foreach($data as $key=>$val)
		{
			$arr = explode(',', $val);
			foreach($arr as $k=>$v)
			{
				if(!is_numeric($v) || $v<0 || $v==''){
					return false;
				}
			}
		}
		return true;
	}

	function _import_resource()
    {
		$resource['script'] = array(array( // JQUERY UI
			'path' => 'jquery.ui/jquery.ui.js'
		),
		array(
			'path' => 'mlselection.js',
		),
		array(
			'path' => 'jquery.plugins/jquery.validate.js',
		),
		array( // 对话框
			'attr' => 'id="dialog_js"',
			'path' => 'dialog/dialog.js'
		),
		array(
			'attr' => 'id="delivery_js"',
			'path' => 'delivery.js'
		));		
        $this->import_resource($resource);
    }
	
	function _get_member_submenu()
    {
	    //增加是否为旗舰店判断 by PwordC
	    $store_id = $this->visitor->get('store_id');
	    if ($store_id == 2){
	        $menus = array(
	            array(
	                'name' => 'delivery_list',
	                'url'  => 'index.php?app=my_delivery',
	            ),
	            array(
	                'name' => 'delivery_add',
	                'url'  => 'index.php?app=my_delivery&amp;act=add',
	            ),
	        );
	        $this->assign('allow_handle',1);
	    }else {
	        $menus = array(
	            array(
	                'name' => 'delivery_list',
	                'url'  => 'index.php?app=my_delivery',
	            ),
	        );
	    } 
        if (ACT == 'edit')
        {
            $menus[] = array(
                'name' => 'delivery_edit',
                'url'  => '',
            );
        }
        return $menus;
    }
    /*
     * 运费模板推送到所有店铺
     */
    function batch_delivery($type,$id,$data){
        $store_mod =& m('store');
        $store_id = $this->visitor->get('store_id');
        $other_store_ids = $store_mod->find(array(
            'conditions' => 'store_id != '.$store_id,
            'fields' => 'store_id',
        ));
        $store_ids = array();
        foreach ($other_store_ids as $k=>$v){
            array_push($store_ids,$v['store_id']);
        }
        if($type=='edit'){
            $info = $this->_delivery_mod->get("template_id={$id}");
            $template_ids = $this->_delivery_mod->find(array(
                'conditions' => "parent_id = '".$id."' and store_id !=".$store_id,
                'fields' => 'template_id,store_id',
            ));
            foreach ($template_ids as $k=>$v){
                $data['store_id'] = $v['store_id'];
                $this->_delivery_mod->edit($v['template_id'],$data);
            }
        }
        if($type=='add'){
            foreach ($store_ids as $k=>$v){
                $data['store_id'] = $v;
                $data['parent_id'] = $id;
                $this->_delivery_mod->add($data);
            }
        }
        if ($type=='drop'){
            $other_ids = $this->_delivery_mod->find(array(
               'conditions' => "parent_id ={$id} and store_id !={$store_id}",
               'fields' =>'template_id',
            ));
            foreach ($other_ids as $v){
                $this->_delivery_mod->drop($v['template_id']);
            }
        }
    }
}

?>