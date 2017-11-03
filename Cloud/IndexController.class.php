<?php
namespace Cloud\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
//        $user = new \Common\Lib\Cloud\User();
        $Pwd = new \Common\Lib\Cloud\Pwd();
//        $Card = new \Common\Lib\Cloud\Card();

        #获取会员信息
//        $param = [
//            'bizUserId' => 'yunBizUserId_B2C_weidao_666',   //3f3cfbe9-06e7-4a86-bf11-be9c0d704068
//        ];
//        $res = $user->getMemberInfo($param);

        #重置新移动快捷支付密码申请（发短信验证码）
//        $param = [
//            'bizUserId'         => 'yunBizUserId_B2C_weidao_666',
//            'name'              => '何鹏辉',
//            'identityNo'        => '421222199207167211',
//        ];
//        $res = $Pwd->resetNewMobilePayPwdApply($param);

        #设置/ 修改新移动快捷支付密码        ：仅支持个人会员
//        $param = [
//            'bizUserId'         => 'yunBizUserId_B2C_weidao_666',
//            'operationType'     => 'edit',                   //edit
//            'name'              => '何鹏辉',
//            'identityNo'        => '421222199207167211',
//            'oldPassword'       => '163542',
//            'newPassword'       => '163543',
//        ];
//        $res = $Pwd->setNewMobilePayPwd($param);

        #查询绑定银行卡
//        $param = [
//            'bizUserId'              => 'yunBizUserId_B2C_weidao_666',
//            'cardNo'                 => '6228480402637874214',
//        ];
//        $res = $Card->queryBankCard($param);

        #解绑绑定银行卡
//        $param = [
//            'bizUserId'              => 'yunBizUserId_B2C_weidao_666',
//            'cardNo'                 => '6228480402637874214',
//        ];
//        $res = $Card->unbindBankCard($param);

        #设置安全卡
//        $param = [
//            'bizUserId'              => 'yunBizUserId_B2C_weidao_666',
//            'cardNo'                 => '6228480688862785278',
//        ];
//        $res = $Card->setSafeCard($param);

        #三要素绑定银行卡
//        $param = [
//            'bizUserId'              => 'yunBizUserId_B2C_weidao_666',
//            'cardNo'                 => '6228480402637874214',
//            'name'                   => '何鹏辉',
//            'identityNo'             => '421222199207167211',
//            'isSafeCard'             => false,          //信用卡时不能填写：true:设置为安全卡，false:不设置。默认为 false
//            'unionBank'              => '',
//        ];
//        $res = $Card->threeElementsBindBankCard($param);

        #确认绑定卡
//        $param = [
//            'bizUserId'              => 'yunBizUserId_B2C_weidao_666',
//            'tranceNum'              => '1103113956000861',
//            'transDate'              => '',
//            'cardCheck'              => 4,
//            'phone'                  => '13560705508',
//            'verificationCode'       => '445055',
//        ];
//        $res = $Card->bindBankCard($param);

        #请求绑定银行卡    三要素（持卡人、身份证、卡号）可直接调用确认绑定卡
//        $param = [
//            'bizUserId'              => 'yunBizUserId_B2C_weidao_666',
//            'cardNo'                 => '6228480401234564214',
//            'phone'                  => '13560705508',
//            'name'                   => '何鹏辉',
//            'cardCheck'              => 4,
//            'identityNo'             => '421222199207167211',
//            'validate'               => '',             //信用卡必填
//            'cvv2'                   => '',
//            'isSafeCard'             => '',             //信用卡时不能填写：true:设置为安全卡，false:不设置。默认为 false
//            'unionBank'              => '',
//        ];
//        $res = $Card->applyBindBankCard($param);

        #查询卡
//        $param = [
//            'cardNo' => '6228480688862785278',   //3f3cfbe9-06e7-4a86-bf11-be9c0d704068
//        ];
//        $res = $Card->getBankCardBin($param);
        
        #锁定/解锁会员
//        $param = [
//            'bizUserId' => 'yunBizUserId_B2C_weidao_666',   //3f3cfbe9-06e7-4a86-bf11-be9c0d704068
//        ];
//        $res = $user->unlockMember($param); //lockMember

        #设置企业信息
//        $param = [
//            'bizUserId' => '8023',
//            'backUrl' => 'http://',     //企业会员审核成功或者失败，将会发送后台通知
//            //企业基础信息
//            'companyBasicInfo' => [
//                'companyName' => '',
//                'companyAddress' => '',
//                'businessLicense' => '',
//                'organizationCode' => '',
//                'telephone' => '',
//                'legalName' => '',
//                'identityType' => '',
//                'legalIds' => '',
//                'legalPhone' => '',
//                'accountNo' => '',
//                'parentBankName' => '',
//                'bankCityNo' => '',
//                'bankName' => '',
//                'unionBank' => '',
//            ],
//        ];
//        $res = $user->setCompanyInfo($param);

        #个人实名认证
//        $param = [
//            'bizUserId' => 'yunBizUserId_B2C_weidao_666',
//            'name' => '何鹏辉',
//            'identityNo' => '421222199207167211',
//        ];
//        $res = $user->setRealName($param);

        #重置绑定手机
//        $param = [
//            'bizUserId' => 'yunBizUserId_B2C_weidao_666',
//            'oldPhone' => '13560705508',
//            'newPhone' => '13530020109',
//            'newVerificationCode' => '473801',
//        ];
//        $res = $user->changeBindPhone($param);

        #绑定手机
//        $param = [
//            'bizUserId' => 'yunBizUserId_B2C_weidao_666',
//            'phone' => '13560705508',
//            'verificationCode' => '482150',
//        ];
//        $res = $user->bindPhone($param);

        #发送短信
//        $param = [
//            'bizUserId' => 'yunBizUserId_B2C_weidao_666',
//            'phone' => '13560705508',
//            'verificationCodeType' => '6', //9:绑定手机、6：解绑手机
//        ];
//        $res = $user->sendVerificationCode($param);

        #创建会员
//        $param = [
//            'bizUserId' => 'yunBizUserId_B2C_weidao_888',
//            'memberType' => 3,
//            'source' => 1,
//        ];
//        $res = $user->createMember($param);

        print_r($res);
        exit;

    }
}