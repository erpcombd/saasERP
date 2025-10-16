<?


 



//require "../../../engine/tools/check.php";

//

//require "../../../engine/configure/db_connect.php";

//

//require "../../../engine/tools/my.php";

//

//require "../../../engine/tools/report.class.php";




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



	



if($_POST['product_group']!='') $product_group=$_POST['product_group'];



if($_POST['item_brand']!='') 	$item_brand=$_POST['item_brand'];



if($_POST['item_id']>0) 		$item_id=$_POST['item_id'];



if($_POST['dealer_code']>0) 	$dealer_code=$_POST['dealer_code'];

if($_POST['item_sub_group']>0) 	$sub_group_id=$_POST['item_sub_group'];






if($_POST['status']!='') 		$status=$_POST['status'];



if($_POST['or_no']!='') 		$or_no=$_POST['or_no'];



if($_POST['area_id']!='') 		$area_id=$_POST['area_id'];



if($_POST['zone_id']!='') 		$zone_id=$_POST['zone_id'];



if($_POST['region_id']>0) 		$region_id=$_POST['region_id'];



if($_POST['depot_id']!='') 		$depot_id=$_POST['depot_id'];



if($_POST['dealer_type']!='') 		$dealer_type=$_POST['dealer_type'];

if($_POST['warehouse_id']!='') 		$warehouse_id=$_POST['warehouse_id'];

if($_POST['item_id']!='') 		$item_con=$_POST['item_id'];







if($_POST['receive_type']!='') 		$receive_type=$_POST['receive_type'];







if(isset($receive_type)) 			{$receive_type_con=' and o.receive_type="'.$receive_type.'"';} 











if(isset($item_brand)) 			{$item_brand_con=' and i.brand_category="'.$item_brand.'"';} 



if(isset($dealer_code)) 		{$dealer_con=' and m.vendor_id="'.$dealer_code.'"';} 



if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 



if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 











if(isset($dealer_code)) 		{$dealer_con=' and m.vendor_id='.$dealer_code;} 



//if(isset($item_id))				{$item_con=' and o.item_id='.$item_id;} 



if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 







switch ($_POST['report']) {







	    case 1000:



		$report="Damage Report Item Wise";





	break;



	



	case 2:



$report="Damage Report Date Wise";







	break;
	
	case 261124:



		$report="Production vs Consumption Report";

		break;
		
		
			case 217:



		$report="Production Report(FG) ";

		break;
		
		
					case 218:



		$report="Consumption Report";

		break;
		
		
						case 219:



		$report="Production Wise Overhead report";

		break;
		
		
						case 27824:



		$report="BOM Report";

		break;


case 12823:



		$report="Warehouse Item Transection Report";



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 

		

		if(isset($enty_con)) 				{$con=' and a.entry_by='.$enty_con;} 



		if(isset($item_con)) 				{$item_con=' and i.item_id='.$item_con;} 



		



		if(isset($receive_status)){	



			if($receive_status=='All_Purchase')



			{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}



			else



			{$status_con=' and a.tr_from="'.$receive_status.'"';}



		}



		



		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		



  $sql='select ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.pack_size,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount, (a.item_in-a.item_ex) as current_stock,a.tr_from as tr_type,sr_no,



(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



		   



from journal_item a, item_info i, user_activity_management c , item_sub_group s 



where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id 



 '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$con.' 



order by a.id, a.ji_date';



	break;





		case 3:



		$report="Damage Report Summary";







		break;



}



}

$tr_type="Show";

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



    <style type="text/css" media="print">



      div.page



      {



        page-break-after: always;



        page-break-inside: avoid;



      }



    </style>



</head>



<body>



<div align="center" id="pr">



<input type="button" value="Print" onclick="hide();window.print();"/>



</div>



<div class="main" style="text-align:center; ">



<?



		$str 	.= '<div class="header" >';



		if(isset($_SESSION['company_name'])) 



		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';



		if(isset($report)) 



		$str 	.= '<h2>'.$report.'</h2>';



		if(isset($to_date)) 



		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';



		if(isset($product_group)) 



		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';



		



		if(isset($item_brand)) 



		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';



		



		if(isset($item_id)) 



		$str 	.= '<h2>Item Name : '.find_a_field('item_info','item_name','item_id='.$item_id).'</h2>';



		



		if(isset($receive_type)) 



		$str 	.= '<h2>Damage Type : '.find_a_field('damage_cause','damage_cause','id='.$receive_type).'</h2>';



		



		if(isset($dealer_type)) 



		$str 	.= '<h2>Dealer Type : '.$dealer_type.'</h2>';



		if(isset($dealer_code)) 



		$str 	.= '<h2>Dealer Name : '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';

		



		$str 	.= '</div>';



		$str 	.= '<div class="left" style="width:100%">';













