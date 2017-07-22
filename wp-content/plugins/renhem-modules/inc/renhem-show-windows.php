<?php
if ( ! class_exists( 'HN_RENHEM_WINDOWS' ) )
{
    /**
     * Class HN_RENHEM_WINDOWS
     * Uses for business relate to manage windows plugin
     */
    class HN_RENHEM_WINDOWS
    {
        /**
         * Constructor of class
         */
        function __construct()
        {
//            add_action( 'bsv2_header', array( $this, 'register_styles' ), 5 );
            add_action( 'before_end_frontpage_main_content', array( $this, 'window_popup' ), 5 );
            add_action( 'bsv2_footer', array( $this, 'register_scripts' ), 10 );
        }

        /**
         * Register styles need to use in module
         */
        function register_styles()
        {

        }

        /**
         * Display popup contains all windows
         */
        function window_popup()
        {
            echo do_shortcode('[display_windows]');
        }

        /**
         * enqueue scripts
         */
        function register_scripts()
        {
            $scripts_source = sprintf( '%s?v=%s', RM_JS_URL . 'scripts.js', RM_VERSION );
        ?>
            <script type="text/javascript" src="<?php echo $scripts_source; ?>"></script>
        <?php
        }
    }
    new HN_RENHEM_WINDOWS;
}