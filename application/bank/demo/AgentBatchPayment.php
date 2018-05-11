<?php
require_once ('../ebusclient/AgentBatchPaymentRequest.php');
//1、取得批量授权扣款需要的信息
$seqno_arr = $_REQUEST['SeqNo'];
$orderno_arr = $_REQUEST['OrderNo'];
$agentsignno_arr = $_REQUEST['AgentSignNo'];
$cardno_arr = $_REQUEST['CardNo'];
$orderamount_arr = $_REQUEST['OrderAmount'];
$receiveraddress_arr = $_REQUEST['ReceiverAddress'];
$fee_arr = $_REQUEST['Fee'];
$certificateno_arr = $_REQUEST['CertificateNo'];
$installmentmark_arr = $_REQUEST['InstallmentMark'];
$installmentcode_arr = $_REQUEST['InstallmentCode'];
$installmentnum_arr = $_REQUEST['InstallmentNum'];
$commoditytype_arr = $_REQUEST['CommodityType'];
$submername_arr = $_REQUEST['SubMerName'];
$submerid_arr = $_REQUEST['SubMerId'];
$submermcc_arr = $_REQUEST['SubMerMCC'];
$submerchantremarks_arr = $_REQUEST['SubMerchantRemarks'];
$productid_arr = $_REQUEST['ProductID'];
$productname_arr = $_REQUEST['ProductName'];
$unitprice_arr = $_REQUEST['UnitPrice'];
$qty_arr = $_REQUEST['Qty'];
$productremarks_arr = $_REQUEST['ProductRemarks'];
$producttype_arr = $_REQUEST['ProductType'];
$productdiscount_arr = $_REQUEST['ProductDiscount'];
$productexpireddate_arr = $_REQUEST['ProductExpiredDate'];
$buyip_arr = $_REQUEST['BuyIP'];
$isBreakAccount_arr = $_REQUEST['IsBreakAccount'];
$splitAccTemplate_arr = $_REQUEST['SplitAccTemplate'];
$remark_arr = $_REQUEST['Remark'];

//2、生成批量授权扣款请求对象
$tRequest = new AgentBatchPaymentRequest();
$tRequest->agentBatch["BatchNo"] = ($_POST['BatchNo']);
$tRequest->agentBatch["BatchDate"] = ($_POST['BatchDate']);
$tRequest->agentBatch["BatchTime"] = ($_POST['BatchTime']);
$tRequest->agentBatch["AgentCount"] = ($_POST['AgentCount']);
$tRequest->agentBatch["AgentAmount"] = ($_POST['AgentAmount']);

$tRequest->request["ReceiveAccount"] = ($_POST['ReceiveAccount']);
$tRequest->request["ReceiveAccName"] = ($_POST['ReceiveAccName']);
$tRequest->request["CurrencyCode"] = ($_POST['CurrencyCode']);


//3、生成每个批次包明细
//取得列表项 
$item = array ();
for ($i = 0; $i < count($orderno_arr, COUNT_NORMAL); $i++) {
	$item["SeqNo"] = $seqno_arr[$i];
	$item["OrderNo"] = $orderno_arr[$i];
	$item["AgentSignNo"] = $agentsignno_arr[$i];
	$item["CardNo"] = $cardno_arr[$i];
	$item["OrderAmount"] = $orderamount_arr[$i];
	$item["ReceiverAddress"] = $receiveraddress_arr[$i];
	$item["Fee"] = $fee_arr[$i];
	$item["CertificateNo"] = $certificateno_arr[$i];
	$item["InstallmentMark"] = $installmentmark_arr[$i];
	if ($installmentmark_arr[$i] === ("1")) {
		$item["InstallmentCode"] = $installmentcode_arr[$i];
		$item["InstallmentNum"] = $installmentnum_arr[$i];
	}
	$item["CommodityType"] = $commoditytype_arr[$i];
	$item["SubMerName"] = $submername_arr[$i];
	$item["SubMerId"] = $submerid_arr[$i];
	$item["SubMerMCC"] = $submermcc_arr[$i];
	$item["SubMerchantRemarks"] = $submerchantremarks_arr[$i];
	$item["ProductID"] = $productid_arr[$i];
	$item["ProductName"] = $productname_arr[$i];
	$item["UnitPrice"] = $unitprice_arr[$i];
	$item["Qty"] = $qty_arr[$i];
	$item["ProductRemarks"] = $productremarks_arr[$i];
	$item["ProductType"] = $producttype_arr[$i];
	$item["ProductDiscount"] = $productdiscount_arr[$i];
	$item["ProductExpiredDate"] = $productexpireddate_arr[$i];
	$item["BuyIP"] = $buyip_arr[$i];
	$item["IsBreakAccount"] = $isBreakAccount_arr[$i];
	$item["SplitAccTemplate"] = $splitAccTemplate_arr[$i];
	$item["Remark"] = $remark_arr[$i];
	$tRequest->details[$i] = $item;
	$item = array ();

	$tRequest->iSumAmount += $orderamount_arr[$i];
}

//4.传送交易请求
$tResponse = $tRequest->postRequest();

if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("TrxType   = [" . $tResponse->GetValue("TrxType") . "]<br/>");
	print ("MerchantNo = [" . $tResponse->GetValue("MerchantNo") . "]<br/>");
	print ("SendTime   = [" . $tResponse->GetValue("SendTime") . "]<br/>");
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>