//Damage Report Summary modify on 13 Nov 2019 by Payer Rony



if($_POST['report']==3){



	

//

//if(isset($receive_type)) 	{$receive_type_con=' and m.receive_type="'.$receive_type.'"';} 

//

//if(isset($dealer_code)) 		{$dealer_con=' and m.vendor_id='.$dealer_code;}

//

//if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

//

//if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

//

//if(isset($item_id)) 		{$item_con=' and o.item_id="'.$item_id.'"';} 

//

//if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';}





if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$receive_type.'"';} 



if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$dealer_code;}



if($_REQUEST['$t_date'] != '') 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if($_REQUEST['$product_group']!= '') 		{$pg_con=' and d.product_group="'.$product_group.'"';} 



if($_REQUEST['$item_id']!='') 		{$item_con=' and o.item_id="'.$item_id.'"';} 



if($_REQUEST['$dealer_type']!='') 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';}



//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')



  $sql="select m.vendor_id, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,sum(c.qty) as total_qty,sum(c.amount) as amount

 





from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m







where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id ".$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by c.vendor_id";







$query = db_query($sql);



	







echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">



	

<thead>



	

<tr>







<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>



	

</tr>





<tr>





<th>S/L</th>





<th style=" text-align:center;" >Dealer Name</th>



<th style=" text-align:center;">Toral Quantity</th>

	

<th style=" text-align:center;">Total Amount</th>





</tr>



	







</thead>



	







<tbody>';



	







while($data=mysqli_fetch_object($query)){$s++;







?>



	







<tr>



	







<td><?=$s?></td>

<?php /*?>&item_id=<?=$data->item_id;?>&dealer_type=<?=$_REQUEST['dealer_type']?>&brand_category=<?=$_REQUEST['item_brand']?><?php */?>

<td>

<a href="master_report.php?report=1000&dealer_code=<?=$data->vendor_id;?>&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>" target="_blank"><?=($data->party_name)?></a>

</td>



	

<td style="text-align:center"><?=$data->total_qty?></td>



<td style="text-align:center"><?=$data->amount?></td>





</tr>



	







<?



	







$tot_qty = $tot_qty+$data->total_qty;



	

$tot_amt = $tot_amt+$data->amount;









	







}



	







echo '<tr class="footer">



	





<td style="text-align:right">&nbsp;</td>



	

<td style="text-align:right">&nbsp;</td>







<td style="text-align:center">'.number_format($tot_qty,2).'</td>



	

<td style="text-align:center">'.number_format($tot_amt,2).'</td>



	







</tr>



	







</tbody>



	







</table>';







}







else if($_REQUEST['report']==2)



{





if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 



if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}



