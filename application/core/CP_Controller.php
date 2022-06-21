<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CP_Controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		/**
		 * set load
		 */
		$this->config->load('codepress');
		$this->lang->load('codepress', config_item('language'));

		$this->load->helper(array(
			'common',
			'array',
			'url',
			'form',
			'error',
		));

		$this->load->library(array(
			'document',
			'user',
		));

		/**
		 * set cache
		 */
		if ( cp_config_item('use_cache') ) {
			$this->load->driver('cache', array( 
				'adapter'	=> 'apc',
				'backup'	=> 'file',
				//'key_prefix'   => 'cp_',
			));
		}

		/**
		 * set font=ko
		 */
		$this->document->add_css('font-notosanskr', base_url('assets/css/notosanskr.css'));

		/**
		 * auto logout
		 */
		$this->document->add_js('session-timeout', base_url('template/global_assets/js/plugins/extensions/session_timeout.min.js'));

		/**
		 * set parameter
		 */
		$this->document->add_js_params('base_url', untrailingslashit(base_url()));
		$this->document->add_js_params('text__no_records', $this->lang->line('text_cp_no_records'));
		$this->document->add_js_params('error__system', $this->lang->line('text_cp_system_error'));
	}

}
