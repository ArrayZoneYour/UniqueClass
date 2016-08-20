<?php
namespace Admin\Controller;
use Think\Controller;

class ScoreController extends Controller {
	//检查用户是否登录
	public function __construct(){
		parent::__construct();
		if(!session('?admin_name')){
			$this->error('非法用户，请先登录！', U('Index/login'));
		}
	}

	//学生成绩展示功能
    public function showScore() {
        //实例化Score模型对象
        $model = M('score');
        $student = M('student');
        //判断是否有参数class_id，如果有则使用I方法接收并赋值给$class，如果没有则使用默认值1
        $class_id = I('param.class_id', 1);
        $term = I('param.term', 1);
        $subject_id = I('param.subject_id', 1);
        //以数组的形式组合查询条件
        $where = array('b.class_id' => $class_id,
            'c.subject_id' => $subject_id,
            'a.term' => $term);
        //通过模型类获取指定班级ID的学生信息
        // 获取排序方式
        if(IS_POST){
        	$order = $_POST[order_first].' '.$_POST[order_second];
        	//通过模型类获取指定班级ID的学生信息
        	$score_info = $model->alias('a')
            ->join('LEFT JOIN stu_student b ON a.student_number =b.student_number')
            ->join('LEFT JOIN stu_subject c ON a.subject_id =c.subject_id')
            ->where($where)->order($order)->select();
            }else{
            $score_info = $model->alias('a')
            ->join('LEFT JOIN stu_student b ON a.student_number =b.student_number')
            ->join('LEFT JOIN stu_subject c ON a.subject_id =c.subject_id')
            ->where($where)->order($order)->select();
        }
        //把班级ID分配到视图页面
        $this->assign('class_id', $class_id);
        $this->assign('subject_id', $subject_id);
        $this->assign('term', $term);
        //把成绩信息分配到视图页面
        $this->assign('score_info', $score_info);
		//实例化Major模型对象，使用relation方法进行关联操作
		$major_info = D('major')->relation(true)->select();
        $subject_info = D('subject')->relation(true)->select();
        //把专业及班级信息分配到视图页面
        $this->assign('major_info', $major_info);
        $this->assign('subject_info',$subject_info);
        //把排序信息分配到视图页面
        // $this->assign('order_second',$_POST[order_second]);
        //显示视图
        $this->display();
    }

    public function add() {
        //获取score模型类对象
        $model = M('score');
        $alert = new \Think\Alert();
        //判断是否有POST数据，如果有则说明需要进行数据更新
        if (IS_POST) {
            //使用create方法获取表单数据
            $model->create();
            //使用add方法进行数据更新
            if ($model->where($where)->add() !== false) {
                $alert->confirm("学生成绩添加成功！是否继续添加？","add.html","showScore.html");
            }
            $alert->alert("成绩更新失败！");
        }
        //实例化Major模型对象，使用relation方法进行关联操作
        $subject_info = D('subject')->relation(true)->select();
        //将学生信息分配到视图页面
        $this->assign('score_info', $score_info);
        //将专业和班级信息分配到视图页面
        $this->assign('subject_info', $subject_info);
        //显示视图
        $this->display();
    }

    public function update() {
        //获取score模型类对象
        $model = M('score');
        $id = I('param.id',1);
        //组合查询条件
        $where = array( "id" => $id );

        //根据查询条件获取学生信息，由于是单条数据，因此使用find方法
        $score_info = $model->where($where)->find();
        $alert = new \Think\Alert();
        //判断是否有POST数据，如果有则说明需要进行数据更新
        if (IS_POST) {
            //使用create方法获取表单数据
            $model->create();
            //使用add方法进行数据更新
            if ($model->where($where)->save() !== false) {
                $alert->confirm("学生成绩更新成功！是否继续添加？","../../update.html","../../showScore.html");
            }
            $alert->alert("成绩更新失败！");
        }
        //实例化Major模型对象，使用relation方法进行关联操作
		$major_info = D('major')->relation(true)->select();
        //将学生信息分配到视图页面
        $this->assign('score_info', $score_info);
        //将专业和班级信息分配到视图页面
        $this->assign('major_info', $major_info);
        //显示视图
        $this->display();
    }

    public function addAll() {
        $student = M('student');
        $class_id = I('param.class_id',1);
        $subject_id = I('param.subject_id',1);
        $where = array( "class_id" => $class_id );
        $score_info = $student->where($where)->select();
		//判断是否有POST表单提交
		if ($_POST["score"] !== NULL) {
			$model = M('score');
			//调用create()方法收集表单数据
			$data = $model->create();
			//由于表单存在多条学生数据，因此需要整理，定义$newDate数组变量，用来保存整理后的表单数据
			$new_data = array();
			//遍历$data数组
			foreach($data as $k => $v){
				//按照addAll()方法要求的格式，组合插入数据
				for($i=0,$len=count($v); $i<$len; $i++){
					isset($v[$i]) && $new_data[$i][$k] = $v[$i];
				}
			}
			if ($model->addAll($new_data)) {
				//当添加成功后，提示信息并跳转到学生所属的学生列表页
				$this->success('学生成绩更新成功，正在跳转，请稍候！', U("showScore"));
				return;
			}
			//添加失败，则返回到上一页面
			$this->error('学生成绩更新失败，可能已经录入部分学生成绩，请处理后重新输入！');
			return;
		}
		//实例化Major模型对象，使用relation方法进行关联操作
		$major_info = D('major')->relation(true)->select();
        $subject_info = D('subject')->relation(true)->select();
		//将成绩信息分配到视图页面中
		$this->assign('score_info', $score_info);
        //将专业和班级信息分配到视图页面
        $this->assign('major_info', $major_info);
        $this->assign('subject_info', $subject_info);
        $this->assign('subject_id', $subject_id);
        $this->assign('class_id', $class_id);
		//显示视图文件
		$this->display();
	}

	public function delete() {
		//获取score模型对象
		$model = M('score');
		//组合删除条件
		$where = array(
			'id' => I('get.id'),
		);
		//获取班级id，用于删除成功时跳转
		$class_id = I('class_id');
		//使用delete方法进行数据删除
		$res = $model->where($where)->delete();
		//判断删除是否成功，当返回值为false时，表示删除失败
		if ($res === false) {
			$this->error('删除失败，正在返回，请稍候！');
			return;
		//当返回.值为0时，表示要删除的数据不存在
		} elseif ($res === 0) {
			$this->error('要删除的学生信息不存在，请重新选择！');
			return;
		}
		//不为false 0 则表示删除成功，跳转到被删除的学生所属班级的学生列表页
		$this->success('删除成功，正在跳转，请稍候！', U("showScore?class_id={$class_id}"));
		return;
	}
}