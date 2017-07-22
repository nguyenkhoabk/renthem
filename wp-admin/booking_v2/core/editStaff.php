<?php
	include("../core.php");
	
	$id = $_POST['id'];
	
	$arr = $staff->getStaff("*"," id = '".$id."' ","")
?>
<input type="hidden" name="ed_staff_id" id="ed_staff_id" value="<?=$arr[0]['id']?>" />
<a href="javascript:;" onclick="cancelStaffEdit();" class="close">x</a>
  					<h1>Edit Staff</h1>
  					<div class="booking-add-box">
	  						<div class="booking-column-2">
	  							
	  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Name</label>
	  									<input type="text" id="ed_staff_name" name="staff_name" value="<?=$arr[0]['name']?>" />
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Phone</label>
	  									<input type="text" value="<?=$arr[0]['phone']?>"  id="ed_staff_phone" name="staff_phone" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
	  							
	  						</div>
  						
  						<div class="booking-column-2 right-vline">
  							
  							<div class="row">
	  								<div class="booking-column-1">
	  									<label>Email</label>
	  									<input type="text" value="<?=$arr[0]['email']?>" id="ed_staff_email"  name="staff_email" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
  						</div>
  						<div class="clear"></div>
  						<div class="tool-bar">
  							<button class="btn b-save" onclick="updateStaff();">Save</button>
  							<button class="btn b-cancel" onclick="cancelStaffEdit();">Cancel</button>  							
  						</div>
  						<div class="clear"></div>
  					</div>
  					
  					