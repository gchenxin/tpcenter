<?php

namespace app\common\model;

use think\Model;

class Goods extends Model
{
    protected $table = 'PRD_Goods';

    public function __construct($data = []) {
        parent::__construct($data);
    }

    public function checkGoods($goodsId){
        return $this->get($goodsId);
    }

    public function getSkuInfo($goodsId){
        return $this->get($goodsId);
    }
     
}
