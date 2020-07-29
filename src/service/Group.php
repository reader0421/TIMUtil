<?php


namespace TIMUtil\service;


use TIMUtil\TIMUtil;

class Group extends TIMUtil
{
    const SERVICE_NAME = 'group_open_http_svc';

    /**
     * 创建群
     * @param $type
     * 群组形态，包括 Public（陌生人社交群），Private（即 Work，好友工作群），ChatRoom（即 Meeting，会议群），AVChatRoom（直播群）
     * @param $name
     * 群名称，最长30字节，使用 UTF-8 编码，1个汉字占3个字节
     * @param string $groupId
     * 为了使得群组 ID 更加简单，便于记忆传播，腾讯云支持 App 在通过 REST API 创建群组时 自定义群组 ID
     * @param string $ownerAccount
     * 群主 ID，自动添加到群成员中。如果不填，群没有群主
     * @param string $introduction
     * 群简介，最长240字节，使用 UTF-8 编码，1个汉字占3个字节
     * @param string $notification
     * 群公告，最长300字节，使用 UTF-8 编码，1个汉字占3个字节
     * @param string $faceUrl
     * 群头像 URL，最长100字节
     * @param string $maxMemberCount
     *    最大群成员数量，缺省时的默认值：私有群是200，公开群是2000，聊天室是6000，音视频聊天室和在线成员广播大群无限制
     * @param string $applyJoinOption
     *    申请加群处理方式。
     * 包含 FreeAccess（自由加入），
     * NeedPermission（需要验证），
     * DisableApply（禁止加群），
     * 不填默认为 NeedPermission（需要验证）仅当创建支持申请加群的 群组 时，该字段有效
     * @param array $memberList
     *    初始群成员列表，最多500个；成员信息字段详情请参阅 群成员资料
     * @param array $appDefinedData
     *    群组维度的自定义字段，默认情况是没有的，需要开通，详情请参阅 自定义字段
     * @return bool|mixed
     */
    public function createGroup($type,
                                $name,
                                $groupId=null,
                                $ownerAccount=null,
                                $introduction=null,
                                $notification=null,
                                $faceUrl=null,
                                $maxMemberCount=null,
                                $applyJoinOption='NeedPermission',
                                array $memberList=[],
                                array $appDefinedData=[])
    {
        $data = [
            'Type'=>$type,
            'Name'=>$name,
            'ApplyJoinOption'=>$applyJoinOption,
        ];
        !empty($groupId)? $data['GroupId'] = $groupId:true;
        !empty($ownerAccount)? $data['Owner_Account'] = $ownerAccount:true;
        !empty($introduction)? $data['Introduction'] = $introduction:true;
        !empty($notification)? $data['Notification'] = $notification:true;
        !empty($faceUrl)? $data['FaceUrl'] = $faceUrl:true;
        !empty($maxMemberCount)? $data['MaxMemberCount'] = $maxMemberCount:true;
        !empty($memberList)? $data['MemberList'] = $memberList:true;
        !empty($appDefinedData)? $data['AppDefinedData'] = $appDefinedData:true;

        return $this->postData(self::SERVICE_NAME,'create_group',$data);
    }

    /**
     * 获取群详细资料
     * @param array $groupList
     * 需要拉取的群组列表
     * @param array $responseFilter
     * 包含三个过滤器：
     * GroupBaseInfoFilter，基础信息字段过滤器
     * MemberInfoFilter，成员信息字段过滤器
     * AppDefinedDataFilter_Group，群组维度的自定义字段过滤器
     * @return bool|mixed
     */
    public function getGroupInfo(array $groupList, array $responseFilter = [])
    {
        $data = [
           'GroupIdList'=>$groupList
        ];
        if(!empty($responseFilter)){
            $data['ResponseFilter'] = $responseFilter;
        }

        return $this->postData(self::SERVICE_NAME,'get_group_info',$data);
    }

