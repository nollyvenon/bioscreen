<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.

	if(partial_access('admin') || $store_access->have_module_access('labsamples')) {} else { 
		HEADER('LOCATION: store.php?message=samples');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	$sample_image = '';
	//Profile Image Processing.
	if(isset($_FILES['sample_image']) && $_FILES['sample_image'] != '') { 
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["sample_image"]["name"]);
		$extension = end($temp);
		
		if ((($_FILES["sample_image"]["type"] == "image/gif")
		|| ($_FILES["sample_image"]["type"] == "image/jpeg")
		|| ($_FILES["sample_image"]["type"] == "image/jpg")
		|| ($_FILES["sample_image"]["type"] == "image/pjpeg")
		|| ($_FILES["sample_image"]["type"] == "image/x-png")
		|| ($_FILES["sample_image"]["type"] == "image/png"))
		&& ($_FILES["sample_image"]["size"] < 2048000)
		&& in_array($extension, $allowedExts)) {
 			 if ($_FILES["sample_image"]["error"] > 0) {
    			$message = "Return Code: " . $_FILES["sample_image"]["error"];
    	} else 	{
			$phrase = substr(md5(uniqid(rand(), true)), 16, 16);
	  if (file_exists("upload/" .$phrase.$_FILES["sample_image"]["name"])) {
	      $message = $_FILES["sample_image"]["name"] . " already exists. ";
      } else {
		  move_uploaded_file($_FILES["sample_image"]["tmp_name"],
		  "upload/".$phrase.str_replace(' ', '-',$_FILES["sample_image"]["name"]));
		  $sample_image = "upload/".$phrase.str_replace(' ', '-', $_FILES["sample_image"]["name"]);
	  } //if file not exist already.
	  
    } //if file have no error
  }//if file type is alright.
} //if image was uploaded processing.
/*Image processing ends here.*/

//User update submission image processing edit user password setting if not changed.
if(isset($_POST['edit_sample']) && $_POST['edit_sample'] != '') { 
	if(isset($sample_image)) { 
		$sample_image = $sample_image;
	} else { 
		if(isset($_POST['already_img'])) { 
			$sample_image = $_POST['already_img'];
		} else { 
			$sample_image = '';
		}
	}
	if(isset($_POST['update_sample']) && $_POST['update_sample'] == '1') {
		extract($_POST);
		if($sample_image != '') { 
			$sample_image = $sample_image;
		} else { 
			$sample_image = $already_img;
		}
		$message = $sample->update_sample($edit_sample,$sample_manual_id, $sample_name, $sample_unit, $sample_result, $client_id, $sample_type, $pay_status, $sample_image, $date_taken, $result_taken, $comment, $lab_scientist, $sample_description);
	}
}//update user submission.

	//setting level data if updating or editing.
	if(isset($_POST['edit_sample'])) {
		$sample->set_sample($_POST['edit_sample']);	
	} //level set ends here
	
	if(isset($_POST['add_sample'])) {
		$add_sample = $_POST['add_sample'];
		if($add_sample == '1') { 
			extract($_POST);
			$message = $sample->add_sample($sample_manual_id, $sample_name, $sample_description, $sample_unit, $sample_result, $client_id, $sample_type, $pay_status, $sample_image, $date_taken, $result_taken, $comment, $lab_scientist);
		}
	}//isset add level
	
	if(isset($_POST['edit_sample'])){ $page_title = 'Edit Lab Sample'; } else { $page_title = 'Add Lab Sample';}; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.

	//display message if exist.
	if(isset($message) && $message != '') { 
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
	}
?>
<script type="text/javascript">
	$('body').ready(function(){ 
		$("input[name='sample_manual_id']").focus();
	});
