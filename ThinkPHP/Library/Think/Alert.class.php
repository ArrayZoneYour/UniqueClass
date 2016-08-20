<?php
// | Copyright (c) 2016- http://hustliyidong.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 李宜东 <1208397343@qq.com> <http://www.hustliyidong.cn>
// +----------------------------------------------------------------------
// | 弹窗功能类
// +----------------------------------------------------------------------
namespace Think;
/**
*@param $str 						提示信息
*@param $url 						跳转链接
*/

class Alert
{

	function alert($str,$url)
	{
		$str_javascript = <<<start
		<script type='text/javascript'>
		alert("$str");
		window.location='$url'; 
		</script>
start;
		echo $str_javascript;
	}

	function confirm($str,$url1,$url2)
	{
		$str_javascript = <<<start
		<script type='text/javascript'>
		var r = confirm("$str");
		if (r==true)
		{
		  window.location='$url1';
		}
		else
		{
		  window.location='$url2';
		}
		</script>
start;
		echo $str_javascript;
	}
}
?>