    /**
     * 获取群成员详细资料
     * @param $groupId
     * 需要拉取成员信息的群组的 ID
     * @param int $limit
     * 一次最多获取多少个成员的资料，不得超过10000。如果不填，则获取群内全部成员的信息
     * @param int $offset
     * 从第几个成员开始获取，如果不填则默认为0，表示从第一个成员开始获取
     * @param array $memberInfoFilter
     * 需要获取哪些信息， 如果没有该字段则为群成员全部资料，成员信息字段详情请参阅 群成员资料
     * @param array $memberRoleFilter
     * 拉取指定身份的群成员资料。如没有填写该字段，默认为所有身份成员资料，成员身份可以为：“Owner”，“Admin”，“Member”
     * @param array $appDefinedDataFilter_GroupMember
     * 默认情况是没有的。
     * 该字段用来群成员维度的自定义字段过滤器，指定需要获取的群成员维度的自定义字段，群成员维度的自定义字段详情请参阅 自定义字段
     * @return bool|mixed
     */
    public function getGroupMemberInfo($groupId,
                                       $limit = null,
                                       $offset = null,
                                       array $memberInfoFilter=[],
                                       array $memberRoleFilter = [],
                                       array $appDefinedDataFilter_GroupMember = [])
    {
        $data =[
            'GroupId'=>$groupId
        ];
        !empty($memberInfoFilter)?$data['MemberInfoFilter'] = $memberInfoFilter:true;
        !empty($memberRoleFilter)?$data['MemberRoleFilter'] = $memberRoleFilter:true;
        !empty($appDefinedDataFilter_GroupMember)?$data['AppDefinedDataFilter_GroupMember'] = $appDefinedDataFilter_GroupMember:true;
        !empty($limit)?$data['Limit'] = $limit:true;
        !empty($offset)?$data['Offset'] = $offset:true;

        return $this->postData(self::SERVICE_NAME,'get_group_member_info',$data);
    }

    /**
     * 修改群基础资料
     * @param $groupId
     * 需要修改基础信息的群组的 ID
     * @param null $name
     * 群名称，最长30字节
     * @param null $introduction
     * 群简介，最长240字节
     * @param null $notification
     * 群公告，最长300字节
     * @param null $faceUrl
     * 群头像 URL，最长100字节
     * @param null $maxMemberNum
     * 最大群成员数量
     * 私有群、公开群和聊天室：该字段阈值请参考 群组系统 和 计费概述 中的群成员人数上限相关说明
     * 音视频聊天室和在线成员广播大群：该字段为无效字段，无需填写
     * @param null $applyJoinOption
     * 申请加群处理方式。包含
     * FreeAccess（自由加入），
     * NeedPermission（需要验证），
     * DisableApply（禁止加群）
     * @param array $appDefinedData
     * 默认情况是没有的。开通群组维度的自定义字段详情请参见 自定义字段
     * @return bool|mixed
     */
    public function modifyGroupBaseInfo($groupId,
                                        $name = null,
                                        $introduction = null,
                                        $notification = null,
                                        $faceUrl = null,
                                        $maxMemberNum = null,
                                        $applyJoinOption = null,
                                        array $appDefinedData =[])
    {
        $data=[
            'GroupId'=>$groupId
        ];
        !empty($name) ? $data['Name'] = $name : true;
        !empty($introduction) ? $data['Introduction'] = $introduction : true;
        !empty($notification) ? $data['Notification'] = $notification : true;
        !empty($faceUrl) ? $data['FaceUrl'] = $faceUrl : true;
        !empty($maxMemberNum) ? $data['MaxMemberNum'] = $maxMemberNum : true;
        !empty($applyJoinOption) ? $data['ApplyJoinOption'] = $applyJoinOption : true;
        !empty($appDefinedData) ? $data['AppDefinedData'] = $appDefinedData : true;

        return $this->postData(self::SERVICE_NAME,'modify_group_base_info',$data);
    }

