<?php
require('../../wp-blog-header.php');

	include("core.php");
if (is_user_logged_in()){
   
} else {
	header("Location: http://renthem.dev/wp-admin");
}
?>
<html lang="en">
  <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
       
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="favicon.ico">
   
        <title>Booking system</title>
		<meta name="description" xml:lang="en" lang="en" content="" />
        <meta name="keywords"  xml:lang="en" lang="en" content="" />
  		<link href="css/style_booking.css" rel="stylesheet" />
    	<link rel="stylesheet" href="css/datepicker.css" type="text/css" />
    	<link rel="stylesheet" href="css/admin-calendar.css" type="text/css" />
  </head>

	<body>
		  <div class="alert-line"><h3></h3></div>
		  <div id="book_info_popup_display"></div>
  <?php
	$date = date("Y-m-d");
  ?>
  			<div id="book-wrap">
			<div id="preload"><center><img src="images/ajax-loader.gif" alt=""/></center></div>
  		<div id="calendar_place">
  				
  		</div>
  				<div class="clear"></div>
  				<div class="book-add" id="book-add-form">
  					
  					
  				</div>
  				<div class="book-add" id="book-edit-form">  					
  				</div>
  				
  				<div class="clear"></div>
  				<div id="book-pending">
  						<H1>Pending Bookings</H1>
  						<table>
  							<thead>
  								<tr>
	  								<td>Name</td>
	  								<td>Address</td>
	  								<td>Phone</td>
	  								<td>Email</td>
	  								<td>Service</td>
	  								<td>Date</td>
	  								<td>Tools</td>
	  							</tr>
  							</thead>
  							<tbody>
							<?php
								$pending=$book->getPendingBook("*", "", "");
								
								foreach ($pending as $value) {
							?>
							<tr id="pedding_book_<?=$value['id']?>">
	  								<td><?=$value['first_name'].' '.$value['last_name']?></td>
	  								<td><?=$value['street']?></td>
	  								<td><?=$value['mobile']?></td>
	  								<td><?=$value['email']?></td>
	  								<td style="text-align:center !important;">
									
									<?php
										if ($value['clean_service_id'] != "") {
											echo $service->getServiceName($value['clean_service_id']);
										}
									?>
									&nbsp;
								<?php
										if ($value['window_service_id'] != "") {
											echo $service->getServiceName($value['window_service_id']);
										}
									?>
							
	  								<td style="text-align:center !important;"><?=date("Y-m-d",$value['up_date'])?></td>
	  								<td style="text-align:center !important;"><a href="javascript:;" onclick="displayPendingBookingEdit(<?=$value['id']?>);">view</a> &nbsp; &#9679; &nbsp;<a href="javascript:;" onclick="return deletePendingBook(<?=$value['id']?>);">delete</a></td>
	  							</tr>
							<?php
								}
							
							?>
  								
  							</tbody>
  							
  						</table>
  					
  				</div>
  				<div id="book-setting">
  					<button onclick="showStaffList();" class="btn b-default">Staff</button>
  					<button onclick="showServiceList();" class="btn b-default">Services</button>  	
  					<button onclick="showBookingList();" class="btn b-default">Bookings</button>  	
					<button onclick="showPriceList();" class="btn b-default">Price List</button> 
					<div id="emailStatusDiv" style="float:left;">
					<?php 
						if ($emailStatus == 1) {
					?>
						<button onclick="emailStatusChange('off');" class="btn b-email-on">Auto Email ON</button> 		
					<?php
						} else {
					?>
						<button onclick="emailStatusChange('on');" class="btn b-email-off">Auto Email OFF</button> 		
					<?php	
						}
					?>	
					</div>
						<a href="//renthem.dev/wp-admin/"><button class="btn b-default"  >WP Admin</button></a>
  				</div>
  				
  					<div class="book-add" id="edit-price" style="display:none;"></div>
				<div class="book-add" id="book-add-price" style="display:none;">
  					<a href="javascript:;" onclick="cancelPrice();" class="close">x</a>
  					<h1>Add Price</h1>
  					<div class="booking-add-box">
	  						<div class="booking-column-2">
	  							
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Service</label>
	  									<select name="add_price_service" id="add_price_service">
											<?php
												foreach ($serviceArr as $value) {
													echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
												}
											?>
										</select>
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Amount</label>
	  									<input type="text" value=""  id="add_price_amount" name="add_price_amount" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							<div class="row">
	  								<div class="booking-column-1">
	  									<label>Frequency</label>
	  									<select name="add_price_frequency" id="add_price_frequency">
											<option value=""> - select - </option>
											<option value="0">one time</option>
											<option value="1">one time a month</option>
											<option value="2">every second week</option>
											<option value="4">every week</option>
										</select>
	  								</div>
	  								
	  								<div class="clear"></div>
	  							</div>
	  							
	  						</div>
  						
  						<div class="booking-column-2 right-vline">
  							
  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Minimum Value</label>
	  									<input type="text" value=""  id="add_price_min_value" name="add_price_min_value" />
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Maximum Value</label>
	  									<input type="text" value=""  id="add_price_max_value" name="add_price_max_value" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
  						</div>
  						<div class="clear"></div>
  						<div class="tool-bar">
  							<button class="btn b-save" onclick="savePrice();">Save</button>
  							<button class="btn b-cancel" onclick="cancelPrice();">Cancel</button>  							
  						</div>
  						<div class="clear"></div>
  					</div>
  					
  					
  				</div>
				
				
  				<div class="book-add" id="book-add-staff">
  					<a href="javascript:;" onclick="cancelStaff();" class="close">x</a>
  					<h1>Add Staff</h1>
  					<div class="booking-add-box">
	  						<div class="booking-column-2">
	  							
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Name</label>
	  									<input type="text" id="staff_name" name="staff_name" value="" />
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Phone</label>
	  									<input type="text" value=""  id="staff_phone" name="staff_phone" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							
	  						</div>
  						
  						<div class="booking-column-2 right-vline">
  							
  							<div class="row">
	  								<div class="booking-column-1">
	  									<label>Email</label>
	  									<input type="text" value=""id="staff_email"  name="staff_email" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
  						</div>
  						<div class="clear"></div>
  						<div class="tool-bar">
  							<button class="btn b-save" onclick="saveStaff();">Save</button>
  							<button class="btn b-cancel" onclick="cancelStaff();">Cancel</button>  							
  						</div>
  						<div class="clear"></div>
  					</div>
  					
  					
  				</div>
  				
  				<div class="book-add" id="book-add-service">
  					<a href="javascript:;" onclick="cancelService();" class="close">x</a>
  					<h1>Add Service</h1>
  					<div class="booking-add-box">
	  						
  							
  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Name</label>
	  									<input type="text" value=""id="service_name"  name="service_name" />
	  								</div>
									<div class="booking-column-2">
	  									<label>Background</label>
	  									<input type="text" value=""id="background"  name="background" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
  						<div class="row">
	  								<div class="booking-column-2">
	  									<label>Display on</label>
	  									<select id="show_on"  name="show_on" >
											<option value="0">Admin</option>
											<option value="1">Front end</option>											
											<option value="2">Front end + Admin</option>
										</select>
	  								</div>
									<div class="booking-column-2">
	  									<label>Type</label>
	  									<select name="service_type" id="service_type">
											<option value="1">kvm</option>
											<option value="2">windows</option>
										</select>
	  								</div>
	  								<div class="clear"></div>
	  							</div>
							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Position</label>
	  									<input type="text" value=""id="service_position"  name="service_position" />
	  								</div>
									<div class="booking-column-2">
	  									<label>URL</label>
	  									<input type="text" value=""id="service_url"  name="service_url" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>	
								
								
  						<div class="clear"></div>
  						<div class="tool-bar">
  							<button class="btn b-save" onclick="saveService();">Save</button>
  							<button class="btn b-cancel" onclick="cancelService();">Cancel</button>  							
  						</div>
  						<div class="clear"></div>
  					</div>
  					
  					
  				</div>
  				<div class="book-add" id="book-edit-staff">
  				</div>
  				<div class="book-add" id="book-edit-service">
  				</div>
  				
  				<div id="book-history"></div>
				<div id="price-list">
								
  					<div class="box">
  						<div class="book-title">Price list</div>
		  					<div class="book-button">
		  						<button class="btn b-add"  onclick="$('#book-add-price').show();">Add New Price</button>
		  					</div>
		  					<div class="clear"></div>
					</div>
					<div id="price_table_list">
							<table>
  						<thead>
  							<tr>
	  							<td>Service</td>
								<td>Amount</td>
								<td>Value</td>
								<td>Frequency</td>
	  							<td>Tools</td>
	  						</tr>
  						</thead>
  						<tbody >
  							<?php
  								foreach ($priceArr as $value) {
							?>	
								<tr id="price_row_<?=$value['id']?>">
									<td><?=$service->getServiceName($value['service_id'])?></td>
									<td style="text-align: center !important;"><?=$value['amount']?></td>
									<td style="text-align: center !important;"><?=$value['start_value']?> - <?=$value['end_value']?></td>
									<td style="text-align: center !important;">
									<?php
										switch ($value['frequency']) {
											case '0':
													echo 'One time';
												break;
											case '1':
													echo 'One time a month';
												break;
											case '2':
													echo 'Every second week';
												break;
											case '4':
													echo 'Every week';
												break;
										}
									?>
									</td>
									<td style="text-align: center !important;">
										<a href="javascript:;" onclick="editPrice('<?=$value['id']?>');">edit</a>  &nbsp; &#9679; &nbsp;
										<a href="javascript:;" onclick="deletePrice('<?=$value['id']?>');">delete</a> 
									</td>
								</tr>	  
							<?php
								  }
  								
  							?>
  						</tbody>
  					</table>
		  			</div>
  				</div>
  				
  				
  				
  				
  				
  				<div id="book-service">
  					<div class="box">
  						<div class="book-title">Services</div>
		  					<div class="book-button">
		  						<button class="btn b-add"  onclick="$('#book-add-service').show();">Add New Service</button>
		  					</div>
		  					<div class="clear"></div>
		  			</div>
		  					
  					<table>
  						<thead>
  							<tr>
	  							<td>Name</td>
	  							<td>Position</td>
								<td>Color</td>
	  							<td>Tools</td>
	  						</tr>
  						</thead>
  						<tbody id="service_table_list">
  							<?php
  								foreach ($serviceArr as $value) {
							?>	
								<tr id="service_row_<?=$value['id']?>">
									<td><?=$value['name']?></td>
									<td align="center" style="text-align:center !important;"><?=$value['position']?></td>
									<td style="background-color:<?=$value['background']?> !important;"></td>
									<td style="text-align: center !important;">
										<a href="javascript:;" onclick="editService('<?=$value['id']?>');">edit</a>  &nbsp; &#9679; &nbsp;
										<a href="javascript:;" onclick="deleteService('<?=$value['id']?>');">delete</a> 
									</td>
								</tr>	  
							<?php
								  }
  								
  							?>
  						</tbody>
  					</table>
  				</div>
  				<div id="book-staff">
  						
  						<div class="box">
	  						<div class="book-title">Manage Staff</div>
			  					<div class="book-button">
			  						<button class="btn b-add"  onclick="$('#book-add-staff').show();">Add New Staff</button>
			  					</div>
			  					<div class="clear"></div>
			  			</div>
		  					
  						<table>
  							<thead>
  								<tr>	  								
	  								<td>Name</td>
	  								<td>Phone</td>
	  								<td>Email</td>	  								
	  								<td>Tools</td>
	  							</tr>
  							</thead>
  							<tbody id="staff_table_list">
  								<?php
  									foreach($staffArr as $value) {
  								?>
  								<tr id="staff_row_<?=$value['id']?>">
	  								<td><?=$value['name']?></td>
	  								<td><?=$value['phone']?></td>
	  								<td><?=$value['email']?></td>
	  								<td style="text-align: center !important;">
	  									<a href="javascript:;" onclick="editStaff('<?=$value['id']?>');">edit</a> 	&nbsp; &#9679; &nbsp;
	  									<a href="javascript:;" onclick="deleteStaff('<?=$value['id']?>');">delete</a>
	  								</td>
	  							</tr>
  								<?php
  									}
  								?>
  								
  							</tbody>
  							
  						</table>
  					
  				</div>
			
  				
  			</div>
  	
  	
  			<script type="text/javascript" src="js/jquery.js"></script>
  			<script type="text/javascript" src="js/booking.js"></script>
			<script type="text/javascript" src="js/datepicker.js"></script>
   			<script type="text/javascript" src="js/eye.js"></script>
   			<script type="text/javascript" src="js/utils.js"></script>
   			<script type="text/javascript" src="js/admin-calendar.js"></script>

   			<script type="text/javascript">
   			$( document ).ready(function() {
   				
				
				$("#book_info_popup_display").click(function() {
					$("#book_info_popup_display").slideUp("slow");
				});
				loadCalendar("<?=$date?>");
			
			window.setInterval(function(){
				updatePendingBooking();
			}, 30000);

			});
			</script>
		
	<script type="text/javascript">
	
	
