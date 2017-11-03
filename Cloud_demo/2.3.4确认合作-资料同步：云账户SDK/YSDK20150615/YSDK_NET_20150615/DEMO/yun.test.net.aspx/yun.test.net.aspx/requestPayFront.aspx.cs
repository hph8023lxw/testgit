using ime.service.util;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace yun.test.net.aspx
{
    public partial class requestPayFront : System.Web.UI.Page
    {
        private string timeFormatStr = "yyyy-MM-dd HH:mm:ss";

        protected void Page_Load(object sender, EventArgs e)
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

            //公钥
            RSACryptoServiceProvider publicKey = RSAUtil.loadPublicKey(alias, path, pwd);
            //私钥
            RSACryptoServiceProvider privateKey = RSAUtil.loadPrivateKey(alias, path, pwd);

            string bizUserId = Request.Params.Get("bizUserId");
            string bizOrderNo = Request.Params.Get("bizOrderNo");
            string consumerIp = Request.Params.Get("consumerIp");
            string verificationCode = Request.Params.Get("verificationCode");

            JObject param = new JObject();
            param.Add("bizUserId", bizUserId);
            param.Add("bizOrderNo", bizOrderNo);
            param.Add("consumerIp", consumerIp);
            if(verificationCode != null)
            {
                param.Add("verificationCode", verificationCode);
            }

            JObject req = new JObject();
            req.Add("service", "OrderService");
            req.Add("method", "pay");
            req.Add("param", param);
            string reqStr = JsonConvert.SerializeObject(req);

            string timestamp = DateTime.Now.ToString(timeFormatStr);

            //签名
            StringBuilder signSb = new StringBuilder();
            signSb.Append(sysid).Append(reqStr).Append(timestamp);
            string sign = RSAUtil.Sign(privateKey, signSb.ToString());

            //组装参数
            Dictionary<string, string> requestParams = new Dictionary<string, string>();
            requestParams.Add("sysid", sysid);
            requestParams.Add("sign", sign);
            requestParams.Add("timestamp", timestamp);
            requestParams.Add("v", "1.0");
            requestParams.Add("req", reqStr);

            StringBuilder requestSb = new StringBuilder();

            foreach (KeyValuePair<string, string> requestParamsOne in requestParams)
            {
                requestSb.Append(requestParamsOne.Key).Append("=").Append(HttpUtility.UrlEncode(requestParamsOne.Value, Encoding.UTF8)).Append("&");
            }

            string href = "http://122.227.225.142:23661/service/gateway/frontTrans.do?" + requestSb.ToString();

            jumpA.HRef = href;
        }
    }
}