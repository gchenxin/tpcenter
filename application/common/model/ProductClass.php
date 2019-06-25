<?php

namespace app\common\model;

use think\Model;

class ProductClass extends Model{
	protected $table = "PRD_Class";

	public function __construct(){
		parent::__construct();
		$this->autoWriteTimestamp = false;
	}

	public function getClassList(){
		$list = $this->select();
		$list = $this->generateTreeStruct($list);
		return $list;
	}

	public function generateTreeStruct($data,$child = 'child'){
		$list = array_combine(array_column($data,'id'),$data);
		$dataReference = [];
		foreach($list as $key=>$value){
			$value = $value->toArray();
			$parentId = $value['Parentid'];
			if(!$parentId){
				if(!isset($dataReference[$value['id']])){
					$dataReference[$value['id']] = &$list[$key];
				}
				continue;
			}else{
				if(isset($dataReference[$parentId])){
					if(!isset($dataReference[$parentId][$child][$value['id']])){
						$dataReference[$parentId][$child][$valaue['id']] = &$list[$key];
					}
				}
			}
		}
		return $dataReference;
	}
}
	
