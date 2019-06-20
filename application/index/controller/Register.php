<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/20
 * Time: 17:01
 */
namespace app\index\controller;

use think\Controller;

class Register extends Controller{

    public function create($mobile,$password){
        try{
            $userIntId = model('User')->addItem($mobile,$password);
            return Ajax::success($userIntId)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }
}