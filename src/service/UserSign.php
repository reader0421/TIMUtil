<?php


namespace TIMUtil\service;


use Tencent\TLSSigAPIv2;

class UserSign
{
    protected $TLSSigAPI;

    public function __construct($app_id,$app_secret)
    {
        $this->TLSSigAPI = new TLSSigAPIv2($app_id,$app_secret);
    }

    /**
     * 生成签名
     *
     * @param $identifier
     * 用户账号
     * @param int $expire 过期时间，单位秒，默认 180 天
     * @return string 签名字符串
     * @throws \Exception
     */
    public function genSign($identifier,$expire = 86400*180)
    {
        return $this->TLSSigAPI->genSig($identifier,$expire);
    }

    /**
     * 带 userbuf 生成签名。
     * @param $identifier
     * 用户账号
     * @param int $expire 过期时间，单位秒，默认 180 天
     * @param string $userbuf 用户数据
     * @return string 签名字符串
     * @throws \Exception
     */
    public function genSigWithUserBuf($identifier, $expire, $userbuf)
    {
        return $this->TLSSigAPI->genSigWithUserBuf($identifier,$expire,$userbuf);
    }

    /**
     * 带 userbuf 验证签名。
     *
     * @param string $sig 签名内容
     * @param string $identifier 需要验证用户名，utf-8 编码
     * @param int $init_time 返回的生成时间，unix 时间戳
     * @param int $expire_time 返回的有效期，单位秒
     * @param string $error_msg 失败时的错误信息
     * @return boolean 验证是否成功
     * @throws \Exception
     */
    public function verifySig($sig, $identifier, &$init_time, &$expire_time, &$error_msg)
    {
        return $this->TLSSigAPI->verifySig($sig, $identifier, $init_time, $expire_time, $error_msg);
    }

    /**
     * 验证签名
     * @param string $sig 签名内容
     * @param string $identifier 需要验证用户名，utf-8 编码
     * @param int $init_time 返回的生成时间，unix 时间戳
     * @param int $expire_time 返回的有效期，单位秒
     * @param string $userbuf 返回的用户数据
     * @param string $error_msg 失败时的错误信息
     * @return boolean 验证是否成功
     * @throws \Exception
     */
    public function verifySigWithUserBuf($sig, $identifier, &$init_time, &$expire_time, &$userbuf, &$error_msg)
    {
        return $this->TLSSigAPI->verifySigWithUserBuf($sig, $identifier, $init_time, $expire_time, $userbuf, $error_msg);
    }
    
}