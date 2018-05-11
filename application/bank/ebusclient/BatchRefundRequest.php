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
class BatchRefundRequest extends TrxRequest {
	public $order = array ();
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_OVERDUEREFUND,
		"BatchNo" => "",
		"BatchDate" => "",
		"BatchTime" => "",
		"MerRefundAccountNo" => "",
		"MerRefundAccountName" => "",
		"TotalCount" => "",
		"TotalAmount" => ""
	);
	function __construct() {
	}

	protected function getRequestMessage() {
		Json :: arrayRecursive($this->request, "urlencode", false);
		$js = '"OrderData":[';
		$count = count($this->order, COUNT_NORMAL);
		for ($i = 0; $i < $count; $i++) {
			Json :: arrayRecursive($this->order[$i], 'urlencode', false);
			$js = $js . json_encode($this->order[$i]);
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
		#region 验证request信息
		if (!DataVerifier :: isValidDate($this->request["BatchDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1100, "订单日期不合法！");
		if (!DataVerifier :: isValidTime($this->request["BatchTime"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1100, "订单时间不合法！");
		if ($this->request["BatchNo"] == null)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1100, "批次号不合法！");
		if ($this->request["TotalCount"] <= 0)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "退款交易总笔数不能小于1笔");
		if ($this->request["TotalCount"] > ILength :: MAXSUMCOUNT)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "退款交易总笔数不能大于10000笔");

		if (!DataVerifier :: isValidAmount($this->request["TotalAmount"], 2))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "退款交易总金额不合法！");
		#endregion  
		#region
		if (count($this->order, COUNT_NORMAL) < 1)
			return "退款明细为空";
		foreach ($this->order as $orderitem) {
			if (!DataVerifier :: isValidString($orderitem["OrderNo"], ILength :: ORDERID_LEN))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "退款订单原交易编号不允许为空");
			if (!DataVerifier :: isValidString($orderitem["NewOrderNo"], ILength :: ORDERID_LEN))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "退款订单编号不允许为空");
			if ($orderitem["CurrencyCode"] !== "156")
				throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "交易币种非法");
			if (!DataVerifier :: isValidAmount($orderitem["RefundAmount"], 2))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "退款金额非法");

		}
		#endregion         
	}
}
?>