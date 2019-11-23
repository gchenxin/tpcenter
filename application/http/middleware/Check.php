<?php

namespace app\http\middleware;

use think\Loader;
use Ajax;

class Check
{
    public function handle($request, \Closure $next)
    {
        //前置中间件
        $allowed_origins = config('auth.allow_origin');
        if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
            header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
        }
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        //非对称解密
        $this->decryptRSA($request);

        //参数检验
        $this->checkParamHandler($request);

        return $next($request);

    }

    /**
     * openssl非对称加密解密
     * @param $request
     */
    public function decryptRSA(&$request){
        //app('app\common\logic\EncryptRSA')->decrypt($request->params);
    }

    public function checkParamHandler(&$request){
        $request->page = empty($request->page) ? 1 : $request->page;
        $request->limit = empty($request->limit) ? 20 : $request->limit;
    }

}
