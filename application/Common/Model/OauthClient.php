<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/17
 * Time: 14:09
 */

namespace app\Common\Model;

use think\Model;

class OauthClient extends Model
{
    protected $table = 'oauth_clients';

    public function __construct($data = [])
    {
        parent::__construct($data);
    }

    public function checkClient($clientId,$clientKey){
        if(!$clientId || !$clientKey) return null;
        $where['client_id'] = $clientId;
        $where['client_secret'] = $clientKey;
        $where['status'] = 1;
        $ifExists = $this->where($where)->find();
        return $ifExists;
    }
}