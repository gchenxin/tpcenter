<?php

namespace app\common\model;

use think\Model;
class User extends Model
{
    protected $table = 'USR_User';
    public function __construct($data = []) {
        parent::__construct($data);
	$this->autoWriteTimestamp = false;
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

    public function getUserFieldsByMobile($mobile){
    	$where['Mobile'] = $mobile;
	return $this->where($where)->find();
    }

    public function getUserFields($userId, $field = '*'){
	$result = $this->field($field)->get($userId);
	if($result) $result = $result->toArray();
	return $result;
    }

    public function modifyItem($userId,$item){
    	$item = json_decode($item,true);
	$userInfo = $this->getUserFields($userId,'id,Username,Usersex,Useremail,Realname');
	if(!$userInfo){
		throwException(ERROE_PARAM);
	}
	$userInfo = array_merge($userInfo,$item);
	return $this->allowField('Username,Usersex,Useremail,Realname')->isUpdate(true)->save($userInfo);
    }

    public function authorize($userId,$password){
    	$userInfo = $this->getUserFields($userId);
    	if(!$userInfo){
		throwException(ERROR_PARAM);
	}elseif(!password_verify($password,$userInfo['Userpassword'])){
		throwException(ERROR_VERIFY);
	}else{
		return true;
	}
    }

    public function getUserInfo($userId){
    	return $this->get($userId);
    }

    public function setPassword($userId,$password,$newPassword){
	$userInfo = $this->getUserInfo($userId);
	if(!$userInfo)	throwException(ERROR_PARAM);
	elseif(!password_verify($password,$userInfo->Userpassword)) throwException(ERROR_VERIFY);
	$userInfo->Userpassword = password_hash(substr(md5($password),10,15),PASSWORD_BCRYPT);
	return $userInfo->save();
    }

    public function disable($userId,$value){
    	$userInfo = $this->getUserInfo($userId);
	if($userInfo){
		$userInfo->Disabled = $value;
		return $userInfo->save();
	}
	throwException(ERROR_PARAM);
    }
    
    public function recycle($userId,$value){
    	$userInfo = $this->getUserInfo($userId);
	if($userInfo){
		$userInfo->Deleted = $value;
		return $userInfo->save();
	}
	throwException(ERROR_PARAM);
    }
}
