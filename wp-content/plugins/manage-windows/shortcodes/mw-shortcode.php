<?php
/**
 * Shortcodes used in plugin
 */

// shortcode display windows
add_shortcode( 'mw_list', 'mw_list_windows' );

function mw_list_windows( $atts )
{
    $atts = shortcode_atts( array(
        'number' => -1,
        'number_per_row'    =>  4,
        'add_option_price'  =>  350,
        'cat'       =>  '',
        'add_option_price_2' =>  20,
        'add_option_price_3' =>  30,
        'init_price'    =>  -1,
    ), $atts );
	// get windows order
	$window_order = array();
	if ( get_option( '_mw_sorting_windows' )  )
	{
		$window_order = get_option( '_mw_sorting_windows' );
		$window_order = array_map( 'intval', $window_order );
	}

    $args = array(
        'post_type' => 'fonsterputs',
        'posts_per_page'    =>  $atts['number'],
//        'order' =>  'ASC',
        'orderby'           =>  'post__in',
        'post__in'          =>  $window_order
    );

    if ( ! empty( $atts['cat'] ) )
    {
        $args['tax_query'] = array(
            array(
                'taxonomy'  =>  'mw_window_category',
                'field'     => 'slug',
                'terms'     => $atts['cat']
            ),
        );
    }
    $begin_row = true;
    $count_post = 0;
	$list_ids = array();
    if ( $atts['init_price'] > -1 )
    {
        $init_price = $atts['init_price'];
    }
    else
    {
        $init_price = get_option( '_start_price' );
    }
    $my_query = new WP_Query( $args );
    $output = sprintf( '<h2>%s</h2>', __( 'BOKA FöNSTERPUTSNING', 'mw' ) );
    if( isset( $_GET['action'] ) && $_GET['action'] == 'mw-add-order' )
    {
        if( isset( $_GET['message'] ) && $_GET['message'] == 'success' )
        {
			?>
            <div id="message_success" style="display:none">

                <p class="mw-message">Tack för din bokning</p>

            </div>
                <script>
                    jQuery( document ).ready( function( $ )
                    {
                        var options = {
                            backOpacity : 0,
                            speed : 300,
                            width : 250
                        };
                        var popup = new $.Popup( options );
                        popup.open( '#message_success' );
                    });
                </script>
			<?php
//            $output .= sprintf( '<p class="mw-message">%s</p>', __( 'Order Received', 'mw' ) );
        }
    }
    $output .= '<form class="mw-container" method="post">';
    if( $my_query->have_posts() ) :
        while ( $my_query->have_posts() ) : $my_query->the_post();
            // get price and model
            $price = get_post_meta( get_the_ID(), '_mw_meta_price', true );
//            $model = get_post_meta( get_the_ID(), '_mw_meta_model', true );
            if ( $begin_row )
            {
                $output .= '<div class="mw-row">';
            }
	        $list_ids[] = get_the_ID();
            $output .= '<div class="mw-window">';
            $output .= sprintf( '<p class="window-title">%s</p>', get_the_title() );
            $output .= '<a class="mw-thumbnail" data-tooltip="' . wp_strip_all_tags( get_the_content() ) . '">';
            $output .= get_the_post_thumbnail( get_the_ID() );
            $output .= '</a>';
            $output .= '<div class="mw-calculate"><a href="#" class="mw-sub">-</a><input type="text" autocomplete="false" class="mw-quantity" data-last-value="0" data-price="' . $price . '" name="mw-number-' . get_the_ID() . '" value="0"><a href="#" class="mw-add">+</a></div>';
	        $output .= '<input type="hidden" name="product-id-' . get_the_ID() . '" value="' . get_the_ID() . '"/>';
            $output .= '</div>'; // end .mw-window
            $count_post ++;
            $begin_row = false;
            if ( $count_post == $atts['number_per_row'] || $my_query->current_post == $my_query->post_count -1 )
            {
                $output .= '<div class="mw-clear"></div>'; // end.mw-clear
                $output .= '</div>'; // end .mw-row
                $begin_row = true;
                $count_post = 0;
            }
        endwhile;
        wp_reset_postdata();
        $output .= '<input class="add_option_price" name="add_option_price" type="hidden" value="' . $atts['add_option_price'] . '" />';
        $output .= '<input class="add_option_price" name="add_option_price_2" type="hidden" value="' . $atts['add_option_price_2'] . '" />';
        $output .= '<input class="add_option_price" name="add_option_price_3" type="hidden" value="' . $atts['add_option_price_3'] . '" />';

    else :
        $output .= sprintf( '<p>%s</p>', __( 'There is no window', 'mw' ) );
    endif;
    $output .= '<input type="hidden" id="mw-totally-price" name="mw-totally-price" value="0" />';
	$output .= '<input type="hidden" name="mw-list-ids" value="' . implode( ',', $list_ids ) . '" />';
	$output .= '<input type="hidden" name="mw-order-price" id="mw-order-price" value="' . $init_price . '" />';
	$output .= '<input type="hidden" name="mw-init-price-value" id="mw-init-price-value" value="' . $init_price . '" />';
    $output .= '<input type="hidden" name="mw-user-id" value="' . get_current_user_id() . '" />';
    $output .= sprintf( '<div class="window-option">%s%s</div>', '<input id="add-more-option" type="checkbox" value="yes" disabled="disabled" name="add-more-option" class="add-more-option" />', '<label class="add-option-title" for="add-more-option">Rent Hem behöver ta med sig stege och teleskopskaft</label>' );
    $output .= sprintf( '<div class="window-option">%s%s</div>', '<input id="add-more-option-2" type="checkbox" value="yes" disabled="disabled" name="add-more-option-2" class="add-more-option" />', '<label class="add-option-title" for="add-more-option-2">Jag har treglas fönster (totalt 6 sidor att putsa per fönster)</label>' );
    $output .= sprintf( '<div class="window-option">%s%s</div>', '<input id="add-more-option-3" type="checkbox" value="yes" disabled="disabled" name="add-more-option-3" class="add-more-option" />', '<label class="add-option-title" for="add-more-option-3">Tvätt av karm</label>' );

	$output .= '<div class="mw-order-information">';
	$output .= sprintf( '<h3>%s</h3>', __( 'BESTÄLLARE', 'mw' ) );

	$output .= '<div class="mw-table-row">';
	$output .= '<div class="mw-col-5">';
	$output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'VÄlJ  DATUM (*)', 'mw' ) );
	$output .= '<input type="text" name="delivery-date" id="delivery-date" placeholder="' . __( 'VÄlJ DATUM', 'mw' ) . '" />';
	$output .= '</div>'; // end .mw-col-5
    $output .= '<div class="mw-col-3">';
    $output .=  sprintf( '<label><strong>%s</strong></label>', __( 'VÄlJ  TID', 'mw' ) );
    $output .= '<label class="delivery-time-label"><input type="radio" checked name="delivery-time" value="morning" /> 08:00 - 12:00</label>';
    $output .= '<label class="delivery-time-label"><input type="radio" name="delivery-time" value="afternoon" /> 13:00 - 17:00</label>';
    $output .= '</div>'; // end .mw-col-3
	$output .= '<div class="mw-clear"></div>';
	$output .= '</div>';// end .mw-table-row

	$output .= '<div class="mw-table-row">';
	$output .= '<div class="mw-col-4">';
	$output .= sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Efternamn (*)', 'mw' ) );
	$output .= '<input type="text" id="second-name" name="second-name" placeholder="Efternamn" />';
	$output .= '</div>'; // end .mw-col-4
	$output .= '<div class="mw-col-4">';
	$output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Förnamn (*)' ) );
	$output .= '<input type="text" id="first-name" name="first-name" placeholder="Förnamn" />';
	$output .= '</div>'; // end .mw-col-4
	$output .= '<div class="mw-clear"></div>';
	$output .= '</div>'; // end .mw-table-row

	$output .= '<div class="mw-table-row">';
	$output .= '<div class="mw-col-4">';
	$output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Tel/mobil (*)' ) );
	$output .= '<input type="text" id="mobile-phone" name="mobile-phone" placeholder="Tel eller mobil" />';
	$output .= '</div>'; // end .mw-col-4
	$output .= '<div class="mw-col-4">';
	$output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'E-post (*)' ) );
	$output .= '<input type="text" id="email" name="email" placeholder="E-post" />';
	$output .= '</div>'; // end .mw-col-4
	$output .= '<div class="mw-clear"></div>';
	$output .= '</div>'; // end .mw-table-row

	$output .= '<div class="mw-table-row">';
	$output .= '<div class="mw-col-4">';
	$output .=  sprintf( '<label>%s</label>', __( 'Personnummer (RUT-avdrag)' ) );
	$output .= '<input type="text" id="personal" name="personal" placeholder="Personnummer" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-clear"></div>';
    $output .= '</div>'; // end .mw-table-row
    $output .= '<div class="mw-table-row">';
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s</label>', __( 'Meddelande' ) );
    $output .= '<textarea rows="6" cols="60" style=" width: 92%; " id="meddelande" name="meddelande" placeholder="Meddelande" ></textarea>';
	$output .= '</div>'; // end .mw-col-4
	$output .= '<div class="mw-clear"></div>';
	$output .= '</div>'; // end .mw-table-row

	$output .= '</div>'; // end .mw-order-information

	$output .= '<div class="mw-order-address">';
	$output .= sprintf( '<h3>%s</h3>', __( 'Adress', 'mw' ) );

	$output .= '<div class="mw-table-row">';
	$output .= '<div class="mw-col-4">';
	$output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Adress (*)', 'mw' ) );
	$output .= '<input type="text" id="address" name="address" placeholder="Adress" />';
	$output .= '</div>'; // end .mw-col-4
	$output .= '<div class="mw-col-4">';
	$output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Postnr (*)', 'mw' ) );
	$output .= '<input type="text" id="zip-code" name="zip-code" placeholder="Postnr" />';
	$output .= '</div>'; // end .mw-col-4
	$output .= '<div class="mw-col-4">';
	$output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Ort (*)', 'mw' ) );
	$output .= '<input type="text" id="city" name="city" placeholder="Ort" />';
	$output .= '</div>'; // end .mw-col-4
	$output .= '<div class="mw-clear"></div>';
	$output .= '</div>'; // end .mw-table-row

	$output .= '<div class="mw-table-row">';
	$output .= '<div class="mw-col-4">';
	$output .=  sprintf( '<label>%s</label>', __( 'Portkod', 'mw' ) );
	$output .= '<input type="text" id="door-code" name="door-code" placeholder="Portkod" />';
	$output .= '</div>'; // end .mw-col-4
	$output .= '<div class="mw-clear"></div>';
	$output .= '</div>'; // end .mw-table-row

	$output .= '</div>'; // end .mw-order-address

    $output .= '<input id="mw_list_layout" type="hidden" name="mw_list_layout" value="layout_1" />'; // layout type

    $output .= sprintf( '<div class="mw-init-price mw-left mw-col-4"><strong><span class="mw-price-title">%s: </span><span id="mw-total-price-display" data-init-price="' . $init_price . '">%s</span><span class="mw-price-currency">%s</span></strong><p>%s</p></div>  <div class="mw-place-order mw-right">%s</div>', __( 'Totalpris', 'mw' ), 0, __( ' Kr', 'mw' ), __( '*Priset ovanför är 50% efter skattereduktion', 'mw' ) ,'<input class="mw-button-place-order" id="mw-button-place-order" type="submit" value="Boka" />' );

   if( isset( $_GET['action'] ) && $_GET['action'] == 'mw-add-order' )
    {
        if( isset( $_GET['message'] ) && $_GET['message'] == 'success' )
        {
			?>
            <div id="message_success" style="display:none">

                <p class="mw-message">Tack för din bokning</p>

            </div>
                <script>
                    jQuery( document ).ready( function( $ )
                    {

						if (document.getElementById("message_success").style.display === 'none') {
        document.getElementById("message_success").style.display = 'block';
    } else {
        document.getElementById("message_success").style.display = 'none';
    }
                        var options = {
                            backOpacity : 0,
                            speed : 300,
                            width : 250
                        };
                        var popup = new $.Popup( options );
                        show( '#message_success' );
                    });
                </script>
			<?php
//            $output .= sprintf( '<p class="mw-message">%s</p>', __( 'Order Received', 'mw' ) );
        }
    }

   $output .= '<div class="mw-clear"></div>';
    $output .= wp_nonce_field( 'place-order', 'place-order-nonce' );
    $output .= '</form>'; // end .mw-container
    return $output;
}

