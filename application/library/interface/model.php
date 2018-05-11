<?php
/**
 * interface controllers
 * 
 * @copyright (c)Ldos.net All rights reserved.
 * @author: Yzwu <distil@163.com>
 */

interface ModelInterfaceLib {
	public function create($sql);
	public function update($sql);
	public function retrieve($sql);
	public function delete($sql);
}