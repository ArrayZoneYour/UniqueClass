<?php
namespace Admin\Controller;
use Think\Controller;
class SubjectController extends Controller{
	//检查登录
	public function __construct(){
		parent::__construct();
		if(!session('?admin_name')){
			$this->error('非法用户，请先登录！', U('Index/login'));
		}
	}
	//科目列表展示功能
    public function showSubject() {
        //实例化Student模型对象
        $model = M('subject');
        $subject_class = M('subject_class');
        //判断是否有参数subject_id，如果有则使用I方法接收并赋值给$subject，如果没有则使用默认值1
        $class_id = I('param.class_id', 1);
        // $sql = 'select c.subject_id,c.subject_name from stu_subject_class as sc left join stu_class as s on s.class_id=sc.class_id='.$class_id.' left join stu_subject as c on c.subject_id=sc.subject_id';
        // //以数组的形式组合查询条件
        $where = array('class_id' => $class_id);
        // //通过模型类获取指定班级ID的学生信息
        //select a.*,b.* from where aid = bid = 1;
        // $subject_info = $model->where($where)->select();
        //把班级ID分配到视图页面
        $this->assign('class_id', $class_id);
        //把科目信息分配到视图页面
        $this->assign('subject_info', $subject_info);
		// //实例化Major模型对象，使用relation方法进行关联操作
		// $subject_info = D('subject')->relation(true)->select();
        // 
        $sql = 'select * from (select c.class_id,s.subject_id,s.subject_name from stu_subject_class as sc left join stu_class as c on c.class_id=sc.class_id=1 left join stu_subject as s on s.subject_id=sc.subject_id) as result where class_id='.$class_id.'';
        $subject_info = $model->query($sql);
        //把专业及班级信息分配到视图页面
        $this->assign('subject_info', $subject_info);
        // 
        $major_info = D('major')->relation(true)->select();
        //把专业及班级信息分配到视图页面
        $this->assign('major_info', $major_info);
        //显示视图
        $this->display();
    }
}