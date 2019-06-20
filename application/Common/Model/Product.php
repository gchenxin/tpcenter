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
}
