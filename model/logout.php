<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/15
 * Time: 19:26
 */
include '../init.php';
setcookie('user_id','',time()-1,'/');
setcookie('user_name','',time()-1,'/');
session_start();
$_SESSION=array();
jump('../index.php',1,'注销成功');
