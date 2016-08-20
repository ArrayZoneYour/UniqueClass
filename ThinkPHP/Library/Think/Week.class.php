<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016- http://hustliyidong.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 李宜东 <1208397343@qq.com> <http://www.hustliyidong.cn>
// +----------------------------------------------------------------------
namespace Think;

class Week {
	public $firstWeek;
	public $lastWeek;
	public $selectWeek;
	// 周次显示
	public function show($firstWeek,$lastWeek,$selectWeek) {
		$str = "<select name=\"week\">";
		$str .= "<option value=".$selectWeek.">第".$selectWeek."周</option>";
		for ($x=$firstWeek; $x<=$lastWeek; $x++) {
			if ( $x != $selectWeek)
	  		$str .= "<option value=".$x.">第".$x."周</option>";
		} 
		$str .= "</select>";
		return $str;
	}
}