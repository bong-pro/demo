<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function doc_generate_nav($nav_data=array(), $menu_id=false)
{
	$html = '';
	foreach ( $nav_data AS $key => $item ) {
		$item_class = 'nav-item';
		$link_class = 'nav-link';

		if ( $menu_id == $item['menu_id'] ) $link_class .= ' active';

		$link_class .= ' ' . $item['link_class'];

		$target = '';
		if ( !empty($item['link_target']) ) $target = 'target="' . html_escape($item['link_target']) . '"';

		$child_html = '';
		if ( isset($item['_children']) && sizeof($item['_children']) > 0 ) {
			$child_html .= '<ul class="nav nav-group-sub" data-submenu-title="' . html_escape($item['name']) . '">';
			$child_html .= doc_generate_nav($item['_children'], $menu_id);
			$child_html .= '</ul>';

			$item_class .= ' nav-item-submenu';
			if ( preg_match("/<li(.*?)class=\"(.*?)active(.*?)\"(.*?)>(.*?)<\/li>/i", $child_html) ) {
				$item_class .= ' nav-item-expanded nav-item-open';
			}
		}

		$html .= '<li class="' . html_escape($item_class) . '" data-menu-id="' . $item['menu_id'] . '">'
			. '<a href="' . $item['link'] . '" class="' . html_escape($link_class) . '" ' . $target . '>'
			. $item['before_html'] . '<span>' . $item['name'] . '</span>' . $item['after_html']
			. '</a>' . $child_html . '</li>';
	}

	return $html;
}

function doc_generate_breadcrumb($menu_item, $no_display_1_depth=true)
{
	$html = '';
	if ( !empty($menu_item) && is_array($menu_item) ) {
		if ( isset($menu_item['_parent']) && sizeof($menu_item['_parent']) > 0 ) {
			$html .= doc_generate_breadcrumb($menu_item['_parent'], $no_display_1_depth);
		}

		if ( $no_display_1_depth && $menu_item['parent_menu_id'] < 1 ) return $html;

		$html .= sprintf('<a href="%s" class="breadcrumb-item">%s</a>' . PHP_EOL, $menu_item['link'], $menu_item['name']);
	}

	return $html;
}
