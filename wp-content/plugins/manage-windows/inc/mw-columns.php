<?php
/**
 * Add more column in order post type
 */
if( ! class_exists( 'MW_COLUMNS' ) )
{
    class MW_COLUMNS
    {
        function __construct()
        {
            // Display on colmuns admin
            add_filter( 'manage_fonsterputs_posts_columns', array( $this, 'display_columns_head' ) );
            // Sort Column on colmuns admin
            add_filter( 'manage_fonsterputs_posts_columns', array( $this, 'sort_columns_head' ) );
            // Display content
            add_action( 'manage_fonsterputs_posts_custom_column', array( $this, 'display_column_content' ), 1, 2 );
	        // Display customer name column
	        add_filter( 'manage_mw_order_posts_columns', array( $this, 'display_columns_cus_order_head' ) );
	        // Display content
	        add_action( 'manage_mw_order_posts_custom_column', array( $this, 'display_column_cus_order_content' ), 1, 2 );
        }

	    // Display header on window table
        function display_columns_head( $defaults )
        {
//
            $defaults['_mw_window_image'] = __( 'Thumbnail', 'mw' );
            $defaults['_mw_window_price'] = __( 'Price', 'mw' );
            $defaults['_mw_window_cat'] = __( 'Categories', 'mw' );
            return $defaults;
        }

	    // Display header customer name on order table
	    function display_columns_cus_order_head( $defaults )
	    {
//
		    $defaults['_mw_order_cus_name'] = __( 'Cusomter Name', 'mw' );
		    return $defaults;
	    }

	    // Sort Image column before Date
        function sort_columns_head( $columns )
        {
            $crunchify_columns = array();
            $title = 'date';
            foreach($columns as $key => $value) {
                if ($key==$title){
                    $crunchify_columns['title'] = 'Title';   // Move date column before title column
                    $crunchify_columns['_mw_window_image'] = '';   // Move author column before title column
                }
                $crunchify_columns[$key] = $value;
            }
            return $crunchify_columns;
        }

		// Sort Image on column
        function display_column_content( $column_name, $post_ID )
        {
            if ( $column_name == '_mw_window_image' )
            {
                $thumbnail = get_the_post_thumbnail( $post_ID, 'mw-small-thumbnail' );

                ?>
                <div id="_emergency_field_<?php echo $post_ID; ?>"><?php echo $thumbnail; ?></div>
            <?php
            }
            if ( $column_name == '_mw_window_price' )
            {
                $window_price = get_post_meta( $post_ID, '_mw_meta_price', true );
                echo sprintf( '%s Kr', $window_price );
            }
            if ( $column_name == '_mw_window_cat' )
            {
                $terms = get_the_terms( $post_ID, 'mw_window_category' );
                if ( $terms )
                {
                    $list_cat = array();
                    foreach ( $terms as $term )
                    {
                        $list_cat[] = $term->name;
                    }
                    if ( count( $list_cat ) > 0 )
                    {
                        echo implode( ', ', $list_cat );
                    }
                }
            }
        }
	    // Sort Image on column
	    function display_column_cus_order_content( $column_name, $post_ID )
	    {
		    if ( $column_name == '_mw_order_cus_name' )
		    {
			    $order = get_post_meta( $post_ID, '_order_detail' );
			    $customer_name = $order[0]['second_name'] . ' ' . $order[0]['first_name'];
			    ?>
			    <div id="_emergency_field_<?php echo $post_ID; ?>"><?php echo $customer_name; ?></div>
		    <?php
		    }
	    }
    }
    new MW_COLUMNS;
}