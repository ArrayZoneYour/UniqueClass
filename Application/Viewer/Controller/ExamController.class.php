<?php
namespace Viewer\Controller;
use Think\Controller;

class ExamController extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function sign() {
        $this->error("暂不开放");

		if (IS_POST) {
            //实例化sign模型类
            $model = M('sign');
            //获取要添加的学生信息
            $model->create();
            $alert = new \Think\Alert();
            //执行模型类的add()方法，完成数据添加
            if ($_POST['QQ'] !== 0) {
                //当添加成功后，提示信息并跳转到学生所属的学生列表页 
                $alert->alert("信息有误");
                return;
            }
            $model->add();
            $alert->alert("报名成功");
            return;
        }
        //显示视图文件
        $this->display();
    }

    public function check() {
        // $this->error("暂不开放");
    	//判断是否有POST表单提交
        if (IS_POST) {
            $student_number = $_POST['student_number'];
            $password = $_POST['password'];
            if(!trim($student_number)){
               return show(0,'student_number is null');
            }
            if(!trim($password)){
               return show(0,'password is null');
            }
            $data = D('Index')->getDataByStudentNumber($student_number);
            if(!$data){
                return show(0,'can\'t find the user');
            }
            if($data['password'] != getMd5Password($password)){
                return show(0,'password is wrong');
            }
            //实例化studnet模型类
            $model = M('cet');
            $where = array('student_number' => $student_number);
            //执行模型类的add()方法，完成数据添加
            $sign_info = $model->where($where)->select();
        }
        $this->assign('sign_info', $sign_info);
        $this->display();
    }
}