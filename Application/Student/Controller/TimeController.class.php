<?php
namespace Student\Controller;
use Think\Controller;

class TimeController extends Controller{
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

	// 登记自习时间
	public function input() {
        $student_number = session('student_number');
        //获取time模型类对象
        $time = M('time_day');
        $config = M('config');
        $where_week = array('config_name' => week);
        $week = $config->where($where_week)->getField('config_cont');
        //组合查询条件
        $where = array(
            'student_number' => $student_number,
             'week' => I('get.week',$week),
        );
        //判断是否有POST数据，如果有则说明需要进行数据更新
        if (IS_POST) {
            // 首先判断自习时间是否录入
            $study_info = $time->where($where)->find();
            if($study_info['mon'] !== NULL || $study_info['tue'] !== NULL || $study_info['wed'] !== NULL || $study_info['thu'] !== NULL || $study_info['fri'] !== NULL || $study_info['sat'] !== NULL || $study_info['sun'] !== NULL){
            //使用create方法获取表单数据
                $data = $time->create();
                $data['student_number'] = $student_number;
                $data['id'] = $study_info['id'];
                $data['week'] = $week;
                //使用save方法进行数据更新
                if ($time->save($data) !== false) {
                $this->redirect("Time/view");
                //更新成功，则提示相关信息并跳转到当前学生所属班级的学生列表页
                return;
                }
            //更新失败，提示相关信息并跳转到上一页面
            $this->error('自习信息更新失败，请重新输入！');
            return;
            }else{
                $data = $time->create();
                $data['student_number'] = $student_number;
                $data['week'] = $week;
                if ($time->add($data) !== false) {
                $this->redirect("Time/view");
                return;
                }
            }
        }
            
            
        //根据查询条件获取学生信息
        $study_info = $time->where($where)->find();
        $this->assign('study_info', $study_info);
        $this->assign('week',$week);
        $this->display();
    }

    public function inputLate() {
        $student_number = session('student_number');
        //获取time模型类对象
        $time = M('time_day');
        $config = M('config');
        $where_week = array('config_name' => 'week');
        $week = $config->where($where_week)->getField('config_cont');
        $week = $week - 1;

        

        //组合查询条件
        $where = array(
            'student_number' => $student_number,
             'week' => $week,
        );
        $study_info = $time->where($where)->find();
        if($study_info['mon'] !== NULL || $study_info['tue'] !== NULL || $study_info['wed'] !== NULL || $study_info['thu'] !== NULL || $study_info['fri'] !== NULL || $study_info['sat'] !== NULL || $study_info['sun'] !== NULL){
                    $alert = new \Think\Alert();
                    $alert->alert("上周自习时间已经填写！","view.html");
            }
        //判断是否有POST数据，如果有则说明需要进行数据更新
        if (IS_POST) {
            $data = $time->create();
            // 首先判断自习时间是否录入
            if($data['Mon'] !== NULL || $data['Tue'] !== NULL || $data['Wed'] !== NULL || $data['Thu'] !== NULL || $data['Fri'] !== NULL || $data['Sat'] !== NULL || $data['Sun'] !== NULL){
            //使用create方法获取表单数据
                $data = $time->create();
                $data['student_number'] = $student_number;
                $data['week'] = $week;
                //使用save方法进行数据更新
                if ($time->add($data) !== false) {
                $this->redirect("Time/view");
                //更新成功，则提示相关信息并跳转到当前学生所属班级的学生列表页
                return;
                }
            //更新失败，提示相关信息并跳转到上一页面
            $this->error('自习信息更新失败，请重新输入！');
            return;
            }/*else{
                $alert = new \Think\Alert();
                $alert->alert("上周自习时间已经填写！","inputLate.html");
            }*/
        }
            
            
        //根据查询条件获取学生信息
        $study_info = $time->where($where)->find();
        $this->assign('study_info', $study_info);
        $this->assign('week',$week);
        $this->assign('data',$data);
        $this->display();
    }

