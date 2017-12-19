<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 16:41
 */
include '../init.php';
/*session_start();
if (!isset($_SESSION['userinfo'])){
    //说明用户没有登录
    jump('./loginforhtml.php',0,'请先登录');
}*/
is_login();
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysql=MySqlDBUtil::getInstance($arr);

$pub_id=$_GET['pub_id'];//楼主的id
//获取楼主的信息
$sql="select *from publish where pub_id=$pub_id";
//得到一个数组
$row=$mysql->fetchRow($sql);

//开启session会话机制，判断是否登录
@session_start();
//加载视图
include DIR_VIEW.'reply.html';