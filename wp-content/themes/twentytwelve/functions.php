<?php
/**
 * Twenty Twelve functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwelve', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );

/**
 * Adds support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Returns the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Twelve 1.2
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function twentytwelve_get_font_url() {
	$font_url = '';

	/* translators: If there are characters in your language that are not supported
	 by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'twentytwelve' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		 this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'twentytwelve' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		$font_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

	$font_url = twentytwelve_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'twentytwelve-fonts', esc_url_raw( $font_url ), array(), null );

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() );

	/*
	 * Loads the Internet Explorer specific stylesheet.
	 */
	wp_enqueue_style( 'twentytwelve-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentytwelve-style' ), '20121010' );
	$wp_styles->add_data( 'twentytwelve-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );

/**
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses twentytwelve_get_font_url() To get the Google Font stylesheet URL.
 *
 * @since Twenty Twelve 1.2
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string
 */
function twentytwelve_mce_css( $mce_css ) {
	$font_url = twentytwelve_get_font_url();

	if ( empty( $font_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'twentytwelve_mce_css' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentytwelve' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
			register_sidebar( array(
		'name' => __( 'menuf', 'twentytwelve' ),
		'id' => 'menuf',
		'description' => __( 'menuf', 'twentytwelve' ),
		'before_widget' => '<div id="menuf">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
	
		register_sidebar( array(
		'name' => __( 'slider', 'twentytwelve' ),
		'id' => 'slider',
		'description' => __( 'slider', 'twentytwelve' ),
		'before_widget' => '<div id="slider">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
	
				register_sidebar( array(
		'name' => __( 'fb', 'twentytwelve' ),
		'id' => 'fb',
		'description' => __( 'fb', 'twentytwelve' ),
		'before_widget' => '<div id="fb">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
	
			register_sidebar( array(
		'name' => __( 'box1', 'twentytwelve' ),
		'id' => 'box1',
		'description' => __( 'box1', 'twentytwelve' ),
		'before_widget' => '<div id="box1">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	
				register_sidebar( array(
		'name' => __( 'box2', 'twentytwelve' ),
		'id' => 'box2',
		'description' => __( 'box2', 'twentytwelve' ),
		'before_widget' => '<div id="box2">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	
					register_sidebar( array(
		'name' => __( 'box3', 'twentytwelve' ),
		'id' => 'box3',
		'description' => __( 'box3', 'twentytwelve' ),
		'before_widget' => '<div id="box3">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	
	
	
	
					register_sidebar( array(
		'name' => __( 'info', 'twentytwelve' ),
		'id' => 'info',
		'description' => __( 'info', 'twentytwelve' ),
		'before_widget' => '<div id="info">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
		
					register_sidebar( array(
		'name' => __( 'kalendarz', 'twentytwelve' ),
		'id' => 'kalendarz',
		'description' => __( 'kalendarz', 'twentytwelve' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	

	register_sidebar( array(
		'name' => __( 'Second Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );

if ( ! function_exists( 'twentytwelve_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'twentytwelve_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentytwelve' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'twentytwelve_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentytwelve_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function twentytwelve_body_class( $classes ) {
	$background_color = get_background_color();
	$background_image = get_background_image();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) )
			$classes[] = 'custom-background-empty';
		elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
			$classes[] = 'custom-background-white';
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'twentytwelve_body_class' );

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'twentytwelve_content_width' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function twentytwelve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_customize_preview_js() {
	wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );

/************************************Booking Calender Widegets***************************************/
include('BookingCalender.php');
class CalenderNewWidgetRent extends WP_Widget {

	function CalenderNewWidgetRent() {
		// Instantiate the parent object
		$widgetOptions = array( 'description' => __('Use this widget to add booking calendar to the sidebar'));
		parent::__construct(false, __('Booking Calender Rent Hem'), $widgetOptions);
	}

	function widget( $args, $instance ) {
		// Widget output
		BookingCalender();
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		update_option('BookingCalenderRentHem', $_POST['BookingCalenderRentHem']);
		
	}

	function form( $instance ) {
		// Output admin widget options form
		?>
		Title : <input type="text" name="BookingCalenderRentHem" value="<?php echo get_option('BookingCalenderRentHem'); ?>"  />
        <?php
	}
}

function CalenderNewWidgetRent_register_widgets() {
	register_widget( 'CalenderNewWidgetRent' );
}

add_action( 'widgets_init', 'CalenderNewWidgetRent_register_widgets' );

/*********************************************************************************FOR CALENDER**********************************/

global $custom_table_example_db_version;

$custom_table_example_db_version = '1.1'; // version changed from 1.0 to 1.1
include('BookingOnlyCalender.php');


function custom_table_example_install()

{

    global $wpdb;

    global $custom_table_example_db_version;

     $table_name = $wpdb->prefix . "bookings";

		 

	   $sql = "CREATE TABLE IF NOT EXISTS $table_name (

					  `Id` bigint(20) NOT NULL auto_increment,

					  `standing` varchar(50) NOT NULL,

					  `start` varchar(50) NOT NULL,

					  `often` varchar(50) NOT NULL,

					  `amount` varchar(50) NOT NULL,

					  `Display_date` date NOT NULL,

					  `timeval` varchar(50) NOT NULL,

					  `name` varchar(200) NOT NULL,

					  `address` text NOT NULL,

					  `postno` varchar(50) NOT NULL,

					  `city` varchar(200) NOT NULL,

					  `kvm` varchar(50) NOT NULL,

					  `mobileno` varchar(20) NOT NULL,

					  `email` varchar(200) NOT NULL,
					  
					  `custommessag` varchar(200) NOT NULL,
					  
					  `orderTime` date NOT NULL,

					  PRIMARY KEY  (`Id`)

		);";

    // we are calling dbDelta which cant migrate database

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);



    // save current database version for later use (on upgrade)

    add_option('custom_table_example_db_version', $custom_table_example_db_version);

    $installed_ver = get_option('custom_table_example_db_version');

    if ($installed_ver != $custom_table_example_db_version) {

       $sql = "CREATE TABLE IF NOT EXISTS $table_name (

					  `Id` bigint(20) NOT NULL auto_increment,

					  `standing` varchar(50) NOT NULL,

					  `start` varchar(50) NOT NULL,

					  `often` varchar(50) NOT NULL,

					  `amount` varchar(50) NOT NULL,

					  `Display_date` date NOT NULL,

					  `timeval` varchar(50) NOT NULL,

					  `name` varchar(200) NOT NULL,

					  `address` text NOT NULL,

					  `postno` varchar(50) NOT NULL,

					  `city` varchar(200) NOT NULL,

					  `kvm` varchar(50) NOT NULL,

					  `mobileno` varchar(20) NOT NULL,

					  `email` varchar(200) NOT NULL,

					  PRIMARY KEY  (`Id`)

		);";



        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);



        // notice that we are updating option, rather than adding it

        update_option('custom_table_example_db_version', $custom_table_example_db_version);

    }

}



register_activation_hook(__FILE__, 'custom_table_example_install');



/**

 * register_activation_hook implementation

 *

 * [OPTIONAL]

 * additional implementation of register_activation_hook

 * to insert some dummy data

 */

/*function custom_table_example_install_data()

{

    global $wpdb;



    $table_name = $wpdb->prefix . 'cte'; // do not forget about tables prefix



    $wpdb->insert($table_name, array(

        'name' => 'Alex',

        'email' => 'alex@example.com',

        'age' => 25

    ));

    $wpdb->insert($table_name, array(

        'name' => 'Maria',

        'email' => 'maria@example.com',

        'age' => 22

    ));

}*/



//register_activation_hook(__FILE__, 'custom_table_example_install_data');



/**

 * Trick to update plugin database, see docs

 */

function custom_table_example_update_db_check()

{

    global $custom_table_example_db_version;

    if (get_site_option('custom_table_example_db_version') != $custom_table_example_db_version) {

        custom_table_example_install();

    }

}



add_action('plugins_loaded', 'custom_table_example_update_db_check');



/**

 * PART 2. Defining Custom Table List

 * ============================================================================

 *

 * In this part you are going to define custom table list class,

 * that will display your database records in nice looking table

 *

 * http://codex.wordpress.org/Class_Reference/WP_List_Table

 * http://wordpress.org/extend/plugins/custom-list-table-example/

 */



if (!class_exists('WP_List_Table')) {

    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

}



/**

 * Custom_Table_Example_List_Table class that will display our custom table

 * records in nice table

 */

class Custom_Table_Example_List_Table extends WP_List_Table

{

    /**

     * [REQUIRED] You must declare constructor and give some basic params

     */

    function __construct()

    {

        global $status, $page;



        parent::__construct(array(

            'singular' => 'booking',

            'plural' => 'bookings',

        ));

    }



    /**

     * [REQUIRED] this is a default column renderer

     *

     * @param $item - row (key, value array)

     * @param $column_name - string (key)

     * @return HTML

     */

    function column_default($item, $column_name)

    {

        return $item[$column_name];

    }
    function column_name($item)

    {

        $actions = array(

            'edit' => sprintf('<a href="?page=persons_form&Id=%s">%s</a>', $item['Id'], __('Edit', 'custom_table_example')),

            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['Id'], __('Delete', 'custom_table_example')),

        );



        return sprintf('%s %s',

            $item['name'],

            $this->row_actions($actions)

        );

    }


    function column_cb($item)

    {

        return sprintf(

            '<input type="checkbox" name="id[]" value="%s" />',

            $item['Id']

        );

    }


    function get_columns()

    {

       $columns = array(

            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text

            'name' => __('Name', 'custom_table_example'),

            'email' => __('E-Mail', 'custom_table_example'),

            'standing'=> __('Standing', 'custom_table_example'),

			'often'=> __('Often', 'custom_table_example'),

			'amount'=> __('Amount', 'custom_table_example'),

			'Display_date'=> __('Booking Date', 'custom_table_example'),
			
			'orderTime'=> __('Order Date', 'custom_table_example'),

			'timeval'=> __('Time', 'custom_table_example'),
			
			'custommessag'=> __('Message', 'custom_table_example'),
			
			'StaffName'=> __('Staff Name', 'custom_table_example'),
			
			'SendMailStatus'=> __('Schedule Mail', 'custom_table_example')

			

        );
        return $columns;

    }


    function get_sortable_columns()

    {

        $sortable_columns = array(

            'name' => array('name', true),

            'amount' => array('amount', true),

            'Display_date' => array('Display_date', true),

        );

        return $sortable_columns;

    }

    function get_bulk_actions()

    {

        $actions = array(

            'delete' => 'Delete'

        );

        return $actions;

    }

    function process_bulk_action()

    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'bookings'; // do not forget about tables prefix



        if ('delete' === $this->current_action()) {

            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();

            if (is_array($ids)) $ids = implode(',', $ids);



            if (!empty($ids)) {

                $wpdb->query("DELETE FROM $table_name WHERE Id IN($ids)");

            }

        }

    }

    function prepare_items()

    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'bookings'; // do not forget about tables prefix



        $per_page = 20; // constant, how much records will be shown per page



        $columns = $this->get_columns();

        $hidden = array();

        $sortable = $this->get_sortable_columns();



        // here we configure table headers, defined in our methods

        $this->_column_headers = array($columns, $hidden, $sortable);



        // [OPTIONAL] process bulk action if any

        $this->process_bulk_action();



        // will be used in pagination settings

        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");



        // prepare query params, as usual current page, order by and order direction

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'name';

        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';



        // [REQUIRED] define $items array

        // notice that last argument is ARRAY_A, so we will retrieve array

       $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_bookings INNER JOIN wp_stafftable ON wp_bookings.StaffId=wp_stafftable.id ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);


        // [REQUIRED] configure pagination

        $this->set_pagination_args(array(

            'total_items' => $total_items, // total items defined above

            'per_page' => $per_page, // per page constant defined at top of method

            'total_pages' => ceil($total_items / $per_page) // calculate pages count

        ));

    }

}

function custom_table_example_admin_menu()

{

    add_menu_page(__('Booking', 'custom_table_example'), __('Booking', 'custom_table_example'), 'activate_plugins', 'booking', 'custom_table_example_persons_page_handler');

    add_submenu_page('booking', __('Booking', 'custom_table_example'), __('Booking', 'custom_table_example'), 'activate_plugins', 'booking', 'custom_table_example_persons_page_handler');

    // add new will be described in next part

    add_submenu_page('booking', __('Add new', 'custom_table_example'), __('Add new', 'custom_table_example'), 'activate_plugins', 'persons_form', 'custom_table_example_persons_form_page_handler');

}



add_action('admin_menu', 'custom_table_example_admin_menu');

/*Staff menu start*/
function custom_table_example_admin_menu_staff(){
	
	add_menu_page(__('Staff', 'custom_table_example'), __('Staff', 'custom_table_example'), 'activate_plugins', 'Staff', 'custom_table_example_Staff_page_handler');
	
}
    function custom_table_example_Staff_page_handler(){
		include('stafflist.php');
	}

add_action('admin_menu', 'custom_table_example_admin_menu_staff');
/*Staff menu end*/
/*Staff sub menu start*/
add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
	// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function ); 
	add_submenu_page( 'Staff', 'staff_list', 'Add Staff', 'manage_options', 'staff_list', 'my_custom_staff_list_submenu_page_callback' ); 
}

function my_custom_staff_list_submenu_page_callback() {
	
	include('stafflist.php');

}

/*Hour menu start*/
function custom_table_example_admin_menu_Hour(){
	
	add_menu_page(__('Hour', 'custom_table_example'), __('Hour', 'custom_table_example'), 'activate_plugins', 'Hour', 'custom_table_example_Hour_page_handler');
	
}
    function custom_table_example_Hour_page_handler(){
		include('hourlist.php');
	}

add_action('admin_menu', 'custom_table_example_admin_menu_Hour');
/*Hour menu end*/
/*Hour sub menu start*/
add_action('admin_menu', 'register_my_custom_submenu_page_hour');

function register_my_custom_submenu_page_hour() {
	// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function ); 
	add_submenu_page( 'Hour', 'Hour_list', 'Add Hour', 'manage_options', 'Hour_list', 'my_custom_Hour_list_submenu_page_callback' ); 
}

function my_custom_Hour_list_submenu_page_callback() {
	
	include('hourlist.php');

}

/*Hour sub menu start*/

function custom_table_example_persons_page_handler()

{

    global $wpdb;



    $table = new Custom_Table_Example_List_Table();

    $table->prepare_items();



    $message = '';

    if ('delete' === $table->current_action()) {

        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_example'), count($_REQUEST['id'])) . '</p></div>';

    }

    ?>

<div class="wrap">



    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>

    <h2><?php _e('Booking Management', 'custom_table_example')?> <a class="add-new-h2"

                                 href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=persons_form');?>"><?php _e('Add new', 'custom_table_example')?></a>

    </h2>
<div style="float:left;"><?php CalenderView(); ?></div>
    <?php echo $message; ?>



    <form id="persons-table" method="GET">

        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>

        <?php $table->display() ?>

    </form>



</div>

<?php

}

function custom_table_example_persons_form_page_handler()

{

    global $wpdb;

    $table_name = $wpdb->prefix . 'bookings'; // do not forget about tables prefix



    $message = '';

    $notice = '';



    // this is default $item which will be used for new records

    $default = array(

        'Id' => 0,

        'standing' => '',

        'start' => '',

        'often' => '',

		'amount' => '',

		'Display_date' => '',

		'timeval'=>'',

		'name'=>'',

		'address'=>'',

		'postno'=>'',

		'city'=>'',

		'kvm'=>'',

		'mobileno'=>'',

		'email'=>'',
		
		'StaffId'=>'',
		
		'SendMailStatus'=>''

		

		

    );

					

    // here we are verifying does this request is post back and have correct nonce

    if (wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {

        // combine our default item with request params

        $item = shortcode_atts($default, $_REQUEST);

        // validate data, and if all ok save item to database

        // if id is zero insert otherwise update

		

        $item_valid = custom_table_example_validate_person($item);

        if ($item_valid === true) {

            if ($item['Id'] == 0) {

                $result = $wpdb->insert($table_name, $item);

                $item['Id'] = $wpdb->insert_id;

                if ($result) {

                    $message = __('Item was successfully saved', 'custom_table_example');

                } else {

                    $notice = __('There was an error while saving item', 'custom_table_example');

                }

            } else {

                $result = $wpdb->update($table_name, $item, array('Id' => $item['Id']));

                if ($result) {

                    $message = __('Item was successfully updated', 'custom_table_example');

                } else {

                    $notice = __('You have not update any item', 'custom_table_example');

                }

            }

        } else {

            // if $item_valid not true it contains error message(s)

            $notice = $item_valid;

        }

    }

    else {

        // if this is not post back we load item to edit or give new one to create

        $item = $default;

        if (isset($_REQUEST['Id'])) {

            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE Id = %d", $_REQUEST['Id']), ARRAY_A);

            if (!$item) {

                $item = $default;

                $notice = __('Item not found', 'custom_table_example');

            }

        }

    }



    // here we adding our custom meta box

    add_meta_box('persons_form_meta_box', 'Person data', 'custom_table_example_persons_form_meta_box_handler', 'person', 'normal', 'default');



    ?>

<div class="wrap">

    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>

    <h2><?php _e('Booking Management', 'custom_table_example')?> <a class="add-new-h2"

                                href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=booking');?>"><?php _e('back to list', 'custom_table_example')?></a>

    </h2>



    <?php if (!empty($notice)): ?>

    <div id="notice" class="error"><p><?php echo $notice ?></p></div>

    <?php endif;?>

    <?php if (!empty($message)): ?>

    <div id="message" class="updated"><p><?php echo $message ?></p></div>

    <?php endif;?>



    <form id="form" method="POST">

        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>

        <?php /* NOTICE: here we storing id to determine will be item added or updated */ ?>

        <input type="hidden" name="Id" value="<?php echo $item['Id'] ?>"/>



        <div class="metabox-holder" id="poststuff">

            <div id="post-body">

                <div id="post-body-content">

                    <?php /* And here we call our custom meta box */ ?>

                    <?php do_meta_boxes('person', 'normal', $item); ?>

                    <input type="submit" value="<?php _e('Save', 'custom_table_example')?>" id="submit" class="button-primary" name="submit">

                </div>

            </div>

        </div>

    </form>

</div>

<?php

}

function custom_table_example_persons_form_meta_box_handler($item)

{

    ?>

<script type="text/javascript">

	function showSecond()

	{

		var val=document.getElementById("standing").value;

		if(val=="H")

		{

			document.getElementById("hour1").style.display="block";

			document.getElementById("hour2").style.display="none";

			document.getElementById("hour3").style.display="none";

			document.getElementById("hour4").style.display="none";

			document.getElementById("trweekly").style.display="";

		}

		if(val=="F")

		{

			document.getElementById("hour1").style.display="none";

			document.getElementById("hour2").style.display="block";

			document.getElementById("hour3").style.display="none";

			document.getElementById("hour4").style.display="none";

			document.getElementById("trweekly").style.display="none";

		}

		if(val=="P")

		{

			document.getElementById("hour1").style.display="none";

			document.getElementById("hour2").style.display="none";

			document.getElementById("hour3").style.display="block";

			document.getElementById("hour4").style.display="none";

			document.getElementById("trweekly").style.display="none";

			

			

		}

		if(val=="E")

		{

			document.getElementById("hour1").style.display="none";

			document.getElementById("hour2").style.display="none";

			document.getElementById("hour3").style.display="none";

			document.getElementById("hour4").style.display="block";

			document.getElementById("trweekly").style.display="none";

		}

		calculate();

	}

	function calculate()

	{

		var standing=document.getElementById("standing").value;

		var start=document.getElementById("start").value;

		var hours;

		var total;

		

			var start_text=document.getElementById("start");

		var selectedTextstart = start_text.options[start_text.selectedIndex].text;

		if(standing=="H")

		{

			hours=document.getElementById("often1").value;

			hours_text=document.getElementById("often1");

			if(start==135)

			{

				total=hours*start*4;	

			}

			if(start==140)

			{

				total=hours*start*2;	

			}

			if(start==155)

			{

				total=hours*start;	

			}

			

		}

		if(standing=="F")

		{

			hours=document.getElementById("often2").value;

			total=hours;

			hours_text=document.getElementById("often2");

			selectedTextstart="-";

			

		}

		if(standing=="E")

		{

			hours=document.getElementById("often4").value;

			total=185*hours;

			hours_text=document.getElementById("often3");

			selectedTextstart="-";

		}

		if(standing=="P")

		{

			hours=document.getElementById("often3").value;

			total=99*hours;

			hours_text=document.getElementById("often4");

			selectedTextstart="-";

		}

	

		

		var standing_text=document.getElementById("standing");

		var selectedTextStanding = standing_text.options[standing_text.selectedIndex].text;

		

		var selectedTexthours = hours_text.options[hours_text.selectedIndex].text;

		

		document.getElementById("amount").value=total;

		document.getElementById("hdnstanding").value=selectedTextStanding;

		document.getElementById("hdnstart").value=selectedTextstart;

		document.getElementById("hdnoften").value=selectedTexthours;

		

	}

	

</script>

<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">

    <tbody>

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="name"><b><?php _e('Staff', 'custom_table_example')?></b></label>

        </th>

        <td>

           <select name="StaffId" id="StaffId" style="width:200px" required>
                <?php 
				global $wpdb;
				$conrequest=$wpdb->get_results("select * from wp_stafftable");
                foreach($conrequest as $cont)
                {?>
				<option value="<?php echo ($cont->id); ?>" <?php if(esc_attr($item['StaffId'])==$cont->id) { ?> selected="selected" <?php } ?>><?php echo ($cont->StaffName); ?></option>
                <?php } ?>

			</select>

        </td>

    </tr>
    
    <tr class="form-field">

        <th valign="top" scope="row">

            <label for="name"><b><?php _e('Schedule Mail Status', 'custom_table_example')?></b></label>

        </th>

        <td>

           <select name="SendMailStatus" id="SendMailStatus" style="width:200px" required>
           
				<option value="Enable" <?php if(esc_attr($item['SendMailStatus'])=='Enable') { ?> selected="selected" <?php } ?>>Enable</option>
                <option value="Disable" <?php if(esc_attr($item['SendMailStatus'])=='Disable') { ?> selected="selected" <?php } ?>>Disable</option>
               
			</select>

        </td>

    </tr>

	 <tr class="form-field">

        <th valign="top" scope="row">

            <label for="name"><?php _e('Standing', 'custom_table_example')?></label>

        </th>

        <td>

           <select name="standing1" id="standing" style="width:200px" onchange="showSecond()" required>

		   		<option value="">---Select---</option>
				<?php
                $Standing=$wpdb->get_results("select * from wp_ea_category where parent=52");
                foreach($Standing as $Standingsingle)
                {
                ?>
                <option value="<?php echo $Standingsingle->description; ?>" <?php if(esc_attr($item['standing'])==$Standingsingle->name) { ?> selected="selected" <?php } ?>><?php echo $Standingsingle->name; ?></option>
                <?php }?>

			</select>

        </td>

    </tr>

	

	 <tr class="form-field" id="trweekly" <?php if(esc_attr($item['standing'])!="Hemstadning") { ?> style="display:none" <?php } ?>>

        <th valign="top" scope="row">

            <label for="name"><?php _e('Hurt ofta?', 'custom_table_example')?></label>

        </th>

        <td>

          <select name="start1" id="start" style="width:200px" onchange="calculate()">
			<?php
            $Hurt_ofta=$wpdb->get_results("select * from wp_ea_category where parent=53");
            foreach($Hurt_ofta as $Hurt_oftasingle)
            {
            ?>
            <option value="<?php echo $Hurt_oftasingle->description; ?>" <?php if(esc_attr($item['start'])==$Hurt_oftasingle->name) { ?> selected="selected" <?php } ?>><?php echo $Hurt_oftasingle->name; ?></option>
            <?php }?>

			</select>

        </td>

    </tr>

	

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="name"><?php _e('Hurt stort?', 'custom_table_example')?></label>

        </th>

        <td id="hour1">

			<select name="often11" id="often1" style="width:200px" onchange="calculate()">
			<?php
            $hour1=$wpdb->get_results("select * from wp_ea_category where parent=48");
            foreach($hour1 as $hour1single)
            {
            ?>
            <option value="<?php echo $hour1single->description; ?>" <?php if(esc_attr($item['standing'])=="Hemstadning") { if(esc_attr($item['often'])==$hour1single->name) { ?> selected="selected" <?php } } ?>><?=$hour1single->name?></option>
            <?php }?>
			</select>

		</td>

		<td id="hour2" style="display:none" >

			<select name="often12" id="often2" style="width:200px" onchange="calculate()">
			<?php
            $hour2=$wpdb->get_results("select * from wp_ea_category where parent=49");
            foreach($hour2 as $hour2single)
            {
            ?>
            <option value="<?php echo $hour2single->description; ?>" <?php if(esc_attr($item['standing'])=="Flyttstadning") { if(esc_attr($item['often'])==$hour2single->name) { ?> selected="selected" <?php } } ?>><?=$hour2single->name?></option>
            <?php }?>
            
			</select>

		</td>

		<td id="hour3" style="display:none">

			<select name="often13" id="often3" style="width:200px" onchange="calculate()">
			<?php
            $hour3=$wpdb->get_results("select * from wp_ea_category where parent=50");
            foreach($hour3 as $hour3single)
            {
            ?>
            <option value="<?php echo $hour3single->description; ?>" <?php if(esc_attr($item['standing'])=="Provstadning") {  if(esc_attr($item['often'])==$hour3single->name) { ?> selected="selected" <?php } } ?>><?=$hour3single->name?></option>
            <?php }?>

			</select>

		</td>

		<td id="hour4" style="display:none">

			<select name="often14" id="often4" style="width:200px" onchange="calculate()">
			<?php
            $hour4=$wpdb->get_results("select * from wp_ea_category where parent=51");
            foreach($hour4 as $hour4single)
            {
            ?>
            <option value="<?php echo $hour4single->description; ?>" <?php if(esc_attr($item['standing'])=="Engangstadning") { if(esc_attr($item['often'])==$hour4single->name) { ?> selected="selected" <?php } }?>><?=$hour4single->name?></option>
            <?php }?>

			</select>			

			<input type="hidden" id="hdnstanding" name="standing" value="<?php echo esc_attr($item['standing'])?>" />

			<input type="hidden" id="hdnstart"  name="start" value="<?php echo esc_attr($item['start'])?>" />

			<input type="hidden" id="hdnoften" name="often" value="<?php echo esc_attr($item['often'])?>" />

		</td>

    </tr>

	

	

	 <tr class="form-field">

        <th valign="top" scope="row">

            <label for="name"><?php _e('Amount', 'custom_table_example')?></label>

        </th>

        <td>

            <input id="amount" name="amount" type="text" style="width: 95%" value="<?php echo esc_attr($item['amount'])?>"

                   size="50" class="code" placeholder="<?php _e('Your amount', 'custom_table_example')?>" required>

        </td>

    </tr>

	

	

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="name"><?php _e('Booking Date', 'custom_table_example')?></label>

        </th>

        <td>

            <input id="Display_date" name="Display_date" type="text" style="width: 95%" value="<?php echo esc_attr($item['Display_date'])?>"

                   size="50" class="code" placeholder="<?php _e('Your Booking Date', 'custom_table_example')?>" required><br />

				   [YYYY-MM-DD]

        </td>

    </tr>

	

		<tr class="form-field">

        <th valign="top" scope="row">

            <label for="name"><?php _e('Time', 'custom_table_example')?></label>

        </th>

        <td>

			<input type="radio" name="timeval" style="width:0%" id="timeval1" value="8:00-12:00" <?php if(esc_attr($item['timeval'])=="8:00-12:00") { ?> checked="checked" <?php } ?> />formiddag<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8:00-12:00<br /><br />

			<input type="radio" style="width:0%" name="timeval" id="timeval2" value="13:00-17:00" <?php if(esc_attr($item['timeval'])=="") { ?> checked="checked" <?php } ?> <?php if(esc_attr($item['timeval'])=="13:00-17:00") { ?> checked="checked" <?php } ?> />eftermiddag<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;13:00-17:00

		

        </td>

    </tr>

	

	

	

	

    <tr class="form-field">

        <th valign="top" scope="row">

            <label for="name"><?php _e('Namn', 'custom_table_example')?></label>

        </th>

        <td>

            <input id="name" name="name" type="text" style="width: 95%" value="<?php echo esc_attr($item['name'])?>"

                   size="50" class="code" placeholder="<?php _e('Your name', 'custom_table_example')?>" required>

        </td>

    </tr>

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="address"><?php _e('Gatuadress', 'custom_table_example')?></label>

        </th>

        <td>

           <!-- <input id="name" name="name" type="text" style="width: 95%" value="<?php echo esc_attr($item['address'])?>"

                   size="50" class="code" placeholder="<?php _e('Your Gatuadress', 'custom_table_example')?>" required> -->

				   

				   <textarea id="address" name="address" class="code" placeholder="<?php _e('Your Gatuadress', 'custom_table_example')?>"><?php echo esc_attr($item['address'])?></textarea> 

        </td>

    </tr>

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="postno"><?php _e('Postnummer', 'custom_table_example')?></label>

        </th>

        <td>

            <input id="postno" name="postno" type="text" style="width: 95%" value="<?php echo esc_attr($item['postno'])?>"

                   size="50" class="code" placeholder="<?php _e('Your Postnummer', 'custom_table_example')?>" required>

        </td>

    </tr>

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="city"><?php _e('Ort', 'custom_table_example')?></label>

        </th>

        <td>

            <input id="city" name="city" type="text" style="width: 95%" value="<?php echo esc_attr($item['city'])?>"

                   size="50" class="code" placeholder="<?php _e('Your Ort', 'custom_table_example')?>" required>

        </td>

    </tr>

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="kvm"><?php _e('Ungefär storlek på din bostad(i kvm)', 'custom_table_example')?></label>

        </th>

        <td>

            <input id="kvm" name="kvm" type="text" style="width: 95%" value="<?php echo esc_attr($item['kvm'])?>"

                   size="50" class="code" placeholder="<?php _e('Your Ort', 'custom_table_example')?>" required>

        </td>

    </tr>

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="MobileNo"><?php _e('Mobilnummer', 'custom_table_example')?></label>

        </th>

        <td>

            <input id="mobileno" name="mobileno" type="text" style="width: 95%" value="<?php echo esc_attr($item['mobileno'])?>"

                   size="50" class="code" placeholder="<?php _e('Your Mobilenummer', 'custom_table_example')?>" required>

        </td>

    </tr>

    <tr class="form-field">

        <th valign="top" scope="row">

            <label for="email"><?php _e('E-post', 'custom_table_example')?></label>

        </th>

        <td>

            <input id="email" name="email" type="email" style="width: 95%" value="<?php echo esc_attr($item['email'])?>"

                   size="50" class="code" placeholder="<?php _e('Your E-post', 'custom_table_example')?>" required>

        </td>

    </tr>

    

	

    </tbody>

</table>

<?php

}

function custom_table_example_validate_person($item)

{

    $messages = array();



    if (empty($item['name'])) $messages[] = __('Name is required', 'custom_table_example');

    if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-post is in wrong format', 'custom_table_example');

    if (empty($messages)) return true;

    return implode('<br />', $messages);

}

function custom_table_example_languages()

{

    load_plugin_textdomain('custom_table_example', false, dirname(plugin_basename(__FILE__)));

}



add_action('init', 'custom_table_example_languages');

$timestamp=1389999996;
wp_schedule_event($timestamp, 'daily', 'prefix_daily_event_hook'); 

function prefix_daily_event_hook(){
global $wpdb;
$mailallrequest=$wpdb->get_results("SELECT * FROM wp_bookings");
$ToDay=date("Y-m-d");
foreach($mailallrequest as $mailone)
	{	
		if($mailone->SendMailStatus=='Enable'){
			
			$bookdats=$mailone->Display_date;
			$to=$mailone->email;
			$from=get_option('admin_email');;                
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: <'.$from.'>' . "\r\n".'Reply-To:'.$$from. "\r\n" ;
			$subject="Booking Reminder : Rent Hem Stockholm ";
			$message='';
			$message .='<br><h3>Hello Mr. '.$mailone->name.' </h3> Here is your Booking Details : <br><br>';
			$messageeach=
			'<b>Name : '.$mailone->name.'</b><br>'.
			'<b>Service Time : '.$mailone->timeval.'</b><br>'.
			'<b>Booking Date : '.$mailone->Display_date.'</b><br>'.
			'<b>Standing : </b>'.$mailone->standing.'<br>'.
			'<b>Start : </b>'.$mailone->start.'<br>'.
			'<b>Often : </b>'.$mailone->often.'<br>'.
			'<b>Postno : </b>'.$mailone->postno.'<br>';
			$message .=$messageeach;
			$datetime1 = new DateTime($ToDay);
			$datetime2 = new DateTime($bookdats);
			$interval = $datetime1->diff($datetime2);
			$Difftme=intval($interval->format('%R%a'));
			if($Difftme==1){
				//@mail($to, $subject, $message, $headers);
			}
		}
	}
}
