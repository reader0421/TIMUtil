<?php
namespace TIMUtil\Tag;

class TagIM
{
    /**
     * 昵称
     * 长度不得超过500个字节
     */
    const Nick = 'Tag_Profile_IM_Nick';

    /**
     * 性别
     * 	Gender_Type_Unknown：没设置性别
     * Gender_Type_Female：女性
     * Gender_Type_Male：男性
     */
    const Gender = 'Tag_Profile_IM_Gender';

    /**
     * 生日
     * 推荐用法：20190419
     */
    const BirthDay = 'Tag_Profile_IM_BirthDay';

    /**
     * 所在地
     * 长度不得超过16个字节，推荐用法如下：
     * App 本地定义一套数字到地名的映射关系
     * 后台实际保存的是4个 uint32_t 类型的数字
     * 其中第一个 uint32_t 表示国家
     * 第二个 uint32_t 用于表示省份
     * 第三个 uint32_t 用于表示城市
     * 第四个 uint32_t 用于表示区县
     */
    const Location = 'Tag_Profile_IM_Location';

    /**
     * 个性签名
     * 长度不得超过500个字节
     */
    const SelfSignature = 'Tag_Profile_IM_SelfSignature';

    /**
     * 加好友验证方式
     * AllowType_Type_NeedConfirm：需要经过自己确认才能添加自己为好友
     * AllowType_Type_AllowAny：允许任何人添加自己为好友
     * AllowType_Type_DenyAny：不允许任何人添加自己为好友
     */
    const AllowType = 'Tag_Profile_IM_AllowType';

    /**
     * 语言
     */
    const Language = 'Tag_Profile_IM_Language';

    /**
     * 头像URL
     * 长度不得超过500个字节
     */
    const Image = 'Tag_Profile_IM_Image';

    /**
     * 消息设置
     * 标志位：Bit0：置0表示接收消息，置1则不接收消息
     */
    const MsgSettings = 'Tag_Profile_IM_MsgSettings';

    /**
     * 管理员禁止加好友标识
     * AdminForbid_Type_None：默认值，允许加好友
     * AdminForbid_Type_SendOut：禁止该用户发起加好友请求
     */
    const AdminForbidType = 'Tag_Profile_IM_AdminForbidType';

    /**
     * 等级
     * 	通常一个 UINT-8 数据即可保存一个等级信息
     *  您可以考虑拆分保存，从而实现多种角色的等级信息
     */
    const Level = 'Tag_Profile_IM_Level';

    /**
     * 角色
     * 通常一个 UINT-8 数据即可保存一个角色信息
     * 您可以考虑拆分保存，从而保存多种角色信息
     */
    const Role = 'Tag_Profile_IM_Role';


}