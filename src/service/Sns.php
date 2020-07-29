<?php


namespace TIMUtil\service;


use TIMUtil\TIMUtil;

/**
 * 关系链管理
 * Class Sns
 * @package TIMUtil\service
 */
class Sns extends TIMUtil
{
    const SERVICE_NAME = 'sns';

    /**
     * 添加好友
     * @param $from_account
     * 需要为该 UserID 添加好友
     * @param array $add_friend_item
     * 好友结构体对象
     * @param string $add_type
     * 加好友方式（默认双向加好友方式）：
     * Add_Type_Single 表示单向加好友
     * Add_Type_Both 表示双向加好友
     * @param int $force_add_flags
     * 管理员强制加好友标记：1表示强制加好友，0表示常规加好友方式
     * @return bool|mixed
     */
    public function friendAdd($from_account,array $add_friend_item,$add_type = 'Add_Type_Both',$force_add_flags = 0)
    {
        $data = [
            'From_Account'=>$from_account,
            'AddFriendItem'=>$add_friend_item,
            'AddType'=>$add_type,
            'ForceAddFlags'=>$force_add_flags,
        ];
        return $this->postData(self::SERVICE_NAME,'friend_add',$data);
    }

    /**
     * 导入好友
     * @param $from_account
     * 需要为该 UserID 添加好友
     * @param $add_friend_item
     * 好友结构体对象
     * @return bool|mixed
     */
    public function friendImport($from_account,$add_friend_item)
    {
        $data = [
            'From_Account'=>$from_account,
            'AddFriendItem'=>$add_friend_item,
        ];
        return $this->postData(self::SERVICE_NAME,'friend_import',$data);
    }

    /**
     * 更新好友
     * @param $from_account
     * 需要更新该 UserID 的关系链数据
     * @param $update_item
     * 需要更新的好友对象数组
     * @return bool|mixed
     */
    public function friendUpdate($from_account,$update_item)
    {
        $data = [
            'From_Account'=>$from_account,
            'UpdateItem'=>$update_item,
        ];
        return $this->postData(self::SERVICE_NAME,'friend_update',$data);
    }

    /**
     * 删除好友
     * @param $from_account
     * 	需要删除该 UserID 的好友
     * @param array $to_accounts
     * 待删除的好友的 UserID 列表，单次请求的 To_Account 数不得超过1000
     * @param string $delete_type
     * 删除模式
     * Delete_Type_Single 单向删除好友
     * Delete_Type_Both 双向删除好友
     * @return bool|mixed
     */
    public function friendDelete($from_account,array $to_accounts,$delete_type = 'Delete_Type_Single')
    {
        $data = [
            'From_Account'=>$from_account,
            'To_Account'=>$to_accounts,
            'DeleteType'=>$delete_type
        ];
        return $this->postData(self::SERVICE_NAME,'friend_delete',$data);
    }

    /**
     * 删除所有好友
     * @param $from_account
     * 指定要清除好友数据的用户的 UserID
     * @param string $delete_type
     * 删除模式
     * Delete_Type_Single 单向删除好友
     * Delete_Type_Both 双向删除好友
     * @return bool|mixed
     */
    public function friendDeleteAll($from_account,$delete_type = 'Delete_Type_Single')
    {
        $data = [
            'From_Account'=>$from_account,
            'DeleteType'=>$delete_type
        ];
        return $this->postData(self::SERVICE_NAME,'friend_delete_all',$data);
    }

    /**
     * 校验好友
     * @param $from_account
     * 需要校验该 UserID 的好友
     * @param array $to_accounts
     * 请求校验的好友的 UserID 列表，单次请求的 To_Account 数不得超过1000
     * @param string $check_type
     * 校验模式
     * CheckResult_Type_Both 双向校验
     * CheckResult_Type_Single 单向校验
     * @return bool|mixed
     */
    public function friendCheck($from_account,array $to_accounts,$check_type = 'CheckResult_Type_Both')
    {
        $data = [
            'From_Account'=>$from_account,
            'To_Account'=>$to_accounts,
            'CheckType'=>$check_type
        ];
        return $this->postData(self::SERVICE_NAME,'friend_check',$data);
    }

    /**
     * 拉取好友
     * @param $from_account
     * 指定要拉取好友数据的用户的 UserID
     * @param $start_index
     * 分页的起始位置
     * @param $standard_sequence
     * 上次拉好友数据时返回的 StandardSequence，如果 StandardSequence 字段的值与后台一致，后台不会返回标配好友数据
     * @param $custom_sequence
     * 上次拉好友数据时返回的 CustomSequence，如果 CustomSequence 字段的值与后台一致，后台不会返回自定义好友数据
     * @return bool|mixed
     */
    public function friendGet($from_account,$start_index,$standard_sequence = 0,$custom_sequence = 0 )
    {
        $data = [
            'From_Account'=>$from_account,
            'StartIndex'=>$start_index,
            'StandardSequence'=>$standard_sequence,
            'CustomSequence'=>$custom_sequence
        ];
        return $this->postData(self::SERVICE_NAME,'friend_get',$data);
    }

