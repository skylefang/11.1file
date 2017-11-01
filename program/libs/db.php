<?php
$mysql = new mysqli('localhost','root','',
    'program',3306);
// 设置查询字符集
$mysql -> query('set names utf8');
// 判断是否连接成功
if($mysql->errno){
    // $mysql->connect_errno 表示连接失败后查询失败原因的地方
    echo '数据库连接失败，失败原因'.$mysql->connect_errno;
    exit;
}