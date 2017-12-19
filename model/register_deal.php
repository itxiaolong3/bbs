<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 9:58
 */
include '../init.php';
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysql=MySqlDBUtil::getInstance($arr);
//$link=mysqli_connect('localhost','root','123');
//mysqli_query($link,'set names utf8');
//mysqli_query($link,'use bbs');

//接受数据,加上trim可以去除空格
$user_name=trim($_POST['user_name']);
$user_name=mysqli_real_escape_string($mysql->link,$user_name);//防止Sql注入
$user_password1=trim($_POST['user_password1']);
$user_password2=trim($_POST['user_password2']);
$vcode=trim($_POST['vcode']);//接受用户输入的验证码

session_start();
if (strtolower($vcode)!=strtolower($_SESSION['captcha'])){
    //验证失败
    jump('./register.php',1,'验证码不正确');//刷新且2秒后跳转
}

//判断数据的合法性，其实这个操作在html注册表中都可以完成的
if (empty($user_name)||empty($user_password1)||empty($user_password2)){
    jump('./register.php',2,'用户名或者密码不可为空，请您重新输入');//刷新且2秒后跳转
}
//判断用户名的合法性
if (strlen($user_name)<6||strlen($user_name)>16){
    jump('./register.php',2,'用户名个数在6到16位，请您重新输入');
}
//判断用户名的合法性
if (strlen($user_password1)<6||strlen($user_password1)>16){
    jump('./register.php',2,'密码个数在6到16位，请您重新输入');
}
//判断前后两次的密码是否一致
if ($user_password1!==$user_password2){
    jump('./register.php',2,'前后密码不一致，请您重新输入');
}
//判断用户名是否存在
$sql="select *from user where user_name='$user_name'";
$mysql->my_query($sql);
//mysqli_query($link,$sql);
if ($mysql->fetchRow($sql)>0){
    jump('./register.php',2,'用户名已经存在，请您重新输入');
}

//保存注册信息
$md5_password=md5($user_password1);
$sql="insert into user values(null,'$user_name','$md5_password',DEFAULT ,DEFAULT )";

/*admin_id`
  `admin_user_id`
   , admin_name
  `admin_sex
  `admin_email
  `admin_school`
  `admin_phone`
  `admin_motto` varchar(255) DEFAULT NULL,
  `admin_character` varchar(255) DEFAULT NULL,
  `admin_hobby` varchar(255) DEFAULT NULL,
  `admin_major` varchar(255) DEFAULT NULL,
  `admin_selfpice*/
$result=$mysql->my_query($sql);
//得到插入的数据自增的id
$get_last_id=$mysql->getLastId();
$sql2="insert into admin_user_info values(null,$get_last_id,DEFAULT,DEFAULT ,DEFAULT,DEFAULT,DEFAULT ,DEFAULT,DEFAULT,DEFAULT ,DEFAULT ,DEFAULT )";
$result2=$mysql->my_query($sql2);

if ($result&&$result2){
    header("refresh:2;url=./login.php");
    die("恭喜您，注册成功！");
}else{
    header("refresh:2;url=./register.php");
    echo "错误编号：",mysqli_errno($link)."<br/>";
    echo "错误信息：",mysqli_error($link)."<br/>";
    die("发生未知错误，注册失败");
}