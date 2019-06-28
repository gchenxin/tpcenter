<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

Facade::bind([
    'app\Facade\AjaxFacade' => 'app\Ajax\Ajax',
    'app\Facade\AuthTokenFacade' => 'app\Oauth\Oauth',
]);

//全局错误码
//不是授权认证的客户端
define('NOT_INVALID_CLIENT',1);
//token认证失败
define('ERROR_ACCESS',2);
//sign签名错误
define('ERROR_SIGN',3);
//refresh token验证失败
define('ERROR_REFRESH',4);
//参数错误
define('ERROR_PARAM',5);
//拒绝执行
define('ERROR_DENY',6);
//操作失败
define('ERROR_FAIL',7);
//验证失败
define('ERROR_VERIFY',8);


/**
 * 抛出全局异常
 * @param $code
 * @throws Exception
 */
function throwException($code){
    $ERROR_MESSAGE = [
        '',
        'invalid authorization client! - 未授权的应用！',
        'access denied! - token验证错误！',
        'sign error! - 签名错误！',
        'refresh token invalid! - refresh token验证错误！',
        'params invalid! - 参数格式错误！',
        'operation denied! - 拒绝执行！',
        'operation failed! - 操作失败！',
	'verify failed! - 验证失败！'
    ];
    exception($ERROR_MESSAGE[$code],$code);
}

//curl方法
function curlPost($url, $param='', $header="", $isPost=true )
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, $isPost);           //提交方式
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);    //传输数据
    if (!empty($header))
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);   //header头
    curl_setopt($ch, CURLOPT_URL, $url);
    $res = curl_exec($ch);
    if ($res === false) {
	//echo 'Curl error:'. curl_errno($ch);
	$res = '{}';
    }
    curl_close($ch);
    return $res;
}

function asynExec($domainName, $domainPort, $detailPage){
    $fp = fsockopen($domainName, $domainPort, $errNo, $errStr, 30);
    if (!$fp){
	return false;
    }else{
	stream_set_blocking($fp,true);      //开启了手册上说的非阻塞模式
	stream_set_timeout($fp,1);
	$out = "GET {$detailPage} HTTP/1.1\r\n";
	$out .= "Host: {$domainName}\r\n";
	$out .= "Connection: Close\r\n\r\n";
	
	fwrite($fp, $out);
	usleep(1000);
	//while(!feof($fp)){
	    //echo fgets($fp, 128);
	//}
	fclose($fp);
	}
}

function getRedis(){
    $config = config("cache.redis");
    $redis = new \Redis();
    $redis->connect($config['host'], $config['port']);
    $redis->auth($config['password']);

    return $redis;
}
