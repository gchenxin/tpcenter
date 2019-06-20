<?php
namespace app\index\controller;

use Ajax;
use think\Controller;

class Login extends Controller
{
    protected $middleware = ['Check'];

    //微信公众号登录入口
    public function gzhEntrance(){
        $logic = logic('WechatBLL');
        $token_url = $logic->getAuthorizeUrl('snsapi_base');
        $token_data = curlPost($token_url);
        if(!empty($token_data)){
            $userInfo = json_decode($token_data, TRUE);
        }
    }
}
