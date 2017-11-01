<?php
// login.php两个作用引入页面，处理数据
/*GET  打开页面  请求方式是GET时直接打开页面
  POST 请求方式是POST时请求处理数据
  REQUEST_METHOD  请求方式
*/
// header 保证不会乱码
header('Content-type:text/html;charset=utf8');
/*用server里面request_method这个方法判断是post 和get方式接收*/
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // 显示页面
    include '../templete/admin/login.html';
}else{
    // 验证数据 用户名和密码
    /*var_dump($_POST); 发送的数据打印到了页面中*/
    // 获取前台发出的数据
    $user = $_POST['user'];
    $pass = $_POST['pass'];

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
    $sql = "select * from admin";
    // 在php中双引号可识别变量。可以换行，换行不代表一句的结束，分号才代表一行的结束
    /*$sql = "select * from admin where uname='$user'";*/
    // 如果出错在出错的地方加一个exit;来阻止下面的代码的执行，在它的前面把sql语句输出来，来检查错误
    /*echo $sql;
    exit;*/
    // 也可这样写
    /*$sql = "select * from admin where uname='{$user}'";*/
    $result = $mysql->query($sql);
    $arr = $result->fetch_all(MYSQL_ASSOC);
   /* echo用来输出字符串，不能输出数组 */
    /*print_r()用来输出数组*/
    /*var_dump() 网页面中打印*/
    for($i=0;$i<count($arr);$i++){
        // uname、upass访问数组的某一个索引或属性，所以不加$
        if($arr[$i]['uname'] == $user && $arr[$i]['upass'] == $pass){
            /*echo 'success';*/
            // 此处是要改变路径   引入用include
            header('Location:main.php');
            exit;
        }
    }
    $message = '登录失败，请核对后再登录';
    $url = 'login.php';
    // 引进message而不是修改
    include 'message.html';
    /*echo 'fail';*/
}
?>