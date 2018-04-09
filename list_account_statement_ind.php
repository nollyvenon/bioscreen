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
	
	if(partial_access('admin') || $store_access->have_module_access('accounts')) {} else { 
		HEADER('LOCATION: store.php?message=accounts');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.

	 $page_title = 'View All Transactions'; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.

?>

                    <script src="js/jquery-1.11.2.min.js"></script>
        			<script src="js/bootstrap-datepicker.js"></script>
                   </div><!--left-side-form ends here.-->
                   
                   <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Account</th>
                <th>Type</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
			<?php $account->alltransactions(); ?>
        </tbody>
    </table>
<?php
	require_once("includes/footer.php");
?>