<?php
namespace app\common\logic;

class Redis{
    public static $connection;
    public static $config;
    public function __construct(){
    	if(!self::$connection || (self::$connection->ping() != '+PONG')){
	    if(!self::$config){
		self::$config = config('cache.tash_cache');
		self::$connection = new \Redis();
		self::$connection->connect(self::$config['host'], self::$connection['port']);
		self::$connection->auth(self::$config['password']);
	    }
	}
    }

    public function get($name){
	return self::$connection->get($name);
    }

    public function set($key,$value){
	return self::$connection->set($key,$value);
    }

    public function delete($name){
	return self::$connection->delete($name);
    }
}
