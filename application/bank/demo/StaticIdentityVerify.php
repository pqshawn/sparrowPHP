<?php
require_once ('../ebusclient/QuickIdentityVerifyRequest.php');
//1、生成身份验证请求对象
$tRequest = new QuickIdentityVerifyRequest();
$tRequest->request["CustomType"] = ($_POST['CustomType']); //客户类型 （必要信息）
$tRequest->request["ClientName"] = ($_POST['ClientName']); //客户姓名 （必要信息）
$tRequest->request["AccNo"] = ($_POST['BankCardNo']); //银行帐号       （必要信息）
$tRequest->request["CertificateNo"] = ($_POST['CertificateNo']); //证件号码       （必要信息）
$tRequest->request["CertificateType"] = ($_POST['ddlCertificateType']); //证件类型       （必要信息）
$tRequest->request["MobileNo"] = ($_POST['PhoneNo']); //手机号
$tRequest->request["CustomNo"] = ($_POST['CustomNo']); //网银客户号
//3、传送身份验证请求
$tResponse = $tRequest->postRequest();

if ($tResponse->isSuccess()) {
	//4、身份验证请求提交成功，商户自定后续动作 
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	out . println("TrxType = [" . $tResponse->GetValue("TrxType") . "]<br>");
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}
?>