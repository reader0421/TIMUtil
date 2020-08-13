<?php


namespace TIMUtil\service;


use TIMUtil\TIMUtil;

/**
 * 账号管理
 * Class Account
 * @package TIMUtil\service
 */
class Account extends TIMUtil
{
    const SERVICE_NAME = 'im_open_login_svc';

    /**
     * 导入单个账号
     * 200次/秒
     * @param $identifier
     * 用户名，长度不超过32字节
     * @param string $nick
     * 	用户昵称
     * @param string $faceUrl
     * 用户头像 URL
     * @return bool|mixed
     */
    public function accountImport(string $identifier,$nick='',$faceUrl='')
    {
        $data = [
            'Identifier'=>$identifier,
            'Nick'=>$nick,
            'FaceUrl'=>$faceUrl
        ];
        return $this->postData(self::SERVICE_NAME,'account_import',$data);
    }

    /**
     * 导入多个账号
     * 100次/秒
     * @param array $accounts
     * 用户名，单个用户名长度不超过32字节，单次最多导入100个用户名
     * @return bool|mixed
     */
    public function multiAccountImport(array $accounts)
    {
        $data = ['Accounts'=>$accounts];
        return $this->postData(self::SERVICE_NAMEm,'multiaccount_import',$data);
    }

    /**
     * 删除账号
     * 100次/秒
     * @param array $user_ids
     * 请求删除的帐号的UserID数组，单次请求最多支持100个帐号
     * @return bool|mixed
     */
    public function accountDelete(array $user_ids)
    {
        $data = [];
        foreach ($user_ids as $v){
            $arr = ['UserID'=>$v];
            $data['DeleteItem'][] = $arr;
        }
        return $this->postData(self::SERVICE_NAME,'account_delete',$data);
    }

    /**
     * 查询账号
     * 100次/秒
     * @param array $user_ids
     * 请求检查的帐号的UserID数组，单次请求最多支持100个帐号
     * @return bool|mixed
     */
    public function accountCheck(array $user_ids)
    {
        $data = [];
        foreach ($user_ids as $v){
            $arr = ['UserID'=>$v];
            $data['CheckItem'][] = $arr;
        }
        return $this->postData(self::SERVICE_NAME,'account_check',$data);
    }

    /**
     * 失效账号登录态
     * 200次/秒
     * @param $user_id
     * 	用户名
     * @return bool|mixed
     */
    public function kick($user_id)
    {
        $data = ['Identifier'=>$user_id];
        return $this->postData(self::SERVICE_NAME,'kick',$data);
    }

    /**
     * 查询账号在线状态
     * 200次/秒
     * @param array $user_ids
     * 需要查询这些 UserID 的登录状态，一次最多查询500个 UserID 的状态
     * @param int $is_need_detail
     * 是否需要返回详细的登录平台信息。0表示不需要，1表示需要
     * @return bool|mixed
     */
    public function queryState(array $user_ids,$is_need_detail = 0)
    {
        $data = [
            'To_Account'=>$user_ids,
            'IsNeedDetail'=>$is_need_detail
        ];
        return $this->postData('openim','querystate',$data);
    }

}