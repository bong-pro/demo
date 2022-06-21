<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CP_Controller
{

	public function index()
	{
		// load model
		$this->load->model( 'Model_group' );

		$groups = $this->Model_group->list_all();

		// load page
		$this->document->config( 'ID', 10902010 );
		$this->document->config( 'page_title', 'User List' );
		$this->document->view( 'preferences/members/users', array(
			'groups' => $groups,
		) );
	}

	public function list()
	{
		$params = array(
			'user_id'           => $this->input->get( 'user_id' ),

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

		$this->load->model( 'Model_user' );
		$data = $this->Model_user->list( $args );

		cp_api_json( $data );
	}

	public function item_get( $target_id='' )
	{
		if ( empty( $target_id ) ) {
			return false;
		}

		$this->load->model( 'Model_user' );
		$data = $this->Model_user->_item( null, array(
			'user_id' => $target_id,
		) );

		cp_api_json( $data );
	}

	public function item_delete( $target_id='' )
	{
		if ( ! empty( $target_id ) ) {
			$this->load->model( 'Model_user' );
			$data = $this->Model_user->_delete( $target_id, null );
		}

		cp_api_json( $data );
	}

	public function selected_delete()
	{
		if ( ! empty( $this->input->post() ) ) {
			$this->load->model( 'Model_user' );
			$data = $this->Model_user->_selected_delete( $this->input->post() );
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
		$data = array(
			'user_id'		=> preg_replace( '/\s+/', '', strtolower( $this->input->post( 'user_id' ) ) ),
			'user_name'		=> preg_replace( '/\s+/', '', strtolower( $this->input->post( 'user_name' ) ) ),
			'mobile'		=> $this->input->post( 'mobile' ),
			'is_used'		=> $this->input->post( 'is_used' ),
			'group_id'		=> $this->input->post( 'group_id' ),
		);

		if ( ! empty( $this->input->post( 'user_password_modified' ) ) ) {
			$data['user_password'] = md5( $this->input->post( 'user_password_modified' ) );
		}

		if ( ! empty( $this->input->post( 'email' ) ) ) {
			$data['email'] = $this->input->post( 'email' );
		}

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

	public function item_insert()
	{
		$this->load->library( 'form_validation' );
		$this->load->helper( 'security' );

		$this->form_validation->set_rules( 'user_login', '아이디', 'trim|required|alphanumunder|min_length[3]|max_length[30]|is_unique[tom_user.user_login]' );
		$this->form_validation->set_rules( 'user_password', '비밀번호', 'required|min_length[4]|max_length[20]' );
		$this->form_validation->set_rules( 'user_name', '이름', 'trim|required|min_length[3]|max_length[50]|xss_clean' );
		$this->form_validation->set_rules( 'email', '이메일', 'trim|required|valid_email|min_length[8]|max_length[50]' );
		$this->form_validation->set_rules( 'mobile', '전화번호', 'trim|required|numeric|min_length[10]|max_length[30]' );

		if ( true === $this->form_validation->run() ) {
			$data = array(
				'user_login'		=> preg_replace( '/\s+/', '', strtolower( $this->input->post( 'user_login' ) ) ),
				'user_password'		=> md5( $this->input->post( 'user_password' ) ),
				'user_name'			=> preg_replace( '/\s+/', '', strtolower( $this->input->post( 'user_name' ) ) ),
				'email'				=> $this->input->post( 'email' ),
				'mobile'			=> $this->input->post( 'mobile' ),
				'group_id'			=> $this->input->post( 'group_id' ),
			);

			try {
				$update = array_filter( $data, function( $v ) {
					return null !== $v;
				} );

				if ( empty( $update ) ) {
					throw new Exception( '등록할 데이터가 없습니다.' );
				}

				if ( ! empty( $update ) ) {
					$data['result']     = $this->Model_user->_insert( $update );
					$data['message']    = '신규등록이 완료되었습니다.';
					$data['confirm']    = 'Y';
				}
			} catch ( Exception $e ) {
				$data['message'] = $e->getMessage();
			}
		} else {
			$data['message']    = 'Error. 등록정보를 확인해주세요.';
			$data['confirm']    = 'N';
		}

		cp_api_json( $data );
	}

}
