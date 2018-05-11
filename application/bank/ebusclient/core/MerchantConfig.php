<?php
class_exists('TrxException') or require (dirname(__FILE__) . '/TrxException.php');

class MerchantConfig {
	//签名算法
	const SIGNATURE_ALGORITHM = 'SHA1withRSA';

	//证书储存媒体 - 文件形式
	const KEY_STORE_TYPE_FILE = '0';

	//证书储存媒体 - Sign Server
	const KEY_STORE_TYPE_SIGN_SERVER = '1';

	//商户数
	private static $iMerchantNum = 1;

	//证书储存媒体
	private static $iKeyStoreType = '0';

	//初始旗标
	private static $iIsInitialed = FALSE;

	//商户配置文件
	private static $iResourceBundle = null;

	//商户号
	private static $iMerchantIDs = array ();

	//商户证书（Base64编码）
	private static $iMerchantCertificates = array ();

	//商户私钥
	private static $iMerchantKeys = array ();

	//网上支付平台通讯方式（HTTP / HTTPS）
	private static $iTrustPayConnectMethod = 'http';

	//网上支付平台服务器IP
	private static $iTrustPayServerName = '';

	//网上支付平台交易端口
	private static $iTrustPayServerPort = 0;

	//网上支付平台交易网址
	private static $iTrustPayTrxURL = '';

	//商户通过浏览器提交网上支付平台交易网址
	private static $iTrustPayIETrxURL = '';

	//商户通过浏览器提交网上支付平台交易失败网址
	private static $iMerchantErrorURL = '';

	//网上支付平台接口特性
	private static $iNewLine = '1';

	//网上支付平台证书
	private static $iTrustpayCertificate = null;

	//商户日志开关
	private static $iIsLog = FALSE;

	//商户日志目录
	private static $iLogPath = '';
	
	private static $iLogWriter = null;

	public function __construct() {
		self :: bundle();
	}

public static function getLogWriterObject($LogWriter) {
		self :: $iLogWriter = $LogWriter;
		return self :: $iLogWriter ;
	}
	public static function getTrustPayConnectMethod() {
		self :: bundle();
		return self :: $iTrustPayConnectMethod;
	}
	public static function getKeyStoreType() {
		self :: bundle();
		return self :: $iKeyStoreType;
	}
	public static function getTrustPayServerName() {
		self :: bundle();
		return self :: $iTrustPayServerName;
	}
	public static function getTrustPayServerPort() {
		self :: bundle();
		return self :: $iTrustPayServerPort;
	}
	public static function getTrustPayNewLine() {
		self :: bundle();
		return self :: $iNewLine;
	}
	public static function getTrustPayTrxURL() {
		self :: bundle();
		return self :: $iTrustPayTrxURL;
	}
	public static function getTrustPayIETrxURL() {
		self :: bundle();
		return self :: $iTrustPayIETrxURL;
	}
	public static function getMerchantErrorURL() {
		self :: bundle();
		return self :: $iMerchantErrorURL;
	}
	public static function getTrustpayCertificate() {
		self :: bundle();
		return self :: $iTrustpayCertificate;
	}
	public static function getMerchantNum() {
		self :: bundle();
		return self :: $iMerchantNum;
	}
	public static function getIsLog() {
		self :: bundle();
		return self :: $iIsLog;
	}

	public static function getMerchantID($aMerchantNo) {
		self :: bundle();
		return self :: $iMerchantIDs[$aMerchantNo -1];
	}

	public static function getTrxLogFile($aFileName = 'TrxLog') {
		self :: bundle();
		$tLogFile = null;
		if (self :: $iIsLog) {
			$datatime = new DateTime('now', new DateTimeZone('Asia/Shanghai'));
			$tFileName = self :: $iLogPath . "/$aFileName." . $datatime->format('Ymd') . '.log';
			$tLogFile = fopen($tFileName, 'a');
			if (!$tLogFile) {
				throw new TrxException(TrxException :: TRX_EXC_CODE_1004, TrxException :: TRX_EXC_MSG_1004, " - 系统无法写入交易日志至[$tFileName]中!");
			}
		}
		return $tLogFile;

	}

