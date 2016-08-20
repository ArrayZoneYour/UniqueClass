<?php
namespace Admin\Controller;
use Think\Controller;

class TimeController extends Controller{

	//检查登录
	public function __construct(){
		parent::__construct();
		if(!session('?admin_name')){
			$this->error('非法用户，请先登录！', U('Index/login'));
		}
	}	
	//自习时间查看功能
	public function showTime(){
		$Week = new \Think\Week();
		//实例化time_day和user模型对象
		$model = M('user');
		$time = M('time_day');
		//以数组的形式组合查询条件
		$week = I('param.week','5');
		$sum = '(b.mon+b.tue+b.wed+b.thu+b.fri+b.sat+b.sun)';
		if(IS_POST){
			$count = $model->alias('a')
			->join('LEFT JOIN stu_time_day b ON a.student_number =b.student_number')
			->where('b.week = '.$week)
			->count();// 查询满足要求的总记录数
			$Page = new \Think\Page($count,27);
			// 实例化分页类 传入总记录数和每页显示的记录数
			$order = $_POST[order_first].' '.$_POST[order_second];
			$this->assign('order',$order);
			$time_info = $model->alias('a')
			->join('LEFT JOIN stu_time_day b ON a.student_number =b.student_number')
			->field('a.student_name,a.student_number,b.mon,b.tue,b.wed,b.thu,b.fri,b.sat,b.sun,b.week,'.$sum.' AS time_all')
			->where('b.week = '.$week)
			->order($order)
			->limit($Page->firstRow.','.$Page->listRows)
			->select();
		}else{
			$count = $model->alias('a')
			->join('LEFT JOIN stu_time_day b ON a.student_number =b.student_number')
			->where('b.week = '.$week)
			->count();// 查询满足要求的总记录数
			$Page = new \Think\Page($count,27);
			// 实例化分页类 传入总记录数和每页显示的记录数
			$time_info = $model->alias('a')
			->join('LEFT JOIN stu_time_day b ON a.student_number =b.student_number')
			->field('a.student_name,a.student_number,b.mon,b.tue,b.wed,b.thu,b.fri,b.sat,b.sun,b.week,'.$sum.' AS time_all')
			->where('b.week = '.$week)
			->order('a.student_number ASC')
			->limit($Page->firstRow.','.$Page->listRows)
			->select();
		}
		//把自习时间分配到视图页面
		$show = $Page->show();// 分页显示输出
		$show_week = $Week->show(5,13,$week);
		$this->assign('time_info',$time_info);
		// $this->assign('order',$order);
		$this->assign('count',$count);
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('week',$show_week);
		//显示视图
		$this->display();
	}

	public function timeNull() {
		$Week = new \Think\Week();
		$week = I('param.week',8);
		$user = M('user');
		$timeNull = $user->alias('a')
		->join('LEFT JOIN stu_time_day b ON a.student_number =b.student_number and b.week = '.$week)
		->field('a.student_name,a.student_number')
		->where('b.mon IS NULL')
		->select();
		$show_week = $Week->show(5,13,$week);
		$this->assign('timeNull',$timeNull);
		$this->assign('week',$show_week);
		$this->display();
	}
}