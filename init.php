<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 8:14
 * 项目初始化文件
 */
//1、设置编码
header("Content-type:text/html;charset-utf-8");

//2、定义目录常量
define('DIR_ROOT',str_replace('\\','/',__DIR__).'/');
//定义配置文件
define("DIR_CONFIG",DIR_ROOT.'config/');

//定义核心文件目录常量
define("DIR_CORE",DIR_ROOT.'core/');

//定义业务逻辑处理目录常量
define("DIR_MODEL",DIR_ROOT.'model/');

//定义模板文件目录常量
define("DIR_VIEW",DIR_ROOT.'view/');

//定义公开文件目录常量,这里用相对路劲
define("DIR_PUBLIC","./public");

//定义上传文件目录常量,这里用相对路劲
define("DIR_UPLOADS",DIR_ROOT."uploads/");
//封装跳转页面的函数
function jump($url,$time=2,$info=NULL){
    //直接跳转，不带提示信息
    if ($info==NULL){
        header("location:$url");
        die();
    }else{
        header("refresh:$time;$url");
        die("$info");
    }

}
function escapeString($str){
    return addslashes(strip_tags(trim($str)));
}
//封装是否登录的函数
function is_login(){
    @session_start();
    if (!isset($_COOKIE['user_id'])&&!isset($_SESSION['userinfo'])){
        //说明用户没有登录
        jump('./login.php',0,'请先登录');
    }
}

//封装登录注册状态的显示
function login_regin(){
    @session_start();
    if (isset($_COOKIE['user_id'])||isset ($_SESSION['userinfo'])){
        if(!isset ($_SESSION['userinfo'])){
           echo  "<img src='".$_SESSION['userinfo']['user_image']."' width='50px' height='50px'style=\"border-radius:50px;vertical-align:middle;margin-right: 15px;\"/>";
           echo "<a href=\"#\">".$_COOKIE['user_name']." 您好</a>";
        }else{
            echo  "<img src='".$_SESSION['userinfo']['user_image']."' width='50' height='50'style=\"border-radius:50px;vertical-align:middle;margin-right: 15px;\"/>";
           echo "<a href=\"#\">". $_SESSION['userinfo']['user_name']." 您好</a>";
        }
        echo "<a href=\"./logout.php\">&nbsp;&nbsp;&nbsp;退出</a>";
        echo "<a href=\"./upload_image.php\">&nbsp;&nbsp;&nbsp;上传头像</a>";
     }else{
        echo "<a href=\"../model/login.php\">登录</a>&nbsp:";
        echo " <a href=\"../model/register.php\">注册</a>";
    }
}
function login_regin_forindex(){
    @session_start();
    if (isset($_COOKIE['user_id'])||isset ($_SESSION['userinfo'])){
        if(!isset ($_SESSION['userinfo'])){
            echo "<a href=\"#\">"."<img src='".$_SESSION['userinfo']['user_image']."' width='50px' height='50px'style=\"border-radius:50px;vertical-align:middle;margin-right: 15px;\"/>". $_COOKIE['user_name']." 您好</a>";
        }else{
            echo "<a href=\"#\">"."<img src='".$_SESSION['userinfo']['user_image']."' width='50px' height='50px'style=\"border-radius:50px;vertical-align:middle;margin-right: 15px;\"/>". $_SESSION['userinfo']['user_name']." 您好</a>";
        }
        echo "<a href=\"model/logout.php\">&nbsp;&nbsp;&nbsp;退出</a>";
        echo "<a href=\"model/upload_image.php\">&nbsp;&nbsp;&nbsp;上传头像</a>";
    }else{
        echo "<a href=\"./model/login.php\">登录</a>&nbsp:";
        echo " <a href=\"./model/register.php\">注册</a>";
    }
}