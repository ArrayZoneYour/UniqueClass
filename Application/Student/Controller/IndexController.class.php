<?php
namespace Student\Controller;
use Think\Controller;
class IndexController extends Controller{

    

	public function index() {
        if ($student_number = session('student_number')) {//验证SESSION
            $student_name = session('student_name');//获取名字
            $this->assign('student_number', $student_number);//将姓名和学号分配到视图
            $this->assign('student_name',$student_name);
            $this->display();
        } else {
            $this->error('非法用户，请先登录！', U('login'));
 	    }
 	}


    public function login() {
        if (IS_POST) {
            $student_number = $_POST['student_number'];
            $password = $_POST['password'];
            if(!trim($student_number)){
               return show(0,'用户名不能为空');
            }
            if(!trim($password)){
               return show(0,'密码不能为空');
            }
            $data = D('Index')->getDataByStudentNumber($student_number);
            if(!$data){
                return show(0,'该用户不存在');
            }
            if($data['password'] != getMd5Password($password)){
                return show(0,'密码错误');
            }
            session('student_number', $data['student_number']);
            session('lastlogin', $data['lastlogin']);
            $data['lastlogin'] = time();
            $update = D('Index')->updateLoginData($data,$student_number);
            return show(1,'登录成功');
        }
        $this->display();
    }


	public function logout(){
		session(null);
		$this->success('退出成功。',U('login'));
	}
}