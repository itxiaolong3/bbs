<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/30
 * Time: 10:51
 */
//include str_replace( '\\' , '/' , realpath(dirname(__FILE__).'/../')).'\init.php';
include '../init.php';

//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysqls=MySqlDBUtil::getInstance($arr);

//实现分页开始
//1、接收当前页码数，2、定义每页显示的记录数，3、查询总记录数，4、计算总页数，5、拼凑页码字符串
$pageNum=isset($_GET['num']) ? $_GET['num'] : 1;         //1、接收当前页码数
$eveyPage=5;                                               //2、定义每页显示的记录数
$getkeyword=escapeString($_GET['keyword']);
$sqlforlimit="select count(*) as sum from publish where pub_title LIKE '%{$getkeyword}%'";   //3、查询总记录数
/*$result=$mysql->my_query($sqlforlimit);
$row=mysqli_fetch_assoc($result);
$rowCount=$row['sum'];*/
$rowCount=$mysqls->fetchColum($sqlforlimit);

$pages=ceil($rowCount / $eveyPage);               //4、计算总页数,ceil是向上取整
//5、拼凑页码字符串
//首页
$strPage='';
$strPage.="<a href='list_father.php?num=1'>首页</a>";
//上一页
$prePage=$pageNum== 1 ? 1 : $pageNum-1;
if ($pageNum== 1){
    $strPage.="<span style='background: #E0DEDE; border-color: #E0DEDE #D6D3D3 #CBC6C6;'>《上一页</span>";
}else{
    $strPage.="<a href='list_father.php?num=$prePage'>《上一页</a>";
}

//第一个页码的startpage值
if ($pageNum<=3){
    $startPage= 1;
}else{
    $startPage=$pageNum - 2;
}
//规定startpage的最大值
if ($startPage>$pages-4){
    $startPage=$pages-4;
}
//防止startpage出现负值
if ($startPage<=1){
    $startPage=1;
}
//最后一个页码数
$endpage=$startPage+4;
if ($endpage>$pages){
    $endpage=$pages;
}
//拼凑出中间页码数
for ($i=$startPage;$i<=$endpage;$i++){
    if ($i==$pageNum){
        $strPage.="<a href='list_father.php?num=$i'><font color='red'>$i</font></a>";
    }else{
        $strPage.="<a href='list_father.php?num=$i'>$i</a>";
    }

}
//下一页
$nextPage=$pageNum== $pages ? $pages : $pageNum+1;
if($pageNum==$pages){
    $strPage.="<span style='background: #E0DEDE; border-color: #E0DEDE #D6D3D3 #CBC6C6;'>下一页》</span>";
}else{
    $strPage.="<a href='list_father.php?num=$nextPage'>下一页》</a>";
}


//尾页
$strPage.="<a href='list_father.php?num=$pages'>尾页</a>";
//总页数
$strPage.="总".$pages."页";
//实现分页结束
//起始页数=(当前页码数-1)*每页显示的页数，最终页数=总页数
$offset=($pageNum-1)*$eveyPage;
$sql="select *from publish publish LEFT JOIN user on pub_owner=user_name
 where pub_title LIKE '%{$getkeyword}%' order by pub_time desc limit $offset,$eveyPage";
$result=$mysqls->my_query($sql);//得到资源结果集

session_start();
//加载视图文件
include DIR_VIEW.'list_son.html';

