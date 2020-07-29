<?php


namespace TIMUtil\msg;


class MsgBody
{
    protected $body = [];


    /**
     * 生成文本消息
     * @param $content String
     * 消息内容。当接收方为 iOS 或 Android 后台在线时，作为离线推送的文本展示。
     * @return $this
     */
    public function createTextMsg($content)
    {
        $data = [
            'MsgType'=>'TIMTextElem',
            'MsgContent'=>['Text'=>$content]
        ];
        $this->body[] = $data;
        return $this;
    }

    /**
     * 生成地理位置消息
     * @param $Latitude Number
     * 纬度。
     * @param $Longitude Number
     * 经度。
     * @param $Desc String
     * 	地理位置描述信息。
     * @return $this
     */
    public function createLocationMsg($Latitude,$Longitude,$Desc)
    {
        $data = [
            'MsgType'=>'TIMLocationElem',
            'MsgContent'=>[
                'Desc'=>$Desc,
                'Latitude'=>$Latitude,
                'Longitude'=>$Longitude
            ]
        ];
        $this->body[] = $data;
        return $this;
    }

    /**
     * 生成表情消息
     * @param $Index Number
     * 表情索引，用户自定义。
     * @param $Data String
     * 	额外数据。
     * @return $this
     */
    public function createFaceMsg($Index,$Data)
    {
        $data = [
            'MsgType'=>'TIMFaceElem',
            'MsgContent'=>[
                'Index'=>$Index,
                'Data'=>$Data,
            ]
        ];
        $this->body[] = $data;
        return $this;
    }

    /**
     * 自定义消息元素
     * @param $Data String
     * 自定义消息数据。 不作为 APNs 的 payload 字段下发，故从 payload 中无法获取 Data 字段。
     * @param $Desc String
     * 自定义消息描述信息。当接收方为 iOS 或 Android 后台在线时，做离线推送文本展示。
     * 若发送自定义消息的同时设置了 OfflinePushInfo.Desc 字段，此字段会被覆盖，请优先填 OfflinePushInfo.Desc 字段。
     * 当消息中只有一个 TIMCustomElem 自定义消息元素时，如果 Desc 字段和 OfflinePushInfo.Desc 字段都不填写，
     * 将收不到该条消息的离线推送，需要填写 OfflinePushInfo.Desc 字段才能收到该消息的离线推送。
     * @param $Ext String
     * 扩展字段。当接收方为 iOS 系统且应用处在后台时，此字段作为 APNs 请求包 Payloads 中的 Ext 键值下发，Ext 的协议格式由业务方确定，APNs 只做透传。
     * @param $Sound String
     * 自定义 APNs 推送铃音。
     * @return $this
     */
    public function createCustomMsg($Data,$Desc,$Ext,$Sound)
    {
        $data = [
            'MsgType'=>'TIMCustomElem',
            'MsgContent'=>[
                'Data'=>$Data,
                'Desc'=>$Desc,
                'Ext'=>$Ext,
                'Sound'=>$Sound
            ]
        ];
        $this->body[] = $data;
        return $this;
    }

    /**
     * 获取消息内容
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }
}