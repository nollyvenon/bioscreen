<?php
//Purchase Class

class Sale { 

	function get_sale_info($sale_id, $term) { 
		global $db;
		$query = "SELECT * from sales WHERE sale_id='".$sale_id."'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		return $row[$term];
	}//get user email ends here.
	
	//add purchase functions starts here.
	function add_sale($datetime, $custom_inv_no, $memo, $client_id, $payment_method) { 
		global $db;
		
		$query = "INSERT into sales(sale_id, datetime, manual_inv_no, memo, client_id, payment_status, store_id, agent_id) VALUES(NULL, '".$datetime."', '".$custom_inv_no."', '".$memo."', '".$client_id."', '".$payment_method."', '".$_SESSION['store_id']."', '".$_SESSION['user_id']."')";
		$result = $db->query($query) or die($db->error);
		return $db->insert_id;
	}//add_purchase ends here. returns purchase id.
	//add purchase functions ends here.
	
	function add_creditor($receiveable, $received, $client_id) { 
		global $db;
		
		$query = "INSERT into creditors(credit_id, receiveable, received, client_id, store_id) VALUES(NULL, '".$receiveable."', '".$received."', '".$client_id."', '".$_SESSION['store_id']."')";
		$result = $db->query($query) or die($db->error);
		return $db->insert_id;
	}//add_credit ends here.
	
	function add_inventory($inn, $out_inv, $product_id, $warehouse_id) {
		global $db;
		$query = "INSERT into inventory(inventory_id, inn, out_inv, store_id, product_id, warehouse_id) VALUES(NULL, '".$inn."', '".$out_inv."', '".$_SESSION['store_id']."', '".$product_id."', '".$warehouse_id."')";
		$result = $db->query($query) or die($db->error);
		return $db->insert_id;	
	}//add inventory function ends here.
	
	function add_price($cost, $selling_price, $tax, $product_id) {
		global $db;	
		$query = "INSERT into price(price_id, cost, selling_price, tax, store_id, product_id) VALUES(NULL, '".$cost."', '".$selling_price."', '".$tax."', '".$_SESSION['store_id']."', '".$product_id."')";
		$result = $db->query($query) or die($db->error);
		return $db->insert_id;
	}//add price table ends here.
	
	function add_sale_detail($sale_id, $price_id, $inventory_id, $creditor_id) {
		global $db;	
		$query = "INSERT into sale_detail(sale_detail_id, sale_id, store_id, price_id, inventory_id, credit_id) VALUES(NULL, '".$sale_id."', '".$_SESSION['store_id']."', '".$price_id."', '".$inventory_id."', '".$creditor_id."')";
		$result = $db->query($query) or die($db->error);
		return $db->insert_id;
	}//add purchase detail function ends here.	
	
