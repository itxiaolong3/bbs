<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 17:19
 */
include '../init.php';
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysql=MySqlDBUtil::getInstance($arr);

//获取传来的数据
$rep_pub_id=trim($_POST['rep_pub_id']);
$rep_content=escapeString($_POST['rep_content']);
//判断数据的合法性
if (empty($rep_content)){
    jump("./reply.html?pub_id=$rep_pub_id",2,'内容不可为空,3秒后自动回跳');
    die();
}
//$rep_user="小龙";
session_start();
if (isset($_SESSION['userinfo'])){
    $rep_user=$_SESSION['userinfo']['user_name'];//应该是其他人
}else{
    $rep_user=$_COOKIE['user_name'];
}
$rep_time=time();
$sql_content="insert into reply values(null,'$rep_pub_id','$rep_user','$rep_content','$rep_time', default, default)";
$result=$mysql->my_query($sql_content);

if ($result){
    //发表成功
    jump("./show.php?pub_id=$rep_pub_id&dataAction=reply");

}else{
    //发表失败
    jump("./reply.html?pub_id=$rep_pub_id",'1','发生未知错误，回复文章失败！');
}