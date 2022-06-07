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
 *  | Date: 2020/10/23 下午3:27
 *  +----------------------------------------------------------------------
 *  | Description:   HttpHelper
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\Helper;

use FormBuilder\UI\Elm\Components\Select;
use http\Client;
use http\Client\Request;
use http\Message\Body;
use GuzzleHttp\Client as Guzzle;
use Psr\Http\Client\ClientInterface;

class HttpHelper
{
    protected static $client;
    protected static $request;
    protected static $body;
    protected static $Guzzle;

    public function __construct(){
        if(class_exists(Client::class)){
            self::$client = new Client();
            self::$request = new Request();
            self::$body = new Body();

        }else{
            self::$Guzzle = new Guzzle();
        }
    }
    static protected function init(){
        new self();
    }

    /****
     * 发送post请求
     * @param $url
     * @param $body
     * @param array $header
     * @return
     */
    static public function post($url, $body, array $header = [])
    {
        return self::request('post',$url,$body,$header)->getBody();
    }

    /****
     * 发送get请求
     * @param $url
     * @param string $body
     * @param array $header
     * @return Body
     */
    static public function get($url,$body='',$header=[]){

        return self::request('get',$url,$body,$header)->getBody();
    }
    /****
     * 发送http请求，
     * return self::request(...)->getBody()
     * @param string $method 请求方式
     * @param string $url 请求地址
     * @param string|array $body 请求内容
     * @param array|null $headers header
     * @return false|Client\Response|string|NULL
     */
    static public function request($method,$url,$body=null,$headers=[]){
        self::init();
        if (is_array($body)) {
            $body = http_build_query($body);
        }
        if(class_exists(Client::class)){
            self::$request->setRequestMethod(strtoupper($method));
            self::$request->setRequestUrl($url);
            if (null != $body) {
                self::$body->append($body);
                self::$request->setBody(self::$body);
            }
            if (!empty($headers)) {
                self::$request->setHeaders($headers);
            }
            self::$client->enqueue(self::$request)->send();
            return self::$client->getResponse();
        }else{
            return json_encode(['使用该函数请先安装php-http']);
        }

    }


}