    /**
     * 增加群成员
     * @param $groupId
     * 操作的群 ID
     * @param array $memberList
     * 待添加的群成员数组
     *  [ // 一次最多添加500个成员
     *
     * "Member_Account": "tommy" // 要添加的群成员 ID（必填）
     * },
     * {
     * "Member_Account": "jared"
     * }]
     * @param int $silence
     * 是否静默加人。0：非静默加人；1：静默加人。不填该字段默认为0
     * @return bool|mixed
     */
    public function addGroupMember($groupId,array $memberList,$silence = 0)
    {
        $data = [
            'GroupId'=>$groupId,
            'MemberList'=>$memberList,
            'Silence'=>$silence
        ];

        return $this->postData(self::SERVICE_NAME,'add_group_member',$data);
    }

    /**
     * 删除群组成员
     * @param $groupId
     * 操作的群 ID
     * @param array $memberToDel_Account
     * 待删除的群成员
     * @param int $silence
     * 是否静默删人。
     * 0表示非静默删人，1表示静默删人。
     * 静默即删除成员时不通知群里所有成员，只通知被删除群成员。
     * 不填写该字段时默认为0
     * @param string $reason
     * 踢出用户原因
     * @return bool|mixed
     */
    public function deleteGroupMember($groupId,array $memberToDel_Account,$silence = 0,$reason = '')
    {
        $data = [
            'GroupId'=>$groupId,
            'Silence'=>$silence,
            'Reason'=>$reason,
            'MemberToDel_Account'=>$memberToDel_Account
        ];

        return $this->postData(self::SERVICE_NAME,'delete_group_member',$data);
    }

    /**
     * 修改群成员资料
     * @param $groupId
     * 操作的群 ID
     * @param $member_account
     * 要操作的群成员
     * @param array $fields
     * 要修改的字段及值
     * [key=>value,key=>value,...]
     * field：
     * Role：成员身份，Admin/Member 分别为设置/取消管理员
     * MsgFlag：消息屏蔽类型 AcceptAndNotify、Discard或者AcceptNotNotify
     * NameCard：群名片（最大不超过50个字节）
     * AppMemberDefinedData：群成员维度的自定义字段，默认情况是没有的，需要开通，详情请参阅 群组系统
     * ShutUpTime：需禁言时间，单位为秒，0表示取消禁言
     * @return bool|mixed
     */
    public function modifyGroupMemberInfo($groupId,$member_account,array $fields)
    {
        $data = [
            'GroupId'=>$groupId,
            'Member_Account'=>$member_account,
        ];
        foreach ($fields as $k=>$v){
            $data[$k]=$v;
        }

        return $this->postData(self::SERVICE_NAME,'modify_group_member_info',$data);
    }

    /**
     * 解散群组
     * @param $groupId
     * 操作的群 ID
     * @return bool|mixed
     */
    public function destroyGroup($groupId)
    {
        $data = ['GroupId'=>$groupId];

        return $this->postData(self::SERVICE_NAME,'destroy_group',$data);
    }

    /**
     * 拉取用户所加入的群组
     * @param $memberAccount
     * 需要查询的用户帐号
     * @param null $limit
     * 单次拉取的群组数量，如果不填代表所有群组
     * @param int $offset
     * 从第多少个群组开始拉取
     * @param null $groupType
     * 	拉取哪种群组类型，例如
     * Public(陌生人社交群)，
     * Private（即新版本Work，好友工作群)，
     * ChatRoom （即新版本Meeting，会议群），
     * AVChatRoom(直播群)，
     * 不填为拉取所有
     * @param array $responseFilter
     * 分别包含 GroupBaseInfoFilter 和 SelfInfoFilter 两个过滤器；
     * GroupBaseInfoFilter 表示需要拉取哪些基础信息字段，详情请参阅 群组系统；
     * SelfInfoFilter 表示需要拉取用户在每个群组中的哪些个人资料，详情请参阅 群组系统
     * @param int $withNoActiveGroups
     * 	是否获取用户已加入但未激活的 Private（即新版本中 Work，好友工作群) 群信息，
     *  0表示不获取，1表示获取。默认为0
     * @param int $withHugeGroups
     * 是否获取用户加入的 AVChatRoom(直播群)，0表示不获取，1表示获取。默认为0
     * @return bool|mixed
     */
    public function getJoinedGroupList($memberAccount,
                                       $limit = null,
                                       $offset = 0,
                                       $groupType = null,
                                       array $responseFilter = [],
                                       $withNoActiveGroups = 0,
                                       $withHugeGroups = 0)
    {
        $data = [
            'Member_Account'=>$memberAccount,
            'WithNoActiveGroups'=>$withNoActiveGroups,
            'WithHugeGroups'=>$withHugeGroups,
        ];
        !empty($limit) ? $data['Limit'] = $limit:true;
        !empty($offset) ? $data['Offset'] = $offset:true;
        !empty($groupType) ? $data['GroupType'] = $groupType:true;
        !empty($responseFilter) ? $data['ResponseFilter'] = $responseFilter:true;

        return $this->postData(self::SERVICE_NAME,'get_joined_group_list',$data);
    }

