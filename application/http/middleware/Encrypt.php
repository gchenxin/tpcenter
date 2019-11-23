<?php


namespace app\http\middleware;


use OAuth;

class Encrypt{

    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        var_dump($request);
        // 添加中间件执行代码
        //app('rsa')->encrypt();

        return $response;
    }
}