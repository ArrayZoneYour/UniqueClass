<?php
namespace Viewer\Controller;
use Think\Controller;

class LoginController extends Controller {

    public function index(){
    	if (session('adminUser')) {
    		redirect(U('Interview/Index'));
    	}
    	// $res = D('admin')->getAdminByUsername('admin');
    	// print_r($res);

        $this->display();
        // return show(1,'测试成功');
    }

    public function check() {
    	$username = $_POST['username'];
    	$password = $_POST['password'];
    	if(!trim($username)) {
    		return show(0,'用户名不能为空');
    	}
    	if(!trim($password)) {
    		return show(0,'密码不能为空');
    	}

    	$ret = D('Admin')->getAdminByUsername($username);
    	// print_r($res);
    	if(!$ret) {
    		return show(0,'该用户不存在');
    	}

    	if($ret['apwd'] != md5($password)) {
    		return show(0,'密码错误');
    	}

    	session('adminUser', $ret);
    	return show(1,'登录成功');
    }

    public function logout() {
        session('adminUser',NULL);
        $url = U('Login/Index');
        redirect($url);
    }
}