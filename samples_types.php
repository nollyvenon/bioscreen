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
	
	if(isset($_POST['delete_sample_type']) && $_POST['delete_sample_type'] != '') { 
		$message = $sample->delete_sample_type($_POST['delete_sample_type']);
	}//delete account.
	
	$new_store->set_store($_SESSION['store_id']); //setting store.
	 
	$page_title = 'Sample Types'; //You can edit this to change your page title.
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
	    <a href="manage_sample_types.php" class="btn btn-primary btn-default">Add New Sample Type</a>
    </p>
    <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Timestamp</th>
                <th>Poster</th>
                <th>View</th>
                <?php if(partial_access('admin')) { ?>
                <th class="no-print">Edit</th>
                <th class="no-print">Delete</th><?php } ?>
            </tr>
        </thead>
        <tbody>
			<?php $sample->list_sample_types();  ?>
        </tbody>
    </table> 
    <!--content Ends here.-->
<?php
	require_once("includes/footer.php");
?>