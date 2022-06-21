<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_server_cpu_usage()
{
	$load = sys_getloadavg();
	return $load[0];
}
