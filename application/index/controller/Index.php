<?php
namespace app\index\controller;

use Ajax;
use think\App;
use think\Controller;

class Index extends Controller
{

    public function index()
    {
        return Ajax::success()->toJson();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
