<?php
namespace TIMUtil\msg;


class MsgBuilder
{
    /**
     * 1：把消息同步到 From_Account 在线终端和漫游上；
     * 2：消息不同步至 From_Account；
     * 若不填写默认情况下会将消息存 From_Account 漫游
     * 选填
     * @var int
     */
    protected $SyncOtherMachine = 1;

    /**
     * 消息发送方 UserID（用于指定发送消息方帐号）
     * 选填
     * @var string
     */
    protected $From_Account = '';

    /**
     * 消息接收方 UserID
     * 必填
     * @var string
     */
    protected $To_Account ='';

    /**
     * 用于批量发消息
     * @var array
     */
    protected $To_Accounts = [];

    /**
     * 消息离线保存时长（单位：秒），最长为7天（604800秒）
     * 若设置该字段为0，则消息只发在线用户，不保存离线
     * 若设置该字段超过7天（604800秒），仍只保存7天
     * 若不设置该字段，则默认保存7天
     * 选填
     * @var int
     */
    protected $MsgLifeTime = 604800;

    /**
     * 消息随机数，由随机函数产生，用于后台定位问题
     * 必填
     * @var int
     */
    protected $MsgRandom;

    /**
     * 消息时间戳，UNIX 时间戳（单位：秒）
     * 选填
     * @var
     */
    protected $MsgTimeStamp;

    /**
     * 消息内容，具体格式请参考 消息格式描述（注意，一条消息可包括多种消息元素，MsgBody 为 Array 类型）
     * @var
     */
    protected $MsgBody = [];

    /**
     * 离线推送信息配置，具体可参考 消息格式描述
     * @var OfflinePushInfo
     */
    protected $OfflinePushInfo = null;

    protected $ForbidCallbackControl = [];

    public function __construct()
    {
        $this->MsgRandom = mt_rand(0, 4294967295);
        $this->MsgTimeStamp = time();
    }

    
    /**
     * 把消息同步到 From_Account 在线终端和漫游上；
     * @return $this
     */
    public function setSyncOtherMachine()
    {
        $this->SyncOtherMachine = 1;
        return $this;
    }

    /**
     * 消息不同步至 From_Account
     * @return $this
     */
    public function setUnSyncOtherMachine()
    {
        $this->SyncOtherMachine = 2;
        return $this;
    }

    /**
     * 消息发送方 UserID（用于指定发送消息方帐号）
     * @param $user_id
     * @return $this
     */
    public function setFromAccount($user_id)
    {
        $this->From_Account = $user_id;
        return $this;
    }

    /**
     * 消息接收方 UserID
     * @param $user_id
     * @return $this
     */
    public function setToAccount($user_id)
    {
        $this->To_Account = $user_id;
        return $this;
    }

    /**
     * 消息接收方 UserIDs
     * 会覆盖 setToAccount
     * @param array $user_ids
     * @return $this
     */
    public function setToAccounts(array $user_ids)
    {
        $this->To_Accounts = $user_ids;
        return $this;
    }

    /**
     * 消息离线保存时长（单位：秒），最长为7天（604800秒）
     * 若设置该字段为0，则消息只发在线用户，不保存离线
     * 若设置该字段超过7天（604800秒），仍只保存7天
     * 若不设置该字段，则默认保存7天
     * @param $second
     * @return $this
     */
    public function setMsgLifeTime($second)
    {
        $this->MsgLifeTime = $second;
        return $this;
    }

    /**
     * 增加一个消息内容
     * @param MsgBody $body
     * @return $this
     */
    public function setMsgBody(MsgBody $body)
    {
        $this->MsgBody = $body->getBody();
        return $this;
    }

    /**
     * 消息回调禁止开关，只对本条消息有效
     * @param array $callbacks
     * ForbidBeforeSendMsgCallback 表示禁止发消息前回调，ForbidAfterSendMsgCallback 表示禁止发消息后回调
     * @return $this
     */
    public function setForbidCallbackControl($callbacks=[])
    {
        $this->ForbidCallbackControl = $callbacks;
        return $this;
    }

    /**
     * 清空消息内容
     * @return $this
     */
    public function clearMsgBody()
    {
        $this->MsgBody = [];
        return $this;
    }

    /**
     * 离线推送信息配置，具体可参考 消息格式描述
     * @param OfflinePushInfo $info
     * @return $this
     */
    public function setOfflinePushInfo(OfflinePushInfo $info)
    {
        $this->OfflinePushInfo = $info->getData();
        return $this;
    }

    /**
     * 检查消息信息是否缺失
     * @return bool
     * @throws \Exception
     */
    public function checkMsg()
    {
        if(empty($this->To_Account) && empty($this->To_Accounts)){
            throw new \Exception('required To_Account',-1);
        }
        if(empty($this->MsgBody)){
            throw new \Exception('required MsgBody',-1);
        }
        return true;
    }

    /**
     * 生成消息体
     * @return int[]
     */
    public function build()
    {
        $data = [
            'SyncOtherMachine'=>$this->SyncOtherMachine,
        ];
        if(!empty($this->From_Account)){
            $data['From_Account'] = $this->From_Account;
        }
        if(!empty($this->To_Account)){
            $data['To_Account'] = $this->To_Account;
        }
        if(!empty($this->To_Accounts)){
            $data['To_Account'] = $this->To_Accounts;
        }
        $data['MsgLifeTime'] = $this->MsgLifeTime;
        $data['MsgRandom'] = $this->MsgRandom;
        $data['MsgTimeStamp'] = $this->MsgTimeStamp;
        $data['MsgBody'] = $this->MsgBody;
        $data['ForbidCallbackControl'] = $this->ForbidCallbackControl;
        if(!is_null($this->OfflinePushInfo)){
            $data['OfflinePushInfo'] = $this->OfflinePushInfo;
        }
        return $data;
    }


}