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
class QuickAgentSignContractRequest extends TrxRequest {
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_EBUS_InterfaceAgentSignContract_REQ,
		"OrderDate" => "",
		"OrderTime" => "",
		"OrderNo" => "",
		"PaymentLinkType" => "",
		"MerCustomNo" => "",
		"AgentSignNo" => "",
		"CardNo" => "",
		"CardType" => "",
		"MobileNo" => "",
		"InvaidDate" => "",
		"IsSign" => "",
		"AccName" => "",
		"CertificateNo" => "",
		"CertificateType" => "",
		"CardDueDate" => "",
		"CVV2" => ""
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
		if (!DataVerifier :: isValidString($this->request["OrderNo"], ILength :: ORDERID_LEN))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "交易编号长度不合法");
		if (!DataVerifier :: isValidBankCardNo($this->request["CardNo"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "签约账号不合法");
		if (!DataVerifier :: isValid($this->request["MobileNo"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "签约手机号不合法");
		//5::校验定单日期合法性
		if (!DataVerifier :: isValidDate($this->request["OrderDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "订单日期格式不正确");
		//6.校验定单日期合法性
		if (!DataVerifier :: isValidTime($this->request["OrderTime"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "订单时间格式不正确");
		if (!DataVerifier :: isValidDate($this->request["InvaidDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "签约有效期格式不正确");
		if (!($this->request["IsSign"] === "Sign"))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "设置签约标识不合法");

		//检验证件类型、证件号码合法性
		if (!DataVerifier :: isValidCertificate($this->request["CertificateType"], $this->request["CertificateNo"])) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "证件类型、证件号码不合法");
		}

		//验证客户姓名
		if ($this->request["AccName"] == null)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1100, "客户姓名未设置");

		if ($this->request["CardType"] === 3) {
			//验证贷记卡CVV2
			if (!DataVerifier :: isValidString($this->request["CVV2"], 3))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1100, "贷记卡CVV2未设置");

			//验证贷记卡有效期
			if (!DataVerifier :: isValidString($this->request["CardDueDate"], 4))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1100, "贷记卡有效期未设置");

		}
	}
}
?>