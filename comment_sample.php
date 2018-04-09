<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.

//	echo $_POST['comment_sample'];
	if(partial_access('admin') || $store_access->have_module_access('products')) {} else { 
		HEADER('LOCATION: store.php?message=samples');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.

	//setting level data if updating or editing.
	//if(isset($_POST['comment'])) {
		$sample->set_sample($_POST['comment_sample']);
		//HEADER('LOCATION: manage_samples.php');	
	//} //level set ends here

	if(isset($_POST['comment_sample'])) {
		$comment_sample = $_POST['comment_sample'];
		if($comment_sample == '1') { 
			extract($_POST);
			$message = $sample->comment_sample($comment_sample, $comment);
			$sample->set_sample($_POST['comment_sample']);
		}
		
		//if($update_sample == '1') { 
		//	HEADER('LOCATION: manage_samples.php');
		//}
		
	}//isset add level
	
	
	
	 $page_title = 'Comment on Lab Sample'; //You can edit this to change your page title.
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
		$("input[name='comment']").focus();
	});
</script>
                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" id="comment_sample" name="level" method="post">
                     <div class="form-group">
                        	<label class="control-label">Comment</label>
                            <textarea class="form-control" placeholder="Comment" name="comment"><?php echo $sample->comment; ?></textarea>
                      </div>
                      
						<?php 
						if(isset($_POST['comment_sample'])){ 
							echo '<input type="hidden" name="comment_sample" value="'.$_POST['comment_sample'].'" />';
							echo '<input type="hidden" name="update_sample" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_sample" value="1" />';
						} ?>                        
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['comment_sample'])){ echo 'Comment Lab Sample'; } ?>" />
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