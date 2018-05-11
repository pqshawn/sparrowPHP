<?php
require_once ('../ebusclient/QueryBatchRefundRequest.php');
//1、生成退款批量结果查询请求对象
$tRequest = new QueryBatchRefundRequest();
$tRequest->request["BatchDate"] = ($_POST['BatchDate']); //订单日期（必要信息）
$tRequest->request["BatchTime"] = ($_POST['BatchTime']); //订单时间（必要信息）
$tRequest->request["SerialNumber"] = ($_POST['SerialNumber']); //设定退款批量结果查询请求的流水号（必要信息）

//2、传送退款批量结果查询请求并取得结果
$tResponse = $tRequest->postRequest();
//3、支付请求提交成功，返回结果信息
if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("BatchDate      = [" . $tResponse->GetValue("BatchDate") . ToString() . "]<br/>");
	print ("BatchTime  = [" . $tResponse->GetValue("BatchTime") . ToString() . "]<br/>");
	print ("SerialNumber  = [" . $tResponse->GetValue("SerialNumber") . ToString() . "]<br/>");
	print ("BatchStatus  = [" . $tResponse->GetValue("BatchStatus") . ToString() . "]<br/>");
	print ("MerRefundAccountNo  = [" . $tResponse->GetValue("MerRefundAccountNo") . ToString() . "]<br/>");
	print ("MerRefundAccountName  = [" . $tResponse->GetValue("MerRefundAccountName") . ToString() . "]<br/>");
	print ("RefundAmount  = [" . $tResponse->GetValue("RefundAmount") . ToString() . "]<br/>");
	print ("RefundCount    = [" . $tResponse->GetValue("RefundCount") . ToString() . "]<br/>");
	print ("SuccessAmount      = [" . $tResponse->GetValue("SuccessAmount") . ToString() . "]<br/>");
	print ("SuccessCount      = [" . $tResponse->GetValue("SuccessCount") . ToString() . "]<br/>");
	print ("FailedAmount      = [" . $tResponse->GetValue("FailedAmount") . ToString() . "]<br/>");
	print ("FailedCount      = [" . $tResponse->GetValue("FailedCount") . ToString() . "]<br/>");
	//4、取得订单明细
	$batchdetails = $tResponse->GetArrayValue("Order");
	if (count($batchdetails, COUNT_NORMAL) === 0) {
		print ("批量退款明细为空<br/>");
	} else {
		foreach ($batchdetails as $batchdetail) {
			$detail = new Json($batchdetail);
			print ("OriginalOrderNo   = [" . $detail->GetValue["OriginalOrderNo"] . "]<br/>");
			print ("RefundOrderNo = [" . $detail->GetValue["RefundAmount"] . "]<br/>");
			print ("CurrencyCode  = [" . $detail->GetValue["CurrencyCode"] . "]<br/>");
			print ("RefundAmountCell   = [" . $detail->GetValue["RefundAmountCell"] . "]<br/>");
			print ("OrderStatus = [" . $detail->GetValue["OrderStatus"] . "]<br/>");
			print ("Remark  = [" . $detail->GetValue["Remark"] . "]<br/>");
		}
	}
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>