<?php
/* PHP的curl方法封装

*/


function ret_json($json) {
    return stripslashes(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}
function real_ip($type = 0) {
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($type <= 0 && isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] as $xip) {
            if (filter_var($xip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                $ip = $xip;
                break;
            }
        }
    } elseif ($type <= 0 && isset($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ($type <= 1 && isset($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif ($type <= 1 && isset($_SERVER['HTTP_X_REAL_IP']) && filter_var($_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    return $ip;
}
function curl($url, $paras = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.real_ip(), 'CLIENT-IP:'.real_ip()));
    if (isset($paras['Header'])) {
        $Header = $paras['Header'];
    } else {
        $Header[] = "Accept:*/*";
        $Header[] = "Accept-Encoding:gzip,deflate,sdch";
        $Header[] = "Accept-Language:zh-CN,zh;q=0.8";
        $Header[] = "Connection:close";
        $Header[] = "X-FORWARDED-FOR:" . real_ip();
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
    if (isset($paras['ctime'])) { // 连接超时
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $paras['ctime']);
    } else {
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    }
    if (isset($paras['rtime'])) { // 读取超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $paras['rtime']);
    }
    if (isset($paras['post'])) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
    }
    if (isset($paras['header'])) {
        curl_setopt($ch, CURLOPT_HEADER, true);
    }
    if (isset($paras['cookie'])) {
        curl_setopt($ch, CURLOPT_COOKIE, $paras['cookie']);
    }
    if (isset($paras['refer'])) {
        if ($paras['refer'] == 1) {
            curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
        }
    }
    if (isset($paras['ua'])) {
        curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
    }
    if (isset($paras['nobody'])) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    //curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (isset($paras['GetCookie'])) {
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $result = curl_exec($ch);
        preg_match_all("/Set-Cookie: (.*?);/m", $result, $matches);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $headerSize); //状态码
        $body = substr($result, $headerSize);
        $ret = array("cookie" => $matches, "body" => $body, "Header" => $header, 'code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),);
        curl_close($ch);
        return $ret;
    }
    $ret = curl_exec($ch);
    if (isset($paras['loadurl'])) {
        $Headers = curl_getinfo($ch);
        if (isset($Headers['redirect_url'])) {
            $ret = $Headers['redirect_url'];
        } else {
            $ret = false;
        }
    }
    curl_close($ch);
    return $ret;
}