	private static function bundle() {
		if (!self :: $iIsInitialed) {
			//1、读取系统配置文件
			$tIniFile = getenv('ABCMerchantIniFile');
			if (!$tIniFile) {
				$tIniFile = dirname(__FILE__) . '/../TrustMerchant.ini';
			}
			self :: $iResourceBundle = @ parse_ini_file($tIniFile);
			if (empty (self :: $iResourceBundle)) {
				throw new TrxException(TrxException :: TRX_EXC_CODE_1000, TrxException :: TRX_EXC_MSG_1000);
			}

			//2、读取系统配置段
			self :: $iTrustPayConnectMethod = self :: getParameterByName('TrustPayConnectMethod');
			self :: $iTrustPayServerName = self :: getParameterByName('TrustPayServerName');
			self :: $iTrustPayServerPort = intval(self :: getParameterByName('TrustPayServerPort'));
			if (self :: $iTrustPayServerPort == 0) {
				throw new TrxException(TrxException :: TRX_EXC_CODE_1001, TrxException :: TRX_EXC_MSG_1001 . ' - 网上支付平台交易端口[TrustPayServerPort]配置错误！');
			}
			self :: $iTrustPayTrxURL = self :: getParameterByName('TrustPayTrxURL');
			self :: $iTrustPayIETrxURL = self :: getParameterByName('TrustPayIETrxURL');
			self :: $iMerchantErrorURL = self :: getParameterByName('MerchantErrorURL');
			$tNewLine = self :: getParameterByName('TrustPayNewLine');
			if ($tNewLine == '1') {
				self :: $iNewLine = '\n';
			} else {
				self :: $iNewLine = '\r\n';
			}
			$tTrustPayCertFile = self :: getParameterByName('TrustPayCertFile');
			self :: $iTrustpayCertificate = openssl_x509_read(self :: der2pem(file_get_contents($tTrustPayCertFile)));
			if (!self :: $iTrustpayCertificate) {
				throw new TrxException(TrxException :: TRX_EXC_CODE_1002, TrxException :: TRX_EXC_MSG_1002 . "[$tTrustPayCertFile]！");
			}

			self :: $iIsLog = (self :: getParameterByName('EnableLog', FALSE) == '1');
			if (self :: $iIsLog) {
				self :: $iLogPath = self :: getParameterByName('LogPath');
			}

			//3、读取商户号
			self :: $iMerchantIDs = array_filter(array_map('trim', explode(',', self :: getParameterByName('MerchantID'), 100)));
			self :: $iMerchantNum = count(self :: $iMerchantIDs);

			//4、读取商户证书
			self :: $iKeyStoreType = self :: getParameterByName('MerchantKeyStoreType');
			if (self :: $iKeyStoreType == self :: KEY_STORE_TYPE_FILE) {
				self :: bindMerchantCertificateByFile();
			} else
				if (self :: $iKeyStoreType == self :: KEY_STORE_TYPE_SIGN_SERVER) {
				} else {
					throw new TrxException(TrxException :: TRX_EXC_CODE_1001, TrxException :: TRX_EXC_MSG_1001 . ' - 证书储存媒体配置错误！');
				}
			self :: $iIsInitialed = TRUE;
		}
	}

