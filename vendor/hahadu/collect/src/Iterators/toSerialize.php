<?php

namespace Hahadu\Collect\Iterators;

trait toSerialize
{

    //JsonSerializable
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * 转换当前数据集为JSON字符串
     * @access public
     * @param integer $options json参数
     * @return string
     */
    public function toJson(int $options = JSON_UNESCAPED_UNICODE): string
    {
        return json_encode($this->toArray(), $options);
    }

    /*****
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }


}