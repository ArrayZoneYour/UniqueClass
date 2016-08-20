<?php
//声明该模型类的命名空间
namespace Student\Model;
//引入继承类的命名空间
use Think\Model\RelationModel;
class StudentModel extends RelationModel {
    //关联定义
    protected $_link = array(
    );
}