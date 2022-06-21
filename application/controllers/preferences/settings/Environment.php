<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Environment extends CP_Controller
{

	public function index()
	{
		$this->document->config('ID', 10901080);
		$this->document->config('page_title', 'Environment');

		ob_start();
		phpinfo();
		$phpinfo_html = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', ob_get_clean());

		$this->document->view('preferences/settings/environment', array(
			'phpinfo_html'  => $phpinfo_html,
		));
	}

}
