<?php
	include("../core.php");
?>
<a href="javascript:;" onclick="$('#book-add-form').html('').hide();" class="close">x</a>
  					<h1>Add Booking</h1>
  					<div class="booking-add-box">
	  						<div class="booking-column-2">
	  		<form action="" method="post" id="add_book_frm">	 		
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>First Name</label>
	  									<input type="text" name="add_first_name" id="add_first_name" value="" />
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Last Name</label>
	  									<input type="text" name="add_last_name" id="add_last_name" value="" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
								<div class="row">
	  								<div class="booking-column-1">
	  									<label>Address</label>
	  									<textarea name="add_address" id="add_address" rows="2"></textarea>
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							<div class="row">
	  								
	  								<div class="booking-column-2">
	  									<label>Zip</label>
	  									<input type="text" name="add_zip" id="add_zip" value="" />
	  								</div>
									<div class="booking-column-2">
	  									<label>City</label>
	  									<input type="text" name="add_city" id="add_city" value="" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Mobile</label>
	  									<input type="text" name="add_mobile" id="add_mobile" value="" />
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Email</label>
	  									<input type="text" name="add_email" id="add_email" value="" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							<div class="row">
	  								<div class="booking-column-1">
	  									<label>Comment</label>
	  									<textarea name="add_comment" id="add_comment" rows="3"></textarea>
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  						</div>
  						
  						<div class="booking-column-2 right-vline">
  							<div class="row">
  								<div class="booking-column-2">
  									<label>Staff</label>
	  									<select name="add_staff" id="add_staff" multiple style="height:70px;">
	  										
	  										<?php
	  											foreach ($staffArr as $value) {
	  												echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
	  											}
	  										?>
	  									</select>
  								</div>
  								<div class="booking-column-2">
  									<label>Date</label>
  									<input type="text" name="add_date" id="add_date" class="caledar" style="text-align: center;" value="<?=$_POST['default_date']?>" />
  								</div>
  								<div class="clear"></div>
  							</div>
  						
  							
  							<div class="row">
  								<div class="booking-column-2">
  									<label>Start Hour</label>
  									<select name="add_start_hour" id="add_start_hour">
  										<?php
	  											foreach ($workHourArr as $value) {
	  													echo '<option value="'.$value['id'].'">'.str_pad( $value['start_hour'], 2, "0", STR_PAD_LEFT).':'.str_pad( $value['start_minute'], 2, "0", STR_PAD_LEFT).'</option>';
	  												}
	  										?>
  									</select>
  								</div>
  								<div class="booking-column-2">
  									<label>End Hour</label>
  									<select name="add_end_hour" id="add_end_hour">
  										<?php
	  											foreach ($workHourArr as $value) {
	  													echo '<option value="'.$value['id'].'">'.str_pad($value['start_hour'], 2, "0", STR_PAD_LEFT).':'.str_pad( $value['start_minute'], 2, "0", STR_PAD_LEFT).'</option>';
	  												}
	  										?>
  									</select>
  								</div>
  								<div class="clear"></div>
  							</div>
  							
								
				<div class="row">
					<div class="booking-column-2">
  						<label>Size</label>
  						<input type="text" name="add_size" onkeyup="updatePriceValue( );" id="add_size" value="" />
  					</div>	
					<div class="booking-column-2">
  						<label>Windows</label>
  						<input type="text" name="add_windows" onkeyup="updatePriceValue( );" id="add_windows" value="" />
  					</div>	
					<div class="clear"></div>
				</div>				
				<div class="row" id="priceRowList"  style="padding-top:20px !important;">
				</div>				
				<div class="row">
					<div class="booking-column-2">
  						<label>Total</label>
  						<input type="text" name="add_total" id="add_total" value="" />
  					</div>	
					<div class="booking-column-2">
  						<label>Special Offer</label>
  						<input type="text" name="add_special_offer"  id="add_special_offer" value="" />
  					</div>	
					<div class="clear"></div>
				</div>	
				<div class="row" id="priceRowList"  style="padding-top:20px !important;">
				</div>	
				<div class="row">
					<div class="booking-column-2">
  					<label><Input type="checkbox" value="1" id="sendUserEmail" name="sendUserEmail" CHECKED /> Send user email</label>
					</div>
				</div>
  				<!--		
				
				<div class="row">
	  								<div class="booking-column-1">
	  									<label>Service</label>
	  									<?php
	  									/**	foreach($serviceArr as $value) {
	  											echo '<input type="radio" name="add_service"  value="'.$value['id'].'" /> '.$value['name'].'<br/>';
	  										}*/
	  									?>
	  								</div>
	  								<div class="clear"></div>
	  							</div>
				<div class="row">
  								<div class="booking-column-2">
  									<label>Size</label>
  									<input type="text" name="add_size" onkeyup="updateSizePrice(this.value );" id="add_size" value="" />
  								</div>
  								<div class="booking-column-2">
  									<label>Windows</label>
  									<input type="text" name="add_windows" onkeyup="updateWindowsPrice(this.value);" id="add_windows" value="" />
  								</div>
  								<div class="clear"></div>
  							</div>
  							<div class="row">
  								<div class="booking-column-2">
  									<label>Price Size</label>
  									<input type="text" name="add_price_size" id="add_price_size" value="" />
  								</div>
  								<div class="booking-column-2">
  									<label>Price Windows</label>
  									<input type="text" name="add_price_windows" id="add_price_windows" value="" />
  								</div>
  								<div class="clear"></div>
  							</div>
  							
					-->		
							
							
							
							
  						</div>
  						<div class="clear"></div>
  						<div class="tool-bar">
  							<button class="btn b-save" type="button" onclick="return addBook();" >Save</button>
  							<button class="btn b-cancel" type="button"  onclick="$('#book-add-form').html('').hide();">Cancel</button>  							
  						</div>
  						<div class="clear"></div>
  					</div>
  					