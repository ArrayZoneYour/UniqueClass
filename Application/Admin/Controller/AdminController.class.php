<?php
namespace Admin\Controller;
use Think\Controller;

class AdminController extends Controller{
	//检查登录
	public function __construct(){
		parent::__construct();
		if(!session('?admin_name')){
			$this->error('非法用户，请先登录！', U('Index/login'));
		}
	}

    
	//管理员列表展示功能
	public function showAdmin(){
		//实例化admin模型对象
		$model = M('admin');
		//判断参数admin_level,如果有使用则使用I方法接受并赋值给$admin_level,否则返回默认值1
		$admin_level = I('param.admin_level',1);
		//以数组的形式组合查询条件
		$where = array('admin_level' => $admin_level);
		//通过模型类获取指定admin_level的管理员的信息
		$admin_info = $model->where($where)->select();
		//把admin_level分配到视图页面
		$this->assign('admin_level',$admin_level);
		//把管理员信息分配到指定页面
		$this->assign('admin_info',$admin_info);
		//显示视图
		$this->display();
	}

	//管理员密码修改功能
	public function update(){
        $model=M('admin');
        $admin_info['apwd'] = md5($admin_info['apwd']);
        $subject_info = D('subject')->select();
        $alert = new \Think\Alert();
        //以数组的形式查询到需要修改的管理员信息
        $where = array(
            'aid' => I('get.aid'),
        );
        $_POST["apwd"] = md5($_POST["apwd"]);
        //判断是否有POST数据，如果有则说明需要进行数据更新
        if (IS_POST) {
            //使用create方法获取表单数据
            $admin_info = $model->create();
            //使用save方法进行数据更新
            if ($model->save() !== false) {
                //更新成功，则提示相关信息并跳转到当前管理员所属班级的学生列表页
                $alert->alert('管理员信息更新成功', '../../showAdmin');
                // var_dump($_POST);
                return;
            }
            //更新失败，提示相关信息并跳转到上一页面
                $alert->alert('管理员信息更新失败，请重新输入！','../../showAdmin');
            return;
        }
        //根据查询条件获取管理员信息，由于是单条数据，因此使用find方法
        $admin_info = $model->where($where)->find();
        //将管理员信息分配到视图页面
        $this->assign('admin_info', $admin_info);
        $this->assign('subject_info', $subject_info);
        //显示视图
        $this->display();
    }

    // 添加管理员方法
    function add(){
        // 实例化stu_admin表
        $admin = M('admin');
        $subject_info = D('subject')->select();
        // POST发送同时加密密码
        $_POST["apwd"] = md5($_POST["apwd"]);
        if (IS_POST) {
            // 读取表单
            $admin_info = $admin->create();
            // 实例化弹窗类
            $alert = new \Think\Alert();
            if ($admin->add() !== false) {
                $alert->confirm("管理员创建成功！是否继续添加？","add.html","showAdmin.html");
            }else{
                $alert->alert("管理员创建失败！");
                $this->redirect('Admin/add');
            }
        }
        $this->assign('subject_info', $subject_info);
        $this->display();
    }
}