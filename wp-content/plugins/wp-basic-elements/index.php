<?php
/**
* Plugin Name: WP Basic Elements
* Plugin URI: -
* Description: Disable unnecessary features and speed up your site. Make the WP Admin simple and clean. <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=DYLYJ242GX64J&lc=SE&item_name=WP%20Basic%20Elements&item_number=Support%20Open%20Source&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted" target="_blank">Donate</a>
* Version: 4.0.2
* Author: Damir Calusic
* Author URI: https://www.damircalusic.com/
* License: GPLv2
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/ 

/*  Copyright (C) 2014  Damir Calusic (email : damir@damircalusic.com)
	
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU general Public License, version 2, as 
	published by the Free Software Foundation.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU general Public License for more details.
	
	You should have received a copy of the GNU general Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('WBE_VERSION', '4.0.2');

load_plugin_textdomain('wpbe', false, basename( dirname( __FILE__ ) ) . '/languages');

add_action('admin_menu', 'wpb_elements');

function wpb_elements() {
	add_action('admin_init', 'register_wpb_settings');
	add_submenu_page('options-general.php', 'WPB Elements', 'WPB Elements', 'manage_options', 'wpb_settings_page', 'wpb_settings_page');
}

function register_wpb_settings() {
	register_setting('wpb-settings-group', 'wpbe_turn_off_updates');
	register_setting('wpb-settings-group', 'wpbe_turn_on_gzip');
	register_setting('wpb-settings-group', 'wpbe_disable_emojis');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_rss');
	register_setting('wpb-settings-group', 'wpbe_disable_rsd');
	register_setting('wpb-settings-group', 'wpbe_remove_manifest_link');
	register_setting('wpb-settings-group', 'wpbe_remove_meta_generator');
	register_setting('wpb-settings-group', 'wpbe_remove_meta_generator_qtranslate');
	register_setting('wpb-settings-group', 'wpbe_remove_index_rel_link');
	register_setting('wpb-settings-group', 'wpbe_remove_prev_link');
	register_setting('wpb-settings-group', 'wpbe_remove_start_link');
	register_setting('wpb-settings-group', 'wpbe_remove_adjacent_links');
	register_setting('wpb-settings-group', 'wpbe_remove_short_link');
	register_setting('wpb-settings-group', 'wpbe_remove_pings');
	register_setting('wpb-settings-group', 'wpbe_remove_canonical');
	register_setting('wpb-settings-group', 'wpbe_remove_screen_options');
	register_setting('wpb-settings-group', 'wpbe_remove_help_link');
	register_setting('wpb-settings-group', 'wpbe_remove_welcome_panel');
	register_setting('wpb-settings-group', 'wpbe_remove_activity_dashboard');
	register_setting('wpb-settings-group', 'wpbe_remove_quick_press_dashboard');
	register_setting('wpb-settings-group', 'wpbe_remove_ataglance_dashboard');
	register_setting('wpb-settings-group', 'wpbe_remove_wpnews_dashboard');
	register_setting('wpb-settings-group', 'wpbe_remove_yoast_seo_dashboard');
	register_setting('wpb-settings-group', 'wpbe_remove_woocoomerce_reviews_dasbhoard');
	register_setting('wpb-settings-group', 'wpbe_remove_dashboard_wpzoom');
	register_setting('wpb-settings-group', 'wpbe_remove_bbpress_right_now');
	register_setting('wpb-settings-group', 'wpbe_remove_spm_dashboard');
	register_setting('wpb-settings-group', 'wpbe_remove_layers_addons');
	register_setting('wpb-settings-group', 'wpbe_remove_layers_pro');
	register_setting('wpb-settings-group', 'wpbe_remove_itsec_dashboard');
	register_setting('wpb-settings-group', 'wpbe_add_to_side_menu');
	register_setting('wpb-settings-group', 'wpbe_add_widget_shortcode');
	register_setting('wpb-settings-group', 'wpbe_add_excerpts_shortcode');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_logo');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_new_content');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_sitename');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_customize');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_edit');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_updates');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_search');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_comments');
	register_setting('wpb-settings-group', 'wpbe_remove_w3tc');
	register_setting('wpb-settings-group', 'wpbe_remove_a1s');
	register_setting('wpb-settings-group', 'wpbe_remove_yseo');
	register_setting('wpb-settings-group', 'wpbe_remove_wp_zoom');
	register_setting('wpb-settings-group', 'wpbe_remove_vfb');
	register_setting('wpb-settings-group', 'wpbe_remove_ngg');
	register_setting('wpb-settings-group', 'wpbe_remove_admin_color_scheme');
	register_setting('wpb-settings-group', 'wpbe_remove_aim_contact');
	register_setting('wpb-settings-group', 'wpbe_remove_yahoo_contact');
	register_setting('wpb-settings-group', 'wpbe_remove_jabber_contact');
	register_setting('wpb-settings-group', 'wpbe_remove_gplus_contact');
	register_setting('wpb-settings-group', 'wpbe_admin_footer_left');
	register_setting('wpb-settings-group', 'wpbe_admin_footer_right');
	register_setting('wpb-settings-group', 'wpbe_wp_mail_from_name');
	register_setting('wpb-settings-group', 'wpbe_wp_mail_from');
}

function wpb_settings_page() {
?>
    <form method="post" action="options.php" style="width:98%;color:rgba(128,128,128,1) !important;">
        <?php settings_fields('wpb-settings-group'); ?>
        <?php do_settings_sections('wpb-settings-group'); ?>
        <div id="welcome-panel" class="welcome-panel">
            <label style="position:absolute;top:5px;right:10px;padding:20px 15px 0 3px;font-size:13px;text-decoration:none;line-height:1;">
            	<?php _e('Version','wpbe'); ?> <?php echo WBE_VERSION; ?>
            </label>
            <div class="welcome-panel-content">
                <h1><?php _e('WP Basic Elements','wpbe'); ?></h1>
                <p class="about-description"><?php _e('With WP Basic Elements you can disable unnecessary features and speed up your site. Make the WP Admin simple and clean. You can activate gzip compression, change admin footers in backend, activate shortcodes in widgets, remove admin toolbar options and you can clean the code markup from unnecessary code snippets like WordPress generator meta tag and a bunch of other non important code snippets in the code. Cleaning the code markup will speed up your sites loadtime and increase the overall performance.','wpbe'); ?></p>
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h4><?php _e('Quick Info','wpbe'); ?></h4>
                        <p><?php _e('When you change something do not forget to click on this blue Save Changes button below this text.','wpbe'); ?></p>
                        <p class="submit">
                        	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','wpbe'); ?>">
                       	</p>
                    </div>
                    <div class="welcome-panel-column">
                    	<h4><?php _e('Quick Tip','wpbe'); ?></h4>
                    	<p><?php _e('Follow me on Twitter to keep up with the latest updates and if you want you can donate to support open source. Just click on the buttons below to choose what you want to do.','wpbe'); ?></p>
                        <p class="submit">
                        	<a class="button button-secondary" href="https://twitter.com/damircalusic/" target="_blank">
                           		<?php _e('FOLLOW ON TWITTER','wpbe'); ?>
                        	</a>
                        	<a class="button button-secondary" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=DYLYJ242GX64J&lc=SE&item_name=WP%20Basic%20Elements&item_number=Support%20Open%20Source&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted" target="_blank">
                           		<?php _e('DONATE TO SUPPORT','wpbe'); ?>
                        	</a>
                     	</p>
                     </div>
                    <div class="welcome-panel-column welcome-panel-last"></div>
                </div>
            </div>
        </div>
        
        <div id="dashboard-widgets-wrap">
        	<div id="dashboard-widgets" class="metabox-holder">
            	
                <div id="postbox-container-1" class="postbox-container">
                    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    
                    	<div id="wpcore" class="postbox">
                        	<button type="button" class="handlediv button-link" aria-expanded="true"><span class="toggle-indicator" data-src="wpcore" aria-hidden="true"></span></button>
                        	<h2 class="hndle ui-sortable-handle"><span><?php _e('WP Core','wpbe'); ?></span></h2>
							<div class="inside">
								<div class="main">
                                    <ul>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_add_to_side_menu" value="1" <?php echo checked(1, get_option('wpbe_add_to_side_menu'), false); ?> />
                                                <?php _e('Add shortcut for WPB Elements in sidebar menu','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_turn_on_gzip" value="1" <?php echo checked(1, get_option('wpbe_turn_on_gzip'), false); ?> />
                                                <?php _e('Enable gzip compression (ob_start(\'ob_gzhandler\') used)','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_turn_off_updates" value="1" <?php echo checked(1, get_option('wpbe_turn_off_updates'), false); ?> />
                                                <?php _e('Disable Plugins, WordPress and Themes update notifications for non-admins.','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_disable_emojis" value="1" <?php echo checked(1, get_option('wpbe_disable_emojis'), false); ?> />
                                                <?php _e('Disable Emoji icons if not in use.','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_add_widget_shortcode" value="1" <?php echo checked(1, get_option('wpbe_add_widget_shortcode'), false); ?> />
                                                <?php _e('Enable shortcode in widgets','wpbe'); ?>
                                            </label>
                                        </li>
                                         <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_add_excerpts_shortcode" value="1" <?php echo checked(1, get_option('wpbe_add_excerpts_shortcode'), false); ?> />
                                                <?php _e('Enable shortcode in manual excerpts','wpbe'); ?>
                                            </label>
                                        </li>
                                    </ul>
                                 </div>
                          	</div>
						</div>
                        
                        <div id="wpoptimisation" class="postbox">
                        	<button type="button" class="handlediv button-link" aria-expanded="true"><span class="toggle-indicator" data-src="wpoptimisation" aria-hidden="true"></span></button>
                        	<h2 class="hndle ui-sortable-handle"><span><?php _e('WP Optimisation','wpbe'); ?></span></h2>
							<div class="inside">
								<div class="main">
                                	<p><?php _e('Disable features from the wp_head() function and make your code cleaner.','wpbe'); ?></p>
                                    <ul>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_rss" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_rss'), false); ?> />
                                                <?php _e('Remove Post, Comment and Category feeds','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_disable_rsd" value="1" <?php echo checked(1, get_option('wpbe_disable_rsd'), false); ?> />
                                                <?php _e('Remove EditURI link','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_manifest_link" value="1" <?php echo checked(1, get_option('wpbe_remove_manifest_link'), false); ?> />
                                                <?php _e('Remove Windows Live Writer Manifest File','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_meta_generator" value="1" <?php echo checked(1, get_option('wpbe_remove_meta_generator'), false); ?> />
                                                <?php _e('Remove WordPress &amp; WooCommerce generator Meta Tag','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_meta_generator_qtranslate" value="1" <?php echo checked(1, get_option('wpbe_remove_meta_generator_qtranslate'), false); ?> />
                                                <?php _e('Remove qTranslate-X generator Meta Tag','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_index_rel_link" value="1" <?php echo checked(1, get_option('wpbe_remove_index_rel_link'), false); ?> />
                                                <?php _e('Remove Index link','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_prev_link" value="1" <?php echo checked(1, get_option('wpbe_remove_prev_link'), false); ?> />
                                                <?php _e('Remove Prev link','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_start_link" value="1" <?php echo checked(1, get_option('wpbe_remove_start_link'), false); ?> />
                                                <?php _e('Remove Start link','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_adjacent_links" value="1" <?php echo checked(1, get_option('wpbe_remove_adjacent_links'), false); ?> />
                                                <?php _e('Remove Relational links for the Posts','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_short_link" value="1" <?php echo checked(1, get_option('wpbe_remove_short_link'), false); ?> />
                                                <?php _e('Remove WordPress shortlink','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_pings" value="1" <?php echo checked(1, get_option('wpbe_remove_pings'), false); ?> />
                                                <?php _e('Remove WordPress Pingbacks','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_canonical" value="1" <?php echo checked(1, get_option('wpbe_remove_canonical'), false); ?> />
                                                <?php _e('Remove canonical link','wpbe'); ?>
                                            </label>
                                        </li>
                                    </ul>
                                    
                                 </div>
                          	</div>
						</div>
                        
                        <div id="wpdashboard" class="postbox">
                        	<button type="button" class="handlediv button-link" aria-expanded="true"><span class="toggle-indicator" data-src="wpdashboard" aria-hidden="true"></span></button>
                        	<h2 class="hndle ui-sortable-handle"><span><?php _e('WP Dashboard','wpbe'); ?></span></h2>
							<div class="inside">
								<div class="main">
                                	<p><?php _e('Disable features from the main WordPress Dashboard and make it a little bit cleaner.','wpbe'); ?></p>
                                    <ul>
                                    	<li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_screen_options" value="1" <?php echo checked(1, get_option('wpbe_remove_screen_options'), false); ?> />
                                                <?php _e('Remove Screen Options from top right corner','wpbe'); ?>
                                            </label>
                                        </li>
                                    	<li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_help_link" value="1" <?php echo checked(1, get_option('wpbe_remove_help_link'), false); ?> />
                                                <?php _e('Remove Help link from top right corner','wpbe'); ?>
                                            </label>
                                        </li>
                                    	<li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_welcome_panel" value="1" <?php echo checked(1, get_option('wpbe_remove_welcome_panel'), false); ?> />
                                                <?php _e('Remove Welcome to WordPress!','wpbe'); ?>
                                            </label>
                                        </li>
                                    	<li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_ataglance_dashboard" value="1" <?php echo checked(1, get_option('wpbe_remove_ataglance_dashboard'), false); ?> />
                                                <?php _e('Remove At a Glance','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_activity_dashboard" value="1" <?php echo checked(1, get_option('wpbe_remove_activity_dashboard'), false); ?> />
                                                <?php _e('Remove Activity','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_quick_press_dashboard" value="1" <?php echo checked(1, get_option('wpbe_remove_quick_press_dashboard'), false); ?> />
                                                <?php _e('Remove Quick Draft','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wpnews_dashboard" value="1" <?php echo checked(1, get_option('wpbe_remove_wpnews_dashboard'), false); ?> />
                                                <?php _e('Remove WordPress News','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_yoast_seo_dashboard" value="1" <?php echo checked(1, get_option('wpbe_remove_yoast_seo_dashboard'), false); ?> />
                                                <?php _e('Remove Yoast SEO Posts Overview','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_woocoomerce_reviews_dasbhoard" value="1" <?php echo checked(1, get_option('wpbe_remove_woocoomerce_reviews_dasbhoard'), false); ?> />
                                                <?php _e('Remove WooCommerce Latest Reviews','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_dashboard_wpzoom" value="1" <?php echo checked(1, get_option('wpbe_remove_dashboard_wpzoom'), false); ?> />
                                                <?php _e('Remove WP-Zoom dasboard','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_bbpress_right_now" value="1" <?php echo checked(1, get_option('wpbe_remove_bbpress_right_now'), false); ?> />
                                                <?php _e('Remove bbPress Right Now','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_spm_dashboard" value="1" <?php echo checked(1, get_option('wpbe_remove_spm_dashboard'), false); ?> />
                                                <?php _e('Remove Simple Personal Message','wpbe'); ?>
                                            </label>
                                        </li>
                                        
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_layers_addons" value="1" <?php echo checked(1, get_option('wpbe_remove_layers_addons'), false); ?> />
                                                <?php _e('Remove Layers addons','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_layers_pro" value="1" <?php echo checked(1, get_option('wpbe_remove_layers_pro'), false); ?> />
                                                <?php _e('Remove Layers Pro','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_itsec_dashboard" value="1" <?php echo checked(1, get_option('wpbe_remove_itsec_dashboard'), false); ?> />
                                                <?php _e('Remove Ithemes Security dashboard widget','wpbe'); ?>
                                            </label>
                                        </li>
                                        
                                    </ul>
                                    
                                 </div>
                          	</div>
						</div>
                
                    </div>
            	</div>
                
                <div id="postbox-container-2" class="postbox-container">
                	<div id="side-sortables" class="meta-box-sortables ui-sortable">
                    	
                        <div id="generellt" class="postbox">
                        	<button type="button" class="handlediv button-link" aria-expanded="true"><span class="toggle-indicator" data-src="generellt" aria-hidden="true"></span></button>
                        	<h2 class="hndle ui-sortable-handle"><span><?php _e('WP Admin Toolbar','wpbe'); ?></span></h2>
							<div class="inside">
								<div class="main">
                                	<p><?php _e('Check the ones you would like to disable in the admin toolbar. You are not going to delete anything instead you will just make your toolbar cleaner and more friendly.','wpbe'); ?></p>
                                    <p><?php _e('Just test and see what happens in the toolbar. If you want anything back just uncheck and it will appear again.','wpbe'); ?></p>
                                    <ul>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_logo" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_logo'), false); ?> />
                                                <?php _e('Remove WP Logo','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_new_content" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_new_content'), false); ?> />
                                                <?php _e('Remove WP New Content','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_sitename" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_sitename'), false); ?> />
                                                <?php _e('Remove WP sitename','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_customize" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_customize'), false); ?> />
                                                <?php _e('Remove WP customize','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_edit" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_edit'), false); ?> />
                                                <?php _e('Remove WP edit','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_updates" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_updates'), false); ?> />
                                                <?php _e('Remove WP Updates','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_comments" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_comments'), false); ?> />
                                                <?php _e('Remove WP Comments','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_search" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_search'), false); ?> />
                                                <?php _e('Remove WP Search','wpbe'); ?>
                                            </label>
                                        </li>
                                    </ul>
                                    <p><strong><?php _e('Plugins (if used)','wpbe'); ?></strong></p>
                                    <ul>    
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_w3tc" value="1" <?php echo checked(1, get_option('wpbe_remove_w3tc'), false); ?> />
                                                <?php _e('Remove W3 Total Cache','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_a1s" value="1" <?php echo checked(1, get_option('wpbe_remove_a1s'), false); ?> />
                                                <?php _e('Remove All in One Seo','wpbe'); ?>
                                            </label>
                                        </li> 
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_yseo" value="1" <?php echo checked(1, get_option('wpbe_remove_yseo'), false); ?> />
                                                <?php _e('Remove Yoast SEO','wpbe'); ?>
                                            </label>
                                        </li> 
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_wp_zoom" value="1" <?php echo checked(1, get_option('wpbe_remove_wp_zoom'), false); ?> />
                                                <?php _e('Remove WP Zoom Framework','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_vfb" value="1" <?php echo checked(1, get_option('wpbe_remove_vfb'), false); ?> />
                                                <?php _e('Remove Visual Form Builder','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_ngg" value="1" <?php echo checked(1, get_option('wpbe_remove_ngg'), false); ?> />
                                                <?php _e('Remove Nextgen Gallery link','wpbe'); ?>
                                            </label>
                                        </li> 
                                    </ul>
                                 </div>
                          	</div>
						</div>
                        
                        <div id="wpusers" class="postbox">
                        	<button type="button" class="handlediv button-link" aria-expanded="true"><span class="toggle-indicator" data-src="wpusers" aria-hidden="true"></span></button>
                        	<h2 class="hndle ui-sortable-handle"><span><?php _e('WP Users','wpbe'); ?></span></h2>
							<div class="inside">
								<div class="main">
                                	<p><?php _e('Disable unnecessary fields that you do not want to display to your users in admin backend.','wpbe'); ?></p>
                                	<ul>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_admin_color_scheme" value="1" <?php echo checked(1, get_option('wpbe_remove_admin_color_scheme'), false); ?> />
                                                <?php _e('Disable Color Scheme selector for users','wpbe'); ?>
                                            </label>

                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_aim_contact" value="1" <?php echo checked(1, get_option('wpbe_remove_aim_contact'), false); ?> />
                                                <?php _e('Disable AIM field from users contact field','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_jabber_contact" value="1" <?php echo checked(1, get_option('wpbe_remove_jabber_contact'), false); ?> />
                                                <?php _e('Disable Jabber field from users contact field','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_yahoo_contact" value="1" <?php echo checked(1, get_option('wpbe_remove_yahoo_contact'), false); ?> />
                                                <?php _e('Disable Yahoo IM field from users contact field','wpbe'); ?>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="wpbe_remove_gplus_contact" value="1" <?php echo checked(1, get_option('wpbe_remove_gplus_contact'), false); ?> />
                                                <?php _e('Disable Google Plus field from users contact field','wpbe'); ?>
                                            </label>
                                        </li>
                                    </ul>    
                                </div>
                          	</div>
						</div>
                        
                    </div>
               	</div>
                
                <div id="postbox-container-3" class="postbox-container">
                	<div id="column3-sortables" class="meta-box-sortables ui-sortable">
                    
                    	<div id="wpadminfooter" class="postbox">
                        	<button type="button" class="handlediv button-link" aria-expanded="true"><span class="toggle-indicator" data-src="wpadminfooter" aria-hidden="true"></span></button>
                        	<h2 class="hndle ui-sortable-handle"><span><?php _e('WP Admin Footer','wpbe'); ?></span></h2>
							<div class="inside">
								<div class="main">
                                	<p><?php _e('Change the default footer text to what you want.','wpbe'); ?></p>
                                	<ul>
                                        <li>
                                            <label style="display:block;margin-bottom:5px;">
                                                <?php _e('Text Left (HTML allowed)','wpbe'); ?>
                                            </label>
                                            <textarea type="text" name="wpbe_admin_footer_left" style="width:100%;height:100px;"><?php echo get_option('wpbe_admin_footer_left'); ?></textarea>
                                        </li>
                                        <li>
                                            <label style="display:block;margin-bottom:5px;">
                                                <?php _e('Text Right (HTML allowed)','wpbe'); ?>
                                            </label>
                                            <textarea type="text" name="wpbe_admin_footer_right" style="width:100%;height:100px;"><?php echo get_option('wpbe_admin_footer_right'); ?></textarea>
                                        </li>
                                    </ul>
                                </div>
                          	</div>
						 </div>
                         
                         <div id="wpmail" class="postbox">
                        	<button type="button" class="handlediv button-link" aria-expanded="true"><span class="toggle-indicator" data-src="wpmail" aria-hidden="true"></span></button>
                        	<h2 class="hndle ui-sortable-handle"><span><?php _e('WP Mail','wpbe'); ?></span></h2>
							<div class="inside">
								<div class="main">
                                	<ul>
                                        <li>
                                            <label style="display:block;margin-bottom:5px;">
                                                <?php _e('Change mail name <strong>(WordPress)</strong> sent to users to your own','wpbe'); ?>
                                            </label>
                                            <input type="text" name="wpbe_wp_mail_from_name" style="width:100%;" value="<?php echo get_option('wpbe_wp_mail_from_name'); ?>" placeholder="<?php _e('Example:','wpbe');?> <?php echo get_bloginfo('name'); ?>" />
                                        </li>
                                        <li>
                                            <label style="display:block;margin-bottom:5px;">
                                                <?php _e('Change mail adress <strong>(wordpress@mysite.com)</strong> sent to users','wpbe'); ?>
                                            </label>
                                            <input type="text" name="wpbe_wp_mail_from" style="width:100%;" value="<?php echo get_option('wpbe_wp_mail_from'); ?>" placeholder="<?php _e('Example:','wpbe');?> <?php echo get_bloginfo('admin_email'); ?>" />
                                        </li>
                                    </ul>
                                </div>
                          	</div>
						 </div>
                        
                    
                    </div>
               	</div>
            
            </div>
        </div>
        
    </form>
    <script>
		jQuery(document).ready(function( $ ) {
			$('.handlediv .toggle-indicator').click(function() {
				var div = $(this).attr("data-src");
				if($("#" + div).hasClass("closed")){
					$("#" + div).removeClass("closed");
				}
				else{
					$("#" + div).addClass("closed");
				}
			});
		});
	</script>
<?php 
}  

function wpbe_turn_on_gzip(){ 
    ob_start('ob_gzhandler');
}

function wpbe_turn_off_updates(){
	if(!current_user_can('manage_options')){
		function remove_core_updates(){
			global $wp_version;
			return (object)array('last_checked'=> time(), 'version_checked'=> $wp_version);
		}
	
		add_filter('pre_site_transient_update_core','remove_core_updates');
		add_filter('pre_site_transient_update_plugins','remove_core_updates');
		add_filter('pre_site_transient_update_themes','remove_core_updates');
	}
}

function wpbe_shortcut(){ 
	add_menu_page('WPB Elements', 'WPB Elements', 'manage_options', __FILE__, 'wpb_settings_page', 'dashicons-awards', 3);
}

function wpbe_remove_wp_logo() { 
    global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo'); 
}

function wpbe_remove_wp_new_content() {   
    global $wp_admin_bar;
	$wp_admin_bar->remove_menu('new-content'); 
}

function wpbe_remove_wp_sitename() {   
    global $wp_admin_bar;
	$wp_admin_bar->remove_menu('site-name');  
}

function wpbe_remove_wp_customize() {   
    global $wp_admin_bar;
	$wp_admin_bar->remove_menu('customize');  
}

function wpbe_remove_wp_edit() {   
    global $wp_admin_bar;
	$wp_admin_bar->remove_menu('edit');  
}

function wpbe_remove_wp_updates() {
    global $wp_admin_bar;
	$wp_admin_bar->remove_menu('updates'); 
}

function wpbe_remove_wp_search() {
	global $wp_admin_bar;
    $wp_admin_bar->remove_menu('search'); 
}

function wpbe_remove_wp_comments() {
	global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments'); 
}

function wpbe_remove_w3tc() {
	global $wp_admin_bar;
    $wp_admin_bar->remove_menu('w3tc'); 
}

function wpbe_remove_a1s() {
	global $wp_admin_bar;
    $wp_admin_bar->remove_menu('all-in-one-seo-pack'); 
}

function wpbe_remove_yseo() {
	global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wpseo-menu'); 
}

function wpbe_remove_wp_zoom() {
	global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wpzoom'); 
}

function wpbe_remove_vfb() {
	global $wp_admin_bar;
    $wp_admin_bar->remove_menu('vfb_admin_toolbar'); 
}

function wpbe_remove_ngg() {
	global $wp_admin_bar;
    $wp_admin_bar->remove_menu('ngg-menu'); 
}

function wpbe_remove_pings($headers) {
	unset($headers['X-Pingback']);
	return $headers;
}

function wpbe_remove_aim_contact($contactmethods) {
	unset($contactmethods['aim']);
	return $contactmethods;
}

function wpbe_remove_jabber_contact($contactmethods) {
	unset($contactmethods['jabber']);
	return $contactmethods;
}

function wpbe_remove_yahoo_contact($contactmethods) {
	unset($contactmethods['yim']);
	return $contactmethods;
}

function wpbe_remove_gplus_contact($contactmethods) {
	unset($contactmethods['googleplus']);
	return $contactmethods;
}

function wpbe_remove_screen_options(){
	?>
    <style type="text/css">
		#screen-options-link-wrap #show-settings-link{display:none !important;}
		#contextual-help-link-wrap, #screen-options-link-wrap{border:none !important;}
	</style>
    <?php
}

function wpbe_remove_help_link(){
	?>
    <style type="text/css">
		#contextual-help-link-wrap #contextual-help-link{display:none !important;}
		#contextual-help-link-wrap, #screen-options-link-wrap{border:none !important;}
	</style>
    <?php
}

function wpbe_disable_emojis() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');	
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');	
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('emoji_svg_url', '__return_false');
}

function wpbe_remove_meta_generator_qtranslate(){
	remove_action('wp_head', 'qtranxf_wp_head_meta_generator');
}

function wpbe_remove_ataglance_dashboard(){
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
}

function wpbe_remove_activity_dashboard(){
	remove_meta_box('dashboard_activity', 'dashboard', 'normal');
}

function wpbe_remove_quick_press_dashboard(){
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}

function wpbe_remove_wpnews_dashboard(){
	remove_meta_box('dashboard_primary', 'dashboard', 'side');
}

function wpbe_remove_yoast_seo_dashboard(){
	remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'normal');
}

function wpbe_remove_woocoomerce_reviews_dasbhoard(){
	remove_meta_box('woocommerce_dashboard_recent_reviews', 'dashboard', 'normal');
}

function wpbe_remove_dashboard_wpzoom(){
	remove_meta_box('dashboard_wpzoom', 'dashboard', 'normal');
}

function wpbe_remove_bbpress_right_now(){
	remove_meta_box('bbp-dashboard-right-now', 'dashboard', 'side');
}

function wpbe_remove_spm_dashboard(){
	remove_meta_box('spm_dashboard_widget', 'dashboard', 'normal');
}

function wpbe_remove_layers_addons(){
	remove_meta_box('layers-addons', 'dashboard', 'normal');
}

function wpbe_remove_layers_pro(){
	remove_meta_box('layers-pro', 'dashboard', 'normal');
}

function wpbe_remove_itsec_dashboard(){
	remove_meta_box('itsec-dashboard-widget', 'dashboard', 'normal');
}

function wpbe_admin_footer_left() { 
     echo get_option('wpbe_admin_footer_left'); 
}

function wpbe_admin_footer_right() { 
     return get_option('wpbe_admin_footer_right'); 
}

function wpbe_wp_mail_from($old) {
	return get_option('wpbe_wp_mail_from');
}

function wpbe_wp_mail_from_name($old) {
	return get_option('wpbe_wp_mail_from_name');
}

// Disable Plugins, WordPress and Themes update notifications for non-admins
if(get_option('wpbe_turn_off_updates') == '1'){ add_action('plugins_loaded', 'wpbe_turn_off_updates'); } 

// Initiate wpbe_turn_on_gzip on WordPress site
if(get_option('wpbe_turn_on_gzip') == '1'){ add_action('init', 'wpbe_turn_on_gzip'); } 

// Disable Emoji icons if not in use
if(get_option('wpbe_disable_emojis') == '1'){ add_action('init', 'wpbe_disable_emojis'); } 

// Remove Category, Post and Comment feeds
if(get_option('wpbe_remove_wp_rss') == '1'){ remove_action('wp_head', 'feed_links_extra', 3); remove_action('wp_head', 'feed_links', 2); }

// Remove the EditURI link (Really Simple Discovery service endpoint)
if(get_option('wpbe_disable_rsd') == '1'){ remove_action('wp_head', 'rsd_link'); }

// Remove Windows Live Writer manifest file
if(get_option('wpbe_remove_manifest_link') == '1'){ remove_action('wp_head', 'wlwmanifest_link'); }

// Remove WordPress / WooCommerce wpbe_remove_meta_generatorerator tag
if(get_option('wpbe_remove_meta_generator') == '1'){ remove_action('wp_head', 'wp_generator'); }

// Remove q-Translate-X generator meta tag
if(get_option('wpbe_remove_meta_generator_qtranslate') == '1'){ add_action('init', 'wpbe_remove_meta_generator_qtranslate'); }

// Remove Index link
if(get_option('wpbe_remove_index_rel_link') == '1'){ remove_action('wp_head', 'index_rel_link'); }

// Remove Prev link
if(get_option('wpbe_remove_prev_link') == '1'){ remove_action('wp_head', 'parent_post_rel_link', 10, 0); }

// Remove Start link
if(get_option('wpbe_remove_start_link') == '1'){ remove_action('wp_head', 'start_post_rel_link', 10, 0); }

// Remove relational links for the Posts
if(get_option('wpbe_remove_adjacent_links') == '1'){ remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); }

// Remove WordPress shortlink
if(get_option('wpbe_remove_short_link') == '1'){ remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); }

// Remove pings from header
if(get_option('wpbe_remove_pings') == '1'){ add_filter('wp_headers', 'wpbe_remove_pings'); }

// Remove canonical link
if(get_option('wpbe_remove_canonical') == '1'){ remove_action('wp_head', 'rel_canonical'); }

// Remove Screen Options link from dashboard
if(get_option('wpbe_remove_screen_options') == '1'){ add_action('admin_head', 'wpbe_remove_screen_options'); }

// Remove Help link from dashboard
if(get_option('wpbe_remove_help_link') == '1'){ add_action('admin_head', 'wpbe_remove_help_link'); }

// Remove Welcome to WordPress from dashboard
if(get_option('wpbe_remove_welcome_panel') == '1'){ remove_action('welcome_panel', 'wp_welcome_panel'); }

// Remove At a Glance from dashboard
if(get_option('wpbe_remove_ataglance_dashboard') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_ataglance_dashboard'); }

// Remove Activity from dashboard
if(get_option('wpbe_remove_activity_dashboard') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_activity_dashboard'); }

// Remove Quick Press from dashboard
if(get_option('wpbe_remove_quick_press_dashboard') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_quick_press_dashboard'); }

// Remove WordPress News from dashboard
if(get_option('wpbe_remove_wpnews_dashboard') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_wpnews_dashboard'); }

// Remove Yoast SEO Posts Overview
if(get_option('wpbe_remove_yoast_seo_dashboard') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_yoast_seo_dashboard'); }

// Remove WooCommerce Reviews from dashboard
if(get_option('wpbe_remove_woocoomerce_reviews_dasbhoard') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_woocoomerce_reviews_dasbhoard'); }

// Remove WP-Zoom Dashboard from dashboard
if(get_option('wpbe_remove_dashboard_wpzoom') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_dashboard_wpzoom'); }

// Remove bbPress Right Now from dashboard
if(get_option('wpbe_remove_bbpress_right_now') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_bbpress_right_now'); }

// Remove Simple Personal Message from dashboard
if(get_option('wpbe_remove_spm_dashboard') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_spm_dashboard'); }

// Remove Layers addons from dashboard
if(get_option('wpbe_remove_layers_addons') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_layers_addons'); }

// Remove Layers Pro from dashboard
if(get_option('wpbe_remove_layers_pro') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_layers_pro'); }

// Remove Ithemes Security widget from dashboard
if(get_option('wpbe_remove_itsec_dashboard') == '1'){ add_action('wp_dashboard_setup', 'wpbe_remove_itsec_dashboard'); }

// Add WPB Elements in main admin menu
if(get_option('wpbe_add_to_side_menu') == '1'){ add_action('admin_menu', 'wpbe_shortcut'); }

// Add shortcode ability to widgets
if(get_option('wpbe_add_widget_shortcode') == '1'){ add_filter('widget_text', 'do_widgetshortcode'); } 

// Add shortcode ability to manual excerpts
if(get_option('wpbe_add_excerpts_shortcode') == '1'){ add_filter('the_excerpt', 'do_shortcode'); } 

// Remove WP Logo in toolbar
if(get_option('wpbe_remove_wp_logo') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_wp_logo'); } 

// Remove WP New Content in toolbar
if(get_option('wpbe_remove_wp_new_content') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_wp_new_content'); } 

// Remove Site Name in toolbar
if(get_option('wpbe_remove_wp_sitename') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_wp_sitename'); } 

// Remove WP customize in toolbar
if(get_option('wpbe_remove_wp_customize') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_wp_customize'); } 

// Remove WP edit in toolbar
if(get_option('wpbe_remove_wp_edit') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_wp_edit'); } 

// Remove WP Updates in toolbar
if(get_option('wpbe_remove_wp_updates') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_wp_updates'); } 

// Remove WP Search in toolbar
if(get_option('wpbe_remove_wp_search') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_wp_search'); } 

// Remove WP Comments in toolbar
if(get_option('wpbe_remove_wp_comments') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_wp_comments'); } 

// Remove W3 Total Cache in toolbar
if(get_option('wpbe_remove_w3tc') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_w3tc'); } 

// Remove All in One Seo Pack in toolbar
if(get_option('wpbe_remove_a1s') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_a1s'); }

// Remove Yoast SEO in toolbar
if(get_option('wpbe_remove_yseo') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_yseo'); }

// Remove WP Zoom Framework in toolbar
if(get_option('wpbe_remove_wp_zoom') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_wp_zoom'); }

// Remove Visual Form Builder in toolbar
if(get_option('wpbe_remove_vfb') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_vfb'); }

// Remove Nextgen Gallery from  the toolbar
if(get_option('wpbe_remove_ngg') == '1'){ add_action('wp_before_admin_bar_render', 'wpbe_remove_ngg'); }

// Remove Website URL from Users contact info
if(get_option('wpbe_remove_admin_color_scheme') == '1'){ remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker'); }

// Remove AIM from Users contact info
if(get_option('wpbe_remove_aim_contact') == '1'){ add_filter('user_contactmethods', 'wpbe_remove_aim_contact', 999, 1); }

// Remove Jabber from Users contact info
if(get_option('wpbe_remove_jabber_contact') == '1'){ add_filter('user_contactmethods', 'wpbe_remove_jabber_contact', 999, 1); }

// Remove Yahoo IM from Users contact info
if(get_option('wpbe_remove_yahoo_contact') == '1'){ add_filter('user_contactmethods', 'wpbe_remove_yahoo_contact', 999, 1); }

// Remove Google Plus from Users contact info
if(get_option('wpbe_remove_gplus_contact') == '1'){ add_filter('user_contactmethods', 'wpbe_remove_gplus_contact', 999, 1); }

// Add custom text to the admin footer left
if(get_option('wpbe_admin_footer_left') != ''){ add_filter('admin_footer_text', 'wpbe_admin_footer_left'); } 

// Add custom text to the admin footer right
if(get_option('wpbe_admin_footer_right') != ''){ add_filter('update_footer', 'wpbe_admin_footer_right', '1234'); }

// Change WordPress custom name to your own name
if(get_option('wpbe_wp_mail_from_name') != ''){ add_filter('wp_mail_from_name', 'wpbe_wp_mail_from_name'); }

// Change WordPress cusotm name
if(get_option('wpbe_wp_mail_from') != ''){ add_filter('wp_mail_from', 'wpbe_wp_mail_from'); }