<?php

namespace app\common\model;

use think\Model;

class Product extends Model
{
    protected $table = 'PRD_Product';

    public function __construct($data = []) {
        parent::__construct($data);
    }

    public function checkGoods($productId){
        return $this->get($productId);
    }
}
