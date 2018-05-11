<?php
require_once ('../ebusclient/AgentUnSignRequest.php');

//1、生成授权支付解约请求对象
$tRequest = new AgentUnSignRequest();
$tRequest->request["OrderNo"] = ($_POST['OrderNo']); //订单编号（必要信息）
$tRequest->request["AgentSignNo"] = ($_POST['AgentSignNo']); //签约编号（必要信息）
$tRequest->request["RequestDate"] = ($_POST['RequestDate']); //请求日期 （必要信息 - YYYY/MM/DD）
$tRequest->request["RequestTime"] = ($_POST['RequestTime']); //请求时间 （必要信息 - HH:MM:SS）

//2、传送授权支付解约请求
$tResponse = $tRequest->postRequest();

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