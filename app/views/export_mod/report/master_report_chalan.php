<?



//



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


//$depot=$_SESSION['user']['depot'];



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



if($_POST['dealer_type']!='') 	$dealer_type=$_POST['dealer_type'];







if($_POST['status']!='') 		$status=$_POST['status'];



if($_POST['do_no']!='') 		$do_no=$_POST['do_no'];



if($_POST['area_id']!='') 		$area_id=$_POST['area_id'];



if($_POST['zone_id']!='') 		$zone_id=$_POST['zone_id'];



if($_POST['region_id']>0) 		$region_id=$_POST['region_id'];



if($_POST['depot_id']!='') 		$depot_id=$_POST['depot_id'];







if(isset($item_brand)) 			{$item_brand_con=' and i.sub_group_id="'.$item_brand.'"';} 



if(isset($dealer_code)) 		{$dealer_con=' and d.dealer_code="'.$dealer_code.'"';} 



if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 		{$pg_con=' and d.team_name="'.$product_group.'"';} 







if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';}



if(isset($dealer_type)) 		{$dealer_type_con=' and d.dealer_type="'.$dealer_type.'"';}







if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 



if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 



if(isset($area_id)) 			{$area_con=' and a.area_name="'.$area_id.'"';} 



if(isset($zone_id)) 			{$zone_con=' and z.ZONE_CODE='.$zone_id;}



if(isset($region_id)) 			{$region_con=' and r.BRANCH_ID='.$region_id;}





//if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 



//if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 



//if(isset($zone_id)) 			{$zone_con=' and a.buyer_id='.$zone_id;}



//if(isset($region_id)) 		{$region_con=' and d.id='.$region_id;}



//if(isset($item_id)) 			{$item_con=' and b.item_id='.$item_id;} 



//if(isset($status)) 			{$status_con=' and a.status="'.$status.'"';} 



//if(isset($do_no)) 			{$do_no_con=' and a.do_no="'.$do_no.'"';} 



//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $chalan_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







switch ($_POST['report']) {



case 1:



		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		

		



		$report="Delivery Chalan Summary Brief";



		break;

		

		

		

case 1001:



		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		

		



		$report="Delivery Challan Vat Report";



		break;

		

		

		



case 101:



		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and  m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		$report="Delivery Order wise Chalan Summary Brief";



		break;



case 2:



		$report="Item Wise Chalan Details Report";



		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}



		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 



		if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}

		

		if(isset($area_id)) 		{$con.=' and d.area_code="'.$area_id.'"';}







		$sql='select 



		i.finish_goods_code as fg,



		i.item_id,



		i.item_name,



		i.unit_name as unit,



		i.s_price,

		

		i.c_price,

		

		i.d_price,



		i.pack_size,



		sum(m.total_unit) pcs,



		sum(a.total_unit) qty,



		sum(a.total_unit*i.d_price) as DP,



		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,



		



		



		sum(a.total_unit*a.unit_price) as actual_price



		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i where d.dealer_code=m.dealer_code and m.id=a.order_no  and  



	a.unit_price>0  and a.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.$pg_con.' 



	group by  a.item_id order by i.finish_goods_code';



/*$sql2='select 



		i.finish_goods_code as fg2,



		m.gift_on_item as item_id,



		i.item_name,



		i.unit_name as unit,



		i.item_brand as brand,



		i.pack_size,



		sum(a.total_unit) div i.pack_size as pkt,



		sum(a.total_unit) mod i.pack_size as pcs,



		sum(a.total_unit) qty,



		sum(a.total_unit*i.d_price) as DP,



		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,



		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,



		



		sum(a.total_unit*a.unit_price) as actual_price



		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 



		



		where d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   



	a.item_id = 1096000100010312 and m.gift_on_item=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 



	group by  m.gift_on_item order by i.finish_goods_code';



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{


	$citem[$data2->item_id] = $data2->sale_price*$data2->qty;



	}



	$sql2='select 



		i.finish_goods_code as fg3,



		m.gift_on_item as item_id,



		i.item_name,



		i.unit_name as unit,



		i.item_brand as brand,



		i.pack_size,



		i.d_price,



		sum(a.total_unit) div i.pack_size as pkt,



		sum(a.total_unit) mod i.pack_size as pcs,



		sum(a.total_unit) qty,



		sum(a.total_unit*i.d_price) as DP,



		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,



		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,



		



		sum(a.total_unit*a.unit_price) as actual_price



		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 



		



		where d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   



	a.unit_price = 0 and m.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 



	group by  m.gift_on_item order by i.finish_goods_code';

	

	echo $sql2;



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{



	$ditem[$data2->item_id] = $data2->d_price*$data2->qty;



	}

*/

	break;

	

	

	

	

	

	

	case 1115:



		$report="Gift Item Chalan Details Report";



		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}



		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 



		if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}

		

		if(isset($area_id)) 		{$con.=' and d.area_code="'.$area_id.'"';}







		 $sql='select 



		i.finish_goods_code as fg,



		i.item_id,



		i.item_name,



		i.unit_name as unit,



		i.d_price as dealer_price,

		

	



		i.pack_size,



		sum(m.total_unit) pcs,



		sum(a.total_unit) qty,



		sum(a.total_unit*i.d_price) as DP,



		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,



		



		



		sum(a.total_unit*a.unit_price) as actual_price



		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i where d.dealer_code=m.dealer_code and m.id=a.order_no  and  



	a.unit_price=0  and a.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.$pg_con.' 



	group by  a.item_id order by i.finish_goods_code';



/*$sql2='select 



		i.finish_goods_code as fg2,



		m.gift_on_item as item_id,



		i.item_name,



		i.unit_name as unit,



		i.item_brand as brand,



		i.pack_size,



		sum(a.total_unit) div i.pack_size as pkt,



		sum(a.total_unit) mod i.pack_size as pcs,



		sum(a.total_unit) qty,



		sum(a.total_unit*i.d_price) as DP,



		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,



		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,



		



		sum(a.total_unit*a.unit_price) as actual_price



		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 



		



		where d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   



	a.item_id = 1096000100010312 and m.gift_on_item=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 



	group by  m.gift_on_item order by i.finish_goods_code';



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{



	$citem[$data2->item_id] = $data2->sale_price*$data2->qty;



	}



	$sql2='select 



		i.finish_goods_code as fg3,



		m.gift_on_item as item_id,



		i.item_name,



		i.unit_name as unit,



		i.item_brand as brand,



		i.pack_size,



		i.d_price,



		sum(a.total_unit) div i.pack_size as pkt,



		sum(a.total_unit) mod i.pack_size as pcs,



		sum(a.total_unit) qty,



		sum(a.total_unit*i.d_price) as DP,



		sum(a.total_unit*a.unit_price)/sum(a.total_unit) as sale_price,



		sum((a.total_unit*i.d_price)-(a.total_amt)) as discount,



		



		sum(a.total_unit*a.unit_price) as actual_price



		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i 



		



		where d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and   



	a.unit_price = 0 and m.item_id=i.item_id '.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 



	group by  m.gift_on_item order by i.finish_goods_code';

	

	echo $sql2;



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{



	$ditem[$data2->item_id] = $data2->d_price*$data2->qty;



	}

*/

	break;

	

	

	

	



	



	case 3:



$report="Delivered Chalan Report (Chalan Wise)";



if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($dealer_code)) {$dealer_con=' and m.dealer_code='.$dealer_code;} 



if(isset($item_id)){$item_con=' and i.item_id='.$item_id;} 



if(isset($depot_id)) {$depot_con=' and d.depot="'.$depot_id.'"';} 



	break;

	

	

	

		case 30:



$report="Day by Day Product Wise Chalan";



if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'"';} 



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($dealer_code)) {$dealer_con=' and m.dealer_code='.$dealer_code;} 



if(isset($item_id)){$item_con=' and i.item_id='.$item_id;} 



if(isset($depot_id)) {$depot_con=' and d.depot="'.$depot_id.'"';} 



	break;

	

	



	case 6:



	if($_REQUEST['chalan_no']>0)



header("Location:chalan_view.php?v_no=".$_REQUEST['chalan_no']);



	break;



	case 5:



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 



$report="Delivery Order Brief Report (Region Wise)";



	break;



	    case 7:



		$report="Item wise DO Report";



if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 







$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,i.item_brand,i.sales_item_type as `group`,



floor(sum(o.total_unit)/o.pkt_size) as crt,



mod(sum(o.total_unit),o.pkt_size) as pcs, 



sum(o.total_amt)as dP,



sum(o.total_unit*o.t_price)as tP



from 



sale_do_master m,sale_do_details o, item_info i,dealer_info d



where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';



	break;



		case 8:



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 



$report="Dealer Performance Report";



	    case 9:



		$report="Item Report (Region Wise)";



if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 



		break;



		



		case 10:



		$report="Daily Collection Summary";



		



$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 



sale_do_master m,dealer_info d  , warehouse w



where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";



		break;



		



		case 11:



		$report="Daily Collection &amp; Order Summary";



		



$sql="select m.do_no, m.do_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from 



sale_do_master m,dealer_info d  , warehouse w 



where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";



		break;



				case 13:



		$report="Daily Collection Summary(EXT)";



		



$sql="select m.do_no,m.do_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 



sale_do_master m,dealer_info d  , warehouse w



where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";



		break;



    case 111:



	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



$report="Corporate Chalan Summary Brief";



	break;



	    case 112:



	if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



$report="SuperShop Chalan Summary Brief";



	break;



	



	    case 1004:



		$report="Warehouse Stock Position Report(Closing)";







		break;



}



}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>

<?=$report?>

</title>

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

<style type="text/css">

<!--

.style1 {font-weight: bold}

.style2 {font-weight: bold}

.style3 {font-weight: bold}

.style4 {font-weight: bold}

.style5 {font-weight: bold}

.style6 {font-weight: bold}

.style7 {font-weight: bold}

.style8 {font-weight: bold}

.style9 {font-weight: bold}

.style10 {font-weight: bold}

.style11 {font-weight: bold}

.style12 {font-weight: bold}

.style13 {font-weight: bold}

.style14 {font-weight: bold}

.style15 {font-weight: bold}

.style16 {font-weight: bold}

.style17 {font-weight: bold}

.style18 {font-weight: bold}

.style19 {font-weight: bold}

.style20 {font-weight: bold}

.style21 {font-weight: bold}

