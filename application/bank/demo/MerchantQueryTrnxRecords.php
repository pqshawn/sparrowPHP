<?php
require_once ('../ebusclient/QueryTrnxRecords.php');
//1、、生成交易流水查询请求对象
$tRequest = new QueryTrnxRecords();
$tRequest->request["SettleDate"] = ($_POST['SettleDate']); //查询日期YYYY/MM/DD （必要信息）
$tRequest->request["SettleStartHour"] = ($_POST['SettleStartHour']); //查询开始时间段（0-23）
$tRequest->request["SettleEndHour"] = ($_POST['SettleEndHour']); //查询截止时间段（0-23）
$tRequest->request["ZIP"] = ($_POST['ZIP']);

//2、传送交易流水查询请求并取得交易流水
$tResponse = $tRequest->postRequest();

//3、判断交易流水查询结果状态，进行后续操作
if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("TrxType      = [" . $tResponse->GetValue("TrxType") . "]<br/>");
	print ("ZIPDetailRecords      = [" . $tResponse->GetValue("ZIPDetailRecords") . "]<br/>"); //请求报文指定压缩时该字段有值
	print ("DetailRecords      = [" . $tResponse->GetValue("DetailRecords") . "]<br/>"); //请求报文不指定压缩时该字段有值
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>