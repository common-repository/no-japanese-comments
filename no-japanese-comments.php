<?php
/*

**************************************************************************

Plugin Name:  No Japanese Comments
Plugin URI:   http://www.arefly.com/no-japanese-comments/
Description:  Disallow Japanese Language Comments in Your Blog. 在你的部落格中禁止日文評論
Version:      1.0.7
Author:       Arefly
Author URI:   http://www.arefly.com/
Text Domain:  no-japanese-comments
Domain Path:  /lang/

**************************************************************************

	Copyright 2014  Arefly  (email : eflyjason@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

**************************************************************************/

define("NO_JAPANESE_COMMENTS_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("NO_JAPANESE_COMMENTS_FULL_DIR", plugin_dir_path( __FILE__ ));
define("NO_JAPANESE_COMMENTS_TEXT_DOMAIN", "no-japanese-comments");

/* Plugin Localize */
function no_japanese_comments_load_plugin_textdomain() {
	load_plugin_textdomain(NO_JAPANESE_COMMENTS_TEXT_DOMAIN, false, dirname(plugin_basename( __FILE__ )).'/lang/');
}
add_action('plugins_loaded', 'no_japanese_comments_load_plugin_textdomain');

include_once NO_JAPANESE_COMMENTS_FULL_DIR."options.php";

/* Add Links to Plugins Management Page */
function no_japanese_comments_action_links($links){
	$links[] = '<a href="'.get_admin_url(null, 'options-general.php?page='.NO_JAPANESE_COMMENTS_TEXT_DOMAIN.'-options').'">'.__("Settings", NO_JAPANESE_COMMENTS_TEXT_DOMAIN).'</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'no_japanese_comments_action_links');

function no_japanese_comments($incoming_comment) {
	$jpattern ='/[ぁ-ん]+|[ァ-ヴ]+/u';
	if(preg_match($jpattern, $incoming_comment['comment_content'])){
		$message = nl2br(get_option("no_japanese_comments_notice"));
		if (get_option("no_japanese_comments_mode") == "ajax") {
			err($message);
		}else{
			header("Content-type: text/html; charset=utf-8");
			wp_die($message);
		}
		exit;
	}
	return($incoming_comment);
}
add_filter('preprocess_comment', 'no_japanese_comments');
