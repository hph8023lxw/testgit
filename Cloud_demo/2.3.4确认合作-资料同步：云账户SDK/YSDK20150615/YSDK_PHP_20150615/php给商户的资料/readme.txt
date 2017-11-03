Test.php:测试入口类
RSAUtil.php,SOAClient.php：辅助类
requestPayFront_forTest.php：网关支付请求
getPayFront.php：接收网关前台、后台返回示例

请将pfx文件转成pem文件
openssl pkcs12 -in xxxxxxxxx.pfx -out test.pem
（
	xxxxxxxxx.pfx 证书文件，请根据实际情况填写。
	建议pem密码和pfx密码保持一致。
）

证书等相关文件请向运营人员要求提供。