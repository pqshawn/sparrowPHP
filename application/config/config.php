<?php
/**
 * Global configure
 *
 * @author:Yzwu <Ldos.net>
 * Date:2015/1/3 
 */

if(!defined('ROOT_DIR')){
    define('ROOT_DIR',realpath(dirname(dirname(__FILE__))));
}
define('LOG_FILE_PATH', ROOT_DIR.'/../mylogs/{date}.log');

//'normal', 'pathinfo', #todo rewrite
define('URL_MODEL', 'pathinfo');

define('PUBLIC_DIR', ROOT_DIR.'/public');
define('VIEWS', ROOT_DIR.'/views');
//css-js-path
define('CSS_DIR', PUBLIC_DIR.'/css');
define('JS_DIR', PUBLIC_DIR.'/javascript');
define('IMG_DIR', PUBLIC_DIR.'/images');

//db driver (type: mysql,mysqli, @todo pdo, oracle)
define('DB_DRIVER', 'mysqli');
define('DB_PREFIX', 'dos_');
//long or short connect
define('DB_PERSISTENT_CONNECT', 0);
define('DB_FILES_DIR', ROOT_DIR.'/dbcheme');
//DB base config
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '123456');
define('DB_NAME', 'post');
define('DB_CHARSET', 'utf8');

// weather
define('WEATHER_KEY', '105e7b_SmartWeatherAPI_513ce6b');
define('WEATHER_APPID', '77ec71e85c1509d8');
