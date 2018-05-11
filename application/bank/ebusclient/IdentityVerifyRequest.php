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
class IdentityVerifyRequest extends TrxRequest {
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_IDENTITY_VERIFY_REQ,
		"CustomType" => "",
		"BankCardNo" => "",
		"CertificateNo" => "",
		"CertificateType" => "",
		"ResultNotifyURL" => "",
		"OrderDate" => "",
		"OrderTime" => "",
		"PaymentLinkType" => ""
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
		$customType = $this->request["CustomType"];
		if (!($customType === "0") && !($customType === "1"))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "客户类型不合法");
		if (!DataVerifier :: isValidURL($this->request["ResultNotifyURL"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "验证结果回传网址不合法");
		if (!DataVerifier :: isValidDate($this->request["OrderDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "订单日期不合法");
		if (!DataVerifier :: isValidTime($this->request["OrderTime"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "订单时间不合法");
		if (!DataVerifier :: isValidBankCardNo($this->request["BankCardNo"])) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "银行卡号不合法");
		}
		if (!DataVerifier :: isValidCertificate($this->request["CertificateType"], $this->request["CertificateNo"])) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "证件类型、证件号码不合法");
		}

	}
}
?>