<?php

namespace app\http\middleware;

use Ajax;
class Auth
{
    public function handle($request, \Closure $next)
    {
        //token验证
        if($this->checkTokenHandler($request)){
            return $next($request);
        }
        return Ajax::error(999,'access deny!')->toJson();
    }

    public function checkTokenHandler($request){
        return false;
    }
}
