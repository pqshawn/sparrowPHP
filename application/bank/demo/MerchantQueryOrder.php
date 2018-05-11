<?php
require_once ('../ebusclient/QueryOrderRequest.php');
//1、生成交易查询对象
$payTypeID = ($_POST['PayTypeID']);
$queryType = ($_POST['QueryType']);
if ($queryType === "0") {
	$QueryType = "false";
} else
	if ($queryType === "1") {
		$QueryType = "true";
	}
//2、传送请求
$tRequest = new QueryOrderRequest();
$tRequest->request["PayTypeID"] = $payTypeID; //设定交易类型
$tRequest->request["OrderNo"] = ($_POST['OrderNo']); //设定订单编号 （必要信息）
$tRequest->request["QueryDetail"] = $QueryType; //设定查询方式

$tResponse = $tRequest->postRequest();
//3、支付请求提交成功，返回结果信息
if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	//4、获取结果信息
	$orderInfo = $tResponse->GetValue("Order");
	if ($orderInfo == null) {
		print ("查询结果为空<br/>");
	} else {
		//1、还原经过base64编码的信息 
		$orderDetail = base64_decode($orderInfo);
		$orderDetail = iconv("GB2312", "UTF-8", $orderDetail);
		$detail = new Json($orderDetail);
		if ($queryType === "0") {
			print ("PayTypeID      = [" . $detail->GetValue("PayTypeID") . "]<br/>");
			print ("OrderNo      = [" . $detail->GetValue("OrderNo") . "]<br/>");
			print ("OrderDate      = [" . $detail->GetValue("OrderDate") . "]<br/>");
			print ("OrderTime      = [" . $detail->GetValue("OrderTime") . "]<br/>");
			print ("OrderAmount      = [" . $detail->GetValue("OrderAmount") . "]<br/>");
			print ("Status      = [" . $detail->GetValue("Status") . "]<br/>");
		} else {
			if ($payTypeID === "ImmediatePay" || $payTypeID === "PreAuthPay") {
				print ("PayTypeID      = [" . $detail->GetValue("PayTypeID") . "]<br/>");
				print ("OrderNo      = [" . $detail->GetValue("OrderNo") . "]<br/>");
				print ("OrderDate      = [" . $detail->GetValue("OrderDate") . "]<br/>");
				print ("OrderTime      = [" . $detail->GetValue("OrderTime") . "]<br/>");
				print ("OrderAmount      = [" . $detail->GetValue("OrderAmount") . "]<br/>");
				print ("Status      = [" . $detail->GetValue("Status") . "]<br/>");
				print ("OrderDesc      = [" . $detail->GetValue("OrderDesc") . "]<br/>");
				print ("OrderURL      = [" . $detail->GetValue("OrderURL") . "]<br/>");
				print ("PaymentLinkType      = [" . $detail->GetValue("PaymentLinkType") . "]<br/>");
				print ("AcctNo      = [" . $detail->GetValue("AcctNo") . "]<br/>");
				print ("CommodityType      = [" . $detail->GetValue("CommodityType") . "]<br/>");
				print ("ReceiverAddress      = [" . $detail->GetValue("ReceiverAddress") . "]<br/>");
				print ("BuyIP      = [" . $detail->GetValue("BuyIP") . "]<br/>");
				print ("iRspRef      = [" . $detail->GetValue("iRspRef") . "]<br/>");
				print ("ReceiveAccount      = [" . $detail->GetValue("ReceiveAccount") . "]<br/>");
				print ("ReceiveAccName      = [" . $detail->GetValue("ReceiveAccName") . "]<br/>");
				print ("MerchantRemarks      = [" . $detail->GetValue("MerchantRemarks") . "]<br/>");

				//5、商品明细
				$orderItems = $detail->GetArrayValue("OrderItems");
				if (count($orderItems, COUNT_NORMAL) === 0) {
					print ("商品明细为空<br/>");
				} else {
					foreach ($orderItems as $orderItem) {
						$detail = new Json($orderItem);
						print ("SubMerName      = [" . $detail->GetValue("SubMerName") . "],");
						print ("SubMerId      = [" . $detail->GetValue("SubMerId") . "],");
						print ("SubMerMCC      = [" . $detail->GetValue("SubMerMCC") . "],");
						print ("SubMerchantRemarks      = [" . $detail->GetValue("SubMerchantRemarks") . "],");
						print ("ProductID      = [" . $detail->GetValue("ProductID") . "],");
						print ("ProductName      = [" . $detail->GetValue("ProductName") . "],");
						print ("UnitPrice      = [" . $detail->GetValue("UnitPrice") . "],");
						print ("Qty      = [" . $detail->GetValue("Qty") . "],");
						print ("ProductRemarks      = [" . $detail->GetValue("ProductRemarks") . "],");
					}

				}
			}
			 else
				if ($payTypeID === "DividedPay") {
					print ("PayTypeID      = [" . $detail->GetValue("PayTypeID") . "]<br/>");
					print ("OrderNo      = [" . $detail->GetValue("OrderNo") . "]<br/>");
					print ("OrderDate      = [" . $detail->GetValue("OrderDate") . "]<br/>");
					print ("OrderTime      = [" . $detail->GetValue("OrderTime") . "]<br/>");
					print ("OrderAmount      = [" . $detail->GetValue("OrderAmount") . "]<br/>");
					print ("Status      = [" . $detail->GetValue("Status") . "]<br/>");
					print ("InstallmentCode      = [" . $detail->GetValue("InstallmentCode") . "]<br/>");
					print ("InstallmentNum      = [" . $detail->GetValue("InstallmentNum") . "]<br/>");
					print ("PaymentLinkType      = [" . $detail->GetValue("PaymentLinkType") . "]<br/>");
					print ("AcctNo      = [" . $detail->GetValue("AcctNo") . "]<br/>");
					print ("CommodityType      = [" . $detail->GetValue("CommodityType") . "]<br/>");
					print ("ReceiverAddress      = [" . $detail->GetValue("ReceiverAddress") . "]<br/>");
					print ("BuyIP      = [" . $detail->GetValue("BuyIP") . "]<br/>");
					print ("iRspRef      = [" . $detail->GetValue("iRspRef") . "]<br/>");
					print ("ReceiveAccount      = [" . $detail->GetValue("ReceiveAccount") . "]<br/>");
					print ("ReceiveAccName      = [" . $detail->GetValue("ReceiveAccName") . "]<br/>");
					print ("MerchantRemarks      = [" . $detail->GetValue("MerchantRemarks") . "]<br/>");

					//5、商品明细
					$orderItems = $detail->GetArrayValue("OrderItems");
					if (count($orderItems, COUNT_NORMAL) === 0) {
						print ("商品明细为空<br/>");
					} else {
						foreach ($orderItems as $orderItem) {
							$detail = new Json($orderItem);
							print ("商品明细为:<br/>");
							print ("SubMerName      = [" . $detail->GetValue("SubMerName") . "],");
							print ("SubMerId      = [" . $detail->GetValue("SubMerId") . "],");
							print ("SubMerMCC      = [" . $detail->GetValue("SubMerMCC") . "],");
							print ("SubMerchantRemarks      = [" . $detail->GetValue("SubMerchantRemarks") . "],");
							print ("ProductID      = [" . $detail->GetValue("ProductID") . "],");
							print ("ProductName      = [" . $detail->GetValue("ProductName") . "],");
							print ("UnitPrice      = [" . $detail->GetValue("UnitPrice") . "],");
							print ("Qty      = [" . $detail->GetValue("Qty") . "],");
							print ("ProductRemarks      = [" . $detail->GetValue("ProductRemarks") . "],");
							print ("<br/>");
						}
					}
					//5、商品明细
					$orderItems = $detail->GetArrayValue("Distribution");
					if (count($orderItems, COUNT_NORMAL) === 0) {
						print ("分账账户信息为空<br/>");
					} else {
						foreach ($orderItems as $orderItem) {
							$detail = new Json($orderItems);
							print ("分账账户信息明细为:<br/>");
							print ("DisAccountNo      = [" . $detail->GetValue("DisAccountNo") . "],");
							print ("DisAccountName      = [" . $detail->GetValue("DisAccountName") . "],");
							print ("DisAmount      = [" . $detail->GetValue("DisAmount") . "],");
							print ("<br/>");
						}
					}
				} else
					if (payTypeID . equals("Refund")) {
						print ("PayTypeID      = [" . $detail->GetValue("PayTypeID") . "]<br/>");
						print ("OrderNo      = [" . $detail->GetValue("OrderNo") . "]<br/>");
						print ("OrderDate      = [" . $detail->GetValue("OrderDate") . "]<br/>");
						print ("OrderTime      = [" . $detail->GetValue("OrderTime") . "]<br/>");
						print ("RefundAmount      = [" . $detail->GetValue("RefundAmount") . "]<br/>");
						print ("Status      = [" . $detail->GetValue("Status") . "]<br/>");
						print ("iRspRef      = [" . $detail->GetValue("iRspRef") . "]<br/>");
						print ("MerRefundAccountNo      = [" . $detail->GetValue(" MerRefundAccountNo") . "]<br/>");
						print ("MerRefundAccountName      = [" . $detail->GetValue(" MerRefundAccountName") . "]<br/>");
					} else
						if (payTypeID . equals("AgentPay")) {
							print ("PayTypeID      = [" . $detail->GetValue("PayTypeID") . "]<br/>");
							print ("OrderNo      = [" . $detail->GetValue("OrderNo") . "]<br/>");
							print ("OrderDate      = [" . $detail->GetValue("OrderDate") . "]<br/>");
							print ("OrderTime      = [" . $detail->GetValue("OrderTime") . "]<br/>");
							print ("OrderAmount      = [" . $detail->GetValue("OrderAmount") . "]<br/>");
							print ("Status      = [" . $detail->GetValue("Status") . "]<br/>");
							print ("InstallmentCode      = [" . $detail->GetValue("InstallmentCode") . "]<br/>");
							print ("InstallmentNum      = [" . $detail->GetValue("InstallmentNum") . "]<br/>");
							print ("PaymentLinkType      = [" . $detail->GetValue("PaymentLinkType") . "]<br/>");
							print ("AcctNo      = [" . $detail->GetValue("AcctNo") . "]<br/>");
							print ("CommodityType      = [" . $detail->GetValue("CommodityType") . "]<br/>");
							print ("ReceiverAddress      = [" . $detail->GetValue("ReceiverAddress") . "]<br/>");
							print ("BuyIP      = [" . $detail->GetValue("BuyIP") . "]<br/>");
							print ("iRspRef      = [" . $detail->GetValue("iRspRef") . "]<br/>");
							//out.println("HostTime      = [" . json.GetKeyValue("HostTime") . "]<br/>");
							//out.println("HostDate      = [" . json.GetKeyValue("HostDate") . "]<br/>");
							print ("ReceiveAccount      = [" . $detail->GetValue("ReceiveAccount") . "]<br/>");
							print ("ReceiveAccName      = [" . $detail->GetValue("ReceiveAccName") . "]<br/>");
							print ("MerchantRemarks      = [" . $detail->GetValue("MerchantRemarks") . "]<br/>");

							//商品明细
							$orderItems = $detail->GetArrayValue("OrderItems");
							if (count($orderItems, COUNT_NORMAL) === 0) {
								print ("商品明细为空<br/>");
							} else {
								foreach ($orderItems as $orderItem) {
									$detail = new Json($orderItem);
									print ("商品明细为:<br/>");
									print ("SubMerName      = [" . $detail->GetValue("SubMerName") . "],");
									print ("SubMerId      = [" . $detail->GetValue("SubMerId") . "],");
									print ("SubMerMCC      = [" . $detail->GetValue("SubMerMCC") . "],");
									print ("SubMerchantRemarks      = [" . $detail->GetValue("SubMerchantRemarks") . "],");
									print ("ProductID      = [" . $detail->GetValue("ProductID") . "],");
									print ("ProductName      = [" . $detail->GetValue("ProductName") . "],");
									print ("UnitPrice      = [" . $detail->GetValue("UnitPrice") . "],");
									print ("Qty      = [" . $detail->GetValue("Qty") . "],");
									print ("ProductRemarks      = [" . $detail->GetValue("ProductRemarks") . "],");
									print ("<br/>");
								}
							}
							//获取分账账户信息
							$orderItems = $detail->GetArrayValue("Distribution");
							if (count($orderItems, COUNT_NORMAL) === 0) {
								print ("分账账户信息明细为空<br/>");
							} else {
								foreach ($orderItems as $orderItem) {
									$detail = new Json($orderItems);
									print ("分账账户信息明细为:<br/>");
									print ("DisAccountNo      = [" . $detail->GetValue("DisAccountNo") . "],");
									print ("DisAccountName      = [" . $detail->GetValue("DisAccountName") . "],");
									print ("DisAmount      = [" . $detail->GetValue("DisAmount") . "],");
									print ("<br/>");
								}
							}
						} else
							if (payTypeID . equals("PreAuthed") || payTypeID . equals("PreAuthCancel")) {
								print ("PayTypeID      = [" . $detail->GetValue("PayTypeID") . "]<br/>");
								print ("OrderNo      = [" . $detail->GetValue("OrderNo") . "]<br/>");
								print ("OrderDate      = [" . $detail->GetValue("OrderDate") . "]<br/>");
								print ("OrderTime      = [" . $detail->GetValue("OrderTime") . "]<br/>");
								print ("OrderAmount      = [" . $detail->GetValue("OrderAmount") . "]<br/>");
								print ("Status      = [" . $detail->GetValue("Status") . "]<br/>");
								print ("AcctNo      = [" . $detail->GetValue("AcctNo") . "]<br/>");
								print ("iRspRef      = [" . $detail->GetValue("iRspRef") . "]<br/>");
								print ("ReceiveAccount      = [" . $detail->GetValue("ReceiveAccount") . "]<br/>");
								print ("ReceiveAccName      = [" . $detail->GetValue("ReceiveAccName") . "]<br/>");
							}
		}
	}
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>