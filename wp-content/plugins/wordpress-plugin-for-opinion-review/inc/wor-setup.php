<?php
if( ! class_exists( 'WOR_SETUP' ) )
{
    /*
     * Class register post type, enqueue script, style and other components for plugin
     *
     * */
    class WOR_SETUP
    {
        function __construct()
        {
            // register post type
            add_action( 'init', array( $this, 'register_renew_post_type' ) );
            // add meta box
            add_action( 'add_meta_boxes', array( $this, 'review_meta_boxes' ) );
            // save meta box
            add_action( 'save_post', array( $this, 'save_review_meta_boxes' ) );
            // hide add new review sub menu
            add_action('admin_menu', array( $this, 'hide_add_new_review' ) );
            // enqueue style, script
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            // enqueue admin style, script
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

        }

        /*
         * Register review post type
         * @return void
         * */
        function register_renew_post_type()
        {
            // Question

            $labels = array(
                'name'                => _x( 'Review', 'Post Type General Name', 'wor' ),
                'singular_name'       => _x( 'Review', 'Post Type Singular Name', 'wor' ),
                'menu_name'           => __( 'Reviews', 'wor' ),
                'parent_item_colon'   => __( 'Parent Review:', 'wor' ),
                'all_items'           => __( 'All Reviews', 'wor' ),
                'view_item'           => __( 'View Review', 'wor' ),
                'add_new_item'        => __( 'Add New Review', 'wor' ),
                'add_new'             => __( 'New Review', 'wor' ),
                'edit_item'           => __( 'Edit Review', 'wor' ),
                'update_item'         => __( 'Update Review', 'wor' ),
                'search_items'        => __( 'Search Review', 'wor' ),
                'not_found'           => __( 'No review found', 'wor' ),
                'not_found_in_trash'  => __( 'No review found in Trash', 'wor' ),
            );
            $args = array(
                'labels'    => $labels,
                'public'    => true,
                'menu_icon' => 'dashicons-star-filled',
                'supports'  => array( 'title', 'thumbnail', 'editor' ),
            );
            register_post_type( 'review', $args );

        }

        /*
         * Register meta boxed: first name, last name, city, rating
         * @return void
         * */
        function review_meta_boxes()
        {
            $screen = 'review';
            add_meta_box( 'wor_review_meta', __( 'Information', 'wor' ), array( $this, 'meta_information' ), $screen );
            add_meta_box( 'wor_review_admin_comment_meta', __( 'Admin comment', 'wor' ), array( $this, 'meta_admin_comment' ), $screen );
        }
        /*
         *  Display meta boxes information
         * @return void
         * */
        function meta_information( $post )
        {
            $metas = get_post_meta( $post->ID, '_wor_review_metas', true );
        ?>
            <div class="admin-mor-rating" data-score="<?php echo $metas['rating']; ?>"></div><span id="mor-rating-text" class="wor-meta-label"></span>
            <div>
                <label><?php _e( 'First Name: ', 'wor' ); ?></label><label class="wor-meta-label"><?php echo $metas['first_name']; ?></label>
            </div>
            <div>
                <label><?php _e( 'Last Name: ', 'wor' ); ?></label><label class="wor-meta-label"><?php echo $metas['last_name']; ?></label>
            </div>
            <div>
                <label><?php _e( 'City: ', 'wor' ); ?></label><label class="wor-meta-label"><?php echo $metas['city']; ?></label>
            </div>
        <?php
        }
        /*
         *  Display textarea let admin input his comment
         *  @param WP_POST $post The object for the current post/page
         */
        function meta_admin_comment( $post )
        {
            $metas = get_post_meta( $post->ID, '_wor_review_metas', true );
            $admin_comment = $metas['comment'];
            wp_nonce_field( 'wor_save_admin_comment', 'wor_save_admin_comment_nonce' );
        ?>
            <textarea name="wor_admin_comment" class="wor-admin-field" rows="5"><?php echo $admin_comment; ?></textarea>
        <?php
        }
        /*
         * Save meta box
         * @param int $post_id the ID of the post is being saved
         */
        function save_review_meta_boxes( $post_id )
        {
            /*
             * We need to verify this came from our screen and with proper authorization,
             * because the save_post action can be triggered at other times.
             */
                // Check if our nonce is set.
            if ( isset( $_POST['wor_save_admin_comment_nonce'] ) && wp_verify_nonce( $_POST['wor_save_admin_comment_nonce'], 'wor_save_admin_comment' ) ) 
            {
                // If this is an autosave, our form has not been submitted, so we don't want to do anything.
                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
                {
                    return;
                }
                // get current post meta
                $metas = get_post_meta( $post_id, '_wor_review_metas', true );
                $admin_comment = $_POST['wor_admin_comment'];
                $metas['comment'] = $admin_comment;
                $metas['time_comment'] = date( 'Y-m-d' );
                update_post_meta( $post_id, '_wor_review_metas', $metas );
            }
        }
        /*
         * Hide add new review
         * @return void
         * */
        function hide_add_new_review()
        {
            global $submenu;

            unset($submenu['edit.php?post_type=review'][10]);
        }

        /*
         * Enqueue file style, js
         * @return void
         * */
        function enqueue_scripts()
        {
            // main style
            wp_enqueue_style( 'wor-style', WOR_CSS_URL . 'style.css' );
            // rating style
            wp_enqueue_style( 'wor-rating-style', WOR_CSS_URL . 'jquery.raty.css' );
            // rating script
            wp_enqueue_script( 'wor-rating-script', WOR_JS_URL . 'jquery.raty.js', array( 'jquery' ), '1.0.0', true );
            // Plugin's script
            // Locallize script
            $script_data = array(
                'imgUrl' => WOR_IMAGES_URL,
            );
            wp_register_script( 'wor-scripts', WOR_JS_URL . 'script.js', array( 'jquery' ), '1.0.0', true );
            wp_localize_script( 'wor-scripts', 'WOR', $script_data );
            wp_enqueue_script( 'wor-scripts' );
            // Enqueue validation script
            wp_enqueue_script( 'wor-validate-script', WOR_JS_URL . 'validation.js', array( 'jquery' ), '1.0.0', true );
	        // Load simple popup script
	        wp_enqueue_script( 'wor-popup-script', WOR_JS_URL . 'jquery.popup.min.js', array( 'jquery' ), '1.0.0', true );
        }

        /*
         * Enqueue stylesheet, scripts
         * @return void
         * */
        function admin_scripts()
        {
            // main style
            wp_enqueue_style( 'wor-admin-style', WOR_CSS_URL . 'admin.css' );
            // rating style
            wp_enqueue_style( 'wor-rating-style', WOR_CSS_URL . 'jquery.raty.css' );
            // rating script
            wp_enqueue_script( 'wor-rating-script', WOR_JS_URL . 'jquery.raty.js', array( 'jquery' ), '1.0.0', true );
            // Plugin's script
            // Locallize script
            $script_data = array(
                'imgUrl' => WOR_IMAGES_URL,
            );
            wp_register_script( 'wor-admin-scripts', WOR_JS_URL . 'admin-script.js', array( 'jquery' ), '1.0.0', true );
            wp_localize_script( 'wor-admin-scripts', 'WOR', $script_data );
            wp_enqueue_script( 'wor-admin-scripts' );
        }
    }
    new WOR_SETUP;
}