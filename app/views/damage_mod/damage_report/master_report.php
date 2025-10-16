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

	

if($_POST['product_group']!='') $product_group=$_POST['product_group'];

if($_POST['item_brand']!='') 	$item_brand=$_POST['item_brand'];

if($_POST['item_id']>0) 		$item_id=$_POST['item_id'];

if($_POST['dealer_code']>0) 	$dealer_code=$_POST['dealer_code'];



if($_POST['status']!='') 		$status=$_POST['status'];

if($_POST['or_no']!='') 		$or_no=$_POST['or_no'];

if($_REQUEST['super_zone']>0) 		$super_zone=$_REQUEST['super_zone'];

if($_REQUEST['area']>0) 		$area_id=$_REQUEST['area'];

if($_REQUEST['territory']>0) 		$territory_id=$_REQUEST['territory'];

if($_REQUEST['region']>0) 		$region_id=$_REQUEST['region'];

if($_REQUEST['depot_id']!='') 		$depot_id=$_REQUEST['depot_id'];

if($_POST['depot_id']!='') 		$depot_id=$_POST['depot_id'];

if($_POST['dealer_type']!='') 		$dealer_type=$_POST['dealer_type'];



if($_POST['receive_type']!='') 		$receive_type=$_POST['receive_type'];



if(isset($receive_type)) 			{$receive_type_con=' and o.receive_type="'.$receive_type.'"';} 





if(isset($item_brand)) 			{$item_brand_con=' and i.brand_category="'.$item_brand.'"';} 

if(isset($dealer_code)) 		{$dealer_con=' and m.vendor_id="'.$dealer_code.'"';} 

if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 

if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 





if(isset($dealer_code)) 		{$dealer_con=' and m.vendor_id='.$dealer_code;} 

if(isset($item_id))				{$item_con=' and o.item_id='.$item_id;} 

if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 



switch ($_POST['report']) {



	    case 1000:

		$report="Damage Report Item Wise";


	break;

	

	case 2:

$report="Damage Report Date Wise";



	break;



		case 3:

		$report="Damage Report Summary";



		break;

}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title><?=$report?></title>

<link href="../../css/report.css" type="text/css" rel="stylesheet" />

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

if($_REQUEST['report']==3){

	
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



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 


if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$receive_type.'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$dealer_code;}

if($_REQUEST['t_date'] != '' &&  $_REQUEST['f_date'] != '' ) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.or_date between \''.$_REQUEST['f_date'].'\' and \''.$_REQUEST['t_date'].'\'';}

if($_REQUEST['$product_group']!= '') 		{$pg_con=' and d.product_group="'.$product_group.'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and i.item_id="'.$item_id.'"';} 
if($item_brand) 		{$item_brand_con=' and i.brand_category="'.$item_brand.'"';} 
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 
if($_REQUEST['item_id']!='') 		{$item_con=' and c.item_id="'.$_REQUEST['item_id'].'"';} 


//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

  $sql="select m.vendor_id, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,sum(c.qty) as total_qty,sum(c.amount) as amount,ss.super_zone_name,r.BRANCH_NAME as region,z.ZONE_NAME as area,a.AREA_NAME as territory
 


from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss



where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by c.vendor_id";



$query = db_query($sql);

	



echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>


<tr>


<th style=" text-align:center;">S/L</th>


<th>Dealer Name</th>

<th>Super Zone</th>
<th>Region</th>
<th>Area</th>
<th>Territory</th>

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
<td style="text-align:left">
<a href="master_report.php?report=10007777&item_id=<?=$_REQUEST['item_id']?>&dealer_code=<?=$data->vendor_id;?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>" target="_blank"><?=($data->party_name)?></a>
</td>


<td><?=$data->super_zone_name?></td>
<td><?=$data->region?></td>
<td><?=$data->area?></td>
<td><?=$data->territory?></td>


	
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



}



else if($_REQUEST['report']==2)

