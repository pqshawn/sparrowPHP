<?php
/**
 * app:Site
 * module: Article
 * @copyright (c)Ldos.net All rights reserved.
 * @author: yuzw <distil@163.com>
 */
class ToolSiteCon extends ControllerLib {
	public $_weather_areaid = '101020600';
	public $_weather_type = 'forecast_v';
	public $_weather_appid = '';
	public $_weather_privatekey = WEATHER_KEY;
	public $_weather_key = '';
	public $_weather_uri = '';
	public $_weather_res = '';
	public $_weather_code = array(
		'00' => '晴',
		'01' => '多云',
		'02' => '阴',
		'03' => '阵雨',
		'04' => '雷阵雨',
		'05' => '雷阵雨伴有冰雹',
		'06' => '雨夹雪',
		'07' => '小雨',
		'08' => '中雨',
		'09' => '大雨',
		10 => '暴雨',
		11 => '大暴雨',
		12 => '特大暴雨',
		13 => '阵雪',
		14 => '小雪',
		15 => '中雪',
		16 => '大雪',
		17 => '暴雪',
		18 => '雾',
		19 => '冻雨',
		20 => '沙尘暴',
		21 => '小到中雨',
		22 => '中到大雨',
		23 => '大到暴雨',
		24 => '暴雨到大暴雨',
		25 => '大暴雨到特大暴雨',
		26 => '小到中雪',
		27 => '中到大雪',
		28 => '大到暴雪',
		29 => '浮尘',
		30 => '扬沙',
		31 => '强沙尘暴',
		53 => '霾',
		99 => '无'
		);
    private $_geyan = array('', '努力，奋斗的意义是能看到现实', '虚拟现实可以引爆新游戏', '物联必须大数据伴奏', '一个伟大的时代悄悄来临', '', '数据是流动的音符', '', '立体全息的影像暂搁浅在液晶里');
	private $_rss_url = 'http://news.163.com/special/00011K6L/rss_newstop.xml';

	public function __construct() {
		parent::__construct();
        $time = time();
		$this->_geyan[0] = date('Y-m-d H:i:s', $time);
        
	}

	public function __destruct() {}

	public function weather_api() {
		try{
			$date = date('YmdHi', time());
			$public_key = 'http://open.weather.com.cn/data/?areaid='.$this->_weather_areaid.'&type='.$this->_weather_type.'&date='.$date.'&appid='.WEATHER_APPID;
			$this->_weather_key = base64_encode(hash_hmac('sha1', $public_key, $this->_weather_privatekey, TRUE));
			$appid_six = substr(WEATHER_APPID, 0, 6);
			$this->_weather_uri = 'http://open.weather.com.cn/data/?areaid='.$this->_weather_areaid.'&type='.$this->_weather_type.'&date='.$date.'&appid='.$appid_six.'&key='.urlencode($this->_weather_key);
			$this->_weather_res = file_get_contents($this->_weather_uri);
		} catch(Exception $e) {
			trigger_error('get the weather api failure!', E_USER_ERROR);
		}
	}
	
	public function index($get_icon_str = false) {
		$this->weather_api();
		if($this->_weather_res) {
			$day = array('今天', '明天', '后天');
			$weather = array();
			$decode_res = json_decode($this->_weather_res, true);

			$now = date('H', time());
			$today_icon_flag = array('icon' => '/public/images/icon/day/undefined.png', 'message' => '');
			if($now >= 0 && $now < 8) { // * 今天缓存结束，取明天的
				$code = $decode_res['f']['f1'][1]['fa'];
				if(array_key_exists($code, $this->_weather_code)) {
					$today_icon_flag['icon'] = str_replace('undefined', $code, $today_icon_flag['icon']);
					$today_icon_flag['message'] = $this->_weather_code[$code];
				}
			} else if($now >= 8 && $now < 18){
				$code = $decode_res['f']['f1'][0]['fa'];
				if(array_key_exists($code, $this->_weather_code)) {
					$today_icon_flag['icon'] = str_replace('undefined', $code, $today_icon_flag['icon']);
					$today_icon_flag['message'] = $this->_weather_code[$code];
				}
			} else {
				$code = $decode_res['f']['f1'][0]['fb'];
				if(array_key_exists($code, $this->_weather_code)) {
					$today_icon_flag['icon'] = str_replace('day/undefined', 'night/'.$code, $today_icon_flag['icon']);
					$today_icon_flag['message'] = $this->_weather_code[$code];
				}
			}
			if(!empty($day))
			foreach ($day as $key => $value) {
				$weather[$value] = ' 日:'.$this->_weather_code[$decode_res['f']['f1'][$key]['fa']]
								. ' 夜:'.$this->_weather_code[$decode_res['f']['f1'][$key]['fb']]
								. '　'.$decode_res['f']['f1'][$key]['fc'].'℃/'.$decode_res['f']['f1'][$key]['fd'].'℃';

			}
            if($get_icon_str) {
            	return $today_icon_flag;
            }
			$this->_pagedata['weather_icon'] = $today_icon_flag;
			$this->_pagedata['weather'] = $weather;
		}
		$request = $_POST;
		$data = array();
		if(is_array($request) && !empty($request)) {
			foreach ($request as $key => $value) {
				if(empty($value)) continue;
				switch ($key) {
					case 'encrypt_b':
						$data['encrypt_b'] = $value;
						$data['encrypt_s'] = md5($value);
						break;
					case 'timestamp_b':
						$data['timestamp_b'] = $value;
						$data['timestamp_s'] = strtotime($value);
						break;
					case 'formatime_b':
						$data['formatime_b'] = $value;
						$data['formatime_s'] = date('Y-m-d H:i:s', $value);
						break;
					default:
						break;
				}
			}
		}
		$this->_pagedata['data'] = $data;
		$this->display('site/tool/index.tpl', false, false, false);
	}

