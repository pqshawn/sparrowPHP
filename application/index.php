<?php
/**
 * @author Yzwu <Ldos.net>
 * @version 1.0
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

define('ROOT_DIR', realpath(dirname(__FILE__)));
require(ROOT_DIR.'/library/blood.php');

blood::dispatch();
