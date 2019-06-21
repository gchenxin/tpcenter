<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/20
 * Time: 17:01
 */
namespace app\index\controller;

use think\Controller;
use Ajax;
/**
 * @brief 
 */
class User extends Controller{

	/**
	 * @brief 
	 *
	 * @param $mobile
	 * @param $password
	 *
	 * @return 
	 */
    public function create($mobile,$password){
        try{
            $userIntId = model('User')->addItem($mobile,$password);
            return Ajax::success($userIntId)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    public function modify($userId,$item){
    	try{
            $userIntId = model('User')->modifyItem($mobile,$item);
            return Ajax::success($userIntId)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }
}
