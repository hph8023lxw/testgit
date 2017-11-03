<?php
namespace Common\Lib\Cloud;

/**
 * Class Order
 * @package Common\Lib\Cloud
 * @remark  云账户基层类
 */
class Basic{
    public $sysUrl;
    public $timestamp;
    protected $sysSid;
    protected $accountSetNo;
    protected $version;
    public $setCompanyInfoBackUrl;                  //设置企业信息后台回调地址
    public $depositApplyBackUrl;                    //充值申请后台回调地址
    public $withdrawApplyBackUrl;                   //提现申请后台回调地址
    public $consumeApplyBackUrl;                    //消费申请后台回调地址
    public $agentCollectApplySimplifyBackUrl;       //托管代收申请后台回调地址
    public $signalAgentPaySimplifyBackUrl;          //单笔托管代付申请后台回调地址
    private $pfxUrl;
    private $pfxPwd;

    /**
     * @remark  初始化数据
     * User constructor.
     */
    public function __construct()
    {
        $this->sysUrl = C('COULD_CONFIG.sysUrl');
        $this->sysSid = C('COULD_CONFIG.sysSid');
        $this->accountSetNo = C('COULD_CONFIG.accountSetNo');
        $this->pfxUrl = C('COULD_CONFIG.pfxUrl');
        $this->setCompanyInfoBackUrl = '';
        $this->depositApplyBackUrl = '';
        $this->withdrawApplyBackUrl = '';
        $this->consumeApplyBackUrl = '';
        $this->agentCollectApplySimplifyBackUrl = '';
        $this->signalAgentPaySimplifyBackUrl = '';
        $this->pfxPwd = C('COULD_CONFIG.pfxPwd');
        $this->timestamp = date('Y-m-d H:i:s');
        $this->version = '1.0';
    }

    /**
     * @remark 发送数据
     * @param array $param
     * @param string $service
     * @param string $method
     * @return mixed
     */
    public function sendData($param = array() , $service = '' , $method = '')
    {
        $row = [
            'service' => $service,
            'method' => $method,
            'param' => $param,
        ];
        $req = json_encode($row);
        $signParam = $this->sysSid.$req.$this->timestamp;
        $sign = $this->sign($signParam);
        $parameter = 'sysid='.urlencode($this->sysSid).'&sign='.urlencode($sign).'&timestamp='.urlencode($this->timestamp).'&v='.urlencode($this->version).'&req='.urlencode($req);
        $result = json_decode($this->requestCurl($this->sysUrl,$parameter),true);
        return $result;
    }

    /**
     * @remark 生成秘钥
     * @param string $data
     * @return string|void
     */
    public function sign($data = '')
    {
        $certs = array();
        openssl_pkcs12_read(file_get_contents($this->pfxUrl), $certs, $this->pfxPwd); //其中password为你的证书密码
        if(!$certs) return false;
        $signature = '';
        openssl_sign($data, $signature, $certs['pkey']);
        return base64_encode($signature);
    }

    /**
     * @remark 验证签名
     * @param string $data
     * @param string $signature
     * @return bool|void
     */
    public function verifySign($data = '', $signature = ''){
        $certs = array();
        openssl_pkcs12_read(file_get_contents($this->pfxUrl), $certs,  $this->pfxPwd);
        if(!$certs) return false;
        $result = (bool) openssl_verify($data, base64_decode($signature), $certs['cert']); //openssl_verify验签成功返回1，失败0，错误返回-1
        return $result;
    }

    /**
     * @remark 字段加密
     * @param string $data
     * @return string
     */
    public function rsa($data = '')
    {
        $encryptData="";
        $certs = array();
        openssl_pkcs12_read(file_get_contents($this->pfxUrl), $certs, $this->pfxPwd);
        openssl_private_encrypt($data, $encryptData, $certs['pkey']);
        return base64_encode($encryptData);
    }

    /**
     * @remark  字段解密
     * @param string $data
     * @param string $rsaData
     * @return bool
     */
    public  function verifyRsa($data = '' , $rsaData = '')
    {
        $certs = array();
        openssl_pkcs12_read(file_get_contents($this->pfxUrl), $certs,  $this->pfxPwd);
        if(!$certs) return false;
        $result = (bool) openssl_public_encrypt($data, base64_decode($rsaData), $certs['cert']);
        return $result;
    }

    /**
     * @remark  判断是否是直连银行
     * @param string $bankName
     * @return bool
     */
    public function is_unionBank($bankName = '')
    {
        $bool = false;
        $bankRow = [
            '1020000' => '中国工商银行',
            '1030000' => '中国农业银行',
            '1040000' => '中国银行',
            '1050000' => '中国建设银行',
            '3020000' => '中信银行',
            '3030000' => '光大银行',
            '3040000' => '华夏银行',
            '4105840' => '平安银行',
            '3080000' => '招商银行',
            '3090000' => '兴业银行',
            '3100000' => '浦发银行',
            '1000000' => '中国邮政储蓄银行',
            '4083320' => '宁波银行',
            '4243010' => '南京银行',
            '14385500' => '农信湖南',
        ];
        if(in_array($bankName,$bankRow)){
            $bool = true;
        }
        return $bool;
    }

    /**
     * @remark  curl请求数据
     * @param string $url
     * @param array $param
     * @param bool|false $header
     * @return mixed
     */
    public function requestCurl($url = '',$param = array() , $header = false){
        $ch = curl_init();                              //初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);            //设置链接
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //设置是否返回信息
        if($header){
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        if(!empty($param)){
            curl_setopt($ch, CURLOPT_POST, 1);                                  //设置为POST方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);     //POST数据
        }
        $response = curl_exec($ch);         //接收返回信息

        if(curl_errno($ch)){	            //出错则显示错误信息
            print curl_error($ch);
        }
        curl_close($ch);                    //关闭curl链接
        return $response;
    }
}