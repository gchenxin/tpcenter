<?php
namespace app\common\model;

use think\Model;

class OrderLog extends Model{
    protected $table = 'TRD_OrderLog';

    public function __construct(){
    	parent::__construct();
    }
}
