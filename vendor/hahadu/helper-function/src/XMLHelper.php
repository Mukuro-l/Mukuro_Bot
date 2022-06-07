<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu/wechat
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2020/10/20 上午11:19
 *  +----------------------------------------------------------------------
 *  | Description:   微信公众平台SDK
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\Helper;


use Hahadu\Collect\Collection;

class XMLHelper
{
    /**
     * 数据XML编码
     * @param mixed  $data 数据
     * @param string $item 数字索引时的节点名称
     * @param string $id   数字索引key转换为的属性名
     * @return string
     */
    static public function data_to_xml($data, $item = 'item', $id = 'id')
    {
        $xml = $attr = '';
        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                $id && $attr = " {$id}=\"{$key}\"";
                $key         = $item;
            }
            $xml .= "<{$key}{$attr}>";
            $xml .= (is_array($val) || is_object($val)) ? self::data_to_xml($val, $item, $id) : $val;
            $xml .= "</{$key}>\n";
        }
        return $xml;
    }

    /**
     * XML编码
     * @param mixed $data 数据
     * @param bool $xml 是否显示<?XML>文件标签
     * @param string $root 根节点名
     * @param string $item 数字索引的子节点名
     * @param string $attr 根节点属性
     * @param string $id   数字索引子节点key转换的属性名
     * @param string $encoding 数据编码
     * @param string $standalone
     * @return string
     */
    static public function xml_encode($data,$xml=true, $root = 'root',  $item = 'item', $attr = '', $id = 'id', $encoding = 'utf-8', $standalone ='yes')
    {
        if (is_array($attr)) {
            $_attr = array();
            foreach ($attr as $key => $value) {
                $_attr[] = "{$key}=\"{$value}\"";
            }
            $attr = implode(' ', $_attr);
        }
        $attr = trim($attr);
        $attr = empty($attr) ? '' : " {$attr}";
        if($xml){
            $xml  = "<?xml version=\"1.0\" encoding=\"{$encoding}\" standalone=\"{$standalone}\"?> \n";
        }
        $xml .= "<{$root}{$attr}>\n";
        $xml .= self::data_to_xml($data, $item, $id);
        $xml .= "</{$root}>";
        return $xml;
    }

    /****
     * xml转JSON
     * @param $xmlData
     * @return mixed
     */
    static public function xml_to_json($xmlData){
        return self::collect($xmlData)->toJson();
    }
    /****
     * xml转普通对象
     * @param xml $xmlData
     * @param bool $assoc
     * @return mixed
     */
    static public function xml_to_obj($xmlData){
        return (object)self::xml_to_array($xmlData);
    }
    /****
     * xml转数组
     * @param $xmlData
     * @return mixed
     */
    static public function xml_to_array($xmlData){
        return  self::collect($xmlData)->toArray();
    }

    static private function collect($xmlData){

        $xmlObj = simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA);
        return new Collection($xmlObj);
    }


}