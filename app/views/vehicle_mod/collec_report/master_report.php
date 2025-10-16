<?

session_start();
require_once "../../../assets/support/inc.all.php";
$deler_arr=explode("--",$_POST['cust_id']);
 $del_id=$deler_arr[1];
date_default_timezone_set('Asia/Dhaka');
		function ssd($qty,$pk,$colour='')
		{
		if($colour!='') $c = 'bgcolor="'.$colour.'" ';
		echo '
		<td '.$c.'>'.(int)($qty/$pk).'</td>
		<td '.$c.'>'.($qty%$pk).'</td>
		<td '.$c.'>'.(int)$qty.'</td>
			';
		}
if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
		$t_date=$_POST['t_date'];
		$f_date=$_POST['f_date'];
		
		$to_date=$_POST['t_date'];
		$fr_date=$_POST['f_date'];
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../../assets/css/report.css" type="text/css" rel="stylesheet" />
<style>
*{
	font-size:
	}
h2, h3, h4 {
	text-align:center;
	}
</style>


<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>



<style type="text/css">
.vertical-text {
	transform: rotate(270deg);
	transform-origin: left top 1;
	float:left;
	width:2px;
	padding:1px;
	font-size:10px;
	font-family:Arial, Helvetica, sans-serif;
}
.style1 {font-weight: bold}
.style2 {font-weight: bold}
.style3 {font-weight: bold}

h3 { margin:0; padding:0; font-weight: 700;}
.style4 {font-weight: bold}
.style5 {font-weight: bold}
.style6 {font-weight: bold}
.style7 {font-weight: bold}
</style>
</head>
<body>
<div align="center" id="pr">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div>







<?

		
if($_POST['report']==1) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Sales Report (Challan Wise)</h2></div>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</tr>

<tr>
<th style="text-align:center;" >S/L</th>
<th style="text-align:center;" >Challan No</th>
<th style="text-align:center;" >Invoice No</th>
<th style="text-align:center;" >Challan Date</th>
<th style="text-align:center;" >Customer Code</th>
<th style="text-align:center;" >Name of Customer</th>
<th style="text-align:center;" >Opening Balance</th>
<th style="text-align:center;" >Collection</th>
<th style="text-align:center;" >Return</th>
<th style="text-align:center;" >Total Sale</th>
<th style="text-align:center;" >Adjustment</th>
<th style="text-align:center;" >Closing Balance</th>
<th style="text-align:center;" >Phone Number</th>
<th style="text-align:center;" >Remarks</th>
</tr>
</thead><tbody>
<?php
if($del_id!=''){
$del_con="and dealer_code='".$del_id."'";
}

$ssql =  mysql_query('select ledger_id,sum(cr_amt-dr_amt) amt from journal where  "'.$del_con.'" and tr_from="Journal" group by ledger_id');
while($jv_data = mysql_fetch_object($ssql))
{
$jv_amt[$jv_data->ledger_id] = $jv_data->amt;
}

$ssql2 =  mysql_query('select ledger_id,sum(cr_amt) amt from journal where jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Receipt" group by ledger_id');
while($jv_data2 = mysql_fetch_object($ssql2))
{
$jv_amt2[$jv_data2->ledger_id] = $jv_data2->amt;
}

$ssql3 =  mysql_query('select ledger_id,sum(cr_amt) amt from journal where jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="SalesReturn" group by ledger_id');
while($jv_data3 = mysql_fetch_object($ssql3))
{
$jv_amt3[$jv_data3->ledger_id] = $jv_data3->amt;
}

  //$journal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"');
  
  $sql="select * from sale_do_chalan where chalan_date between '".$f_date."' and '".$t_date."' ".$del_con." and chalan_no in(select tr_no from journal where tr_from='Sales') group by chalan_no";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
$all_del_info=find_all_field('dealer_info','','dealer_code="'.$row->dealer_code.'"');
 $id=find_a_field('journal','id','ledger_id="'.$all_del_info->account_code.'" and tr_no="'.$row->chalan_no.'"');

 $opening_bal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and id < "'.$id.'"');
//$collection=0;
//if($old_ledger_code!=$all_del_info->account_code)
// $collection=find_a_field('journal','sum(cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$row->chalan_date.'" and "'.$row->chalan_date.'" and tr_from="Receipt"');
 
 //$journal=0;
 //if($old_ledger_code!=$all_del_info->account_code)
 // $journal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"');
// echo 'select sum(dr_amt-cr_amt) from journal where ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"';
 $collection = $jv_amt2[$all_del_info->account_code]; $jv_amt2[$all_del_info->account_code] = 0;
$journal = $jv_amt[$all_del_info->account_code]; $jv_amt[$all_del_info->account_code] = 0;
$return = $jv_amt3[$all_del_info->account_code]; $jv_am3t[$all_del_info->account_code] = 0;
//if($old_ledger_code!=$all_del_info->account_code)
//$return=find_a_field('journal','sum(cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="SalesReturn"');

//$tot_sale=find_a_field('sale_do_chalan','sum(total_amt)','chalan_no="'.$row->chalan_no.'" ');
$tot_sale=find_a_field('journal','sum(dr_amt)','tr_no="'.$row->chalan_no.'" and tr_from="Sales" ');
//echo 'select sum(dr_amt) from journal where tr_no="'.$row->chalan_no.'" and tr_from="Sales"  ';
$clos_bal=($opening_bal-$collection-$return-$journal)+$tot_sale;
if($clos_bal<1){$bal_status="(Cr)";}else{$bal_status="(Dr)";}

?>
<tr>
<td><?=$i++;?></td>
<td style="text-align:left;" ><?=$row->chalan_no_another?></td>
<td style="text-align:left;" ><?=$row->chalan_no?></td>
<td style="text-align:left;" ><?=date("d-m-Y",strtotime($row->chalan_date))?></td>
<td style="text-align:left;" ><?=$row->dealer_code?></td>
<td style="text-align:left;"><?=$all_del_info->dealer_name_e;?></td>
<td style="text-align:right;"><?php echo number_format($opening_bal,2);?></td>
<td style="text-align:right;" ><?php 
echo number_format($collection,0);
?></td>
<td style="text-align:right;" ><?=number_format($return,2);?></td>
<td style="text-align:right;" ><?php echo number_format($tot_sale,2);?></td>
<td style="text-align:right;" ><?=number_format($journal,2);?></td>
<td style="text-align:right;" ><?php echo number_format($clos_bal,2);?></td>
<td style="text-align:right;" ><?=find_a_field('dealer_info','mobile_no','dealer_code="'.$row->dealer_code.'"')?></td>
<td></td>
</tr>
<?php 
$grand_tot_sale+=$tot_sale;
$grand_tot_col+=$collection;
$grand_tot_ret+=$return;
$old_ledger_code=$all_del_info->account_code;
$gr_journal+=$journal;
} 

?>
<tr>
<td colspan="6" style="text-align:right;"><b>Grand Total =</b></td>
<td></td>
<td style="text-align:right;font-weight:bold;"><?=number_format($grand_tot_col,2)?></td>
<td style="text-align:right;font-weight:bold;" ><?=number_format($grand_tot_ret,2)?></td>

<td style="text-align:right;font-weight:bold;"  ><?=number_format($grand_tot_sale,2)?></td>
<td style="text-align:right;font-weight:bold;"><?=number_format($gr_journal,2)?></td>
<td></td>
<td></td>
<td></td>
</tr>
<?

}


if($_POST['report']==4234234423) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Sales Report (Challan Wise)</h2></div>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</tr>

<tr>
<th style="text-align:center;" >S/L</th>
<th style="text-align:center;" >Challan No</th>
<th style="text-align:center;" >Invoice No</th>
<th style="text-align:center;" >Challan Date</th>
<th style="text-align:center;" >Customer Code</th>
<th style="text-align:center;" >Name of Customer</th>
<th style="text-align:center;" >Total Sale</th>
<th style="text-align:center;" >Phone Number</th>
<th style="text-align:center;" >Remarks</th>
</tr>
</thead><tbody>
<?php
if($del_id!=''){
$del_con="and dealer_code='".$del_id."'";
}

$ssql =  mysql_query('select ledger_id,sum(cr_amt-dr_amt) amt from journal where  "'.$del_con.'" and tr_from="Journal" group by ledger_id');
while($jv_data = mysql_fetch_object($ssql))
{
$jv_amt[$jv_data->ledger_id] = $jv_data->amt;
}

$ssql2 =  mysql_query('select ledger_id,sum(cr_amt) amt from journal where jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Receipt" group by ledger_id');
while($jv_data2 = mysql_fetch_object($ssql2))
{
$jv_amt2[$jv_data2->ledger_id] = $jv_data2->amt;
}

$ssql3 =  mysql_query('select ledger_id,sum(cr_amt) amt from journal where jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="SalesReturn" group by ledger_id');
while($jv_data3 = mysql_fetch_object($ssql3))
{
$jv_amt3[$jv_data3->ledger_id] = $jv_data3->amt;
}

  //$journal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"');
  
 echo $sql="select * from sale_do_chalan where chalan_date between '".$f_date."' and '".$t_date."' ".$del_con." and chalan_no in(select tr_no from journal where tr_from='Sales') group by chalan_no";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
$all_del_info=find_all_field('dealer_info','','dealer_code="'.$row->dealer_code.'"');
 $id=find_a_field('journal','id','ledger_id="'.$all_del_info->account_code.'" and tr_no="'.$row->chalan_no.'"');

 $opening_bal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and id < "'.$id.'"');
//$collection=0;
//if($old_ledger_code!=$all_del_info->account_code)
// $collection=find_a_field('journal','sum(cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$row->chalan_date.'" and "'.$row->chalan_date.'" and tr_from="Receipt"');
 
 //$journal=0;
 //if($old_ledger_code!=$all_del_info->account_code)
 // $journal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"');
// echo 'select sum(dr_amt-cr_amt) from journal where ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"';
 $collection = $jv_amt2[$all_del_info->account_code]; $jv_amt2[$all_del_info->account_code] = 0;
$journal = $jv_amt[$all_del_info->account_code]; $jv_amt[$all_del_info->account_code] = 0;
$return = $jv_amt3[$all_del_info->account_code]; $jv_am3t[$all_del_info->account_code] = 0;
//if($old_ledger_code!=$all_del_info->account_code)
//$return=find_a_field('journal','sum(cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="SalesReturn"');

//$tot_sale=find_a_field('sale_do_chalan','sum(total_amt)','chalan_no="'.$row->chalan_no.'" ');
$tot_sale=find_a_field('journal','sum(dr_amt)','tr_no="'.$row->chalan_no.'" and tr_from="Sales" ');
//echo 'select sum(dr_amt) from journal where tr_no="'.$row->chalan_no.'" and tr_from="Sales"  ';
$clos_bal=($opening_bal-$collection-$return-$journal)+$tot_sale;
if($clos_bal<1){$bal_status="(Cr)";}else{$bal_status="(Dr)";}

?>
<tr>
<td><?=$i++;?></td>
<td style="text-align:left;" ><?=$row->chalan_no_another?></td>
<td style="text-align:left;" ><?=$row->chalan_no?></td>
<td style="text-align:left;" ><?=date("d-m-Y",strtotime($row->chalan_date))?></td>
<td style="text-align:left;" ><?=$row->dealer_code?></td>
<td style="text-align:left;"><?=$all_del_info->dealer_name_e;?></td>
<td style="text-align:right;" ><?php echo number_format($tot_sale,2);?></td>
<td style="text-align:right;" ><?=find_a_field('dealer_info','mobile_no','dealer_code="'.$row->dealer_code.'"')?></td>
<td></td>
</tr>
<?php 
$grand_tot_sale+=$tot_sale;
$grand_tot_col+=$collection;
$grand_tot_ret+=$return;
$old_ledger_code=$all_del_info->account_code;
$gr_journal+=$journal;
} 

?>
<tr>
<td colspan="6" style="text-align:right;"><b>Grand Total =</b></td>
<td style="text-align:right;font-weight:bold;"><?=number_format($grand_tot_col,2)?></td>
<td></td>
<td></td>
</tr>
<?

}




elseif($_POST['report']==1010) 



