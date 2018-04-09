<?php
	include('../system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
		
	if(partial_access('admin') || $store_access->have_module_access('sales')) {} else { 
		HEADER('LOCATION: ../store.php?message=products');
	}
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: ../stores.php?message=1');
	} //select company redirect ends here.
?>	
<html>
	<head>
    	<title>Sale invoice</title>
        <link rel="stylesheet" type="text/css" media="all" href="reports.css" />
    	<style type="text/css">
        	.pos_report_container { 
				width:300px;
				margin:auto;	
			}
			h3 { 
				text-align:center;
				font-size:15px;	
			}
			p.phone, .invoicetable { 
				  font-family: Arial, Helvetica, sans-serif;
  				  font-size: 12px;	
				  text-align:center;
			}
			.invoicetable {margin-top:15px;}
			.lefttd {text-align:left;width:140px;} 
			.righttd {text-align:right;width:140px;}
			table { font-size:12px;}
			table .header th {border-bottom:1px solid #000;}
			table .header th, table td {padding:3.5px;}
			.item_detail .total, .item_detail .tax, .item_detail .qty, .item_detail .price {text-align:right;}
        </style>
    </head>
    
    <body>
    
    	<div class="pos_report_container">
        	<?php 
				$store_logo = $new_store->get_store_info($_SESSION['store_id'], 'store_logo');
				if($store_logo != '') {
					echo "<center><img src='../".$store_logo."' width='280px' /></center>";	
				} ?>
			<!--	<h3><?php echo $new_store->get_store_info($_SESSION['store_id'], 'store_name'); ?></h3>-->
				<p class="phone"><?php echo $new_store->get_store_info($_SESSION['store_id'], 'address1'); ?> <?php echo $new_store->get_store_info($_SESSION['store_id'], 'address2'); ?> <?php echo $new_store->get_store_info($_SESSION['store_id'], 'city'); ?> <?php echo $new_store->get_store_info($_SESSION['store_id'], 'state'); ?> <?php echo $new_store->get_store_info($_SESSION['store_id'], 'country'); ?> <br>Call: <?php echo $new_store->get_store_info($_SESSION['store_id'], 'phone'); ?><br> Email: <?php echo $new_store->get_store_info($_SESSION['store_id'], 'email'); ?></p>
        <?php $mysqldate = strtotime($sale->get_sale_info($_GET['sale_id'], 'datetime')); ?>
        <?php $agent_id = $sale->get_sale_info($_GET['sale_id'], 'agent_id'); ?>
        <?php $client_id = $sale->get_sale_info($_GET['sale_id'], 'client_id'); ?>
        	  <table class="invoicetable">
              		<tr>
                    	<td class="lefttd">Date: <?php echo date('d-M-Y', $mysqldate); ?></td>
                        <td class="righttd">S.INV # : <?php echo $_GET['sale_id']; ?></td>
                    </tr>
                    
                    <tr>
                    	<td class="lefttd"><!--Agent: <?php echo $user->get_user_info($agent_id, 'first_name').' '.$user->get_user_info($agent_id, 'last_name'); ?>--></td>
                        <td class="righttd">Payment: <?php echo $sale->get_sale_info($_GET['sale_id'], 'payment_status'); ?></td>
                    </tr>
                    <tr>
                    	<td class="lefttd">Customer: <?php echo $client->get_client_info($client_id, 'full_name'); ?></td>
                        <td class="righttd">Balance: <?php echo currency_format($client->get_client_balance($client_id)); ?></td>
                    </tr>
              </table>
              <?php $invoice_detail = $sale->view_sale_invoice($_GET['sale_id'], 'pos_invoice'); ?>
              <!--work here.-->
              	<table class="item_detail" width="100%" align="center" cellpadding="0" cellspacing="0">
                	<tr class="header">
                    	<th style="width:10px !important;">#</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Tax</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                    <?php echo $invoice_detail['rows']; ?>
                </table>
              <!--work here.-->
    
<table width="95%" align="right" cellspacing="0" style="margin-top:5px; text-align:right;margin-bottom:5px;" cellpadding="5" border="0px">
        		<tr>
                	<td><strong>Total:</strong> <?php echo $new_store->get_store_info($_SESSION['store_id'], 'currency'); ?> <?php echo currency_format($invoice_detail['grand_total']); ?> </td></tr>
                    <tr>
                    <td><strong>Received:</strong> <?php echo $new_store->get_store_info($_SESSION['store_id'], 'currency'); ?> <?php echo currency_format($invoice_detail['received_amount']); ?> </td></tr>
                    <tr><td><strong>Balance:</strong>   <?php echo $new_store->get_store_info($_SESSION['store_id'], 'currency'); ?> <?php echo currency_format($invoice_detail['grand_total']-$invoice_detail['received_amount']); ?></td>
                </tr>
                </table>

      <p style="text-align:center;font-size:12px; margin-top:20px;">This is computer generated Invoice does not need Signature.</p>      
        </div><!--reportContainer Ends here.-->
    </body>
</html>