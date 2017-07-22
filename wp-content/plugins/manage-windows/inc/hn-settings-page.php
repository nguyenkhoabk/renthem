<?php
/**
 * Settings Page
 */

if ( ! class_exists( 'HN_SETTINGS_PAGE' ) )
{
	class HN_SETTINGS_PAGE
	{
		function __construct()
		{
			add_action( 'admin_menu', array( $this, 'add_sub_menu' ) );
			// Register settings
			add_action( 'admin_init', array( $this, 'register_settings' ) );
		}

		function  add_sub_menu()
		{
			add_submenu_page(
				'edit.php?post_type=fonsterputs',
				__( 'Settings', 'mw' ),
				__( 'Settings', 'mw' ),
				'manage_options',
				'mw_settings',
				array( $this,  'settings_page')
			);
		}

		/*
		 * Register settings field
		 * void
		 * */

		function register_settings()
		{
			// Add new section to Settings page
			add_settings_section( 'mw_section_price', __( 'Setting Price', 'mw' ), array( $this, 'setting_section_callback' ), 'mw_settings' );
            add_settings_section( 'mw_section_sort_widow', __( 'Sorting', 'mw' ), array( $this, 'setting_section_callback' ), 'mw_settings' );
			// Add new field to setting_price section and sorting section
			add_settings_field( 'start_price', __( 'Start Price', 'mw' ), array( $this, 'setting_field_price_callback' ), 'mw_settings', 'mw_section_price' );
            add_settings_field( 'sorting_windows', __( '', 'mw' ), array( $this, 'setting_sorting_field_callback' ), 'mw_settings', 'mw_section_sort_widow' );
			// Register settings
			register_setting( '_mw_sorting_windows', '_start_price' );
            register_setting( '_mw_sorting_windows', '_mw_sorting_windows' );
		}

		function setting_section_callback()
		{
			?>
			<?php
		}

		function setting_field_price_callback()
		{
			$price = get_option( '_start_price' );
		?>
			<input name="_start_price" type="text" id="start_price" value="<?php echo $price; ?>" class="regular-text">
		<?php
		}

        function setting_sorting_field_callback()
        {
	        $window_order = array();
	        if ( get_option( '_mw_sorting_windows' )  )
	        {
		        $window_order = get_option( '_mw_sorting_windows' );
		        $window_order = array_map( 'intval', $window_order );
	        }
            // get all windows
            $args = array(
                'post_type'         => 'fonsterputs',
                'posts_per_page'    =>  -1,
	            'orderby'           =>  'post__in',
	            'post__in'          =>  $window_order
            );
            $my_query = new WP_Query( $args );
            ?>
            <ul id="mw-sortable">
            <?php
                if( $my_query->have_posts() ) :
                    while( $my_query->have_posts() ) : $my_query->the_post();
                    ?>
                    <li class="mw-window-item"><?php echo get_the_title(); ?><input type="hidden" name="_mw_sorting_windows[]" value="<?php echo get_the_ID(); ?>"></li>
                    <?php
                    endwhile;
                endif;
            ?>
	            <li class="mw-clear"></li>
            </ul>
            <?php
        }


		function settings_page()
		{
		?>
			<form  method="post" action="options.php">
				<h1><?php echo __( 'Settings Page', 'mw' ); ?></h1>
				<?php settings_fields( '_mw_start_price' ) ?>
                <?php  settings_fields( '_mw_sorting_windows' ) ?>
				<?php do_settings_sections( 'mw_settings' ); ?>
				<?php submit_button(); ?>
			</form>
		<?php
		}
	}
	new HN_SETTINGS_PAGE;
}
