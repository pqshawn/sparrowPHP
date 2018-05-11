<?php
/**
 * Mapper URL
 *
 * @author:Yzwu <Ldos.net>
 * Date:2015/1/3 
 */

//extend_name ,such as ('.html', '.shtml', '.php', '.jsp', '.asp');
define('MAPPER_EXTEND_NAME', '.html');
//$_mapper_model = 'pathinfo';

//URL static mapper
$_mapper_url = array(
	//site app

	array(
		'pattern' => 'gallery',
		'extension' => MAPPER_EXTEND_NAME,
		'app' => 'site',
		'module' => 'posts',
		'action' => 'gallery',
		//@todo ,may I corresponding 'pattern'? 
		'config' => array(),
		'default' => array(),
		'pathinfo' => '',
		'parameter' => array(),
		),

        array(
		'pattern' => 'gajax',
		'extension' => MAPPER_EXTEND_NAME,
		'app' => 'site',
		'module' => 'posts',
		'action' => 'gajax',
		//@todo ,may I corresponding 'pattern'? 
		'config' => array(),
		'default' => array(),
		'pathinfo' => '',
		'parameter' => array(),
		),

	array(
		'pattern' => 'posts-{name}-{id}',
		'extension' => MAPPER_EXTEND_NAME,
		'app' => 'site',
		'module' => 'posts',
		'action' => 'index',
		//@todo ,may I corresponding 'pattern'? 
		'config' => array(
					'name' => '[a-zA-Z][a-zA-Z_0-9]+',
					'id' => '[0-9]+',
					),
		'default' => array(
					'name' => 'default',
					'id' => 1,
					),
		'pathinfo' => '',
		'parameter' => array(),
		),
	array(
		'pattern' => 'tool-{action}',
		'extension' => MAPPER_EXTEND_NAME,
		'app' => 'site',
		'module' => 'tool',
		'action' => '',
		'config' => array(
					'action' => '[a-zA-Z][a-zA-Z_0-9]+',
					),
		'default' => array(
					'action' => 'index',
					),
		'pathinfo' => '',
		'parameter' => array(),
		),
	array(
		'pattern' => 'search',
		'extension' => MAPPER_EXTEND_NAME,
		'app' => 'site',
		'module' => 'posts',
		'action' => 'search',
		//@todo ,may I corresponding 'pattern'? 
		'config' => array(),
		'default' => array(),
		'pathinfo' => '',
		'parameter' => array(),
		),
	//mobile app
	array(
		'pattern' => 'openapi-{type}',
		'extension' => MAPPER_EXTEND_NAME,
		'app' => 'mobile',
		'module' => 'openapi',
		'action' => 'index',
		'config' => array(
					'type' => '[a-zA-Z][a-zA-Z_0-9]+',
					),
		'default' => array(
					'type' => 'default',
					),
		'pathinfo' => '',
		'parameter' => array(),
		),
	
	//admin
	array(
		'pattern' => 'manage',
		'app' => 'admin',
		'module' => 'manage',
		'action' => 'index',
		//'config' => array(),
		// 'config' => array(
		// 			'type' => '[a-zA-Z][a-zA-Z_0-9]+',
		// 			),
		// 'default' => array(
		// 			'type' => 'default',
		// 			),
		),


);
