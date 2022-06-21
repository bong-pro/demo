<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_logs extends CP_Model
{

	/**
	 * table name
	 */
	protected $_table = 'logs';

	/**
	 * primary key
	 */
	protected $primary_key = 'log_id';

	/**
	 * search fields=keyword
	 */
	protected $search_keyword_fields = array(
		'log_id',
		'contents',
	);

	public function logs($args=array())
	{
		return $this->_list(
			"{$this->_table}.*",
			null,
			'1=1',
			array($this->primary_key => 'DESC'),
			null,
			null
		);
	}

	public function empty_table()
	{
		$this->db->empty_table($this->_table);
		return true;
	}

}