if($_REQUEST['t_date'] != '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 



if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 



if($_REQUEST['dealer_type']!='') 		{$dtype_con=' and d.dealer_type="'.$_REQUEST['dealer_type'].'"';}



//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')



 $sql = "select distinct concat(i.finish_goods_code,'- ',item_name) as item_name,m.vendor_id,m.or_no,m.or_date,i.brand_category,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,



o.qty as total_qty, 





o.amount as amount



from 



sales_damage_receive_master m,sales_damage_receive_detail o, item_info i,dealer_info d, warehouse w



where m.or_no=o.or_no and m.vendor_id=d.dealer_code and i.item_id=o.item_id and m.status='UNCHECKED' and o.warehouse_id=w.warehouse_id   ".$date_con.$item_con.$item_brand_con.$depot_con.$receive_type_con.$dealer_con.' order by i.finish_goods_code,m.or_no,m.or_date';







$query = db_query($sql);



	







echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">



	

<thead>



	

<tr>







<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>



	

</tr>





<tr>





<th>S/L</th>



<th style=" text-align:center;">Item Name</th>

<th style=" text-align:center;">Item Brand</th>

<th style=" text-align:center;" >DR NO</th>

<th style=" text-align:center;" >DR DATE</th>

<th style=" text-align:center;">Dealer Name</th>



<th style=" text-align:center;">Toral Quantity</th>

	

<th style=" text-align:center;">Total Amount</th>





</tr>



	







</thead>



	







<tbody>';



	







while($data=mysqli_fetch_object($query)){$s++;







?>



	







<tr>





<td><?=$s?></td>



<td><?=($data->item_name)?></a></td>



<td style="text-align:center"><?=($data->brand_category)?></td>



<td style="text-align:center"><?=($data->or_no)?></td>



<td style="text-align:center"><?=($data->or_date)?></td>



<td><?=($data->party_name)?></td>



	

<td style="text-align:center"><?=$data->total_qty?></td>



<td style="text-align:center"><?=$data->amount?></td>





</tr>



	







<?



$tot_qty = $tot_qty+$data->total_qty;



	

$tot_amt = $tot_amt+$data->amount;



}



	







echo '<tr class="footer">



	





<td style="text-align:right">&nbsp;</td>



	

<td style="text-align:right">&nbsp;</td>



<td style="text-align:right">&nbsp;</td>



	

<td style="text-align:right">&nbsp;</td>



<td style="text-align:right">&nbsp;</td>



	

<td style="text-align:right">&nbsp;</td>







<td style="text-align:center">'.number_format($tot_qty,2).'</td>



	

<td style="text-align:center">'.number_format($tot_amt,2).'</td>



	







</tr>



	







</tbody>



	







</table>';
?>
<?php
}
else if($_REQUEST['report']==219){
if($_POST['item_id']>0){ $item_con=' and i.item_id="'.$_POST['item_id'].'"';}
if($_POST['item_sub_group']>0){ $item_sub_con=' and i.sub_group_id="'.$_POST['item_sub_group'].'"';}
if($_POST['section_id']>0){ $sec_con=' and m..section_id="'.$_POST['section_id'].'"';}
if($_POST['warehouse_id']>0){ $pl_con='  and m.warehouse_id="'.$_POST['warehouse_id'].'"';}
?>
<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
	<thead>
	
	<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
	
		<tr>
			<th>SL</th>
			<th>Batch No</th>
			<th>PR No</th>
			<th>Production Date</th>
			<th>Section</th>
			<th>Production Line</th>
			<th>FG Name</th>
			<th>Unit</th>
			<th>Quantity</th>
			<th>Total Overhead Cost</th>
		 
		</tr>
	</thead>
	<tbody>
	<?php 
 $wsql='select * from warehouse where 1 group by warehouse_id';
 $wquery=db_query($wsql);
 while($wrow=mysqli_fetch_object($wquery)){
 	$ware_name[$wrow->warehouse_id]=$wrow->warehouse_name;
 }
	 $wsql='select * from item_info where 1 group by item_id';
 $wquery=db_query($wsql);
 while($wrow=mysqli_fetch_object($wquery)){
 	$item_name_get[$wrow->item_id]=$wrow->item_name;
	$item_unit_get[$wrow->item_id]=$wrow->unit_name;
 }
 
 	 $wsql='select * from production_receive_master where 1 group by pr_no';
 $wquery=db_query($wsql);
 while($wrow=mysqli_fetch_object($wquery)){
 	$section_data[$wrow->pr_no]=$wrow->section_id;
 }
  	  $wsql='select sum(cr_amt) as tot_fo_cost,tr_no from journal j,accounts_ledger a where j.ledger_id=a.ledger_id and a.ledger_group_id=411010  group by tr_no';
 $wquery=db_query($wsql);
 while($wrow=mysqli_fetch_object($wquery)){
 	$over_data[$wrow->tr_no]=$wrow->tot_fo_cost;
 }
    $sql='select m.*,i.item_name,i.unit_name,i.sub_group_id,i.item_id,m.section_id from item_info i,production_receive_master m where  m.fg_item_id=i.item_id and m.pr_date between "'.$fr_date.'" and "'.$to_date.'" '.$item_con.$item_sub_con.$sec_con.$pl_con.' and m.status="RECEIVED"';
		 // $sql='select * from  production_receive_master where pr_date between "'.$fr_date.'" and "'.$to_date.'" and status="RECEIVED"';
		$query=db_query($sql);
		while($row=mysqli_fetch_object($query)){
	?>
		<tr>
			<td><?php echo ++$i;?></td>
			<td><?php echo $row->batch_no;?></td>
			<td><?php echo $row->pr_no;?></td>
			<td><?php echo $row->pr_date;?></td>
			<td><?php echo $ware_name[$row->section_id];?></td>
			<td><?php echo $ware_name[$row->warehouse_id];?> </td>
			<td><?php echo $item_name_get[$row->fg_item_id];?> </td>
			<td><?php echo $item_unit_get[$row->fg_item_id];?></td>
			<td><?php echo $row->pr_qty;?></td>
	 
			<td><?php echo $over_data[$row->pr_no];?></td>
		</tr>
		<?php 
		$tot_factory_overhead+=$over_data[$row->pr_no];
		} ?>
		<tr>
			<td colspan="9" style="text-align:right;">Total</td>
			<td><?php echo $tot_factory_overhead;?></td>
		</tr>
	</tbody>
</table>
<?php


}



