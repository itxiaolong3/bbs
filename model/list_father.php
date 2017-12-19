<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/30
 * Time: 10:51
 */
include '../init.php';
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysql=MySqlDBUtil::getInstance($arr);
//实现分页开始
//1、接收当前页码数
$pageNum = isset($_GET['num']) ? $_GET['num'] : 1;
//3、查询总记录数
$sqlforlimit="select count(*) as sum from publish ";
$rowCount=$mysql->fetchColum($sqlforlimit);
/*$result=$mysql->my_query($sqlforlimit);
$row=mysqli_fetch_assoc($result);*/
/*$rowCount=$row['sum'];*/

$rowsPerpage=$sqlconfig['page']['rowsPerpage'];
$maxnum=$sqlconfig['page']['maxnum'];
$url='./list_father.php';

//加载分页函数
include  DIR_CORE.'pageUtil.php';
$strPage=page($pageNum,$rowCount,$maxnum,$rowsPerpage,$url);

//实现分页结束
//起始页数=(当前页码数-1)*每页显示的页数，最终页数=总页数
$offset=($pageNum-1)*$rowsPerpage;
$sql="select *from publish publish LEFT JOIN user on pub_owner=user_name order by pub_time desc limit $offset,$rowsPerpage";
$result=$mysql->my_query($sql);//得到资源结果集

session_start();
//加载视图文件
include DIR_VIEW.'list_father.html';
