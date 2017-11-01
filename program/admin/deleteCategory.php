<?php
include '../libs/db.php';
$cid = $_GET['cid'];
// 看是否有子栏目  有子栏目就不允许删除，没有子栏目才允许删除
$sql = "select * from category where pid={$cid}";
if($mysql->query($sql)->fetch_assoc()){
    $message = '存在子栏目';
    $url = 'showCategory.php';
    include 'message.html';
    exit();

}
// 没有子栏目直接进行删除
$sql = "delete from category where cid={$cid}";
$mysql->query($sql);
if($mysql->affected_rows){
    $message = '删除成功';
    $url = 'showCategory.php';
    include 'message.html';
}