{


if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date'] != '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and i.item_id="'.$_REQUEST['item_id'].'"';} 
	

if($_REQUEST['dealer_type']!='') 		{$dtype_con=' and d.dealer_type="'.$_REQUEST['dealer_type'].'"';}

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

 $sql = "select distinct concat(i.finish_goods_code,'- ',item_name) as item_name,o.item_id,m.vendor_id,m.or_no,m.or_date,i.brand_category,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,

sum(o.qty) as total_qty, 


sum(o.amount) as amount

from 

sales_damage_receive_master m,sales_damage_receive_detail o, item_info i,dealer_info d, warehouse w

where m.or_no=o.or_no and m.vendor_id=d.dealer_code and i.item_id=o.item_id and m.status='UNCHECKED' and o.warehouse_id=w.warehouse_id   ".$date_con.$item_con.$item_brand_con.$depot_con.$receive_type_con.$dealer_con.' group by o.item_id order by i.finish_goods_code,m.or_no,m.or_date';



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


<th style=" text-align:center;">Toral Quantity</th>
	
<th style=" text-align:center;">Total Amount</th>


</tr>

	



</thead>

	



<tbody>';

	



while($data=mysqli_fetch_object($query)){$s++;



?>

	



<tr>


<td><?=$s?></td>

<td style="text-align:left" >
<a href="master_report.php?report=2000&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>&item_id=<?=$data->item_id?>&dealer_code=<?=$data->vendor_id?>&brand_category=<?=$_REQUEST['item_brand']?>" target="_blank"><?=($data->item_name)?></a>
</td>

<td style="text-align:center"><?=($data->brand_category)?></td>


	
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



<td style="text-align:center">'.number_format($tot_qty,2).'</td>

	
<td style="text-align:center">'.number_format($tot_amt,2).'</td>

	



</tr>

	



</tbody>

	



</table>';


}

else if($_REQUEST['report']==2121)

{



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;}





if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date'] != '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 
//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

 $sql = "select distinct concat(i.finish_goods_code,'- ',item_name) as item_name,o.item_id,m.vendor_id,m.or_no,m.or_date,i.brand_category,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,

sum(o.qty) as total_qty, 


sum(o.amount) as amount

from 

sales_damage_receive_master m,sales_damage_receive_detail o, item_info i,dealer_info d, warehouse w,branch r,zon z,area a,super_zone ss

where m.or_no=o.or_no and m.vendor_id=d.dealer_code and i.item_id=o.item_id and m.status='UNCHECKED' and o.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$item_brand_con.$depot_con.$receive_type_con.$dealer_con.' group by o.item_id order by i.finish_goods_code,m.or_no,m.or_date';



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


<th style=" text-align:center;">Total Quantity</th>
	
<th style=" text-align:center;">Total Amount</th>


</tr>

	



</thead>

	



<tbody>';

	



while($data=mysqli_fetch_object($query)){$s++;



?>

	



<tr>


<td><?=$s?></td>

<td style="text-align:left">
<a href="master_report.php?report=3&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>&item_id=<?=$data->item_id?>&brand_category=<?=$_REQUEST['item_brand']?>" target="_blank"><?=($data->item_name)?></a>
</td>

<td style="text-align:center"><?=($data->brand_category)?></td>


	
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



<td style="text-align:center">'.number_format($tot_qty,2).'</td>

	
<td style="text-align:center">'.number_format($tot_amt,2).'</td>

	



</tr>

	



</tbody>

	



</table>';


}


else if($_REQUEST['report']==1000){


if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

if($_REQUEST['dealer_type']!='') 		{$dtype_con=' and d.dealer_type="'.$_REQUEST['dealer_type'].'"';}

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);


 $sql = "select o.item_id,concat(i.finish_goods_code,'- ',item_name) as item_name,m.vendor_id,i.brand_category,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,

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



<td style="border:0px;text-align:center;" colspan="20" ><h1>Dealer Name :'.$dealer_name.'</h1></td>

	
</tr>


<tr>


<th style=" text-align:center;">S/L</th>

<th>Item Name</th>
<th>Item Brand</th>



<th style=" text-align:center;">Toral Quantity</th>
	
<th style=" text-align:center;">Total Amount</th>


</tr>

	



</thead>

	



<tbody>';

	



while($data=mysqli_fetch_object($query)){$s++;



?>

	



<tr>

<td><?=$s?></td>

<td style="text-align:left">
<a href="master_report.php?report=2&dealer_code=<?=$data->vendor_id;?>&f_date=<?=$_REQUEST['f_date']?>&t_date=<?=$_REQUEST['t_date']?>&item_id=<?=$data->item_id?>&dealer_type=<?=$_REQUEST['dealer_type']?>&brand_category=<?=$_REQUEST['item_brand']?>" target="_blank"><?=($data->item_name)?></a>
</td>

<td style="text-align:left"><?=($data->brand_category)?></td>



	
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



<td style="text-align:center">'.number_format($tot_qty,2).'</td>

	
<td style="text-align:center">'.number_format($tot_amt,2).'</td>

	



</tr>

	



</tbody>

	



</table>';





}



else if($_REQUEST['report']==10007777){


if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

if($_REQUEST['dealer_type']!='') 		{$dtype_con=' and d.dealer_type="'.$_REQUEST['dealer_type'].'"';}

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);


 $sql = "select m.or_no,m.vendor_id,i.brand_category,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,

sum(o.qty) as total_qty, 

sum(o.qty*i.d_price) as Cost_Price,

sum(o.amount)as amount

from 

sales_damage_receive_master m,sales_damage_receive_detail o, item_info i,dealer_info d, warehouse w

where m.or_no=o.or_no and m.vendor_id=d.dealer_code and i.item_id=o.item_id and m.status='UNCHECKED' and o.warehouse_id=w.warehouse_id   ".$date_con.$item_con.$item_brand_con.$depot_con.$receive_type_con.$dealer_con.$dtype_con.' group by m.or_no';



$query = db_query($sql);

	



echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Dealer Name :'.$dealer_name.'</h1></td>

	
</tr>


<tr>


<th style=" text-align:center;">S/L</th>

<th>Or No</th>
<th>Item Brand</th>



<th style=" text-align:center;">Total Quantity</th>
	
<th style=" text-align:center;">Total Amount</th>


</tr>

	



</thead>

	



<tbody>';

	



while($data=mysqli_fetch_object($query)){$s++;



?>

	



<tr>

<td><?=$s?></td>

<td style="text-align:left"><a href="damage_view_print.php?v_no=<?=$data->or_no?>" target="_blank">
<?=($data->or_no)?></a>
</td>

<td style="text-align:left"><?=($data->brand_category)?></td>



	
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



<td style="text-align:center">'.number_format($tot_qty,2).'</td>

	
<td style="text-align:center">'.number_format($tot_amt,2).'</td>

	



</tr>

	



</tbody>

	



</table>';





}



else if($_REQUEST['report']==1001){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 
//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);


 $sql = "select o.item_id,i.item_name as item_name,m.vendor_id,

sum(o.qty) as total_qty, 

sum(o.qty*i.d_price) as Cost_Price,

sum(o.amount)as amount

from 

sales_damage_receive_master m,sales_damage_receive_detail o, item_info i,dealer_info d, warehouse w,branch r,zon z,area a

where m.or_no=o.or_no and i.item_id=o.item_id and m.status='UNCHECKED' and o.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$item_brand_con.$depot_con.$receive_type_con.$dealer_con.$dtype_con.' group by i.finish_goods_code';



$query = db_query($sql);

	



echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Damage Report</h1></td>

	
</tr>


<tr>


<th style=" text-align:center;">S/L</th>

<th>Item Name</th>



<th style=" text-align:center;">Toral Quantity</th>

</tr>

	



</thead>

	



<tbody>';

	



while($data=mysqli_fetch_object($query)){$s++;



?>

	



<tr>

<td><?=$s?></td>

<td style="text-align:left">
<?=$data->item_name?>
</td>




	
<td style="text-align:center"><?=$data->total_qty?></td>


</tr>

	



<?

	



$tot_qty = $tot_qty+$data->total_qty;

	
$tot_amt = $tot_amt+$data->amount;




	



}

	



echo '<tr class="footer">

	


<td style="text-align:right">&nbsp;</td>

	
<td style="text-align:right">&nbsp;</td>



	




<td style="text-align:center">'.number_format($tot_qty,2).'</td>



	



</tr>

	



</tbody>

	



</table>';





}



else if($_REQUEST['report']==90121){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select ss.super_zone_name  as area_name,ss.super_zone_id,d.dealer_code,sum(c.amount) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE  ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by ss.super_zone_id,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->super_zone_id != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->super_zone_id;
			
			
			$area_name[$data->super_zone_id]=$data->area_name;
			
			$amount[$data->super_zone_id][$data->month]= $data->amount;
			
			
	}
	
	
	
	
 $sql_sale="select ss.super_zone_id,i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_amt) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),ss.super_zone_id";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->super_zone_id][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Super Zone Name</th>
'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	

 $dealer_sql ="select ss.* from branch r,zon z,area a,super_zone ss where   ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE group by ss.super_zone_id ";

$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->super_zone_name;?></td>

<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->super_zone_id][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->super_zone_id][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->super_zone_id]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->super_zone_id]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->super_zone_id],2); $g_final_total_sale +=$y_total_sale[$data_dealer->super_zone_id];?></td>
<td><?=number_format($y_total[$data_dealer->super_zone_id],2); $g_final_total +=$y_total[$data_dealer->super_zone_id];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="2">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}

