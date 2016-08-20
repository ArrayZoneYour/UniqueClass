<?php
namespace Student\Controller;
use Think\Controller;

class FriendLinkController extends Controller {
	//检查登录
	public function __construct(){
		parent::__construct();
		if(!session('?student_number')){
			$this->error('非法用户，请先登录！', U('Index/login'));
		}else {
            # 实例化user表
            $user = M('user');
            # 从session中获取用户编号
            $student_number = session('student_number');
            # 根据用户编号定位信息
            $where = array(
            'student_number' => $student_number,
            );
            //根据查询条件获取学生信息，由于是单条数据，因此使用find方法
            $user_info = $user->where($where)->find();
            //将学生信息分配到视图页面
            $this->assign('user_info', $user_info);
        }
	}

      public function input() {
        //判断是否有POST数据，如果有则说明需要进行数据更新
        if (IS_POST) {
            //使用create方法获取表单数据
            $username = $_POST['username'];
            $password = $_POST['password'];
            $urllib = new \Think\FriendLink();
            $url = $urllib->url($username,$password);
            $QRlib = new \Think\QRcodeOutputer();
            $QRcode = $QRlib->output($url,10);
        }
        //显示视图
        $this->assign("QRcode",$QRcode);
        $this->display();
      }

      public function fastLogin() {

      }
}