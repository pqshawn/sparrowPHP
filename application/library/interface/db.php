<?php
/**
 * db driver interface
 * 
 * @copyright (c)Ldos.net All rights reserved.
 * @author:Yzwu <Ldos.net>
 */

interface DbInterfaceLib {
	public function _connect($db_config, $new_link);
	public function create($sql);
	public function update();
	public function retrieve();
	public function delete();
	public function exec($sql, $db_link, $new_link);
	public function count();
	public function begin();
	public function commit();
	public function rollback();
	public function quote($string);
}