else if($_REQUEST['report']==9012102){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select r.BRANCH_NAME  as area_name,r.BRANCH_ID,d.dealer_code,sum(c.amount) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE  ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by r.BRANCH_ID,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->BRANCH_ID != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->BRANCH_ID;
			
			
			$area_name[$data->BRANCH_ID]=$data->area_name;
			
			$amount[$data->BRANCH_ID][$data->month]= $data->amount;
			
			
	}
	
	
	
	
 $sql_sale="select r.BRANCH_ID,i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_amt) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),r.BRANCH_ID";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->BRANCH_ID][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Region Name</th>
'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	

 $dealer_sql ="select r.* from branch r,zon z,area a,super_zone ss where   ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE group by r.BRANCH_ID ";

$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->BRANCH_NAME;?></td>

<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->BRANCH_ID][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->BRANCH_ID][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->BRANCH_ID]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->BRANCH_ID]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->BRANCH_ID],2); $g_final_total_sale +=$y_total_sale[$data_dealer->BRANCH_ID];?></td>
<td><?=number_format($y_total[$data_dealer->BRANCH_ID],2); $g_final_total +=$y_total[$data_dealer->BRANCH_ID];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="2">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}


else if($_REQUEST['report']==9012103){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select z.ZONE_NAME  as area_name,z.ZONE_CODE,d.dealer_code,sum(c.amount) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE  ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by z.ZONE_CODE,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->ZONE_CODE != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->ZONE_CODE;
			
			
			$area_name[$data->ZONE_CODE]=$data->area_name;
			
			$amount[$data->ZONE_CODE][$data->month]= $data->amount;
			
			
	}
	
	
	
	
 $sql_sale="select z.ZONE_CODE,i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_amt) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),z.ZONE_CODE";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->ZONE_CODE][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Area Name</th>

<th rowspan="2">Region Name</th>
'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	

 $dealer_sql ="select z.*,r.BRANCH_NAME from branch r,zon z,area a,super_zone ss where   ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE group by z.ZONE_CODE ";

$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->ZONE_NAME;?></td>
	
<td align="left"><?=$data_dealer->BRANCH_NAME;?></td>

<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->ZONE_CODE][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->ZONE_CODE][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->ZONE_CODE]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->ZONE_CODE]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->ZONE_CODE],2); $g_final_total_sale +=$y_total_sale[$data_dealer->ZONE_CODE];?></td>
<td><?=number_format($y_total[$data_dealer->ZONE_CODE],2); $g_final_total +=$y_total[$data_dealer->ZONE_CODE];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="3">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}
else if($_REQUEST['report']==9012104){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and i.item_id="'.$_REQUEST['item_id'].'"';} 
	
if(isset($item_brand))				{$item_brand_con=' and i.brand_category="'.$item_brand.'"';} 


	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select i.item_name  as area_name,i.item_id,d.dealer_code,sum(c.amount) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE  ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by i.item_id,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->area_name != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->area_name;
			
			
			$area_name[$data->item_id]=$data->area_name;
			
			$amount[$data->item_id][$data->month]= $data->amount;
			
			
	}
	
	
	
	
 $sql_sale="select i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_amt) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$item_brand_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),i.item_id";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->item_id][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Item Name</th>
'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	

 $dealer_sql ="select i.* from item_info i where i.sub_group_id=500100000 	".$item_brand_con.$item_con."" ;

$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->item_name;?></td>

<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->item_id][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->item_id][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->item_id]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->item_id]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->item_id],2); $g_final_total_sale +=$y_total_sale[$data_dealer->item_id];?></td>
<td><?=number_format($y_total[$data_dealer->item_id],2); $g_final_total +=$y_total[$data_dealer->item_id];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="2">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}

