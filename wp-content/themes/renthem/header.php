<?php/*
Theme Name: Rent Hem Stockholm
Author: Copyrighted by Renthem.se
Author URI: http://www.renthem.se
Description: Theme for "renthem.se"
Version: 1.0

*/?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
<?php
// current post id
$current_id = get_the_ID();
$dontshow = array(1151, 963);
if (!in_array($current_id, $dontshow)) {
?>
<script type="text/javascript" src="https://s3.amazonaws.com/static.dudamobile.com/DM_redirect.js"></script>
<script type="text/javascript">DM_redirect("http://m.renthem.se");</script>
<?php
}
?>
<meta name="locations" content="Sweden" />
<meta name="robots" content="all, index, follow" /> 
<meta name="googlebot" content="all, index, follow" />
<meta name="language" content="svenska, sv" />
<meta name="abstract" content="Prisvärda städtjänster i Stockholm med hög personlig service och omtanke" />
<meta name="copyright" content="Renthem.se">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="stylesheet" href="<?php echo site_url(); ?>/wp-admin/booking_v2/css/book-form.css" type="text/css" />
<script type="text/javascript">function get_style () { return "none"; }
function end_ () { document.getElementById('omre').style.display = get_style(); }</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
	$("#book_value").keyup(function(){
		$.ajax({
		type: "POST",
		url: "/wp-admin/booking_v2/showBookForm.php",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#book_value").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#book_value").css("background","#FFF");
		}
		});
	});
});
function selectCountry(val) {
$("#book_value").val(val);
$("#suggesstion-box").hide();
}

 jQuery(window ).load(function () {



            jQuery.ajax({



		type: "POST",



		url: "/wp-admin/booking_v2/showBookForm.php",



		success:function( result ) {	



			if (result != "" ) {



				$("#calendar-cont").html(result );			



			}



		}



	});



});



function showBookOffer() {



		alert("da");



		$("#bookOffer").show();



	}



</script>
<?php wp_head(); ?>
<link href="<?php bloginfo('template_url'); ?>/css/style.css" rel="stylesheet">
<link href="<?php bloginfo('template_url'); ?>/css/fancybox.css" rel="stylesheet">
<script src="<?php bloginfo('template_url'); ?>/js/fancybox.js"></script>
<script type="text/javascript">



    (function($){



        $('#calender-title-1').on('change', 'select', function() {



            ClearAmt();



        });



    })(jQuery);







	function ClearAmt()



	{



		document.getElementById("totalamt").innerHTML="";



		document.getElementById("hdnamount").value="";



		document.getElementById("hdnsize").value="";



		document.getElementById("hdnoften").value="";



		//calculate();



	}



	function calculate()



	{



		var standing=document.getElementById("standing").value;



		var size=document.getElementById("size").value;



		var often = document.getElementById("often").value;



		var hours;



		var total;







		if(standing=="H")



		{



			hours=size;



			



			if(often==140)



			{



				total=(hours*often*4);	



			}



			if(often==150)



			{



				total=(hours*often*2);	



			}



			if(often==155)



			{



				total=(hours*often);	



			}



		}



		else if(standing=="F")



		{



			hours=size;



			total=hours;



		}



        else if(standing=="E")



		{



			hours=size;



			hours_priceE=document.getElementById("Engngstdning_hour_price").value;



			total=(hours_priceE*hours);



		}



        else if(standing=="P")



		{



			hours=size;



			hours_priceP=document.getElementById("Provsdning_hour_price").value;



			total=(hours_priceP*hours);



		}



        else 



		{



            hours = jQuery("#size").is(':visible')?size:1;



            often = jQuery('#often').is(':visible')?often:1;



            total = (often*hours);



        }



		



		document.getElementById("totalamt").innerHTML="<big>Din Kostnad Blir <span style='color:#000000'>"+total+" Kr</span></big>";



		document.getElementById("hdnamount").value=total;



		var standing_text=document.getElementById("standing");



		var selectedTextStanding = standing_text.options[standing_text.selectedIndex].text;



		



		var size_text=document.getElementById('size');



		var selectedTextSize = size_text.options[size_text.selectedIndex].text;







		var hours_text=document.getElementById("often");



		var selectedTexthours = (jQuery(hours_text).is(':visible')?hours_text.options[hours_text.selectedIndex].text:"-");



		



		document.getElementById("hdnstanding").value=selectedTextStanding;



		document.getElementById("hdnsize").value=selectedTextSize;



		document.getElementById("hdnoften").value=selectedTexthours;



	}



	



	function LastStep()



	{



		var standing =document.getElementById("hdnstanding").value;



		var size = document.getElementById("hdnsize").value;



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



	                size:size,



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



	var size=document.getElementById("Hsize").value;



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



	xmlhttp.open("GET","<?php echo bloginfo('template_url'); ?>/input_db.php?standing="+standing+"&size="+size+"&often="+often+"&amount="+amount+"&Display_date="+Display_date+"&timeval="+timeval+"&name="+name+"&address="+address+"&postno="+postno+"&city="+city+"&kvm="+kvm+"&mobileno="+mobileno+"&email="+email+"&custommessag="+custommessag,true);



	xmlhttp.send();



}



