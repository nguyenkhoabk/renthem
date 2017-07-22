<?php
/**
 * Register metaboxes
 */
if ( ! class_exists( 'MW_META_BOXES' ) )
{
	class MW_META_BOXES
	{
		function __construct()
		{
			add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
			// save meta boxes data on window post type
			add_action( 'save_post', array( $this, 'save_meta_boxes' ) );
			// update order
			add_action( 'save_post', array( $this, 'update_order' ) );
		}

		/*
		 * Register price meta field
		 * */
		function register_meta_boxes()
		{
            // add metabox to window
			$screen = 'fonsterputs';
			add_meta_box( 'mw_meta_price_id', __( 'Window Properties', 'mw' ), array( $this, 'meta_properties' ), $screen );
            // add metabox to order
            $screen = 'mw_order';
            add_meta_box( 'mw_order_customer', __( 'Order Information', 'mw' ), array( $this, 'order_customer' ), $screen, 'normal' );
            add_meta_box( 'mw_order_products', __( 'Products Information', 'mw' ), array( $this, 'order_product' ), $screen, 'normal' );
			// Save order
		}

		/**
		 * Render Meta Price content.
		 *
		 * @param WP_Post $post The post object.
		 */

		function meta_properties( $post )
		{
			// Add an nonce field so we can check for it later.
			wp_nonce_field( 'mw_meta_boxes', 'mw_meta_boxes_nonce' );

			// Use get_post_meta to retrieve an existing value from the database.
			$price = get_post_meta( $post->ID, '_mw_meta_price', true );
//			$model = get_post_meta( $post->ID, '_mw_meta_model', true );
			// Display the form, using the current value.
			echo '<table>';
//				echo '<tr>';
//					echo '<td>';
//						echo '<label for="mw_meta_model">';
//						_e( 'Model: ', 'mw' );
//						echo '</label> ';
//					echo '</td>';
//					echo '<td>';
//						echo '<input type="text" id="mw_meta_model" name="mw_meta_model"';
//						echo ' value="' . esc_attr( $model ) . '" size="25" />';
//					echo '</td>';
//				echo '</tr>';
				echo '<tr>';
					echo '<td>';
						echo '<label for="mw_meta_price">';
						_e( 'Price: ', 'mw' );
						echo '</label> ';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="mw_meta_price" name="mw_meta_price"';
						echo ' value="' . esc_attr( $price ) . '" size="25" />';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		}

		/**
		 * Save the meta when the post is saved.
		 *
		 * @param int $post_id The ID of the post being saved.
		 */

		function update_order( $post_id )
		{

			// Check if our nonce is set.
			if (  ! isset( $_POST['mw_order_product_nonce'] ) || ! wp_verify_nonce( $_POST['mw_order_product_nonce'], 'mw_order_product' ) )
				  return $post_id;
			// If this is an autosave, our form has not been submitted,
			//     so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;

			$order = get_post_meta( $post_id, '_order_detail' );
			$option_price = $_POST['product-option-price'];
            $add_option = $_POST['add-more-option'];
							  $add_option_2 = $_POST['add-more-option-2'];
			$init_price = get_option( '_start_price' );
			// Update the meta field.
			$products = $order[0]['products'];
			// update information
			$total_price = 0;
			foreach ( $products as $key => $value )
			{
				// remove product
				$remove_product = "remove-product-$key";
				if ( $_POST[$remove_product] == 'yes' )
				{
					unset( $products[$key] );
				}
				else
				{
					$product_qty = "product-quantity-$key";
					$new_qty = $_POST[$product_qty];
					// reassign product data
					$products[$key]['qty'] = $new_qty;
					if( $new_qty > 0 )
					{
						$product_price = get_post_meta( $key, '_mw_meta_price', true );
						$total_price += ( $new_qty * $product_price );
					}
				}
			}
			// update product in order
            if( $add_option == 'yes' )
            {
                $total_price += $option_price;
            }
						if( $add_option_2 == 'yes' )
						{
								$total_price += ( $new_qty * $add_option_2 );
						}
			if( $total_price < $init_price )
			{
				$total_price = $init_price;
			}
            $order['add_more_option'] = $add_option;
			$order['products'] = $products;
			$order['total_price'] = $total_price;
			$order['add_option_price'] = $option_price;
			// update new order information
			update_post_meta( $post_id, '_order_detail', $order );

		}

		/**
		 * Save the meta when the post is saved.
		 *
		 * @param int $post_id The ID of the post being saved.
		 */

		function save_meta_boxes( $post_id )
		{
			// Check if our nonce is set.
			if (  ! isset( $_POST['mw_meta_boxes_nonce'] ) ||  ! wp_verify_nonce( $_POST['mw_meta_boxes_nonce'], 'mw_meta_boxes' ) )
				return $post_id;

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;

			// Sanitize the user input.
			$price = sanitize_text_field( $_POST['mw_meta_price'] );
//			$model = sanitize_text_field( $_POST['mw_meta_model'] );

			// Update the meta field.
			update_post_meta( $post_id, '_mw_meta_price', $price );
//			update_post_meta( $post_id, '_mw_meta_model', $model );

			// save to order_option
			$list_windows = get_option( '_mw_sorting_windows' );
			$list_windows[] = $post_id;
			update_option( '_mw_sorting_windows', $list_windows );
		}

        /*
         * Render customer information in order detail
         * @param WP_Post $post The post object.
         *
         * */

        function  order_customer( $post )
        {
            // Add an nonce field so we can check for it later.
            wp_nonce_field( 'mw_order_customer', 'mw_order_customer_nonce' );
            $order = get_post_meta( $post->ID, '_order_detail' );
            $cus_id = $order[0]['user_id'];
            $user_data = get_userdata( $cus_id );
            $cus_name = sprintf( '%s %s', $order[0]['first_name'], $order[0]['second_name'] );
            $cus_email = $user_data->user_email;
            ?>
            <table class="order-information-container">
                <tr>
                   <td colspan="2">
                       <h3 class="mw-section-title"><?php _e( 'Kontaktperson', 'mw' ); ?></h3>
                   </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'Delivery date: ', 'mw' );?></label>
                    </td>
                    <td>
                        <?php echo esc_html( $order[0]['delivery_date'] ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'Delivery Time: ', 'mw' );?></label>
                    </td>
                    <td>
                        <?php
                        if( $order[0]['delivery_date'] == '' )
                        {
                            echo '';
                        }
                        else
                        {
                            if( $order[0]['delivery_time'] == 'morning' )
                            {
                                echo '08:00 - 12:00';
                            }
                            else if( $order[0]['delivery_time'] == 'afternoon' )
                            {
                                echo '13:00 - 17:00';
                            }
                            else
                            {
                                echo '';
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'Name: ', 'mw' );?></label>
                    </td>
                    <td>
                    <?php echo  esc_html( $cus_name ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'Tel/mobil: ', 'mw' );?></label>
                    </td>
                    <td>
                        <?php echo  esc_html( $order[0]['mobile_phone'] ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'E-post: ', 'mw' );?></label>
                    </td>
                    <td>
                        <?php echo  esc_html( $order[0]['email'] ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'Personnummer: ', 'mw' );?></label>
                    </td>
                    <td>
                        <?php echo  esc_html( $order[0]['personal'] ); ?>
                    </td>
                </tr>
            </table>
            <table class="order-information-container">
                <tr>
                    <td colspan="2">
                        <h3 class="mw-section-title"><?php _e( 'Adress', 'mw' ); ?></h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'Adress: ', 'mw' );?></label>
                    </td>
                    <td>
                        <?php echo  esc_html( $order[0]['address'] ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'Postnr: ', 'mw' );?></label>
                    </td>
                    <td>
                        <?php echo  esc_html( $order[0]['zip_code'] ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'Ort: ', 'mw' );?></label>
                    </td>
                    <td>
                        <?php echo  esc_html( $order[0]['city'] ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e( 'Portkod: ', 'mw' );?></label>
                    </td>
                    <td>
                        <?php echo  esc_html( $order[0]['door_code'] ); ?>
                    </td>
                </tr>
            </table>
            <div class="mw-clear"></div>
            <div class="mw-order-add-option">
                <input type="checkbox" value="yes" <?php checked( 'yes', $order[0]['add_more_option'] ); ?> name="add-more-option" id="add-more-option"> <label for="add-more-option"><?php _e( 'Rent Hem behöver ta med sig stege och teleskopskaft', 'mw' ); ?></label>
            </div>
						<div class="mw-order-add-option">
								<input type="checkbox" value="yes" <?php checked( 'yes', $order[0]['add_more_option_2'] ); ?> name="add-more-option-2" id="add-more-option-2"> <label for="add-more-option-2"><?php _e( 'Jag har treglas fönster (totalt 6 sidor att putsa per fönster)', 'mw' ); ?></label>
						</div>
            <?php
        }

        /*
         * Render product information in order detail
         * @param WP_Post $post The post object.
         *
         * */

        function  order_product( $post )
        {
            // Add an nonce field so we can check for it later.
            wp_nonce_field( 'mw_order_product', 'mw_order_product_nonce' );
            $order = get_post_meta( $post->ID, '_order_detail' );
//            echo '<pre>';
//            var_dump( $order );
//            echo '</pre>';
	        $option_price = $order[0]['add_option_price'];
	        $products = $order[0]['products'];
            ?>
            <h3 class="mw-section-title"><?php _e( 'Products', 'mw' ); ?></h3>
            <table class="mw-order-products">
                <tr>
                    <th>
                         <?php echo __( 'ID', 'mw' ); ?>
                    </th>'
                    <th>
                        <?php echo __( '', 'mw' ); ?>
                    </th>
                    <th>
	                    <?php echo __( 'Product Name', 'mw' ); ?>
                    </th>
                    <th>
	                    <?php echo __( 'Quantity', 'mw' ); ?>
                    </th>
                    <th>
	                    <?php echo __( 'Price', 'mw' ); ?>
                    </th>
                    <th>
	                    <?php echo __( 'Delete', 'mw' ); ?>
                    </th>
                </tr>
                <?php
                foreach( $products as $key => $value )
                {
                    $price = get_post_meta( $key, '_mw_meta_price', true );
                    ?>
                    <tr class="mw-product">
                        <td><?php echo $key; ?></td>
                        <td><?php echo get_the_post_thumbnail( $key, 'mw-small-thumbnail' ); ?></td>
                        <td><?php echo get_the_title( $key ); ?></td>
                        <td><input type="number" value="<?php echo $value['qty']; ?>" name="product-quantity-<?php echo $key; ?>" /></td>
                        <td><?php echo $price; ?></td>
                        <td><input type="checkbox" value="yes" name="remove-product-<?php echo $key; ?>" /></td>
                        <td><input type="hidden" name="product-price-<?php echo $price; ?>" /></td>
                        <td><input type="hidden" name="product-option-price" value="<?php echo $option_price; ?>" /></td>
                    </tr>
                    <?php
                }
                ?>
                <tr class="order-total">
                    <td colspan="6"><?php echo sprintf( '%s: %s %s',  __( 'Total Price' ), $order[0]['total_price'], __( ' Kr', 'mw' ) );?>
                    </td>
                </tr>
            </table>
            <?php
        }
	}
	new MW_META_BOXES;
}
