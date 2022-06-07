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
 *  | Date: 2020/10/1 下午4:54
 *  +----------------------------------------------------------------------
 *  | Description:   数组操作类
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\Helper;
use Hahadu\Collect\Collection;

class ArrayHelper
{

    /*****
     * @param $array
     * @return Collection
     */
    static public function collect($array): Collection
    {
        return new Collection($array);
    }
    /****
     * 多维数组排序
     * @param array $multi_array 多维数组
     * @param string $sort_key  二维数组的键名
     * @param int $sort 排序方式 SORT_ASC || SORT_DESC
     * @return Collection
     */
    static public function multi_array_sort(&$multi_array,$sort_key,$sort=SORT_DESC): Collection
    {
        return self::collect($multi_array)->order($sort_key,$sort);
    }

    /*****
     * 封装消息数组
     * @param int $code 状态码
     * @param string $message 消息提示
     * @param array $data 消息数据
     * @param array $optional 消息其他数据 [$key=>$value]
     * @return array
     */
    static public function wrap_msg_array($code,$message='',$data=[],array $optional=[]): array
    {
        $array = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
        if(!empty($optional) && is_array($optional)){
            return array_merge($array,$optional);
        }
        return $array;
    }

    /****
     * 获取数组下标
     * @param array $arrk
     */
    static public function arrk($arrk){
        foreach( array_keys($arrk) as $k1 ) {
            foreach( array_keys($arrk[$k1]) as $k2 ) {
                $k1;
                $k2;
            }
        }
    }

    /*****
     * 列出数组中的重复元素
     * @param $array
     * @return array
     */
    static public function array_repeat_list($array) {

        return self::collect($array)->diff_assoc();
    }

    /******
     * 根据二维数组中的部分子键值列出多维数组中的重复元素
     * @param array $arr 查询的目标数组
     * @param array $keys 要进行判断的键名组合的数组
     * @return Collection 重复的值
     */
    static function check_array_repeat($arr,$keys): Collection
    {
        $unique_arr = [];
        $unique_arr = self::collect($arr)->map(function ($item)use($keys,$unique_arr){
            $str = "";
            foreach ($keys as $a => $b) {
                $str .= "{$item[$b]},";
            }
            if (!in_array($str, $unique_arr)) {
                $unique_arr[] = $str;
            } else {
                return $item;
            }
        });

        return $unique_arr;

    }


    /**
     * 不区分大小写的in_array()
     * @param  string $str   检测的字符
     * @param  array  $array 数组
     * @return bool       是否in_array
     */
    static public function in_iarray($str,$array){
        $str=strtolower($str);
        return self::collect($array)->map('strtolower')->isIn($str);
    }

    /******
     * 数组模糊查询
     * @param string $search 查询字符串
     * @param array $array 查询对象
     * @return Collection 查询结果
     */
    static public function array_fuzzy_search($search, $array){

        return self::collect($array)
            ->filter(function ($item)use($search){
                if (strstr($item, $search) != false) {
                    return $item;
                }
            });

    }



}