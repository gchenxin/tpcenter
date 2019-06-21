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
            $userModId = model('User')->modifyItem($userId,$item);
            return Ajax::success($userModId)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }
}
