<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 23:15
 */
include '../init.php';
is_login();
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysql=MySqlDBUtil::getInstance($arr);

//接受数据
$num = $_GET['num'];//楼层数
$pub_id = $_GET['pub_id'];//楼主的id
$rep_id = $_GET['rep_id'];//被引用的帖子的id

// 5, 提取楼主的信息
$sql = "select * from publish where pub_id=$pub_id";
$row = $mysql->fetchRow($sql);

// 6, 提取被引用的帖子的信息
$sql = "select * from reply where rep_id=$rep_id";
$rep_row = $mysql->fetchRow($sql);// 被引用的帖子的数组信息

//加载视图文件
include DIR_VIEW.'quote.html';