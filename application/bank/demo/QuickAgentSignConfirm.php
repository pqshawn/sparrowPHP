<?php
require_once ('../ebusclient/QuickAgentSignConfirm.php');

//1、生成授权支付签约确认请求对象
$tRequest = new QuickAgentSignConfirm();
$tRequest->request["OrderNo"] = ($_POST['OrderNo']); //订单编号（必要信息） 
$tRequest->request["VerifyCode"] = ($_POST['VerifyCode']); //验证码（必要信息）

//2、传送授权支付签约确认请求
$tResponse = $tRequest->postRequest();
//3、授权支付签约确认请求提交成功
if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("TrxType   = [" . $tResponse->GetValue("TrxType") . "]<br/>");
	print ("OrderNo   = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
	print ("AgentSignNo = [" . $tResponse->GetValue("AgentSignNo") . "]<br/>");
} else {
	//4、授权支付签约请求提交失败，商户自定后续动作
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>