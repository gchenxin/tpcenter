<?php
namespace app\common\logic;

use think\Loader;

class EncryptRSA
{
    private $isOpen;
    private $publicKey;
    private $privateKey;

    public function __construct(){
        $this->isOpen = config('auth.rsa_encrypt');
        $privateKeyPath = config('auth.rsa_private_path');
        $publicKeyPath = config('auth.rsa_public_path');
        $rootPath = Loader::getRootPath();
        $this->publicKey = str_replace("\\",'/',$rootPath . "application\\" . $publicKeyPath);
        $this->privateKey = str_replace("\\",'/',$rootPath . "application\\" . $privateKeyPath);
    }

    /**
     * RSA非对称解密 客户端参数密文要进行urlencode操作
     * @param $encryptData
     * @return bool
     */
    public function decrypt($encryptData){
        if($this->isOpen){
            //加载openssl扩展
            if(!extension_loaded('openssl')){
                return false;
            }
            $encryptData = base64_decode($encryptData);
            $privateKey = openssl_pkey_get_private(file_get_contents($this->privateKey));
            if(!$privateKey)
                return false;
            //用私钥解密
            $decryptData = '';
            if (!openssl_private_decrypt($encryptData, $decryptData, $privateKey)) {
                return false;
            }
            return $decryptData;
        }else{
            return $encryptData;
        }
    }

    /**
     * 私钥加密，客户端公钥加密
     * @param $data
     * @return bool
     */
    public function encrypt($data){
        if($this->isOpen){
            //加载openssl扩展
            if(!extension_loaded('openssl')){
                return false;
            }
            $publicKey = openssl_pkey_get_public(file_get_contents($this->publicKey));
            $data = json_encode($data);
            if(!$publicKey)
                return false;
            //用公钥加密
            $encryptData = '';
            if (!openssl_public_encrypt($data, $encryptData, $publicKey)) {
                return false;
            }
            return base64_encode($encryptData);
        }else{
            return $data;
        }
    }
}