else if($_REQUEST['report']==9012105){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select a.area_name  as area_name,a.AREA_CODE,d.dealer_code,sum(c.amount) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE  ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by a.AREA_CODE,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->area_name != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->area_name;
			
			
			$area_name[$data->AREA_CODE]=$data->area_name;
			
			$amount[$data->AREA_CODE][$data->month]= $data->amount;
			
			
	}
	
	
	
	
 $sql_sale="select a.AREA_CODE,i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_amt) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),a.AREA_CODE";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->AREA_CODE][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Territory Name</th>

<th rowspan="2">Area Name</th>
'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	

 $dealer_sql ="select a.*,z.ZONE_NAME from branch r,zon z,area a,super_zone ss where   ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE";

$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->AREA_NAME;?></td>

<td align="left"><?=$data_dealer->ZONE_NAME;?></td>

<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->AREA_CODE][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->AREA_CODE][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->AREA_CODE]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->AREA_CODE]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->AREA_CODE],2); $g_final_total_sale +=$y_total_sale[$data_dealer->AREA_CODE];?></td>
<td><?=number_format($y_total[$data_dealer->AREA_CODE],2); $g_final_total +=$y_total[$data_dealer->AREA_CODE];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="3">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}
	
	
else if($_REQUEST['report']==9012107){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select i.brand_category  as area_name,b.id as brand,d.dealer_code,sum(c.amount) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE,ss.super_zone_name,z.ZONE_NAME
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss,brand_category_info b
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and b.brand_category=i.brand_category ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by i.brand_category,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->area_name != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->area_name;
			
			
			$area_name[$data->brand]=$data->area_name;
		
			
				
			$amount[$data->brand][$data->month]= $data->amount;
			
			
	}
	
	
	
 $sql_sale="select b.id as brand,i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_amt) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss,brand_category_info b where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 and b.brand_category=i.brand_category ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),i.brand_category";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->brand][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Group Name</th>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	

 $dealer_sql ="select d.* from brand_category_info d where 1";

$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->brand_category;?></td>
<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->id][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->id][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->id]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->id]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->id],2); $g_final_total_sale +=$y_total_sale[$data_dealer->id];?></td>
<td><?=number_format($y_total[$data_dealer->id],2); $g_final_total +=$y_total[$data_dealer->id];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="2">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}	