elseif($_POST['report']==261124)
{
$sql='';

?>


<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<thead>
		<tr><td colspan="17" style="border:0px;">
		<?
		echo '<div class="header">';
echo '<h1 style="text-align: center; font-weight: bold; text-shadow: 1px 1px 1px gray; height: 10px; font-size: 18px;">'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';
		if(isset($report)) 
		echo '<h2>'.$report.'</h2>';
if($_REQUEST['group_id']!=''){echo '<h1 style="text-align: center; font-size: 15px; height: 10px; font-weight: bold;"> Group :'.find_a_field('item_group','group_name','1 and group_id='.$_REQUEST['group_id'],$group_name).'</h1>';};

		if($_REQUEST['warehouse_id']!=''){echo '<h1 style="text-align: center; font-size: 15px;  font-weight: bold;">Section : '.find_a_field('warehouse','warehouse_name','1 and warehouse_id='.$_REQUEST['warehouse_id'],$warehouse_name).'</h1>';};
if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';
		echo '<div class="date" style=" text-align:right; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

if($_POST['t_date']!='' || $_POST['f_date']!=''){ $pdate_con .=  'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';}



if($_POST['item_id']!='') 				{$item_con=' and b.item_id='.$_POST['item_id'].' ';}



if($_POST['group_id']!='') 				{$g_con=' and g.group_id='.$_POST['group_id'];}



if($_POST['warehouse_id']!='') 				{$w_con=' and a.warehouse_id='.$_POST['warehouse_id'];}

//if($_GET['status']!='') 				{$status_con=' and a.status='.$_GET['status'];}

		?>
		</td></tr>
		</thead>
<tbody>
	<tr>
	<td valign="top">
	<table  border="0" cellpadding="2" cellspacing="0">
	<thead>

<tr style="background: #B8B8B8; text-align:center; font-size: 16px; border: 1px solid black;" ><td colspan="9"><strong>Production Receive</strong></td></tr>
	<tr valign="top">

<th width="">SL/NO</th>
		<th width="">PR No </th>
		<th width="">PR Date</th>
		<th width="">Warehouse Name</th>
<th width=""><div align="center">FG Code</div></th>
 <th width=""><div align="center">Item Group</div></th>
      <th width=""><div align="center">Item Name</div></th>
	  <th width=""><div align="center">Production qty</div></th>
      <th width=""><div align="center">Remarks</div></th>
	  </tr>
	  </thead>
	  <tbody>
	  <?

    $res = 'select a.id,a.sr_no,a.ji_date,i.finish_goods_code as fg_code,i.item_name,w.warehouse_name,g.group_name,a.item_in qty
  from   journal_item a, item_info i, item_sub_group s, item_group g, warehouse w,production_receive_detail b 
  where a.tr_from in ("Production Receive") and w.warehouse_id=a.warehouse_id and a.sr_no=b.pr_no and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and a.item_id=i.item_id and a.item_id=b.item_id '.$item_con.$pdate_con.$con.$g_con.$w_con.' group by a.id,a.sr_no order by a.sr_no';

$sl=0;
$query=db_query($res);
while($data=mysqli_fetch_object($query)){ ?>
	  <tr>
	<td valign="top"><div align="center"><?=++$sl?></div></td>
      	<td valign="top"><?=$data->sr_no;?></td>
      	<td valign="top"><?=$data->ji_date;?></td>
		<td valign="top"><?=$data->warehouse_name;?></td>
		<td valign="top"><?=$data->fg_code;?></td>
		<td valign="top">&nbsp;<?=$data->group_name;?></td>
	  	<td valign="top"><?=$data->item_name;?></td>
	  	<td valign="top"><?=$data->qty;?></td>
		<td valign="top"><div align="center">  <?=$data->remarks;?> </div></td>
  	</tr>

	<? 
	$tot = $tot+$data->qty;
	} 
	?>

	  <tr>
<td colspan="7">Total : </td>
<td>&emsp;<b><? if($tot!=''){ echo $tot;}else{ echo $tot=0; };?></b></td>
<td>&emsp;</td>

</tr>
	  </tbody>
	  </table>
	  </td>

	  <td valign="top">
	  <table  border="0" cellpadding="2" cellspacing="0" >
	  <thead>
	  <tr style="background: #B8B8B8; text-align:center; font-size: 16px; border: 1px solid black;" ><td colspan="8"><strong>Production Consumption</strong></td></tr>
	  <tr>
        <th width="">SL/NO</th>
		<th width="">Production No</th>
	    <th width="">Consumption Date </th>
		<th width="">Warehouse Name</th>
		<th width=""><div align="center">FG Code</div></th>
		<th width=""><div align="center">Item Group</div></th>
      	<th width=""><div align="center">Item Name</div></th>
	  	<th width=""><div align="center">Consumption</div></th>
	  </tr>
	  </thead>
	  <tbody>

	  <?

if($_POST['t_date']!='' || $_POST['f_date']!=''){ $rcvdate_con .=  'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';}

if($_POST['item_id']!='') 				{$item_con=' and b.item_id='.$_POST['item_id'].' ';}

if($_POST['group_id']!='') 				{$g_con=' and g.group_id='.$_POST['group_id'];}

if($_POST['warehouse_id']!='') 				{$w_con=' and a.warehouse_id='.$_POST['warehouse_id'];}

	   $res = 'select a.id,a.sr_no,a.ji_date,i.item_name,g.group_name,a.item_ex qty,b.item_id,b.id,i.finish_goods_code as fg_code,w.warehouse_name  
	   from   journal_item a, production_rm_consumption b, item_info i, item_sub_group s, item_group g , warehouse w 
	   where a.sr_no=b.pr_no  and a.tr_from="Consumption" and w.warehouse_id=a.warehouse_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and a.item_id=i.item_id and i.item_id=b.item_id '.$item_con.$rcvdate_con.$g_con.$w_con.' group by a.id,a.sr_no ';

$sl=0;

$query=db_query($res);
while($data=mysqli_fetch_object($query)){ ?>

	  <tr valign="top">
	<td valign="top" width=""><div align="center"><?=++$sl?></div></td>
      	<td valign="top" width=""><?=$data->sr_no;?></td>
			<td valign="top" width=""><?=$data->ji_date;?></td>
			<td valign="top" width=""><?=$data->warehouse_name;?></td>
			<td valign="top" width=""><?=$data->fg_code;?></td>
			<td valign="top" width=""><?=$data->group_name;?></td>
	  	<td valign="top" width=""><?=$data->item_name;?></td>
		<td valign="top" width=""><div align="center"> <?=$data->qty;?> </div></td>
  	</tr>
	  <? 
	  $tott = $tott+$data->qty;
	  } ?>
	  <tr>
<td colspan="7">Total : </td>
<td style="text-align:right; font-weight:bold;"><div align="center"> <? if($tott!=''){ echo $tott;}else{ echo $tott=0; };?></div></td>
</tr>
	  </tbody>
	  </table>
	  </td>
	</tr>
</tbody>
</table>
  <div align="center">
    <table>
      <tr style="background: #B8B8B8;">
        <td colspan="6"><div align="center"><strong>Grand Total</strong></div></td>
      </tr>
      <tr align="right">
        <td colspan="3"><div align="center"><strong>Production Receive :</strong> <b> <?=$tot?> </b></div></td>
		  
		  <td colspan="3"><div align="center"><strong>Production Consumption  :</strong> <b><?=$tott?> </b></div></td>
      </tr>
    </table>
    <?

}



