#  安装

```composer
composer require laofu110/poster
```

#  使用方法

```
$config =[
    'bg' => '',//背景图片路径
    'format'=>'jpg',//支持jpg、png、gif
    'quality'=>75,//压缩质量（0-100），输出格式为jpg时比较明显
    'text' => [
        [
            'text' => '',
            'left' => 242, 
            'top' => 466,
            'fontSize' =>28,
            'fontColor' => '68,68,68',
            'angle' => 0,//旋转角度
        ],
    ],
    'image' =>[
        [
            'url' => '',//支持图片数据流、网络地址、本地路径
            'left' => 110,
            'top' => 420,
            'width' => 110,
            'height' => 110,
            'radius' => 50,
            'opacity' => 100,
        ],
    ]
];
$Poster=new \Laofu\Image\Poster($config);
$img=$Poster->make($filename);//当$filename=''时，会返回图片数据流，可以结合response直接输出到浏览器
if(!$img){
    $err=$Poster->errMsg;
}
```

> 当图片类型为网络地址时，如果图片下载需要用到referer以及其他参数时，可以在图片参数里添加header参数

#  说明

* 画布大小等于背景图片大小，暂不支持使用空背景参数定义画布
* 实际上画布bg的参数除了支持直接给定一个字符串图片以外，也可以给一个数组参数，里面也可以包含timeout跟header选项
* 本项目基于 [jiankeluoluo/php_poster](https://github.com/jiankeluoluo/php_poster) 二次封装，因为引入了网络图片下载功能，为了防止内存溢出，去掉了static方法