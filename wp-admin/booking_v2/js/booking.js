	function show_alert_box(message, alert) {
			 $(".alert-line h3").html(message);
			 $(".alert-line").slideDown("slow");
 			 switch (alert) {
 			 	case '1': // error
 			 		$(".alert-line").css('background-color', '#f35958');
 
 			 	break;
 			 	case '2': // done
 			 		$(".alert-line").css('background-color', '#6dd300');
 			 	break;
 			 }
			setTimeout(function() {
                 $(".alert-line").slideUp("slow");
            }, 4000);
         
		}