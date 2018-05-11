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
class_exists('IIsBreakAccountType') or require (dirname(__FILE__) . '/core/IIsBreakAccountType.php');
class AgentPaymentRequest extends TrxRequest {
	public $orderitems = array ();
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_EBUS_AgentPayment_REQ,
		"OrderDate" => "",
		"OrderTime" => "",
		"OrderNo" => "",
		"AgentSignNo" => "",
		"CardNo" => "",
		"CurrencyCode" => "",
		"Amount" => "",
		"ReceiverAddress" => "",
		"Fee" => "",
		"CertificateNo" => "",
		"InstallmentMark" => "",
		"InstallmentCode" => "",
		"InstallmentNum" => "",
		"CommodityType" => "",
		"PaymentLinkType" => "",
		"BuyIP" => "",
		"ExpiredDate" => "",
		"ReceiveAccount" => "",
		"ReceiveAccName" => "",
		"MerchantRemarks" => "",
		"IsBreakAccount" => "",
		"SplitAccTemplate" => ""
	);
	function __construct() {
	}

	protected function getRequestMessage() {
		Json :: arrayRecursive($this->request, "urlencode", false);
		$js = '"OrderItems":[';
		$count = count($this->orderitems, COUNT_NORMAL);
		for ($i = 0; $i < $count; $i++) {
			Json :: arrayRecursive($this->orderitems[$i], 'urlencode', false);
			$js = $js . json_encode($this->orderitems[$i]);
			if ($i < $count -1) {
				$js = $js . ',';
			}
		}
		$js = $js . ']}';
		$tMessage = json_encode($this->request);
		$tMessage = substr($tMessage, 0, -1);
		$tMessage = $tMessage . ',' . $js;
		$tMessage = urldecode($tMessage);
		return $tMessage;
	}

	/// 支付请求信息是否合法
	protected function checkRequest() {
		if (!DataVerifier :: isValidDate($this->request["OrderDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "订单日期格式不正确");
		if (!DataVerifier :: isValidTime($this->request["OrderTime"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "订单时间格式不正确");
		if (!DataVerifier :: isValidString($this->request["OrderNo"], ILength :: ORDERID_LEN))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "交易编号不合法");
		if (!DataVerifier :: isValidString($this->request["AgentSignNo"], ILength :: ORDERID_LEN))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "签约协议号不合法");
		if ($this->request["CurrencyCode"] !== ("156"))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "账单币种不合法");
		if (!DataVerifier :: isValidAmount($this->request["Amount"], 2))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "账单金额不合法");
		if (!ICommodityType :: InArray($this->request["CommodityType"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "商品种类不合法");
		if (!($this->request["InstallmentMark"] === IInstallmentmark :: INSTALLMENTMARK_YES) && !($this->request["InstallmentMark"] === IInstallmentmark :: INSTALLMENTMARK_NO))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "分期标识为空或输入非法");
		if ($this->request["InstallmentMark"] === IInstallmentmark :: INSTALLMENTMARK_YES) {
			if (strlen($this->request["InstallmentCode"]) !== 8) {
				throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "分期代码长度应该为8位");
			}

			if (!DataVerifier :: isValid($this->request["InstallmentNum"]) || strlen($this->request["InstallmentNum"]) > 2) {
				throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "分期期数非有效数字或者长度超过2");
			}
		}else
		{
			unset ($this->order["InstallmentCode"]);
			unset ($this->order["InstallmentNum"]);
		}
		if (($this->request["IsBreakAccount"] !== IIsBreakAccountType :: IsBreak_TYPE_YES) && ($this->request["IsBreakAccount"] !== IIsBreakAccountType :: IsBreak_TYPE_NO)) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "交易是否分账设置异常，必须为：0或1");
		}
		$tError = $this->isValid();
		if (strlen($tError) !== 0)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "订单信息不合法！[" . $tError . "]");
	}
	/// 支付请求信息是否合法
	private function isValid() {
		#region 验证$orderitems信息（订单明细）
		if (count($this->orderitems, COUNT_NORMAL) < 1)
			return "商品明细为空";
		foreach ($this->orderitems as $orderitem) {
			if ($orderitem["ProductName"] == null)
				return "产品名称为空";
			if (strlen($orderitem["ProductName"]) > 100)
				return "产品名称超长";
		}
		return "";
	}
}
?>