.style22 {font-weight: bold}

.style23 {font-weight: bold}

.style24 {font-weight: bold}

-->

    </style>

</head>

<body>

<div align="center" id="pr">

  <input type="button" value="Print" onclick="hide();window.print();"/>

</div>

<div class="main">

  <?



		$str 	.= '<div class="header">';



		if(isset($_SESSION['company_name'])) 



		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';



		if(isset($report)) 



		$str 	.= '<h2>'.$report.'</h2>';



		if(isset($dealer_code)) 



		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';



		if(isset($to_date))



		$str 	.= '<h2>Date Interval : '.date("j-M-Y",strtotime($fr_date)).' To '.date("j-M-Y",strtotime($to_date)).'</h2>';

		

		if($_POST['region_id']!="" || $_POST['zone_id']!="" || $_POST['area_id']!="" || $_POST['depot_id']!=""){

		 if($_POST['region_id']!=""){$regeion=' Region Name:-'.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$_POST['region_id']);}

		 

		 if($_POST['zone_id']!=""){$regeion.=' &nbsp;&nbsp;Zone Name:-'.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$_POST['zone_id']);}

		 

		 if($_POST['area_id']!=""){$regeion.=' &nbsp;&nbsp;Area Name:-'.find_a_field('area','AREA_NAME','AREA_CODE='.$_POST['area_id']);}

		 

		 if($_POST['depot_id']!=""){$regeion.=' &nbsp;&nbsp;Depot Name:-'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['depot_id']);}



		$str 	.= '<h2>'.$regeion.'</h2>';}



		if(isset($product_group)) 



		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';



		if(isset($dealer_type)) 



		$str 	.= '<h2>Dealer Type : '.$dealer_type.'</h2>';



		$str 	.= '</div>';



		$str 	.= '<div class="left" style="width:100%">';







//		if(isset($allotment_no)) 



//		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';



//		$str 	.= '</div><div class="right">';



//		if(isset($client_name)) 



//		$str 	.= '<p>Dealer Name: '.$dealer_name.'</p>';



//		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';



if($_POST['report']==1004) 



