<?

//session_start();

 

 

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

	case 11001:
		$report="Purchase Quotation Report";
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.quotation_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		break;

    case 1:
		$report="Purchase Quotation Report";
		//if(isset($by)) 			{$by_con=' and a.entry_by='.$by;}
		if($_POST['by']>0)
		
		$by_con .= 'and a.entry_by="'.$_POST['by'].'"';
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}
		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
		
		if($_POST['sub_group_id']>0)
		
		$item_con .= 'and d.sub_group_id="'.$_POST['sub_group_id'].'"';

		//if(isset($sub_group_id)){$item_sub_con=' and d.sub_group_id='.$sub_group_id;} 
		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}
		
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.quotation_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		   /*$sql='select a.quotation_no as quotation_no,a.quotation_date as quotation_date, a.req_no,c.vendor_name as vendor_name,a.status,e.item_name,b.unit_name,b.qty as qua,b.quotation_price 
		   
		   from quotation_master a, quotation_detail b, vendor c, item_info e
		   where a.quotation_no=b.quotation_no and a.vendor_id=c.vendor_id and b.item_id=e.item_id and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.' order by a.quotation_no';*/
	break;
	
    case 2:
		$report="Chalan Report (Purchase Order Wise)";
		if(isset($by)) 			{$by_con=' and a.prepared_by='.$by;} 
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;} 
		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;} 
		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;} 
		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';} 
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.po_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
echo  $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,
((select sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_qty, 
((select b.rate*sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_amt,

if((select count(qty) from purchase_master_chalan where b.id=specification_id)>0,((b.qty-(select sum(qty) from purchase_master_chalan where b.id=specification_id))*1.00),(b.qty*1.00)) as balance_qty
 from purchase_master a, 
purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f where a.id=b.po_no and c.id=a.vendor_id and d.id=e.product_category_id and b.item_id=e.id and f.user_id=a.prepared_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.' order by a.id,b.id';
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

		
		   $sql='select a.po_date,c.vendor_name as vendor_name,a.status,f.fname as prepared_by, a.prepared_at,a.id as po_no,b.id as order_id,d.category_name,e.item_name,(b.qty*1.00) as qty,b.rate,b.amount,
((select sum(qty) from purchase_master_chalan where b.id=specification_id)*1.00) as chalan_qty, 
((select b.qty-sum(qty) from purchase_master_chalan where b.id=specification_id)) as balance_qty from purchase_master a, 
purchase_invoice b, vendor c, item_sub_group d, item_info e, user_activity_management f where a.id=b.po_no and c.id=a.vendor_id and d.id=e.product_category_id and b.item_id=e.id and f.user_id=a.prepared_by and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$status_con.' order by a.id,b.id';
	break;
	case 4:
	if($_REQUEST['wo_id']>0)
header("Location:work_order_print.php?po_no=".$_REQUEST['wo_id']);
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

		
		 $sql='select ji_date as GR_Date,a.sr_no as GR_no,pm.po_date,pm.po_no,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `RQ`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,v.vendor_name,a.entry_at,c.fname as User 
		   
		   from journal_item a, item_info i, user_activity_management c , item_sub_group s , purchase_receive pr,purchase_master pm,vendor v
		   where pm.vendor_id=v.vendor_id and c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id and a.warehouse_id="1" and a.tr_no=pr.id and pr.po_no=pm.po_no '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.' order by a.id';
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

	<?
	require_once "../../../controllers/core/inc.exporttable.php";
	?>

</head>
<body>
<!--<div align="center" id="pr">-->
<!--<input type="button" value="Print" onclick="hide();window.print();"/>-->
<!--</div>-->
<div class="main">
<?

//		$str 	.= '<div class="header">';
//		if(isset($_SESSION['company_name']))
//		$str 	.= '<h1>'.find_a_field('user_group','group_name','1').'</h1>';
//		if(isset($report))
//		$str 	.= '<h2>'.$report.'</h2>';
//		if(isset($to_date))
//		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
//		$str 	.= '</div>';
//		if(isset($_SESSION['company_logo']))
//		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
//		$str 	.= '<div class="left">';
//		if(isset($project_name))
//		$str 	.= '<p>Project Name: '.$project_name.'</p>';
//		if(isset($allotment_no))
//		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
//		$str 	.= '</div><div class="right">';
//		if(isset($client_name))
//		$str 	.= '<p>Client Name: '.$client_name.'</p>';
//		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
//------------------------------------------------------------------------------------------------------


		$str 	.= '<tr style="border: 0px">';
		$str 	.= '<th style="border: 0px" colspan="2" width="25%" align="center" >';
	if(isset($_SESSION['user']['group']))
		$str 	.= '<img width="50%" src="<?=SERVER_ROOT?>public/uploads/logo/'.$_SESSION['proj_id'].'.png'.'">';
		$str 	.= '</th>';

		$str 	.= '<th style="border: 0px" colspan="6" width="50%" align="center" >';
		$str 	.= '<h1 style="font-weight: bolder; text-align: center;">'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

	if(isset($report))
		$str 	.= '<h2 style="margin: 1px; font-size:14px; text-align: center;">'.$report.'</h2>';


	if(isset($vendor_id))
		$str 	.= '<h2 style="margin: 1px; font-size:12px; text-align: center;"><strong>Vendor Name:</strong>'.find_a_field('vendor','vendor_name','vendor_id='.$vendor_id).'</h2>';


	if(isset($ctg_warehouse))
		$str 	.= '<h3 style="margin: 1px; font-size:12px; text-align: center;"><strong>Ctg Warehouse:</strong> '.find_a_field('tea_warehouse','warehouse_name','warehouse_id='.$ctg_warehouse).'</h3>';

	if(isset($garden_id))
		$str 	.= '<h3 style="margin: 1px; font-size:12px; text-align: center;"><strong>Garden Name:</strong> '.find_a_field('tea_garden','garden_name','garden_id='.$garden_id).'</h3>';


	if(isset($to_date))
		$str 	.= '<h2 style="margin: 1px; font-size:12px; text-align: center;"><strong>For the Period of: </strong>'.date("d-m-Y",strtotime($fr_date)).' <strong>To</strong> '.date("d-m-Y",strtotime($to_date)).'</h2>';

	if(isset($warehouse_id))
		$str 	.= '<h2 style="margin: 1px; font-size:12px; text-align: center;"><strong>PL/WH Name: </strong>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</h2>';

	if(isset($allotment_no))
		$str 	.= '<h2 style="margin: 1px; font-size:12px; text-align: center;"><strong>Allotment No: </strong> '.$allotment_no.'</h2>';

	if(isset($item_id))
		$str 	.= '<h2 style="margin: 1px; font-size:12px; text-align: center;"><strong>Item Name: </strong> '.find_a_field('item_info','item_name','item_id='.$item_id).'</h2>';
		$str 	.= '</th>';


		$str 	.= '<th style="border: 0px" colspan="2" width="25%" align="center" >';
		$str 	.= '</th>';
		$str 	.= '</tr>';
		$str 	.= '<tr><th style="border: 0px" colspan="10">';
		$str 	.= '<div class="date" style="margin: 1px; font-size:12px;"> <strong>Reporting Time:</strong> '.date("h:i A d-m-Y").'</div>';
		$str 	.= '</th></tr>';









if($_REQUEST['report']==1100) { // do summery report modify jan 24 2018

 $sql="select m.do_no,i.item_name,m.do_date,d.dealer_name_e as dealer_name,
w.warehouse_name as depot,s.unit_price,s.total_unit,s.total_amt,m.status


from sale_return_master m,sale_return_details s,dealer_info d  , warehouse w, item_info i,user_group u

where m.status in ('CHECKED','COMPLETED')  and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and i.item_id=s.item_id
".$depot_con.$date_con.$item_con.$dealer_con.$dtype_con." order by m.do_date,m.do_no";


$query = db_query($sql); ?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" 	id="ExportTable">

<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>

<tr>
<th>S/L</th>
<th>SR No</th>
<th>Item Name</th>
<th>SR Date</th>
<th>Dealer Name</th>
<th>Depot</th>
<th>Unit Price</th>
<th>Total Unit</th>
<th>Total Amount</th>
<th>Status</th>
<!--<th>Payment Details</th>
<th>Total Amt</th>-->
</tr>
</thead><tbody>

<?
while($data=mysqli_fetch_object($query)){$s++;

?>
<tr>
<td><?=$s?></td>
<td><?=$data->do_no?></td>
<td><?=$data->item_name?></td>
<td><?=$data->do_date?></td>
<td><?=$data->dealer_name?></td>
<td><?=$data->depot?></td>
<td><?=$data->unit_price?></td>
<td><?=$data->total_unit?></td>
<td style="text-align:right"><?=$data->total_amt; $total=$total+$data->total_amt?></td>
<td style="text-align:right"><?=$data->status?></td>

</tr>
<? } ?>
<tr class="footer">
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right">&nbsp;</td>
<td style="text-align:right;">Total Amount</td>
<td style="text-align:right;"><?=number_format($total,2)?></td>
</tr>
</tbody>
</table>
<? }


if($_REQUEST['report']==11001) { // do summery report modify jan 24 2018

 if($_POST['by']>0)
		
		$by_con .= 'and a.entry_by="'.$_POST['by'].'"';
		
		if(isset($vendor_id)) 	{$vendor_con=' and a.vendor_id='.$vendor_id;}
		if(isset($cat_id)) 		{$cat_con=' and d.id='.$cat_id;}
		if(isset($item_id)) 	{$item_con=' and b.item_id='.$item_id;}
		
		if($_POST['sub_group_id']>0)
		
		$item_con .= 'and d.sub_group_id="'.$_POST['sub_group_id'].'"';

		//if(isset($sub_group_id)){$item_sub_con=' and d.sub_group_id='.$sub_group_id;} 
		if(isset($status)) 		{$status_con=' and a.status="'.$status.'"';}
		
if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.quotation_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		   $sqlll='select a.quotation_no as quotation_no,a.quotation_date as quotation_date, a.req_no,c.vendor_name as vendor_name,a.status,e.item_name,b.unit_name,b.qty,b.quotation_price 
		   
		   from quotation_master a, quotation_detail b, vendor c, item_info e
		   where a.quotation_no=b.quotation_no and a.vendor_id=c.vendor_id and b.item_id=e.item_id and a.status!="MANUAL" '.$date_con.$by_con.$vendor_con.$cat_con.$item_con.$item_sub_con.$status_con.' order by a.quotation_no';


$query = db_query($sqlll); ?>
<table width="100%" cellspacing="0" cellpadding="2" border="0" 	id="ExportTable">

<thead><tr><td style="border:0px;" colspan="11"><?=$str?></td></tr>

<tr>
<th>S/L</th>
<th>Quotation No</th>
<th>Quotation Date</th>
<th>Req No</th>
<th>Vendor Name</th>
<th>Status</th>
<th>Item Name</th>
<th>Unit Name</th>
<th>Quantity</th>
<th>Quotation Price</th>
<!--<th>Payment Details</th>
<th>Total Amt</th>-->
</tr>
</thead><tbody>

<?
while($data=mysqli_fetch_object($query)){$s++;

?>
<tr>
<td><?=$s?></td>
<td><?=$data->quotation_no?></td>
<td><?=$data->quotation_date?></td>
<td><?=$data->req_no?></td>
<td><?=$data->vendor_name?></td>
<td><?=$data->status?></td>
<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td style="text-align:right"><?=$data->qty;?></td>
<td style="text-align:right"><?=$data->quotation_price?></td>

</tr>
<? 
$tot_quantity+=$data->qty;
} ?>
<tr>
<th colspan="8" style="text-align:right;">Total</th>

<th style="text-align:right;"><?php echo $tot_quantity;?></th>
<th></th>
</tr>
</tbody>
</table>
<? }		
if($_POST['report']==6)
{
$report="Purchase Receive Report";
?>
	<table width="100%" border="0" cellpadding="2" cellspacing="0" 	id="ExportTable">
		
		<thead>
		<tr><td colspan="19" style="border:0px;">
		<?
		echo '<div class="header">';
		echo '<h1>'.find_a_field('project_info','proj_name','1').'</h1>';
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
		<th>Po No</th>
		<th>Po Date</th>
		<th>Vendor Name</th>
		<th>Item Name </th>
		<th>Rate</th>
		<th>OQ</th>
		<th>RQ</th>
		<th>DQ</th>
	    <th>Amt</th>
	</tr>
<? 


if($_POST['f_date']!=''&&$_POST['t_date']!='')
$con .= ' and a.po_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
if($_POST['vendor_id']>0)
$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';

$res='select  a.po_no, a.po_date, v.vendor_name,u.fname as entry_by
from 
purchase_master a,warehouse b, vendor v,user_activity_management u where u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id and  a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' order by a.po_no desc';

$query = db_query($res);
while($data=mysqli_fetch_object($query))
{

?>

	<tr>
      <td valign="top"><?=$data->po_no;?></td>
	  <td valign="top"><?=$data->po_date;?></td>
	  <td valign="top"><?=$data->vendor_name;?></td>
	  <td colspan="6">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px; border:0;" id="ExportTable">
<? 
$sql = 'select a.*,b.item_name from purchase_invoice a,item_info b where a.item_id=b.item_id and a.po_no="'.$data->po_no.'"';
$sqlq = db_query($sql);
while($info=mysqli_fetch_object($sqlq)){
?>
	<tr style=" border-collapse: collapse;">
	  <td width="28.5%"><?=$info->item_name.'('.$info->unit_name.')';?></td>
	  <td width="15.3%"><?=number_format($info->rate,2)?></td>
	  <td width="11%"><?=number_format($info->qty,0)?></td>
	  <td width="11%"><? $rq = find_a_field('purchase_receive','sum(qty)','order_no="'.$info->id.'"'); echo number_format($rq,0);?></td>
	  <td width="11%"><? $dq = $info->qty - $rq; if($dq>0) echo number_format($dq,0); $tot = $rq*$info->rate; $total = $total + $tot;?></td>
	  <td width="0%"><?=number_format(($tot),2);?></td>
	</tr>
<? }?>
</table>
	  </td>
	</tr>
<? }?>
	<tr>
	  <td colspan="8" valign="top"><div align="right"><strong>Total:</strong></div></td>
	  <td><div align="left">
	    <?=number_format(($total),2);?></div></td>
	</tr>
</tbody>
	</table>
<?
}
elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);


?></div>
</body>
</html>