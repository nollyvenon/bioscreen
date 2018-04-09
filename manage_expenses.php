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
	if(isset($_POST['update_expense'])) { 
		extract($_POST);
		$message = $expenses->update_expense($edit_expense,$type_id, $datetime, $title, $description, $amount);
	}//update ends here.
	
	//setting level data if updating or editing.
	if(isset($_GET['expense_id'])) {
		$expenses->set_expense($_GET['expense_id']);	
	} //level set ends here
	
	if(isset($_POST['add_expense'])) {
		$add_expense = $_POST['add_expense'];
		if($add_expense == '1') { 
			extract($_POST);
			$message = $expenses->add_expense($type_id, $datetime, $title, $description, $amount);
		}
	}//isset add level
	
	if(isset($_POST['edit_expense'])){ $page_title = 'Edit Expense'; } else { $page_title = 'Add Expense';}; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.

	//display message if exist.
	if(isset($message) && $message != '') { 
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
	}
	
	if($expenses->datetime != '') { 
		$date = $expenses->datetime;
		$date = strtotime($date);
		$date = date('Y-m-d', $date);
	} else { 
		$date = date('Y-m-d');
	}
?>
                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_expense_type" method="post">
                    <div class="form-group">
                    	<label class="control-label">Date: </label>
                        <input type="text" name="datetime" class="form-control datepick" required="required" readonly="readonly" value="<?= $date; ?>" />
                    </div>
                    <div class="form-group">
                    	<select name="type_id" class="autofill" style="width:100%" required="required">
	                    	<option value="">Select Expense Type</option>
	                    	<?=$expenses->expense_type_options($expenses->type_id); ?>	
                    	</select>
                    </div>
                    <div class="form-group">
                        	<label class="control-label">Expense Title*</label>
                            <input type="text" class="form-control" name="title" placeholder="Expense title" value="<?php echo $expenses->title; ?>" required="required" />
                      </div>
                      
                     <div class="form-group">
                        	<label class="control-label">Description</label>
                            <textarea class="form-control" placeholder="Expsense description" name="description"><?php echo $expenses->description; ?></textarea>
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Amount*</label>
                            <input type="text" class="form-control" name="amount" placeholder="Expense amount" value="<?php echo $expenses->amount; ?>" required="required" />
                      </div>
                      
                      
						<?php 
						if(isset($_GET['expense_id'])){ 
							echo '<input type="hidden" name="edit_expense" value="'.$_GET['expense_id'].'" />';
							echo '<input type="hidden" name="update_expense" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_expense" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_GET['expense_id'])){ echo 'Update expense'; } else { echo 'Add Expense';} ?>" />
                    </form>
                   </div><!--left-side-form ends here.-->
                   
<?php
	require_once("includes/footer.php");
?>