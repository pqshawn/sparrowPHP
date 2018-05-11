<?php
require_once ('../ebusclient/QuickAgentSignResendReq.php');
//1、生成授权支付签约验证码重发请求对象
$tRequest = new QuickAgentSignResendReq();
$tRequest->request["OrderNo"] = ($_POST['OrderNo']); //订单编号（必要信息）
$tRequest->request["CardNo"] = ($_POST['CardNo']); //签约账号       （必要信息）

//2、传送授权支付签约验证码重发请求
$tResponse = $tRequest->postRequest();
//3、授权支付签约验证码重发请求提交成功，获取返回信息
if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("TrxType   = [" . $tResponse->GetValue("TrxType") . "]<br/>");
	print ("OrderNo = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
	print ("CardNo = [" . $tResponse->GetValue("CardNo") . "]<br/>");
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>