<?php
//声明该模型类的命名空间
namespace Admin\Model;
//引入继承类的命名空间
use Think\Model\RelationModel;
class StudentModel extends RelationModel {
    //关联定义
    protected $_link = array(
            //表示与class表进行关联，与class表的关系是一对多
            'Score' => self::HAS_ONE,
    );
}
