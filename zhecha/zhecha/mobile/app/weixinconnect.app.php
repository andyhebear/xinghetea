<?php

class WeixinconnectApp extends MallbaseApp
{
	var $_bind_mod;
	var $_app;
	var $_config = array();
	var $_member_mod;
	
    function __construct()
    {
        $this->WeixinconnectApp();
    }
    function WeixinconnectApp()
    {
        parent::__construct();
		$this->_bind_mod 	= &m('member_bind');
		$this->_member_mod 	= &m('member');
		$this->_app      	= 'weixin';

		$this->_config = $this->_get_plugin_conf(array('name'=>'weixinconnect','event'=>'on_weixin_login'));
    }
	
	function callback()
	{
		extract($this->_config);
		
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$AppId}&secret={$AppSecret}&code={$_GET['code']}&grant_type=authorization_code";
		
		$result = ecm_curl($url);
		
		if($result)
		{
			$result = json_decode($result, true);
			
			$openid = $result['openid'];
			$unionid = isset($result['unionid']) ? $result['unionid'] : $openid;
			
			if(!$unionid)
			{
				$this->show_warning('登录授权失败，请重新发起授权！');
				return;
			}
			
			$bind = $this->_bind_mod->get(array('conditions'=>"unionid='".$unionid."' AND app='".$this->_app."'", 'fields'=>'user_id'));
			
			if($bind && $bind['user_id'])
			{
				$user_id = $bind['user_id'];
				
				/* 如果该unionid已经绑定， 则检查该用户是否填写了手机或电子邮件 */
				$member = $this->_member_mod->get(array('conditions'=>'user_id='.$user_id, 'fields'=>'phone_mob, email'));
				
				/* 如果没有此用户，则说明绑定数据过时，删除绑定 */
				if(!$member) {
					$this->_bind_mod->drop('user_id='.$user_id);
					$this->show_message('bind_data_error');
					return;
				}

				// 执行登录
				$this->_do_login($user_id);
				
				/* 同步登陆外部系统 */
				$ms =& ms();
				$synlogin = $ms->user->synlogin($user_id);
				$this->show_message(Lang::get('login_successed') . $synlogin, 'back_index', site_url());
			}
			else
			{
				//授权令牌
				$token = $result['access_token'];
			
				//获取用户个人信息（UnionID机制）
				$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid;
				$user_info = ecm_curl($url);
				$user_info = json_decode($user_info, true);
				
				// 进入绑定模式
				$_SESSION['bind'] = array(
					'unionid'			=> $unionid,
					'openid' 			=> $openid, 
					'app' 				=> $this->_app, 
					'bind_expire_time' 	=> gmtime() + 600, 
					'nickname' 			=> $user_info['nickname'], 
					'portrait'			=> $user_info['headimgurl'],
					'real_name'			=> $user_info['nickname']
				);
				$url = SITE_URL . '/' . url('app=member&act=bind&codeType=phone');
				header("Location:".htmlspecialchars_decode($url));
			}
		}
		else
		{
    		$this->show_warning('verify_fail');
			return;
		}

	}
	function login()
	{
		extract($this->_config);
		
		$url = $gateway . "appid=".$AppId."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
		
		header("location:$url");
	}
}

?>