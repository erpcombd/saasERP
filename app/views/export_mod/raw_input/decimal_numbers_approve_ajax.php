<?php
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');


$str = $_POST['data'];
$data=explode('##',$str);
$id = $data[0];
$val = $data[1];
$data=explode('#',$val);


$number_format=$data[0];






$now = date('Y-m-d H:i:s');
$entry_by=$_SESSION['user']['id'];

$change_date=date('Y-m-d');

$backup_data = find_all_field('item_info','','item_id='.$item_id);

  //$backup_sql="INSERT INTO `item_info_backup` (
//
//		item_id ,
//
//		item_name,
//		
//		group_for,
//		
//		change_date,
//		
//		sub_group_id,
//
//		unit_name,
//
//			
//		running_s_price,
//		
//		running_a_price,
//		
//		previous_s_price,
//		previous_a_price,
//		
//		entry_at,
//		entry_by,
//		status
//
//
//		)
//
//VALUES ('".$backup_data->item_id."', '".$backup_data->item_name."', '".$backup_data->group_for."', '".$change_date."', '".$backup_data->sub_group_id."',  '".$backup_data->unit_name."',
//'".$d_price."', '".$a_price."', '".$backup_data->d_price."', '".$backup_data->a_price."', '".$now."', '".$entry_by."', '".$backup_data->status."')";
//		
//		
//		
//		db_query($backup_sql);




     $sql = 'update decimal_numbers set 
	number_format="'.$number_format.'", 

	 approval="Yes", approved_by="'.$entry_by.'", approved_at="'.$now.'" where id='.$id;
db_query($sql);
echo 'Approved';
?>