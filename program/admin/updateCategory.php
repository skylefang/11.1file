<?php
    // 防止乱码
    header('Content-type:text/html;charset=utf8');
    // 打开页面
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        include '../libs/db.php';
        include '../libs/function.php';
        // 拿回栏目数，修改的下拉框中栏目
        $obj = new unit();
        $str = $obj->cateTree(0,$mysql,'category','0',
            $_GET['cid']);

        // 进行封装
        /*$sql = "select cname from category where cid='{$_GET['cid']}'";
        $data = $mysql->query($sql)->fetch_assoc();
        $cname = $data['cname'];*/

        // 拿到当前修改栏目的id和cname
        $cid = $_GET['cid'];
        $cname =  $obj->selectOne($mysql,'category',$_GET['cid'],
            'cname');
        include '../templete/admin/updateCategory.html';
    }else{
        // 处理提交回来的数据
        include '../libs/db.php';
        $pid = $_POST['pid'];
        $cname = $_POST['cname'];
        $cid = $_POST['cid'];
        $sql = "update category set cname='{$cname}',pid='{$pid}' where 
cid='{$cid}'";
        // 将修改的信息提交
        $mysql->query($sql);
        if($mysql->affected_rows){
            // 此处的修改为更新  更新栏目信息
            $message = '修改成功';
            $url = 'showCategory.php';
            include 'message.html';
        }else{
            $message = '修改失败';
            $url = 'showCategory.php';
        }
        include 'message.html';
    }