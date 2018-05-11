
<?php
require_once ('../ebusclient/BatchRefundRequest.php');
$orderno_arr = $_REQUEST['OrderNo'];
$neworderNo_arr = $_REQUEST['NewOrderNo'];
$currencycode_arr = $_REQUEST['CurrencyCode'];
$orderamount_arr = $_REQUEST['RefundAmount'];
$remark_arr = $_REQUEST['Remark'];
$totalCount = $_POST['TotalCount'];
$TotalAmount = $_POST['TotalAmount'];

//验证输入信息并取得退款所需要的信息
if (ValidateRequestPara($orderno_arr, $neworderNo_arr, $currencycode_arr, $orderamount_arr, $remark_arr, $totalCount, $TotalAmount)=== false)
 return ;

//1、生成批量退款请求对象
$tRequest = new BatchRefundRequest();
//取得列表项 
$dic = array ();
for ($i = 0; $i < count($orderno_arr, COUNT_NORMAL); $i++) {
	//string[] torder = new String[6];
	$dic["SeqNo"] = $i +1;
	$dic["OrderNo"] = $orderno_arr[$i];
	$dic["NewOrderNo"] = $neworderNo_arr[$i];
	$dic["CurrencyCode"] = $currencycode_arr[$i];
	$dic["RefundAmount"] = $orderamount_arr[$i];
	$dic["Remark"] = $remark_arr[$i];
	$tRequest->order[$i] = $dic;
	$dic = array ();
}
$tRequest->request["BatchNo"] = ($_POST['BatchNo']); //批量编号  （必要信息）
$tRequest->request["BatchDate"] = ($_POST['BatchDate']); //订单日期  （必要信息）
$tRequest->request["BatchTime"] = ($_POST['BatchTime']); //订单时间  （必要信息）
$tRequest->request["MerRefundAccountNo"] = ($_POST['MerRefundAccountNo']); //商户退款账号
$tRequest->request["MerRefundAccountName"] = ($_POST['MerRefundAccountName']); //商户退款名
$tRequest->request["TotalCount"] = ($_POST['TotalCount']); //总笔数  （必要信息）
$tRequest->request["TotalAmount"] = ($_POST['TotalAmount']); //总金额 （必要信息）

$tResponse = $tRequest->postRequest();

if ($tResponse->isSuccess()) {
	print ("<br>Success!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	print ("TrxType   = [" . $tResponse->GetValue("TrxType") . "]<br/>");
	print ("TotalCount  = [" . $tResponse->GetValue("TotalCount") . "]<br/>");
	print ("TotalAmount = [" . $tResponse->GetValue("TotalAmount") . "]<br/>");
	print ("SerialNumber  = [" . $tResponse->GetValue("SerialNumber") . "]<br/>");
	print ("HostDate  = [" . $tResponse->GetValue("HostDate") . "]<br/>");
	print ("HostTime  = [" . $tResponse->GetValue("HostTime") . "]<br/>");
} else {
	print ("<br>Failed!!!" . "</br>");
	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
}

function ValidateRequestPara($orderno_arr, $neworderNo_arr, $currencycode_arr, $orderamount_arr, $remark_arr, $totalCount, $TotalAmount) {
	if (count($orderno_arr, COUNT_NORMAL) !== (int) $totalCount || count($orderamount_arr) !== (int) $totalCount) {
		$lblMessage = "退款总笔数和退款订单总数不一致，正确的退款总笔数是：" . count($orderno_arr, COUNT_NORMAL);
		echo ($lblMessage);
		return false;
	}
	if (!is_numeric($TotalAmount) || !is_numeric($totalCount)) {
		echo ("总金额和总笔数必输是数字，请重新输入!");
		return false;
	}
	//验证订单非空
	foreach ($orderno_arr as $orderno) {
		if ($orderno == null) {
			echo ("退款订单原交易编号不允许为空");
			return false;
		}
	}
	foreach ($neworderNo_arr as $neworderno) {
		if ($neworderno == null) {
			echo ("退款订单编号不允许为空");
			return false;
		}
	}
	foreach ($currencycode_arr as $currencycode) {
		if ($currencycode !== "156") {
			echo ("退款订单交易币种非人民币");
			return false;
		}
	}
	//验证单笔订单退款金额非空并且是数字
	$iTotalAmount = 0;
	foreach ($orderamount_arr as $orderamount) {
		if ($orderamount == null || $orderamount <= 0) {
			echo ("退款订单金额不允许为空且必须为大于0的数字");
			return false;
		}
		if (!is_numeric($orderamount)) {
			echo ("退款订单金额必输为数字");
			return false;
		}
		$iTotalAmount = $iTotalAmount + $orderamount;
	}
	if ((double) $iTotalAmount !== (double) $TotalAmount) {
		echo ("退款总金额与退款订单总金额不一致");
		return false;
	}
}
?>