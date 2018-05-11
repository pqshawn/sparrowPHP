<?php
require_once ('../ebusclient/QuickAgentSignContractRequest.php');
//1、生成授权支付签约请求对象
$tRequest = new QuickAgentSignContractRequest();
$tRequest->request["OrderDate"] = ($_POST['RequestDate']); //验证请求日期 （必要信息 - YYYY/MM/DD）
$tRequest->request["OrderTime"] = ($_POST['RequestTime']); //验证请求时间 （必要信息 - HH:MM:SS）
$tRequest->request["OrderNo"] = ($_POST['OrderNo']); //订单编号（必要信息）
$tRequest->request["PaymentLinkType"] = ($_POST['PaymentLinkType']); //接入渠道 （必要信息）
$tRequest->request["MerCustomNo"] = ($_POST['MerCustomNo']); //客户编号
$tRequest->request["AgentSignNo"] = ($_POST['AgentSignNo']); //签约编号
$tRequest->request["CardNo"] = ($_POST['CardNo']); //签约账号       （必要信息）
$tRequest->request["CardType"] = ($_POST['CardType']); //农行卡类型
$tRequest->request["MobileNo"] = ($_POST['MobileNo']); //签约手机号（必要信息）
$tRequest->request["InvaidDate"] = ($_POST['InvaidDate']); //签约有效期
$tRequest->request["IsSign"] = ($_POST['IsSign']); //签约/解约标识 （必要信息）
$tRequest->request["AccName"] = ($_POST['AccName']); //客户姓名 （必要信息）       
$tRequest->request["CertificateNo"] = ($_POST['CertificateNo']); //证件号码       （必要信息）
$tRequest->request["CertificateType"] = ($_POST['CertificateType']); //证件类型       （必要信息）
$tRequest->request["CardDueDate"] = ($_POST['CardDueDate']); //贷记卡有效期（卡类型为贷记卡时必要信息）
$tRequest->request["CVV2"] = ($_POST['CVV2']); //贷记卡CVV2（卡类型为贷记卡时必要信息）

//2、传送授权支付签约请求
$tResponse = $tRequest->postRequest();
//3、支付请求提交成功，返回结果信息
if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("TrxType   = [" . $tResponse->GetValue("TrxType") . "]<br/>");
	print ("OrderNo = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>