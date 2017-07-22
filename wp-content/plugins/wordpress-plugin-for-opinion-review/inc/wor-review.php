<?php
if( ! class_exists( 'WOR_REVIEW' ) )
{
    /*
     * Class execute data when form is submittted
     *
     * */
     class WOR_REVIEW
     {

         /*
          * Register hooks for save data when form is submitted
          * @return void
          * */
         function __construct()
         {
            add_action( 'template_redirect', array( $this, 'add_new_review' ) );
         }

         /*
          * Adding new review
          * @return void
          * */
         function add_new_review()
         {
            if( isset( $_POST['review-nonce'] ) && wp_verify_nonce( $_POST['review-nonce'], 'mor-review' ) )
            {
                $rating_value = $_POST['mor-rating-value'];
                $topic = $_POST['wor-review-topic'];
                $first_name = $_POST['wor-review-first-name'];
                $last_name = $_POST['wor-review-last-name'];
                $city = $_POST['wor-review-city'];
                $review = $_POST['wro-review-review'];
                $title = $topic;
                $args = array(
                    'post_content'  =>  $review,
                    'post_title'    =>  $title,
                    'post_type'     =>  'review',
                    'post_status'   =>  'draft'
                );
                // insert post
                $post_id = wp_insert_post( $args );
                if( ! is_wp_error( $post_id ) )
                {
                    // add post metas
                    $review_metas = array(
                        'rating'        =>  $rating_value,
                        'first_name'    =>  $first_name,
                        'last_name'     =>  $last_name,
                        'city'          =>  $city,
                        'posted_date'   =>  get_the_date( 'Y-m-d', $post_id ),
                    );
                    add_post_meta( $post_id, '_wor_review_metas', $review_metas );

	                // Redirect and add param on query URL if submit review success
	                $success_url = add_query_arg( array(
		                'action'    =>  'wor-submit-review',
		                'message'   =>  'success'
	                ), get_the_permalink() );
	                wp_safe_redirect( $success_url );
	                exit;
                }
            }
         }
     }
     new WOR_REVIEW;
}