</script>

                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" id="add_sample" name="level" method="post">
                      <div class="form-group">
                        	<label class="control-label">Patient*</label>
                            <select name="client_id" id="client_id" class="autofill" style="width:100%">
	                    		<option value="">Select Patient by full name or mobile</option>
	                    		<?php echo $client->client_options($sample->client_id); ?>	
                    		</select>
                      </div>
                                            
                    <div class="form-group">
                        <label class="control-label">Sample Unique ID*</label>
                        <input type="text" class="form-control" name="sample_manual_id" placeholder="Sample Unique Id or barcode" value="<?php echo $sample->sample_manual_id; ?>" required="required" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Sample Name*</label>
                            <input type="text" class="form-control" name="sample_name" placeholder="Sample Name" value="<?php echo $sample->sample_name; ?>" required="required" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Sample Unit</label>
                            <input type="text" class="form-control" name="sample_unit" placeholder="Sample Unit eg. QTY, KG" value="<?php echo $sample->sample_unit; ?>" />
                      </div>

                      <div class="form-group">
                        	<label class="control-label">Pay Status</label>
                            <select name="pay_status" style="width:100%" class="autofill">
                            <?php if ($sample->pay_status == ''){ ?>
                            	<option value="">Select Pay Status</option>
                            	<option value="paid">Paid</option>
                            	<option value="unpaid">Unpaid</option>
                            </select>
                            <?php } else{ 
								echo "<option value='$sample->pay_status'>". strtoUpper($sample->pay_status)."</option>";
								?>
                            	<option value="paid">Paid</option>
                            	<option value="unpaid">Unpaid</option>
							<?php	 } ?>
                      </div>

                      <div class="form-group">
                        	<label class="control-label">Sample Image</label>
                            <div class="clearfix"></div>
                           	<input type="file" class="pull-left" name="sample_image" placeholder="Your sample image" />
                            	<?php
									if(isset($sample->sample_image) && $sample->sample_image != '') {
										echo '<a href="'.$sample->sample_image.'" target="_blank"><img src="'.$sample->sample_image.'" height="80" class="pull-left img-thumbnail" style="height:80px;" /></a><input type="hidden" name="already_img" value="'.$sample->sample_image.'">';	
									}
								?>
                                <div class="clearfix"></div>
                        </div>
        
                      <div class="form-group">
                        	<label class="control-label">Date Taken*</label>
                            <input type="text" name="date_taken" class="form-control datepick" readonly="readonly" value="<?php if ($sample->date_taken == ''){ echo date('Y-m-d');} else{ echo $sample->date_taken;} ?>" />
                      </div>
                                            
                      <div class="form-group">
                        	<label class="control-label">Result Date</label>
                            <input type="text" class="form-control datepick" readonly="readonly" name="result_taken" value="<?php if ($sample->result_taken == ''){ echo date('Y-m-d');} else{ echo $sample->result_taken;} ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Sample Type*</label>
                            <select name="sample_type" style="width:100%" class="autofill">
                                <?php $sample->sample_type_options($sample->sample_type); ?>
                            </select>
                      </div>

                      <div class="form-group">
                        	<label class="control-label">Lab Scientist*</label>
                            <select name="lab_scientist" style="width:100%" class="autofill">
                            	<option value="">Lab Scientist</option>
                                <?php $sample->laboratorist_options($sample->lab_scientist); ?>
                            </select>
                      </div>
                                                                                        
                     <div class="form-group">
                        	<label class="control-label">Sample Description</label>
                            <textarea class="form-control" placeholder="Sample description" name="sample_description"><?php echo $sample->sample_description; ?></textarea>
                      </div>
                      
                     <div class="form-group">
                        	<label class="control-label">Sample Result</label>
                            <textarea class="form-control" placeholder="Sample Result" name="sample_result"><?php echo $sample->sample_result; ?></textarea>
                      </div>                      

                     <div class="form-group">
                        	<label class="control-label">Comment</label>
                            <textarea class="form-control" placeholder="Comment" name="comment"><?php echo $sample->comment; ?></textarea>
                      </div>
                      
						<?php 
						if(isset($_POST['edit_sample'])){ 
							echo '<input type="hidden" name="edit_sample" value="'.$_POST['edit_sample'].'" />';
							echo '<input type="hidden" name="update_sample" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_sample" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_sample'])){ echo 'Update Lab Sample'; } else { echo 'Add Lab Sample';} ?>" />
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