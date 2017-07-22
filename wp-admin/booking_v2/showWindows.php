<?php
if( ! class_exists( 'BSV_WINDOWS' ) )
{
    /**
     * Class BSV_WINDOWS
     * Display list windows in plugin Manage Windows
     */
    class BSV_WINDOWS
    {
        /**
         * Class constructor
         */
        function __construct()
        {
            // display windows
            add_action( 'bv2_end_book_wrap', array( $this, 'list_windows' ) );
            // enqueue style and scripts
            add_action( 'bsv2_footer', array( $this, 'register_scripts' ), 10 );
        }

        /**
         * Show Windows
         */

        function list_windows()
        {
            // fonsterputs
            $window_order = array();
            if ( get_option( '_mw_sorting_windows' )  )
            {
                $window_order = get_option( '_mw_sorting_windows' );
                $window_order = array_map( intval, $window_order );
                $list_ids = implode( ',', $window_order );
            }
            $b_posts = new BS_POSTS();
            $list_windows = $b_posts->getPosts( "*", "ID IN (" . $list_ids . ") ORDER BY FIELD( ID, " . $list_ids . " ) " );
            ?>
            <div class="bs-windows-container modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="container">
                            <div class="bs-row">
                                <div class="seletected-windows">
                                    <input type="hidden" name="window-selected-ids" id="window-selected-ids">
                                    <h4>Selected Windows</h4>
                                    <input type="text" name="window-selected-titles" id="window-selected-titles">
                                </div>
                            </div> <!-- end .rm-row -->
                            <div class="bs-row">
                                <?php
                                foreach( $list_windows as $window )
                                {
                                    $window_id = intval( $window['ID'] );
                                    $pMeta = new BS_POST_META();
                                    $thumbnail = $pMeta->getThePostThumbnail( $window_id );
                                    ?>
                                    <div class="rm-window sm-col">
                                        <img title="<?php echo $window['post_title']; ?>" src="<?php echo $thumbnail; ?>">
                                        <div class="window-name">
                                            <label><?php echo $window['post_title']; ?><br /><input type="checkbox" id="window-id-<?php echo $window_id; ?>" value="<?php echo $window_id; ?>"></label>
                                            <input type="hidden" name="window-title" id="window-title-<?php echo $window_id; ?>" value="<?php echo $window['post_title']; ?>">
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="clear"></div>
                            </div> <!-- end .rm-row -->
                            <div class="bs-row">
                                <div class="button-control-container">
                                    <input type="button" class="btn b-save submitbtn" value="Select">
                                    <input type="button" class="btn b-cancel closebtn" value="Cancel">
                                </div>
                            </div> <!-- end .rm-row -->
                        </div> <!-- end .container -->
                    </div> <!-- end .modal-content -->
                </div> <!-- end .modal-dialog -->

            </div>  <!-- end .rm-windows-container -->
        <?php
        }

        /**
         * Output scripts
         */
        function register_scripts()
        {
            $script_source = 'js/scripts.js';
        ?>
            <script type="text/javascript" src="<?php echo $script_source; ?>"></script>
        <?php
        }
    }
    new BSV_WINDOWS;
}
