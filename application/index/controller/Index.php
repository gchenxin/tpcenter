<?php
namespace app\index\controller;

use Ajax;
use think\App;
use think\Controller;

class Index extends Controller
{
//    protected $middleware = ['Check'];
    public function index()
    {
        return Ajax::success()->toJson();
    }

    //不需要验证token的测试方法
    public function test($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