{



			if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



			elseif(isset($item_id)) 			{$item_sub_con=' and i.item_id='.$item_id;} 



			



			if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 



			



			if(isset($t_date)) 



			{$to_date=$t_date; $fr_date=$f_date; $date_con=' and ji_date <="'.$to_date.'"';}



		



		



		$sql='select distinct i.item_id,i.unit_name,i.brand_category_type,i.item_name,"Finished Goods",i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 



		   from item_info i where i.finish_goods_code!=2000 and i.finish_goods_code!=2001 and i.finish_goods_code!=2002 and i.finish_goods_code>0 and i.finish_goods_code not between 5000 and 6000 and i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' and i.item_brand != "" and i.status="Active" order by i.brand_category_type,i.brand_category,i.item_brand';



		   



		$query =db_query($sql);



?>

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="10"><div class="header">

            <h1>M. Ahmed Tea & Lands Co. Ltd</h1>

            <h2>

              <?=$report?>

            </h2>

            <h2>Closing Stock of Date-

              <?=$to_date?>

            </h2>

          </div>

          <div class="left"></div>

          <div class="right"></div>

          <div class="date">Reporting Time:

            <?=date("h:i A d-m-Y")?>

        </div></td>

      </tr>

      <tr>

        <th>S/L</th>

        <th>Brand</th>

        <th>Item Type </th>

        <th>FG</th>

        <th>Item Name</th>

        <th>Group</th>

        <th>Unit</th>

        <th>Dhaka</th>

        <th>Gazipur</th>

        <th>Chittagong</th>

        <th>Borisal</th>

        <th>Bogura</th>

        <th>Sylhet</th>

        <th>Jessore</th>

        <th>Total</th>

      </tr>

    </thead>

    <tbody>

      <?



while($data=mysqli_fetch_object($query)){











	$dhaka = 	(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id = "3"')/$data->pack_size);



	$ctg = 		(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id = "6"')/$data->pack_size);



	$sylhet =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id = "9"')/$data->pack_size);



	$bogura =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id = "7"')/$data->pack_size);



	$borisal =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id = "8"')/$data->pack_size);



	$jessore =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id = "10"')/$data->pack_size);



	$gajipur =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id = "54"')/$data->pack_size);



	$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore + $gajipur;	   



	



	//echo $sql = 'select sum(item_in-item_ex) from journal_item where item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"';







?>

      <tr>

        <td><?=++$j?></td>

        <td><?=$data->item_brand?></td>

        <td><?=$data->brand_category_type?></td>

        <td><?=$data->finish_goods_code?></td>

        <td><?=$data->item_name?></td>

        <td><?=$data->sales_item_type?></td>

        <td><?=$data->unit_name?></td>

        <td style="text-align:right"><?=(int)$dhaka?></td>

        <td style="text-align:right"><?=(int)$gajipur?></td>

        <td style="text-align:right"><?=(int)$ctg?></td>

        <td style="text-align:right"><?=(int)$borisal?></td>

        <td style="text-align:right"><?=(int)$bogura?></td>

        <td style="text-align:right"><?=(int)$sylhet?></td>

        <td style="text-align:right"><?=(int)$jessore?></td>

        <td style="text-align:right"><?=(int)$total?>

        &nbsp;</td>

      </tr>

      <?



}



		



?>

    </tbody>

  </table>

  <?







}





elseif($_POST['report']==1111){?>

  <!--Monthly Sales Statement-->

  <table width="100%" cellspacing="0" cellpadding="2" border="0" style="font-size:14px;">

    <thead>

      <tr>

        <td style="border:0px;" colspan="18"><div class="header">

            <h1>M. Ahmed Tea & Lands Co. Ltd </h1>

            <h2>

              <?=$report?>

            </h2>

            <h2><b>Monthly Sales Statement</b></h2>

          </div>

          <div class="left"></div>

          <div class="right"></div>

          <div class="header">

            <h2>DEPOT:

              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id)?>

            </h2>

            <h2>Date Interval:

			

			 <?=date("j-M-Y",strtotime($f_date));?> 

              <strong>to</strong> 

              <?=date("j-M-Y",strtotime($to_date));?>

            </h2>

          </div>

          <div class="date">Reporting Time:

            <?=date("h:i A d-m-Y")?>

        </div></td>

      </tr>

      <tr>

        <td style="border:0px;" colspan="18"></td>

      </tr>

      <tr>

        <th width="2%" bgcolor="#00FFFF">S/L</th>

        <th width="19%" bgcolor="#00FFFF">Name Of Distributors</th>

        <th width="5%" bgcolor="#00FFFF">Area </th>

        <th width="5%" bgcolor="#00FFFF">Zone</th>

        <th width="11%" bgcolor="#00FFFF">SR/SS/SE</th>

        <th width="4%" bgcolor="#00FFFF">10GM</th>

        <th width="4%" bgcolor="#00FFFF">50Gm</th>

        <th width="4%" bgcolor="#00FFFF">100GM</th>

        <th width="4%" bgcolor="#00FFFF">200GM</th>

        <th width="5%" bgcolor="#00FFFF">500GM(A)</th>

        <th width="2%" bgcolor="#00FFFF">500Gm (H) </th>

        <th width="2%" bgcolor="#00FFFF">500Gm (TS) </th>

        <th width="4%" bgcolor="#00FFFF">1Kg</th>

        <th width="4%" bgcolor="#00FFFF">500GM (D) </th>

        <th width="4%" bgcolor="#00FFFF">Tea Bag </th>

        <th width="4%" bgcolor="#00FFFF">Bag in Bag </th>

        <th width="6%" bgcolor="#00FFFF">Total Kgs </th>

        <th width="8%" bgcolor="#00FFFF">Amount</th>

      </tr>

    </thead>

    <tbody>

      <?



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';}









if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con_in=' and chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) 			{$depot_con_in=' and depot_id="'.$depot_id.'" and unit_price >0';}

$tot_in_con=$date_con_in.$depot_con_in;



$sqle='select distinct c.dealer_code, d.dealer_name_e, d.area_code, d.zone_name  from dealer_info d, sale_do_chalan c  where d.dealer_code=c.dealer_code'.$date_con.$depot_con." order by d.zone_name desc";

$query=db_query($sqle);

while($data=mysqli_fetch_object($query)){



?>

      <tr>

        <td><?=++$j?></td>

        <td><?=$data->dealer_name_e?></td>

        <td><?=find_a_field('area','AREA_NAME','AREA_CODE='.$data->area_code)?></td>

        <td><?=$data->zone_name?></td>

        <td><?=find_a_field('personnel_basic_info p, area a, dealer_info d','p.PBI_NAME','p.PBI_ID=a.sr_id and a.AREA_CODE='.$data->area_code)?></td>

        <td><? $gm_10=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010001 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id'); $tot_gm_10+=$gm_10; echo number_format($gm_10,2);

	

$amt_gm_10=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010001 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id'); $amt_tot_gm_10+=$amt_gm_10;	

	?></td>

        <td><? $gm_50=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010002 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id'); $tot_gm_50+=$gm_50;  echo number_format($gm_50,2);

	

	$amt_gm_50=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010002 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id'); $amt_tot_gm_50+=$amt_gm_50;

	?></td>

        <td style="text-align:left"><? $gm_100=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010003 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_100+=$gm_100;  echo number_format($gm_100,2);

	

	$amt_gm_100=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010003 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $amt_tot_gm_100+=$amt_gm_100;

	?></td>

        <td style="text-align:left"><? $gm_200=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010004 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_200+=$gm_200; echo number_format($gm_200,2);

	

	$amt_gm_200=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010004 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $amt_tot_gm_200+=$amt_gm_200;

	?></td>

        <td style="text-align:left"><? $gm_500A=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010005 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_500A+=$gm_500A;  echo number_format($gm_500A,2);

	

	$amt_gm_500A=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010005 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $amt_tot_gm_500A+=$amt_gm_500A;

	?></td>

        <td style="text-align:left"><? $gm_500H=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010008 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_500H+=$gm_500H; echo number_format($gm_500H,2);

	

	$amt_gm_500H=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010008 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $amt_tot_gm_500H+=$amt_gm_500H;

	?></td>

        <td style="text-align:left"><? $gm_500ts=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010011 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_500ts+=$gm_500ts; echo number_format($gm_500ts,2);

	

	$amt_gm_500ts=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010011 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $amt_tot_gm_500ts+=$amt_gm_500ts;

	?></td>

        <td style="text-align:left"><? $gm_1000=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010006 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_1000+=$gm_1000; echo number_format($gm_1000,2);

	

	$amt_gm_1000=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010006 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $amt_tot_gm_1000+=$amt_gm_1000;

	?></td>

        <td style="text-align:left"><? $gm_500D=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010007 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_500D+=$gm_500D; echo number_format($gm_500D,2);

	

	$amt_gm_500D=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010007 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $amt_tot_gm_500D+=$amt_gm_500D;

	?></td>

        <td style="text-align:left"><? $tea_bag=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010009 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $tot_tea_bag+=$tea_bag;  echo number_format($tea_bag,2);

	

	$amt_tea_bag=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010009 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $amt_tot_tea_bag+=$amt_tea_bag;

	?></td>

        <td style="text-align:left"><? $bag_in_bag=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010010 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $tot_bag_in_bag+=$bag_in_bag; echo number_format($bag_in_bag,2);

	

	$amt_bag_in_bag=find_a_field('sale_do_chalan','sum(total_amt)','item_id=1096000900010010 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id');  $amt_tot_bag_in_bag+=$amt_bag_in_bag;

	?></td>

        <td style="text-align:right"><? $item_kg=find_a_field('sale_do_chalan','sum(total_unit)',' dealer_code='.$data->dealer_code.$tot_in_con);  $tot_item_kg+=$item_kg;  echo number_format($item_kg,2);

	

	$amt_item_kg=find_a_field('sale_do_chalan','sum(total_amt)',' dealer_code='.$data->dealer_code.$tot_in_con);  $amt_tot_item_kg+=$amt_item_kg;

	?></td>

        <td style="text-align:right"><? $amount=find_a_field('sale_do_chalan','sum(total_amt)',' dealer_code='.$data->dealer_code.$tot_in_con);  $tot_amount+=$amount; echo number_format($amount,2)?></td>

      </tr>

      <?

}

?>

      <tr>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td><b>Grand Total = </b></td>

        <td><b>

          <?=number_format($tot_gm_10,2)?>

        </b></td>

        <td><b>

          <?=number_format($tot_gm_50,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($tot_gm_100,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($tot_gm_200,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($tot_gm_500A,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($tot_gm_500H,2)?>

          </b></td>

        <td style="text-align:left"><b>

          <?=number_format($tot_gm_500ts,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($tot_gm_1000,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($tot_gm_500D,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($tot_tea_bag,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($tot_bag_in_bag,2)?>

        </b></td>

        <td style="text-align:right"><b>

          <?=number_format($tot_item_kg,2)?>

        </b></td>

        <td style="text-align:right"><b>

          <?=number_format($tot_amount,2)?>

        </b></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td><strong>Total Amount = </strong></td>

        <td><span class="style14">

          <?=number_format($amt_tot_gm_10,2)?>

          </span></td>

        <td><span class="style15">

          <?=number_format($amt_tot_gm_50,2)?>

          </span></td>

        <td style="text-align:left"><span class="style16">

          <?=number_format($amt_tot_gm_100,2)?>

          </span></td>

        <td style="text-align:left"><span class="style17">

          <?=number_format($amt_tot_gm_200,2)?>

          </span></td>

        <td style="text-align:left"><span class="style18">

          <?=number_format($amt_tot_gm_500A,2)?>

          </span></td>

        <td style="text-align:left"><span class="style19">

          <?=number_format($amt_tot_gm_500H,2)?>

          </span></td>

        <td style="text-align:left"><span class="style24">

          <?=number_format($amt_tot_gm_500ts,2)?>

        </span></td>

        <td style="text-align:left"><span class="style20">

          <?=number_format($amt_tot_gm_1000,2)?>

          </span></td>

        <td style="text-align:left"><span class="style21">

          <?=number_format($amt_tot_gm_500D,2)?>

          </span></td>

        <td style="text-align:left"><span class="style22">

          <?=number_format($amt_tot_tea_bag,2)?>

          </span></td>

        <td style="text-align:left"><span class="style23">

          <?=number_format($amt_tot_bag_in_bag,2)?>

          </span></td>

        <td style="text-align:right"><span class="style24">

          <?=number_format($amt_tot_item_kg,2)?>

          </span></td>

        <td style="text-align:right">&nbsp;</td>

      </tr>

    </tbody>

  </table>

  <!--Monthly Sales Statement-->

  <? }









elseif($_POST['report']==1112){?>

  <!--National Sales Statement-->

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="7"><div class="header">

            <h1>M. Ahmed Tea & Lands Co. Ltd </h1>

            <h2>

              <?=$report?>

            </h2>

            <h2><b>National Sales Statement</b></h2>

            <?php if($_POST['item_id']!=''){?>

            <h2><b>Item Name :

              <?= find_a_field('item_info','item_name','item_id='.$_POST['item_id']); ?>

            </b></h2>

            <?php }?>

          </div>

          <div class="left"></div>

          <div class="right"></div>

          <div class="date">Reporting Time:

            <?=date("h:i A d-m-Y")?>

        </div></td>

      </tr>

      <tr>

        <td style="border:0px;" colspan="7"></td>

      </tr>

      <tr>

        <th width="3%" bordercolor="#000000" bgcolor="#CCFFFF">S/L</th>

        <th width="17%" bordercolor="#000000" bgcolor="#CCFFFF">Month</th>

        <th width="16%" bordercolor="#000000" bgcolor="#CCFFFF">Sylhet Marketing </th>

        <th width="16%" bordercolor="#000000" bgcolor="#CCFFFF">Dhaka Marketing</th>

        <th width="16%" bordercolor="#000000" bgcolor="#CCFFFF">Chittagong Marketing</th>

        <?php if(($_POST['item_id']==1096000900010010 || $_POST['item_id']==1096000900010009) && $_POST['item_id']!=''){?>

        <th width="16%" bordercolor="#000000" bgcolor="#CCFFFF">Total CTN </th>

        <?php }?>

        <th width="16%" bordercolor="#000000" bgcolor="#CCFFFF">Total Kgs </th>

      </tr>

    </thead>

    <tbody>

      <?



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';}









if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con_in=' and chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) 			{$depot_con_in=' and depot_id="'.$depot_id.'"';}

$tot_in_con=$date_con_in.$depot_con_in;



if($_POST['item_id']!=''){$item_con=' and item_id='.$_POST['item_id'];}

$item_con.=' and unit_price>0';



if($_POST['t_date']!=''){$to_mon=explode('-',$_POST['t_date']);}



for($i=1;$i<13;$i++){



$mon=date('m',mktime(0,0,0,$i,1,date('Y')));

$from_date=date('Y-'.$mon.'-01');

$to_date=date('Y-'.$mon.'-31');



?>

      <tr>

        <td><?=++$j?></td>

        <td><?=date('F',mktime(0,0,0,$i,1,date('Y')))?></td>

        <td><? $sl_depot=find_a_field('sale_do_chalan','sum(total_unit)','chalan_date between "'.$from_date.'" and  "'.$to_date.'" and depot_id=1'.$item_con); $tot_sl_depot+=$sl_depot; echo number_format($sl_depot,2)?></td>

        <td><? $dh_depot=find_a_field('sale_do_chalan','sum(total_unit)','chalan_date between "'.$from_date.'" and  "'.$to_date.'" and depot_id=3'.$item_con); $tot_dh_depot+=$dh_depot; echo number_format($dh_depot,2)?></td>

        <td><? $ct_depot=find_a_field('sale_do_chalan','sum(total_unit)','chalan_date between "'.$from_date.'" and  "'.$to_date.'" and depot_id in(2)'.$item_con); $tot_ct_depot+=$ct_depot; echo number_format($ct_depot,2); $total=$sl_depot+$dh_depot+$ct_depot;?></td>

        <?php if(($_POST['item_id']==1096000900010010 || $_POST['item_id']==1096000900010009) && $_POST['item_id']!=''){?>

        <td><?=number_format(($ctn_tot=$total/8),2); $tctn_tot+=$ctn_tot;?></td>

        <?php }?>

        <td><?=number_format($total,2)?></td>

      </tr>

      <?

//}

}

?>

      <tr>

        <td>&nbsp;</td>

        <td><b>Total = </b></td>

        <td><b>

          <?=number_format($tot_sl_depot,2)?>

        </b></td>

        <td><b>

          <?=number_format($tot_dh_depot,2)?>

        </b></td>

        <td><b>

          <?=number_format($tot_ct_depot,2)?>

        </b></td>

        <?php if(($_POST['item_id']==1096000900010010 || $_POST['item_id']==1096000900010009) && $_POST['item_id']!=''){?>

        <td><b>

          <?=number_format($tctn_tot,2)?>

        </b></td>

        <?php }?>

        <td><b>

          <?=number_format(($tot_sl_depot+$tot_dh_depot+$tot_ct_depot),2)?>

        </b></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

        <td><b>Monthly Average =</b></td>

        <td><b>

          <?=number_format(($tot_sl_depot/$to_mon[1]),2)?>

        </b></td>

        <td><b>

          <?=number_format(($tot_dh_depot/$to_mon[1]),2)?>

        </b></td>

        <td><b>

          <?=number_format(($tot_ct_depot/$to_mon[1]),2)?>

        </b></td>

        <?php if(($_POST['item_id']==1096000900010010 || $_POST['item_id']==1096000900010009) && $_POST['item_id']!=''){?>

        <td><b>

          <?=number_format(($tctn_tot/date('n')),2)?>

        </b></td>

        <?php }?>

        <td><b>

          <?=number_format((($tot_sl_depot+$tot_dh_depot+$tot_ct_depot)/date('n')),2)?>

        </b></td>

      </tr>

    </tbody>

  </table>

  <!--National Sales Statement-->

  <? }









elseif($_POST['report']==1113){?>

  <!--National Sales Statement (Item Wise)-->

  <table width="101%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="18"><div class="header">

            <h1>M. Ahmed Tea & Lands Co. Ltd </h1>

            <h2>

              <?=$report?>

            </h2>

            <h2><b>National Sales Statement (Item Wise)</b></h2>

          </div>

          <div class="left"></div>

          <div class="right"></div>

          <div class="header">

            <!--<h2>DEPOT: <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id)?></h2>-->

            <h2 style="margin:0; padding:0;">Date Interval:

			

			

			

              <?=date("j-M-Y",strtotime($f_date));?> 

              <strong>to</strong> 

              <?=date("j-M-Y",strtotime($to_date));?>

            </h2>

          </div>

          <div class="date">Reporting Time:

            <?=date("h:i A d-m-Y")?>

        </div></td>

      </tr>

      <tr>

        <td style="border:0px;" colspan="18"></td>

      </tr>

      <?php

if($_POST['t_date']!=''){$to_mon=explode('-',$_POST['t_date']);}

 

$sqlw='select * from warehouse where warehouse_id in(1,2,3)';

$queryw=db_query($sqlw);

while($dataw=mysqli_fetch_object($queryw)){



?>

      <tr>

        <th colspan="18" bgcolor="#99FFFF" align="center"><div align="center">DEPOT: <?php echo $dataw->warehouse_name?></div></th>

      </tr>

      <tr>

        <th width="1%">S/L  Omar</th>

        <th width="10%">Month</th>

        <th width="5%">10GM</th>

        <th width="6%">50Gm</th>

        <th width="6%">100GM</th>

        <th width="6%">200GM</th>

        <th width="6%">500GM(A)</th>

        <th width="3%">500Gm(H) </th>

        <th width="3%">500Gm (TS) </th>

        <th width="6%">1Kg</th>

        <th width="6%">250GM(D) </th>

        <th width="6%">500GM(D) </th>

        <th width="6%">Tea Bag </th>

        <th width="6%">T B CTN </th>

        <th width="6%">Bag in Bag </th>

        <th width="6%">B n B CTN </th>

        <th width="8%">Total Kgs </th>

        <th width="9%">Amount</th>

      </tr>

    </thead>

    <tbody>

      <?



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';}









if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con_in=' and chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) 			{$depot_con_in=' and depot_id="'.$depot_id.'"';}

$tot_in_con=$date_con_in.$depot_con_in;



if($dataw->warehouse_id==2){

$depot_conn=' and depot_id in(2)';

}else{

$depot_conn=' and depot_id='.$dataw->warehouse_id;

}



$depot_conn.=' and unit_price>0';

/*$sqle='select distinct c.dealer_code, d.dealer_name_e, d.area_code, d.zone_name  from dealer_info d, sale_do_chalan c  where d.dealer_code=c.dealer_code'.$date_con.$depot_con." order by d.zone_name desc";

$query=db_query($sqle);

while($data=mysqli_fetch_object($query)){*/

$year = $to_mon[0];

for($i=1;$i<($to_mon[1]+1);$i++){



$mon=date('m',mktime(0,0,0,$i,1,date('Y')));





$from_date=date($year.'-'.$mon.'-01');

$to_date=date($year.'-'.$mon.'-31');



?>

      <tr>

        <td><?=++$j?></td>

        <td><?=date('F',mktime(0,0,0,$i,1,date('Y')))?></td>

        <td><? $gm_10=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010001 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id'); $tot_gm_10+=$gm_10; echo number_format($gm_10,2)?></td>

        <td><? $gm_50=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010002 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id'); $tot_gm_50+=$gm_50;  echo number_format($gm_50,2)?></td>

        <td style="text-align:left"><? $gm_100=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010003 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_100+=$gm_100;  echo number_format($gm_100,2)//echo 'sale_do_chalan','sum(total_unit)','item_id=1096000900010003 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id';?></td>

        <td style="text-align:left"><? $gm_200=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010004 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_200+=$gm_200; echo number_format($gm_200,2)?></td>

        <td style="text-align:left"><? $gm_500A=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010005 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_500A+=$gm_500A;  echo number_format($gm_500A,2)?></td>

        <td style="text-align:left"><? $gm_500H=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010008 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_500H+=$gm_500H; echo number_format($gm_500H,2)?></td>

        <td style="text-align:left"><? $gm_500ts=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010011 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_500ts+=$gm_500ts; echo number_format($gm_500ts,2)?></td>

        <td style="text-align:left"><? $gm_1000=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010006 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_1000+=$gm_1000; echo number_format($gm_1000,2)?></td>

        <td style="text-align:left"><? $gm_250D=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010012 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_250D+=$gm_250D; echo number_format($gm_250D,2)?></td>

        <td style="text-align:left"><? $gm_500D=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010007 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_gm_500D+=$gm_500D; echo number_format($gm_500D,2)?></td>

        <td style="text-align:left"><? $tea_bag=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010009 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_tea_bag+=$tea_bag;  echo number_format($tea_bag,2)?></td>

        <td style="text-align:left"><?php echo number_format(($tea_bag/8),2); $t_ctn=($tea_bag/8); $tot_t_ctn+=$t_ctn;?></td>

        <td style="text-align:left"><? $bag_in_bag=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010010 and chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id');  $tot_bag_in_bag+=$bag_in_bag; echo number_format($bag_in_bag,2)?></td>

        <td style="text-align:right"><?php echo number_format(($bag_in_bag/8),2); $b_ctn=($bag_in_bag/8); $tot_b_ctn+=$b_ctn;?></td>

        <td style="text-align:right"><? $item_kg= find_a_field('sale_do_chalan','sum(total_unit)',' chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn);

	

	//echo ' chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn.' group by item_id';  

	$tot_item_kg+=$item_kg;  echo number_format($item_kg,2);?></td>

        <td style="text-align:right"><? $amount=find_a_field('sale_do_chalan','sum(total_amt)',' chalan_date between "'.$from_date.'" and  "'.$to_date.'"'.$depot_conn);  $tot_amount+=$amount; echo number_format($amount,2)?></td>

      </tr>

      <?

} ?>

      <tr>

        <td>&nbsp;</td>

        <td><b>Total = </b></td>

        <td><span style="text-align:right"><strong><?php echo number_format($tot_gm_10,2); $gtot_gm_10+=$tot_gm_10;?></strong></span></td>

        <td><span style="text-align:right"><strong><?php echo number_format($tot_gm_50,2); $gtot_gm_50+=$tot_gm_50; ?></strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_100,2); $gtot_gm_100+=$tot_gm_100;?></strong></span></td>

		

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_200,2); $gtot_gm_200+=$tot_gm_200; ?></strong></span></td>

		

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_500A,2); $gtot_gm_500A+=$tot_gm_500A; ?></strong></span></td>

		

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_500H,2); $gtot_gm_500H+=$tot_gm_500H; ?></strong></span></td>

		

        <td style="text-align:right"><strong><?php echo number_format($tot_gm_500ts,2); $gtot_gm_500ts+=$tot_gm_500ts; ?></strong></td>

		

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_1000,2); $gtot_gm_1000+=$tot_gm_1000;?></strong></span></td>

		

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_250D,2); $gtot_gm_250D+=$tot_gm_250D;?></strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_gm_500D,2); $gtot_gm_500D+=$tot_gm_500D;?></strong></span></td>

		

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_tea_bag,2); $gtot_tea_bag+=$tot_tea_bag; ?></strong></span></td>

		

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_t_ctn,2); $gtot_t_ctn+=$tot_t_ctn; ?></strong></span></td>

		

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format($tot_bag_in_bag,2); $gtot_bag_in_bag+=$tot_bag_in_bag; ?></strong></span></td>

        <td style="text-align:right"><strong><?php echo number_format($tot_b_ctn,2); $gtot_b_ctn+=$tot_b_ctn; ?></strong></td>

        <td style="text-align:right"><strong><?php echo number_format($tot_item_kg,2); $gtot_item_kg+=$tot_item_kg; ?></strong></td>

        <td style="text-align:right"><strong><?php echo number_format($tot_amount,2); $gtot_amount+=$tot_amount; ?></strong></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

        <td><strong>Total(%)</strong> </td>

        <td><span style="text-align:right"><strong><?php echo number_format((($tot_gm_10/$tot_item_kg)*100),2); ?>% </strong></span></td>

        <td><span style="text-align:right"><strong><?php echo number_format((($tot_gm_50/$tot_item_kg)*100),2); ?>% </strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_100/$tot_item_kg)*100),2); ?>% </strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_200/$tot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_500A/$tot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_500H/$tot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:right"><strong><?php echo number_format((($tot_gm_500ts/$tot_item_kg)*100),2); ?>%</strong></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_1000/$tot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_250D/$tot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_gm_500D/$tot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_tea_bag/$tot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left">&nbsp;</td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($tot_bag_in_bag/$tot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:right">&nbsp;</td>

        <td style="text-align:right"><strong><?php echo number_format((($tot_item_kg/$tot_item_kg)*100),2);  ?>%</strong></td>

        <td style="text-align:right">&nbsp;</td>

      </tr>

      <? 

$tot_item_kg=0; $tot_gm_10=0; $tot_gm_50=0;  $tot_gm_100=0; $tot_gm_200=0; $tot_gm_500A=0; $tot_gm_500H=0;  $tot_gm_500ts=0;  $tot_gm_1000=0;  $tot_gm_500D=0; $tot_tea_bag=0; $tot_t_ctn=0; $tot_bag_in_bag=0; $tot_b_ctn=0; $tot_amount=0;

}

