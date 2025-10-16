<?php
session_start();
ob_start();
$warehouse_id = 3;


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$x = 1;
$sql = 'select * from accounts_ledger where group_for=3 order by ledger_id';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
	$jv_no=next_journal_voucher_id();
	$tr_from = 'Closing';
	$jv_date = strtotime('2014-06-30');
	$narration = 'Closing Balance of 2014-06-30';
	$sql2 = 'select sum(dr_amt-cr_amt) from journal where ledger_id="'.$data->ledger_id.'" and jv_date < "'.strtotime('2014-07-01').'"';
	$query2 = db_query($sql2);
	$data2 = mysqli_fetch_row($query2);
	$amt = $data2[0];
	if($amt<0)
	{
	$dr_amt = (-1)*$amt;
	$cr_amt = 0;
	add_to_journal('', $jv_no, $jv_date, $data->ledger_id, $narration, $dr_amt, $cr_amt, $tr_from, $jv);
	}
	
	if($amt>0)
	{
	$dr_amt = 0;
	$cr_amt = $amt;
	add_to_journal('', $jv_no, $jv_date, $data->ledger_id, $narration, $dr_amt, $cr_amt, $tr_from, $jv);
	}
}
?>