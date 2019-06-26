<?php
namespace app\common\model;

use think\Model;

class SysArea extends Model{
    protected $table='SYS_Area';

    public function __construct(){
    	parent::__construct();
    }

    public function getWholeDistrict($areaId){
	$where['a.zip_code'] = $areaId;
	$info = $this->alias('a')->join('SYS_Area c','a.pid=c.id')->join('SYS_Area p','c.pid=p.id')
		->field('p.zip_code pCode,p.name pName,p.first,c.zip_code cCode,c.name cName,a.zip_code aCode,a.name aName')->find();
	if($info)	$info = $info->toArray();
	return $info;
    }
}
