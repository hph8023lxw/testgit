<?php
namespace Common\Lib\Cloud;

require 'Basic.Class.php';
/**
 * Class Order
 * @package Common\Lib\Cloud
 * @remark  云账户订单接口
 */
class Order extends Basic{

    public $service = 'OrderService';

    #充值申请
    public function depositApply($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['bizOrderNo']))                 E('商户订单号不能为空');
            if(empty($param['amount']))                     E('订单金额不能为空');
            if(empty($param['fee']))                        E('手续费不能为空');
            if(empty($param['payMethod']))                  E('支付方式不能为空');
            if(empty($param['industryCode']))               E('行业代码不能为空');
            if(empty($param['industryName']))               E('行业名称不能为空');
            if(empty($param['source']))                     E('访问终端类型不能为空');
            $payMethod = $param['payMethod'];

            $parameter = [
                'bizUserId'                 => $param['bizUserId'],
                'bizOrderNo'                => $param['bizOrderNo'],
                'accountSetNo'              => $this->accountSetNo,
                'amount'                    => $param['amount'],
                'fee'                       => $param['fee'],
                'validateType'              => $param['validateType'],
                'frontUrl'                  => $param['frontUrl'],
                'backUrl'                   => $this->depositApplyBackUrl,
                'ordErexpireDatetime'       => $param['ordErexpireDatetime'],
                'payMethod'                 => $this->getPayMethod($payMethod),
                'industryCode'              => $param['industryCode'],
                'industryName'              => $param['industryName'],
                'source'                    => $param['source'],
                'summary'                   => $param['summary'],
                'extendInfo'                => $param['extendInfo'],
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

    /**
     * @remark  获取支付方式
     * @param array $payMethod
     * @return array
     */
    public function getPayMethod($payMethod = array()){
        $result = [];
        foreach($payMethod as $key => $val){
            switch($key){
                case 'QUICKPAY_N':  #新移动快捷支付
                    $result[$key]['bankCardNo'] = $this->rsa($val['bankCardNo']);
                    $result[$key]['amount']     = $val['amount'];
                    break;
                case 'WITHDRAW_TLT':    #通联通代付
                    $result[$key]['payTypeName'] = $val['payTypeName'];
                    $result[$key]['unionBank']   = $val['unionBank'];
                    break;
                case 'BALANCE':    #账户余额
                    foreach($val as $k=>$v){
                        $result[$key][$k]['accountSetNo'] = $v['accountSetNo'];
                        $result[$key][$k]['amount']   = $v['amount'];
                    }
                    break;
                default:
                    break;
            }
        }
        return $result;
    }

    #提现申请
    public function withdrawApply($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['bizOrderNo']))                 E('商户订单号不能为空');
            if(empty($param['amount']))                     E('订单金额不能为空');
            if(empty($param['fee']))                        E('手续费不能为空');
            if(empty($param['payMethod']))                  E('支付方式不能为空');
            if(empty($param['bankCardNo']))                 E('银行卡号/账号不能为空');
            if(empty($param['industryCode']))               E('行业代码不能为空');
            if(empty($param['industryName']))               E('行业名称不能为空');
            if(empty($param['source']))                     E('访问终端类型不能为空');
            $parameter = [
                'bizUserId'                 => $param['bizUserId'],
                'bizOrderNo'                => $param['bizOrderNo'],
                'accountSetNo'              => $this->accountSetNo,
                'amount'                    => $param['amount'],
                'fee'                       => $param['fee'],
                'validateType'              => $param['validateType'],
                'backUrl'                   => $this->withdrawApplyBackUrl,
                'ordErexpireDatetime'       => $param['ordErexpireDatetime'],
                'payMethod'                 => $param['payMethod'],             /****************/
                'bankCardNo'                => $param['bankCardNo'],
                'bankCardPro'               => $param['bankCardPro'],
                'withdrawType'              => $param['withdrawType'],
                'industryCode'              => $param['industryCode'],
                'industryName'              => $param['industryName'],
                'source'                    => $param['source'],
                'summary'                   => $param['summary'],
                'extendInfo'                => $param['extendInfo'],
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

    #消费申请
    public function consumeApply($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['payerId']))                    E('消费用户标识不能为空');
            if(empty($param['recieverId']))                 E('消费商户标识不能为空');
            if(empty($param['bizOrderNo']))                 E('商户订单号不能为空');
            if(empty($param['amount']))                     E('订单金额不能为空');
            if(empty($param['fee']))                        E('手续费不能为空');
            if(empty($param['payMethod']))                  E('支付方式不能为空');
            if(empty($param['industryCode']))               E('行业代码不能为空');
            if(empty($param['industryName']))               E('行业名称不能为空');
            if(empty($param['source']))                     E('访问终端类型不能为空');
            $parameter = [
                'payerId'                   => $param['payerId'],           //消费用户的 bizUserId，支持个人会员、企业会员
                'recieverId'                => $param['recieverId'],        //消费商户的 bizUserId，支持个人会员、企业会员、平台自身。如果是平台自身，参数值
                'bizOrderNo'                => $param['bizOrderNo'],
                'amount'                    => $param['amount'],
                'fee'                       => $param['fee'],
                'validateType'              => $param['validateType'],
                'backUrl'                   => $this->consumeApplyBackUrl,
                'ordErexpireDatetime'       => $param['ordErexpireDatetime'],
                'payMethod'                 => $param['payMethod'],             /****************/
                'goodsName'                 => $param['goodsName'],
                'goodsDesc'                 => $param['goodsDesc'],
                'industryCode'              => $param['industryCode'],
                'industryName'              => $param['industryName'],
                'source'                    => $param['source'],
                'summary'                   => $param['summary'],
                'extendInfo'                => $param['extendInfo'],
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

    #托管代收申请（简化版）
    public function agentCollectApplySimplify($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['payerId']))                    E('付款用户标识不能为空');
            if(empty($param['bizOrderNo']))                 E('商户订单号不能为空');
            if(empty($param['amount']))                     E('订单金额不能为空');
            if(empty($param['tradeCode']))                  E('业务码不能为空');
            if(empty($param['payMethod']))                  E('支付方式不能为空');
            if(empty($param['industryCode']))               E('行业代码不能为空');
            if(empty($param['industryName']))               E('行业名称不能为空');
            if(empty($param['source']))                     E('访问终端类型不能为空');
            $parameter = [
                'payerId'                   => $param['payerId'],           //付款用户 bizUserId，支持个人会员、企业会员
                'bizOrderNo'                => $param['bizOrderNo'],
                'goodsType'                 => $param['goodsType'],
                'goodsNo'                   => $param['goodsNo'],
                'amount'                    => $param['amount'],
                'fee'                       => $param['fee'],
                'validateType'              => $param['validateType'],
                'frontUrl'                  => $param['frontUrl'],
                'backUrl'                   => $this->agentCollectApplySimplifyBackUrl,
                'ordErexpireDatetime'       => $param['ordErexpireDatetime'],
                'payMethod'                 => $param['payMethod'],                     /****************/
                'goodsName'                 => $param['goodsName'],
                'goodsDesc'                 => $param['goodsDesc'],
                'industryCode'              => $param['industryCode'],
                'industryName'              => $param['industryName'],
                'source'                    => $param['source'],
                'summary'                   => $param['summary'],
                'extendInfo'                => $param['extendInfo'],
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

    #单笔托管代付（简化版）
    public function signalAgentPaySimplify($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('收款用户标识不能为空');
            if(empty($param['bizOrderNo']))                 E('商户订单号不能为空');
            if(empty($param['amount']))                     E('订单金额不能为空');
            if(empty($param['fee']))                        E('手续费不能为空');
            if(empty($param['tradeCode']))                  E('业务码不能为空');
            $payToBankCardInfo = $param['payToBankCardInfo'];   //如果是代付到银行账户，则必填
            $splitRuleList = $param['splitRuleList'];   //内扣。支持分账到会员或者平台账户
            $parameter = [
                'bizUserId'                 => $param['bizUserId'],
                'bizOrderNo'                => $param['bizOrderNo'],
                'accountSetNo'              => $this->accountSetNo,
                'backUrl'                   => $this->signalAgentPaySimplifyBackUrl,
                'payToBankCardInfo'         => $payToBankCardInfo,         /****************/
                'amount'                    => $param['amount'],
                'fee'                       => $param['fee'],
                'splitRuleList'             => $splitRuleList,             /****************/
                'goodsType'                 => $param['goodsType'],
                'goodsNo'                   => $param['goodsNo'],
                'tradeCode'                 => $param['tradeCode'],
                'summary'                   => $param['summary'],
                'extendInfo'                => $param['extendInfo'],
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

    #批量托管代付（简化版）
    public function batchAgentPaySimplify($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizBatchNo']))                 E('收款用户标识不能为空');
            if(empty($param['tradeCode']))                  E('业务码不能为空');
            $batchPayList = $param['batchPayList'];       //如果是代付到银行账户，则必填
            $parameter = [
                'bizBatchNo'                => $param['bizBatchNo'],
                'batchPayList'              => [
                    'bankCardNo'            =>  $this->rsa($batchPayList['bankCardNo']),
                    'bankName'              =>  $batchPayList['bankName'],
                    'bindTime'              =>  $batchPayList['bindTime'],
                    'cardType'              =>  $batchPayList['cardType'],
                    'bindState'             =>  $batchPayList['bindState'],
                    'phone'                 =>  $batchPayList['phone'],
                    'isSafeCard'            =>  $batchPayList['isSafeCard'],
                    'isVerifyPayChecked'    =>  $batchPayList['isVerifyPayChecked'],
                    'IsQUICKPAYCard'        =>  $batchPayList['IsQUICKPAYCard'],
                    'bindMethod'            =>  $batchPayList['bindMethod'],
                ],
                'goodsType'                 => $param['goodsType'],
                'goodsNo'                   => $param['goodsNo'],
                'tradeCode'                 => $param['tradeCode'],
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

    #确认支付（后台+ +短信验证码确认）
    public function pay($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['bizOrderNo']))                 E('商户订单号不能为空');
            if(empty($param['verificationCode']))           E('短信验证码不能为空');
            if(empty($param['consumerIp']))                 E('ip 地址不能为空');
            $parameter = [
                'bizUserId'                 => $param['bizUserId'],
                'bizOrderNo'                => $param['bizOrderNo'],
                'tradeNo'                   => empty($param['tradeNo']) ? '' : $param['tradeNo'],
                'verificationCode'          => $param['verificationCode'],
                'consumerIp'                => $param['consumerIp'],
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

    #退款
    public function refund($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['bizOrderNo']))                 E('商户订单号不能为空');
            if(empty($param['oriBizOrderNo']))              E('商户原订单号不能为空');
            if(empty($param['amount']))                     E('本次退款总金额不能为空');   //单位：分
            $parameter = [
                'bizUserId'                 => $param['bizUserId'],
                'bizOrderNo'                => $param['bizOrderNo'],
                'oriBizOrderNo'             => $param['oriBizOrderNo'],
                'refundList'                => $param['refundList'],
                'backUrl'                   => $param['backUrl'],
                'amount'                    => $param['amount'],
                'feeAmount'                 => $param['feeAmount'],
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

    #冻结金额
    public function freezeMoney($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['bizFreezenNo']))               E('订单号不能为空');
            if(empty($param['amount']))                     E('金额不能为空');   //单位：分
            $parameter = [
                'bizUserId'             => $param['bizUserId'],
                'bizFreezenNo'          => $param['bizFreezenNo'],
                'accountSetNo'          => $this->accountSetNo,
                'amount'                => $param['amount'],
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

    #解冻金额
    public function unfreezeMoney($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['bizFreezenNo']))               E('订单号不能为空');
            if(empty($param['amount']))                     E('金额不能为空');   //单位：分
            $parameter = [
                'bizUserId'             => $param['bizUserId'],
                'bizFreezenNo'          => $param['bizFreezenNo'],
                'accountSetNo'          => $this->accountSetNo,
                'amount'                => $param['amount'],
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

    #平台转账
    public function applicationTransfer($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizTransferNo']))              E('商户系统转账编号不能为空');
            if(empty($param['sourceAccountSetNo']))         E('源账户集编号不能为空');
            if(empty($param['targetBizUserId']))            E('目标商户系统用户标识不能为空');
            if(empty($param['targetAccountSetNo']))         E('目标账户集编号不能为空');
            if(empty($param['amount']))                     E('金额不能为空');
            $parameter = [
                'bizTransferNo'         => $param['bizTransferNo'],
                'sourceAccountSetNo'    => $param['sourceAccountSetNo'],
                'targetBizUserId'       => $param['targetBizUserId'],
                'targetAccountSetNo'    => $param['targetAccountSetNo'],
                'amount'                => $param['amount'],
                'remark'                => $param['remark'],
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

    #查询余额
    public function queryBalance($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            $parameter = [
                'bizUserId'         => $param['bizUserId'],
                'accountSetNo'      => $this->accountSetNo,
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

    #查询订单状态
    public function getOrderDetail($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['bizOrderNo']))                 E('用户标识不能为空');
            $parameter = [
                'bizUserId'         => $param['bizUserId'],
                'bizOrderNo'        => $param['bizOrderNo'],
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

    #查询账户收支明细
    public function queryInExpDetail($param = array())
    {
        $result = ['code' => 0 , 'msg' => '' ,'data ' => []];
        try{
            if(empty($param))                               E('参数不能为空');
            if(empty($param['bizUserId']))                  E('用户标识不能为空');
            if(empty($param['startPosition']))              E('起始位置不能为空');
            if(empty($param['queryNum']))                   E('查询条数不能为空');
            $parameter = [
                'bizUserId'         => $param['bizUserId'],
                'accountSetNo'      => $this->accountSetNo,
                'dateStart'         => $param['dateStart'],
                'dateEnd'           => $param['dateEnd'],
                'startPosition'     => $param['startPosition'],
                'queryNum'          => $param['queryNum'],
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