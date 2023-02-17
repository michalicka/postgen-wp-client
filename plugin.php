<?php
/*
Plugin Name: Postgen WP Client
Plugin URI: https://github.com/michalicka/postgen-wp-client
Description: A Wordpress plugin client providing API for PostGen AI publisher.
Author: Jan Michalicka
Author URI: http://www.janmichalicka.com
Version: 1.0
*/

define('PGWC_PLUGIN_DIR', str_replace('\\','/',dirname(__FILE__)));
require_once(PGWC_PLUGIN_DIR.'/options.php');

function pgwc_menu() {
  add_options_page('Postgen Client', 'Postgen Client', 8, __FILE__, 'pgwc_options');
}

add_action('admin_menu', 'pgwc_menu');

