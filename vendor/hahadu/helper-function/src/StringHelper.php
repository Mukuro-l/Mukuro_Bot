<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2020/10/1 上午11:11
 *  +----------------------------------------------------------------------
 *  | Description:   字符串操作类
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\Helper;

class StringHelper
{
    /*
     *按规则截取字符串中的指定字符
     *@param str 要截取的字符串
     *@param leftStr 开始标示符
     *@param rightStr 结束标示符
     *return string
     *demo
     *url=https://baidu.com/video/?video_id=123456789&line=0&ratio=7
     *GetSubStr($url,'?video_id=','&line=0')
     *结果：123456789
     */
    static public function GetSubStr($str, $leftStr, $rightStr)
    {
        $left = strpos($str, $leftStr);
        //echo '左边:'.$left;
        $right = strpos($str, $rightStr, $left);
        //echo '<br>右边:'.$right;
        if ($left < 0 or $right < $left) return '';
        return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
    }

    /*******
     * 创建uuid 推荐用php-uuid extension 代替
     * @return string
     */
    static public function uuid_create()
    {
        if (function_exists('com_create_guid')) {
            return trim(com_create_guid(), '{}');
        } else {
            $namespace = rand(11111, 99999);
            $guid = rand();
            $uid = uniqid(rand(), true);
            $data = $namespace;
            $data .= $_SERVER['REQUEST_TIME'];
            $data .= $_SERVER['HTTP_USER_AGENT'];
            $data .= $_SERVER['REMOTE_ADDR'];
            $data .= $_SERVER['REMOTE_PORT'];
            $char_id = hash('ripemd128', $uid . $guid . md5($data));
            $hyphen = chr(45); // "-"
            return
                substr($char_id, 0, 8) . $hyphen .
                substr($char_id, 8, 4) . $hyphen .
                substr($char_id, 12, 4) . $hyphen .
                substr($char_id, 16, 4) . $hyphen .
                substr($char_id, 20, 12);
        }
    }


