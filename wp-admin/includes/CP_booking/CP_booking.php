<?php
/**
 * Plugin Name: Booking Staff v1
 * Plugin URI: http://renthem.se
 * Description: Booking system
 * Version: 1.0
 * Author: Ciprian
 * Author URI: http://world10top.com/
 * License: GPL2
 */


 // add the admin options page
add_action('admin_menu', 'plugin_admin_add_page');
function plugin_admin_add_page() {
 add_menu_page( 'Booking', 'Booking v2', 'manage_options', 'booking_v2/admin.php', '', plugins_url( 'booking_v2/images/icon.png' ), 110 );
}
?>
<?php // display the admin options page
function plugin_options_page() {
?>
<?php
	include("core.php");
?>
  <div class="alert-line"><h3></h3></div>
  <?php
	$date = date("d-m-Y");
  ?>
  			<div id="book-wrap">
  		<div id="calendar_place">
  				
  		</div>
  				<div class="clear"></div>
  				<div class="book-add" id="book-add-form">
  					
  					
  				</div>
  				<div class="book-add" id="book-edit-form">  					
  				</div>
  				
  				<div class="clear"></div>
  				<div id="book-pending" style="display:none;">
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
  								<tr>
	  								<td>dad</td>
	  								<td>dca</td>
	  								<td>dad</td>
	  								<td>sada</td>
	  								<td><a href="#">view</a></td>
	  								<td></td>
	  								<td></td>
	  							</tr>
  							</tbody>
  							
  						</table>
  					
  				</div>
  				<div id="book-setting">
  					<button onclick="showStaffList();" class="btn b-default">Staff</button>
  					<button onclick="showServiceList();" class="btn b-default">Services</button>  	
  					<button onclick="showBookingList();" class="btn b-default">Bookings</button>  	
					<button onclick="showPriceList();" class="btn b-default">Price List</button>  	
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
							<table>
  						<thead>
  							<tr>
	  							<td>Service</td>
								<td>Amount</td>
								<td>Value</td>
	  							<td>Tools</td>
	  						</tr>
  						</thead>
  						<tbody id="price_table_list">
  							<?php
  								foreach ($priceArr as $value) {
							?>	
								<tr id="price_row_<?=$value['id']?>">
									<td><?=$service->getServiceName($value['service_id'])?></td>
									<td style="text-align: center !important;"><?=$value['amount']?></td>
									<td style="text-align: center !important;"><?=$value['start_value']?> - <?=$value['end_value']?></td>
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
  				
  			</div>
  	
  	
  			<script type="text/javascript" src="js/jquery.js"></script>
  			<script type="text/javascript" src="js/booking.js"></script>
			<script type="text/javascript" src="js/datepicker.js"></script>
   			<script type="text/javascript" src="js/eye.js"></script>
   			<script type="text/javascript" src="js/utils.js"></script>

   			<script type="text/javascript">
   			$( document ).ready(function() {
   				
				
				
				loadCalendar("<?=$date?>");
				
			});
			</script>
		
	<script type="text/javascript">
	function cancelPrice() {
		$("#add_price_amount").val("");
		$("#add_price_min_value").val(""); 
		$("#add_price_service").val("");
		$("#add_price_max_value").val("");
						
		$('#book-add-price').hide();
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
	function deleteBook(book_id, date) {
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
	function updateSizePrice(size) {
		var service = $('input:radio[name=add_service]:checked').val();
		
			$.ajax({
				type: "POST",
				data: "size="+size+"&service="+service,
				url: "core/caculateAmount.php",
				success:function( result ) {	
				
					$("#add_price_size").val(result); 
				}
			});
		
	
	}
	function updateWindowsPrice(size) {
		var service = $('input:radio[name=add_service]:checked').val();
		
			$.ajax({
				type: "POST",
				data: "size="+size+"&service="+service,
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
				success:function( result ) {	
					$("#calendar_place").show().html(result); 
					
					$('#default_date').DatePicker({
						format:'d-m-Y',
						date: $('#default_date').val(),
						current: $('#default_date').val(),
						starts: 1,
						position: 'r',
						onBeforeShow: function(){
							$('#default_date').DatePickerSetDate($('#default_date').val(), true);
						},
						onChange: function(formated, dates){
							$('#default_date').val(formated);
							loadCalendar(formated);
							$('#default_date').DatePickerHide();
							
						}
					});
				
				
				}
			});
	}
	function showBookInfoPopup(book_id) {
		var default_date = "";
		
		$.ajax({
				type: "POST",
				url: "core/editBooking.php",
				data: "default_date="+default_date+"&book_id="+book_id,
				success:function( result ) {	
					$("#book-add-form").show().html(result); 					
					
					$('#edit_date').DatePicker({
						format:'d-m-Y',
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
	
	function showBookEdit(book_id) {
			var default_date = $("#default_date").val();
		
		$.ajax({
				type: "POST",
				url: "core/editBooking.php",
				data: "default_date="+default_date+"&book_id="+book_id,
				success:function( result ) {	
					$("#book-add-form").show().html(result); 					
					
					$('#edit_date').DatePicker({
						format:'d-m-Y',
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
		var edit_name = $("#edit_name").val();
			var edit_email = $("#edit_email").val();
			var edit_city = $("#edit_city").val();
			var edit_zip = $("#edit_zip").val();
			var edit_address = $("#edit_address").val();
			var edit_mobile = $("#edit_mobile").val();
			var edit_comment	 = $("#edit_comment").val();		
				
			var edit_staff = $("#edit_staff").val();
			var edit_frequency = $("#edit_frequency").val();
			var edit_date = $("#edit_date").val();
			var edit_start_hour = $("#edit_start_hour").val();
			var edit_end_hour = $("#edit_end_hour").val();
			//var edit_service = $( 'input[name=edit_service]:checked' ).val(); //$('input[name=edit_service]:checked', '#edit_book_frm').val();
			
			 var edit_service = $('input:radio[name=edit_service]:checked').val();

       
			var edit_size = $("#edit_size").val();
			var edit_windows = $("#edit_windows").val();
			var edit_price_size = $("#edit_price_size").val();
			var edit_price_windows = $("#edit_price_windows").val();
			
			
			if (edit_name == "") {$("#edit_name").focus(); show_alert_box('Name is required!', '1'); return false;}
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
			//if (edit_service == "") {$("#edit_service").focus(); return false;} els
			if (edit_service == 4) {
				if (edit_windows == "") {$("#edit_windows").focus(); return false;}			
				if (edit_price_windows == "") {$("#edit_price_windows").focus(); return false;}
			} else {
				if (edit_size == "") {$("#edit_size").focus(); return false;}
				if (edit_price_size == "") {$("#edit_price_size").focus(); return false;}
			}
			
			if (edit_start_hour > edit_end_hour) {
				$("#edit_end_hour").focus(); show_alert_box('End Hour must be less than start hour!', '1'); return false;
			}
		
				// check free time
			
			var time_check = 0;
			
			
			$.ajax({
				type: "POST",
				data: "start_time="+edit_start_hour+"&end_time="+edit_end_hour+"&staff="+edit_staff+"&date="+edit_date,
				url: "core/checkAvilableTime.php",
				success:function( result ) {	
					time_check =  result;
				}
			});
			if (time_check != 0) {
				show_alert_box('This staff is not available on selected time!', '1');
				return false;
			}
			
			//check time frequency
			if (edit_frequency!=0) {
				var time_check = 0;
				
				var alert_txt = "";
				switch (edit_frequency) {
					case '1':
							alert_txt = " 1 week";
						break;
					case '2':
							alert_txt = " 2 weeks";
						break;
					case '4':
							alert_txt = " 4 weeks";	
						break;
				}
				
				$.ajax({
					type: "POST",
					data: "start_time="+edit_start_hour+"&end_time="+edit_end_hour+"&staff="+edit_staff+"&date="+edit_date+"&frequency="+edit_frequency,
					url: "core/checkAvilableTime.php",
					success:function( result ) {					
						time_check =  result;
					}
				});
				if (time_check != 0) {
					show_alert_box('This staff is not available on selected time over '+alert_txt+'!', '1');
					return false;
				}
			}
			
				$.ajax({
					type: "POST",
					url: "core/updateBook.php",
					data: "action=update"+							
							"&book_id="+edit_book_id +
							"&client_id="+edit_client_id +
							"&name="+edit_name +
							"&email="+edit_email +
							"&city="+edit_city +
							"&zip="+edit_zip +
							"&address="+edit_address +
							"&mobile="+edit_mobile +
							"&comment="+edit_comment +
							"&staff="+edit_staff +
							"&frequency="+edit_frequency +
							"&date="+edit_date +
							"&start_hour="+edit_start_hour +
							"&end_hour="+edit_end_hour +
							"&service="+edit_service +
							"&size="+edit_size +
							"&window="+edit_windows +
							"&price_size="+edit_price_size +
							"&price_windows="+edit_price_windows,
					success:function( result ) {	
						var default_date = $('#default_date').val();
							loadCalendar(default_date);
						
						$('#book-add-form').html('').hide();
						show_alert_box('Booking have been updated', '2');
					}
				});
				
	}
		function addBook() {
			var add_name = $("#add_name").val();
			var add_email = $("#add_email").val();
			var add_city = $("#add_city").val();
			var add_zip = $("#add_zip").val();
			var add_address = $("#add_address").val();
			var add_mobile = $("#add_mobile").val();
			var add_comment	 = $("#add_comment").val();		
				
			var add_staff = $("#add_staff").val();
			var add_frequency = $("#add_frequency").val();
			var add_date = $("#add_date").val();
			var add_start_hour = $("#add_start_hour").val();
			var add_end_hour = $("#add_end_hour").val();
			//var add_service = $( 'input[name=add_service]:checked' ).val(); //$('input[name=add_service]:checked', '#add_book_frm').val();
			
			 var add_service = $('input:radio[name=add_service]:checked').val();

       
			var add_size = $("#add_size").val();
			var add_windows = $("#add_windows").val();
			var add_price_size = $("#add_price_size").val();
			var add_price_windows = $("#add_price_windows").val();
			
			
			if (add_name == "") {$("#add_name").focus(); show_alert_box('Name is required!', '1'); return false;}
			if (add_email == "") {$("#add_email").focus();show_alert_box('Email is required!', '1'); return false;}
			if (add_city == "") {$("#add_city").focus(); show_alert_box('City is required!', '1');return false;}
			if (add_zip == "") {$("#add_zip").focus(); show_alert_box('Zip is required!', '1');return false;}
			if (add_address == "") {$("#add_address").focus(); show_alert_box('Address is required!', '1'); return false;}
			if (add_mobile == "") {$("#add_mobile").focus(); show_alert_box('Mobile Number is required!', '1'); return false;}
			
			if (add_staff == "") {$("#add_staff").focus(); show_alert_box('Staff is required!', '1'); return false;}
			if (add_frequency == "") {$("#add_frequency").focus(); show_alert_box('Frequency is required!', '1'); return false;}
			if (add_date == "") {$("#add_date").focus(); show_alert_box('Date is required!', '1'); return false;}
			if (add_start_hour == "") {$("#add_start_hour").focus(); show_alert_box('Start Hour is required!', '1'); return false;}
			if (add_end_hour == "") {$("#add_end_hour").focus(); show_alert_box('End Hour is required!', '1'); return false;}
			//if (add_service == "") {$("#add_service").focus(); return false;} els
			if (add_service == 4) {
				if (add_windows == "") {$("#add_windows").focus(); return false;}			
				if (add_price_windows == "") {$("#add_price_windows").focus(); return false;}
			} else {
				if (add_size == "") {$("#add_size").focus(); return false;}
				if (add_price_size == "") {$("#add_price_size").focus(); return false;}
			}
			
			if (add_start_hour > add_end_hour) {
				$("#add_end_hour").focus(); show_alert_box('End Hour must be less than start hour!', '1'); return false;
			}
		
				// check free time
			
			var time_check = 0;
			
			
			$.ajax({
				type: "POST",
				data: "start_time="+add_start_hour+"&end_time="+add_end_hour+"&staff="+add_staff+"&date="+add_date,
				url: "core/checkAvilableTime.php",
				success:function( result ) {	
					time_check =  result;
				}
			});
			if (time_check != 0) {
				show_alert_box('This staff is not available on selected time!', '1');
				return false;
			}
			
			//check time frequency
			if (add_frequency!=0) {
				var time_check = 0;
				
				var alert_txt = "";
				switch (add_frequency) {
					case '1':
							alert_txt = " 1 week";
						break;
					case '2':
							alert_txt = " 2 weeks";
						break;
					case '4':
							alert_txt = " 4 weeks";	
						break;
				}
				
				$.ajax({
					type: "POST",
					data: "start_time="+add_start_hour+"&end_time="+add_end_hour+"&staff="+add_staff+"&date="+add_date+"&frequency="+add_frequency,
					url: "core/checkAvilableTime.php",
					success:function( result ) {					
						time_check =  result;
					}
				});
				if (time_check != 0) {
					show_alert_box('This staff is not available on selected time over '+alert_txt+'!', '1');
					return false;
				}
			}
			
				$.ajax({
					type: "POST",
					url: "core/addBook.php",
					data: "action=add"+
							"&name="+add_name +
							"&email="+add_email +
							"&city="+add_city +
							"&zip="+add_zip +
							"&address="+add_address +
							"&mobile="+add_mobile +
							"&comment="+add_comment +
							"&staff="+add_staff +
							"&frequency="+add_frequency +
							"&date="+add_date +
							"&start_hour="+add_start_hour +
							"&end_hour="+add_end_hour +
							"&service="+add_service +
							"&size="+add_size +
							"&window="+add_windows +
							"&price_size="+add_price_size +
							"&price_windows="+add_price_windows,
					success:function( result ) {	
						$('#book-add-form').html('').hide();
						var default_date = $('#default_date').val();
							loadCalendar(default_date);
						show_alert_box('Booking have been saved', '2');
					}
				});
				
				
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
						format:'d-m-Y',
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
		var edit_price_max_value = $("#edit_price_max_value").val();
		
		var edit_price_id = $("#edit_price_id").val();
		
		if (edit_price_service == "") { $("#edit_price_service").focus(); show_alert_box('Service is required', '1'); return false;	}
		if (edit_price_amount == "") { $("#edit_price_amount").focus(); show_alert_box('Amount is required', '1'); return false;	}
		if (edit_price_min_value == "") { $("#edit_price_min_value").focus(); show_alert_box('Minimum value is required', '1'); return false;	}
		if (edit_price_max_value == "") { $("#edit_price_max_value").focus(); show_alert_box('Maximum value is required', '1'); return false;	}
		
		$.ajax({
					type: "POST",
					url: "core/updatePrice.php",
					data: "action=update&service_id="+edit_price_service+"&amount="+edit_price_amount+"&min_value="+edit_price_min_value+"&max_value="+edit_price_max_value+"&id="+edit_price_id,
					 success:function( result ) {	
						cancelStaffEdit();
						$("#price_row_"+edit_price_id).remove();
						$("#price_table_list").append(result);
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
					}
				});
				
	}
	function updateService() {
		var service_name = $("#ed_service_name").val();
		var ed_background = $("#ed_background").val();
		var ed_service_id = $("#ed_service_id").val();
		if (ed_service_name == "") { $("#ed_service_name").focus(); show_alert_box('Service name is required', '1'); return false;	}
		if (ed_background == "") { $("#ed_background").focus(); show_alert_box('Service background is required', '1'); return false;	}
		$.ajax({
					type: "POST",
					url: "core/updateService.php",
					data: "action=update&service_name="+ed_service_name+"&background="+ed_background+"&id="+ed_service_id,
					 success:function( result ) {	
						cancelStaffEdit();
						$("#service_row_"+ed_service_id).remove();
						$("#service_table_list").append(result);
					}
				});
	}
	function savePrice() {
		var add_price_service = $("#add_price_service").val();
		var add_price_amount = $("#add_price_amount").val();
		var add_price_min_value = $("#add_price_min_value").val();
		var add_price_max_value = $("#add_price_max_value").val();
		
		if (add_price_service == "") { $("#add_price_service").focus(); show_alert_box('Service is required', '1');  return false;	}
		if (add_price_amount == "") { $("#add_price_amount").focus(); show_alert_box('Amount is required', '1');  return false;	}
		if (add_price_min_value == "") { $("#add_price_min_value").focus(); show_alert_box('Minimum value is required', '1');  return false;	}
		if (add_price_max_value == "") { $("#add_price_max_value").focus(); show_alert_box('Maximum value is required', '1');  return false;	}
		
		
		$.ajax({
					type: "POST",
					url: "core/savePrice.php",
					data: "action=add&add_price_service="+add_price_service+
							"&add_price_amount="+add_price_amount+
							"&add_price_min_value="+add_price_min_value+
							"&add_price_max_value="+add_price_max_value	,
					 success:function( result ) {	
						cancelPrice();
						$("#price_table_list").append(result);
						show_alert_box('Price have been saved', '2'); 
					}
				});
				
	}
	function saveService() {
		var service_name = $("#service_name").val();
		var background = $("#background").val();
		if (service_name == "") { $("#service_name").focus(); show_alert_box('Service name is required', '1');  return false;	}
		if (background == "") { $("#background").focus(); show_alert_box('Service background is required', '1');  return false;	}
		$.ajax({
					type: "POST",
					url: "core/saveService.php",
					data: "action=add&service_name="+service_name+"&background="+background,
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
 
<?php
}?>