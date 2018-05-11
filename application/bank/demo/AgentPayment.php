<?php
require_once ('../ebusclient/AgentPaymentRequest.php');
//1、生成单笔授权扣款请求对象
$tRequest = new AgentPaymentRequest();
//2、生成定单订单对象，并将订单明细加入定单中
$tRequest->request["OrderDate"] = ($_POST['OrderDate']); //设定订单日期 （必要信息 - YYYY/MM/DD）
$tRequest->request["OrderTime"] = ($_POST['OrderTime']); //设定订单时间 （必要信息 - HH:MM:SS）
$tRequest->request["OrderNo"] = ($_POST['OrderNo']); //设定订单编号 （必要信息）
$tRequest->request["AgentSignNo"] = ($_POST['AgentSignNo']); //设定授权支付协议号 （必要信息）
$tRequest->request["CardNo"] = ($_POST['CardNo']); //设定账号
$tRequest->request["CurrencyCode"] = ($_POST['CurrencyCode']); //设定交易币种 （必要信息）
$tRequest->request["Amount"] = ($_POST['Amount']); //设定交易金额 （必要信息）
$tRequest->request["ReceiverAddress"] = ($_POST['ReceiverAddress']); //设定手续费金额
$tRequest->request["Fee"] = ($_POST['Fee']); //设定手续费金额
$tRequest->request["CertificateNo"] = ($_POST['CertificateNo']); //证件号码
$tRequest->request["InstallmentMark"] = ($_POST['InstallmentMark']); //分期标识（必要信息）
if (($_POST['InstallmentMark']) === ("1")) {
	$tRequest->request["InstallmentCode"] = ($_POST['InstallmentCode']); //设定分期代码
	$tRequest->request["InstallmentNum"] = ($_POST['InstallmentNum']); //设定分期期数
}
$tRequest->request["CommodityType"] = ($_POST['CommodityType']); //设置商品种类 （必要信息）
$tRequest->request["PaymentLinkType"] = ($_POST['PaymentLinkType']); //设定支付接入方式 （必要信息）
$tRequest->request["BuyIP"] = ($_POST['BuyIP']);
$tRequest->request["ExpiredDate"] = ($_POST['ExpiredDate']); //设定订单保存时间
$tRequest->request["ReceiveAccount"] = ($_POST['ReceiveAccount']); //设定收款方账号
$tRequest->request["ReceiveAccName"] = ($_POST['ReceiveAccName']); //设定收款方户名
$tRequest->request["MerchantRemarks"] = ($_POST['MerchantRemarks']); //设定附言
$tRequest->request["IsBreakAccount"] = ($_POST['IsBreakAccount']); //设定交易是否分账
$tRequest->request["SplitAccTemplate"] = ($_POST['SplitAccTemplate']); //分账模版编号

//2、订单明细

$orderitem = array ();
$orderitem["SubMerName"] = "测试二级商户1"; //设定二级商户名称
$orderitem["SubMerId"] = "12345"; //设定二级商户代码
$orderitem["SubMerMCC"] = "0000"; //设定二级商户MCC码 
$orderitem["SubMerchantRemarks"] = "测试"; //二级商户备注项
$orderitem["ProductID"] = "IP000001"; //商品代码，预留字段
$orderitem["ProductName"] = "中国移动IP卡"; //商品名称
$orderitem["UnitPrice"] = "1.00"; //商品总价
$orderitem["Qty"] = "1"; //商品数量
$orderitem["ProductRemarks"] = "测试商品"; //商品备注项
$orderitem["ProductType"] = "充值类"; //商品类型
$orderitem["ProductDiscount"] = "0.9"; //商品折扣
$orderitem["ProductExpiredDate"] = "10"; //商品有效期
$tRequest->orderitems[0] = $orderitem;

$orderitem = array ();
$orderitem["SubMerName"] = "测试二级商户2"; //设定二级商户名称
$orderitem["SubMerId"] = "12345"; //设定二级商户代码
$orderitem["SubMerMCC"] = "0000"; //设定二级商户MCC码 
$orderitem["SubMerchantRemarks"] = "测试2"; //二级商户备注项
$orderitem["ProductID"] = "IP000001"; //商品代码，预留字段
$orderitem["ProductName"] = "中国移动IP卡2"; //商品名称
$orderitem["UnitPrice"] = "1.00"; //商品总价
$orderitem["Qty"] = "1"; //商品数量
$orderitem["ProductRemarks"] = "测试商品2"; //商品备注项
$orderitem["ProductType"] = "充值类2"; //商品类型
$orderitem["ProductDiscount"] = "0.9"; //商品折扣
$orderitem["ProductExpiredDate"] = "10"; //商品有效期
$tRequest->orderitems[1] = $orderitem;

//3、传送单笔授权扣款请求
$tResponse = $tRequest->postRequest();

if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("OrderNo      = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
	print ("TrxType      = [" . $tResponse->GetValue("TrxType") . "]<br/>");
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>