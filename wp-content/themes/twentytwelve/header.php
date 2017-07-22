<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?><link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="https://www.dropbox.com/s/dd991fyp260jygs/jquery-fancybox.css" />
<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700,500&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/js/jquery.fancybox-1.3.4.pack.js"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_url'); ?>/css/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="stylesheet" type="text/css" href="https://www.dropbox.com/s/wy0m668x1vz7wrw/rent-home.css" />

<script type="text/javascript">
	function ClearAmt()
	{
		document.getElementById("totalamt").innerHTML="";
		document.getElementById("hdnamount").value="";
	}
	function showSecond()
	{
		var val=document.getElementById("standing").value;
		if(val=="H")
		{
			document.getElementById("hour1").style.display="block";
			document.getElementById("hour2").style.display="none";
			document.getElementById("hour3").style.display="none";
			document.getElementById("hour4").style.display="none";
			document.getElementById("trweekly").style.display="";
		}
		if(val=="F")
		{
			document.getElementById("hour1").style.display="none";
			document.getElementById("hour2").style.display="block";
			document.getElementById("hour3").style.display="none";
			document.getElementById("hour4").style.display="none";
			document.getElementById("trweekly").style.display="none";
		}
		if(val=="P")
		{
			document.getElementById("hour1").style.display="none";
			document.getElementById("hour2").style.display="none";
			document.getElementById("hour3").style.display="block";
			document.getElementById("hour4").style.display="none";
			document.getElementById("trweekly").style.display="none";
			
			
		}
		if(val=="E")
		{
			document.getElementById("hour1").style.display="none";
			document.getElementById("hour2").style.display="none";
			document.getElementById("hour3").style.display="none";
			document.getElementById("hour4").style.display="block";
			document.getElementById("trweekly").style.display="none";
		}
		document.getElementById("totalamt").innerHTML="";
		document.getElementById("hdnamount").value="";
		//calculate();
	}
	function calculate()
	{
		var standing=document.getElementById("standing").value;
		var start=document.getElementById("start").value;
		var hours;
		var total;
		if(standing=="H")
		{
			hours=document.getElementById("often1").value;
			if(start==135)
			{
				total=hours*start*4;	
			}
			if(start==140)
			{
				total=hours*start*2;	
			}
			if(start==155)
			{
				total=hours*start;	
			}
			document.getElementById("totalamt").innerHTML="Din Kostand Blir <span style='color:#000000'>"+total+" Kr</span>";
		}
		if(standing=="F")
		{
			hours=document.getElementById("often2").value;
			total=hours;
			document.getElementById("totalamt").innerHTML="Din Kostand Blir <span style='color:#000000'>"+hours+" Kr</span>";
		}
		if(standing=="E")
		{
			hours=document.getElementById("often4").value;
			hours_priceE=document.getElementById("Engngstdning_hour_price").value;
			total=hours_priceE*hours;
			document.getElementById("totalamt").innerHTML="Din Kostand Blir <span style='color:#000000'>"+total+" Kr</span>";
		}
		if(standing=="P")
		{
			hours=document.getElementById("often3").value;
			hours_priceP=document.getElementById("Provsdning_hour_price").value;
			total=hours_priceP*hours;
			document.getElementById("totalamt").innerHTML="Din Kostand Blir <span style='color:#000000'>"+total+" Kr</span>";
		}
		document.getElementById("hdnamount").value=total;
	}
	
