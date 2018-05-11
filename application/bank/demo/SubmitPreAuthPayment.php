<?php
require_once ('../ebusclient/PreAuthPaymentRequest.php');

//1、生成预授权确认/取消请求对象
$tRequest = new PreAuthPaymentRequest();
$tRequest->order["OperateType"] = ($_POST['PayTypeID']); //交易类型       （必要信息）
$tRequest->order["OrderDate"] = ($_POST['OrderDate']);//交易日期       
$tRequest->order["OrderTime"] =($_POST['OrderTime']);           //交易时间       （必要信息）
$tRequest->order["OrderNo"] = ($_POST['OrderNo']);; //交易编号       （必要信息）
$tRequest->order["OriginalOrderNo"] = ($_POST['OriginalOrderNo']); //原交易编号       （必要信息） 
$tRequest->order["CurrencyCode"] = ($_POST['CurrencyCode']); //币种       （必要信息）
$tRequest->order["OrderAmount"] = ($_POST['OrderAmount']); //金额       （必要信息）
$tRequest->order["Fee"] = ($_POST['Fee']); //手续费金额     
$tRequest->order["MerchantRemarks"] = ($_POST['MerchantRemarks']); //附言

//2、传送预授权确认/取消请求并取得结果
$tResponse = $tRequest->postRequest();
//3、判断预授权确认/取消结果状态，进行后续操作
if ($tResponse->isSuccess()) {
	print ("<br/>Success!!!" . "<br/>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print("OrderNo      = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
	print("OrderAmount      = [" . $tResponse->GetValue("OrderAmount") . "]<br/>");
	print("OriginalOrderNo      = [" . $tResponse->GetValue("OriginalOrderNo") . "]<br/>");
	print("BatchId      = [" . $tResponse->GetValue("BatchNo") . "]<br/>");
	print("VouchNo      = [" . $tResponse->GetValue("VouchNo") . "]<br/>");
	print("HostDate      = [" . $tResponse->GetValue("HostDate") . "]<br/>");
	print("HostTime      = [" . $tResponse->GetValue("HostTime") . "]<br/>");
	print("iRspRef      = [" . $tResponse->GetValue("iRspRef") . "]<br/>");
} else {
	//4、处理失败
	print ("<br/>Failed!!!" . "<br/>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>