{



?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>
<tr>
<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Sales Report (Challan Wise)</h2></div>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</tr>

<tr>
<th style="text-align:center;">S/L</th>
<th style="text-align:center;">Customer Code</th>
<th style="text-align:center;">Name of Customer</th>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">Invoice No</th>
<th style="text-align:center;">Challan No</th>
<!--<th style="text-align:center;">Order Value</th>
<th style="text-align:center;">VAT</th>
<th style="text-align:center;">Transport</th>-->
<th style="text-align:center;">Total Sales</th>
<th style="text-align:center;">Phone Number</th>
<th style="text-align:center; width:225px">Remarks</th>


</tr>
</thead>
<tbody>
<?php 

$cust_id_get=$_POST['cust_id'];
	$test=explode('--',$cust_id_get);
	
	 $cust_id=$test[1];
	 if($cust_id){
	 $con='and dealer_code="'.$cust_id.'"';
	 }


  $sql='select * from sale_do_chalan where chalan_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" '.$con.' group by chalan_no ';
$query=mysql_query($sql);
while($data=mysql_fetch_object($query)){
?>
<tr>
	<td><?=++$i?></td>
	<td align="center"><?=$data->dealer_code;?></td>
	<td align="left"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
	<td><?php echo  date("d-m-Y",strtotime($data->chalan_date));?></td>
	<td align="center"><?=$data->chalan_no;?></td>
	<td align="center"><a href="chalan_bill_corporate1.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no_another?></a></td>
	
	<td style="text-align:right;"><?php echo $chalan_amt=find_a_field('secondary_journal','sum(cr_amt)','  tr_from="Sales" and tr_no="'.$data->chalan_no.'"'); ?></td>
	
	
	<?php /*?><td style="text-align:right;"><?php echo $vat=find_a_field('secondary_journal','sum(cr_amt)',' jv_date between  "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and ledger_id="3215005000020000" and tr_from="Sales" and tr_no="'.$data->chalan_no.'"');?></td>
	
	<td style="text-align:right;"><?php echo $transport=find_a_field('secondary_journal','sum(cr_amt)',' jv_date between  "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and ledger_id="5310011000000000" and tr_from="Sales" and tr_no="'.$data->chalan_no.'"'); ?></td>
	
	<td style="text-align:right;"><?php echo number_format($tot_sale=$chalan_amt+$vat+$transport,2); ?></td><?php */?>
	<td align="center"><?=find_a_field('dealer_info','mobile_no','dealer_code="'.$data->dealer_code.'"')?></td>
	<td><?=$data->remarks;?></td>
	
</tr>
<?php
$gr_tot_chalan_qty+=$chalan_qty;
$gr_tot_chalan+=$chalan_amt;
$gr_tot_vat+=$vat;
$gr_tot_transport+=$transport;
$gr_tot_sale+=$tot_sale;
$gr_tot_sale_acc+=$tot_sale_acc;
$gr_tot_sale_acc_pending+=$tot_sale_acc_pending;
 } ?>
 <tr>
 	<th colspan="6" style="text-align:right;">Total</th>
		<th style="text-align:right;"><?=number_format($gr_tot_chalan,2)?></th>
	<th></th>
	<th></th>
	
 </tr>
</tbody>
</table>


  <?




}


		
else if($_POST['report']==111) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>
<td style="border:0px;" colspan="12">

<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Daily Delivery Wise Sales Report</h2></div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td>
</tr>
<thead>
<tr>
<th>S/L</th>
<th>Name of Customer</th>
<th>Customer Code</th>
<th>Date</th>
<th>Challan No</th>
<th>Bill No/SO No</th>
<th>Opening Balance</th>

<th>Total Sale</th>
<th>Closing Balance</th>
<th>Phone Number</th>
<th>Remarks</th>
</tr>
</thead><tbody>
<?php
if($del_id!=''){
$del_con="and dealer_code='".$del_id."'";
}
 $sql="select * from sale_do_chalan where chalan_date between '".$f_date."' and '".$t_date."' ".$del_con." group by chalan_no";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
$all_del_info=find_all_field('dealer_info','','dealer_code="'.$row->dealer_code.'"');
 $id=find_a_field('journal','id','ledger_id="'.$all_del_info->account_code.'" and tr_no="'.$row->chalan_no.'"');
$opening_bal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and id<"'.$id.'"');


$tot_sale=find_a_field('sale_do_chalan','sum(total_amt)','chalan_no="'.$row->chalan_no.'" ');
$clos_bal=$opening_bal-$tot_sale;
if($clos_bal<1){$bal_status="(Cr)";}else{$bal_status="(Dr)";}
?>
<tr>
<td><?=$i++;?></td>
<td><?=$all_del_info->dealer_name_e;?></td>
<td><?=$row->dealer_code?></td>
<td><?=$row->chalan_date?></td>
<td><?=$row->chalan_no?></td>
<td><?=$row->do_no ?></td>
<td><?php echo $opening_bal;?></td>

<td><?php echo $tot_sale;?></td>
<td><?php echo $clos_bal.$bal_status;?></td>
<td><?=find_a_field('dealer_info','mobile_no','dealer_code="'.$row->dealer_code.'"')?></td>
<td></td>
</tr>
<?php 
$grand_tot_sale+=$tot_sale;
} ?>
<tr>
<td colspan="7" style="text-align:right;"><b>Grand Total =</b></td>

<td><?=$grand_tot_sale?></td>
<td></td>
<td></td>
<td></td>
</tr>
<?

}

elseif($_POST['report']==11) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Sales Order Report(Customer Wise In Amount)</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</tr>

<tr >
<th style="text-align:center;">S/L</th>
<th style="text-align:center;">Name of Customer</th>
<th style="text-align:center;">Customer Code</th>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">SO No</th>
<!--<th>Advance</th>-->
<th style="text-align:center;">Total Order Amount (Approved)</th>
<th style="text-align:center;">Total Order Amount<br />  (Unapproved Accounts)</th>
<th style="text-align:center;">Total Order Amount<br />  (Unapproved Sales)</th>
<th style="text-align:center;">Total Order Amount</th>
<th style="text-align:center;">Phone Number</th>
<th style="text-align:center;" >Remarks</th>
</tr>
</thead><tbody>
<?php
if($del_id!=''){
$del_con="and dealer_code='".$del_id."'";
}

  $sql="select * from sale_do_master where do_date between '".$f_date."' and '".$t_date."' and status!='MANUAL' group by do_no";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
$all_del_info=find_all_field('dealer_info','','dealer_code="'.$row->dealer_code.'"');
?>
<tr>
<td style="text-align:left;" ><?=$i++;?></td>
<td style="text-align:left;"><?=$all_del_info->dealer_name_e;?></td>
<td style="text-align:left;"><?=$row->dealer_code?></td>
<td style="text-align:left;"><?=date("d-m-Y",strtotime($row->do_date))?></td>

<td style="text-align:left;"><?=$row->do_no ?></td>

<!--<td style="text-align:right;"><?=find_a_field('sale_do_master','rcv_amt','do_no="'.$row->do_no.'"');?></td>-->
<td style="text-align:right;" ><?=number_format($tot_sale_approv=find_a_field('sale_do_details d,sale_do_master m','sum(d.total_amt)','m.do_no="'.$row->do_no.'" and m.do_no=d.do_no and m.status not in("MANUAL","ACC_APPROVE","VERIFIED_SO")'),2);?></td>
<td style="text-align:right;" ><?=number_format($tot_sale_unapacc=find_a_field('sale_do_details d,sale_do_master m','sum(d.total_amt)','m.do_no="'.$row->do_no.'" and m.do_no=d.do_no and m.status in("ACC_APPROVE")'),2);?></td>
<td style="text-align:right;" ><?=number_format($tot_sale_unapsale=find_a_field('sale_do_details d,sale_do_master m','sum(d.total_amt)','m.do_no="'.$row->do_no.'" and m.do_no=d.do_no and m.status  in("VERIFIED_SO")'),2);?></td>
<td style="text-align:right;" ><?=number_format($tot_sale=find_a_field('sale_do_details','sum(total_amt)','do_no="'.$row->do_no.'"'),2);?></td>

<td style="text-align:right;"><?=find_a_field('dealer_info','mobile_no','dealer_code="'.$row->dealer_code.'"')?></td>
<td></td>

</tr>
<?php 
$grand_tot_sale+=$tot_sale;
$grand_tot_sale_approv+=$tot_sale_approv;
$grand_tot_sale_unapacc+=$tot_sale_unapacc;
$grand_tot_sale_unappsale+=$tot_sale_unapsale;
} ?>
<tr>
<td colspan="5" style="text-align:right;"><b>Grand Total =</b></td>

<td style="text-align:right;font-weight:bold;"><?=number_format($grand_tot_sale_approv,2)?></td>
<td style="text-align:right;font-weight:bold;"><?=number_format($grand_tot_sale_unapacc,2)?></td>
<td style="text-align:right;font-weight:bold;"><?=number_format($grand_tot_sale_unappsale,2)?></td>
<td style="text-align:right;font-weight:bold;"><?=number_format($grand_tot_sale,2)?></td>
<td></td>
<td></td>
</tr>
<?

}


elseif($_POST['report']==353465346) 



{
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>
<tr>
<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Invoice Maturity Report</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</tr>

<tr>
<th style="text-align:center;">S/L</th>
<th style="text-align:center;">Invoice No</th>
<th style="text-align:center;">Invoice Date</th>
<th style="text-align:center;">Challan No</th>
<th style="text-align:center;">SO No</th>
<th style="text-align:center;">PO No</th>
<th style="text-align:center;">Bill Receiving Date</th>
<th style="text-align:center;">Maturity Date</th>
<th style="text-align:center;">Customer Code</th>
<th style="text-align:center;">Customer Name</th>
<th style="text-align:center;">Challan Amount</th>
<th style="text-align:center;">VAT</th>
<th style="text-align:center;">Transport</th>
<th style="text-align:center;">Total Sales</th>
<th style="text-align:center;">Total Sales(Accounts Approved)</th>
<th style="text-align:center;">Total Sales(Accounts Approval Pending)</th>
<th style="text-align:center;">Bill Maturity Days</th>
</tr>
</thead>
<tbody>
<?php 

$cust_id_get=$_POST['cust_id'];
	$test=explode('--',$cust_id_get);
	
	 $cust_id=$test[1];
	 if($cust_id){
	 $con='and dealer_code="'.$cust_id.'"';
	 }


 $sql='select * from sale_do_chalan where bill_maturity_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" '.$con.' and status="COMPLETED" group by chalan_no ';
$query=mysql_query($sql);
while($data=mysql_fetch_object($query)){
?>
<tr>
	<td><?=++$i?></td>
	<td><a href="../../../acc_mod/pages/challan_list/invoice.php?v_no=<?=$data->chalan_no?>" target="_blank"><?=$data->chalan_no?></a></td>
	<td><?php echo  date("d-m-Y",strtotime($data->chalan_date));?></td>
	<td><?=$data->chalan_no_another?></td>
	<td><?=$data->do_no?></td>
	<td><?=find_a_field('sale_do_master','po_no','do_no='.$data->do_no)?></td>
		<td><?php echo  date("d-m-Y",strtotime($data->bill_rec_date));?></td>
	<td><?php echo  date("d-m-Y",strtotime($data->bill_maturity_date));?></td>
	<td><?=$data->dealer_code;?></td>
	<td><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
	<td style="text-align:right;"><?php echo number_format($chalan_amt=find_a_field('sale_do_chalan','sum(total_amt)','chalan_no="'.$data->chalan_no.'"'),2);?></td>
	<td style="text-align:right;"><?=number_format($vat=find_a_field('secondary_journal','sum(cr_amt)',' jv_date between  "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and ledger_id="3215005000020000" and tr_from="Sales" and tr_no="'.$data->chalan_no.'"'),2);?></td>
	<td style="text-align:right;"><?=number_format($transport=find_a_field('secondary_journal','sum(cr_amt)',' jv_date between  "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and ledger_id="5310011000000000" and tr_from="Sales" and tr_no="'.$data->chalan_no.'"'),2);?></td>
	<td style="text-align:right;"><?php echo number_format($tot_sale=$chalan_amt+$vat+$transport,2); ?></td>
	<td style="text-align:right;"><?=number_format($tot_sale_acc=find_a_field('journal','sum(dr_amt)',' jv_date between  "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and tr_no="'.$data->chalan_no.'" and tr_from="Sales" '),2);?></td>
		<td style="text-align:right;"><?=number_format($tot_sale_acc_pending=find_a_field('secondary_journal','sum(dr_amt)',' jv_date between  "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" and tr_no="'.$data->chalan_no.'" and tr_from="Sales" and checked="" '),2);?></td>
	<td><?=find_a_field('dealer_info','bill_maturity_days','dealer_code='.$data->dealer_code);?></td>

</tr>
<?php
$gr_tot_chalan+=$chalan_amt;
$gr_tot_vat+=$vat;
$gr_tot_transport+=$transport;
$gr_tot_sale+=$tot_sale;
$gr_tot_sale_acc+=$tot_sale_acc;
$gr_tot_sale_acc_pending+=$tot_sale_acc_pending;
 } ?>
 <tr>
 	<th colspan="10" style="text-align:right;">Total</th>
	<th style="text-align:right;"><?=number_format($gr_tot_chalan,2)?></th>
	<th style="text-align:right;"><?=number_format($gr_tot_vat,2)?></th>
	<th style="text-align:right;"><?=number_format($gr_tot_transport,2)?></th>
	<th style="text-align:right;"><?=number_format($gr_tot_sale,2)?></th>
	<th style="text-align:right;"><?=number_format($gr_tot_sale_acc,2)?></th>
	<th style="text-align:right;"><?=number_format($gr_tot_sale_acc_pending,2)?></th>
	<th></th>
 </tr>
</tbody>
</table>


  <?







}


