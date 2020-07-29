<?php


namespace TIMUtil\service;


use TIMUtil\msg\MsgBuilder;
use TIMUtil\TIMUtil;

/**
 * 单聊消息
 * Class OpenIM
 * @package TIMUtil\service
 */
class OpenIM extends TIMUtil
{
    const SERVICE_NAME = 'openim';

    /**
     * 单发单聊消息
     * @param MsgBuilder $builder
     * @return bool|mixed
     */
    public function sendMsg(MsgBuilder $builder)
    {
        try{
            $data = $builder->build();
        }catch (\Exception $e){
            $this->errCode = $e->getCode();
            $this->errMsg = $e->getMessage();
            return false;
        }
        return $this->postData(self::SERVICE_NAME,'sendmsg',$data);
    }

    /**
     * 批量发单聊消息
     * @param MsgBuilder $builder
     * @return bool|mixed
     */
    public function batchSendMsg(MsgBuilder $builder)
    {
        try{
            $data = $builder->build();
        }catch (\Exception $e){
            $this->errCode = $e->getCode();
            $this->errMsg = $e->getMessage();
            return false;
        }
        return $this->postData(self::SERVICE_NAME,'batchsendmsg',$data);
    }

    /**
     * 导入单聊消息
     * @param $data
     * 消息内容，手动生成，暂不提供builder,批量占用内存大
     * @return bool|mixed
     */
    public function importMsg($data)
    {
        return $this->postData(self::SERVICE_NAME,'importmsg',$data);
    }

    /**
     * 查询单聊消息
     * @param $from_account
     * 会话其中一方的 UserID，若已指定发送消息方帐号，则为消息发送方
     * @param $to_account
     * 会话其中一方的 UserID
     * @param $max_cnt
     * 请求的消息条数
     * @param $min_time
     * 请求的消息时间范围的最小值
     * @param $max_time
     * 请求的消息时间范围的最大值
     * @param string $last_msg_key
     * 上一次拉取到的最后一条消息的 MsgKey，续拉时需要填该字段
     * @return bool|mixed
     */
    public function adminGetroammsg($from_account,$to_account,$max_cnt,$min_time,$max_time,$last_msg_key = '')
    {
        $data = [
            'From_Account'=>$from_account,
            'To_Account'=>$to_account,
            'MaxCnt'=>$max_cnt,
            'MinTime'=>$min_time,
            'MaxTime'=>$max_time,
        ];
        if(!empty($last_msg_key)){
            $data['LastMsgKey'] = $last_msg_key;
        }
        return $this->postData(self::SERVICE_NAME,'admin_getroammsg',$data);
    }

    /**
     * 撤回单聊消息
     * @param $from_account
     * 消息发送方 UserID
     * @param $to_account
     * 消息接收方 UserID
     * @param $msg_key
     * 待撤回消息的唯一标识。该字段由 REST API 接口 单发单聊消息 和 批量发单聊消息 返回
     * @return bool|mixed
     */
    public function adminMsgwithdraw($from_account,$to_account,$msg_key)
    {
        $data = [
            'From_Account'=>$from_account,
            'To_Account'=>$to_account,
            'MsgKey'=>$msg_key
        ];
        return $this->postData(self::SERVICE_NAME,'admin_msgwithdraw',$data);
    }
}