function getTotalPrice() {
	var window_price = 0;
	var clean_price = 0;
	var total = 0;
	var clean_service = "";
	$("input:checkbox[name=window_service]:checked").each(function() {
					window_price=$("#window_price").text();
				});
				
		$("input:checkbox[name=clean_service]:checked").each(function() {
					clean_service = $(this).val();
				});
	if (clean_service != "") {
		var vec = clean_service.split("::");
		var clean_price=$("#clean_price_"+vec[0]+"_"+vec[1]).text();
	}	
				
	
	total = parseInt(window_price) + parseInt(clean_price);
	$("#add_total").val(total);
}




	function cancelPrice() {
		$("#add_price_amount").val("");
		$("#add_price_min_value").val(""); 
		$("#add_price_service").val("");
		$("#add_price_max_value").val("");
						
		$('#book-add-price').hide();
	}
	function Checkbox_to_RadioButton(box){
			  $('input:checkbox[name=' + box.name + ']').each(function(){
					if (this != box) $(this).attr('checked', false);
			  });
			  getTotalPrice();
		} 

	function updatePriceValueEdit() {
		var add_size = $("#edit_size").val();
		var add_windows = $("#edit_windows").val();
		var clean_service = "";
		if (add_size == "") {
			add_size = 0;
		}
		if (add_windows == "") {
			add_windows = 0;
		}
		$("input:checkbox[name=clean_service]:checked").each(function() {
					clean_service = $(this).val();
				});
		$.ajax({
				type: "POST",
				data: "add_size="+add_size+"&add_windows="+add_windows+"&clean_service="+clean_service,
				url: "core/getPriceList.php",
				success:function( result ) {	
					$("#priceRowList").html(result);
				}
			});
			
			
	}
	
	function updatePriceValue() {
		var add_size = $("#add_size").val();
		var add_windows = $("#add_windows").val();
		var clean_service = "";
		if (add_size == "") {
			add_size = 0;
		}
		if (add_windows == "") {
			add_windows = 0;
		}
		$("input:checkbox[name=clean_service]:checked").each(function() {
					clean_service = $(this).val();
				});
		$.ajax({
				type: "POST",
				data: "add_size="+add_size+"&add_windows="+add_windows+"&clean_service="+clean_service,
				url: "core/getPriceList.php",
				success:function( result ) {	
					$("#priceRowList").html(result);
					
					getTotalPrice();
				}
			});
			
			
	}
	function updateBooking() {
		$.ajax({
				type: "POST",
				url: "core/getUpdateBooking.php",
				success:function( result ) {	
					$("#book-history").html(result);
				}
			});
	}
	function updatePendingBooking() {
		$.ajax({
				type: "POST",		
				url: "core/getUpdatePendingBooking.php",
				success:function( result ) {	
					$("#book-pending").html(result);
				}
			});
	}
	
	
	function showWeekStaffWork(data, staff_id) {
		$.ajax({
				type: "POST",
				data: "date="+data+"&staff_id="+staff_id,
				url: "core/getStaffWeekWork.php",
				success:function( result ) {	
					$("#book-calendar").html(result);
				}
			});
	}
	function deleteBookEdit(book_id, date) {
		if (confirm("Are you sure you want to delete?")) {
			$('#book-add-form').html('').hide();
			$.ajax({
				type: "POST",
				data: "book_id="+book_id+"&date="+date,
				url: "core/deleteBook.php",
				success:function( result ) {	
					$("#book_id_delete_"+book_id).remove();
					loadCalendar(date);
					show_alert_box('Booking have been deleted.', '2'); 
				}
			});
		}
	}
	
	/**
	 *  delete current day booking
	 * @param book_id
	 * @param date
	 */


	function deleteBookEditOnCurrentDay(book_id, date) {
	    if (confirm("Are you sure you want to delete?")) {
	        $('#book-add-form').html('').hide();
	        $.ajax({
	            type: "POST",
	            data: "book_id="+book_id+"&date="+date,
	            url: "core/deleteBookOnCurrentDay.php",
	            success:function( result ) {
	                $("#book_id_delete_"+book_id).remove();
	                loadCalendar(date);
	                show_alert_box('Booking have been deleted.', '2');
	            }
	        });
	    }
	}	
	function deleteBook(book_id, date) {
	if (confirm("Are you sure you want to delete?")) {
		$.ajax({
				type: "POST",
				data: "book_id="+book_id+"&date="+date,
				url: "core/deleteBook.php",
				success:function( result ) {	
					$("#book_id_delete_"+book_id).remove();
					loadCalendar(date);
					show_alert_box('Booking have been deleted.', '2'); 
				}
			});
		}
	}
	function updateSizePrice(size) {
		var service = $('input:radio[name=add_service]:checked').val();
		var frequency = $("#add_frequency").val();
			$.ajax({
				type: "POST",
				data: "size="+size+"&service="+service+"&frequency="+frequency,
				url: "core/caculateAmount.php",
				success:function( result ) {	
				
					$("#add_price_size").val(result); 
				}
			});
		
	
	}
	function updateWindowsPrice(size) {
		var service = $('input:radio[name=add_service]:checked').val();
		var frequency = $("#add_frequency").val();
			$.ajax({
				type: "POST",
				data: "size="+size+"&service="+service+"&frequency="+frequency,
				url: "core/caculateAmount.php",
				success:function( result ) {	
				
					$("#add_price_windows").val(result); 
				}
			});

	
	}
	
	function showPriceList() {
		$("#book-service").hide();
		$("#book-staff").hide();
		$("#book-history").hide();
		cancelStaff();
		cancelStaffEdit();
		cancelServiceEdit();
				
		$("#price-list").show();
	}
	function showBookingList() {
		$("#book-service").hide();
		$("#price-list").hide();
		$("#book-staff").hide();
				cancelStaff();
				cancelPrice();
				cancelStaffEdit();
				cancelServiceEdit();
			$.ajax({
				type: "POST",
				url: "core/showBookingList.php",
				success:function( result ) {	
					$("#book-history").show().html(result); 
				}
			});
	}
	function loadCalendar(datashow) {
		$.ajax({
				type: "POST",
				url: "core/showCalendar.php",
				data: "date="+datashow,
				 beforeSend: function(){
					   $('#preload').show();  // #info must be defined somehwere
					   $('#calendar_place').html("");  // #info must be defined somehwere
				   },
				success:function( result ) {	
					$("#calendar_place").show().html(result); 
					
					$('#default_date').DatePicker({
						format:'Y-m-d',
						date: $('#default_date').val(),
						current: $('#default_date').val(),
						starts: 1,
						position: 'r',
						onBeforeShow: function(){
							$('#default_date').DatePickerSetDate($('#default_date').val(), true);
						}, // Mark public sweden days
						onRender: function(date) {
							var publicDays = [ 'Jan 1', 'Jan 6', 'Feb 14', 'Mar 29', 'April 1', 'April 2', 'April 3', 'April 5', 'April 6', 'May 1', 'May 14', 'May 24', 'May 25', 'May 31', 'June 6', 'June 19', 'June 20', 'Oct 25', 'Oct 31', 'Nov 8', 'Dec 13', 'Dec 24', 'Dec 25', 'Dec 26', 'Dec 31' ];
							var result = { className: false };
							var currentYear = date.getFullYear();
							for ( var day in publicDays )				
							{
								var dateTemp = publicDays[day] + ', ' + currentYear;
								var dateTempObj = new Date( dateTemp );
								if ( date.valueOf() == dateTempObj.valueOf() )
								{
									result.className = 'datepickerSpecial';
								};
							}
							return result;
						},
						onChange: function(formated, dates){
							$('#default_date').val(formated);
							loadCalendar(formated);
							$('#default_date').DatePickerHide();
							
						}
					});
				
				
				},
					   complete: function(){
							$('#preload').hide();  // #info must be defined somehwere
					   }
			});
	}
	
	
	function deletePendingBook(id) {
		$.ajax({
				type: "POST",
				url: "core/deletePendingBook.php",
				data: "id="+id,
				success:function( result ) {	
						$("#pedding_book_"+id).remove();
						show_alert_box('Booking have been deleted!', '2'); 
					}
			});
	}
	
	var show =  false;
	function showBookInfoPopupBottom(book_id) {
	
		$.ajax({
				type: "POST",
				url: "core/showPopupInfo.php",
				data: "book_id="+book_id,
				success:function( result ) {	
					$("#book_info_popup_display").html(result).slideDown("slow");
				onClick();
						}
			});
	
		
	}
	g_timer = null;
	function startTimer() {
		g_timer = setTimeout(function() {
					$("#book_info_popup_display").slideUp("slow").html("");	
				}, 4000);
	}
	
	
