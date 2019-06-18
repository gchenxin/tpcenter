<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/17
 * Time: 11:52
 */
namespace app\Oauth;


use PhpOffice\PhpSpreadsheet\Reader\Xls\MD5;
use think\Db;
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
        $this->client_id = isset($param['client_id']) ? $param['client_id'] : null;
        $this->client_key = isset($param['client_key']) ? $param['client_key'] : null;
        $this->auth_type = isset($param['auth_type']) ? $param['auth_type'] : null;
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
            //验证签名
            if(!$this->checkSign()){
                throwException(ERROR_SIGN);
            }
            return $this->generateToken($clientInfo['user_id'],$clientInfo['scope']);
        }else{
            throwException(NOT_INVALID_CLIENT);
        }

    }

    public function refreshToken(){
        //验证是否是授权的clientId
        $clientInfo = model('OauthClient')->checkClient($this->client_id,$this->client_key);
        if($clientInfo){
            //验证签名
            if(!$this->checkSign()){
                throwException(ERROR_SIGN);
            }
            //验证refreshToken是否正确
            if(!model('OauthRefresh')->check($this->refresh_token,$this->client_id,$this->client_key)){
                throwException(ERROR_REFRESH);
            }
            return $this->generateToken($clientInfo['user_id'],$clientInfo['scope']);
        }else{
            throwException(NOT_INVALID_CLIENT);
        }

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
        return true;
        $param = request()->param();
        unset($param['XDEBUG_SESSION_START']);
        unset($param['sign']);
        unset($param['token']);
        unset($param['refresh_token']);
        ksort($param);
        $encryptStr = '';
        foreach($param as $key=>$value){
            $encryptStr .= $key.'='.$value;
        }
        return $this->sign == \md5($encryptStr);
    }

    /**
     * 生成token令牌
     * @param $userId
     * @param $scope
     * @return array
     * @throws \Exception
     */
    public function generateToken($userId, $scope){
        try{
            Db::startTrans();
            $token = \md5($this->client_id . $this->client_key . date('YmdHis',time()) . mt_rand(1,999));
            $expire = date('Y-m-d H:i:s',time() + 7200);
            $result = model('OauthAccess')->setAccessToken($this->client_id,$userId,$token,$scope,$expire);
            if(!$result){
                throwException(ERROR_FAIL);
            }
            $refreshToken = md5($token);
            $result = model('OauthRefresh')->setRefreshToken($this->client_id,$userId,$refreshToken,$scope);
            if(!$result){
                throwException(ERROR_FAIL);
            }
            Db::commit();
            return ['access_token'=>$token,'refresh_token'=>$refreshToken,'expire'=>$expire];
        }catch(\Exception $e){
            Db::rollback();
            throwException($e->getCode());
        }
    }

}