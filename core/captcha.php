<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 10:07
 * 生成验证码
 */
//创建画布
$canvas=imagecreate(170,40);

//设置画布颜色,背景色随机
$canvcolor=imagecolorallocate($canvas,mt_rand(200,255),mt_rand(150,255),mt_rand(200,255));
//填充背景色
imagefill($canvas,0,0,$canvcolor);

//生成随机验证码字符串,0-9,和24个字母，大小写字母
$arr=array_merge(range(0,9),range('a','z'),range('A','Z'));
shuffle($arr); //把数组的内容大乱
//随机生成 4 个字符的数组，参数4是arr数组中的的下标
$rand_keys=array_rand($arr,4);

//4、绘制文字
//生成的字符
$str='';
foreach ($rand_keys as $value){
    $str.=$arr[$value];
}

//把生成的文字保存在session中
session_start();
$_SESSION['captcha']=$str;

//为了字符在图片中有间距，我们可以一个一个生成字符
$span=floor(170/(4+1));//字符间距
for ($i=1;$i<=4;$i++){
    //文字颜色，颜色也是随机的
    $stringColor=imagecolorallocate($canvas,mt_rand(0,255),mt_rand(0,110),mt_rand(0,100));
    imagestring($canvas,5,$i*$span,12,$str[$i-1],$stringColor);
}


//5、生成干扰线
for ($i=1;$i<=5;$i++){
    $linecolor=imagecolorallocate($canvas,mt_rand(0,150),mt_rand(20,200),mt_rand(180,220));
    imageline($canvas,mt_rand(0,169),mt_rand(0,39),mt_rand(0,169),mt_rand(0,39),$linecolor);
}

//6、生成干扰点
for ($i=1;$i<=170*40*0.02;$i++){
    $pixlcolor=imagecolorallocate($canvas,mt_rand(100,150),mt_rand(0,120),mt_rand(0,220));
    imagesetpixel($canvas,mt_rand(0,169),mt_rand(0,39),$pixlcolor);
}

//7、输出图片,即输出画布
//设置响应头为图片输出
header("Content-type:image/png");
//在图片输入的之前必须保证前面不能有任何输出，否则图片显示错误，清除缓存函数用到ob_clean()
ob_clean();
imagepng($canvas);

//释放资源
imagedestroy($canvas);
