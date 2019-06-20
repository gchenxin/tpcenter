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

    public function addItems($mobile,$password){
        $data = [
            'Username'  =>  $mobile,
            'Userpassword'  =>
        ];
    }
}
