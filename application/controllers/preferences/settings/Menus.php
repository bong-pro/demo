<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends CP_Controller
{

	public function index()
	{
		// load page
		$this->document->config( 'ID', 10901010 );
		$this->document->config( 'page_title', 'Menu List' );
		$this->document->view( 'preferences/settings/menus' );
	}

	public function list()
	{
		$params = array(
			'menu_id'	=> $this->input->get( 'menu_id' ),

			'keyword'	=> $this->input->get( 'keyword' ),
			'is_used'	=> $this->input->get( 'is_used' ),
			'start'		=> $this->input->get( 'start' ),
			'end'		=> $this->input->get( 'end' ),

			'limit'		=> $this->input->get( 'limit' ),
			'offset'	=> $this->input->get( 'offset' ),
			'orderby'	=> $this->input->get( 'orderby' ),
			'order'		=> $this->input->get( 'order' ),
		);

		$args = array_filter( $params, function($v) {
			return ( isset( $v ) && !is_null( $v ) );
		} );

		$this->load->model( 'MenusModel' );
		$data = $this->MenusModel->menu_list( $args );

		cp_api_json( $data );
	}

	public function item_get( $target_id='' )
	{
		if ( empty( $target_id ) ) {
			return false;
		}

		$this->load->model( 'Model_menu' );
		$data = $this->Model_menu->_item( null, array(
			'menu_id' => $target_id,
		) );

		cp_api_json( $data );
	}

	public function item_delete( $target_id='' )
	{
		if ( ! empty( $target_id ) ) {
			$this->load->model( 'Model_menu' );
			$data = $this->Model_menu->_delete( $target_id, null );
		}

		cp_api_json( $data );
	}

	public function selected_delete()
	{
		if ( ! empty( $this->input->post() ) ) {
			$this->load->model( 'MenusModel' );
			$data = $this->MenusModel->_selected_delete( $this->input->post() );
		}

		cp_api_json( $data );
	}

	public function name_put( $target_id='' )
	{
		! empty( $this->input->post( 'name' ) ) ? $update['name'] = $this->input->post( 'name' ) : $update['name'] = null;

		$this->load->model( 'Model_menu' );
		$data['result'] = $this->Model_menu->_update( null, $update, array( 'menu_id' => $target_id ) );
		$data['message'] = '정보가 업데이트 되었습니다.';

		cp_api_json( $data );
	}

	public function paren_menu_put( $target_id='' )
	{
		! empty( $this->input->post( 'parent_menu_id' ) ) ? $update['parent_menu_id'] = $this->input->post( 'parent_menu_id' ) : $update['parent_menu_id'] = null;

		$this->load->model( 'Model_menu' );
		$data['result'] = $this->Model_menu->_update( null, $update, array( 'menu_id' => $target_id ) );
		$data['message'] = '정보가 업데이트 되었습니다.';

		cp_api_json( $data );
	}

	public function priority_put( $target_id='' )
	{
		! empty( $this->input->post( 'priority' ) ) ? $update['priority'] = $this->input->post( 'priority' ) : $update['priority'] = null;

		$this->load->model( 'Model_menu' );
		$data['result'] = $this->Model_menu->_update( null, $update, array( 'menu_id' => $target_id ) );
		$data['message'] = '정보가 업데이트 되었습니다.';

		cp_api_json( $data );
	}

	public function link_put( $target_id='' )
	{
		! empty( $this->input->post( 'link' ) ) ? $update['link'] = $this->input->post( 'link' ) : $update['link'] = null;

		$this->load->model( 'Model_menu' );
		$data['result'] = $this->Model_menu->_update( null, $update, array( 'menu_id' => $target_id ) );
		$data['message'] = '정보가 업데이트 되었습니다.';

		cp_api_json( $data );
	}

	public function status_put( $target_id='' )
	{
		$data = array(
			'is_used'			=> $this->input->post( 'is_used' ),
		);

		try {
			$update = array_filter( $data, function( $v ) {
				return null !== $v;
			} );

			if ( empty( $update ) ) {
				throw new Exception( '수정할 데이터가 없습니다.' );
			}

			$this->load->model( 'Model_menu' );
			$data['result'] = $this->Model_menu->_update( null, $update, array(
				'menu_id' => $target_id,
			) );

			$data['message'] = '정보가 업데이트 되었습니다.';
		} catch ( Exception $e ) {
			$data['message'] = $e->getMessage();
		}

		cp_api_json( $data );
	}

	public function item_put( $target_id='' )
	{
		// model load
		$this->load->model( 'Model_menu' );

		$data = array(
			'name'				=> $this->input->post( 'name' ),
			'parent_menu_id'	=> $this->input->post( 'parent_menu_id' ),
			'priority'			=> $this->input->post( 'priority' ),
			'link'				=> $this->input->post( 'link' ),
			'is_used'			=> $this->input->post( 'is_used' ),
		);

		! empty( $this->input->post( 'link_target' ) ) ? $update['link_target'] = $this->input->post( 'link_target' ) : $update['link_target'] = null;
		! empty( $this->input->post( 'link_class' ) ) ? $update['link_class'] = $this->input->post( 'link_class' ) : $update['link_class'] = null;
		! empty( $this->input->post( 'before_html' ) ) ? $update['before_html'] = $this->input->post( 'before_html' ) : $update['before_html'] = null;
		! empty( $this->input->post( 'after_html' ) ) ? $update['after_html'] = $this->input->post( 'after_html' ) : $update['after_html'] = null;

		try {
			$update = array_filter( $data, function( $v ) {
				return null !== $v;
			} );

			if ( empty( $update ) ) {
				throw new Exception( '수정할 데이터가 없습니다.' );
			}

			$data['result'] = $this->Model_menu->_update( null, $update, array(
				'menu_id' => $target_id,
			) );

			$data['message'] = '정보가 업데이트 되었습니다.';
		} catch ( Exception $e ) {
			$data['message'] = $e->getMessage();
		}

		cp_api_json( $data );
	}

	public function item_insert()
	{
		// model load
		$this->load->model( 'Model_menu' );

		$data = array(
			'menu_id'			=> $this->input->post( 'menu_id' ),
			'name'				=> $this->input->post( 'name' ),
			'parent_menu_id'	=> $this->input->post( 'parent_menu_id' ),
			'priority'			=> $this->input->post( 'priority' ),
			'link'				=> $this->input->post( 'link' ),
			'link_target'		=> $this->input->post( 'link_target' ),
			'link_class'		=> $this->input->post( 'link_class' ),
			'before_html'		=> $this->input->post( 'before_html' ),
			'after_html'		=> $this->input->post( 'after_html' ),
			'is_used'			=> $this->input->post( 'is_used' ),
		);

		try {
			$update = array_filter( $data, function( $v ) {
				return null !== $v;
			} );

			if ( empty( $update ) ) {
				throw new Exception( '등록할 데이터가 없습니다.' );
			}

			$check = $this->Model_menu->_item( null, array(
				'menu_id' => $this->input->post( 'add_menu_id' ),
			) );

			if ( ! empty( $check ) ) {
				$data['message']    = '중복되는 일련번호가 있습니다.';
				$data['confirm']    = 'N';
			} else {
				$data['result']     = $this->Model_menu->_insert( $update );
				$data['message']    = '신규등록이 완료되었습니다.';
				$data['confirm']    = 'Y';
			}
		} catch ( Exception $e ) {
			$data['message'] = $e->getMessage();
		}

		cp_api_json( $data );
	}

}