	function view_sale_invoice($sale_id, $type) {
		global $db;
		
		/*Products Detail.*/
		$sale_detail_query = "SELECT * from sale_detail WHERE sale_id='".$sale_id."' AND store_id='".$_SESSION['store_id']."'";
		$sale_detail_result = $db->query($sale_detail_query) or die($db->error);
	
		$grandTotal = 0;
		$received = 0;
		$rows = '';
		$counter = 1;
		while($sale_detail_row = $sale_detail_result->fetch_array()) { 
			$price_id = $sale_detail_row['price_id'];
			$inventory_id = $sale_detail_row['inventory_id'];
			$credit_id = $sale_detail_row['credit_id'];
		
			$inventoryQuery = "SELECT * from inventory WHERE inventory_id='".$inventory_id."'";
			$inventoryResult = $db->query($inventoryQuery) or die($db->error);
			$inventoryRow = $inventoryResult->fetch_array();
			$qty = $inventoryRow['out_inv'];
			$product_id = $inventoryRow['product_id'];
			
			$pductQuery = "SELECT * from products WHERE product_id='".$product_id."'";
			$productResult = $db->query($pductQuery) or die($db->error);
			$productRow = $productResult->fetch_array();
			
			$pId = $productRow['product_manual_id'];
			$pName = $productRow['product_name'];
		
			$priceQuery = "SELECT * from price WHERE price_id='".$price_id."'";
			$priceResult = $db->query($priceQuery) or die($db->error);
			$priceRow = $priceResult->fetch_array();
		
			$creditQuery = "SELECT * from creditors WHERE credit_id='".$credit_id."'";
			$creditResult = $db->query($creditQuery) or die($db->error);
			$creditRow = $creditResult->fetch_array();
		
			$price = $priceRow['selling_price'];
			$tax = $priceRow['tax'];
			$grandTotal += ($price*$qty)+($tax*$qty);
			$received += $creditRow['received'];
				
			$rows .= "<tr><td>";
			if($type == 'pos_invoice') { 
			$rows .= $counter;
			} else { 
			$rows .= $pId;
			}
			$rows .= "</td><td>";
			$rows .= $pName;
			$rows .= "</td><td class='price'>";
			$rows .= $price;
			$rows .= "</td><td class='qty'>";
			$rows .= $qty;
			$rows .= "</td><td class='tax'>";
			$rows .= $tax;
			$rows .= "</td><td class='total'>";
			$rows .= currency_format((($qty*$price)+($tax*$qty)));
			$rows .= "</td></tr>";
			$counter++;
		}
		$return_message = array(
			"rows" => $rows,
			"grand_total" => $grandTotal,
			"received_amount" => $received
		);
		return $return_message;
	}//view purchase invoice ends here.
	
	function list_all_sales() { 
		global $db;
		
		$query = "SELECT * from sales WHERE store_id='".$_SESSION['store_id']."' ORDER by sale_id DESC";
		$result = $db->query($query) or die($db->error);
		
		$content = '';
		while($row = $result->fetch_array()) {
			extract($row);
			
			$users = new Users;
			$agent_name = $users->get_user_info($agent_id, 'first_name').' '.$users->get_user_info($agent_id, 'last_name');
			
			$clients = new Client;
			$client_name = $clients->get_client_info($client_id, 'full_name');
			
			$sale_detail = "SELECT * from sale_detail WHERE sale_id='".$sale_id."'";
			$sale_detail_result = $db->query($sale_detail) or die($db->error);
			
			$receiveable = 0;
			$received = 0;
			$items = 0;
			
			while($sale_detail_row = $sale_detail_result->fetch_array()) {
				$inventory_id = $sale_detail_row['inventory_id'];
				$creditor_id = $sale_detail_row['credit_id'];
				
				//Inventory q?uery.
				$inventory_query = "SELECT * from inventory WHERE inventory_id='".$inventory_id."'";
				$inventory_result = $db->query($inventory_query) or die($db->error);
				$inventory_row = $inventory_result->fetch_array();
				
				$items += $inventory_row['out_inv'];
				
				//Inventory q?uery.
				$credit_query = "SELECT * from creditors WHERE credit_id='".$creditor_id."'";
				$credit_result = $db->query($credit_query) or die($db->error);
				$credit_row = $credit_result->fetch_array();
				
				$receiveable += $credit_row['receiveable'];
				$received += $credit_row['received'];
					
			}//purchase detail loop.
			
			$content .= '<tr><td>';
			$content .= $sale_id;
			$content .= '</td><td>';
			$datetime = strtotime($datetime);
			$content .= date('d-m-Y', $datetime);
			$content .= '</td><td>';
			$content .= $agent_name;
			$content .= '</td><td>';
			$content .= $client_name;
			$content .= '</td><td>';
			$content .= $manual_inv_no;
			$content .= '</td><td>';
			$content .= $memo;
			$content .= '</td><td>';
			$content .= $payment_status;
			$content .= '</td><td>';
			$content .= $items;
			$content .= '</td><td>';
			$content .= ($receiveable);
			$content .= '</td><td>';
			$content .= ($received);
			$content .= '</td><td>';
			$content .= '<a href="reports/view_sale_invoice.php?sale_id='.$sale_id.'" target="_blank">View</a>';
			$content .= '</td>';
				if(partial_access('admin')) { 
				$content .= '<td><form method="post" name="delete" onsubmit="return confirm_delete();" action="">';
				$content .= '<input type="hidden" name="delete_sale" value="'.$sale_id.'">';
				$content .= '<input type="submit" class="btn btn-default btn-sm" value="Delete">';
				$content .= '</form>';
				$content .= '</td>'; }
				$content .= '</tr>';	
		}//main_while loop
		echo $content;
	}//list_all purchases function ends here.
	
