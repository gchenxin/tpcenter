<?php
namespace app\common\model;

use think\Model;

class Order extends Model{
    protected $table = 'TRD_Order';
    public function __construct(){
    	parent::__construct();
    }

    public function payNotify($orderId,$payMent,$payMoney){
    	//支付回调1.检查订单金额 2.写流水数据 3.修改订单支付状态 4.写订单日志
	$orderInfo = $this->getOrderInfo($orderInfo);
	if($payMoney >= $orderInfo['OrderFee']){
		
	}
    }
    
    public function getOrderInfo($orderId){
    	$where['id'] = $orderId;
	$result = $this->where($where)->find();
	if($result) $result = $result->toArray();
	return $result;
    }

    public function addOrder($orderData){
	$orderData = json_decode($orderData,true);
				
    }
}
