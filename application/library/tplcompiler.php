<?php
/**
 * compiler template
 * 
 * @copyright (c)Ldos.net All rights reserved.
 * @author: Yzwu <distil@163.com>
 */

class TplcompilerLib {
	public static $_vars = array();
	private $_modifier_delimiter = '|';
	private $_modifier_param_delimiter = ':';
	public function __construct() {

	}

	public function __destruct() {

	}

	/**
	 * compile template
	 *
	 * @param string $html
	 *
	 * @return string $compile_text
	 */
	public function compile($html) {
		$left_delimiter = '<{';
		$right_delimiter = '}>';
		$compile_text = '';
		// 模板中的注释
		$html = preg_replace("!{$left_delimiter}\*.*?\*{$right_delimiter}!su", '', $html);
		$split_res = preg_split('/'.$left_delimiter.'(\s*(?:\:|)[a-z\/][a-z\_0-9]*|)(.*?)'.$right_delimiter.'/isu', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
		if(is_array($split_res) && !empty($split_res)) {
			foreach ($split_res as $k => $v) {
				$k = $k % 3;
				if($k == 0) {
					$compile_text .= $v;
				} elseif ($k == 1) {
					$function = trim($v);
				} else {
					//取参并且处理@todo
					if($function) {
						$params = $this->parse(trim($v));
						$result = $this->parse_function($function, $params);
						$compile_text .= $result;
					} else {
						$followParam = $this->parse(trim($v));
						
						if(strpos($followParam, $this->_modifier_delimiter) !== false) {
							list($item_value, $item_modifier) = explode($this->_modifier_delimiter, $followParam);
							$item_params = '';
							if(strpos($item_modifier, $this->_modifier_param_delimiter) !== false) {
								list($item_modifier, $item_params) = explode($this->_modifier_param_delimiter, $item_modifier);
							}
						}
						$item_str = '<?php echo '.$followParam.';?>';
						$compile_text .= $item_str;
					}
				}
			}
		}
		// echo $compile_text;exit;
		return $compile_text;
	}

	/**
	 * the params to vars
	 *
	 * @param string $params
	 * 
	 * @return string $params
	 */
	public function parse($params) {
		if(!empty($params)) {
			$pares = preg_replace_callback('/\$([a-z0-9\_\.]+)/', array($this, 'replace_vars'), $params);
			return $pares;
		}
	}

	/**
	 * replace the var
	 *
	 * @param string $subject
	 */
	public function replace_vars($subject) {
		$result = '';
		if($subject[1]) {
			$exarr = explode('.', $subject[1]);
			$result = '$this->_vars[\''.implode('\'][\'',$exarr).'\']';
		}
		return $result;
	}

	/**
	 * return the the string which can exec
	 *
	 * @param string $function
	 * @param string $params
	 *
	 * @return string $result
	 */
	public function parse_function($function, $params) {
		switch ($function) {
			case 'if':
				return '<?php if('.$params.') { ?>';
				break;
			case 'foreach':
				$params = $this->parse_params($params);
				if(empty($params['from'])) {
					trigger_error('Missing \'from\' param for \'foreach\' in '.__FILE__.' on '.__LINE__, E_USER_ERROR);
				}
				if(empty($params['value'])) {
					trigger_error('Missing \'item\' param for \'foreach\' in '.__FILE__.' on '.__LINE__, E_USER_ERROR);
				}
				if(!empty($params['key'])) {
					$params['key'] = '$this->_vars[\'key\']  => '; 
				} else {
					$params['key'] = '$k => ';
				}
				return '<?php if('.$params['from'].') foreach((array)'.$params['from'].' as '.$params['key'].'$this->_vars[\''.$params['value'].'\']) {?>';
				break;
			case '/if':
				return '<?php } ?>';
				break;
			case '/foreach':
				return '<?php } ?>';
				break;
			default:
				break;
		}
	}

	/**
	 * params string to array
	 *
	 * @param string $params
	 *
	 * @return array $params
	 */
	public function parse_params($params) {
		preg_match_all('/([a-zA-Z_]+)=(?:\s*|)(.*?)\s/isu', $params.' ', $matches, PREG_SET_ORDER);
		$returns = array();
		if(is_array($matches) && !empty($matches)) {
			foreach($matches as $m) {
				$returns[$m[1]] = $m[2];
			}
		}
		return $returns;
	}
}