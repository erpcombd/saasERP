<?php
require_once "../../../assets/template/layout.top.php";
$title='Select Vendor For Purchase Return';

$page_for = 'Purchase_Return';
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
		//auto_insert_sales_return_secoundary($$unique);
		
		$or_no = $$unique;

$tr_from = 'Purchase_Return';
$group_for = $_SESSION['user']['group'];
$or = find_all_field('warehouse_other_receive','',"or_no=".$or_no);
$narration = 'Purchase Return PR#'.$or_no.' MSL#'.$or->manual_or_no.' Send Date#'.$or->receive_date.' ';
$chalan_date = $or->actual_receive_date;
$jv_date = $or->or_date;
$vendor= find_all_field('vendor','*',"vendor_id=".$or->vendor_id);
$vendor_ledger = $vendor->ledger_id;
$tr_no = $or_no;
$jv_no=next_journal_sec_voucher_id('','Purchase_Return',$vendor->depot);

//$acc_code = find_all_field_sql("select c.id,w.ledger_id from warehouse w, cost_center c where w.acc_code=c.cc_code and w.warehouse_id=".$or->warehouse_id);
//$cc_code = ($acc_code->id>0)?$acc_code->id:'0';

//$return_ledger = find_all_field('config_group_class','Purchase_Return',"group_for=".$_SESSION['user']['group']);

//$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
//$dealer_ledger= $vendor->account_code;
$proj_id = 'Clouderp';

$sql ="select a.amount as total_amt,a.id,a.or_no,a.or_date,a.vendor_id,a.item_id,a.qty,s.ledger_id_2 from item_sub_group s,item_info i, warehouse_other_receive_detail a where i.sub_group_id=s.sub_group_id and a.item_id=i.item_id and  or_no=".$or_no;
$query = mysql_query($sql);
$i==0;
while($ch_data = mysql_fetch_object($query))
{
$tr_id = $ch_data->id;
$total_amount += $ch_data->total_amt;
//debit	
//$cogs_rate = find_a_field('journal_item', '(sum(item_in*final_price)-sum(item_ex*final_price))/(sum(item_in)-sum(item_ex))', 'item_id = "'.$row->item_id.'" and warehouse_id = "'.$_SESSION['user']['depot'].'"');
//$cogs_amt = $cogs_rate*$ch_data->qty;
add_to_sec_journal($proj_id, $jv_no, $jv_date,$vendor_ledger, $narration, ($total_amount), '0', $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->sales_return, $narration, ($ch_data->total_amt), '0', $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->cogs_ledger, $narration,'0', ($cogs_amt),  $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
}
add_to_sec_journal($proj_id, $jv_no, $jv_date, $ch_data->ledger_id_2, $narration, '0',($total_amount),  $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);





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
auto_complete_from_db('vendor','vendor_name','vendor_id',' 1','vendor');
?>
<script language="javascript">
window.onload = function() {document.getElementById("do").focus();}
</script>
<div class="form-container_large">
<form action="item_return.php" method="post" name="codz" id="codz">
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
    <td align="right" bgcolor="#FF9966"><strong>Active Vendor List: </strong></td>
    <td bgcolor="#FF9966"><strong>

<?
$query = "select a.do_no,b.dealer_code,b.dealer_name_e from sale_do_master a,dealer_info b where b.dealer_code=a.dealer_code and a.status ='PROCESSING' and b.depot=".$_SESSION['user']['depot']."  order by a.do_no";
?>
<input name="vendor" type="text" id="vendor"  class="form-control"/>
    </strong></td>
    <td bgcolor="#FF9966" align="center"><strong>
      <input type="submit" name="submitit" id="submitit" value="Return Receive" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090" class="form-control"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
require_once "../../../assets/template/layout.bottom.php";
?>