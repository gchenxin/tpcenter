<?php

namespace app\http\middleware;

use Ajax;
use Oauth;

class Auth
{
    public function handle($request, \Closure $next)
    {
        //token验证
        try{
            if($this->checkTokenHandler()){
                return $next($request);
            }
        }catch(\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    public function checkTokenHandler(){
        return Oauth::checkUserToken();
    }
}
