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
class PaymentIERequest extends TrxRequest {
	public $order = array (
		"PayTypeID" => "",
		"OrderNo" => "",
		"ExpiredDate" => "",
		"OrderAmount" => "",
		"Fee" => "",
		"CurrencyCode" => "",
		"ReceiverAddress" => "",
		"InstallmentMark" => "",
		"InstallmentCode" => "",
		"InstallmentNum" => "",
		"BuyIP" => "",
		"OrderDesc" => "",
		"OrderURL" => "",
		"OrderDate" => "",
		"OrderTime" => "",
		"orderTimeoutDate" => "",
		"CommodityType" => ""
	);
	public $orderitems = array ();
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_PAY_REQ,
		"PaymentType" => "",
		"PaymentLinkType" => "",
		"UnionPayLinkType" => "",
		"ReceiveAccount" => "",
		"ReceiveAccName" => "",
		"NotifyType" => "",
		"ResultNotifyURL" => "",
		"MerchantRemarks" => "",
		"IsBreakAccount" => "",
		"SplitAccTemplate" => ""
	);
	function __construct() {

	}

	protected function getRequestMessage() {
		$js = '"Order":' . (json_encode(($this->order)));
		$js = substr($js, 0, -1);
		$js = $js . ',"OrderItems":[';
		$count = count($this->orderitems, COUNT_NORMAL);
		for ($i = 0; $i < $count; $i++) {
			$js = $js . json_encode($this->orderitems[$i]);
			if ($i < $count -1) {
				$js = $js . ',';
			}
		}
		$js = $js . ']}}';
		$tMessage = json_encode($this->request);
		$tMessage = substr($tMessage, 0, -1);
		$tMessage = $tMessage . ',' . $js;
		return $tMessage;
		 
	}

	/// 支付请求信息是否合法
	protected function checkRequest() {
		$tError = $this->isValid();
		if ($tError != null)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101 . "订单信息不合法！[" . $tError . "]");
	}
	/// 支付请求信息是否合法
	private function isValid() {		
		if (($this->request["PaymentType"] === IPaymentType :: PAY_TYPE_UCBP) && ($this->request["PaymentLinkType"] === IChannelType :: PAY_LINK_TYPE_MOBILE)) {
			if ($this->request["UnionPayLinkType"] !== IChannelType :: UPMPLINK_TYPE_WAP)
				return "银联跨行移动支付接入方式不合法";
		} else {
			unset ($this->request["UnionPayLinkType"]);
		}

		if (!($this->request["NotifyType"] === INotifyType :: NOTIFY_TYPE_URL) && !($this->request["NotifyType"] === INotifyType :: NOTIFY_TYPE_SERVER))
			return "支付通知类型不合法！";

		if (!(DataVerifier :: isValidURL($this->request["ResultNotifyURL"])))
			return "支付结果回传网址不合法！";

		if (strlen($this->request["MerchantRemarks"]) > 100) {
			return "附言长度大于100";
		}
		if (($this->request["IsBreakAccount"] !== IIsBreakAccountType :: IsBreak_TYPE_YES) && ($this->request["IsBreakAccount"] !== IIsBreakAccountType :: IsBreak_TYPE_NO)) {
			return "交易是否分账设置异常，必须为：0或1";
		}

		//验证order信息
		$payTypeId = $this->order["PayTypeID"];
		if (!($payTypeId === IPayTypeID :: PAY_TYPE_DIRECTPAY) && !($payTypeId === IPayTypeID :: PAY_TYPE_PREAUTH) && !($payTypeId === IPayTypeID :: PAY_TYPE_INSTALLMENTPAY))
			return "设定交易类型错误";

		if ($payTypeId === IPayTypeID :: PAY_TYPE_INSTALLMENTPAY) {
			if (!($this->order["InstallmentMark"] === IInstallmentmark :: INSTALLMENTMARK_YES)) {
				return "分期标识为空或输入非法";
			} else {
				if (strlen($this->order["InstallmentCode"]) !== 8) {
					return "分期代码长度应该为8位";
				}

				if (!DataVerifier :: isValid($this->order["InstallmentNum"]) || (strlen($this->order["InstallmentNum"]) > 2)) {
					return "分期期数非有效数字或者长度超过2";
				}
			}
		} else {
			unset ($this->order["InstallmentCode"]);
			unset ($this->order["InstallmentNum"]);
		}
		if ((($payTypeId === IPayTypeID :: PAY_TYPE_DIRECTPAY) || ($payTypeId === IPayTypeID :: PAY_TYPE_PREAUTH)) && ($this->order["InstallmentMark"] === IInstallmentmark :: INSTALLMENTMARK_YES))
			return "交易类型为直接支付或预授权支付时，分期标识不允许输入为“1”";
		if (strlen($this->order["OrderNo"]) <= 0)
			return "交易编号为空";
		if (strlen($this->order["OrderNo"]) > ILength :: ORDERID_LEN)
			return "交易编号超长";
		if (!DataVerifier :: isValidDate($this->order["OrderDate"]))
			return "订单日期不合法";
		if (!DataVerifier :: isValidTime($this->order["OrderTime"]))
			return "订单时间不合法";
		if (!ICommodityType :: InArray($this->order["CommodityType"]))
			return "商品种类不合法";
		if (!DataVerifier :: isValidAmount($this->order["OrderAmount"], 2))
			return "订单金额不合法";
		if ($this->order["CurrencyCode"] !== "156")
			return "设定交易币种错误";

		#region 验证$orderitems信息（订单明细）
		if (count($this->orderitems, COUNT_NORMAL) < 1)
			return "商品明细为空";
		foreach ($this->orderitems as $orderitem) {
			if (!DataVerifier :: isValidString($orderitem["ProductName"], ILength :: PRODUCTNAME_LEN))
				return "产品名称不合法";
		}
		return "";
	}
}
?>