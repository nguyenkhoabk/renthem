<?php
/**
 * Shortcode displays booking on front-page
 */

add_shortcode( 'frontend_booking_form', 'frontend_booking_form' );

function frontend_booking_form( $attr )
{
    $output = '<div class="rm-frontent-booking-container">';
    $output .= '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>';
    $output .= '<link rel="stylesheet" type="text/css" href="//renthem.dev/wp-admin/booking_v2/ustawienia.css" media="screen" />';
    $output .= '<link rel="stylesheet" href="//renthem.dev/wp-admin/booking_v2/css/new_calendar.css" type="text/css" />';
    $output .= '<script src="//renthem.dev/wp-admin/booking_v2/js/new-calendar.js"></script></p>';
    $output .= '<p><script src="//renthem.dev/wp-admin/booking_v2/js/book-script-form.js"></script></p>';
    $output .= '<div id="calendar-cont" style="box-shadow: 4px 0px 5px #D1D1D1;"> </div>';
    $output .= '</div>';
    return $output;
}

add_shortcode( 'display_windows', 'display_windows' );

function display_windows( $attr )
{
    // fonsterputs
    $window_order = array();
    if ( get_option( '_mw_sorting_windows' )  )
    {
        $window_order = get_option( '_mw_sorting_windows' );
        $window_order = array_map( intval, $window_order );
    }
    $args = array(
        'post_type' => 'fonsterputs',
        'posts_per_page'    =>  -1,
        'orderby'           =>  'post__in',
        'post__in'          =>  $window_order
    );
    $my_query = new WP_Query( $args );
?>
    <div class="rm-windows-container rm-modal">
        <div class="rm-modal-dialog">
            <div class="rm-modal-content">
                <div class="rm-container">
                    <div class="rm-row">
                        <div class="seletected-windows">
                            <input type="hidden" name="window-selected-ids" id="window-selected-ids">
                            <h4>Selected Windows</h4>
                            <input type="text" name="window-selected-titles" id="window-selected-titles">
                        </div>
                    </div> <!-- end .rm-window -->
                    <div class="rm-row">
                <?php
                if( $my_query->have_posts() ) :
                    while( $my_query->have_posts() ) : $my_query->the_post();
                    ?>
                        <div class="rm-window rm-sm-col">
                            <?php echo get_the_post_thumbnail( get_the_ID() ); ?>
                            <div class="rm-window-title">
                                <p><label for="rm-window-id-<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></label></p>
                                <input type="checkbox" name="rm-window-id-<?php echo get_the_ID(); ?>" id="rm-window-id-<?php echo get_the_ID(); ?>" value="<?php echo get_the_ID()?>" />
                                <input type="hidden" name="window-title" value="<?php echo get_the_title(); ?>" />
                            </div>
                        </div> <!-- end .rm-window -->
                    <?php
                    endwhile;
                endif;
                ?>
                        <div class="rm-clear"></div>
                    </div> <!-- end .rm-row -->
                    <div class="rm-row">
                        <div class="button-control-container">
                            <input type="button" class="rm-btn b-save rm-submitbtn" value="Select">
                            <input type="button" class="rm-btn b-cancel rm-closebtn" value="Cancel">
                        </div>
                    </div> <!-- end .rm-row -->
                </div> <!-- end .rm-container -->
            </div> <!-- end .rm-modal-content -->
        </div> <!-- end .rm-container -->
    </div> <!-- end .rm-modal-dialog -->
<?php
}