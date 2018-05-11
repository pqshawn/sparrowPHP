<?php
class_exists('XMLDocument') or require (dirname(__FILE__) . '/XMLDocument.php');
class_exists('TrxException') or require (dirname(__FILE__) . '/TrxException.php');

class TrxResponse {
	protected $iReturnCode = '';

	//[响应码]: 交易成功。
	const RC_SUCCESS = '0000';

	//错误信息 
	protected $iErrorMessage = '';

	//响应信息原始报文
	protected $iResponseMessage;

	public function isSuccess() {
		return $this->iReturnCode === TrxResponse :: RC_SUCCESS;
	}

	public function getReturnCode() {
		return $this->iReturnCode;
	}

	public function setReturnCode($aReturnCode) {
		$this->iReturnCode = trim($aReturnCode);
		return $this;
	}

	public function getErrorMessage() {
		return $this->iErrorMessage;
	}

	public function setErrorMessage($aErrorMessage) {
		$this->iErrorMessage = trim($aErrorMessage);
		return $this;
	}
	public function __construct($tXMLString) {
		if ($tXMLString == null) {
			;
		} else {
			$this->initWithXML($tXMLString);
		}
	}

	public function initWithXML($aXMLDocument) {
		$iResponseMessage = new XMLDocument($aXMLDocument);
		$this->init($iResponseMessage);
	}

	public function initWithCodeMsg($aReturnCode, $aErrorMessage) {
		$this->setReturnCode($aReturnCode);
		$this->setErrorMessage($aErrorMessage);
	}

	protected function init($aXMLDocument) {
		$tReturnCode = $aXMLDocument->getValue('ReturnCode');
		if ($tReturnCode === null) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1303, TrxException :: TRX_EXC_MSG_1303, '无法取得[ReturnCode]!');
		}
		$this->setReturnCode($tReturnCode);
		$tErrorMessage = $aXMLDocument->getValue('ReturnMessage');
		if ($tErrorMessage !== null) {
			$this->setErrorMessage($tErrorMessage);
		}
		if ($this->iReturnCode === TrxResponse :: RC_SUCCESS) {
			$this->iResponseMessage = $aXMLDocument;
		}

	}

	public function getValue($aTag) {
		return $this->iResponseMessage->getValueNoNull($aTag);
	}

	public function getOriginalResponseMessage() {
		return $this->iResponseMessage;
	}

	public function getMerchantID() {
		return $this->getValue('MerchantID');

	}

	public function getCustomerNo() {
		return $this->getValue('CustomerNo');

	}

	public function getFunctionID() {
		return $this->getValue('FunctionID');

	}

	public function getContractID() {
		return $this->getValue('ContractID');

	}

	public function getBuyerAmount() {
		return $this->getValue('BuyerAmount');

	}

	public function getEntryFlagDate() {
		return $this->getValue('EntryFlagDate');

	}

	public function getEntryFlag() {
		return $this->getValue('EntryFlag');

	}

	public function getSalerFee() {
		return $this->getValue('SalerFee');

	}

	public function getReturnURL() {
		return $this->getValue('ReturnURL');

	}

	public function getOrderDate() {
		return $this->getValue('OrderDate');

	}

	public function getInterBankFee() {
		return $this->getValue('InterBankFee');

	}

	public function getKeyNext() {
		return $this->getValue('KeyNext');

	}

	public function getAccInfo() {
		return $this->getValue('AccInfo');

	}

	public function getHostDate() {
		return $this->getValue('HostDate');

	}

	public function getHostTime() {
		return $this->getValue('HostTime');

	}

	public function getStatus() {
		return $this->getValue('Status');

	}

	public function getAccDate() {
		return $this->getValue('AccDate');

	}

}

/*
$r = new TrxResponse();
$r->initWithXML(new XMLDocument(''));
*/
?>
