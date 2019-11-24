<?php
namespace app\index\controller;

use Ajax;
use think\Controller;

class Index extends Controller
{
//    protected $middleware = ['Check'];
    public function index()
    {
        $arr = [];
        return Ajax::success($arr)->toJson();
    }

    //不需要验证token的测试方法
    public function test($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
