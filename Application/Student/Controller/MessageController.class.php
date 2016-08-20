<?php

namespace Student\Controller;
use Think\Controller;
class MessageController extends Controller {

	public function __construct(){
        parent::__construct();
        if(!session('?student_number')){
            $this->error('非法用户，请先登录！', U('Index/login'));
        }else {
            # 实例化user表
            $user = M('user');
            # 从session中获取用户编号
            $student_number = session('student_number');
            $student_name = session('student_name');
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

    public function add() {
        $student_number = session('student_number');
        $model = M('message');
        $model_level = M('level');
        $alert = new \Think\Alert();
        $level = $model_level->field('level')->where($where)->find();
        if (IS_POST) {
            if ($level == 1) {
                $model->create();
                $model->posttime = NOW_TIME;
                $model->postname = session(student_name);
                $message = $model->add();
                if ($message !== false) {
                    $alert->alert('消息发布成功！','view.html');
                } else {
                    $alert->alert('消息发布失败！');
                }
            }else{
                $alert->alert('您没有权限发布消息');
            }
            
        }
        $this->display();
        
    }

    public function update() {}

    public function delete() {}

    public function view() {
        $model = M('message');
        $message = $model->where('hide = 0')->order('top desc,posttime desc')->select();
        $this->assign('message',$message);
        $this->display();
    }
}
