<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CP_Controller
{

	public function index()
	{
		// cpu usage
		$load = sys_getloadavg();
		$data['cpu_usage_percent'] =  $load[0] * 100;

		// memory usage
		$free			= shell_exec('free');
		$free			= (string) trim($free);
		$free_arr		= explode("\n", $free);
		$mem			= explode(" ", $free_arr[1]);
		$mem			= array_filter($mem);
		$mem			= array_merge($mem);
		$memory_usage	= $mem[2] / $mem[1] * 100;

		// storage usage
		$data['memory_total']			= $mem[1];
		$data['memory_used']			= $mem[2];
		$data['memory_usage_percent']	= $memory_usage;

		$ds								= disk_total_space("/");
		$df								= disk_free_space("/");
		$data['disk_free']				= $df;
		$data['disk_use']				= $ds - $df;
		$data['disk_entire']			= $ds;
		$data['disk_usage_percent']		= $df / $ds * 100;

		$this->document->config( 'page_title', 'Dashboard' );
		$this->document->view('dashboard', $data);
	}

	public function get_server_info()
	{
		// cpu usage
		$load = sys_getloadavg();
		$data['cpu_usage_percent'] =  $load[0] * 100;

		// memory usage
		$free			= shell_exec('free');
		$free			= (string) trim($free);
		$free_arr		= explode("\n", $free);
		$mem			= explode(" ", $free_arr[1]);
		$mem			= array_filter($mem);
		$mem			= array_merge($mem);
		$memory_usage	= $mem[2] / $mem[1] * 100;

		// storage usage
		$data['memory_total']			= $mem[1];
		$data['memory_used']			= $mem[2];
		$data['memory_usage_percent']	= $memory_usage;

		$ds								= disk_total_space("/");
		$df								= disk_free_space("/");
		$data['disk_free']				= $df;
		$data['disk_use']				= $ds - $df;
		$data['disk_entire']			= $ds;
		$data['disk_usage_percent']		= $df / $ds * 100;

		cp_api_json($data);
	}

}
