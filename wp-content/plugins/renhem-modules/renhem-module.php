<?php
/**
Plugin Name: Renhem Modules
Plugin URI:
Description: a plugin to contains modules use for tasks
Version: 1.1.1
Author: HanoiSoftware
 */

define( 'RM_DIR', plugin_dir_path( __FILE__ ) );
define( 'RM_INC_DIR', trailingslashit( RM_DIR . 'inc' ) );

define( 'RM_URL', plugin_dir_url( __FILE__ ) );
define( 'RM_CSS_URL', trailingslashit( RM_URL . 'css' ) );
define( 'RM_JS_URL', trailingslashit( RM_URL . 'js' ) );

define( 'RM_VERSION', '1.1.1' );

if( ! is_admin() )
{
    require RM_INC_DIR . 'renhem-module-core.php';
}

require RM_INC_DIR . 'functions/shortcodes.php';
require RM_INC_DIR . 'renhem-show-windows.php';