function LastStep()
{
		var standing=document.getElementById("standing").value;
		var start=document.getElementById("start").value;
		var hours;
		
		var start_text=document.getElementById("start");
		var selectedTextstart = start_text.options[start_text.selectedIndex].text;
		
		if(standing=="H")
		{
			hours=document.getElementById("often1").value;
			hours_text=document.getElementById("often1");
		}
		if(standing=="F")
		{
			hours=document.getElementById("often2").value;
			hours_text=document.getElementById("often2");
			selectedTextstart="-";
		}
		if(standing=="E")
		{
			hours=document.getElementById("often3").value;
			hours_text=document.getElementById("often3");
			selectedTextstart="-";
		}
		if(standing=="P")
		{
			hours=document.getElementById("often4").value;
			hours_text=document.getElementById("often4");
			selectedTextstart="-";
		}
		
		var standing_text=document.getElementById("standing");
		var selectedTextStanding = standing_text.options[standing_text.selectedIndex].text;
		
		
		
		var selectedTexthours = hours_text.options[hours_text.selectedIndex].text;
		
		document.getElementById("hdnstanding").value=selectedTextStanding;
		document.getElementById("hdnstart").value=selectedTextstart;
		document.getElementById("hdnoften").value=selectedTexthours;
		
		
		
		
		var standing =document.getElementById("hdnstanding").value;
		var start = document.getElementById("hdnstart").value;
		var often = document.getElementById("hdnoften").value;
		var time = "";
		if(document.getElementById("radTime1").checked == true)
		{
			time = document.getElementById("radTime1").value;
		}
		else
		{
			time = document.getElementById("radTime2").value;
		}
		var setdate= document.getElementById("hdndate").value;
		var amount = document.getElementById("hdnamount").value;
		if(amount=="")
		{
			alert("Vänligen beräkna fram ett pris");
			return false;
		}
		if(setdate=="")
		{
			alert("Vänligen välj ett bokningsdatum");
			return false;
		}
		
		jQuery.fancybox(
    	{
       		href : '<?php echo bloginfo('template_url'); ?>/Booking.php',
        	type : 'ajax',
        	ajax : {
            type: 'POST',
            data: {
                standing:standing,
                start:start,
				often:often,
				time:time,
				setdate:setdate,
				amount:amount
            }
        }
    });
	
}
</script>
<script type="text/javascript">

function Trim(myval)
{
	return myval.split(" ").join("");
}
function validateEmail(fld)

{

	var my=fld;

	var attherate=my.indexOf("@");

	var lastattherate = my.lastIndexOf("@");

	var dotpos=my.lastIndexOf(".");

	var posspace = my.indexOf(" ");

	var totallen = my.length;

	

	if (attherate<=0 || dotpos<=0 || attherate > dotpos || (dotpos-attherate)<=1 || (dotpos == totallen-1) || posspace > -1 || attherate!=lastattherate)

		return false;

	else

		return true;

}
function InputData()
{		
		var standing=document.getElementById("Hstanding").value;
		var start=document.getElementById("Hstart").value;
		var often=document.getElementById("Hoften").value;
		var amount=document.getElementById("Hamount").value;
		var Display_date=document.getElementById("HDisplay_date").value;
		var timeval=document.getElementById("Htimeval").value;
		
		var name=document.getElementById("name").value;
		var address=document.getElementById("address").value;
		var postno=document.getElementById("postno").value;
		var city=document.getElementById("city").value;
		var kvm=document.getElementById("kvm").value;
		var mobileno=document.getElementById("mobileno").value;
		var email=document.getElementById("email").value;
		var custommessag=document.getElementById("custommessag").value;
		
		/*if(Trim(custommessag)=="")
		{
			document.getElementById("errMsg").innerHTML="Message should not be blank.";
			document.getElementById("custommessag").focus();
			return false;
		}*/
		if(Trim(name)=="")
		{
			document.getElementById("errMsg").innerHTML="Name should not be blank.";
			document.getElementById("name").focus();
			return false;
		}
		if(Trim(address)=="")
		{
			document.getElementById("errMsg").innerHTML="Address should not be blank.";
			document.getElementById("address").focus();
			return false;
		}
		if(Trim(postno)=="")
		{
			document.getElementById("errMsg").innerHTML="Post Number should not be blank.";
			document.getElementById("postno").focus();
			return false;
		}
		if(isNaN(Trim(postno)))
		{
			document.getElementById("errMsg").innerHTML="Post Number should be number.";
			document.getElementById("postno").focus();
			return false;
		}
		if(Trim(city)=="")
		{
			document.getElementById("errMsg").innerHTML="City should not be blank.";
			document.getElementById("city").focus();
			return false;
		}
		if(Trim(kvm)=="")
		{
			document.getElementById("errMsg").innerHTML="Property size should not be blank.";
			document.getElementById("kvm").focus();
			return false;
		}
		if(isNaN(Trim(kvm)))
		{
			document.getElementById("errMsg").innerHTML="Property size should be number.";
			document.getElementById("kvm").focus();
			return false;
		}
		if(Trim(mobileno)=="")
		{
			document.getElementById("errMsg").innerHTML="Mobile No. should not be blank.";
			document.getElementById("mobileno").focus();
			return false;
		}
		if(isNaN(Trim(mobileno)))
		{
			document.getElementById("errMsg").innerHTML="Mobile No. should be number.";
			document.getElementById("mobileno").focus();
			return false;
		}
		if(Trim(email)=="")
		{
			document.getElementById("errMsg").innerHTML="E-mail should not be blank.";
			document.getElementById("email").focus();
			return false;
		}
		if(!validateEmail(email))
		{
			document.getElementById("errMsg").innerHTML="Please enter correct e-mail address.";
			document.getElementById("email").focus();
			return false;
		}
		if(!document.getElementById("chkterms").checked)
		{
			document.getElementById("errMsg").innerHTML="Please check terms & conidtions.";
			return false;
		}
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
		}
	    else
	    {// code for IE6, IE5
	 	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }
     	xmlhttp.onreadystatechange=function()
	    {
     	 
	   		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	   		{
				document.getElementById("InsertData").innerHTML=xmlhttp.responseText;
			}
  		}
	xmlhttp.open("GET","<?php echo bloginfo('template_url'); ?>/input_db.php?standing="+standing+"&start="+start+"&often="+often+"&amount="+amount+"&Display_date="+Display_date+"&timeval="+timeval+"&name="+name+"&address="+address+"&postno="+postno+"&city="+city+"&kvm="+kvm+"&mobileno="+mobileno+"&email="+email+"&custommessag="+custommessag,true);
	xmlhttp.send();
	
	
}

