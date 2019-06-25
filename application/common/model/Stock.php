<?php
namespace app\common\model;

use think\Model;

class Stock extends Model{
    protected $table = 'PRD_Stock';
    public function __construct(){
    	parent::__construct();
    }

    public function getSkuInfo($goodsId,$productId){
    	$where[] = ['s.GoodsId','=',$goodsId];
	$where[] = ['s.ProductId','=',$productId];
	$where[] = ['p.isOnSale','=',1];
	$remainStock = $this->alias('s')->join('PRD_Product p','s.ProductId=p.id')
		->join('PRD_Goods g','s.GoodsId=g.id')->field('s.*,g.price')->where($where)->find();
	if($remainStock)	$remainStock = $remainStock->toArray();
	return $remainStock;
    }
}
