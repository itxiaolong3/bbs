<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/24
 * Time: 9:30
 */
//加载初始化文件
include '../init.php';
//链接数据库
$sqlconfig=include DIR_CONFIG.'config.php';
$arr=$sqlconfig['db'];
$mysql=MySqlDBUtil::getInstance($arr);
//加载上传文件验证文件
include DIR_CORE.'upload_publish.php';
$getpubtime=$_GET['getpubtime'];
//声明上传的参数
$file=$_FILES['file'];
$allow=array('image/jpg','image/jpeg','image/png','image/gif');
$path=DIR_UPLOADS."image_publish";

//调用上传函数
$result=upload($file,$allow,$error,$path);
if ($result){
    //上传成功
    session_start();
    
    //更新数据库中的用户表，添加图片路径数据到数据库
    $sql="insert into pub_img values(null,'$result',default,'$getpubtime' ,DEFAULT )";
    $res=$mysql->my_query($sql);
    if ($res){
        //图片入库成功
        //入库后把原来的图像删除
            //@unlink($path.'/'.$get_image_name);
        echo '{
				  "code": 0 
				  ,"msg": "" 
				  ,"data": {
				    "src":"'. "{$result}".'"
				    ,"title": "插入的图片"
				  }
			}';
        //jump('./list_father.php',1,"上传成功");
    }else{
        //入库失败
        jump('./upload_image.php',1,'发送未知错误，头像上传失败。');
    }
}else{
    //上传失败
    jump('./upload_image.php',1,'头像上传失败。');
}

