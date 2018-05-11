<?php
class_exists('ICertificateType') or require(dirname(__FILE__).'/ICertificateType.php');
class DataVerifier
{
	    ///**校验证件类型正确性*/
        public static function isValidCertificate($sCertificateType, $sCertificateNo)
        {

            if (strpos(ICertificateType::CERTIFICATETYPE, "|".$sCertificateType."|") === false)
            {
                return false;
            }
            if ($sCertificateNo == null) return false;
            $len = strlen($sCertificateNo);
            if (!(ICertificateType::I === $sCertificateType))
                return true;

            if ($len != 15 && $len != 18)
                return false;

            return true;

        }
		 /**
         * 检验银行卡号是否合法
         * @param iBankCardNo
         * @return
         */
        public static function isValidBankCardNo($iBankCardNo)
        {

            if (!self::isValidString($iBankCardNo, ILength::CARDNO_LEN))
            	return false;
            $numeric = "1234567890";
            for ($i = 0; $i < strlen($iBankCardNo); $i++)
            {
                $character = substr($iBankCardNo,$i, 1);
                if (strpos($numeric, $character) === false)
                {
                    return false;
                }
            }
            return true;
        }
        
         /**校验字符串是否不为空且有效*/
        
        public static function isValidString($sValue, $len)
        {
            if ($sValue == null) return false;
            if (strlen($sValue) > $len) return false;
            return true;
        }
		/// <summary> 检查传入的字符串时否符合URL的格式。
		/// </summary>
		/// <param name="aString">需要检查的字符串。
		/// </param>
		/// <returns> 检查结果，true:正确   false:不正确
		/// 
		/// </returns>
		public static function isValidURL($aString)
		{
			if ((strlen($aString) < 0) || (strlen($aString)> ILength :: RESULT_NOTIFY_URL_LEN))
				return false;
			if ((strpos($aString, 'http://') === false) && (strpos($aString, 'https://') === false))
				return false;
			return true;
		}
		
		 /**
         * 检验传入的字符串是否合法
         * @param 
         * @return
         */
        public static function isValid($str)
        {
            $numeric = '1234567890';
            if (strlen($str) <= 0)
                return false;
            for ($i = 0; $i < strlen($str); $i++)
            {
                $character = $str[$i];
                if (strpos($numeric, $character) === false)
                {
                    return false;
                }
            }
            /**/
            return true;
        }
        
        /// <summary> 检查传入的字符串时否符合YYYY/MM/DD的日期格式。
        /// </summary>
        /// <param name="aString">需要检查的字符串。
        /// </param>
        /// <returns> 检查结果，true:正确   false:不正确
        /// 
        /// </returns>
        public static function isValidDate($aString)
        {
            if (strlen($aString) !== 10)
                return false;
            if (($aString[4] !== '/') || ($aString[7] !== '/'))
                return false;
			$tYYYY = substr($aString, 0, 4);
            $tMM = substr($aString, 5, 2);
            $tDD = substr($aString, 8, 2);
            if (($tMM < 1) || ($tMM > 12))
				return false;
			if (($tDD < 1) || ($tDD > 31))
            	return false;
            return true;
        }

        /// <summary> 检查传入的字符串时否符合HH:MM:SS的时间格式。
        /// </summary>
        /// <param name="aString">需要检查的字符串。
        /// </param>
        /// <returns> 检查结果，true:正确   false:不正确
        /// 
        /// </returns>
        public static function isValidTime($aString)
        {
            if (strlen($aString) !== 8)
                return false;
            if (($aString[2] !== ':') || ($aString[5] !== ':'))
                return false;
			$tHH = substr($aString, 0, 2);
			$tMM = substr($aString, 3, 2);
			$tSS = substr($aString, 6, 2);
			if (($tHH < 0) || ($tHH > 23))
            	return false;
            if (($tMM < 0) || ($tMM > 59))
            	return false;
            if (($tSS < 0) || ($tSS > 59))
            	return false;              

            return true;
        }
        
        /// <summary> 检查传入的金额是否符合要。
		/// </summary>
		/// <param name="aAmount">金额。
		/// </param>
		/// <param name="aExp">小数点后位数，如果小于零时，将不对传入的金额作检查并回传false。
		/// </param>
		/// <returns> 检查结果，true:正确   false:不正确
		/// 
		/// </returns>
		public static function isValidAmount($tAmountStr, $aExp) 
		{
			if ($tAmountStr <= 0)
				return false;
			if (!is_numeric($tAmountStr))
				return false;
			if ($aExp >= 0) 
			{
				$tIndex = strpos($tAmountStr, ".", 0);
				if ($tIndex === false)
					return true;
				else if ($tIndex >= strlen($tAmountStr) - $aExp - 1)
					return true;
				
			}
		}
		
}

?>