// shortcode display windows layout 2
add_shortcode( 'mw_list_second', 'mw_list_windows_second' );
function mw_list_windows_second( $atts )
{
    $atts = shortcode_atts( array(
        'number' => -1,
        'number_per_row'    =>  4,
        'add_option_price'  =>  350,
        'cat'       =>  '',
        'add_option_price_2' =>  20,
        'add_option_price_3' =>  30,
        'init_price'    =>  -1,
    ), $atts );
    // get windows order
    $window_order = array();
    if ( get_option( '_mw_sorting_windows' )  )
    {
        $window_order = get_option( '_mw_sorting_windows' );
        $window_order = array_map( 'intval', $window_order );
    }

    $args = array(
        'post_type' => 'fonsterputs',
        'posts_per_page'    =>  $atts['number'],
//        'order' =>  'ASC',
        'orderby'           =>  'post__in',
        'post__in'          =>  $window_order
    );

    if ( ! empty( $atts['cat'] ) )
    {
        $args['tax_query'] = array(
            array(
                'taxonomy'  =>  'mw_window_category',
                'field'     => 'slug',
                'terms'     => $atts['cat']
            ),
        );
    }
    $begin_row = true;
    $count_post = 0;
    $list_ids = array();
    if ( $atts['init_price'] > -1 )
    {
        $init_price = $atts['init_price'];
    }
    else
    {
        $init_price = get_option( '_start_price' );
    }
    $my_query = new WP_Query( $args );
    $output = sprintf( '<h2>%s</h2>', __( 'FÖNSTERPUTS FÖR FÖRETAG', 'mw' ) );
    if( isset( $_GET['action'] ) && $_GET['action'] == 'mw-add-order' )
    {
        if( isset( $_GET['message'] ) && $_GET['message'] == 'success' )
        {
            ?>
            <div id="message_success" style="display:none">

                <p class="mw-message">Tack för din bokning</p>

            </div>
            <script>
                jQuery( document ).ready( function( $ )
                {
                    var options = {
                        backOpacity : 0,
                        speed : 300,
                        width : 250
                    };
                    var popup = new $.Popup( options );
                    popup.open( '#message_success' );
                });
            </script>
            <?php
//            $output .= sprintf( '<p class="mw-message">%s</p>', __( 'Order Received', 'mw' ) );
        }
    }
    $output .= '<form class="mw-container" method="post">';
    if( $my_query->have_posts() ) :
        while ( $my_query->have_posts() ) : $my_query->the_post();
            // get price and model
            $price = get_post_meta( get_the_ID(), '_mw_meta_price', true );
//            $model = get_post_meta( get_the_ID(), '_mw_meta_model', true );
            if ( $begin_row )
            {
                $output .= '<div class="mw-row">';
            }
            $list_ids[] = get_the_ID();
            $output .= '<div class="mw-window">';
            $output .= sprintf( '<p class="window-title">%s</p>', get_the_title() );
            $output .= '<a class="mw-thumbnail" data-tooltip="' . wp_strip_all_tags( get_the_content() ) . '">';
            $output .= get_the_post_thumbnail( get_the_ID() );
            $output .= '</a>';
            $output .= '<div class="mw-calculate"><a href="#" class="mw-sub">-</a><input type="text" autocomplete="false" class="mw-quantity" data-last-value="0" data-price="' . $price . '" name="mw-number-' . get_the_ID() . '" value="0"><a href="#" class="mw-add">+</a></div>';
            $output .= '<input type="hidden" name="product-id-' . get_the_ID() . '" value="' . get_the_ID() . '"/>';
            $output .= '</div>'; // end .mw-window
            $count_post ++;
            $begin_row = false;
            if ( $count_post == $atts['number_per_row'] || $my_query->current_post == $my_query->post_count -1 )
            {
                $output .= '<div class="mw-clear"></div>'; // end.mw-clear
                $output .= '</div>'; // end .mw-row
                $begin_row = true;
                $count_post = 0;
            }
        endwhile;
        wp_reset_postdata();
        $output .= '<input class="add_option_price" name="add_option_price" type="hidden" value="' . $atts['add_option_price'] . '" />';
        $output .= '<input class="add_option_price" name="add_option_price_2" type="hidden" value="' . $atts['add_option_price_2'] . '" />';
        $output .= '<input class="add_option_price" name="add_option_price_3" type="hidden" value="' . $atts['add_option_price_3'] . '" />';

    else :
        $output .= sprintf( '<p>%s</p>', __( 'There is no window', 'mw' ) );
    endif;
    $output .= '<input type="hidden" id="mw-totally-price" name="mw-totally-price" value="0" />';
    $output .= '<input type="hidden" name="mw-list-ids" value="' . implode( ',', $list_ids ) . '" />';
    $output .= '<input type="hidden" name="mw-order-price" id="mw-order-price" value="' . $init_price . '" />';
    $output .= '<input type="hidden" name="mw-init-price-value" id="mw-init-price-value" value="' . $init_price . '" />';
    $output .= '<input type="hidden" name="mw-user-id" value="' . get_current_user_id() . '" />';
    $output .= sprintf( '<div class="window-option">%s%s</div>', '<input id="add-more-option" type="checkbox" value="yes" disabled="disabled" name="add-more-option" class="add-more-option" />', '<label class="add-option-title" for="add-more-option">Rent Hem behöver ta med sig stege och teleskopskaft</label>' );
    $output .= sprintf( '<div class="window-option">%s%s</div>', '<input id="add-more-option-2" type="checkbox" value="yes" disabled="disabled" name="add-more-option-2" class="add-more-option" />', '<label class="add-option-title" for="add-more-option-2">Jag har treglas fönster (totalt 6 sidor att putsa per fönster)</label>' );
    $output .= sprintf( '<div class="window-option">%s%s</div>', '<input id="add-more-option-3" type="checkbox" value="yes" disabled="disabled" name="add-more-option-3" class="add-more-option" />', '<label class="add-option-title" for="add-more-option-3">Tvätt av karm</label>' );

    $output .= '<div class="mw-order-information">';
    $output .= sprintf( '<h3>%s</h3>', __( 'BESTÄLLARE', 'mw' ) );

    $output .= '<div class="mw-table-row">';
    $output .= '<div class="mw-col-5">';
    $output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'VÄlJ  DATUM (*)', 'mw' ) );
    $output .= '<input type="text" name="delivery-date" id="delivery-date" placeholder="' . __( 'VÄlJ DATUM', 'mw' ) . '" />';
    $output .= '</div>'; // end .mw-col-5
    $output .= '<div class="mw-col-3">';
    $output .=  sprintf( '<label><strong>%s</strong></label>', __( 'VÄlJ  TID', 'mw' ) );
    $output .= '<label class="delivery-time-label"><input type="radio" checked name="delivery-time" value="morning" /> 08:00 - 12:00</label>';
    $output .= '<label class="delivery-time-label"><input type="radio" name="delivery-time" value="afternoon" /> 13:00 - 17:00</label>';
    $output .= '</div>'; // end .mw-col-3
    $output .= '<div class="mw-clear"></div>';
    $output .= '</div>';// end .mw-table-row

    $output .= '<div class="mw-table-row">';
    $output .= '<div class="mw-col-4">';
    $output .= sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Fullständigt namn (*)', 'mw' ) );
    $output .= '<input type="text" id="second-name" name="second-name" placeholder="Fullständigt namn" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-clear"></div>';
    $output .= '</div>'; // end .mw-table-row

    $output .= '<div class="mw-table-row">';
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Företagsnamn (*)' ) );
    $output .= '<input type="text" id="first-name" name="first-name" placeholder="Företagsnamn" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Organisationsnummer (*) ' ) );
    $output .= '<input type="text" id="organisation" name="organisation" placeholder="Organisations nummer" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-clear"></div>';
    $output .= '</div>'; // end .mw-table-row

    $output .= '<div class="mw-table-row">';
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Tel/mobil (*)' ) );
    $output .= '<input type="text" id="mobile-phone" name="mobile-phone" placeholder="Tel eller mobil" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'E-post (*)' ) );
    $output .= '<input type="text" id="email" name="email" placeholder="E-post" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-clear"></div>';
    $output .= '</div>'; // end .mw-table-row

    $output .= '</div>'; // end .mw-order-information

    $output .= '<div class="mw-order-address">';
    $output .= sprintf( '<h3>%s</h3>', __( 'Adress', 'mw' ) );

    $output .= '<div class="mw-table-row">';
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Adress (*)', 'mw' ) );
    $output .= '<input type="text" id="address" name="address" placeholder="Adress" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-clear"></div>';
    $output .= '</div>'; // end .mw-table-row

    $output .= '<div class="mw-table-row">';
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Postnr (*)', 'mw' ) );
    $output .= '<input type="text" id="zip-code" name="zip-code" placeholder="Postnr" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s<span class="require-field"></span></label>', __( 'Ort (*)', 'mw' ) );
    $output .= '<input type="text" id="city" name="city" placeholder="Ort" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-clear"></div>';
    $output .= '</div>'; // end .mw-table-row

    $output .= '<div class="mw-table-row">';
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s</label>', __( 'Portkod', 'mw' ) );
    $output .= '<input type="text" id="door-code" name="door-code" placeholder="Portkod" />';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-clear"></div>';
    $output .= '</div>'; // end .mw-table-row

    $output .= '<div class="mw-table-row">';
    $output .= '<div class="mw-col-4">';
    $output .=  sprintf( '<label>%s</label>', __( 'Meddelande' ) );
    $output .= '<textarea rows="6" cols="60" style=" width: 92%; " id="meddelande" name="meddelande" placeholder="Meddelande" ></textarea>';
    $output .= '</div>'; // end .mw-col-4
    $output .= '<div class="mw-clear"></div>';
    $output .= '</div>'; // end .mw-table-row

    $output .= '</div>'; // end .mw-order-address

    $output .= '<input id="mw_list_layout" type="hidden" name="mw_list_layout" value="layout_2" />'; // layout type

    $output .= sprintf( '<div class="mw-init-price mw-left mw-col-4"><strong><span class="mw-price-title">%s: </span><span id="mw-total-price-display" data-init-price="' . $init_price . '">%s</span><span class="mw-price-currency">%s</span></strong><p>%s</p></div>  <div class="mw-place-order mw-right">%s</div>', __( 'Totalpris', 'mw' ), 0, __( ' Kr', 'mw' ), __( '*Priset ovanför är exkl. moms', 'mw' ) ,'<input class="mw-button-place-order" id="mw-button-place-order" type="submit" value="Boka" />' );

    if( isset( $_GET['action'] ) && $_GET['action'] == 'mw-add-order' )
    {
        if( isset( $_GET['message'] ) && $_GET['message'] == 'success' )
        {
            ?>
            <div id="message_success" style="display:none">

                <p class="mw-message">Tack för din bokning</p>

            </div>
            <script>
                jQuery( document ).ready( function( $ )
                {

                    if (document.getElementById("message_success").style.display === 'none') {
                        document.getElementById("message_success").style.display = 'block';
                    } else {
                        document.getElementById("message_success").style.display = 'none';
                    }
                    var options = {
                        backOpacity : 0,
                        speed : 300,
                        width : 250
                    };
                    var popup = new $.Popup( options );
                    show( '#message_success' );
                });
            </script>
            <?php
//            $output .= sprintf( '<p class="mw-message">%s</p>', __( 'Order Received', 'mw' ) );
        }
    }

    $output .= '<div class="mw-clear"></div>';
    $output .= wp_nonce_field( 'place-order', 'place-order-nonce' );
    $output .= '</form>'; // end .mw-container
    return $output;
}

