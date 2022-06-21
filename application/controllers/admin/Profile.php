<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends CP_Controller
{

	public function index()
	{
		$this->document->config( 'ID', 102010 );
		$this->document->config( 'page_title', 'Profile' );

		$this->document->view( 'admin/profile' );
	}

}
