<?php
	include('system_load.php');
	//Including this file we load system.
	
	//user Authentication.
	authenticate_user('admin');
	
	$warehouse_obj = new Warehouse;
	
	//installation form processing when submits.
	if(isset($_POST['settings_submit']) && $_POST['settings_submit'] == 'Yes') {
	//validation to check if fields are empty!
		//adding site url
		set_option($_SESSION['store_id'].'_default_warehouse', $_POST[$_SESSION['store_id'].'_default_warehouse']);
		
		set_option($_SESSION['store_id'].'_default_customer', $_POST[$_SESSION['store_id'].'_default_customer']);
		
		set_option($_SESSION['store_id'].'_pos_items', $_POST[$_SESSION['store_id'].'_pos_items']);
		$message = $language['settings_saved1'];
		HEADER('LOCATION: pos_settings.php?message='.$message); 
	}//form processing.
	
	

	//Page display settings.
	$page_title = 'Store Settings'; //You can edit this to change your page title.

	require_once("includes/header.php"); //including header file.

    //display message if exist.
	if(isset($_GET['message']) && $_GET['message'] != '') { 
		echo '<div class="alert alert-success">';
		echo $_GET['message'];
		echo '</div>';
	}
	if(isset($message) && $message != '') { 
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
	}
?>
                    <div class="col-sm-10">
                    <form name="set_install" id="set_install" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    	
                        <div class="form-group">
                    	<label class="control-label">Select Default Warehouse:</label>
                        <select name="<?=$_SESSION['store_id'];?>_default_warehouse" class="form-control">
                        	<option value="">Select Default Warehouse</option>
                        	<?php $warehouse_obj->warehouse_options(get_option($_SESSION['store_id'].'_default_warehouse')); ?>
                        </select>
		                    </div>
                            
                        <div class="form-group">
                    	<label class="control-label">Select Default Customer:</label>
                        <select name="<?=$_SESSION['store_id'];?>_default_customer" class="form-control">
                        	<option value="">Select Default Customer</option>
                        	<?php echo $client->client_options(get_option($_SESSION['store_id'].'_default_customer')); ?>
                        </select>
		                    </div>
                            
                            <div class="form-group">
                    	<label class="control-label">Products to show in POS:</label>
                        <input type="text" class="form-control" name="<?=$_SESSION['store_id'];?>_pos_items" value="<?=get_option($_SESSION['store_id'].'_pos_items'); ?>" />
		                    </div>    
       
                    <input type="hidden" name="settings_submit" value="Yes" />
                    <input type="submit" value="<?php echo $language['submit_button']; ?>" class="btn btn-primary" />
            </form>
            <script>
				$(document).ready(function() {
					// validate the Installation form
					$("#set_install").validate();
				});
            </script>
           </div><!--left-side-form ends here.-->                   
<?php
	require_once("includes/footer.php");
?>