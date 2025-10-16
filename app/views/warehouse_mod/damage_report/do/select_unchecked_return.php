<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Select Unchecked Return Order';



$page_for = 'Return';

do_calander('#or_date');

do_calander('#quotation_date');



//auto_reinsert_sales_return_secoundary('8894');





$table_master='warehouse_other_receive';

$table_details='warehouse_other_receive_detail';

$unique='or_no';

$$unique = $_POST[$unique];

unset($_SESSION[$unique]);

if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='UNCHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		auto_insert_sales_return_secoundary($$unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';

}



if(isset($_POST['delete']))

{

		

		$crud   = new crud($table_master);

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		$crud   = new crud($table_details);

		$condition=$unique."=".$$unique;

		$crud->delete_all($condition);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Deleted.';

}

auto_complete_start_from_db('dealer_info','dealer_name_e','dealer_code',' canceled="Yes"','dealer');

$target_url = 'item_return.php';

?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

}

</script>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?or_no='+theUrl);

}

</script>

<div class="form-container_large">

  

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>

<tr>
  <th>Return No</th>
  <th>Return Date</th>
  <th>Dealer Name</th>
  <th>Depot</th>
  <th>Return Amt </th>
</tr>





<? 






$res="select * from warehouse_other_receive where status='MANUAL' and receive_type='Return'";
//echo $res;
$query = db_query($res);

while($data = mysqli_fetch_object($query))

{

?>

<tr onClick="custom(<?=$data->or_no;?>);"<?=(++$z%2)?'':'class="alt"';?> >

	<td>&nbsp;<?=$data->or_no;?></td>

	<td>&nbsp;<?=$data->or_date;?></td>

	<td>&nbsp;<?=$data->vendor_name;?></td>

	<td>&nbsp;<?=$data->warehouse_id;?></td>

	<td>&nbsp;<? echo $do_amt = find_a_field('warehouse_other_receive_details','sum(amount)','or_no='.$data->or_no)?></td>
	</tr>

<?

$total_send_amt = $total_send_amt + $do_amt;

$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;

}



?>

<tr class="alt"><td colspan="4"><span style="text-align:right;"> Total: </span></td><td colspan="0"><?=number_format($total_send_amt,2);?></td></tr>



</tbody></table>

</div></td>

</tr>

</table>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>