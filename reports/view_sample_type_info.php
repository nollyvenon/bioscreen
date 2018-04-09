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
		
	if(partial_access('admin') || $store_access->have_module_access('sample')) {} else { 
		HEADER('LOCATION: ../store.php?message=sample');
	}
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: ../stores.php?message=1');
	} //select company redirect ends here.
?>	
<html>
	<head>
    	<title>View Sample Type</title>
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
                    	<h1 style="color:#CCC;">Sample Type Info</h1>
                        <?php $mysqldate = strtotime($sample->get_sample_type_info($_GET['sample_type_id'], 'timestamp')); ?>
                        <p>Date: <?php echo date('d-M-Y', $mysqldate); ?><br />
                        Manual # : <?php echo $_GET['sample_type_id']; ?><br />
                        <?php 				$users = new Users;
						$user_id = $sample->get_sample_type_info($_GET['sample_type_id'], 'user_id');
						$full_name = $users->get_user_info($user_id, 'first_name').' '.$users->get_user_info($user_id, 'last_name'); ?>
                        </p>
                        
                    </td>
                </tr>
            </table>
            <br />
<table width="45%" border="1px" cellspacing="0" cellpadding="5px">
	<tr>
    	<td bgcolor="#666666"><strong style="color:#FFF;">Info</strong></td>
    </tr>
    <tr>
    	<td>
        <?php $client_id = $sample->get_sample_type_info($_GET['sample_type_id'], 'user_id'); ?>
    	<h4>Poster: <?php echo $users->get_user_info($user_id, 'first_name').' '.$users->get_user_info($user_id, 'last_name'); ?></h4>
        <p>Sample Name: <?php echo $sample->get_sample_type_info($_GET['sample_type_id'], 'sample_type_name'); ?></p>
         <p>Sample Description: <?php echo $sample->get_sample_type_info($_GET['sample_type_id'], 'sample_type_description'); ?></p>
         <p>Status: <?php echo $sample->get_sample_type_info($_GET['sample_type_id'], 'status'); ?></p>
        </td>
    </tr>
</table><br />

<div style="clear:both;"></div>

      <p style="text-align:center; margin-top:20px;">This is computer generated Slip does not need Signature.</p>      
        </div><!--reportContainer Ends here.-->
    </body>
</html>