?>

      <tr>

        <td>&nbsp;</td>

        <td><b>Grand Total = </b></td>

        <td><span class="style1">

          <?=number_format($gtot_gm_10,2)?>

          </span> </td>

        <td><span class="style2">

          <?=number_format($gtot_gm_50,2)?>

          </span> </td>

        <td style="text-align:left"><span class="style3">

          <?=number_format($gtot_gm_100,2)?>

          </span> </td>

        <td style="text-align:left"><span class="style4">

          <?=number_format($gtot_gm_200,2)?>

          </span> </td>

        <td style="text-align:left"><span class="style5">

          <?=number_format($gtot_gm_500A,2)?>

          </span> </td>

        <td style="text-align:left"><span class="style6">

          <?=number_format($gtot_gm_500H,2)?>

          </span> </td>

        <td style="text-align:left"><span class="style24">

          <?=number_format($gtot_gm_500ts,2)?>

        </span></td>

        <td style="text-align:left"><span class="style7">

          <?=number_format($gtot_gm_1000,2)?>

          </span> </td>

        <td style="text-align:left"><span class="style8">

          <?=number_format($gtot_gm_250D,2)?>

        </span> </td>

        <td style="text-align:left"><span class="style8">

          <?=number_format($gtot_gm_500D,2)?>

          </span> </td>

        <td style="text-align:left"><span class="style9">

          <?=number_format($gtot_tea_bag,2)?>

          </span> </td>

        <td style="text-align:left"><span class="style10">

          <?=number_format($gtot_t_ctn,2)?>

          </span> </td>

        <td style="text-align:left"><span class="style13">

          <?=number_format($gtot_bag_in_bag,2)?>

          </span></td>

        <td style="text-align:right"><span class="style11">

          <?=number_format($gtot_b_ctn,2)?>

          </span> </td>

        <td style="text-align:right"><span class="style12">

          <?=number_format($gtot_item_kg,2)?>

          </span></td>

        <td style="text-align:right"><strong>

          <?=number_format($gtot_amount,2)?>

          </strong></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

        <td><b>Grand(%) </b></td>

        <td><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_10/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_50/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_100/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_200/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_500A/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_500H/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:right"><strong><?php echo number_format((($gtot_gm_500ts/$gtot_item_kg)*100),2); ?>%</strong></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_1000/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_250D/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_gm_500D/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_tea_bag/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:left">&nbsp;</td>

        <td style="text-align:left"><span style="text-align:right"><strong><?php echo number_format((($gtot_bag_in_bag/$gtot_item_kg)*100),2); ?>%</strong></span></td>

        <td style="text-align:right">&nbsp;</td>

        <td style="text-align:right"><strong><?php echo number_format((($gtot_item_kg/$gtot_item_kg)*100),2);  ?>%</strong></td>

        <td style="text-align:right">&nbsp;</td>

      </tr>

    </tbody>

  </table>

  <!--National Sales Statement (Item Wise)-->

  <? }







