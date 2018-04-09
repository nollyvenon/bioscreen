<?php
//Notes Class

class LabScientist {
	public $laboratorist_id;
	public $laboratorist_manual_id;
	public $laboratorist_name;
	public $business_title;
	public $mobile;
	public $phone;
	public $address;
	public $city;
	public $state;
//	public $zipcode;
	public $country;
	public $email;
	public $sex;
	public $notes;

	
	function get_lab_scientist_info($laboratorist_id, $term) { 
		global $db;
		$query = "SELECT * from laboratorist WHERE laboratorist_id='".$laboratorist_id."'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		return $row[$term];
	}//get user email ends here.
	
	function add_lab_scientist($laboratorist_manual_id, $laboratorist_name, $business_title, $phone, $address, $city, $state, $country, $email) {
		global $db;
		$query = "SELECT * from laboratorist WHERE laboratorist_name='".$laboratorist_name."' AND store_id='".$_SESSION['store_id']."'";
		$result = $db->query($query) or die($db->error);
		$num_rows = $result->num_rows;
		
		if($num_rows > 0) { 
			return 'A lab scientist with same name already exists.';
		} else { 
			$query = "INSERT into laboratorist(laboratorist_manual_id, laboratorist_name, business_title, phone, address, city, state, country, email, store_id)
				VALUES('".$laboratorist_manual_id."', '".$laboratorist_name."', '".$business_title."','".$phone."', '".$address."', '".$city."', '".$state."', '".$country."', '".$email."', '".$_SESSION['store_id']."')
			";
			$result = $db->query($query) or die($db->error);
			$_SESSION['cn_id'] = $db->insert_id;
			return 'Lab Scientist added successfuly.';
		}
	}//add warehouse ends here.
	
	function set_lab_scientist($laboratorist_id) { 
		global $db;
		$query = 'SELECT * from laboratorist WHERE laboratorist_id="'.$laboratorist_id.'" AND store_id="'.$_SESSION['store_id'].'"';
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		extract($row);
		$this->laboratorist_id = $laboratorist_id;
		$this->laboratorist_manual_id = $laboratorist_manual_id;
		$this->laboratorist_name = $laboratorist_name;
		$this->business_title = $business_title;
		$this->phone = $phone;
		$this->address = $address;
		$this->city = $city;
		$this->state = $state;
		$this->zipcode = $zipcode;
		$this->country = $country;
		$this->email = $email;
		$this->notes = $notes;
	}//Set Warehouse ends here..
	
	function update_lab_scientist($edit_lab_scientist, $laboratorist_manual_id, $laboratorist_name, $business_title, $phone, $address, $city, $state, $country, $email) { 
		global $db;
		$query = 'UPDATE laboratorist SET
				  laboratorist_manual_id = "'.$laboratorist_manual_id.'",
				  laboratorist_name = "'.$laboratorist_name.'",
				  business_title = "'.$business_title.'",
				  phone = "'.$phone.'",
				  address = "'.$address.'",
				  email = "'.$email.'",
				  city = "'.$city.'",
				  state = "'.$state.'",
				  country = "'.$country.'"
				   WHERE laboratorist_id="'.$edit_lab_scientist.'" AND store_id="'.$_SESSION['store_id'].'"';
		$result = $db->query($query) or die($db->error);
		return 'Lab Scientist updated Successfuly!';
	}//update user level ends here.	
	
	function list_laboratorist() {
		global $db;
		$query = 'SELECT * from laboratorist WHERE store_id="'.$_SESSION['store_id'].'" ORDER by laboratorist_name ASC';
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
			$content .= $laboratorist_id;
			$content .= '</td><td>';
			$content .= $laboratorist_name;
			$content .= '</td><td>';
			$content .= $business_title;
			$content .= '</td><td>';
			$content .= $email;
			$content .= '</td><td>';
			$content .= $phone;
			$content .= '</td><td>';
			$content .= $address.' '.$city.' '.$state.' '.$country;
			if(partial_access('admin')) {
			$content .= '<td><form method="post" name="edit" action="manage_lab_scientist.php">';
			$content .= '<input type="hidden" name="edit_lab_scientist" value="'.$laboratorist_id.'">';
			$content .= '<input type="submit" class="btn btn-default btn-sm" value="Edit">';
			$content .= '</form>';
			$content .= '</td><td>';
			$content .= '<form method="post" name="delete" onsubmit="return confirm_delete();" action="">';
			$content .= '<input type="hidden" name="delete_lab_scientist" value="'.$laboratorist_id.'">';
			$content .= '<input type="submit" class="btn btn-default btn-sm" value="Delete">';
			$content .= '</form>';
			$content .= '</td>';
			}
			$content .= '</tr>';
			unset($class);
		}//loop ends here.	
	echo $content;
	}//list_notes ends here.
	
	function delete_lab_scientist($laboratorist_id) { 
		global $db;
		$query = "SELECT * FROM laboratorist_log WHERE laboratorist_id='".$laboratorist_id."'";
		$result = $db->query($query) or die($db->error);
		$num_rows = $result->num_rows;
		
		if($num_rows > 0) { 
			return 'Please delete sale invoices, receivings, return invoices, return payments for related lab_scientist first.';
		} else { 
			$query = "DELETE FROM laboratorist WHERE laboratorist_id='".$laboratorist_id."'";
			$result = $db->query($query) or die($db->error);
			return 'Lab Scientist deleted successfuly!';
		}
	}//delete lab_scientist ends here.
	
	function add_log($datetime, $laboratorist_id, $transaction_type, $type_table_id) {
		global $db;
		$query = "INSERT into laboratorist_log(laboratorist_log_id, datetime, laboratorist_id, transaction_type, type_table_id, store_id) VALUES(NULL, '".$datetime."', '".$laboratorist_id."', '".$transaction_type."', '".$type_table_id."', '".$_SESSION['store_id']."')";	
		$result = $db->query($query) or die($db->error);
		return $db->insert_id;
	}//add log ends here.

	
	function lab_scientist_options($laboratorist_id) {
		global $db;
		$query = 'SELECT * from laboratorist WHERE store_id="'.$_SESSION['store_id'].'" ORDER by laboratorist_name ASC';
		$result = $db->query($query) or die($db->error);
		$options = '';
		if($laboratorist_id != '') { 
			while($row = $result->fetch_array()) { 
				if($laboratorist_id == $row['laboratorist_id']) {
				$options .= '<option selected="selected" value="'.$row['laboratorist_id'].'">'.$row['laboratorist_name'].' ('.$row['mobile'].')</option>';
				} else { 
				$options .= '<option value="'.$row['laboratorist_id'].'">'.$row['laboratorist_name'].' ('.$row['mobile'].')</option>';
				}
			}
		} else { 
			while($row = $result->fetch_array()) { 
				$options .= '<option value="'.$row['laboratorist_id'].'">'.$row['laboratorist_name'].' ('.$row['mobile'].')</option>';
			}
		}
		return $options;
		
		 
	}//vendor options ends here.
		
}//class ends here.