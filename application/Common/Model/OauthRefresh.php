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
        $data = [
            'refresh_token' => $refreshToken,
            'client_id' =>  $clientId,
            'user_id'   =>  $userId,
            'expire'    =>  date("Y-m-d H:i:s",time() + 24 * 3600),
            'scope' =>  $scope
        ];
        return $this->save($data);
    }
}