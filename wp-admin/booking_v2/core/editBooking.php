<?php
	include("../core.php");
	
	$default_date = $_POST['default_date'];
	$book_id = $_POST['book_id'];
	
	// book details 
	
	
	$bookDetailsVec = $book->getBookDetails(" * "," id = '".$book_id."'");
	
	$book_id = $bookDetailsVec[0]['id'];
	$service_id = $bookDetailsVec[0]['service_id'];
	$service_window_id = $bookDetailsVec[0]['service_window_id'];
	$frequency = $bookDetailsVec[0]['frequency'];
	$size = $bookDetailsVec[0]['size'];

	$window = $bookDetailsVec[0]['window'];
	$time = $bookDetailsVec[0]['time'];
	$date = $bookDetailsVec[0]['date'];
	$price_size = $bookDetailsVec[0]['price_size'];
	$price_windows = $bookDetailsVec[0]['price_windows'];
	
	$total = $bookDetailsVec[0]['total'];
	$special_offer = $bookDetailsVec[0]['special_offer'];
	
	// get book
	$bookVec = $book->getBook(" * "," book_id = '".$book_id."'", array(" time_id " => " ASC "));
	
	$client_id = "";
	$staff_id = "";
	
	$start_time = 9999 ;
	$end_time = 0;
	
	$no = count($bookVec);
	
	$staff_vec = array();
	for ($i=0; $i < $no; $i++) {
		$client_id = $bookVec[$i]['client_id'];
		$staff_id = $bookVec[$i]['staff_id'];

	if (!in_array($bookVec[$i]['staff_id'],$staff_vec)) {
			$staff_vec[] = $bookVec[$i]['staff_id'];
		} else {
		//$staff_vec[] = $bookVec[$i]['staff_id'];
		}
		
		if ($start_time > $bookVec[$i]['time_id']) {
			$start_time = $bookVec[$i]['time_id'];
		}
		if ($end_time < $bookVec[$i]['time_id']) {
			$end_time = $bookVec[$i]['time_id'];
		}
	}
	

	$end_time++;

	$clientVec = $client->getClient(" * ", " id = '".$client_id."' ");
	$first_name = $clientVec[0]['first_name'];
	$last_name = $clientVec[0]['last_name'];
	$address = $clientVec[0]['address'];
	$zipcode = $clientVec[0]['zipcode'];
	$city = $clientVec[0]['city'];
	$phone = $clientVec[0]['phone'];
	$email = $clientVec[0]['email'];
	
	$bookCommentVec = $book->getBookComment(" * ", " book_id = '".$book_id."' ");
	$comment = "";
	if (count($bookCommentVec) == 1) {
		$comment = $bookCommentVec[0]['comment'];
	}

?>

<a href="javascript:;" onclick="$('#book-add-form').html('').hide();" class="close">x</a>
  					<h1>Edit Booking</h1>
  					<div class="booking-add-box">
	  						<div class="booking-column-2">
	  		<form action="" method="post" id="edit_book_frm">	 		
	  			<input type="hidden" name="edit_book_id" id="edit_book_id" value="<?=$book_id?>" />
				<input type="hidden" name="edit_client_id" id="edit_client_id" value="<?=$client_id?>" />
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>First Name</label>
	  									<input type="text" name="edit_first_name" id="edit_first_name" value="<?=$first_name?>" />
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Last Name</label>
	  									<input type="text" name="edit_last_name" id="edit_last_name" value="<?=$last_name?>" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
								<div class="row">
	  								<div class="booking-column-1">
	  									<label>Address</label>
	  									<textarea name="edit_address" id="edit_address" rows="2"><?=$address?></textarea>
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							<div class="row">
	  								
	  								<div class="booking-column-2">
	  									<label>Zip</label>
	  									<input type="text" name="edit_zip" id="edit_zip" value="<?=$zipcode?>" />
	  								</div>
									<div class="booking-column-2">
	  									<label>City</label>
	  									<input type="text" name="edit_city" id="edit_city" value="<?=$city?>" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Mobile</label>
	  									<input type="text" name="edit_mobile" id="edit_mobile" value="<?=$phone?>" />
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Email</label>
	  									<input type="text" name="edit_email" id="edit_email" value="<?=$email?>" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							<div class="row">
	  								<div class="booking-column-1">
	  									<label>Comment</label>
	  									<textarea name="edit_comment" id="edit_comment" rows="3"><?=$comment?></textarea>
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  						</div>
  						
  						<div class="booking-column-2 right-vline">
  							<div class="row">
  								<div class="booking-column-2">
  									<label>Staff</label>
	  									<select name="edit_staff" id="edit_staff"  multiple="multiple" style="height:70px;">
	  										<?php
	  											foreach ($staffArr as $value) {
												if (in_array($value['id'], $staff_vec)){
														echo '<option value="'.$value['id'].'" SELECTED>'.$value['name'].'</option>';
													} else {
														echo '<option value="'.$value['id'].'"  >'.$value['name'].'</option>';
													}	  											
	  											}
	  										?>
	  									</select>
  								</div>
  								<div class="booking-column-2">
  									<label>Date</label>
  									<input type="text" name="edit_date" id="edit_date" class="caledar" style="text-align: center;" value="<?=$date?>" />
  								</div>
  								<div class="clear"></div>
  							</div>
  				
  							
  							<div class="row">
  								<div class="booking-column-2">
  									<label>Start Hour</label>
  									<select name="edit_start_hour" id="edit_start_hour">
  										<?php
	  											foreach ($workHourArr as $value) {
													if ($value['id'] == $start_time) {
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
  									<select name="edit_end_hour" id="edit_end_hour">
  										<?php
	  											foreach ($workHourArr as $value) {
														if ($end_time == $value['id']) {
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
								<input type="text" name="edit_size" onkeyup="updatePriceValueEdit( );" id="edit_size" value="<?=$size?>" />
							</div>	
							<div class="booking-column-2">
								<label>Windows</label>
								<input type="text" name="edit_windows" onkeyup="updatePriceValueEdit( );" id="edit_windows" value="<?=$window?>" />
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
  						<input type="text" name="add_total" id="add_total" value="<?=$total?>" />
  					</div>	
					<div class="booking-column-2">
  						<label>Special Offer</label>
  						<input type="text" name="add_special_offer"  id="add_special_offer" value="<?=$special_offer?>" />
  					</div>	
					<div class="clear"></div>
				</div>		
							
							
							
  							
  						</div>
						
  						<div class="clear"></div>
						<div class="" style="width:100%; border-top:1px solid #E5E9EC;" id="extra-info">

						</div>
  						<div class="clear"></div>
  						<div class="tool-bar">
							<button class="btn b-cleaning-dates left" type="button" onclick="cleaningDates('<?=$book_id?>');" >Cleaning dates</button>
							<button class="btn b-copy-booking left" type="button" onclick="copyBooking('<?=$book_id?>');" >Copy booking</button>
						
						
  							<button class="btn b-save" type="button" onclick="updateBook();" >Update</button>
							
  							<button class="btn b-cancel" type="button"  onclick="$('#book-add-form').html('').hide();">Cancel</button>

							<button class="btn b-delete" type="button"  onclick="deleteBookEdit('<?=$book_id?>','<?=$date?>')">Delete</button>

							<button class="btn b-delete" type="button"  onclick="deleteBookEditOnCurrentDay('<?=$book_id?>','<?=$default_date?>')">Delete Current Day</button>
  							<input type="hidden" name="current_date" value="<?php echo $default_date; ?>">
  						</div>
  						<div class="clear"></div>
  					</div>
  				