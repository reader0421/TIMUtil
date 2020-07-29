<?php


namespace TIMUtil\service;


use TIMUtil\TIMUtil;

class OpenConfigSvr extends TIMUtil
{
    const SERVICE_NAME = 'openconfigsvr';

    /**
     * 设置全局禁言
     * @param $setAccount
     * 设置禁言配置的帐号
     * @param int $C2CMsgNoSpeakingTime
     * 单聊消息禁言时间，单位为秒，非负整数，最大值为4294967295（十六进制 0xFFFFFFFF）
     * 0表示取消该帐号的单聊消息禁言
     * 4294967295表示该帐号被设置永久禁言
     * 其它值表示该帐号具体的禁言时间
     * @param int $groupMsgNoSpeakingTime
     * @return bool|mixed
     */
    public function setNoSpeaking($setAccount,$C2CMsgNoSpeakingTime = 4294967295,$groupMsgNoSpeakingTime = 4294967295)
    {
        $data = [
            'Set_Account'=>$setAccount,
            'C2CmsgNospeakingTime'=>$C2CMsgNoSpeakingTime,
            'GroupmsgNospeakingTime'=>$groupMsgNoSpeakingTime
        ];
        return $this->postData(self::SERVICE_NAME,'setnospeaking',$data);
    }

    /**
     * 查询全局禁言
     * @param $getAccount
     * 查询禁言信息的帐号
     * @return bool|mixed
     */
    public function getNoSpeaking($getAccount)
    {
        $data = [
            'Get_Account'=>$getAccount
        ];
        return $this->postData(self::SERVICE_NAME,'getnospeaking',$data);
    }
}