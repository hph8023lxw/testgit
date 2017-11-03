<%@page import="ime.service.util.RSAUtil"%>
<%@page import="java.security.PublicKey"%>
<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="org.apache.log4j.Logger" %>
<%@ page import="java.util.Enumeration" %>

<% 
	/** -------------------订单结果通知验签-----------------------------**/
	
	Logger logger = Logger.getLogger("aa");
	logger.info("================订单结果通知验签开始======================");
	
	//获取参数
	String sysid = request.getParameter("sysid");
	String sign = request.getParameter("sign");
	String timestamp = request.getParameter("timestamp");
	String v = request.getParameter("v");
	String rps = request.getParameter("rps");
	logger.info("sysid=" + sysid + ",,sign" + sign + ",,timestamp=" + timestamp + ",,v=" + v + ",,rps=" +rps);
	
	//根据实际情况填写
	String alias = "";  //应用号
	String path = "";   //证书路径
	String pwd = "";    //证书密码
	PublicKey publicKey = RSAUtil.loadPublicKey(alias, path, pwd);
	String text = sysid+rps+timestamp;
	Boolean verifyResult = ime.service.util.RSAUtil.verify(publicKey, text, sign);
	
	logger.info("签名验证结果：" + verifyResult);
	logger.info("================订单结果通知验签结束======================");
%>