elseif($_POST['report']==2) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>

<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Customer Wise Cash Collection Report</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</tr>

<thead>
<tr>
<th style="text-align:center;">S/L</th>
<th style="text-align:center;">Customer Code</th>
<th style="text-align:center; width:250px;">Name of Customer</th>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">MR No</th>
<th style="text-align:center;">Total in Amount</th>
<th style="text-align:center; width:350px;">Deposited <br />Cash/Bank.Bkash</th>

</tr>
</thead>

<tbody>
<?php 
if($del_id!=''){
$del_con="and d.dealer_code='".$del_id."'";
}
    $sql="select d.account_code,d.dealer_name_e,d.dealer_code,j.jv_date,j.tr_no,j.ledger_id,j.tr_from,j.type from journal j,dealer_info d where j.jv_date between '".$f_date."' and '".$t_date."' and j.ledger_id=d.account_code and j.tr_from in('Receipt') ".$del_con." group by j.jv_no,j.ledger_id order by j.jv_date asc ";
  
 $query=mysql_query($sql);
 while($row=mysql_fetch_object($query)){
?>
<tr>
<td style="text-align:left;"><?=++$i?></td>
<td style="text-align:left;"><?=$row->dealer_code?></td>
<td style="text-align:left;"><?=$row->dealer_name_e?></td>
<td style="text-align:left;"><?=date("d-m-Y",strtotime($row->jv_date))?></td>
<td style="text-align:left;"><?=$row->tr_no?></td>
<td style="text-align:right;"><?php  echo number_format($collection=find_a_field('journal','sum(cr_amt)',' tr_no="'.$row->tr_no.'" and ledger_id="'.$row->account_code.'"'),2);

?></td>
<td style="text-align:right;">
</td>
</tr>


<?php 
$gr_cash+=$salescash;
$gr_pettycash+=$pettycash;
$gr_head_cash+=$head_cash;
$gr_bcash+=$bkash;
$gr_bank+=$bank;
$gr_total+=$collection;
} 
?>
<tr style="font-weight:bold;">
<td colspan="5" style="text-align:right;"><b>Grand Total =</b></td>
<td style="text-align:right;"><?=number_format($gr_total,2);?></td>

<td></td>

</tr>

</tbody>

<?

}

elseif($_POST['report']==3555)


{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>
<td style="border:0px;" colspan="12">

<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Daily Sales Report</h2></div>
<h3>From "<?=$_POST['f_date']?> "  &nbsp;  To   &nbsp; " <?=$_POST['t_date']?>"</h3>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td>
</tr>
<thead>
<tr>
<th>S/L</th>
<th>Challan No</th>
<th>Invoice No</th>
<th>Challan Date</th>
<th>Customer Code</th>
<th>Name of Customer</th>


<th>Opening Balance</th>
<th>Collection</th>
<th>Return</th>
<th>Total Sale</th>
<th>Adjustment</th>
<th>Closing Balance</th>
<th>Phone Number</th>
<th>Remarks</th>
</tr>
</thead><tbody>
<?php
if($del_id!=''){
$del_con="and dealer_code='".$del_id."'";
}


$ssql =  mysql_query('select ledger_id,sum(cr_amt-dr_amt) amt from journal where jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal" group by ledger_id');
while($jv_data = mysql_fetch_object($ssql))
{
$jv_amt[$jv_data->ledger_id] = $jv_data->amt;
}

$ssql2 =  mysql_query('select ledger_id,sum(cr_amt) amt from journal where jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Receipt" group by ledger_id');
while($jv_data2 = mysql_fetch_object($ssql2))
{
$jv_amt2[$jv_data2->ledger_id] = $jv_data2->amt;
}

$ssql3 =  mysql_query('select ledger_id,sum(cr_amt) amt from journal where jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="SalesReturn" group by ledger_id');
while($jv_data3 = mysql_fetch_object($ssql3))
{
$jv_amt3[$jv_data3->ledger_id] = $jv_data3->amt;
}

  //$journal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"');
  
 $sql="select * from sale_do_chalan where chalan_date between '".$f_date."' and '".$t_date."' ".$del_con." group by chalan_no";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
$all_del_info=find_all_field('dealer_info','','dealer_code="'.$row->dealer_code.'"');
 $id=find_a_field('journal','id','ledger_id="'.$all_del_info->account_code.'" and tr_no="'.$row->chalan_no.'"');

 $opening_bal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and id < "'.$id.'"');
//$collection=0;
//if($old_ledger_code!=$all_del_info->account_code)
// $collection=find_a_field('journal','sum(cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$row->chalan_date.'" and "'.$row->chalan_date.'" and tr_from="Receipt"');
 
 //$journal=0;
 //if($old_ledger_code!=$all_del_info->account_code)
 // $journal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"');
// echo 'select sum(dr_amt-cr_amt) from journal where ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"';
 $collection = $jv_amt2[$all_del_info->account_code]; $jv_amt2[$all_del_info->account_code] = 0;
$journal = $jv_amt[$all_del_info->account_code]; $jv_amt[$all_del_info->account_code] = 0;
$return = $jv_amt3[$all_del_info->account_code]; $jv_am3t[$all_del_info->account_code] = 0;
//if($old_ledger_code!=$all_del_info->account_code)
//$return=find_a_field('journal','sum(cr_amt)','ledger_id="'.$all_del_info->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="SalesReturn"');

$tot_sale=find_a_field('sale_do_chalan','sum(total_amt)','chalan_no="'.$row->chalan_no.'" ');
$clos_bal=($opening_bal-$collection-$return-$journal)+$tot_sale;
if($clos_bal<1){$bal_status="(Cr)";}else{$bal_status="(Dr)";}

?>
<tr>
<td><?=$i++;?></td>
<td style="text-align:left;" ><?=$row->chalan_no?></td>
<td style="text-align:left;" ><?=$row->chalan_no?></td>
<td style="text-align:left;" ><?=$row->chalan_date?></td>
<td style="text-align:left;" ><?=$row->dealer_code?></td>
<td style="text-align:left;"><?=$all_del_info->dealer_name_e;?></td>

<td style="text-align:right;"><?php echo number_format($opening_bal,0);?></td>
<td style="text-align:right;" ><?php 

echo number_format($collection,0);
?></td>
<td style="text-align:right;" ><?=number_format($return,0);?></td>
<td style="text-align:right;" ><?php echo number_format($tot_sale,0);?></td>
<td style="text-align:right;" ><?=number_format($journal,0);?></td>
<td style="text-align:right;" ><?php echo number_format($clos_bal,0);?></td>
<td style="text-align:right;" ><?=find_a_field('dealer_info','mobile_no','dealer_code="'.$row->dealer_code.'"')?></td>
<td></td>
</tr>
<?php 
$grand_tot_sale+=$tot_sale;
$grand_tot_col+=$collection;
$grand_tot_ret+=$return;
$old_ledger_code=$all_del_info->account_code;
} 

?>
<tr>
<td colspan="6" style="text-align:right;"><b>Grand Total =</b></td>
<td></td>
<td style="text-align:right;font-weight:bold;"><?=number_format($grand_tot_col,0)?></td>
<td style="text-align:right;font-weight:bold;" ><?=number_format($grand_tot_ret,0)?></td>

<td style="text-align:right;font-weight:bold;" ><?=number_format($grand_tot_sale,0)?></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<?

}

elseif($_POST['report']==3) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>
<td style="border:0px;" colspan="13">

<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Account Receivable Report</h2></div>
<h3>From "<?=$_POST['f_date']?> "  &nbsp;  To   &nbsp; " <?=$_POST['t_date']?>"</h3>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>

</tr>

<thead>
<tr >
<th style="text-align:center;">S/L</th>
<th style="text-align:center;">Customer Code</th>
<th style="text-align:center;" >Customer Name</th>
<th style="text-align:center;">Corporate Address</th>
<th style="text-align:center;">Contact Person Mobile</th>
<th style="text-align:center;">Opening</th>
<th style="text-align:center;">Collection</th>
<th style="text-align:center;">Return</th>

<th style="text-align:center;">Sales</th>

<th style="text-align:center;">Adjustment</th>
<th style="text-align:center;">Closing Balance</th>
<th style="text-align:center;">Status</th>
<th style="text-align:center;">Activity</th>
<th style="text-align:center;">Last Sale Date</th>
<th style="text-align:center;">Last Collection Date</th>
<th style="text-align:center;">Customer Type</th>
<th style="text-align:center;">Reference</th>
</tr>
</thead><tbody>
<?php
$sql="select * from dealer_info";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
 $opening_bal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$row->account_code.'" and jv_date<"'.$f_date.'"');
  $collection=find_a_field('journal','sum(cr_amt)','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Receipt"');
    $returns=find_a_field('journal','sum(cr_amt)','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="SalesReturn"');
	$sales=find_a_field('journal','sum(dr_amt)','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Sales"');
	$adjustment=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"');	
//echo 'select sum(dr_amt-cr_amt) from journal where ledger_id="'.$row->account_code.'" and jv_date<"'.$f_date.'" ';
//$closing_bal=($opening_bal+$collection+$returns)-($sales-$adjustment);
$closing_bal=($opening_bal+$sales)-($collection+$returns+$adjustment);
?>
<tr>
<td><?=$i++?></td>
<td><?=$row->dealer_code?></td>
<td><?=$row->dealer_name_e?></td>
<td><?=$row->address_e?></td>
<td><?=$row->mobile_no?></td>
<td style="text-align:right;"><?=number_format($opening_bal,2)?></td>
<td style="text-align:right;"><?=number_format($collection,2)?></td>
<td style="text-align:right;"><?=number_format($returns,2)?></td>
<td style="text-align:right;"><?=number_format($sales,2)?></td>
<td style="text-align:right;"><?=number_format($adjustment,2)?></td>
<td style="text-align:right;"><?=number_format($closing_bal,2)?></td>
<td style="text-align:right;"><?php 
if($closing_bal>0){
echo "Due";
}
elseif($closing_bal<0){
echo "Advance";
}
else{
echo "No Balance";
}
?></td>
<td>
<?php 
$mov_tot=$sales+$returns+$collection;
if($mov_tot>0){

	if($opening_bal>0){
		echo "Old Moving";
	}
	else{
		echo "New Moving";
	}
}
elseif($closing_bal<=0){
echo "Non Moving";
}

?>
</td>
<td><?php 
echo $last_sale_date=find_a_field('journal','jv_date','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Sales" order by id desc');
?></td>
<td>
<?php 
echo $last_col_date=find_a_field('journal','jv_date','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Receipt" order by id desc');
?>
</td>
<?php 
$cust_all=find_all_field('dealer_info','','account_code='.$row->account_code);
?>
<td><?php 
echo find_a_field('dealer_type','dealer_type','id='.$cust_all->dealer_type);
?></td>
<td><?php 
echo $cust_all->reference	;
?></td>


</tr>
<?php 
$gr_coll+=$collection;
$gr_ret+=$returns;
$gr_sal+=$sales;
$gr_adj+=$adjustment;
} ?>
<tr>
<td colspan="5" style="text-align:right;font-weight:bold"><b>Grand Total =</b></td>


<td></td>
<td style="text-align:right;font-weight:bold"><?=$gr_coll?></td>
<td style="text-align:right;font-weight:bold"><?=$gr_ret?></td>
<td style="text-align:right;font-weight:bold"><?=$gr_sal?></td>
<td style="text-align:right;font-weight:bold"><?=$gr_adj?></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>


</tr>
<?

}

elseif($_POST['report']==4) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Sales & Collection Report</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>


</tr>

<thead>
<tr>
<th style="text-align:center;" >Date</th>
<th style="text-align:center;" > Sales (Accounts Approved)</th>
<th style="text-align:center;" > Sales (Accounts Approval Pending)</th>
<th style="text-align:center;" > Sales (Total)</th>

<th style="text-align:center;" >Market Return</th>
<th style="text-align:center;" >Collection</th>
<th style="text-align:center;">Remarks</th>

</tr>
</thead><tbody>
<?php
  $sql="select * from journal where jv_date  between '".$f_date."' and '".$t_date."'  group by jv_date";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
?>

