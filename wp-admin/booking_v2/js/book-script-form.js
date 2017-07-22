 jQuery(window ).load(function () {
			jQuery.ajax({
				type: "POST",
				url: "http://renthem.dev/wp-admin/booking_v2/showBookForm.php",
				success:function( result ) {	
					if (result != "" ) {
						$("#calendar-cont").html(result );			
					}
				}
			});
		});
		
		$(document).ready(function(){
	


		});
		function Checkbox_to_RadioButton(box){
			  $('input:checkbox[name=' + box.name + ']').each(function(){
					if (this != box) $(this).attr('checked', false);
			  });
		} 


		function updateWindowPrice(window_no, service_id) {
		if (window_no != "") {
			jQuery.ajax({
					type: "POST",
					data: "window_no="+window_no+"&service_id="+service_id,
					url: "http://renthem.dev/wp-admin/booking_v2/showBookFormWindowPrice.php",
					success:function( result ) {	
						if (result != "" ) {
							$("#window_price_"+service_id).html(result );
							$("#window_no_tmp").val(window_no);
							$('input:checkbox[name=window_service]').attr('checked', true);
						}
					}
				});
			}
		}
		function showBookOffer() {
				var book_value = $("#book_value").val();
				if ((book_value == "") || (book_value == "kvm")) {
					$("#book_value").focus();
					return false;
				}
				
				jQuery.ajax({
					type: "POST",
					data: "book_value="+book_value,
					url: "http://renthem.dev/wp-admin/booking_v2/showBookFromPrice.php",
					success:function( result ) {	
						if (result != "" ) {
							$("#bookOffer").show().html(result );			
						}
					}
				});
				
			}
			
			function showBookPopUp() {
				var clean_service = "";
				var window_service = "";
				var window_no = $("#window_no_tmp").val();
				
				$("input:checkbox[name=clean_service]:checked").each(function() {
					clean_service = $(this).val();
				});
				$("input:checkbox[name=window_service]:checked").each(function() {
					window_service = $(this).val();
				});
				
	
				if ((clean_service == "") && (window_service == "")) {
					alert("Please select a service");
					return false;
				}
				if ((window_service != "") && (parseInt(window_no) == 0)) {
					alert("Please type number of windows");
					return false;
				}
				
				$("#clean_service").val(clean_service);
				$("#window_service").val(window_service);
				$("#window_no_book").val(window_no);
				
				var screen_height = $(document).height()+50;
				
					
					
				$("#book-lightbox").show().height(screen_height);
				$('html, body').animate({scrollTop : 0},800);
			}
			function closePopUp() {
				$("#book-lightbox").hide();
			}
			
			function validateBookForm() {
				var clean_service = $("#clean_service").val();
				var window_service = $("#window_service").val();
				var window_no = $("#window_no_book").val();

				var frmBookFirstName = $("#frmBookFirstName").val();
				var frmBookLastName = $("#frmBookLastName").val();
				var frmBookStreet = $("#frmBookStreet").val();
				var frmBookZip = $("#frmBookZip").val();
				var frmBookCity = $("#frmBookCity").val();
				var frmBookSize = $("#book_value").val();
				var frmBookMobile = $("#frmBookMobile").val();
				var frmBookEmail = $("#frmBookEmail").val();
				var frmBookDate = $("#frmBookDate").val();
				var frmBookComment = $("#frmBookComment").val();
				
				var frmBookHour = "";
				var frmBookTerms = "";
				
			$("input:radio[name=frmBookHour]:checked").each(function() {
					frmBookHour = $(this).val();
				});
			$("input:checkbox[name=frmBookTerms]:checked").each(function() {
					frmBookTerms = $(this).val();
				});

				if (frmBookFirstName == "") { $("#frmBookFirstName").focus(); return false;} 
				if (frmBookLastName == "") { $("#frmBookLastName").focus(); return false;} 
				if (frmBookStreet == "") { $("#frmBookStreet").focus(); return false;} 
				if (frmBookZip == "") { $("#frmBookZip").focus(); return false;} 
				if (frmBookCity == "") { $("#frmBookCity").focus(); return false;} 
				if (frmBookMobile == "") { $("#frmBookMobile").focus(); return false;} 
				if (frmBookEmail == "") { $("#frmBookEmail").focus(); return false;} 
				if (frmBookDate == "") { $("#frmBookDate").focus(); return false;} 
				if (frmBookHour == "") {
					alert("Please select time"); return false;
				}
				if (frmBookTerms == "") {
					alert("Please accept Terms"); return false;
				}
				
		jQuery.ajax({
					type: "POST",
					data: "clean_service="+clean_service+
						"&window_service="+window_service+
						"&window_no="+window_no+
						"&frmBookLastName="+frmBookLastName+
						"&frmBookFirstName="+frmBookFirstName+
						"&frmBookStreet="+frmBookStreet+
						"&frmBookZip="+frmBookZip+
						"&frmBookCity="+frmBookCity+
						"&frmBookSize="+frmBookSize+
						"&frmBookMobile="+frmBookMobile+
						"&frmBookEmail="+frmBookEmail+
						"&frmBookDate="+frmBookDate+
						"&frmBookHour="+frmBookHour+
						"&frmBookComment="+frmBookComment+
						"&action=saveBooking",
					url: "http://renthem.dev/wp-admin/booking_v2/setupNewBookingClient.php",
					success:function( result ) {	
				
						$('#frmBook')[0].reset();
						
						$("#book-lightbox").hide();
						$("#book_value").val("");
						$("#bookOffer").html("");
						alert("Tack för din bokning.");
					}
				});
				
				return false;
			}