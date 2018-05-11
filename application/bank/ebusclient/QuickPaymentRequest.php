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
class QuickPaymentRequest extends TrxRequest {
	public $order = array (
		"PayTypeID" => "",
		"orderTimeoutDate" => "",
		"OrderNo" => "",
		"CurrencyCode" => "",
		"OrderAmount" => "",
		"ExpiredDate" => "",
		"OrderDesc" => "",
		"OrderDate" => "",
		"OrderTime" => "",
		"ReceiverAddress" => "",
		"BuyIP" => ""
	);
	public $orderitems = array ();
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_KPAYVERIFY_REQ,
		"CardNo" => "",
		"MobileNo" => "",
		"CommodityType" => "",
		"Installment" => "",
		"ProjectID" => "",
		"Period" => "",
		"PaymentType" => "",
		"PaymentLinkType" => "",
		"ReceiveAccount" => "",
		"ReceiveAccName" => "",
		"MerchantRemarks" => "",
		"IsBreakAccount" => "",
		"SplitAccTemplate" => ""
	);
	function __construct() {
	}

	protected function getRequestMessage() {
		Json :: arrayRecursive($this->order, "urlencode", false);
		Json :: arrayRecursive($this->request, "urlencode", false);
		$js = '"Order":' . (json_encode(($this->order)));
		$js = substr($js, 0, -1);
		$js = $js . ',"OrderItems":[';
		$count = count($this->orderitems, COUNT_NORMAL);
		for ($i = 0; $i < $count; $i++) {
			Json :: arrayRecursive($this->orderitems[$i], "urlencode", false);
			$js = $js . json_encode($this->orderitems[$i]);
			if ($i < $count -1) {
				$js = $js . ',';
			}
		}
		$js = $js . ']}}';
		$tMessage = json_encode($this->request);
		$tMessage = substr($tMessage, 0, -1);
		$tMessage = $tMessage . ',' . $js;
		$tMessage = urldecode($tMessage);
		return $tMessage;
	}

	/// 支付请求信息是否合法
	protected function checkRequest() {
		$tError = $this->isValid();
		if (strlen($tError) !== 0)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "订单信息不合法！[" . $tError . "]");
	}
	/// 支付请求信息是否合法
	private function isValid() {
		#region 验证$this->request信息
		if (!DataVerifier :: isValidBankCardNo($this->request["CardNo"]))
			return "支付账号不合法！";
		if (!DataVerifier :: isValid($this->request["MobileNo"]))
			return "手机号不合法！";
		if (!ICommodityType :: InArray($this->request["CommodityType"]))
			return "商品种类不合法";
		if ((!$this->request["Installment"] === IInstallmentmark :: INSTALLMENTMARK_YES) && (!$this->request["Installment"] === IInstallmentmark :: INSTALLMENTMARK_NO))
			return "分期标识为空或输入非法";
		$payTypeId = $this->order["PayTypeID"];
		if ($payTypeId === IPayTypeID :: PAY_TYPE_INSTALLMENTPAY) {
			if ($this->request["Installment"] === IInstallmentmark :: INSTALLMENTMARK_YES) {
				if (strlen($this->request["ProjectID"]) !== 8) {
					return "分期代码长度应该为8位";
				}

				if (!DataVerifier :: isValid($this->request["Period"]) || strlen($this->request["Period"]) > 2) {
					return "分期期数非有效数字或者长度超过2";
				}
			}
		}
		if (($this->request["IsBreakAccount"] !== IIsBreakAccountType :: IsBreak_TYPE_YES) && ($this->request["IsBreakAccount"] !== IIsBreakAccountType :: IsBreak_TYPE_NO)) {
			return "交易是否分账设置异常，必须为：0或1";
		}
		#endregion

		#region 验证order信息
		if ((!$this->order["PayTypeID"] === IPayTypeID :: PAY_TYPE_DIRECTPAY) && (!$this->order["PayTypeID"] === IPayTypeID :: PAY_TYPE_INSTALLMENTPAY))
			return "设定交易类型错误";
		if ($this->order["OrderAmount"] <= 0)
			return "订单金额小于等于零";
		if (!DataVerifier :: isValidString($this->order["OrderNo"], ILength :: ORDERID_LEN))
			return "交易编号不合法";
		if (strlen($this->order["OrderDesc"]) > ILength :: ORDER_DESC_LEN)
			return "订单说明超长";
		if (!DataVerifier :: isValidDate($this->order["OrderDate"]))
			return "订单日期不合法";
		if (!DataVerifier :: isValidTime($this->order["OrderTime"]))
			return "订单时间不合法";
		if (!DataVerifier :: isValidAmount($this->order["OrderAmount"], 2))
			return "订单金额不合法";
		if ($this->order["CurrencyCode"] !== "156")
			return "设定交易币种错误";
		#endregion

		#region 验证$orderitems信息（订单明细）
		if (count($this->orderitems, COUNT_NORMAL) < 1)
			return "商品明细为空";
		foreach ($this->orderitems as $orderitem) {
			if (!DataVerifier :: isValidString($orderitem["ProductName"], ILength :: PRODUCTNAME_LEN))
				return "产品名称不合法";
		}

		#endregion
		return "";
	}
}
?>