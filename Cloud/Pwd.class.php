<?php
namespace Common\Lib\Cloud;

use Think\Exception;

require 'Basic.Class.php';

/**
 * Class User
 * @package Common\Lib\Cloud
 * @remark  云账户用户密码设置接口
 */
class Pwd extends Basic{

    public $service = 'MemberPwdService';

    #设置/ 修改新移动快捷支付密码        ：仅支持个人会员
    public function setNewMobilePayPwd($param = array())
    {
        $result = ['code' => 0 , 'msg' => '设置密码成功'];
        try{
            if(empty($param))                       E('参数不能为空');
            if(empty($param['bizUserId']))          E('用户标识不能为空');
            if(empty($param['operationType']))      E('操作不能为空');    //set：设置 、edit：修改
            if(empty($param['name']))               E('姓名不能为空');
            if(empty($param['identityNo']))         E('证件号码不能为空');
            if(empty($param['newPassword']))        E('新支付密码不能为空');
            if($param['operationType'] == 'edit'){
                if(empty($param['oldPassword']))        E('原支付密码不能为空');
            }
            $parameter = [
                'bizUserId'         => $param['bizUserId'],
                'operationType'     => $param['operationType'],
                'name'              => $param['name'],
                'identityType'      => 1,           //证件类型：目前只支持身份证
                'identityNo'        => $this->rsa($param['identityNo']),
                'oldPassword'       => empty($param['oldPassword']) ? '' : $this->rsa($param['oldPassword']),
                'newPassword'       => $this->rsa($param['newPassword']),
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = $response['signedValue'];
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #重置新移动快捷支付密码申请（发短信验证码）
    public function resetNewMobilePayPwdApply($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['name']))                       E('姓名不能为空');
            if(empty($param['identityNo']))                 E('证件号码不能为空');
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'name'                   => $param['name'],
                'identityType'           => 1,
                'identityNo'             => $this->rsa($param['identityNo']),
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = $response['signedValue'];
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }

    #重置新移动快捷支付密码确认
    public function resetNewMobilePayPwdAffrim($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['name']))                       E('姓名不能为空');
            if(empty($param['identityType']))               E('证件类型不能为空');
            if(empty($param['identityNo']))                 E('证件号码不能为空');
            if(empty($param['payPassword']))                E('支付密码不能为空');
            if(empty($param['lastCardNo']))                 E('用户最近绑定的银行卡号不能为空');
            if(empty($param['mobileFlowNO']))               E('短信发送流水号不能为空');
            if(empty($param['mobileMsCode']))               E('短信验证码不能为空');
            $parameter = [
                'bizUserId'              => $param['bizUserId'],
                'name'                   => $param['name'],
                'identityType'           => $param['identityType'],
                'identityNo'             => $this->rsa($param['identityNo']),
                'payPassword'            => $this->rsa($param['payPassword']),
                'lastCardNo'             => $this->rsa($param['lastCardNo']),
                'mobileFlowNO'           => $param['mobileFlowNO'],
                'mobileMsCode'           => $param['mobileMsCode'],
            ];
            $response = $this->sendData($parameter ,$this->service , __FUNCTION__);
            if(empty($response) || $response['status'] == 'error'){
                E($response['message']);
            }
            $result['data'] = $response['signedValue'];
            $result['code'] = 1;
        }catch(Exception $e){
            $result['msg'] = $e->getMessage();
        }
        return $result;
    }
}