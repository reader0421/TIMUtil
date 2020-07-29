<?php


namespace TIMUtil;


use GuzzleHttp\Client;
use TIMUtil\service\Account;
use TIMUtil\service\Group;
use TIMUtil\service\OpenConfigSvr;
use TIMUtil\service\OpenIM;
use TIMUtil\service\Operation;
use TIMUtil\service\Profile;
use TIMUtil\service\Sns;
use TIMUtil\service\UserSign;

class TIMUtil
{
    const DOMAIN = 'https://console.tim.qq.com/v4';

    protected $app_id = '';

    protected $app_secret = '';

    protected $adminIdentifier = 'administrator';

    protected $usersig;

    protected $errMsg = 'ok';

    protected $errCode = 0;



    public function __construct($app_id,$app_secret,$usersig = '',$adminId='')
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        if(!empty($adminId)){
            $this->adminIdentifier = $adminId;
        }
        if(!empty($usersig)){
            $this->usersig = $usersig;
        }
    }

    public function account()
    {
        return new Account($this->app_id,$this->app_secret,$this->usersig,$this->adminIdentifier);
    }

    public function openIM()
    {
        return new OpenIM($this->app_id,$this->app_secret,$this->usersig,$this->adminIdentifier);
    }

    public function profile()
    {
        return new Profile($this->app_id,$this->app_secret,$this->usersig,$this->adminIdentifier);
    }

    public function sns()
    {
        return new Sns($this->app_id,$this->app_secret,$this->usersig,$this->adminIdentifier);
    }

    public function group()
    {
        return new Group($this->app_id,$this->app_secret,$this->usersig,$this->adminIdentifier);
    }

    public function openConfigSvr()
    {
        return new OpenConfigSvr($this->app_id,$this->app_secret,$this->usersig,$this->adminIdentifier);
    }

    public function operation()
    {
        return new Operation($this->app_id,$this->app_secret,$this->usersig,$this->adminIdentifier);
    }

    public function getErrMsg()
    {
        return $this->errMsg;
    }

    public function getErrCode()
    {
        return $this->errCode;
    }

    public function getAdminUserSig()
    {
        if(!empty($this->usersig)){
            return $this->usersig;
        }else{
            //重新获取
            $UserSign = new UserSign($this->app_id,$this->app_secret);
            $sig = $UserSign->genSign($this->adminIdentifier);
            $this->usersig = $sig;
            return $sig;
        }
    }

    public function genUserSig($user_id,$expire_time = 86400*180)
    {
        $UserSign = new UserSign($this->app_id,$this->app_secret);
        return $UserSign->genSign($user_id,$expire_time);
    }

    public function setAdminId($id)
    {
        $this->adminIdentifier = $id;
        return $this;
    }

    protected function postData($service_name,$command,$data)
    {
        $url = self::DOMAIN.'/'.$service_name.'/'.$command;
        $http = new Client();
        $sign = $this->getAdminUserSig();
        $random = mt_rand(0, 4294967295);
        try{
            $response = $http->post($url,[
                'query'=>[
                    'sdkappid'=>$this->app_id,
                    'identifier'=>$this->adminIdentifier,
                    'usersig'=>$sign,
                    'random'=>$random,
                    'contenttype'=>'json'
                ],
                'json'=>$data,
            ]);
            $code = $response->getStatusCode();
            if($code != 200){
                $this->error = $response->getReasonPhrase();
                return false;
            }
            $body = $response->getBody()->getContents();
            if (!empty($body) && !empty($body = json_decode($body))) {
                if (!empty($body->ErrorCode) || !isset($body->ActionStatus) || (strtolower($body->ActionStatus) !== 'ok')) {
                    $this->errMsg = $body->ErrorInfo ?? '请求失败';
                    $this->errCode = $body->ErrorCode ?? -1;
                    return false;
                }
                return $body;
            }
            $this->errMsg = -1;
            $this->errCode = '请求失败';
            return false;
        }catch (\Exception $e){
            $this->errMsg = $e->getMessage();
            $this->errCode = $e->getCode();
            return false;
        }
    }
}