<tr>
<td><?=date("d-m-Y",strtotime($row->jv_date))?></td>
<td style="text-align:right;" >
<?=number_format($sales=find_a_field('journal','sum(dr_amt)',' jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and tr_from="Sales"'),2);?>

</td>
<td style="text-align:right;" >
<?=number_format($sales_ac_pending=find_a_field('secondary_journal','sum(dr_amt)',' jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and tr_from="Sales" and checked=""'),2);?>

</td>
<td style="text-align:right;" >
<?=number_format($totsales=$sales+$sales_ac_pending,2);?>

</td>
<td style="text-align:right;"><?=number_format($returns=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and tr_from="SalesReturn"'),2);?></td>
<td style="text-align:right;">
<?php  echo number_format($collection=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and tr_from="Receipt"'),2);?></td>
<td></td>

</tr>
<?php
$gr_tot_sale+=$sales;
$gr_sale_ac_un+=$sales_ac_pending;
$gr_sale+=$totsales;
$gr_tot_ret+=$returns;
$gr_tot_coll+=$collection;
 } ?>
<tr>
<th style="text-align:right;" ><b>Grand Total =</b></td>
<th style="text-align:right;"><?=number_format($gr_tot_sale,2)?></td>
<th style="text-align:right;"><?=number_format($gr_sale_ac_un,2)?></td>
<th style="text-align:right;"><?=number_format($gr_sale,2)?></td>
<th style="text-align:right;"><?=number_format($gr_tot_ret,2)?></td>
<th style="text-align:right;"><?=number_format($gr_tot_coll,2)?></td>
<th></td>



</tr>
<?

}

elseif($_POST['report']==5) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Net Sales Report</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>


</tr>

<thead>
<tr>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">Gross Sales (Accounts Approved)</th>
<th style="text-align:center;">Gross Sales (Accounts Approval Pending)</th>
<th style="text-align:center;">VAT</th>
<th style="text-align:center;">Transport Expenses</th>
<th style="text-align:center;">Adjustment</th>
<th style="text-align:center;">Sales Before Return</th>
<th style="text-align:center;">Return</th>
<th style="text-align:center;">Net Sales</th>
<th style="text-align:center;">Collection</th>
<th style="text-align:center;">Remarks</th>

</tr>
</thead><tbody>
<?php
  $sql="select * from secondary_journal where jv_date  between '".$f_date."' and '".$t_date."'  group by jv_date";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
