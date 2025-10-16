<?

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

date_default_timezone_set('Asia/Dhaka');



if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)

{

	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))

	{

		$t_date=$_POST['t_date'];

		$f_date=$_POST['f_date'];

	}

	

	if($_POST['by']>0) 			$by=$_POST['by'];

	if($_POST['vendor_id']>0) 	$vendor_id=$_POST['vendor_id'];

	if($_POST['cat_id']>0) 		$cat_id=$_POST['cat_id'];

	if($_POST['item_id']>0) 	$item_id=$_POST['item_id'];

	if($_POST['sub_group_id']>0)$sub_group_id=$_POST['sub_group_id'];

	if($_POST['status']!='') 	$status=$_POST['status'];



switch ($_POST['report']) {

    case 1:

		$report="Purchase Order Report";

		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}

		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}

		if(isset($sub_group_id)) 		{$sub_group_id=' and e.sub_group_id='.$sub_group_id;}

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}

		

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		

		if($_POST['warehouse_id']>0)		{$wh_con=' and a.warehouse_id="'.$_POST['warehouse_id'].'"';}

		

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		  $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as entry_by, a.entry_at,a.po_no as po_no,b.id as order_id,d.sub_group_name,e.item_name,b.qty,b.rate,b.amount 

		   

		   from purchase_master a, purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f 

		   where a.po_no=b.po_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id and f.user_id=a.entry_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$sub_group_id.$item_con.$status_con.$wh_con.' order by a.po_date,b.id';

	break;

    case 2:

		$report=" Purchase Received report";



		if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}



	



		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}



		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}

		

		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}

		

		if(isset($ctg_warehouse)) 	{$ctg_warehouse_con=' and b.shed_id='.$ctg_warehouse;}



		if(isset($garden_id)) 	{$garden_id_con=' and b.garden_id='.$garden_id;}

		

		if($_POST['warehouse_id']>0)		{$wh_con=' and a.warehouse_id="'.$_POST['warehouse_id'].'"';}



		



		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}

		if($_POST['sub_group_id']>0){$sub_con=' and e.sub_group_id="'.$_POST['sub_group_id'].'"';}



		



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		



		 $sql='select a.po_no as po_no, DATE_FORMAT(a.po_date, "%d-%m-%Y") as po_date, r.serial_no, r.pr_no, r.rec_date, r.rec_date,  b.invoice_no as inv_no, e.item_name, r.qty as received,r.rate,r.amount

		

		 from purchase_master a, purchase_invoice b, purchase_receive r, vendor c, item_sub_group d, item_info e, user_activity_management f 

		 

		 where a.po_no=b.po_no and b.id=r.order_no and c.vendor_id=a.vendor_id and d.sub_group_id=e.sub_group_id and b.item_id=e.item_id  and f.user_id=a.entry_by and (a.status="CHECKED" or a.status="COMPLETED") '.$wh_con.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.$sub_con.$garden_id_con.' order by r.rec_date';

	break;

	

	case 3:

		$report="Chalan Report (Chalan Date Wise)";

		if(isset($by)) 			{$by_con=' and a.prepared_by='.$by;} 

		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;} 

		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;} 

		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;} 

		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';} 

if(isset($t_date)) 

