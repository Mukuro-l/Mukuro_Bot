<?php


namespace Hahadu\Collect\Interfaces;


interface JsonInterface
{
    public function toJson(int $options = JSON_UNESCAPED_UNICODE): string;
}