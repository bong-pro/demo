<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CP_Input extends CI_Input
{

	protected function _fetch_from_array(&$array, $index=null, $xss_clean=null, $default_value=null)
	{
		is_bool($xss_clean) OR $xss_clean = $this->_enable_xss;

		// If $index is NULL, it means that the whole $array is requested
		isset($index) OR $index = array_keys($array);

		// allow fetching multiple keys at once
		if ( is_array($index) ) {
			$output = array();
			foreach ( $index as $key ) {
				$output[$key] = $this->_fetch_from_array($array, $key, $xss_clean);
			}
			return $output;
		}

		if ( isset($array[$index]) ) {
			$value = $array[$index];
		} elseif (($count = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $index, $matches)) > 1) { // Does the index contain array notation
			$value = $array;
			for ( $i = 0; $i < $count; $i++ )
			{
				$key = trim($matches[0][$i], '[]');
				if ( $key === '' ) break; // Empty notation will return the value as array

				if ( isset($value[$key]) ) {
					$value = $value[$key];
				} else {
					return $default_value;
				}
			}
		} else {
			return $default_value;
		}

		return ($xss_clean === true) ? $this->security->xss_clean($value) : $value;
	}

	public function get($index=null, $xss_clean=null, $default_value=null)
	{
		return $this->_fetch_from_array($_GET, $index, $xss_clean, $default_value);
	}

	public function post($index=null, $xss_clean=null, $default_value=null)
	{
		return $this->_fetch_from_array($_POST, $index, $xss_clean, $default_value);
	}

	public function post_get($index, $xss_clean=null, $default_value=null)
	{
		return isset($_POST[$index]) ? $this->post($index, $xss_clean, $default_value) : $this->get($index, $xss_clean, $default_value);
	}

	public function get_post($index, $xss_clean=null, $default_value=null)
	{
		return isset($_GET[$index]) ? $this->get($index, $xss_clean, $default_value) : $this->post($index, $xss_clean, $default_value);
	}

	public function cookie($index=null, $xss_clean=null, $default_value=null)
	{
		return $this->_fetch_from_array($_COOKIE, $index, $xss_clean, $default_value);
	}

	public function server($index, $xss_clean=null, $default_value=null)
	{
		return $this->_fetch_from_array($_SERVER, $index, $xss_clean, $default_value);
	}

	public function ip_address()
	{
		if ( $this->ip_address !== false ) {
			return $this->ip_address;
		}

		if ( !empty($this->server('HTTP_CLIENT_IP')) && $this->valid_ip($this->server('HTTP_CLIENT_IP')) ) {
			$this->ip_address = $this->server('HTTP_CLIENT_IF');
		} elseif ( ! empty($this->server('HTTP_X_FORWARDED_FOR')) && $this->valid_ip($this->server('HTTP_X_FORWARDED_FOR')) ) {
			$this->ip_address = $this->server('HTTP_X_FORWARDED_FOR');
		} elseif ( ! empty($this->server('HTTP_X_FORWARDED')) && $this->valid_ip($this->server('HTTP_X_FORWARDED')) ) {
			$this->ip_address = $this->server('HTTP_X_FORWARDED');
		} elseif ( ! empty($this->server('HTTP_FORWARDED_FOR')) && $this->valid_ip($this->server('HTTP_FORWARDED_FOR')) ) {
			$this->ip_address = $this->server('HTTP_FORWARDED_FOR');
		} elseif ( ! empty($this->server('HTTP_FORWARDED')) && $this->valid_ip($this->server('HTTP_FORWARDED')) ) {
			$this->ip_address = $this->server('HTTP_FORWARDED');
		} else {
			parent::ip_address();
		}

		return $this->ip_address();
	}

}
