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

    public function disable($userId){
    	try{
            $userModId = model('User')->disable($userId,0);
            return Ajax::success($userModId)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    public function active($userId){
    	try{
            $userModId = model('User')->disable($userId,1);
            return Ajax::success($userModId)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    public function deleted($userId){
    	try{
            $userModId = model('User')->recycle($userId,1);
            return Ajax::success($userModId)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    public function recovery($userId,0){
    	try{
            $userModId = model('User')->recycle($userId,$item);
            return Ajax::success($userModId)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }
}