else if($_REQUEST['report']==218){
if($_POST['item_id']>0){ $item_con=' and i.item_id="'.$_POST['item_id'].'"';}
if($_POST['item_sub_group']>0){ $item_sub_con=' and i.sub_group_id="'.$_POST['item_sub_group'].'"';}
if($_POST['section_id']>0){ $sec_con=' and m..section_id="'.$_POST['section_id'].'"';}
if($_POST['warehouse_id']>0){ $pl_con=' and p.warehouse_id="'.$_POST['warehouse_id'].'"';}
?>
<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
	<thead>
	<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
	
		<tr>
			<th>SL</th>
			<th>Batch No</th>
			<th>PR No</th>
			<th>Consumption Date</th>
			<th>Section</th>
			<th>Production Line</th>
			<th>Item Name</th>
			<th>Unit</th>
			<th>Quantity</th>
			<th>Per Unit Rate</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	<?php 
 $wsql='select * from warehouse where 1 group by warehouse_id';
 $wquery=db_query($wsql);
 while($wrow=mysqli_fetch_object($wquery)){
 	$ware_name[$wrow->warehouse_id]=$wrow->warehouse_name;
 }
 
 
 
 
		   $sql='select p.*,i.item_name,i.unit_name,i.sub_group_id,i.item_id,m.section_id from  production_rm_consumption p,item_info i,production_receive_master m where p.pr_no=m.pr_no and p.item_id=i.item_id and p.pr_date between "'.$fr_date.'" and "'.$to_date.'" '.$item_con.$item_sub_con.$sec_con.$pl_con.' and p.status="RECEIVED"';
		$query=db_query($sql);
		while($row=mysqli_fetch_object($query)){
	?>
		<tr>
			<td><?php echo ++$i;?></td>
			<td><?php echo $row->batch_no;?></td>
			<td><?php echo $row->pr_no;?></td>
			<td><?php echo $row->pr_date;?></td>
			<td><?php echo $ware_name[$row->section_id];?></td>
			<td><?php echo $ware_name[$row->warehouse_id];?> </td>
			<td><?php echo  $row->item_name;?> </td>
			<td><?php echo  $row->unit_name;?></td>
			<td><?php echo $row->total_unit;?></td>
			<td><?php echo $row->unit_price;?></td>
			<td><?php echo $row->total_amt;?></td>
		</tr>
		<?php 
		$tot_consumpt+=$row->total_amt;
		} ?>
		<tr>
			<td colspan="10" style="text-align:right;">Total</td>
			<td><?php echo $tot_consumpt;?></td>
		</tr>
	</tbody>
</table>
<?php


}
else if($_REQUEST['report']==217){
?>
<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
	<thead>
	
	<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>

		<tr>
			<th>SL</th>
			<th>Batch No</th>
			<th>Production Date</th>
			<th>Section</th>
			<th>Production Line</th>
			<th>FG Name</th>
			<th>Unit</th>
			<th>Quantity</th>
			<th>Per Unit Rate</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	if($_POST['item_id']>0){ $item_con='  and i.item_id="'.$_POST['item_id'].'"';}
if($_POST['item_sub_group']>0){ $item_sub_con=' and i.sub_group_id="'.$_POST['item_sub_group'].'"';}
if($_POST['section_id']>0){ $sec_con=' and m..section_id="'.$_POST['section_id'].'"';}
if($_POST['warehouse_id']>0){ $pl_con=' and m.warehouse_id="'.$_POST['warehouse_id'].'"';}
	
 $wsql='select * from warehouse where 1 group by warehouse_id';
 $wquery=db_query($wsql);
 while($wrow=mysqli_fetch_object($wquery)){
 	$ware_name[$wrow->warehouse_id]=$wrow->warehouse_name;
 }
	 $wsql='select * from item_info where 1 group by item_id';
 $wquery=db_query($wsql);
 while($wrow=mysqli_fetch_object($wquery)){
 	$item_name_get[$wrow->item_id]=$wrow->item_name;
 }
 
 
		    $sql='select m.*,i.item_name,i.unit_name,i.sub_group_id,i.item_id,m.section_id from item_info i,production_receive_master m where  m.fg_item_id=i.item_id and m.pr_date between "'.$fr_date.'" and "'.$to_date.'" '.$item_con.$item_sub_con.$sec_con.$pl_con.' and m.status="RECEIVED"';
 
		  ///$sql='select * from production_receive_master where pr_date between "'.$fr_date.'" and "'.$to_date.'" and status="RECEIVED"';
		$query=db_query($sql);
		while($row=mysqli_fetch_object($query)){
	?>
		<tr>
			<td><?php echo ++$i;?></td>
			<td><?php echo $row->batch_no;?></td>
			<td><?php echo $row->pr_date;?></td>
			<td><?php echo $ware_name[$row->section_id];?></td>
			<td><?php echo $ware_name[$row->warehouse_id];?> </td>
			<td><?php echo $item_name_get[$row->fg_item_id];?> </td>
			<td><?php echo $row->unit_name;?></td>
			<td><?php echo $row->pr_qty;?></td>
			<td><?php echo $row->cost_price;?></td>
			<td><?php echo $row->cost_amt;?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php


}

else if($_REQUEST['report']==27824){
?>
<style>
    
    table th {
    position:sticky;
    top:0;
    z-index:1;
    border-top:1;
    background: #ededed;
	text-align:center;
	

body{
	margin:0px !important;
}


/* Apply styles for printing */
@media print {
@page {
/*  size: A4;  */            /* Set page size to A4 */
  margin: 5mm;          /* Define margins (top, right, bottom, left) */
}
}	
}
</style>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
	<thead>
	<tr>
<td style="border:0px;" colspan="24">
<div class="header">
<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"');?></h1>
<h2><?=$report?></h2>
<h2><?=$warehouse_name?></h2>
<h2><?='<h2>For the Period of:- '.$f_date.' To '.$t_date.'</h2>';?></h2>

</div>
<div class="left"></div>
<div class="right"></div>
<div class="date" style="text-align:right">Reporting Time: <?=date("h:i A d-m-Y")?></div>
</td>
</tr>
<tr>
<th rowspan="2" style="text-align: center; width: 6% !important;">SL</th>
<th colspan="2" style="text-align: center; width: 20% !important;" >BOM Information</th>
<th colspan="3" style="text-align: center; width: 50% !important;">Consumption</th>
<th colspan="3" style="text-align: center; width: 24% !important;" >Finished Goods</th>
</tr>

<tr>
<th style="text-align: center; width: 10% !important;">BOM NO</th>
<th style="text-align: center; width: 10% !important;">Product Name</th>


<th style="text-align: center; width: 15% !important;">Item ID</th>
<th style="width: 20% !important;">Raw Material Name</th>
<th style="text-align: center; width: 15% !important;">Raw Material Qty</th>

<th style="text-align: center; width: 8% !important;">FG ID</th>
<th style="width: 8% !important;">FG Name</th>
<th style="text-align: center; width: 8% !important;">Qty</th>

</tr>

</thead>
	<tbody>
	<?php 
	if($_POST['item_id']>0){ $item_con='  and i.item_id="'.$_POST['item_id'].'"';}
if($_POST['item_sub_group']>0){ $item_sub_con=' and i.sub_group_id="'.$_POST['item_sub_group'].'"';}
if($_POST['section_id']>0){ $sec_con=' and m..section_id="'.$_POST['section_id'].'"';}
if($_POST['warehouse_id']>0){ $pl_con=' and m.warehouse_id="'.$_POST['warehouse_id'].'"';}
	
 $wsql="select m.bom_no,m.fg_item_id,m.quantity,m.unit_name
 from bom_master m
 where 1";
 $wquery=db_query($wsql);

		while($row=mysqli_fetch_object($wquery)){
		
		$sql2="select r.bom_no,r.fg_item_id,r.item_id,r.total_unit,r.unit_name
 from bom_raw_material r
 where r.bom_no='".$row->bom_no."'";
 $query=db_query($sql2);

	?>
	
		<tr>
		
		    <td><?php echo ++$i;?></td>
			
			<td><?php echo $row->bom_no;?></td>
			<td><?php echo find_a_field('item_info','item_name','item_id='.$row->fg_item_id);?></td>
			
                    <td colspan="3" style="margin:0px; padding:0px;">
					<style>
						.border tr{ border-left:0px !important; border-right:0px !important;}
						.border tr .td1{ border-left:0px !important; }
						.border tr .td3{ border-right:0px !important;}
					</style>
					<table class="border" width="100%" border="0" bordercolor="#FFFFFF">
					<?php while($row2 = mysqli_fetch_object($query)){ ?>
						<tr>
							<td class="td1" style="width: 15% !important;"><?php echo $row2->item_id; ?></td>
							<td class="td2" style="width: 20% !important; text-align:left;">
							<?php $text_item_name =find_a_field('item_info', 'item_name', 'item_id=' . $row2->item_id);
							
							// Replace semicolons and commas with spaces
							$text_with_item_name = str_replace(',', ', ', $text_item_name);
							$text_with_item_name = str_replace(';', '; ', $text_with_item_name);
							$text_with_item_name = str_replace('+', ' + ', $text_with_item_name);
							$text_with_item_name = str_replace('-', ' - ', $text_with_item_name);
							$text_with_item_name = str_replace('&', '& ', $text_with_item_name);
							$text_with_item_name = str_replace('/', '/ ', $text_with_item_name);
							$text_with_item_name = str_replace('%', '% ', $text_with_item_name);
							$text_with_item_name = str_replace('(', ' (', $text_with_item_name);
							$text_with_item_name = str_replace(')', ') ', $text_with_item_name);
							$text_with_item_name = str_replace('X', ' X ', $text_with_item_name);
							
							// Output the result
							echo $text_with_item_name;

							
							 ?>
							
							</td>
							<td class="td3" style="width: 15% !important;"><?php echo number_format($row2->total_unit, 2); ?> &nbsp;<?php echo $row2->unit_name; ?></td>
						</tr>
					<?php } ?>
					</table>
				</td>
			
			<td><?php echo find_a_field('item_info','finish_goods_code','item_id='.$row->fg_item_id);?></td>
			<td align="left"><?php echo find_a_field('item_info','item_name','item_id='.$row->fg_item_id);?></td>
			<td><?php echo number_format($row->quantity,2);?> &nbsp;<? echo $row->unit_name;?></td>
		</tr>
		<?php }?>
	</tbody>
</table>
<?php


}





else if($_REQUEST['report']==1000){





if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 



if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}



if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 



if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 



if($_REQUEST['dealer_type']!='') 		{$dtype_con=' and d.dealer_type="'.$_REQUEST['dealer_type'].'"';}



//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')



 $sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,m.vendor_id,i.brand_category,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,



sum(o.qty) as total_qty, 



sum(o.qty*i.d_price) as Cost_Price,



sum(o.amount)as amount



from 



sales_damage_receive_master m,sales_damage_receive_detail o, item_info i,dealer_info d, warehouse w



where m.or_no=o.or_no and m.vendor_id=d.dealer_code and i.item_id=o.item_id and m.status='UNCHECKED' and o.warehouse_id=w.warehouse_id   ".$date_con.$item_con.$item_brand_con.$depot_con.$receive_type_con.$dealer_con.$dtype_con.' group by i.finish_goods_code';







$query = db_query($sql);



	







echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">



	

<thead>



	

<tr>







<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>



	

</tr>





<tr>





<th>S/L</th>



<th style=" text-align:center;">Item Name</th>

<th style=" text-align:center;">Item Brand</th>



<th style=" text-align:center;">Dealer Name</th>



<th style=" text-align:center;">Toral Quantity</th>

	

<th style=" text-align:center;">Total Amount</th>





</tr>



	







</thead>



	







<tbody>';



	







while($data=mysqli_fetch_object($query)){$s++;







?>



	







<tr>



<td><?=$s?></td>



<td><a href="master_report.php?report=2&dealer_code=<?=$data->vendor_id;?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>&item_id=<?=$_REQUEST['item_id']?>&dealer_type=<?=$_REQUEST['dealer_type']?>&brand_category=<?=$_REQUEST['item_brand']?>" target="_blank"><?=($data->item_name)?></a></td>



<td><?=($data->brand_category)?></td>



<td><?=($data->party_name)?></td>



	

<td style="text-align:center"><?=$data->total_qty?></td>



<td style="text-align:center"><?=$data->amount?></td>





</tr>



	







<?



	







$tot_qty = $tot_qty+$data->total_qty;



	

$tot_amt = $tot_amt+$data->amount;









	







}



	







echo '<tr class="footer">



	





<td style="text-align:right">&nbsp;</td>



	

<td style="text-align:right">&nbsp;</td>



<td style="text-align:right">&nbsp;</td>



	

<td style="text-align:right">&nbsp;</td>







<td style="text-align:center">'.number_format($tot_qty,2).'</td>



	

<td style="text-align:center">'.number_format($tot_amt,2).'</td>



	







</tr>



	







</tbody>



	







</table>';











}









