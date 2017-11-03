using System;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using ime.service.client;
using ime.service.util;
using System.Security.Cryptography;
using Newtonsoft.Json.Linq;

namespace yun.test.net
{
    [TestClass]
    public class yunTest
    {
        //soa客户对象
        private static SOAClient soaClient;
        //公钥
        private static RSACryptoServiceProvider publicKey = null;
        //私钥
        private static RSACryptoServiceProvider privateKey = null;
        //soa名
        private static string soaName = "MemberService";  //用户类SOA


        [TestInitialize]
        public void BeforeTest()
        {
            //soa请求地址
            string serverAddress = "http://122.227.225.142:23661/service/soa";
            //商户号
            String sysid = "";
            //密钥密码
            String pwd = "";
            //证书名称
            String alias = "";
            //证书文件路径，用户指定
            String path = "";

            try
            {
                publicKey = RSAUtil.loadPublicKey(alias, path, pwd);
                privateKey = RSAUtil.loadPrivateKey(alias, path, pwd);
                soaClient = new SOAClient();
                soaClient.setServerAddress(serverAddress);
                soaClient.setPrivateKey(privateKey);
                soaClient.setPublicKey(publicKey);
                soaClient.setSysId(sysid);

                System.Console.WriteLine("beforeClass success");
            }catch(Exception e)
            {
                System.Console.WriteLine("beforeClass error：" + e.Message);
            }
        }
        
        [TestMethod]
        //创建会员
        public void TestCreateMember()
        {
            try
            {
                System.Console.WriteLine("TestCreateMember start");
                JObject param = new JObject();
                param.Add("bizUserId", "");  //商户系统用户标识，商户系统中唯一编号
                param.Add("memberType", 3);    //会员类型
                param.Add("source", 1);        //访问终端类型

                System.Console.WriteLine("request:" + param.ToString());
                JObject response = soaClient.request(soaName, "createMember", param);
                System.Console.WriteLine("response:" + response.ToString());
            }catch(Exception e)
            {
                System.Console.WriteLine("error：" + e.Message);
            }
        }

        [TestMethod]
        //实名认证
        public void TestSetRealName()
        {
            try
            {
                System.Console.WriteLine("TestSetRealName start");
                JObject param = new JObject();
                param.Add("bizUserId", "");  //商户系统用户标识，商户系统中唯一编号
                param.Add("name", "");    //会员类型
                param.Add("identityType", 1);        //访问终端类型
                param.Add("identityNo", rsaEncrypt(""));

                System.Console.WriteLine("request:" + param.ToString());
                JObject response = soaClient.request(soaName, "setRealName", param);
                System.Console.WriteLine("response:" + response.ToString());
            }
            catch (Exception e)
            {
                System.Console.WriteLine("error：" + e.Message);
            }
        }


        /// <summary>
        /// 加密
        /// </summary>
        /// <param name="str"></param>
        /// <returns></returns>
        public string rsaEncrypt(string str)
        {
            RSAUtil rsa = new RSAUtil(publicKey, privateKey);
            string encryptStr = rsa.encrypt(str);

            return encryptStr;
        }

        /// <summary>
        /// 解密
        /// </summary>
        /// <param name="str"></param>
        /// <returns></returns>
        public string rsaDecrypt(string str)
        {
            RSAUtil rsa = new RSAUtil(publicKey, privateKey);
            string decryptStr = rsa.dencrypt(str);

            return decryptStr;
        }
    }
}
