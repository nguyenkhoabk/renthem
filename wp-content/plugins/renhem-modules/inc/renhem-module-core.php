<?php
if( ! class_exists( 'RM_MODULES_CORE' ) )
{
    /**
     * Class RM_MODULES_CORE
     * Register main element in plugin
     */
    class RM_MODULES_CORE
    {
        /**
         * Contructor for class
         */
        function __construct()
        {
            add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
        }

        /**
         * Enqueue script, stylesheet element on front-end
         */
        function scripts()
        {
            wp_enqueue_style( 'rm-main-style', RM_CSS_URL . 'style.css', array(), RM_VERSION );
            wp_enqueue_script( 'rm-main-script', RM_JS_URL . 'scripts.js', array(), RM_VERSION, true );
        }
    }
    new RM_MODULES_CORE;
}