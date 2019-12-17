<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/17
 * Time: 18:01
 */

namespace app\Common\Model;

use think\Model;
class OauthRefresh extends Model
{
    protected $table = 'oauth_refresh_tokens';

    public function __construct($data = [])
    {
        parent::__construct($data);
    }

    public function setRefreshToken($clientId,$userId,$refreshToken,$scope){
        //暂不启用refresh token
        return true;
        $this->removeRefreshToken($clientId);
        $data = [
            'refresh_token' => $refreshToken,
            'client_id' =>  $clientId,
            'user_id'   =>  $userId,
            'expire'    =>  date("Y-m-d H:i:s",time() + 24 * 3600),
            'scope' =>  $scope
        ];
        return $this->save($data);
    }

    public function removeRefreshToken($clientId){
        $where['client_id'] = $clientId;
        $this->where($where)->delete();
    }

    public function check($refresh,$clientId,$clientKey){
        $where['rt.refresh_token'] = $refresh;
        $where['rt.client_id'] = $clientId;
        $where['c.client_secret'] = $clientKey;
        $result = $this->alias('rt')->join('oauth_clients c','rt.client_id=c.client_id')->where($where)->find();
        return $result ? true : false;
    }
}