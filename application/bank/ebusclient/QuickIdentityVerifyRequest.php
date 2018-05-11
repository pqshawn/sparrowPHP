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
class QuickIdentityVerifyRequest extends TrxRequest {
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_STATIC_IDENTITY_VERIFY_REQ,
		"CustomType" => "",
		"ClientName" => "",
		"AccNo" => "",
		"CertificateNo" => "",
		"CertificateType" => "",
		"MobileNo" => "",
		"CustomNo" => ""
	);
	function __construct() {
		$this->request["TrxType"] = IFunctionID :: TRX_TYPE_STATIC_IDENTITY_VERIFY_REQ;
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
		// 检验卡号合法性
		if (!DataVerifier :: isValidBankCardNo($this->request["AccNo"])) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "银行卡号不合法");
		}
		// 检验证件类型、证件号码合法性
		if (!DataVerifier :: isValidCertificate($this->request["CertificateType"], $this->request["CertificateNo"])) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "证件类型、证件号码不合法");
		}
		// 检验证件类型、证件号码合法性
		if ($this->request["ClientName"] == null) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "客户姓名不合法");
		}
		//验证手机号
		if (!DataVerifier :: isValid($this->request["MobileNo"])) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "手机号不合法！");
		}
	}
}
?>