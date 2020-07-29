<?php


namespace TIMUtil\service;


use TIMUtil\TIMUtil;

/**
 * 资料管理
 * Class Profile
 * @package TIMUtil\service
 */
class Profile extends TIMUtil
{
    const SERVICE_NAME = 'profile';

    /**
     * 设置资料
     * @param $from_account
     * 需要设置该 UserID 的资料
     * @param array $items
     * 待设置的用户的资料对象数组，数组中每一个对象都包含了 Tag 和 Value
     * @return bool|mixed
     */
    public function portraitSet($from_account,array $items)
    {
        $data = [
            'From_Account'=>$from_account,
            'ProfileItem'=>$items
        ];
        return $this->postData(self::SERVICE_NAME,'portrait_set',$data);
    }

    /**
     * 拉去资料
     * @param $to_account
     * 需要拉取这些 UserID 的资料；
     * 注意：每次拉取的用户数不得超过100，避免因回包数据量太大以致回包失败
     * @param array $tag_list
     * 指定要拉取的资料字段的 Tag
     * @return bool|mixed
     */
    public function portraitGet($to_account,array $tag_list)
    {
        $data = [
            'To_Account'=>$to_account,
            'TagList'=>$tag_list
        ];
        return $this->postData(self::SERVICE_NAME,'portrait_get',$data);
    }
}