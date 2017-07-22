<?php
/*
 * Order class
 * */

if ( ! class_exists( 'MW_ORDER' ) )
{
	class MW_ORDER
	{
		function __construct()
		{
			// Class make an order when form is submitted
			add_action( 'template_redirect', array( $this, 'make_order' ) );
			// Change wordpress mail name
//			add_filter( 'wp_mail_from_name', array( $this, 'my_mail_from_name' ) );
			//notification mail email change
//			add_filter('wp_mail_from', array( $this, 'custom_email_from' ));
		}

		function my_mail_from_name()
		{
			return "Rent Hem – Fönsterputs ";
		}

		function custom_email_from( $mail )
		{
			$mail = ' info@renthem.se';  // Replace the email address here //
			return $mail;
		}
		/*
		 * Make an order
		 * @void
		 * */
		function make_order()
		{
			if( isset( $_POST['place-order-nonce'] ) && wp_verify_nonce( $_POST['place-order-nonce'], 'place-order' ) )
			{
				$products_id = explode( ',' ,$_POST['mw-list-ids'] );
                $product_info = array();
                $message_product = '';
				foreach ( $products_id as $id)
				{
                    $product_amount = "mw-number-$id";
                    if ( $_POST[$product_amount] > 0 )
                    {
                        $message_product .= '<br>';
                        $message_product .= sprintf( '%s: %s st', get_the_title( $id ), $_POST[$product_amount] );
                    }
				}
                // save information to order
                $order['user_id'] = $_POST['mw-user-id'];
                $order['products'] = $product_info;
                $order['total_price'] = $_POST['mw-order-price'];
				$order['add_option_price'] = $_POST['add_option_price'];
				$order['add_option_price_2'] = $_POST['add_option_price_2'];
                $order['add_more_option'] = $_POST['add-more-option'];
                $order['add_more_option_2'] = $_POST['add-more-option-2'];
                $order['add_more_option_3'] = $_POST['add-more-option-3'];
				$order['delivery_date'] =   $_POST['delivery-date'];
                $order['delivery_time'] = $_POST['delivery-time'];
                $order['second_name'] = $_POST['second-name'];
                $order['first_name'] = $_POST['first-name'];
                $order['mobile_phone'] = $_POST['mobile-phone'];
                $order['email'] = $_POST['email'];
                $order['personal'] = $_POST['personal'];
                $order['organisation'] = $_POST['organisation'];
                $order['meddelande'] = $_POST['meddelande'];
                $order['address'] = $_POST['address'];
                $order['zip_code'] = $_POST['zip-code'];
                $order['city'] = $_POST['city'];
                $order['door_code'] = $_POST['door-code'];
                $order['layout'] = $_POST['mw_list_layout'];
                $post_args = array(
                    'post_title'    =>  '',
                    'post_content'  =>  '',
                    'post_type'     =>  'mw_order',
                    'post_status'   => 'publish',
                );
                // Insert the post into the database
                $order_id = wp_insert_post( $post_args );
                if ( ! is_wp_error( $order_id ) )
                {
                    wp_update_post( array(
                        'ID'            =>  $order_id,
                        'post_title'    =>  "#$order_id",
                    ) );
                    // add order meta
                    add_post_meta( $order_id, '_order_detail', $order );

                    // send email to admin and customer
                    // Admin
	                if( $order['delivery_date'] != '' )
	                {
		                if( $order['delivery_time'] == 'morning' )
		                {
							$delivery_time = '08:00 - 12:00';
		                }
		                else if( $order['delivery_time'] == 'afternoon' )
		                {
			                $delivery_time = '13:00 - 17:00';
		                }
	                }
	                $more_option = $order['add_more_option'] == 'yes' ? 'JA' : 'Nej';
					$more_option_2 = $order['add_more_option_2'] == 'yes' ? 'JA' : 'Nej';
                    $more_option_3 = $order['add_more_option_3'] == 'yes' ? 'JA' : 'Nej';
	                $admin_email = 'info@renthem.se';
//                    $message .= '<br><strong>Order Detail:</strong></p>';

                    if ( 'layout_1' == $order['layout'] )
                    {
                        $subject = __( 'Ny	Bokning	Fönsterputs', 'mw' );
                        $message  = '<h2 style="text-align: center; font-weight: bold">NY	FÖNSTERPUTS	BOKNING</h2>';
                        $message .= '<br> Namn: ' . $order['second_name'] . ' ' . $order['first_name'];
                        $message .= '<br> Adress: ' . $order['address'];
                        $message .= '<br> PostAdress: ' . $order['city'] . ' ' . $order['zip_code'];
                        $message .= '<br> Portkod: ' . $order['door_code'];
                        $message .= '<br> Personnummer: ' . $order['personal'];
                        $message .= '<br> Meddelande: ' . $order['meddelande'];
                        $message .= '<br>';
                        $message .= '<br> Mobilnr: ' . $order['mobile_phone'];
                        $message .= '<br> Email: ' . $order['email'];
                        $message .= '<br>';
                        $message .= '<br> Datum: ' . $order['delivery_date'];
                        $message .= '<br> Tid: ' . $delivery_time;
                        $message .= '<br>';
                        $message .= '<br>';
                        $message .= '<h3 style="margin-bottom: 0px">Beställda	fönster</h3>';
                        $message .= $message_product;
                        $message .= '<br>';
                        $message .= 'Ta med stege & teleskopskaft: ' . $more_option;
                        $message .= '<br>';
                        $message .= 'Treglas fönster: ' . $more_option_2;
                        $message .= '<br>';
                        $message .= 'Tvätt av karm: ' . $more_option_3;
                        $message .= '<br>---------------------';
                        $message .= sprintf( '<br>Totalt: %s %s', $order['total_price'], 'kr' );
                    }
                    elseif( 'layout_2' == $order['layout'] )
                    {
                        $subject = __( 'Ny	Bokning	Fönsterputs FÖRETAG', 'mw' );
                        $message  = '<h2 style="text-align: center; font-weight: bold">NY	FÖNSTERPUTS	BOKNING FÖRETAG</h2>';
                        $message .= '<br> Namn: ' . $order['second_name'];
                        $message .= '<br> Företagsnamn: ' . $order['first_name'];
                        $message .= '<br> Organisationsnummer: ' . $order['organisation'];
                        $message .= '<br> Adress: ' . $order['address'];
                        $message .= '<br> PostAdress: ' . $order['zip_code'] . ' ' . $order['city'];
                        $message .= '<br> Portkod: ' . $order['door_code'];
                        $message .= '<br>';
                        $message .= '<br> Mobilnr: ' . $order['mobile_phone'];
                        $message .= '<br> Email: ' . $order['email'];
                        $message .= '<br>';
                        $message .= '<br> Datum: ' . $order['delivery_date'];
                        $message .= '<br> Tid: ' . $delivery_time;
                        $message .= '<br> Meddelande: ' . $order['meddelande'];
                        $message .= '<br>';
                        $message .= '<br>';
                        $message .= '<h3 style="margin-bottom: 0px">Beställda	fönster</h3>';
                        $message .= $message_product;
                        $message .= '<br>';
                        $message .= 'Ta med stege & teleskopskaft: ' . $more_option;
                        $message .= '<br>';
                        $message .= 'Treglas fönster: ' . $more_option_2;
                        $message .= '<br>';
                        $message .= 'Tvätt av karm: ' . $more_option_3;
                        $message .= '<br>---------------------';
                        $message .= sprintf( '<br>Totalt: %s %s', $order['total_price'], 'kr' );
                        $message .= '<br><span style="font-size: 10px"><sup>*</sup>Priset ovanför är exkl. moms</span>';
                    }


                    if ( 'layout_1' == $order['layout'] )
                    {
                        $headers[] = 'From: Rent Hem – Fönsterputs <info@renthem.se>';
                    }
                    elseif( 'layout_2' == $order['layout'] )
                    {
                        $headers[] = 'From: Rent Hem – Fönsterputs Företag <info@renthem.se>';
                    }

                    $headers[] = 'Content-Type: text/html; charset=UTF-8';
                    wp_mail( $admin_email, $subject, $message, $headers );

                    // send to customer
                    $cus_email = $order['email'];
                    $rep_subject = __( 'Tack för din bokning', 'mw' );
                    $rep_message = '<p style="text-align: center; font-size: 18px">Tack	för	din	bokning!</p>';
	                $rep_message .= '<br>';
                    if ( 'layout_1' == $order['layout'] )
                    {
                        $rep_message .= 'Vi har tagit emot eran bokning, inom 2 timmar skickar vi en	bokningsbekräftelse.';
                    }
                    elseif( 'layout_2' == $order['layout'] )
                    {
                        $rep_message .= 'Vi har tagit emot eran bokning, inom 2 arbetstimmar skickar vi en	bokningsbekräftelse.';
                    }

	                $rep_message .= '<br>';
	                $rep_message .= '<br>';
	                $rep_message .= '<br>';
	                $rep_message .= 'Din bokning innehåller	följande:';
	                $rep_message .= '<br>';
	                $rep_message .= $message_product;
	                $rep_message .= '<br>';
	                $rep_message .= 'Ta med stege & teleskopskaft: ' . $more_option;
									$rep_message .= '<br>';
									$rep_message .= 'Treglas fönster: ' . $more_option_2;
	                $rep_message .= '<br>---------------------';
	                $rep_message .= sprintf( '<br>Totalt: %s %s', $order['total_price'], 'kr' );
                    if ( 'layout_1' == $order['layout'] )
                    {
                        $rep_message .= '<br><span style="font-size: 10px"><sup>*</sup>priset ovanför är efter RUT</span>';
                    }
                    elseif ( 'layout_2' == $order['layout'] )
                    {
                        $rep_message .= '<br><span style="font-size: 10px"><sup>*</sup>Priset ovanför är exkl. moms</span>';
                    }
	                $rep_message .= '<br>';
	                $rep_message .= '<br>';
	                $rep_message .= '<br>Med Vänlig	Hälsning';
	                $rep_message .= '<br>www.renthem.se';
                    if ( 'layout_2' == $order['layout'] )
                    {
                        $rep_message .= '<br>08-82 44 77';
                    }
                    if ( 'layout_1' == $order['layout'] )
                    {
                        $headers_client[] = 'From: Rent Hem – Fönsterputs <info@renthem.se>';
                    }
                    elseif ( 'layout_2' == $order['layout'] )
                    {
                        $headers_client[] = 'From: Rent Hem – Fönsterputs Företag <info@renthem.se>';
                    }

	                $headers_client[] = 'Content-Type: text/html; charset=UTF-8';
                    wp_mail( $cus_email, $rep_subject, $rep_message, $headers_client );

                    $success_url = add_query_arg( array(
                        'action'    =>  'mw-add-order',
                        'message'   =>  'success'
                    ), get_the_permalink() );
                    wp_safe_redirect( $success_url );
                    exit;
                }
			}
		}
	}
	new MW_ORDER;
}