?>
<tr>
<td><?=date("d-m-Y",strtotime($row->jv_date))?></td>
<td style="text-align:right;"><?=number_format($sales=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and tr_from="Sales"'),2);?></td>
<td style="text-align:right;"><?=number_format($salesacc_approvpend=find_a_field('secondary_journal','sum(cr_amt)',' jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and tr_from="Sales" and checked=""'),2);
//echo 'select sum(dr_amt) from secondary_journal where jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and tr_from="Sales" and checked="" ';
?></td>

<td style="text-align:right;"><?=number_format($vat=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and ledger_id="3215005000020000" and tr_from="Sales"'),2);?></td>
<td style="text-align:right;"><?=number_format($transport=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and ledger_id="5310011000000000" and tr_from="Sales"'),2);?></td>
<td style="text-align:right;"><?php echo number_format($adjustment=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=4017002800000000 and jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and tr_from="Journal"'),2);

?></td>
<td style="text-align:right;"><?php 
echo number_format($sbr=$sales-($vat+$transport),2);
?></td>
<td style="text-align:right;"><?=number_format($returns=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and tr_from="SalesReturn"'),2);?></td>
<td style="text-align:right;"><?php echo number_format($net_sale=$sbr-$returns,2);?></td>
<td style="text-align:right;"><?php   echo number_format($collection=find_a_field('journal j,accounts_ledger a','sum(j.cr_amt)',' j.jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and j.tr_from="Receipt" and j.ledger_id=a.ledger_id and a.ledger_group_id=1203'),2);
//echo 'select sum(j.cr_amt) from journal j,accounts_ledger a where  j.jv_date between  "'.$row->jv_date.'" and "'.$row->jv_date.'" and j.tr_from="Receipt" and j.ledger_id=a.ledger_id and a.ledger_group_id=1203';
?></td>
<td></td>

</tr>
<? 
$gr_salesacc_approvpend+=$salesacc_approvpend;
$gr_sale+=$sales;
$gr_vat+=$vat;
$gr_transport+=$transport;
$gr_adjust+=$adjustment;
$gr_sbr+=$sbr;
$gr_ret+=$returns;
$gr_net_sale+=$net_sale;
$gr_collect+=$collection;

} ?>
<tr>
<th style="text-align:right;"><b>Grand Total =</b></th>
<th style="text-align:right;"><?=number_format($gr_sale,2)?></th>
<th style="text-align:right;"><?=number_format($gr_salesacc_approvpend,2)?></th>
<th style="text-align:right;"><?=number_format($gr_vat,2)?></th>
<th style="text-align:right;"><?=number_format($gr_transport,2)?></th>
<th style="text-align:right;"><?=number_format($gr_adjust,2)?></th>
<th style="text-align:right;"><?=number_format($gr_sbr,2)?></th>
<th style="text-align:right;"><?=number_format($gr_ret,2)?></th>
<th style="text-align:right;"><?=number_format($gr_net_sale,2)?></th>
<th style="text-align:right;"><?=number_format($gr_collect,2)?></th>
<th></th>



</tr>
</tbody>
</table>
<?php 
//$tot_sales_unverify=$sales=find_a_field('secondary_journal','sum(dr_amt)',' jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Sales" and checked!="	YES"');
//echo 'select sum(dr_amt) from secondary_journal where jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Sales" and checked!="	YES" and j.group_for=2 ';
?>
<!--<span><h3>Chalan not verify accounts=<?=$tot_sales_unverify?></h3></span>-->
<?

}





elseif($_POST['report']==44412344) 
{
		 $str3 	.= '<h1 style="text-align:center;">'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		 
?>
<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1>
<h2>Delivery Summary (Challan Date Wise)</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
<?php echo $str3;?>

<table width="100%;"  cellspacing="0" cellpadding="2" border="0" >
	<thead>
		<tr>
			<th style="text-align:center">Sl</th>
			<th style="text-align:center">Delivery Date</th>		
			<th style="text-align:center">Challan No</th>
			<th style="text-align:center">Voucher No</th>
			<th style="text-align:center">Voucher Date</th>
			<th style="text-align:center">SO NO</th>
			<th style="text-align:center">SO Date</th>
			<th style="text-align:center">PO No</th>
			<th style="text-align:center">PO Date</th>
			<th style="text-align:center">VAT NO</th>
			<th style="text-align:center">Customer Code</th>
			<th style="text-align:center">Customer Name</th>
			<th style="text-align:center">Address</th>
			<th style="text-align:center">Item Code</th>
			<th style="text-align:center">Item Name</th>
			<th style="text-align:center">UOM</th>
			<th style="text-align:center">Quantity</th>
			<th style="text-align:center">Rate</th>
			<th style="text-align:center">Value</th>
			<th style="text-align:center">VAT</th>
			<th style="text-align:center">Transport</th>
			<th style="text-align:center">Others</th>
			<th style="text-align:center">Total</th>



			
		</tr>
	</thead>
	<tbody>
	<?php 
	 
	 $cust_id_get=$_POST['cust_id'];
	$test=explode('--',$cust_id_get);
	
	 $cust_id=$test[1];
	 if($cust_id){
	 $con='and dealer_code="'.$cust_id.'"';
	 }
	 
	 
	  $sql='select * from sale_do_chalan where chalan_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" '.$con.' order by chalan_no';
	  
	    $query=mysql_query($sql);
	    while($row=mysql_fetch_object($query)){
	?>
		<tr>
			<td><?=++$i?></td>
			<td><?=date("d-m-Y",strtotime($row->chalan_date))?></td>
			<td style="text-align:right"><?=$row->chalan_no_another?></td>
			
			<td style="text-align:right"><?=find_a_field('secondary_journal','jv_no',' tr_from="Sales" and tr_no="'.$row->chalan_no.'"');?></td>
			<td><?=date("d-m-Y",strtotime(find_a_field('secondary_journal','jv_date',' tr_from="Sales" and tr_no="'.$row->chalan_no.'"')));?></td>
			<td><?=$row->do_no?></td>
			<td><?=date("d-m-Y",strtotime(find_a_field('sale_do_master','do_date','do_no='.$row->do_no)));?></td>
			<td><?=find_a_field('sale_do_master','po_no','do_no='.$row->do_no);?></td>
			<td><?=find_a_field('sale_do_master','po_date','do_no='.$row->do_no);?></td>
			<td style="text-align:right"><?=$row->vat_challan?></td>
			<td><?=$row->dealer_code;?></td>
			<td><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
			<td><?=find_a_field('dealer_info','delivery_address','dealer_code='.$row->dealer_code);?></td>
			<td><?=find_a_field('item_info','finish_goods_code','item_id='.$row->item_id);?></td>
			<td><?=find_a_field('item_info','item_name','item_id='.$row->item_id);?></td>
			<td><?=find_a_field('item_info','unit_name','item_id='.$row->item_id);?></td>			
			<td style="text-align:right"><?=$row->total_unit;?></td>
			<td style="text-align:right"><?=$row->unit_price;?></td>
			<td style="text-align:right"><?=$row->total_amt;?></td>
			<td style="text-align:right"><?
			
			if($old_chalan_no != $row->chalan_no){
echo $vat=find_a_field('secondary_journal','sum(cr_amt)',' ledger_id="3215005000020000" and tr_from="Sales" and tr_no="'.$row->chalan_no.'"');
$transport=find_a_field('secondary_journal','sum(cr_amt)',' ledger_id="5310011000000000" and tr_from="Sales" and tr_no="'.$row->chalan_no.'"');
$total_value = $row->total_amt+$vat+$transport;
$tot_vat+=$vat;
$tot_tansport+=$transport;

}else{
$vat = 0;
$total_value = $row->total_amt;
}
		$old_chalan_no = $row->chalan_no;
		
					 
			 ?></td>
			<td style="text-align:right"><?=$transport; ?></td>
			<td style="text-align:right"></td>
			<td style="text-align:right"><?=$total_value?></td>


			
		</tr>
		
			<?php 
		$tot_del_qty+=$row->total_unit;
		$tot_rate+=$row->unit_price;
		$tot_gross_val+=$row->total_amt;
		$tot_gross_value+=$total_value;
				} ?>
		<tr>
			<th colspan="16" style="text-align:right;" >Total</th>
			<th style="text-align:right"><?=number_format($tot_del_qty,2);?></th>
			<th style="text-align:right"></th>
			<th style="text-align:right"><?=number_format($tot_gross_val,2);?></th>
			<th style="text-align:right"><?=number_format($tot_vat,2);?></th>
			<th style="text-align:right"><?=number_format($tot_tansport,2);?></th>
			<th style="text-align:right"></th>
			<th style="text-align:right"><?=number_format($tot_gross_value,2); ?></th>



		</tr>
	</tbody>
	</table>
<?

}





elseif($_POST['report']==76) 
{	


?>
<?php 



$from_mon=explode('-',$f_date);
$to_mon=explode('-',$t_date);
 $from_mon[1];
 $to_mon[1];
$year=$from_mon[0];
$year2 = substr($year, -2);
?>
<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Yearly Net Sales Report</h2>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>


</tr>

<thead>
<tr>
<th style="text-align:center;" >Month</th>

<th style="text-align:center;" >Gross Sales (Accounts Approved)</th>
<th style="text-align:center;" >Gross Sales (Accounts Approval Pending)</th>
<th style="text-align:center;">VAT</th>
<th style="text-align:center;" >Transport Expenses</th>
<th style="text-align:center;" >Adjustmant</th>
<th style="text-align:center;" >Sales Befor Return</th>
<th style="text-align:center;">Return</th>
<th style="text-align:center;">Net Sales</th>
<th style="text-align:center;" >Remarks</th>



</tr>
</thead><tbody>
<?php

    $sql="select * from month_rep where id  between '".$from_mon[1]."' and '".$to_mon[1]."'  ";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
$start_date_db=explode('-',$row->start_date);
$end_date_db=explode('-',$row->end_date);
 $start_date=$year."-".$start_date_db['1']."-".$start_date_db['2'];

 $end_date=$year."-".$end_date_db['1']."-".$end_date_db['2'];
?>
<tr>
<td><?=$row->month_name."-".$year2;?></td>

<td style="text-align:right;"><?=number_format($sales=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Sales"'),2);?></td>
<td style="text-align:right;"><?=number_format($sales_accpernd=find_a_field('secondary_journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Sales" and checked=""'),2);?></td>
<td style="text-align:right;"><?=number_format($vat=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and ledger_id="3215005000020000	" and tr_from="Sales"'),2);?></td>
<td style="text-align:right;"><?=number_format($transport=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and ledger_id="5310011000000000" and tr_from="Sales"'),2);?></td>
<td style="text-align:right;"><?php echo $other=0;?></td>
<td style="text-align:right;"><?=number_format($sbr=$sales-($vat+$transport),2);?></td>
<td style="text-align:right;"><?=number_format($returns=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="SalesReturn"'),2);?></td>
<td style="text-align:right;"><?php  echo number_format($net_sale=($sbr-$returns),2);?></td>
<td style="text-align:right;"></td>




</tr>
<? 
$gr_tot_gr_sale_pend+=$sales_accpernd;
$gr_tot_gr_sale+=$sales;
$gr_tot_ret+=$returns;
$gr_tot_vat+=$vat;
$gr_tot_transp+=$transport;
$gr_tot_sbr+=$sbr;
$gr_tot_net+=$net_sale;
}?>

<tr>
<th style="text-align:right;">Grand Total =</th>

<th style="text-align:right;"><?=number_format($gr_tot_gr_sale,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_gr_sale_pend,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_vat,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_transp,2)?></th>
<th style="text-align:right;"></th>
<th style="text-align:right;"><?=number_format($gr_tot_sbr,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_ret,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_net,2)?></th>
<th></th>


</tr>


<!-- NEW EXPeriment   aging start -->



<?

}





elseif($_POST['report']==68) {









        $report="Aging Report";



		  // date('d-M-Y',strtotime($variable));



		 $to_date=date('Y-m-d',strtotime($t_date));

		 $fr_date=date('Y-m-d',strtotime($f_date));



		//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



  if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';}

  $sql66='select d.dealer_name_e,d.marketing_person,d.account_code,sum(j.dr_amt-j.cr_amt) as closing_amount,j.tr_id
 from  dealer_info d,journal j  
 
 where j.ledger_id=d.account_code and d.account_code>0'.$con.' and j.jv_date between "'.strtotime($f_date).'" and "'.strtotime($t_date).'" and j.tr_from="Sales" group by  d.account_code';



$query = mysql_query($sql66);







?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>

<td style="border:0px;" colspan="7"><?=$str?></td>

</tr>



<tr>

<th>S/L</th>

<th>Customer Name</th>

<th>Closing</th>

<th>Sales person</th>

<th>30 days past dues</th>

<th>31 to 45 days past dues</th>

<th>46 to 60 days past dues</th>

<th>61 to 75 days past dues</th>

<th> 76 to 90 days past dues</th>

<th> 91 to 105 days past dues </th>

<th> Above 105 days past dues </th>

</tr></thead><tbody>



<?

while($data=mysql_fetch_object($query)){



$closing =find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$data->account_code.'"');

//////////////*************  Check Dues *************/////////////////////////////
//old Format
    $today_days= strtotime($t_date);
    $days_30= $today_days-(86400*30);
	
    $days_31= $days_30-86400;
    $days_45= $days_31-(86400*15);
     
	$days_46= $days_45-86400;
    $days_60= $days_46-(86400*15);
	
    $days_61= $days_60-86400;
	$days_75= $days_61-(86400*15);
	
    $days_76= $days_75-86400;
    $days_90= $days_76-(86400*15);
	
    $days_91= $days_90-86400;
    $days_105= $days_91-(86400*15);
	
    $aging_fixed_back_date = strtotime('01-06-2021');


//old Format
	
//New date check

   $do_date = find_a_field('sale_do_master','do_date','do_no='.$data->tr_id);

   $start = strtotime($do_date);
   $end =strtotime($t_date);

   $days_count= ceil(abs($start - $end) / 86400);

  /* $start = $today_days;
   $end =$days_46;
   $days_count= ceil(abs($start - $end) / 86400);*/
   
   
   
    $rceived = find_a_field('journal','sum(cr_amt)', 'tr_from="Receipt" and ledger_id="'.$data->account_code.'" and ref_no='.$data->tr_id);


   /*$total_amt = find_a_field('journal','sum(dr_amt)','tr_from="sales" and ledger_id="'.$data->account_code.'" and tr_id='.$data->tr_id);
   if($data->ref_no>0){
   $rceived = find_a_field('journal','sum(cr_amt)', 'tr_from="Receipt" and ledger_id="'.$data->account_code.'" and ref_no='.$data->tr_id);
   }else{
   $rceived = find_a_field('receipt','sum(cr_amt)', 'ledger_id="'.$data->account_code.'" and ref_no='.$data->tr_id);
   }
   $sales_return = find_a_field('secondary_journal','sum(cr_amt)', 'tr_from="SalesReturn" and ref_no='.$data->tr_id);
   $check_dues=$total_amt-($rceived+$sales_return);*/



if($closing>0){


$s++;



?>



<tr>

<td><?=$s?></td>

<td><?=$data->dealer_name_e?></td>

<td align="right"><?=number_format($closing);?></td>

<td><?=find_a_field('personnel_basic_info','concat(PBI_ID," - ",PBI_NAME)','PBI_ID='.$data->marketing_person);?></td>




<td align="right"><?

// ______SALES : 30 days past DO NO _____*
  $sql = 'select tr_id from journal 
where ledger_id = "'.$data->account_code.'" and tr_from="Sales" and jv_date between "'.$days_30.'" and "'.$today_days.'" group by tr_id ';
$queryy = mysql_query($sql);
$ii=0;
$ddi ='';
while($sales_data = mysql_fetch_object($queryy)){

if($ii==0){  $ddi = $sales_data->tr_id;}
else{
$ddi .=','.$sales_data->tr_id;
}
++$ii;

}
$ddi;

//________ 30 days past dues ___________
$sales_30   = find_a_field('journal','sum(dr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Sales" and tr_id in ('.$ddi.')');
$rceived_30 = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Receipt" and ref_no in ('.$ddi.')');
$return_30  = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="SalesReturn" and ref_no in ('.$ddi.')');
$expense_30 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="Expense" and ref_no in ('.$ddi.')');

 $check_dues_30 = ($sales_30-($rceived_30+$return_30+$expense_30));  $check_dues_total +=$check_dues_30;

echo ($check_dues_30>0)?  number_format($check_dues_30,0) : ''; 




//$day30=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$data->account_code.'" and jv_date between "'.$days_30.'" and "'.$today_days.'"');



?></td>

<td align="right"><?
// ______SALES : 31 to 45 days past dues DO NO _____*
 $sql2 = 'select tr_id,SUM(dr_amt) as dr_amtt  from journal 
where ledger_id = "'.$data->account_code.'" and tr_from="Sales" and jv_date between "'.$days_45.'" and "'.$days_31.'" group by tr_id ';
$query2 = mysql_query($sql2);
$iii=0;
$ddi2 ='';
while($sales_data = mysql_fetch_object($query2)){

if($iii==0){  $ddi2 = $sales_data->tr_id;}
else{
$ddi2 .=','.$sales_data->tr_id;
}
++$iii;

}
$ddi2;

//________ 31 to 45 days past  ___________
  $sales_45   = find_a_field('journal','sum(dr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Sales" and tr_id in ('.$ddi2.')');
  $rceived_45 = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Receipt" and ref_no in ('.$ddi2.')');
  $return_45  = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="SalesReturn" and ref_no in ('.$ddi2.')');
  $expense_45 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="Expense" and ref_no in ('.$ddi2.')');

 $check_dues_45 = $sales_45-($rceived_45+$return_45+$expense_45);

echo ($check_dues_45>0)?  number_format($check_dues_45,0) : ''; 

//$day45=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$data->account_code.'" and jv_date between "'.$days_45.'" and "'.$days_31.'"');
?></td>

<td align="right"><?


// ______SALES : 46 to 60 days past dues DO NO _____*
 $sql = 'select tr_id from journal 
where ledger_id = "'.$data->account_code.'" and tr_from="Sales" and jv_date between "'.$days_60.'" and "'.$days_45.'" group by tr_id ';
$queryy = mysql_query($sql);
$ii=0;
$ddi ='';
while($sales_data = mysql_fetch_object($queryy)){

if($ii==0){  $ddi = $sales_data->tr_id;}
else{
$ddi .=','.$sales_data->tr_id;
}
++$ii;

}
$ddi;

//________ 46 to 60 days past dues ___________
$sales_60   = find_a_field('journal','sum(dr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Sales" and tr_id in ('.$ddi.')');
$rceived_60 = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Receipt" and ref_no in ('.$ddi.')');
$return_60  = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="SalesReturn" and ref_no in ('.$ddi.')');
$expense_60 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="Expense" and ref_no in ('.$ddi.')');

 $check_dues_60 = ($sales_60-($rceived_60+$return_60+$expense_60));
echo ($check_dues_60>0)?  number_format($check_dues_60,0) : ''; 




//=$day60=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$data->account_code.'" and jv_date between "'.$days_60.'" and "'.$days_45.'"');



?></td>

<td align="right"><?

// ______SALES : 61 to 75 days past dues DO NO _____*
$sql = 'select tr_id from journal 
where ledger_id = "'.$data->account_code.'" and tr_from="Sales" and jv_date between "'.$days_75.'" and "'.$days_60.'" group by tr_id ';
$queryy = mysql_query($sql);
$ii=0;
$ddi ='';
while($sales_data = mysql_fetch_object($queryy)){

if($ii==0){  $ddi = $sales_data->tr_id;}
else{
$ddi .=','.$sales_data->tr_id;
}
++$ii;

}
$ddi;

//________ 61 to 75 days past dues  days past dues ___________
$sales_75   = find_a_field('journal','sum(dr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Sales" and tr_id in ('.$ddi.')');
$rceived_75 = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Receipt" and ref_no in ('.$ddi.')');
$return_75  = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="SalesReturn" and ref_no in ('.$ddi.')');
$expense_75 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="Expense" and ref_no in ('.$ddi.')');
$check_dues_75 = ($sales_75-($rceived_75+$return_75+$expense_75));

echo ($check_dues_75>0)?  number_format($check_dues_75,0) : '';     


//$day75=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$data->account_code.'" and jv_date between "'.$days_75.'" and "'.$days_60.'"');?></td>

<td align="right"><?
// ______SALES : 76 to 90 days past dues DO NO _____*
$sql = 'select tr_id from journal 
where ledger_id = "'.$data->account_code.'" and tr_from="Sales" and jv_date between "'.$days_90.'" and "'.$days_75.'" group by tr_id ';
$queryy = mysql_query($sql);
$ii=0;
$ddi ='';
while($sales_data = mysql_fetch_object($queryy)){

if($ii==0){  $ddi = $sales_data->tr_id;}
else{
$ddi .=','.$sales_data->tr_id;
}
++$ii;

}
$ddi;

//________ 76 to 90 days past dues___________
$sales_90   = find_a_field('journal','sum(dr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Sales" and tr_id in ('.$ddi.')');
$rceived_90 = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Receipt" and ref_no in ('.$ddi.')');
$return_90 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="SalesReturn" and ref_no in ('.$ddi.')');
$expense_90 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="Expense" and ref_no in ('.$ddi.')');
$check_dues_90 = ($sales_90-($rceived_90+$return_90+$expense_90));

echo ($check_dues_90>0)?  number_format($check_dues_90,0) : '';  

//$day90=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$data->account_code.'" and jv_date between "'.$days_90.'" and "'.$days_75.'"');



?></td>

<td align="right"><?

// ______SALES : 91 to 105 days past duesDO NO _____*
$sql = 'select tr_id from journal 
where ledger_id = "'.$data->account_code.'" and tr_from="Sales" and jv_date between "'.$days_105.'" and "'.$days_90.'" group by tr_id ';
$queryy = mysql_query($sql);
$ii=0;
$ddi ='';
while($sales_data = mysql_fetch_object($queryy)){

if($ii==0){  $ddi = $sales_data->tr_id;}
else{
$ddi .=','.$sales_data->tr_id;
}
++$ii;

}
$ddi;

//________ 91 to 105 days past dues___________
$sales_105   = find_a_field('journal','sum(dr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Sales" and tr_id in ('.$ddi.')');
$rceived_105 = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Receipt" and ref_no in ('.$ddi.')');
$return_105 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="SalesReturn" and ref_no in ('.$ddi.')');
$expense_105 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="Expense" and ref_no in ('.$ddi.')');
$check_dues_105 = ($sales_105-($rceived_105+$return_105+$expense_105));

echo ($check_dues_105>0)?  number_format($check_dues_105,0) : '';  

//=$day105=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$data->account_code.'" and jv_date between "'.$days_105.'" and "'.$days_90.'"');

?></td>

<td align="right">

<?

// ______SALES : Above 105 days past dues DO NO _____*
 $sql7 = 'select tr_id from journal 
where ledger_id = "'.$data->account_code.'" and tr_from="Sales" and jv_date between "'.$aging_fixed_back_date.'" and "'.$days_105.'" group by tr_id ';
$queryy7 = mysql_query($sql7);
$ii7=0;
$ddi7 ='';
while($sales_data7 = mysql_fetch_object($queryy7)){

if($ii7==0){  $ddi7 = $sales_data7->tr_id;}
else{
$ddi7 .=','.$sales_data7->tr_id;
}
++$ii7;

}
 $ddi7;

//________ 91 to 105 days past dues___________
 $sales_avobe_105   = find_a_field('journal','sum(dr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Sales" and tr_id in ('.$ddi7.')');
 $rceived_avobe_105 = find_a_field('journal','sum(cr_amt)', 'ledger_id = "'.$data->account_code.'" and tr_from="Receipt" and ref_no in ('.$ddi7.')');
 $return_avobe_105 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="SalesReturn" and ref_no in ('.$ddi7.')');
 $expense_avobe_105 = find_a_field('journal','sum(cr_amt)',  'ledger_id = "'.$data->account_code.'" and tr_from="Expense" and ref_no in ('.$ddi7.')');
 $check_dues_avobe_105 = ($sales_avobe_105-($rceived_avobe_105+$return_avobe_105+$expense_avobe_105));

echo ($check_dues_avobe_105>0)?  number_format($check_dues_avobe_105,0) : '';  

//$day105=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$data->account_code.'" and jv_date<"'.$days_105.'"  ');




?></td>



</tr>

<? } } ?>

<tr class="footer"><td>&nbsp;</td>

<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align="right"><? //=number_format($check_dues_total,2)?></td><td>&nbsp;</td><td><? //=number_format($total_amt,2)?></td><td></td></tr></tbody></table>











<!--end agning report section-->





<?

}

elseif($_POST['report']==1060) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Customer Wise Account Receivable Report</h2></div>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>


</tr>

<thead>
<tr >
<th style="text-align:center;">S/L</th>
<th style="text-align:center;">Customer Code</th>
<th style="text-align:center;" >Customer Name</th>
<th style="text-align:center;">Corporate Address</th>
<th style="text-align:center;">Contact Person Mobile</th>
<th style="text-align:center;">Opening</th>
<th style="text-align:center;">Collection</th>
<th style="text-align:center;">Return</th>

<th style="text-align:center;">Sales</th>

<th style="text-align:center;">Adjustment</th>
<th style="text-align:center;">Closing Balance</th>
<th style="text-align:center;">Status</th>
<th style="text-align:center;">Activity</th>
<th style="text-align:center;">Last Sale Date</th>
<th style="text-align:center;">Last Collection Date</th>
<th style="text-align:center;">Customer Type</th>
<th style="text-align:center;">Reference</th>
<th style="text-align:center;">Bill Maturity Days</th>
</tr>
</thead><tbody>
<?php




 $sql="select * from dealer_info";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
 $opening_bal=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$row->account_code.'" and jv_date<"'.$f_date.'"');
  //$collection=find_a_field('journal','sum(cr_amt)','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Receipt"');
    $collection=find_a_field('journal j,accounts_ledger a','sum(j.cr_amt)',' j.jv_date between  "'.$f_date.'" and "'.$t_date.'" and j.tr_from="Receipt" and j.ledger_id=a.ledger_id and a.ledger_id="'.$row->account_code.'" and a.ledger_group_id=1203');
  
    $returns=find_a_field('journal','sum(cr_amt)','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="SalesReturn"');
	$sales=find_a_field('journal','sum(dr_amt)','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Sales"');
	$adjustment=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Journal"');	
//echo 'select sum(dr_amt-cr_amt) from journal where ledger_id="'.$row->account_code.'" and jv_date<"'.$f_date.'" ';
//$closing_bal=($opening_bal+$collection+$returns)-($sales-$adjustment);
$closing_bal=($opening_bal+$sales)-($collection+$returns+$adjustment);
?>
<tr>
<td><?=$i++?></td>
<td><?=$row->dealer_code?></td>
<td><?=$row->dealer_name_e?></td>
<td><?=$row->address_e?></td>
<td><?=$row->mobile_no?></td>
<td style="text-align:right;"><?=number_format($opening_bal,2)?></td>
<td style="text-align:right;"><?=number_format($collection,2)?></td>
<td style="text-align:right;"><?=number_format($returns,2)?></td>
<td style="text-align:right;"><?=number_format($sales,2)?></td>
<td style="text-align:right;"><?=number_format($adjustment,2)?></td>
<td style="text-align:right;"><?=number_format($closing_bal,2)?></td>
<td style="text-align:right;"><?php 
if($closing_bal>0){
echo "Due";
}
elseif($closing_bal<0){
echo "Advance";
}
else{
echo "No Balance";
}
?></td>
<td>
<?php
 
 if($opening_bal>0 && $sales<1 && $collection<1 && $returns<1){
 
 echo "Old Non Moving";
 }
 elseif($opening_bal<1 && $sales<1 && $collection<1 && $returns<1){
 
 echo "New Non Moving";
 }
 
 elseif ($opening_bal<1 && $sales>0 && $collection<1 && $returns<1){
 
 echo "New Moving";
 }
 
  elseif ($opening_bal<1 && $sales<1 && $collection>0 && $returns<1){
 
 echo "New Moving";
 }
 
   elseif ($opening_bal<1 && $sales>0 && $collection>0 ){
 
 echo "New Moving";
 }
 
 
   elseif ($opening_bal>0 && $sales>0 && $collection<1 && $returns<1){
 
 echo "Old Moving";
 }
 
    elseif ($opening_bal>0 && $sales<1 && $collection>0 && $returns<1){
 
 echo "Old Moving";
 }
 
     elseif ($opening_bal>0 && $sales>0 && $collection>0 && $returns<1){
 
 echo "Old Moving";
 }
 
 
/*$mov_tot=$sales+$collection;
if($mov_tot>0){

	if($opening_bal>0){
		echo "Old Moving";
	}
	else{
		echo "New Moving";
	}
}

elseif($mov_tot<0){

	if($opening_bal>0){
		echo "Old Moving";
	}
	else{
		echo "Old Non Moving";
	}
}*/









?>
</td>
<td>
<?php 
 $last_sale_date=find_a_field('journal','jv_date','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Sales" order by id desc');
 if($last_sale_date){
 echo date("d-m-Y",strtotime($last_sale_date));
 }
?>
</td>
<td>
<?php 
 $last_col_date=find_a_field('journal','jv_date','ledger_id="'.$row->account_code.'" and jv_date between  "'.$f_date.'" and "'.$t_date.'" and tr_from="Receipt" order by id desc');
  if($last_col_date){
 echo date("d-m-Y",strtotime($last_col_date));
 }
?>

</td>
<?php 
$cust_all=find_all_field('dealer_info','','account_code='.$row->account_code);
?>
<td><?php 
echo find_a_field('dealer_type','dealer_type','id='.$cust_all->dealer_type);
?></td>
<td><?php 
echo $cust_all->reference	;
?></td>

<td align="center"><?php 
echo $cust_all->bill_maturity_days	;
?></td>


</tr>
<?php 
$gr_opening_bal+=$opening_bal;
$gr_coll+=$collection;
$gr_ret+=$returns;
$gr_sal+=$sales;
$gr_adj+=$adjustment;
} ?>
<tr>
<td colspan="5" style="text-align:right;font-weight:bold"><b>Grand Total =</b></td>


<td><?=number_format($gr_opening_bal,2)?></td>
<td style="text-align:right;font-weight:bold"><?=number_format($gr_coll,2)?></td>
<td style="text-align:right;font-weight:bold"><?=number_format($gr_ret,2)?></td>
<td style="text-align:right;font-weight:bold"><?=number_format($gr_sal,2)?></td>
<td style="text-align:right;font-weight:bold"><?=number_format($gr_adj,2)?></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>


</tr>
<?

}

elseif($_POST['report']==106) 
{echo "<h1 style='text-align:center;'>".find_a_field('project_info','proj_name','1')."</h1>";
		 $str3 	.= '<h2 style="text-align:center;">'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h2>';
		 echo "<h2>Delivery Pending Report (PO Wise)</h2>";
	
?>
<?php echo $str3;?>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
<table width="100%;" cellspacing="0" cellpadding="2" border="0" >
	<thead>
		<tr>
			<th style="text-align:center;">Sl</th>
			<th style="text-align:center;">SO No</th>
			<th style="text-align:center;">Order Date</th>
			<th style="text-align:center;">PO No</th>
			<th style="text-align:center;">PO Date</th>
			<th style="text-align:center;">Customer Code</th>
			<th style="text-align:center;">Customer Name</th>
			<th style="text-align:center;">Item Code</th>
			<th style="text-align:center;">Item Name</th>
			<th style="text-align:center;">UOM</th>
			<th style="text-align:center;">Order Quantity</th>
			<th style="text-align:center;">Order In Value</th>
			<th style="text-align:center;">Delivery Quantity</th>
			<th style="text-align:center;">Delivery In Value</th>
			<th style="text-align:center;">Undelivery Quantity</th>
			<th style="text-align:center;">Undelivery In Value</th>
			<th style="text-align:center;">Status</th>
		
		</tr>
	</thead>
	<tbody>
	<?php 
	 $cust_id_get=$_POST['cust_id'];
	$test=explode('--',$cust_id_get);
	
	 $cust_id=$test[1];
	 if($cust_id){
	 $con='and m.dealer_code="'.$cust_id.'"';
	 }
	 
	 $sql='select d.*,m.do_date,m.status,m.do_no,m.po_no,m.po_date,m.entry_by from sale_do_details d,sale_do_master m where m.do_date between "'.$fr_date.'" and "'.$to_date.'" and m.do_no=d.do_no '.$con.' ';
	$query=mysql_query($sql);
	while($row=mysql_fetch_object($query)){
	?>
		<tr>
			<td style="text-align:left;"><?=++$i?></td>
			<td style="text-align:left;"><?=$row->do_no?></td>
			<td style="text-align:left;"><?=date("d-m-Y",strtotime($row->do_date))?></td>
			<td style="text-align:left;"><?=$row->po_no?></td>
			<td style="text-align:left;"><?=$row->po_date?></td>
			<td style="text-align:left;"><?=$row->dealer_code?></td>
			<td style="text-align:left;"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
			<td style="text-align:left;"><?=find_a_field('item_info','finish_goods_code','item_id='.$row->item_id);?></td>
			<td style="text-align:left;"><?=find_a_field('item_info','item_name','item_id='.$row->item_id);?></td>
			<td style="text-align:left;"><?=find_a_field('item_info','unit_name','item_id='.$row->item_id);?></td>
			<td style="text-align:right;"><?php echo number_format($ord_qty=$row->total_unit,2)?></td>
				<td style="text-align:right;"><?php echo number_format($ord_in_value=$row->total_amt,2)?></td>
			<td style="text-align:right;"><?php 
				echo number_format($del_qty= find_a_field('sale_do_chalan','sum(total_unit)','item_id="'.$row->item_id.'" and do_no="'.$row->do_no.'" and chalan_date between   "'.$fr_date.'" and "'.$to_date.'" and status="COMPLETED" '),2);
				
				?></td>
				<td style="text-align:right;"><?php 
				echo number_format($del_in_value= find_a_field('sale_do_chalan','sum(total_amt)','item_id="'.$row->item_id.'" and do_no="'.$row->do_no.'" and chalan_date between   "'.$fr_date.'" and "'.$to_date.'" and status="COMPLETED"'),2);
				?></td>
			<td style="text-align:right;"><!--<a href="master_report.php?report=219&do_no=<?=$row->do_no?>">--><?php echo number_format($un_del_qty=$ord_qty-$del_qty,2);?><!--</a>--></td>
			<td style="text-align:right;"><?php echo number_format($un_del_qty_value=$ord_in_value-$del_in_value,2);?></td>
			
		<td style="text-align:right;"><?php 
		if($un_del_qty_value>0){
		echo "Undelivery";
		}
		else if($un_del_qty_value<0){
		echo "<span style='color:red;'>Excess Delivery</span>";
		}
		else{
		echo " Delivery Completed";
		}
		
		?></td>
			
		</tr>
			<?php 
		$tot_or_qty+=$ord_qty;
		$tot_or_qty_val+=$ord_in_value;
		$tot_del_qty+=$del_qty;
		$tot_del_qty_val+=$del_in_value;
		$tot_undel_qty+=$un_del_qty;
		$tot_undel_qty_val+=$un_del_qty_value;
		} ?>
		<tr>
			<th colspan="10" style="text-align:right;" >Grand Total =</th>
			<th style="text-align:right;"><?=number_format($tot_or_qty,2)?></th>
			<th style="text-align:right;"><?=number_format($tot_or_qty_val,2)?></th>
			<th style="text-align:right;"><?=number_format($tot_del_qty,2)?></th>
			<th style="text-align:right;"><?=number_format($tot_del_qty_val,2)?></th>
			<th style="text-align:right;"><?=number_format($tot_undel_qty,2)?></th>
			<th style="text-align:right;"><?=number_format($tot_undel_qty_val,2)?></th>
			<th></th>
		</tr>
	</tbody>
	</table>
<?

}

elseif($_POST['report']==96) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Monthly Accounts Receivable Summery Report (With Approved)</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>


</tr>

<thead>
<tr>
<th style="text-align:center;" >Month</th>
<th style="text-align:center;" >Opening Balance</th>
<th style="text-align:center;" >Sales (Accounts Approved)</th>
<th style="text-align:center;" >Sales (Accounts Approval Pending)</th>
<th style="text-align:center;" >Market Return</th>
<th style="text-align:center;" >Collection</th>
<th style="text-align:center;" >Adjustment</th>
<th style="text-align:center;" >Closing Balance</th>
<th style="text-align:center;" >Status</th>
<th style="text-align:center;" >Growth in Amount</th>
<th style="text-align:center;" >Growth in %</th>


</tr>
</thead><tbody>
<?php
 $f_date;
$from_mon=explode('-',$f_date);
$to_mon=explode('-',$t_date);
  $from_mon[1];
 $to_mon[1];
$year=$from_mon[0];
    $sql="select * from month_rep where id  between '".$from_mon[1]."' and '".$to_mon[1]."'  ";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
$start_date_db=explode('-',$row->start_date);
$end_date_db=explode('-',$row->end_date);
 $start_date=$year."-".$start_date_db['1']."-".$start_date_db['2'];

 $end_date=$year."-".$end_date_db['1']."-".$end_date_db['2'];
?>
<tr>
<td><?=$row->month_name?></td>
<td style="text-align:right;">
<?php echo number_format($opening_bal=find_a_field('journal j,accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=1203 and j.jv_date<"'.$start_date.'"'),2);
//echo 'select sum(j.dr_amt-j.cr_amt) from journal j,accounts_ledger a where j.ledger_id=a.ledger_id and a.ledger_group_id=1003 and j.jv_date<"'.$start_date.'" ';
?>
</td>
<td style="text-align:right;"><?=number_format($sales=find_a_field('journal','sum(dr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Sales"'),2);?></td>
<td style="text-align:right;"><?=number_format($salespending=find_a_field('secondary_journal','sum(dr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Sales" and checked=""'),2);?></td>
<td style="text-align:right;"><?=number_format($returns=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="SalesReturn"'),2);?></td>
<td style="text-align:right;" ><?php  //echo number_format($collection=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Receipt"'),2);
echo number_format($collection=find_a_field('journal j,accounts_ledger a','sum(j.cr_amt)',' j.jv_date between  "'.$start_date.'" and "'.$end_date.'" and j.tr_from="Receipt" and j.ledger_id=a.ledger_id and a.ledger_group_id=1203'),2);

?></td>
<td style="text-align:right;"><?php echo number_format($adjustment=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=4017002800000000 and jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Journal"'),2);?></td>
<td style="text-align:right;">
<?php 
//echo $due=$totsales-($sales+$returns+$collection+$adjustment);
echo number_format($closing_bal=($opening_bal+$sales)-($returns+$collection+$adjustment),2);
?>
</td>

<td>
<?php 
if($closing_bal>0){
echo "Due";
}elseif($closing_bal<0){
echo "Advance";
}
else{
echo "OK";
}
?></td>

<td><?=$closing_bal-$opening_bal;?></td>
<td></td>

</tr>
<? 
$gr_tot_gr_sale_pend+=$salespending;
$gr_tot_op+=$opening_bal;
$gr_tot_gr_sale+=$sales;
$gr_tot_ret+=$returns;
$gr_tot_col+=$collection;
$gr_tot_adj+=$adjustment;
$gr_tot_clo+=$closing_bal;
}?>

<tr>
<th style="text-align:right;">Grand Total =</th>
<th style="text-align:right;"></th>
<th style="text-align:right;"><?=number_format($gr_tot_gr_sale,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_gr_sale_pend,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_ret,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_col,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_adj,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_clo,2)?></th>
<th style="text-align:right;"></th>
<td></td>
<td></td>



</tr>
<?

}


elseif($_POST['report']==96000) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Monthly Accounts Receivable Summery</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>


</tr>

<thead>
<tr>
<th style="text-align:center;" >Month</th>
<th style="text-align:center;" >Opening Balance</th>
<th style="text-align:center;" >Sales</th>

<th style="text-align:center;" >Market Return</th>
<th style="text-align:center;" >Collection</th>
<th style="text-align:center;">Adjustment</th>
<th style="text-align:center;">Closing Balance</th>
<th style="text-align:center;">Due/(Advance)</th>
<th style="text-align:center;">Remarks</th>

</tr>
</thead><tbody>
<?php
 $f_date;
$from_mon=explode('-',$f_date);
$to_mon=explode('-',$t_date);
  $from_mon[1];
 $to_mon[1];
$year=$from_mon[0];
    $sql="select * from month_rep where id  between '".$from_mon[1]."' and '".$to_mon[1]."'  ";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
$start_date_db=explode('-',$row->start_date);
$end_date_db=explode('-',$row->end_date);
 $start_date=$year."-".$start_date_db['1']."-".$start_date_db['2'];

 $end_date=$year."-".$end_date_db['1']."-".$end_date_db['2'];
?>
<tr>
<td><?=$row->month_name?></td>
<td style="text-align:right;">
<?php echo number_format($opening_bal=find_a_field('journal j,accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.ledger_group_id=1003 and j.jv_date<"'.$start_date.'"'),2);
//echo 'select sum(j.dr_amt-j.cr_amt) from journal j,accounts_ledger a where j.ledger_id=a.ledger_id and a.ledger_group_id=1003 and j.jv_date<"'.$start_date.'" ';
?>
</td>
<td style="text-align:right;"><?=number_format($sales=find_a_field('journal','sum(dr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Sales"'),2);?></td>

<td style="text-align:right;"><?=number_format($returns=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="SalesReturn"'),2);?></td>
<td style="text-align:right;" ><?php  echo number_format($collection=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Receipt"'),2);?></td>
<td style="text-align:right;"><?php echo number_format($adjustment=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=4017002800000000 and jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Journal"'),2);?></td>
<td style="text-align:right;">
<?php 
//echo $due=$totsales-($sales+$returns+$collection+$adjustment);
echo number_format($closing_bal=($opening_bal+$sales)-($returns+$collection+$adjustment),2);
?>
</td>
<td></td>
<td></td>

</tr>
<? 
$gr_tot_gr_sale_pend+=$salespending;
$gr_tot_op+=$opening_bal;
$gr_tot_gr_sale+=$sales;
$gr_tot_ret+=$returns;
$gr_tot_col+=$collection;
$gr_tot_adj+=$adjustment;
$gr_tot_clo+=$closing_bal;
}?>

<tr>
<th style="text-align:right;">Grand Total =</th>
<th style="text-align:right;"><?=number_format($gr_tot_op,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_gr_sale,2)?></th>

<th style="text-align:right;"><?=number_format($gr_tot_ret,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_col,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_adj,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_clo,2)?></th>
<th style="text-align:right;"></th>
<td></td>


</tr>
<?

}

elseif($_POST['report']==66) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
<?php 


$from_mon=explode('-',$f_date);
$to_mon=explode('-',$t_date);
 $from_mon[1];
 $to_mon[1];
$year=$from_mon[0];
$year2 = substr($year, -2);
?>
<thead>

<tr>


<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Monthly Sales & Collection Report</h2>

<h2 style="font-weight:bold;">Year <?=$year?></h2>
</div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>


</tr>

<thead>
<tr>
<th style="text-align:center;" >Month</th>
<th style="text-align:center;" >Sales Order</th>
<th style="text-align:center;" >Gross Sales Or Total Delivery (Accounts Approved)</th>
<th style="text-align:center;" >Gross Sales Or Total Delivery (Accounts Approval Pending)</th>
<th style="text-align:center;" >Market Return</th>
<th style="text-align:center;" >Collection</th>
<th style="text-align:center;" >Adjustment</th>
<th style="text-align:center;" >Due/(Advance)</th>
<th style="text-align:center;" >Due/(Advance)</th>


</tr>
</thead><tbody>
<?php 
    $sql="select * from month_rep where id  between '".$from_mon[1]."' and '".$to_mon[1]."'  ";
$query=mysql_query($sql);
$i=1;
while($row=mysql_fetch_object($query)){
$start_date_db=explode('-',$row->start_date);
$end_date_db=explode('-',$row->end_date);
 $start_date=$year."-".$start_date_db['1']."-".$start_date_db['2'];

 $end_date=$year."-".$end_date_db['1']."-".$end_date_db['2'];
?>
<tr>
<td><?=$row->month_name."-".$year2?></td>
<td style="text-align:right;"><?=number_format($totsales=find_a_field('sale_do_details d,sale_do_master m','sum(d.total_amt)',' m.do_date between  "'.$start_date.'" and "'.$end_date.'" and m.do_no=d.do_no and m.status in("CHECKED","COMPLETED") '),2);?></td>
<td style="text-align:right;"><?=number_format($sales=find_a_field('journal','sum(dr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Sales"'),2);?></td>
<td style="text-align:right;"><?=number_format($salesacc_pend=find_a_field('secondary_journal','sum(dr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Sales" and checked=""'),2);
//echo 'select sum(dr_amt) from secondary_journal where jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Sales" and checked="" ';

?></td>

<td style="text-align:right;"><?=number_format($returns=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="SalesReturn"'),2);?></td>
<td style="text-align:right;"><?php  echo number_format($collection=find_a_field('journal','sum(cr_amt)',' jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Receipt"'),2);?></td>
<td style="text-align:right;"><?php echo number_format($adjustment=find_a_field('journal','sum(dr_amt-cr_amt)','ledger_id=4017002800000000 and jv_date between  "'.$start_date.'" and "'.$end_date.'" and tr_from="Journal"'),2);?></td>
<td style="text-align:right;">
<?php 
echo number_format($due=$sales-($returns+$collection+$adjustment),2);
?>
</td>
<td><?php 
if($due>0){
echo "Due";
}elseif($due<0){
echo "Advance";
}
else{
echo "Equivalent";
}
?></td>


</tr>
<?
$gr_salesacc_pend+=$salesacc_pend; 
$gr_tot_amt+=$totsales;
$gr_tot_gr_sale+=$sales;
$gr_tot_ret+=$returns;
$gr_tot_col+=$collection;
$gr_tot_adj+=$adjustment;
$gr_tot_due+=$due;
}?>

<tr>
<th style="text-align:right;">Grand Total =</th>
<th style="text-align:right;"><?=number_format($gr_tot_amt,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_gr_sale,2)?></th>
<th style="text-align:right;"><?=number_format($gr_salesacc_pend,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_ret,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_col,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_adj,2)?></th>
<th style="text-align:right;"><?=number_format($gr_tot_due,2)?></th>
<th></th>



</tr>
<?

}

elseif($_POST['report']==86) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>
<tr>


<h1 style="text-align:center;"><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Product Group Wise Sales Report</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>


</tr>

<tr>
<th rowspan="2" style="text-align:center;">S/L</th>
<th rowspan="2" style="text-align:center;" >Types</th>
<th rowspan="2" style="text-align:center;" >UOM</th>
<th colspan="3" style="text-align:center;">Sales</th>
</tr>
<tr>
  <th style="text-align:center;">Quantity</th>
  <th style="text-align:center;">Value</th>
  <th style="text-align:center;">in%</th>
</tr>
</thead>
<tbody>
<?php 
	 $sql22='select sum(c.total_unit) as sum_tot_unit,sum(c.total_amt) as sum_tot_amt,c.item_id,c.chalan_date,i.item_id,i.unit_name,i.sub_group_id,sg.sub_group_id,sg.group_id from sale_do_chalan c,item_info i,item_sub_group sg where c.chalan_date between "'.$f_date.'" and "'.$t_date.'" and c.item_id=i.item_id and i.sub_group_id=sg.sub_group_id and c.approve_by>0  group by sg.group_id ';
	$query22=mysql_query($sql22);
	while($row22=mysql_fetch_object($query22)){
	$gr_tot_amt22+=$row22->sum_tot_amt;
	}
	$rat_gr_tot_amt=$gr_tot_amt22;
	?>
<?php 
	 $sql='select sum(c.total_unit) as sum_tot_unit,sum(c.total_amt) as sum_tot_amt,c.item_id,c.chalan_date,i.item_id,i.unit_name,i.sub_group_id,sg.sub_group_id,sg.group_id from sale_do_chalan c,item_info i,item_sub_group sg where c.chalan_date between "'.$f_date.'" and "'.$t_date.'" and c.item_id=i.item_id and i.sub_group_id=sg.sub_group_id and c.approve_by>0 group by sg.group_id ';
	$query=mysql_query($sql);
	while($row=mysql_fetch_object($query)){
	?>
	<tr>
	<td><?php echo ++$i;?></td>
	<td><?php echo find_a_field('item_group','group_name','group_id='.$row->group_id);?></td>
	<td><?php echo $row->unit_name;?></td>
	<td style="text-align:right;"><?php echo number_format($row->sum_tot_unit,2);?></td>
	<td style="text-align:right;"><?php echo number_format($row->sum_tot_amt,2);?></td>
	<td style="text-align:right;" ><?php 
	$rat_gr=($row->sum_tot_amt*100)/$rat_gr_tot_amt;
	echo round($rat_gr,2)."%";
	?></td>
	</tr>
	<?php 
	$gr_tot_qty+=$row->sum_tot_unit;
	$gr_tot_amt+=$row->sum_tot_amt;
	$gr_rat_tot+=$rat_gr;
	} ?>
	<tr>
	<td style="text-align:right;font-weight:bold;" colspan="3" >Grand Total =</td>
	<td style="text-align:right;font-weight:bold;" ><?=number_format($gr_tot_qty,2)?></td>
	<td style="text-align:right;font-weight:bold;"  ><?=number_format($gr_tot_amt,2)?></td>
	<td style="text-align:right;font-weight:bold;"><?=$gr_rat_tot." %"?></td>
	</tr>
</tbody>
</table>
<br /><br />
<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>


<tr>
<th >S/L</th>
<th  >Ledger ID</th>
<th  >Ledger Name</th>
<th  >Amount</th>
</tr>

</thead>
<tbody>
<?php 
$sql='select sum(cr_amt) as amount,ledger_id from secondary_journal where ledger_id!=4102001000000000 and tr_from="Sales" and jv_date between "'.$f_date.'" and "'.$t_date.'" and cr_amt !="" group by ledger_id';
$query33=mysql_query($sql);
while($roww=mysql_fetch_object($query33)){
?>
<tr>
	<td><?php echo ++$i;?></td>
	<td><?php echo $roww->ledger_id; ?></td>
	<td><?php echo find_a_field('accounts_ledger','ledger_name','ledger_id='.$roww->ledger_id); ?></td>
	<td><?php echo $roww->amount; ?></td>
</tr>
<?php  
$tot_bal+=$roww->amount;
} ?>
<tr>
	<td colspan="3" style="text-align:right;">Total</td>
	
	<td><?php echo $tot_bal; ?></td>
</tr>
</tbody>
</table>
<?

}



elseif($_POST['report']==86000) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>
<tr>


<h1 style="text-align:center;"><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>Product Group Wise Sales Report</h2>
<h3>From  <?=date("d-m-Y",strtotime($_POST['f_date']))?>  To <?=date("d-m-Y",strtotime($_POST['t_date']))?></h3>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>


</tr>

<tr>
<th rowspan="2" style="text-align:center;">S/L</th>
<th rowspan="2" style="text-align:center;" >Types</th>
<th rowspan="2" style="text-align:center;" >UOM</th>
<th colspan="3" style="text-align:center;">Sales</th>
</tr>
<tr>
  <th style="text-align:center;">Quantity</th>
  <th style="text-align:center;">Value</th>
  <th style="text-align:center;">in%</th>
</tr>
</thead>
<tbody>
<?php 
	 $sql22='select sum(c.total_unit) as sum_tot_unit,sum(c.total_amt) as sum_tot_amt,c.item_id,c.chalan_date,i.item_id,i.unit_name,i.sub_group_id,sg.sub_group_id,sg.group_id from sale_do_chalan c,item_info i,item_sub_group sg where c.chalan_date between "'.$f_date.'" and "'.$t_date.'" and c.item_id=i.item_id and i.sub_group_id=sg.sub_group_id and c.status="COMPLETED" group by sg.group_id ';
	$query22=mysql_query($sql22);
	while($row22=mysql_fetch_object($query22)){
	$gr_tot_amt22+=$row22->sum_tot_amt;
	}
	$rat_gr_tot_amt=$gr_tot_amt22;
	?>
<?php 
	 $sql='select sum(c.total_unit) as sum_tot_unit,sum(c.total_amt) as sum_tot_amt,c.item_id,c.chalan_date,i.item_id,i.unit_name,i.sub_group_id,sg.sub_group_id,sg.group_id from sale_do_chalan c,item_info i,item_sub_group sg where c.chalan_date between "'.$f_date.'" and "'.$t_date.'" and c.item_id=i.item_id and i.sub_group_id=sg.sub_group_id and c.status="COMPLETED" group by sg.group_id ';
	$query=mysql_query($sql);
	while($row=mysql_fetch_object($query)){
	?>
	<tr>
	<td><?php echo ++$i;?></td>
	<td><?php echo find_a_field('item_group','group_name','group_id='.$row->group_id);?></td>
	<td><?php echo $row->unit_name;?></td>
	<td style="text-align:right;"><?php echo number_format($row->sum_tot_unit,2);?></td>
	<td style="text-align:right;"><?php echo number_format($row->sum_tot_amt,2);?></td>
	<td style="text-align:right;" ><?php 
	$rat_gr=($row->sum_tot_amt*100)/$rat_gr_tot_amt;
	echo round($rat_gr,2)."%";
	?></td>
	</tr>
	<?php 
	$gr_tot_qty+=$row->sum_tot_unit;
	$gr_tot_amt+=$row->sum_tot_amt;
	$gr_rat_tot+=$rat_gr;
	} ?>
	<tr>
	<td style="text-align:right;font-weight:bold;" colspan="3" >Grand Total =</td>
	<td style="text-align:right;font-weight:bold;" ><?=number_format($gr_tot_qty,2)?></td>
	<td style="text-align:right;font-weight:bold;"  ><?=number_format($gr_tot_amt,2)?></td>
	<td style="text-align:right;font-weight:bold;"><?=$gr_rat_tot." %"?></td>
	</tr>
</tbody>
</table>
<?

}


elseif($_POST['report']==6) 
{	


?>

<table width="100%" cellspacing="0" cellpadding="2" border="0">

<thead>

<tr>
<td style="border:0px;" colspan="21">

<div class="header" style="text-align:center"><h1><?=find_a_field('project_info','proj_name','1')?></h1><h2><?=$report?></h2>
<h2>MIS Report</h2></div>
<div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>

</tr>

<thead>
<tr>
<th>S/N</th>
<th>GL Date</th>
<th>Gl Code And Description</th>
<th>Voucher</th>
<th>PO No</th>
<th>PO Date</th>
<th>SO No</th>
<th>SO Date</th>
<th>Chalan No</th>
<th>Challan Receive Date </th>
<th>Invoice No</th>
<th>Invoice Rec Date</th>
<!--<th> Products Description</th>-->
<th>Payment Type </th>
<th> Tr Date</th>
<th> Acc Name</th>
<th>Particulars </th>
<th>Type</th>
<th>Debit</th>
<th> Credit</th>
<th> Balance</th>

</tr>
</thead><tbody>
<?php
$fdate=$_POST['f_date'];
$tdate=$_POST['t_date'];
	$cc_code = (int) $_REQUEST['cc_code'];
	$dealer_type = $_REQUEST['dealer_type'];
	if($dealer_type!='')
	{
	$d_table = ',dealer_info d';
	$d_where = ' and d.account_code=b.ledger_id and d.dealer_type="'.$dealer_type.'" ';
	}
		if($cc_code > 0)
		$cc_con = " AND a.cc_code=$cc_code";

	 $total_sql = "select sum(a.dr_amt),sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '$sledger_id%' and  b.group_for=".$_SESSION['user']['group']." ".$cc_con.$d_where;
		
		if($tr_from!='')
		 $total_sql.=" and a.tr_from='".$tr_from."'";
		 
		 if($_POST['user_name']!='')
		 $total_sql.=" and a.user_id='".$_POST['user_name']."'";
		
		$total=mysql_fetch_row(mysql_query($total_sql));
		
	 $c="select sum(a.dr_amt)-sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date<'$fdate' and a.ledger_id like '$sledger_id%' and b.group_for=".$_SESSION['user']['group']." ".$cc_con.$d_where;

		       $p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_no,a.jv_no,a.cheq_no,a.cheq_date,a.relavent_cash_head,a.id,a.tr_id,a.tr_no,a.type
			   
			   from journal a,accounts_ledger b".$d_table." 
			   
			   where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' ".$cc_con." and a.ledger_id like '$sledger_id%' and b.group_for=".$_SESSION['user']['group']." ".$d_where."";
		 
		 if($tr_from!='')
		 $p.=" and a.tr_from='".$tr_from."'";
		 
		 if($_POST['user_name']!='')
		 $p.=" and a.user_id='".$_POST['user_name']."'";
		 
		 $p.=" ORDER by jv_no,cr_amt";


	if($total[0]>$total[1])
	{
		$t_type="(Dr)";
		$t_total=$total[0]-$total[1];
	}
	else
	{
		$t_type="(Cr)";
		$t_total=$total[1]-$total[0];
	}
	/* ===== Opening Balance =======*/
	
	$psql=mysql_query($c);
	$pl = mysql_fetch_row($psql);
	$blance=$pl[0];

  $sql=mysql_query($p);
  while($data=mysql_fetch_row($sql))
  {
  $pi++;
  ?>
  <tr <?=($xx%2==0)?' bgcolor="#EDEDF4"':'';$xx++;?>>
  <td align="center"><?php echo $pi;?></td>
  <td></td>
  <td></td>
    
    <td align="center" >
	<?php
	if($data[4]=='Receipt'||$data[4]=='Payment'||$data[4]=='Journal'||$data[4]=='Contra')
	{
		//$link="voucher_print_receipt.php?v_type=".$data[4]."&v_date=".$data[0]."&view=1&vo_no=".$data[8];
		$link="general_voucher_print_view.php?jv_no=".$data[8];
		echo  $data[7] ;
	}
	
		elseif($data[4]=='Sales')
	{
		$link="general_voucher_print_view.php?jv_no=".$data[8];
		echo  $data[7] ;
	}
	
	
		elseif($data[4]=='Inventory Journal')
	{
		$link="inventory_journal_print_view.php?jv_no=".$data[8];
		echo  $data[8] ;
	}
	
		elseif($data[4]=='FOC')
	{
		$link="foc_sec_print_view.php?jv_no=".$data[8];
		echo  $data[7] ;
	}
	
	
		elseif($data[4]=='SCHEME')
	{
		$link="scheme_sec_print_view.php?jv_no=".$data[8];
		echo  $data[7] ;
	}
	
		elseif($data[4]=='PROVISION')
	{
		$link="provision_jv_print_view.php?jv_no=".$data[8];
		echo  $data[7] ;
	}
	
	
		elseif($data[4]=='Sales Return')
	{
		$link="sr_sec_print_view.php?jv_no=".$data[8];
		echo  $data[7] ;
	}
	
	
	else {
		echo $data[6];
	}
	?>	</td>
	<td></td>
	<td></td>
	<td><?=$data[13];?></td>
	<td><?=find_a_field('sale_do_master','do_date','do_no="'.$data[13].'"');?></td>
	<td><?=$data[14];?></td>
	<td></td>
	<td></td>
	<td></td>
	<!--<td></td>-->
	<td><?=$data[15];?></td>
    <td align="center"><?php echo date('d-m-Y',strtotime($data[0]));?></td>
    <td align="left"><?=$data[1];?></td>
    <td align="left"><?=$data[5];?><?=(($data[9]!='')?'-Cq#'.$data[9]:'');?><?=(($data[10]>943898400)?'-Cq-Date#'.date('d-m-Y',$data[10]):'');?></td>
    <td align="center"><?php echo $data[4];?></td>
    <td align="right"><?php echo number_format($data[2],2);?></td>
    <td align="right"><?php echo number_format($data[3],2);?></td>
    <td align="right" bgcolor="#FFCCFF"><?php $blance = $blance+($data[2]-$data[3]); if($blance>0) echo '(Dr) '.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <th colspan="5" align="center">Difference Balance : <?php echo number_format($t_total,2)." ".$t_type?> </th>
    
	<th colspan="12"></th>
    <th align="right"><strong><?php echo number_format($total[0],2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total[1],2);?></strong></th>
    <th align="right">&nbsp;</th>
  </tr>
  




<?

}

?>

</body>
</html>