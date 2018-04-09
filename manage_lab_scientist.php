<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
		$labscientist = new LabScientist;
	
	if(partial_access('admin') || $store_access->have_module_access('lab_scientists')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	
	//updating user level
	if(isset($_POST['update_lab_scientist'])) { 
		extract($_POST);
		$message = $labscientist->update_lab_scientist($edit_lab_scientist, $laboratorist_manual_id, $laboratorist_name, $business_title, $phone, $address, $city, $state, $country, $email);
	}//update ends here.
	
	//setting level data if updating or editing.
	if(isset($_POST['edit_lab_scientist'])) {
		$labscientist->set_lab_scientist($_POST['edit_lab_scientist']);	
	} //level set ends here
	
	if(isset($_POST['add_lab_scientist'])) {
		$add_lab_scientist = $_POST['add_lab_scientist'];
		if($add_lab_scientist == '1') { 
			extract($_POST);
			$message = $labscientist->add_lab_scientist($laboratorist_manual_id, $laboratorist_name, $business_title, $phone, $address, $city, $state, $country, $email);
		}
	}//isset add level
	
	if(isset($_POST['edit_lab_scientist'])){ $page_title = 'Edit Lab Scientist'; } else { $page_title = 'Add Lab Scientist';}; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.

	//display message if exist.
		if(isset($message) && $message != '') { 
			echo '<div class="alert alert-success">';
			echo $message;
			echo '</div>';
		}
?>
                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_lab_scientist" name="level" method="post">
                    <div class="form-group">
                        	<label class="control-label">Manual ID*</label>
                            <input type="text" class="form-control" name="laboratorist_manual_id" placeholder="Lab Scientist ID" value="<?php echo $labscientist->laboratorist_manual_id; ?>" required="required" />
                      </div>
                    <div class="form-group">
                        	<label class="control-label">Full Name*</label>
                            <input type="text" class="form-control" name="laboratorist_name" placeholder="Lab Scientist full name" value="<?php echo $labscientist->laboratorist_name; ?>" required="required" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Title</label>
                            <input type="text" class="form-control" name="business_title" placeholder="Business Title" value="<?php echo $labscientist->business_title; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone number" value="<?php echo $labscientist->phone; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $labscientist->email; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $labscientist->address; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $labscientist->city; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State" value="<?php echo $labscientist->state; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country" value="<?php echo $labscientist->country; ?>" />
                      </div>
						<?php 
						if(isset($_POST['edit_lab_scientist'])){ 
							echo '<input type="hidden" name="edit_lab_scientist" value="'.$_POST['edit_lab_scientist'].'" />';
							echo '<input type="hidden" name="update_lab_scientist" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_lab_scientist" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_lab_scientist'])){ echo 'Update Lab Scientist'; } else { echo 'Add Lab Scientist';} ?>" />
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