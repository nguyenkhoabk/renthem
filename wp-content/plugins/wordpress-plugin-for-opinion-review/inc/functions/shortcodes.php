<?php
add_shortcode( 'wor_form_review', 'wor_show_form_review' );

/**
 * Display form submit review and rating
 * @param array $atts   Shortcode attributes
 * @return string
 * */

function wor_show_form_review( $atts )
{
    $output = '';
	if( isset( $_GET['action'] ) && $_GET['action'] == 'wor-submit-review' )
	{
		if( isset( $_GET['message'] ) && $_GET['message'] == 'success' )
		{
			?>
			<h3>I am here</h3>
			<div id="wor_message_success" style="display:none">
				<p class="mor-message">Tack för ditt omdöme</p>
			</div>
			<script>
				jQuery( document ).ready( function( $ )
				{
					var options = {
						backOpacity : 0,
						speed : 300,
						width : 200,
                        height: 100
					};
					var popup = new $.Popup( options );
					popup.open( '#wor_message_success' );
				});
			</script>
<?php
//            $output .= sprintf( '<p class="mw-message">%s</p>', __( 'Order Received', 'mw' ) );
		}
	}
    $output .= '<form name="wor-form-review" class="wor-form-review-container" method="post">';
    $output .= '    <div>';
    $output .= '        <span>' . __( "Ditt betyg", "wor" ) . '</span><span><sup>*</sup></span><span class="wor-error wor-hide">'.  __( "Required", "wor" ) . '</span><br />';
    $output .= '        <div class="mor-rating mor-left"></div>';
    $output .= '        <span id="mor-rating-text"></span>';
    $output .= '        <input type="hidden" id="mor-rating-value" name="mor-rating-value" value="0">';
    $output .= '        <div class="mor-clear"></div>';
    $output .= '    </div>';   
    $output .= '    <div>';
    $output .= '        <span>' . __( "Namn", "wor" ) . '</span><span><sup>*</sup></span><span class="wor-error wor-hide">'.  __( "Required", "wor" ) . '</span><br />';
    $output .= '        <input type="text" name="wor-review-first-name" class="wor-input-field" value="">';
    $output .= '    </div>';
    $output .= '    <div>';
    $output .= '        <span>' . __( "Efternamn", "wor" ). '</span><span><sup>*</sup></span><span class="wor-error wor-hide">'.  __( "Required", "wor" ) . '</span><br />';
    $output .= '        <input type="text" name="wor-review-last-name" class="wor-input-field" value="">';
    $output .= '    </div>';
    $output .= '    <div>';
    $output .= '        <span>' . __( "Stad", "wor" ) . '</span><span><sup>*</sup></span><span class="wor-error wor-hide">'.  __( "Required", "wor" ) . '</span><br />';
    $output .= '        <input type="text" name="wor-review-city" class="wor-input-field" value="">';
    $output .= '    </div>';
    $output .= '    <div>';
    $output .= '        <span>' . __( "Rubrik", "wor" ) . '</span><span><sup>*</sup></span><span class="wor-error wor-hide">'.  __( "Required", "wor" ) . '</span><br />';
    $output .= '        <input type="text" name="wor-review-topic" class="wor-input-field" value="">';
    $output .= '    </div>';     
    $output .= '    <div>';
    $output .= '        <span>' . __( "Ditt omdöme", "wor" ) . '</span><span><sup>*</sup></span><span class="wor-error wor-hide">'.  __( "Required", "wor" ) . '</span><br />';
    $output .= '        <textarea name="wro-review-review" rows="10" class="wro-textarea"></textarea>';
    $output .= '    </div>';
    $output .= wp_nonce_field( 'mor-review', 'review-nonce' );
    $output .= '    <div>';
    $output .= '        <input type="submit" class="wro-button wro-submit wor-right" value="Lägg till">';
    $output .= '        <div class="wor-clear"></div>';
    $output .= '    </div>';
    $output .= '</form>';
    return $output;
}