else if($_REQUEST['report']==9012108){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select d.dealer_name_e  as area_name,d.dealer_code,sum(c.amount) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE,ss.super_zone_name,z.ZONE_NAME
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE  ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by d.dealer_code,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->area_name != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->area_name;
			
			
			$area_name[$data->dealer_code]=$data->area_name;
		
			
				
			$amount[$data->dealer_code][$data->month]= $data->amount;
			
			
	}
	
	
	
 $sql_sale="select i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_amt) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),d.dealer_code";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->dealer_code][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Party Name</th>
<th rowspan="2">Zone Name</th>
<th rowspan="2">Area Name</th>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	

 $dealer_sql ="select d.*,ss.super_zone_name,z.ZONE_NAME from dealer_info d, branch r,zon z,area a,super_zone ss where     d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and d.dealer_type in('Depot','Distributor')";

$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->dealer_name_e;?></td>
<td align="left"><?=$data_dealer->super_zone_name;?></td>

<td align="left"><?=$data_dealer->ZONE_NAME;?></td>
<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->dealer_code][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->dealer_code][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->dealer_code]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->dealer_code]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->dealer_code],2); $g_final_total_sale +=$y_total_sale[$data_dealer->dealer_code];?></td>
<td><?=number_format($y_total[$data_dealer->dealer_code],2); $g_final_total +=$y_total[$data_dealer->dealer_code];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="4">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}	
	
