<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use Ajax;

class Cartshop extends Controller {

    /**
     * 显示资源列表
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request) {
        try{
            $cartShopList = model('CartShop')->getList($request->userId);
            return Ajax::success($cartShopList)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create(Request $request) {
        try{
            $result = model('CartShop')->addItems($request->userId,$request->items);
            if(!$result){
                throwException(ERROR_PARAM);
            }
            return Ajax::success($result)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request) {
        try{
            $result = model('CartShop')->saveItems($request->cartId,$request->buyCount,$request->isSelect,$request->modify);
            if(!$result){
                throwException(ERROR_PARAM);
            }
            return Ajax::success($result)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    /**
     * 显示资源总数
     *
     * @param  int $id
     * @return \think\Response
     */
    public function getCartShopItemsCount(Request $request) {
        try{
            $cartShopList = model('CartShop')->getItemsCount($request->userId);
            return Ajax::success($cartShopList)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($cartId) {
        //
        try{
            $cartShopList = model('CartShop')->remove($cartId);
            return Ajax::success($cartShopList)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }
}
