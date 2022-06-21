<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Version extends CP_Controller
{

	public function index()
	{
		$this->document->config('ID', 10901090 );
		$this->document->config( 'page_title', 'Site Version' );

		$this->document->view('preferences/settings/version', array(
			'version_info'	=> array(),
		));
	}

}
