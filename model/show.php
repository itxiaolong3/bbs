<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/30
 * Time: 22:38
 */
include '../init.php';
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];

$pub_id=$_GET['pub_id'];//楼主的id

$mysql=MySqlDBUtil::getInstance($arr);
//添加记录阅读次数的功能,如果是从回复页进来的就不用刷新，这里需要判断动作标志
if (!$_GET['dataAction']){
    $sql_pub_hits="update publish set pub_hits=pub_hits+1 where pub_id=$pub_id";
    $mysql->my_query($sql_pub_hits);
}

//得到一个数组
$sql="select * from publish LEFT JOIN user on pub_owner=user_name where pub_id =$pub_id";
$row=$mysql->fetchRow($sql);//得到楼主的信息
//实现分页开始
//1、接收当前页码数，2、定义每页显示的记录数，3、查询总记录数，4、计算总页数，5、拼凑页码字符串
$pageNum=isset($_GET['num']) ? $_GET['num'] : 1;         //1、接收当前页码数

$eveyPage=5;                                               //2、定义每页显示的记录数
$sqlforlimit="select count(*) from reply where rep_pub_id=$pub_id ";   //3、查询总记录数
/*$result=$mysql->my_query($sqlforlimit);
$replyRow=mysqli_fetch_assoc($result);
$rowCount=$replyRow['sum'];*/
$rowCount=$mysql->fetchColum($sqlforlimit);

$pages=ceil($rowCount / $eveyPage);               //4、计算总页数,ceil是向上取整
//5、拼凑页码字符串
//首页
$strPage='';
$strPage.="<a href='show.php?pub_id=$pub_id&num=1&dataAction=reply'>首页</a>";
//上一页
$prePage=$pageNum== 1 ? 1 : $pageNum-1;
if ($pageNum==1){
    $strPage.="<span style='background: #E0DEDE; border-color: #E0DEDE #D6D3D3 #CBC6C6;'>《上一页</span>";
}else{
    $strPage.="<a href='show.php?pub_id=$pub_id&num=$prePage&dataAction=reply'>《上一页</a>";
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
        $strPage.="<a href='show.php?pub_id=$pub_id&num=$i&dataAction=reply'><font color='red'>$i</font></a>";
    }else{
        $strPage.="<a href='show.php?pub_id=$pub_id&num=$i&dataAction=reply'>$i</a>";
    }

}
//下一页
$nextPage=$pageNum== $pages ? $pages : $pageNum+1;
if ($pageNum==$pages||$pages==0){
    $strPage.="<span style='background: #E0DEDE; border-color: #E0DEDE #D6D3D3 #CBC6C6;'>下一页》</span>";
}else{
    $strPage.="<a href='show.php?pub_id=$pub_id&num=$nextPage&dataAction=reply'>下一页》</a>";
}


//尾页
if ($pages==0){
    $strPage.="<span style='background: #E0DEDE; border-color: #E0DEDE #D6D3D3 #CBC6C6;'>尾页</span>";
}else{
    $strPage.="<a href='show.php?pub_id=$pub_id&num=$pages&dataAction=reply'>尾页</a>";
}

//总页数
$strPage.="总".$pages."页";
//实现分页结束
$offset=($pageNum-1)*$eveyPage;
$req_sql="select *from reply LEFT JOIN user on rep_user=user_name where rep_pub_id=$pub_id order by rep_time asc limit $offset,$eveyPage";
$req_result=$mysql->my_query($req_sql);

//开启session会话机制，判断是否登录
session_start();
//加载视图
include DIR_VIEW.'show.html';