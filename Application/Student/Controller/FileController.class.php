<?php
namespace Student\Controller;
use Think\Controller;

class FileController extends Controller {
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

	public function showFiles(){
		$model = M('file');
        $files_info = $model->select();
        $this->assign('files_info',$files_info);
        $this->display();
	}

	public function upload(){
		$model = M('file');
        $files_info = $model->select();
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('pdf','doc','docx');// 设置附件上传类型
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
            $data['owner'] = session('student_name');
            $data['filePath'] = '/Uploads/'.$info['file']['savepath'].$info['file']['savename'];
            $data['createTime'] = NOW_TIME;
            $model->add($data);
            $alert->alert("上传成功","showFiles.html");
            }
        }
        $this->assign('files_info',$files_info);
        $this->display();
	}
}