    /**
     * 拉取指定好友
     * @param $from_account
     * 指定要拉取好友数据的用户的 UserID
     * @param array $to_accounts
     * 好友的 UserID 列表
     * 建议每次请求的好友数不超过100，避免因数据量太大导致回包失败
     * @param array $tag_list
     * 指定要拉取的资料字段及好友字段
     * @return bool|mixed
     */
    public function friendGetList($from_account,array $to_accounts,array $tag_list)
    {
        $data = [
            'From_Account'=>$from_account,
            'To_Account'=>$to_accounts,
            'TagList'=>$tag_list,
        ];
        return $this->postData(self::SERVICE_NAME,'friend_get_list',$data);
    }

    /**
     * 添加黑名单
     * @param $from_account
     * 请求为该 UserID 添加黑名单
     * @param array $to_accounts
     * 待添加为黑名单的用户 UserID 列表，单次请求的 To_Account 数不得超过1000
     * @return bool|mixed
     */
    public function blackListAdd($from_account,array $to_accounts)
    {
        $data = [
            'From_Account'=>$from_account,
            'To_Account'=>$to_accounts,
        ];
        return $this->postData(self::SERVICE_NAME,'black_list_add',$data);
    }

    /**
     * 删除黑名单
     * @param $from_account
     * 需要删除该 UserID 的黑名单
     * @param $to_accounts
     * 待删除的黑名单的 UserID 列表，单次请求的 To_Account 数不得超过1000
     * @return bool|mixed
     */
    public function blackListDelete($from_account,$to_accounts)
    {
        $data = [
            'From_Account'=>$from_account,
            'To_Account'=>$to_accounts,
        ];
        return $this->postData(self::SERVICE_NAME,'black_list_delete',$data);
    }

    /**
     * 拉取黑名单
     * @param $from_account
     * 需要拉取该 UserID 的黑名单
     * @param $start_index
     * 拉取的起始位置
     * @param $max_limited
     * 每页最多拉取的黑名单数
     * @param $last_sequence
     * 上一次拉黑名单时后台返回给客户端的 Seq，初次拉取时为0
     * @return bool|mixed
     */
    public function blackListGet($from_account,$start_index,$max_limited,$last_sequence)
    {
        $data = [
            'From_Account'=>$from_account,
            'StartIndex'=>$start_index,
            'MaxLimited'=>$max_limited,
            'LastSequence'=>$last_sequence,
        ];
        return $this->postData(self::SERVICE_NAME,'black_list_get',$data);
    }

    /**
     * 校验黑名单
     * @param $from_account
     * 需要校验该 UserID 的黑名单
     * @param array $to_accounts
     * 待校验的黑名单的 UserID 列表，单次请求的 To_Account 数不得超过1000
     * @param string $check_type
     * 校验模式
     * BlackCheckResult_Type_Both 双向校验
     * BlackCheckResult_Type_Single 单向校验
     * @return bool|mixed
     */
    public function blackListCheck($from_account,array $to_accounts,$check_type = 'BlackCheckResult_Type_Both')
    {
        $data = [
            'From_Account'=>$from_account,
            'To_Account'=>$to_accounts,
            'CheckType'=>$check_type,
        ];
        return $this->postData(self::SERVICE_NAME,'black_list_check',$data);
    }

    /**
     * 添加分组
     * @param $from_account
     * 	需要为该 UserID 添加新分组
     * @param array $group_names
     * 新增分组列表
     * @param array $to_accounts
     * 需要加入新增分组的好友的 UserID 列表
     * @return bool|mixed
     */
    public function groupAdd($from_account,array $group_names,array $to_accounts =[])
    {
        $data = [
            'From_Account'=>$from_account,
            'GroupName'=>$group_names,
        ];
        if(!empty($to_accounts)){
            $data['To_Account'] = $to_accounts;
        }
        return $this->postData(self::SERVICE_NAME,'group_add',$data);
    }

    /**
     * 删除分组
     * @param $from_account
     * 需要删除该 UserID 的分组
     * @param array $group_names
     * 要删除的分组列表
     * @return bool|mixed
     */
    public function groupDelete($from_account,array $group_names)
    {
        $data = [
            'From_Account'=>$from_account,
            'GroupName'=>$group_names,
        ];
        return $this->postData(self::SERVICE_NAME,'group_delete',$data);
    }
}