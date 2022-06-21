<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_hook
{

	public function init()
	{
		$_CI =& get_instance();

		if ( in_array($_CI->uri->segment(1), array('api', 'auth')) ) return;

		/**
		 * 로그인 확인
		 */
		if ( $_CI->user->is_logged_in() !== true ) {
			//redirect(add_query_arg('redirect_to', urlencode(current_url()), site_url('auth')));
			redirect(site_url('auth'));
			exit;
		}
	}

}
