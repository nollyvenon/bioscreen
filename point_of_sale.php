<?php
	include('system_load.php');
	//This loads system.	
	
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
		
	if(partial_access('admin') || $store_access->have_module_access('sales')) {} else { 
		HEADER('LOCATION: store.php?message=products');
		exit();
	}

	if(isset($_POST['add_client1'])) {
		$add_client = $_POST['add_client'];
		if($add_client == '1') { 
			extract($_POST);
			$message = $client->add_client($full_name, $business_title, $mobile, $phone, $age, $sex, $blood_group, $birth_date, $HMO_name, $address, $city, $state, $zipcode, $country, $email, $price_level, $notes);
		}
	}//isset add level

	$page_title = "Point Of Sale"; //You can edit this to change your page title.
	$page = "pos";
	
	if(get_option($_SESSION['store_id'].'_default_warehouse') == '') { 
		$message = "Please select default warehouse to access POS going to Dashboard >> Store >> <a href='pos_settings.php'>Store Settings</a> so POS can process invoices from that warehouse because there is no option to select different warehouses, if you want to use different warehouse for each product please go to Sales >> <a href='manage_sale.php'>Add new</a>.";
		HEADER("LOCATION: pos_settings.php?message=".$message);
	}
	
	require_once('includes/header.php');
	
	if(isset($message) && $message != '') { 
		echo "<script type='text/javaScript'>
				alert('".$_GET['message']."');
			  </script>";
	}
	if(isset($_GET['message']) && $_GET['message'] != '') { 
		echo "<script type='text/javaScript'>
				alert('".$_GET['message']."');
			  </script>";
	}
	
	if(isset($_GET['sale_id'])) { ?>
	<script type="text/javascript">
		window.open('reports/view_pos_sale_invoice.php?sale_id=<?php echo $_GET['sale_id']; ?>', '_blank'); 
	</script>
<?php } ?>

<link rel="stylesheet" type="text/css" href="css/pos.css" media="all" />
<script type="text/javascript">
	jQuery(function($) {
		$('form[data-async]').on('submit', function(event) {
			
			var $form = $(this);
			var $target = $($form.attr('data-target'));

			$.ajax({
				type: $form.attr('method'),
				url: 'includes/otherprocesses.php',
				data: $form.serialize(),
				dataType: 'json',
 
			success: function(response) {
				var message = response.message;
				var client_options = response.client_options;
				var client_id = response.client_id;
			
				$('#client_id').html(client_options);
				$("#client_id").select2().select2('val', client_id);
				$('#success_message').html('<div class="alert alert-success">'+message+'</div>');
			}
		});
		event.preventDefault();
	});
});
</script>

<!-- Add new vendor modal starts here. -->
<div class="modal fade" id="addnewclient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add new client</h4>
      </div>
     	
         <div class="modal-body">
        <!-- <form data-async data-target="#addnewclient" method="POST" enctype="multipart/form-data" role="form">-->
                  <form id="form1" name="form1" method="post" action="">
         <div id="success_message"></div>
         		<table style="width:100%;">
                	<tr>
                    	<td>
                    <div class="form-group">
                        	<label class="control-label">Full Name*</label>
                            <input type="text" class="form-control" name="full_name" placeholder="Patient full name" value="" required="required" />
                      </div>
                      		</td>
                            <td>
                      <div class="form-group">
                        	<label class="control-label">Business Title</label>
                            <input type="text" class="form-control" name="business_title" placeholder="Business Title" value="" />
                      </div>
                      	</td>
                        </tr>
                        <tr>
                        <td>
                      <div class="form-group">
                        	<label class="control-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile number" value="" />
                      </div>
                      </td>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone number" value="" />
                      </div>
                      </td>
                      </tr>
                      <tr>
                      	<td>
                      		<div class="form-group">
                        		<label class="control-label">Address</label>
                        	    <input type="text" class="form-control" name="address" placeholder="Address" value="" />
                      		</div>
                      	</td>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" value="" />
                      </div>
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State" value="" />
                      </div>
                      </td>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">Zipcode</label>
                            <input type="text" class="form-control" name="zipcode" placeholder="Zip Code" value="" />
                      </div>
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <div class="form-group">
                        	<label class="control-label">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country" value="" />
                      </div>
                      </td>
                      <td>
				     <div class="form-group">
                        	<label class="control-label">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email" value="" />
                      </div>
                      </td>
                      </tr>
                      <tr>
                      	<td>
                      <div class="form-group">
                        	<label class="control-label">Price Level</label>
                            <select name="price_level" class="form-control">
                            	<option value="default_rate">Default</option>
                                <option value="level_1">Level 1</option>
                                <option value="level_2">Level 2</option>
                                <option value="level_3">Level 3</option>
                                <option value="level_4">Level 4</option>
                                <option value="level_5">Level 5</option>
                            </select>
                      </div>
                      	</td>
                        <td>
                      <div class="form-group">
                        	<label class="control-label">Notes</label>
                            <textarea class="form-control" name="notes"></textarea>
                      </div>
                      	</td>
                        	</tr>
                      </table>	
                        <input type="hidden" name="add_client" value="1" />
                         <input type="submit" name="add_client1" id="submit" class="btn btn-primary" value="Add Patient">
                      </form>   
                              </div>
      <div class="modal-footer">
      	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--add new vendor modal ends here.-->

