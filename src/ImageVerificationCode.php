<?php
namespace Fir\ImageVerificationCode;
/**
 *	$author fir
 */
class ImageVerificationCode{

    //图片资源
    private $image = null;
    //生成的验证码字的个数
    public $codeNum;
    //验证码高度
    public $height;
    //验证码宽度
    public $width;
    //干扰元素数量
    private $disturbColorNum;
    //生成的code
    public $code='';
    //字体
    private $fontFace;

    /*
	 *	架构函数
	 *	验证码宽度 默认120
	 *	验证码高度 默认 35
	 *	验证码数量 默认4
	 *
	 */
    public function __construct($width = 90, $height = 40, $codeNum = 4, $fontFace = ''){
        //判断服务器环境是否安装了GD库
        if (!extension_loaded('gd')) {
            if (!extension_loaded('gd.so')) {
                exit('未加载GD扩展');
            }
        }
        //初始化
        $this->width = $width;
        $this->height = $height;
        $this->codeNum = $codeNum;
        if(empty($fontFace)){
            $this->fontFace = dirname(__FILE__).DIRECTORY_SEPARATOR.'Alex_Bold.ttf';
        }else{
            $this->fontFace = $fontFace;
        }
        //设置干扰元素数量
        $number = floor($width * $height/15);
        if($number > 240 - $codeNum){
            $this->disturbColorNum = 240-$codeNum;
        }else{
            $this->disturbColorNum = $number;
        }
        //创建图片资源
        $this->createImage();
        //设置干扰颜色
        $this->setDisturbColor();
        //生成code
        $this->createCode();
    }

    public function Generate(){
        //存入session
        session(['ImageVerificationCode' => $this->code]);
        //往图片上添加文本
        $this->outputText($this->fontFace);
        //输出图像
        $this->ouputImage();
    }

    //创建图片 无边框
    private function createImage(){
        //生成图片资源
        $this->image = imagecreatetruecolor($this->width,$this->height);
        //画出图片背景
        $backColor = imagecolorallocate($this->image,mt_rand(255,255),mt_rand(255,255),mt_rand(255,255));
        imagefill($this->image,0,0,$backColor);
    }

    //输出图像
    private function ouputImage(){
        ob_clean();	//防止出现'图像因其本身有错无法显示'的问题
        if(imagetypes() & IMG_GIF){
            imagepng($this->image);
        }else if(imagetypes() & IMG_JPG){
            imagepng($this->image);
        }else if(imagetypes() & IMG_PNG){
            imagepng($this->image);
        }else if(imagetypes() & IMG_WBMP){
            imagepng($this->image);
        }else{
            die('PHP不支持图像创建');
        }
    }

    //往图片上添加文本
    private function outputText($fontFace=''){
        //画出code
        $code = str_split($this->code);
        foreach ($code as $k => $v){
            $fontSize = mt_rand(20,25);
            $x = floor(($this->width - 4) / $this->codeNum) * $k + 5;
            $y = mt_rand($fontSize, $this->height - 2);
            imagettftext($this->image, $fontSize, mt_rand(-30, 30), $x, $y, $this->randomColor(0, 180), $fontFace, $v);
        }
    }

    private function randomColor($start = 0, $end = 255){
        return imagecolorallocate($this->image,mt_rand($start,$end),mt_rand($start,$end),mt_rand($start,$end));
    }

    //设置干扰颜色
    private function setDisturbColor(){
        //画出点干扰
        for($i=0; $i <= $this->disturbColorNum; $i++){
            $pixelColor = $this->randomColor();
            imagesetpixel($this->image, mt_rand(0, $this->width), mt_rand(0, $this->height), $pixelColor);
        }
        //画出干扰线 待续
        for ($i = 0; $i < 10; $i ++){
            imageline($this->image, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->height), mt_rand(0, $this->width),$this->randomColor());
        }
    }

    //生成随机验证码
    private function createCode(){
        $string = [
                '0','1','2','3','4','5','6','7','8','9',
                'a','b','c','d','e','f','g','h','j','k','l','m','n','p','q','r','s','t','u','v','w','x','y','z',
                'A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z'
        ];
        $code = array_rand($string, $this->codeNum);
        foreach ($code as $k => $v){
            $this->code .= $string[$v];
        }
    }

    // 摧毁资源
    public function __destruct(){
        imagedestroy($this->image);
    }
}