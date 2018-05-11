<?php
/**
 * weather
 * SmartWeatherAPI from weather.com.cn 
 *
 * @copyright (c)Ldos.net All rights reserved.
 * @author: Yzwu <distil@163.com>
 */

namespace library;

class WeatherLib {
 	
 	private $_private_key = '';
 	private $_appid = '';
 	private $_appid_six = '';
 	private $_type = array('forecast_f', 'forecast_v', 'index_f', 'index_v');
 	public $_public_key = 'http://open.weather.com.cn/data/?';

 	public function __construct() {
 		$this->_private_key = WEATHER_KEY;
 		$this->_appid = WEATHER_APPID;
 		$this->_appid_six = substr($this->_appid,0,6);
 	}

 	public function __destruct() {

 	}

 	public function main($areaid = '', $type = 1) {
		if(empty($areaid)) return '';
		$result = array();
		$type = $this->_type[$type];
		$date = date('YmdHi');
		$appid_six = $this->_appid_six;
		$public_key = $this->_public_key.'areaid='.$areaid.'&type='.$type.'&date='.$date.'&appid='.$this->_appid;
		
		$key = base64_encode(hash_hmac('sha1',$public_key,$this->_private_key,TRUE));
		$url = $this->_public_key.'areaid='.$areaid.'&type='.$type.'&date='.$date.'&appid='.$appid_six.'&key='.urlencode($key);

		$string=file_get_contents($url);
 		if(!$string) {
 			$result = false;
 		} else {
 			$result = json_decode($string, true);
 		}
 		return $result;
 	}

 	
}