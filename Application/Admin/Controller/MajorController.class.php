<?php
namespace Admin\Controller;
use Think\Controller;
class MajorController extends Controller{
	//检查登录
	public function __construct(){
		parent::__construct();
		if(!session('?admin_name')){
			$this->error('非法用户，请先登录！', U('Index/login'));
		}
	}


    //展示专业和班级数据
    public function showMajor(){
		//实例化Major模型对象，使用relation方法进行关联操作
		$major_info = D('major')->relation(true)->select();
        //使用assign()方法分配数据
        $this->assign('major_info', $major_info);
        //显示视图
        $this->display();
    }
}