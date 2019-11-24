<?php


namespace app\http\middleware;

class Encrypt{

    public function handle($request, \Closure $next)
    {
        $response = $next($request);
//        $data = $response->getData();
//        var_dump(base64_encode(app('Encrypt')->encrypt(json_encode($data))));
        // 添加中间件执行代码
        //app('rsa')->encrypt();

        return $response;
    }
}