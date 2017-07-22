<?php
/**
 * Class setup the components for plugin
 */

if ( ! class_exists( 'MW_SETUP' ) )
{
	class MW_SETUP
	{
		function __construct()
		{
			// register post type
			add_action( 'init', array( $this, 'register_window_post_type' ) );
            add_action( 'init', array( $this, 'register_window_category' ) );
			// remove quick edit on mw_order post tyoe
			add_filter( 'post_row_actions', array( $this, 'remove_row_actions' ), 10, 2 );
            // enqueue scripts
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            // enqueue scripts in admin page
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		}

		function remove_row_actions( $actions, $post )
		{
			global $current_screen;
			if( $current_screen->post_type != 'mw_order' ) return $actions;
			unset( $actions['edit'] );
			unset( $actions['view'] );
//			unset( $actions['trash'] );
			unset( $actions['inline hide-if-no-js'] );
			//$actions['inline hide-if-no-js'] .= __( 'Quick&nbsp;Edit' );

			return $actions;
		}

		function register_window_post_type()
		{
			// Window

			$labels = array(
				'name'                => _x( 'Window', 'Post Type General Name', 'mw' ),
				'singular_name'       => _x( 'Window', 'Post Type Singular Name', 'mw' ),
				'menu_name'           => __( 'Windows', 'mw' ),
				'parent_item_colon'   => __( 'Parent Window:', 'mw' ),
				'all_items'           => __( 'All Windows', 'mw' ),
				'view_item'           => __( 'View Window', 'mw' ),
				'add_new_item'        => __( 'Add New Window', 'mw' ),
				'add_new'             => __( 'New Window', 'mw' ),
				'edit_item'           => __( 'Edit Window', 'mw' ),
				'update_item'         => __( 'Update Window', 'mw' ),
				'search_items'        => __( 'Search Window', 'mw' ),
				'not_found'           => __( 'No window found', 'mw' ),
				'not_found_in_trash'  => __( 'No window found in Trash', 'mw' ),
			);
			$args = array(
				'labels'    => $labels,
				'public'    => true,
				'menu_icon' => 'dashicons-grid-view',
				'supports'  => array( 'title', 'thumbnail', 'editor' ),
			);
			register_post_type( 'fonsterputs', $args );

			// Order

			$labels = array(
				'name'                => _x( 'Order', 'Post Type General Name', 'mw' ),
				'singular_name'       => _x( 'Order', 'Post Type Singular Name', 'mw' ),
				'menu_name'           => __( 'Orders', 'mw' ),
				'parent_item_colon'   => __( 'Parent Order:', 'mw' ),
				'all_items'           => __( 'All Orders', 'mw' ),
				'view_item'           => __( 'View Order', 'mw' ),
				'add_new_item'        => __( 'Add New Order', 'mw' ),
				'add_new'             => __( 'New Order', 'mw' ),
				'edit_item'           => __( 'Edit Order', 'mw' ),
				'update_item'         => __( 'Update Order', 'mw' ),
				'search_items'        => __( 'Search Order', 'mw' ),
				'not_found'           => __( 'No order found', 'mw' ),
				'not_found_in_trash'  => __( 'No order found in Trash', 'mw' ),
			);
			$args = array(
				'labels'    => $labels,
				'public'    => true,
				'menu_icon' => 'dashicons-heart',
				'supports'  => false,
				'capabilities' => array(
					'create_posts' => false, // Removes support for the "Add New" function
				),
				'map_meta_cap' => true,
				'show_in_menu' => 'edit.php?post_type=fonsterputs',
			);
			register_post_type( 'mw_order', $args );

		}

        /**
         * Function register collection taxonomy
         */
        function register_window_category()
        {
            register_taxonomy( 'mw_window_category',
                'fonsterputs',
                apply_filters( 'wpfss_taxonomy_args_window_category', array(
                    'hierarchical'          => true,
                    'label'                 => __( 'Categories', 'mw' ),
                    'labels' => array(
                        'name'              => __( 'Window Categories', 'mw' ),
                        'singular_name'     => __( 'Window Category', 'mw' ),
                        'menu_name'         => _x( 'Categories', 'Admin menu name', 'mw' ),
                        'search_items'      => __( 'Search Window Categories', 'mw' ),
                        'all_items'         => __( 'All Window Categories', 'mw' ),
                        'parent_item'       => __( 'Parent Window Category', 'mw' ),
                        'parent_item_colon' => __( 'Parent Window Category:', 'mw' ),
                        'edit_item'         => __( 'Edit Window Category', 'mw' ),
                        'update_item'       => __( 'Update Window Category', 'mw' ),
                        'add_new_item'      => __( 'Add New Window Category', 'mw' ),
                        'new_item_name'     => __( 'New Case Window Name', 'mw' ),
                        'not_found'         => __( 'No Case Window found', 'mw' ),
                    ),
                    'show_ui'               => true,
                    'query_var'             => true,
                    'rewrite'               => array(
                        'slug'         => 'mw-windows-category',
                    ),
                ) )
            );
        }

        function enqueue_scripts()
        {
	        // Main style
            wp_enqueue_style( 'mw-style-css', MW_CSS_URL . 'style.css' );
	        // datetimepicker style
	        wp_enqueue_style( 'mw-datetimepicker', MW_CSS_URL . 'jquery.datetimepicker.css' );
	        // Update price when the amount of product is changed
	        wp_enqueue_script( 'mw-update-price-script', MW_JS_URL . 'update-total-price.js', array( 'jquery' ), '1.0.0', true );
	        // Validate form before make an order
	        wp_enqueue_script( 'mw-validate-form-script', MW_JS_URL . 'validate-form.js', array( 'jquery' ), '1.0.0', true );
	        // Datetimepicker script lib
	        wp_enqueue_script( 'mw-datetimepicker-script-lib', MW_JS_URL . 'jquery.datetimepicker.js', array( 'jquery' ), '1.0.0', true );
	        // Load Datetimepicker
	        wp_enqueue_script( 'mw-datetimepicker-script', MW_JS_URL . 'delivery-time.js', array( 'jquery' ), '1.0.0', true );
            // Load simple popup script
            wp_enqueue_script( 'mw-popup-script', MW_JS_URL . 'jquery.popup.min.js', array( 'jquery' ), '1.0.0', true );
        }

        function admin_scripts()
        {
            wp_enqueue_style( 'mw-admin-style-css', MW_CSS_URL . 'admin.css' );
            wp_enqueue_script( 'mw-sortable-script', MW_JS_URL . 'admin-windows-sortable.js', array( 'jquery', 'jquery-ui-sortable' ), '1.0.0', true );
        }

	}
	new MW_SETUP;
}