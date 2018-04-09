<?php
	include('system_load.php');
	//This loads system.
	
	//user Authentication.
	authenticate_user('admin');
	
	//User object.
	$new_user = new Users;
	//user level object
	$new_userlevel = new Userlevel;
	
	//Profile Image Processing.
	if(isset($_FILES['profile_image']) && $_FILES['profile_image'] != '') { 
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["profile_image"]["name"]);
		$extension = end($temp);
		
		if ((($_FILES["profile_image"]["type"] == "image/gif")
		|| ($_FILES["profile_image"]["type"] == "image/jpeg")
		|| ($_FILES["profile_image"]["type"] == "image/jpg")
		|| ($_FILES["profile_image"]["type"] == "image/pjpeg")
		|| ($_FILES["profile_image"]["type"] == "image/x-png")
		|| ($_FILES["profile_image"]["type"] == "image/png"))
		&& ($_FILES["profile_image"]["size"] < 2048000)
		&& in_array($extension, $allowedExts)) {
 			 if ($_FILES["profile_image"]["error"] > 0) {
    			$message = "Return Code: " . $_FILES["profile_image"]["error"];
    	} else 	{
			$phrase = substr(md5(uniqid(rand(), true)), 16, 16);
	  if (file_exists("upload/" .$phrase.$_FILES["profile_image"]["name"])) {
	      $message = $_FILES["profile_image"]["name"] . " already exists. ";
      } else {
		  move_uploaded_file($_FILES["profile_image"]["tmp_name"],
		  "upload/".$phrase.str_replace(' ', '-',$_FILES["profile_image"]["name"]));
		  $profile_image = "upload/".$phrase.str_replace(' ', '-', $_FILES["profile_image"]["name"]);
	  } //if file not exist already.
	  
    } //if file have no error
  }//if file type is alright.
} //if image was uploaded processing.
/*Image processing ends here.*/