</script>
<script type="text/javascript">

	
	function storeDate(selectDate,selectMonth,selectYear,selectId)
	{
		
		varDate=selectYear+"-"+selectMonth+"-"+selectDate;
		
		var active = document.querySelector(".bookeddate");
		 	if (active){
				active.classList.remove("bookeddate");
			}
		
		jQuery("#"+selectId).addClass("bookeddate");
		//document.getElementById(""+selectId+"").className = "bookeddate";
		
		document.getElementById('hdndate').value=varDate;
	}
	
	function bookNotAllowDate(){
		alert('Please select date 3 days after current date');
	}
	
	
	
	function nextDates()
	{
		document.getElementById('tr5').style.display="";
		document.getElementById('tr6').style.display="";
		document.getElementById('tr7').style.display="";
		document.getElementById('tr8').style.display="";
		document.getElementById('tr9').style.display="";
		
		document.getElementById('tr0').style.display="none";
		document.getElementById('tr1').style.display="none";
		document.getElementById('tr2').style.display="none";
		document.getElementById('tr3').style.display="none";
		document.getElementById('tr4').style.display="none";
		
		document.getElementById('nextlink').style.display="none";
		document.getElementById('prevlink').style.display="";
	}
	function prevDates()
	{
		document.getElementById('tr5').style.display="none";
		document.getElementById('tr6').style.display="none";
		document.getElementById('tr7').style.display="none";
		document.getElementById('tr8').style.display="none";
		document.getElementById('tr9').style.display="none";
		
		document.getElementById('tr0').style.display="";
		document.getElementById('tr1').style.display="";
		document.getElementById('tr2').style.display="";
		document.getElementById('tr3').style.display="";
		document.getElementById('tr4').style.display="";
		
		document.getElementById('prevlink').style.display="none";
		document.getElementById('nextlink').style.display="";
	}
</script>
</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
	
		<hgroup>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( home_url( '/' ) ); ?>logo.jpg"></a>
			<h2 class="site-description">|&nbsp&nbsp<?php bloginfo( 'description' ); ?></h2>
		</hgroup>

		

		
		
	 <!--<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav> -->

	
	
	
	</header><!-- #masthead -->
	
	
			<?php do_action('codetemp_CTF_kodda_menu_display'); ?>
	
	

		<?php if( is_home() ) : ?> <?php dynamic_sidebar( 'slider' ); ?> <!--<div class="kalendarz"><?php //dynamic_sidebar( 'kalendarz' ); ?></div>-->
            <?php if (!dynamic_sidebar('Front Page Widget Area') ) : ?><?php endif; ?>

				
				<div class="icon">
				<img src="<?php echo esc_url( home_url( '/' ) ); ?>/icon.png">
				</div>
		
				<?php dynamic_sidebar( 'box1' ); ?>
						<?php dynamic_sidebar( 'box2' ); ?>
								<?php dynamic_sidebar( 'box3' ); ?>
								
										
											<?php dynamic_sidebar( 'info' ); ?>
										
										
										<?php endif;?>
		
		
		

	<div id="main" class="wrapper"<?php if( is_home() ) : ?> style="display:none;"<?php endif;?>>