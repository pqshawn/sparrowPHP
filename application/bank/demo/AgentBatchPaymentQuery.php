<?php
require_once ('../ebusclient/AgentBatchPaymentQueryRequest.php');
//1、生成批量授权扣款查询请求对象
$tRequest = new AgentBatchPaymentQueryRequest();
$tRequest->request["BatchNo"] = ($_POST['BatchNo']); //请求批次号       （必要信息）
$tRequest->request["BatchDate"] = ($_POST['BatchDate']); //请求日期      YYYY/MM/DD       （必要信息）

//2、传送交易请求
$tResponse = $tRequest->postRequest();

if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("BatchNo  = [" . $tResponse->GetValue("BatchNo") . "]<br/>");
	print ("BatchDate    = [" . $tResponse->GetValue("BatchDate") . "]<br/>");
	print ("BatchTime    = [" . $tResponse->GetValue("BatchTime") . "]<br/>");
	print ("AgentAmount  = [" . $tResponse->GetValue("AgentAmount") . "]<br/>");
	print ("AgentCount    = [" . $tResponse->GetValue("AgentCount") . "]<br/>");
	print ("BatchStatus    = [" . $tResponse->GetValue("BatchStatus") . "]<br/>");
	print ("BatchStatusZH    = [" . $tRequest->getBatchSatusChinese($tResponse->GetValue("BatchStatus")) . "]<br/>");
	print ("CurrencyCode    = [" . $tResponse->GetValue("CurrencyCode") . "]<br/>");
	print ("SuccessAmount    = [" . $tResponse->GetValue("SuccessAmount") . "]<br/>");
	print ("SuccessCount    = [" . $tResponse->GetValue("SuccessCount") . "]<br/>");
	print ("FailedAmount    = [" . $tResponse->GetValue("FailedAmount") . "]<br/>");
	print ("FailedCount    = [" . $tResponse->GetValue("FailedCount") . "]<br/>");
	//4、取得批量授权扣款明细
	$batchdetails = $tResponse->GetArrayValue("AgentBatchDetail");
	if (count($batchdetails, COUNT_NORMAL) === 0) {
		print ("批量授权扣款明细为空<br/>");
	} else {
		foreach ($batchdetails as $batchdetail) {
			$detail = new Json($batchdetail);
			print ("SeqNo   = [" . $detail->GetValue("SeqNo") . "],");
			print ("OrderNo   = [" . $detail->GetValue("OrderNo") . "],");
			print ("AcctNo   = [" . $detail->GetValue("AcctNo") . "],");
			print ("OrderAmount = [" . $detail->GetValue("OrderAmount") . "],");
			print ("AgentSignNo = [" . $detail->GetValue("AgentSignNo") . "],");
			print ("OrderStatus  = [" . $detail->GetValue("OrderStatus") . "],");
			print ("OrderStatusZH  = [" . tRequest . getBatchDetailStatusChinese($detail->GetValue("OrderStatus")) . "]<br/>");
		}
	}

} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>