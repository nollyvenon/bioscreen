<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	
	if(partial_access('admin') || $store_access->have_module_access('expenses')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	
	//updating user level
	if(isset($_POST['update_expense_type'])) { 
		extract($_POST);
		$message = $expenses->update_expense_type($edit_expense_type,$type_name, $type_description);
	}//update ends here.
	//setting level data if updating or editing.
	if(isset($_POST['edit_expense_type'])) {
		$expenses->set_expense_type($_POST['edit_expense_type']);	
	} //level set ends here
	if(isset($_POST['add_expense_type'])) {
		$add_expense_type = $_POST['add_expense_type'];
		if($add_expense_type == '1') { 
			extract($_POST);
			$message = $expenses->add_expense_type($type_name, $type_description);
		}
	}//isset add level
	
	if(isset($_POST['edit_expense_type'])){ $page_title = 'Edit Expense Type'; } else { $page_title = 'Add Expense Type';}; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.

	//display message if exist.
	if(isset($message) && $message != '') { 
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
	}
?>
                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_expense_type" method="post">
                    <div class="form-group">
                        	<label class="control-label">Type Name*</label>
                            <input type="text" class="form-control" name="type_name" placeholder="Expense type name" value="<?php echo $expenses->type_name; ?>" required="required" />
                      </div>
                      
                     <div class="form-group">
                        	<label class="control-label">Category Description</label>
                            <textarea class="form-control" placeholder="Type description" name="type_description"><?php echo $expenses->type_description; ?></textarea>
                      </div>
						<?php 
						if(isset($_POST['edit_expense_type'])){ 
							echo '<input type="hidden" name="edit_expense_type" value="'.$_POST['edit_expense_type'].'" />';
							echo '<input type="hidden" name="update_expense_type" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_expense_type" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_expense_type'])){ echo 'Update expense type'; } else { echo 'Add Expense Type';} ?>" />
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