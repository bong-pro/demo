<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Document
{

	protected $_CI = null;

	/**
	 * 환경설정 값
	 * @var array
	 */
	protected $_config = array();

	/**
	 * 레이아웃별 환경설정 값
	 * @var array
	 */
	protected $_section_config = array();

	/**
	 * CSS 큐
	 * @var array
	 */
	protected $css = array();

	/**
	 * JS 큐
	 * @var array
	 */
	protected $js = array();

	/**
	 * JS 변수
	 * @var array
	 */
	public $script_params = array();

	public $inline_style = null;

	public $inline_script = null;

	private $template_dir = null;

	private $view_dir = null;

	/**
	 * 생성자
	 * @param array $args
	 */
	public function __construct($args = array())
	{
		$this->_CI = &get_instance();
		$this->_CI->load->helper('document');
		$this->_CI->load->model('Model_menus');
		$this->_CI->load->library('session');

		$this->template_dir = cp_config_item('template_dir', 'templates');
		$this->view_dir = cp_config_item('view_dir', 'pages');

		$this->init($args);
	}

	public function init($args)
	{
		$defaults = array(
			'ID'                        => -1,

			'page_title'                => '',
			'meta_description'          => '',
			'meta_keywords'             => '',
			'meta_author'               => '',

			'body_class'                => '', // sidebar-xs,
			'page_class'                => '',
			'content_class'             => '',

			'layout'                    => true,
			'layout_num'				=> 'layout_1/', // layout_1 ~ layout_6
			'direction'					=> 'LTR/', // LTR, RTL
			'theme'                     => 'default/', // dark, default, material
			'theme_color'               => '#333',

			'section__header'           => '',
			'section__left_sidebar'     => '',
			'section__page_title'       => true,
			'section__breadcrumb'       => '',
			'section__content'          => '',
			'section__footer'           => '',
			'section__right_sidebar'    => false,
		);

		$this->_config = cp_parse_args($args, $defaults);
	}

	/**
	 * 환경설정 파라미터 변경
	 * @param string|array $key
	 * @param string $value
	 * @param boolean $replace
	 */
	public function config($key_or_array, $value=false, $is_concat=false)
	{
		if ( !is_array($key_or_array) ) $key_or_array = array($key_or_array => $value);

		foreach( $key_or_array as $key => $item ) {
			$this->_config[$key] = $is_concat == true && ! is_array($this->_config[$key]) ? ' ' . $item : $item;
		}

		//$this->_config = cp_parse_args( $key_or_array, $this->_config );
	}

	/**
	 * 환경설정 레이아웃 데이터 설정/변경
	 * @param string $section
	 * @param string|array $key_or_array
	 * @param string $value
	 */
	public function section_config($section, $key_or_array, $value=false)
	{
		if ( !is_array($key_or_array) ) $key_or_array = array($key_or_array => $value);

		$section_config = array_key_exists($section, $this->_section_config) ? $this->_section_config[$section] : array();

		$this->_section_config[$section] = cp_parse_args($key_or_array, $section_config);
	}

	protected function _parse_config()
	{
		$config = $this->_config;
		$config['page_link'] = '';

		// 각 레이아웃 yeild 생성
		if ( $config['layout'] !== false ) {
			// 메인 메뉴
			$main_menu = $this->_CI->Model_menus->list();

			// 해당 페이지 정보
			if ( $config['ID'] > 0 ) {
				$current_menu = $this->_CI->Model_menus->item($config['ID']);

				if ( empty($config['page_title']) ) {
					$this->_config['page_title'] = $current_menu['name'];
					$config = $this->_config;
				}

				if ( empty($config['page_link']) ) {
					$page_link_array = explode('/', $current_menu['link']);
					$this->_config['page_link'] = strtoupper($page_link_array['1']);
					$config = $this->_config;
				}

				if ( $config['section__breadcrumb'] !== false ) {
					$this->section_config(
						'breadcrumb',
						'current_menu',
						$current_menu
					);
				}
			}

			foreach ( $config as $key => $value ) {
				if ( strpos($key, 'section__') === 0 && $value !== false ) {
					$section_name = preg_replace('/^section__/', '', $key);

					if ( $section_name == 'content' ) continue;

					$section_config = array('document_ID' => $config['ID']);

					switch ( $section_name ) {
						case 'header' :
							$section_config['use__left_sidebar']	= ($config['section__left_sidebar'] !== false);
							$section_config['use__right_sidebar']	= ($config['section__right_sidebar'] !== false);
							break;
						case 'left_sidebar' :
							$section_config['nav_data'] = $main_menu;
							break;
						case 'page_title' :
							$section_config['page_title']	= $config['page_title'];
							$section_config['page_link']	= $config['page_link'];
							break;
						case 'breadcrumb' :
							break;
						case 'footer' :
							break;
						case 'right_sidebar' :
							break;
					}
					$this->section_config($section_name, $section_config);

					if ( empty($value) || !is_string($value) ) {
						$value = $this->template_dir . '/sections/' . $section_name;
					} else {
						$value = trailingslashit($this->view_dir) . $value;
					}

					$config[$key] = $this->_CI->load->view($value, $this->_section_config[$section_name], true);
					$this->_CI->load->clear_vars();
				}
			}
		}

		// body class 재정의
		if ( !empty($config['body_class']) ) {
			$body_class = array_filter(array_map('trim', explode(' ', $config['body_class'])));
			$body_class = array_unique($body_class);
			$config['body_class'] = implode(' ', $body_class);
		}

		return $config;
	}

	/**
	 * 최종 레이아웃 출력 (view file 버전)
	 * @param string $view_name
	 * @param array $vars
	 * @param boolean $return
	 * @return string
	 */
	public function view($view_name='', $vars=array(), $return=false)
	{
		if ( $this->_CI->input->is_ajax_request() ) {
			if ( !empty($view_name) ) {
				if ( strpos($view_name, trailingslashit($this->view_dir)) !== 0 ) {
					$view_name = trailingslashit($this->view_dir) . $view_name;
				}
				return $this->_CI->load->view($view_name, $vars, $return);
			}
			return $view_name;
		}

		// 설정 파싱
		$config = $this->_parse_config();

		if ( is_array($vars) ) $vars['page_title'] = $config['page_title'];

		// 본문 생성
		if ( !empty($view_name) ) {
			if ( strpos($view_name, trailingslashit($this->view_dir)) !== 0 ) {
				$view_name = trailingslashit($this->view_dir) . $view_name;
			}
			$config['section__content'] = $this->_CI->load->view($view_name, $vars, true);
		}

		// 화면 렌더링
		return $this->_CI->load->view($this->template_dir . '/document', $config, $return);
	}

	/**
	 * 레이아웃 내 컴포넌트 출력용
	 * @param string $widget_name
	 */
	public function widget($widget_name, $data='', $return=false)
	{
		return $this->_CI->load->view($this->template_dir . '/widgets/' . str_replace('_', '-', $widget_name), $data, $return);
	}

	/**
	 * 스타일시트 큐 추가
	 * @param string $handle
	 * @param string $src
	 * @param boolean $ver
	 * @param string $media
	 */
	public function add_css($handle, $src='', $ver=false, $media='all')
	{
		$this->css[$handle] = array(
			'src'	=> $src,
			'ver'	=> $ver,
			'media'	=> $media
		);
		return $this;
	}

	/**
	 * 스타일시트 큐 제거
	 * @param string $handle
	 * @return boolean
	 */
	public function remove_css($handle)
	{
		if ( array_key_exists($handle, $this->css) ) unset($this->css[$handle]);
		return $this;
	}

	/**
	 * 자바스크립트 큐 추가
	 * @param string $handle
	 * @param string $src
	 * @param boolean $ver
	 * @param boolean $in_footer
	 */
	public function add_js($handle, $src='', $ver=false, $in_footer=false)
	{
		$this->js[$handle] = array(
			'src'		=> $src,
			'ver'		=> $ver,
			'in_footer'	=> $in_footer
		);
		return $this;
	}

	/**
	 * 자바스크립트 큐 삭제
	 * @param string $handle
	 * @return Document
	 */
	public function remove_js($handle)
	{
		if ( array_key_exists($handle, $this->js) ) unset($this->js[$handle]);
		return $this;
	}

	/**
	 * 스크립트 공통 json 변수 추가
	 * @param string $key
	 * @param int|string|array $value
	 */
	public function add_js_params($key, $value)
	{
		$this->js_params[$key] = $value;
		return $this;
	}

	/**
	 * 스크립트 공통 json 변수 삭제
	 * @param string $key
	 * @return boolean
	 */
	public function remove_js_params($key)
	{
		if ( array_key_exists($handle, $this->js_params) ) unset($this->js_params[$handle]);
		return $this;
	}

	/**
	 * 인라인 스타일 추가
	 * @param string $inline_style
	 * @return Document
	 */
	public function add_inline_style($inline_style='')
	{
		if ( is_string($inline_style) ) $this->inline_style .= $inline_style;
		return $this;
	}

	/**
	 * 인라인 스크립트 추가
	 * @param string $inline_script
	 */
	public function add_inline_script($inline_script='')
	{
		if ( is_string($inline_script) ) $this->inline_script .= $inline_script;
		return $this;
	}

	/**
	 * 스타일시트 출력
	 */
	public function output_css()
	{
		foreach ( $this->css as $handle => $item ) {
			$src = !empty($item['ver']) ? add_query_arg('ver', $item['ver'], $item['src'] ) : $item['src'];
			printf('<link rel="stylesheet" id="%1$s-css" href="%2$s" type="text/css" media="%3$s">' . PHP_EOL, $handle, $src, $item['media']);
		}
		if ( $this->inline_style ) echo '<style type="text/css">' . preg_replace('/\s+/', '', $this->inline_style)  . '</style>' . PHP_EOL;
	}

	/**
	 * 스크립트 출력
	 * @param boolean $footer
	 */
	public function output_js($footer=false)
	{
		foreach ( $this->js as $handle => $item ) {
			if ( (!$footer && $item['in_footer']) || ($footer && !$item['in_footer']) ) continue;
			$src = !empty($item['ver']) ? add_query_arg('ver', $item['ver'], $item['src']) : $item['src'];
			printf('<script type="text/javascript" src="%s"></script>' . PHP_EOL, $src);
		}

		if ( $footer ) {
			echo '<script type="text/javascript">' . PHP_EOL;
			echo 'var cp_params = ' . json_encode($this->js_params) . ';' . PHP_EOL;
			if ($this->inline_script) echo preg_replace('/\s+/', ' ', $this->inline_script);
			echo '</script>' . PHP_EOL . PHP_EOL;
		}
	}

}
