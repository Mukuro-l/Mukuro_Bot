<?php
include "./vendor/autoload.php";
include "./Module/GifCreator.php";
use Intervention\Image\ImageManagerStatic as Image;
use GuzzleHttp\Client;
use GifCreator\GifCreator;

function Json(array $jsonData)
{
    return json_encode($jsonData, JSON_UNESCAPED_UNICODE);
}

function de_Json($jsonData):array
{
    return json_decode($jsonData, true);
}

/**
*@author Mukuro-l
*@doc 逐行计算文本长度，获取最大值
*/
//文件
function String_File_size(string $file)
{
    if (is_file($file)) {
        //打开文件
        $text = fopen($file, "r");

        //设置空数组
        //循环结果
        $total = [];
        //结果
        $result = [];

        //如果没有到底，一直循环
        while (!feof($text)) {
            //逐行读取
            $line = fgets($text);
            //去除余数
            $quantity = intval(floor(strlen($line)/3));
            //填入循环结果
            $total[] = $quantity;
        }
        //排序
        sort($total);

        do {
            $result[] = $total[count($total)-1];
        } while (count($result)!==1);

        //关闭文件
        fclose($text);

        return $result[0];
    }
}

//请注意 避免\r\n被转义
function String_size(string $text)
{
    if (strstr($text, '\r\n')) {
        $result = [];
        $array = explode('\r\n', $text);
        foreach ($array as $file) {
            $quantity = intval(floor(strlen($file)/3));
            $result[] = $quantity;
        }
        sort($result);

        return $result[count($result)-1];
    } else {
        return '\r\n可能被转义，或者没有\r\n！';
    }
}


function radius_img(string $imgpath, int $radius = 420)
{
    $ext     = pathinfo($imgpath);
    $src_img = null;
    switch ($ext['extension']) {
    case "jpg":
        $src_img = imagecreatefromjpeg($imgpath);
        break;
    case "png":
        $src_img = imagecreatefrompng($imgpath);
        break;
    }
    
    
    $wh = getimagesize($imgpath);
    $w  = $wh[0];
    $h  = $wh[1];
    // $radius = $radius == 0 ? (min($w, $h) / 2) : $radius;
    $img = imagecreatetruecolor($w, $h);
    //这一句一定要有
    imagesavealpha($img, true);
    //拾取一个完全透明的颜色,最后一个参数127为全透明
    $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
    imagefill($img, 0, 0, $bg);
    $r = $radius; //圆 角半径
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            $rgbColor = imagecolorat($src_img, $x, $y);
            if (($x >= $radius && $x <= ($w - $radius)) || ($y >= $radius && $y <= ($h - $radius))) {
                //不在四角的范围内,直接画
                imagesetpixel($img, $x, $y, $rgbColor);
            } else {
                //在四角的范围内选择画
                //上左
                $y_x = $r; //圆心X坐标
                $y_y = $r; //圆心Y坐标
                if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
                //上右
                $y_x = $w - $r; //圆心X坐标
                $y_y = $r; //圆心Y坐标
                if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
                //下左
                $y_x = $r; //圆心X坐标
                $y_y = $h - $r; //圆心Y坐标
                if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
                //下右
                $y_x = $w - $r; //圆心X坐标
                $y_y = $h - $r; //圆心Y坐标
                if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
            }
        }
    }
    
    imagepng($img, $imgpath);
}

