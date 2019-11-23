<?php
namespace app\common\logic;

use think\Loader;

class EncryptRSA
{
    private $isOpen;
    private $privateKey;

    public function __construct(){
        $this->isOpen = config('auth.rsa_encrypt');
        $privateKeyPath = config('auth.rsa_cert_path');
        $rootPath = Loader::getRootPath();
        $this->privateKey = str_replace("\\",'/',$rootPath . "application\\" . $privateKeyPath);
    }

    /**
     * RSA非对称解密
     * @param $encryptData
     * @param $decryptData
     * @return bool
     */
    public function decrypt($encryptData){
        if($this->isOpen){
            //加载openssl扩展
            if(extension_loaded('openssl')){
                return false;
            }
            $privateKey = openssl_pkey_get_private(file_get_contents($this->privateKey));
            if(!$privateKey)
                return false;
            //用私钥解密
            if (!openssl_public_decrypt($encryptData, $decryptData, $privateKey)) {
                return false;
            }
            return $decryptData;
        }else{
            return $encryptData;
        }
    }

    /**
     * 私钥加密，客户端公钥解密
     * @param $data
     * @return bool
     */
    public function encrypt($data){
        if($this->isOpen){
            //加载openssl扩展
            if(extension_loaded('openssl')){
                return false;
            }
            $privateKey = openssl_pkey_get_private(file_get_contents($this->privateKey));
            if(!$privateKey)
                return false;
            //用私钥加密
            $encryptData = '';
            if (!openssl_private_encrypt($data, $encryptData, $privateKey)) {
                return false;
            }
            return $encryptData;
        }else{
            return $data;
        }
    }
}