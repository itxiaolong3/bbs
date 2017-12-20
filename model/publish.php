<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 23:17
 */
include '../init.php';
/*获取当时的时间戳传给保存贴文的处理界面，充当前贴文标志*/
$gettime=time();
session_start();
if (!isset($_COOKIE['user_id'])&&!isset($_SESSION['userinfo'])){
    //说明用户没有登录
    jump('./login.php',2,'请先登录');
}
include DIR_VIEW.'publish.html';