// Display list review
add_shortcode( 'wor_list_review', 'wor_display_reviews' );

/*
 * Output list review
 * @return string
 * */

function wor_display_reviews( $atts )
{
    $atts = shortcode_atts( array(
        'number' => 5,
        'pager'  => 'no',
        'page_url'  => '#',
    ), $atts );
    $output = '';

    $output .= '<section class="wor-list-reviewed-container">';
    $paged = 1;
    if( $atts['pager'] == 'yes' )
    {
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    }
    $args = array(
        'post_type'         => 'review',
        'posts_per_page'    =>  $atts['number'],
        'paged'             =>  $paged,
    );
    $my_query = new WP_Query( $args );
    if( $my_query->have_posts() ) :
        while( $my_query->have_posts() ) : $my_query->the_post();
            $metas = get_post_meta( get_the_ID(), '_wor_review_metas', true );
            $first_name = $metas['first_name'];
            $last_name = $metas['last_name'];
            $posted_date = $metas['posted_date'];
            if( $posted_date == '' )
            {
                $posted_date = get_the_date('Y-m-d');
            }

            $name = sprintf( '%s %s', $first_name, mb_substr( $last_name, 0, 1 ) );
            $output .= '<div class="wor-reviewed-item">';
            $output .= '        <div class="wor-review-item-left wor-left">';
            $output .= '            <h3>' . $name . '</h3>';
            $output .= '            <span>' .  $metas['city'] . '</span> ';
            $output .= '        </div>'; // .wor-review-item-left
	        $output .= '        <div class="wor-review-item-right wor-right">';
            $output .= '        	<div class="wor-entry-content">';
	        $output .= '        	<div class="wor-reviewed-top">';
	        $output .= '                <div class="mor-rating-item" data-score="' . $metas['rating'] . '"></div><span class="mor-rating-time-publish">' . $posted_date . '</span>';
	        $output .= '        	</div>'; // .wor-reviewed-top
	        $output .= '            <h3>' . get_the_title() . '</h3>';
            $output .= '            	<p>';
            $output .=                      get_the_content();
            $output .= '            	</p>';
            $output .= '        	</div>'; // .wor-entry-content
            if ( ! empty( $metas['comment'] ) )
            {
                $output .= '        <div class="wor-entry-content wor-admin-comment">';
                $output .= '            <h3 class="wor-left">Rent Hem svarar:</h3>';
                $output .= '            <div class="wor-right">' . $metas['time_comment'] . '</div>';
                $output .= '            <div class="wor-clear"></div>';
                $output .= '            <p>';
                $output .=                  wpautop( $metas['comment'] );
                $output .= '            </p>';
                $output .= '        </div>';   // .wor-entry-content .wor-admin-comment
            }
	        $output .= '		</div>'; // .wor-review-item-right
	        $output .= '<div class="wor-clear"></div>';
            $output .= '</div>'; // .wor-reviewed-item
        endwhile;
        $output .= '<div class="wor-list-review-pagination">';
            if( $atts['pager'] == 'yes' )
            {
                $output .= '    <div class="mor-left">' .  get_previous_posts_link( 'Prev' ) . '</div>';
                $output .= '    <div class="mor-right">'. get_next_posts_link( 'Next', $my_query->max_num_pages ) . '</div>';
            }
            else
            {
                $output .= '<div class="mor-left"><a href="'. esc_url( $atts['page_url'] ) . '">' . __( 'Se fler omdömen', 'wor' ) . '</a></div>';
            }
        $output .= '<div class="wor-clear"></div>';
        $output .= '</div>'; // end .wor-list-review-pagination
            wp_reset_postdata();
        else :
            $output .= '<h2>' . __( 'There is no post', 'wor' ) . '</h2>';
        endif;
    $output .= '</section>'; // end .wor-list-reviewed-container
    return $output;
}