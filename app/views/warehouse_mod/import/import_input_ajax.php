<?php
session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');
$or_no = $_SESSION[$unique];		


$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);

        
		$warehouse_id = $_SESSION['user']['depot'];//$_POST['warehouse_id'];
        $rec_date=$_POST['rec_date'];
        $now = date('Y-m-d H:s:i');
        $or_no = $_POST['or_no'];
		
		
		$sql = 'select * from warehouse_other_receive_detail where or_no="'.$or_no.'"';
		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{

			if(($_POST['qty_'.$data->id]!=''))

			{
                
				$serial_no = $_POST['or_no'];
				$qty = $_POST['qty_'.$data->id];
				$po_qty = find_a_field('warehouse_other_receive_detail','sum(qty)','or_no="'.$or_no.'" and item_id="'.$data->item_id.'"');
				$rcv_qty = find_a_field('journal_item','sum(item_in)','lot_no="'.$or_no.'" and item_id="'.$data->item_id.'" and tr_from="Import"');
				//$rcv_qty = find_a_field('lc_import','sum(qty)','import_no="'.$or_no.'" and item_id="'.$data->item_id.'"');
				$serial_check = find_a_field('journal_item','sum(item_in)','serial_no="'.$serial_no.'"');
				//$serial_check = find_a_field('lc_import','sum(qty)','serial_no="'.$serial_no.'"');
				
                
				$rate=$_POST['rate_'.$data->id];
				$amount = $qty*$rate;
				

				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;

				$lc_insert = 'insert into lc_import(`import_no`,`item_id`,`serial_no`,`rate`,`qty`,`amount`,`import_date`,`entry_by`,`import_rcv_date`) value("'.$or_no.'","'.$item_id.'","'.$serial_no.'","'.$rate.'","'.$qty.'","'.$amount.'","'.$rec_date.'","'.$_SESSION['user']['id'].'","'.$rec_date.'")';
				db_query($lc_insert);
				//$last_id = mysqli_insert_id();
//journal_item_control($data->item_id ,$warehouse_id,$rec_date,$qty,0,'Purchase',$xid,$rate,'',$pr_no);
$journal_item_sql = 'insert into journal_item (`ji_date`,`item_id`,`warehouse_id`,`lot_no`,`serial_no`,`item_in`,`item_price`,`final_price`,`tr_from`,`tr_no`,`sr_no`,`entry_by`,`entry_at`) value("'.$rec_date.'","'.$item_id.'","'.$warehouse_id.'","'.$or_no.'","'.$serial_no.'","'.$qty.'","'.$rate.'","'.$rate.'","Import","'.$data->id.'","'.$data->id.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d h:i:s').'")';
db_query($journal_item_sql);


	

		}
		}

$res='select p.import_no,p.import_no,i.item_name,i.unit_name,p.qty ,i.unit_name as action from lc_import p,item_info i where i.item_id=p.item_id and p.import_no="'.$or_no.'"';

$all_dealer[]=link_report($res);
echo json_encode($all_dealer);

?>



