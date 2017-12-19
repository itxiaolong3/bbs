<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 23:28
 */
include '../init.php';
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysql=MySqlDBUtil::getInstance($arr);
//获取传来的数据
$pub_title=escapeString($_POST['pub_title']);
$pub_content=escapeString($_POST['pub_content']);
$pub_module_id=escapeString($_POST['module_id']);
//var_dump("分类标志"+$_POST['module_id']) ;
//判断数据的合法性
if (empty($pub_module_id)){
    jump('./publish.php',2,'请选择帖子类型');
}else if (empty($pub_title)||empty($pub_content)){
    jump('./publish.php',2,'标题或内容不可为空');
}
//把所有发帖数据写入数据库中
//$pub_owner='游客';//应该是博主
session_start();
if (isset($_SESSION['userinfo'])){
    $pub_owner=$_SESSION['userinfo']['user_name'];//应该是博主
}else{
    $pub_owner='非法人员';
}
$pub_time=time();
$sql="insert into publish values(null,'$pub_title','$pub_content','$pub_owner','$pub_time',DEFAULT ,DEFAULT,'$pub_module_id' )";
$result=$mysql->my_query($sql);
if ($result){
    //发表成功
    jump('./list_father.php');

}else{
    //发表失败
    jump('./publish.php','2','发生未知错误，发表文章失败！');
}