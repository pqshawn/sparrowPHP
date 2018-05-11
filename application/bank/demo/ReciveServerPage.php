<?php
require_once ('../ebusclient/Result.php');
//1、取得MSG参数，并利用此参数值生成验证结果对象
$tResult = new Result();
$tResponse = $tResult->init($_POST['MSG']);

if ($tResponse->isSuccess()) {
	//2、、支付成功
	//tMerchantPage = "http://172.30.7.117/demo/CustomerPage.aspx?请传入必要的参数"  如下：
	$tMerchantPage = "http://localhost/demo/CustomerPage.aspx?OrderNo=" . $tResponse->getValue("OrderNo");

} else {
	//3、失败
	//tMerchantPage = "http://172.30.7.117/demo/MerchantFailure.aspx?请传入必要的参数" 如下：
	$tMerchantPage = "http://localhost/demo/MerchantFailure.php?OrderNo=" . $tResponse->getValue("OrderNo");
}
print ("<html><head><meta http-equiv=\"refresh\" content=\"0; url='<%= tMerchantPage %>'\"></head></html>");
?>