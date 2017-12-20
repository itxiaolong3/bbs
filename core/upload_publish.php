<?php
/**
 * Created by PhpStorm.
 * User: xiaolong
 * Date: 2017/10/14
 * Time: 11:07
 * 封装文件上传函数
 */
/**
 * @param array $file  上传文件的信息(一维数组，一共有5个元素)
 * @param array $allow 文件上传的类型
 * @param string $error 引用传递，用来记录错误信息
 * @param string $path 文件上传的目录
 * @param int $maxsize 允许上传的文件大小
 * @return bool 返回是否上传成功
 */
function upload($file,$allow,& $error,$path,$maxsize=1048576){
    //验证文件
    switch ($file['error']){
        case 1:$error='上传失败！超出了文件限制的大小！';
                return false;
        case 2:$error='上传失败！文件超出浏览器的文件大小限制！';
                return false;
        case 3:$error='上传失败！文件不完整';
                return false;
        case 4:$error='上传失败，请选择要上传的文件';
                return false;
        case 6:
        case 7:$error='不好意思，服务器繁忙，请稍后再试！';
                return false;
    }
    //再次验证业务流程中的文件大小
    if ($file['size']>$maxsize){
        //超出了自己业务逻辑所规定的大小
        $error='上传失败，超出了规定文件限制的大小！';
        return false;
    }
    //验证文件后缀名
    if (!in_array($file['type'],$allow)){
        $error='上传的文件类型不正确，允许的类型有：'.implode(",",$allow);
        return false;
    }
    //移动临时文件保存到真正的文件夹中
    $newname= randName($file['name']);
    $target=$path . '/' .$newname;
    $result=move_uploaded_file($file['tmp_name'],$target);
    if ($result){
       return 'http://www.'.$_SERVER['HTTP_HOST'].'/mybbs/uploads/image_publish/'.$newname;
    }else{
        $error="发生未知错误，上传失败";
        return false;
    }
}

/**
 * 随机生成复制文件名字的函数 时间 + 随机6位数 + 后缀
 * @param $fileName 文件的原始名字
 * $newName随机生成的新文件的名字
 */
function randName($fileName){
    //生成时间部分的名字
    $RanNewName=date('YmdHis');
    //随机产生6位数
    $str="0987654321";
    for ($i=0;$i<6;$i++){
        $RanNewName .=$str[mt_rand(0,strlen($str)-1)];//mt_rand()返回 min （或者 0） 到 max （或者是到 mt_getrandmax() ，包含这个值）之间的随机整数
    }
    //加上文件的后缀名
    $RanNewName .=strchr($fileName,'.');
    return $RanNewName;
}