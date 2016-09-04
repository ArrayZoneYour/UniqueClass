<?php
namespace Common\Model;
use Think\Model;
use Think\Exception;
/**
 * 用户组操作
 * @author  Li Yidong
 */
class AdminModel extends Model {

	// private $_db = '';

	// public function __construct() {
	// 	$conn = $this->_db = M('admin');
	// }

	public function getAdminByUsername($username = '') {
		$res = $this->where('aname="'.$username.'"')->find();
		return $res;
	}

}