<?php
require_once ('../ebusclient/Result.php');
require_once('../ebusclient/core/IFunctionID.php');
//1、取得MSG参数，并利用此参数值生成验证结果对象
$tResult = new Result();
$tResponse = $tResult->init($_POST['MSG']);


if ($tResponse->isSuccess()) {
	//3、签约解约成功
	if ($tResponse->getValue("TrxType") === strtoupper(IFunctionID :: TRX_TYPE_EBUS_AgentSignContract_REQ)) {
		print ("<br>签约成功<br>");
		print ("签约协议号: [" . $tResponse->getValue("AgentSignNo") . "]<br>");
		print ("签约卡号后4位: [" . $tResponse->getValue("Last4CardNo") . "]<br>");
	} else
		if ($tResponse->getValue("TrxType") === strtoupper(IFunctionID :: TRX_TYPE_EBUS_AgentUnsignContract_REQ)) {
			print ("解约成功<br>");
		}
	print ("OrderNo         = [" . $tResponse->getValue("OrderNo") . "]<br>");

} else {
	//4、签约解约失败
	print ("<br>Failed!!!" . "</br>");
	print ("<br>ReturnCode   = [" . $tResponse->getReturnCode() . "]<br>");
	print ("ErrorMessage = [" . $tResponse->getErrorMessage() . "]<br>");
}
?>