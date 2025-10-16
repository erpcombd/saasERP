<?
//
require "../../support/inc.all.php";

$i = 0;
$jv_date = '1514656800';
$jv_no = '17123100000100';
$entry_time = date('Y-m-d H:i:s');
$sql = 'select ledger_id,sum(dr_amt-cr_amt) qty from journal where jv_date<"1514743200" and group_for = 2 and (ledger_id like "1%" or ledger_id like "2%") group by ledger_id ';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
if($data->qty<>0)
{
$ledger_id[$i] 	  = $data->ledger_id;
$qty = $data->qty;
if($data->qty>0)
{

$item_in1[$i] =  0;
$item_ex1[$i] =  $qty;
$item_in2[$i] =  $qty;
$item_ex2[$i] =  0;
}
else
{
$qty = $data->qty*(-1);
$item_in1[$i] =  $qty;
$item_ex1[$i] =  0;
$item_in2[$i] =  0;
$item_ex2[$i] =  $qty;
}

$i++;
}
}

for($p=0;$p<$i;$p++)
{

	
	 $journal="INSERT INTO `journal` (
	`jv_no` ,
	`jv_date` ,
	`ledger_id` ,
	`narration` ,
	`dr_amt` ,
	`cr_amt` ,
	`tr_from` 
	)VALUES ('$jv_no', '$jv_date', '".$ledger_id[$p]."', 'Closing-2017', '".$item_in1[$p]."', '".$item_ex1[$p]."', 'Closing-2017')";
	$query_journal=db_query($journal);
	
	 $journal="INSERT INTO `journal` (
	`jv_no` ,
	`jv_date` ,
	`ledger_id` ,
	`narration` ,
	`dr_amt` ,
	`cr_amt` ,
	`tr_from` 
	)VALUES ('$jv_no', '$jv_date', '".$ledger_id[$p]."', 'Opening-2018', '".$item_in2[$p]."', '".$item_ex2[$p]."', 'Opening-2018')";
	$query_journal=db_query($journal);

}

?>