{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

		  echo $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,

((select sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_qty, 

((select b.qty-sum(qty) from purchase_master_chalan where b.id=specification_id)) as balance_qty from purchase_master a, 

purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f where a.id=b.po_no and c.id=a.vendor_id and d.id=e.product_category_id and b.item_id=e.id and f.user_id=a.prepared_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.' order by a.id,b.id';

	break;

	case 4:

	if($_REQUEST['po_no']>0)

header("Location:work_order_print.php?po_no=".$_REQUEST['po_no']);

	break;

	case 5:

		$report="Purchase History Report";

		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 

		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 

		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 

		if(isset($vendor_id)) 	{$vendor_con=' and v.vendor_id='.$vendor_id;} 

		$status_con=' and a.tr_from = "Purchase" ';

		

		if(isset($t_date)) 

		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		

	echo	$sql='select ji_date as GR_Date,a.sr_no as GR_no,pm.po_date,pm.po_no,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `RQ`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,v.vendor_name,a.entry_at,c.fname as User 

		   

		   from journal_item a, item_info i, user_activity_management c , item_sub_group s , purchase_receive pr,purchase_master pm,vendor v

		   where pm.vendor_id=v.vendor_id and c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id and a.warehouse_id="5" and a.tr_no=pr.id and pr.po_no=pm.po_no '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.' order by a.id';

	break;

}

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title><?=$report?></title>

<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

<script language="javascript">

function hide()

{

document.getElementById('pr').style.display='none';

}

</script>

</head>

<body>

<div align="center" id="pr">

<input type="button" value="Print" onclick="hide();window.print();"/>

</div>

<div class="main">

<?

		$str 	.= '<div class="header" align="center">';

		if(isset($_SESSION['company_name'])) 

		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';

		if(isset($report)) 

		$str 	.= '<h2>'.$report.'</h2>';

		if(isset($to_date)) 

		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';

		if(isset($vendor_id)) 

		$str 	.= '<h2>Vendor Name: '.find_a_field('vendor','vendor_name','vendor_id="'.$vendor_id.'"').'</h2>';

		$str 	.= '</div>';

		if(isset($_SESSION['company_logo'])) 

		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';

		$str 	.= '<div class="left">';

		if(isset($project_name)) 

		$str 	.= '<p>Project Name: '.$project_name.'</p>';

		if($_POST['warehouse_id']>0)

		$str 	.= '<p style="text-align:center;">Branch.: '.find_a_field('warehouse','warehouse_name','warehouse_id="'.$_POST['warehouse_id'].'"').'</p>';

		$str 	.= '</div><div class="center">';

		

		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

if($_POST['report']==404)

{

$report="Customer Report";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">

		

		<thead>

		<tr><td colspan="7" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

<tbody>



	<tr>

		<th>S/L</th>

		<th>Customer Name</th>

		<th>Short Name</th>

		<th>Phone </th>

		<th>Email</th>

		<th>Address</th>

		<th>Bin</th>

	</tr>

<? 

if($_POST['customer_id']>0)
$con = 'and customer_id="'.$_POST['customer_id'].'"';

$res='select  * from crm_service_customer where 1 '.$con.'';
$query = db_query($res);
$i=1;
while($data=mysqli_fetch_object($query))

{

?>
	<tr>

	   <td><?=$i++?></td>
	   <td><?=$data->customer_name?></td>
	   <td><?=$data->short_name?></td>
	   <td><?=$data->phone_no?></td>
	   <td><?=$data->email?></td>
	   <td><?=$data->address?></td>
	   <td><?=$data->bin?></td>
	</tr>

<? }?>

	

</tbody></table>

<?

}
if($_POST['report']==505)

{

$report="Bill Information";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">

		

		<thead>

		<tr><td colspan="7" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

<tbody>



	<tr>

		<th>S/L</th>

		<th>Customer Name</th>

		<th>Phone </th>

		<th>Email</th>
		
		<th>Service Type</th>
		
		<th>Billing Cycle</th>
		
		<th>Fee</th>
		
		<th>Billing Date</th>

	</tr>

<? 

if($_POST['customer_id']>0)
$con = 'and c.customer_id="'.$_POST['customer_id'].'"';

if($_POST['type']>0)
$con .= 'and b.service_id="'.$_POST['type'].'"';

 $res='select  c.*,b.*,t.type from crm_service_customer c,crm_bill_assign b,crm_acc_bill_type t where c.customer_id=b.customer and b.service_id=t.id  '.$con.' order by c.customer_name asc';
$query = db_query($res);
$i=1;
while($data=mysqli_fetch_object($query))

{

?>
	<tr>
	   <td><?=$i++?></td>
	   <td><?=$data->customer_name?></td>
	   <td><?=$data->phone_no?></td>
	   <td><?=$data->email?></td>
	   <td><?=$data->type?></td>
	   <td><?=$data->cycle?></td>
	   <td><?=$data->service_charge?></td>
	   <td><?=$data->billing_cycle?></td>
	</tr>

<? }?>

	

</tbody></table>

<?

}


if($_POST['report']==606)

{

$report="Bill Information Report";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">

		

		<thead>

		<tr><td colspan="12" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

<tbody>



	<tr>

		<th>S/L</th>

		<th>Customer Name</th>

		<th>Bill No </th>

		<th>Bill Submit Date</th>
		
		<th>Month/Year</th>
		
		<th>Billing Type</th>
		
		<th>Submit By</th>
		
		<th>Discount</th>
		
		<th>Total Amount</th>
		
		<th>Status</th>
		
		<th>Receive Date</th>
		
		<th>Receive Amount</th>
		
		<th>Due Amount</th>
		
		<th>Receive By</th>

	</tr>

<? 



  $rec='select j.tr_no,sum(j.cr_amt) as amt,j.jv_date,u.fname from journal j,user_activity_management u where j.entry_by=u.user_id and j.tr_from in(select concat(type," Receive") from crm_acc_bill_type)group by j.tr_no';
$rquery=db_query($rec);
while($rRow=mysqli_fetch_object($rquery)){

$ramt[$rRow->tr_no]=$rRow->amt;
$rentry[$rRow->tr_no]=$rRow->fname;
$rdate[$rRow->tr_no]=$rRow->jv_date;
}



if($_POST['f_date']!='' && $_POST['t_date']){

$con=' and b.bill_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ';

}
if($_POST['customer_id']>0){
$con .= ' and b.customer="'.$_POST['customer_id'].'"';
}
if($_POST['status']!=''){
$con .= ' and b.status="'.$_POST['status'].'"';
}

if($_POST['type']>0)
$con .= 'and b.service_type="'.$_POST['type'].'"';

$res='select  b.*,c.customer_name,u.fname,t.type from crm_bill_info b left join crm_acc_bill_type t on t.id=b.service_type,crm_service_customer c,user_activity_management u where b.customer=c.customer_id and b.entry_by=u.user_id  '.$con.' group by b.bill_no';
$query = db_query($res);
$i=1;
while($data=mysqli_fetch_object($query))

{

?>
	<tr>

	   <td><?=$i++?></td>
	   <td><?=$data->customer_name?></td>
	   <td><?=$data->manual_bill_no?></td>
	   <td><?=$data->bill_date?></td>
	   <td><?=date("M-Y", strtotime($data->bill_date))?></td>
	   <td><?=$data->type?></td>
	   <td><?=$data->fname?></td>
	   <td><?=$data->discount_amt?></td>
	   <td><?=$data->net_receivable_amt?></td>
	   <td><?=$data->status?></td>
	    <td><?=($ramt[$data->bill_no]!='')? $rdate[$data->bill_no] : ''?></td>
	   <td><?=$ramt[$data->bill_no]?></td>
	   <td><?=($ramt[$data->bill_no]!='')? $data->net_receivable_amt-$ramt[$data->bill_no] : ''?></td>
	   <td><?=($ramt[$data->bill_no]!='')? $rentry[$data->bill_no] : ''?></td>
	</tr>

<? }?>

	

</tbody></table>

<?

}

if($_POST['report']==709)

{

$report="Collection Report";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">

		

		<thead>

		<tr><td colspan="12" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

<tbody>



	<tr>

		<th>S/L</th>

		<th>Collection Date</th>
		
		<th>Customer Name</th>
		
		<th>Discount Amount</th>
		
		<th>Tax Amount</th>
		
		<th>Net Collection Amount</th>

	</tr>

<? 

if($_POST['f_date']!='' && $_POST['t_date']){

$con=' and j.jv_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ';

}
if($_POST['customer_id']>0){
$con .= ' and d.customer_id="'.$_POST['customer_id'].'"';
}

  $rec='select j.jv_date,j.tr_no, sum(j.cr_amt) as received_amt,d.customer_name 
from journal j,crm_service_customer d where d.ledger_id=j.ledger_id '.$con.' group by j.ledger_id,j.tr_no';
$query = db_query($rec);
$i=1;
while($data=mysqli_fetch_object($query))

{
$discount_amt = find_a_field('journal','dr_amt','tr_no="'.$data->tr_no.'" and ledger_id=3110050001');
$tax_amt = find_a_field('journal','dr_amt','tr_no="'.$data->tr_no.'" and ledger_id=2310010002');
$gross_collection = $data->received_amt-($discount_amt+$tax_amt);

?>
	<tr>

	   <td><?=$i++?></td>
	   <td><?=$data->jv_date?></td>
	   <td><?=$data->customer_name?></td>
	   <td align="right"><?=($discount_amt>0)?number_format($discount_amt,2):'';$total_discount +=$discount_amt;?></td>
	   <td align="right"><?=($tax_amt>0)?number_format($tax_amt,2):'';$total_tax +=$tax_amt;?></td>
	   <td align="right"><?=($gross_collection>0)?number_format($gross_collection,2):'';$total_received +=$gross_collection;?></td>
	</tr>

<? }?>

	<tr>
	 <td colspan="3"><strong>Total</strong></td>
	 <td align="right"><strong><?=number_format($total_discount,2)?></strong></td>
	 <td align="right"><strong><?=number_format($total_tax,2)?></strong></td>
	 <td align="right"><strong><?=number_format($total_received,2)?></strong></td>
	</tr>

</tbody></table>

<?

}

if($_POST['report']==707)

{

$report="Bill Closing Report";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">

		

		<thead>

		<tr><td colspan="12" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 

		echo '<h2>AS ON: '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

<tbody>



	<tr>

		<th>S/L</th>

		<th>Customer Name</th>

		<th>License Amount</th>

		<th>Monthly Bill</th>
		
		<th>LF Opening</th>
		
		<th>MC Opening</th>
		
		<th>MC Payable</th>
		
		<th>Collection LF</th>
		
		<th>Collection MC</th>
		
		<th>Due LF</th>
		
		<th>Due MC</th>
		
		
		
		<th>Discount</th>
		
		<th>Closing LF</th>
		
		<th>Closing MC</th>
		

	</tr>

<? 

if($_POST['t_date']!=''){

$con=' and b.bill_date<="'.$_POST['t_date'].'" ';
$tdate = $_POST['t_date'];

}

$rec='select j.tr_no,sum(j.cr_amt) as amt,j.jv_date,u.fname from journal j,user_activity_management u where j.entry_by=u.user_id and j.tr_from="BillReceive" group by j.tr_no';
$rquery=db_query($rec);
while($rRow=mysqli_fetch_object($rquery)){

$ramt[$rRow->tr_no]=$rRow->amt;
$rentry[$rRow->tr_no]=$rRow->fname;
$rdate[$rRow->tr_no]=$rRow->jv_date;
}

$lfsql = 'select sum(service_charge) as service_charge,customer from crm_bill_assign where cycle="license" group by customer order by id desc';
$qrry = db_query($lfsql);
while($license=mysqli_fetch_object($qrry)){
$lf[$license->customer] = $license->service_charge;
}

$mcsql = 'select sum(service_charge) as service_charge,customer from crm_bill_assign where cycle="monthly" group by customer order by id desc';
$mcqrry = db_query($mcsql);
while($monthly=mysqli_fetch_object($mcqrry)){
$mc[$monthly->customer] = $monthly->service_charge;
}

//License bill payable
$psql = 'select sum(dr_amt) as total_payable,ledger_id from journal where tr_from in ("Service Charge","Server Charge","Service Charge + Server Charge","BillSubmit") and jv_date<="'.$tdate.'" group by ledger_id';
$pqrry = db_query($psql);
while($bill_payable=mysqli_fetch_object($pqrry)){
$total_mbill_payable[$bill_payable->ledger_id] = $bill_payable->total_payable;
}

//Monthly bill receive
$rsql = 'select sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("Service Charge Receive","Server Charge Receive","Service Charge + Server Charge Receive","BillReceive") and jv_date<="'.$tdate.'" group by ledger_id';
$rqrry = db_query($rsql);
while($bill_receive=mysqli_fetch_object($rqrry)){
$total_mbill_receive[$bill_receive->ledger_id] = $bill_receive->total_receive;
}

//License bill payable
$lpsql = 'select sum(dr_amt) as total_payable,ledger_id from journal where tr_from in("License Fee","LicenseBillSubmit") and jv_date<="'.$tdate.'" group by ledger_id';
$pqrry = db_query($lpsql);
while($lbill_payable=mysqli_fetch_object($pqrry)){
$total_lbill_payable[$lbill_payable->ledger_id] = $lbill_payable->total_payable;
}

//License bill receive
$lsql = 'select sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("License Fee Receive","LicenseBillReceive") and jv_date<="'.$tdate.'" group by ledger_id';
$lqrry = db_query($lsql);
while($lbill_receive=mysqli_fetch_object($lqrry)){
$total_lbill_receive[$lbill_receive->ledger_id] = $lbill_receive->total_receive;
}

//Monthly bill opening
$mosql = 'select sum(dr_amt-cr_amt) as total_receive,ledger_id from journal where tr_from in ("MCOpening") and jv_date<="'.$tdate.'" group by ledger_id';
$moqrry = db_query($mosql);
while($mopening=mysqli_fetch_object($moqrry)){
$monthly_opening[$mopening->ledger_id] = $mopening->total_receive;
}


//License bill opening
$losql = 'select sum(dr_amt) as total_receive,ledger_id from journal where tr_from in ("LFOpening") and jv_date<="'.$tdate.'" group by ledger_id';
$loqrry = db_query($losql);
while($lopening=mysqli_fetch_object($loqrry)){
$license_opening[$lopening->ledger_id] = $lopening->total_receive;
}

$losql = 'select sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("LFOpening") and jv_date<="'.$tdate.'" group by ledger_id';
$loqrry = db_query($losql);
while($lopening=mysqli_fetch_object($loqrry)){
$license_opening_receive[$lopening->ledger_id] = $lopening->total_receive;
}

$losql = 'select sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("MCOpening") and jv_date<="'.$tdate.'" group by ledger_id';
$loqrry = db_query($losql);
while($lopening=mysqli_fetch_object($loqrry)){
$monthly_opening_receive[$lopening->ledger_id] = $lopening->total_receive;
}



$con = '';
if($_POST['customer_id']>0){
$con = ' and customer_id="'.$_POST['customer_id'].'"';
}


$res='select customer_name,customer_id,ledger_id from crm_service_customer where 1 '.$con.' order by customer_name asc';
$query = db_query($res);
$i=1;
while($data=mysqli_fetch_object($query))
{
$opening_monthly=$monthly_opening[$data->ledger_id];
$opening_license=$license_opening[$data->ledger_id];

   $monthly_bill_due=($total_mbill_payable[$data->ledger_id]+$opening_monthly)-($total_mbill_receive[$data->ledger_id]);
$total_monthly_payable = $total_mbill_payable[$data->ledger_id];
$total_monthly_receive = $total_mbill_receive[$data->ledger_id]+$monthly_opening_receive[$data->ledger_id];
$total_license_bill_payable = $total_lbill_payable[$data->ledger_id];
$total_license_bill_receive = $license_opening_receive[$data->ledger_id];//$total_lbill_receive[$data->ledger_id];

$due_license_bill = ($total_license_bill_payable+$opening_license)-$total_license_bill_receive;

  $mc_closing = $monthly_bill_due-$mcdiscount;

$lf_due = $total_license_bill_payable-$opening_license;
$lf_real_due =  $license_opening[$data->ledger_id];
$lf_closing = $lf_real_due-$lfdiscount;

?>
	<tr>

	   <td><?=$i++?></td>
	   <td><?=$data->customer_name?></td>
	   <td><?=($lf[$data->customer_id]>0)? number_format($lf[$data->customer_id],2):'';$total_lf +=$lf[$data->customer_id];?></td>
	   <td><?=($mc[$data->customer_id]>0)? number_format($mc[$data->customer_id],2):'';$total_mc +=$mc[$data->customer_id];?></td>
	   
	   <td><?=($opening_license>0)? number_format($opening_license,2):'';$total_opening_license +=$opening_license;?></td>
	   <td><?=($opening_monthly>0)? number_format($opening_monthly,2):'';$total_opening_monthly +=$opening_monthly;?></td>
	  
	   
	   <!--<td><?=($total_license_bill_payable>0)? number_format($total_license_bill_payable,2):'';$total_lf_payable +=$total_license_bill_payable;?></td>-->
	   <td><?=($total_monthly_payable>0)? number_format($total_monthly_payable,2):'';$total_mc_payable +=$total_monthly_payable;?></td>
	   <td><?=($total_license_bill_receive>0)? number_format($total_license_bill_receive,2):'';$toatl_lf_receive +=$total_license_bill_receive;?></td>
	   <td><?=($total_monthly_receive>0)? number_format($total_monthly_receive,2):'';$total_mc_receive +=$total_monthly_receive;?></td>
	   
	   <td><?=($lf_real_due>0)? number_format($lf_real_due,2):'';$total_lf_due +=$lf_real_due?></td>
	   <td><?=($monthly_bill_due>0)? number_format($monthly_bill_due,2):'';$total_mc_due +=$monthly_bill_due?></td>
	  
	   <td><?=$discount;$total_discount +=$total_discount;?></td>
	   <td><?=($lf_closing>0)? number_format($lf_closing,2):'';$total_lf_closing +=$lf_closing;?></td>
	   <td><?=($mc_closing>0)? number_format($mc_closing,2):'';$total_mc_closing +=$mc_closing;?></td>
	   
	</tr>

<? }?>

<tr>
 <td colspan="2"><strong>Total</strong></td>
 <td><strong><?=number_format($total_lf,2)?></strong></td>
 <td><strong><?=number_format($total_mc,2)?></strong></td>
 <td><strong><?=number_format($total_opening_license,2)?></strong></td>
 <td><strong><?=number_format($total_opening_monthly,2)?></strong></td>
 <!--<td><strong><?=number_format($total_lf_payable,2)?></strong></td>-->
 <td><strong><?=number_format($total_mc_payable,2)?></strong></td>
 <td><strong><?=number_format($toatl_lf_receive,2)?></strong></td>
 <td><strong><?=number_format($total_mc_receive,2)?></strong></td>
 <td><strong><?=number_format($total_lf_due,2)?></strong></td>
 <td><strong><?=number_format($total_mc_due,2)?></strong></td>
 <td><strong><?=number_format($total_discount,2)?></strong></td>
 <td><strong><?=number_format($total_lf_closing,2)?></strong></td>
 <td><strong><?=number_format($total_mc_closing,2)?></strong></td>
</tr>	

</tbody></table>

<?

}


if($_POST['report']==777)

{

$report="Monthly Collection Report";

?>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">

		

		<thead>

		<tr><td colspan="12" style="border:0px;">

		<?

		echo '<div class="header">';

		echo '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

		if(isset($report)) 

		echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 

		echo '<h2>Monthly: '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>

		</td></tr>

<tbody>



	<tr>

		<th>S/L</th>

		<th>Customer Name</th>

		<th>License Amount</th>

		<th>Monthly Bill</th>
		
		<th>LF Opening</th>
		
		<th>MC Opening</th>
		
		<!--<th>MC Payable</th>-->
		
		<th>Collection LF</th>
		
		<th>Collection MC</th>
		
		
		
		
		
		<th>Discount</th>
		
		<th>Closing LF</th>
		
		<th>Closing MC</th>
		

	</tr>

<? 

if($_POST['t_date']!=''){

$con=' and b.bill_date<="'.$_POST['t_date'].'" ';
$tdate = $_POST['t_date'];

}

elseif ($_POST['f_date']!=''){

$con2=' and b.bill_date<="'.$_POST['f_date'].'" ';
$fdate = $_POST['f_date'];

}

$rec='select j.tr_no,sum(j.cr_amt) as amt,j.jv_date,u.fname from journal j,user_activity_management u where j.entry_by=u.user_id and j.tr_from="BillReceive" group by j.tr_no';
$rquery=db_query($rec);
while($rRow=mysqli_fetch_object($rquery)){

$ramt[$rRow->tr_no]=$rRow->amt;
$rentry[$rRow->tr_no]=$rRow->fname;
$rdate[$rRow->tr_no]=$rRow->jv_date;
}

$lfsql = 'select sum(service_charge) as service_charge,customer from crm_bill_assign where cycle="license" group by customer order by id desc';
$qrry = db_query($lfsql);
while($license=mysqli_fetch_object($qrry)){
$lf[$license->customer] = $license->service_charge;
}

  $mcsql = 'select sum(service_charge) as service_charge,customer from crm_bill_assign where cycle="monthly" group by customer order by id desc';
$mcqrry = db_query($mcsql);
while($monthly=mysqli_fetch_object($mcqrry)){
$mc[$monthly->customer] = $monthly->service_charge;
}

//License bill payable
$psql = 'select sum(dr_amt) as total_payable,ledger_id from journal where tr_from in ("Service Charge","Server Charge","Service Charge + Server Charge","BillSubmit") and jv_date<="'.$tdate.'" group by ledger_id';
$pqrry = db_query($psql);
while($bill_payable=mysqli_fetch_object($pqrry)){
$total_mbill_payable[$bill_payable->ledger_id] = $bill_payable->total_payable;
}

//Monthly bill receive
 $rsql = 'select sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("Service Charge Receive","Server Charge Receive","Service Charge + Server Charge Receive","BillReceive") and jv_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" group by ledger_id';
$rqrry = db_query($rsql);
while($bill_receive=mysqli_fetch_object($rqrry)){
$total_mbill_receive[$bill_receive->ledger_id] = $bill_receive->total_receive;
}

//License bill payable
$lpsql = 'select sum(dr_amt) as total_payable,ledger_id from journal where tr_from in("License Fee","LicenseBillSubmit") and jv_date<="'.$tdate.'" group by ledger_id';
$pqrry = db_query($lpsql);
while($lbill_payable=mysqli_fetch_object($pqrry)){
$total_lbill_payable[$lbill_payable->ledger_id] = $lbill_payable->total_payable;
}

//License bill receive
$lsql = 'select sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("License Fee Receive","LicenseBillReceive") and jv_date<"'.$_POST['f_date'].'" group by ledger_id';
$lqrry = db_query($lsql);
while($lbill_receive=mysqli_fetch_object($lqrry)){
$total_lbill_receive[$lbill_receive->ledger_id] = $lbill_receive->total_receive;
}

//Monthly bill opening
   $mosql = 'select sum(dr_amt)-sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("MCOpening","Service Charge Receive","Server Charge Receive","Service Charge + Server Charge Receive","BillReceive") and jv_date<"'.$_POST['f_date'].'" group by ledger_id';
$moqrry = db_query($mosql);
while($mopening=mysqli_fetch_object($moqrry)){
$monthly_opening[$mopening->ledger_id] = $mopening->total_receive;
}


//



//

//License bill opening
$losql = 'select sum(dr_amt)-sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("LFOpening") and jv_date<"'.$_POST['f_date'].'" group by ledger_id';
$loqrry = db_query($losql);
while($lopening=mysqli_fetch_object($loqrry)){
$license_opening[$lopening->ledger_id] = $lopening->total_receive;
}

 $losql = 'select sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("LFOpening") and jv_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" group by ledger_id';
$loqrry = db_query($losql);
while($lopening=mysqli_fetch_object($loqrry)){
$license_opening_receive[$lopening->ledger_id] = $lopening->total_receive;
}

$losql = 'select sum(cr_amt) as total_receive,ledger_id from journal where tr_from in ("MCOpening") and jv_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" group by ledger_id';
$loqrry = db_query($losql);
while($lopening=mysqli_fetch_object($loqrry)){
$monthly_opening_receive[$lopening->ledger_id] = $lopening->total_receive;
}



$con = '';
if($_POST['customer_id']>0){
$con = ' and customer_id="'.$_POST['customer_id'].'"';
}


$res='select customer_name,customer_id,ledger_id from crm_service_customer where 1 '.$con.' order by customer_name asc';
$query = db_query($res);
$i=1;
while($data=mysqli_fetch_object($query))
{
$opening_monthly=$monthly_opening[$data->ledger_id];

$opening_license=$license_opening[$data->ledger_id]-$license_opening_receive[$data->ledger_id];

$monthly_bill_due=($total_mbill_payable[$data->ledger_id]+$opening_monthly)-$total_mbill_receive[$data->ledger_id];
$total_monthly_payable = $total_mbill_payable[$data->ledger_id];
$total_monthly_receive = $total_mbill_receive[$data->ledger_id]+$monthly_opening_receive[$data->ledger_id];
$total_license_bill_payable = $total_lbill_payable[$data->ledger_id];
$total_license_bill_receive = $license_opening_receive[$data->ledger_id];//$total_lbill_receive[$data->ledger_id];

$due_license_bill = ($total_license_bill_payable+$opening_license)-$total_license_bill_receive;

$mc_closing =($opening_monthly+$mc[$data->customer_id] )-($mcdiscount+$total_monthly_receive);

$lf_due = $total_license_bill_payable-$opening_license;
$lf_real_due =  $license_opening[$data->ledger_id];
$lf_closing = $lf_real_due-$total_license_bill_receive-$lfdiscount;

?>
	<tr>

	   <td><?=$i++?></td>
	   <td><?=$data->customer_name?></td>
	   <td><?=($lf[$data->customer_id]>0)? number_format($lf[$data->customer_id],2):'';$total_lf +=$lf[$data->customer_id];?></td>
	   <td><?=($mc[$data->customer_id]>0)? number_format($mc[$data->customer_id],2):'';$total_mc +=$mc[$data->customer_id];?></td>
	   
	   <td><?=($license_opening[$data->ledger_id]>0)? number_format($license_opening[$data->ledger_id],2):'';$total_opening_license +=$license_opening[$data->ledger_id];?></td>
	   
	   <td><?=($monthly_opening[$data->ledger_id]>0)? number_format($monthly_opening[$data->ledger_id],2):'';$total_opening_monthly +=$monthly_opening[$data->ledger_id];?></td>
	  
	   
	   <!--<td><?=($total_license_bill_payable>0)? number_format($total_license_bill_payable,2):'';$total_lf_payable +=$total_license_bill_payable;?></td>-->
	   <?php /*?><td><?=($total_monthly_payable>0)? number_format($total_monthly_payable,2):'';$total_mc_payable +=$total_monthly_payable;?></td><?php */?>
	   <td><?=($total_license_bill_receive>0)? number_format($total_license_bill_receive,2):'';$toatl_lf_receive +=$total_license_bill_receive;?></td>
	   <td><?=($total_monthly_receive>0)? number_format($total_monthly_receive,2):'';$total_mc_receive +=$total_monthly_receive;?></td>
	   
	   
	  
	   <td><?=$discount;$total_discount +=$total_discount;?></td>
	   <td><?=($lf_closing>0)? number_format($lf_closing,2):'';$total_lf_closing +=$lf_closing;?></td>
	   <td><?=($mc_closing>0)? number_format($mc_closing,2):'';$total_mc_closing +=$mc_closing;?></td>
	   
	</tr>

<? }?>

<tr>
 <td colspan="2"><strong>Total</strong></td>
 <td><strong><?=number_format($total_lf,2)?></strong></td>
 <td><strong><?=number_format($total_mc,2)?></strong></td>
 <td><strong><?=number_format($total_opening_license,2)?></strong></td>
 <td><strong><?=number_format($total_opening_monthly,2)?></strong></td>
 <!--<td><strong><?=number_format($total_lf_payable,2)?></strong></td>-->
 <?php /*?><td><strong><?=number_format($total_mc_payable,2)?></strong></td><?php */?>
 <td><strong><?=number_format($toatl_lf_receive,2)?></strong></td>
 <td><strong><?=number_format($total_mc_receive,2)?></strong></td>
 
 <td><strong><?=number_format($total_discount,2)?></strong></td>
 <td><strong><?=number_format($total_lf_closing,2)?></strong></td>
 <td><strong><?=number_format($total_mc_closing,2)?></strong></td>
</tr>	

</tbody></table>

<?

}




elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);

?></div>

</body>

</html>