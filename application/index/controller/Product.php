<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use Ajax;
class Product extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function getProductList(){Request $request}
    {
	$keywords = input('keywords');
	$className = input('className');
	$lastest = input('lastest');
	$priceRange = input('priceRange');
        try{
	    $productList = model('Product')->getProductList($keywords,$className,$lastest,$priceRange,$request->page,$request->limit);
            return Ajax::success($productList)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }
    }

    public function getProductClass(){
	try{
            $classList = model('ProductClass')->getClassList();
            return Ajax::success($classList)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }    
    }

    public function getSkuInfo($goodsId,$productId){
	try{
            $info = model('Stock')->getSkuInfo($goodsId,$productId);
            return Ajax::success($info)->toJson();
        }catch (\Exception $e){
            return Ajax::error($e->getCode(),$e->getMessage())->toJson();
        }    
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
