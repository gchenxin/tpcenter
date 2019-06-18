<?php
/**
 * Created by PhpStorm.
 * User: chenxin
 * Date: 2019/6/16
 * Time: 16:33
 */

// +----------------------------------------------------------------------
// | 接口认证设置
// +----------------------------------------------------------------------

return [
    //是否开启接口的token认证
    'inter_auth'    =>  true,
    //不需要认证的接口列表，只有在开启了接口认证才有用,控制器命名全小写
    'ignore_list'   =>  [
//        'index/index/index',
        'index/oauthtoken/getAccessToken',
        'index/oauthtoken/refreshToken',
    ],
    //认证控制器,需要在middleware中注册中间件别名
    'auth_middleware'   =>  'Auth',
    //跨域处理,允许访问的地址列表
    'allow_origin'  =>  [
        'http://src.com:9002'
    ],
];