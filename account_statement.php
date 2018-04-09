<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	$store_access = new StoreAccess;
	$new_store = new Store;
	$client = new Client;
	$account = new Accounts;
	
	if(partial_access('admin') || $store_access->have_module_access('products')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
			//$message = $account->list_account_statement_ind($store_id, $from_date, $to_date, $trans_type);

	
	if(isset($_POST['viewstate'])) {
		$viewstate = $_POST['viewstate'];
		//if($viewstate == '1') { 
			extract($_POST);
			$message = $account->list_account_statement_ind($store_id, $from_date, $to_date, $trans_type);
		//}
	}//isset add level
	
	 $page_title = 'View Statement'; //You can edit this to change your page title.
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
		$("input[name='product_manual_id']").focus();
	});
</script>
                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" id="add_category" name="level" method="post">
                      

                      <div class="form-group">
                        	<label class="control-label">Select Account</label>
                           <select name="store_id" id="store_id" class="autofill" style="width:100%">
	                    <option value="">Select A Store Account</option>
	                    <?=$new_store->store_options(); ?>	
                    </select>
                      </div>
                      


                      <div class="form-group">
                        	<label class="control-label">From Date</label>
                            <input type="text" name="from_date" class="form-control datepick" value="<?php echo date('Y-m-d');?>" readonly="readonly" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">To Date</label>
                            <input type="text" name="to_date" class="form-control datepick" readonly="readonly" value="<?php echo date('Y-m-d');?>" />
                      </div>
                      
                      
                     <div class="form-group">
                        	<label class="control-label">Type</label>
                           <select name="trans_type" id="trans_type" class="autofill" style="width:100%">
	                    <option value="">All Transactions</option>
	                    <option value="Expense">Debit</option>
	                    <option value="Income">Credit</option>
                    </select>
                      </div>
						<?php 
						if(isset($_POST['viewstate'])){ 
							echo '<input type="hidden" name="viewstate1" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="viewstate1" value="0" />';
						} ?>
                        <input name="viewstate" type="submit" class="btn btn-primary" value="View Statement" />
                    </form>

                   </div><!--left-side-form ends here.-->
 <?php
 	if(isset($_POST['viewstate'])) {  ?>
                  
                   <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
			<?php $account->list_account_statement_ind($store_id, $from_date, $to_date, $trans_type); ?>
        </tbody>
    </table>
    
    <?php }  ?>
    
                        <script>
						$(document).ready(function() {
							// validate the register form
							$("#add_category").validate();
						});
                    </script>
                    <script src="js/jquery-1.11.2.min.js"></script>
        			<script src="js/bootstrap-datepicker.js"></script>
<?php
	require_once("includes/footer.php");
?>