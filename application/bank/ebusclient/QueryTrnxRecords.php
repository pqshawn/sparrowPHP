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
class QueryTrnxRecords extends TrxRequest {
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_QUERYTRNXRECORDS,
		"SettleDate" => "",
		"SettleStartHour" => "",
		"SettleEndHour" => "",
		"ZIP" => ""
	);
	function __construct() {
	}

	protected function getRequestMessage() {
		Json :: arrayRecursive($this->request, "urlencode", false);
		$tMessage = json_encode($this->request);
		$tMessage = urldecode($tMessage);
		return $tMessage;
	}

	/// 支付请求信息是否合法
	protected function checkRequest() {
		if (!DataVerifier :: isValidDate($this->request["SettleDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "交易流水查询
			日期不合法！");
		if (!is_numeric($this->request["SettleStartHour"]) || !is_numeric($this->request["SettleEndHour"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "查询起止时间不合法，必输输入0-23之间的有效时间段，且截止时间不小于开始时间！");
		$startLen = strlen($this->request["SettleStartHour"]);
		$endLen = strlen($this->request["SettleEndHour"]);
		$startHour = $startLen < 2 ? "0" . $this->request["SettleStartHour"] : $this->request["SettleStartHour"];
		$endHour = $endLen < 2 ? "0" + $this->request["SettleEndHour"] : $this->request["SettleEndHour"];
		if ($startHour < 0 || $startHour > 23 || $endHour < 0 || $endHour > 23 || $startHour > $endHour) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "对账起止时间不合法，必须输入0-23之间的有效时间段，且截止时间不小于开始时间！");
		}

		if (!($this->request["ZIP"] === "1") && !($this->request["ZIP"] === "0")) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "压缩标识不合法！");
		}
	}
}
?>