//User update submission image processing edit user password setting if not changed.
if(isset($_POST['edit_user']) && $_POST['edit_user'] != '') { 
	if(isset($profile_image)) { 
		$profile_image = $profile_image;
	} else { 
		if(isset($_POST['already_img'])) { 
			$profile_image = $_POST['already_img'];
		} else { 
			$profile_image = '';
		}
	}
	if(isset($_POST['password']) && $_POST['password'] != '') { 
		if($_POST['password'] == $_POST['confirm_password']) { 
			$password_set = $_POST['password'];
		} else { 
			$message = "Password does not match.";
		}
	} else { 
		$password_set = '';
	}
	if(isset($_POST['update_user']) && $_POST['update_user'] == '1') {
	extract($_POST);
	if($password != $confirm_password){ 
		$message = 'Password does not match!';
	} else {
	$message = $new_user->update_user($_POST['edit_user'], $_SESSION['user_type'], $first_name, $last_name, $gender, $date_of_birth, $address1, $address2, $city, $state, $country, $zip_code, $mobile, $phone, $username, $email, $password_set, $profile_image, $description, $status, $user_type);
		}
	}
}//update user submission.
	
	if(isset($_POST['edit_user']) && $_POST['edit_user'] != '') { 
		$new_user->set_user($_POST['edit_user'], $_SESSION['user_type'], $_SESSION['user_id']);
	}//setting user data if editing. 	
	
	//add user processing.
	if(isset($_POST['add_user']) && $_POST['add_user'] == '1') { 
		extract($_POST);
		if($first_name == '') { 
			$message = 'First name is required!';
		} else if($username == '') { 
			$message = 'Username is required!';
		} else if($email == '') { 
			$message = 'Email is required!';
		} else if($password == ''){ 
			$message = 'Password Cannot be empty!';
		} else if($password != $confirm_password){ 
			$message = 'Password does not match!';
		} else if($status == '0') { 
			$message = 'Please select user status.';
		} else if($user_type == '0') { 
			$message = 'Please select user type.';
		}  else {
		$message = $new_user->add_user($first_name, $last_name, $gender, $date_of_birth, $address1, $address2, $city, $state, $country, $zip_code, $mobile, $phone, $username, $email, $password, $profile_image, $description, $status, $user_type);
		}
	}//add user processing ends here.
	
	if(isset($_POST['edit_user'])){ $page_title = 'Edit user'; } else { $page_title = 'Add New User';} //page title set.
	require_once("includes/header.php"); //including header file.
	?>
                	<?php
					//display message if exist.
						if(isset($message) && $message != '') { 
							echo '<div class="alert alert-success">';
							echo $message;
							echo '</div>';
						}
					?>
                    <div class="col-sm-8">
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_user" name="user" method="post" enctype="multipart/form-data" role="form">
                     <div class="form-group">
                     <label class="control-label">First Name*</label>
                     <input type="text" class="form-control" name="first_name" placeholder="Enter first name" value="<?php echo $new_user->first_name; ?>" required="required" />
                     </div>
                        
                       <div class="form-group">
                     	<label class="control-label">Last Name*</label>
                        <input class="form-control" type="text" name="last_name" placeholder="Enter last name" value="<?php echo $new_user->last_name; ?>" required="required" />
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Gender</label>
                            <select class="form-control" name="gender">
                            	<option vale=''>Select Gender</option>
                                <option value="Male" <?php if($new_user->gender == 'Male') { echo 'selected="selected"'; } ?>>Male</option>
                                <option value="Female" <?php if($new_user->gender == 'Female') { echo 'selected="selected"'; } ?>>Female</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Date of birth</label>
                            <input type="text" class="form-control datepick" readonly="readonly" name="date_of_birth" placeholder="Date of birth Format 2013-12-03" value="<?php echo $new_user->date_of_birth; ?>" />
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Address 1</label>
                            <textarea name="address1" class="form-control" placeholder="Address line 1"><?php echo $new_user->address1; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Address 2</label>
                            <textarea name="address2" class="form-control" placeholder="Address line 2"><?php echo $new_user->address2; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">City</label>
                            <input type="text" name="city" class="form-control" placeholder="City" value="<?php echo $new_user->city; ?>" />
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">State/Province</label>
                            <input type="text" name="state" class="form-control" placeholder="State or Province" value="<?php echo $new_user->state; ?>" />
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Your Country" value="<?php echo $new_user->country; ?>" />
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Zip code</label>
                            <input type="text" class="form-control" name="zip_code" placeholder="Your zip code" value="<?php echo $new_user->zip_code; ?>" />
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" placeholder="Your Mobile Number" value="<?php echo $new_user->mobile; ?>" />
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Your phone number" value="<?php echo $new_user->phone; ?>" />
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Username*</label>
                            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $new_user->username; ?>" required="required" />
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Email*</label>
                            <input type="text" class="form-control" name="email" placeholder="Your email address" value="<?php echo $new_user->email; ?>" required="required" />
                        </div>
                       <?php if(isset($_POST['edit_user'])) { ?> 
                        <div class="form-group">
                        	<label class="control-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" value="" /><small>Leave blank if you don't want to change password</small>
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" value="" />
                        </div>
                        <?php } else {?>
                        <div class="form-group">
                        	<label class="control-label">Password*</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" value="" required="required" /> 
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Confirm Password*</label>
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" value="" required="required" />
                        </div>
						<?php } ?>
                        <div class="form-group">
                        	<label class="control-label">Profile Image</label>
                           	<div class="clearfix"></div>
                            <input type="file" class="pull-left clearfix" name="profile_image" placeholder="Your profile image" />
                            	<?php
									if(isset($new_user->profile_image) && $new_user->profile_image != '') {
										echo '<a href="'.$new_user->profile_image.'" target="_blank"><img src="'.$new_user->profile_image.'" height="80" class="pull-left img-thumbnail" style="height:80px;" /></a><input type="hidden" name="already_img" value="'.$new_user->profile_image.'">';	
									}
								?>
                                <div class="clearfix"></div>
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Description</label>
                            <textarea name="description" class="form-control" placeholder="User Description"><?php echo $new_user->description; ?></textarea>
                        </div>
                        <div class="form-group">
                        	<label class="control-label">Status*</label>
                            <select name="status" required="required" class="form-control" id="status" class="required">
									<option value="0">Select Status</option>
                                    <option <?php if($new_user->status == 'activate'){echo 'selected="selected"';} ?> value="activate">Activate</option>
                                    <option <?php if($new_user->status == 'deactivate'){echo 'selected="selected"';} ?> value="deactivate">Deactive</option>
                                    <option <?php if($new_user->status == 'ban'){echo 'selected="selected"';} ?> value="ban">Ban</option>
                                    <option <?php if($new_user->status == 'suspend'){echo 'selected="selected"';} ?> value="suspend">Suspend</option>                           	
	                            </select>
                        </div>
                        
                        <div class="form-group">
                        	<label class="control-label">User Type*</label>
                            <select name="user_type" class="form-control" required="required" id="user_type" class="required">
									<option value="">Select User Type</option>
                                    <option <?php if($new_user->user_type == 'admin'){echo 'selected="selected"';} ?> value="admin">Admin</option>
                                    <?php $new_userlevel->userlevel_options($new_user->user_type); ?>                          	
	                            </select>
                         </div>
							  <?php 
						if(isset($_POST['edit_user'])){ 
							echo '<input type="hidden" name="edit_user" value="'.$_POST['edit_user'].'" />';
							echo '<input type="hidden" name="update_user" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_user" value="1" />';
						} ?>
                        <div class="form-group">
                        	<input type="submit" value="<?php if(isset($_POST['edit_user'])){ echo 'Update User'; } else { echo 'Add User';} ?>" class="btn btn-primary" />
                        </div>
                    </form>
                    <script type="text/javascript">
						$(document).ready(function() {
						// validate the register form
					$("#add_user").validate();
						});
                    </script>
                                        <script src="js/jquery-1.11.2.min.js"></script>
        			<script src="js/bootstrap-datepicker.js"></script>

                   </div><!--left-side-form ends here.-->
                   
<?php
	require_once('includes/sidebar.php');
?>                        
<?php
	require_once("includes/footer.php");
?>