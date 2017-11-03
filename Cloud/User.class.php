<?php
namespace Common\Lib\Cloud;

use Think\Exception;
require 'Basic.Class.php';

/**
 * Class User
 * @package Common\Lib\Cloud
 * @remark  云账户用户接口
 */
class User extends Basic{

    public $service = 'MemberService';

    #创建会员
    public function createMember($param = array())
    {
        $result = ['code' => 0 , 'msg' => '创建成功' ,'data ' => []];
        try{
            if(empty($param))               E('参数不能为空');
            if(empty($param['bizUserId']))  E('用户标识不能为空');
            if(empty($param['memberType'])) E('会员类型不能为空');
            if(empty($param['source']))     E('访问终端类型不能为空');
            $parameter = [
                'bizUserId'  => $param['bizUserId'],
                'memberType' => $param['memberType'],
                'source'     => $param['source'],
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

    #发送短信验证码
    public function sendVerificationCode($param = array())
    {
        $result = ['code' => 0 , 'msg' => '短信发送成功'];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['phone']))                      E('手机号码不能为空');
            if(empty($param['verificationCodeType']))       E('验证码类型不能为空');
            $parameter = [
                'bizUserId'                 => $param['bizUserId'],
                'phone'                     => $param['phone'],
                'verificationCodeType'      => $param['verificationCodeType'],
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

    #绑定手机
    public function bindPhone($param = array())
    {
        $result = ['code' => 0 , 'msg' => '手机绑定成功'];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['phone']))                      E('手机号码不能为空');
            if(empty($param['verificationCode']))           E('验证码不能为空');
            $parameter = [
                'bizUserId'                 => $param['bizUserId'],
                'phone'                     => $param['phone'],
                'verificationCode'          => $param['verificationCode'],
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

    #重置绑定手机
    public function changeBindPhone($param = array())
    {
        $result = ['code' => 0 , 'msg' => '重置绑定手机成功'];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['oldPhone']))                   E('原手机号码不能为空');
            if(empty($param['newPhone']))                   E('新手机号码不能为空');
            if(empty($param['newVerificationCode']))        E('验证码不能为空');
            $parameter = [
                'bizUserId'                    => $param['bizUserId'],
                'oldPhone'                     => $param['oldPhone'],
                'newPhone'                     => $param['newPhone'],
                'newVerificationCode'          => $param['verificationCode'],
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

    #个人实名认证
    public function setRealName($param = array())
    {
        $result = ['code' => 0 , 'msg' => '实名认证成功'];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['name']))                       E('姓名不能为空');
            if(empty($param['identityNo']))                 E('身份证号码不能为空');
            $parameter = [
                'bizUserId'           => $param['bizUserId'],
                'isAuth'              => true,
                'name'                => $param['name'],                    //目前必须通过云账户认证
                'identityType'        => 1,                                 //目前只支持身份证。
                'identityNo'          => $this->rsa($param['identityNo']),
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

    #设置企业信息
    public function setCompanyInfo($param = array())
    {
        $result = ['code' => 0 , 'msg' => '设置企业信息成功'];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            //企业基础信息
            if(empty($param['companyBasicInfo']))           E('企业基础信息不能为空');
            $companyBasicInfo = $param['companyBasicInfo'];
            if(empty($companyBasicInfo['companyName']))                 E('企业名称不能为空');
            if(empty($companyBasicInfo['companyAddress']))              E('企业地址不能为空');
            if(empty($companyBasicInfo['businessLicense']))             E('营业执照号不能为空');
            if(empty($companyBasicInfo['organizationCode']))            E('组织机构代码不能为空');
            if(empty($companyBasicInfo['telephone']))                   E('联系电话不能为空');
            if(empty($companyBasicInfo['legalName']))                   E('法人姓名不能为空');
            if(empty($companyBasicInfo['identityType']))                E('法人证件类型不能为空');
            if(empty($companyBasicInfo['legalIds']))                    E('法人证件号码不能为空');
            if(empty($companyBasicInfo['legalPhone']))                  E('法人手机号码不能为空');
            if(empty($companyBasicInfo['accountNo']))                   E('企业对公账户不能为空');
            if(empty($companyBasicInfo['parentBankName']))              E('开户银行名称不能为空');
            $is_unionBank = $this->is_unionBank($companyBasicInfo['parentBankName']);
            if($is_unionBank){
                if(empty($companyBasicInfo['unionBank']))              E('支付行号不能为空');
            }
            $parameter = [
                'bizUserId'             => $param['bizUserId'],
                'backUrl'               => $this->setCompanyInfoBackUrl,
                'companyBasicInfo'      => [
                    'companyName'       => $companyBasicInfo['companyName'],
                    'companyAddress'    => $companyBasicInfo['companyAddress'],
                    'businessLicense'   => $companyBasicInfo['businessLicense'],
                    'organizationCode'  => $companyBasicInfo['organizationCode'],
                    'telephone'         => $companyBasicInfo['telephone'],
                    'legalName'         => $companyBasicInfo['legalName'],
                    'identityType'      => $companyBasicInfo['identityType'],
                    'legalIds'          => $this->rsa($companyBasicInfo['legalIds']),
                    'legalPhone'        => $companyBasicInfo['legalPhone'],
                    'accountNo'         => $this->rsa($companyBasicInfo['accountNo']),
                    'parentBankName'    => $companyBasicInfo['parentBankName'],
                    'bankCityNo'        => empty($companyBasicInfo['bankCityNo']) ? '' : $companyBasicInfo['bankCityNo'],   //开户行地区代码
                    'bankName'          => empty($companyBasicInfo['bankName']) ? '' : $companyBasicInfo['bankName'],       //开户行支行名称
                    'unionBank'         => empty($companyBasicInfo['unionBank']) ? '' : $companyBasicInfo['unionBank'],     //支付行号  非直连出金范围内的银行，必填
                ]
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #企业信息审核结果通知[不可用]
    public function verifyResult($param = array())
    {
        return $this->sendData($param ,$this->service , __FUNCTION__);
    }

    #获取会员信息
    public function getMemberInfo($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            $parameter = [
                'bizUserId'           => $param['bizUserId'],
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

    #锁定会员
    public function lockMember($param = array())
    {
        $result = ['code' => 0 , 'msg' => '锁定成功' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            $parameter = [
                'bizUserId'           => $param['bizUserId'],
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

    #解锁会员
    public function unlockMember($param = array())
    {
        $result = ['code' => 0 , 'msg' => '解锁成功' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            $parameter = [
                'bizUserId'           => $param['bizUserId'],
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