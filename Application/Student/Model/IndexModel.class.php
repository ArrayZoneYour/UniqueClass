<?php
//声明该模型类的命名空间
namespace Student\Model;
//引入继承类的命名空间
use Think\Model\RelationModel;
class IndexModel extends RelationModel {
    //关联定义
    protected $_link = array(
    );

    private $_db = '';

    public function __construct(){
    	$this->_db = M('user');
    }

    public function getDataByStudentNumber($student_number){
    	$where = array('student_number' => $student_number,);
    	$data = $this->_db->where($where)->find();
    	return $data;
    }

    public function updateLoginData($data,$student_number){
    	$where = array('student_number' => $student_number,);
    	$update = $this->_db->where($where)->save($data);
    	return $update;
    }
}