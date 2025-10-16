<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

//--========Table information==========-----------//
$table_master='asset_transfer_master';

$unique_master='pi_no';

$table_detail='asset_transfer_details';

$unique_detail='id';


//--========Table information==========-----------//

$unique = $_POST[$unique_master];

$table		=$table_detail;

		$crud      	=new crud($table);

		$iii=explode('->',$_POST['item_id']);

		$_POST['item_id']=$iii[1];
		$_POST['pi_date'] = date('Y-m-d');

		
		$item_type = find_a_field('item_info','item_type','item_id="'.$iii[1].'"');
		if($item_type=='Serialized'){
		
		$item_price = find_a_field('journal_asset_item','item_price','item_id="'.$iii[1].'" and serial_no="'.$_POST['serial_no'].'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
		$_POST['unit_price'] = $item_price;
		
		$check = find_a_field('journal_asset_item','serial_no','item_id="'.$iii[1].'" and serial_no="'.$_POST['serial_no'].'" and warehouse_id="'.$_SESSION['user']['depot'].'" and item_in>0');
		$exist_check = find_a_field('asset_transfer_details','pi_no','serial_no="'.$_POST['serial_no'].'" and warehouse_from="'.$_SESSION['user']['depot'].'" and status in ("MANUAL","SEND")');
		}else{
		$item_price = find_a_field('journal_asset_item','(sum(item_in*item_price)-sum(item_ex*item_price))/sum(item_in-item_ex)','item_id="'.$iii[1].'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
		$_POST['unit_price'] = $item_price;
		$check = 'Non-serialized';
		$exist_check = '';
		}
		
		if($check!='' && $exist_check==''){
		$_POST['total_amt'] =$_POST['unit_price']* $_POST['total_unit'];
		$xid = $crud->insert();
		}
$res='select a.id,b.finish_goods_code as FG_code,b.item_name,b.unit_name,a.serial_no, a.total_unit as total_qty,"X" from asset_transfer_details a,item_info b where b.item_id=a.item_id and a.pi_no='.$unique.' order by a.id';


$all_dealer[]=link_report_add_del_auto($res,1,6);//link_report_del($res);
echo json_encode($all_dealer);

?>



