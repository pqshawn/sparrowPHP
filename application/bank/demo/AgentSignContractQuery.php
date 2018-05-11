<?php
require_once ('../ebusclient/QueryAgentSignRequest.php');
//1、生成退款请求对象
$tRequest = new QueryAgentSignRequest();
$tRequest->request["OrderNo"] = ($_POST['OrderNo']); //交易编号（必要信息）

//2、传送签约/解约结果查询请求并取得订单查询结果
$tResponse = $tRequest->postRequest();
//3、判断签约/解约结果查询结果状态，进行后续操作
if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("TrxType      = [" . $tResponse->GetValue("TrxType") . "]<br/>");
	print ("MerchantNo      = [" . $tResponse->GetValue("MerchantNo") . "]<br/>");
	print ("OrderNo      = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
	print ("AgentSignNo      = [" . $tResponse->GetValue("AgentSignNo") . "]<br/>");
	print ("CertificateNo      = [" . $tResponse->GetValue("CertificateNo") . "]<br/>");
	print ("CertificateType      = [" . $tResponse->GetValue("CertificateType") . "]<br/>");
	print ("Last4CardNo      = [" . $tResponse->GetValue("Last4CardNo") . "]<br/>");
	print ("SignDate      = [" . $tResponse->GetValue("SignDate") . "]<br/>");
	print ("UnSignDate      = [" . $tResponse->GetValue("UnSignDate") . "]<br/>");
	print ("AgentSignStatus      = [" . $tResponse->GetValue("AgentSignStatus") . "]<br/>");
	print ("AccountType      = [" . $tResponse->GetValue("AccountType") . "]<br/>");
	print ("PaymentLinkType      = [" . $tResponse->GetValue("PaymentLinkType") . "]<br/>");

} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>