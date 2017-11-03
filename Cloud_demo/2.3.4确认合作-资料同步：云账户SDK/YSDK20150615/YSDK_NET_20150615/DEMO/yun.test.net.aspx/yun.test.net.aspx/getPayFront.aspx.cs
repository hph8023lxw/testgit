using ime.service.util;
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
    public partial class getPayFront : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            //密钥密码
            String pwd = "";
            //证书名称
            String alias = "";
            //证书文件路径，用户指定
            String path = "";

            //组装参数
            string sysid = Request.Params.Get("sysid");
            string sign = Request.Params.Get("sign");
            string timestamp = Request.Params.Get("timestamp");
            string v = Request.Params.Get("v");
            string rps = Request.Params.Get("rps");

            RSACryptoServiceProvider publicKey = RSAUtil.loadPublicKey(alias, path, pwd);
            StringBuilder sb = new StringBuilder();
            sb.Append(sysid).Append(rps).Append(timestamp);
            bool isVerify = RSAUtil.verify(publicKey, sb.ToString(), sign);
        }
    }
}