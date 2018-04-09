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
	
	if(isset($_POST['delete_sample']) && $_POST['delete_sample'] != '') { 
		$message = $sample->delete_sample($_POST['delete_sample']);
	}//delete account.
	
	$new_store->set_store($_SESSION['store_id']); //setting store.
	 
	$page_title = 'Samples'; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.
	
    //display message if exist.
        if(isset($message) && $message != '') { 
            echo '<div class="alert alert-success">';
            echo $message;
            echo '</div>';
        }
    ?>
	<!--content here-->
	<p>
	    <a href="manage_sample.php" class="btn btn-primary btn-default">Add New</a>
        <a href="products.php?alert=1" class="btn btn-primary btn-default">Products Alert</a>
    </p>
    <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Unit</th>
                <th>Pay Status</th>
                <th>Image</th>
                <th>Results</th>
                <th>Date<br />Taken</th>
                <th>Result<br />Date</th>
                <th>Comment</th>
                <th>View</th>
                <?php if(partial_access('admin')) { ?>
                <th> Add Comment</th>
                <?php } ?>
                <?php if(partial_access('admin')) { ?>
                <th class="no-print">Edit</th>
                <th class="no-print">Delete</th><?php } ?>
            </tr>
        </thead>
        <tbody>
			<?php $sample->list_samples();  ?>
        </tbody>
    </table> 
    <!--content Ends here.-->
<?php
	require_once("includes/footer.php");
?>