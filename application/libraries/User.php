<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User
{

	protected $_CI;

	protected $data;

	public function __construct()
	{
		$this->_CI =& get_instance();
		$this->_CI->load->library('session');
		$this->_CI->load->model('Model_users');
	}

	protected function _get_data()
	{
		$data = false;
		if ( $this->is_logged_in() ) {
			$data = $this->_CI->Model_users->_item($this->get_user_id());
			$metas = $this->_get_meta_data(element('user_id', $data));
			if ( is_array($metas) ) $data = array_merge($data, $metas);
		}
		$this->data = $data;

		return $this->data;
	}

	protected function _get_meta_data($user_id)
	{
		return array();
	}

	public function is_logged_in()
	{
		return $this->get_user_id() ? true : false;
	}

	public function get_user_id()
	{
		if ( $this->_CI->session->userdata('user_id') ) return $this->_CI->session->userdata('user_id');
		return false;
	}

	public function get_avatar($args=array())
	{
		$defaults = array(
			'width'		=> 38,
			'height'	=> 38,
			'default'	=> base_url('assets/images/placeholders/user.svg'),
			'alt'		=> '',
			'class'		=> '',
		);
		$args = cp_parse_args($args, $defaults);

		$avatar_image = $this->item('image');
		if ( $avatar_image === false ) $avatar_image = $args['default'];

		return sprintf(
			'<img src="%s" class="%s" width="%s" border="0" alt="%s" />',
			$avatar_image,
			html_escape($args['class']),
			html_escape($args['width']),
			html_escape($args['alt'])
		);
	}

	public function item($key='', $default=false)
	{
		if ( empty($this->data) ) $this->_get_data();
		if ( empty($key) || empty($this->data) ) return $default;

		return isset($this->data[$key]) ? $this->data[$key] : $default;
	}

}
