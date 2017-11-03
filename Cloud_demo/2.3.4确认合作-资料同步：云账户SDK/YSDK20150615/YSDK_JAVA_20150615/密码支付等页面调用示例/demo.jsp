<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8" %>

<%@page import="java.util.Map"%>
<%@page import="java.util.HashMap"%>
<%@page import="org.apache.log4j.Logger"%>

<%@page import="java.text.SimpleDateFormat"%>
<%@page import="java.util.Date"%>
<%@page import="org.json.JSONObject"%>

<%@page import="java.text.SimpleDateFormat"%>
<%@ page import="java.util.Iterator" %>
<%@ page import="java.net.URLEncoder" %>
<%@ page import="ime.service.util.RSAUtil" %>
<%@ page import="java.security.interfaces.RSAPublicKey" %>
<%@ page import="java.security.interfaces.RSAPrivateKey" %>

<%@ page import="java.security.PublicKey" %>
<%@ page import="java.security.PrivateKey" %>



<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title></title>
</head>

<body>

<%
	/**------------------------------------设置支付密码页面---------------------------------------------**/
	Logger logger = Logger.getLogger("gatewayFront.jsp");
	SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
	/*String soaUrl = "http://10.55.3.236:6003/";*/
	String soaUrl = "http://122.227.225.142:23661/";
	/*String sysid = (String)request.getParameter("sysid");"100000000002"*/
	String sysid = (String)request.getParameter("sysid");
	String timestamp = sdf.format(new Date());
	String v = "1.0";
	String service = "MemberPwdService";

	String bizUserId = (String)request.getParameter("bizUserId");
	String phone = (String)request.getParameter("phone");
	String identityNo = (String)request.getParameter("identityNo");
	String name = (String)request.getParameter("name");
	String method = (String)request.getParameter("method");
	String jumpUrl = (String)request.getParameter("jumpUrl");
	String backUrl = (String) request.getParameter("backUrl");


	String alias = "100000000002";
	String path = "/home/bps.yun.test/tomcat6103/webapps/ROOT/gateway/100000000002.pfx";
	String password = "697057";
	
	PrivateKey privateKey = RSAUtil.loadPrivateKey(alias, path, password);
	PublicKey publicKey = RSAUtil.loadPublicKey(alias, path, password);
	RSAUtil rsaUtil = new RSAUtil((RSAPublicKey)publicKey, (RSAPrivateKey)privateKey);
	String idenStr = rsaUtil.encrypt(identityNo);

	out.println("</ br>");
	out.println(method);
	out.println("</ br>");
	StringBuilder sb = new StringBuilder();
	String href="";
	String href1="";
	String href2="";
	String href3="";

	out.println("</ br>");
	out.println("identityNo:   "+identityNo);

	out.println("</ br>");
	out.println("idenStr:   "+idenStr);
	out.println("</ br>");
	out.println(idenStr);
	out.println("</ br>");
	/*String method = "setPayPwd";*/
	
	/**------------------------------------设置支付密码页面---------------------------------------------**/
	if("setPayPwd".equals(method)){
		JSONObject param = new JSONObject();
		param.put("bizUserId",bizUserId);
		param.put("phone",phone);
		param.put("identityType",1);
		param.put("jumpUrl",jumpUrl);
		param.put("backUrl",backUrl);
			/*330227198805284412*/
		param.put("identityNo",idenStr);
		param.put("name",name);

		JSONObject rps = new JSONObject();
		rps.put("service", service);
		rps.put("method", method);
		rps.put("param",param);

		//签名
		String signStr = sysid + rps.toString() + timestamp;
		String sign = RSAUtil.sign(privateKey, signStr);


		sb.setLength(0);
		Map map = new HashMap();
		map.put("sysid", sysid);
		map.put("sign", sign);
		map.put("timestamp", timestamp);
		map.put("v", "1.0");
		map.put("req", rps.toString());
		Iterator iterator = map.entrySet().iterator();
		while (iterator.hasNext()) {
			Map.Entry entry = (java.util.Map.Entry) iterator.next();
			sb.append((String) entry.getKey()).append("=").append(URLEncoder.encode(URLEncoder.encode((String) entry.getValue(),"UTF-8"),"UTF-8")).append("&");
		}
		String hrefStr = sb.toString().substring(0,sb.length()-1);
		href = soaUrl+"pwd/setPayPwd.html?"+hrefStr;

		out.println("</ br>");
		out.println(href);
%>
<a  style="margin-left: 50%; font-size: 36px" href="<%=href%>" >跳转设置支付密码页面</a>
<br>
<%
	}

	/**------------------------------------重置支付密码页面---------------------------------------------**/
	sb.setLength(0);
	if("resetPayPwd".equals(method)){
			/*String method2 = "resetPayPwd";*/
		JSONObject param2 = new JSONObject();
		param2.put("bizUserId",bizUserId);
		param2.put("identityType",1);
			/*330227198805284412*/
		param2.put("identityNo",idenStr);
		param2.put("name",name);
		param2.put("phone",phone);
		param2.put("jumpUrl",jumpUrl);
		JSONObject rps2 = new JSONObject();
		rps2.put("service", service);
		rps2.put("method", method);
		rps2.put("param",param2);
		//签名
		String signStr2 = sysid + rps2.toString() + timestamp;
		String sign2 = RSAUtil.sign(privateKey, signStr2.toString());
		sb.setLength(0);
		Map map2 = new HashMap();
		map2.put("sysid", sysid);
		map2.put("sign", sign2);
		map2.put("timestamp", timestamp);
		map2.put("v", "1.0");
		map2.put("req", rps2.toString());
		Iterator iterator2 = map2.entrySet().iterator();
		while (iterator2.hasNext()) {
			Map.Entry entry = (java.util.Map.Entry) iterator2.next();
			sb.append((String) entry.getKey()).append("=").append(URLEncoder.encode(URLEncoder.encode((String) entry.getValue(),"UTF-8"),"UTF-8")).append("&");
		}
		String hrefStr2 = sb.toString().substring(0,sb.length()-1);
		href1 = soaUrl+"pwd/resetPayPwd.html?"+hrefStr2;
		out.println("</ br>");
		out.println(href1);
%>
<a  style="margin-left: 50%; font-size: 36px" href="<%=href1%>">跳转重置支付密码页面</a>
<br>
<%
	}
	/**------------------------------------修改支付密码页面---------------------------------------------**/
	sb.setLength(0);
	if("updatePayPwd".equals(method)){
		JSONObject param3 = new JSONObject();
		param3.put("bizUserId",bizUserId);
		param3.put("identityType",1);
			/*330227198805284412*/
		param3.put("identityNo",idenStr);
		param3.put("name",name);
		param3.put("jumpUrl",jumpUrl);
		JSONObject rps3 = new JSONObject();
		rps3.put("service", service);
		rps3.put("method", method);
		rps3.put("param",param3);
		//签名
		String signStr3 = sysid + rps3.toString() + timestamp;
		String sign3 = RSAUtil.sign(privateKey, signStr3.toString());
		sb.setLength(0);
		Map map3 = new HashMap();
		map3.put("sysid", sysid);
		map3.put("sign", sign3);
		map3.put("timestamp", timestamp);
		map3.put("v", "1.0");
		map3.put("req", rps3.toString());
		Iterator iterator3 = map3.entrySet().iterator();
		while (iterator3.hasNext()) {
			Map.Entry entry = (java.util.Map.Entry) iterator3.next();
			sb.append((String) entry.getKey()).append("=").append(URLEncoder.encode(URLEncoder.encode((String) entry.getValue(),"UTF-8"),"UTF-8")).append("&");
		}
		String hrefStr3 = sb.toString().substring(0,sb.length()-1);
		href2 =soaUrl+"pwd/updatePayPwd.html?"+hrefStr3;
		out.println("</ br>");
		out.println(href2);
%>
<a  style="margin-left: 50%; font-size: 36px" href="<%=href2%>" >跳转修改支付密码页面</a>
<br>
<%
	}
	/**------------------------------------修改安全手机页面---------------------------------------------**/
	sb.setLength(0);
	if("updatePhoneByPayPwd".equals(method)){
		JSONObject param4= new JSONObject();
		param4.put("bizUserId",bizUserId);
		param4.put("identityType",1);
			/*330227198805284412*/
		param4.put("identityNo",idenStr);
		param4.put("name",name);
		param4.put("oldPhone",phone);
		param4.put("jumpUrl",jumpUrl);
		param4.put("backUrl",backUrl);

		JSONObject rps4 = new JSONObject();
		rps4.put("service", service);
		rps4.put("method", method);
		rps4.put("param",param4);

		//签名
		String signStr4 = sysid + rps4.toString() + timestamp;
		String sign4 = RSAUtil.sign(privateKey, signStr4.toString());
		sb.setLength(0);
		Map map4 = new HashMap();
		map4.put("sysid", sysid);
		map4.put("sign", sign4);
		map4.put("timestamp", timestamp);
		map4.put("v", "1.0");
		map4.put("req", rps4.toString());
		Iterator iterator4= map4.entrySet().iterator();
		while (iterator4.hasNext()) {
			Map.Entry entry = (java.util.Map.Entry) iterator4.next();
			sb.append((String) entry.getKey()).append("=").append(URLEncoder.encode(URLEncoder.encode((String) entry.getValue(),"UTF-8"),"UTF-8")).append("&");
		}
		String hrefStr4 = sb.toString().substring(0,sb.length()-1);
		href3 = soaUrl+"pwd/updatePhoneByPayPwd.html?"+hrefStr4;
		out.println("</ br>");
		out.println(href3);
%>
<a style="margin-left: 50%; font-size: 36px" href="<%=href3%>" >跳转修改安全手机页面</a>
<br>
<%
	}
	%>

<%--<br>
<a  style="margin-left: 50%; font-size: 36px" href="<%=href1%>">跳转重置支付密码页面</a>
<br>
<a  style="margin-left: 50%; font-size: 36px" href="<%=href2%>" >跳转修改支付密码页面</a>
<br>
<a style="margin-left: 50%; font-size: 36px" href="<%=href3%>" >跳转修改安全手机页面</a>
<br>--%>
<%--<a style="margin-left: 50%; font-size: 36px" href="<%=href5%>" >跳转订单支付页面</a>
<br>--%>
</body>
</html>

