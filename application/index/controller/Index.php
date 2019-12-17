<?php
namespace app\index\controller;

use Ajax;
use think\Controller;
use think\Request;

class Index extends Controller
{
//    protected $middleware = ['Check'];
    public function index(Request $request)
    {
        $arr = $request->param();
        return Ajax::success($arr)->toJson();
    }

    //不需要验证token的测试方法
    public function test($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    
    public function noRoute(){
        $err = '访问路由不正确！';
        return Ajax::error(1,$err)->toJson();
    }
}
