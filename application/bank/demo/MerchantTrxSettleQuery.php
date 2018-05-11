<?php
require_once ('../ebusclient/SettleRequest.php');
//1、生成商户对账单下载请求对象
$tRequest = new SettleRequest();
$tRequest->request["SettleDate"] = ($_POST['SettleDate']); //对账日期YYYY/MM/DD （必要信息）
$tRequest->request["ZIP"] = ($_POST['ZIP']);

//2、传送商户对账单下载请求并取得对账单
$tResponse = $tRequest->postRequest();

//3、判断商户对账单下载结果状态，进行后续操作
if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("TrxType      = [" . $tResponse->GetValue("TrxType") . "]<br/>");
	print ("SettleDate      = [" . $tResponse->GetValue("SettleDate") . "]<br/>");
	print ("SettleType      = [" . $tResponse->GetValue("SettleType") . "]<br/>");
	print ("NumOfPayments      = [" . $tResponse->GetValue("NumOfPayments") . "]<br/>");
	print ("SumOfPayAmount      = [" . $tResponse->GetValue("SumOfPayAmount") . "]<br/>");
	print ("NumOfRefunds      = [" . $tResponse->GetValue("NumOfRefunds") . "]<br/>");
	print ("SumOfRefundAmount      = [" . $tResponse->GetValue("SumOfRefundAmount") . "]<br/>");
	print ("ZIPDetailRecords      = [" . $tResponse->GetValue("ZIPDetailRecords") . "]<br/>");
	print ("DetailRecords      = [" . $tResponse->GetValue("DetailRecords") . "]<br/>");
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>