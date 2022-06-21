<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CP_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->document->remove_js('session-timeout');
	}

	public function index()
	{
		$redirect_to = $this->input->post_get('redirect_to') ? urldecode($this->input->post_get('redirect_to')) : null;

		if ( empty($redirect_to) ) {
			$redirect_to = cp_config_item('login_redirect_to', base_url());
		}

		if ( $this->user->is_logged_in() ) {
			alert( 'You are already logged in.', $redirect_to );
		}

		$this->load->library('form_validation');

		$this->form_validation->set_data([
			'login'    => $this->input->post( 'login' ),
			'password' => $this->input->post( 'password' )
		]);

		$this->form_validation->set_rules('login', 'Login ID', 'trim|required|alphanumunder|min_length[3]|max_length[30]' );
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[20]|callback__check_id_pw[' . $this->input->post('login') . ']');

		if ( $this->form_validation->run() == true ) {
			redirect($redirect_to);
			exit;
		} else {
			$this->document->config(array(
				'layout'        => false,
				'page_title'	=> 'Login',
				'content_class'	=> 'd-flex justify-content-center align-items-center login-cover',
			));

			$this->document->view('login', array(
				'use_sociallogin'   => cp_config_item('use_sociallogin', false),
				'use_registration'  => cp_config_item('use_registration', false),
				'redirect_to'       => $redirect_to,
			));
		}

	}

	public function _check_id_pw($password, $login)
	{
		$this->load->helper('security');

		$user = $this->Model_users->_item(null, array('login' => $login));
		$password = $password ? do_hash($password, 'md5') : '';

		if ( empty($user) ) {
			if ( $login ) {
				$this->session->set_flashdata('message', dismissible('warning', 'Please check your login ID.'));
			}
			return false;
		}

		if ( isset($user['is_used']) && $user['is_used'] !== 'Y' && $user['password'] == $password ) {
			$this->session->set_flashdata('message', dismissible('warning', 'Restricted Login ID.'));
			return false;
		}

		if ( isset($user['password']) && $user['password'] !== $password ) {
			$this->session->set_flashdata('message', dismissible('warning', 'Please confirm your password.'));
			return false;
		}

		$this->session->set_userdata('user_id', element('user_id', $user));
		return true;
	}

	public function logout()
	{
		if ( !$this->user->is_logged_in() ) redirect();

		$this->session->sess_destroy();

		$url_after_logout = cp_config_item('url_after_logout');
		if ( $url_after_logout ) $url_after_logout = site_url($url_after_logout);
		if ( empty($url_after_logout) ) {
			$url_after_logout = $this->input->get_post('redirect_to') ? $this->input->get_post('redirect_to') : site_url();
		}

		redirect($url_after_logout, 'refresh');
	}

	public function register()
	{
		$this->load->library('form_validation');
		$this->load->helper('security');

		$this->form_validation->set_rules('login', 'Login ID', 'trim|required|alphanumunder|min_length[3]|max_length[30]|is_unique[users.login]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[20]');
		$this->form_validation->set_rules('password_cp', 'Password confirm', 'required|min_length[4]|max_length[20]|matches[password]');
		$this->form_validation->set_rules('name', 'User name', 'trim|required|min_length[3]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('email', 'User email', 'trim|required|valid_email|min_length[8]|max_length[50]');
		$this->form_validation->set_rules('mobile', 'User mobile', 'trim|required|numeric|min_length[10]|max_length[30]');

		$password = $this->input->post('password') ? do_hash($this->input->post('password'), 'md5') : '';

		if ( $this->form_validation->run() === true ) {
			$data = array(
				'login'		=> $this->input->post('login'),
				'password'	=> $password,
				'name'		=> $this->input->post('name'),
				'email'		=> $this->input->post('email'),
				'mobile'	=> $this->input->post('mobile')
			);

			$this->load->model('Model_users');
			$this->Model_users->_insert($data);
			alert('The information has been registered.', base_url());
		} else {
			$this->document->config(array(
				'layout'        => false,
				'page_title'	=> 'Register',
				'content_class'	=> 'd-flex justify-content-center align-items-center login-cover',
			));

			$this->document->view('register');
		}
	}
	
	public function data_check()
	{
		$user = $this->Model_users->_item(null, array('login' => $this->input->post('login')));
		echo empty($user) ? json_encode(true) : json_encode(false);
		exit;
	}

}
