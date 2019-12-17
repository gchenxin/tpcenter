<?php
namespace app\common\logic;

use think\Loader;

class EncryptRSA
{
    private $isOpenEncrypt;
    private $isOpenDecrypt;
    private $publicKey;
    private $privateKey;

    public function __construct(){
        $this->isOpenEncrypt = config('auth.rsa_encrypt');
        $this->isOpenDecrypt = config('auth.rsa_client_mode');
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
        if($this->isOpenDecrypt){
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
            return substr(str_replace('\\','',$decryptData),1,-1);
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
        if($this->isOpenEncrypt){
            //
            $uri = lcfirst(request()->module()) . '/' . lcfirst(request()->controller(true)). '/' . lcfirst(request()->action(true));
            $encryptIgnore = config('auth.rsa_encrypt_ignore');
            if(in_array($uri, $encryptIgnore)){
                return $data;
            }
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

    /**
     * 生成证书
     * @return bool
     */
    public function exportOpenSSLFile(){
        $config = array(
            "digest_alg"    => "sha512",
            "private_key_bits" => 4096,           //字节数  512 1024 2048  4096 等
            "private_key_type" => OPENSSL_KEYTYPE_RSA,   //加密类型
        );
        $res = openssl_pkey_new($config);
        if($res == false){
            $config['config'] = "D:/xampp/apache/conf/openssl.cnf";
            $res = openssl_pkey_new($config);
        }
        openssl_pkey_export($res, $private_key, null, $config);
        $public_key = openssl_pkey_get_details($res);
        $public_key = $public_key["key"];
        $rootPath = Loader::getRootPath();
        file_put_contents($rootPath."/application/Cert/rsa_public_key.pem",$public_key);
        file_put_contents($rootPath."/application/Cert/rsa_private_key.pem",$private_key);
        openssl_free_key($res);
    }
}