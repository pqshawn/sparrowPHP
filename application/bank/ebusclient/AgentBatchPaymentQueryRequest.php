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
class AgentBatchPaymentQueryRequest extends TrxRequest {
	public $request = array (
		"TrxType" => IFunctionID :: TRX_TYPE_EBUS_AGENTBATCHQUERY_RESULT,
		"BatchNo" => "",
		"BatchDate" => ""
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
		//1.校验批次号最大长度
		if (!DataVerifier :: isValidString($this->request["BatchNo"], ILength :: ORDERID_LEN))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批次号长度超过限制或为空");
		//2.校验批次日期合法性
		if (!DataVerifier :: isValidDate($this->request["BatchDate"]))
			throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "批次日期格式不正确");
	}
	/// <summary>
	///  取得核准状态的中文说明。
	///  
	///  @param aStatus
	///             批量状态代码
	///  @return $tStatusChinese 批量状态的中文说明。
	/// </summary>
	public function getBatchSatusChinese($aStatus) {
		$tStatusChinese = "";
		if ($aStatus === (IBatchStatus :: STATUS_UNCHECK)) {
			$tStatusChinese = "批量待复核";
		} else
			if ($aStatus === (IBatchStatus :: STATUS_CHECKSUCCESS)) {
				$tStatusChinese = "批量复核通过待发送";
			} else
				if ($aStatus === (IBatchStatus :: STATUS_REJECT)) {
					$tStatusChinese = "批量复核被驳回";
				} else
					if ($aStatus === (IBatchStatus :: STATUS_SEND)) {
						$tStatusChinese = "批量等待处理";
					} else
						if ($aStatus === (IBatchStatus :: STATUS_SUCCESS)) {
							$tStatusChinese = "批量提交成功";
						} else
							if ($aStatus === (IBatchStatus :: STATUS_FAIL)) {
								$tStatusChinese = "批量提交失败";
							} else {
								$tStatusChinese = "未知状态";
							}
		return $tStatusChinese;
	}
}
?>