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
$getpubid=$_GET['pub_id'];
$getidsql="select * from publish where pub_id='$getpubid'";
$getpubids=$mysql->fetchRow($getidsql);
$getpubimgid=$getpubids['pub_img_id'];
$sql = "DELETE  publish,reply  from  publish left join reply on publish.pub_id=reply.rep_pub_id where publish.pub_id='$getpubid'";
$rs=$mysql->affetchedRow($sql);//返回影响条数

$sql1 = "delete from pub_img where img_pub_id='$getpubimgid'";

$getre=$mysql->my_query($sql1);

if ($rs>=1){
    jump("./list_father.php",0);
}else{
    jump("./show.php?pub_id=$getpubid",2,"删除失败，2秒后返回");
}