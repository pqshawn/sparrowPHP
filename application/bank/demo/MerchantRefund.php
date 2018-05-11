<?php
require_once ('../ebusclient/RefundRequest.php');
//1、生成退款请求对象
$tRequest = new RefundRequest();
$tRequest->request["OrderDate"] = ($_POST['OrderDate']); //订单日期（必要信息）
$tRequest->request["OrderTime"] = ($_POST['OrderTime']); //订单时间（必要信息）
$tRequest->request["MerRefundAccountNo"] = ($_POST['MerRefundAccountNo']); //商户退款账号
$tRequest->request["MerRefundAccountName"] = ($_POST['MerRefundAccountName']); //商户退款名
$tRequest->request["OrderNo"] = ($_POST['OrderNo']); //原交易编号（必要信息）
$tRequest->request["NewOrderNo"] = ($_POST['NewOrderNo']); //交易编号（必要信息）
$tRequest->request["CurrencyCode"] = ($_POST['CurrencyCode']); //交易币种（必要信息）
$tRequest->request["TrxAmount"] = ($_POST['TrxAmount']); //退货金额 （必要信息）
$tRequest->request["MerchantRemarks"] = ($_POST['MerchantRemarks']); //附言

//2、传送退款请求并取得退货结果
$tResponse = $tRequest->postRequest();

//3、支付请求提交成功，返回结果信息
if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("OrderNo   = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
	print ("NewOrderNo   = [" . $tResponse->GetValue("NewOrderNo") . "]<br/>");
	print ("TrxAmount = [" . $tResponse->GetValue("TrxAmount") . "]<br/>");
	print ("BatchNo   = [" . $tResponse->GetValue("BatchNo") . "]<br/>");
	print ("VoucherNo = [" . $tResponse->GetValue("VoucherNo") . "]<br/>");
	print ("HostDate  = [" . $tResponse->GetValue("HostDate") . "]<br/>");
	print ("HostTime  = [" . $tResponse->GetValue("HostTime") . "]<br/>");
	print ("iRspRef  = [" . $tResponse->GetValue("iRspRef") . "]<br/>");
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>