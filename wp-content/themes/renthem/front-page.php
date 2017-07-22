<?php /*** Template Name: Startowa**/get_header(); ?><div id="top-bar-1"><a class="logo" href="<?php echo get_home_url(); ?>"></a><div class="mini"><div class="topmini"></div><div class="top-number">info@renthem.se <br /> 08-82 44 77 </div></div><div class="big"><div class="top-number">info@renthem.se <br /> <a href="tel:+468824477">08-82 44 77</a> </div><div class="top"></div></div></div><!-- /#top-bar-1 --> <style type="text/css"> a {text-decoration:none;color : #000000;} </style>



<div id="menu-bar-1"><?php wp_nav_menu(array('menu' => 'Menu')); ?></div>



<?php dynamic_sidebar( 'menures' ); ?>

<div id="slider-1">



<img class="slider" src="<?php bloginfo('template_url'); ?>/images/slide1.jpg" alt="Rent Hem Stockholm" title="Rent Hem Stockholm">



<img class="women"src="<?php bloginfo('template_url'); ?>/images/Rent_Hem_Stockholm.png" alt="Rent Hem Stockholm" title="Rent Hem Stockholm">





 </div>

<!-- /#slider -->

<link rel="stylesheet" type="text/css" href="//renthem.dev/wp-admin/booking_v2/ustawienia.css" media="screen" />    

<link rel="stylesheet" href="//renthem.dev/wp-admin/booking_v2/css/new_calendar.css" type="text/css" />	

<script src="//renthem.dev/wp-admin/booking_v2/js/new-calendar.js"></script>	

<script src="//renthem.dev/wp-admin/booking_v2/js/book-script-form.js"></script>									

<div id="calendar-cont" style=" box-shadow: 4px 0px 5px #D1D1D1; "></div>	



<div class="bodyhome"> <?php dynamic_sidebar( 'homeinfo' ); ?> </div>



<div id="main-bar">

<div class="content">



<div class="block"><center><a href="<?php echo get_option('siteurl'); ?>/tjanster-priser/hemstadning-stockholm/"><img src="<?php bloginfo('template_url'); ?>/images/hemstädning.png"></a></center><?php ShowPageShort(1108); ?><!-- mt 21/51/1108 --></div>

<div class="block"><center><a href="<?php echo get_option('siteurl'); ?>/tjanster-priser/storstadning-stockholm/"><img src="<?php bloginfo('template_url'); ?>/images/storstädning.png"></a></center><?php ShowPageShort(53); ?><!-- 25/53 --></div>





<div class="block"><center><a href="<?php echo get_option('siteurl'); ?>/tjanster-priser/flyttstadning/"><img src="<?php bloginfo('template_url'); ?>/images/flyttstädning.png"></a></center><?php ShowPageShort(57); ?><!-- 29/57 --></div>

<div class="block"><center><a href="<?php echo get_option('siteurl'); ?>/tjanster-priser/storstadning-stockholm/"><img src="<?php bloginfo('template_url'); ?>/images/kontorsstädning.png"></a></center><?php ShowPageShort(55); ?><!-- 27/55 --></div>




<?php do_action( 'before_end_frontpage_main_content' ); ?>

</div></div><!-- /#main-bar --><div id="bignews">



  





<?php dynamic_sidebar( 'bignews' ); ?><?php dynamic_sidebar( 'img' ); ?></div><?php dynamic_sidebar( 'news' ); ?><?php get_footer(); ?>