<?php
// | Copyright (c) 2016- http://hustliyidong.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 李宜东 <1208397343@qq.com> <http://www.hustliyidong.cn>
// +----------------------------------------------------------------------
// | 友链功能类
// +----------------------------------------------------------------------
namespace Think;
/**
*@param $username 							用户名
*@param $password 							密码 
*/
class FriendLink
{
	function url($username,$password) {
		$url = "http://math.hust.edu.cn:8080/vote/view/user/stuLoginAction.jsp?username=".$username."&password=".$password;
		return $url;
	}
}