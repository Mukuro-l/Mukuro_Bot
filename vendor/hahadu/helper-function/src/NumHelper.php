<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu/helper-function
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2020/11/9 上午11:42
 *  +----------------------------------------------------------------------
 *  | Description:   NumHelper 数字处理
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\Helper;


class NumHelper
{
    /**
     * 获取一定范围内的随机数字
     * 跟rand()函数的区别是 位数不足补零 例如
     * rand(1,9999)可能会得到 465
     * rand_number(1,9999)可能会得到 0465  保证是4位的
     * @param integer $min 最小值
     * @param integer $max 最大值
     * @return string
     */
    static function rand_number ($min=1, $max=9999) {
        return sprintf("%0".strlen($max)."d", mt_rand($min,$max));
    }

    /**
     * 生成不重复的随机数
     * @param  int $start  需要生成的数字开始范围
     * @param  int $end 结束范围
     * @param  int $length 需要生成的随机数个数
     * @return array       生成的随机数
     */
    static function get_rand_number($start=1,$end=10,$length=4){
        $connt=0;
        $temp=array();
        while($connt < $length){
            $temp[]=rand($start,$end);
            $data=array_unique($temp);
            $connt=count($data);
        }
        sort($data);
        return $data;
    }

}