else if($_POST['report']==211111) 



{















$sql2 	= "select distinct o.or_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,m.or_date,d.address_e,d.mobile_no,d.product_group from 



sales_damage_receive_master m,sales_damage_receive_detail o, item_info i,dealer_info d , warehouse w



where m.or_no=o.or_no and i.item_id=o.item_id and m.vendor_id=d.dealer_code  and w.warehouse_id=d.depot ".$receive_type_con.$date_con.$item_con.$depot_con.$dealer_con;



$query2 = db_query($sql2);







while($data=mysqli_fetch_object($query2)){



echo '<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid">';



	$dealer_code = $data->dealer_code;



	$dealer_name = $data->dealer_name_e;



	$warehouse_name = $data->warehouse_name;



	$or_date = $data->or_date;



	$or_no = $data->or_no;



		if($dealer_code>0) 



{



$str 	.= '<p style="width:100%;text-align:center;">Dealer Name: '.$dealer_name.' - '.$dealer_code.'('.$data->product_group.')</p>';



$str 	.= '<p style="width:100%,text-align:center;">DI NO: '.$or_no.' 



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depot:'.$warehouse_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:'.$or_date.'</p>



<p style="width:100%,text-align:center;">Destination:'.$data->address_e.'('.$data->mobile_no.')</p>';







$dealer_con = ' and m.vendor_id='.$dealer_code;



$do_con = ' and m.or_no='.$or_no;



$item_con = ' and o.item_con='.$item_con;







$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,dd.damage_cause,o.qty as pcs,(i.d_price*o.qty) as Cost_price,o.amount as Dealer_Price from 



sales_damage_receive_master m,sales_damage_receive_detail o, item_info i,dealer_info d , warehouse w, damage_cause dd



where o.receive_type=dd.id and m.or_no=o.or_no and i.item_id=o.item_id and m.vendor_id=d.dealer_code  ".$receive_type_con.$date_con.$item_con.$depot_con.$do_con." order by m.or_date,o.item_id asc";



}







echo report_create($sql,1,$str);



		$str = '';



		echo '</div>';



}



}



elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);



?></div>



</body>



</html>

<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>