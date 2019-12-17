<?php

namespace app\http\middleware;

use Ajax;
use Oauth;
use think\exception\ErrorException;
use think\exception\Exception;

class Auth
{
    public function handle($request, \Closure $next)
    {
        //token验证
        try{
//            if($request->header('from') != 'fruyu.tbk.app'){
//                throwException(NOT_INVALID_CLIENT);
//            }
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