//设置图片水印
function Text_Images(string $text, int|string $qq):
    string
{
    $BOT_Config = json_decode(file_get_contents("config.json"), true);
    
    Image::configure(['driver' => 'imagick']);


    //一个字符占用63*63=3969个像素
    //1080/17=63

    //可占用30行
    //1920/63=30

    //1920/3=640  640+640=1280

    //1280/63=20

    //总共1080*1280=1382400个像素

    //一行17个
    //一共可容下
    //17*30=510个字

    //半屏可容下
    //1382400/3969=348个字
if (is_file($text)){
    $number=String_File_size($text);
    $tall=count(file($text))-20;
    $text_data=file_get_contents($text);
}else{
    $number=String_size($text);
    $tall=20;
    $array = explode('\r\n', $text);
        $quantity = "\r\n";
        foreach ($array as $file) {
            $quantity .= "$file\r\n";
            
        }
        $text_data = $quantity;
}
    
    if ($number>17&&$number!==17) {
        $number = $number-17;
        $number = $number*63;
        $number = 1080+$number;
        $tall_one = $tall*63;
        $tall = $tall_one + 1920;
    } else {
        $number = 1080;
        $tall = 1920;
    }

    //创建一个画布
    $image = Image::canvas($number, $tall, '#E6E6FA');

    //第一个参数是○直径
    /*$image ->circle(100, 960, 540, function ($draw) {
    //定义背景色
        $draw->background('#0000ff');
        $draw->border(1, '#f00');
    });
    */
    //1280
    /*$image->line(480, 1080, 480, 540, function ($draw) {
        $draw->color('#0000ff');
        $draw->width(20);
    });
                //起点x 起点y 终点
    $image->line(1440, 1080, 1440, 540, function ($draw) {
        $draw->color('#0000ff');
        $draw->width(20);
    });

    $image->line(1440, 540, 480, 540, function ($draw) {
        $draw->color('#0000ff');
        $draw->width(20);
    });
    */

    $time_array = ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];

    $today_time = date("Y-m-d")." ".$time_array[date("w")];

    //添加文字
    $image->text($today_time.date("H:i:s"), 240, 10, function ($font) {
        $font->file('./Data/Font/cute.TTF');
        $font->size(50);
        $font->color('#000000');
        $font->align('left');
        $font->valign('top');
        $font->angle(0);
    });

    $image->text("version:".$BOT_Config["SDK"], 240, 73, function ($font) {
        $font->file('./Data/Font/cute.TTF');
        $font->size(50);
        $font->color('#000000');
        $font->align('left');
        $font->valign('top');
        $font->angle(0);
    });

    $image->text("QQ:".$qq, 240, 136, function ($font) {
        $font->file('./Data/Font/cute.TTF');
        $font->size(50);
        $font->color('#000000');
        $font->align('left');
        $font->valign('top');
        $font->angle(0);
    });

    
    $image->text($text_data, 0, 470, function ($font) {
        $font->file('./Data/Font/cute.TTF');
        $font->size(60);
        $font->color('#000000');
        $font->align('left');
        $font->valign('top');
        $font->angle(0);
    });

    $image->text("Mukuro-v".$BOT_Config["SDK"], $number, $tall, function ($font) {
        $font->file('./Data/Font/cute.TTF');
        $font->size(50);
        $font->color('#FFD700');
        $font->align('right');
        $font->valign('down');
        $font->angle(0);
    });


    //$image -> pixelate(15);
    //$image -> fit(150, 50);
    $image -> insert("./images/xx.png", 'top-left', 0, 0);
    $image -> save('./images/'.  $qq . ".jpg");
    $image_data = "file://".realpath(dirname("./images/". $qq . ".jpg"))."/". $qq ."jpg";
    return "[CQ:image,file=".$image_data."]";
}
    
    function Auto_doc(int $qq):
     string
    {
        $Mukuro_doc_First = "<---六儿的插件--->\r\n";
        $data = file_get_contents("./Doc/Mukuro_Menu_Doc/Menu.doc");
        $Mukuro_doc = $Mukuro_doc_First . $data;
        file_put_contents("./Data/Text/".$qq.".txt", $Mukuro_doc);
        return Text_Images("./Data/Text/".$qq.".txt", $qq);
    }

function Heihei(string $order, int $qq):string
{
    if ($order == "一分钟") {
        Image::configure(['driver' => 'imagick']);

        $qq_img_data = file_get_contents("https://q.qlogo.cn/headimg_dl?dst_uin=".$qq."&spec=640");
        file_put_contents("./images/".$qq.".jpg", $qq_img_data);

        $image = Image::make(file_get_contents("./images/一分钟.jpg"));

        //242/6=40.33333333
        radius_img("./images/".$qq.".jpg", 200);


        $toux = Image::make("./images/".$qq.".jpg");

        $toux -> resize(400, 400);

        $toux -> flip('h');

        $toux -> rotate(-25);

        $toux -> save("./images/".$qq.".png");

        $image -> insert("./images/".$qq.".png", 'center', -10, 100);

        $image -> save("./images/".$qq.".png");

        copy("./images/".$qq.".png", "../gocq/data/images/".$qq.".png");

        return "[CQ:image,file=".$qq.".png]";
    }
}
//自定义合成图片
/*function To_Image(int $_x=1280, int $_y=1280, int $x=1280/2,int $y=1280/2, string $img_data, string $path="./images/" ){
$image = Image::canvas($_x, $_y, '#E6E6FA');


}
*/
//GuzzleHttp Curl封装
function Curl(string $Url)
{
    //创建客户端
    $client = new Client([
    'base_uri' => $Url,
    'timeout'  => 2.0,
]);
}


/**
*@doc 合成gif动图
*@date 2022.6.24
*/
//frames需要数据流数组
function To_Gif(array $frames, array $durations=[40, 40, 40, 40])
{
    //按照顺序设置一个包含每帧毫秒时间的数组
    $gc = new GifCreator();
    //设置循环，遵守数组元素数量
    $gc->create($frames, $durations, count($frames));
    //注意，这只会返回一个数据流
    $gifBinary = $gc->getGif();
    return $gifBinary;
}

//开发中
function M_Database(array $test)
{
    //使用predis
    $client = new Predis\Client();
    $client->set('foo', 'bar');
    $value = $client->get('foo');
}