<script type="text/javascript">
	$('body').ready(function(){ 
		$("input[name='to_auto']").focus();
	});
</script>
    
  	<div class="point_of_sale">
    	<!--Left sidebar-->
        <div class="pos_left">
        <form action="includes/process_sale.php" method="post">
      	  <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>" />
      	  <input type="hidden" name="custom_inv_no" value="POS Sale" />
     	   <input type="hidden" name="memo" value="Sale processed from POS Module" >
        
        	<table>
            	<tr>
                	<td width="370px">
                        <div class="form-group">
                            <select name="client_id" id="client_id" class="autofill" style="width:100%">
                                <option value="">Select Patient by full name or mobile</option>
                                <?=$client->client_options(get_option($_SESSION['store_id'].'_default_customer')); ?>	
                        	</select>
                    	</div>
                    </td>
                    <td><div class="form-group"><a data-toggle="modal" href="#addnewclient" style="font-size:22px;" title="Add new client"><i class="glyphicon glyphicon-plus-sign"></i></a></div></td>
                </tr>

                <tr>
                	<td colspan="2">
                    	<div class="form-group">
            			    <input type="text" class="form-control" name="to_auto" id="to" placeholder="Product Name or barcode" value="" />
          				</div>
                    </td>
                </tr>
            </table>
            
            <div class="items_container">
            <table class="table" id="items">
            	<tr>
                	<th><i class="glyphicon glyphicon-trash" title="Delete item"></i></th>
                    <th>Product</th>
                    <th>QTY</th>
                    <th>Tax</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <tr class="item-row">
                </tr>
            </table>
            </div>
            
            <div class="calculations">
            	<div class="styletotal">Total: <span class="totalamount">0.00</span> &nbsp;&nbsp;&nbsp;Tax: <span class="taxamount">0.00</span> &nbsp;&nbsp;&nbsp;Items: <span class="numberofitems">0</span></div>
                <div class="paymentamount">Receiveable: <span id="grand_total" class="receiveable">0.00</span></div>
                <table>
                	<tr>
                    	<td>
                        <select name="payment_method" class="form-control">
                			<option value="0">Select payment method</option>
                    		<option value="cash" selected="selected">Cash</option>
                			<option value="credit_card">Credit Card</option>
                            <option value="credit">Credit</option>
                		</select>
                        </td>
                        <td>
                        <input type="hidden" name="sale_type" value="pos_sale" />
                        <input type="submit" class="btn btn-primary" name="save" value="Save" /> &nbsp;<input type="submit" class="btn btn-primary" name="print" value="Print" />
                        </td>
                    </tr>
                </table>
            </div>
		</form>
        </div>
        <!--leftSide bar Ends here-->
		<div class="rightsidepos">
        	<select name="product_cat_id" id="product_cat_id" class="autofill" style="width:100%">
            	<option value="all">From all categories</option>
                <?php $product_category->category_options('all'); ?>
            </select>
            <div id="productscontainer">
             	<?php $_SESSION['category_id'] = 'all'; echo $product->list_pos_products($_SESSION['category_id']); ?>
            </div><!--productsContainer Ends here-->
        	
        </div>
  </div>
<?php
	require_once("includes/footer.php");
?>