	public function calName() {
		$name_center_foreach = 100;
		$name_last_foreach = 100;

		$family_name_len = 7;
		$name_word_good_len_arr = array(); //这是一个数组,存储二维合适名称 array(0=>array(1,2))

		$good_nums = array(1, 3, 5, 7, 8, 11, 13, 15, 16, 18, 21,
			23, 24, 25, 31, 32, 33, 35, 37, 39, 41, 45, 47, 48,
			52, 57, 61, 63, 65, 67, 68, 81);

		$tian_ge = $family_name_len + 1; // 天格
		$ren_ge = ''; // 人格
		$di_ge = ''; // 地格
		$wai_ge = ''; // 外格
		$zong_ge = ''; // 总格

		for ($i = 1; $i <= $name_center_foreach; $i++) {
			$current_center_name_len = $i;
			// 天格不用计算,从人格开始
			$ren_ge = $family_name_len + $current_center_name_len;
			for ($j = 1; $j <= $name_last_foreach; $j++) {
				$good = 0;
				$current_last_name_len = $j;
				$di_ge = $current_center_name_len + $current_last_name_len;
				$wai_ge = 1 + $current_last_name_len;
				$zong_ge = $family_name_len + $current_center_name_len + $current_last_name_len;
				// 三才解析
				$sancai_jiexi = $tian_ge + $ren_ge + $di_ge;
				// 人地
				$rendi_jiexi = $ren_ge + $di_ge;
				// 人天
				$rentian_jiexi = $ren_ge + $tian_ge;
				// 人外
				$renwai_jiexi = $ren_ge + $wai_ge;

				$ren_ge_res = in_array($ren_ge, $good_nums);
				$di_ge_res = in_array($di_ge, $good_nums);
				$wai_ge_res = in_array($wai_ge, $good_nums);
				$zong_ge_res = in_array($zong_ge, $good_nums);
				$sancai_res = in_array($sancai_jiexi, $good_nums);
				$rendi_res = in_array($rendi_jiexi, $good_nums);
				$rentian_res = in_array($rentian_jiexi, $good_nums);
				$renwai_res = in_array($renwai_jiexi, $good_nums);
				
				if($ren_ge_res) $good += 1;
				if($di_ge_res) $good += 1;
				if($wai_ge_res) $good += 1;
				if($zong_ge_res) $good += 1;
				if($sancai_res) $good += 1;
				if($rendi_res) $good += 1;
				if($rentian_res) $good += 1;
				if($renwai_res) $good += 1;

				if($good >= 7) {
					$name_word_good_len_arr[] = array($current_center_name_len, $current_last_name_len);
				}
			}		
		}
		print_r($name_word_good_len_arr);exit;
	}

	public function rss_news() {
		$buff = file_get_contents($this->_rss_url);

		// $parser = xml_parser_create();
		// xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1); 
		// xml_parse_into_struct($parser,$buff,$values,$idx); 
		// xml_parser_free($parser); 
		print_R($buff);exit;
		// echo($simple_rss);exit;
		
	}

