<?php



session_start();



ob_start();




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



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


//$chalan_no = date('ym').sprintf('%06d', $or_no);




$ji_sql = "select a.id, a.po_no, a.po_date, a.item_id,  a.warehouse_id, a.vendor_id, b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='".$po_no."' ORDER by a.id ";

$ji_query = db_query($ji_sql);	

		while($data_ji=mysqli_fetch_object($ji_query))

		{

		
		journal_item_control($data_ji->item_id,$data_ji->warehouse_id, $data_ji->po_date, $data_ji->qty, 0,'Purchase', $data_ji->id, $data_ji->unit_price,'',$po_no);

		
		}
		
		
		
		if($po_no>0)
		{
		auto_insert_purchase_secoundary_journal($po_no);
		}




		 $sql = 'update purchase_master set status="COMPLETED", checked_by="'.$checked_by.'",
		  checked_at="'.$checked_at.'" where po_no = '.$po_no;
		db_query($sql);

		


		
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