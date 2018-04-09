<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('all');
	
	if(isset($_POST['reply_form']) && $_POST['reply_form'] == '1') {
		extract($_POST);
		if($reply_detail != '') {
		$message = $message_obj->send_reply($reply_to, $subject_id, $reply_detail);	
		} else { 
		$message = $language["message_is_empty"];
		}
	}
	
	$page_title = $language["my_messages"]; //You can edit this to change your page title.
	$sub_title = "Manage your messages";
	require_once("includes/header.php"); //including header file.

	//display message if exist.
	if(isset($message) && $message != '') { 
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
	}
?>
<!--row starts here.-->
<div class="row">
	<!--left sidebar starts here.-->
  <div class="col-sm-2">
		<button class="btn btn-success" data-toggle="modal" data-target="#new_message" style="width:100%">New Message</button>
<!-- Modal -->
<script type="text/javascript">
	jQuery(function($) {
		$('form[data-async]').on('submit', function(event) {
			var $form = $(this);
			var $target = $($form.attr('data-target'));

			tinyMCE.triggerSave();

		$.ajax({
			type: $form.attr('method'),
			url: 'includes/messageprocess.php',
			data: $form.serialize(),
 
		success: function(data, status) {
			$('#success_message').html('<div class="alert alert-success">'+data+'</div>');
		}
	});
	event.preventDefault();
});
});
</script>				
<div class="modal fade" id="new_message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $language["send_message"]; ?></h4>
      </div>
	  <div class="modal-body">
      		<div id="success_message"></div>
           <form data-async data-target="#rating-modal" method="POST" enctype="multipart/form-data" role="form">
      		<div class="form-group">
				<label class="control-label"><?php echo $language["message_to"]; ?> <small><?php echo $language["email_or_username"]; ?></small></label>
				<input type="text" class="form-control" name="message_to" required="required" value="" />
			</div>
			
			<div class="form-group">
				<label class="control-label"><?php echo $language["subject"]; ?></label>
				<input type="text" class="form-control" name="subject" required="required" value="" />
			</div>
			
			<div class="form-group">
				<label class="control-label"><?php echo $language["message"]; ?></label>
                <textarea name="message" class="tinyst form-control"></textarea>
			</div>
              <input type="hidden" name="from" value="'.<?php echo $_SESSION['user_id']; ?>.'" />
			  <input type="hidden" name="form_type" value="new_message" />
        
              <input type="submit" id="submit" value="<?php echo $language["send_message"]; ?>" class="btn btn-primary" />
           </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $language["close"]; ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  		<hr />
        <a href="messages.php" class="btn btn-<?php if(isset($_GET['type'])){echo'default';}else{echo'primary';}?>" style="width:100%"><?php echo $language["inbox"]; ?></a>
        <div style="height:7px;"></div>
        <a href="messages.php?type=sent" class="btn btn-<?php if(isset($_GET['type'])){echo'primary';}else{echo'default';}?>" style="width:100%"><?php echo $language["sent"]; ?></a>
  </div>
  <!--left sidebar ends here.-->
  
  <!--right sidebar starts here.-->
  <div class="col-sm-10">
  	<?php if(isset($_GET['thread_id']) && $_GET['thread_id'] != '') : ?>
  	<div style="border:2px solid #E6E6E3; padding:10px; border-radius:5px;">
        <?php $message_obj->list_thread($_GET['thread_id']); ?>
    </div>
    <?php else: ?>
    <table cellpadding="0" cellspacing="0" border="0" class="table display" id="wc_table" width="100%">
    	<thead>
    	<tr>
        	<th class="hide">Pic</th>
            <th class="hide">Message From</th>
            <th class="hide">Message</th>
        </tr>
        </thead>
        <tbody>
 		<?php 
		if(isset($_GET['type']) && $_GET['type'] == 'sent') { 
			$message_obj->list_sent();
		} else { 
			$message_obj->list_inbox();
		}
		 ?>
        </tbody>
    </table>
    <?php endif; ?>
  </div>
   <!--right sidebar ends here.-->
</div>
<!--row ends here.-->                    
<?php
	require_once("includes/footer.php");
?>