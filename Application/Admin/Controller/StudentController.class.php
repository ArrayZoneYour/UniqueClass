<?php
namespace Admin\Controller;
use Think\Controller;

class StudentController extends Controller {
	//检查用户是否登录
	public function __construct(){
		parent::__construct();
		if(!session('?admin_name')){
			$this->error('非法用户，请先登录！', U('Index/login'));
		}
	}

    //学生列表展示功能
    public function showList() {
        //实例化Student模型对象
        $model = M('student');
        //判断是否有参数class_id，如果有则使用I方法接收并赋值给$class，如果没有则使用默认值1
        $class_id = I('param.class_id', 1);
        //以数组的形式组合查询条件
        $where = array('class_id' => $class_id);
        //通过模型类获取指定班级ID的学生信息
        $student_info = $model->where($where)->select();
        //把班级ID分配到视图页面
        $this->assign('class_id', $class_id);
        //把学生信息分配到视图页面
        $this->assign('student_info', $student_info);
		//实例化Major模型对象，使用relation方法进行关联操作
		$major_info = D('major')->relation(true)->select();
        //把专业及班级信息分配到视图页面
        $this->assign('major_info', $major_info);
        //显示视图
        $this->display();
    }

	//添加学生
    public function add() {
        //获取学生所属班级id
        $class_id = I('get.class_id');
        //判断是否有POST表单提交
        if (IS_POST) {
            $data['class_id'] = $_POST['class_id'];
            $data['student_number'] = $_POST['student_number'];
            //实例化studnet模型类
            $model = M('student');
            $score = M('score');
            //获取要添加的学生信息
            $model->create();
            $score->data($data)->add();
            //执行模型类的add()方法，完成数据添加
            if ($model->add()) {
                //当添加成功后，提示信息并跳转到学生所属的学生列表页
                $this->success('学生添加成功，正在跳转，请稍候！', U("showList?class_id={$class_id}"));
                // echo "添加成功，您可以继续添加";
                return;
            }
            //添加失败，则返回到上一页面
            $this->error('学生添加失败，请重新输入！');
            return;
        }
        //实例化Major模型对象，使用relation方法进行关联操作
		$major_info = D('major')->relation(true)->select();
        //将专业班级信息分配到视图页面中
        $this->assign('major_info', $major_info);
        //将班级id分配到视图页面中
        $this->assign('class_id', $class_id);
        //显示视图文件
        $this->display();
    }

    public function update() {
        //获取student模型类对象
        $model = M('student');
        //组合查询条件
        $where = array(
            'student_id' => I('get.student_id'),
        );
        //判断是否有POST数据，如果有则说明需要进行数据更新
        if (IS_POST) {
            //使用create方法获取表单数据
            $student_info = $model->create();
            //使用save方法进行数据更新
            if ($model->save() !== false) {
                //更新成功，则提示相关信息并跳转到当前学生所属班级的学生列表页
                $this->success('学生信息更新成功，正在跳转，请稍候！', U("showList?class_id={$student_info['class_id']}"));
                //var_dump($_POST);
                return;
            }
            //更新失败，提示相关信息并跳转到上一页面
            $this->error('学生信息更新失败，请重新输入！');
            return;
        }
        //根据查询条件获取学生信息，由于是单条数据，因此使用find方法
        $student_info = $model->where($where)->find();
        //判断该学生是否存在，如果不存在则提示错误信息并返回上一页面
        if (!isset($student_info)) {
            $this->error('查询的学生信息不存在，请重新选择！');
            return;
        }
        //实例化Major模型对象，使用relation方法进行关联操作
		$major_info = D('major')->relation(true)->select();
        //将学生信息分配到视图页面
        $this->assign('student_info', $student_info);
        //将专业和班级信息分配到视图页面
        $this->assign('major_info', $major_info);
        //显示视图
        $this->display();
    }

	public function delete() {
		//获取student模型对象
		$model = M('student');
		//组合删除条件
		$where = array(
			'student_id' => I('get.student_id'),
		);
		//获取班级id，用于删除成功时跳转
		$class_id = I('class_id');
		//使用delete方法进行数据删除
		$res = $model->where($where)->delete();
		//判断删除是否成功，当返回值为false时，表示删除失败
		if ($res === false) {
			$this->error('删除失败，正在返回，请稍候！');
			return;
		//当返回值为0时，表示要删除的数据不存在
		}else if ($res === 0) {
			$this->error('要删除的学生信息不存在，请重新选择！');
			return;
		}
		//不为false 0 则表示删除成功，跳转到被删除的学生所属班级的学生列表页
		$this->success('删除成功，正在跳转，请稍候！', U("showList?class_id={$class_id}"));
		return;
	}

	public function addAll(){
		//判断是否有POST表单提交
		if (IS_POST) {
			//实例化student模型类
			$model = M('student');
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
				$this->success('学生添加成功，正在跳转，请稍候！', U("showList"));
				return;
			}
			//添加失败，则返回到上一页面
			$this->error('学生添加失败，请重新输入！');
			return;
		}
		//实例化Major模型对象，使用relation方法进行关联操作
		$major_info = D('major')->relation(true)->select();
		//将专业班级信息分配到视图页面中
		$this->assign('major_info', $major_info);
		//显示视图文件
		$this->display();
	}

    // public function class(){
    //     $this->display();
    // }


    public function import_excel() {
        import('Org.Util.PHPExcel');
        $file_name="D:/amp/test/TP_END/Public/Uploads/2016-05-08/572f010cacf94.xls";//这里是EXCEL文件路径
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file_name,$encode='utf-8');//把EXCEL转化为对象
        $sheet = $objPHPExcel->getSheet(0);//取得excel工作sheet;
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        for($i=2;$i<=$highestRow;$i++){
            $data['stu_name']=$objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            $data['stu_number']=$objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            $data['sex']=$objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            // $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            // $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            // $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            // $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            M('users')->add($data);//thinkphp的存储方法（具体你用什么框架或者原生代码，自己去insert，数据格式自己构造）
        }
    }

    public function upload(){
        $model = M('file');
        $files_info = $model->select();
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     31457280 ;// 设置附件上传大小
        $upload->exts      =     array('pdf','doc','docx','ppt');// 设置附件上传类型
        $upload->rootPath  =     'Public/Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        if (IS_POST) {
            # code...
            $info = $upload->upload();
            $alert = new \Think\Alert();
            if(!$info) {// 上传错误提示错误信息
            $alert->alert($upload->getError());
            }else{// 上传成功
            $data['fileName'] = $info['file']['name'];
            $data['owner'] = session('admin_name');
            $data['filePath'] = '/Uploads/'.$info['file']['savepath'].$info['file']['savename'];
            $data['createTime'] = NOW_TIME;
            $model->add($data);
            $alert->alert("上传成功","showFiles.html");
            }
        }
        $this->assign('files_info',$files_info);
        $this->display();
    }
	
	//空方法
	public function _empty(){
		$this->error('开发中');
	}
}

