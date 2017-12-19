<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 17:21
 */
//加载配置文件
include '../init.php';
//加载数据库配置文件
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
//得到数据库对象
$mysql=MySqlDBUtil::getInstance($arr);

//获取用户名和密码
$user_name=trim($_POST['user_name']);
$user_name=mysqli_real_escape_string($mysql->link,$user_name);//防止Sql注入
$user_password=trim($_POST['user_password']);
$md5_password=md5($user_password);

//判断输入是否合法
if (trim(strlen($user_name)==0||strlen($user_password==0))){
    jump('./login.php',2,'用户名和密码不可为空');
}
if (strlen($user_name)<6||strlen($user_name)>16){
    jump('./login.php',2,'用户名个数在6到16位，请您重新输入');
}

if (strlen($user_password)<6||strlen($user_password)>16){
    jump('./login.php',2,'密码个数在6到16位，请您重新输入');
}

//判断用户名是否存在
$sql="select *from user where user_name ='$user_name'";
$row=$mysql->fetchRow($sql);
if ($mysql->affetchedRow($sql)==0){//返回最近执行的sql影响行
   jump('./login.php',2,'用户名不存在');
}

//判断用户名和密码是否正确
$sql="select *from user where user_name ='$user_name' and user_password='$md5_password'";
if ($mysql->affetchedRow($sql)>0){
    echo '登录成功';
    if (isset($_POST['rember'])){
        //如果勾选了3天免登录就保存cookie
        setcookie('user_id',$row['user_id'],time()+259200,'/');
        setcookie('user_name',$row['user_name'],time()+259200,'/');
    }
    //使用session保存用户信息，完善发帖和回复能正确显示对应的用户名
    session_start();
    $_SESSION['userinfo']=$row;
    jump('./publish.php',2);
}else{
    jump('./login.php',2,'密码或者用户名不正确');
}