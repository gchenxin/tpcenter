<?php
namespace app\common\model;

use think\Model;

class OrderItem extends Model{
    protected $table = 'TRD_OrderItem';

    public function __construct(){
    	parent::__construct();
    }
}