	public static function getParameterByName($aParamName, $aThrowException = TRUE) {
		if (self :: $iResourceBundle == null) {
			self :: bundle();
		}
		if (array_key_exists($aParamName, self :: $iResourceBundle)) {
			$tValue = self :: $iResourceBundle[$aParamName];
		} else {
			$tValue = '';
		}
		if ($tValue == '' && $aThrowException) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1001, TrxException :: TRX_EXC_MSG_1001 . " - 未设定[$aParamName]参数值!");
		}
		return $tValue;
	}

	private static function der2pem($der_data) {
		$pem = chunk_split(base64_encode($der_data), 64, "\n");
		$pem = "-----BEGIN CERTIFICATE-----\n" . $pem . "-----END CERTIFICATE-----\n";
		return $pem;
	}

	private static function bindMerchantCertificateByFile() {
		$tMerchantCertFiles = self :: getParameterByName('MerchantCertFile');
		$tMerchantCertPasswords = self :: getParameterByName('MerchantCertPassword');

		$tMerchantCertFileArray = array_filter(array_map('trim', explode(',', $tMerchantCertFiles, 100)));
		$tMerchantCertPasswordArray = array_filter(array_map('trim', explode(',', $tMerchantCertPasswords, 100)));

		if (self :: $iMerchantNum != count($tMerchantCertFileArray) || self :: $iMerchantNum != count($tMerchantCertPasswordArray)) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1007, TrxException :: TRX_EXC_MSG_1007);
		}

		self :: $iMerchantCertificates = array ();
		self :: $iMerchantKeys = array ();
		for ($i = 0; $i < self :: $iMerchantNum; $i++) {
			//1、读取证书
			$tCertificate = array ();
			if (openssl_pkcs12_read(file_get_contents($tMerchantCertFileArray[$i]), $tCertificate, $tMerchantCertPasswordArray[$i])) {
				//2、验证证书是否在有效期内
				$cer = openssl_x509_parse($tCertificate['cert']);
				$t = time();
				if ($t < $cer['validFrom_time_t'] || $t > $cer['validTo_time_t']) {
					throw new TrxException(TrxException :: TRX_EXC_CODE_1005, TrxException :: TRX_EXC_MSG_1005);
				}
				self :: $iMerchantCertificates[] = $tCertificate;
				//3、取得密钥
				$pkey = openssl_pkey_get_private($tCertificate['pkey']);
				if ($pkey) {
					self :: $iMerchantKeys[] = $pkey;
				} else {
					echo(TrxException :: TRX_EXC_CODE_1003.TrxException :: TRX_EXC_MSG_1003."无法生成私钥证书对象！");
					self:: $iLogWriter->logNewLine(TrxException :: TRX_EXC_CODE_1003.TrxException :: TRX_EXC_MSG_1003."无法生成私钥证书对象！");
				}

			} else {				
				echo(TrxException :: TRX_EXC_CODE_1002.TrxException :: TRX_EXC_MSG_1002.'[' . $tMerchantCertFileArray[$i]. "]！");
				self:: $iLogWriter->logNewLine(TrxException :: TRX_EXC_CODE_1003.TrxException :: TRX_EXC_MSG_1003."无法生成私钥证书对象！");
			}

		}
	}

	public static function signMessage($aMerchantNo, $aMessage) {
		self :: bundle();
		$tMessage = null;
		if (self :: $iKeyStoreType == self :: KEY_STORE_TYPE_FILE) {
			$tMessage = self :: fileSignMessage($aMerchantNo, $aMessage);
		} else
			if (self :: $iKeyStoreType == self :: KEY_STORE_TYPE_SIGN_SERVER) {
				$tMessage = self :: signServerSignMessage($aMessage);
			}

		if (!$tMessage) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1102, TrxException :: TRX_EXC_MSG_1102);
		}

		return $tMessage;
	}

	private static function fileSignMessage($aMerchantNo, $aMessage) {
		$key = self :: $iMerchantKeys[$aMerchantNo -1];
		$signature = '';
		$data = strval($aMessage);
		if (!openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA1)) {
			return null;
		}
		$signature = base64_encode($signature);
		$tMessage = "{\"Message\":$data" . "," . '"Signature-Algorithm":' . '"' . self :: SIGNATURE_ALGORITHM . '","Signature":"' . $signature . '"}';
		return $tMessage;
	}

	private static function signServerSignMessage($aMessage) {
		throw new Exception('Not implement');
	}

	public static function verifySign($aMessage) {
		self :: bundle();
		$tTrxResponse = $aMessage->getValue('Message');
		if ($tTrxResponse == null) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1301, TrxException :: TRX_EXC_MSG_1301, '无[Message]段！');
		}
		$tAlgorithm = $aMessage->getValue('Signature-Algorithm');
		if ($tAlgorithm == null) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1301, TrxException :: TRX_EXC_MSG_1301, '无[Signature-Algorithm]段！');
		}
		$tSignBase64 = $aMessage->getValue('Signature');
		if ($tSignBase64 == null) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1301, TrxException :: TRX_EXC_MSG_1301, '无[Signature]段！');
		}

		$tSign = base64_decode($tSignBase64);
		$key = openssl_pkey_get_public(self :: $iTrustpayCertificate);
		$data = strval($tTrxResponse);
		try {
			if (openssl_verify($data, $tSign, $key, OPENSSL_ALGO_SHA1) == 1) {
				;
			} else {
				throw new TrxException(TrxException :: TRX_EXC_CODE_1302, TrxException :: TRX_EXC_MSG_1302);
			}
		} catch (Exception $e) {
			
			throw new TrxExCeption(TrxExCeption :: TRX_EXC_CODE_1999, TrxException :: TRX_EXC_MSG_1999 . ' - ' . $e->getMessage());
		}

	}

	public static function verifySignXML($aMessage) {
		self :: bundle();
		$aMessage = new XMLDocument($aMessage);

		$tTrxResponse = $aMessage->getValue('Message');
		if ($tTrxResponse == null) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1301, TrxException :: TRX_EXC_MSG_1301, '无[Message]段！');
		}
		$tAlgorithm = $aMessage->getValue('Signature-Algorithm');
		if ($tAlgorithm == null) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1301, TrxException :: TRX_EXC_MSG_1301, '无[Signature-Algorithm]段！');
		}
		$tSignBase64 = $aMessage->getValue('Signature');
		if ($tSignBase64 == null) {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1301, TrxException :: TRX_EXC_MSG_1301, '无[Signature]段！');
		}

		$tSign = base64_decode($tSignBase64);
		$key = openssl_pkey_get_public(self :: $iTrustpayCertificate);
		$data = strval($tTrxResponse);

		if (openssl_verify($data, $tSign, $key, OPENSSL_ALGO_SHA1) == 1) {
			;
		} else {
			throw new TrxException(TrxException :: TRX_EXC_CODE_1302, TrxException :: TRX_EXC_MSG_1302);
		}

	}
}
?>