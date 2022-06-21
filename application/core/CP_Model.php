<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CP_Model extends CI_Model
{

	/**
	 * table name
	 */
	protected $_table;

	/**
	 * primary key
	 */
	protected $primary_key;

	/**
	 * search fields=keyword
	 */
	protected $search_keyword_fields = [];

	/**
	 * serch fields=start/end
	 */
	protected $search_start_end_field;

	/**
	 * secret fields
	 */
	protected $secret_fields = [];

	/**
	 * secret key
	 * @var
	 */
	protected $secret_key;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->secret_key = $this->db->escape(cp_config_item('db_secret_key', 'codepress'));
	}

	protected function encrypt($string_or_field='', $use_escape=true)
	{
		if ($use_escape == true) $string_or_field = $this->db->escape( $string_or_field );
		return " HEX(AES_ENCRYPT({{$string_or_field}}, {{$this->secret_key}})) ";
	}

	protected function decrypt($string_or_field='', $use_escape=true)
	{
		if ($use_escape=true) $string_or_field = $this->db->escape($string_or_field);
		return " AES_DECRYPT(UNHEX({{$string_or_field}}), {{$this->secret_key}}) ";
	}

	protected function __where_by_keyword($keyword='')
	{
		$where = '';
		if ( !empty($keyword) && !empty($this->search_keyword_fields) ) {
			$search_fields = !is_array($this->search_keyword_fields) ? (array) $this->search_keyword_fields : $this->search_keyword_fields;

			$where_strings = array();
			foreach ( $search_fields as $item ) {
				if ( strpos($item, '.') === false ) $item = "{$this->_table}.{$item}";
				$where_strings[] = "{$item} LIKE '%" . $this->db->escape_like_str($keyword) . "%' ESCAPE '!'";
			}
			$where .= " AND (" . implode(' OR ', $where_strings) . ")";
		}

		return $where;
	}

	protected function __where_by_start_end($start='', $end='')
	{
		$where = '';
		if ( (!empty($start) || !empty($end)) && !empty($this->search_start_end_field) ) {
			$field_name = $this->search_start_end_field;

			if ( !empty($start) ) {
				$start_time	= strtotime($start);
				$start		= date('Y-m-d H:i:s', $start_time);
			}

			if ( !empty($end) ) {
				$end_time	= strtotime($end);
				$format		= (strlen($end) > 10) ? 'Y-m-d H:i:s' : 'Y-m-d 23:59:59';
				$end		= date($format, $end_time);
			}

			if ( !is_array($this->search_start_end_field) ) {
				// table of fields
				if ( strpos($field_name, '.') === false ) $field_name = "{$this->_table}.{$field_name}";

				if ( !empty($start) && !empty($end) ) {
					$where .= " AND {$field_name} BETWEEN " . $this->db->escape($start) . " AND " . $this->db->escape($end);
				} elseif ( !empty($start) ) {
					$where .= " AND {$field_name}>=" . $this->db->escape($start);
				} elseif ( !empty($end) ) {
					$where .= " AND {$field_name}<=" . $this->db->escape($end);
				}
			} elseif ( !empty($field_name['start']) && !empty($field_name['end']) ) {
				// table of fields
				foreach ( $field_name as $key => $item ) {
					if ( strpos($item, '.') === false ) {
						$field_name[$key] = "{$this->_table}.{$item}";
					}
				}

				if ( !empty($start) && !empty($end) ) {
					$where .= " AND (
						({$field_name['start']}>=" . $this->db->escape($start) . " AND {$field_name['start']}<=" . $this->db->escape($end) . ")
						OR ({$field_name['end']}>=" . $this->db->escape($start) . " AND {$field_name['end']}<=" . $this->db->escape($end) . ")
						OR ({$field_name['start']}<=" . $this->db->escape($start) . " AND {$field_name['end']}>=" . $this->db->escape($end) . ")
					)";
				} elseif ( !empty($args['start']) ) {
					$where .= " AND (
						({$field_name['start']}>=" . $this->db->escape($start) . ")
						OR ({$field_name['end']}>=" . $this->db->escape($start) . ")
					)";
				} elseif ( !empty($args['end']) ) {
					$where .= " AND (
						({$field_name['start']}<=" . $this->db->escape($end) . ")
						OR ({$field_name['end']}<=" . $this->db->escape($end) . ")
					)";
				}
			}
		}

		return $where;
	}

	public function _list($select='', $join=array(), $where=array(), $orderby=array(), $limit='', $offset='', $groupby='')
	{
		if ( !empty($select) ) $this->db->select($select);
		$this->db->from($this->_table);
		if ( !empty($join) && is_array($join) ) {
			if ( isset($join['table']) && isset($join['on']) ) $join = array($join);
			foreach ( $join as $item ) {
				if ( empty($item['table']) || empty($item['on']) ) continue;
				$item['type'] = !empty($item['type']) ? $item['type'] : 'LEFT';
				$this->db->join($item['table'], $item['on'], $item['type'] );
			}
		}
		if ( ! empty($where) ) $this->db->where( $where );
		if ( ! empty($groupby) ) $this->db->group_by( $groupby );
		if ( empty($orderby) ) $orderby = array( $this->primary_key => 'DESC' );
		if ( is_array($orderby) ) {
			foreach ( $orderby as $key => $item ) {
				$this->db->order_by($key, $item);
			}
		} else {
			$this->db->order_by($orderby);
		}
		if ( !empty($limit) ) {
			$offset = !empty($offset) ? $offset : 0;
			$this->db->limit($limit, $offset);
		}

		$query = $this->db->get();
		$r = array(
			'list'          => $query->result_array(),
			'total_rows'    => 0,
		);

		$this->db->from($this->_table);
		!empty($groupby) ? $this->db->select( "COUNT(DISTINCT {$groupby}) AS rownum" ) : $this->db->select( 'COUNT(*) AS rownum' );
		if ( !empty($join) && is_array($join) ) {
			if ( isset($join['table']) && isset($join['on']) ) $join = array($join);
			foreach ( $join as $item ) {
				if ( empty($item['table']) || empty($item['on']) ) continue;
				$item['type'] = ! empty( $item['type'] ) ? $item['type'] : 'LEFT';
				$this->db->join( $item['table'], $item['on'], $item['type'] );
			}
		}
		if ( !empty($where) ) $this->db->where( $where );

		$query = $this->db->get();

		$rows = $query->row_array();
		$r['total_rows'] = (int) $rows['rownum'];

		return $r;
	}

	public function _item($primary_value='', $where=array(), $select='*')
	{
		if ($primary_value) $this->db->where($this->primary_key, $primary_value);
		if ($where) $this->db->where($where);

		$this->db->select($select);
		$this->db->from($this->_table);
		$this->db->limit(1);

		$query = $this->db->get();

		return $query->row_array();
	}

	public function _delete($primary_value='', $where='')
	{
		if ( $primary_value ) $this->db->where($this->primary_key, $primary_value);
		if ( $where ) $this->db->where($where);

		$result = $this->db->delete($this->_table);

		$this->_log_insert($this->_table . '_delete;' . $result);

		return $result;
	}

	public function _selected_delete($primary_value=array())
	{
		if ( empty($primary_value) ) return false;
		foreach ( $primary_value as $item ) {
			$this->db->where($this->primary_key, $item);
			$result = $this->db->delete($this->_table);

			$this->_log_insert($this->_table . '_selected_delete;' . $result);
		}

		return $result;
	}

	public function _update($primary_value='', $updatedata='', $where='')
	{
		if ( empty($updatedata) ) return false;
		if ( !empty($primary_value) ) $this->db->where($this->primary_key, $primary_value);
		if ( !empty($where) ) $this->db->where($where);

		$this->db->set($updatedata);
		$result = $this->db->update($this->_table);

		$this->_log_insert($this->_table . '_update;' . $result);

		return $result;
	}

	public function _insert($data)
	{
		if ( empty($data) ) return false;

		$this->db->insert($this->_table, $data);
		$insert_id = $this->db->insert_id();

		$this->_log_insert($this->_table . '_insert;' . $insert_id);

		return $insert_id;
	}

	public function _insert_batch($data)
	{
		if ( empty($data) ) return false;

		$this->db->insert_batch($this->_table, $data);

		$this->_log_insert($this->_table . '_insert_batch;' . $data);

		return true;
	}

	public function _replace($data='')
	{
		if ( empty($data) ) return false;

		$this->db->replace($this->_table, $data);

		return true;
	}

	public function _count_by($where='', $like='')
	{
		if ($where) $this->db->where($where);
		if ($like) $this->db->like($like);

		return $this->db->count_all_results($this->_table);
	}

	public function _log_insert($contents)
	{
		if ( empty($contents) ) return false;
		$user_id = !empty($this->user->item('user_id')) ? $this->user->item('user_id') : null;

		$data = array(
			'user_id'	=> $user_id,
			'user_ip'	=> $this->input->ip_address(),
			'contents'	=> $contents
		);

		$this->db->insert('logs', $data);

		return true;
	}

}