</script>



<script type="text/javascript">



	function storeDate(selectDate,selectMonth,selectYear,selectId)



	{



		varDate=selectYear+"-"+selectMonth+"-"+selectDate;



		jQuery(".bookeddate").each(function()



		{



			if(!jQuery(this).hasClass("weekend"))



			{



				jQuery(this).removeClass("bookeddate");



			}



		});



	 	



		



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

<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>



<script type="text/javascript">

<!--

function clean(it){

if (it.defaultValue==it.value) it.value = "";

}

function rest(it){

if (it.value == "") it.value = it.defaultValue;

}

//-->

</script>


<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MB4PZSF');</script>
<!-- End Google Tag Manager -->


</head>





<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MB4PZSF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- lightbox -->	<div id="book-lightbox" style="display:none;">			<div id="popup">				<div id="popup-close" onClick="closePopUp();">x</div>				<div id="popup-title"> Rent Hem Stockholm</div>				<div id="popup-description">För att slutföra bokningen behöver vi bara dina personuppgifter/adress, se nedan. Därefter kommer en bekräftelse skickas till eran e-mail adress. Har du nagra fragor gar det bra att ringa var kundtjänst pá				08-82 44 77 eller maila pa info@renthem.se .</div>			<form action="" method="post" id="frmBook" onSubmit="return validateBookForm();">					<input type="hidden" name="clean_service" value="" id="clean_service" />				<input type="hidden" name="window_service" value="" id="window_service" />				<input type="hidden" name="window_no_book" value="" id="window_no_book" />				<table width="100%" class="book_form_table_x">					<tr>						<td width="50%"><b>Förnamn *</b><br/>							<input type="text" class="class-input" name="frmBookFirstName" id="frmBookFirstName" />						</td>						<td  width="50%"><b>Efternamn *</b><br/>							<input type="text" class="class-input" name="frmBookLastName" id="frmBookLastName" />						</td>					</tr>					<tr>						<td><b>Gatuadress *</b><br/>							<input type="text" class="class-input" name="frmBookStreet" id="frmBookStreet" />						</td>						<td><b>Postnummer *</b><br/>							<input type="text" class="class-input" name="frmBookZip" id="frmBookZip" />							</td>					</tr>					<tr>						<td>	<b>Ort *</b><br/>							<input type="text" class="class-input" name="frmBookCity" id="frmBookCity" />						</td>						<td><b>Mobilnr. *</b><br/>							<input type="text" class="class-input" name="frmBookMobile" id="frmBookMobile" />							</td>					</tr>					<tr>						<td><b>E-post *</b><br/>							<input type="text" class="class-input" name="frmBookEmail" id="frmBookEmail" />						</td>						<td><b>Date *</b><br/>							<input  type="text" class="class-input" name="frmBookDate" autocomplete="off" id="frmBookDate"/>							</td>					</tr>					<tr>						<td><b>Meddelande</b> <br/>							<textarea class="class-input" style="resize:none;" id="frmBookComment" name="frmBookComment"></textarea>						</td>						<td>							<input type="radio" name="frmBookHour" value="8-12" /> Förmiddag 8:00-12:00 <br/>							<input type="radio" name="frmBookHour" value="13-17" /> Eftermiddag 13:00-17:00						</td>					</tr>					<tr>						<td><input type="checkbox" value="1" name="frmBookTerms" /> Jag har läst <A target="_blank" href="http://renthem.se/bokningsvillkor/">Bokningsvillkoren</a></td>						<td align="center"><input type="submit" value="Boka !" /></td>					</tr>									</table>		</form>			</div>		</div>
<div id="page"><script type="text/javascript"> end_(); </script>