else if($_REQUEST['report']==9012109){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select d.dealer_name_e  as area_name,d.dealer_code,sum(c.qty) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE  ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by d.dealer_code,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->area_name != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->area_name;
			
			
			$area_name[$data->dealer_code]=$data->area_name;
			
			$amount[$data->dealer_code][$data->month]= $data->amount;
			
			
	}
	
	
	
	
 $sql_sale="select i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_unit) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),d.dealer_code";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->dealer_code][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Party Name</th>

<th rowspan="2">Zone Name</th>

<th rowspan="2">Area Name</th>
'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	


 $dealer_sql ="select d.*,ss.super_zone_name,z.ZONE_NAME from dealer_info d, branch r,zon z,area a,super_zone ss where     d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and d.dealer_type in('Depot','Distributor')";
$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->dealer_name_e;?></td>
	
<td align="left"><?=$data_dealer->super_zone_name;?></td>
	
<td align="left"><?=$data_dealer->ZONE_NAME;?></td>

<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->dealer_code][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->dealer_code][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->dealer_code]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->dealer_code]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->dealer_code],2); $g_final_total_sale +=$y_total_sale[$data_dealer->dealer_code];?></td>
<td><?=number_format($y_total[$data_dealer->dealer_code],2); $g_final_total +=$y_total[$data_dealer->dealer_code];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="4">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}	
	
else if($_REQUEST['report']==9012106){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select i.brand_category  as area_name,b.id as brand,d.dealer_code,sum(c.qty) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE,ss.super_zone_name,z.ZONE_NAME
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss,brand_category_info b
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and b.brand_category=i.brand_category ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by i.brand_category,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->area_name != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->area_name;
			
			
			$area_name[$data->brand]=$data->area_name;
		
			
				
			$amount[$data->brand][$data->month]= $data->amount;
			
			
	}
	
	
	
 $sql_sale="select b.id as brand,i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_unit) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss,brand_category_info b where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 and b.brand_category=i.brand_category ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),i.brand_category";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->brand][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Group Name</th>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	

 $dealer_sql ="select d.* from brand_category_info d where 1";

$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->brand_category;?></td>
<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->id][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->id][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->id]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->id]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->id],2); $g_final_total_sale +=$y_total_sale[$data_dealer->id];?></td>
<td><?=number_format($y_total[$data_dealer->id],2); $g_final_total +=$y_total[$data_dealer->id];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="2">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}	
	
