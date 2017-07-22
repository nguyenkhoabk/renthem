<?php
/**
    Plugin Name: Wordpress Opinion Review
    Plugin URI:
    Description: a plugin to wordpress that the customers can insert their comments/opinion
    Version: 1.3.4
    Author: HanoiSoftware
 */
define( 'WOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WOR_INC_PATH', trailingslashit( WOR_PATH . 'inc' ) );
define( 'WOR_FUNCTION_PATH', trailingslashit( WOR_INC_PATH . 'functions' ) );

define( 'WOR_URL', plugin_dir_url( __FILE__ ) );
define( 'WOR_CSS_URL', trailingslashit( WOR_URL . 'css' ) );
define( 'WOR_JS_URL', trailingslashit( WOR_URL . 'js' ) );
define( 'WOR_IMAGES_URL', trailingslashit( WOR_URL . 'images' ) );

require WOR_INC_PATH . 'wor-setup.php';
require WOR_FUNCTION_PATH . 'shortcodes.php';
require WOR_INC_PATH . 'wor-review.php';

if( is_admin() )
{
    require WOR_FUNCTION_PATH . 'hn-wor-settings-page.php';
}
require WOR_FUNCTION_PATH . 'wor-tab-slide.php';
