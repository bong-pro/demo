<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CP_Controller
{

	public function index()
	{
		// load helper
		$this->load->helper('directory');
		$this->load->helper('tree');

		$tree_data = directory_map('../application/views/pages');
		$tree = doc_generate_tree_json( $tree_data, array(), null );

		// load page
		$this->document->config( 'ID', 10902020 );
		$this->document->config( 'page_title', 'Group List' );
		$this->document->view( 'preferences/members/groups', array(
			'tree' => $tree,
		) );
	}

	public function list()
	{
		$params = array(
			'keyword'           => $this->input->get( 'keyword' ),
			'is_used'           => $this->input->get( 'is_used' ),
			'start'             => $this->input->get( 'start' ),
			'end'               => $this->input->get( 'end' ),

			'limit'             => $this->input->get( 'limit' ),
			'offset'            => $this->input->get( 'offset' ),
			'orderby'           => $this->input->get( 'orderby' ),
			'order'             => $this->input->get( 'order' ),
		);

		$args = array_filter( $params, function($v) {
			return ( isset( $v ) && !is_null( $v ) );
		} );

		$this->load->model( 'Model_group' );
		$data = $this->Model_group->list( $args );

		cp_api_json( $data );
	}

	public function item_get( $target_id='' )
	{
		if ( empty( $target_id ) ) {
			return false;
		}

		$this->load->helper('directory');
		$this->load->helper('tree');

		$this->load->model( 'Model_group' );

		$data = $this->Model_group->_item( null, array(
			'group_id' => $target_id,
		) );

		if ( ! empty( $data['permission'] ) ) {
			$tree_data = directory_map('../application/views/pages');
			$tree = doc_generate_tree_json( $tree_data, array(), $data['permission'] );
			$data['tree'] = $tree;
		}

		cp_api_json( $data );
	}

	public function item_delete( $target_id='' )
	{
		if ( ! empty( $target_id ) ) {
			$this->load->model( 'Model_group' );
			$data['result'] = $this->Model_group->_delete( $target_id, null );
		}

		cp_api_json( $data );
	}

	public function selected_delete()
	{
		if ( ! empty( $this->input->post() ) ) {
			$this->load->model( 'Model_group' );
			$data = $this->Model_group->_selected_delete( $this->input->post() );
		}

		cp_api_json( $data );
	}

	public function status_put( $target_id='' )
	{
		$data = array(
			'is_used' => $this->input->post( 'is_used' ),
		);

		try {
			$update = array_filter( $data, function( $v ) {
				return null !== $v;
			} );

			if ( empty( $update ) ) {
				throw new Exception( '수정할 데이터가 없습니다.' );
			}

			$this->load->model( 'Model_user' );
			$data['result'] = $this->Model_user->_update( null, $update, array(
				'user_id' => $target_id,
			) );

			$data['message'] = '정보가 업데이트 되었습니다.';
		} catch ( Exception $e ) {
			$data['message'] = $e->getMessage();
		}

		cp_api_json( $data );
	}

	public function item_put( $target_id='' )
	{
		// edit tree
		$tree_count = count( $this->input->post() );

		$tree_data = array();

		for ( $i=0; $i<$tree_count; $i++ ) {
			if ( substr( $this->input->post( $i ), 0, 1 ) === '/' ) {
				array_push( $tree_data, $this->input->post( $i ) );
			}
		}

		$data = array(
			'group_name'    => $this->input->post( 'group_name' ),
			'is_used'       => $this->input->post( 'is_used' ),
		);

		try {
			$update = array_filter( $data, function( $v ) {
				return null !== $v;
			} );

			$tree_count > 0 ? $update['permission'] = '"' . implode( '","', $tree_data ) . '"' : $update['permission'] = null;

			if ( empty( $update ) ) {
				throw new Exception( '수정할 데이터가 없습니다.' );
			}

			$this->load->model( 'Model_group' );
			$data['result'] = $this->Model_group->_update( null, $update, array(
				'group_id' => $target_id,
			) );

			$data['message'] = '정보가 업데이트 되었습니다.';
		} catch ( Exception $e ) {
			$data['message'] = $e->getMessage();
		}

		cp_api_json( $data );
	}

	public function item_insert()
	{
		// edit tree
		$tree_count = count( $this->input->post() );

		$tree_data = array();

		for ( $i=0; $i<$tree_count; $i++ ) {
			if ( substr( $this->input->post( $i ), 0, 1 ) === '/' ) {
				array_push( $tree_data, $this->input->post( $i ) );
			}
		}

		$data = array(
			'group_name'	=> $this->input->post( 'group_name' ),
			'permission'	=> '"' . implode( '","', $tree_data ) . '"',
			'is_used'		=> $this->input->post( 'is_used' ),
		);

		try {
			$update = array_filter( $data, function( $v ) {
				return null !== $v;
			} );

			if ( empty( $update ) ) {
				throw new Exception( '등록할 데이터가 없습니다.' );
			}

			$this->load->model( 'Model_group' );
			$check = $this->Model_group->_item( null, array(
				'group_name' => $this->input->post( 'group_name' ),
			) );

			if ( ! empty( $check ) ) {
				$data['message']	= '중복되는 그룹명이 있습니다.';
				$data['confirm']	= 'N';
			} else {
				$data['result']		= $this->Model_group->_insert( $update );
				$data['message']	= '신규등록이 완료되었습니다.';
				$data['confirm']	= 'Y';
			}
		} catch ( Exception $e ) {
			$data['message'] = $e->getMessage();
		}

		cp_api_json( $data );
	}

}
