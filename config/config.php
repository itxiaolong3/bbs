<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 12:00
 */
//加载封装好的数据库类
include '../core/MySqlDBUtil.php';

return array(
    'db'=>array(
        'host'=>'116.196.122.209',
        'port'=>'3306',
        'user'=>'root',
        'pass'=> '134136110cjl',
        'charset'=>'utf8',
        'dbname'=> 'bbs'
    ),
    //分页配置信息
    'page'=>array(
        'rowsPerpage'=>5,//每页显示的记录数
        'maxnum'=>6 //页面上能显示的最多有多少个页面
    )

);
/**
 * 在调用数据库配置是可以这样调用
 * $config=include DIR_CONFIG.'config.php';
 * $arr=$config['db'];
 */