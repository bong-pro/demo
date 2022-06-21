<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CP_Form_validation extends CI_Form_validation
{

	/**
	 * Reference to the CodeIgniter instance
	 *
	 * @var object
	 */
	protected $CI;

	/**
	 * Validation data for the current form submission
	 *
	 * @var array
	 */
	protected $_field_data = array();

	/**
	 * Validation rules for the current form
	 *
	 * @var array
	 */
	protected $_config_rules = array();

	/**
	 * Array of validation errors
	 *
	 * @var array
	 */
	protected $_error_array = array();

	/**
	 * Array of custom error messages
	 *
	 * @var array
	 */
	protected $_error_messages = array();

	/**
	 * Start tag for error wrapping
	 *
	 * @var string
	 */
	protected $_error_prefix = '<p>';

	/**
	 * End tag for error wrapping
	 *
	 * @var string
	 */
	protected $_error_suffix = '</p>';

	/**
	 * Custom error message
	 *
	 * @var string
	 */
	protected $error_string = '';

	/**
	 * Whether the form data has been validated as safe
	 *
	 * @var bool
	 */
	protected $_safe_form_data = false;

	/**
	 * Custom data to validate
	 *
	 * @var array
	 */
	public $validation_data = array();

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Match one field to another
	 * @access public
	 * @param string
	 * @param field
	 * @return bool
	 */
	public function is_unique($str, $field)
	{
		if ( substr_count($field, '.') === 3 ) {
			list($table, $field, $id_field, $id_val) = explode('.', $field);
			$query = $this->CI->db->limit(1)->where($field, $str)->where($id_field . ' != ', $id_val)->get($table);
		} else {
			list($table, $field) = explode('.', $field);
			$query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
		}

		return $query->num_rows() === 0;
	}
	// --------------------------------------------------------------------

	/**
	 * Alpha-numeric with underscores and dashes
	 * @access public
	 * @param string
	 * @return bool
	 */
	public function alphanumunder($str)
	{
		return (!preg_match("/^([-a-z0-9_])+$/i", $str)) ? false : true;
	}

	public function valid_url($str)
	{
		$pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
		if ( !preg_match($pattern, $str) ) {
			return false;
		}

		return true;
	}

	public function valid_phone($value)
	{
		$value = trim($value);
		if ($value === '') {
			return true;
		} else {
			if (preg_match('/^\(?[0-9]{2,3}\)?[-. ]?[0-9]{3,4}[-. ]?[0-9]{4}$/', $value)) {
				return preg_replace('/^\(?([0-9]{2,3})\)?[-. ]?([0-9]{3,4})[-. ]?([0-9]{4})$/', '$1-$2-$3', $value);
			} else {
				return false;
			}
		}
	}

}
