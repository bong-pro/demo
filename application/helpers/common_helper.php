<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * debug function
 * @param string|array|object $var
 * @param boolean $exit
 */
function cp_print($var, $exit=false)
{
	echo '<pre>';print_r($var);echo '</pre>';
	if ( $exit ) exit;
}

function cp_config_item($key, $default=false)
{
	$value = config_item('cp__' . $key);
	return !empty($value) ? $value : $default;
}

function cp_parse_args($args, $defaults=array())
{
	if ( is_object($args) ) $r = get_object_vars($args);
	elseif ( is_array($args) ) $r =& $args;
	else parse_str($args, $r);

	if ( is_array($defaults) ) return array_merge($defaults, $r);

	return $r;
}

function cp_map_deep($value, $callback)
{
	if ( is_array($value) ) {
		foreach ( $value as $index => $item ) {
			$value[$index] = cp_map_deep($item, $callback);
		}
	} elseif ( is_object($value) ) {
		$object_vars = get_object_vars($value);
		foreach ( $object_vars as $property_name => $property_value ) {
			$value->$property_name = cp_map_deep($property_value, $callback);
		}
	} else {
		$value = call_user_func($callback, $value);
	}

	return $value;
}

function cp_api_request($api_route, $type='get', $data=array())
{
	global $api_connection;

	if ( empty($api_connection) ) {
		$api_connection = new GuzzleHttp\Client(array(
			'base_uri'  => api_url(),
		));
	}

	if ( strpos( $api_route, api_url() ) !== 0 ) $api_route = api_url($api_route);

	$type = ! empty($type) ? strtoupper($type) : 'get';
	
	try {
		$response = $api_connection->request($type, $api_route, array(
			//'debug' => true,
			'query' => $data,
		));

		if ( $response->getStatusCode() === 200 && $body = $response->getBody() ) {
			return json_decode($body->getContents(), true);
		}
	} catch ( GuzzleHttp\Exception\ClientException $e ) {
		if ( $e->hasResponse() ) {
			$response = $e->getResponse();
		}
	}

	return false;
}

function cp_api_json($data)
{
	header('Access-Control-Allow-Origin: *');
	header("Content-Type: application/json");

	$json = json_encode($data);
	if ( $json === false ) {
		$json = json_encode( array(
			"jsonError",
			json_last_error_msg()
		));
		if ( $json === false ) {
			$json = '{"jsonError": "unknown"}';
		}
		http_response_code(500);
	}
	echo $json;
	exit;
}
