<?php
	include("../core.php");
	$book_id = $_POST['id'];
	
	$bookPending = $book->getPendingBook(" * "," id = '".$book_id."'");
	$first_name = $bookPending[0]['first_name'];
	$last_name = $bookPending[0]['last_name'];
	$street = $bookPending[0]['street'];
	$zip = $bookPending[0]['zip'];
	$city = $bookPending[0]['city'];
	$mobile = $bookPending[0]['mobile'];
	$email = $bookPending[0]['email'];
	$data = $bookPending[0]['data'];
	$frequency = $bookPending[0]['clean_service_frequency'];
	
	$window = $bookPending[0]['window_no'];
	
	$service_id = $bookPending[0]['clean_service_id'];
	$service_window_id = $bookPending[0]['window_service_id'];
	
	$bookComment = $book->getBookComment("*", " book_id = 'pen-".$book_id."' ", array("id" => "DESC"));

$comment = $bookComment[0]['comment'];	
	
	$size = $bookPending[0]['size'];
	$hour = $bookPending[0]['hour'];
	$time = "";
	
	$start_time_select =0 ;
	$end_time_select =0 ;
	switch ($hour) {
		case '8-12':
			$time = "Förmiddag 8:00-12:00 ";
			$start_time_select =1 ;
			$end_time_select =9 ;
	
		break;
		case '13-17':
			$time = "Eftermiddag 13:00-17:00 ";
				$start_time_select =11 ;
			$end_time_select =19 ;
		break;
	}
///	print_r($bookPending);
?>
<a href="javascript:;" onclick="$('#book-add-form').html('').hide();" class="close">x</a>
  					<h1>Pending Booking</h1>
  					<div class="booking-add-box">
	  						<div class="booking-column-2">
	  		<form action="" method="post" id="add_book_frm">	
<input type="hidden" name="pending_book_id" id="pending_book_id" value="<?=$book_id?>" />			
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>First Name</label>
	  									<input type="text" name="add_first_name" id="add_first_name" value="<?=$first_name?>" />
	  								</div>
	  								<div class="booking-column-2">
										<label>Last Name</label>
	  									<input type="text" name="add_last_name" id="add_last_name" value="<?=$last_name?>" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
								<div class="row">
	  								<div class="booking-column-1">
	  									<label>Address</label>
	  									<textarea name="add_address" id="add_address" rows="2"><?=$street?></textarea>
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							<div class="row">
	  								<div class="booking-column-2">
										<label>Zip</label>
	  									<input type="text" name="add_zip" id="add_zip" value="<?=$zip?>" />
	  									
	  								</div>
	  								<div class="booking-column-2">
	  									<label>City</label>
	  									<input type="text" name="add_city" id="add_city" value="<?=$city?>" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Mobile</label>
	  									<input type="text" name="add_mobile" id="add_mobile" value="<?=$mobile?>" />
	  								</div>
	  								<div class="booking-column-2">
	  										<label>Email</label>
	  									<input type="text" name="add_email" id="add_email" value="<?=$email?>" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							<div class="row">
	  								<div class="booking-column-1">
	  									<label>Comment</label>
	  									<textarea name="add_comment" id="add_comment" rows="3"><?=$comment?></textarea>
	  								</div>
	  								<div class="clear"></div>
	  							</div>
								<div class="row">
	  								<div class="booking-column-1">
	  									<label>Available time</label>
	  									<input type="text" name="" id="" value="<?=$time?>" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  						</div>
  						
  						<div class="booking-column-2 right-vline">
  							<div class="row">
  								<div class="booking-column-2">
  									<label>Staff</label>
	  									<select name="add_staff" id="add_staff"  multiple style="height:70px;">
	  										<?php
	  											foreach ($staffArr as $value) {
	  												echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
	  											}
	  										?>
	  									</select>
  								</div>
  								<div class="booking-column-2">
  									<label>Date</label>
  									<input type="text" name="add_date" id="add_date" class="caledar" style="text-align: center;" value="<?=$data?>" />
  								</div>
  								<div class="clear"></div>
  							</div>
  							
  							
  							<div class="row">
  								<div class="booking-column-2">
  									<label>Start Hour</label>
  									<select name="add_start_hour" id="add_start_hour">
  										<?php
	  											foreach ($workHourArr as $value) {
													if ($start_time_select == $value['id']) {
															echo '<option value="'.$value['id'].'" SELECTED >'.str_pad( $value['start_hour'], 2, "0", STR_PAD_LEFT).':'.str_pad( $value['start_minute'], 2, "0", STR_PAD_LEFT).'</option>';
													} else {
															echo '<option value="'.$value['id'].'">'.str_pad( $value['start_hour'], 2, "0", STR_PAD_LEFT).':'.str_pad( $value['start_minute'], 2, "0", STR_PAD_LEFT).'</option>';
													}
	  												
	  												}
	  										?>
  									</select>
  								</div>
  								<div class="booking-column-2">
  									<label>End Hour</label>
  									<select name="add_end_hour" id="add_end_hour">
  										<?php
	  											foreach ($workHourArr as $value) {
													if ($end_time_select == $value['id'] ) {
															echo '<option value="'.$value['id'].'" SELECTED >'.str_pad($value['start_hour'], 2, "0", STR_PAD_LEFT).':'.str_pad( $value['start_minute'], 2, "0", STR_PAD_LEFT).'</option>';
													} else {
															echo '<option value="'.$value['id'].'">'.str_pad($value['start_hour'], 2, "0", STR_PAD_LEFT).':'.str_pad( $value['start_minute'], 2, "0", STR_PAD_LEFT).'</option>';
													}
	  												
	  												}
	  										?>
  									</select>
  								</div>
  								<div class="clear"></div>
  							</div>
  						
						
						
						
						<div class="row">
							<div class="booking-column-2">
								<label>Size</label>
								<input type="text" name="add_size" onkeyup="updatePriceValue( );" id="add_size" value="<?=$size?>" />
							</div>	
							<div class="booking-column-2">
								<label>Windows</label>
								<input type="text" name="add_windows" onkeyup="updatePriceValue( );" id="add_windows" value="<?=$window?>" />
							</div>	
							<div class="clear"></div>
						</div>				
						<div class="row" id="priceRowList"  style="padding-top:20px !important;">
						
		<!--- update price id -->				
