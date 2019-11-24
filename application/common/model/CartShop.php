<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/19
 * Time: 9:19
 */

namespace app\Common\Model;

use think\Model;
class CartShop extends Model {
    protected $table = 'TRD_CartShop';

    public function __construct($data = []) {
        parent::__construct($data);
    }

    public function getList($userId){
        $where['userId'] = $userId;
        $list = $this->where($where)->select();
        return $list;
    }

    public function addItems($userId,$items){
        $IfUserExists = model('User')->checkUser($userId);
        $items = json_decode($items,true);
        if(!$items || !$IfUserExists){
            throwException(ERROR_PARAM);
        }
        $addData = [];
        $update = [];
        foreach($items as $item){
            if(!(model('Goods')->checkGoods($item['GoodsId'])) || !(model('Product')->checkProduct($item['ProductId']))){
                throwException(ERROR_PARAM);
            }
            $where['userId'] = $userId;
            $where['ProductId'] = $item['ProductId'];
            $where['GoodsId'] = $item['GoodsId'];
            $where['Props'] = $item['Props'];
            $cartInfo = $this->where($where)->find();
            if(!$cartInfo){
                $addData[] = [
                    'UserId'    =>  $userId,
                    'ProductId' =>  $item['ProductId'],
                    'GoodsId' =>  $item['GoodsId'],
                    'BuyCount' =>  $item['BuyCount'],
                    'isSelect' =>  $item['isSelect'],
                    'Props' =>  $item['Props']
                ];
            }else{
                $update[] = [
                    'id'    =>  $cartInfo['id'],
                    'BuyCount'  =>  $cartInfo['BuyCount'] + $item['BuyCount']
                ];
            }

        }
        if($addData){
            $result = $this->saveAll($addData);
        }
        if($update){
            $result = $this->saveAll($update);
        }
        return $result ? true : false;

    }

    public function getItemsCount($userId){
        $where['userId'] = $userId;
        $list =  $this->where($where)->value('SUM(BuyCount) BuyCount');
        return $list;
    }

    /**
	* @Brand
	*
	* @param $cartId
	* @param $buyCount
	* @param $isSelect
	* @param $modify 商品数量增加/设置为某值
	*
	* @return 
     */
    public function saveItems($cartId,$buyCount,$isSelect,$modify){
        $cartInfo = $this->get($cartId);
        if(!$cartInfo){
            throwException(ERROR_PARAM);
        }
        if(!$buyCount && !$isSelect) throwException(ERROR_PARAM);
        if($buyCount){
            if($modify) {
                $cartInfo->BuyCount += $buyCount;
            }else{
                $cartInfo->BuyCount = $buyCount;
            }
        }
        if($isSelect) $cartInfo->isSelect = $isSelect;
        return $cartInfo->save();
    }

    public function remove($cartId){
        return $this->destroy($cartId);
    }

    public function clear($userId){
	return $this->where('userId',$userId)->delete();
    }
}
