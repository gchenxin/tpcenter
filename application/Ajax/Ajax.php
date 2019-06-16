<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/15
 * Time: 14:49
 */

namespace app\Ajax;

class Ajax{

    public $status;
    public $message;
    public $data;
    public $total;
    public $perPage;
    public $current;
    public $last;

    public function __construct(){
        $this->status = 0;
        $this->message = '执行成功！';
        $this->data = [];
        $this->total = 0;
        $this->perPage = 0;
        $this->current = 1;
        $this->last = 1;

    }

    public function success($data=[],$message=''){
        $this->data = empty($data) ? $this->data : $data;
        $this->message = empty($message) ? $this->message : $message;
        return $this;
    }

    public function error($code = 1,$message = '操作失败！'){
        $this->status = empty($code) ? $this->status : $code;
        $this->message = empty($message) ? $this->message : $message;
        return $this;
    }

    public function toJson(){
        return json($this);
    }

}