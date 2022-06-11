<?php
use Hahadu\ImageFactory\Config\Config;
use Hahadu\ImageFactory\Kernel\Factory;

function Text_Images_one(string $text, int $qq,string $image='./images/Mukuro_background.png'):string{
        $config = new Config();
        $config->setSavePath = 'images/';
        $config->waterMarkText = $text; //设置水印文字，支持\n换行符
        $config->TextStyle = [
        //支持的配置项
            'font_size' => 20, //字体大小
            'font_weight' => 500, //字体粗细
            'fill_color' => '#000000',//字体颜色，支持标准色值，
            'under_color' => '#F8F8FF',//背景颜色，支持标准色值
            'fill_opacity' => '0.5', //浮点数0-1，透明度，这里设置透明度会覆盖fill_color中的透明度
            'stroke_width' =>0.1, //描边
        ];
        Factory::setOptions($config);
        $text_water_mark = Factory::text_to_image()->text_water_mark($image,$x='center',$y='top',$option=[]);
        $config->waterMarkImage='./images/xx.png';
        Factory::setOptions($config);

        $option=[
            'format' => 'jpg', //文件格式后缀
            'opacity' => 5,//设置图像透明度,值越大可见度越低，目前仅支持带alpha通道的图片
            'path' => '' //自定义文件保存路径，此处会覆盖$config->setSavePath
        ];

        $img_mark_url = Factory::image_to_image()->image_water_mark('.'.$text_water_mark,$x='left',$y='top',$option);

	}

//设置图片水印
function Text_Images(string $text, int $qq):
	string {
	Text_Images_one($text,$qq,$image='./images/Mukuro_background.png');
		$config = new Config();
        $config->setSavePath = 'images/';
        $config->waterMarkText = 'Mukuro_Bot'; //设置水印文字，支持\n换行符
        $config->TextStyle = [
        //支持的配置项
            'font_size' => 20, //字体大小
            'font_weight' => 500, //字体粗细
            'fill_color' => '#000000',//字体颜色，支持标准色值，
            'under_color' => '#F8F8FF',//背景颜色，支持标准色值
            'fill_opacity' => '0.5', //浮点数0-1，透明度，这里设置透明度会覆盖fill_color中的透明度
            'stroke_width' =>0.1, //描边
        ];
        Factory::setOptions($config);
        $text_water_mark = Factory::text_to_image()->text_water_mark("./images/Mukuro_background.png",$x='right',$y='down',$option=[]);
		
		copy('.'.$text_water_mark . $qq . ".png", "../gocq/data/images/" . $qq . ".jpg");
		return "[CQ:image,file=".$qq.".jpg]";
	}
	function Auto_doc(int $qq):
		bool {
			$Mukuro_doc_First = "<---六儿的小功能--->\r\n";
			$data = file_get_contents("./Doc/Mukuro_Menu_Doc/Menu.doc");
			$Mukuro_doc = $Mukuro_doc_First . $data;
			return Text_Images($Mukuro_doc, $qq);
		}
	
?>
