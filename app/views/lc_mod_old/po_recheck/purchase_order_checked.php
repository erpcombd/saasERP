<?php



//



//




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Select Dealer for Demand Order';



$now = date('Y-m-d H:s:i');



$table_master='purchase_sp_master';



$unique='po_no';



$table_detail='purchase_sp_invoice';



$unique_detail='id';












$$unique_master=$_POST[$unique_master];







if(isset($_POST['delete']))



{
		$po_no = $_REQUEST['po_no'];
		$crud   = new crud($table_master);
		
		$delete_pi = "delete from purchase_sp_invoice where po_no='".$po_no."'";
		db_query($delete_pi);
		
		$delete_pr = "delete from purchase_sp_receive where po_no='".$po_no."'";
		db_query($delete_pr);
		
		//$delete_ji = "delete from journal_item where po_no='".$po_no."' and tr_from='Purchase' ";
		//db_query($delete_ji);
		
		$delete_sj = "delete from secondary_journal where tr_id='".$po_no."' and tr_from='Purchase' ";
		db_query($delete_sj);
		
		$delete_jv = "delete from journal where tr_id='".$po_no."' and tr_from='Purchase' ";
		db_query($delete_jv);
		
		
		$condition=$unique."=".$po_no;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$po_no;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Deleted.';


?>
<script language="javascript">
window.location.href = "select_po_for_recheck.php";
</script>
<?
}






if(isset($_POST['confirmm']))



{

 		$po_no = $_REQUEST['po_no'];
		
		$delete_pr = "delete from purchase_sp_receive where po_no='".$po_no."'";
		db_query($delete_pr);
		
		//$delete_ji = "delete from journal_item where po_no='".$po_no."' and tr_from='Purchase' ";
		//db_query($delete_ji);
		
		$delete_sj = "delete from secondary_journal where tr_id='".$po_no."' and tr_from='Purchase' ";
		db_query($delete_sj);
		
		$delete_jv = "delete from journal where tr_id='".$po_no."' and tr_from='Purchase' ";
		db_query($delete_jv);
 
 		$checked_by = $_SESSION['user']['id'];
		$checked_at = date('Y-m-d H:i:s');

		$prevent_multi=find_a_field('purchase_sp_receive','pr_no','po_no='.$po_no);


		$po_all=find_all_field('purchase_sp_master','','po_no='.$po_no);

//$pr_no = date('ym').sprintf('%06d', $po_no);

$pr_no = next_transection_no($po_all->group_for,$po_all->po_date,'purchase_sp_receive','pr_no');	


if ($prevent_multi<1) {


$po_sql = "select m.group_for, m.invoice_no, a.id, a.po_no, a.po_date, a.item_id,  a.warehouse_id, a.vendor_id, b.item_name,a.rate as unit_price, a.pkt_size, a.pkt_unit, a.qty ,a.unit_name,a.amount, m.purchase_type from purchase_sp_invoice a, purchase_sp_master m, item_info b where 
a.po_no=m.po_no and b.item_id=a.item_id and a.po_no='".$po_no."' ORDER by a.id ";

$po_query = db_query($po_sql);	

		while($po_data=mysqli_fetch_object($po_query))

		{
		
		$rec_date=$po_data->po_date;

		
		  $ins_pr_sql = "INSERT INTO `purchase_sp_receive` 
 (`pr_no`, `group_for`, `po_no`, `order_no`, `rec_no`, `rec_date`,  `vendor_id`, `item_id`, `warehouse_id`, `rate`, pkt_size, pkt_unit , `qty`, `unit_name`, `amount`, `qc_by`, `ch_no`, `entry_by`, `entry_at`, status,
 purchase_type) VALUES
('".$pr_no."', '".$po_data->group_for."', '".$po_data->po_no."', '".$po_data->id."', '".$pr_no."', 
 '".$po_data->po_date."',  '".$po_data->vendor_id."', '".$po_data->item_id."' , '".$po_data->warehouse_id."' , 
'".$po_data->unit_price."' ,  '".$po_data->pkt_size."' ,  '".$po_data->pkt_unit."' ,  '".$po_data->qty."' , 
'".$po_data->unit_name."' , '".$po_data->amount."', '0' , '".$po_data->invoice_no."' , '".$checked_by."', 
'".$checked_at."', 'Received', '".$po_data->purchase_type."' )";

db_query($ins_pr_sql);

		
		}



//$ji_sql = "select a.id, a.pr_no, a.rec_date, a.po_no, a.item_id,  a.warehouse_id, a.vendor_id, a.group_for, b.item_name,a.rate as unit_price, a.qty, a.amount,a.unit_name,a.amount from purchase_sp_receive a,item_info b where b.item_id=a.item_id and a.pr_no='".$pr_no."' ORDER by a.id ";
//
//$ji_query = db_query($ji_sql);	
//
//		while($data_ji=mysqli_fetch_object($ji_query))
//
//		{
//		
//		$final_avg_price = moving_average_price_calculation($data_ji->item_id,$data_ji->qty,$data_ji->amount,$data_ji->group_for);
//
//		
//journal_item_control($data_ji->item_id,$data_ji->warehouse_id, $data_ji->rec_date, $data_ji->qty, 0,'Purchase', $data_ji->id, $data_ji->unit_price,'',$pr_no,'','',$data_ji->po_no,
//'','',$data_ji->group_for, $final_avg_price);
//
//		
//		}
		

		 
		  $sql = 'update purchase_sp_master set status="COMPLETED", pr_no="'.$pr_no.'", pr_date="'.$rec_date.'", checked_by="'.$checked_by.'", checked_at="'.$checked_at.'" where po_no = '.$po_no;
		 db_query($sql);

		

auto_insert_purchase_secoundary_journal($pr_no);

		
?>



<?php /*?><?
if($po_no>0)
		{

			echo "<script language='javascript'>window.open('po_print_view.php?po_no=".$po_no."','Chalan Print').focus();</script>";
	
		}
?><?php */?>

<?
	}	
?>



<script language="javascript">
window.location.href = "select_po_for_recheck.php";
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



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>