    public function view(){
    	if ($student_number = session('student_number')) {
            $this->assign('student_number', $student_number);
        }else{
        	$this->error('e');
    	}
    	$model = M('time_day');
    	// 组合筛选
    	$where = array('student_number' => $student_number,);
        $pk = M('time_pk');
        $pk_info = $pk->where($where)->find();
        $all_mon = $model->where($where)->sum('mon');
        $all_tue = $model->where($where)->sum('tue');
        $all_wed = $model->where($where)->sum('wed');
        $all_thu = $model->where($where)->sum('thu');
        $all_fri = $model->where($where)->sum('fri');
        $all_sat = $model->where($where)->sum('sat');
        $all_sun = $model->where($where)->sum('sun');
        // 防止用户篡改数据，不适用表单更新
        $data['student_number'] = $student_number;
        $data['mon'] = $all_mon;
        $data['tue'] = $all_tue;
        $data['wed'] = $all_wed;
        $data['thu'] = $all_thu;
        $data['fri'] = $all_fri;
        $data['sat'] = $all_sat;
        $data['sun'] = $all_sun;
        $data['sum'] = $all_mon+$all_tue+$all_wed+$all_thu+$all_fri+$all_sat+$all_sun;
        if($pk_info[sum]!=NULL){
            // $pk_info = $pk->create($data);
            //使用save方法进行数据更新
            if ($pk_info = $pk->save($data) !== false) {
            }
        }else{
            $pk_info = $pk->create($data);
            if ($pk_info = $pk->add($data) !== false) {
            }
        }
    	$study_info = $model->where($where)->select();
        $this->assign('all_mon',$all_mon);
        $this->assign('all_tue',$all_tue);
        $this->assign('all_wed',$all_wed);
        $this->assign('all_thu',$all_thu);
        $this->assign('all_fri',$all_fri);
        $this->assign('all_sat',$all_sat);
        $this->assign('all_sun',$all_sun);
    	$this->assign('study_info',$study_info);
    	$this->display();
    }

    public function updatePK(){
        $model = M('time_day');
        $pk = M('time_pk');
        $where = array('student_number' => I('get.student_number'),);
        $pk_info = $pk->where($where)->find();
        if($pk_info[sum]!=NULL){
            // 验证用户是否篡改数据
            $data['student_number'] = I('get.student_number');
            $data['mon'] = $model->where($where)->sum('mon');
            $data['tue'] = $model->where($where)->sum('tue');
            $data['wed'] = $model->where($where)->sum('wed');
            $data['thu'] = $model->where($where)->sum('thu');
            $data['fri'] = $model->where($where)->sum('fri');
            $data['sat'] = $model->where($where)->sum('sat');
            $data['sun'] = $model->where($where)->sum('sun');
            if($pk_info = $pk->create($data)) {
                $this->error('请不要篡改您的数据');
            }
            //使用save方法进行数据更新
            if ($pk->save($data) !== false) {
                // $this->redirect("Time/view");
                return;
            }
            $this->error('自习信息更新失败，请重新输入！');
            return;
        }else{
            $pk_info = $pk->create($data);
            // 验证用户是否篡改数据
            $data['student_number'] = I('get.student_number');
            $data['mon'] = $model->where($where)->sum('mon');
            $data['tue'] = $model->where($where)->sum('tue');
            $data['wed'] = $model->where($where)->sum('wed');
            $data['thu'] = $model->where($where)->sum('thu');
            $data['fri'] = $model->where($where)->sum('fri');
            $data['sat'] = $model->where($where)->sum('sat');
            $data['sun'] = $model->where($where)->sum('sun');
            if ($pk->add($data) !== false) {
                // $this->redirect("Time/view");
                return;
            }
        }
    }

    public function rank() {
        $rank = M('time_pk');
        $student_number = session('student_number');
        $where = array('a.student_number' => $student_number,);
        $me = $rank ->alias('a')
        ->join('LEFT JOIN stu_user b ON a.student_number = b.student_number')
        ->where($where)
        ->find();
        $other = $rank ->alias('a')
        ->join('LEFT JOIN stu_user b ON a.student_number = b.student_number')
        ->order('a.sum desc')
        ->select();
        $sql="SELECT COUNT(*) AS tp_count FROM stu_time_pk a LEFT JOIN stu_user  b ON a.student_number =b.student_number WHERE ( a.sum>".$me['sum']." ) LIMIT 1";
        $num=$rank->query($sql);
        $this->assign('num',$num);
        $this->assign('me',$me);
        $this->assign('other',$other);
        $this->display();
    }
}