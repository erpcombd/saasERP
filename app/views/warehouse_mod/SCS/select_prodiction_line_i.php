
<?php
session_start();



ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Depot To Depot Product Transfer';

//--- START SMS FUNCTION
// function sms($dest_addr,$sms_text){
// $url = "http://api.rankstelecom.com/api/v3/sendsms/plain?user=sajeebcorp&password=Sajeeb3636&sender=8804445648540";
// $sms_text="&SMSText=".$sms_text;
// $gsm="&gsm=".$dest_addr;
// $postdata=$url.$sms_text.$gsm;
// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $result = curl_exec($ch);}
// -- END SMS FUNCTION



$table_master='production_issue_master';
$unique_master='pi_no';

$table_detail='production_issue_detail';
$unique_detail='id';

$$unique_master=$_POST[$unique_master];



if(isset($_POST['confirm'])){

		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='MANUAL';
		$pi = find_all_field('production_issue_master','pi_no','pi_no='.$$unique_master);

// bin card entry		
//$sql = 'select a.id,b.finish_goods_code as code,b.item_name,b.item_id,a.old_production_date,a.total_unit,a.total_unit%b.pack_size as pcs_qty,a.pi_date,a.unit_price
//		from production_issue_detail a,item_info b 
//		where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';
//		$query = db_query($sql);
//		while($data=mysqli_fetch_object($query)){
//journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->pi_date,0,$data->total_unit,'Transit',$data->id,$data->unit_price,$_SESSION['line_id'],$$unique_master);
//}		
		

// ----------------- Secondary Journal

// HFL TO Sajeeb Store change by kamrul

//if($_SESSION['user']['depot']==5&&($pi->warehouse_to==17||$pi->warehouse_to==68))
//		{
//		$ledger_dr = '1097000300010002';
//		$sales_ledger = '3002000100070000';
//		$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
//		auto_insert_sale_sc_out($pi->pi_date,$ledger_dr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
//
//		}
//		elseif($_SESSION['user']['depot']==17)
//		{
//		$sales_ledger = '3028000100010000';
//		
//		if($pi->warehouse_to==5)
//		$ledger_dr = '1126000200010000';
//		else
//		$ledger_dr = '1126000200020000';
//		
//		//$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$_SESSION['user']['depot']);
//		//$ledger_dr = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);	
//		$narration = 'PI No-'.$pi_no.'||SendDt:'.$pi->pi_date;
//		auto_insert_sale_sc_out($pi->pi_date,$ledger_dr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
//		}
//		elseif($_SESSION['user']['depot']==68) // flour mill to 
//		{
//		$ledger_cr = '3026000100050000';
//		
//		if($pi->warehouse_to==5)
//		$sales_ledger = '1116000200010000';
//		if($pi->warehouse_to==17)
//		$sales_ledger = '1116000300010000';
//		else
//		$sales_ledger = '1119000100050002'; // sajeeb
//
//		$narration = 'PI No-'.$pi_no.'||SendDt:'.$pi->pi_date;
//		auto_insert_sale_sc_out($pi->pi_date,$sales_ledger,$ledger_cr,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
//		}
//		else
//		{
//		
//		
//		$ledger_cr = '1078000200010000'; // Goods in transit
//		$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$_SESSION['user']['depot']);
//		if($_SESSION['user']['depot']==51) // damage section
//		$sales_ledger = '4026000100020000';
//		else
//		$sales_ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);	
//		$narration = 'PI No-'.$pi_no.'||SendDt:'.$pi->pi_date;
//		auto_insert_store_transfer_issue($pi->pi_date,$ledger_cr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
//
//		}
		

		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Send.';



// --- START SMS sending process
/*$from = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);
$to_store = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['line_id']);
$mobile = find_a_field('warehouse','mobile_no','warehouse_id='.$_SESSION['line_id']);
$number_check = substr($mobile, 0, 2);
if ($number_check == '88') {
$dest_addr = $mobile;
$sms_text ='PI No:'.$pi->pi_no.',
Date:'.$pi->pi_date.',
'.$pi->carried_by.',
'.$from.' to '.$to_store;

sms($dest_addr,$sms_text);
//sms('8801611111884',$sms_text);
}*/
// end sms process


}

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}


?>
<script language="javascript">
window.onload = function() {document.getElementById("dealer").focus();}
</script>
<div class="form-container_large">
<form action="production_issue.php" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
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
    <td align="right" bgcolor="#FF9966"><strong>Select Depot: </strong></td>
    <td bgcolor="#FF9966"><strong>
<select name="line_id" id="line_id" style="width:200px;" required>
<option></option>
<?
foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['line_id'],'1');
?>

</select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Create PI" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>
</form>

</div>

<p><br><p><br><p><br>
<center>
<h2>Unfinished PI List</h2>



<?
$unique = 'req_no'; 
$target_url = '../SCS/print_view.php';
?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<?
$res='SELECT p.pi_no,p.pi_no,p.pi_date,p.remarks,
(select w.warehouse_name from warehouse w where w.warehouse_id=p.warehouse_to) as destination,p.carried_by,p.entry_at,p.entry_by 
FROM production_issue_master p
where p.warehouse_from="'.$_SESSION['user']['depot'].'" and p.status="MANUAL"
and p.warehouse_to in (3,6,7,8,9,10,11,54,89,90,68,51)
and p.pi_date>"2019-01-01"
';
echo link_report($res,'print_view.php');
?>
</div></td>
</tr>
</table>












<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>