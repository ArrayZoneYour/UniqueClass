<?php

/**
 * 公用方法
 */

function show($status, $message, $data=array()) {
	$result = array(
		'status' => $status,
		'message' => $message,
		'data' => $data,
	);

	exit(json_encode($result));
}

function getMd5Password($password) {
	// return md5($password , C('MD5_PRE'));
	return md5($password);
}

function sex($id) {
	return ($id==1)?"男":"女";
}

function aspirstion_oeistudy($id) {
	$Arr = array("","学习部","学业辅导部","办公室","文宣部");
	return $Arr[$id];
}