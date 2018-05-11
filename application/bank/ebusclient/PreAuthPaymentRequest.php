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
class_exists('IPreAuthPayType') or require (dirname(__FILE__) . '/core/IPreAuthPayType.php');
class PreAuthPaymentRequest extends TrxRequest {
	public $order = array (
		"OperateType" => "",
		"OrderDate" => "",
		"OrderTime" => "",
		"OrderNo" => "",
		"OriginalOrderNo" => "",
		"CurrencyCode" => "",
		"OrderAmount" => "",
		"Fee" => "",
		"MerchantRemarks" => ""
	);
	public $request = array (
	"TrxType" => IFunctionID :: TRX_TYPE_EBUS_PREAUTHCANCELCONFIRM_REQ,
	);
	function __construct() {
	}

	protected function getRequestMessage() {
		Json :: arrayRecursive($this->order, "urlencode", false);
		Json :: arrayRecursive($this->request, "urlencode", false);
		$js = '"Order":' . (json_encode(($this->order))) . "}";

		$tMessage = json_encode($this->request);
		$tMessage = substr($tMessage, 0, -1);
		$tMessage = $tMessage . ',' . $js;
		$tMessage = urldecode($tMessage);
		return $tMessage;
	}

	/// 支付请求信息是否合法
	protected function checkRequest() {
		if (!($this->order["OperateType"] === IPreAuthPayType :: PREAUTHPAY_TYPE_CANCEL) && !($this->order["OperateType"] === IPreAuthPayType :: PREAUTHPAY_TYPE_CONFIRM))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "交易类型不合法");
		if (!DataVerifier :: isValidString($this->order["OrderNo"], ILength :: ORDERID_LEN))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "原交易编号不合法");
		if (!DataVerifier :: isValidString($this->order["OriginalOrderNo"], ILength :: ORDERID_LEN))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "交易编号不合法");
		if (!DataVerifier :: isValidDate($this->order["OrderDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "订单日期不合法");
		if (!DataVerifier :: isValidTime($this->order["OrderTime"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "订单时间不合法");
		if (!DataVerifier :: isValidAmount($this->order["OrderAmount"], 2))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "订单金额不合法");
		if ($this->order["CurrencyCode"] !== "156")
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "交易币种不合法");
	}
}
?>