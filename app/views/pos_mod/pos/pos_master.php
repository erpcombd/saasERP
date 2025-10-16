<?

session_start();
require_once "../../../assets/support/inc.all.php";

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
	
	if($_POST['warehouse_id']>0) 				$warehouse_id=$_POST['warehouse_id'];
	if($_POST['item_id']>0) 					$item_id=$_POST['item_id'];
	if($_POST['receive_status']!='') 			$receive_status=$_POST['receive_status'];
	if($_POST['issue_status']!='') 				$issue_status=$_POST['issue_status'];
	if($_POST['item_sub_group']>0) 				$sub_group_id=$_POST['item_sub_group'];
	if($_POST['item_brand']>0) 				    $item_brand=$_POST['item_brand'];
	if($_POST['dealer_code']>0) 		        $dealer=$_POST['dealer_code'];
	
	if($_POST['ctg_warehouse']>0) 				$ctg_warehouse=$_POST['ctg_warehouse'];
	if($_POST['garden_id']>0) 				    $garden_id=$_POST['garden_id'];
	
	
switch ($_POST['report']) {
    case 1:
		echo $report="Point Of Sales Details Report";
		
	break;
   
		
		case 6:
		$report="Depot Transfer Report (Brief)";
		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;}  
		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 
		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 

		
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}

		
		$sql='select 
		
		i.finish_goods_code as fg,
		i.item_name,
		i.unit_name as unit,
		
		sum(a.item_ex) as qty,
		
		i.p_price as Cost_Price,
		sum(a.item_ex*p_price) as cost_Amt,
		i.d_price as Distributor_Price,
		sum(a.item_ex*i.d_price) as Distributor_Amt
		from journal_item a, item_info i, user_activity_management c,warehouse w  where w.use_type!="PL" and a.item_ex>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 
		w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';
		break;
		
		
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
	<?
	require_once "../../../assets/support/inc.exporttable.php";
	?>
</head>
<body>
<!--<div align="center" id="pr">-->
<!--<input name="button" type="button" onclick="hide();window.print();" value="Print" />-->
<!--</div>-->
<div class="main">
<?
		$str 	.= '<div class="header">';
		$str 	.= '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		
		if(isset($vendor_id)) 
		$str 	.= '<h3>Broker Name: '.find_a_field('vendor','vendor_name','vendor_id='.$vendor_id).'</h3>';
		
		if(isset($ctg_warehouse)) 
		$str 	.= '<h3>Ctg Warehouse: '.find_a_field('tea_warehouse','warehouse_name','warehouse_id='.$ctg_warehouse).'</h3>';
		
		if(isset($garden_id)) 
		$str 	.= '<h3>Garden Name: '.find_a_field('tea_garden','garden_name','garden_id='.$garden_id).'</h3>';
		
		
		if(isset($to_date)) 
		$str 	.= '<h2>'.date("d-m-Y",strtotime($fr_date)).' To '.date("d-m-Y",strtotime($to_date)).'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(isset($warehouse_id))
		$str 	.= '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($item_id)) 
		$str 	.= '<p>Item Name: '.find_a_field('item_info','item_name','item_id='.$item_id).'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		
if($_POST['report']==1111) 
{	

echo 'working';
?>

<table width="100%" cellspacing="0" cellpadding="2" border="0" id="ExportTable">
<thead>
<tr>
<th>S/L</th>
<th>POS No.</th>
<th>POS Date</th>
<th>Customer Name</th>
<th>Item Name</th>
<th>Qty</th>
<th>Rate</th>
<th>Total Amount</th>
<th>Discount</th>
<th>Total Receivable</th>
<th>Sales Person</th>
<th>Entry By</th>
<th>Entry At</th>
</tr>
</thead>
<tbody>
<?
if(isset($warehouse_id)) 				{$warehouse_con=' and m.warehouse_id='.$warehouse_id;} 
		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
		if(isset($dealer)) 				        {$dealer_con=' and m.dealer_id='.$dealer;} 
		elseif(isset($item_id)) 				{$item_con=' and s.item_id='.$item_id;} 
		if(isset($t_date)) 
		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.pos_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
echo $possql='select m.pos_id,m.pos_date,d.dealer_name,i.item_name,w.warehouse_id, s.qty,s.rate,s.total_amt,s.discount_amt,m.register_discount,p.PBI_NAME as sales_person,u.fname,m.entry_at m.comments 

from sale_pos_master m, warehouse w, sale_pos_details s left join dealer_pos d on d.dealer_code=s.dealer_id left join item_info i on i.item_id=s.item_id left join personnel_basic_info p on p.PBI_ID=m.sales_person left join user_activity_management u on u.user_id=m.entry_by 

where m.pos_id=s.pos_id and m.warehouse_id=w.warehouse_id '.$warehouse_con.$item_sub_con.$item_con.$date_con.$dealer_con.' ';
$posqry = mysql_query($possql);		 
while($data=mysql_fetch_object($posqry)){
$total_receivable =  $data->total_amt-$data->discount_amt;
?>
<tr>
<td><?=$j?></td>
<td><?=$pos_id?></td>
<td><?=$data->pos_date?></td>
<td><?=$data->dealer_name?></td>
<td><?=$data->item_name?></td>
<td><?=$data->qty?></td>
<td><?=$data->rate?></td>
<td style="text-align:right"><?=number_format($data->total_amt,2)?></td>
<td style="text-align:right"><?=@number_format($data->discount_amt,2)?></td>
<td style="text-align:right"><?=number_format($total_receivable,2)?></td>
<td><?=$data->sales_person?></td>
<td><?=$data->fname?></td>
<td><?=$data->entry_at?></td>
</tr>
<?
}
		
?>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td align="right"> <b>Total:</b></td>
<td></td>
<td></td>
<td></td>
<td style="text-align:right"><?=number_format(($total_amt),2)?></td>
</tr>
<?

}

elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
}
?>
</div>
</body>
</html>