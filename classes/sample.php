<?php
//sample Class

class Sample {
	public $sample_id;
	public $sample_manual_id;
	public $sample_name;
	public $client_id;
	public $sample_description;
	public $sample_unit;
	public $pay_status;
	public $sample_image;
	public $date_taken;
	public $result_taken;
	public $lab_scientist;
	public $comment;
	public $sample_type;
	public $sample_type_manual_id;
	public $sample_type_name;
	public $sample_type_description;
	
	function set_sample($sample_id) { 
		global $db;
		$query = "SELECT * from samples WHERE sample_id='".$sample_id."' AND store_id='".$_SESSION['store_id']."'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		extract($row);
		
		$this->sample_manual_id = $sample_manual_id;
		$this->sample_name = $sample_name;
		$this->sample_description = $sample_description;
		$this->sample_unit = $sample_unit;
		$this->pay_status = $pay_status;
		$this->client_id = $client_id;
		$this->sample_image = $sample_image;
		$this->lab_scientist = $lab_scientist;
		$this->date_taken = $date_taken;
		$this->result_taken = $result_taken;
		$this->sample_type = $sample_type;
		$this->sample_result = $sample_result;
		$this->comment = $comment;		
	}
	
	function set_sample_type($sample_type_id) { 
		global $db;
		$query = "SELECT * from sample_types WHERE sample_type_id='".$sample_type_id."' AND store_id='".$_SESSION['store_id']."'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		extract($row);
		
		$this->sample_type_manual_id = $sample_type_manual_id;
		$this->sample_type_name = $sample_type_name;
		$this->sample_type_description = $sample_type_description;
		$this->status = $status;
		$this->user_id = $user_id;
	}
	
	function add_sample($sample_manual_id, $sample_name, $sample_description, $sample_unit, $sample_result, $client_id, $sample_type, $pay_status, $sample_image, $date_taken, $result_taken, $comment, $lab_scientist) { 
		global $db;
		$query = "SELECT * from samples WHERE sample_manual_id='".$sample_manual_id."' AND store_id='".$_SESSION['store_id']."'";
		$result = $db->query($query) or die($db->error);
		$num_rows = $result->num_rows;
		if($num_rows > 0) { 
			return 'A sample already exist with this id.';
		} else { 
			$query = "INSERT into samples (sample_manual_id, sample_name, sample_description, client_id, sample_unit, sample_result, sample_type, pay_status, sample_image, date_taken, result_taken, comment, lab_scientist, user_id, store_id) 
			VALUES('".$sample_manual_id."', '".$sample_name."', '".$sample_description."', '".$client_id."', '".$sample_unit."', '".$sample_result."', '".$sample_type."', '".$pay_status."', '".$sample_image."', '".$date_taken."', '".$result_taken."', '".$comment."', '".$lab_scientist."', '".$_SESSION['user_id']."', '".$_SESSION['store_id']."')";
			$result = $db->query($query) or die($db->error);
			$sample_id = $db->insert_id;
			return 'Sample was added successfully!';
		}
	}//add sample ends here.

	function add_sample_types($sample_type_manual_id, $sample_type_name, $sample_type_description) { 
		global $db;
		$query = "SELECT * from sample_types WHERE sample_type_manual_id='".$sample_type_manual_id."' AND store_id='".$_SESSION['store_id']."'";
		$result = $db->query($query) or die($db->error);
		$num_rows = $result->num_rows;
		if($num_rows > 0) { 
			return 'A sample type already exist with this id.';
		} else { 
			$query = "INSERT into sample_types (sample_type_manual_id, sample_type_name, sample_type_description, user_id, store_id) 
			VALUES('".$sample_type_manual_id."', '".$sample_type_name."', '".$sample_type_description."',  '".$_SESSION['user_id']."', '".$_SESSION['store_id']."')";
			$result = $db->query($query) or die($db->error);
			$sample_id = $db->insert_id;
			return 'Sample Type was added successfully!';
		}
	}//add sample ends here.
	
