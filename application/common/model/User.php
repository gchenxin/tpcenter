<?php

namespace app\common\model;

use think\Model;
class User extends Model
{
    protected $table = 'USR_User';
    public function __construct($data = []) {
        parent::__construct($data);
    }

    public function checkUser($userId){
        return $this->get($userId);
    }

    public function addItem($mobile,$password){
	$password = password_hash(substr(md5($password),10,15),PASSWORD_BCRYPT);
        $data = [
            'Username'  	=>	$mobile,
            'Userpassword'  	=>	$password,
	    'Mobile'		=>	$mobile,
	    'Regdate'		=>	date('Y-m-d H:i:s',time()),
        ];
	if($this->getUserInfoByMobile($mobile)){
		throwException(ERROR_PARAM);
	}
	return $this->save($data);
    }

    public function getUserInfoByMobile($mobile){
    	$where['Mobile'] = $mobile;
	return $this->where($where)->find();
    }

    public function getUserInfo($userId, $field = '*'){
	    return $this->field($field)->get($userId);
    }

    public function modifyItem($userId,$item){
    	$item = json_decode($item,true);
	$userInfo = $this->getUserInfo($userId);
	if(!$userInfo){
		throwException(ERROE_PARAM);
	}
	$userInfo = array_merge($userInfo,$item);
	return $userInfo;
    }
}
