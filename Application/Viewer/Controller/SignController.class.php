<?php
namespace Viewer\Controller;
use Think\Controller;

class SignController extends Controller {

    public function index() {
        if(IS_POST) {
            if(!isset($_POST['name']) || !$_POST['name']) {
                return show(0,'姓名不能为空');
            }
            if(!isset($_POST['class']) || !$_POST['class']) {
                return show(0,'班级不能为空');
            }
            if(!isset($_POST['birthday']) || !$_POST['birthday']) {
                return show(0,'生日不能为空');
            }
            if(!isset($_POST['phone']) || !$_POST['phone']) {
                return show(0,'电话不能为空');
            }
            if(!isset($_POST['QQ']) || !$_POST['QQ']) {
                return show(0,'QQ不能为空');
            }
            if(!isset($_POST['aspiration_first']) || !$_POST['aspiration_first']) {
                return show(0,'第一志愿不能为空');
            }
            if(!isset($_POST['specialty']) || !$_POST['specialty']) {
                return show(0,'特长不能为空');
            }
            if(!isset($_POST['gain']) || !$_POST['gain']) {
                return show(0,'信息不全');
            }
            if(!isset($_POST['suggestion']) || !$_POST['suggestion']) {
                return show(0,'信息不全');
            }
            $menuId = M("Sign")->add($_POST);
            if($menuId) {
                if(!isset($_POST['pic']) || !$_POST['pic']) {
                    return show(1, '报名成功但照片上传失败（可能是浏览器不支持flash）');
                }
                return show(1,'报名成功');
            }
            return show(0,'报名失败');
        }
        $this->display();
        
    }
}