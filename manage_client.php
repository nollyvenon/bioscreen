<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	
	if(partial_access('admin') || $store_access->have_module_access('clients')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	
	//updating user level
	if(isset($_POST['update_client'])) { 
		extract($_POST);
		$message = $client->update_client($edit_client, $full_name, $business_title, $mobile, $phone, $address, $city, $state, $zipcode, $country, $email, $price_level, $notes);
	}//update ends here.
	
	//setting level data if updating or editing.
	if(isset($_POST['edit_client'])) {
		$client->set_client($_POST['edit_client']);	
	} //level set ends here
	
	if(isset($_POST['add_client'])) {
		$add_client = $_POST['add_client'];
		if($add_client == '1') { 
			extract($_POST);
			$message = $client->add_client($full_name, $business_title, $mobile, $phone, $age, $sex, $blood_group, $birth_date, $HMO_name, $address, $city, $state, $zipcode, $country, $email, $price_level, $notes);
		}
	}//isset add level
	
	if(isset($_POST['edit_client'])){ $page_title = 'Edit Patient'; } else { $page_title = 'Add Patient';}; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.

	//display message if exist.
		if(isset($message) && $message != '') { 
			echo '<div class="alert alert-success">';
			echo $message;
			echo '</div>';
		}
?>
                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_client" name="level" method="post">
                    <div class="form-group">
                        	<label class="control-label">Full Name*</label>
                            <input type="text" class="form-control" name="full_name" placeholder="Patient full name" value="<?php echo $client->full_name; ?>" required="required" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Title</label>
                            <input type="text" class="form-control" name="business_title" placeholder="Business Title" value="<?php echo $client->business_title; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile number" value="<?php echo $client->mobile; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone number" value="<?php echo $client->phone; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $client->address; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $client->city; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State" value="<?php echo $client->state; ?>" />
                      </div>
                <!--      <div class="form-group">
                        	<label class="control-label">Zipcode</label>
                            <input type="text" class="form-control" name="zipcode" placeholder="Zip Code" value="<?php echo $client->zipcode; ?>" />
                      </div>-->
                      <div class="form-group">
                        	<label class="control-label">Sex</label>
                            <input type="text" class="form-control" name="sex" placeholder="Sex" value="<?php echo $client->sex; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Age</label>
                            <input type="text" class="form-control" name="age" placeholder="Age" value="<?php echo $client->age; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Blood Group</label>
                            <input type="text" class="form-control" name="blood_group" placeholder="Blood Group" value="<?php echo $client->blood_group; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">HMO Name</label>
                            <input type="text" name="hmo_name" class="form-control" value="" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Birth Date</label>
                            <input type="text" name="birth_date" class="form-control datepick" value="<?php echo date('Y-m-d'); ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country" value="<?php echo $client->country; ?>" />
                      </div>
				     <div class="form-group">
                        	<label class="control-label">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $client->email; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Price Level</label>
                            <select name="price_level" class="form-control">
                            	<option <?php if($client->price_level == 'default_rate') echo 'selected="selected"'; ?> value="default_rate">Default</option>
                                <option <?php if($client->price_level == 'level_1') echo 'selected="selected"'; ?> value="level_1">Level 1</option>
                                <option <?php if($client->price_level == 'level_2') echo 'selected="selected"'; ?> value="level_2">Level 2</option>
                                <option <?php if($client->price_level == 'level_3') echo 'selected="selected"'; ?> value="level_3">Level 3</option>
                                <option <?php if($client->price_level == 'level_4') echo 'selected="selected"'; ?> value="level_4">Level 4</option>
                                <option <?php if($client->price_level == 'level_5') echo 'selected="selected"'; ?> value="level_5">Level 5</option>
                            </select>
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Notes</label>
                            <textarea class="form-control" name="notes"><?php echo $client->notes; ?></textarea>
                      </div>	
						<?php 
						if(isset($_POST['edit_client'])){ 
							echo '<input type="hidden" name="edit_client" value="'.$_POST['edit_client'].'" />';
							echo '<input type="hidden" name="update_client" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_client" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_client'])){ echo 'Update Patient'; } else { echo 'Add Patient';} ?>" />
                    </form>
                    <script>
						$(document).ready(function() {
							// validate the register form
							$("#add_category").validate();
						});
                    </script>
                    <script src="js/jquery-1.11.2.min.js"></script>
        			<script src="js/bootstrap-datepicker.js"></script>
                   </div><!--left-side-form ends here.-->
                   
<?php
	require_once("includes/footer.php");
?>