<?php
/**
 * Settings Page
 */

if ( ! class_exists( 'HN_WOR_SETTINGS_PAGE' ) )
{
	class HN_WOR_SETTINGS_PAGE
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
				'options-general.php',
				__( 'Tab Slide Out Setting', 'wor' ),
                __( 'Tab Slide Out Setting', 'wor' ),
				'manage_options',
				'wor_settings',
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
			add_settings_section( 'wor_section_tab', __( '', 'wor' ), array( $this, 'setting_section_callback' ), 'wor_settings' );
			// Add new field to setting_price section and sorting section
            add_settings_field( 'wor_display_tab_slide', __( 'Display tab slide', 'wor' ), array( $this, 'setting_field_display_tab_slide_callback' ), 'wor_settings', 'wor_section_tab' );
			add_settings_field( 'wor_number_post', __( 'The number posts are displayed on tab', 'wor' ), array( $this, 'setting_field_number_post_callback' ), 'wor_settings', 'wor_section_tab' );
            add_settings_field( 'wor_number_link_to_page', __( 'Url link to list reviews page', 'wor' ), array( $this, 'setting_url_callback' ), 'wor_settings', 'wor_section_tab' );
			// Register settings
            register_setting( '_wor_tab_slide', '_wor_tab_slide' );
		}

		function setting_section_callback()
		{
			?>
			<?php
		}

        function setting_field_display_tab_slide_callback()
        {
            $options = get_option( '_wor_tab_slide' );
            ?>
            <input name="_wor_tab_slide[show]" type="checkbox" id="_wor_display_tab_slide" value="yes" <?php checked( $options['show'], 'yes' ); ?>>
        <?php
        }

		function setting_field_number_post_callback()
		{
            $options = get_option( '_wor_tab_slide' );

		?>
			<input name="_wor_tab_slide[number]" type="text" value="<?php echo $options['number'] == '' ? 3 : $options['number']; ?>" class="regular-text">
		<?php
		}

        function setting_url_callback()
        {
            $options = get_option( '_wor_tab_slide' );
        ?>
            <input name="_wor_tab_slide[url]" type="text" id="_wor_url" value="<?php echo $options['url']; ?>" class="regular-text">
        <?php
        }

		function settings_page()
		{
		?>
			<form  method="post" action="options.php">
				<h1><?php echo __( 'Settings Page', 'wor' ); ?></h1>
                <?php settings_fields( '_wor_tab_slide' ); ?>
				<?php do_settings_sections( 'wor_settings' ); ?>
				<?php submit_button(); ?>
			</form>
		<?php
		}
	}
	new HN_WOR_SETTINGS_PAGE;
}
