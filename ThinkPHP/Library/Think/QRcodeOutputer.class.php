<?php
// | Copyright (c) 2016- http://hustliyidong.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 李宜东 <1208397343@qq.com> <http://www.hustliyidong.cn>
// +----------------------------------------------------------------------
// | 友链功能类
// +----------------------------------------------------------------------
namespace Think;

/**
* @param $url 							目标链接
* @param $size 							二维码大小
*/
class QRcodeOutputer
{
	function __construct(){
		include_once('phpqrcode/qrlib.php');
	}

	function output($url,$size)
	{
		$temp='./Public/QRcode/';
		// 定义图片名称
		$filename=time().".png";
		$viewname="/TP_END/Public/QRcode/".$filename;
		// 生成完整目录
		$filename=$temp.$filename;
		// 使用QRCode创建二维码
		\QRcode::png($url,$filename,"L",$size);
		// 输出图片
		return "<img src='".$viewname."'>";
	}
}
?>