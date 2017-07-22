<?php
	include("../core.php");
	$id = $_POST['id'];
	
	$arr = $service->getServicePrice("*"," id = '".$id."' ","");

?>

	<a href="javascript:;" onclick="cancelPriceEdit();" class="close">x</a>
  					<h1>Edit Price</h1>
  					<div class="booking-add-box">
	  						<div class="booking-column-2">
	  							<input type="hidden" name="edit_price_id" value="<?=$arr[0]['id']?>" id="edit_price_id" />
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Service</label>
	  									<select name="edit_price_service" id="edit_price_service">
											<?php
												foreach ($serviceArr as $value) {
												if ($arr[0]['service_id'] == $value['id']) {
													echo '<option value="'.$value['id'].'" SELECTED >'.$value['name'].'</option>';
												} else {
													echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
												}
													
												}
											?>
										</select>
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Amount</label>
	  									<input type="text" value="<?=$arr[0]['amount']?>"  id="edit_price_amount" name="edit_price_amount" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  								<div class="row">
	  								<div class="booking-column-1">
	  									<label>Frequency</label>
	  									<select name="edit_price_frequency" id="edit_price_frequency">
											<option value=""> - select - </option>
											<option value="0" <?php if ($arr[0]['frequency'] == 0) { echo 'SELECTED'; } ?>>one time</option>
											<option value="1" <?php if ($arr[0]['frequency'] == 1) { echo 'SELECTED'; } ?>>one time a month</option>
											<option value="2" <?php if ($arr[0]['frequency'] == 2) { echo 'SELECTED'; } ?>>every second week</option>
											<option value="4" <?php if ($arr[0]['frequency'] == 4) { echo 'SELECTED'; } ?>>ever week</option>
										</select>
	  								</div>
	  								
	  								<div class="clear"></div>
	  							</div>
	  							
	  						</div>
  						
  						<div class="booking-column-2 right-vline">
  							
  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Minimum Value</label>
	  									<input type="text" value="<?=$arr[0]['start_value']?>"  id="edit_price_min_value" name="edit_price_min_value" />
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Maximum Value</label>
	  									<input type="text" value="<?=$arr[0]['end_value']?>"  id="edit_price_max_value" name="edit_price_max_value" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
  						</div>
  						<div class="clear"></div>
  						<div class="tool-bar">
  							<button class="btn b-save" onclick="updatePrice();">Update</button>
  							<button class="btn b-cancel" onclick="cancelPriceEdit();">Cancel</button>  							
  						</div>
  						<div class="clear"></div>
  					</div>