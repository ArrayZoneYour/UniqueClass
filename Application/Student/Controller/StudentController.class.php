<?php
namespace Student\Controller;
use Think\Controller;
class StudentController extends Controller{
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
            $student_name = session('student_name');
            $last_login = session('last_login');
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

    public function userInfo() {
        # 用户头像地址
        $pic = "default/03.jpg";
        # 将用户头像地址分配到页面
        $this->assign("pic",$pic);
        # 显示视图
        $this->display();
    }

    // 个人信息修改
    public function updateInfo(){
        $student_number = session('student_number');
        $student_name = session('student_name');
        $model = M('user');
        $user_info['password'] = md5($admin_info['password']);
        //判断是否有POST数据，如果有则说明需要进行数据更新
        if (IS_POST) {
            //使用create方法获取表单数据
            $user_info = $model->create();
            $user_info = $model->student_number = $student_number;
            $user_info = $model->student_name = $student_name;
            //使用save方法进行数据更新
            if ($model->save() !== false) {
                //更新成功，则提示相关信息并跳转到学生信息页
                $this->redirect("Student/userInfo");
                return;
            }
            //更新失败，提示相关信息并跳转到上一页面
            $this->error('您的信息更新失败，请重新输入！');
            return;
        }
        //显示视图
        $this->display();
    }

    public function updatePassword(){
        $student_number = session('student_number');
        $student_name = session('student_name');
        $model = M('user');
        $user_info['password'] = md5($admin_info['password']);
        //判断是否有POST数据，如果有则说明需要进行数据更新
        if (IS_POST) {
            //使用create方法获取表单数据
            $_POST['password'] = md5($_POST['password']);
            $user_info = $model->create();
            $user_info = $model->student_number = $student_number;
            $user_info = $model->student_name = $student_name;
            //使用save方法进行数据更新
            if ($model->save() !== false) {
                //更新成功，则提示相关信息并跳转到学生信息页
                $this->success('您的密码更新成功，请重新登录，正在跳转，请稍候！', U("Index/login"));
                return;
            }
            //更新失败，提示相关信息并跳转到上一页面
            $this->error('您的信息更新失败，请重新输入！');
            return;
        }
        //显示视图
        $this->display();
    }

    public function upload() {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     'Public/Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        if (IS_POST) {
            # code...
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
            }else{// 上传成功
            $this->success('上传成功！');
            }
        }
        $this->display();
    }

    public function import() {
        vendor("PHPExcel.PHPExcel");//这里是导入PHPexcl
        $file_name=excel文件路径;//这里是EXCEL文件路径
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file_name,$encode='utf-8');//把EXCEL转化为对象
        $sheet = $objPHPExcel->getSheet(0);//取得excel工作sheet;
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        for($i=2;$i<=$highestRow;$i++){
            $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            $data['数据库字段名']=$objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();//ABCD.....就是excel对应的ABCDEF......
            M('Users')->add($data);//thinkphp的存储方法（具体你用什么框架或者原生代码，自己去insert，数据格式自己构造）
        }
    }
}