<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/17
 * Time: 13:34
 */

namespace app\Common\Model;

use think\db\Expression;
use think\Model;

class OauthAccess extends Model
{
    protected $table = 'oauth_access_tokens';

    public function __construct($data = [])
    {
        parent::__construct($data);
    }

    public function checkToken($token){
        if(!$token) return false;
        $where[] = ['access_token','=',$token];
        $where[] = ['expires','>=', date('Y-m-d H:i:s',time())];
        $result = $this->where($where)->find();
        return $result ? true : false;
    }

    public function setAccessToken($clientId,$userId,$token,$scope,$expire){
        $this->removeAccessToken($clientId);
        $data = [
            'access_token'  =>  $token,
            'client_id' =>  $clientId,
            'user_id'   =>  $userId,
            'expires'   =>  $expire,
            'scope' =>  $scope
        ];
        return $this->save($data);
    }

    protected function removeAccessToken($clientId){
        $where['client_id'] = $clientId;
        $this->where($where)->delete();
    }

}