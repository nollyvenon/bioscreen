<?php
//store Class

class Accounts {
	public $store_id;
	public $from_date;
	public $to_date;
	public $trans_type;
	public $address2;
	public $city;
	public $state;
	public $country;
	public $zip_code;
	public $phone;
	public $email;
	public $currency;
	public $store_logo;
	public $description;
	
	function get_store_info($store_id, $term) { 
		global $db;
		$query = "SELECT * from stores WHERE store_id='".$store_id."'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		return $row[$term];
	}//get user email ends here.	
	
	
	function account_name($store_id) { 
		global $db;
		$query = 'SELECT * from sys_accounts WHERE store_id="'.$store_id.'"';
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		return $row['account_name'];
	}//store_info ends here.
		
	function set_account($store_id) { 
		global $db;
		if($_SESSION['user_type'] != 'admin') {
			$query_access = "SELECT * from store_access WHERE user_id='".$_SESSION['user_id']."' AND store_id='".$store_id."'";
			$result_access = $db->query($query_access) or die($db->error);
			$row_num = $result_access->num_rows;
			if($row_num < 0) { 
			echo 'You have no access to this store.';
			exit();
			}
		}
		$query = "SELECT * from sys_accounts WHERE store_id='".$store_id."'"; 
		$result = $db->query($query) or die($db->error);
		if($result->num_rows > 0) {
			$row = $result->fetch_array();
			extract($row);	
			$this->balance = $balance;
			$this->description = $description;
			$this->account = $account;
		} else { 
			echo 'This store does not exist or You cant access this store.';
		}
		
	}//level set ends here.
	
	function update_account($store_id, $balance, $account_name) {
		global $db;
		if($_SESSION['user_type'] != 'admin') {
			exit();
		}//checks admin user.
		$query = 'UPDATE sys_accounts SET
			balance="'.$balance.'",
			account_name="'.$account_name.'",
			WHERE store_id='.$store_id.'
			';	
		$result = $db->query($query) or die($db->error);
		return 'store was updated successfuly!';
		}//update_store function ends here.
		
	function alltransactions() {
			global $db;
			if($_SESSION['user_type'] == 'admin') { 
				$query = 'SELECT * from sys_transactions ORDER by store_id ASC';
				$result = $db->query($query) or die($db->error);
			$content = '';
			$count = 0;
			while($row = $result->fetch_array()) { 
				extract($row);
				$count++;
				if($count%2 == 0) { 
					$class = 'even';
				} else { 
					$class = 'odd';
				}
				$content .= '<tr class="'.$class.'">';
				$content .= '<td>';
				$d=strtotime($date);
				$content .= date('M d, Y',$d);
				$content .= '</td><td>';
				$content .= $account;
				$content .= '</td><td>';
				$content .= $type;
				$content .= '</td><td>';
				$content .= $description;
				$content .= '</td><td>';
				$content .= $amount;
				$content .= '</td><td>';
				$content .= $dr;
				$content .= '</td><td>';
				$content .= $cr;
				$content .= '</td><td>';
				$content .= $bal;
				$content .= '</td></tr>'; 
				unset($class);
			}//loop ends here.
				
			} //if else ends here.
			
		echo $content;
	}//list_levels ends here.
	
		function list_account_statement_ind($store_id, $from_date, $to_date, $trans_type) {
			global $db;
			if($_SESSION['user_type'] == 'admin') { 
	if ($trans_type==""){
		$query = 'SELECT * from sys_transactions WHERE store_id='.$store_id.' AND date > '.$from_date.' AND date < '.$to_date.' ORDER by store_id ASC, id DESC';
	}else {
		$query = 'SELECT * from sys_transactions WHERE store_id='.$store_id.' AND date > '.$from_date.' AND date < '.$to_date.' AND type='.$trans_type.'  ORDER by store_id ASC';
	//	$query = "SELECT * from sys_transactions WHERE store_id='1' AND date > '2016-01-29' AND date < '2016-05-29' AND type='Income'  ORDER by store_id ASC";
	}
	
				$result = $db->query($query) or die($db->error);
			$content = '';
			$count = 0;
			while($row = $result->fetch_array()) { 
				extract($row);
				$count++;
				if($count%2 == 0) { 
					$class = 'even';
				} else { 
					$class = 'odd';
				}
				$content .= '<tr class="'.$class.'">';
				$content .= '<td>';
				$d=strtotime($date);
				$content .= date('M d, Y',$d);
				$content .= '</td><td>';
				$content .= $description;
				$content .= '</td><td>';
				$content .= $dr;
				$content .= '</td><td>';
				$content .= $cr;
				$content .= '</td><td>';
				$content .= $bal;
				$content .= '</td></tr>'; 
				unset($class);
			}//loop ends here.
				
			} //if else ends here.
			
		echo $content;
	}//list_levels ends here.

	
	function store_options() {
		global $db; 
		$query = 'SELECT * from stores ORDER by store_name ASC';
		$result = $db->query($query) or die($db->error);
		
			while($row = $result->fetch_array()) { 
				$options .= '<option value="'.$row['store_id'].'">'.$row['store_manual_id'].' | '.ucfirst($row['store_name']).'</option>';
			}
		echo $options;
	}//store options
}//store class ends here.