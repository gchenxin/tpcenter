<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/17
 * Time: 11:52
 */
namespace app\Oauth;


use PhpOffice\PhpSpreadsheet\Reader\Xls\MD5;
use think\Request;
use Ajax;

class Oauth
{
    private $client_id;
    private $client_key;
    private $auth_type;
    private $token;
    private $refresh_token;
    private $timestamp;
    private $sign;

    public function __construct(Request $request)
    {
        $param = $request->param();
        $this->client_id = isset($param['AUTH_USER']) ? $param['AUTH_USER'] : null;
        $this->client_key = isset($param['AUTH_KEY']) ? $param['AUTH_KEY'] : null;
        $this->auth_type = isset($param['AUTH_TYPE']) ? $param['AUTH_TYPE'] : null;
        $this->token = isset($param['token']) ? $param['token'] : null;
        $this->refresh_token = isset($param['refresh_token']) ? $param['refresh_token'] : null;
        $this->timestamp = isset($param['timestamp']) ? $param['timestamp'] : null;
        $this->sign = isset($param['sign']) ? $param['sign'] : null;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @return mixed
     */
    public function getAuthType()
    {
        return $this->auth_type;
    }


    /**
     * 获取token令牌
     * @return bool
     */
    public function getAccessToken(){
        //验证是否是授权的clientId
        $clientInfo = model('OauthClient')->checkClient($this->client_id,$this->client_key);
        if($clientInfo){
            $token = \md5($this->client_id . $this->client_key . date('YmdHis',time()) . mt_rand(1,999));
            $expire = date('Y-m-d H:i:s',time() + 7200);
            $result = model('OauthAccess')->setAccessToken($this->client_id,$clientInfo['user_id'],$token,$clientInfo['scope'],$expire);
            if(!$result){
                throwException(ERROR_FAIL);
            }
            $refreshToken = md5($token);
            $result = model('OauthRefresh')->setRefreshToken($this->client_id,$clientInfo['user_id'],$refreshToken,$clientInfo['scope']);
            if(!$result){
                throwException(ERROR_FAIL);
            }
            return ['access_token'=>$token,'refresh_token'=>$refreshToken,'expire'=>$expire];
        }else{
            throwException(NOT_INVALID_CLIENT);
        }

    }

    public function refreshToken(){

    }

    /**
     * 验证token\
     * @param $token
     * @return bool
     */
    public function checkUserToken(){
        if(!(model('OauthAccess')->checkToken($this->token)))
            throwException(ERROR_ACCESS);
        if(!$this->checkSign()){
            throwException(ERROR_SIGN);
        }
        return true;
    }

    /**
     * 验证应用签名
     * @param $timestamp
     * @param $sign
     * @return bool
     */
    public function checkSign(){
        $param = request()->param();
        unset($param['XDEBUG_SESSION_START']);
        unset($param['sign']);
        unset($param['token']);
        ksort($param);
        $encryptStr = '';
        foreach($param as $key=>$value){
            $encryptStr .= $key.'='.$value;
        }
        return $this->sign == \md5($encryptStr);
    }



}