<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 17:06
 */
include '../init.php';
session_start();
if (isset($_COOKIE['user_id'])||isset($_SESSION['userinfo'])){
    jump('./publish.php','0');
}
include DIR_VIEW.'login.html';