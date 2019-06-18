<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/17
 * Time: 17:28
 */

namespace app\index\controller;

use think\Controller;
use Oauth;
use Ajax;

class Oauthtoken extends Controller
{
    public function getAccessToken(){
        try{
            $result = Oauth::getAccessToken();
            return Ajax::success($result)->toJson();
        }catch(\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }

    }

    public function refreshToken(){
        try{
            $result = Oauth::refreshToken();
            return Ajax::success($result)->toJson();
        }catch(\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }


}