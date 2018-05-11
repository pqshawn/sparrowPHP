<?php
class_exists('TrxException') or require(dirname(__FILE__).'/TrxException.php');
class Json
{
    protected $iReturnCode = '';

    //[响应码]: 交易成功。
    const RC_SUCCESS = '0000';
    
    //错误信息 
    protected $iErrorMessage = '';
    
    //响应信息原始报文
    private $iResponseMessage;

    
    public function isSuccess()
    {
        return $this->iReturnCode === Json::RC_SUCCESS;
    }
    
    public function getReturnCode()
    {
        return $this->iReturnCode;
    }

    public function setReturnCode($aReturnCode)
    {
        $this->iReturnCode = trim($aReturnCode);
        return $this;
    }

    public function getErrorMessage()
    {
        return $this->iErrorMessage;
    }

    public function setErrorMessage($aErrorMessage)
    {
        $this->iErrorMessage = trim($aErrorMessage);
        return $this;
    }

    public function __construct($aJSONString='')
    {    	
        $this->init($aJSONString);
    }

    protected function init($aJSONString)
    {
    	$this->iResponseMessage = $aJSONString;
    	if (!empty($aJSONString))
    	{
	    	$tReturnCode = $this->getValue('ReturnCode');
	        if ($tReturnCode === null)
	        {
	            throw new TrxException(TrxException::TRX_EXC_CODE_1303, TrxException::TRX_EXC_MSG_1303, '无法取得[ReturnCode]!');
	        }
	        $this->setReturnCode($tReturnCode);
	        $tErrorMessage = iconv("GB2312", "UTF-8", $this->getValue('ErrorMessage'));
	        if ($tErrorMessage !== null)
	        {
	            $this->setErrorMessage($tErrorMessage);
	        }
    	}
        return $this;
    }
    public function initWithCodeMsg($aReturnCode, $aErrorMessage)
    {
        $this->setReturnCode($aReturnCode);
        $this->setErrorMessage($aErrorMessage);
    }
   
	public static function arrayRecursive(&$array, $function, $apply_to_keys_also = false) 
	{		
		foreach ($array as $key => $value)
		{ 
			$array[$key] = $function($value); 
		}
	} 
    /// <summary> 回传文件中的信息
        /// </summary>
        /// <param name="aTag">域名
        /// </param>
        /// <returns> 指定域的值
        /// 
        /// </returns>
        public function GetValue($aTag)
        {
            $json = $this->iResponseMessage;            
            $index = 0;
            $length = 0;
            $index = strpos($json, $aTag, 0);
            if ($index === false)
                return "";
            do
            {
            	if($json[$index-1] === "\"" && $json[$index+strlen($aTag)] === "\"")                
                {
                    break;
                }
                else
                {
                    $index = strpos($json, $aTag, $index+1);
                    if ($index === false)
                		return "";
                }
            } while (true);
            $index = $index + strlen($aTag) + 2;            
            $c = $json[$index];
            if ($c === '{') 
			{
				$output = self::GetObjectValue($index, $json);
			}
            if ($c === '"') 
            {
				$output = self::GetStringValue($index, $json);
            }
            return $output;
        }

        /// <summary> 回传文件中的信息
        /// </summary>
        /// <param name="aTag">域名
        /// </param>
        /// <returns> 指定域的object值
        /// 
        /// </returns>
        private function GetObjectValue($index, $json)
        {
            $count = 0;
            $_output = "";
            do
            {
                $c = $json[$index];                
                if ($c === '{')
                {                	
                    $count++;
                }
                if ($c === '}')
                    $count--;

                if ($count !== 0)
                {
                    $_output =$_output.$c;
                }
                else
                {
                    $_output = $_output.$c;
                    return $_output;
                }
                $index++;
            } while (true);
        }
        /// <summary> 回传文件中的信息
        /// </summary>
        /// <param name="aTag">域名
        /// </param>
        /// <returns> 指定域的值
        /// 
        /// </returns>
        private function GetStringValue($index, $json)
        {
            $index++;
            $_output = "";
            do
            {
                $c = $json[$index++];
                if ($c !== '"') 
                {
                    $_output = $_output.$c;
                }
                else
                {                	
                    return $_output;
                }

            } while (true);
        }
        
        /// <summary> 回传JSON文件中字符串书做
        /// </summary>
        /// <param name="aTag">域名
        /// </param>
        /// <returns> 指定域的值
        /// 
        /// </returns>
        public function GetArrayValue($aTag)
        {
            $json = $this->iResponseMessage;
            //Dictionary<int, Hashtable> hashtableDictionary = new Dictionary<int, Hashtable>();
            $hashtableDictionary = array();
            //Hashtable ht = new Hashtable();
            $ht = array();
            $_output = "";
            //int index = json.IndexOf(aTag);
            $index = strpos($json, $aTag, 0);
            if ($index === false)
                return null;
            $length = strlen($aTag);
            $index = $index + $length + 2;
            $startIndex = $index;
            $key = 0;
            do
            {
                $c = $json[$index++];
                if ($c === '[')
                    continue;
                if ($c !== ']')
                {
                    $_output = $_output.$c;
                }

                if ($c === '}')
                {
                    $c = $json[$index++];//防止将}后面的,写到_output里面
                    $ht[$key] =$_output;//将简单的json字符串放入hashtable中
                    $key++;
                    $_output = "";
                }
                if ($c === ']')
                {
                    //if (count($ht) == 0)
                    //    return null;
                    //$hashtableDictionary = self::ParseArray($ht);
                    //return $ht;
                    return $ht;
                }
            } while (true);

            return $ht; ;
        }

       /* public function ParseArray($ht)
        {
            Dictionary<int, Hashtable> dic = new Dictionary<int, Hashtable>();
            Hashtable ht = new Hashtable();
            string json = "";
            foreach (int key in hts.Keys)
            {
                json = hts[key].ToString();
                ht = ParseString(json);
                dic.Add(key, ht);
                ht = new Hashtable();
            }
            return dic;
        }*/
}

?>
