<?php
//声明该模型类的命名空间
namespace Admin\Model;
//引入继承类的命名空间
use Think\Model\RelationModel;
class SubjectModel extends RelationModel{
	//关联定义
    protected $_link = array(
            //表示与class表进行关联，与class表的关系是多对多
            'Class' => self::MANY_TO_MANY,
    );

    public function getAll() {
        return $this->select();
    }

    public function addOne($data) {
        if($data){
            return $this->add($data);
        }
        else{
            return false;
        }
    }

    public function updateOne($data) {
        if($data) {
            return $this->save($data);
        }
        else{
            return false;
        }
    }
}