<?php
namespace Teacher\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index() {
        if ($admin_name = session('admin_name')) {
            $this->assign('admin_name', $admin_name);
            $this->display();
        } else {
            $this->error('非法用户，请先登录！', U('login'));
 	    }
 	}


    public function login() {
        if (IS_POST) {
            $adminModel = M('admin');
            $subjectModel = M('subject');
            $adminInfo = $adminModel->create();
            $where = array(
                'aname' => $adminInfo['aname'],
            );
            if ($realPwd = $adminModel->where($where)->getField('apwd')) {
                if ($realPwd == md5($adminInfo['apwd'])) {
                    if ($adminModel->where($where)->getField('admin_level') == 2){
                        session('admin_name', $adminInfo['aname']);
                        $subject = $adminModel->where($where)->getField('subject');
                        session('subject',$subject);
                        $where_subject = array('subject_id' => $subject);
                        $subject_name = $subjectModel->where($where_subject)->getField('subject_name');
                        session('subject_name',$subject_name);
                        session('subject_id',$subject);
                        $this->redirect('Index/index');
                    }else{
                        $this->error('您不具有老师的权限！');
                    }
                }
            }
            $this->error('用户名或密码不正确，请重试！');
        }
        $this->display();
    }


	public function logout(){
		session(null);
		$this->redirect('Index/login');
    }
}