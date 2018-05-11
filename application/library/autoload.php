<?php
/**
 * autoload,when spl_autoload_register not works
 * 
 * @author Yzwu <Ldos.net>
 * Date:2015/1/3
 */

function __autoload($class_name) 
{
	$nspace = $class_name;
		$nspace_path = str_replace('\\', '/', $nspace);
		$nspace_arr = explode('/', $nspace_path);
		if(count($nspace_arr) > 1) {
			$filepath = ROOT_DIR.'/'.$nspace_path.'.php';
			if(is_file($filepath)) {
				require_once($filepath);
				return true;
			} else {
				$class_name = array_pop($nspace_arr);
			}
		}//if start namespace,your can must use the rule of namespace

    	$cname_split = preg_split("/(?=[A-Z])/", $class_name, 0, PREG_SPLIT_NO_EMPTY);
    	if(is_array($cname_split)) {
    		//stack
    		$array_tolower = function($v){return strtolower($v);};
    		$cname_arr = array_reverse(array_map($array_tolower, $cname_split));
    		$cname_ower = array_shift($cname_arr);
    		$ower_flag = '';
    		switch ($cname_ower) {
    			case 'lib':
    				$ower_flag = 'library';
    				break;
    			case 'con':
    				$ower_flag = 'controllers';
    				break;
    			case 'mod':
    				$ower_flag = 'models';
    				break;
    			default:
    				break;
    		}
    		$class_filep = ROOT_DIR.'/'.$ower_flag.'/'.implode('/', $cname_arr).'.php';
    		if(is_file($class_filep)) {
    			require_once($class_filep);
    		} else {
    			trigger_error('the file path is not exists!', E_USER_ERROR);
    		}
    	}
}