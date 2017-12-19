<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 21:46
 * 5.29
 */
include '../init.php';
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysql=MySqlDBUtil::getInstance($arr);

//1,接受数据
$rep_content=escapeString($_POST['rep_content']);//回复的内容
$rep_pub_id=$pub_id=$_GET['pub_id'];//楼主的id
$rep_quote_id=$rep_id=$_GET['rep_id'];//被引用的回帖的id
$rep_num=$num=$_GET['num'];//被引用的回帖的楼层号

//2、判断数据的合法性
if (empty($rep_content)){
    jump("./quote.php?num=$num&pub_id=$pub_id&rep_id=$rep_id",1,'内容不可为空');
}

//3、数据入库
session_start();
//提前回复者的名字
$rep_user=$_SESSION['userinfo']['user_name'];
$rep_time=time();

//组装sql语句进行插入
$sql="insert into reply values(null,$rep_pub_id,'$rep_user','$rep_content',$rep_time,$rep_num,$rep_quote_id)";
$result=$mysql->my_query($sql);
if ($result){
    //插入成功
    jump("show.php?pub_id=$pub_id&dataAction=reply",'1');
}else{
    //插入失败
    jump("./quote.php?num=$num&pub_id=$pub_id&rep_id=$rep_id",1,'发送未知');
}