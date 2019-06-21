<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/20
 * Time: 10:43
 */

namespace app\common\logic;


class WechatBLL {
    private $app_id;
    private $app_key;
    private $mch_id;
    private $template_info;
    private $redirect_url;

    public function __construct() {
        $config = config('wechat');
        $this->app_id = $config['app_id'];
        $this->app_key = $config['app_secret'];
        $this->mch_id = $config['mch_id'];
        $this->template_info = $config['template_info'];
        $this->redirect_url = $config['redirect_url'];
    }

    //获取微信用户授权地址
    public function getAuthorizeUrl($scope = 'snsapi_userinfo'){
        return 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->app_id . '&redirect_uri=' . urlencode($this->redirect_url['login']) . '&response_type=code&scope=' . $scope . '&state=123#wechat_redirect';
    }

    /**
     * 获取授权token
     *
     * @param $code 通过getAuthorizeUrl获取到的code
     * @return mixed
     */
    public function get_access_token($code)
    {
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->app_id}&secret={$this->app_key}&code={$code}&grant_type=authorization_code";
        $token_data = curlPost($token_url);
        if(!empty($token_data)){
            return json_decode($token_data, TRUE);
        }
        return false;
    }

    /**
     * 获取授权后的微信用户信息
     * @param $access_token
     * @param $open_id
     * @return array|mixed
     */
    public function get_user_info($access_token, $open_id)
    {
        if ($access_token && $open_id) {
            $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
            $info_data = curlPost($info_url);
            $wechatUserInfo=[];
            if (!empty($info_data)) {
                $wechatUserInfo = json_decode($info_data, TRUE);
                $wechatUserInfo['appId'] = $this->appId;
            }
            return $wechatUserInfo;
        }
    }
}