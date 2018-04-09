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
	$sample = new Sample;
		
	if(partial_access('admin') || $store_access->have_module_access('sales')) {} else { 
		HEADER('LOCATION: ../store.php?message=products');
	}
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: ../stores.php?message=1');
	} //select company redirect ends here.
?>	
<html>
	<head>
    	<title>Sample Results</title>
        <link rel="stylesheet" type="text/css" media="all" href="reports.css" />
    </head>
    
    <body>
    	<div id="reportContainer">
        	<table width="100%" cellpadding="10px" border="0px">
            	<tr>
                	<td style="text-align:left;">
                    	<h2 style="color:#09F;"><?php echo $store->get_store_info($_SESSION['store_id'], 'store_name'); ?></h2>
                        <p class="phone">Phone: <?php echo $store->get_store_info($_SESSION['store_id'], 'phone'); ?><br />
                        Address: <?php echo $store->get_store_info($_SESSION['store_id'], 'address1'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'address2'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'city'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'state'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'country'); ?><br>
						Email: <?php echo $store->get_store_info($_SESSION['store_id'], 'email'); ?>
                        </p>
                    </td>
                    <td style="text-align:right;">
                        <?php $mysqldate = strtotime($sample->get_sample_info($_GET['sample_id'], 'date_taken')); ?>
                        <p>Date: <?php echo date('d-M-Y', $mysqldate); ?><br />
                        S.INV # : <?php echo $_GET['sample_id']; ?><br />
                        <?php 
						$laboratorist_id = $sample->get_sample_info($_GET['sample_id'], 'lab_scientist'); 
						 ?>
						<!--Lab Scientist: <?php echo $sample->get_laboratorist_info($laboratorist_id, 'laboratorist_name'); ?><br>
						Payment Type: <?php echo $sample->get_sample_info($_GET['sample_id'], 'pay_status'); ?>-->
                        </p>
                        
                    </td>
                </tr>
            </table>
                                	<h1 style="color:#CCC; text-align:center">Sample Results</h1>

<table width="50%" border="1px" cellspacing="0" cellpadding="5px">
	<tr>
    	<td bgcolor="#666666"><strong style="color:#FFF;">Client</strong></td>
    </tr>
    <tr>
    	<td>
        <?php $client_id = $sample->get_sample_info($_GET['sample_id'], 'client_id'); ?>        
        <table width="100%" border="0">
          <tr>
    <td width="42%">Name: <?php echo $client->get_client_info($client_id, 'full_name') ; ?></td>
    <td width="4%">&nbsp;</td>
    <td width="54%">Address: <?php echo $client->get_client_info($client_id, 'address'); ?></td>
  </tr>
  <tr>
    <td>Age : <?php echo $client->get_client_info($client_id, 'age'); ?></td>
    <td>&nbsp;</td>
    <td> Phone # : <?php echo $client->get_client_info($client_id, 'phone'); ?></td>
  </tr>
  <tr>
    <td>Sex: <?php echo $client->get_client_info($client_id, 'sex'); ?></td>
    <td>&nbsp;</td>
    <td>Lab No: <?php echo $sample->get_sample_info($_GET['sample_id'], 'sample_manual_id'); ?></td>
  </tr>
</table>

      </td>
    </tr>
</table><br />

<table width="100%" cellpadding="5px" cellspacing="0" align="right">
	<tr>
        <td width="350px" valign="top" style="text-align:right;">
        	<table width="95%" align="left" cellspacing="0" style="margin-top:5px;" cellpadding="5" border="0px">
            	<tr><th>Sample Name: </th><td> <?php echo $sample->get_sample_info($_GET['sample_id'], 'sample_name'); ?></td></tr>
        		<tr>
                	<th>Sample Description: </th><td><?php echo $sample->get_sample_info($_GET['sample_id'], 'sample_description'); ?></td></tr>
                <tr><th>Sample Unit:</th><td> <?php echo $sample->get_sample_info($_GET['sample_id'], 'sample_unit'); ?></td></tr>
                   <tr> <th>Pay Status: </th><td><?php echo $sample->get_sample_info($_GET['sample_id'], 'pay_status'); ?></td></tr>
                   <tr> <th>Result: </th><td><?php echo $sample->get_sample_info($_GET['sample_id'], 'sample_result'); ?></td></tr>
                   <?php
				  $sample_type =  $sample->get_sample_info($_GET['sample_id'], 'sample_type');
				  
				   ?>
                   <tr> <th>Sample Type: </th><td><?php echo $sample->get_sample_type_info($sample_type, 'sample_type_name'); ?></td></tr>
                   <tr> <th>Date of Sample: </th><td><?php echo $sample->get_sample_info($_GET['sample_id'], 'date_taken'); ?></td></tr>
                   <tr> <th>Date of Result: </th><td><?php echo $sample->get_sample_info($_GET['sample_id'], 'result_taken'); ?></td></tr>
                   <tr> <th>Comment: </th><td><?php echo $sample->get_sample_info($_GET['sample_id'], 'comment'); ?></td></tr>
                </table>
        </td>
    </tr>
</table>
<div style="clear:both;"></div>

      <p style="text-align:center; margin-top:20px;">&nbsp;</p>
      <p style="text-align:center; margin-top:20px;">This is computer generated Result Slip does not need Signature.</p>      
        </div><!--reportContainer Ends here.-->
    </body>
</html>