elseif($_POST['report']==1114){?>

  <!--SR Wise Contribution-->

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="16"><div class="header">

            <h1>M. Ahmed Tea & Lands Co. Ltd </h1>

            <h2>

              <?=$report?>

            </h2>

            <h2><b>SR Wise Contribution</b></h2>

          </div>

          <div class="left"></div>

          <div class="right"></div>

          <div class="header">

            <h2>DEPOT:

              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id)?>

            </h2>

            <h2>Date Interval:

              <?=$f_date?>

              -

              <?=$to_date?>

            </h2>

          </div>

          <div class="date">Reporting Time:

            <?=date("h:i A d-m-Y")?>

        </div></td>

      </tr>

      <tr>

        <td style="border:0px;" colspan="16"></td>

      </tr>

      <?



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) 			{$depot_con=' and c.depot_id="'.$depot_id.'"';}









if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con_in=' and chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

if(isset($depot_id)) 			{$depot_con_in=' and depot_id="'.$depot_id.'" and unit_price >0';}

$tot_in_con=$date_con_in.$depot_con_in;



 $sqleaa='select a.* from area a where 1';

$queryaa=db_query($sqleaa);

while($dataa=mysqli_fetch_object($queryaa)){



$sqle='select p.* from personnel_basic_info p, area a  where a.AREA_CODE='.$dataa->AREA_CODE.' and p.PBI_ID=a.sr_id and p.PBI_DESIGNATION in(5,6,8,10,11,12,13,61) and p.JOB_LOCATION='.$depot_id;

$query=db_query($sqle);

while($data=mysqli_fetch_object($query)){

//echo $data->PBI_ID;

?>

      <tr>

        <th bgcolor="#CCFFFF"><?=++$j?></th>

        <th colspan="15" bgcolor="#CCFFFF"><?=$data->PBI_NAME?></th>

      </tr>

      <tr>

        <th width="2%" bgcolor="#CCFFFF">&nbsp;</th>

        <th width="13%" bgcolor="#CCFFFF">Name Of Distributors</th>

        <th width="8%" bgcolor="#CCFFFF">Base Market </th>

        <th width="9%" bgcolor="#CCFFFF">Area </th>

        <th width="4%" bgcolor="#CCFFFF">10GM</th>

        <th width="5%" bgcolor="#CCFFFF">50Gm</th>

        <th width="5%" bgcolor="#CCFFFF">100GM</th>

        <th width="5%" bgcolor="#CCFFFF">200GM</th>

        <th width="7%" bgcolor="#CCFFFF">500GM(A)</th>

        <th width="6%" bgcolor="#CCFFFF">500Gm (H) </th>

        <th width="5%" bgcolor="#CCFFFF">1Kg</th>

        <th width="6%" bgcolor="#CCFFFF">500GM (D) </th>

        <th width="5%" bgcolor="#CCFFFF">Tea Bag </th>

        <th width="5%" bgcolor="#CCFFFF">Bag in Bag </th>

        <th width="5%" bgcolor="#CCFFFF">Total Kgs </th>

        <th width="10%" bgcolor="#CCFFFF">Amount</th>

      </tr>

    </thead>

    <tbody>

      <?php

	  

 $sqlea='select a.*, d.* from dealer_info d, area a where a.AREA_CODE=d.area_code and a.AREA_CODE='.$dataa->AREA_CODE.' and a.sr_id='.$data->PBI_ID;

$querya=db_query($sqlea);

while($datad=mysqli_fetch_object($querya)){?>

      <tr>

        <td><?=$datad->dealer_code?></td>

        <td><?=$datad->dealer_name_e?></td>

        <td><?=find_a_field('base_market','BASE_MARKET_NAME','BASE_MARKET_CODE='.$datad->basemarket_code)?></td>

        <td><?=find_a_field('area','AREA_NAME','AREA_CODE='.$datad->area_code)?></td>

        <td><? $gm_10=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010001 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id'); $tot_gm_10+=$gm_10; echo number_format($gm_10,2)?></td>

        <td><? $gm_50=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010002 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id'); $tot_gm_50+=$gm_50;  echo number_format($gm_50,2)?></td>

        <td style="text-align:left"><? $gm_100=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010003 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_100+=$gm_100;  echo number_format($gm_100,2)//echo 'sale_do_chalan','sum(total_unit)','item_id=1096000900010003 and dealer_code='.$data->dealer_code.$tot_in_con.' group by item_id';?></td>

        <td style="text-align:left"><? $gm_200=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010004 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_200+=$gm_200; echo number_format($gm_200,2)?></td>

        <td style="text-align:left"><? $gm_500A=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010005 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_500A+=$gm_500A;  echo number_format($gm_500A,2)?></td>

        <td style="text-align:left"><? $gm_500H=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010008 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_500H+=$gm_500H; echo number_format($gm_500H,2)?></td>

        <td style="text-align:left"><? $gm_1000=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010006 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_1000+=$gm_1000; echo number_format($gm_1000,2)?></td>

        <td style="text-align:left"><? $gm_500D=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010007 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id');  $tot_gm_500D+=$gm_500D; echo number_format($gm_500D,2)?></td>

        <td style="text-align:left"><? $tea_bag=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010009 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id');  $tot_tea_bag+=$tea_bag;  echo number_format($tea_bag,2)?></td>

        <td style="text-align:left"><? $bag_in_bag=find_a_field('sale_do_chalan','sum(total_unit)','item_id=1096000900010010 and dealer_code='.$datad->dealer_code.$tot_in_con.' group by item_id');  $tot_bag_in_bag+=$bag_in_bag; echo number_format($bag_in_bag,2)?></td>

        <td style="text-align:right"><? $item_kg=find_a_field('sale_do_chalan','sum(total_unit)',' dealer_code='.$datad->dealer_code.$tot_in_con);  $tot_item_kg+=$item_kg;  echo number_format($item_kg,2)?></td>

        <td style="text-align:right"><? $amount=find_a_field('sale_do_chalan','sum(total_amt)',' dealer_code='.$datad->dealer_code.$tot_in_con);  $tot_amount+=$amount; echo number_format($amount,2)?></td>

      </tr>

      <?

}



?>

      <tr>

        <td></td>

        <td colspan="3" align="right"><strong>TOTAL:</strong></td>

        <td><strong>

          <?=$tot_gm_10; $grnd_tot_gm_10+=$tot_gm_10;?>

        </strong></td>

        <td><strong>

          <?=$tot_gm_50; $grnd_tot_gm_50+=$tot_gm_50;?>

        </strong></td>

        <td style="text-align:left"><strong>

          <?=$tot_gm_100; $grnd_tot_gm_100+=$tot_gm_100;?>

        </strong></td>

        <td style="text-align:left"><strong>

          <?=$tot_gm_200; $grnd_tot_gm_200+=$tot_gm_200;?>

        </strong></td>

        <td style="text-align:left"><strong>

          <?=$tot_gm_500A; $grnd_tot_gm_500A+=$tot_gm_500A;?>

        </strong></td>

        <td style="text-align:left"><strong>

          <?=$tot_gm_500H; $grnd_tot_gm_500H+=$tot_gm_500H;?>

        </strong></td>

        <td style="text-align:left"><strong>

          <?=$tot_gm_1000; $grnd_tot_gm_1000+=$tot_gm_1000;?>

        </strong></td>

        <td style="text-align:left"><strong>

          <?=$tot_gm_500D; $grnd_tot_gm_500D+=$tot_gm_500D;?>

        </strong></td>

        <td style="text-align:left"><strong>

          <?=$tot_tea_bag; $grnd_tot_tea_bag+=tot_tea_bag;?>

        </strong></td>

        <td style="text-align:left"><strong>

          <?=$tot_bag_in_bag; $grnd_tot_bag_in_bag+=$tot_bag_in_bag;?>

        </strong></td>

        <td style="text-align:right"><strong>

          <?=$tot_item_kg; $grnd_tot_item_kg+=$tot_item_kg;?>

        </strong></td>

        <td style="text-align:right"><strong>

          <?=$tot_amount; $grnd_tot_amount+=$tot_amount;?>

        </strong></td>

      </tr>

      <tr>

        <td></td>

        <td colspan="15">&nbsp;</td>

      </tr>

      <? 

 $tot_gm_10=0; $tot_gm_50=0; $tot_gm_100=0; $tot_gm_200=0; $tot_gm_500A=0; $tot_gm_500H=0; $tot_gm_1000=0; $tot_gm_500D=0; $tot_tea_bag=0; $tot_bag_in_bag=0; $tot_item_kg=0; $tot_amount=0;

}

}

