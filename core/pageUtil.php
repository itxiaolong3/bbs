<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 19:15
 * 封装函数
 */
/**
 * @param $pageNum 当前页码数
 * @param $rowCount 总记录数
 * @param $maxnum 能显示在页面上的最大页码数就是在首页和尾页之间的页码
 * @param $rowsPerPage 每页显示的记录数
 * @param $url 固定不变的url
 * @return string $strPage 生成的页码字符串
 */
function page($pageNum,$rowCount, $maxnum, $rowsPerPage, $url)
{
   /* //1、接收当前页码数
    $pageNum = isset($_GET['num']) ? $_GET['num'] : 1;*/
    //2、计算总页数,ceil是向上取整
    $pages = ceil($rowCount / $rowsPerPage);
    //3、拼凑页码字符串
    //首页
    $strPage = '';
    $strPage .= "<a href='{$url}?num=1'>首页</a>";
    //上一页
    $prePage = $pageNum == 1 ? 1 : $pageNum - 1;
    if ($pageNum == 1) {
        $strPage .= "<span style='background: #E0DEDE; border-color: #E0DEDE #D6D3D3 #CBC6C6;'>《上一页</span>";
    } else {
        $strPage .= "<a href='{$url}?num=$prePage'>《上一页</a>";
    }

    //第一个页码的startpage值
    if ($pageNum <= 3) {
        $startPage = 1;
    } else {
        $startPage = $pageNum - 2;
    }
    //规定startpage的最大值
    if ($startPage > $pages - ($maxnum - 1)) {
        $startPage = $pages - ($maxnum - 1);
    }
    //防止startpage出现负值
    if ($startPage <= 1) {
        $startPage = 1;
    }
    //最后一个页码数
    $endpage = $startPage + 4;
    if ($endpage > $pages) {
        $endpage = $pages;
    }
    //拼凑出中间页码数
    for ($i = $startPage; $i <= $endpage; $i++) {
        if ($i == $pageNum) {
            $strPage .= "<a href='{$url}?num=$i'><font color='red'>$i</font></a>";
        } else {
            $strPage .= "<a href='{$url}?num=$i'>$i</a>";
        }

    }
    //下一页
    $nextPage=$pageNum== $pages ? $pages : $pageNum+1;
    if($pageNum==$pages){
        $strPage.="<span style='background: #E0DEDE; border-color: #E0DEDE #D6D3D3 #CBC6C6;'>下一页》</span>";
    }else{
        $strPage.="<a href='{$url}?num=$nextPage'>下一页》</a>";
    }

    //尾页
    $strPage.="<a href='{$url}?num=$pages'>尾页</a>";
    //总页数
    $strPage.="总".$pages."页";
    //返回页码字符串
    return $strPage;
}