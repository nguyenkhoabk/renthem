<?php 

/**
* Template Name: Default
*
*/

get_header(); ?>



<div id="top-bar-1">



<a class="logo" href="<?php echo get_home_url(); ?>"></a>

<div class="mini">
<div class="topmini"></div>
<div class="top-number">info@renthem.se <br /> 08-82 44 77 </div>
</div>

<div class="big">
<div class="top-number">info@renthem.se <br /> 08-82 44 77 </div>
<div class="top"></div>
</div>



</div><!-- /#top-bar-1 -->


<div id="menu-bar-1">




			<?php wp_nav_menu(array('menu' => 'Menu')); ?>


</div><!-- /#menu-bar-1 -->

<?php dynamic_sidebar( 'menures' ); ?>


<div id="slider-1">

 <?php dynamic_sidebar( 'slider' ); ?> 

</div><!-- /#slider -->






<div class="content-all">

<?php ShowPageTitle(); ?>
<?php ShowPagePosts(); ?>




</div>



 <?php dynamic_sidebar( 'homeinfo' ); ?> 








<?php get_footer(); ?>



