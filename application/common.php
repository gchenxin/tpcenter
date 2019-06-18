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

/**
 * 抛出全局异常
 * @param $code
 * @throws Exception
 */
function throwException($code){
    $ERROR_MESSAGE = [
        '',
        'invalid authorization client!',
        'access denied!',
        'sign error!',
        'refresh token invalid!',
        'params invalid!',
        'operation denied!',
        'operation failed!'
    ];
    exception($ERROR_MESSAGE[$code],$code);
}