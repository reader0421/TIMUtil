<?php


namespace TIMUtil\service;


use TIMUtil\TIMUtil;

class Operation extends TIMUtil
{
    /**
     * 拉取运营数据
     * @param array $requestFiled
     * 该字段用来指定需要拉取的运营数据，不填默认拉取所有字段。详细可参阅下文可拉取的运营字段
     * AppName	应用名称
     * AppId	应用 SDKAppID
     * Company	所属客户名称
     * ActiveUserNum	活跃用户数
     * RegistUserNumOneDay	新增注册人数
     * RegistUserNumTotal	累计注册人数
     * LoginTimes	登录次数
     * LoginUserNum	登录人数
     * UpMsgNum	上行消息数
     * SendMsgUserNum	发消息人数
     * APNSMsgNum	APNs 推送数
     * C2CUpMsgNum	上行消息数（C2C）
     * C2CSendMsgUserNum	发消息人数（C2C）
     * C2CAPNSMsgNum	APNs 推送数（C2C）
     * MaxOnlineNum	最高在线人数
     * ChainIncrease	关系链对数增加量
     * ChainDecrease	关系链对数删除量
     * GroupUpMsgNum	上行消息数（群）
     * GroupSendMsgUserNum	发消息人数（群）
     * GroupAPNSMsgNum	APNs 推送数（群）
     * GroupSendMsgGroupNum	发消息群组数
     * GroupJoinGroupTimes	入群总数
     * GroupQuitGroupTimes	退群总数
     * GroupNewGroupNum	新增群组数
     * GroupAllGroupNum	累计群组数
     * GroupDestroyGroupNum	解散群个数
     * CallBackReq	回调请求数
     * CallBackRsp	回调应答数
     * Date	日期
     * @return bool|mixed
     */
    public function getAppInfo(array $requestFiled = [])
    {
        return $this->postData('openconfigsvr','getappinfo',$requestFiled);
    }

    /**
     * 下载最近消息记录
     * @param $chatType
     * 	消息类型，C2C 表示单发消息 Group 表示群组消息
     * @param $msgTime
     * 	需要下载的消息记录的时间段，2015120121表示获取2015年12月1日21:00 - 21:59的消息的下载地址。
     * 该字段需精确到小时。每次请求只能获取某天某小时的所有单发或群组消息记录
     * @return bool|mixed
     */
    public function getHistory($chatType,$msgTime)
    {
        $data = [
            'ChatType'=>$chatType,
            'MsgTime'=>$msgTime
        ];
        return $this->postData('open_msg_svc','get_history',$data);
    }

    /**
     * 获取服务器IP地址
     * @return bool|mixed
     */
    public function getIPList()
    {
        $data = [];
        return $this->postData('ConfigSvc','GetIPList',$data);
    }
}