else if($_REQUEST['report']==901210400){



if(isset($area_id))				{$area_con=' and z.ZONE_CODE='.$area_id;} 
if(isset($region_id))				{$region_con=' and r.BRANCH_ID='.$region_id;} 
if(isset($territory_id))				{$territory_con=' and a.AREA_CODE='.$territory_id;} 
if(isset($super_zone))				{$super_zone=' and ss.super_zone_id='.$super_zone;} 



if($_REQUEST['receive_type'] != '') 			{$receive_type_con=' and m.receive_type="'.$_REQUEST['receive_type'].'"';} 

if($_REQUEST['dealer_code'] != '') 		{$dealer_con=' and m.vendor_id='.$_REQUEST['dealer_code'];}

if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con=' and m.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
	
if($_REQUEST['t_date']!= '') 				{$to_date=$_REQUEST['t_date']; $fr_date=$_REQUEST['f_date']; $date_con_sale=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if($_REQUEST['product_group']!= '') 		{$pg_con=' and d.product_group="'.$_REQUEST['product_group'].'"';} 

if($_REQUEST['item_id']!='') 		{$item_con=' and o.item_id="'.$_REQUEST['item_id'].'"';} 

	
	
if($_REQUEST['dealer_type']!='') {
	if($_REQUEST['dealer_type']=='Depot')
	 {
	 	$dtype_con=' and d.dealer_type="Depot"';
	} 
		elseif($_REQUEST['dealer_type']=='Distributor')
			 {$dtype_con=' and d.dealer_type="Distributor"';}  
		elseif($_REQUEST['dealer_type']=='Foreign')
			 {$dtype_con=' and d.dealer_type="Foreign"';}  
			 
			else{$dtype_con=' and d.dealer_type in("Depot","Distributor")';}
	} 	

//concat('<a href="',case 1,'" target="_blank" >',sum(c.qty) as total_qty,'</a>')

$dealer_name = find_a_field('dealer_info','dealer_name_e','dealer_code='.$_REQUEST['dealer_code']);




  $sdate = strtotime($_REQUEST['f_date']);
 $edate = strtotime($_REQUEST['t_date']);

 $s_date =date("Y-m-01",$sdate);
 $m_date = $new_date = date("Y-m-15",$sdate);
 $e_date =date("Y-m-t",$edate);

$start_date = strtotime(date("Y-m-01 00:00:00",strtotime($s_date)));
$end_date = strtotime(date("Y-m-t 23:59:59",strtotime($e_date)));
for($c=1;$c<13;$c++)
{

	if($new_date>$e_date)  {$c=$c-1;break;}
	else
	{
	$st_date[$c] = date("Y-m-01",(strtotime($new_date)));
	$en_date[$c] = date("Y-m-t",(strtotime($new_date)));
  $priod[$c] = date("Ym",(strtotime($new_date)));
	$period_name[$c] = date("M, Y",(strtotime($new_date)));
	}
$new_date = date("Y-m-d",(strtotime($new_date)+2592000));
} 


	
 $sql = "select i.item_name  as area_name,i.item_id,d.dealer_code,sum(c.qty) as amount,concat(date_format(m.or_date,'%Y%m')) as month,z.ZONE_CODE
from dealer_info d  , warehouse w, item_info i, sales_damage_receive_detail c,sales_damage_receive_master m, branch r,zon z,area a,super_zone ss
where i.item_id=c.item_id and c.vendor_id=d.dealer_code and m.or_no=c.or_no and m.vendor_id=c.vendor_id and m.status='UNCHECKED' and c.warehouse_id=w.warehouse_id and d.area_code=a.AREA_CODE and ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE  ".$super_zone.$region_con.$area_con.$territory_con.$date_con.$item_con.$pg_con.$item_brand_con.$dtype_con.$dealer_con." group by i.item_id,concat(date_format(m.or_date,'%Y%m'))";



$query = db_query($sql);

	while($data=mysqli_fetch_object($query)){
	
			 if($data->area_name != $old_group) {
			$row_count++;
			}
			
			$old_group = $data->area_name;
			
			
			$area_name[$data->item_id]=$data->area_name;
			
			$amount[$data->item_id][$data->month]= $data->amount;
			
			
	}
	
	
	
	
 $sql_sale="select i.item_id,i.item_name,i.unit_name,i.brand_category,d.dealer_code,m.do_date ,concat(date_format(m.do_date,'%Y%m')) as month,sum(de.total_unit) total_unit from item_info i, sale_do_details de , sale_do_master m, dealer_info d , branch r,zon z,area a,super_zone ss where d.dealer_code=de.dealer_code and  de.do_no=m.do_no and d.area_code=a.AREA_CODE  and  ss.super_zone_id=r.super_zone_id and r.BRANCH_ID=z.REGION_ID and a.ZONE_ID=z.ZONE_CODE and m.status!='MANUAL' and de.unit_price > 0 ".$super_zone.$region_con.$area_con.$territory_con.$date_con_sale.$dtype_con.$item_con.$brand_category_con.$dealer_con." and m.status in ('COMPLETED','PROCESSING','CHECKED')  and  de.item_id=i.item_id GROUP by concat(date_format(m.do_date,'%Y%m')),i.item_id";
	
	$query_sale = db_query($sql_sale);

while($datas=mysqli_fetch_object($query_sale)){
			
			$item_name[$datas->item_id]=$datas->item_name;
			$item_qty[$datas->item_id][$datas->month]=$datas->total_unit;
			$brand[$datas->item_id]= $datas->brand_category;
			$unit[$datas->item_id]= $datas->unit_name;


}




echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">

	
<thead>

	
<tr>



<td style="border:0px;text-align:center;" colspan="20" >'.$str.'</td>

	
</tr>
<tr>



<td style="border:0px;text-align:center;" colspan="20" ><h1>Group Wise Damage Report</h1></td>

	
</tr>


<tr>
<th rowspan="2">SL</th>
<th rowspan="2">Item Name</th>
'; ?>

<? for($p=1;$p<=$c;$p++){?><th colspan="2"><?=$period_name[$p]?></th><? } ?>
<? echo '


<th colspan="2">Total</th>



</tr>

<tr>

'; ?>

<? for($p=1;$p<=$c;$p++){?><th>Sale</th><th>Damage</th><? } ?>
<? echo '


<th>Sale</th>
<th>Damage</th>


</tr>

	



</thead>

	



<tbody>';

	

 $dealer_sql ="select i.* from item_info i where i.sub_group_id=500100000";

$query_dealer = db_query($dealer_sql);

while($data_dealer=mysqli_fetch_object($query_dealer))

  { $sl++;
?>

	



<tr>




<td><?=$sl;?></td>
<td align="left"><?=$data_dealer->item_name;?></td>

<? for($p=1;$p<=$c;$p++){?>

	
<td><? $p_total_sale[$p]=$item_qty[$data_dealer->item_id][$priod[$p]];
	if($p_total_sale[$p] > 0) { echo number_format($p_total_sale[$p],2); }
	else { echo '-'; }

?></td>
	
<td><? $p_total[$p]=$amount[$data_dealer->item_id][$priod[$p]];
	if($p_total[$p] > 0) { echo number_format($p_total[$p],2); }
	else { echo '-'; }

?></td>


 <? $y_total[$data_dealer->item_id]+=$p_total[$p];
 	$x_total[$priod[$p]]+=$p_total[$p];
?>
	
	 <? $y_total_sale[$data_dealer->item_id]+=$p_total_sale[$p];
 	$x_total_sale[$priod[$p]]+=$p_total_sale[$p];
?>
	

<? } ?>

<td><?=number_format($y_total_sale[$data_dealer->item_id],2); $g_final_total_sale +=$y_total_sale[$data_dealer->item_id];?></td>
<td><?=number_format($y_total[$data_dealer->item_id],2); $g_final_total +=$y_total[$data_dealer->item_id];?></td>
</tr>

	



<?

}



echo '<tr class="footer">

	



<td colspan="2">Grand Total</td>


'?>

<? for($p=1;$p<=$c;$p++){?>
<td><?=number_format($x_total_sale[$priod[$p]],2)?></td>
<td><?=number_format($x_total[$priod[$p]],2)?></td>

<? }?>
<td><?=number_format($g_final_total_sale,2);?></td>
<td><?=number_format($g_final_total,2);?></td>
<? '


	



</tr>

	



</tbody>

	



</table>';





}


else if($_REQUEST['report']==2000)

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

//elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}

?></div>

</body>

</html>