	function sale_graph_data() { 
		global $db;
		$query = "SELECT * FROM sales WHERE datetime > DATE_SUB(NOW(), INTERVAL 1 MONTH) AND store_id='".$_SESSION['store_id']."'";
		$result = $db->query($query) or die($db->error);

		$date_set = '';
		$daily_sale = 0;
		$today = '';
		while($row = $result->fetch_array()) {
			extract($row);
			$sale_detail = "SELECT * from sale_detail WHERE sale_id='".$sale_id."'";
			$sale_detail_result = $db->query($sale_detail) or die($db->error);
			$receiveable = 0;
			while($sale_detail_row = $sale_detail_result->fetch_array()) {
				$creditor_id = $sale_detail_row['credit_id'];
				//Inventory q?uery.
				$credit_query = "SELECT * from creditors WHERE credit_id='".$creditor_id."'";
				$credit_result = $db->query($credit_query) or die($db->error);
				$credit_row = $credit_result->fetch_array();
				
				$receiveable += $credit_row['receiveable'];
			}//purchase detail loop.
			
			$datetime = strtotime($datetime);
			$date_pr = date('Y-m-d', $datetime);
			$daily_sale = $receiveable; 
			$today = $date_pr;
			$content[] = Array(
				"date" => $today,
				"total" => $daily_sale
			);
		}//main_while loop
		
		$new_arr = array();
		array_walk($content,function ($v,$k) use(&$new_arr) {
    		array_key_exists($v['date'],$new_arr) ? $new_arr[$v['date']] = $new_arr[$v['date']]+$v['total'] : $new_arr[$v['date']]=$v['total'];
});
	$js_arr = '';
	foreach($new_arr as $key => $value) { 
		if($js_arr != '') { 
			$js_arr .= ', ';
		}
		$js_arr .= '["'.$key.'", '.$value.']';
	}
	echo $js_arr;
}//list_all purchases function ends here.
		
	
	function delete_sale($sale_id) {
		global $db;
		
		$query = "DELETE FROM sales WHERE sale_id='".$sale_id."'";
		$result = $db->query($query) or die($db->error);
		
		$query = "SELECT * from sale_detail WHERE sale_id='".$sale_id."'";
		$result_detail = $db->query($query) or die($db->error);	
		
		while($row = $result_detail->fetch_array()) { 
			extract($row);
			
			$delete[] = "DELETE FROM price WHERE price_id='".$price_id."'";
			$delete[] = "DELETE FROM inventory WHERE inventory_id='".$inventory_id."'";
			$delete[] = "DELETE FROM creditors WHERE credit_id='".$credit_id."'";
			
			foreach($delete as $query) { 
				$result = $db->query($query) or die($db->error);
			}
		}//main loop ends here.
		$delete = "DELETE FROM sale_detail WHERE sale_id='".$sale_id."'";
		$result = $db->query($delete) or die($db->error);
		
		$delete = "DELETE FROM customer_log WHERE transaction_type='Sale Invoice' AND type_table_id='".$sale_id."'";
		$result = $db->query($delete) or die($db->error);
		
		$delete = "DELETE FROM customer_log WHERE transaction_type='Cash Sale' AND type_table_id='".$sale_id."'";
		$result = $db->query($delete) or die($db->error);
		
		return "Sale was deleted successfuly.";
	}//delete_sale ends here.
	
}//Purchase Class Ends here.