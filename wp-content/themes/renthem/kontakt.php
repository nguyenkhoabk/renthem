<?php 

/**
* Template Name: Kontakt
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




<div id="slider-1">

 <?php dynamic_sidebar( 'slider' ); ?> 

</div><!-- /#slider -->






<div class="content-all" id="maps">
<div style="position: absolute; top: 80px; left: 685px;" id="myPointer"><img src="https://renthem.se/wp-content/uploads/2014/10/point.png" class="attachment-full" alt="point" width="53" height="83"></div>

<div class="leftk">
<?php ShowPageTitle(); ?>
<?php ShowPagePosts(); ?>

</div>
<div class="rightk">
 <?php dynamic_sidebar( 'ckontakt' ); ?> 
</div>
<style>

.rightk .simple-image {

  display: none;
}
.rightk .simple-image img {

  display: none;
}
.rightk .textwidget {

  margin-top: 110px;
}
#maps {

  position: relative;
}
@media screen and (max-width: 1100px) {	

#myPointer {
  display: none;
}

}

</style>

</div>



 <?php dynamic_sidebar( 'homeinfo' ); ?> 








<?php get_footer(); ?>

