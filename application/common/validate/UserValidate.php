<?php
namespace app\common\validate;

use think\Validate;

class UserValidate extends Validate{
	protected $rules = [
		'Username'	=>	'unique:USR_User|require',
		'Useremail'	=>	'email',
		'Mobile'	=>	'unique:USR_User|require'
	];
	protected $failException = true;

	protected $message = [
		'Username.unique'	=>	'用户名已存在',
		'Username.require'	=>	'用户名不i能为空',
		'Useremail.email'	=>	'邮箱格式错误',
		'Mobile.require'	=>	'手机号不能为空',
		'Mobile.unique'		=>	'手机号已被注册'
	];
}
