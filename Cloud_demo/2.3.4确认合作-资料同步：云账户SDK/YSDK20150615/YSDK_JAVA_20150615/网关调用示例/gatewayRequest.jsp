<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8"%>

<%@page import="org.json.JSONObject"%>

<%@page import="org.apache.log4j.Logger"%>
<%@page import="java.util.Map"%>
<%@page import="java.util.HashMap"%>
<%@page import="java.util.Date"%>
<%@page import="java.util.Iterator"%>
<%@page import="java.text.SimpleDateFormat"%>
<%@page import="ime.service.util.RSAUtil"%>
<%@page import="java.security.PrivateKey"%>
<%@page import="java.net.URLEncoder"%>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache"> 
<meta http-equiv="cache-control" content="no-cache"> 
<meta http-equiv="expires" content="0">   
</head>
<body>
	<%
		/**---------------------------------网关调用示例--------------------------------**/
	
		response.setHeader("Pragma", "No-cache");
		response.setHeader("Cache-Control", "no-cache");
		response.setHeader("Expires", "0");

		Logger logger = Logger.getLogger("aaa.jsp");
		SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		
		//获取参数
		//以get方式调用，以下参数在URL中传入
		String bizUserId = (String)request.getParameter("bizUserId");                //商户系统用户标识
		String bizOrderNo = (String)request.getParameter("bizOrderNo");				 //商户系统订单号
		String consumerIp = (String)request.getParameter("consumerIp");              //ip
		String verificationCode = (String)request.getParameter("verificationCode");  //如果是纯网关，则不传

		//根据情况填写
		String sysid = "";                                //应用号
		String timestamp = sdf.format(new Date());        //时间戳
		String alias = "";                                //应用号别名，同应用号
		String path = "";                                 //证书文件地址
		String password = "";                             //证书密码
		
		//组装req参数
		JSONObject param = new JSONObject();
		param.put("bizUserId", bizUserId);
		param.put("bizOrderNo", bizOrderNo); 
		param.put("consumerIp", consumerIp);
		param.put("verificationCode", verificationCode);
		JSONObject req = new JSONObject();
		req.put("service", "OrderService");
		req.put("method", "pay");
		req.put("param", param);
		
		//签名
		PrivateKey privateKey = RSAUtil.loadPrivateKey(alias, path, password);
		logger.info("privateKey" + privateKey);
		StringBuilder sb = new StringBuilder();
		String reqStr1 = req.toString();
		sb.append(sysid).append(reqStr1).append(timestamp);
		String sign = RSAUtil.sign(privateKey, sb.toString());
		
		//组装请求参数
		Map map = new HashMap();
		map.put("sysid", sysid);
		map.put("sign", sign);
		map.put("timestamp", timestamp);
		map.put("v", "1.0");
		map.put("req", req.toString());
		sb.setLength(0);
		Iterator iterator = map.entrySet().iterator();
		while (iterator.hasNext()) {
			Map.Entry entry = (java.util.Map.Entry) iterator.next();
			sb.append((String) entry.getKey()).append("=").append(URLEncoder.encode((String) entry.getValue(),"UTF-8")).append("&");
		}
		
		out.println(map.toString());

		String href = "http://122.227.225.142:23661/service/gateway/frontTrans.do?"+sb.toString();  //请求地址，根据实际环境填写
		
		out.println("</ br>");
		
		out.println(href);
	%>

	<a href="<%=href%>" style="margin-left: 50%; font-size: 36px">前台支付</a>
	<br />

</body>
</html>