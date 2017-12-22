<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 23:12
 */
//加载配置文件
include '../init.php';
//加载数据库配置文件
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
//得到数据库对象
$mysql=MySqlDBUtil::getInstance($arr);
$getrepid=$_GET['repid'];
$getpubid=$_GET['pub_id'];
$sql="delete from reply where rep_id='$getrepid'";
$rs=$mysql->affetchedRow($sql);

if ($rs>=1){
    jump("./show.php?pub_id=$getpubid",0);
}else{
    jump("./show.php?pub_id=$getpubid",2,"删除失败，2秒后返回");
}