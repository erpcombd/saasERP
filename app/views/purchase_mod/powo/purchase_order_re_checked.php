<?php



session_start();



ob_start();



require "../../support/inc.all.php";



$title='Select Dealer for Demand Order';



$now = date('Y-m-d H:s:i');



$table_master='purchase_master';



$unique_master='po_no';







$table_detail='purchase_invoice';



$unique_detail='id';












$$unique_master=$_POST[$unique_master];







if(isset($_POST['delete']))



{
$crud   = new crud($table_master);



		$condition=$unique_master."=".$$unique_master;		



		$crud->delete($condition);



		$crud   = new crud($table_detail);



		$crud->delete_all($condition);



		$crud   = new crud($table_chalan);



		$crud->delete_all($condition);
		
		// $sql = "delete from journal_item where tr_from = 'Cash Sale' and sr_no = '".$$unique_master."'";

		//db_query($sql);



		unset($$unique_master);



		unset($_POST[$unique_master]);
		
		
		



		$type=1;



		$msg='Successfully Deleted.';


?>
<script language="javascript">
window.location.href = "select_dealer_do.php";
</script>
<?
}







if(isset($_POST['confirmm']))



{

 $po_no = $_REQUEST['po_no'];
 
 		$checked_by = $_SESSION['user']['id'];
		$checked_at = date('Y-m-d H:i:s');


$pr_no = find_a_field('purchase_receive','pr_no','po_no='.$po_no);

//$pr_no = date('ym').sprintf('%06d', $po_no);




//$po_sql = "select m.group_for, m.invoice_no, a.id, a.po_no, a.po_date, a.item_id,  a.warehouse_id, a.vendor_id, b.item_name,a.rate as unit_price, a.pkt_size, a.pkt_unit, a.qty ,a.unit_name,a.amount from purchase_invoice a, purchase_master m, item_info b where 
//a.po_no=m.po_no and b.item_id=a.item_id and a.po_no='".$po_no."' ORDER by a.id ";
//
//$po_query = db_query($po_sql);	
//
//		while($po_data=mysqli_fetch_object($po_query))
//
//		{
//
//		
//		  $ins_pr_sql = "INSERT INTO `purchase_receive` 
// (`pr_no`, `group_for`, `po_no`, `order_no`, `rec_no`, `rec_date`,  `vendor_id`, `item_id`, `warehouse_id`, `rate`, pkt_size, pkt_unit , `qty`, `unit_name`, `amount`, `qc_by`, `ch_no`, `entry_by`, `entry_at`, status) VALUES
//('".$pr_no."', '".$po_data->group_for."', '".$po_data->po_no."', '".$po_data->id."', '".$pr_no."', 
// '".$po_data->po_date."',  '".$po_data->vendor_id."', '".$po_data->item_id."' , '".$po_data->warehouse_id."' , 
//'".$po_data->unit_price."' ,  '".$po_data->pkt_size."' ,  '".$po_data->pkt_unit."' ,  '".$po_data->qty."' , 
//'".$po_data->unit_name."' , '".$po_data->amount."', '0' , '".$po_data->invoice_no."' , '".$checked_by."', 
//'".$checked_at."', 'Received' )";
//
//db_query($ins_pr_sql);
//
//		
//		}



//$ji_sql = "select a.id, a.pr_no, a.rec_date, a.po_no, a.item_id,  a.warehouse_id, a.vendor_id, b.item_name,a.rate as unit_price, a.qty ,a.unit_name,a.amount from purchase_receive a,item_info b where b.item_id=a.item_id and a.pr_no='".$pr_no."' ORDER by a.id ";
//
//$ji_query = db_query($ji_sql);	
//
//		while($data_ji=mysqli_fetch_object($ji_query))
//
//		{
//
//		
//journal_item_control($data_ji->item_id,$data_ji->warehouse_id, $data_ji->rec_date, $data_ji->qty, 0,'Purchase', $data_ji->id, $data_ji->unit_price,'',$pr_no,'','',$data_ji->po_no);
//
//		
//		}
		
		
		
//1
$sql_ji_id = "select id from journal_item where sr_no='".$pr_no."'  LIMIT 1 ";
$ji_id = find_a_field_sql($sql_ji_id);

//2
  $sql = "select sum(item_in-item_ex) as opening_qty, item_id from journal_item where id<'".$ji_id."' group by item_id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){

$opening_qty[$data->item_id]=$data->opening_qty;

}


	
		
		  $sql_avr = "SELECT  p.po_no, p.pr_no, p.rec_date, p.vendor_id, p.group_for, p.item_id, i.item_name, p.unit_name, i.c_price, p.rate, sum(p.qty) as buy_qty, p.unit_name as unit, sum(p.amount) as buy_amount, av.opening_rate FROM purchase_receive p, purchase_average_rate_cal av,  item_info i, item_sub_group s WHERE p.item_id=av.item_id and p.item_id=i.item_id and i.sub_group_id=s.sub_group_id 
 and p.pr_no='".$pr_no."' GROUP by p.item_id ";
