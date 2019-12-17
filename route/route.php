<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//Route::get('think', function () {
//    return 'hello,ThinkPHP5!';
//});

//variable global pattern
Route::pattern([
    'name' => '\w+',
    'id'    => '\d+'
]);

//Route Dynamic
//Route::rule('hello/:name/:id', 'index/:name/index','GET');

//Route group
Route::group('api', function(){
    Route::rule('getCode', 'index/Oauthtoken/getAccessToken');
//    Route::rule('refreshToken', 'index/Oauthtoken/refreshToken');
    Route::rule('test', 'index/index/index');
})->ext('html')->method('get|post');

//miss路由
Route::miss('index/index/noRoute');
return [

];
