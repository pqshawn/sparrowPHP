<?php
/**
 * app:Site
 * model: Article
 * @copyright (c)Ldos.net All rights reserved.
 * @author: Yzwu <distil@163.com>
 */

class PostsSiteMod extends ModelLib {
	public function __construct() {
		parent::__construct();
	}

	public function __destruct() {

	}

	public function get_data($cols, $where = '', $order = '', $offset = 0, $limit = -1) {
		$data = $this->retrieve($cols, $where, $order, $offset, $limit);
		return $data;
	}

}