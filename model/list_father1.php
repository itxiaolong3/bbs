<?php
/**
 * 分页的简单版本，只有 首页，上一页，下一页，尾页
 * User: xiaolong
 * Date: 2017/9/30
 * Time: 10:51
 */
include '../init.php';
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysql=MySqlDBUtil::getInstance($arr);
//实现分页
//1、接收当前页码数，2、定义每页显示的记录数，3、查询总记录数，4、计算总页数，5、拼凑页码字符串
$pageNum=isset($_GET['num']) ? $_GET['num'] : 1;         //1、接收当前页码数
$eveyPage=5;                                               //2、定义每页显示的记录数
$sqlforlimit="select count(*) as sum from publish ";   //3、查询总记录数
$result=$mysql->my_query($sqlforlimit);
$row=mysqli_fetch_assoc($result);
$rowCount=$row['sum'];
$pages=ceil($rowCount / $eveyPage);               //4、计算总页数,ceil是向上取整
//5、拼凑页码字符串
//首页
$strPage='';
$strPage.="<a href='list_father.php?num=1'>首页</a>";
//上一页
$prePage=$pageNum== 1 ? 1 : $pageNum-1;
$strPage.="<a href='list_father.php?num=$prePage'>《上一页</a>";

//下一页
$nextPage=$pageNum== $pages ? $pages : $pageNum+1;
$strPage.="<a href='list_father.php?num=$nextPage'>下一页》</a>";

//尾页
$strPage.="<a href='list_father.php?num=$pages'>尾页</a>";

//起始页数=(当前页码数-1)*每页显示的页数，最终页数=总页数
$offset=($pageNum-1)*$eveyPage;
$sql="select *from publish order by pub_time desc limit $offset,$eveyPage";
$result=$mysql->my_query($sql);//得到资源结果集
//加载视图文件
include DIR_VIEW.'list_father.html';
