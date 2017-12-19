<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/24
 * Time: 8:45
 */
//加载初始化文件
include '../init.php';
session_start();
//判断用户是否登录
if (!isset($_SESSION['userinfo'])){
    jump('./loginforhtml.php','1','请先登录');
}
//加载视图文件
include DIR_VIEW.'upload_image.html';