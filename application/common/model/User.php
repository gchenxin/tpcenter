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
        $data = [
            'Username'  	=>	$mobile,
            'Userpassword'  	=>	$password,
	    'Mobile'		=>	$mobile,
	    'Regdate'		=>	date('Y-m-d H:i:s',time()),
        ];
	return $this->save($data);
    }
}
