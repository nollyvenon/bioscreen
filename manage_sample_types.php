<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.

	
	if(partial_access('admin') || $store_access->have_module_access('labsamples')) {} else { 
		HEADER('LOCATION: store.php?message=sample_types');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.

	//setting level data if updating or editing.
	if(isset($_POST['edit_sample_type'])) {
		$sample->set_sample_type($_POST['edit_sample_type']);	
	} //level set ends here
	
	if(isset($_POST['add_sample_type'])) {
		$add_sample = $_POST['add_sample_type'];
		if($add_sample == '1') { 
			extract($_POST);
			$message = $sample->add_sample_types($sample_type_manual_id, $sample_type_name, $sample_type_description);
		}
	}//isset add level
				$users = new Users;

	if(isset($_POST['update_sample_type'])) { 
		extract($_POST);
		$message = $sample->update_sample_type($edit_sample_type, $sample_type_manual_id, $sample_type_name, $sample_type_description, $status);
		$sample->set_sample_type($_POST['edit_sample_type']);	
	}//update ends here.				

	if(isset($_POST['edit_sample_type'])){ $page_title = 'Edit Lab Sample Type'; } else { $page_title = 'Add Lab Sample Type';}; //You can edit this to change your page title.
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
                        <label class="control-label">Sample Type Unique ID*</label>
                        <input type="text" class="form-control" name="sample_type_manual_id" placeholder="Sample Unique Id or barcode" value="<?php echo $sample->sample_type_manual_id; ?>" required="required" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Sample Type Name*</label>
                            <input type="text" class="form-control" name="sample_type_name" placeholder="Sample Name" value="<?php echo $sample->sample_type_name; ?>" required="required" />
                      </div>
                      
                     <div class="form-group">
                        	<label class="control-label">Sample Type Description</label>
                            <textarea class="form-control" placeholder="Sample Type Description" name="sample_type_description"><?php echo $sample->sample_type_description; ?></textarea>
                      </div>

                     <div class="form-group">
                        	<label class="control-label">Poster</label>
                            <?php
							$user_id = $_SESSION['user_id'];
                            $full_name = $users->get_user_info($user_id, 'first_name').' '.$users->get_user_info($user_id, 'last_name'); ?>
                             <input type="text" class="form-control" name="Comment" value="<?php echo $full_name; ?>" readonly="readonly" />
                      </div>
                      
						<?php 
						if(isset($_POST['edit_sample_type'])){ 
							echo '<input type="hidden" name="edit_sample_type" value="'.$_POST['edit_sample_type'].'" />';
							echo '<input type="hidden" name="update_sample_type" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_sample_type" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_sample_type'])){ echo 'Update Lab Sample Type'; } else { echo 'Add Lab Sample Type';} ?>" />
                    </form>
                    <script>
						$(document).ready(function() {
							// validate the register form
							$("#add_category").validate();
						});
                    </script>
                   </div><!--left-side-form ends here.-->
                   
<?php
	require_once("includes/footer.php");
?>