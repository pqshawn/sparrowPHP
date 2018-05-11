<?php
class_exists('TrxRequest') or require (dirname(__FILE__) . '/core/TrxRequest.php');
class_exists('Json') or require (dirname(__FILE__) . '/core/Json.php');
class_exists('IChannelType') or require (dirname(__FILE__) . '/core/IChannelType.php');
class_exists('IPaymentType') or require (dirname(__FILE__) . '/core/IPaymentType.php');
class_exists('INotifyType') or require (dirname(__FILE__) . '/core/INotifyType.php');
class_exists('DataVerifier') or require (dirname(__FILE__) . '/core/DataVerifier.php');
class_exists('ILength') or require (dirname(__FILE__) . '/core/ILength.php');
class_exists('IPayTypeID') or require (dirname(__FILE__) . '/core/IPayTypeID.php');
class_exists('IInstallmentmark') or require (dirname(__FILE__) . '/core/IInstallmentmark.php');
class_exists('ICommodityType') or require (dirname(__FILE__) . '/core/ICommodityType.php');
class QuickPaymentReSend extends TrxRequest {
	public $order = array (
		"OrderNo" => "",
		"CurrencyCode" => "",
		"OrderAmount" => "",
		"OrderDate" => "",
		"OrderTime" => ""
	);
	public $request = array(
		"TrxType" => IFunctionID :: TRX_TYPE_KPAYRESEND_REQ,
	);
	function __construct() {
	}

	protected function getRequestMessage() {
		Json :: arrayRecursive($this->order, "urlencode", false);
		Json :: arrayRecursive($this->request, "urlencode", false);
		$js = '"Order":' . (json_encode(($this->order)));
		$js = substr($js, 0, -1) . '}}';
		$tMessage = json_encode($this->request);
		$tMessage = substr($tMessage, 0, -1);
		$tMessage = $tMessage . ',' . $js;
		$tMessage = urldecode($tMessage);
		return $tMessage;
	}

	/// 支付请求信息是否合法
	protected function checkRequest() {
		if (count($this->order) === 0)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1100, "未设定订单信息！");
		$tError = $this->isValid();
		if (strlen($tError) !== 0)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "订单信息不合法！[" . $tError . "]");
	}
	/// 支付请求信息是否合法
	private function isValid() {
		if (strlen($this->order["OrderNo"]) == null)
			return "交易编号为空";
		if (!DataVerifier :: isValidAmount($this->order["OrderAmount"], 2))
			return "订单金额不合法";
		if (strlen($this->order["OrderNo"]) > ILength :: ORDERID_LEN)
			return "交易编号超长";
		if (!DataVerifier :: isValidDate($this->order["OrderDate"]))
			return "订单日期不合法";
		if (!DataVerifier :: isValidTime($this->order["OrderTime"]))
			return "订单时间不合法";
		if ($this->order["CurrencyCode"] !== "156")
			return "设定交易币种错误";

		return "";
	}
}
?>