<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('all');
	
	//Delete note.
	if(isset($_POST['delete_note']) && $_POST['delete_note'] != '') { 
		$message = $notes_obj->delete_note($_POST['delete_note']); 
	}//delete ends here.
		
	$page_title = $language["my_notes"]; //You can edit this to change your page title.
	$sub_title = "Manage your notes.";
	require_once("includes/header.php"); //including header file.

    //display message if exist.
        if(isset($message) && $message != '') { 
            echo '<div class="alert alert-success">';
            echo $message;
            echo '</div>';
        }
    ?>
    <p>
    <a href="manage_notes.php" class="btn btn-primary btn-default"><?php echo $language["add_new"]; ?></a>
    </p>
   <?php $notes_obj->list_notes(); ?>

<?php
	require_once("includes/footer.php");
?>