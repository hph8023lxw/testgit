<?php
namespace Common\Lib\Cloud;
use Think\Exception;

require 'Basic.Class.php';
/**
 * Class Card
 * @package Common\Lib\Cloud
 * @remark  云账户银行卡接口
 */
class Card extends Basic{

    public $service = 'MemberService';

    #查询卡
    public function getBankCardBin($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['cardNo']))                     E('银行卡号不能为空');
            $parameter = [
                'cardNo'              => $this->rsa($param['cardNo']),
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = json_decode($response['signedValue'],true);
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #请求绑定银行卡
    public function applyBindBankCard($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['cardNo']))                     E('银行卡号不能为空');
            if(empty($param['phone']))                      E('银行预留手机不能为空');
            if(empty($param['name']))                       E('姓名不能为空');
            if(empty($param['identityNo']))                 E('证件号码不能为空');
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'cardNo'                 => $this->rsa($param['cardNo']),
                'phone'                  => $param['phone'],
                'name'                   => $param['name'],
                'cardCheck'              => $param['cardCheck'],                      //默认4要素
                'identityType'           => 1,                      //只支持身份证
                'identityNo'             => $this->rsa($param['identityNo']),
                'validate'               => empty($param['validate']) ? '' : $this->rsa($param['validate']),    //信用卡必填
                'cvv2'                   => $param['cvv2'],
                'isSafeCard'             => empty($param['isSafeCard']) ? false : true,          //信用卡时不能填写：true:设置为安全卡，false:不设置。默认为 false
                'unionBank'              => $param['unionBank'],
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = json_decode($response['signedValue'],true);
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #确认绑定银行卡
    public function bindBankCard($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['tranceNum']))                  E('流水号不能为空');
            if(empty($param['phone']))                      E('银行预留手机不能为空');
            if(empty($param['verificationCode']))           E('短信验证码不能为空');
            if($param['cardCheck'] == 2) {
                if(empty($param['transDate']))                  E('申请时间不能为空');
            }
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'tranceNum'              => $param['tranceNum'],
                'transDate'              => $param['transDate'],
                'phone'                  => $param['phone'],
                'verificationCode'       => $param['verificationCode'],
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = json_decode($response['signedValue'],true);
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #实名付绑定银行卡申请
    public function applyVerifyPayBindBankCard($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['cardNo']))                     E('银行卡号不能为空');
            if(empty($param['phone']))                      E('银行预留手机不能为空');
            if(empty($param['name']))                       E('姓名不能为空');
            if(empty($param['identityType']))               E('证件类型不能为空');
            if(empty($param['identityNo']))                 E('证件号码不能为空');
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'cardNo'                 => $this->rsa($param['cardNo']),
                'phone'                  => $param['phone'],
                'name'                   => $param['name'],
                'identityType'           => $param['identityType'],
                'identityNo'             => $this->rsa($param['identityNo']),
                'isSafeCard'             => $param['isSafeCard'],          //信用卡时不能填写：true:设置为安全卡，false:不设置。默认为 false
                'unionBank'              => $param['unionBank'],
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = json_decode($response['signedValue'],true);
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #实名付绑定银行卡确认
    public function affirmVerifyPayBindCard($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['tranceNum']))                  E('流水号不能为空');
            if(empty($param['verificationCode']))           E('短信验证码不能为空');
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'tranceNum'              => $param['tranceNum'],
                'verificationCode'       => $param['verificationCode'],
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = json_decode($response['signedValue'],true);
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #三要素绑定银行卡
    public function threeElementsBindBankCard($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['cardNo']))                     E('银行卡号不能为空');
            if(empty($param['name']))                       E('姓名不能为空');
            if(empty($param['identityNo']))                 E('证件号码不能为空');
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'cardNo'                 => $this->rsa($param['cardNo']),
                'name'                   => $param['name'],
                'identityType'           => 1,
                'identityNo'             => $this->rsa($param['identityNo']),
                'isSafeCard'             => $param['isSafeCard'],          //信用卡时不能填写：true:设置为安全卡，false:不设置。默认为 false
                'unionBank'              => $param['unionBank'],
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = json_decode($response['signedValue'],true);
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #设置安全卡
    public function setSafeCard($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['cardNo']))                     E('银行卡号不能为空');
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'cardNo'                 => $this->rsa($param['cardNo']),
                'isSafeCard'             => true,
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = json_decode($response['signedValue'],true);
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #查询绑定银行卡
    public function queryBankCard($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['cardNo']))                     E('银行卡号不能为空');
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'cardNo'                 => $this->rsa($param['cardNo']),
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = json_decode($response['signedValue'],true);
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #解绑绑定银行卡
    public function unbindBankCard($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['cardNo']))                     E('银行卡号不能为空');
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'cardNo'                 => $this->rsa($param['cardNo']),
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = json_decode($response['signedValue'],true);
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

}