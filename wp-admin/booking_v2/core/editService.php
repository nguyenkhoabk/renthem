<?php
	include("../core.php");
	
	$id = $_POST['id'];
	
	$arr = $service->getService("*"," id = '".$id."' ","")
?>
<input type="hidden" name="ed_service_id" id="ed_service_id" value="<?=$arr[0]['id']?>" />
<a href="javascript:;" onclick="cancelServiceEdit();" class="close">x</a>
  					<h1>Edit Service</h1>
  					<div class="booking-add-box">
	  						
  							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Name</label>
	  									<input type="text" value="<?=$arr[0]['name']?>" id="ed_service_name"  name="ed_service_name" />
	  								</div>
	  								<div class="booking-column-2">
	  									<label>Background</label>
	  									<input type="text"  id="ed_background" name="ed_background" value="<?=$arr[0]['background']?>" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>
											<div class="row">
	  								<div class="booking-column-2">
	  									<label>Display on</label>
	  									<select id="ed_show_on"  name="ed_show_on" >
											<option value="0" <?php if ($arr[0]['show_on'] == "0" ) { echo 'SELECTED'; } ?> >Admin</option>
											<option value="1" <?php if ($arr[0]['show_on'] == "1" ) { echo 'SELECTED'; } ?> >Front end</option>											
											<option value="2" <?php if ($arr[0]['show_on'] == "2" ) { echo 'SELECTED'; } ?> >Front end + Admin</option>
										</select>
	  								</div>
									<div class="booking-column-2">
	  									<label>Type</label>
	  									<select name="ed_service_type" id="ed_service_type">
											<option value="1" <?php if ($arr[0]['type'] == "2" ) { echo 'SELECTED'; } ?>>kvm</option>
											<option value="2" <?php if ($arr[0]['type'] == "2" ) { echo 'SELECTED'; } ?>>windows</option>
										</select>
	  								</div>
	  								<div class="clear"></div>
	  							</div>
							<div class="row">
	  								<div class="booking-column-2">
	  									<label>Position</label>
	  									<input type="text" value="<?=$arr[0]['position']?>" id="ed_service_position"  name="ed_service_position" />
	  								</div>
									<div class="booking-column-2">
	  									<label>URL</label>
	  									<input type="text" value="<?=$arr[0]['url']?>" id="ed_service_url"  name="ed_service_url" />
	  								</div>
	  								<div class="clear"></div>
	  							</div>	
						
  						
  						<div class="clear"></div>
  						<div class="tool-bar">
  							<button class="btn b-save" onclick="updateService();">Save</button>
  							<button class="btn b-cancel" onclick="cancelServiceEdit();">Cancel</button>  							
  						</div>
  						<div class="clear"></div>
  					</div>