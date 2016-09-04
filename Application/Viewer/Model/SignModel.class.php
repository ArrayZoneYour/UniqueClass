<?php
namespace Viewer\Model;
use Think\Model;

class SignModel extends Model {

    public function checkSign() {
        $data = I('post.');
        $map['phone'] = $data['phone'];
        $map['name'] = $data['name'];
        if($map){
            $res = $this->where($map)->find();
            return $res;
        }
        else{
            return show(0, '查询信息不全！');
        }
    }
}