    /**
     * 字符串截取，支持中文和其他编码
     * @param string $str 需要转换的字符串
     * @param int $start 开始位置
     * @param int $length 截取长度
     * @param bool $suffix 截断显示字符
     * @param string $charset 编码格式
     * @return string
     */
    static public function re_substr($str, $start = 0, $length, $suffix = true, $charset = "utf-8")
    {
        if (function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif (function_exists('iconv_substr')) {
            $slice = iconv_substr($str, $start, $length, $charset);
        } else {
            $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("", array_slice($match[0], $start, $length));
        }
        $omit = mb_strlen($str) >= $length ? '...' : '';
        return $suffix ? $slice . $omit : $slice;
    }

    /**
     * 按符号截取字符串的指定部分
     * @param string $str 需要截取的字符串
     * @param string $sign 需要截取的符号
     * @param int $number 如是正数以0为起点从左向右截  负数则从右向左截
     * @return string 返回截取的内容
     *  示例
     * $str='123/456/789';
     * cut_str($str,'/',0);  返回 123
     * cut_str($str,'/',-1);  返回 789
     * cut_str($str,'/',-2);  返回 456
     *
     */
    static public function cut_str($str, $sign, $number)
    {
        $array = explode($sign, $str);
        $length = count($array);
        if ($number < 0) {
            $new_array = array_reverse($array);
            $abs_number = abs($number);
            if ($abs_number > $length) {
                return 'error';
            } else {
                return $new_array[$abs_number - 1];
            }
        } else {
            if ($number >= $length) {
                return 'error';
            } else {
                return $array[$number];
            }
        }
    }

    /****
     *敏感词检测
     * @param string $content 要检测的文本
     * @param array $violations 定义敏感词
     * @return int
     *
     *用法：
     * 参数violations中定义敏感词 array ('AV', '政治'，'情色','共产党' )
     * if (transgress_keyword($_POST[title])> 0 || transgress_keyword($_POST[content])> 0 ) {
     * //判断返回值大于0说明包含敏感词
     * echo '您输入的内容中含有敏感词';
     * }
     */
    static public function violations_keyword($content, $violations = [])
    {                  //定义处理违法关键字的方法
        //$keyword_list = \think\facade\Config::get('violations'); //读取配置文件中的violations
        //$keyword_list 是一个数组
        $keyword_list = $violations;

        $result = 0;
        for ($i = 0; $i < count($keyword_list); $i++) {    //根据数组元素数量执行for循环
            //应用substr_count检测文章的标题和内容中是否包含敏感词
            if (substr_count($content, $keyword_list [$i]) > 0) {
                $result++;
            }
        }
        return $result;              //返回变量值，根据变量值判断是否存在敏感词
    }

    /****
     * 将字符串转为utf8编码
     * @param string $str
     * @return array|mixed|string
     */
    static public function trans_utf8($str)
    {
        /***转换编码  */
        if (is_array($str)) {
            foreach ($str as $k => $v) {
                if (is_array($v)) {
                    $str[$k] = self::trans_utf8($v);
                } else {
                    $encode = mb_detect_encoding($v, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
                    if ($encode == 'EUC-CN') {
                        $str[$k] = iconv('GBK', 'UTF-8', $v);
                    }
                }
            }
        } else {
            $encode = mb_detect_encoding($str, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5', 'CP936'));
            if ($encode == 'EUC-CN') {
                $str = iconv('GBK', 'UTF-8', $str);
            }
        }
        return $str;
        /**转换编码结束*/
    }

    /****
     * 将字符串转为gbk编码
     * @param string $str
     * @return array|mixed|string
     */
    static public function trans_gbk($str)
    {
        /* 转换编码  */
        if (is_array($str)) {
            foreach ($str as $k => $v) {
                if (is_array($v)) {
                    $str[$k] = self::trans_gbk($v);
                } else {
                    $encode = mb_detect_encoding($v, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5', 'CP936'));
                    if ($encode == 'CP936') {
                        $str[$k] = mb_convert_encoding($v, 'utf-8', 'GBk');
                    }
                }
            }
        } else {
            $encode = mb_detect_encoding($str, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
            if ($encode == 'CP936') {
                $str = mb_convert_encoding($str, 'utf-8', 'GBk');
            }
        }
        return $str;
        /**转换编码结束*/
    }

    /****
     * 根据符号截取字符串
     * @param string $preg 要匹配的范围
     * @param string $str 要截取的字符串
     * @return string
     * $str ="你好<我>(爱)[北京]{天安门}";
     * return str_preg('{}',$str) 天安门
     */
    static public function str_preg($preg, $str)
    {
        switch ($preg) {
            case '<>':
                preg_match_all("/(?:<)(.*)(?:>)/i", $str, $result);
                return $result;
                break;
            case '()':
                preg_match_all("/(?:\()(.*)(?:\))/i", $str, $result);
                return $result;
                break;
            case '[]':
                preg_match_all("/(?:\[)(.*)(?:\])/i", $str, $result);
                return $result;
                break;
            case '{}':
                preg_match_all("/(?:\{)(.*)(?:\})/i", $str, $result);
                return $result;
                break;
            case '""':
                preg_match_all("/(?:\")(.*)(?:\")/i", $str, $result);
                return $result;
                break;
            default:
                preg_match_all("/^(.*)(?:<)/i", $str, $result);
                return $result;
        }
    }

    /**
     *获取正文内其中1张图片路径 默认获取第一张
     * @param string $str 正文内容
     * @param int $num 第几张
     * @return mixed|string
     */
    static public function get_one_pic(string $str, int $num = 0)
    {
        $img_arr = self::get_all_pic($str);
        if (!empty($img_arr)) {
            if ($num == 0) {
                return current($img_arr);
            }
            if (!empty($img_arr[$num - 1])) {
                return $img_arr[$num - 1];
            }
        }
        return '';
    }

    /**
     *获取正文所有图片路径
     * @param string $str 正文内容
     * @return array|mixed
     */
    static public function get_all_pic($str)
    {
        $pattern = "/<img.*?src=[\'|\"](.*?(?:[\.[A-Za-z]|\.?]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern, $str, $match);
        if (!empty($match[1])) {
            return $match[1];
        }
        return [];
    }

    /**
     * 将字符串分割为数组
     * @param string $str 字符串
     * @return array       分割得到的数组
     */
    static public function mb_str_split($str)
    {
        return preg_split('/(?<!^)(?!$)/u', $str);
    }

    /**
     * 删除指定的标签和内容
     * @param array $tags 需要删除的标签数组
     * @param string $str 数据源
     * @param int|bool $content 是否删除标签内的内容 0保留内容 1不保留内容
     * @return string
     */
    static public function strip_html_tags($tags, $str, $content = 0)
    {
        if ($content) {
            $html = array();
            foreach ($tags as $tag) {
                $html[] = '/(<' . $tag . '.*?>[\s|\S]*?<\/' . $tag . '>)/';
            }
            $data = preg_replace($html, '', $str);
        } else {
            $html = array();
            foreach ($tags as $tag) {
                $html[] = "/(<(?:\/" . $tag . "|" . $tag . ")[^>]*>)/i";
            }
            $data = preg_replace($html, '', $str);
        }
        return $data;
    }

    /****
     * 生成随机字符串
     * 可用于创建随机密码
     * @param int $length 长度
     * @param string|null $chars 字符串字典
     * @return string
     */
    static public function create_rand_string($length = 9, $chars = NULL)
    {
        // 密码字符集，可任意添加你需要的字符
        if (empty($chars)) {
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_[]{}<>~`+=,.;:/?|';
        }
        $chars = self::trans_utf8($chars);

        $password = '';
        for ($i = 0; $i < $length; $i++) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            $password .= self::re_substr($chars, mt_rand(0, mb_strlen($chars) - 1), 1, false);
            // 第二种是取字符数组 $chars 的任意元素 但是中文乱码
            //$password .= $chars[ mt_rand(0, mb_strlen($chars) - 1) ];
        }

        return $password;
    }

    /**
     * 替换字符串中间的字符为指定符号，用于用户匿名处理
     * @param $name
     * @param string $mask
     * @return mixed|string
     */
    static public function anonymous($name, $mask = '*')
    {
        $strLen = mb_strlen($name, 'UTF-8');
        $min = 3;
        if ($strLen <= 1)
            return $mask;
        if ($strLen <= $min)
            return mb_substr($name, 0, 1, 'UTF-8') . str_repeat($mask, $min - 1);
        else
            return mb_substr($name, 0, 1, 'UTF-8') . str_repeat($mask, $strLen - 1) . mb_substr($name, -1, 1, 'UTF-8');
    }


    /****
     * 检查字符串是否包含中文
     * @param $str
     * @return bool
     */
    static public function check_chines($str)
    {
        if (preg_match("/[\x7f-\xff]/", $str)) {
            return true;
        } else {
            return false;
        }
    }

    /****
     * 提取字符串中的中文
     * @param $text
     * @return string
     */
    static public function get_chines($text)
    {
        preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $text, $cn_text);
        return implode('', $cn_text[0]);

    }

    /****
     * 密码加密和验证
     * @param string $data 要加密或验证的密码字符串
     * @param string $hash 加密后的密码，该参数为空时加密$data,不为空则验证$data
     * @param int $cost //数值越大性能要求越高
     * @return bool|string|null
     */
    static public function password($data, $hash = '', $cost = 12)
    {
        if ($hash == null) {
            return password_hash(md5($data), PASSWORD_BCRYPT, ['cost' => $cost]);
        } else {
            return password_verify(md5($data), $hash);
        }
    }
}