<?php
//设置页面内容是html编码格式是utf-8
header("Content-Type: text/plain;charset=utf-8"); 

//得到连接
$conn=mysql_connect("localhost","liyidong","liyidong");
if(!conn){
    die("connect fail".mysql_errno());
}

//设置访问数据库的编码
mysql_query("set names utf8",$conn) or die (mysql_errno());

//选择数据库
mysql_select_db("itcast",$conn) or die (mysql_errno());

$sql="select 信息技术导论 from student_score where student_number=".$_POST['student_number'];

$res=mysql_query($sql,$conn);

if($res){
	echo "该用户未录入成绩";
}