	function update_sample($edit_sample,$sample_manual_id, $sample_name, $sample_unit, $sample_result, $client_id, $sample_type, $pay_status, $sample_image, $date_taken, $result_taken, $comment, $lab_scientist, $sample_description) {
		global $db;
		$query = "UPDATE samples SET
			sample_manual_id='".$sample_manual_id."',
			sample_name='".$sample_name."',
			sample_unit='".$sample_unit."',
			sample_result='".$sample_result."',
			client_id='".$client_id."',
			sample_type='".$sample_type."',
			pay_status='".$pay_status."',
			sample_image='".$sample_image."',
			sample_type='".$sample_type."',
			date_taken='".$date_taken."',
			result_taken='".$result_taken."',
			comment='".$comment."',
			lab_scientist='".$lab_scientist."',
			sample_description='".$sample_description."'
			WHERE sample_id='".$edit_sample."'
		";
		$result = $db->query($query) or die($db->error);
		
		return 'Sample was updated successfuly.';	
	}//update sample ends here.
	
	function update_sample_type($edit_sample_type, $sample_type_manual_id, $sample_type_name, $sample_type_description, $status) {
		global $db;
		$query = "UPDATE sample_types SET
			sample_type_manual_id='".$sample_type_manual_id."',
			sample_type_name='".$sample_type_name."',
			sample_type_description='".$sample_type_description."',
			status='".$status."'
			WHERE sample_type_id='".$edit_sample_type."'
		";
		$result = $db->query($query) or die($db->error);
		
		return 'Sample was updated successfuly.';	
	}//update sample ends here.
	
	function comment_sample($comment_sample, $comment) {
		global $db;
		$query = "UPDATE samples SET
			comment='".$comment."'
			WHERE sample_id='".$comment_sample."'
		";
		$result = $db->query($query) or die($db->error);
		
		return 'Sample was updated successfuly.';	
	}//update sample ends here.
	
	
	function list_samples() { 
		global $db;
		$query = "SELECT * from samples WHERE store_id='".$_SESSION['store_id']."' ORDER by sample_name ASC";
		$result = $db->query($query) or die($db->error);
			$content = '';
			$count = 0;
			while($row = $result->fetch_array()) { 
				extract($row);
				$count++;
				if($count % 2 == 0) { 
					$class = 'even';
				} else { 
					$class = 'odd';
				}
				$content .= '<tr class="'.$class.'">';
				$content .= '<td>';
				$content .= $sample_id;
				$content .= '</td><td>';
				$content .= $sample_name;
				$content .= '</td><td>';
				$content .= substr($sample_description, 0,18);
				$content .= '</td><td>';
				$content .= $sample_unit;
				$content .= '</td><td>';
				$content .= $pay_status;
				$content .= '</td><td>';
				if($sample_image != '') { 
					$sample_image = '<img class="img-thumbnail" src="'.$sample_image.'" width="50" height="50" />';
				}
				$content .= $sample_image;
				$content .= '</td><td>';
				$content .= $sample_result;
				$content .= '</td><td>';
				$content .= $date_taken;
				$content .= '</td><td>';
				$content .= $result_taken;
				$content .= '</td><td>';
				$content .= $comment;
				$content .= '</td><td>';
				$content .= '<a href="reports/view_sample_info.php?sample_id='.$sample_id.'" target="_blank">View</a>';
				$content .= '</td>';				
				if(partial_access('admin')) {
				$content .= '<td class="no-print">';
				$content .= '<form method="post" name="comment" action="comment_sample.php">';
				$content .= '<input type="hidden" name="comment_sample" value="'.$sample_id.'">';
				$content .= '<input type="submit" class="btn btn-default btn-sm" value="Comment">';
				$content .= '</form>';
				$content .= '</td>';
				}
				if(partial_access('admin')) {
				$content .= '<td class="no-print">';
				$content .= '<form method="post" name="edit" action="manage_sample.php">';
				$content .= '<input type="hidden" name="edit_sample" value="'.$sample_id.'">';
				$content .= '<input type="submit" class="btn btn-default btn-sm" value="Edit">';
				$content .= '</form>';
				$content .= '</td><td class="no-print">';
				$content .= '<form method="post" name="delete" onsubmit="return confirm_delete();" action="">';
				$content .= '<input type="hidden" name="delete_sample" value="'.$sample_id.'">';
				$content .= '<input type="submit" class="btn btn-default btn-sm" value="Delete">';
				$content .= '</form>';
				$content .= '</td>';
				}
				$content .= '</tr>';
				unset($class);
			}//loop ends here.
		echo $content;
	}
	
	
	function list_sample_types() { 
		global $db;
		$query = "SELECT * from sample_types WHERE store_id='".$_SESSION['store_id']."' ORDER by sample_type_name ASC";
		$result = $db->query($query) or die($db->error);
			$content = '';
			$count = 0;
			while($row = $result->fetch_array()) { 
				extract($row);
				$count++;
				if($count % 2 == 0) { 
					$class = 'even';
				} else { 
					$class = 'odd';
				}
				$content .= '<tr class="'.$class.'">';
				$content .= '<td>';
				$content .= $sample_type_id;
				$content .= '</td><td>';
				$content .= $sample_type_name;
				$content .= '</td><td>';
				$content .= substr($sample_type_description, 0,18);
				$content .= '</td><td>';
				$timestamp = strtotime($timestamp);
				$content .= date('d-m-Y', $timestamp);
				$content .= '</td><td>';
			$users = new Users;
			$full_name = $users->get_user_info($user_id, 'first_name').' '.$users->get_user_info($user_id, 'last_name');
				
				$content .= $full_name;
				$content .= '</td><td>';
				$content .= '<a href="reports/view_sample_type_info.php?sample_type_id='.$sample_type_id.'" target="_blank">View</a>';
				$content .= '</td>';				
				if(partial_access('admin')) {
				$content .= '<td class="no-print">';
				$content .= '<form method="post" name="edit" action="manage_sample_types.php">';
				$content .= '<input type="hidden" name="edit_sample_type" value="'.$sample_type_id.'">';
				$content .= '<input type="submit" class="btn btn-default btn-sm" value="Edit">';
				$content .= '</form>';
				$content .= '</td><td class="no-print">';
				$content .= '<form method="post" name="delete" onsubmit="return confirm_delete();" action="">';
				$content .= '<input type="hidden" name="delete_sample_type" value="'.$sample_type_id.'">';
				$content .= '<input type="submit" class="btn btn-default btn-sm" value="Delete">';
				$content .= '</form>';
				$content .= '</td>';
				}
				$content .= '</tr>';
				unset($class);
			}//loop ends here.
		echo $content;
	}	
	
	
	function delete_sample($sample_id) {
		global $db;
		$query = "SELECT * FROM samples WHERE sample_id='".$sample_id."' AND pay_status='paid'";
		$result = $db->query($query) or die($db->error);
		$num_rows = $result->num_rows;
		
		if($num_rows > 0) {
			return 'You cannot delete a laboratory sample that has been paid for.'; 
		} else { 
		$query = "DELETE FROM samples WHERE sample_id='".$sample_id."'";
		$result = $db->query($query) or die($db->error);
		return 'Lab Sample was deleted successfuly.';
		}
	}//sample_id delete
	
