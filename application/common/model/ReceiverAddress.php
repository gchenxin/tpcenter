<?php
namespace app\common\model;

use think\Model;

class ReceiveAddress extends Model{
    protected $table='ReceiveAddress';
    
    public function __construct(){
    	parent::__construct();
    }

    public function getAddressInfo($aId){
    	$where['id'] = $aid;
	$info = $this->alias('ra')->join('SYS_Area p','ra.ProvinceId=p.id')
		->join('SYS_Area c','c.id=ra.CityId')
		->join('SYS_Area a','a.id=ra.AreaId')->field('ra.*,p.name pName,c.name cName,a.name aName')->find();
	if($info)	$info = $info->toArray();
	return $info;
    }

    public function addAddress($userId,$addrData){
	$addrData = json_decode($addrData,true);
	Db::startTrans();
	if($addrData['isDefault']){
	    $this->where(['Userid'=>$userId])->update(['isDefault'=>0]);
	}
	$data = [
		'Name'	=>	$addData['name'],
		'Tel'	=>	$addData['tel'],
		'Mobile'=>	$addData['mobile'],
		'ProvinceId'	=>	$addData['provinceId'],
		'CityId'	=>	$addData['cityId'],
		'AreaId'	=>	$addData['areaId'],
		'Address'	=>	$addData['address'],
		'PostCode'	=>	$addData['post'],
		'Userid'	=>	$addData['userId'],
		'isDefault'	=>	$addData['isDefault']
	];
	$result = $this->save($data);
	if(!$result){
	    Db::rollback();
	    throwException(ERROR_FAIL);
	}
	Db::commit();
	return $result;
    }
}
