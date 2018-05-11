<?php
require_once ('../ebusclient/Result.php');
//1、取得MSG参数，并利用此参数值生成验证结果对象
$tResult = new Result();
$tResponse = $tResult->init($_POST['MSG']);

if ($tResponse->isSuccess()) {
	//2、验证成功
	print ("<br>户名         = [" . $tResponse->getValue("AccountName") . "]<br>");

} else {
	//3、验证失败
	print ("<br>ReturnCode   = [" . $tResponse->getReturnCode() . "]<br>");
	print ("ErrorMessage = [" . $tResponse->getErrorMessage() . "]<br>");
}
?>