<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$details_id = $_REQUEST['details_id'];

$pos_id = $_REQUEST['pos_id'];

$comment = $_REQUEST['comment'];

$register_mode= $_REQUEST['register_mode'];

$payment_method=$_REQUEST['payment_method'];

$usql = "update sale_pos_master set status = 'CHECKED', comments = '$comment', register_mode = '$register_mode' where pos_id = '$pos_id' ";

db_query($usql);

$psql ="update pos_payment set status = 'PAID' where pos_id = '$pos_id'";

db_query($psql);

$max_id = mysqli_fetch_object(db_query("select max(pos_id)+1 as max_pos_id from sale_pos_master"));

$data['max_id'] = $max_id->max_pos_id;

$data['status'] = "ok";

$rr_sql  = "select * from sale_pos_details where pos_id = '".$pos_id."' order by id asc";

	$rr_query = db_query($rr_sql);

	while($datas = mysqli_fetch_assoc($rr_query )){

		extract($datas);

		$ji_date = $pos_date;

		if($register_mode=="sale"){

		$item_in = 0;

		$item_ex = $qty;

		$tr_from="POS Sale";			

		}

		if($register_mode=="return"){

		$item_in = $qty;

		$item_ex = 0;

		$tr_from="POS Return";						

			}



		$tr_no = $id;

		$sr_no = $pos_id;

		journal_item_control($item_id ,$warehouse_id,$ji_date,$item_in,$item_ex,$tr_from,$tr_no,$rate,$r_warehouse='',$sr_no,$c_price='',$lot_no='',$vendor_id='');
////////////////////////////////////////log////////////////////////////////////////////


$address = explode('/',$_SERVER['REQUEST_URI']);

$s= count($address);

$module_id = find_a_field('user_module_manage','id','module_file="'.$address[$s-4].'"');

$page_all=find_all_field('user_page_manage','','page_link = "'.$address[$s-1].'" and folder_name="'.$address[$s-2].'"'); 

$page_id=$page_all->id;
$page_name=$page_all->page_name;

$trans_end = microtime(true);

$execution_time = ($trans_end - $trans_start);

$tr_type="Add";

activity_log($module_id,$page_id,$page_name,$tr_from,$sr_no,$tr_no,$tr_type,$execution_time);

////////////////////////////////////////log////////////////////////////////////////////
		}

echo json_encode($data);



?>