    /**
     * 查询用户在群组中的身份
     * @param $groupId
     * 需要查询的群组 ID
     * @param array $userAccounts
     * 表示需要查询的用户帐号，最多支持500个帐号
     * @return bool|mixed
     */
    public function getRoleInGroup($groupId,array $userAccounts)
    {
        $data = [
            'GroupId'=>$groupId,
            'User_Account'=>$userAccounts
        ];

        return $this->postData(self::SERVICE_NAME,'get_role_in_group',$data);
    }

    /**
     * 批量禁言和取消禁言
     * @param $groupId
     * 需要查询的群组 ID
     * @param array $membersAccount
     * 需要禁言的用户帐号，最多支持500个帐号
     * @param $shutUpTime
     * 需禁言时间，单位为秒，为0时表示取消禁言
     * @return bool|mixed
     */
    public function forbidSendMsg($groupId,array $membersAccount,$shutUpTime)
    {
        $data = [
            'GroupId'=>$groupId,
            'Members_Account'=>$membersAccount,
            'ShutUpTime'
        ];

        return $this->postData(self::SERVICE_NAME,'forbid_send_msg',$data);
    }

    /**
     * 获取被禁言群成员列表
     * @param $groupId
     * 	需要获取被禁言成员列表的群组 ID。
     * @return bool|mixed
     */
    public function getGroupShuttedUin($groupId)
    {
        $data = [
            'GroupId'=>$groupId
        ];

        return $this->postData(self::SERVICE_NAME,'get_group_shutted_uin',$data);
    }

    /**
     * 在群组中发送普通消息
     * @param $groupId
     * 向哪个群组发送消息
     * @param $random
     * 无符号32位整数。如果5分钟内两条消息的随机值相同，后一条消息将被当做重复消息而丢弃
     * @param array $msgBody
     * 消息体，详细可参阅 消息格式描述
     * @param null $fromAccount
     * 消息来源帐号，选填。
     * 如果不填写该字段，则默认消息的发送者为调用该接口时使用的 App 管理员帐号。
     * 除此之外，App 亦可通过该字段“伪造”消息的发送者，从而实现一些特殊的功能需求。
     * 需要注意的是，如果指定该字段，必须要确保字段中的帐号是存在的
     * @param null $offlinePushInfo
     * 离线推送信息配置，详细可参阅 消息格式描述
     * @param array|string[] $forbidCallbackControl
     * 消息回调禁止开关，只对单条消息有效，
     * ForbidBeforeSendMsgCallback 表示禁止发消息前回调，
     * ForbidAfterSendMsgCallback 表示禁止发消息后回调
     * @param string $msgPriority
     * 消息的优先级 默认优先级 Normal。
     * 可以指定4种优先级，从高到低依次为 High、Normal、Low 以及 Lowest，区分大小写。
     * @param int $onlineOnlyFlag
     * 如果消息体中指定 OnlineOnlyFlag，只要值大于0，则消息表示只在线下发，不存离线和漫游（AVChatRoom 和 BChatRoom 不允许使用）。
     * @return bool|mixed
     */
    public function sendGroupMsg($groupId,
                                 $random,
                                 array $msgBody,
                                 $fromAccount = null,
                                 $offlinePushInfo = null,
                                 array $forbidCallbackControl = ['ForbidBeforeSendMsgCallback','ForbidAfterSendMsgCallback'],
                                 $msgPriority = 'Normal',
                                 $onlineOnlyFlag = 0)
    {
        $data =[
            'GroupId'=>$groupId,
            'Random'=>$random,
            'MsgBody'=>$msgBody,
            'OnlineOnlyFlag'=>$onlineOnlyFlag,
            'MsgPriority'=>$msgPriority
        ];
        !empty($fromAccount) ? $data['From_Account'] = $fromAccount : true;
        !empty($offlinePushInfo) ? $data['OfflinePushInfo'] = $offlinePushInfo : true;
        !empty($forbidCallbackControl) ? $data['ForbidCallbackControl'] = $forbidCallbackControl : true;

        return $this->postData(self::SERVICE_NAME,'send_group_msg',$data);
    }

