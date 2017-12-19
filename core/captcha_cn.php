<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12
 * Time: 10:07
 * 生成中文验证码
 */
//创建画布
$canvas=imagecreate(180,60);

//设置画布颜色,背景色随机
$canvcolor=imagecolorallocate($canvas,mt_rand(200,255),mt_rand(150,255),mt_rand(200,255));
//填充背景色
imagefill($canvas,0,0,$canvcolor);

/*//生成随机验证码字符串,0-9,和24个字母，大小写字母
$arr=array_merge(range(0,9),range('a','z'),range('A','Z'));
shuffle($arr); //把数组的内容打乱
//随机生成 4 个字符的数组，参数4是arr数组中的的下标
$rand_keys=array_rand($arr,4);*/
//随机的中文库
$str_cn="所以说能认识你真的不容易啊但万幸中的一幸就是大三第二学期你被编位编到了我的后面声明
我并没有贿赂才哥哦你知道吗当你被安排坐在我后我的内心是万马奔腾久能平息知道是激动还是紧张当然那时我并不太认识你但就是有那种感觉现在回想起来也挺奇怪的
难道一时就对你有意思了想是不可能的
也许你自带一种特定的磁场感应到我吧这种磁场也俗称为不过说起气质你还真的非常有";

//4、绘制文字
//生成的字符
$str='';
for ($i=1;$i<=4;$i++){
    $sum=strlen($str_cn)/3;//计算文字库有多少个，每个字有三个字节
    //得到随机截取位置
    $pos=3*mt_rand(0,$sum-1);
    $str.=substr($str_cn,$pos,3);
}

//把生成的文字保存在session中
session_start();
$_SESSION['captchacn']=$str;

//为了字符在图片中有间距，我们可以一个一个生成字符
$span=floor(180/(4+1));//字符间距
for ($i=1;$i<=4;$i++){
    //文字颜色，颜色也是随机的
    $stringColor=imagecolorallocate($canvas,mt_rand(0,255),mt_rand(0,110),mt_rand(0,100));
    /**
     * 参数一：背景颜色
     * 参数二：文字大小
     * 参数三：x,y
     * 参数四：文字颜色
     * 参数五：字体库
     * 参数六：显示的文字
     */
    imagettftext($canvas,20,mt_rand(-50,50),$i*$span,30,$stringColor,
        './STHUPO.ttf',substr($str,($i-1)*3,3));
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