	public function image() {
		$prefix = rand(1, 2);
		$order = rand(1, 4);
		$geyan = $this->_geyan[rand(0, 8)];
		$name = $prefix.'-'.$order;
		$image_url = "/public/images/advertise/{$name}.jpg";

		$image_path = ROOT_DIR.$image_url;
		$image = imagecreatefromstring(file_get_contents($image_path));
		$color= imagecolorallocate($image, 200, 200, 200);
		$font = ROOT_DIR.'/public/css/huawenxingkai.ttf';
		imagettftext($image,22,0,10,50,$color,$font,$geyan);
		header('Content-Type:image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
	
	public function show_weather() {
		$this->weather_api();
		$result = array('code' => 0);
		$background_url = '/public/images/main_bg/';
		$weather = $this->index(true);
		if(isset($weather['message']) && in_array($weather['message'], $this->_weather_code)) {
			$result['code'] = 1;
			$result['tool_icon'] = $weather['icon'];
			if($weather['message'] == '多云') {
				$background_url .= 'cloudy.jpg';
			} elseif($weather['message'] == '阴') {
				$background_url .= 'overcast.jpg';
			} elseif(in_array($weather['message'], array('小雨', '中雨', '大雨'))) {
				$background_url .= 'rainy.jpg';
			} elseif(in_array($weather['message'], array('阵雨', '暴雨'))) {
				$background_url .= 'rainstorm.jpg';
			} else {
				$background_url .= 'sunny.jpg';
			}
			$result['background_url'] = $background_url;
		}
		echo json_encode($result);
	}
        public function download() {
		$request = $this->_request->_parameter;
		$key = preg_replace('/[^\w]+/', '', $request['key']);

		$calculate_y = date('Y');
		$calculate_m = date('m');
		$calculate_d = date('d');
		$calculate_h = date('H');
		$prefix = 'shawn';
		$suffix = 'uaregreat!';
		$calculate = md5($prefix.md5($calculate_h.$calculate_y.$calculate_m.$calculate_d).$suffix);

		if($key && $calculate == $key) {
			header('Content-Description: File Transfer');
	 		$thefile = PUBLIC_DIR.'/upload/files/a0/b9/a2/fsadcxxczewqqereqqe.docx';
	 		$filename = 'resume'.time().'.doc';

			$fileinfo = pathinfo($filename);
			header('Content-type: application/x-'.$fileinfo['extension']);
			header('Content-Disposition: attachment; filename='.$fileinfo['basename']);
			header('Content-Length: '.filesize($filename));
			readfile($thefile);
		} else {
			if($key) $tip = '<p style="color:pink;padding:30px 0px;">请提供正确密钥,如不知道可以联系zongwuzong@126.com索取</p>'; 
			$output = <<<OUTPUT
			<!DOCTYPE html>
			<html>
				<head>
					<title>下载简历</title>
                                        <meta charset="utf-8">
					<style>* {margin:0px;padding:0px;}</style>
				</head>
				<body style="margin:0 auto;">
					<div style="margin:50px auto;width:500px;height:300px;background:#e3effb;text-align:center;padding:50px 50px;">
					<form method="get">
					<h1>动态密钥:</h1>
					<div><input type="text" value="" name="key"><input type="submit" value="提交"></div>
					</form>
					$tip
					</div>
				</body>
			</html>
OUTPUT;
			echo $output;
		}
		
	}




        public function pd($get_icon_str = false) {
		$data = array(
                array('title' =>'格雷项目活动图','src' => 'geleiActivity.png'),
                array('title' =>'格雷基础技术架构图','src' => 'geleiBase.jpg'),
                array('title' =>'iOSMDM管控','src' => 'iosMDM.jpg'),
                array('title' =>'格雷服务MQ','src' => 'SD_MQ.jpg'),
                array('title' =>'APP后台通讯','src' => 'clientConnect.png'),
                array('title' =>'高可用分布式数据层','src' => 'HADistribute.jpg'),
                array('title' =>'格雷部件图','src' => 'geleiComponent.png'),
                array('title' =>'家长孩子帐号体系','src' => 'childParent.png'),
                array('title' =>'格雷软件模块','src' => 'APP.png'),
                array('title' =>'设备建立连接图','src' => 'DeviceConnect.png'),
                array('title' =>'设备发送管控指令图','src' => 'sendControl.png'),
                array('title' =>'格雷网址模块','src' => 'urlModule.png'),
                array('title' =>'商品订单业务ER图','src' => 'order.jpg'),
                array('title' =>'促销ER图','src' => 'promotion.jpg')
                );
	
		$this->_pagedata['data'] = $data;
		$this->display('site/tool/pd.tpl', false, false, false);
	}


}