	function delete_sample_type($sample_type_id) {
		global $db;
		$query = "DELETE FROM sample_types WHERE sample_type_id='".$sample_type_id."'";
		$result = $db->query($query) or die($db->error);
		return 'Lab Sample was deleted successfuly.';
	}//sample_type_id delete
	
	function list_client_levels() { 
		global $db;
		$query = "SELECT * from clients WHERE store_id='".$_SESSION['store_id']."' ORDER by full_name ASC";
		$result = $db->query($query) or die($db->error);
		
		$content = '';
		while($row = $result->fetch_array()) {
			extract($row);
			$content .= '<tr>';
			$content .= '<form method="post" action="">';
			$content .= '<td>';
			$content .= $client_id;
			$content .= '</td><td>';
			$content .= $full_name;
			$content .= '</td><td>';
			$content .= $business_title;
			$content .= '</td><td>';
			$content .= $mobile;
			$content .= '</td><td>';
			$content .= $phone;
			$content .= '</td><td>';
			$content .= $email;
			$content .= '</td><td>';
			$content .= '<select name="price_level" class="form-control" style="height:28px;padding-top:3px;padding-bottom:3px;">';
			if($price_level == 'default_level'):
			$content .= '<option selected="selected" value="default_level">Default</option>';
            else:
			$content .= '<option value="default_level">Default</option>';
			endif;
			if($price_level == 'level_1'):
			$content .= '<option selected="selected" value="level_1">Level 1</option>';
			else:
			$content .= '<option value="level_1">Level 1</option>';
			endif;
			if($price_level == 'level_2'):
            $content .= '<option selected="selected" value="level_2">Level 2</option>';
			else:
			$content .= '<option value="level_2">Level 2</option>';
			endif;
			if($price_level == 'level_3'):
            $content .= '<option selected="selected" value="level_3">Level 3</option>';
			else:
			$content .= '<option value="level_3">Level 3</option>';
			endif;
			if($price_level == 'level_4'):
            $content .= '<option selected="selected" value="level_4">Level 4</option>';
			endif;
			if($price_level == 'level_5'):
            $content .= '<option selected="selected" value="level_5">Level 5</option>';
			else:
			$content .= '<option value="level_5">Level 5</option>';
            endif;
			$content .= '</select>';
			$content .= '</td><td>';
			$content .= '<input type="hidden" name="update_client" value="'.$client_id.'">';
			$content .= '<input type="submit" class="btn btn-default btn-sm" value="Update">';
			$content .= '</td></form></tr>';	
		} //while loop products
		echo $content;	
	} //list product rates to manage rates of different price levels.
	
