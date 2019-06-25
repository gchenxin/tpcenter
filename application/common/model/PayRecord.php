<?php
namespace app\common\model;

use think\Model;

class PayRecord extends Model{
    protected $table = 'TRD_PayRecord';

    public function __construct(){
    	parent::__construct();
    }
}
