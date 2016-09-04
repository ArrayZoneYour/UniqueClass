<?php
namespace Viewer\Controller;
use Think\Controller;

class InterviewController extends CommonController {

    public function index() {
        $id = I('get.id');
        $signers_first = M('sign')->where('aspiration_first='.$id)->select();
        $signers_second = M('sign')->where('aspiration_second='.$id)->select();
        $this->assign('signers_first', $signers_first);
        $this->assign('signers_second', $signers_second);
        $this->display();
    }
}