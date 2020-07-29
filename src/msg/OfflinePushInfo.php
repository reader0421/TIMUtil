<?php


namespace TIMUtil\msg;


class OfflinePushInfo
{
    /**
     * 0表示推送，1表示不离线推送。
     * @var int
     */
    protected $PushFlag = null;

    /**
     * 离线推送标题。该字段为 iOS 和 Android 共用。
     * @var String
     */
    protected $Title = null;

    /**
     * 离线推送内容。该字段会覆盖上面各种消息元素 TIMMsgElement 的离线推送展示文本。
     * 若发送的消息只有一个 TIMCustomElem 自定义消息元素，该 Desc 字段会覆盖 TIMCustomElem 中的 Desc 字段。
     * 如果两个 Desc 字段都不填，将收不到该自定义消息的离线推送。
     * @var String
     */
    protected $Desc = null;

    /**
     * 离线推送透传内容。由于国内各 Android 手机厂商的推送平台要求各不一样，
     * 请保证此字段为 JSON 格式，否则可能会导致收不到某些厂商的离线推送。
     * @var String
     */
    protected $Ext = null;

    /**
     * AndroidInfo.Sound  Android 离线推送声音文件路径。
     * AndroidInfo.OPPOChannelID  OPPO 手机 Android 8.0 以上的 NotificationChannel 通知适配字段。
     * @var string[]
     */
    protected $AndroidInfo = null;

    /**
     * ApnsInfo.BadgeMode 这个字段缺省或者为0表示需要计数，为1表示本条消息不需要计数，即右上角图标数字不增加。
     * ApnsInfo.Title 该字段用于标识 APNs 推送的标题，若填写则会覆盖最上层 Title。
     * ApnsInfo.SubTitle 该字段用于标识 APNs 推送的子标题。
     * ApnsInfo.Image 	该字段用于标识 APNs 携带的图片地址，当客户端拿到该字段时，可以通过下载图片资源的方式将图片展示在弹窗上。
     * @var string[]
     */
    protected $ApnsInfo = null;

    /**
     * 0表示推送，1表示不离线推送。
     * @param $flag
     * @return $this
     */
    public function setPushFlag($flag)
    {
        $this->PushFlag = $flag;
        return $this;
    }

    /**
     * 离线推送标题。该字段为 iOS 和 Android 共用。
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->Title = $title;
        return $this;
    }

    /**
     * 离线推送内容。该字段会覆盖上面各种消息元素 TIMMsgElement 的离线推送展示文本。
     * 若发送的消息只有一个 TIMCustomElem 自定义消息元素，该 Desc 字段会覆盖 TIMCustomElem 中的 Desc 字段。
     * 如果两个 Desc 字段都不填，将收不到该自定义消息的离线推送。
     * @param $desc
     * @return $this
     */
    public function setDesc($desc)
    {
        $this->Desc = $desc;
        return $this;
    }

    /**
     * 离线推送透传内容。由于国内各 Android 手机厂商的推送平台要求各不一样，
     * 请保证此字段为 JSON 格式，否则可能会导致收不到某些厂商的离线推送。
     * @param $ext
     * @return $this
     */
    public function setExt(array $ext)
    {
        $this->Ext = json_encode($ext);
        return $this;
    }

    /**
     * 设置安卓推送内容
     * @param $sound
     * Android 离线推送声音文件路径。
     * @param $oppo_channel_id
     * OPPO 手机 Android 8.0 以上的 NotificationChannel 通知适配字段。
     * @return $this
     */
    public function setAndroidInfo($sound,$oppo_channel_id)
    {
        $this->AndroidInfo['Sound'] = $sound;
        $this->AndroidInfo['OPPOChannelID'] = $oppo_channel_id;
        return $this;
    }

    /**
     * 苹果推送内容
     * @param $sound
     * @param $badgeMode
     * 这个字段缺省或者为0表示需要计数，为1表示本条消息不需要计数，即右上角图标数字不增加。
     * @param $title
     * 该字段用于标识 APNs 推送的标题，若填写则会覆盖最上层 Title。
     * @param $subtitle
     * 该字段用于标识 APNs 推送的子标题。
     * @param $image
     * 该字段用于标识 APNs 携带的图片地址，当客户端拿到该字段时，可以通过下载图片资源的方式将图片展示在弹窗上。
     * @return $this
     */
    public function setApnsInfo($sound,$badgeMode,$title,$subtitle,$image)
    {
        $this->ApnsInfo['Sound'] = $sound;
        $this->ApnsInfo['BadgeMode'] = $badgeMode;
        $this->ApnsInfo['Title'] = $title;
        $this->ApnsInfo['SubTitle'] = $subtitle;
        $this->ApnsInfo['image'] = $image;
        return $this;
    }

    public function getData()
    {
        $data = [];
        $flag = false;
        if(!is_null($this->PushFlag)){
            $data['PushFlag'] = $this->PushFlag;
            $flag = true;
        }
        if(!is_null($this->Title)){
            $data['Title'] = $this->Title;
            $flag = true;
        }
        if(!is_null($this->Desc)){
            $data['Desc'] = $this->Desc;
            $flag = true;
        }
        if(!is_null($this->Ext)){
            $data['Ext'] = $this->Ext;
            $flag = true;
        }
        if(!is_null($this->AndroidInfo)){
            $data['AndroidInfo'] = $this->AndroidInfo;
            $flag = true;
        }
        if(!is_null($this->ApnsInfo)){
            $data['ApnsInfo'] = $this->ApnsInfo;
            $flag = true;
        }
        return $flag ? $data: null;
    }

}