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
	$client = new \Swoole\Client(SWOOLE_SOCK_TCP);
	if (!$client->connect('127.0.0.1', 9005, -1))
	{
	    exit("connect failed. Error: {$client->errCode}\n");
	}
	$client->send("hello world\n");
	echo $client->recv();
	$client->close();
    }

    //不需要验证token的测试方法
    public function test($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
