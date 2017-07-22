<?php
if( ! class_exists( 'WOR_SLIDE_OUT' ) )
{
    /**
     * Class display tab slide out on homepage
     * */
    class WOR_SLIDE_OUT
    {
        /**
         * Class constructor
         *
         * */
        function __construct()
        {
            add_action( 'wp_footer', array( $this, 'display_tab_reviews' ) );
        }

        /**
         * Output tab slide out and list reviews on it
         * */
        function display_tab_reviews()
        {
            $options = get_option( '_wor_tab_slide' );
            $display = $options['show'];
            $number_post = $options['number'];
            $url = $options['url'];
            if( $display == 'yes' )
            {

        ?>
                <div class="pollSlider">
                    <span class="wor-close-tab-button">Close</span>
                    <div class="wor-clear"></div>
                    <?php
                    $args = array(
                        'post_type'         => 'review',
                        'posts_per_page'    =>  $number_post,
                    );
                    $my_query = new WP_Query( $args );
                    if( $my_query->have_posts() ) :
                        while( $my_query->have_posts() ) : $my_query->the_post();
                            $metas = get_post_meta( get_the_ID(), '_wor_review_metas', true );
                            $first_name = $metas['first_name'];
                            $last_name = $metas['last_name'];
                            $name = sprintf( '%s %s', $first_name, mb_substr( $last_name, 0, 1 ) );
                            $posted_date = $metas['posted_date'];
                            if( $posted_date == '' )
                            {
                                $posted_date = get_the_date('Y-m-d');
                            }
                        ?>
                            <div class="wor-tab-slide-item">
                                <div class="wor-tab-slide-item-header">
                                    <div class="mor-tab-rating-item" data-score="<?php echo $metas['rating']; ?>"></div><span class="mor-rating-time-publish"><?php echo $posted_date; ?></span>
                                </div>
                                <h4><?php echo get_the_title(); ?></h4>
                                <p><?php echo get_the_excerpt(); ?></p>
                                <div class="wor-tab-slide-item-footer">
                                    <span><?php echo sprintf( '%s, %s', $name, $metas['city'] ); ?></span>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <h3>There is not review.</h3>
                    <?php
                    endif;
                    ?>
                    <div class="wor-list-review-pagination"><a href="<?php echo esc_url( $url )?>"><?php echo __( 'Se fler omdömen', 'wor' ); ?></a></div>
                </div>
                <div id="pollSlider-button">
                    <div class="pollSldier-button-text">
                        <span>O</span>
                        <span>M</span>
                        <span>D</span>
                        <span>Ö</span>
                        <span>M</span>
                        <span>E</span>
                    </div>
                    <div class="wor-close-tab wor-tab-hide" href="#">Close tab</div>
                </div>
        <?php
            }
        }
    }
    new WOR_SLIDE_OUT;
}