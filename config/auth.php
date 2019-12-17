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
    'inter_auth'    =>  false,
    //不需要认证的接口列表，只有在开启了接口认证才有用,控制器命名全小写
    'ignore_list'   =>  [
        'index/index/index',
        'index/oauthtoken/getAccessToken',
        'index/index/noRoute'
//        'index/oauthtoken/refreshToken',
    ],
    //认证控制器,需要在middleware中注册中间件别名
    'auth_middleware'   =>  'Auth',
    //跨域处理,允许访问的地址列表
    'allow_origin'  =>  [
        'http://src.com:9002',
        'http://127.0.0.1:8020',
        'http://cfree.com'
    ],
    //是否开启非对称加密
    'rsa_encrypt' => false,
    //客户端是否开启加密模式
    'rsa_client_mode' => false,
    'rsa_public_path' => 'Cert/rsa_public_key.pem',
    'rsa_private_path' => 'Cert/rsa_private_key.pem',
    //不需要加密的接口
    'rsa_encrypt_ignore' => [
//        'index/index/index'
    ],
];