	function sample_options($sample_id) {
		global $db;
		$query = 'SELECT * from samples WHERE store_id="'.$_SESSION['store_id'].'" ORDER by sample_name ASC';
		$result = $db->query($query) or die($db->error);
		$options = '';
		if($sample_id != '') { 
			while($row = $result->fetch_array()) { 
				if($sample_id == $row['sample_id']) {
				$options .= '<option selected="selected" value="'.$row['sample_id'].'">'.$row['sample_name'].' ('.$row['sample_manual_id'].')</option>';
				} else { 
				$options .= '<option value="'.$row['sample_id'].'">'.$row['sample_name'].' ('.$row['sample_manual_id'].')</option>';
				}
			}
		} else { 
			while($row = $result->fetch_array()) { 
				$options .= '<option value="'.$row['sample_id'].'">'.$row['sample_name'].' ('.$row['sample_manual_id'].')</option>';
			}
		}
		echo $options;	
	}//sample_options ends here.

	function sample_type_options($sample_type) {
		global $db;
		$query = 'SELECT * from sample_types WHERE store_id="'.$_SESSION['store_id'].'" ORDER by sample_type_name ASC';
		$result = $db->query($query) or die($db->error);
		$options = '';
		if($sample_type != '') { 
			while($row = $result->fetch_array()) { 
				if($sample_type == $row['sample_type_id']) {
				$options .= '<option selected="selected" value="'.$row['sample_type_id'].'">'.$row['sample_type_name'].' ('.$row['sample_type_manual_id'].')</option>';
				} else { 
				$options .= '<option value="'.$row['sample_type_id'].'">'.$row['sample_type_name'].' ('.$row['sample_type_manual_id'].')</option>';
				}
			}
		} else { 
			while($row = $result->fetch_array()) { 
				$options .= '<option value="'.$row['sample_type_id'].'">'.$row['sample_type_name'].' ('.$row['sample_type_manual_id'].')</option>';
			}
		}
		echo $options;	
	}//sample_options ends here.
	
	function get_sample_info($sample_id, $term) { 
		global $db;
		$query = "SELECT * from samples WHERE sample_id='".$sample_id."'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		return $row[$term];
	}//get user email ends here.

	function get_sample_type_info($sample_type_id, $term) { 
		global $db;
		$query = "SELECT * from sample_types WHERE sample_type_id='".$sample_type_id."'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		return $row[$term];
	}//get user email ends here.

	function get_laboratorist_info($laboratorist_id, $term) { 
		global $db;
		$query = "SELECT * from laboratorist WHERE laboratorist_id='".$laboratorist_id."'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		return $row[$term];
	}//get user email ends here.
	
	function laboratorist_options($lab_scientist) {
		global $db;
		$query = 'SELECT * from laboratorist WHERE store_id="'.$_SESSION['store_id'].'" ORDER by laboratorist_name ASC';
		$result = $db->query($query) or die($db->error);
		$options = '';
		if($lab_scientist != '') { 
			while($row = $result->fetch_array()) { 
				if($sample_id == $row['sample_id']) {
				$options .= '<option selected="selected" value="'.$row['laboratorist_id'].'">'.$row['laboratorist_name'].' ('.$row['laboratorist_manual_id'].')</option>';
				} else { 
				$options .= '<option value="'.$row['laboratorist_id'].'">'.$row['laboratorist_name'].' ('.$row['laboratorist_manual_id'].')</option>';
				}
			}
		} else { 
			while($row = $result->fetch_array()) { 
				$options .= '<option value="'.$row['laboratorist_id'].'">'.$row['laboratorist_name'].' ('.$row['laboratorist_manual_id'].')</option>';
			}
		}
		echo $options;	
	}//product_options ends here.
	
	function get_sample_rate($sample_id, $term) { 
		global $db;
		$query = "SELECT * from sample_rates WHERE sample_id='".$sample_id."'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_array();
		return $row[$term];
	}//get user email ends here.
	
	
}//class ends here.