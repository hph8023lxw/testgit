<?php
date_default_timezone_set('PRC');
require_once 'SOAClient.php';
require_once 'RSAUtil.php';

$client = new SOAClient();
//服务地址
$serverAddress = "http://122.227.225.142:23661/service/soa";
//商户号
$sysid = "100000000002";
//证书名称
$alias = "100000000002";
//证书地址
$path = "test.pem";
//证书密码
$pwd = "697057";
$signMethod = "SHA1WithRSA";
$privateKey = RSAUtil::loadPrivateKey($alias, $path, $pwd);
$publicKey = RSAUtil::loadPublicKey($alias, $path, $pwd);
/*
echo '<br>'.$sss = rsaEncrypt("a", $publicKey, $privateKey);
echo '<br>'.rsaDecrypt($sss, $publicKey, $privateKey);
*/

$client->setServerAddress($serverAddress);
$client->setSignKey($privateKey);
$client->setPublicKey($publicKey);
$client->setSysId($sysid);
$client->setSignMethod($signMethod);

//调用接口
createMember($client);   
setRealName($client, $privateKey, $privateKey);  

	//创建会员
	function createMember($client) {
		$param["bizUserId"] = "";      //商户系统用户标识，商户系统中唯一编号
		$param["memberType"] = "3";    //会员类型
		$param["source"] = "1";        //访问终端类型
		$result = $client->request("MemberService", "createMember", $param);
		print_r($result);
	}
	
	//实名认证
	function setRealName($client, $privateKey, $privateKey) {
		$param["bizUserId"] = "";      //商户系统用户标识，商户系统中唯一编号
		$param["name"] = "";           //姓名
		$param["identityType"] = "1";  //证件类型
		$param["identityNo"] = rsaEncrypt("", $privateKey, $privateKey);  //证件号码，加密

		$result = $client->request("MemberService", "setRealName", $param);
		print_r($result);
	}
	
	//加密
	function rsaEncrypt($str, $publicKey, $privateKey) {
		$rsaUtil = new RSAUtil($publicKey, $privateKey);
		$encryptStr = $rsaUtil->encrypt($str);
		return $encryptStr;
	}
	
	//解密
	function rsaDecrypt($str, $publicKey, $privateKey) {
		$rsaUtil = new RSAUtil($publicKey, $privateKey);
		$encryptStr = $rsaUtil->decrypt($str);
		return $encryptStr;
	}
?>