<?php
require_once ('../ebusclient/IdentityVerifyRequest.php');
//1、生成身份验证请求对象
$tRequest = new IdentityVerifyRequest();
$tRequest->request["CustomType"] = ($_POST['CustomType']); //客户类型 （必要信息）
$tRequest->request["BankCardNo"] = ($_POST['BankCardNo']); //银行帐号       （必要信息）
$tRequest->request["CertificateNo"] = ($_POST['CertificateNo']); //证件号码       （必要信息）
$tRequest->request["CertificateType"] = ($_POST['ddlCertificateType']); //证件类型       （必要信息）
$tRequest->request["ResultNotifyURL"] = ($_POST['ResultNotifyURL']); //身份验证回传网址（必要信息）
$tRequest->request["OrderDate"] = ($_POST['OrderDate']); //验证请求日期 （必要信息 - YYYY/MM/DD）
$tRequest->request["OrderTime"] = ($_POST['OrderTime']); //验证请求时间 （必要信息 - HH:MM:SS）
$tRequest->request["PaymentLinkType"] = ($_POST['PaymentLinkType']); //交易渠道 （必要信息 - HH:MM:SS）

//2、传送身份验证请求并取得支付网址
$tResponse = $tRequest->postRequest();

if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("VerifyURL-->" . $tResponse->GetValue("VerifyURL"));
	$PaymentURL = $tResponse->GetValue("VerifyURL");
	print ("<br>PaymentURL=$PaymentURL" . "</br>");
	echo "<script language='javascript'>";
	echo "window.location.href='$PaymentURL'";
	echo "</script>";
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>