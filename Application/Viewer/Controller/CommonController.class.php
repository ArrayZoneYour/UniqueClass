<?php
namespace Viewer\Controller;
use Think\Controller;
class CommonController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->_init();
	}

	/**
	 * 初始化
	 * @return
	 */

	public function _init() {
		// 如果已经登录
		$isLogin = $this->isLogin();
		if(!$isLogin) {
			$url = U('Login/Index');
			redirect($url);
		}
	}

	/**
	 * @获取登录用户信息
	 * @return array
	 */

	public function getLoginUser() {
		return session("adminUser");
	}

	/**
	 * 判断是否登录
	 * @return  boolean 
	 */
	
	public function isLogin() {
		$user = $this->getLoginUser();
		if($user && is_array($user)) {
			return true;
		}

		return false;
	}
}