<?php
namespace Admin\Controller;
use Think\Controller;
//空控制器，当控制器不存在时自动调用
class EmptyController extends Controller {

	//空方法，当方法不存在时自动调用
	public function _empty(){
		$this->error('开发中');
	}

}