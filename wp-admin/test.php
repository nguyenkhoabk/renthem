<html>
	<head>

		<link rel="stylesheet" href="css/book-form.css" type="text/css" />
		
<link rel="stylesheet" type="text/css" media="all" href="calendar/jsDatePick_ltr.min.css" />

<link rel="stylesheet" type="text/css" media="all" href="calendar/jsDatePick_ltr.css" />
<script type="text/javascript" src="calendar/jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%n-%Y"
		});
	};
</script>

	 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
		<meta charset="utf-8">

		<script type="text/javascript"> 
		 jQuery(window ).load(function () {
			jQuery.ajax({
				type: "POST",
				url: "showBookForm.php",
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
					url: "showBookFormWindowPrice.php",
					success:function( result ) {	
						if (result != "" ) {
							$("#window_price_"+service_id).html(result );
							$('input:checkbox[name=window_service]').attr('checked', true);
						}
					}
				});
			}
		}
		function showBookOffer() {
				var book_value = $("#book_value").val();
				if (book_value == "") {
					$("#book_value").focus();
					return false;
				}
				
				jQuery.ajax({
					type: "POST",
					data: "book_value="+book_value,
					url: "showBookFromPrice.php",
					success:function( result ) {	
						if (result != "" ) {
							$("#bookOffer").show().html(result );			
						}
					}
				});
				
			}
			
			function showBookPopUp() {
				
				$(".clean_service:checked").each(function() {
				alert($(this).val());
			});
	
	
		//		window_service
			//	window_no
				
			
				$("#book-lightbox").show();
			}
			function closePopUp() {
				$("#book-lightbox").hide();
			}
		</script>

	</head>
	<body>
		<div id="book-lightbox">
			<div id="popup">
				<div id="popup-close" onclick="closePopUp();">x</div>
				<div id="popup-title"> Vi har reserverat en tid for städning hemma hos er den 18 Juli klockan 13:00-17:00</div>
				<div id="popup-description">For att slutföra bokningen behöver vi bara dina personuppgifter/adress,se nedan. En bekräftelse
				kommer därefter att skickas till din mail. Har du nágra frágor gár det bra att ringa vár kundtjänst pá
				08-82 44 77. Provstädningen ar inte bindande for fortsatt städning, utan bara for det bokade tillfället. </div>
				<table width="100%">
					<tr>
						<td width="50%"><b>Namn *</b><br/>
							<input type="text" class="class-input" name="" />
						</td>
						<td  width="50%"><b>Gatuadress *</b><br/>
							<input type="text" class="class-input" name="" />
						</td>
					</tr>
					<tr>
						<td><b>Postnummer *</b><br/>
							<input type="text" class="class-input" name="" />
						</td>
						<td><b>Ort *</b><br/>
							<input type="text" class="class-input" name="" />
							</td>
					</tr>
					<tr>
						<td><b>Storlek på din bostad (kvm) *</b><br/>
							<input type="text" class="class-input" name="" />
						</td>
						<td><b>Mobilnr. *</b><br/>
							<input type="text" class="class-input" name="" />
							</td>
					</tr>
					<tr>
						<td><b>E-post *</b><br/>
							<input type="text" class="class-input" name="" />
						</td>
						<td><b>Date *</b><br/>
							<input  type="text" id="inputField" class="class-input" name="" />
							</td>
					</tr>
					<tr>
						<td><b>Meddelande</b> <br/>
							<textarea class="class-input" style="resize:none;"></textarea>
						</td>
						<td>
							<input type="radio" name="" /> Förmiddag 8:00-12:00 <br/>
							<input type="radio" value="" /> Eftermiddag 13:00-17:00
						</td>
					</tr>
					<tr>
						<td><input type="checkbox" value="" /> Jag har läst <A target="_blank" href="http://renthem.se/bokningsvillkor/">Bokningsvillkoren</a></td>
						<td align="center"><input type="submit" value="Boka !" /></td>
					</tr>
				</table>
			</div>
		</div>
		<div id="calendar-cont"></div>
	


	</body>
</html>