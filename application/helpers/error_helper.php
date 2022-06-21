<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function alert($message='', $location='')
{
	$CI =& get_instance();

	echo '<meta http-equiv="content-type" content="text/html; charset=' . $CI->config->item('charset') . '">';
	echo '<script type="text/javascript">alert("' . addslashes($message) . '");';
	if ( !empty($location) ) echo 'location.replace("' . $location . '");';
	echo '</script>';
	exit;
}

function alert_back($message='')
{
	$CI =& get_instance();

	echo '<meta http-equiv="content-type" content="text/html; charset=' . $CI->config->item('charset') . '">';
	echo '<script type="text/javascript">';
	echo 'alert("' . addslashes($message) . '");';
	echo 'history.go(-1);';
	echo '</script>';
	exit;
}

function alert_close($message='')
{
	$CI =& get_instance();

	echo '<meta http-equiv="content-type" content="text/html; charset=' . $CI->config->item('charset') . '">';
	echo '<script type="text/javascript">';
	echo 'alert("' . addslashes($message) . '");';
	echo 'window.close();';
	echo '</script>';
	exit;
}

function dismissible($color='',$message='')
{
	echo '<div class="alert alert-styled-left alert-dismissible ';
	if ( !empty($color) ) echo 'alert-' . $color;
	echo '" style="z-index: 9999; position: absolute; top: 5%; left: 50%; transform: translate(-50%, 0%);">';
	echo '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
	echo addslashes($message);
	echo '</div>';
}
