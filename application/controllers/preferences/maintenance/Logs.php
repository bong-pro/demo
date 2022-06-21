<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CP_Controller
{

	public function index()
	{
		$this->load->model('Model_logs');
		$logs = $this->Model_logs->logs();

		$log_html = '****************************** Log ******************************<br>';
		foreach ( $logs['list'] as $item ) {
			$log_html .= '<br>---------- ' . $item['created_at'] . ' ----------';
			$log_html .= '<br>IP : ' . $item['user_ip'];
			$log_html .= '<br>USER ID : ' . $item['user_id'];
			$log_html .= '<br>CONTENTS : ' . $item['contents'];
			$log_html .= '<br>-----------------------------------------<br>';
		}

		$this->document->config('ID', 10903090);
		$this->document->config('page_title', 'LOG');
		$this->document->view('preferences/maintenance/logs', array(
			'logs' => $log_html,
		));
	}

	public function data_download()
	{
		$this->load->helper('download');

		$this->load->model('Model_logs');
		$logs = $this->Model_logs->logs();

		$data = print_r($logs['list'], true);
		$name = 'log_' . date('Ymdhis') . '.txt';

		force_download($name, $data);
	}

	public function data_delete()
	{
		$this->load->model('Model_logs');
		$this->Model_logs->empty_table();

		$data['message'] = 'Delete completed.';

		cp_api_json( $data );
	}

}
