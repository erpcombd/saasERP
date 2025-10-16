<?php

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

//--========Table information==========-----------//
$table_master='purchase_invoice';

$table_details='purchase_receive_asset';

$unique='po_no';

$unique_detail='id';

//--========Table information==========-----------//


		//test


	

$po_no = $_SESSION[$unique];		

if($_SESSION['pr_no']>0){
$pr_no = $_SESSION['pr_no'];
}else{
$pr_no = find_a_field('purchase_receive_asset','pr_no','po_no="'.$po_no.'"');
if($pr_no==0 || $pr_no==''){
$pr_no = find_a_field('purchase_receive_asset','max(pr_no)','1')+1;
}
$_SESSION['pr_no'] = $pr_no;
}
$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);

        
		$vendor_id = $_POST['vendor_id'];

		$warehouse_id = $_SESSION['user']['depot'];

		$qc_by=$_POST['qc_by'];

		$ch_no=$_POST['ch_no'];

		$rec_date=$_POST['rec_date'];
		
		$receive_note=$_POST['receive_note'];

		$rec_no=$_POST['rec_no'];

		$now = date('Y-m-d H:s:i');

		$vendor = find_all_field('vendor','ledger_id',"vendor_id=".$vendor_id);

		$vendor_ledger = $vendor->ledger_id;
		
	

		$sql = 'select * from purchase_invoice where po_no="'.$po_no.'" and warehouse_id="'.$_SESSION['user']['depot'].'"';
		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{
		
		

			if(($_POST['serial_no_'.$data->id]!='')){
	
				$serial_no = trim($_POST['serial_no_'.$data->id]);
				 $po_qty = find_a_field('purchase_invoice','sum(qty)','po_no="'.$po_no.'" and item_id="'.$data->item_id.'"');
				 $pr_qty = find_a_field('purchase_receive_asset','sum(qty)','po_no="'.$po_no.'" and item_id="'.$data->item_id.'"');
				 $serial_check = find_a_field('journal_item','sum(item_in)','serial_no="'.$serial_no.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
				 
				 
				if(($serial_check=='' or $serial_check==0) && $po_qty>$pr_qty){
				$qty=1;
   
				$rate=$_POST['rate_'.$data->id];
				
				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;

				$amount = ($qty*$rate);

				$total = $total + $amount;

 $q = "INSERT INTO `purchase_receive_asset` (`pr_no`, `po_no`, `order_no`, `rec_no`,`rec_date`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, `qty`, `unit_name`, `amount`, `qc_by`, `entry_by`, `entry_at`,ch_no,serial_no,receive_note) VALUES('".$pr_no."', '".$po_no."', '".$data->id."', '".$rec_no."','".$rec_date."',".$vendor_id.", ".$item_id.",".$warehouse_id.", ".$rate.", '".$qty."', '".$unit_name."',  '".$amount."', '".$qc_by."',  '".$_SESSION['user']['id']."', '".$now."', '".$ch_no."','".$serial_no."','".$receive_note."')";

db_query($q);

$xid = mysqli_insert_id();

//journal_item_control($data->item_id ,$warehouse_id,$rec_date,$qty,0,'Purchase',$xid,$rate,'',$pr_no);
$journal_item_sql = 'insert into journal_item (`ji_date`,`item_id`,`warehouse_id`,`lot_no`,`serial_no`,`item_in`,`item_price`,`final_price`,`tr_from`,`tr_no`,`sr_no`,`entry_by`,`entry_at`,`primary_id`) value("'.$rec_date.'","'.$item_id.'","'.$warehouse_id.'","'.$pr_no.'","'.$serial_no.'","'.$qty.'","'.$rate.'","'.$rate.'","AssetPurchase","'.$po_no.'","'.$pr_no.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d h:i:s').'","'.$xid.'")';
db_query($journal_item_sql);

		}
			}
		}

 $res='select p.id,p.pr_no,p.item_id as item_code,i.item_name,i.unit_name,p.qty,p.serial_no as item_serial_no,p.id as action from purchase_receive_asset p,item_info i where i.item_id=p.item_id and p.journal="Pending" and p.warehouse_id="'.$_SESSION['user']['depot'].'" and po_no="'.$po_no.'"';

$all_dealer[]=link_report_add_del_auto($res,1,6);
echo json_encode($all_dealer);

?>



