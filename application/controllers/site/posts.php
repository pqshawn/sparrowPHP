<?php
/**
 * app:Site
 * module: Article
 * @copyright (c)Ldos.net All rights reserved.
 * @author: Cage <distil@163.com>
 */

class PostsSiteCon extends ControllerLib {
	public function __construct() {
		parent::__construct();
	}

	public function __destruct() {}

	public function index() {
		$request = $this->_request->_parameter;
		$cols = '*';
		$where = array(
					'post_author' => 1,
					'post_id' => $request['id'],
					);
		$order = 'post_udate,post_id DESC';
		$offset = 0;
		$limit = 1;
		$data = $this->_model->get_data($cols, $where, $order, $offset, $limit);
		
		if($data) {
			$this->_pagedata['data'] = $data[0];	
		} else {
			$this->_pagedata['data'] = '';
		}
		$this->display('site/article/single.tpl', false, false, false);
	}

	public function gallery() {
		$paras = $this->_request->_parameter;
		$where = array();
		if(is_array($paras) && !empty($paras)) {
			foreach ($paras as $key => $value) {
				switch ($key) {
					case 's':
						$trim_value = trim($value);
						$where['post_title|like'] = $trim_value;
						$where['post_excerpt|like|or'] = $trim_value;
						$this->_pagedata['keywords'] = htmlspecialchars($paras['s']);
						break;
					
					default:
						# code...
						break;
				}
			}
		}
		$order = 'post_udate DESC, post_id DESC';
		$offset = 0;
		$limit = $_COOKIE['count'] > 15? intval($_COOKIE['count']) : 15;
		$data = $this->_model->get_data('*', $where, $order, $offset, $limit);
		$this->_pagedata['data'] = $data;
                $this->_pagedata['count'] = count($data);
		$this->display('site/article/gallery.tpl', false, false, false);
	}

	// @todo launch sphinx cooseek
	public function search() {
		$this->gallery();
	}

	public function add() {
		$mo = $this->model();
		
		$data = array(
					'post_author' => 1,
					'post_cdate' => date('Y-m-d H:i:s'),
					'post_title' => '',
					'post_content' => ''
					);
		$mo->create($data);  
	}

        public function gajax() {
	$paras = $this->_request->_parameter;
	$where = array();
	if(is_array($paras) && !empty($paras)) {
		foreach ($paras as $key => $value) {
			switch ($key) {
				case 's':
					$trim_value = trim($value);
					$where['post_title|like'] = $trim_value;
					$where['post_excerpt|like|or'] = $trim_value;
					$this->_pagedata['keywords'] = htmlspecialchars($paras['s']);
					break;
				case 'offset':
					$offset = intval($paras['offset']);
				case 'limit':
					$limit = intval($paras['limit']);
				case 'count':
					$count = intval($paras['count']);
				default:
					# code...
					break;
			}
		}
	}
	$order = 'post_udate DESC, post_id DESC';
	$offset? '' : $offset = $count;
	$limit? '' : $limit = 15;

	$data = $this->_model->get_data('*', $where, $order, $offset, $limit);
	$return = array('status' => 204, 'content' => '');
	if($data) {
		$this->_pagedata['data'] = $data;
		$this->display('site/article/gajax.tpl', true, false, false);
                $return['content'] = $this->_response->get_body(); 
		$return['status'] = 200; 
                $return['count'] = count($data) + $count;
	}
	echo json_encode($return);
        exit;
        }
}