function onClick() {
    clearTimeout(g_timer);
    startTimer();
}

	function showBookInfoPopupBottomHide(book_id) {
			show = false;
				
	}
	function showBookInfoPopup(book_id) {
		var default_date = $( '#default_date' ).val();
		
		$.ajax({
				type: "POST",
				url: "core/editBooking.php",
				data: "default_date="+default_date+"&book_id="+book_id,
				success:function( result ) {	
					$("#book-add-form").show().html(result); 					
					
					$('#edit_date').DatePicker({
						format:'Y-m-d',
						date: $('#edit_date').val(),
						current: $('#edit_date').val(),
						starts: 1,
						position: 'r',
						onBeforeShow: function(){
							$('#edit_date').DatePickerSetDate($('#edit_date').val(), true);
						},
						onChange: function(formated, dates){
							$('#edit_date').val(formated);
								loadCalendar(formated);
							$('#edit_date').DatePickerHide();
							
							
						}
					});
				
				
				}
			});
	}
	
	function displayPendingBookingEdit(id) {
		$.ajax({
				type: "POST",
				url: "core/editPeedingBooking.php",
				data: "id="+id,
				success:function( result ) {
					$("#book-add-form").show().html(result); 
	var default_date = $('#add_date').val();
							loadCalendar(default_date);
					$('#add_date').DatePicker({
						format:'Y-m-d',
						date: $('#add_date').val(),
						current: $('#add_date').val(),
						starts: 1,
						position: 'r',
						onBeforeShow: function(){
							$('#add_date').DatePickerSetDate($('#add_date').val(), true);
						},
						onChange: function(formated, dates){
							$('#add_date').val(formated);
								loadCalendar(formated);
							$('#add_date').DatePickerHide();
							
							
						}
					});
					
					getTotalPrice();
			}
		});
	}
	function showBookEdit(book_id) {
			var default_date = $("#default_date").val();
		
		$.ajax({
				type: "POST",
				url: "core/editBooking.php",
				data: "default_date="+default_date+"&book_id="+book_id,
				success:function( result ) {	
					$("#book-add-form").show().html(result); 					
					
					$('#edit_date').DatePicker({
						format:'Y-m-d',
						date: $('#edit_date').val(),
						current: $('#edit_date').val(),
						starts: 1,
						position: 'r',
						onBeforeShow: function(){
							$('#edit_date').DatePickerSetDate($('#edit_date').val(), true);
						},
						onChange: function(formated, dates){
							$('#edit_date').val(formated);
								loadCalendar(formated);
							$('#edit_date').DatePickerHide();
							
							
						}
					});
				
				
				}
			});
	}
	
		function updateBook() {
var edit_book_id= $("#edit_book_id").val();
var edit_client_id= $("#edit_client_id").val();
		var edit_first_name = $("#edit_first_name").val();
		var edit_last_name = $("#edit_last_name").val();
			var edit_email = $("#edit_email").val();
			var edit_city = $("#edit_city").val();
			var edit_zip = $("#edit_zip").val();
			
			var total = $("#add_total").val();
			var special_offer = $("#add_special_offer").val();
			
			var edit_address = $("#edit_address").val();
			var edit_mobile = $("#edit_mobile").val();
			var edit_comment	 = $("#edit_comment").val();		
			var edit_staff = "";	
		
			 $("#edit_staff option:selected").each(function() {
				if (edit_staff != "") {
					edit_staff += "::"+$(this).val();
				} else {
				edit_staff = $(this).val();
				}
			});
			
			
			var edit_date = $("#edit_date").val();
			var edit_start_hour = $("#edit_start_hour").val();
			var edit_end_hour = $("#edit_end_hour").val();
			//var edit_service = $( 'input[name=edit_service]:checked' ).val(); //$('input[name=edit_service]:checked', '#edit_book_frm').val();
			
			 var edit_service = $('input:radio[name=edit_service]:checked').val();

       
			var edit_size = $("#edit_size").val();
			var edit_windows = $("#edit_windows").val();
		
				var clean_service = "";
			var window_service = "";
			
				$("input:checkbox[name=clean_service]:checked").each(function() {
					clean_service = $(this).val();
				});
				$("input:checkbox[name=window_service]:checked").each(function() {
					window_service = $(this).val();
				});
				
				
			if (edit_first_name == "") {$("#edit_first_name").focus(); show_alert_box('First Name is required!', '1'); return false;}
			if (edit_last_name == "") {$("#edit_last_name").focus(); show_alert_box('Last Name is required!', '1'); return false;}
			if (edit_email == "") {$("#edit_email").focus();show_alert_box('Email is required!', '1'); return false;}
			if (edit_city == "") {$("#edit_city").focus(); show_alert_box('City is required!', '1');return false;}
			if (edit_zip == "") {$("#edit_zip").focus(); show_alert_box('Zip is required!', '1');return false;}
			if (edit_address == "") {$("#edit_address").focus(); show_alert_box('Address is required!', '1'); return false;}
			if (edit_mobile == "") {$("#edit_mobile").focus(); show_alert_box('Mobile Number is required!', '1'); return false;}
			
			if (edit_staff == "") {$("#edit_staff").focus(); show_alert_box('Staff is required!', '1'); return false;}
			if (edit_frequency == "") {$("#edit_frequency").focus(); show_alert_box('Frequency is required!', '1'); return false;}
			if (edit_date == "") {$("#edit_date").focus(); show_alert_box('Date is required!', '1'); return false;}
			if (edit_start_hour == "") {$("#edit_start_hour").focus(); show_alert_box('Start Hour is required!', '1'); return false;}
			if (edit_end_hour == "") {$("#edit_end_hour").focus(); show_alert_box('End Hour is required!', '1'); return false;}
			
			

		if ( (edit_size == "") && (edit_windows == "")) {	show_alert_box("Please type size or number of window", '1');return false;}
			
			
			
			if (edit_start_hour == edit_end_hour) {
			show_alert_box('Please select date!', '1'); return false;
			}
				
			
			if (parseInt(edit_start_hour) > parseInt(edit_end_hour)) {
				$("#edit_end_hour").focus(); show_alert_box('End Hour must be less than start hour!', '1'); return false;
			}
		
				// check free time
			
					// check free time
		var	edit_frequency = 0;
			
			var clean_vec =  clean_service.split('::');
			edit_frequency = clean_vec[0];
			
			var time_check = 0;
			
			
			$.ajax({
				type: "POST",
				data: "frequency="+edit_frequency+"&start_time="+edit_start_hour+"&end_time="+edit_end_hour+"&staff="+edit_staff+"&date="+edit_date+"&book_id="+edit_book_id,
				url: "core/checkAvilableTime.php",
				success:function( result ) {	
					time_check =  result;
					
			if (parseInt(time_check) != 0) {
				show_alert_box('This staff is not available on selected time!', '1');
				return false;
			}
			
			//check time frequency
	
				var time_check = 0;
				
				var alert_txt = "";
				switch (edit_frequency) {
					case '1':
							alert_txt = " one time a month";
						break;
					case '2':
							alert_txt = " every second week";
						break;
					case '4':
							alert_txt = " every week";	
						break;
				}
				
					$.ajax({
					type: "POST",
					url: "core/updateBook.php",
					data: "action=update"+							
							"&book_id="+edit_book_id +
							"&client_id="+edit_client_id +
							"&first_name="+edit_first_name +
							"&last_name="+edit_last_name +
							"&special_offer="+special_offer +
							"&total="+total +
							"&email="+edit_email +
							"&city="+edit_city +
							"&zip="+edit_zip +
							"&address="+edit_address +
							"&mobile="+edit_mobile +
							"&comment="+edit_comment +
							"&staff="+edit_staff +
							"&clean_service="+clean_service +
							"&window_service="+window_service +
							"&date="+edit_date +
							"&start_hour="+edit_start_hour +
							"&end_hour="+edit_end_hour +
							
							"&size="+edit_size +
							"&window="+edit_windows ,
					success:function( result ) {	
				
						var default_date = $('#default_date').val();
							loadCalendar(default_date);
						
						$('#book-add-form').html('').hide();
						show_alert_box('Booking have been updated', '2');
						updateBooking();
					}
				});
				
			
					
				}
			});
		
			
			
				
	}
	

		function copyBookingNew() {
var edit_book_id= $("#edit_book_id").val();
var edit_client_id= $("#edit_client_id").val();
		var edit_first_name = $("#edit_first_name").val();
		var edit_last_name = $("#edit_last_name").val();
			var edit_email = $("#edit_email").val();
			var edit_city = $("#edit_city").val();
			var edit_zip = $("#edit_zip").val();
			
			var total = $("#add_total").val();
			var special_offer = $("#add_special_offer").val();
			
			var edit_address = $("#edit_address").val();
			var edit_mobile = $("#edit_mobile").val();
			var edit_comment	 = $("#edit_comment").val();		
			var edit_staff = "";	
		
			 $("#edit_staff option:selected").each(function() {
				if (edit_staff != "") {
					edit_staff += "::"+$(this).val();
				} else {
				edit_staff = $(this).val();
				}
			});
			
			
			var edit_date = $("#edit_date").val();
			var edit_start_hour = $("#edit_start_hour").val();
			var edit_end_hour = $("#edit_end_hour").val();
			//var edit_service = $( 'input[name=edit_service]:checked' ).val(); //$('input[name=edit_service]:checked', '#edit_book_frm').val();
			
			 var edit_service = $('input:radio[name=edit_service]:checked').val();

       
			var edit_size = $("#edit_size").val();
			var edit_windows = $("#edit_windows").val();
		
				var clean_service = "";
			var window_service = "";
			
				$("input:checkbox[name=clean_service]:checked").each(function() {
					clean_service = $(this).val();
				});
				$("input:checkbox[name=window_service]:checked").each(function() {
					window_service = $(this).val();
				});
				
				
			if (edit_first_name == "") {$("#edit_first_name").focus(); show_alert_box('First Name is required!', '1'); return false;}
			if (edit_last_name == "") {$("#edit_last_name").focus(); show_alert_box('Last Name is required!', '1'); return false;}
			if (edit_email == "") {$("#edit_email").focus();show_alert_box('Email is required!', '1'); return false;}
			if (edit_city == "") {$("#edit_city").focus(); show_alert_box('City is required!', '1');return false;}
			if (edit_zip == "") {$("#edit_zip").focus(); show_alert_box('Zip is required!', '1');return false;}
			if (edit_address == "") {$("#edit_address").focus(); show_alert_box('Address is required!', '1'); return false;}
			if (edit_mobile == "") {$("#edit_mobile").focus(); show_alert_box('Mobile Number is required!', '1'); return false;}
			
			if (edit_staff == "") {$("#edit_staff").focus(); show_alert_box('Staff is required!', '1'); return false;}
			if (edit_frequency == "") {$("#edit_frequency").focus(); show_alert_box('Frequency is required!', '1'); return false;}
			if (edit_date == "") {$("#edit_date").focus(); show_alert_box('Date is required!', '1'); return false;}
			if (edit_start_hour == "") {$("#edit_start_hour").focus(); show_alert_box('Start Hour is required!', '1'); return false;}
			if (edit_end_hour == "") {$("#edit_end_hour").focus(); show_alert_box('End Hour is required!', '1'); return false;}
			
			
			var sendUserEmail = 0;
			 if ($('#edit_sendUserEmail').is(':checked')) {
				sendUserEmail = 1;
			 }
		
		if ( (edit_size == "") && (edit_windows == "")) {	show_alert_box("Please type size or number of window", '1');return false;}
			
			
			
			if (edit_start_hour == edit_end_hour) {
			show_alert_box('Please select time!', '1'); return false;
			}
				
			
			if (parseInt(edit_start_hour) > parseInt(edit_end_hour)) {
				$("#edit_end_hour").focus(); show_alert_box('End Hour must be less than start hour!', '1'); return false;
			}
		
				// check free time
			
					// check free time
		var	edit_frequency = 0;
			
			var clean_vec =  clean_service.split('::');
			edit_frequency = clean_vec[0];
			
			var time_check = 0;
			
			
			$.ajax({
				type: "POST",
				data: "frequency="+edit_frequency+"&start_time="+edit_start_hour+"&end_time="+edit_end_hour+"&staff="+edit_staff+"&date="+edit_date+"&book_id="+edit_book_id,
				url: "core/checkAvilableTime.php",
				success:function( result ) {	
					time_check =  result;
					
			if (parseInt(time_check) != 0) {
				show_alert_box('This staff is not available on selected time!', '1');
				return false;
			}
			
			//check time frequency
	
				var time_check = 0;
				
				var alert_txt = "";
				switch (edit_frequency) {
					case '1':
							alert_txt = " one time a month";
						break;
					case '2':
							alert_txt = " every second week";
						break;
					case '4':
							alert_txt = " every week";	
						break;
				}
				
	
					$.ajax({
					type: "POST",
					url: "core/updateBookCopy.php",
					data: "action=update"+							
							"&book_id="+edit_book_id +
							"&client_id="+edit_client_id +
							"&first_name="+edit_first_name +
							"&sendUserEmail="+sendUserEmail +
							"&last_name="+edit_last_name +
							"&special_offer="+special_offer +
							"&total="+total +
							"&email="+edit_email +
							"&city="+edit_city +
							"&zip="+edit_zip +
							"&address="+edit_address +
							"&mobile="+edit_mobile +
							"&comment="+edit_comment +
							"&staff="+edit_staff +
							"&clean_service="+clean_service +
							"&window_service="+window_service +
							"&date="+edit_date +
							"&start_hour="+edit_start_hour +
							"&end_hour="+edit_end_hour +
							
							"&size="+edit_size +
							"&window="+edit_windows ,
					success:function( result ) {	
				
						var default_date = $('#default_date').val();
							loadCalendar(default_date);
						
						showBookInfoPopup(result);
						show_alert_box('Booking have been copied', '2');
						updateBooking();
					}
				});
				
			
					
				}
			});
		
			
			
				
	}
	



	function addBook() {
			var add_first_name = $("#add_first_name").val();
			var add_last_name = $("#add_last_name").val();
			var add_email = $("#add_email").val();
			var add_city = $("#add_city").val();
			var add_zip = $("#add_zip").val();
			var add_address = $("#add_address").val();
			var add_mobile = $("#add_mobile").val();
			var add_comment	 = $("#add_comment").val();	
			
			var add_total	 = $("#add_total").val();		
			var add_special_offer	 = $("#add_special_offer").val();	
			
			var pending_book_id = "";
			
			if ($("#pending_book_id").val() != "") {
				pending_book_id = $("#pending_book_id").val();
			}
			var add_staff = "";
			var add_date = $("#add_date").val();
			var add_start_hour = $("#add_start_hour").val();
			var add_end_hour = $("#add_end_hour").val();
			//var add_service = $( 'input[name=add_service]:checked' ).val(); //$('input[name=add_service]:checked', '#add_book_frm').val();
			
			 var add_service = $('input:radio[name=add_service]:checked').val();
			
			var sendUserEmail = 0;
			 if ($('#sendUserEmail').is(':checked')) {
				sendUserEmail = 1;
			 }
			 
			 
			 
		 $("#add_staff option:selected").each(function() {
				if (add_staff != "") {
					add_staff += "::"+$(this).val();
				} else {
				add_staff = $(this).val();
				}
			});
			var add_size = $("#add_size").val();
			var add_windows = $("#add_windows").val();
			
			
			if ( (add_size == "") && (add_windows == "")) {	show_alert_box("Please type size or number of window", '1');return false;}
			
	
			
			
			
			var clean_service = "";
			var window_service = "";
			
				$("input:checkbox[name=clean_service]:checked").each(function() {
					clean_service = $(this).val();
				});
				$("input:checkbox[name=window_service]:checked").each(function() {
					window_service = $(this).val();
				});
				
			
		//	var add_price_size = $("#add_price_size").val();
		//	var add_price_windows = $("#add_price_windows").val();
			
			
			if (add_first_name == "") {$("#add_first_name").focus(); show_alert_box('First Name is required!', '1'); return false;}
			if (add_last_name == "") {$("#add_last_name").focus(); show_alert_box('Last Name is required!', '1'); return false;}
			if (add_email == "") {$("#add_email").focus();show_alert_box('Email is required!', '1'); return false;}
			if (add_city == "") {$("#add_city").focus(); show_alert_box('City is required!', '1');return false;}
			if (add_zip == "") {$("#add_zip").focus(); show_alert_box('Zip is required!', '1');return false;}
			if (add_address == "") {$("#add_address").focus(); show_alert_box('Address is required!', '1'); return false;}
			if (add_mobile == "") {$("#add_mobile").focus(); show_alert_box('Mobile Number is required!', '1'); return false;}
			
			if (add_staff == "") {$("#add_staff").focus(); show_alert_box('Staff is required!', '1'); return false;}
			if (add_date == "") {$("#add_date").focus(); show_alert_box('Date is required!', '1'); return false;}
			if (add_start_hour == "") {$("#add_start_hour").focus(); show_alert_box('Start Hour is required!', '1'); return false;}
			if (add_end_hour == "") {$("#add_end_hour").focus(); show_alert_box('End Hour is required!', '1'); return false;}
			//if (add_service == "") {$("#add_service").focus(); return false;} els
			
		
			if (add_start_hour == add_end_hour) {
			show_alert_box('Please select date!', '1'); return false;
			}
				
			
			if (parseInt(add_start_hour) > parseInt(add_end_hour)) {
				$("#add_end_hour").focus(); show_alert_box('Star Hour must be less than end hour!', '1'); return false;
			}
		
				// check free time
		var	add_frequency = 0;
			
			var clean_vec =  clean_service.split('::');
			add_frequency = clean_vec[0];
			
			var time_check = 0;
			
		 $("#add_staff option:selected").each(function() {
			staff_id = $(this).val();
            $.ajax({
				type: "POST",
				data: "frequency="+add_frequency+"&start_time="+add_start_hour+"&end_time="+add_end_hour+"&staff="+staff_id+"&date="+add_date,
				url: "core/checkAvilableTime.php",
				success:function( result ) {	
				
					time_check =  result;
					if (time_check != 0) {
						show_alert_box('Staff is not available on selected time!', '1');
						return false;
					}
				}
			});
        });

		
			
			
			var time_check = 0;
		
			//check time frequency
	//		if (add_frequency!=0) {
				
				
				var alert_txt = "";
				switch (add_frequency) {
					case '1':
							alert_txt = " one time a month";
						break;
					case '2':
							alert_txt = " every second week";
						break;
					case '4':
							alert_txt = " every week";	
						break;
				}
				
				$.ajax({
					type: "POST",
					data: "start_time="+add_start_hour+"&end_time="+add_end_hour+"&staff="+add_staff+"&date="+add_date+"&frequency="+add_frequency,
					url: "core/checkAvilableTime.php",
					success:function( result ) {					
						time_check =  result;
						
						if (time_check != 0) {
					show_alert_box('This staff is not available on selected time over '+alert_txt+'!', '1');
					return false;
				} else {
				$.ajax({
					type: "POST",
					url: "core/addBook.php",
					data: "action=add"+
							"&first_name="+add_first_name +
							"&last_name="+add_last_name +
							"&email="+add_email +
							"&sendUserEmail="+sendUserEmail +
							"&special_offer="+add_special_offer +
							"&total="+add_total +
							"&city="+add_city +
							"&zip="+add_zip +
							"&address="+add_address +
							"&mobile="+add_mobile +
							"&comment="+add_comment +
							"&pending_book_id="+pending_book_id +
							"&clean_service="+clean_service +
							"&window_service="+window_service +
							"&staff="+add_staff +
							"&date="+add_date +
							"&start_hour="+add_start_hour +
							"&end_hour="+add_end_hour +
							"&size="+add_size +
							"&window="+add_windows ,
					success:function( result ) {	
					
						$('#book-add-form').html('').hide();
						var default_date = $('#default_date').val();
							loadCalendar(default_date);
						show_alert_box('Booking have been saved', '2');
						if (pending_book_id != "") {
							$("#pedding_book_"+pending_book_id).remove();
						}
						updateBooking();
					}
				});
				
				}
						
						
						
						
						
						
					}
				});
				
		//	}
			
		
				
				
		}
	
	function cancelService() {
		$("#service_name").val("");		
		$("#background").val("");		
		$('#book-add-service').hide();
	}
	
	function showAddNewBooking() {
		var default_date = $("#default_date").val();
		
		$.ajax({
				type: "POST",
				url: "core/addBooking.php",
				data: "default_date="+default_date,
				success:function( result ) {	
					$("#book-add-form").show().html(result); 
					
					
					$('#add_date').DatePicker({
						format:'Y-m-d',
						date: $('#add_date').val(),
						current: $('#add_date').val(),
						starts: 1,
						position: 'r',
						onBeforeShow: function(){
							$('#add_date').DatePickerSetDate($('#add_date').val(), true);
						},
						onChange: function(formated, dates){
							$('#add_date').val(formated);
								loadCalendar(formated);
							$('#add_date').DatePickerHide();
							
							
						}
					});
				
				
				}
			});
	}
	function cancelBookList() {
		
		$('#book-history').html("").hide();
	}
	function cancelStaff() {
		$("#staff_name").val("");
		$("#staff_phone").val(""); 
		$("#staff_email").val("");
						
		$('#book-add-staff').hide();
	}
	function cancelStaffEdit() {
		$("#book-edit-staff").html("").hide(); 
	}
	function cancelServiceEdit() {
		$("#book-edit-service").html("").hide(); 
	}
	function cancelPriceEdit() {
		$("#edit-price").html("").hide(); 
	}
	
	function editPrice(id) {

		$.ajax({
				type: "POST",
				url: "core/editPrice.php",
				data: "action=edit&id="+id,
				success:function( result ) {	
					$("#edit-price").show().html(result); 
				}
			});
	}

	function editStaff(id) {
		
			$.ajax({
				type: "POST",
				url: "core/editStaff.php",
				data: "action=edit&id="+id,
				success:function( result ) {	
					$("#book-edit-staff").show().html(result); 
				}
			});
	}
	function editService(id) {
		$.ajax({
				type: "POST",
				url: "core/editService.php",
				data: "action=edit&id="+id,
				success:function( result ) {	
					$("#book-edit-service").show().html(result); 
				}
			});
	}
	
	function updatePrice() {
		var edit_price_service = $("#edit_price_service").val();
		var edit_price_amount = $("#edit_price_amount").val(); 
		var edit_price_min_value = $("#edit_price_min_value").val();
		var edit_price_frequency = $("#edit_price_frequency").val();
		var edit_price_max_value = $("#edit_price_max_value").val();
		
		var edit_price_id = $("#edit_price_id").val();
		
		if (edit_price_service == "") { $("#edit_price_service").focus(); show_alert_box('Service is required', '1'); return false;	}
		if (edit_price_amount == "") { $("#edit_price_amount").focus(); show_alert_box('Amount is required', '1'); return false;	}
		if (edit_price_min_value == "") { $("#edit_price_min_value").focus(); show_alert_box('Minimum value is required', '1'); return false;	}
		if (edit_price_max_value == "") { $("#edit_price_max_value").focus(); show_alert_box('Maximum value is required', '1'); return false;	}
		if (edit_price_frequency == "") { $("#edit_price_frequency").focus(); show_alert_box('Frequency is required', '1'); return false;	}
		
		$.ajax({
					type: "POST",
					url: "core/updatePrice.php",
					data: "action=update&service_id="+edit_price_service+"&amount="+edit_price_amount+"&min_value="+edit_price_min_value+"&max_value="+edit_price_max_value+"&id="+edit_price_id+"&frequency="+edit_price_frequency,
					 success:function( result ) {	
						cancelPriceEdit();
					//	$("#price_row_"+edit_price_id).remove();
						$("#price_table_list").html(result);
						show_alert_box('Price have been updated', '2'); 
					}
				});
	}
	function updateStaff() {
		var staff_name = $("#ed_staff_name").val();
		var staff_phone = $("#ed_staff_phone").val(); 
		var staff_email = $("#ed_staff_email").val();
		
		var ed_staff_id = $("#ed_staff_id").val();
		
		if (staff_name == "") { $("#ed_staff_name").focus(); show_alert_box('Staff name is required', '1'); return false;	}
		if (staff_phone == "") { $("#ed_staff_phone").focus(); show_alert_box('Staff phone is required', '1'); return false;	}
		if (staff_email == "") { $("#ed_staff_email").focus(); show_alert_box('Staff email is required', '1'); return false;	}
		
		$.ajax({
					type: "POST",
					url: "core/updateStaff.php",
					data: "action=update&staff_name="+staff_name+"&staff_phone="+staff_phone+"&staff_email="+staff_email+"&id="+ed_staff_id,
					 success:function( result ) {	
						cancelStaffEdit();
						$("#staff_row_"+ed_staff_id).remove();
						$("#staff_table_list").append(result);
						show_alert_box('Staff have been updated', '2'); 
					}
				});
				
	}
	function updateService() {
		var service_name = $("#ed_service_name").val();
		var ed_background = $("#ed_background").val();
		var ed_service_id = $("#ed_service_id").val();
		

		
		var show_on = $("#ed_show_on").val();
		var service_type = $("#ed_service_type").val();
		var service_position = $("#ed_service_position").val();
		var service_url = $("#ed_service_url").val();
		
		
		if (ed_service_name == "") { $("#ed_service_name").focus(); show_alert_box('Service name is required', '1'); return false;	}
		if (ed_background == "") { $("#ed_background").focus(); show_alert_box('Service background is required', '1'); return false;	}
		if (show_on == "") { $("#ed_show_on").focus(); show_alert_box('Service show on is required', '1');  return false;	}
		if (service_type == "") { $("#ed_service_type").focus(); show_alert_box('Service type is required', '1');  return false;	}
		if (service_position == "") { $("#ed_service_position").focus(); show_alert_box('Service position is required', '1');  return false;	}
		if (service_url == "") { $("#ed_service_url").focus(); show_alert_box('Service url is required', '1');  return false;	}
		
		
		$.ajax({
					type: "POST",
					url: "core/updateService.php",
					data: "action=update&service_name="+service_name+
					"&show_on="+show_on+
					"&service_type="+service_type+
					"&service_position="+service_position+
					"&service_url="+service_url+
					"&background="+ed_background+"&id="+ed_service_id,
					 success:function( result ) {	
						cancelServiceEdit();
						$("#service_row_"+ed_service_id).remove();
						$("#service_table_list").append(result);
						show_alert_box('Service have been updated', '2'); 
					}
				});
	}
	function cleaningDatesInterval(book_id) {
			var start_date = $("#clean_date_start").val();
			var end_date = $("#clean_date_end").val();
			$.ajax({
					type: "POST",
					url: "core/getCleaningDateInt.php",
					data: "book_id="+book_id+"&start_date="+start_date+"&end_date="+end_date,
					 success:function( result ) {
					
						$("#extra-info").html(result);
						
						$('#clean_date_start').DatePicker({
								format:'Y-m-d',
								date: $('#clean_date_start').val(),
								current: $('#clean_date_start').val(),
								starts: 1,
								position: 'r',
								onBeforeShow: function(){
									$('#clean_date_start').DatePickerSetDate($('#clean_date_start').val(), true);
								},
								onChange: function(formated, dates){
									$('#clean_date_start').val(formated);
										
									$('#clean_date_start').DatePickerHide();
									
									
								}
							});
						$('#clean_date_end').DatePicker({
								format:'Y-m-d',
								date: $('#clean_date_end').val(),
								current: $('#clean_date_end').val(),
								starts: 1,
								position: 'r',
								onBeforeShow: function(){
									$('#clean_date_end').DatePickerSetDate($('#clean_date_end').val(), true);
								},
								onChange: function(formated, dates){
									$('#clean_date_end').val(formated);
								
									$('#clean_date_end').DatePickerHide();
									
									
								}
							});
						
						
					}
				});
	}
	function cleaningDates(book_id) {
		$.ajax({
					type: "POST",
					url: "core/getCleaningDate.php",
					data: "book_id="+book_id,
					 success:function( result ) {
					
						$("#extra-info").html(result);
						
						$('#clean_date_start').DatePicker({
								format:'Y-m-d',
								date: $('#clean_date_start').val(),
								current: $('#clean_date_start').val(),
								starts: 1,
								position: 'r',
								onBeforeShow: function(){
									$('#clean_date_start').DatePickerSetDate($('#clean_date_start').val(), true);
								},
								onChange: function(formated, dates){
									$('#clean_date_start').val(formated);
										
									$('#clean_date_start').DatePickerHide();
									
									
								}
							});
						$('#clean_date_end').DatePicker({
								format:'Y-m-d',
								date: $('#clean_date_end').val(),
								current: $('#clean_date_end').val(),
								starts: 1,
								position: 'r',
								onBeforeShow: function(){
									$('#clean_date_end').DatePickerSetDate($('#clean_date_end').val(), true);
								},
								onChange: function(formated, dates){
									$('#clean_date_end').val(formated);
										
									$('#clean_date_end').DatePickerHide();
									
									
								}
							});
						
						
					}
				});
	}
	
	function sendCleaningDateEmail(book_id) {
			var clean_date_start = $("#clean_date_start").val();
			var clean_date_end = $("#clean_date_end").val();
		$.ajax({
					type: "POST",
					url: "core/getCleaningDateSend.php",
					data: "book_id="+book_id+"&clean_date_end="+clean_date_end+"&clean_date_start="+clean_date_start,
					 success:function( result ) {
						show_alert_box('Booking date email have been send.', '2'); 
						$("#extra-info").html("");
					}
				});
	}
	function copyBooking(book_id){
		$.ajax({
					type: "POST",
					url: "core/copyBooking.php",
					data: "book_id="+book_id,
					 success:function( result ) {	
				
							$("#book-add-form").html(result);
							$('#edit_date').DatePicker({
								format:'Y-m-d',
								date: $('#edit_date').val(),
								current: $('#edit_date').val(),
								starts: 1,
								position: 'r',
								onBeforeShow: function(){
									$('#edit_date').DatePickerSetDate($('#edit_date').val(), true);
								},
								onChange: function(formated, dates){
									$('#edit_date').val(formated);
										loadCalendar(formated);
									$('#edit_date').DatePickerHide();
									
									
								}
							});
					
					
					}
				});
	}
	
	function copyBookingEmail() {
		var client_id = $("#copy_client_id").val();
		var staff_id = $("#copy_staff_id").val();
		var book_id = $("#copy_book_id").val();
		var new_date = $("#copy_new_date").val();
		var old_date = $("#copy_old_date").val();
		
		var end_hour = $("#edit_end_hour").val();
		var start_hour = $("#edit_start_hour").val();
		
		if ($("#copy_new_date").val() == "") {
			$("#copy_new_date").focus();
			show_alert_box('Select a new date', '1'); 
			return false;
		}
			$.ajax({
					type: "POST",
					url: "core/copyBookingSetup.php",
					data: "client_id="+client_id + "&staff_id="+staff_id+ "&book_id="+book_id+ "&new_date="+new_date+ "&end_hour="+end_hour+ "&start_hour="+start_hour,
					 success:function( result ) {	
			
							switch (result) {
								case '1':
										show_alert_box('Booking have been setup to new date.', '2'); 
										$("#extra-info").html('');
									break;
								case '2':
										show_alert_box('Staff member is not available on that date.', '1'); 
									break;
							}
							return false;
					}
				});
			return false;
		
	}
	function emailStatusChange(status) {
		$.ajax({
					type: "POST",
					url: "core/updateEmailStatus.php",
					data: "status="+status,
					 success:function( result ) {	
							$('#emailStatusDiv').html(result);
					}
				});
	}
	function savePrice() {
		var add_price_service = $("#add_price_service").val();
		var add_price_amount = $("#add_price_amount").val();
		var add_price_min_value = $("#add_price_min_value").val();
		var add_price_max_value = $("#add_price_max_value").val();
		var add_price_frequency = $("#add_price_frequency").val();
		
		if (add_price_service == "") { $("#add_price_service").focus(); show_alert_box('Service is required', '1');  return false;	}
		if (add_price_amount == "") { $("#add_price_amount").focus(); show_alert_box('Amount is required', '1');  return false;	}
		if (add_price_min_value == "") { $("#add_price_min_value").focus(); show_alert_box('Minimum value is required', '1');  return false;	}
		if (add_price_max_value == "") { $("#add_price_max_value").focus(); show_alert_box('Maximum value is required', '1');  return false;	}
		if (add_price_frequency == "") { $("#add_price_frequency").focus(); show_alert_box('Frequency is required', '1');  return false;	}
		
		
		$.ajax({
					type: "POST",
					url: "core/savePrice.php",
					data: "action=add&add_price_service="+add_price_service+
							"&add_price_amount="+add_price_amount+
							"&add_price_min_value="+add_price_min_value+
							"&add_price_frequency="+add_price_frequency+
							"&add_price_max_value="+add_price_max_value	,
					 success:function( result ) {	
						cancelPrice();
						$("#price_table_list").html(result);
						show_alert_box('Price have been saved', '2'); 
					}
				});
				
	}
	function saveService() {
		var service_name = $("#service_name").val();
		var background = $("#background").val();
		
		var show_on = $("#show_on").val();
		var service_type = $("#service_type").val();
		var service_position = $("#service_position").val();
		var service_url = $("#service_url").val();
		
		if (service_name == "") { $("#service_name").focus(); show_alert_box('Service name is required', '1');  return false;	}
		if (background == "") { $("#background").focus(); show_alert_box('Service background is required', '1');  return false;	}
		
		if (show_on == "") { $("#show_on").focus(); show_alert_box('Service show on is required', '1');  return false;	}
		if (service_type == "") { $("#service_type").focus(); show_alert_box('Service type is required', '1');  return false;	}
		if (service_position == "") { $("#service_position").focus(); show_alert_box('Service position is required', '1');  return false;	}
		if (service_url == "") { $("#service_url").focus(); show_alert_box('Service url is required', '1');  return false;	}
		
		
		$.ajax({
					type: "POST",
					url: "core/saveService.php",
					data: "action=add&service_name="+service_name+
					"&show_on="+show_on+
					"&service_type="+service_type+
					"&service_position="+service_position+
					"&service_url="+service_url+
					"&background="+background,
					 success:function( result ) {	
						cancelService();
						$("#service_table_list").append(result);
						show_alert_box('Service have been saved', '2'); 
					}
				});
	}
	function saveStaff() {
		var staff_name = $("#staff_name").val();
		var staff_phone = $("#staff_phone").val(); 
		var staff_email = $("#staff_email").val();
		
		if (staff_name == "") { $("#staff_name").focus(); show_alert_box('Staff name is required', '1');  return false;	}
		if (staff_phone == "") { $("#staff_phone").focus(); show_alert_box('Staff phone is required', '1');  return false;	}
		if (staff_email == "") { $("#staff_email").focus(); show_alert_box('Staff email is required', '1');  return false;	}
		
		$.ajax({
					type: "POST",
					url: "core/saveStaff.php",
					data: "action=add&staff_name="+staff_name+"&staff_phone="+staff_phone+"&staff_email="+staff_email,
					 success:function( result ) {	
						cancelStaff();
						$("#staff_table_list").append(result);
						show_alert_box('Staff have been saved', '2'); 
					}
				});
				
				
	}
			function deleteStaff(id) {
				$.ajax({
					type: "POST",
					url: "core/deleteStaff.php",
					data: "action=delete&id="+id,
					 success:function( result ) {	
						if (result == "1") {
							$("#staff_row_"+id).remove();
							 show_alert_box('Staff have been deleted', '2'); 
						}
					}
				});
			}
			function deleteService(id) {
				$.ajax({
					type: "POST",
					url: "core/deleteService.php",
					data: "action=delete&id="+id,
					success:function( result ) {
						if (result == "1") {
							$("#service_row_"+id).remove();
							 show_alert_box('Service been deleted', '2'); 
						}
					}
				});
			}
			function deletePrice(id) {
				
			$.ajax({
					type: "POST",
					url: "core/deleteServicePrice.php",
					data: "action=delete&id="+id,
					success:function( result ) {
						if (result == "1") {
							$("#price_row_"+id).remove();
							 show_alert_box('Price been deleted', '2'); 
						}
					}
				});
			}
			function showStaffList() {
				$("#book-staff").show();
				$("#book-service").hide();
				$("#price-list").hide();
				cancelStaff();
				cancelPrice();
				cancelService();
				cancelStaffEdit();
				cancelServiceEdit();
				cancelBookList();
			}
			function showServiceList() {
				$("#book-service").show();
				$("#book-staff").hide();
					$("#price-list").hide();
				cancelStaff();
				cancelService();
				cancelStaffEdit();
				cancelServiceEdit();
				cancelPrice();
				cancelBookList();
			}
   		</script>
 	</body>
 </html>