?>

      <tr>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td><b>

          <?=number_format($grnd_tot_gm_10,2)?>

        </b></td>

        <td><b>

          <?=number_format($grnd_tot_gm_50,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($grnd_tot_gm_100,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($grnd_tot_gm_200,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($grnd_tot_gm_500A,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($grnd_tot_gm_500H,2)?>

          </b></td>

        <td style="text-align:left"><b>

          <?=number_format($grnd_tot_gm_1000,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($grnd_tot_gm_500D,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($grnd_tot_tea_bag,2)?>

        </b></td>

        <td style="text-align:left"><b>

          <?=number_format($grnd_tot_bag_in_bag,2)?>

        </b></td>

        <td style="text-align:right"><b>

          <?=number_format($grnd_tot_item_kg,2)?>

        </b></td>

        <td style="text-align:right"><b>

          <?=number_format($grnd_tot_amount,2)?>

        </b></td>

      </tr>

    </tbody>

  </table>

  <!--SR Wise Contribution-->

  <? }











elseif($_POST['report']==2) 



{



?>

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="7"><?=$str?>

          <center>

          </center>

          <div class="right"></div>

          <div class="date">Reporting Time:

            <?=date("h:i A d-m-Y")?>

        </div></td>

      </tr>

      <tr>

        <th>S/L</th>

        <th>Fg Code </th>

        <th>Item Name</th>

        <th>Unit</th>

        <th>D Price </th>

        <th>Order Kgs</th>

        <th>Chalan Kgs </th>

        <th style="text-align:center;">Sale Amount</th>

        <th style="text-align:center;">Receivable Amount</th>

      </tr>

    </thead>

    <tbody>

      <?



$query = db_query($sql);



while($data=mysqli_fetch_object($query)){



$payable = $data->actual_price - ((($citem[$data->item_id])*(-1)) + (($ditem[$data->item_id])));



$payable_total = $payable_total + $payable;



$dis_total = $dis_total + (($citem[$data->item_id])*(-1));



$dis_total2 = $dis_total2 + (($ditem[$data->item_id]));



$actual_total = $actual_total + $data->actual_price;







?>

      <tr>

        <td><?=++$s?></td>

        <td><?=$data->fg?></td>

        <td><?=$data->item_name?></td>

        <td><?=$data->unit?></td>

		 <? if($_POST['depot_id']==1){?>

        <td><?=number_format($data->s_price,2)?></td>

		 <? }?>

		  <? if($_POST['depot_id']==2){?>

		<td><?=number_format($data->c_price,2)?></td>

		<? }?>

		 <? if($_POST['depot_id']==3){?>

		<td><?=number_format($data->d_price,2)?></td>

		<? }?>

		<? if($_POST['depot_id']==""){?>

		<td><?=number_format($data->sale_price,2)?></td>

		<? }?>

		

        <td><?=number_format($data->pcs,2); $ord_qty+=$data->pcs;?></td>

        <td><?=number_format($data->qty,2); $tot_qty+=$data->qty;?></td>

        <td style="text-align:right"><?=number_format($data->actual_price,2)?></td>

        <td style="text-align:right"><?=number_format($payable,2)?></td>

      </tr>

      <?



}



?>

      <tr class="footer">

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td><?=number_format($ord_qty,2).' Kgs'?>

        &nbsp;</td>

        <td><?=number_format($tot_qty,2).' Kgs'?>

        &nbsp;</td>

        <td style="text-align:right"><?=number_format($actual_total,2)?></td>

        <td style="text-align:right"><?=number_format($payable_total,2)?></td>

      </tr>

    </tbody>

  </table>

  <?



}













elseif($_POST['report']==1115) 



{



?>

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="7"><?=$str?>

          <center>

          </center>

          <div class="right"></div>

          <div class="date">Reporting Time:

            <?=date("h:i A d-m-Y")?>

          </div></td>

      </tr>

      <tr>

        <th>S/L</th>

        <th>Fg Code </th>

        <th>Item Name</th>

        <th>Unit</th>

        <th>D Price </th>

        <th>Order Kgs</th>

        <th>Chalan Kgs </th>

        <th style="text-align:center;">Gift Amount</th>

      </tr>

    </thead>

    <tbody>

      <?



$query = db_query($sql);



while($data=mysqli_fetch_object($query)){



$payable = $data->actual_price - ((($citem[$data->item_id])*(-1)) + (($ditem[$data->item_id])));



$payable_total = $payable_total + $payable;



$dis_total = $dis_total + (($citem[$data->item_id])*(-1));



$dis_total2 = $dis_total2 + (($ditem[$data->item_id]));



$actual_total = $actual_total + $data->actual_price;



$gift_amt = ($data->dealer_price*$data->qty);



$tot_gift_amt += $gift_amt;



?>

      <tr>

        <td><?=++$s?></td>

        <td><?=$data->fg?></td>

        <td><?=$data->item_name?></td>

        <td><?=$data->unit?></td>

        <td><?=number_format($data->dealer_price,2)?></td>

        <td><?=number_format($data->pcs,4); $ord_qty+=$data->pcs;?></td>

        <td><?=number_format($data->qty,4); $tot_qty+=$data->qty;?></td>

        <td style="text-align:right"><?=number_format($gift_amt,2)?></td>

      </tr>

      <?



}



?>

      <tr class="footer">

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td><?=number_format($ord_qty,2).' Kgs'?>

          &nbsp;</td>

        <td><?=number_format($tot_qty,2).' Kgs'?>

          &nbsp;</td>

        <td style="text-align:right"><?=number_format($tot_gift_amt,2)?></td>

      </tr>

    </tbody>

  </table>

  <?



}









elseif($_POST['report']==101)



{



if(isset($product_group))	{$pg_con=' and d.product_group="'.$product_group.'"';} 



$sqld="select c.chalan_no,m.do_no,m.do_date,c.driver_name as serial_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,d.product_group as grp,sum(total_amt) as total_amt from 



sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w



where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con." group by chalan_no order by c.chalan_no";



$query = db_query($sqld);



?>

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="8"><?=$str?></td>

      </tr>

      <tr>

        <th>S/L</th>

        <th>Do Date</th>

        <th>Do No</th>

        <th>Chalan Date</th>

        <th>Chalan No</th>

        <th>Serial No</th>

        <th>Dealer Name</th>

        <th>Depot</th>

        <th>Grp</th>

        <th>DP Total</th>

        <th>Discount</th>

        <th>Sale Total</th>

      </tr>

    </thead>

    <tbody>

      <? 







while($data=mysqli_fetch_object($query)){$s++;



//$sqld = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no;



//$info = mysqli_fetch_row(db_query($sqld));







$sqld1 = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no.' and total_amt>0';



$info1 = mysqli_fetch_row(db_query($sqld1));



$info[0] = $data->total_amt;



$rcv_t = $rcv_t+$data->rcv_amt;



$dp_t = $dp_t+$info[0];



$tp_t = $tp_t+$info1[0];



?>

      <tr>

        <td><?=$s?></td>

        <td><?=$data->do_date?></td>

        <td><?=$data->do_no?></td>

        <td><?=$data->chalan_date?></td>

        <td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank">

          <?=$data->chalan_no?>

        </a></td>

        <td><?=$data->serial_no?></td>

        <td><?=$data->dealer_name?></td>

        <td><?=$data->depot?></td>

        <td><?=$data->grp?></td>

        <td><?=number_format($info1[0],2);?></td>

        <td><?=number_format(($info[0]-$info1[0]),2);?></td>

        <td><?=number_format($info[0],2)?></td>

      </tr>

      <?



}



?>

      <tr class="footer">

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td>&nbsp;</td>

        <td><?=number_format($dp_t,2)?></td>

        <td><?=number_format(($dp_t-$tp_t),2)?></td>

        <td><?=number_format(($tp_t),2)?></td>

      </tr>

    </tbody>

  </table>

  <?







}






elseif($_POST['report']==1) 



{



if(isset($area_id)) 		{$area_con=' and d.area_code="'.$area_id.'"';}



 $sqls="select c.chalan_no,m.do_no,c.driver_name as serial_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,a.AREA_NAME as area,    z.ZONE_NAME as zone, r.BRANCH_NAME as region, w.warehouse_name as depot,sum(total_amt) as total_amt from 



sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w, area a, zon z, branch r



where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id  and a.AREA_CODE=d.area_code and z.ZONE_CODE=a.ZONE_ID and r.BRANCH_ID=z.REGION_ID ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con.$area_con.$zone_con.$region_con." group by chalan_no order by c.chalan_no";







$query = db_query($sqls);



echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Chalan No</th><th>Do No</th><th>Serial No</th><th>Chalan Date</th><th>Dealer Name</th><th>Area</th><th>Zone</th><th>Region</th><th>Depot</th><th>Sales Total</th><th>Dis</th><th>Actual Sales</th></tr></thead>



<tbody>';



while($data=mysqli_fetch_object($query)){$s++;



//$sqld = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no;



//$info = mysqli_fetch_row(db_query($sqld));







$sqld1 = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no.' and unit_price<0 ';



$info1 = mysqli_fetch_row(db_query($sqld1));



$info[0] = $data->total_amt;



$rcv_t = $rcv_t+$data->rcv_amt;



$dp_t = $dp_t+$info[0];



$tp_t = $tp_t+$info1[0];



?>

  <tr>

    <td><?=$s?></td>

    <td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank">

      <?=$data->chalan_no?>

    </a></td>

    <td><?=$data->do_no?></td>

    <td><?=$data->serial_no?></td>

    <td><?=date("d-m-Y",strtotime($data->chalan_date));?></td>

    <td><?=$data->dealer_name?></td>

    <td><?=$data->area?></td>

    <td><?=$data->zone?></td>

    <td><?=$data->region?></td>

    <td><?=$data->depot?></td>

    <td><?=number_format(($info[0]-$info1[0]),2);?></td>

    <td><?=number_format(($info1[0]*(-1)),2);?></td>

    <td><?=number_format(($info[0]),2);?></td>

  </tr>

  <?



}



?>

  <tr class="footer">

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><?=number_format(($dp_t-$tp_t),2)?></td>

    <td><?=number_format(((-1)*$tp_t),2)?></td>

    <td><?=number_format($dp_t,2)?></td>

  </tr>

  </tbody>

  </table>

  <?



}















elseif($_POST['report']==1001) 



{



if(isset($area_id)) 		{$area_con=' and d.area_code="'.$area_id.'"';}



echo $sqls="select c.chalan_no,m.do_no,c.memo_no as memo_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name, a.AREA_NAME as area,w.warehouse_name as depot,sum(total_amt) as total_amt from 



sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w, area a



where  m.do_no=c.do_no and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and a.AREA_CODE=d.area_code ".$depot_con.$date_con.$pg_con.$dealer_con.$dealer_type_con.$area_con." and c.vat_approval='Yes' group by chalan_no order by c.chalan_no";







$query = db_query($sqls);



echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Chalan No</th><th>Do No</th><th>Memo No</th><th>Chalan Date</th><th>Dealer Name</th><th>Area</th><th>Depot</th><th>Sales Total</th><th>Dis</th><th>Actual Sales</th></tr></thead>



<tbody>';



while($data=mysqli_fetch_object($query)){$s++;



//$sqld = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no;



//$info = mysqli_fetch_row(db_query($sqld));







$sqld1 = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no.' and unit_price<0 ';



$info1 = mysqli_fetch_row(db_query($sqld1));



$info[0] = $data->total_amt;



$rcv_t = $rcv_t+$data->rcv_amt;



$dp_t = $dp_t+$info[0];



$tp_t = $tp_t+$info1[0];



?>

  <tr>

    <td><?=$s?></td>

    <td><a href="chalan_view_vat.php?v_no=<?=$data->chalan_no?>" target="_blank">

      <?=$data->chalan_no?>

    </a></td>

    <td><?=$data->do_no?></td>

    <td><?=$data->memo_no?></td>



    <td><?=date("d-m-Y",strtotime($data->chalan_date));?></td>

    <td><?=$data->dealer_name?></td>

    <td><?=$data->area?></td>

    <td><?=$data->depot?></td>

    <td><?=number_format(($info[0]-$info1[0]),2);?></td>

    <td><?=number_format(($info1[0]*(-1)),2);?></td>

    <td><?=number_format(($info[0]),2);?></td>

  </tr>

  <?



}



?>

  <tr class="footer">

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><?=number_format(($dp_t-$tp_t),2)?></td>

    <td><?=number_format(((-1)*$tp_t),2)?></td>

    <td><?=number_format($dp_t,2)?></td>

  </tr>

  </tbody>

  </table>

  <?



}























elseif($_POST['report']==1005) 



{



			if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



			elseif(isset($item_id)) 			{$item_sub_con=' and i.item_id='.$item_id;} 



			



			if(isset($product_group)) 			{$product_group_con=' and i.sales_item_type="'.$product_group.'"';} 



			



			if(isset($t_date)) 



			{$to_date=$t_date; $fr_date=$f_date; $date_con=' and ji_date <="'.$to_date.'"';}



		



		



		$sql='select distinct i.item_id,i.unit_name,i.item_name,"Finished Goods",i.finish_goods_code,i.sales_item_type,i.item_brand,i.pack_size 



		   from item_info i where i.finish_goods_code!=2000 and i.sub_group_id="1096000100010000" '.$item_sub_con.$product_group_con.' and i.item_brand = "Promotional" order by i.sales_item_type';



		   



		$query =db_query($sql);



?>

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;" colspan="9"><div class="header">

            <h1>M. Ahmed Tea & Lands Co. Ltd</h1>

            <h2>

              <?=$report?>

            </h2>

            <h2>Closing Stock of Date-

              <?=$to_date?>

            </h2>

          </div>

          <div class="left"></div>

          <div class="right"></div>

          <div class="date">Reporting Time:

            <?=date("h:i A d-m-Y")?>

        </div></td>

      </tr>

      <tr>

        <th>S/L</th>

        <th>Brand</th>

        <th>FG</th>

        <th>Item Name</th>

        <th>Group</th>

        <th>Unit</th>

        <th>Dhaka</th>

        <th>Gazipur</th>

        <th>Chittagong</th>

        <th>Borisal</th>

        <th>Bogura</th>

        <th>Sylhet</th>

        <th>Jessore</th>

        <th>Total</th>

      </tr>

    </thead>

    <tbody>

      <?



while($data=mysqli_fetch_object($query)){











	$dhaka = 	(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="3"')/$data->pack_size);



	$ctg = 		(int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="6"')/$data->pack_size);



	$sylhet =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"')/$data->pack_size);



	$bogura =   (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="7"')/$data->pack_size);



	$borisal =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="8"')/$data->pack_size);



	$jessore =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="10"')/$data->pack_size);



	$gajipur =  (int)(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="54"')/$data->pack_size);



	$total = 	$dhaka + $ctg + $sylhet + $bogura + $borisal + $jessore + $gajipur;	      



	



	//echo $sql = 'select sum(item_in-item_ex) from journal_item where item_id="'.$data->item_id.'"'.$date_con.' and warehouse_id="9"';







?>

      <tr>

        <td><?=++$j?></td>

        <td><?=$data->item_brand?></td>

        <td><?=$data->finish_goods_code?></td>

        <td><?=$data->item_name?></td>

        <td><?=$data->sales_item_type?></td>

        <td><?=$data->unit_name?></td>

        <td style="text-align:right"><?=(int)$dhaka?></td>

        <td style="text-align:right"><?=(int)$gajipur?></td>

        <td style="text-align:right"><?=(int)$ctg?></td>

        <td style="text-align:right"><?=(int)$borisal?></td>

        <td style="text-align:right"><?=(int)$bogura?></td>

        <td style="text-align:right"><?=(int)$sylhet?></td>

        <td style="text-align:right"><?=(int)$jessore?></td>

        <td style="text-align:right"><?=(int)$total?>

        &nbsp;</td>

      </tr>

      <?



}



		



?>

    </tbody>

  </table>

  <?







}







elseif($_POST['report']==111) 



{



$sql="select distinct c.chalan_no , m.do_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot from 



sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w



where m.status in ('CHECKED','COMPLETED') and m.do_no=c.do_no  and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and d.dealer_type = 'Corporate'".$depot_con.$date_con.$pg_con.$dealer_con." order by m.do_date,m.do_no";



$query = db_query($sql);



echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Chalan No</th><th>Do No</th><th>Chalan Date</th><th>Dealer Name</th><th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th></tr></thead>



<tbody>';



while($data=mysqli_fetch_object($query)){$s++;



$sqld = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no;



$info = mysqli_fetch_row(db_query($sqld));



$dp_t = $dp_t+$info[0];



$dis = find_a_field('sale_do_master','sp_discount','do_no="'.$data->do_no.'"');



$tod = ($info[0]*$dis)/100;



$tot = $info[0]-($info[0]*$dis)/100;



$tod_t = $tod_t + $tod;



$tot_t = $tot_t + $tot;



?>

  <tr>

    <td><?=$s?></td>

    <td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank">

      <?=$data->chalan_no?>

    </a></td>

    <td><?=$data->do_no?></td>

    <td><?=$data->chalan_date?></td>

    <td><?=$data->dealer_name?></td>

    <td><?=$data->depot?></td>

    <td><?=$info[0]?></td>

    <td><?=$tod?></td>

    <td><?=$tot?></td>

  </tr>

  <?



}



echo '<tr class="footer"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.number_format($dp_t,2).'</td><td>'.number_format($tod_t,2).'</td><td>'.number_format($tot_t,2).'</td></tr></tbody></table>';







}



elseif($_POST['report']==112) 



{



$sql="select c.chalan_no , m.do_no,c.chalan_date,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot,sum(total_amt) as total_amt from 



sale_do_master m,sale_do_chalan c,dealer_info d  , warehouse w



where m.status in ('CHECKED','COMPLETED') and m.do_no=c.do_no  and m.dealer_code=d.dealer_code and w.warehouse_id=c.depot_id and d.dealer_type = 'SuperShop'".$depot_con.$date_con.$pg_con.$dealer_con." group by chalan_no order by chalan_no";



$query = db_query($sql);



echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="9">'.$str.'</td></tr><tr><th>S/L</th><th>Chalan No</th><th>Do No</th><th>Chalan Date</th><th>Dealer Name</th><th>Depot</th><th>Total</th><th>Discount</th><th>Net Total</th></tr></thead>



<tbody>';



while($data=mysqli_fetch_object($query)){$s++;



$sqld1 = 'select sum(total_amt) from sale_do_chalan  where chalan_no='.$data->chalan_no.' and total_amt>0';



$info1 = mysqli_fetch_row(db_query($sqld1));



$info[0] = $data->total_amt;







$rcv_t = $rcv_t+$data->rcv_amt;



$dp_t = $dp_t+$info[0];



$tp_t = $tp_t+$info1[0];



?>

  <tr>

    <td><?=$s?></td>

    <td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank">

      <?=$data->chalan_no?>

    </a></td>

    <td><?=$data->do_no?></td>

    <td><?=$data->chalan_date?></td>

    <td><?=$data->dealer_name?></td>

    <td><?=$data->depot?></td>

    <td><?=number_format(($info1[0]),2)?></td>

    <td><?=number_format(($info[0]-$info1[0]),2)?></td>

    <td><?=number_format($info[0],2)?></td>

  </tr>

  <?



}



?>

  <tr class="footer">

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td><?=number_format(($tp_t),2)?></td>

    <td><?=number_format(($dp_t-$tp_t),2)?></td>

    <td><?=number_format($dp_t,2)?></td>

  </tr>

  </tbody>

  </table>

  <? 







}





elseif($_POST['report']==30) 



{

$sql2 	= "select concat(i.finish_goods_code,'- ',item_name) as item_name,c.pkt_unit as crt,c.dist_unit as pcs,c.total_amt as DP_Total,(o.t_price*c.total_unit) as TP_Total, (i.c_price*c.total_unit) as CRP_Total, o.do_no,c.chalan_no as chalan_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,c.chalan_date as do_date,d.address_e,d.mobile_no from 



sale_do_master m,sale_do_details o,sale_do_chalan c, item_info i,dealer_info d , warehouse w



where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and c.order_no = o.id and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=c.depot_id ".$date_con.$item_con.$depot_con.$dtype_con.$pg_con.$dealer_con.$do_con.$item_brand_con;







$query2 = db_query($sql2);



echo '<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><th>S/L</th><th>Chalan Date</th><th>Item Name</th><th>Dealer Name</th><th>Do No</th><th>Chalan No</th><th>Depot</th><th>Kg</th><th>DP Total</th><th>TP Total</th></tr></thead>



<tbody>';

$s=0;

while($data=mysqli_fetch_object($query2)){



$s++;



	$dealer_code = $data->dealer_code;



	$chalan_no = $data->chalan_no;



	$dealer_name = $data->dealer_name_e;



	$warehouse_name = $data->warehouse_name;



	$do_date = $data->do_date;



	$do_no = $data->do_no;

	

	$tot_pcs+=$data->pcs;

	

	$tot_dp+= ($data->team_name=='Corporate')?$data->CRP_Total:$data->DP_Total;

	

	$tot_tp+=$data->TP_Total;



		if($dealer_code>0) 



{?>

  <tr>

    <td><?=$s?></td>

    <td><?=$data->do_date?></td>

    <td><?= $data->item_name?></td>

    <td><?=$data->dealer_name_e?></td>

    <td><?=$data->do_no?></td>

    <td><a href="chalan_view.php?v_no=<?=$data->chalan_no?>" target="_blank">

      <?=$data->chalan_no?>

    </a></td>

    <td><?=$data->warehouse_name?></td>

    <td><?=$data->pcs?></td>

    <td><?= ($data->team_name=='Corporate')?$data->CRP_Total:$data->DP_Total;?></td>

    <td><?=number_format($data->TP_Total,2)?></td>

  </tr>

  <? }









}?>

  <tr>

    <td></td>

    <td></td>

    <td></td>

    <td></td>

    <td></td>

    <td></a></td>

    <td>Total:</td>

    <td><?php  echo $tot_pcs?></td>

    <td><?php  echo $tot_dp;?></td>

    <td><?php  echo number_format($tot_tp,2);?></td>

  </tr>

  <? }









elseif($_POST['report']==3) 



{



$sql2 	= "select distinct o.do_no,c.chalan_no as chalan_no, d.dealer_code,d.dealer_name_e,w.warehouse_name,c.chalan_date as do_date,d.address_e,d.mobile_no,d.team_name from 



sale_do_master m,sale_do_details o,sale_do_chalan c, item_info i,dealer_info d , warehouse w



where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and c.order_no = o.id and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=c.depot_id ".$date_con.$item_con.$depot_con.$dtype_con.$pg_con.$dealer_con.$con;



$query2 = db_query($sql2);







while($data=mysqli_fetch_object($query2)){



echo '<div style="position:relative;display:block; width:100%; page-break-after:always; page-break-inside:avoid">';



	$dealer_code = $data->dealer_code;



	$chalan_no = $data->chalan_no;



	$dealer_name = $data->dealer_name_e;



	$warehouse_name = $data->warehouse_name;



	$do_date = $data->do_date;



	$do_no = $data->do_no;



		if($dealer_code>0) 



{



$str 	.= '<p style="width:100%">Dealer Name: '.$dealer_name.' - '.$dealer_code.'('.$data->team_name.')</p>';



$str 	.= '<p style="width:100%">Chalan NO: '.$chalan_no.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:'.$do_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DO NO: '.$do_no.' 



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Depot:'.$warehouse_name.'</p>



<p style="width:100%">Destination:'.$data->address_e.'('.$data->mobile_no.')</p>';







$dealer_con = ' and m.dealer_code='.$dealer_code;



$do_con = ' and m.do_no='.$do_no;



$sql = "select concat(i.finish_goods_code,'- ',item_name) as item_name,c.pkt_unit as crt,c.dist_unit as Kgs,c.total_amt as DP_Total,(o.t_price*c.total_unit) as TP_Total from 



sale_do_master m,sale_do_details o,sale_do_chalan c, item_info i,dealer_info d , warehouse w



where c.chalan_no='".$chalan_no."' and c.order_no = o.id and m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=c.depot_id ".$date_con.$item_con.$depot_con.$dtype_con.$do_con.$item_brand_con." order by m.do_date desc";



}







	echo report_create($sql,1,$str);



		$str = '';



		echo '</div>';



}



}



elseif($_POST['report']==5) 



{



if(isset($region_id)) 



$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;



else



$sqlbranch 	= "select * from branch";



$querybranch = db_query($sqlbranch);



while($branch=mysqli_fetch_object($querybranch)){



	$rp=0;



	echo '<div>';



if(isset($zone_id)) 



$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;



else



$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;







	$queryzone = db_query($sqlzone);



	while($zone=mysqli_fetch_object($queryzone)){



if($area_id>0) 



$area_con = "and a.AREA_CODE=".$area_id;



$sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 



sale_do_master m,dealer_info d  , area a



where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code  and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con." order by do_no";



$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 



sale_do_master m,dealer_info d  , area a,sale_do_details s



where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con.$area_con;







		$queryt = db_query($sqlt);



		$t= mysqli_fetch_object($queryt);



		if($t->total>0)



		{



			if($rp==0) {$reg_total=0;$dp_total=0; $str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}



			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';



			echo report_create($sql,1,$str);



			$str = '';



			



			$reg_total= $reg_total+$t->total;



			$dp_total= $dp_total+$t->dp_total;



		}







	}



	



			if($rp>0){



?>

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;"></td>

      </tr>

    </thead>

    <tbody>

      <tr class="footer">

        <td align="right"><?=$branch->BRANCH_NAME?>

          Region  DP Total:

          <?=number_format($dp_total,2)?>

          ||| TP Total:

          <?=number_format($reg_total,2)?></td>

      </tr>

    </tbody>

  </table>

  <br />

  <br />

  <br />

  <?  }



	echo '</div>';



}















}



elseif($_POST['report']==9) 



{



if(isset($region_id)) 



$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;



else



$sqlbranch 	= "select * from branch";



$querybranch = db_query($sqlbranch);



while($branch=mysqli_fetch_object($querybranch)){



$rp=0;



echo '<div>';



if(isset($zone_id))



$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;



else



$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;







	$queryzone = db_query($sqlzone);



	while($zone=mysqli_fetch_object($queryzone)){



if($area_id>0) 



$area_con = "and a.AREA_CODE=".$area_id;







$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,



floor(sum(o.total_unit)/o.pkt_size) as crt,



mod(sum(o.total_unit),o.pkt_size) as pcs, 



sum(o.total_amt) as DP,



sum(o.total_unit*o.t_price) as TP



from 



sale_do_master m,sale_do_details o, item_info i, dealer_info d, area a



where m.do_no=o.do_no and m.dealer_code=d.dealer_code  and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.' group by i.finish_goods_code';







$sqlt="select sum(o.t_price*o.total_unit) as total,sum(total_amt) as dp_total



from 



sale_do_master m,sale_do_details o, item_info i, dealer_info d, area a



where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id and a.AREA_CODE=d.area_code  and m.status in ('CHECKED','COMPLETED') and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$item_con.$item_brand_con.$pg_con.$area_con.'';







		$queryt = db_query($sqlt);



		$t= mysqli_fetch_object($queryt);



		if($t->total>0)



		{



			if($rp==0) {$reg_total=0;$dp_total=0; 



			$str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}



			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';



			echo report_create($sql,1,$str);



			$str = '';



			



			$reg_total= $reg_total+$t->total;



			$dp_total= $dp_total+$t->dp_total;



		}







	}



	



			if($rp>0){



?>

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;"></td>

      </tr>

    </thead>

    <tbody>

      <tr class="footer">

        <td align="right"><?=$branch->BRANCH_NAME?>

          Region  DP Total:

          <?=number_format($dp_total,2)?>

          ||| TP Total:

          <?=number_format($reg_total,2)?></td>

      </tr>

    </tbody>

  </table>

  <br />

  <br />

  <br />

  <?  }



	echo '</div>';



}















}



elseif($_POST['report']==8) 



{



if(isset($region_id)) 



$sqlbranch 	= "select * from branch where BRANCH_ID=".$region_id;



else



$sqlbranch 	= "select * from branch";



$querybranch = db_query($sqlbranch);



while($branch=mysqli_fetch_object($querybranch)){



	$rp=0;



	echo '<div>';



if(isset($zone_id)) 



$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID." and ZONE_CODE=".$zone_id;



else



$sqlzone 	= "select * from zon where REGION_ID=".$branch->BRANCH_ID;







	$queryzone = db_query($sqlzone);



	while($zone=mysqli_fetch_object($queryzone)){



if(isset($area_id)) 



{



$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 



sale_do_master m,dealer_info d  , area a



where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." and a.AREA_CODE=".$area_id." ".$date_con.$pg_con." order by do_no";



$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 



sale_do_master m,dealer_info d  ,area a,sale_do_details s



where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.AREA_CODE=".$area_id." and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;



}



else



{



$sql="select concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,a.AREA_NAME as area,d.product_group as grp,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,(select sum(t_price*total_unit) from sale_do_details where do_no=m.do_no)  as TP_Total from 



sale_do_master m,dealer_info d  , area a



where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and a.AREA_CODE=d.area_code and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con." order by do_no";



$sqlt="select sum(s.t_price*s.total_unit) as total,sum(total_amt) as dp_total from 



sale_do_master m,dealer_info d  , warehouse w,area a,sale_do_details s



where  m.status in ('CHECKED','COMPLETED') and m.dealer_code=d.dealer_code and w.warehouse_id=d.depot and a.AREA_CODE=d.area_code and s.do_no=m.do_no and a.ZONE_ID=".$zone->ZONE_CODE." ".$date_con.$pg_con;



}



		$queryt = db_query($sqlt);



		$t= mysqli_fetch_object($queryt);



		if($t->total>0)



		{



			if($rp==0) {$reg_total=0;$dp_total=0; $str .= '<p style="width:100%">Region Name: '.$branch->BRANCH_NAME.' Region</p>';$rp++;}



			$str .= '<p style="width:100%">Zone Name: '.$zone->ZONE_NAME.' Zone</p>';



			echo report_create($sql,1,$str);



			$str = '';



			



			$reg_total= $reg_total+$t->total;



			$dp_total= $dp_total+$t->dp_total;



		}







	}



	



			if($rp>0){



?>

  <table width="100%" cellspacing="0" cellpadding="2" border="0">

    <thead>

      <tr>

        <td style="border:0px;"></td>

      </tr>

    </thead>

    <tbody>

      <tr class="footer">

        <td align="right"><?=$branch->BRANCH_NAME?>

          Region  DP Total:

          <?=number_format($dp_total,2)?>

          ||| TP Total:

          <?=number_format($reg_total,2)?></td>

      </tr>

    </tbody>

  </table>

  <br />

  <br />

  <br />

  <?  }



	echo '</div>';



}















}



elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}



?>

</div>

</body>

</html>

