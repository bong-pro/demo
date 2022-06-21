<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('trailingslashit') ) {
	function trailingslashit($string) {
		return untrailingslashit($string) . '/';
	}
}

if ( !function_exists('untrailingslashit') ) {
	function untrailingslashit($string) {
		return rtrim($string, '/\\');
	}
}

if ( !function_exists('api_url') ) {
	function api_url($path='') {
		$r = trailingslashit(cp_config_item('api_url'));
		if ( ! empty($path) ) {
			$r .= ltrim($path, '/\\');
		}
		return $r;
	}
}

if ( !function_exists('current_url') ) {
	function current_url() {
		$CI =& get_instance();
		$url = $CI->config->site_url($CI->uri->uri_string());
		$return = ($CI->input->server('QUERY_STRING')) ? $url . '?' . $CI->input->server('QUERY_STRING') : $url;
		return $return;
	}
}

if ( !function_exists('_http_build_query') ) {
	function _http_build_query($data, $prefix = null, $sep = null, $key = '', $urlencode = true) {
		$ret = array();

		foreach ( (array) $data as $k => $v ) {
			if ( $urlencode ) $k = urlencode($k);
			if ( is_int($k) && $prefix != null ) $k = $prefix . $k;
			if ( !empty($key) ) $k = $key . '%5B' . $k . '%5D';

			if ( $v === null ) continue;
			elseif ( $v === false ) $v = '0';

			if ( is_array($v) || is_object($v) ) array_push( $ret, _http_build_query($v, '', $sep, $k, $urlencode));
			elseif ( $urlencode ) array_push($ret, $k . '=' . urlencode($v));
			else array_push($ret, $k . '=' . $v);
		}

		if ( $sep === null ) $sep = ini_get('arg_separator.output');

		return implode($sep, $ret);
	}
}

if ( !function_exists('add_query_arg') ) {
	function add_query_arg() {
		$args = func_get_args();
		if ( is_array($args[0]) ) {
			count($args) < 2 || false === $args[1] ? $uri = $_SERVER['REQUEST_URI'] : $uri = $args[1];
		} else {
			count($args) < 3 || false === $args[2] ? $uri = $_SERVER['REQUEST_URI'] : $uri = $args[2];
		}

		$frag = strstr($uri, '#') ? $uri = substr($uri, 0, -strlen($frag)) : $frag = '';

		if ( stripos($uri, 'http://') === 0 ) {
			$protocol = 'http://';
			$uri = substr( $uri, 7 );
		} elseif ( stripos($uri, 'https://') === 0 ) {
			$protocol = 'https://';
			$uri = substr( $uri, 8 );
		} else {
			$protocol = '';
		}

		if ( strpos($uri, '?') !== false ) {
			list($base, $query) = explode('?', $uri, 2);
			$base;
		} elseif ( $protocol || strpos($uri, '=') === false ) {
			$base = $uri . '?';
			$query = '';
		} else {
			$base = '';
			$query = $uri;
		}

		parse_str($query, $qs);
		$qs = cp_map_deep($qs, 'urlencode');
		if ( is_array($args[0]) ) {
			foreach ( $args[0] as $k => $v ) {
				$qs[ $k ] = $v;
			}
		} else {
			$qs[$args[0]] = $args[1];
		}

		foreach ( $qs as $k => $v ) {
			if ( $v === false ) unset( $qs[ $k ] );
		}

		$ret = _http_build_query($qs, null, '&', '', false);
		$ret = trim($ret, '?');
		$ret = preg_replace('#=(&|$)#', '$1', $ret);
		$ret = $protocol . $base . $ret . $frag;
		$ret = rtrim($ret, '?');

		return $ret;
	}
}

if ( !function_exists('remove_query_arg') ) {
	function remove_query_arg( $key, $query = false ) {
		if ( is_array($key) ) { // Removing multiple keys.
			foreach ( $key as $k ) {
				$query = add_query_arg($k, false, $query);
			}
			return $query;
		}
		return add_query_arg($key, false, $query);
	}
}
