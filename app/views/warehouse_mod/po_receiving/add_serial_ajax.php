<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

//--========Table information==========-----------//
$table_master='purchase_invoice';

$table_details='purchase_receive';

$unique='po_no';

$unique_detail='id';
$po_no = $_SESSION[$unique];
$pid = $_POST['pid'];
//--========Table information==========-----------//

		//test
        $po_master= find_all_field('purchase_master','','po_no="'.$po_no.'"');
		$group_for = $po_master->group_for;
		$vendor_id = $_POST['vendor_id'];
		$warehouse_id = $_POST['warehouse_id'];
		$qc_by=$_POST['qc_by'];
		$ch_no=$_POST['ch_no'];
		$transport_charge=$_POST['transport_charge'];
		$other_charge=$_POST['other_charge'];
		$remarks=$_POST['remarks'];
		$rec_date=$_POST['rec_date'];
		$rec_no= find_a_field('purchase_receive','max(rec_no)','po_no="'.$po_no.'"')+1;

		$now = date('Y-m-d H:s:i');
        if($_SESSION['pr_no']>0){
		$pr_no = $_SESSION['pr_no'];
		}else{
		$pr_no = $_SESSION['pr_no'] = next_transection_no('0',$rec_date,'purchase_receive','pr_no');
		}

		

		$sql = 'select * from purchase_invoice where id = '.$pid;

		$query = db_query($sql);
		
		while($data=mysqli_fetch_object($query)){
		
			$total_po_qty = find_a_field('purchase_invoice','qty','id="'.$data->id.'"');
			$total_pr_qty = find_a_field('purchase_receive','sum(qty)','order_no="'.$data->id.'"');
			
			if($total_po_qty>$total_pr_qty){
				$qty=$_POST['chalan_'.$data->id];
				$rate=$_POST['rate_'.$data->id];
				$item_id=$_POST['item_id_'.$data->id];
				$serial_no=$_POST['item_serial'.$data->id];
				$check_serial=find_a_field('journal_item','serial_no','serial_no="'.$serial_no.'"');
				if($check_serial==''){
				$unit_name =$data->unit_name;
				$amount = ($qty*$rate);
				$total = $total + $amount;
					
			if($po_master->vat_include=='Including'){
				
				
			
				//if($po_master->rebate=='Yes'){
				//	$rebate = $po_master->vat * ($po_master->rebate_percentage/100);
					$vat_rate=(($rate/(100+$data->vat))*$data->vat);
				//}
			//else{
				//	$vat_rate=0;
			//	}
				
				$vat_amt = $vat_rate*$qty;
				
				//$with_vat_rate=$rate-$vat_rate;
				
			if($po_master->rebateable == 'Yes'){
			$with_vat_rate=$rate-$vat_rate;
			}
			else{
			$with_vat_rate=$rate;
			}
				
				$with_vat_amt =number_format(($with_vat_rate * $qty),2,'.','');
			}else{
		
			$vat_rate=(($rate*$data->vat)/100);
			$vat_amt = $vat_rate*$qty;
			//$with_vat_rate = $rate+$vat_rate;
			
			if($po_master->rebateable == 'Yes'){
			$with_vat_rate=$rate;
			}
			else{
			$with_vat_rate=$rate+$vat_rate;
			}
			
		
			$with_vat_amt =($qty*$rate);
		

		}
		
		
		$tax_rate=(($with_vat_rate*$data->tax)/100);
		$tax_amt = number_format(($tax_rate*$qty),2,'.','');
		
		if($po_master->tax_include =='Including'){
				if($po_master->rebateable == 'Yes'){	
					if($po_master->vat_include=='Excluding'){$grand_amount  = $amount+$vat_amt-$tax_amt;}
					else{ $grand_amount = $amount-$tax_amt; }
				}
				else{
					$tax_rate=((($with_vat_rate-$vat_rate)*$data->tax)/100);
					$tax_amt = number_format(($tax_rate*$qty),2,'.','');
					
					if($po_master->vat_include=='Excluding'){$grand_amount  = $amount+$vat_amt-$tax_amt;}
					else{ $grand_amount = $amount-$tax_amt; }
				}
		
			//$grand_amount = $with_vat_amt-$tax_amt; 
		}else{
			if($po_master->vat_include=='Including'){ $tax_rate=(($with_vat_rate*$data->tax)/100); }
			else{$tax_rate=(($rate*$data->tax)/100);}

				if($po_master->rebateable == 'Yes'){
					
					$tax_amt = number_format(($tax_rate*$qty),2,'.','');
					$with_vat_rate=$with_vat_rate+$tax_rate;
					$with_vat_amt =$with_vat_rate*$qty;
					$grand_amount=($with_vat_amt)-$tax_amt+$vat_amt;
				}
				else{
					
					$tax_amt = number_format(($tax_rate*$qty),2,'.','');
					$with_vat_rate=$with_vat_rate+$tax_rate;
					$with_vat_amt =$with_vat_rate*$qty;
					$grand_amount=($with_vat_amt)-$tax_amt;
				}
		
		}
		
		if($po_master->deductible=='No'){
			if($po_master->rebateable == 'Yes'){
				$grand_amount=$grand_amount;
			}
			else{
				$grand_amount=$grand_amount;
			}
			//$grand_amount=$grand_amount+$vat_amt;
		
		}
				
		
				
				
				
				if (isset($_POST['is_complete_'.$data->id])) {
					$balCheck = 1;
						$inv='update purchase_invoice set is_complete=1 where id='.$data->id;	
						db_query($inv);	
				} else {
					$balCheck = 0;
				}

	
				
				
				//$final_avg_price = moving_average_price_calculation($item_id,$qty,$amount,$group_for);



 $q = "INSERT INTO `purchase_receive` (`pr_no`, group_for,  `po_no`, `order_no`, `rec_no`,`rec_date`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, `qty`, `unit_name`, `amount`, `qc_by`, `entry_by`, `entry_at`,ch_no, transport_charge, other_charge, remarks, avg_price,status,upload_chalan_1,upload_chalan_2,upload_chalan_3,is_complete,with_vat_rate,with_vat_amt,vat,vat_rate,tax,tax_rate,vat_amt,tax_amt,payable_amt,serial_no)

 VALUES('".$pr_no."', '".$group_for."', '".$po_no."', '".$data->id."', '".$rec_no."','".$rec_date."','".$vendor_id."', '".$item_id."','".$warehouse_id."', '".$rate."', '".$qty."', '".$unit_name."',  '".$amount."', '".$qc_by."',  '".$_SESSION['user']['id']."', '".$now."', '".$ch_no."', '".$transport_charge."', '".$other_charge."', '".$remarks."', '".$final_avg_price."', 'Received','".$_POST['upload_chalan_1']."','".$_POST['upload_chalan_2']."','".$_POST['upload_chalan_3']."','".$balCheck."','".$with_vat_rate."','".$with_vat_amt."','".$data->vat."','".$vat_rate."','".$data->tax."','".$tax_rate."','".$vat_amt."','".$tax_amt."','".$grand_amount."','".$serial_no."')";

db_query($q);

$xid = db_insert_id();

journal_item_control($item_id, $warehouse_id, $rec_date, $qty, 0, 'Purchase', $xid, $with_vat_rate, '', $pr_no, '', '',$group_for, $final_avg_price, '',$serial_no );

$tr_from="Purchase";

$tr_no=$pr_no;

$tr_id=$data->id;                                                                                        

$tr_type="Add";
$all_dealer['error_msg'] = '<span style="color:green; font-weight:bold;">Success!</span>';
}else{
$all_dealer['error_msg'] = '<span style="color:red; font-weight:bold;">Duplicate Serial Found!</span>';
}
}else{
$all_dealer['error_msg'] = '<span style="color:red; font-weight:bold;">Qty Overflow!</span>';
}
}


$res = 'select p.id,i.finish_goods_code as item_code,i.item_name,i.unit_name,p.qty,p.serial_no,p.id as action from purchase_receive p, item_info i where p.item_id=i.item_id and p.pr_no="'.$_SESSION['pr_no'].'"';
$all_dealer['msg']=link_report_add_del_auto($res);//link_report_del($res);
//$all_dealer['msg']= 'This is test'.$q;//link_report_del($res);
echo json_encode($all_dealer);

?>



