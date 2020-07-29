<?php

use TIMUtil\TIMUtil;

require '../vendor/autoload.php';

$app_id = '';
$app_secret = '';

$TIM = new TIMUtil($app_id,$app_secret);


////创建账号
$account = $TIM->account();

$res = $account->accountImport('test1','test1');
var_dump($res);
var_dump($account->getErrCode());
var_dump($account->getErrMsg());

$res = $account->accountImport('test2','test2');
var_dump($res);

//获取UserSig
$sign = $TIM->genUserSig('test1');
var_dump($sign);

//添加好友
$sns = $TIM->sns();

$res = $sns->friendAdd('test1',[
      [
          "To_Account"=>"test2",
         "AddSource"=>"AddSource_Type_Android",
          "Remark"=>'test',
        "AddWording"=>"test1想加你好友"
      ]
  ]);
var_dump($res);

////发消息

////组装消息内容
$msg_body = new \TIMUtil\msg\MsgBody();
$body = $msg_body->createTextMsg('你好')
    ->createTextMsg('啊');
//离线消息
$offlineBuilder = new \TIMUtil\msg\OfflinePushInfo();
$offline = $offlineBuilder->setPushFlag(1)
    ->setTitle('推送标题')
    ->setDesc('推送内容');

$builder = new \TIMUtil\msg\MsgBuilder();
$msg = $builder->setMsgBody($body)
    ->setFromAccount('test2')
    ->setToAccount('test1')
    ->setSyncOtherMachine()
    ->setOfflinePushInfo($offlineBuilder);
$openIM = $TIM->openIM();
$res = $openIM->sendMsg($msg);
var_dump($res);

//建立群组
$group = $TIM->group();
$res = $group->createGroup('Public','test_group','test_group','test1');
var_dump($res);
var_dump($group->getErrCode());
var_dump($group->getErrMsg());
//拉人
$res = $group->addGroupMember('test_group',[["Member_Account"=>"test2"]]);
var_dump($res);
//发送消息
$random = rand(1000,9999);
$res = $group->sendGroupMsg('test_group',$random,$body->getBody(),'test1');
var_dump($res);





