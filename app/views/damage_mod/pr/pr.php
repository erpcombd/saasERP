<?php
session_start();
ob_start();
require_once "../../support/inc.all.php";


$sql = 'select a.* from purchase_receive a,vendor b where a.vendor_id=b.vendor_id and b.group_for=3 and a.rec_date>"2013-12-31"';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
if($data->po_no != $old_po)
$jv=next_journal_voucher_id();
++$x;
	$vendor_ledger = find_a_field('vendor','ledger_id',"vendor_id=".$data->vendor_id);
	$sub_group_ledger_sql= "select s.ledger_id from item_sub_group s,item_info i where i.item_id='".$data->item_id."' and i.sub_group_id=s.sub_group_id";
	$sub_group_ledger= find_a_field_sql($sub_group_ledger_sql);
	
	

		
		auto_insert_purchase($jv,$data->rec_date,$vendor_ledger,$sub_group_ledger,$data->pr_no,$data->amount,$data->po_no,$data->id);
$old_po = $data->po_no;
}
echo $x;
?>