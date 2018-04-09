<?php
	include('system_load.php');
	//This loads system.
	
	$new_level = new Userlevel;
	//user Authentication.
	authenticate_user('admin');
	
	//updating Notes
	if(isset($_POST['update_announcement'])) { 
		extract($_POST);
		$message = $announcement_obj->update_announcement($edit_announcement, $announcement_title, $announcement_detail, $user_type, $announcement_status);
	}//update ends here.
	
	//setting level data if updating or editing.
	if(isset($_POST['edit_announcement'])) {
		$announcement_obj->set_announcement($_POST['edit_announcement']);	
	} //level set ends here
	
	//add user processing.
	if(isset($_POST['add_announcement']) && $_POST['add_announcement'] == '1') { 
		extract($_POST);
		if($announcement_title == '') { 
			$message = $language["announcement_title_required"];
		} else if($announcement_detail == '') { 
			$message = $language["announcement_detail_required"];
		}  else {
		$message = $announcement_obj->add_announcement($announcement_title, $announcement_detail, $user_type, $announcement_status);
		}
	}//add user processing ends here.
	
	if(isset($_POST['edit_announcement'])){ $page_title = $language['edit_announcement']; } else { $page_title = $language['add_announcement'];} //page title set.
	$sub_title = "Add or Update announcements.";
	require_once("includes/header.php"); //including header file.
	
	//display message if exist.
    if(isset($message) && $message != '') { 
       echo '<div class="alert alert-success">';
        echo $message;
        echo '</div>';
     }
?>
    <div class="col-sm-8">
    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_user" name="user" method="post" enctype="multipart/form-data" role="form">
     
     <div class="form-group">
     <label class="control-label"><?php echo $language["announcement_title"]; ?>*</label>
     <input type="text" class="form-control" name="announcement_title" required="required" placeholder="<?php echo $language["announcement_title"]; ?>" value="<?php echo $announcement_obj->announcement_title; ?>" />
     </div>
        
        <div class="form-group">
        <label class="control-label"><?php echo $language["announcement_detail"]; ?>*</label>
        <textarea name="announcement_detail" class="tinyst form-control" placeholder="<?php echo $language["announcement_detail"]; ?>"><?php echo $announcement_obj->announcement_detail; ?></textarea>
        </div>
        
        <div class="form-group">
        <label class="control-label"><?php echo $language["user_type"]; ?></label>
        <select name="user_type" class="form-control">
        <option <?php if($announcement_obj->user_type == 'all'){echo 'selected="selected"';} ?> value="all">All users</option>
        <option <?php if($announcement_obj->user_type == 'admin'){echo 'selected="selected"';} ?> value="admin">Admin</option>
        <?php $new_level->userlevel_options($announcement_obj->user_type); ?>	                            
        </select>                 
        </div>
        
        <div class="form-group">
        <label class="control-label"><?php echo $language["announcement_status"]; ?></label>
        <select name="announcement_status" class="form-control">
	        <option <?php if($announcement_obj->announcement_status == 'active'){echo 'selected="selected"';} ?> value="active">Activate</option>
    	    <option <?php if($announcement_obj->announcement_status == 'deactive'){echo 'selected="selected"';} ?> value="deactive">Deactivate</option>
        </select>                 
        </div>

      <?php 
        if(isset($_POST['edit_announcement'])){ 
            echo '<input type="hidden" name="edit_announcement" value="'.$_POST['edit_announcement'].'" />';
            echo '<input type="hidden" name="update_announcement" value="1" />'; 
        } else { 
            echo '<input type="hidden" name="add_announcement" value="1" />';
        } ?>
        <div class="form-group">
            <input type="submit" value="<?php if(isset($_POST['edit_announcement'])){ echo $language["edit_announcement"]; } else { echo $language["add_announcement"];} ?>" class="btn btn-primary" />
        </div>
    </form>
<script type="text/javascript">
	$(document).ready(function() {
	// validate the register form
	$("#add_user").validate();
	});
</script>
   </div><!--left-side-form ends here.-->
<?php
	require_once('includes/sidebar.php');
	require_once("includes/footer.php");
?>