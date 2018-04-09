<?php
	include('../system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	$sale = new Sale;
	$store_access = new StoreAccess;
	$store = new Store;
	$user = new Users;
	$client = new Client;
		
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
    </head>
    
    <body>
    	<div id="reportContainer">
        	<table width="100%" cellpadding="10px" border="0px">
            	<tr>
                	<td style="text-align:left;">
                    	<h2><?php echo $store->get_store_info($_SESSION['store_id'], 'store_name'); ?></h2>
                        <p class="phone">Phone: <?php echo $store->get_store_info($_SESSION['store_id'], 'phone'); ?><br />
                        Address: <?php echo $store->get_store_info($_SESSION['store_id'], 'address1'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'address2'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'city'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'state'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'country'); ?><br>
						Email: <?php echo $store->get_store_info($_SESSION['store_id'], 'email'); ?>
                        </p>
                    </td>
                    <td style="text-align:right;">
                    	<h1 style="color:#CCC;">Sale Invoice</h1>
                        <?php $mysqldate = strtotime($sale->get_sale_info($_GET['sale_id'], 'datetime')); ?>
                        <p>Date: <?php echo date('d-M-Y', $mysqldate); ?><br />
                        S.INV # : <?php echo $_GET['sale_id']; ?><br />
                        <?php $agent_id = $sale->get_sale_info($_GET['sale_id'], 'agent_id'); ?>
                        Agent: <?php echo $user->get_user_info($agent_id, 'first_name').' '.$user->get_user_info($agent_id, 'last_name'); ?><br>
						Manual Inv#: <?php echo $sale->get_sale_info($_GET['sale_id'], 'manual_inv_no'); ?><br>
						Payment Type: <?php echo $sale->get_sale_info($_GET['sale_id'], 'payment_status'); ?>
                        </p>
                        
                    </td>
                </tr>
            </table>
            <br />
<table width="45%" border="1px" cellspacing="0" cellpadding="5px">
	<tr>
    	<td bgcolor="#666666"><strong style="color:#FFF;">Client</strong></td>
    </tr>
    <tr>
    	<td>
        <?php $client_id = $sale->get_sale_info($_GET['sale_id'], 'client_id'); ?>
    	<h4><?php echo $client->get_client_info($client_id, 'full_name'); ?></h4>
        <p>Phone # : <?php echo $client->get_client_info($client_id, 'phone'); ?> Mob # : <?php echo $client->get_client_info($client_id, 'mobile'); ?><br />
		Address: <?php echo $client->get_client_info($client_id, 'address'); ?> <?php echo $client->get_client_info($client_id, 'city'); ?> <?php echo $client->get_client_info($client_id, 'state'); ?> <?php echo $client->get_client_info($client_id, 'country'); ?></p>
        <p style="text-align:right; background-color:#CCC; font-weight:bold; padding:2px; width:80%; float:right;">Total Receiveable: <?php echo currency_format($client->get_client_balance($client_id)); ?></p>
        </td>
    </tr>
</table><br />
<?php $invoice_detail = $sale->view_sale_invoice($_GET['sale_id']); ?>
<table width="100%" cellpadding="5px" cellspacing="0" border="1">
	<tr bgcolor="#CCCCCC">
    	<th>Product ID</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Tax</th>
        <th width="75">Total</th>
    </tr>
    <?php echo $invoice_detail['rows']; ?>
    
</table>

<table width="100%" cellpadding="5px" cellspacing="0" align="right">
	<tr>
    	<td>
        	<strong>Memo:</strong><br />
            <div style="width:450px; min-height:70px; border:1px solid #000; padding:5px;"><?php echo $sale->get_sale_info($_GET['sale_id'], 'memo'); ?></div>
			
        </td>
        <td width="350px" valign="top" style="text-align:right;">
        	<table width="95%" align="right" cellspacing="0" style="margin-top:5px;" cellpadding="5" border="1px">
        		<tr>
                	<th>Total</th>
                    <th>Received</tH>
                    <th>Balance</th>
                </tr>
                <tr>
                	<td align="right"><?php echo currency_format($invoice_detail['grand_total']); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'currency'); ?></td>
                    <td align="right"><?php echo currency_format($invoice_detail['received_amount']); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'currency'); ?></td>
                    <td align="right"><?php echo currency_format($invoice_detail['grand_total']-$invoice_detail['received_amount']); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'currency'); ?></td>
                </tr>
                </table>
        </td>
    </tr>
</table>
<div style="clear:both;"></div>

      <p style="text-align:center; margin-top:20px;">This is computer generated Invoice does not need Signature.</p>      
        </div><!--reportContainer Ends here.-->
    </body>
</html>