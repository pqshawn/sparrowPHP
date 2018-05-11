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
class AgentSignContractRequest extends TrxRequest {
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_EBUS_AgentSignContract_REQ,
		"CertificateNo" => "",
		"CertificateType" => "",
		"NotifyType" => "",
		"ResultNotifyURL" => "",
		"OrderNo" => "",
		"PaymentLinkType" => "",
		"MerCustomNo" => "",
		"CardType" => "",
		"OrderDate" => "",
		"OrderTime" => "",
		"InvaidDate" => "",
		"IsSign" => ""
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
		//1.验证是否为空
		if (!($this->request["NotifyType"] === INotifyType :: NOTIFY_TYPE_URL) && !($this->request["NotifyType"] === INotifyType :: NOTIFY_TYPE_SERVER))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "通知类型不合法！");

		//2.检验证件类型、证件号码合法性
		if (!DataVerifier :: isValidCertificate($this->request["CertificateType"], $this->request["CertificateNo"])) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "证件类型、证件号码不合法");
		}

		// 3.检验结果接收URL合法性
		if (!DataVerifier :: isValidURL($this->request["ResultNotifyURL"])) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "结果回传网址不合法");
		}

		if (strlen($this->request["ResultNotifyURL"]) > ILength :: RESULT_NOTIFY_URL_LEN)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "验证结果回传网址不合法！");

		//4.校验定单最大长度
		if (!DataVerifier :: isValidString($this->request["OrderNo"], ILength :: ORDERID_LEN))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "交易编号长度不合法");
		//5.校验定单日期合法性
		if (!DataVerifier :: isValidDate($this->request["OrderDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "订单日期格式不正确");
		//6.校验定单日期合法性
		if (!DataVerifier :: isValidTime($this->request["OrderTime"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "订单时间格式不正确");

		if (!DataVerifier :: isValidDate($this->request["InvaidDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "有效期时间格式不正确");

		if (!($this->request["IsSign"] === "Sign"))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "设置签约/标识不合法");
		if (!($this->request["NotifyType"] === INotifyType :: NOTIFY_TYPE_URL) && !($this->request["NotifyType"] === INotifyType :: NOTIFY_TYPE_SERVER))
			return "支付通知类型不合法！";
	}
}
?>