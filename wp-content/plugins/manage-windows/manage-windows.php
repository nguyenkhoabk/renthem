<?php
/**
 * Plugin Name: Manage Windows
 * Author: Hanoi Software
 * Description: Plugin same as Woocommerce for Norbert
 * Version: 1.3.0
 * License: GPL
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

define( 'MW_PATH', plugin_dir_path( __FILE__ ) );
define( 'MW_INC_PATH', trailingslashit( MW_PATH . 'inc' ) );
define( 'MW_TEMPLATES_PATH', trailingslashit( MW_PATH . 'templates' ) );
define( 'MW_SHORTCODES_PATH', trailingslashit( MW_PATH . 'shortcodes' ) );

define( 'MW_URL', plugin_dir_url( __FILE__ ) );
define( 'MW_CSS_URL', trailingslashit( MW_URL . 'css' ) );
define( 'MW_JS_URL', trailingslashit( MW_URL . 'js' ) );
define( 'MW_IMAGES_URL', trailingslashit( MW_URL . 'images' ) );

require MW_INC_PATH . 'mw-setup.php';
if ( is_admin() )
{
	require MW_INC_PATH . 'mw-metaboxes.php';
	require MW_INC_PATH . 'hn-settings-page.php';
    require MW_INC_PATH . 'mw-columns.php';
}
require MW_SHORTCODES_PATH . 'mw-shortcode.php';
require MW_INC_PATH . 'mw-place-order.php';

// Register image size
add_image_size( 'mw-small-thumbnail', 90, 90 );

//load text domain

add_action( 'plugins_loaded', 'mw_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function mw_load_textdomain()
{
	load_plugin_textdomain( 'mw', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}