    /**
     * 在群组中发送系统通知
     * @param $groupId
     * 向哪个群组发送系统通知
     * @param $content
     * 系统通知的内容
     * @param array $toMembersAccount
     * 接收者群成员列表，请填写接收者 UserID，不填或为空表示全员下发
     * @return bool|mixed
     */
    public function sendGroupSystemNotification($groupId,$content,array $toMembersAccount = [])
    {
        $data = [
            'GroupId'=>$groupId,
            'Content'=>$content
        ];
        !empty($toMembersAccount) ? $data['ToMembers_Account'] = $toMembersAccount : true;

        return $this->postData(self::SERVICE_NAME,'send_group_system_notification',$data);
    }

    /**
     * 撤回群消息
     * @param $groupId
     * 操作的群 ID
     * @param array $msgSeqList
     * 被撤回的消息 seq 列表，一次请求最多可以撤回10条消息 seq
     * [{"MsgSeq":100},{"MsgSeq":101}]
     * @return bool|mixed
     */
    public function groupMsgRecall($groupId,array $msgSeqList)
    {
        $data = [
            'GroupId'=>$groupId,
            'MsgSeqList'=>$msgSeqList
        ];

        return $this->postData(self::SERVICE_NAME,'group_msg_recall',$data);
    }

    /**
     * 转让群主
     * @param $groupId
     * 要被转移的群组 ID
     * @param $newOwnerAccount
     * 新群主 ID
     * @return bool|mixed
     */
    public function changeGroupOwner($groupId,$newOwnerAccount)
    {
        $data = [
            'GroupId'=>$groupId,
            'NewOwner_Account'=>$newOwnerAccount
        ];
        return $this->postData(self::SERVICE_NAME,'change_group_owner',$data);
    }

    /**
     * 导入群基础资料
     * {
     *  "Owner_Account": "leckie", // 群主的 UserId（选填）
     *  "Type": "Public", // 群组类型：Private/Public/ChatRoom（必填）
     *  "GroupId":"MyFirstGroup", // 用户自定义群组外显 ID（选填）
     *  "Name": "TestGroup", // 群名称（必填）
     *  "Introduction": "This is group Introduction", // 群简介（选填）
     *  "Notification": "This is group Notification", // 群公告（选填）
     *  "FaceUrl": "http://this.is.face.url",
     *  "MaxMemberCount": 500, // 最大群成员数量（选填）
     *  "ApplyJoinOption": "FreeAccess", // 申请加群处理方式（选填）
     *  "CreateTime": 1448357837, // 群组的创建时间（选填，不填会以请求时刻为准）
     *  "AppDefinedData": [ // 群组维度的自定义字段（选填）
     *      {
     *          "Key": "GroupTestData1", // App 自定义的字段 Key
     *          "Value": "xxxxx" // 自定义字段的值
     *      },
     *      {
     *          "Key": " GroupTestData2",
     *          "Value": "abc\u0000\u0001" // 自定义字段支持二进制数据
     *      }
     *  ]
     * }
     * @param $data
     * @return bool|mixed
     */
    public function importGroup($data)
    {
        return $this->postData(self::SERVICE_NAME,'import_group',$data);
    }

