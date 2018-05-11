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
class AgentBatchPaymentRequest extends TrxRequest {
	public $agentBatch = array (
		"BatchNo" => "",
		"BatchDate" => "",
		"BatchTime" => "",
		"AgentCount" => "",
		"AgentAmount" => ""
	);
	public $details = array ();
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_EBUS_AGENTBATCH_REQ,
		"ReceiveAccount" => "",
		"ReceiveAccName" => "",
		"CurrencyCode" => ""
	);
	public $iSumAmount = 0;
	function __construct() {
	}

	protected function getRequestMessage() {
		Json :: arrayRecursive($this->agentBatch, "urlencode", false);
		Json :: arrayRecursive($this->request, "urlencode", false);
		$js = '"AgentBatch":' . (json_encode(($this->agentBatch)));
		$js = substr($js, 0, -1);
		$js = $js . '},"Details":[';
		$count = count($this->details, COUNT_NORMAL);
		for ($i = 0; $i < $count; $i++) {
			Json :: arrayRecursive($this->details[$i], 'urlencode', false);
			$js = $js . json_encode($this->details[$i]);
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
		if (count($this->agentBatch, COUNT_NORMAL) === 0)
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批次信息不允许为空");
		if ((int) $this->agentBatch["AgentCount"] !== count($this->details, COUNT_NORMAL)) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批内明细合计笔数(" . count($this->details, COUNT_NORMAL) . ")与批次的总笔数(" . $this->agentBatch["AgentCount"] . ")不符");
		}
		if (count($this->details, COUNT_NORMAL) > ILength :: MAXSUMCOUNT) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批次的总笔数(" . count($this->details, COUNT_NORMAL) . ")超过最大限制(" . ILength :: MAXSUMCOUNT . ")");
		}
		$sAgentAmount = $this->agentBatch["AgentAmount"];
		if (!((double) $sAgentAmount === (double) $this->iSumAmount)) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批内明细合计金额(" . $this->agentBatch["AgentAmount"] . ")与批次的总金额(" . $this->iSumAmount . ")不符");
		}

		if (!DataVerifier :: isValidString($this->agentBatch["BatchNo"], ILength :: ORDERID_LEN))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批次号长度超过限制或为空");
		if (!DataVerifier :: isValidDate($this->agentBatch["BatchDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批次日期格式不正确");
		if (!DataVerifier :: isValidTime($this->agentBatch["BatchTime"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批次时间格式不正确");
		if (!DataVerifier :: isValidAmount($this->agentBatch["AgentAmount"], 2))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批量授权扣款总金额不正确");

		if ($this->request["CurrencyCode"] !== "156")
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "币种不合法");

		#endregion
		//验证dic信息
		foreach ($this->details as $detail) {
			if (!DataVerifier :: isValid($detail["SeqNo"]))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "序列号不合法");
			if (!DataVerifier :: isValidString($detail["OrderNo"], ILength :: ORDERID_LEN))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "交易编号不合法");
			if (!DataVerifier :: isValidString($detail["AgentSignNo"], ILength :: ORDERID_LEN))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "授权支付签约号不合法");
			if (!DataVerifier :: isValidAmount($detail["OrderAmount"], 2))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "账单金额不合法");
			//if (!($detail["CommodityType"] === ICommodityType :: COMMODITY_TYPE_RECHARGE) && !($detail["CommodityType"] === ICommodityType :: COMMODITY_TYPE_CONFSUME) && !($detail["CommodityType"] === ICommodityType :: COMMODITY_TYPE_TRANSFER))
			if (!(ICommodityType :: InArray($detail["CommodityType"])))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "序列号" . $detail["SeqNo"] . "商品种类不合法");
			if (!($detail["InstallmentMark"] === IInstallmentmark :: INSTALLMENTMARK_YES) && !($detail["InstallmentMark"] === IInstallmentmark :: INSTALLMENTMARK_NO))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "分期标识为空或输入非法");
			if ($detail["InstallmentMark"] === IInstallmentmark :: INSTALLMENTMARK_YES) {
				if (strlen($detail["InstallmentCode"]) !== 8) {
					throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "分期代码长度应该为8位");
				}
				if (!DataVerifier :: isValid($detail["InstallmentNum"]) || strlen($detail["InstallmentNum"]) > 2) {
					throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "分期期数非有效数字或者长度超过2");
				}
			}
			if (!DataVerifier :: isValidString($detail["ProductName"], ILength :: PRODUCTNAME_LEN))
				throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1101, "商品名称不合法");
			if (($detail["IsBreakAccount"] !== IIsBreakAccountType :: IsBreak_TYPE_YES) && ($detail["IsBreakAccount"] !== IIsBreakAccountType :: IsBreak_TYPE_NO)) {
				throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "交易是否分账设置异常，必须为：0或1");
			}
		}
	}
}
?>