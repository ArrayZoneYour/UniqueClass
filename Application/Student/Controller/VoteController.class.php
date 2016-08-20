<?php

namespace Student\Controller;
use Think\Controller;
class VoteController extends Controller {

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

    public function add() {}

    public function vote() {}

    public function view() {}
}