<?php						
	$serviceFront = $service->getService("*", "",  array('position'=> 'ASC'));
echo '<table width="100%">';
	foreach($serviceFront as $value) {
		//freq 0
		$service_id_aux = $value['id'];
		
		if ($value['type'] == 2) {
		$amount = 0; 
		if ($service_window_id != 0) {
				$servicePrice = $service->getServicePrice("*", "(".$window." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id_aux."')  AND (frequency = 0)", "" );
				$amount = $servicePrice[0]['amount'];
		} else {
			$servicePrice = $service->getServicePrice("*", " ( service_id = '".$service_id_aux."')  AND (frequency = 0)", "" );
		}
		if (count($servicePrice) != 0) {
?>
	<tr>
		<td>Fönsterputsning</td>
	
		<td id="window_price_<?=$service_id_aux?>"><span id="window_price"><?=(int)$amount?></span> <span>Kr</span> </td>
		<td><input type="checkbox" value="<?=$service_id_aux?>" <?php if ($service_window_id != 0) { echo 'CHECKED' ;} ?>		 name="window_service" id="window_id_0_<?=$service_id_aux?>" class="regular-checkbox big-checkbox" /></td>
	</tr>


<?php
			}
		} else {



	//freq 1
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id_aux."')  AND (frequency = 1)", "" );
		if (count($servicePrice) == 1) {
?>
	<tr>
		<td><?=$value['name']?> <?php if ($service_id_aux == 1) { echo 'en gång i månaden';}?> </td>
		
		<td><span id="clean_price_1_<?=$service_id_aux?>"><?=(int)$servicePrice[0]['amount'] *1 ?></span> <span>Kr</span> </td>
		<td> <input type="checkbox" value="1::<?=$service_id_aux?>" onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_1_<?=$service_id_aux?>"  <?php if ( ($service_id == $service_id_aux) && ($frequency == '1')) { echo 'CHECKED'; }?> class="regular-checkbox big-checkbox" /></td>
	</tr>

<?php
}
		//freq 2
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id_aux."')  AND (frequency = 2)", "" );
		if (count($servicePrice) == 1) {
?>
	<tr>
		<td><?=$value['name']?> <?php if ($service_id_aux == 1) { echo 'varannan vecka';}?></td>
		
		<td><span id="clean_price_2_<?=$service_id_aux?>"><?=(int)$servicePrice[0]['amount']*2?></span> <span>Kr</span> </td>
		<td><input type="checkbox"  value="2::<?=$service_id_aux?>"  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_2_<?=$service_id_aux?>"  <?php if ( ($service_id == $service_id_aux) && ($frequency == '2')) { echo 'CHECKED'; }?> class="regular-checkbox big-checkbox" /></td>
	</tr>
		

<?php
}
		//freq 4
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id_aux."')  AND (frequency = 4)", "" );
		if (count($servicePrice) == 1) {
?>
	<tr>	
		<td><?=$value['name']?> <?php if ($service_id_aux == 1) { echo 'varje vecka';}?></td>
		
		<td><span id="clean_price_4_<?=$service_id_aux?>"><?=(int)$servicePrice[0]['amount']*4?></span> <span>Kr</span></td>
		<td><input type="checkbox" value="4::<?=$service_id_aux?>" onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_4_<?=$service_id_aux?>"  <?php if ( ($service_id == $service_id_aux) && ($frequency == '4')) { echo 'CHECKED'; }?> class="regular-checkbox big-checkbox" /></td>
	</tr>
	
<?php
}


		$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id_aux."')  AND (frequency = 0)", "" );
		if (count($servicePrice) == 1) {
?>
	<tr>
		<td><?=$value['name']?></td>
		
		<td><span id="clean_price_0_<?=$service_id_aux?>"><?=(int)$servicePrice[0]['amount']?></span> <span>Kr</span> </td>
		<td><input type="checkbox"  value="0::<?=$service_id_aux?>"  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_0_<?=$service_id_aux?>"  <?php if ( ($service_id == $service_id_aux) && ($frequency == '0')) { echo 'CHECKED'; }?> class="regular-checkbox big-checkbox" /></td>
	</tr>
	
	
<?php
}
	


		} // if type
	}
?>
</table>					
						
						
		<!--- update price id -->					
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
						
						
						<div class="row">
					<div class="booking-column-2">
  					<label><Input type="checkbox" value="1" id="sendUserEmail" name="sendUserEmail" CHECKED /> Send user email</label>
					</div>
				</div>
						
						
						
						
  							
  						</div>
  						<div class="clear"></div>
  						<div class="tool-bar">
  							<button class="btn b-save" type="button" onclick="addBook();" >Save</button>
  							<button class="btn b-cancel" type="button"  onclick="$('#book-add-form').html('').hide();">Cancel</button>  							
  						</div>
  						<div class="clear"></div>
  					</div>
  					