$query_avr = db_query($sql_avr);
while($data_avr=mysqli_fetch_object($query_avr)){
	
	
	 // $ins_avr_sql = "INSERT INTO `purchase_average_rate_cal` 
// (`po_no`, `pr_no`, `po_date`, `group_for`, `vendor_id`, `item_id`, `opening_qty`, `opening_rate`, `opening_value`, `purchase_qty`, `purchase_rate`, `purchase_value`, `stock_qty`, `average_rate`, `stock_value`, `entry_by`, `entry_at`) VALUES
//('".$data_avr->po_no."', '".$data_avr->pr_no."', '".$data_avr->rec_date."', '".$data_avr->group_for."', '".$data_avr->vendor_id."', '".$data_avr->item_id."',
// '".$opening_qty[$data_avr->item_id]."',  '".$data_avr->c_price."', '".$opening_qty_value=($opening_qty[$data_avr->item_id]*$data_avr->c_price)."' , 
// '".$data_avr->buy_qty."', '".$buy_average_rate=($data_avr->buy_amount/$data_avr->buy_qty)."', '".$data_avr->buy_amount."',
// '".$closing_qty=($opening_qty[$data_avr->item_id]+$data_avr->buy_qty)."', 
// '".$average_rate=((($opening_qty_value=($opening_qty[$data_avr->item_id]*$data_avr->c_price))+$data_avr->buy_amount)/($closing_qty=($opening_qty[$data_avr->item_id]+$data_avr->buy_qty)))."',
// '".$closing_value=(($opening_qty_value=($opening_qty[$data_avr->item_id]*$data_avr->c_price))+$data_avr->buy_amount)."',
// '".$checked_by."', '".$checked_at."' )";
//
//db_query($ins_avr_sql);


		$purchase_avr_update = 'update purchase_average_rate_cal set 
		opening_qty="'.$opening_qty[$data_avr->item_id].'", opening_rate="'.$data_avr->opening_rate.'", opening_value="'.$opening_qty_value=($opening_qty[$data_avr->item_id]*$data_avr->opening_rate).'", 
		
		purchase_qty="'.$data_avr->buy_qty.'", purchase_rate="'.$buy_average_rate=($data_avr->buy_amount/$data_avr->buy_qty).'", purchase_value="'.$data_avr->buy_amount.'",
		
		stock_qty="'.$closing_qty=($opening_qty[$data_avr->item_id]+$data_avr->buy_qty).'", 
		average_rate="'.$average_rate=((($opening_qty_value=($opening_qty[$data_avr->item_id]*$data_avr->opening_rate))+$data_avr->buy_amount)/($closing_qty=($opening_qty[$data_avr->item_id]+$data_avr->buy_qty))).'", 
		stock_value="'.$closing_value=(($opening_qty_value=($opening_qty[$data_avr->item_id]*$data_avr->opening_rate))+$data_avr->buy_amount).'",
		edit_at="'.$checked_at.'", edit_by="'.$checked_by.'"
		
		where item_id ="'.$data_avr->item_id.'" and pr_no="'.$pr_no.'" ';
		 db_query($purchase_avr_update);

	


 		$avr_update = 'update item_info set c_price="'.$average_rate=((($opening_qty_value=($opening_qty[$data_avr->item_id]*$data_avr->opening_rate))+$data_avr->buy_amount)/($closing_qty=($opening_qty[$data_avr->item_id]+$data_avr->buy_qty))).'" where item_id = '.$data_avr->item_id;
		 db_query($avr_update);

	
	}

		
//		
//		if($po_no>0)
//		{
//		auto_insert_purchase_secoundary_journal($po_no);
//		}
//



		 $sql1 = 'update purchase_master set status="COMPLETED", checked_by="'.$checked_by.'", checked_at="'.$checked_at.'" where po_no = '.$po_no;
		 db_query($sql1);
		 
		  $sql2 = 'update purchase_receive set status="Received", edit_by="'.$checked_by.'", edit_at="'.$checked_at.'" where pr_no = '.$pr_no;
		 db_query($sql2);


		db_query('delete from secondary_journal where tr_from="Purchase" and tr_no = "'.$pr_no.'"');
		db_query('delete from journal where tr_from="Purchase" and tr_no = "'.$pr_no.'"');
		


		
?>

<?
if($po_no>0)
		{

			echo "<script language='javascript'>window.open('po_print_view.php?po_no=".$po_no."','Chalan Print').focus();</script>";
	
		}
?>


<script language="javascript">
window.location.href = "select_unapproved_po_fg.php?concern=<?=$_SESSION['concern']?>";
</script>






<?



}


?>



<script language="javascript">



window.onload = function() {document.getElementById("dealer").focus();}



</script>



<div class="form-container_large">



<form action="do.php" method="post" name="codz" id="codz">



<table width="70%" border="0" align="center">



  <tr>



    <td>&nbsp;</td>



    <td>&nbsp;</td>



    <td>&nbsp;</td>



  </tr>



  <tr>



    <td>&nbsp;</td>



    <td>&nbsp;</td>



    <td>&nbsp;</td>



  </tr>



  <tr>



    <td align="right" bgcolor="#FF9966"><strong>Active Dealer List: </strong></td>



    <td bgcolor="#FF9966"><strong>



<select id="dealer" name="dealer" required style="width:245px;height:26px;" >
<option></option>
            <? foreign_relation('dealer_info','dealer_code','dealer_name_e',dealer,' dealer_type="Regular" order by dealer_name_e');?>
          </select>

    </strong></td>



    <td bgcolor="#FF9966"><strong>



      <input type="submit" name="submitit" id="submitit" value="Create DO" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>



    </strong></td>



  </tr>



</table>







</form>



</div>







<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>