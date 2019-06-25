<?php

namespace app\common\model;

use think\Model;

class Product extends Model
{
    protected $table = 'PRD_Product';

    public function __construct($data = []) {
        parent::__construct($data);
    }

    public function checkProduct($productId){
        return $this->get($productId);
    }

    public function getProductInfo($pId){
        return $this->get($pId);
    }

    public function addItem($item){
        //
    }

    public function getProductProperty($productId){
	$productInfo = $this->getProductInfo($productId);
	$property = json_decode($productInfo['props'],true);
	return $property;
    }

    public function getProductList($keywords,$classId,$lastest,$orderBy,$priceRange,$page,$limit){
	$whereStr = '1=1';
    	if($keywords){
		$whereStr .= " and ((p.ProductName like '%{$keywords}%') or (p.ProductNo like '%{$keywords}%') or (pc.ClassName like '%{$keywords}%')";
	}
	if($classId){
		$where[] = ['classId','=',$classId];
	}
	if($lastest){
		$where[] = ['p.update_time','>=',new Expression("date_add(now(), interval -1 month)")];
	}
	if($priceRange){
		$priceArr = explode('-',$priceRange);
		if(!empty($priceArr[0]))	$whereStr .= ' and (price>=' . $priceArr[0] . ')';
		if(!empty($priceArr[1]))	$whereStr .= ' and (price<' . $priceArr[1] . ')';
	}
	$where[] = ['Disabled','=',1];
	$where[] = ['Deleted','=',0];
	$where[] = ['isOnSale','=',1];
	$sort = 'order';
	if($orderBy)	$sort = $orderBy . ',' . $sort;
	$list = $this->alias('p')->join('PRD_Class c','p.classId=c.Id')->where($where)->whereStr($whereStr)->fields('p.*,c.className')->order($sort)->paginate();
	return $list;
    }
}
