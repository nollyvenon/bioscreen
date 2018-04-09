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
        <style type="text/css">
        #apDiv1 {
	position: absolute;
	width: 200px;
	height: 115px;
	z-index: 1;
}
        #apDiv2 {
	position: absolute;
	width: 144px;
	height: 61px;
	z-index: 1;
	left: 732px;
	top: 219px;
}
        </style>
	</head>
    
    <body topmargin="0">
<!--    	<div id="reportContainer">-->
        	<table width="151%" cellpadding="10px" border="0px">
            	<tr>
                	<td width="98%" height="130" valign="top" style="text-align:left;">
                    	
                    	<table width="101%" border="0">
                    	  <tr>
                    	    <td width="12%" valign="top"><span style="color:#09F; "><img src="../upload/f375d5712f33b40fIMG-20160217-WA000.jpg" width="189" height="110"></span></td>
                    	    <td width="88%"><SPAN style="color:#09F; "><?php echo $store->get_store_info($_SESSION['store_id'], 'store_name'); ?></span>
                            <p style="font-size:20px;" class="phone"><span style="color:#F86C49; ">A Medical Laboratory offering a full range of Laboratory Services</span><br><span style="color:#0C0; font-weight:bold">Phone:</span>&emsp; <?php echo $store->get_store_info($_SESSION['store_id'], 'phone'); ?><br />
                       <span style="color:#0C0; font-weight:bold"> Address:</span>&nbsp;  <?php echo $store->get_store_info($_SESSION['store_id'], 'address1'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'address2'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'city'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'state'); ?> <?php echo $store->get_store_info($_SESSION['store_id'], 'country'); ?><br>
						<span style="color:#0C0; font-weight:bold">Email:</span>&emsp; &nbsp;  <?php echo $store->get_store_info($_SESSION['store_id'], 'email'); ?><br><span style="color:#0C0; font-weight:bold">Website:</span> <?php echo $store->get_store_info($_SESSION['store_id'], 'website'); ?>
                        </p></td>
                  	    </tr>
                  	  </table>
                        
                    </td>
                    <td width="2%" style="font-size:13px">
                       
                        
                    </td>
                </tr>
            </table>
        	<!--<div id="apDiv2"> <?php $mysqldate = strtotime($sample->get_sample_info($_GET['sample_id'], 'date_taken')); ?>
                        Date: <?php echo date('d-M-Y', $mysqldate); ?><br />
                        S.INV # : <?php echo $_GET['sample_id']; ?><br />
                        <?php 
						$laboratorist_id = $sample->get_sample_info($_GET['sample_id'], 'lab_scientist'); 
						 ?>
						<!--Lab Scientist: <?php echo $sample->get_laboratorist_info($laboratorist_id, 'laboratorist_name'); ?><br>
						Payment Type: <?php echo $sample->get_sample_info($_GET['sample_id'], 'pay_status'); ?>
                        </p></div>-->
<h1 style="color:#0C0; text-align:center">Sample Results</h1>

<table width="50%" border="1px" cellspacing="0" cellpadding="5px">
	<tr>
    	<td bgcolor="#666666"><strong style="color:#0C0;">Client</strong></td>
    </tr>
    <tr>
    	<td>
        <?php $client_id = $sample->get_sample_info($_GET['sample_id'], 'client_id'); ?>        
        <table width="100%" style="font-size:20px;" border="0">
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
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" cellpadding="5px" cellspacing="0">
	<tr>
      <td width="100%" valign="top" style="text-align:right;"><table  style="font-size:23px;"  width="100%" border="0">
          <tr>
    <td width="62%" height="23"><strong>Investigations</strong></td>
    <td width="2%">&nbsp;</td>
    <td width="36%"><strong>Result</strong></td>
  </tr>
  <tr>
    <td><?php echo $sample->get_sample_info($_GET['sample_id'], 'comment'); ?></td>
    <td>&nbsp;</td>
    <td><?php echo $sample->get_sample_info($_GET['sample_id'], 'sample_result'); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>      <p style=" margin-top:50px;">Lab Scientist: <?php echo $sample->get_laboratorist_info($laboratorist_id, 'laboratorist_name'); ?></p>
      <p style=" font-size:20px; margin-top:50px;">&nbsp;</p>
      <p style=" margin-top:50px;">&nbsp;</p>
      <p style="margin-top:20px;">Signature:</p>      
      <p style="margin-top:40px;">Date:</p> </td>
  </tr>
</table>

      </td>
  </tr>
</table>
<div style="clear:both;"></div>

     
        </div><!--reportContainer Ends here.-->
    </body>
</html>