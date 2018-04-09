<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	
	if(partial_access('admin') || $store_access->have_module_access('vendors')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	
	//updating user level
	if(isset($_POST['update_vendor'])) { 
		extract($_POST);
		$message = $vendor->update_vendor($edit_vendor, $full_name, $contact_person, $mobile, $phone, $address, $city, $state, $zipcode, $country, $provider_of);
	}//update ends here.
	
	//setting level data if updating or editing.
	if(isset($_POST['edit_vendor'])) {
		$vendor->set_vendor($_POST['edit_vendor']);	
	} //level set ends here
	
	if(isset($_POST['add_vendor'])) {
		$add_vendor = $_POST['add_vendor'];
		if($add_vendor == '1') { 
			extract($_POST);
			$message = $vendor->add_vendor($full_name, $contact_person, $mobile, $phone, $address, $city, $state, $zipcode, $country, $provider_of);
		}
	}//isset add level
	
	if(isset($_POST['edit_vendor'])){ $page_title = 'Edit Vendor'; } else { $page_title = 'Add Vendor';}; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.

	//display message if exist.
		if(isset($message) && $message != '') { 
			echo '<div class="alert alert-success">';
			echo $message;
			echo '</div>';
		}
?>
                    <div class="row">
                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_vendor" name="level" method="post">
                    <div class="form-group">
                        	<label class="control-label">Full Name*</label>
                            <input type="text" class="form-control" name="full_name" placeholder="Vendor full name" value="<?php echo $vendor->full_name; ?>" required="required" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Contact Person</label>
                            <input type="text" class="form-control" name="contact_person" placeholder="Contact Person" value="<?php echo $vendor->contact_person; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile number" value="<?php echo $vendor->mobile; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone number" value="<?php echo $vendor->phone; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $vendor->address; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $vendor->city; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State" value="<?php echo $vendor->state; ?>" />
                      </div>
                 <!--     <div class="form-group">
                        	<label class="control-label">Zipcode</label>
                            <input type="text" class="form-control" name="zipcode" placeholder="Zip Code" value="<?php echo $vendor->zipcode; ?>" />
                      </div>-->
                      <div class="form-group">
                        	<label class="control-label">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country" value="<?php echo $vendor->country; ?>" />
                      </div>
				     <div class="form-group">
                        	<label class="control-label">Provider of</label>
                            <input type="text" class="form-control" name="provider_of" placeholder="Provider Of" value="<?php echo $vendor->provider_of; ?>" />
                      </div>	
						<?php 
						if(isset($_POST['edit_vendor'])){ 
							echo '<input type="hidden" name="edit_vendor" value="'.$_POST['edit_vendor'].'" />';
							echo '<input type="hidden" name="update_vendor" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_vendor" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_vendor'])){ echo 'Update Vendor'; } else { echo 'Add Vendor';} ?>" />
                    </form>
                    <script>
						$(document).ready(function() {
							// validate the register form
							$("#add_category").validate();
						});
                    </script>
                   </div><!--left-side-form ends here.-->
                 </div><!--row ends here.-->  
<?php
	require_once("includes/footer.php");
?>