    /**
     * 导入群消息
     * @param $groupId
     * 要导入消息的群 ID
     * @param array $msgList
     * 	导入的消息列表
     * [
     *  {
     *      "From_Account": "leckie", // 指定消息发送者
     *      "SendTime":1448357837,
     *      "Random": 8912345, // 消息随机数（可选）
     *      "MsgBody": [ // 消息体，由一个 element 数组组成，详见 TIMMessage 消息对象
     *          {
     *              "MsgType": "TIMTextElem", // 文本
     *              "MsgContent": {
     *                  "Text": "red packet"
     *              }
     *          },
     *          {
     *              "MsgType": "TIMFaceElem", // 表情
     *              "MsgContent": {
     *                  "Index": 6,
     *                  "Data": "abc\u0000\u0001"
     *              }
     *          }
     *      ]
     *  },
     *  {
     *      "From_Account": "peter", // 指定消息发送者
     *      "SendTime":1448357837,
     *      "MsgBody": [ // 消息体，由一个 element 数组组成，详见 TIMMessage 消息对象
     *          {
     *              "MsgType": "TIMTextElem", // 文本
     *              "MsgContent": {
     *                  "Text": "red packet"
     *              }
     *          }
     *      ]
     *  }
     * ]
     * @return bool|mixed
     */
    public function importGroupMsg($groupId,array $msgList)
    {
        $data = [
            'GroupId'=>$groupId,
            'MsgList'=>$msgList
        ];
        return $this->postData(self::SERVICE_NAME,'import_group_msg',$data);
    }

    /**
     * 导入群成员
     * @param $groupId
     * 操作的群 ID
     * @param array $memberList
     * 待添加的群成员数组
     * @return bool|mixed
     */
    public function importGroupMember($groupId,array $memberList)
    {
        $data = [
            'GroupId'=>$groupId,
            'MemberList'=>$memberList
        ];
        return $this->postData(self::SERVICE_NAME,'import_group_member',$data);
    }

    /**
     * 设置成员未读消息计数
     * @param $groupId
     * 操作的群 ID
     * @param $memberAccount
     * 要操作的群成员
     * @param $unreadMsgNum
     * 成员未读消息数
     * @return bool|mixed
     */
    public function setUnreadMsgNum($groupId,$memberAccount,$unreadMsgNum)
    {
        $data = [
            'GroupId'=>$groupId,
            'Member_Account'=>$memberAccount,
            'UnreadMsgNum'=>$unreadMsgNum
        ];
        return $this->postData(self::SERVICE_NAME,'set_unread_msg_num',$data);
    }

    /**
     * 删除指定用户发送的消息
     * 该 API 接口的作用是删除最近1000条消息中指定用户发送的消息。
     * @param $groupId
     * 要删除消息的群 ID
     * @param $senderAccount
     * 	被删除消息的发送者 ID
     * @return bool|mixed
     */
    public function deleteGroupMsgBySender($groupId,$senderAccount)
    {
        $data = [
            'GroupId'=>$groupId,
            'Sender_Account'=>$senderAccount
        ];
        return $this->postData(self::SERVICE_NAME,'delete_group_msg_by_sender',$data);
    }

    /**
     *拉取群历史消息
     * @param $groupId
     * 要拉取历史消息的群组 ID
     * @param int $reqMsgNumber
     * 拉取的历史消息的条数，目前一次请求最多返回20条历史消息，所以这里最好小于等于20
     * @param int $reqMsgSeq
     * 	拉取消息的最大 seq
     * @return bool|mixed
     */
    public function groupMsgGetSimple($groupId,$reqMsgNumber = 20,$reqMsgSeq = 0)
    {
        $data = [
            'GroupId'=>$groupId,
            'ReqMsgNumber'=>$reqMsgNumber,
        ];
        !empty($reqMsgSeq) ? $data['ReqMsgSeq'] = $reqMsgSeq :true;
        return $this->postData(self::SERVICE_NAME,'group_msg_get_simple',$data);
    }

    
}