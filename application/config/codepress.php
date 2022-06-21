<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['cp__use_cache']			= TRUE;
$config['cp__cache_lifetime']		= 60 * 60 * 24;
$config['cp__db_secret_key']		= 'codepress';
$config['cp__template_dir']			= 'templates';
$config['cp__view_dir']				= 'pages';
$config['cp__use_sociallogin']		= FALSE;
$config['cp__use_registration']		= FALSE;
$config['cp__login_redirect_to']	= '/';
