<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.

	
	if(partial_access('admin') || $store_access->have_module_access('products')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	$product_image = '';
	//Profile Image Processing.
	if(isset($_FILES['product_image']) && $_FILES['product_image'] != '') { 
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["product_image"]["name"]);
		$extension = end($temp);
		
		if ((($_FILES["product_image"]["type"] == "image/gif")
		|| ($_FILES["product_image"]["type"] == "image/jpeg")
		|| ($_FILES["product_image"]["type"] == "image/jpg")
		|| ($_FILES["product_image"]["type"] == "image/pjpeg")
		|| ($_FILES["product_image"]["type"] == "image/x-png")
		|| ($_FILES["product_image"]["type"] == "image/png"))
		&& ($_FILES["product_image"]["size"] < 2048000)
		&& in_array($extension, $allowedExts)) {
 			 if ($_FILES["product_image"]["error"] > 0) {
    			$message = "Return Code: " . $_FILES["product_image"]["error"];
    	} else 	{
			$phrase = substr(md5(uniqid(rand(), true)), 16, 16);
	  if (file_exists("upload/" .$phrase.$_FILES["product_image"]["name"])) {
	      $message = $_FILES["product_image"]["name"] . " already exists. ";
      } else {
		  move_uploaded_file($_FILES["product_image"]["tmp_name"],
		  "upload/".$phrase.str_replace(' ', '-',$_FILES["product_image"]["name"]));
		  $product_image = "upload/".$phrase.str_replace(' ', '-', $_FILES["product_image"]["name"]);
	  } //if file not exist already.
	  
    } //if file have no error
  }//if file type is alright.
} //if image was uploaded processing.
/*Image processing ends here.*/

//User update submission image processing edit user password setting if not changed.
if(isset($_POST['edit_product']) && $_POST['edit_product'] != '') { 
	if(isset($product_image)) { 
		$product_image = $product_image;
	} else { 
		if(isset($_POST['already_img'])) { 
			$product_image = $_POST['already_img'];
		} else { 
			$product_image = '';
		}
	}
	if(isset($_POST['update_product']) && $_POST['update_product'] == '1') {
		extract($_POST);
		if($product_image != '') { 
			$product_image = $product_image;
		} else { 
			$product_image = $already_img;
		}
		$message = $product->update_product($edit_product,$product_manual_id, $product_name, $product_unit, $category_id, $product_expiry_date, $tax_id, $product_cost, $product_selling_price, $alert_units, $product_image, $product_description);
	}
}//update user submission.

	//setting level data if updating or editing.
	if(isset($_POST['edit_product'])) {
		$product->set_product($_POST['edit_product']);	
	} //level set ends here
	
	if(isset($_POST['add_product'])) {
		$add_product = $_POST['add_product'];
		if($add_product == '1') { 
			extract($_POST);
			$message = $product->add_product($product_manual_id, $product_name, $product_unit, $category_id, $product_expiry_date, $tax_id, $product_cost, $product_selling_price, $alert_units, $product_image, $product_description);
		}
	}//isset add level
	
	if(isset($_POST['edit_product'])){ $page_title = 'Edit Product'; } else { $page_title = 'Add Product';}; //You can edit this to change your page title.
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
                        <label class="control-label">Product Unique ID*<small>Barcode supported</small></label>
                        <input type="text" class="form-control" name="product_manual_id" placeholder="Product Unique Id or barcode" value="<?php echo $product->product_manual_id; ?>" required="required" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Product Name*</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Product Name" value="<?php echo $product->product_name; ?>" required="required" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Product Unit</label>
                            <input type="text" class="form-control" name="product_unit" placeholder="Product Unit eg. QTY, KG" value="<?php echo $product->product_unit; ?>" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Product Category*</label>
                            <select name="category_id" style="width:100%" class="autofill">
                            	<option value="">Select Category</option>
                                <?php $product_category->category_options($product->category_id); ?>
                            </select>
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Product Tax*</label>
                            <select name="tax_id" style="width:100%" class="autofill">
                            	<option value="">Select Tax</option>
                                <?php $ProductTax->tax_options($product->tax_id); ?>
                            </select>
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Product Cost</label>
                            <input type="text" class="form-control" name="product_cost" placeholder="Product Cost" value="<?php echo $product->product_cost; ?>" required="required" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Product Selling Price</label>
                            <input type="text" class="form-control" name="product_selling_price" placeholder="Product Selling Price" value="<?php echo $product->product_selling_price; ?>" />
                      </div>

                      <div class="form-group">
                        	<label class="control-label">Product Expiry Date</label>
                            <input type="text" name="product_expiry_date" class="form-control datepick" readonly="readonly" value="<?php if ($product->product_expiry_date == ''){ echo date('Y-m-d');} else{ echo $product->product_expiry_date;} ?>" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Alert Units</label>
                            <input type="text" class="form-control" name="alert_units" placeholder="Product Alert units" value="<?php echo $product->alert_units; ?>" required="required" />
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Product Image</label>
                            <div class="clearfix"></div>
                           	<input type="file" class="pull-left" name="product_image" placeholder="Your product image" />
                            	<?php
									if(isset($product->product_image) && $product->product_image != '') {
										echo '<a href="'.$product->product_image.'" target="_blank"><img src="'.$product->product_image.'" height="80" class="pull-left img-thumbnail" style="height:80px;" /></a><input type="hidden" name="already_img" value="'.$product->product_image.'">';	
									}
								?>
                                <div class="clearfix"></div>
                        </div>
                      
                     <div class="form-group">
                        	<label class="control-label">Product Description</label>
                            <textarea class="form-control" placeholder="Product description" name="product_description"><?php echo $product->product_description; ?></textarea>
                      </div>
						<?php 
						if(isset($_POST['edit_product'])){ 
							echo '<input type="hidden" name="edit_product" value="'.$_POST['edit_product'].'" />';
							echo '<input type="hidden" name="update_product" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_product" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_product'])){ echo 'Update Product'; } else { echo 'Add Product';} ?>" />
                    </form>
                    <script>
						$(document).ready(function() {
							// validate the register form
							$("#add_category").validate();
						});
                    </script>
                    <script src="js/jquery-1.11.2.min.js"></script>
        			<script src="js/bootstrap-datepicker.js"></script>
                   </div><!--left-side-form ends here.-->
                   
<?php
	require_once("includes/footer.php");
?>