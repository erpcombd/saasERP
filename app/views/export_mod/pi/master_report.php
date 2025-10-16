<?
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//
//require "../../../assets/engine/tools/check.php";
//
//
//
//require "../../../assets/engine/configure/db_connect.php";
//
//
//
//
//require "../../../assets/engine/tools/my.php";
//
//
//
//
//
//
//
//require "../../../assets/engine/tools/report.class.php";
//

date_default_timezone_set('Asia/Dhaka');

if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)


{


	if((strlen($_REQUEST['t_date'])==10))


	{


		$t_date=$_REQUEST['t_date'];

		$f_date=$_REQUEST['f_date'];


	}


if($_REQUEST['product_group']!='')  $product_group=$_REQUEST['product_group'];



if($_REQUEST['item_brand']!='') 	$item_brand=$_REQUEST['item_brand'];



if($_REQUEST['item_id']>0) 		    $item_id=$_REQUEST['item_id'];



if($_REQUEST['dealer_code']>0) 	    $dealer_code=$_REQUEST['dealer_code'];



if($_REQUEST['dealer_type']!='') 	$dealer_type=$_REQUEST['dealer_type'];

if($_REQUEST['status']!='') 		$status=$_REQUEST['status'];



if($_REQUEST['do_no']!='') 		    $do_no=$_REQUEST['do_no'];



if($_REQUEST['area_id']!='') 		$area_id=$_REQUEST['area_id'];



if($_REQUEST['zone_id']!='') 		$zone_id=$_REQUEST['zone_id'];



if($_REQUEST['region_id']>0) 		$region_id=$_REQUEST['region_id'];



if($_REQUEST['depot_id']!='') 		$depot_id=$_REQUEST['depot_id'];







$item_info = find_all_field('item_info','','item_id='.$item_id);







if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 



if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 



 



if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 		



{



if($product_group=='ABCD')



$pg_con=' and d.product_group!="M"';



else



$pg_con=' and d.product_group="'.$product_group.'"';



} 



if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'" ';}



 







if(isset($dealer_code)) 		{$dealer_con=' and m.dealer_code='.$dealer_code;} 



if(isset($item_id))				{$item_con=' and i.item_id='.$item_id;} 



if(isset($depot_id)) 			{$depot_con=' and d.depot="'.$depot_id.'"';} 



//if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 



//if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 



//if(isset($zone_id)) 			{$zone_con=' and a.buyer_id='.$zone_id;}



//if(isset($region_id)) 		{$region_con=' and d.id='.$region_id;}



//if(isset($item_id)) 			{$item_con=' and b.item_id='.$item_id;} 



//if(isset($status)) 			{$status_con=' and a.status="'.$status.'"';} 



//if(isset($do_no)) 			{$do_no_con=' and a.do_no="'.$do_no.'"';} 



//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $order_con=' and o.order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



//if(isset($t_date)) 			{$to_date=$t_date; $fr_date=$f_date; $chalan_con=' and c.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







switch ($_REQUEST['report']) {



    case 1:



	$report="Delivery Order Summary Brief";



	break;

	

	case 2001:



	$report="Sales Commission Report";



	break;



    case 1999:



	$report="DO Report for Scratch Card";



	$product_group = 'A';



	break;



case 2002:



		$report="Last Year Vs This Year Item Wise Sales Report (Periodical)";



		if(isset($t_date)) {



		$to_date=$t_date; $fr_date=$f_date; 



		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));



		$yto_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($t_date));



		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';



		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';



		}



		if(isset($depot_id)) 			{$con.=' and d.depot="'.$depot_id.'"';}



		if(isset($dealer_code)) 		{$con.=' and d.dealer_code="'.$dealer_code.'"';} 



		if(isset($dealer_type)) 		{$con.=' and d.dealer_type="'.$dealer_type.'"';}



		if(isset($product_group)) 		{$pg_con=' and i.sales_item_type like "%'.$product_group.'%"';}



		



		$sql='select 



		i.finish_goods_code as fg,



		i.item_id,



		i.item_name,



		i.unit_name as unit,



		i.sales_item_type ,



		i.item_brand as brand,



		i.pack_size pkt



		from item_info i where  i.finish_goods_code>0 and i.status="Active" and i.item_brand!="Promotional" and finish_goods_code!=2000 and finish_goods_code!=2001 and finish_goods_code!=2002 and i.item_brand!="Memo" and finish_goods_code not between 9000 and 10000 and i.item_brand!=""  '.$item_brand_con.$pg_con.' 



	 order by i.finish_goods_code';



if(isset($area_id)) 		{$acon.=' and a.AREA_CODE="'.$area_id.'"';}



if(isset($zone_id)) 		{$acon.=' and z.ZONE_CODE="'.$zone_id.'"';}



if(isset($region_id)) 		{$acon.=' and b.BRANCH_ID="'.$region_id.'"';}



 



		$sql2='select 



		i.item_id,



		i.pack_size as pkt,



		sum(a.total_unit) mod i.pack_size as pcs,



		sum(a.total_unit) qty,		



		sum(a.total_unit*a.unit_price) as sale_price



		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i, area ar, branch b, zon z where ar.ZONE_ID=z.ZONE_CODE and d.area_code=ar.AREA_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  



	a.unit_price>0 and a.item_id=i.item_id '.$acon.$con.$date_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 



	group by  a.item_id';



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{



	$this_year_sale_amt[$data2->item_id] = $data2->sale_price;



	$this_year_sale_qty[$data2->item_id] = $data2->qty;



	}







	



			$sql2='select 



		i.item_id,



		i.pack_size as pkt,



		sum(a.total_unit) mod i.pack_size as pcs,



		sum(a.total_unit) qty,		



		sum(a.total_unit*a.unit_price) as sale_price



		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i, area ar, branch b, zon z where ar.ZONE_ID=z.ZONE_CODE and d.area_code=ar.AREA_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  



	a.unit_price>0 and a.item_id=i.item_id '.$acon.$con.$ydate_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 



	group by  a.item_id';



	



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{



	$last_year_sale_amt[$data2->item_id] = $data2->sale_price;



	$last_year_sale_qty[$data2->item_id] = $data2->qty;



	}



	break;



	



		case 2003:



		$report="Last Year Vs This Year Single Item Dealer Wise Sales Report (Periodical)";



		if(isset($t_date)) {



		$to_date=$t_date; $fr_date=$f_date; 



		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));



		$yto_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($t_date));



		



		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';



		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';



		}



		if(isset($product_group)) 			{$product_group_con.=' and d.product_group="'.$product_group.'"';}



		if(isset($depot_id)) 				{$con.=' and d.depot="'.$depot_id.'"';}



		if(isset($dealer_code)) 			{$con.=' and d.dealer_code="'.$dealer_code.'"';} 



		if(isset($dealer_type)) 			{$con.=' and d.dealer_type="'.$dealer_type.'"';}



		if(isset($item_id))		 			{$con.=' and a.item_id="'.$item_id.'"';}



		



if(isset($area_id)) 		{$acon.=' and a.AREA_CODE="'.$area_id.'"';}



if(isset($zone_id)) 		{$acon.=' and z.ZONE_CODE="'.$zone_id.'"';}



if(isset($region_id)) 		{$acon.=' and b.BRANCH_ID="'.$region_id.'"';}



		$sql='select 



		dealer_name_e dealer_name,



		dealer_code,



		AREA_NAME area_name,



		ZONE_NAME zone_name,



		BRANCH_NAME region_name



		from dealer_info d, area a, branch b, zon z where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=a.AREA_CODE  '.$product_group_con.$acon.' 



	    order by dealer_name_e';







		$sql2='select 



		d.dealer_code,



		sum(a.total_unit) div i.pack_size as pkt,



		sum(a.total_unit) qty,		



		sum(a.total_unit*a.unit_price) as sale_price



		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i where 



		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  



	a.unit_price>0 '.$con.$date_con.$product_group_con.$item_con.' 



	group by  d.dealer_code';



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{



	$this_year_sale_amt[$data2->dealer_code] = $data2->sale_price;



	$this_year_sale_qty[$data2->dealer_code] = $data2->qty;



	$this_year_sale_pkt[$data2->dealer_code] = $data2->pkt;



	}



	$sql2='select 



		i.item_id,



		sum(a.total_unit) div i.pack_size as pkt,



		sum(a.total_unit) qty,		



		sum(a.total_unit*a.unit_price) as sale_price



		from dealer_info d, sale_do_details m,sale_do_chalan a, item_info i where 



		d.dealer_code=m.dealer_code and m.id=a.order_no  and i.item_brand!="" and  



	a.unit_price>0  and a.item_id=i.item_id '.$con.$ydate_con.$warehouse_con.$item_con.$item_brand_con.$dtype_con.' 



	group by  a.item_id';



	$sql2='select 



		d.dealer_code,



		sum(a.total_unit) div i.pack_size as pkt,



		sum(a.total_unit) qty,		



		sum(a.total_unit*a.unit_price) as sale_price



		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i where 



		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  



	a.unit_price>0 '.$con.$ydate_con.$product_group_con.$item_con.' 



	group by  d.dealer_code';



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{



	$last_year_sale_amt[$data2->dealer_code] = $data2->sale_price;



	$last_year_sale_qty[$data2->dealer_code] = $data2->qty;



	$last_year_sale_pkt[$data2->dealer_code] = $data2->pkt;



	}



	break;



	



		case 20031:



		$report="Last Year Vs This Year Single Item Region Wise Sales Report (Periodical)";



		if(isset($t_date)) 



		{



		$to_date=$t_date; $fr_date=$f_date; 



		$yfr_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($f_date));



		$yto_date=(date(('Y'),strtotime($f_date))-1).date(('-m-d'),strtotime($t_date));



		



		$date_con=' and a.chalan_date between \''.$fr_date.'\' and \''.$to_date.'\'';



		$ydate_con=' and a.chalan_date between \''.$yfr_date.'\' and \''.$yto_date.'\'';



		}



		if(isset($product_group)) 			{$product_group_con.=' and d.product_group="'.$product_group.'"';}



		if(isset($depot_id)) 				{$con.=' and d.depot="'.$depot_id.'"';}



		if(isset($dealer_code)) 			{$con.=' and d.dealer_code="'.$dealer_code.'"';} 



		if(isset($dealer_type)) 			{$con.=' and d.dealer_type="'.$dealer_type.'"';}



		if(isset($item_id))		 			{$con.=' and a.item_id="'.$item_id.'"';}



		



if(isset($area_id)) 		{$acon.=' and a.AREA_CODE="'.$area_id.'"';}



if(isset($zone_id)) 		{$acon.=' and z.ZONE_CODE="'.$zone_id.'"';}



if(isset($region_id)) 		{$acon.=' and b.BRANCH_ID="'.$region_id.'"';}



		$sql='select 







		BRANCH_NAME region_name,



		BRANCH_ID



		from dealer_info d, area a, branch b, zon z 



		where a.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=a.AREA_CODE  '.$product_group_con.$acon.' 



	    group by BRANCH_NAME';







		$sql2='select 



		BRANCH_ID,



		sum(a.total_unit) div i.pack_size as pkt,



		sum(a.total_unit) qty,		



		sum(a.total_unit*a.unit_price) as sale_price



		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i, area ar, branch b, zon z 



		where 



		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  



		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 



	a.unit_price>0 '.$con.$date_con.$product_group_con.$item_con.' 



	group by BRANCH_NAME';



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{



	$this_year_sale_amt[$data2->BRANCH_ID] = $data2->sale_price;



	$this_year_sale_qty[$data2->BRANCH_ID] = $data2->qty;



	$this_year_sale_pkt[$data2->BRANCH_ID] = $data2->pkt;



	}







	$sql2='select 



		BRANCH_ID,



		sum(a.total_unit) div i.pack_size as pkt,



		sum(a.total_unit) qty,		



		sum(a.total_unit*a.unit_price) as sale_price



		from dealer_info d, sale_do_details m, sale_do_chalan a, item_info i , area ar, branch b, zon z  where 



		d.dealer_code=m.dealer_code and a.item_id=i.item_id and m.id=a.order_no  and i.item_brand!="" and  



		ar.ZONE_ID=z.ZONE_CODE and z.REGION_ID=b.BRANCH_ID and d.dealer_type="Distributor" and d.area_code=ar.AREA_CODE and 



	a.unit_price>0 '.$con.$ydate_con.$product_group_con.$item_con.' 



	group by  BRANCH_NAME';



	$query2 = db_query($sql2);



	while($data2 = mysqli_fetch_object($query2))



	{



	$last_year_sale_amt[$data2->BRANCH_ID] = $data2->sale_price;



	$last_year_sale_qty[$data2->BRANCH_ID] = $data2->qty;



	$last_year_sale_pkt[$data2->BRANCH_ID] = $data2->pkt;



	}



	break;



    case 1991:







$report="Delivery Order Brief Report with Chalan Amount";



	break;



case 191:



$report="Delivery Order  Report (At A Glance)";



break;



	



    case 2:



		$report="Undelivered Do Details Report";







$sql = "select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,d.product_group as grp,w.warehouse_name as depot,concat(i.finish_goods_code,'- ',item_name) as item_name,o.pkt_unit as crt,o.dist_unit as pcs,o.total_amt,m.rcv_amt,m.payment_by as PB from 



sale_do_master m,sale_do_details o, item_info i,dealer_info d , warehouse w



where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$dealer_con.$item_brand_con;



	break;



	case 3:



$report="Undelivered Do Report Dealer Wise";



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($dealer_code)) {$dealer_con=' and m.dealer_code='.$dealer_code;} 



if(isset($item_id)){$item_con=' and i.item_id='.$item_id;} 



if(isset($depot_id)) {$depot_con=' and d.depot="'.$depot_id.'"';} 



	break;



	case 4:



	if($_REQUEST['do_no']>0)



header("Location:work_order_print.php?wo_id=".$_REQUEST['wo_id']);



	break;

	

	

	

	

	

	

	

	

	

	

case 1003:





$report="Corporate Customer Information";

if($_POST['dealer_name_e']!='')

$con.=' and a.dealer_name_e like "%'.$_POST['dealer_name_e'].'%"';

if($_POST['dealer_code']!='')



$con.=' and a.dealer_code = "'.$_POST['dealer_code'].'"';



if($_POST['division_code']!='')



$con.=' and a.division_code = "'.$_POST['division_code'].'"';



elseif($_POST['district_code']!='')



$con.=' and a.district_code = "'.$_POST['district_code'].'"';



elseif($_POST['thana_code']!='')



$con.=' and a.thana_code = "'.$_POST['thana_code'].'"';



if($_POST['region_code']!='')

$con.=' and a.area_code in (select p.AREA_CODE from area p,zon z where p.ZONE_ID=z.ZONE_CODE and z.REGION_ID="'.$_POST['zone_code'].'") ';

elseif($_POST['zone_code']!='')



$con.=' and a.area_code in (select AREA_CODE from area where ZONE_ID="'.$_POST['zone_code'].'") ';



elseif($_POST['area_code']!='')



$con.=' and a.area_code = "'.$_POST['area_code'].'"';



if($_POST['canceled']!='')



$con.=' and a.canceled = "'.$_POST['canceled'].'"';



if($_POST['depot']!='')



$con.=' and a.depot = "'.$_POST['depot'].'"';

if($_POST['product_group']!='')



$con.=' and a.product_group = "'.$_POST['product_group'].'"';

if($_POST['depot']!='')



$con.=' and a.mobile_no = "'.$_POST['mobile_no'].'"';



if($_POST['team_name']!='')



$con.=' and a.team_name = "'.$_POST['team_name'].'"';



		 		  $sql="select a.dealer_code as code,a.account_code as ledger_code,a.dealer_name_e as customer_name ,(select ledger_name from accounts_ledger where ledger_id=a.account_code) as ledger_name,(select sum(dr_amt-cr_amt) from journal where ledger_id=a.account_code) as closing_balance,a.mobile_no as mobile_no,a.dealer_name_b as designation , a.propritor_name_b as contact_person , a.address_e as address, a.canceled as active, a.commission from dealer_info a



		 where a.dealer_type='Corporate'  ".$con."  order by a.dealer_code asc";



		// , area ar, zon z, branch r;

		 //,a.team_name as team, ar.AREA_NAME as area, z.ZONE_NAME as zone, r.BRANCH_NAME as region;





		 //ar.AREA_CODE=a.area_code and z.ZONE_CODE=ar.ZONE_ID and r.BRANCH_ID=z.REGION_ID;



		break;

		

		

		

		

		



	case 5:



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 



$report="Delivery Order Brief Report (Region Wise)";



	break;



		case 6:



	if($_REQUEST['do_no']>0)



header("Location:../report/do_view.php?v_no=".$_REQUEST['do_no']);



	break;



	    case 7:



		$report="Item wise DO Report";



		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 



		



		$sql = "select 



		i.finish_goods_code as code, 



		i.item_name, i.item_brand, 



		i.sales_item_type as `group`,



		floor(sum(o.total_unit)/o.pkt_size) as crt,



		mod(sum(o.total_unit),o.pkt_size) as pcs, 



		sum(o.total_amt)as dP,



		sum(o.total_unit*o.t_price)as tP



		from 



		sale_do_master m,sale_do_details o, item_info i,dealer_info d



		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') and  i.item_brand!='Promotional'  ".$date_con.$item_con.$item_brand_con.$pg_con.' 



		group by i.finish_goods_code';



		break;



		



		case 701:



		$report="Item wise Undelivered DO Report(With Gift)";



		break;



		



		case 7011:



		$report="Item wise Undelivered DO Report(Without Gift)";



		break;



		



		case 8:



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 



$report="Dealer Performance Report";



	    case 9:



		$report="Item Report (Region + Zone)";



if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 



		break;



			    case 14:



		$report="Item Report (Region)";



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



		case 100:



		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		if(isset($product_group)) 	{$pg_con=' and d.product_group="'.$product_group.'"';} 



		$report="Dealer Performance Report";



		break;



		case 101:



		$report="Four(4) Months Comparison Report(CRT)";



		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 



		



		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,



		floor(sum(o.total_unit)/o.pkt_size) as crt,



		mod(sum(o.total_unit),o.pkt_size) as pcs, 



		sum(o.total_amt)as dP,



		sum(o.total_unit*o.t_price)as tP



		from 



		sale_do_master m,sale_do_details o, item_info i,dealer_info d



		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';



		break;



				case 102:



		$report="Four(4) Months Comparison Report(TK)";



		if(isset($t_date)) 	{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		if(isset($product_group)) 		{$pg_con=' and d.product_group="'.$product_group.'"';} 



		



		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,



		floor(sum(o.total_unit)/o.pkt_size) as crt,



		mod(sum(o.total_unit),o.pkt_size) as pcs, 



		sum(o.total_amt)as dP,



		sum(o.total_unit*o.t_price)as tP



		from 



		sale_do_master m,sale_do_details o, item_info i,dealer_info d



		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';



		break;



						case 103:



		$report="Four(4) Months Regioanl Report(CTR)";



		



		if($_REQUEST['region_id']!='') {$region_id = $_REQUEST['region_id'];$region_name = find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id);}







		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,



		floor(sum(o.total_unit)/o.pkt_size) as crt,



		mod(sum(o.total_unit),o.pkt_size) as pcs, 



		sum(o.total_amt)as dP,



		sum(o.total_unit*o.t_price)as tP



		from 



		sale_do_master m,sale_do_details o, item_info i,dealer_info d



		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';



		break;



						case 104:



		$report="Four(4) Months Regional Report(TK)";







		if($_REQUEST['region_id']!='') {$region_id = $_REQUEST['region_id'];$region_name = find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id);}



		



		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,



		floor(sum(o.total_unit)/o.pkt_size) as crt,



		mod(sum(o.total_unit),o.pkt_size) as pcs, 



		sum(o.total_amt)as dP,



		sum(o.total_unit*o.t_price)as tP



		from 



		sale_do_master m,sale_do_details o, item_info i,dealer_info d



		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';



		break;				case 105:



		$report="Four(4) Months Zonal Report(CTR)";







		if($_REQUEST['zone_id']!='') {$zone_id = $_REQUEST['zone_id'];$zone_name = find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id);}







		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,



		floor(sum(o.total_unit)/o.pkt_size) as crt,



		mod(sum(o.total_unit),o.pkt_size) as pcs, 



		sum(o.total_amt)as dP,



		sum(o.total_unit*o.t_price)as tP



		from 



		sale_do_master m,sale_do_details o, item_info i,dealer_info d



		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';



		break;



						case 106:



		$report="Four(4) Months Area Report(TK)";







		



		if($_REQUEST['zone_id']!='') {$zone_id = $_REQUEST['zone_id'];$zone_name = find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id);}



				



		$sql = "select i.finish_goods_code as code,i.item_name,i.item_brand,i.sales_item_type as `group`,



		floor(sum(o.total_unit)/o.pkt_size) as crt,



		mod(sum(o.total_unit),o.pkt_size) as pcs, 



		sum(o.total_amt)as dP,



		sum(o.total_unit*o.t_price)as tP



		from 



		sale_do_master m,sale_do_details o, item_info i,dealer_info d



		where m.do_no=o.do_no and m.dealer_code=d.dealer_code and i.item_id=o.item_id  and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$item_brand_con.$pg_con.' group by i.finish_goods_code';



		break;



		



								case 107:



		$report="Yearly Regional Sales Report(TK)";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);







for($i=12;$i>0;$i--)



{



	$m = $t_array[1]-($i-1);



	$t_stampq = strtotime(date('Y-m-15',strtotime($t_date)))-(60*60*24*30*($i-1));



	${'f_mos'.$i} = date('Y-m-15',$t_stampq);



	${'f_mons'.$i} = date('Y-m-01',$t_stampq);



	${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



$f_date=${'f_mons'.$i};







		break;



case 108:



$report="Yearly Regional Sales Report(Per Item)(CTN)";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);







for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



		break;



case 109:



$report="Yearly Regional Sales Report(Per Item)(TK)";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);







for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



break;									











case 110:



$report="Yearly Zone Wise Sales Report(Per Item)(Tk)";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);







for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



break;



case 111:



$report="Yearly Zone Wise Sales Report(Per Item)(CTN)";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);







for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



break;



case 112:



$report="Yearly Zone Wise Sales Report(Per Item)(Tk)";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);







for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



break;



case 1130:



$report="Corporate Party Wise Sales Report YEARLY";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);



$dealer_type = 'Corporate';



unset($to_date);



for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



break;



case 11301:



$report="SuperShop Party Wise Sales Report YEARLY";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);



$dealer_type = 'SuperShop';



unset($to_date);



for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



break;







case 113:



$report="Yearly Dealer Wise Sales Report(Per Item)(Tk)";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);







for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



break;







case 114:



$report="Yearly Dealer Wise Sales Report(Per Item)(CTN)";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);







for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



break;







case 115:



$report="Yearly Dealer Wise Sales Report(Per Item)(Tk)";



if($t_date=='') $t_date = date('Y-m-d');



$t_array = explode('-',$t_date);



$t_stamp = strtotime($t_date);







for($i=12;$i>0;$i--)



{



$m = $t_array[1]-($i-1);



$t_stampq = strtotime(date('Y-m-01',strtotime($t_date)))-(60*60*24*30*($i-1));







${'f_mons'.$i} = date('Y-m-01',$t_stampq);



${'f_mone'.$i} = date('Y-m-'.date('t',$t_stampq),$t_stampq);



}



break;



case 116:



$report="Single Item Sales Report(Zone Wise)";







break;



case 1992:



$report="Sales Statement(As Per DO)";







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



.style3 {color: #FFFFFF; font-weight: bold; }



.style5 {color: #FFFFFF}
.style7 {font-weight: bold}



-->



    </style>



</head>



<body>



<?
require_once "../../../controllers/core/inc.exporttable.php";
?>


<?php /*?><div align="center" id="pr">



  <input type="button" style="text-align:center" value="Print" onclick="hide();window.print();"/>



</div><?php */?>



<div class="main">



<?



		$str 	.= '<div class="header">';



		if(isset($_SESSION['company_name'])) 



		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';



		if(isset($report)) 



		$str 	.= '<h2>'.$report.'</h2>';



		if(isset($dealer_code)) 



		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';



		if(isset($depot_id)) 



		$str 	.= '<h2>Depot Name : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id).'</h2>';



		if(isset($item_brand)) 



		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';



		if(isset($item_info->item_id)) 



		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';



		if(isset($to_date)) 



		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';



		if(isset($product_group)) 



		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';



		if(isset($region_id)) 



		$str 	.= '<h2>Region Name : '.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id).'</h2>';



		if(isset($zone_id)) 



		$str 	.= '<h2>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id).'</h2>';



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



if($_REQUEST['report']==1) 
{



if($_POST['status']=='ALL'){



$status_con = ' and m.status in ("DONE","UNCHECKED","CHECKED","COMPLETED","PROCESSING","MANUAL","CANCELED") ';



}else{

$status_con = ' and m.status="'.$_POST['status'].'"';

}

if($_POST['marketing_person']!=''){
  $m_con = ' and m.marketing_person="'.$_POST['marketing_person'].'"';
}



 $sql="select m.do_no,m.status as do_status,m.ref_no,i.item_id,m.do_date,m.marketing_person,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,m.status as status,w.warehouse_name as depot, m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details,i.unit_price from 



sale_do_master m,dealer_info d  , warehouse w,sale_do_details i



where m.do_no=i.do_no  and m.dealer_code=d.dealer_code and w.warehouse_id=m.depot_id".$depot_con.$item_con.$date_con.$pg_con.$dealer_con.$dtype_con.$status_con. $m_con." group by i.do_no";



$query = db_query($sql);



?>



<table width="100%" style="text-align:center" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px; text-align:center" colspan="7"><?=$str?></td>



    </tr>



    <tr style="text-align:center">



      <th>S/L</th>



      <th>Do No</th>

	 



      <th>Status</th>

	  <th>Po no</th>



      <th>Date</th>



	  <th>Item Name</th>



      <th style="text-align:center">Client Name</th>

	   <th style="text-align:center;">Marketing Person</th>

	  <th style="text-align:center">Payment Details</th>



      <th>Unit Price</th>

	  <th>KG/LTR</th>

	



      <th>Rcvd Amt</th>
	  
	   <th>Commission</th>



      



      <th>Order Value</th>

	  

	   <th>Bill Submitted</th>

	  

	 



    </tr>



  </thead>



  <tbody>



    <?



while($data=mysqli_fetch_object($query)){$s++;



$sqld = 'select sum(total_amt),sum(t_price*total_unit),sum(total_unit) from sale_do_details where do_no='.$data->do_no;



$info = mysqli_fetch_row(db_query($sqld));



$rcv_t = $rcv_t+$data->rcv_amt;



$dp_t = $dp_t+$info[0];



$tp_t = $tp_t+$info[2];


if($data->do_no==1790){

 $total_rcvd = 78000;

}elseif($data->do_no==1851){

$total_rcvd = 15625;

}elseif($data->do_no==1901){

$total_rcvd = 28000;

}elseif($data->do_no==1777){

$total_rcvd = 10990;

}elseif($data->do_no==1816){

$total_rcvd = 14050;

}elseif($data->do_no==1840){

$total_rcvd = 650;

}elseif($data->do_no==1849){

$total_rcvd = 1600;

}elseif($data->do_no==1854){

$total_rcvd = 1950;

}elseif($data->do_no==1855){

$total_rcvd = 1800;

}elseif($data->do_no==1872){

$total_rcvd = 5400;

}elseif($data->do_no==1883){

$total_rcvd = 1800;

}elseif($data->do_no==1886){

$total_rcvd = 178200;

}elseif($data->do_no==1926){

$total_rcvd = 700;

}elseif($data->do_no==1928){

$total_rcvd = 28000;

}elseif($data->do_no==1946){

$total_rcvd = 15625;

}elseif($data->do_no==2002){

$total_rcvd = 28000;

}elseif($data->do_no==1971){

$total_rcvd = 107800;

}elseif($data->do_no==1996){

$total_rcvd = 560;

}elseif($data->do_no==1997){

$total_rcvd = 52500;

}elseif($data->do_no==2006){

$total_rcvd = 28000;

}elseif($data->do_no==2007){

$total_rcvd = 48000;

}elseif($data->do_no==2032){

$total_rcvd = 52500;

}elseif($data->do_no==2034){

$total_rcvd = 73500;

}elseif($data->do_no==2037){

$total_rcvd = 52500;

}elseif($data->do_no==2126){

$total_rcvd = 96000;

}elseif($data->do_no==2094){

$total_rcvd = 99800;

}elseif($data->do_no==2109){

$total_rcvd = 10800;

}elseif($data->do_no==2110){

$total_rcvd = 10800;

}elseif($data->do_no==2111){

$total_rcvd = 3600;

}elseif($data->do_no==2113){

$total_rcvd = 21000;

}elseif($data->do_no==2115){

$total_rcvd = 1675;

}elseif($data->do_no==2187){

$total_rcvd = 25000;

}elseif($data->do_no==2251){

$total_rcvd = 708000;

}elseif($data->do_no==2264){

$total_rcvd = 354000;

}elseif($data->do_no==1913){

$total_rcvd = 115170;

}else{


$total_rcvd=find_a_field('secondary_journal','sum(dr_amt)','tr_from="Receipt" and ref_no='.$data->do_no);

}

$com = $total_rcvd*1/100;
$tot_com = $tot_com+$com;


?>



    <tr>



      <td><?=$s?></td>



      <td><a href="work_order_bill_corporate.php?v_no=<?=$data->do_no?>" target="_blank">



        <?=$data->do_no?>



        </a></td>



      <td><?=$data->do_status?></td>

	  <td><?=$data->ref_no?></td>



      <td><?=$data->do_date?></td>



	  <td><?=find_a_field('item_info','item_name','item_id='.$data->item_id);?></td>



      <td><?=$data->dealer_name?></td>

	   <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$data->marketing_person);?></td>

	  <td><?=$data->Payment_Details?></td>



      <td><?=$data->unit_price?></td>

	  

	  <td><?=number_format($info[2],0)?></td>

	



      <td style="text-align:right"><?=($total_rcvd>0)? number_format($total_rcvd,0):''?></td>
	  
	  <td style="text-align:right"><?=($com>0)? number_format($com,0):''?></td>



      



      <td><?=number_format($info[0],0)?></td>

	  

	  <td><div align="center"><?=$data->bill_submit?></div></td>

	   



    </tr>



    <?



$toatl_acc_rcv = $toatl_acc_rcv+$total_rcvd;



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

	  <td><?= number_format($tp_t,2,'.',',') ?></td>

	  <td><?= number_format($toatl_acc_rcv,0,'.',',') ?></td>
	  
	  <td><?= number_format($tot_com,0,'.',',') ?></td>

      <td><?= number_format($dp_t,0,'.',',') ?></td>



    </tr>



  </tbody>



</table>



<? 



}

elseif($_REQUEST['report']==150){

if($_REQUEST['status']!='' ){

$con.= ' and m.status="'.$_POST['status'].'" ';
}

if($_POST['f_date'] !='') $con.=' and m.pos_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ';
if($_POST['item_id'] !='') $con.=' and m.item_id = "'.$_POST['item_id'].'" ';
if($_POST['dealer_code'] !='') $con.=' and m.dealer_id = "'.$_POST['dealer_code'].'" ';
if($_POST['pos_id'] !='') $con.=' and m.pos_id = "'.$_POST['pos_id'].'" ';
if($_POST['depot_id'] !='') $con.=' and m.warehouse_id = "'.$_POST['depot_id'].'" ';  

 $sql="select m.*,sum(d.total_amt) as sale,sum(d.discount) as discount from sale_pos_master m , sale_pos_details d where m.pos_id = d.pos_id ".$con." group by m.pos_id order by m.status asc";



$query = db_query($sql);
?>



<table width="100%" style="text-align:center" cellspacing="0" cellpadding="2" border="0">



  <thead>
    <tr>
      <td style="border:0px; text-align:center" colspan="7"><?=$str?></td>
    </tr>
    <tr style="text-align:center">
      <th>S/L</th>
      <th>Pos No</th>
      <th>Status</th>
	  
      <th>Date</th>
      <th style="text-align:center">Client Name</th>
	  <th style="text-align:center;">Warehouse</th>
	  <th style="text-align:center">Payment Details</th>
      <th>Total Sale</th>
	  <th>Discount(%)</th>
      <th>Rceived Amount</th>
	  <th>Bill Submitted By</th>
    </tr>
  </thead>
  <tbody>

    <?
while($data=mysqli_fetch_object($query)){$s++;

?>
    <tr>
      <td><?=$s?></td>
      <td><?=$data->pos_id;?></a></td>
      <td><?=$data->status?></td>
      <td><?=$data->pos_date?></td>
      <td><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_id);?></td>
	  <td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$data->warehouse_id);?></td>
	  <td><?=find_a_field('pos_payment','payment_method','pos_id='.$data->pos_id);?></td>
      <td><?=number_format($data->sale,0);$total_sale+=$data->sale;?></td>
	  <td><?=number_format($data->discount,0);$total_disc+=$data->discount;?></td>
      <td style="text-align:right"><?=number_format($rcv=find_a_field('pos_payment','sum(paid_amt)','pos_id='.$data->pos_id),0);$total_rcv+=$rcv;?></td>
	  <td><div align="center"><?=find_a_field('user_activity_management','fname','USER_ID='.$data->entry_by);?></div></td>
    </tr>
    <?

}
?>
    <tr class="footer">
      <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> <td>&nbsp;</td><td>&nbsp;</td>
	  <td><?= number_format($total_sale,2,'.',',') ?></td>
	  <td><?= number_format($total_disc,0,'.',',') ?></td>
	  <td><?= number_format($total_rcv,0,'.',',') ?></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>


<? 
}
elseif($_REQUEST['report']==2000) 
{

  if($_POST['status']!='' && $_POST['status']!='ALL')

  $status_concat = ' and m.status="'.$_POST['status'].'"';



  $sql="select m.do_no,m.status as do_status,m.marketing_person,i.item_id,m.do_date,i.total_amt,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,w.warehouse_name as depot, m.rcv_amt,concat(m.payment_by,':',m.bank,':',m.remarks) as Payment_Details from 


sale_do_master m,dealer_info d  , warehouse w,sale_do_details i



where m.marketing_person='".$_POST['marketing_person']."'  and m.do_no=i.do_no  and m.dealer_code=d.dealer_code and w.warehouse_id=m.depot_id".$item_con.$date_con.$dealer_con.$status_concat." order by m.do_no,m.do_date";


$query = db_query($sql);



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="7"><?=$str?></td>



    </tr>



    <tr>



      <th>S/L</th>



      <th>No</th>



      <th>Status</th>



      <th>Date</th>



	  <th>Item Name</th>



	  <th>Marketing Person</th>



      <th>Client Name</th>



      <th>Depot</th>



      <th>Rcv Amt</th>

	  

	  <th>Commission</th>



      <th>Payment Details</th>



      <th>DO Value</th>



    </tr>



  </thead>



  <tbody>



    <?



while($data=mysqli_fetch_object($query)){$s++;



$sqld = 'select sum(total_amt),sum(t_price*total_unit) from sale_do_details where do_no='.$data->do_no;



$info = mysqli_fetch_row(db_query($sqld));



$rcv_t = $rcv_t+$data->rcv_amt;



$dp_t = $dp_t+$info[0];



$tp_t = $tp_t+$info[1];




$total_rcvdd=find_a_field('secondary_journal','sum(dr_amt)','tr_from="Receipt" and ref_no='.$data->do_no);




$tot_rcvd  = $tot_rcvd +$total_rcvdd;

$cmsn = $total_rcvdd*1/100;

$tot_cmsn = $tot_cmsn+$cmsn;

?>



    <tr>



      <td><?=$s?></td>



      <td><a href="work_order_bill_corporate.php?v_no=<?=$data->do_no?>" target="_blank">



        <?=$data->do_no?>



        </a></td>



      <td><?=$data->do_status?></td>



      <td><?=$data->do_date?></td>



	  <td><?=find_a_field('item_info','item_name','item_id='.$data->item_id);?></td>



	   <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$data->marketing_person);?></td>



      <td><?=$data->dealer_name?></td>



      <td><?=$data->depot?></td>



      <td style="text-align:right"><?=$total_rcvdd?></td>

	  

	   <td style="text-align:right"><?=$cmsn?></td>



      <td><?=$data->Payment_Details?></td>



      <td><?=$data->total_amt?></td>



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



      <td><?= number_format($tot_rcvd,0,'.',',') ?></td>

	  

	  <td><?= number_format($tot_cmsn,0,'.',',') ?></td>



      <td>&nbsp;</td>



      <td><?= number_format($dp_t,0,'.',',') ?></td>



    </tr>



  </tbody>



</table>



<? 







}






elseif($_POST['report']==210001)
{
		$report="Work Order Brief Report";	
			
		$customer_name = $_POST['customer_name'];
 		$customer=explode("->",$customer_name);
 		$customer[0];
 		if($_POST['customer_name']!='')
 		$customer_con=" and sm.dealer_code=".$customer[0];
		
		$buyer_info = $_POST['buyer'];
 		$buyer=explode("->",$buyer_info);
 		$buyer[0];
 		if($_POST['buyer']!='')
 		$buyer_con=" and sm.buyer_code=".$buyer[0];
		
		$merchandizer_info = $_POST['merchandizer'];
 		$merchandizer=explode("->",$merchandizer_info);
 		$merchandizer[0];
 		if($_POST['merchandizer']!='')
 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="2%" bgcolor="#28AA6C">SL</th>
		<th width="8%" bgcolor="#28AA6C">JOB No </th>
		<th width="9%" bgcolor="#28AA6C">WO Date </th>
		<th width="19%" bgcolor="#28AA6C">Customer Name </th>
		<th width="12%" bgcolor="#28AA6C"><span id="buyer_filter">Buyer</span> Name </th>
		<th width="12%" bgcolor="#28AA6C">Merchandiser Name </th>
		<th width="12%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Team </span></th>
		<th width="12%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Person</span></th>
		<th width="9%" bgcolor="#28AA6C" style="text-align:center">Quantity</th>
		<th width="9%" bgcolor="#28AA6C" style="text-align:center"> Amount ($) </th>
		<th width="5%" bgcolor="#28AA6C" style="text-align:center">Status</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select c.dealer_code, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_chalan c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		 where m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and d.zone_code=z.ZONE_CODE and
		  c.chalan_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->dealer_code]=$info->sales_amt;
		 $sales_qty[$info->dealer_code]=$info->sales_qty;
		
		}
		
		
		  $sql = "select c.dealer_code, sum(c.return_amt) as return_amt, sum(c.total_unit) as return_qty
		  from sale_return_master m, sale_return_details c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		  where  m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id and d.zone_code=z.ZONE_CODE and
		  c.do_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con." group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_amt[$info->dealer_code]=$info->return_amt;
		 $return_qty[$info->dealer_code]=$info->return_qty;
		
  		 
		}
		

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sm.do_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sm.do_no = "'.$_POST['do_no'].'" ';



		
		

		
		 $sql="select  d.dealer_name_e, b.buyer_name, m.merchandizer_name, sm.do_no, sm.do_date, sm.job_no, sm.marketing_team, sm.marketing_person, sm.status, 
		 sum(sd.total_amt) as total_amt, sum(sd.total_unit) as total_unit
		  from dealer_info d, buyer_info b, merchandizer_info m, sale_do_master sm, sale_do_details sd
		 where sm.do_no=sd.do_no and  d.dealer_code=sm.dealer_code and b.buyer_code=sm.buyer_code and m.merchandizer_code=sm.merchandizer_code
		  ".$date_wo.$customer_con.$buyer_con.$merchandizer_con.$job_con." group by  sm.do_no order by sm.job_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no?>"><?=$row->job_no?></a></td>
		<td><?php echo date('d-M-Y',strtotime($row->do_date));?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$row->buyer_name?></td>
		<td><?=$row->merchandizer_name?></td>
		<td><?=find_a_field('marketing_team','team_name','team_code='.$row->marketing_team);?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_team);?></td>
		<td><?=$row->total_unit; $total_total_unit +=$row->total_unit;?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?=$row->status?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong> TOTAL: </strong></div></td>
		  <td><span class="style7">
		    <?=$total_total_unit;?>
		  </span></td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		</tr>
		  
		
		
		
		
		
		</tbody>
</table>
		<?
}












elseif($_POST['report']==210002)
{
		$report="Work Order Summary Report";	
			
		$customer_name = $_POST['customer_name'];
 		$customer=explode("->",$customer_name);
 		$customer[0];
 		if($_POST['customer_name']!='')
 		$customer_con=" and sm.dealer_code=".$customer[0];
		
		$buyer_info = $_POST['buyer'];
 		$buyer=explode("->",$buyer_info);
 		$buyer[0];
 		if($_POST['buyer']!='')
 		$buyer_con=" and sm.buyer_code=".$buyer[0];
		
		$merchandizer_info = $_POST['merchandizer'];
 		$merchandizer=explode("->",$merchandizer_info);
 		$merchandizer[0];
 		if($_POST['merchandizer']!='')
 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="2%" bgcolor="#28AA6C">SL</th>
		<th width="6%" bgcolor="#28AA6C">JOB No </th>
		<th width="7%" bgcolor="#28AA6C">JOB_Date </th>
		<th width="14%" bgcolor="#28AA6C">Customer Name </th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Buyer</span> Name </th>
		<th width="9%" bgcolor="#28AA6C">Merchandiser Name </th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Team </span></th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Person</span></th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Style No </th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">PO No</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Destination</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Referance</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">SKU No</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Pack Type</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Color</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Size</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Item Name </th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Ply</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"><strong>Measurement</strong></th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"><strong>Paper Combination</strong></th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Sqm Rate </th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">UOM</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Quantity</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Unit_Price</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"> Negotiated Price</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center"> Amount ($)</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Printing Info</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Addi. Info</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Addi. Charge</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Date</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Place</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Address </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select c.dealer_code, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_chalan c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		 where m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and d.zone_code=z.ZONE_CODE and
		  c.chalan_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->dealer_code]=$info->sales_amt;
		 $sales_qty[$info->dealer_code]=$info->sales_qty;
		
		}
		
		
		  $sql = "select c.dealer_code, sum(c.return_amt) as return_amt, sum(c.total_unit) as return_qty
		  from sale_return_master m, sale_return_details c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		  where  m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id and d.zone_code=z.ZONE_CODE and
		  c.do_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con." group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_amt[$info->dealer_code]=$info->return_amt;
		 $return_qty[$info->dealer_code]=$info->return_qty;
		
  		 
		}
		

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sm.do_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sm.do_no = "'.$_POST['do_no'].'" ';



		
		

		
		  $sql="select  d.dealer_name_e, b.buyer_name, m.merchandizer_name, sm.do_no, sm.do_date, sm.job_no, sm.marketing_team, sm.marketing_person, sm.status, 
		i.item_name, sd.*
		  from dealer_info d, buyer_info b, merchandizer_info m, sale_do_master sm, sale_do_details sd, item_info i 
		 where sm.do_no=sd.do_no  and sd.item_id=i.item_id and  d.dealer_code=sm.dealer_code and b.buyer_code=sm.buyer_code and m.merchandizer_code=sm.merchandizer_code
		  ".$date_wo.$customer_con.$buyer_con.$merchandizer_con.$job_con." order by sd.job_no, sd.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no?>"><?=$row->job_no?></a></td>
		<td><?=date("d-M-Y",strtotime($row->do_date))?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$row->buyer_name?></td>
		<td><?=$row->merchandizer_name?></td>
		<td><?=find_a_field('marketing_team','team_name','team_code='.$row->marketing_team);?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><?=$row->style_no?></td>
		<td><?=$row->po_no?></td>
		<td><?=$row->destination?></td>
		<td><?=$row->referance?></td>
		<td><?=$row->sku_no?></td>
		<td><?=$row->pack_type?></td>
		<td><?=$row->color?></td>
		<td><?=$row->size?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->ply?></td>
<td><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?> <?=$row->measurement_unit?></td>
		<td><?=$row->paper_combination?></td>
		<td><?=$row->sqm_rate?></td>
		<td><?=$row->unit_name?></td>
		<td><?=$row->total_unit;  $total_sales_qty +=$row->total_unit;?></td>
		<td>$<?=$row->final_price?></td>
		<td>$<?=$row->unit_price?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?=find_a_field('printing_information','printing_information','id='.$row->printing_info);?></td>
		<td><?=find_a_field('additional_information','additional_information','id='.$row->additional_info);?></td>
		<td><?=$row->additional_charge?></td>
		<td><?php echo date('d-M-Y',strtotime($row->delivery_date));?></td>
		<td><?= find_a_field('delivery_place_info','delivery_place','id="'.$row->delivery_place.'"');?></td>
		<td><?= find_a_field('delivery_place_info','address_e','id="'.$row->delivery_place.'"');?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong> TOTAL: </strong></div></td>
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
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=$total_sales_qty;?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		  
		
		
		
		
		
		</tbody>
</table>
		<?
}









elseif($_POST['report']==210428001)
{
		$report="Raw Data Input Sheet";	
			
		//$customer_name = $_POST['customer_name'];
// 		$customer=explode("->",$customer_name);
// 		$customer[0];
// 		if($_POST['customer_name']!='')
// 		$customer_con=" and sm.dealer_code=".$customer[0];
//		
//		$buyer_info = $_POST['buyer'];
// 		$buyer=explode("->",$buyer_info);
// 		$buyer[0];
// 		if($_POST['buyer']!='')
// 		$buyer_con=" and sm.buyer_code=".$buyer[0];
//		
//		$merchandizer_info = $_POST['merchandizer'];
// 		$merchandizer=explode("->",$merchandizer_info);
// 		$merchandizer[0];
// 		if($_POST['merchandizer']!='')
// 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: 
		  <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		
		
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="2%" bgcolor="#28AA6C">SL</th>
		<th width="7%" bgcolor="#28AA6C">ORDER DATE </th>
		<th width="7%" bgcolor="#28AA6C">CONCERN NAME</th>
		<th width="7%" bgcolor="#28AA6C">ORDER NO</th>
		<th width="14%" bgcolor="#28AA6C">PARTY NAME</th>
		<th width="9%" bgcolor="#28AA6C">PARTY CONCERN</th>
		<th width="9%" bgcolor="#28AA6C">BUYER</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">ITEM</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">NO. OF PLY</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">TOTAL QTY</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">TOTAL VALUE </th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">LC NO </th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">LC DATE</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">LC EXPIRY DATE</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select c.dealer_code, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_chalan c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		 where m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and d.zone_code=z.ZONE_CODE and
		  c.chalan_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->dealer_code]=$info->sales_amt;
		 $sales_qty[$info->dealer_code]=$info->sales_qty;
		
		}
		
		
		  $sql = "select c.dealer_code, sum(c.return_amt) as return_amt, sum(c.total_unit) as return_qty
		  from sale_return_master m, sale_return_details c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		  where  m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id and d.zone_code=z.ZONE_CODE and
		  c.do_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con." group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_amt[$info->dealer_code]=$info->return_amt;
		 $return_qty[$info->dealer_code]=$info->return_qty;
		
  		 
		}
		

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sm.lc_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['lc_no']!='')

			$lc_con .= ' and sm.id = "'.$_POST['lc_no'].'" ';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sd.do_no = "'.$_POST['do_no'].'" ';
			
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and sm.dealer_code = "'.$_POST['dealer_code'].'" ';



		
		

		
		   $sql="select  d.dealer_name_e,  i.item_name, sd.*, sm.id, sm.lc_no, sm.lc_date, sm.lc_expiry_date
		  from dealer_info d,  lc_management sm, lc_management_details sd, item_info i 
		 where sm.id=sd.lc_id  and sd.item_id=i.item_id and  d.dealer_code=sm.dealer_code 
		  ".$date_wo.$customer_con.$lc_con.$job_con." order by sd.lc_no, sd.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><?=date("d-M-Y",strtotime($row->do_date))?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no?>">
		  <?=$row->job_no?>
		</a></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$row->merchandizer_code);?></td>
		<td><?=find_a_field('buyer_info','buyer_name','buyer_code='.$row->buyer_code);?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->ply?></td>
<td><?=$row->total_unit;  $total_sales_qty +=$row->total_unit;?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?=$row->lc_no?></td>
		<td><?=date("d-M-Y",strtotime($row->lc_date))?></td>
		<td><?=date("d-M-Y",strtotime($row->lc_expiry_date))?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=$total_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
		  
		
		
		
		
		
		</tbody>
</table>
		<?
}









elseif($_POST['report']==210015)
{
		$report="WO Hold Details Report";	
			
		$customer_name = $_POST['customer_name'];
 		$customer=explode("->",$customer_name);
 		$customer[0];
 		if($_POST['customer_name']!='')
 		$customer_con=" and sm.dealer_code=".$customer[0];
		
		$buyer_info = $_POST['buyer'];
 		$buyer=explode("->",$buyer_info);
 		$buyer[0];
 		if($_POST['buyer']!='')
 		$buyer_con=" and sm.buyer_code=".$buyer[0];
		
		$merchandizer_info = $_POST['merchandizer'];
 		$merchandizer=explode("->",$merchandizer_info);
 		$merchandizer[0];
 		if($_POST['merchandizer']!='')
 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="2%" bgcolor="#28AA6C">SL</th>
		<th width="6%" bgcolor="#28AA6C">JOB No </th>
		<th width="7%" bgcolor="#28AA6C">JOB_Date </th>
		<th width="14%" bgcolor="#28AA6C">Customer Name </th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Buyer</span> Name </th>
		<th width="9%" bgcolor="#28AA6C">Merchandiser Name </th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Team </span></th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Person</span></th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Style No </th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">PO No</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Destination</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Referance</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">SKU No</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Pack Type</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Color</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Size</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Item Name </th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Ply</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"><strong>Measurement</strong></th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"><strong>Paper Combination</strong></th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Sqm Rate </th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">UOM</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Quantity</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Unit_Price</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"> Negotiated Price</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center"> Amount ($)</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Printing Info</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Addi. Info</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Addi. Charge</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Date</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Place</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Address </th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Hold Note </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select c.dealer_code, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_chalan c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		 where m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and d.zone_code=z.ZONE_CODE and
		  c.chalan_date between '".$f_date."' and '".$t_date."' 
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->dealer_code]=$info->sales_amt;
		 $sales_qty[$info->dealer_code]=$info->sales_qty;
		
		}
		
		
		  $sql = "select c.dealer_code, sum(c.return_amt) as return_amt, sum(c.total_unit) as return_qty
		  from sale_return_master m, sale_return_details c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		  where  m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id and d.zone_code=z.ZONE_CODE and
		  c.do_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con." group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_amt[$info->dealer_code]=$info->return_amt;
		 $return_qty[$info->dealer_code]=$info->return_qty;
		
  		 
		}
		

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sm.do_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sm.do_no = "'.$_POST['do_no'].'" ';



		
		

		
		  $sql="select  d.dealer_name_e, b.buyer_name, m.merchandizer_name, sm.do_no, sm.do_date, sm.job_no, sm.marketing_team, sm.marketing_person, sm.status, sm.hold_note,
			i.item_name, sd.*
		  from dealer_info d, buyer_info b, merchandizer_info m, sale_do_master sm, sale_do_details sd, item_info i 
		 where sm.do_no=sd.do_no  and sd.item_id=i.item_id and  d.dealer_code=sm.dealer_code and b.buyer_code=sm.buyer_code and m.merchandizer_code=sm.merchandizer_code
		 and sm.status in ('HOLD REQUEST','HOLD') ".$date_wo.$customer_con.$buyer_con.$merchandizer_con.$job_con." order by sd.job_no, sd.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no?>"><?=$row->job_no?></a></td>
		<td><?=date("d-M-Y",strtotime($row->do_date))?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$row->buyer_name?></td>
		<td><?=$row->merchandizer_name?></td>
		<td><?=find_a_field('marketing_team','team_name','team_code='.$row->marketing_team);?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><?=$row->style_no?></td>
		<td><?=$row->po_no?></td>
		<td><?=$row->destination?></td>
		<td><?=$row->referance?></td>
		<td><?=$row->sku_no?></td>
		<td><?=$row->pack_type?></td>
		<td><?=$row->color?></td>
		<td><?=$row->size?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->ply?></td>
<td><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?> <?=$row->measurement_unit?></td>
		<td><?=$row->paper_combination?></td>
		<td><?=$row->sqm_rate?></td>
		<td><?=$row->unit_name?></td>
		<td><?=$row->total_unit;  $total_sales_qty +=$row->total_unit;?></td>
		<td>$<?=$row->final_price?></td>
		<td>$<?=$row->unit_price?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?=find_a_field('printing_information','printing_information','id='.$row->printing_info);?></td>
		<td><?=find_a_field('additional_information','additional_information','id='.$row->additional_info);?></td>
		<td><?=$row->additional_charge?></td>
		<td><?php echo date('d-M-Y',strtotime($row->delivery_date));?></td>
		<td><?= find_a_field('delivery_place_info','delivery_place','id="'.$row->delivery_place.'"');?></td>
		<td><?= find_a_field('delivery_place_info','address_e','id="'.$row->delivery_place.'"');?></td>
		<td><?=$row->hold_note?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong> TOTAL: </strong></div></td>
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
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=$total_sales_qty;?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		  
		
		
		
		
		
		</tbody>
</table>
		<?
}








elseif($_POST['report']==210016)
{
		$report="WO Canceled Details Report";	
			
		$customer_name = $_POST['customer_name'];
 		$customer=explode("->",$customer_name);
 		$customer[0];
 		if($_POST['customer_name']!='')
 		$customer_con=" and sm.dealer_code=".$customer[0];
		
		$buyer_info = $_POST['buyer'];
 		$buyer=explode("->",$buyer_info);
 		$buyer[0];
 		if($_POST['buyer']!='')
 		$buyer_con=" and sm.buyer_code=".$buyer[0];
		
		$merchandizer_info = $_POST['merchandizer'];
 		$merchandizer=explode("->",$merchandizer_info);
 		$merchandizer[0];
 		if($_POST['merchandizer']!='')
 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="2%" bgcolor="#28AA6C">SL</th>
		<th width="6%" bgcolor="#28AA6C">JOB No </th>
		<th width="7%" bgcolor="#28AA6C">JOB_Date </th>
		<th width="14%" bgcolor="#28AA6C">Customer Name </th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Buyer</span> Name </th>
		<th width="9%" bgcolor="#28AA6C">Merchandiser Name </th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Team </span></th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Person</span></th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Style No </th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">PO No</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Destination</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Referance</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">SKU No</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Pack Type</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Color</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Size</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Item Name </th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Ply</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"><strong>Measurement</strong></th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"><strong>Paper Combination</strong></th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Sqm Rate </th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">UOM</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Quantity</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Unit_Price</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"> Negotiated Price</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center"> Amount ($)</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Printing Info</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Addi. Info</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Addi. Charge</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Date</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Place</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Address </th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Hold Note </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select c.dealer_code, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_chalan c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		 where m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and d.zone_code=z.ZONE_CODE and
		  c.chalan_date between '".$f_date."' and '".$t_date."' 
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->dealer_code]=$info->sales_amt;
		 $sales_qty[$info->dealer_code]=$info->sales_qty;
		
		}
		
		
		  $sql = "select c.dealer_code, sum(c.return_amt) as return_amt, sum(c.total_unit) as return_qty
		  from sale_return_master m, sale_return_details c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		  where  m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id and d.zone_code=z.ZONE_CODE and
		  c.do_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con." group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_amt[$info->dealer_code]=$info->return_amt;
		 $return_qty[$info->dealer_code]=$info->return_qty;
		
  		 
		}
		

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sm.do_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sm.do_no = "'.$_POST['do_no'].'" ';



		
		

		
		  $sql="select  d.dealer_name_e, b.buyer_name, m.merchandizer_name, sm.do_no, sm.do_date, sm.job_no, sm.marketing_team, sm.marketing_person, sm.status, sm.cancel_note,
			i.item_name, sd.*
		  from dealer_info d, buyer_info b, merchandizer_info m, sale_do_master sm, sale_do_details sd, item_info i 
		 where sm.do_no=sd.do_no  and sd.item_id=i.item_id and  d.dealer_code=sm.dealer_code and b.buyer_code=sm.buyer_code and m.merchandizer_code=sm.merchandizer_code
		 and sm.status in ('CANCEL REQUEST','CANCELED') ".$date_wo.$customer_con.$buyer_con.$merchandizer_con.$job_con." order by sd.job_no, sd.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no?>"><?=$row->job_no?></a></td>
		<td><?=date("d-M-Y",strtotime($row->do_date))?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$row->buyer_name?></td>
		<td><?=$row->merchandizer_name?></td>
		<td><?=find_a_field('marketing_team','team_name','team_code='.$row->marketing_team);?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><?=$row->style_no?></td>
		<td><?=$row->po_no?></td>
		<td><?=$row->destination?></td>
		<td><?=$row->referance?></td>
		<td><?=$row->sku_no?></td>
		<td><?=$row->pack_type?></td>
		<td><?=$row->color?></td>
		<td><?=$row->size?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->ply?></td>
<td><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?> <?=$row->measurement_unit?></td>
		<td><?=$row->paper_combination?></td>
		<td><?=$row->sqm_rate?></td>
		<td><?=$row->unit_name?></td>
		<td><?=$row->total_unit;  $total_sales_qty +=$row->total_unit;?></td>
		<td>$<?=$row->final_price?></td>
		<td>$<?=$row->unit_price?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?=find_a_field('printing_information','printing_information','id='.$row->printing_info);?></td>
		<td><?=find_a_field('additional_information','additional_information','id='.$row->additional_info);?></td>
		<td><?=$row->additional_charge?></td>
		<td><?php echo date('d-M-Y',strtotime($row->delivery_date));?></td>
		<td><?= find_a_field('delivery_place_info','delivery_place','id="'.$row->delivery_place.'"');?></td>
		<td><?= find_a_field('delivery_place_info','address_e','id="'.$row->delivery_place.'"');?></td>
		<td><?=$row->cancel_note?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong> TOTAL: </strong></div></td>
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
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=$total_sales_qty;?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		  
		
		
		
		
		
		</tbody>
</table>
		<?
}






elseif($_POST['report']==210018)
{
		$report="FOC Order Details Report";	
			
		$customer_name = $_POST['customer_name'];
 		$customer=explode("->",$customer_name);
 		$customer[0];
 		if($_POST['customer_name']!='')
 		$customer_con=" and sm.dealer_code=".$customer[0];
		
		$buyer_info = $_POST['buyer'];
 		$buyer=explode("->",$buyer_info);
 		$buyer[0];
 		if($_POST['buyer']!='')
 		$buyer_con=" and sm.buyer_code=".$buyer[0];
		
		$merchandizer_info = $_POST['merchandizer'];
 		$merchandizer=explode("->",$merchandizer_info);
 		$merchandizer[0];
 		if($_POST['merchandizer']!='')
 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="2%" bgcolor="#28AA6C">SL</th>
		<th width="6%" bgcolor="#28AA6C">JOB No </th>
		<th width="7%" bgcolor="#28AA6C">JOB_Date </th>
		<th width="14%" bgcolor="#28AA6C">Customer Name </th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Buyer</span> Name </th>
		<th width="9%" bgcolor="#28AA6C">Merchandiser Name </th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Team </span></th>
		<th width="9%" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Person</span></th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Style No </th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">PO No</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Destination</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Referance</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">SKU No</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Pack Type</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Color</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Size</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Item Name </th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Ply</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"><strong>Measurement</strong></th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"><strong>Paper Combination</strong></th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Sqm Rate </th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">UOM</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Quantity</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center">Unit_Price</th>
		<th width="6%" bgcolor="#28AA6C" style="text-align:center"> Negotiated Price</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center"> Amount ($)</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Printing Info</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Addi. Info</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Addi. Charge</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Date</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Place</th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Delivery Address </th>
		<th width="7%" bgcolor="#28AA6C" style="text-align:center">Hold Note </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select c.dealer_code, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_chalan c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		 where m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and d.zone_code=z.ZONE_CODE and
		  c.chalan_date between '".$f_date."' and '".$t_date."' 
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->dealer_code]=$info->sales_amt;
		 $sales_qty[$info->dealer_code]=$info->sales_qty;
		
		}
		
		
		  $sql = "select c.dealer_code, sum(c.return_amt) as return_amt, sum(c.total_unit) as return_qty
		  from sale_return_master m, sale_return_details c, dealer_info d, item_info i, item_sub_group s, item_group g, zon z
		  where  m.do_no=c.do_no and c.dealer_code=d.dealer_code and c.item_id=i.item_id and s.sub_group_id=i.sub_group_id  and s.group_id=g.group_id and d.zone_code=z.ZONE_CODE and
		  c.do_date between '".$f_date."' and '".$t_date."' and g.product_type='Finish Goods'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con." group by c.dealer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $return_amt[$info->dealer_code]=$info->return_amt;
		 $return_qty[$info->dealer_code]=$info->return_qty;
		
  		 
		}
		

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sm.foc_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sm.do_no = "'.$_POST['do_no'].'" ';



		
		

		
		  $sql="select  d.dealer_name_e, b.buyer_name, m.merchandizer_name, sm.foc_no, sm.do_no, sm.do_date, sm.job_no, sm.marketing_team, sm.marketing_person, sm.status, sd.reason,
			i.item_name, sd.*
		  from dealer_info d, buyer_info b, merchandizer_info m, sale_foc_master sm, sale_foc_details sd, item_info i 
		 where sm.do_no=sd.do_no  and sd.item_id=i.item_id and  d.dealer_code=sm.dealer_code and b.buyer_code=sm.buyer_code and m.merchandizer_code=sm.merchandizer_code
		  ".$date_wo.$customer_con.$buyer_con.$merchandizer_con.$job_con." order by sd.job_no, sd.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/foc/foc_order_print_view.php?v_no=<?=$row->foc_no?>"><?=$row->job_no?></a></td>
		<td><?=date("d-M-Y",strtotime($row->do_date))?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$row->buyer_name?></td>
		<td><?=$row->merchandizer_name?></td>
		<td><?=find_a_field('marketing_team','team_name','team_code='.$row->marketing_team);?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><?=$row->style_no?></td>
		<td><?=$row->po_no?></td>
		<td><?=$row->destination?></td>
		<td><?=$row->referance?></td>
		<td><?=$row->sku_no?></td>
		<td><?=$row->pack_type?></td>
		<td><?=$row->color?></td>
		<td><?=$row->size?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->ply?></td>
<td><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?> <?=$row->measurement_unit?></td>
		<td><?=$row->paper_combination?></td>
		<td><?=$row->sqm_rate?></td>
		<td><?=$row->unit_name?></td>
		<td><?=$row->total_unit;  $total_sales_qty +=$row->total_unit;?></td>
		<td>$<?=$row->final_price?></td>
		<td>$<?=$row->unit_price?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?=find_a_field('printing_information','printing_information','id='.$row->printing_info);?></td>
		<td><?=find_a_field('additional_information','additional_information','id='.$row->additional_info);?></td>
		<td><?=$row->additional_charge?></td>
		<td><?php echo date('d-M-Y',strtotime($row->delivery_date));?></td>
		<td><?= find_a_field('delivery_place_info','delivery_place','id="'.$row->delivery_place.'"');?></td>
		<td><?= find_a_field('delivery_place_info','address_e','id="'.$row->delivery_place.'"');?></td>
		<td><?=$row->reason?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="right"><strong> TOTAL: </strong></div></td>
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
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=$total_sales_qty;?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		  
		
		
		
		
		
		</tbody>
</table>
		<?
}












elseif($_POST['report']==210003)
{
		$report="Order Receiving Summary";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL</th>
		<th width="30%" bgcolor="#99FFFF">Marketing Person </th>
		<th width="12%" bgcolor="#99FFFF" style="text-align:center">Sum of Total Qty (Pcs) </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">Sum of Total Value </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}



		

		
		  $sql = "select m.marketing_person, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_details c, marketing_person p
		 where m.do_no=c.do_no and m.marketing_person=p.person_code and c.do_date between '".$f_date."' and '".$t_date."'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by m.marketing_person ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->marketing_person]=$info->sales_amt;
		 $sales_qty[$info->marketing_person]=$info->sales_qty;
		
		}
		
		
	
		
		
		if(isset($zone_id)) 		{$zon_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		 $sql_sub="select t.team_code, t.team_name from marketing_team t, sale_do_master s where  
		 s.marketing_team=t.team_code ".$zon_con." group by s.marketing_team";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		
		<tr>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->team_name?></strong></div></td>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff">&nbsp;</td>
		  </tr>
		
		
		
		<?
		

		
		 $sql="select  p.person_code, p.marketing_person_name from marketing_person p, sale_do_master s
		 where  p.person_code=s.marketing_person and p.team_code='".$info_sub->team_code."'  ".$con." group by s.marketing_person order by p.team_code,p.person_code";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td><?=$row->marketing_person_name?></td>
		<td><? if ($sales_qty[$row->person_code]>0) {?>
		  <?=$sales_qty[$row->person_code]; $total_sales_qty +=$sales_qty[$row->person_code]; ?>
		  <? }?></td>
		<td>$ &nbsp;&nbsp;&nbsp;<? if ($sales_amt[$row->person_code]>0) {?><?=number_format($sales_amt[$row->person_code],2); $total_sales_amt +=$sales_amt[$row->person_code]; ?><? }?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td bgcolor="#FFFFFF"><div align="right"><strong>SUB TOTAL: </strong></div></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    <?=$total_sales_qty; $total_total_sales_qty +=$total_sales_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    $ &nbsp;&nbsp;&nbsp;<?=number_format($total_sales_amt,2); $total_total_sales_amt +=$total_sales_amt;?>
		  </span></td>
		  </tr>
		  
		  <? 
		  $total_sales_qty = 0;
		  $total_sales_amt = 0;
		  $total_return_qty = 0;
		  $total_return_amt = 0;
		  $total_net_sales_qty = 0;
		  $total_net_sales_amt = 0;
		   }?>
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td bgcolor="#FFFFFF"><div align="right"><strong>GRAND TOTAL:</strong></div></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    <?=$total_total_sales_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    $ &nbsp;&nbsp;&nbsp;<?=number_format($total_total_sales_amt,2);?>
		  </span></td>
		  </tr>
		
		</tbody>
</table>
		<?
}









elseif($_POST['report']==210004)
{
		$report="Delivery Details Report";	
			
		$customer_name = $_POST['customer_name'];
 		$customer=explode("->",$customer_name);
 		$customer[0];
 		if($_POST['customer_name']!='')
 		$customer_con=" and sm.dealer_code=".$customer[0];
		
		$buyer_info = $_POST['buyer'];
 		$buyer=explode("->",$buyer_info);
 		$buyer[0];
 		if($_POST['buyer']!='')
 		$buyer_con=" and sm.buyer_code=".$buyer[0];
		
		$merchandizer_info = $_POST['merchandizer'];
 		$merchandizer=explode("->",$merchandizer_info);
 		$merchandizer[0];
 		if($_POST['merchandizer']!='')
 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="1%" rowspan="2" bgcolor="#28AA6C">SL </th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C">JOB No </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C">JOB_Date </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">TR_No </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">Challan No </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">Challan Date </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C">Customer Name </th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Buyer</span> Name </th>
		<th width="5%" rowspan="2" bgcolor="#28AA6C">Merchandiser Name </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Team </span></th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Person</span></th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Style No </th>
		<th width="1%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">PO No</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Destination</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Referance</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">SKU No</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Pack Type</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Color</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Size</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Item Name </th>
		<th width="1%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Ply</th>
		<th width="5%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"><strong>Measurement</strong></th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"><strong>Paper Combination</strong></th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Sqm Rate </th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">UOM</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Unit_Price</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"> Negotiated Price</th>
		<th colspan="2" bgcolor="#28AA6C" style="text-align:center">Order </th>
		<th colspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Challan </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Printing Info</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Addi. Info</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Addi. Charge</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Date</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Place</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Address </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Vehicle No</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Man</th>
		</tr>
		<tr height="30">
		  <th width="4%" bgcolor="#28AA6C" style="text-align:center">Qty</th>
		  <th width="4%" bgcolor="#28AA6C" style="text-align:center"> Amt ($)</th>
		  <th width="1%" bgcolor="#28AA6C" style="text-align:center">Qty</th>
		  <th width="3%" bgcolor="#28AA6C" style="text-align:center"> Amt ($)</th>
		  </tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select id, total_unit, total_amt from sale_do_details where 1  order by id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $wo_amt[$info->id]=$info->total_amt;
		 $wo_qty[$info->id]=$info->total_unit;
		
		}
		
		
		
		  $sql = "select order_no, sum(total_unit) as total_unit, sum(total_amt) as total_amt  from sale_do_chalan where chalan_date <'".$f_date."'  group by by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pre_amt[$info->order_no]=$info->total_amt;
		 $pre_qty[$info->order_no]=$info->total_unit;
		
		}
		
		
	

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sc.chalan_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sm.do_no = "'.$_POST['do_no'].'" ';




		
		  $sql="select  d.dealer_name_e, b.buyer_name, m.merchandizer_name, sm.do_no, sm.do_date, sm.job_no, sm.marketing_team, sm.marketing_person, sm.status, 
		i.item_name, 
		
		
sc.chalan_no, sc.chalan_date, sc.style_no, sc.po_no, sc.destination, sc.referance, sc.sku_no, sc.pack_type, sc.color, sc.size, sc.ply, sc.L_cm, sc.W_cm, sc.H_cm, sc.measurement_unit, sc.paper_combination, sc.sqm_rate, sc.unit_name, sc.final_price, sc.unit_price, sc.printing_info, sc.additional_info, sc.additional_charge, sc.delivery_date, sc.delivery_place, sc.order_no, sum(sc.total_unit) as total_unit, sum(sc.total_amt) as total_amt, sc.vehicle_no,sc.delivery_man

		  from dealer_info d, buyer_info b, merchandizer_info m, sale_do_master sm, sale_do_chalan sc, item_info i 
		 where sm.do_no=sc.do_no  and sc.item_id=i.item_id and  d.dealer_code=sm.dealer_code and b.buyer_code=sm.buyer_code and m.merchandizer_code=sm.merchandizer_code
		  ".$date_wo.$customer_con.$buyer_con.$merchandizer_con.$job_con." group by sc.id order by sc.job_no, sc.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no?>"><?=$row->job_no?></a></td>
		<td><?=date("d-M-Y",strtotime($row->do_date))?></td>
		<td><?=$row->order_no?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/delivery_challan_print_view.php?v_no=<?=$row->chalan_no?>">
		  <?=$row->chalan_no?>
		</a></td>
		<td><?=date("d-M-Y",strtotime($row->chalan_date))?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$row->buyer_name?></td>
		<td><?=$row->merchandizer_name?></td>
		<td><?=find_a_field('marketing_team','team_name','team_code='.$row->marketing_team);?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><?=$row->style_no?></td>
		<td><?=$row->po_no?></td>
		<td><?=$row->destination?></td>
		<td><?=$row->referance?></td>
		<td><?=$row->sku_no?></td>
		<td><?=$row->pack_type?></td>
		<td><?=$row->color?></td>
		<td><?=$row->size?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->ply?></td>
<td><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?></td>
		<td><?=$row->paper_combination?></td>
		<td><?=$row->sqm_rate?></td>
		<td><?=$row->unit_name?></td>
		<td>$<?=$row->final_price?></td>
		<td>$<?=$row->unit_price?></td>
		<td><?= $wo_qty[$row->order_no];?></td>
		<td>$<?= $wo_amt[$row->order_no];?></td>
		<td><?=$row->total_unit;  $total_sales_qty +=$row->total_unit;?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?=find_a_field('printing_information','printing_information','id='.$row->printing_info);?></td>
		<td><?=find_a_field('additional_information','additional_information','id='.$row->additional_info);?></td>
		<td><?=$row->additional_charge?></td>
		<td><?php echo date('d-M-Y',strtotime($row->delivery_date));?></td>
		<td><?= find_a_field('delivery_place_info','delivery_place','id="'.$row->delivery_place.'"');?></td>
		<td><?= find_a_field('delivery_place_info','address_e','id="'.$row->delivery_place.'"');?></td>
		<td><?= $row->vehicle_no;?></td>
		<td><?= find_a_field('delivery_man','delivery_man','id="'.$row->delivery_man.'"');?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
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
		  <td><div align="right"><strong> TOTAL: </strong></div></td>
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
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=$total_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
	
		</tbody>
</table>
		<?
}







elseif($_POST['report']==210019)
{
		$report="FOC Delivery Details Report";	
			
		$customer_name = $_POST['customer_name'];
 		$customer=explode("->",$customer_name);
 		$customer[0];
 		if($_POST['customer_name']!='')
 		$customer_con=" and sm.dealer_code=".$customer[0];
		
		$buyer_info = $_POST['buyer'];
 		$buyer=explode("->",$buyer_info);
 		$buyer[0];
 		if($_POST['buyer']!='')
 		$buyer_con=" and sm.buyer_code=".$buyer[0];
		
		$merchandizer_info = $_POST['merchandizer'];
 		$merchandizer=explode("->",$merchandizer_info);
 		$merchandizer[0];
 		if($_POST['merchandizer']!='')
 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="1%" rowspan="2" bgcolor="#28AA6C">SL</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C">JOB No </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C">JOB_Date </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">TR_No </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">Challan No </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">Challan Date </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C">Customer Name </th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Buyer</span> Name </th>
		<th width="5%" rowspan="2" bgcolor="#28AA6C">Merchandiser Name </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Team </span></th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Person</span></th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Style No </th>
		<th width="1%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">PO No</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Destination</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Referance</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">SKU No</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Pack Type</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Color</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Size</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Item Name </th>
		<th width="1%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Ply</th>
		<th width="5%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"><strong>Measurement</strong></th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"><strong>Paper Combination</strong></th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Sqm Rate </th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">UOM</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Unit_Price</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"> Negotiated Price</th>
		<th colspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Challan </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Printing Info</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Addi. Info</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Addi. Charge</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Date</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Place</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Address </th>
		</tr>
		<tr height="30">
		  <th width="1%" bgcolor="#28AA6C" style="text-align:center">Qty</th>
		  <th width="3%" bgcolor="#28AA6C" style="text-align:center"> Amt ($)</th>
		  </tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select id, total_unit, total_amt from sale_do_details where 1  order by id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $wo_amt[$info->id]=$info->total_amt;
		 $wo_qty[$info->id]=$info->total_unit;
		
		}
		
		
		
		  $sql = "select order_no, sum(total_unit) as total_unit, sum(total_amt) as total_amt  from sale_do_chalan where chalan_date <'".$f_date."'  group by by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pre_amt[$info->order_no]=$info->total_amt;
		 $pre_qty[$info->order_no]=$info->total_unit;
		
		}
		
		
	

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sc.chalan_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sm.do_no = "'.$_POST['do_no'].'" ';



		
		

		
		  $sql="select  d.dealer_name_e, b.buyer_name, m.merchandizer_name, sm.foc_no, sm.do_no, sm.do_date, sm.job_no, sm.marketing_team, sm.marketing_person, sm.status, 
		i.item_name, 
		
		
sc.foc_chalan_no as chalan_no, sc.chalan_date, sc.style_no, sc.po_no, sc.destination, sc.referance, sc.sku_no, sc.pack_type, sc.color, sc.size, sc.ply, sc.L_cm, sc.W_cm, sc.H_cm, sc.measurement_unit, sc.paper_combination, sc.sqm_rate, sc.unit_name, sc.final_price, sc.unit_price, sc.printing_info, sc.additional_info, sc.additional_charge, sc.delivery_date, sc.delivery_place, sc.order_no, sum(sc.total_unit) as total_unit, sum(sc.total_amt) as total_amt

		  from dealer_info d, buyer_info b, merchandizer_info m, sale_foc_master sm, sale_foc_chalan sc, item_info i 
		 where sm.do_no=sc.do_no  and sc.item_id=i.item_id and  d.dealer_code=sm.dealer_code and b.buyer_code=sm.buyer_code and m.merchandizer_code=sm.merchandizer_code
		  ".$date_wo.$customer_con.$buyer_con.$merchandizer_con.$job_con." group by sc.id order by sc.job_no, sc.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/foc/foc_order_print_view.php?v_no=<?=$row->foc_no?>"><?=$row->job_no?></a></td>
		<td><?=date("d-M-Y",strtotime($row->do_date))?></td>
		<td><?=$row->order_no?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/foc/foc_challan_print_view.php?v_no=<?=$row->chalan_no?>">
		  <?=$row->chalan_no?>
		</a></td>
		<td><?=date("d-M-Y",strtotime($row->chalan_date))?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$row->buyer_name?></td>
		<td><?=$row->merchandizer_name?></td>
		<td><?=find_a_field('marketing_team','team_name','team_code='.$row->marketing_team);?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><?=$row->style_no?></td>
		<td><?=$row->po_no?></td>
		<td><?=$row->destination?></td>
		<td><?=$row->referance?></td>
		<td><?=$row->sku_no?></td>
		<td><?=$row->pack_type?></td>
		<td><?=$row->color?></td>
		<td><?=$row->size?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->ply?></td>
<td><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?></td>
		<td><?=$row->paper_combination?></td>
		<td><?=$row->sqm_rate?></td>
		<td><?=$row->unit_name?></td>
		<td>$<?=$row->final_price?></td>
		<td>$<?=$row->unit_price?></td>
		<td><?=$row->total_unit;  $total_sales_qty +=$row->total_unit;?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?=find_a_field('printing_information','printing_information','id='.$row->printing_info);?></td>
		<td><?=find_a_field('additional_information','additional_information','id='.$row->additional_info);?></td>
		<td><?=$row->additional_charge?></td>
		<td><?php echo date('d-M-Y',strtotime($row->delivery_date));?></td>
		<td><?= find_a_field('delivery_place_info','delivery_place','id="'.$row->delivery_place.'"');?></td>
		<td><?= find_a_field('delivery_place_info','address_e','id="'.$row->delivery_place.'"');?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
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
		  <td><div align="right"><strong> TOTAL: </strong></div></td>
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
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=$total_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
	
		</tbody>
</table>
		<?
}







elseif($_POST['report']==210017)
{
		$report="Delivery Cancel Details Report";	
			
		$customer_name = $_POST['customer_name'];
 		$customer=explode("->",$customer_name);
 		$customer[0];
 		if($_POST['customer_name']!='')
 		$customer_con=" and sm.dealer_code=".$customer[0];
		
		$buyer_info = $_POST['buyer'];
 		$buyer=explode("->",$buyer_info);
 		$buyer[0];
 		if($_POST['buyer']!='')
 		$buyer_con=" and sm.buyer_code=".$buyer[0];
		
		$merchandizer_info = $_POST['merchandizer'];
 		$merchandizer=explode("->",$merchandizer_info);
 		$merchandizer[0];
 		if($_POST['merchandizer']!='')
 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="1%" rowspan="2" bgcolor="#28AA6C">SL</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C">JOB No </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C">JOB_Date </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">TR_No </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">Challan No </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">Challan Date </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C">Customer Name </th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Buyer</span> Name </th>
		<th width="5%" rowspan="2" bgcolor="#28AA6C">Merchandiser Name </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Team </span></th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Person</span></th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Style No </th>
		<th width="1%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">PO No</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Destination</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Referance</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">SKU No</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Pack Type</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Color</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Size</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Item Name </th>
		<th width="1%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Ply</th>
		<th width="5%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"><strong>Measurement</strong></th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"><strong>Paper Combination</strong></th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Sqm Rate </th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">UOM</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Unit_Price</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"> Negotiated Price</th>
		<th colspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Challan </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Printing Info</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Addi. Info</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Addi. Charge</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Date</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Place</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Address </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Cancel Note</th>
		</tr>
		<tr height="30">
		  <th width="1%" bgcolor="#28AA6C" style="text-align:center">Qty</th>
		  <th width="3%" bgcolor="#28AA6C" style="text-align:center"> Amt ($)</th>
		  </tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select id, total_unit, total_amt from sale_do_details where 1  order by id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $wo_amt[$info->id]=$info->total_amt;
		 $wo_qty[$info->id]=$info->total_unit;
		
		}
		
		
		
		  $sql = "select order_no, sum(total_unit) as total_unit, sum(total_amt) as total_amt  from sale_do_chalan where chalan_date <'".$f_date."'  group by by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pre_amt[$info->order_no]=$info->total_amt;
		 $pre_qty[$info->order_no]=$info->total_unit;
		
		}
		
		
	

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sc.cancel_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sm.do_no = "'.$_POST['do_no'].'" ';



		
		

		
		  $sql="select  d.dealer_name_e, b.buyer_name, m.merchandizer_name, sm.do_no, sm.do_date, sm.job_no, sm.marketing_team, sm.marketing_person, sm.status, 
		i.item_name, 

sc.chalan_no, sc.chalan_date, sc.style_no, sc.po_no, sc.destination, sc.referance, sc.sku_no, sc.pack_type, sc.color, sc.size, sc.ply, sc.L_cm, sc.W_cm, sc.H_cm, sc.measurement_unit, sc.paper_combination, sc.sqm_rate, sc.unit_name, sc.final_price, sc.unit_price, sc.printing_info, sc.additional_info, sc.additional_charge, sc.delivery_date, sc.delivery_place, sc.order_no, sum(sc.total_unit) as total_unit, sum(sc.total_amt) as total_amt, sc.cancel_note

		  from dealer_info d, buyer_info b, merchandizer_info m, sale_do_master sm, sale_do_chalan_cancel sc, item_info i 
		 where sm.do_no=sc.do_no  and sc.item_id=i.item_id and  d.dealer_code=sm.dealer_code and b.buyer_code=sm.buyer_code and m.merchandizer_code=sm.merchandizer_code
		  ".$date_wo.$customer_con.$buyer_con.$merchandizer_con.$job_con." group by sc.id order by sc.job_no, sc.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no?>"><?=$row->job_no?></a></td>
		<td><?=date("d-M-Y",strtotime($row->do_date))?></td>
		<td><?=$row->order_no?></td>
		<td><a title="WO Preview" target="_blank"href="../../../sales_mod/pages/wo/cancel_challan_print_view.php?v_no=<?=$row->chalan_no?>">
		  <?=$row->chalan_no?>
		</a></td>
		<td><?=date("d-M-Y",strtotime($row->chalan_date))?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$row->buyer_name?></td>
		<td><?=$row->merchandizer_name?></td>
		<td><?=find_a_field('marketing_team','team_name','team_code='.$row->marketing_team);?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><?=$row->style_no?></td>
		<td><?=$row->po_no?></td>
		<td><?=$row->destination?></td>
		<td><?=$row->referance?></td>
		<td><?=$row->sku_no?></td>
		<td><?=$row->pack_type?></td>
		<td><?=$row->color?></td>
		<td><?=$row->size?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->ply?></td>
<td><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?></td>
		<td><?=$row->paper_combination?></td>
		<td><?=$row->sqm_rate?></td>
		<td><?=$row->unit_name?></td>
		<td>$<?=$row->final_price?></td>
		<td>$<?=$row->unit_price?></td>
		<td><?=$row->total_unit;  $total_sales_qty +=$row->total_unit;?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?=find_a_field('printing_information','printing_information','id='.$row->printing_info);?></td>
		<td><?=find_a_field('additional_information','additional_information','id='.$row->additional_info);?></td>
		<td><?=$row->additional_charge?></td>
		<td><?php echo date('d-M-Y',strtotime($row->delivery_date));?></td>
		<td><?= find_a_field('delivery_place_info','delivery_place','id="'.$row->delivery_place.'"');?></td>
		<td><?= find_a_field('delivery_place_info','address_e','id="'.$row->delivery_place.'"');?></td>
		<td><?=$row->cancel_note?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
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
		  <td><div align="right"><strong> TOTAL: </strong></div></td>
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
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=$total_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		  
		
		
		
		
		
		</tbody>
</table>
		<?
}








elseif($_POST['report']==210005)
{
		$report="Delivery Summary";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL</th>
		<th width="30%" bgcolor="#99FFFF">Marketing Person </th>
		<th width="12%" bgcolor="#99FFFF" style="text-align:center">Sum of Total Qty (Pcs) </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">Sum of Total Value </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}



		

		
		  $sql = "select m.marketing_person, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_chalan c, marketing_person p
		 where m.do_no=c.do_no and m.marketing_person=p.person_code and c.chalan_date between '".$f_date."' and '".$t_date."'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by m.marketing_person ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->marketing_person]=$info->sales_amt;
		 $sales_qty[$info->marketing_person]=$info->sales_qty;
		
		}
		
		
	
		
		
		if(isset($zone_id)) 		{$zon_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		 $sql_sub="select t.team_code, t.team_name from marketing_team t, sale_do_master s where  
		 s.marketing_team=t.team_code ".$zon_con." group by s.marketing_team";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		
		<tr>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->team_name?></strong></div></td>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff">&nbsp;</td>
		  </tr>
		
		
		
		<?
		

		
		 $sql="select  p.person_code, p.marketing_person_name from marketing_person p, sale_do_master s
		 where  p.person_code=s.marketing_person and p.team_code='".$info_sub->team_code."'  ".$con." group by s.marketing_person order by p.team_code,p.person_code";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td><?=$row->marketing_person_name?></td>
		<td><? if ($sales_qty[$row->person_code]>0) {?>
		  <?=$sales_qty[$row->person_code]; $total_sales_qty +=$sales_qty[$row->person_code]; ?>
		  <? }?></td>
		<td>$ &nbsp;&nbsp;&nbsp;<? if ($sales_amt[$row->person_code]>0) {?><?=number_format($sales_amt[$row->person_code],2); $total_sales_amt +=$sales_amt[$row->person_code]; ?><? }?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td bgcolor="#FFFFFF"><div align="right"><strong>SUB TOTAL: </strong></div></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    <?=$total_sales_qty; $total_total_sales_qty +=$total_sales_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    $ &nbsp;&nbsp;&nbsp;<?=number_format($total_sales_amt,2); $total_total_sales_amt +=$total_sales_amt;?>
		  </span></td>
		  </tr>
		  
		  <? 
		  $total_sales_qty = 0;
		  $total_sales_amt = 0;
		  $total_return_qty = 0;
		  $total_return_amt = 0;
		  $total_net_sales_qty = 0;
		  $total_net_sales_amt = 0;
		   }?>
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td bgcolor="#FFFFFF"><div align="right"><strong>GRAND TOTAL:</strong></div></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    <?=$total_total_sales_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    $ &nbsp;&nbsp;&nbsp;<?=number_format($total_total_sales_amt,2);?>
		  </span></td>
		  </tr>
		
		</tbody>
</table>
		<?
}









elseif($_POST['report']==210006)
{
		$report="Production Details Report";	
			
		$customer_name = $_POST['customer_name'];
 		$customer=explode("->",$customer_name);
 		$customer[0];
 		if($_POST['customer_name']!='')
 		$customer_con=" and sm.dealer_code=".$customer[0];
		
		$buyer_info = $_POST['buyer'];
 		$buyer=explode("->",$buyer_info);
 		$buyer[0];
 		if($_POST['buyer']!='')
 		$buyer_con=" and sm.buyer_code=".$buyer[0];
		
		$merchandizer_info = $_POST['merchandizer'];
 		$merchandizer=explode("->",$merchandizer_info);
 		$merchandizer[0];
 		if($_POST['merchandizer']!='')
 		$merchandizer_con=" and sm.merchandizer_code=".$merchandizer[0];
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:14px;">
		
		<thead>
		
		
		
		<tr height="30">
		<th width="1%" rowspan="2" bgcolor="#28AA6C">SL</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C">JOB No </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C">JOB_Date </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">TR_No </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">Issue No </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C">Issue Date </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C">Customer Name </th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Buyer</span> Name </th>
		<th width="5%" rowspan="2" bgcolor="#28AA6C">Merchandiser Name </th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Team </span></th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C"><span id="buyer_filter">Marketing Person</span></th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Style No </th>

		<th width="1%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">PO No</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Destination</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Referance</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">SKU No</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Pack Type</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Color</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Size</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Item Name </th>
		<th width="1%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Ply</th>
		<th width="5%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"><strong>Measurement</strong></th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"><strong>Paper Combination</strong></th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Sqm Rate </th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">UOM</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Unit_Price</th>
		<th width="4%" rowspan="2" bgcolor="#28AA6C" style="text-align:center"> Negotiated Price</th>
		<th colspan="2" bgcolor="#28AA6C" style="text-align:center">Order Qty </th>
		<th width="3%" colspan="2" bgcolor="#28AA6C" style="text-align:center">Previous  Production </th>
		<th colspan="2" bgcolor="#28AA6C" style="text-align:center">Production Quantity</th>
		<th width="3%" colspan="2" bgcolor="#28AA6C" style="text-align:center">Pending Qty </th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Printing Info</th>
		<th width="2%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Addi. Info</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Addi. Charge</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Date</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Place</th>
		<th width="3%" rowspan="2" bgcolor="#28AA6C" style="text-align:center">Delivery Address </th>
		</tr>
		<tr height="30">
		  <th width="2%" bgcolor="#28AA6C" style="text-align:center">Qty</th>
		  <th width="1%" bgcolor="#28AA6C" style="text-align:center"> Amt ($)</th>
		  <th width="1%" bgcolor="#28AA6C" style="text-align:center">Qty</th>
		  <th width="2%" bgcolor="#28AA6C" style="text-align:center"> Amt ($)</th>
		  <th width="1%" bgcolor="#28AA6C" style="text-align:center">Qty</th>
		  <th width="3%" bgcolor="#28AA6C" style="text-align:center"> Amt ($)</th>
		  <th width="1%" bgcolor="#28AA6C" style="text-align:center">Qty</th>
		  <th width="2%" bgcolor="#28AA6C" style="text-align:center"> Amt ($)</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 					{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
	

		
		  $sql = "select id, total_unit, total_amt from sale_do_details where 1  order by id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $wo_amt[$info->id]=$info->total_amt;
		 $wo_qty[$info->id]=$info->total_unit;
		
		}
		
		
		
		  $sql = "select order_no, sum(total_unit) as total_unit, sum(total_amt) as total_amt  from sale_do_production_issue where chalan_date <'".$f_date."'  group by by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pre_amt[$info->order_no]=$info->total_amt;
		 $pre_qty[$info->order_no]=$info->total_unit;
		
		}
		
		
	

		
		?>
		
		
		
		
		
		
		
		<?
		
		
		
			if($_POST['f_date']!=''&&$_POST['t_date']!='')

			$date_wo .= ' and sc.chalan_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
			
			
			if($_POST['do_no']!='')

			$job_con .= ' and sm.do_no = "'.$_POST['do_no'].'" ';



		
		

		
		  $sql="select  d.dealer_name_e, b.buyer_name, m.merchandizer_name, sm.do_no, sm.do_date, sm.job_no, sm.marketing_team, sm.marketing_person, sm.status, 
		i.item_name, 
		
		
sc.chalan_no, sc.chalan_date, sc.style_no, sc.po_no, sc.destination, sc.referance, sc.sku_no, sc.pack_type, sc.color, sc.size, sc.ply, sc.L_cm, sc.W_cm, sc.H_cm, sc.measurement_unit, sc.paper_combination, sc.sqm_rate, sc.unit_name, sc.final_price, sc.unit_price, sc.printing_info, sc.additional_info, sc.additional_charge, sc.delivery_date, sc.delivery_place, sc.order_no, sum(sc.total_unit) as total_unit, sum(sc.total_amt) as total_amt

		  from dealer_info d, buyer_info b, merchandizer_info m, sale_do_master sm, sale_do_production_issue sc, item_info i 
		 where sm.do_no=sc.do_no  and sc.item_id=i.item_id and  d.dealer_code=sm.dealer_code and b.buyer_code=sm.buyer_code and m.merchandizer_code=sm.merchandizer_code
		  ".$date_wo.$customer_con.$buyer_con.$merchandizer_con.$job_con." group by sc.order_no order by sc.job_no, sc.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		<td><?=$sl++;?></td>
		<td><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no?>"><?=$row->job_no?></a></td>
		<td><?=date("d-M-Y",strtotime($row->do_date))?></td>
		<td><?=$row->order_no?></td>
		<td><!--<a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/delivery_challan_print_view.php?v_no=<?=$row->chalan_no?>"></a>-->
		  <?=$row->chalan_no?>
		</td>
		<td><?=date("d-M-Y",strtotime($row->chalan_date))?></td>
		<td><?=$row->dealer_name_e?></td>
		<td><?=$row->buyer_name?></td>
		<td><?=$row->merchandizer_name?></td>
		<td><?=find_a_field('marketing_team','team_name','team_code='.$row->marketing_team);?></td>
		<td><?=find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><?=$row->style_no?></td>
		<td><?=$row->po_no?></td>
		<td><?=$row->destination?></td>
		<td><?=$row->referance?></td>
		<td><?=$row->sku_no?></td>
		<td><?=$row->pack_type?></td>
		<td><?=$row->color?></td>
		<td><?=$row->size?></td>
		<td><?=$row->item_name?></td>
		<td><?=$row->ply?></td>
<td><? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?></td>
		<td><?=$row->paper_combination?></td>
		<td><?=$row->sqm_rate?></td>
		<td><?=$row->unit_name?></td>
		<td>$
<?=$row->final_price?></td>
		<td>$
<?=$row->unit_price?></td>
		<td><?=$wo_qty[$row->order_no]; $tot_wo_qty +=$wo_qty[$row->order_no];?></td>
		<td>$<?=$wo_amt[$row->order_no]; $tot_wo_amt +=$wo_amt[$row->order_no];?></td>
		<td><?=$pre_qty[$row->order_no]; $tot_pre_qty +=$pre_qty[$row->order_no];?></td>
		<td>$<?=$pre_amt[$row->order_no]; $tot_pre_amt +=$pre_amt[$row->order_no];?></td>
		<td><?=$row->total_unit;  $total_sales_qty +=$row->total_unit;?></td>
		<td>
		  $<?=number_format($row->total_amt,2); $total_sales_amt +=$row->total_amt;?>		 </td>
		<td><?= $pending_qty = ($wo_qty[$row->order_no]-($pre_qty[$row->order_no]+$row->total_unit)); $total_pending_qty += $pending_qty;?></td>
		<td>$<?= $pending_amt = ($wo_amt[$row->order_no]-($pre_amt[$row->order_no]+$row->total_amt)); $total_pending_amt += $pending_amt;?></td>
		<td><?=find_a_field('printing_information','printing_information','id='.$row->printing_info);?></td>
		<td><?=find_a_field('additional_information','additional_information','id='.$row->additional_info);?></td>
		<td><?=$row->additional_charge?></td>
		<td><?php echo date('d-M-Y',strtotime($row->delivery_date));?></td>
		<td><?= find_a_field('delivery_place_info','delivery_place','id="'.$row->delivery_place.'"');?></td>
		<td><?= find_a_field('delivery_place_info','address_e','id="'.$row->delivery_place.'"');?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
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
		  <td><div align="right"><strong> TOTAL: </strong></div></td>
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
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><span class="style7">
		    <?=$tot_wo_qty;?>
		  </span></td>
		  <td><span class="style7">
		    $<?=number_format($tot_wo_amt,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=$tot_pre_qty;?>
		  </span></td>
		  <td><span class="style7">
		    $<?=number_format($tot_pre_amt,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=$total_sales_qty;?>
		  </span></td>
		  <td><span class="style7">
		    $<?=number_format($total_sales_amt,2);?>
		  </span></td>
		  <td><span class="style7">
		    <?=$total_pending_qty;?>
		  </span></td>
		  <td><span class="style7">
		    $<?=number_format($total_pending_amt,2);?>
		  </span></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		  
		
		
		
		
		
		</tbody>
</table>
		<?
}





elseif($_POST['report']==210007)
{
		$report="Production Summary";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL</th>
		<th width="30%" bgcolor="#99FFFF">Marketing Person </th>
		<th width="12%" bgcolor="#99FFFF" style="text-align:center">Sum of Total Qty (Pcs) </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">Sum of Total Value </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}



		

		
		  $sql = "select m.marketing_person, sum(c.total_amt) as sales_amt, sum(c.total_unit) as sales_qty  
		 from sale_do_master m, sale_do_production_issue c, marketing_person p
		 where m.do_no=c.do_no and m.marketing_person=p.person_code and c.chalan_date between '".$f_date."' and '".$t_date."'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by m.marketing_person ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $sales_amt[$info->marketing_person]=$info->sales_amt;
		 $sales_qty[$info->marketing_person]=$info->sales_qty;
		
		}
		
		
	
		
		
		if(isset($zone_id)) 		{$zon_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		 $sql_sub="select t.team_code, t.team_name from marketing_team t, sale_do_master s where  
		 s.marketing_team=t.team_code ".$zon_con." group by s.marketing_team";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		
		<tr>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->team_name?></strong></div></td>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff">&nbsp;</td>
		  </tr>
		
		
		
		<?
		

		
		 $sql="select  p.person_code, p.marketing_person_name from marketing_person p, sale_do_master s
		 where  p.person_code=s.marketing_person and p.team_code='".$info_sub->team_code."'  ".$con." group by s.marketing_person order by p.team_code,p.person_code";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td><?=$row->marketing_person_name?></td>
		<td><? if ($sales_qty[$row->person_code]>0) {?>
		  <?=$sales_qty[$row->person_code]; $total_sales_qty +=$sales_qty[$row->person_code]; ?>
		  <? }?></td>
		<td>$ &nbsp;&nbsp;&nbsp;<? if ($sales_amt[$row->person_code]>0) {?><?=number_format($sales_amt[$row->person_code],2); $total_sales_amt +=$sales_amt[$row->person_code]; ?><? }?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td bgcolor="#FFFFFF"><div align="right"><strong>SUB TOTAL: </strong></div></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    <?=$total_sales_qty; $total_total_sales_qty +=$total_sales_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    $ &nbsp;&nbsp;&nbsp;<?=number_format($total_sales_amt,2); $total_total_sales_amt +=$total_sales_amt;?>
		  </span></td>
		  </tr>
		  
		  <? 
		  $total_sales_qty = 0;
		  $total_sales_amt = 0;
		  $total_return_qty = 0;
		  $total_return_amt = 0;
		  $total_net_sales_qty = 0;
		  $total_net_sales_amt = 0;
		   }?>
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td bgcolor="#FFFFFF"><div align="right"><strong>GRAND TOTAL:</strong></div></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    <?=$total_total_sales_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    $ &nbsp;&nbsp;&nbsp;<?=number_format($total_total_sales_amt,2);?>
		  </span></td>
		  </tr>
		
		</tbody>
</table>
		<?
}







elseif($_POST['report']==210704001)
{
		$report="PI Approval Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" id="ExportTable"  cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL</th>
		<th width="8%" bgcolor="#99FFFF">TR No </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">TR Date </th>
		<th width="17%" bgcolor="#99FFFF" style="text-align:center">Document Type</th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Approved Date </th>
		 <th width="16%" bgcolor="#99FFFF" style="text-align:center">Approved ID </th>
		  
		 <th width="15%" bgcolor="#99FFFF" style="text-align:center">Approved By</th>
		<th width="17%" bgcolor="#99FFFF" style="text-align:center">Approved At</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $pi_date_con .= ' and a.app_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
	
		
		 $sql="select  a.* from management_approval_history a where 1 ".$pi_date_con." group by a.id order by a.app_date, a.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td>
		<? if ($row->tr_type=="Individual PI" || $row->tr_type=="Combined PI") {?>
		<a title="PI Preview" target="_blank" href="../pi/pi_print_view.php?v_no=<?=$row->tr_no?>"><?=$row->tr_no_view?></a>
		<? }?>
		<? if ($row->tr_type=="Master PI") {?>
		<a title="PI Preview" target="_blank" href="../pi/master_pi_print_view.php?v_no=<?=$row->tr_no?>"><?=$row->tr_no_view?></a>
		<? }?>
		
		
		<? if ($row->tr_type=="Work Order" || $row->tr_type=="WO Hold" || $row->tr_type=="WO Unhold" || $row->tr_type=="WO Canceled") {?>
		<a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->tr_no?>"><?=$row->tr_no_view?></a>
		<? }?>
		
		</td>
		<td><?php echo date('d-M-Y',strtotime($row->tr_date));?></td>
		<td><?=$row->tr_type?></td>
		<td><?php echo date('d-M-Y',strtotime($row->app_date));?></td>
		<td><?=$row->digital_sign?></td>
		<td><?= find_a_field('user_activity_management','fname','user_id='.$row->checked_by);?></td>
		<td><?=$row->checked_at?></td>
		</tr>
<?  }?>
		
		  
	
		
		
		
		</tbody>
</table>
		<?
}








elseif($_POST['report']==210704002)
{
		$report="PI Brief Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL</th>
		<th width="8%" bgcolor="#99FFFF">PI No </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Job No </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">PI Date </th>
		<th width="17%" bgcolor="#99FFFF" style="text-align:center">Customer Name </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">PI Type </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">PI Value </th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Prepared By</th>
		<th width="21%" bgcolor="#99FFFF" style="text-align:center">Approved By</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $pi_date_con .= ' and m.pi_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and m.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and m.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			if($_POST['pi_type']!='')

			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';
		 
	
		
		 $sql="select  m.id, m.pi_no, m.pi_date, m.pi_type, m.dealer_code, m.entry_by, m.entry_at, m.checked_by, m.checked_at, sum(d.total_amt) as total_amt, d.job_no, d.do_no from  pi_master m, pi_details d  where m.id=d.pi_id   ".$pi_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by d.pi_id order by m.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td>
		
		
		<? if ($row->pi_type==1 || $row->pi_type==3){  ?><a href="../pi/pi_print_view.php?v_no=<?=$row->id;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;"> <?=$row->pi_no;?></a><? }?>
<? if ($row->pi_type==2){  ?><a href="../pi/master_pi_print_view.php?v_no=<?=$row->id;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;"> <?=$row->pi_no;?></a><? }?>		</td>
		<td><? if ($row->pi_type==1){  ?><a href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;">
		 <?=$row->job_no;?></a><? }?></td>
		<td><?php echo date('d-m-Y',strtotime($row->pi_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= find_a_field('pi_type','pi_type','id='.$row->pi_type);?></td>
		<td>$ <?=number_format($row->total_amt,2); $total_total_amt +=$row->total_amt;?></td>
		<td><?= find_a_field('user_activity_management','fname','user_id='.$row->entry_by);?></td>
		<td><?= find_a_field('user_activity_management','fname','user_id='.$row->checked_by);?></td>
		</tr>
<?  }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		  
	
		
		
		
		</tbody>
</table>
		<?
}









elseif($_POST['report']==220209001)
{
		$report="Backup Individual PI Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL</th>
		<th width="8%" bgcolor="#99FFFF">PI No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Job No </th>
		<th width="5%" bgcolor="#99FFFF" style="text-align:center">PI Date </th>
		<th width="4%" bgcolor="#99FFFF" style="text-align:center">Master PI </th>
		<th width="17%" bgcolor="#99FFFF" style="text-align:center">Customer Name </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">PI Type </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">PI Value </th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Prepared By</th>
		<th width="21%" bgcolor="#99FFFF" style="text-align:center">Approved By</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $pi_date_con .= ' and m.pi_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and m.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and m.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			if($_POST['pi_type']!='')

			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';
			
			
			
			$sql = "select pi_no, do_no from pi_details  where 1 group by do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pi_no[$info->do_no]=$info->pi_no;
		
		}
		 
	
		
		 $sql="select  m.id, m.pi_no, m.pi_date, m.pi_type, m.dealer_code, m.entry_by, m.entry_at, m.checked_by, m.checked_at, sum(d.total_amt) as total_amt, d.job_no, d.do_no from  pi_master m, pi_details_backup d  where m.id=d.pi_id  and m.pi_type=1 ".$pi_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by d.pi_id order by m.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td>
		
		
		<a href="../pi/backup_pi_print_view.php?v_no=<?=$row->id;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;"> <?=$row->pi_no;?></a></td>
		<td><? if ($row->pi_type==1){  ?><a href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;">
		 <?=$row->job_no;?></a><? }?></td>
		<td><?php echo date('d-m-Y',strtotime($row->pi_date));?></td>
		<td><?=$pi_no[$row->do_no];?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= find_a_field('pi_type','pi_type','id='.$row->pi_type);?></td>
		<td>$ <?=number_format($row->total_amt,2); $total_total_amt +=$row->total_amt;?></td>
		<td><?= find_a_field('user_activity_management','fname','user_id='.$row->entry_by);?></td>
		<td><?= find_a_field('user_activity_management','fname','user_id='.$row->checked_by);?></td>
		</tr>
<?  }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		  
	
		
		
		
		</tbody>
</table>
		<?
}











elseif($_POST['report']==210704003)
{
		$report="LC Pending Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="1%" bgcolor="#99FFFF">SL</th>
		<th width="5%" bgcolor="#99FFFF">PI No </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">PI Date </th>
		<th width="10%" bgcolor="#99FFFF" style="text-align:center">Job No </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Delivery Status</th>
		<th width="9%" bgcolor="#99FFFF" style="text-align:center">Last Delivery Date </th>
		<th width="17%" bgcolor="#99FFFF" style="text-align:center">Customer Name </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">PI Type </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">PI Value </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Delay Days</th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">Prepared By</th>
		<th width="10%" bgcolor="#99FFFF" style="text-align:center">Approved By</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $pi_date_con .= ' and m.pi_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and m.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and m.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			if($_POST['pi_type']!='')

			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';
			
			
			
			
		 $sql = "select pi_id, pi_no, lc_no_view  from lc_receive where 1";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pi_no[$info->pi_id]=$info->pi_no;
		 $lc_no_view[$info->pi_id]=$info->lc_no_view;
		}
		
		
		$sql = "select do_no, job_no, status  from sale_do_master where 1";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $status[$info->do_no]=$info->status;
		 $job_no[$info->do_no]=$info->job_no;
		
		}
		
		
		$sql = "select do_no, max(chalan_date) as last_chalan_date from sale_do_chalan where 1 group by  do_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $last_chalan_date[$info->do_no]=$info->last_chalan_date;
		
		}
			
		 
	
		
		 $sql="select  m.id, m.pi_no, m.pi_date, m.pi_type, m.dealer_code, m.entry_by, m.entry_at, m.checked_by, m.checked_at, sum(d.total_amt) as total_amt, d.do_no from  pi_master m, pi_details d  where m.id=d.pi_id  and  m.pi_type=1 ".$pi_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by d.pi_id order by m.id";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
		
		
		
		$today_date = date("Y-m-d");
		$acknow_date = strtotime($today_date);
		$chalan_date = strtotime($last_chalan_date[$row->do_no]);
		$datediff = $acknow_date - $chalan_date;
		$delay_days =  round($datediff / (60 * 60 * 24));

		if($lc_no_view[$row->id]==""){
		
		if($status[$row->do_no]=='COMPLETED'){
		
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td>
		
		
		<? if ($row->pi_type==1 || $row->pi_type==3){  ?><a href="../pi/pi_print_view.php?v_no=<?=$row->id;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;"> <?=$row->pi_no;?></a><? }?>
<? if ($row->pi_type==2){  ?><a href="../pi/master_pi_print_view.php?v_no=<?=$row->id;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;"> <?=$row->pi_no;?></a><? }?>		</td>
		<td><?php echo date('d-m-Y',strtotime($row->pi_date));?></td>
		<td><?=$job_no[$row->do_no]?></td>
		<td>
		<? if ($row->pi_type==1){  ?>
		<?
			if ($status[$row->do_no]=='COMPLETED') {
			echo $status[$row->do_no];
			}else {
			echo 'DELIVERY PENDING';
			}
		?>
		<? }?>		</td>
		<td><?php echo date('d-m-Y',strtotime($last_chalan_date[$row->do_no]));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= find_a_field('pi_type','pi_type','id='.$row->pi_type);?></td>
		<td>$ <?=number_format($row->total_amt,2); $total_total_amt +=$row->total_amt;?></td>
		<td><? if ($delay_days>0) {?>
			<?=$delay_days;?>
		<? }?></td>
		<td><?= find_a_field('user_activity_management','fname','user_id='.$row->entry_by);?></td>
		<td><?= find_a_field('user_activity_management','fname','user_id='.$row->checked_by);?></td>
		</tr>
<? } } }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		  
	
		
		
		
		</tbody>
</table>
		<?
}









elseif($_POST['report']==210704004)
{
		$report="LC Pending Statement";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="4%" bgcolor="#99FFFF">SL</th>
		<th width="8%" bgcolor="#99FFFF">PI No </th>
		<th width="9%" bgcolor="#99FFFF" style="text-align:center">PI Date </th>
		<th width="20%" bgcolor="#99FFFF" style="text-align:center">Customer Name </th>
		<th width="10%" bgcolor="#99FFFF" style="text-align:center">PI Value </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">Status</th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">Delay Days</th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center">Prepared By</th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Approved By</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		// if($_POST['f_date']!=''&&$_POST['t_date']!='') $wo_date_con .= ' and m.pi_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $pi_date_con .= ' and m.pi_date  <= "'.$_POST['t_date'].'"';
		 
		 
		
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and m.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and m.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			if($_POST['pi_type']!='')

			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';
			
			
			
			
		 $sql = "select pi_id, pi_no, lc_no_view  from lc_receive where 1";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pi_no[$info->pi_id]=$info->pi_no;
		 $lc_no_view[$info->pi_id]=$info->lc_no_view;
		}
		
	
	
		 $sql="select  m.id, m.pi_no, m.pi_date, m.pi_type,  m.dealer_code, m.entry_by, m.entry_at,  m.checked_by, sum(d.total_amt) as total_amt, m.status, d.do_no, d.job_no
		  from  pi_master m, pi_details d  where m.id=d.pi_id  ".$pi_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by d.pi_id order by m.pi_date desc";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
		
		
		
		$today_date = date("Y-m-d");
		$acknow_date = strtotime($today_date);
		$chalan_date = strtotime($row->pi_date);
		$datediff = $acknow_date - $chalan_date;
		$delay_days =  round($datediff / (60 * 60 * 24));

		if($lc_no_view[$row->id]==""){ 
		
	//if($row->do_no !=$do_no[$row->do_no]){}
		
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td>
		

		<? if ($row->pi_type==1 || $row->pi_type==3){  ?><a href="../pi/pi_print_view.php?v_no=<?=$row->id;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;"> <?=$row->pi_no;?></a><? }?>
<? if ($row->pi_type==2){  ?><a href="../pi/master_pi_print_view.php?v_no=<?=$row->id;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700;"> <?=$row->pi_no;?></a><? }?>	</td>
		<td><?php echo date('d-m-Y',strtotime($row->pi_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td>$ <?=number_format($row->total_amt,2); $total_total_amt +=$row->total_amt;?></td>
		<td><?=$row->status?></td>
		<td>
		<? if ($delay_days>0) {?>
			<?=$delay_days;?>
		<? }?>
		</td>
		<td><?= find_a_field('user_activity_management','fname','user_id='.$row->entry_by);?></td>
		<td><?= find_a_field('user_activity_management','fname','user_id='.$row->checked_by);?></td>
		</tr>
<? } } ?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>	
		
		</tbody>
</table>
		<?
}





elseif($_POST['report']==210704005)
{
		$report="Sales Statement";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		<? if($_POST['lc_report_type']==1) {?>
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="1%" bgcolor="#99FFFF">SL</th>
		<th width="5%" bgcolor="#99FFFF">WO No </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">WO Date </th>
		<th width="17%" bgcolor="#99FFFF" style="text-align:center">Customer Name </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Buyer Name</th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Merchandiser</th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Marketing Person</th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">WO Qty </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">WO Value </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">PI No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">PI Value </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Delivery Qty </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Delivery Value </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Delivery Date </th>
		 <th width="7%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		 <th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		 <th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		 <th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Expiry Date </th>
		 <th width="8%" bgcolor="#99FFFF" style="text-align:center">Delay </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $wo_date_con .= ' and m.do_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and m.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and m.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			if($_POST['pi_type']!='')

			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';
			
			
			
		$sql = "select do_no, do_no as dump_do_no, job_no  from dump_so where 1 group by  do_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $dump_do_no[$info->do_no]=$info->dump_do_no;

		}
		
		
		$sql = "select buyer_code, buyer_name  from buyer_info where 1 group by  buyer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $buyer_name[$info->buyer_code]=$info->buyer_name;
		}
		
		$sql = "select merchandizer_code, merchandizer_name  from merchandizer_info where 1 group by  merchandizer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $merchandizer_name[$info->merchandizer_code]=$info->merchandizer_name;
		}
		
		
	$sql = "select person_code, marketing_person_name  from marketing_person where 1 group by  person_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $marketing_person_name[$info->person_code]=$info->marketing_person_name;
		}
			
			
		 $sql = "select a.export_lc_date, a.expiry_date, a.export_lc_no, b.do_no, sum(b.total_amt) as lc_value  from lc_master a, lc_receive_details b where a.lc_no=b.lc_no group by b.do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $export_lc_date[$info->do_no]=$info->export_lc_date;
		 $expiry_date[$info->do_no]=$info->expiry_date;
		 $lc_value[$info->do_no]=$info->lc_value;
		 $export_lc_no[$info->do_no]=$info->export_lc_no;
		}
		
		
		
		
		
		$sql = "select do_no, max(chalan_date) as last_chalan_date, sum(total_unit) as delivery_qty, sum(total_amt) as delivery_amt   from sale_do_chalan where 1 group by  do_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $last_chalan_date[$info->do_no]=$info->last_chalan_date;
		 $delivery_qty[$info->do_no]=$info->delivery_qty;
		 $delivery_amt[$info->do_no]=$info->delivery_amt;
		
		}
		
		
		 $pi_sql = "SELECT   pi_id, do_no, pi_no, sum(total_amt) as total_amt FROM pi_details WHERE 1 GROUP by do_no ";
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$pi_no[$pi_data->do_no] = $pi_data->pi_no;		
			$pi_total_amt[$pi_data->do_no] = $pi_data->total_amt;
			}
			
		 
	
		
		 $sql="select  m.do_no, m.job_no, m.do_date, m.buyer_code, m.merchandizer_code, m.marketing_person, m.dealer_code, m.entry_by, m.entry_at,  sum(d.total_amt) as total_amt, sum(d.total_unit) as total_unit
		  from  sale_do_master m, sale_do_details d  where m.do_no=d.do_no and m.status!='CANCELED'  ".$wo_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by d.do_no order by m.do_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
		
		
		
		

		//if($lc_no_view[$row->id]==""){ }
	
		
		//if($dump_do_no[$row->do_no]==0){ }
		
		
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td>
		
	<a href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700; text-decoration:none;"> <?=$row->job_no;?></a>	</td>
		<td><?php echo date('d-M-Y',strtotime($row->do_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= $buyer_name[$row->buyer_code];?></td>
		<td><?= $merchandizer_name[$row->merchandizer_code];?></td>
		<td><?= $marketing_person_name[$row->marketing_person];?></td>
		<td><?=number_format($row->total_unit,0); $total_total_unit +=$row->total_unit;?></td>
		<td>$ <?=number_format($row->total_amt,2); $total_total_amt +=$row->total_amt;?></td>
		<td><?=$pi_no[$row->do_no];?></td>
		<td>$
		  <?=number_format($pi_total_amt[$row->do_no],2); $total_pi_total_amt +=$pi_total_amt[$row->do_no];?></td>
		<td><?=number_format($delivery_qty[$row->do_no],0); $total_delivery_qty +=$delivery_qty[$row->do_no];?></td>
		<td>$
		  <?=number_format($delivery_amt[$row->do_no],2); $total_delivery_amt +=$delivery_amt[$row->do_no];?></td>
		<td><? if($last_chalan_date[$row->do_no]!="") {?><?php echo date('d-M-Y',strtotime($last_chalan_date[$row->do_no]));?><? }?>
		
		
		<?php /*?><?  
$o=0;
		 $po_sql = 'SELECT  chalan_no FROM sale_do_chalan
		 WHERE  do_no="'.$row->do_no.'" GROUP by chalan_no ';
			$po_query=db_query($po_sql);
			while($po_data= mysqli_fetch_object($po_query)){
			$o++;
			if ($o>1) echo ', ';
echo $po_data->chalan_no;}?><?php */?>		</td>
		<td><?=$export_lc_no[$row->do_no];?></td>
		<td>$
		  <?=number_format($lc_value[$row->do_no],2); $total_lc_value +=$lc_value[$row->do_no];?></td>
		<td><? if($export_lc_date[$row->do_no]!="") {?>
		  <?php echo date('d-M-Y',strtotime($export_lc_date[$row->do_no]));?>
		  <? }?></td>
		<td><? if($expiry_date[$row->do_no]!="") {?>
		  <?php echo date('d-M-Y',strtotime($expiry_date[$row->do_no]));?>
		  <? }?></td>
		<td>
		
		<?
		
		$today_date = date("Y-m-d");
		$acknow_date = strtotime($today_date);
		$chalan_date = strtotime($last_chalan_date[$row->do_no]);
		$datediff = $acknow_date - $chalan_date;
		$delay_days =  round($datediff / (60 * 60 * 24));
		
		?>
		<? if ($lc_value[$row->do_no]==0 && $delivery_qty[$row->do_no]>0) {?>
		<?=$delay_days;?>
		<? }?>		</td>
		</tr>
<? } ?>



		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong><?=number_format($total_total_unit,2);?>
		  </strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td><strong>$<?=number_format($total_pi_total_amt,2);?>
		  </strong></td>
		<td><strong>
		  <?=number_format($total_delivery_qty,2);?>
        </strong></td>
		<td><strong>$<?=number_format($total_delivery_amt,2);?>
		  </strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>$<?=number_format($total_lc_value,2);?>
        </strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>	
		
		</tbody>
</table>
<? }?>




<? if($_POST['lc_report_type']==2) {?>
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="1%" bgcolor="#99FFFF">SL</th>
		<th width="5%" bgcolor="#99FFFF">WO No </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">WO Date </th>
		<th width="17%" bgcolor="#99FFFF" style="text-align:center">Customer Name </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Buyer Name</th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Merchandiser</th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Marketing Person</th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">WO Qty </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">WO Value </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">PI No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">PI Value </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Delivery Qty </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Delivery Value </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Delivery Date </th>
		 <th width="7%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		 <th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		 <th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		 <th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Expiry Date </th>
		 <th width="8%" bgcolor="#99FFFF" style="text-align:center">Delay </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $wo_date_con .= ' and m.do_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and m.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and m.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			if($_POST['pi_type']!='')

			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';
			
			
				
		$sql = "select do_no, do_no as dump_do_no, job_no  from dump_so where 1 group by  do_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $dump_do_no[$info->do_no]=$info->dump_do_no;

		}
		
		
	$sql = "select buyer_code, buyer_name  from buyer_info where 1 group by  buyer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $buyer_name[$info->buyer_code]=$info->buyer_name;
		}
		
			$sql = "select merchandizer_code, merchandizer_name  from merchandizer_info where 1 group by  merchandizer_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $merchandizer_name[$info->merchandizer_code]=$info->merchandizer_name;
		}
		
		
	$sql = "select person_code, marketing_person_name  from marketing_person where 1 group by  person_code ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $marketing_person_name[$info->person_code]=$info->marketing_person_name;
		}
				
			
		 $sql = "select a.export_lc_date, a.expiry_date, a.export_lc_no, b.do_no, sum(b.total_amt) as lc_value  from lc_master a, lc_receive_details b where a.lc_no=b.lc_no group by b.do_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $export_lc_date[$info->do_no]=$info->export_lc_date;
		 $expiry_date[$info->do_no]=$info->expiry_date;
		 $lc_value[$info->do_no]=$info->lc_value;
		 $export_lc_no[$info->do_no]=$info->export_lc_no;
		}
		
		
		
		
		
		$sql = "select do_no, max(chalan_date) as last_chalan_date, sum(total_unit) as delivery_qty, sum(total_amt) as delivery_amt   from sale_do_chalan where 1 group by  do_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $last_chalan_date[$info->do_no]=$info->last_chalan_date;
		 $delivery_qty[$info->do_no]=$info->delivery_qty;
		 $delivery_amt[$info->do_no]=$info->delivery_amt;
		
		}
		
		
		 $pi_sql = "SELECT   pi_id, do_no, pi_no, sum(total_amt) as total_amt FROM pi_details WHERE 1 GROUP by do_no ";
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$pi_no[$pi_data->do_no] = $pi_data->pi_no;		
			$pi_total_amt[$pi_data->do_no] = $pi_data->total_amt;
			}
			
		 
	
		
		 $sql="select  m.do_no, m.job_no, m.do_date, m.buyer_code, m.merchandizer_code, m.marketing_person,  m.dealer_code, m.entry_by, m.entry_at,  sum(d.total_amt) as total_amt, sum(d.total_unit) as total_unit
		  from  sale_do_master m, sale_do_details d  where m.do_no=d.do_no  and m.status!='CANCELED' ".$wo_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by d.do_no order by m.do_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{
		
		
		
		

		//if($lc_no_view[$row->id]==""){ }
		//if($dump_do_no[$row->do_no]==0){}
		
		if($lc_value[$row->do_no]==0){
		
		
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td>
		
	<a href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$row->do_no;?>" target="_blank" style=" color:#000000; font-size:12px; font-weight:700; text-decoration:none;"> <?=$row->job_no;?></a>	</td>
		<td><?php echo date('d-M-Y',strtotime($row->do_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= $buyer_name[$row->buyer_code];?></td>
		<td><?= $merchandizer_name[$row->merchandizer_code];?></td>
		<td><?= $marketing_person_name[$row->marketing_person];?></td>
		<td><?=number_format($row->total_unit,0); $total_total_unit +=$row->total_unit;?></td>
		<td>$ <?=number_format($row->total_amt,2); $total_total_amt +=$row->total_amt;?></td>
		<td><?=$pi_no[$row->do_no];?></td>
		<td>$
		  <?=number_format($pi_total_amt[$row->do_no],2); $total_pi_total_amt +=$pi_total_amt[$row->do_no];?></td>
		<td><?=number_format($delivery_qty[$row->do_no],0); $total_delivery_qty +=$delivery_qty[$row->do_no];?></td>
		<td>$
		  <?=number_format($delivery_amt[$row->do_no],2); $total_delivery_amt +=$delivery_amt[$row->do_no];?></td>
		<td><? if($last_chalan_date[$row->do_no]!="") {?><?php echo date('d-M-Y',strtotime($last_chalan_date[$row->do_no]));?><? }?>
		
		
		<?php /*?><?  
$o=0;
		 $po_sql = 'SELECT  chalan_no FROM sale_do_chalan
		 WHERE  do_no="'.$row->do_no.'" GROUP by chalan_no ';
			$po_query=db_query($po_sql);
			while($po_data= mysqli_fetch_object($po_query)){
			$o++;
			if ($o>1) echo ', ';
echo $po_data->chalan_no;}?><?php */?>		</td>
		<td><?=$export_lc_no[$row->do_no];?></td>
		<td>$
		  <?=number_format($lc_value[$row->do_no],2); $total_lc_value +=$lc_value[$row->do_no];?></td>
		<td><? if($export_lc_date[$row->do_no]!="") {?>
		  <?php echo date('d-M-Y',strtotime($export_lc_date[$row->do_no]));?>
		  <? }?></td>
		<td><? if($expiry_date[$row->do_no]!="") {?>
		  <?php echo date('d-M-Y',strtotime($expiry_date[$row->do_no]));?>
		  <? }?></td>
		<td>
		
		<?
		
		$today_date = date("Y-m-d");
		$acknow_date = strtotime($today_date);
		$chalan_date = strtotime($last_chalan_date[$row->do_no]);
		$datediff = $acknow_date - $chalan_date;
		$delay_days =  round($datediff / (60 * 60 * 24));
		
		?>
		<? if ($lc_value[$row->do_no]==0 && $delivery_qty[$row->do_no]>0) {?>
		<?=$delay_days;?>
		<? }?>		</td>
		</tr>
<? }  } ?>



		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong><?=number_format($total_total_unit,2);?>
		  </strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td><strong>$<?=number_format($total_pi_total_amt,2);?>
		  </strong></td>
		<td><strong>
		  <?=number_format($total_delivery_qty,2);?>
        </strong></td>
		<td><strong>$<?=number_format($total_delivery_amt,2);?>
		  </strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>$<?=number_format($total_lc_value,2);?>
        </strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>	
		
		</tbody>
</table>
<? }?>




		<?
}





elseif($_POST['report']==210802001001)
{
		$report="LC Received Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Rec. Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Expiry Date </th>
		<th width="16%" bgcolor="#99FFFF" style="text-align:center">Applicant Name</th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Applicant Bank </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">Tenor</th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center">Concern</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $lc_date_con .= ' and a.lc_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and b.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and a.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			//if($_POST['pi_type']!='')
//
//			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';
		 
	
		
		  $sql="select a.lc_no_view, a.lc_no, a.lc_date, a.export_lc_no, a.export_lc_date, a.expiry_date, a.dealer_code, a.bank_buyers, a.tenor_days, sum(c.total_amt) as total_amt, b.marketing_person  from  lc_master a, lc_receive b, pi_details c  where a.lc_no=b.lc_no  and b.pi_id=c.pi_id ".$lc_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by b.lc_no order by a.lc_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$row->lc_no_view;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->lc_date));?></td>
		<td><?=$row->export_lc_no;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->export_lc_date));?></td>
		<td><?php echo date('d-m-Y',strtotime($row->expiry_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= find_a_field('bank_buyers','bank_name','bank_id='.$row->bank_buyers);?></td>
		<td>$ <?=number_format($row->total_amt,2); $total_total_amt +=$row->total_amt;?></td>
		<td><?= find_a_field('tenor_days','tenor_type','tenor_days='.$row->tenor_days);?></td>
		<td><?= find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		</tr>
<?  }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		  
	
		
		
		
		</tbody>
</table>
		<?
}






elseif($_POST['report']==210802001)
{
		$report="LC Received Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL </th>
		<th width="6%" bgcolor="#99FFFF">Job No </th>
		<th width="6%" bgcolor="#99FFFF">PI No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Rec. Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Expiry Date </th>
		<th width="16%" bgcolor="#99FFFF" style="text-align:center">Applicant Name</th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Applicant Bank </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">Tenor</th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center">Concern</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $lc_date_con .= ' and a.lc_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and b.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and a.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			//if($_POST['pi_type']!='')
//
//			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';
		 

			 $po_sql = "SELECT  c.job_no,b.lc_no FROM lc_master a, lc_receive b, pi_details c 
			 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id ".$lc_date_con.$pi_con.$customer_con." group by c.do_no ";
			$po_query=db_query($po_sql);
			while($po_data= mysqli_fetch_object($po_query)){
			$lc_count[$po_data->lc_no]++;
			$job_no[$po_data->lc_no][] = $po_data->job_no;
			}
			
			
			 $pi_sql = "SELECT  c.pi_no, b.lc_no FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id ".$lc_date_con.$pi_con.$customer_con." GROUP by c.pi_id ";
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$pi_count[$pi_data->lc_no]++;
			$pi_no[$pi_data->lc_no][] = $pi_data->pi_no;
			}
			
			
			 $lc_sql = "SELECT  c.pi_no, b.lc_no, sum(c.total_amt) as lc_value FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id ".$lc_date_con.$pi_con.$customer_con." GROUP by a.lc_no ";
			$lc_query=db_query($lc_sql);
			while($lc_data= mysqli_fetch_object($lc_query)){
			$lc_value[$lc_data->lc_no] = $lc_data->lc_value;
			}
			
			 $sql = "SELECT  d.dealer_code, d.dealer_name_e as dealer_name FROM dealer_info d  WHERE 1";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$dealer_name[$data->dealer_code] = $data->dealer_name;
			}
			
			
			 $sql = "SELECT  b.bank_id, b.bank_name as bank_name FROM  bank_buyers b  WHERE 1";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$bank_name[$data->bank_id] = $data->bank_name;
			}
			
			 $sql = "SELECT  b.tenor_days, b.tenor_type as tenor_type FROM  tenor_days b  WHERE 1 ";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$tenor_type[$data->tenor_days] = $data->tenor_type;
			}
			
			
			$sql = "SELECT  b.person_code, b.marketing_person_name as marketing_person_name FROM  marketing_person b WHERE 1 ";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$marketing_person_name[$data->person_code] = $data->marketing_person_name;
			}
			
			
			
			
		  $sql="select a.lc_no_view, a.lc_no, a.lc_date, a.export_lc_no, a.export_lc_date, a.expiry_date, a.dealer_code, a.bank_buyers, a.tenor_days,  b.marketing_person  from  lc_master a, lc_receive b  where a.lc_no=b.lc_no  ".$lc_date_con.$pi_con.$customer_con." group by b.lc_no order by a.lc_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{	
			
		$pi++;
			
		$lc_no_view[] = $row->lc_no_view;
		$lc_date[] = $row->lc_date;
		$lc_no[] = $row->lc_no;
		
		$export_lc_no[] = $row->export_lc_no;
		$export_lc_date[] = $row->export_lc_date;
		$expiry_date[] = $row->expiry_date;
		$dealer_code[] = $row->dealer_code;
		$bank_buyers[] = $row->bank_buyers;
		$tenor_days[] = $row->tenor_days;
		$marketing_person[] = $row->marketing_person;
		//$total_amt[] = $row->total_amt;
		
		}
		?>
		
		<? for($i=0;$i<$pi;$i++){?>
		
		<tr>
		<td><?=$lc_no_view[$i]?></td>
		<td>

<? for($s=0;$s<$lc_count[$lc_no[$i]];$s++){?>

<?=$job_no[$lc_no[$i]][$s];?>

<? }?>
		
		</td>
		<td>
		
		
<? for($p=0;$p<$pi_count[$lc_no[$i]];$p++){?>

<?=$pi_no[$lc_no[$i]][$p];?>

<? }?>
	</td>
		<td><?php echo date('d-M-Y',strtotime($lc_date[$i]));?></td>
		<td><?=$export_lc_no[$i]?></td>
		<td><?php echo date('d-M-Y',strtotime($export_lc_date[$i]));?></td>
		<td><?php echo date('d-M-Y',strtotime($expiry_date[$i]));?></td>
		<td><?= $dealer_name[$dealer_code[$i]]?></td>
		<td><?= $bank_name[$bank_buyers[$i]]?></td>
		<td>$ <?=number_format($lc_value[$lc_no[$i]],2); $total_total_amt +=$lc_value[$lc_no[$i]];?></td>
		<td><?= $tenor_type[$tenor_days[$i]]?></td>
		<td><?= $marketing_person_name[$marketing_person[$i]];?></td>
		</tr>
<?  }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		  
	
		
		
		
		</tbody>
</table>
		<?
}






elseif($_POST['report']==21111301)
{
		$report="LC Receive Pending Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL </th>
		<th width="6%" bgcolor="#99FFFF">Job No </th>
		<th width="6%" bgcolor="#99FFFF">PI No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Rec. Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Expiry Date </th>
		<th width="16%" bgcolor="#99FFFF" style="text-align:center">Applicant Name</th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Applicant Bank </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">Tenor</th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center">Concern</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $lc_date_con .= ' and a.lc_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and b.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and a.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			//if($_POST['pi_type']!='')
//
//			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';
		 

			 $po_sql = "SELECT  c.job_no,b.lc_no FROM lc_master a, lc_receive b, pi_details c 
			 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id ".$lc_date_con.$pi_con.$customer_con." group by c.do_no ";
			$po_query=db_query($po_sql);
			while($po_data= mysqli_fetch_object($po_query)){
			$lc_count[$po_data->lc_no]++;
			$job_no[$po_data->lc_no][] = $po_data->job_no;
			}
			
			
			 $pi_sql = "SELECT  c.pi_no, b.lc_no FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id ".$lc_date_con.$pi_con.$customer_con." GROUP by c.pi_id ";
			$pi_query=db_query($pi_sql);
			while($pi_data= mysqli_fetch_object($pi_query)){
			$pi_count[$pi_data->lc_no]++;
			$pi_no[$pi_data->lc_no][] = $pi_data->pi_no;
			}
			
			
			 $lc_sql = "SELECT  c.pi_no, b.lc_no, sum(c.total_amt) as lc_value FROM lc_master a, lc_receive b, pi_details c 
		 WHERE a.lc_no=b.lc_no  and b.pi_id=c.pi_id ".$lc_date_con.$pi_con.$customer_con." GROUP by a.lc_no ";
			$lc_query=db_query($lc_sql);
			while($lc_data= mysqli_fetch_object($lc_query)){
			$lc_value[$lc_data->lc_no] = $lc_data->lc_value;
			}
			
			 $sql = "SELECT  d.dealer_code, d.dealer_name_e as dealer_name FROM dealer_info d  WHERE 1";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$dealer_name[$data->dealer_code] = $data->dealer_name;
			}
			
			
			 $sql = "SELECT  b.bank_id, b.bank_name as bank_name FROM  bank_buyers b  WHERE 1";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$bank_name[$data->bank_id] = $data->bank_name;
			}
			
			 $sql = "SELECT  b.tenor_days, b.tenor_type as tenor_type FROM  tenor_days b  WHERE 1 ";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$tenor_type[$data->tenor_days] = $data->tenor_type;
			}
			
			
			$sql = "SELECT  b.person_code, b.marketing_person_name as marketing_person_name FROM  marketing_person b WHERE 1 ";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$marketing_person_name[$data->person_code] = $data->marketing_person_name;
			}
			
			
			
			
		  $sql="select a.lc_no_view, a.lc_no, a.lc_date, a.export_lc_no, a.export_lc_date, a.expiry_date, a.dealer_code, a.bank_buyers, a.tenor_days,  b.marketing_person  from  lc_master a, lc_receive b  where a.lc_no=b.lc_no  ".$lc_date_con.$pi_con.$customer_con." group by b.lc_no order by a.lc_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{	
			
		$pi++;
			
		$lc_no_view[] = $row->lc_no_view;
		$lc_date[] = $row->lc_date;
		$lc_no[] = $row->lc_no;
		
		$export_lc_no[] = $row->export_lc_no;
		$export_lc_date[] = $row->export_lc_date;
		$expiry_date[] = $row->expiry_date;
		$dealer_code[] = $row->dealer_code;
		$bank_buyers[] = $row->bank_buyers;
		$tenor_days[] = $row->tenor_days;
		$marketing_person[] = $row->marketing_person;
		//$total_amt[] = $row->total_amt;
		
		}
		?>
		
		<? for($i=0;$i<$pi;$i++){?>
		
		<tr>
		<td><?=$lc_no_view[$i]?></td>
		<td>

<? for($s=0;$s<$lc_count[$lc_no[$i]];$s++){?>

<?=$job_no[$lc_no[$i]][$s];?>

<? }?>
		
		</td>
		<td>
		
		
<? for($p=0;$p<$pi_count[$lc_no[$i]];$p++){?>

<?=$pi_no[$lc_no[$i]][$p];?>

<? }?>
	</td>
		<td><?php echo date('d-M-Y',strtotime($lc_date[$i]));?></td>
		<td><?=$export_lc_no[$i]?></td>
		<td><?php echo date('d-M-Y',strtotime($export_lc_date[$i]));?></td>
		<td><?php echo date('d-M-Y',strtotime($expiry_date[$i]));?></td>
		<td><?= $dealer_name[$dealer_code[$i]]?></td>
		<td><?= $bank_name[$bank_buyers[$i]]?></td>
		<td>$ <?=number_format($lc_value[$lc_no[$i]],2); $total_total_amt +=$lc_value[$lc_no[$i]];?></td>
		<td><?= $tenor_type[$tenor_days[$i]]?></td>
		<td><?= $marketing_person_name[$marketing_person[$i]];?></td>
		</tr>
<?  }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		  
	
		
		
		
		</tbody>
</table>
		<?
}









elseif($_POST['report']==210802002)
{
		$report="BOE Submission Pending Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Rec. Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Expiry Date </th>
		<th width="16%" bgcolor="#99FFFF" style="text-align:center">Applicant Name</th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Applicant Bank </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">Tenor</th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center">Concern</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $lc_date_con .= ' and a.lc_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and b.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and a.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			//if($_POST['pi_type']!='')
//
//			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';



			$sql = "SELECT  lc_no, sum(total_amt) as total_amt  FROM  lc_receive_details WHERE 1 group by lc_no ";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$total_amt[$data->lc_no] = $data->total_amt;
			}
		 
	
		
		  $sql="select a.lc_no_view, a.lc_no, a.lc_date, a.export_lc_no, a.export_lc_date, a.expiry_date, a.dealer_code, a.bank_buyers, a.tenor_days, b.marketing_person  from  lc_master a, boe_submission b  where a.lc_no=b.lc_no   ".$pi_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by b.lc_no order by a.lc_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$row->lc_no_view;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->lc_date));?></td>
		<td><?=$row->export_lc_no;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->export_lc_date));?></td>
		<td><?php echo date('d-m-Y',strtotime($row->expiry_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= find_a_field('bank_buyers','bank_name','bank_id='.$row->bank_buyers);?></td>
		<td>$ <?=number_format($total_amt[$row->lc_no],2); $total_total_amt +=$total_amt[$row->lc_no];?></td>
		<td><?= find_a_field('tenor_days','tenor_type','tenor_days='.$row->tenor_days);?></td>
		<td><?= find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		</tr>
<?  }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		  
	
		
		
		
		</tbody>
</table>
		<?
}







elseif($_POST['report']==210802003)
{
		$report="BOE Pending Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Rec. Date </th>
		<th width="4%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		<th width="5%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">Expiry Date </th>
		<th width="15%" bgcolor="#99FFFF" style="text-align:center">Applicant Name</th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center">Applicant Bank </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Tenor</th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">Concern</th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Sub. Date </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Pending Days </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $lc_date_con .= ' and a.lc_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and b.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and a.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			//if($_POST['pi_type']!='')
//
//			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';


$sql = "SELECT  lc_no, sum(total_amt) as total_amt  FROM  lc_receive_details WHERE 1 group by lc_no ";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$total_amt[$data->lc_no] = $data->total_amt;
			}


 	 $sql = "select lc_no, count(lc_no) as lc_no_count  from boe_receive where1 group by lc_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $lc_no_count[$info->lc_no]=$info->lc_no_count;
		
		
		}
		 
	
		
		  $sql="select a.lc_no_view, a.lc_no, a.lc_date, a.export_lc_no, a.export_lc_date, a.expiry_date, a.dealer_code, a.bank_buyers, a.tenor_days,  b.marketing_person, b.invoice_date  
		  from  lc_master a, boe_submission b where a.lc_no=b.lc_no   ".$pi_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by b.lc_no order by a.lc_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<? if($lc_no_count[$row->lc_no]<1) { ?>
		<tr>
		<td><?=$row->lc_no_view;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->lc_date));?></td>
		<td><?=$row->export_lc_no;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->export_lc_date));?></td>
		<td><?php echo date('d-m-Y',strtotime($row->expiry_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= find_a_field('bank_buyers','bank_name','bank_id='.$row->bank_buyers);?></td>
		<td>$ <?=number_format($total_amt[$row->lc_no],2); $total_total_amt +=$total_amt[$row->lc_no];?></td>
		<td><?= find_a_field('tenor_days','tenor_type','tenor_days='.$row->tenor_days);?></td>
		<td><?= find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		<td><?php echo date('d-m-Y',strtotime($row->invoice_date));?></td>
		<td><?

		$today_date = date('Y-m-d');
		$acknow_date = strtotime($today_date);
		$chalan_date = strtotime($row->invoice_date);
		$datediff = $acknow_date - $chalan_date;
		echo $acknowledgement_days =  round($datediff / (60 * 60 * 24));

		?></td>
		</tr>
<? } }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		  
	
		
		
		
		</tbody>
</table>
		<?
}








elseif($_POST['report']==210802004)
{
		$report="BOE Received Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Rec. Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Expiry Date </th>
		<th width="16%" bgcolor="#99FFFF" style="text-align:center">Applicant Name</th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Applicant Bank </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">Tenor</th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center">Concern</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $lc_date_con .= ' and a.lc_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and b.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and a.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			//if($_POST['pi_type']!='')
//
//			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';


$sql = "SELECT  lc_no, sum(total_amt) as total_amt  FROM  lc_receive_details WHERE 1 group by lc_no ";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$total_amt[$data->lc_no] = $data->total_amt;
			}
		 
	
		
		  $sql="select a.lc_no_view, a.lc_no, a.lc_date, a.export_lc_no, a.export_lc_date, a.expiry_date, a.dealer_code, a.bank_buyers, a.tenor_days,  b.marketing_person 
		   from  lc_master a, boe_receive b  where a.lc_no=b.lc_no  ".$pi_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by b.lc_no order by a.lc_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$row->lc_no_view;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->lc_date));?></td>
		<td><?=$row->export_lc_no;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->export_lc_date));?></td>
		<td><?php echo date('d-m-Y',strtotime($row->expiry_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= find_a_field('bank_buyers','bank_name','bank_id='.$row->bank_buyers);?></td>
		<td>$ <?=number_format($total_amt[$row->lc_no],2); $total_total_amt +=$total_amt[$row->lc_no];?></td>
		<td><?= find_a_field('tenor_days','tenor_type','tenor_days='.$row->tenor_days);?></td>
		<td><?= find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		</tr>
<?  }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		
		
		</tbody>
</table>
		<?
}










elseif($_POST['report']==210802005)
{
		$report="Maturity Receive Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Rec. Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Expiry Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LDBC No</th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LDBC Date</th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Maturity Recv Date</th>
		<th width="16%" bgcolor="#99FFFF" style="text-align:center">Applicant Name</th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Applicant Bank </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">Tenor</th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center">Concern</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $lc_date_con .= ' and b.invoice_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and b.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and a.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			//if($_POST['pi_type']!='')

//
//			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';



$sql = "SELECT  lc_no, sum(total_amt) as total_amt  FROM  lc_receive_details WHERE 1 group by lc_no ";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$total_amt[$data->lc_no] = $data->total_amt;
			}
		 
	
		
		  $sql="select a.lc_no_view, a.lc_no, a.lc_date, a.export_lc_no, a.export_lc_date, a.expiry_date, a.dealer_code, a.bank_buyers, a.tenor_days,	
		b.marketing_person,  b.ldbc_no, b.ldbc_no_date, b.maturity_rec_date, b.invoice_date
		from  lc_master a, maturity_receive b
		 where a.lc_no=b.lc_no and b.status='CHECKED'  ".$pi_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by b.lc_no order by a.lc_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$row->lc_no_view;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->lc_date));?></td>
		<td><?=$row->export_lc_no;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->export_lc_date));?></td>
		<td><?php echo date('d-m-Y',strtotime($row->expiry_date));?></td>
		<td><?=$row->ldbc_no;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->ldbc_no_date));?></td>
		<td><?php echo date('d-m-Y',strtotime($row->maturity_rec_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= find_a_field('bank_buyers','bank_name','bank_id='.$row->bank_buyers);?></td>
		<td>$ <?=number_format($total_amt[$row->lc_no],2); $total_total_amt +=$total_amt[$row->lc_no];?></td>
		<td><?= find_a_field('tenor_days','tenor_type','tenor_days='.$row->tenor_days);?></td>
		<td><?= find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		</tr>
<?  }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		
		
		</tbody>
</table>
		<?
}








elseif($_POST['report']==210802006)
{
		$report="LC Realization Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($_POST['dealer_code']>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$_POST['dealer_code'])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<?php /*?><img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;"><?php */?>
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" id="ExportTable"  border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Rec. Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LC No </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Expiry Date </th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LDBC No</th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">LDBC Date</th>
		<th width="8%" bgcolor="#99FFFF" style="text-align:center">Maturity Recv Date</th>
		<th width="16%" bgcolor="#99FFFF" style="text-align:center">Applicant Name</th>
		<th width="14%" bgcolor="#99FFFF" style="text-align:center">Applicant Bank </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">LC Value </th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Realization Date</th>
		<th width="7%" bgcolor="#99FFFF" style="text-align:center">Realization Value </th>
		<th width="6%" bgcolor="#99FFFF" style="text-align:center">Tenor</th>
		<th width="13%" bgcolor="#99FFFF" style="text-align:center">Concern</th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		 if($_POST['f_date']!=''&&$_POST['t_date']!='') $lc_date_con .= ' and b.invoice_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		 
		 
			if($_POST['do_no']!='')

			$job_con .= ' and d.do_no = "'.$_POST['do_no'].'" ';
			
			if($_POST['pi_no']!='')

			$pi_con .= ' and b.id = "'.$_POST['pi_no'].'" ';
			
			if($_POST['dealer_code']!='')

			$customer_con .= ' and a.dealer_code = "'.$_POST['dealer_code'].'" ';
			
			//if($_POST['pi_type']!='')

//
//			$pi_type_con .= ' and m.pi_type = "'.$_POST['pi_type'].'" ';


$sql = "SELECT  lc_no, sum(total_amt) as total_amt  FROM  lc_receive_details WHERE 1 group by lc_no ";
			$query=db_query($sql);
			while($data= mysqli_fetch_object($query)){
			$total_amt[$data->lc_no] = $data->total_amt;
			}
		 
	
		
		  $sql="select a.lc_no_view, a.lc_no, a.lc_date, a.export_lc_no, a.export_lc_date, a.expiry_date, a.dealer_code, a.bank_buyers, a.tenor_days, 
		b.marketing_person,  b.ldbc_no, b.ldbc_no_date, b.maturity_rec_date, b.invoice_date, b.realization_date, b.realization_value

		from  lc_master a, lc_realization b 
		 where a.lc_no=b.lc_no and b.status='CHECKED'  ".$pi_date_con.$job_con.$pi_con.$customer_con.$pi_type_con." group by b.lc_no order by a.lc_no";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$row->lc_no_view;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->lc_date));?></td>
		<td><?=$row->export_lc_no;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->export_lc_date));?></td>
		<td><?php echo date('d-m-Y',strtotime($row->expiry_date));?></td>
		<td><?=$row->ldbc_no;?></td>
		<td><?php echo date('d-m-Y',strtotime($row->ldbc_no_date));?></td>
		<td><?php echo date('d-m-Y',strtotime($row->maturity_rec_date));?></td>
		<td><?= find_a_field('dealer_info','dealer_name_e','dealer_code='.$row->dealer_code);?></td>
		<td><?= find_a_field('bank_buyers','bank_name','bank_id='.$row->bank_buyers);?></td>
		<td>$ <?=number_format($total_amt[$row->lc_no],2); $total_total_amt +=$total_amt[$row->lc_no];?></td>
		<td><?php echo date('d-m-Y',strtotime($row->realization_date));?></td>
		<td>$
		  <?=number_format($row->realization_value,2); $total_realization_value +=$row->realization_value;?></td>
		<td><?= find_a_field('tenor_days','tenor_type','tenor_days='.$row->tenor_days);?></td>
		<td><?= find_a_field('marketing_person','marketing_person_name','person_code='.$row->marketing_person);?></td>
		</tr>
<?  }?>

		<tr>
		<td></td>
		<td>&nbsp;</td>
		<td><strong>Total</strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong>$<?=number_format($total_total_amt,2);?></strong></td>
		<td>&nbsp;</td>
		<td><strong>$
		  <?=number_format($total_realization_value,2);?>
        </strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		
		
		
		</tbody>
</table>
		<?
}












elseif($_POST['report']==210008)
{
		$report="Performance Report";		
		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}
		
		?>
		
		<table width="100%">
	   	<tr>
		<td width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		<td  width="50%" style="border:0px; border-color:white;">
			<table width="100%"  >
				<tr align="center" >
					<td style="font-size:20px; border:0px; border-color:white;"><strong><?=$_SESSION['company_name'];?></strong></td>	
				</tr>
				<tr align="center" >
					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>	
				</tr>
				
		 <? if ($group_for>0) {?>
        <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;"><strong>Company: <?=find_a_field('user_group','group_name','id='.$group_for)?></strong></td>
         </tr>
		 <? }?>
		 
		 
		 <? if ($customer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Customer Name: <?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$customer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($buyer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Buyer Name: <?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer[0])?></td>
         </tr>
		 <? }?>
		 
		 
		  <? if ($merchandizer[0]>0) {?>
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Merchandiser Name: <?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer[0])?></td>
         </tr>
		 <? }?>
		 
		
		 <tr>
          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Period of: <?php echo date('d-m-Y',strtotime($_POST['f_date']));?>
		   <strong>To</strong> <?php echo date('d-m-Y',strtotime($_POST['t_date']));?></td>
         </tr>
			</table>
		
		</td>
		
		<td  width="25%" align="center" style="border:0px; border-color:white;">
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?= $_SESSION['user']['group']?>.png" style="width:150px;">
		</td>
		</tr>
		
		<tr>
			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>
		</tr>
	   	
	   	
	
		 
		 
       </table>
		
		
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
		
		<thead>
		
		
		
		<tr style="font-size:12px; height:25px;">
		<th width="2%" bgcolor="#99FFFF">SL</th>
		<th width="30%" bgcolor="#99FFFF">Marketing Person </th>
		<th width="12%" bgcolor="#99FFFF" style="text-align:center">Total Order Received Qty (PCS) </th>
		<th width="12%" bgcolor="#99FFFF" style="text-align:center">Total Order Received Value (USD) </th>
		<th width="12%" bgcolor="#99FFFF" style="text-align:center">Total Order Produced Qty (PCS) </th>
		<th width="12%" bgcolor="#99FFFF" style="text-align:center">Total Order Produced Value (USD) </th>
		<th width="12%" bgcolor="#99FFFF" style="text-align:center">Total Order Delivered Qty (PCS) </th>
		<th width="11%" bgcolor="#99FFFF" style="text-align:center">Total Order Delivered Value (USD) </th>
		</tr>
		</thead><tbody>
		<? $sl=1;
		
		
		
		
		//if(isset($dealer_code)) 	{$con=' and d.dealer_code="'.$dealer_code.'"';}


		if(isset($zone_id)) 		{$con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		if(isset($item_sub_group)) 	{$item_sub_con=' and i.sub_group_id='.$item_sub_group;}
		
		if(isset($item_group)) 		{$item_group_con=' and s.group_id='.$item_group;}
		
		if(isset($item_mother_group)) 			{$item_mother_group_con=' and g.mother_group_id='.$item_mother_group;}

		
		if(isset($group_for)) 		{$group_for_con=' and m.group_for="'.$group_for.'"';}
		
		if(isset($item_type)) 					{$item_type_con=' and i.item_type='.$item_type;}
		
		
		
		
		
		  $sql = "select m.marketing_person, sum(c.total_amt) as wo_amt, sum(c.total_unit) as wo_qty  
		 from sale_do_master m, sale_do_details c, marketing_person p
		 where m.do_no=c.do_no and m.marketing_person=p.person_code and c.do_date between '".$f_date."' and '".$t_date."'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by m.marketing_person ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $wo_amt[$info->marketing_person]=$info->wo_amt;
		 $wo_qty[$info->marketing_person]=$info->wo_qty;
		
		}


		
		  $sql = "select m.marketing_person, sum(c.total_amt) as challan_amt, sum(c.total_unit) as challan_qty  
		 from sale_do_master m, sale_do_chalan c, marketing_person p
		 where m.do_no=c.do_no and m.marketing_person=p.person_code and c.chalan_date between '".$f_date."' and '".$t_date."'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by m.marketing_person ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $challan_amt[$info->marketing_person]=$info->challan_amt;
		 $challan_qty[$info->marketing_person]=$info->challan_qty;
		
		}
		
		
		
		 $sql = "select m.marketing_person, sum(c.total_amt) as production_amt, sum(c.total_unit) as production_qty  
		 from sale_do_master m, sale_do_production_issue c, marketing_person p
		 where m.do_no=c.do_no and m.marketing_person=p.person_code and c.chalan_date between '".$f_date."' and '".$t_date."'
		   ".$con.$item_sub_con.$group_for_con.$item_group_con.$item_mother_group_con.$item_type_con."  group by m.marketing_person ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $production_amt[$info->marketing_person]=$info->production_amt;
		 $production_qty[$info->marketing_person]=$info->production_qty;
		
		}
		
		
	
		
		
		if(isset($zone_id)) 		{$zon_con=' and z.ZONE_CODE="'.$zone_id.'"';}
		
		 $sql_sub="select t.team_code, t.team_name from marketing_team t, sale_do_master s where  
		 s.marketing_team=t.team_code ".$zon_con." group by s.marketing_team";
		$data_sub=db_query($sql_sub);

		while($info_sub=mysqli_fetch_object($data_sub)){ 
		
		?>
		
		
		
		<tr>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff"><div align="left" style="text-transform:uppercase; font-size:14px; font-weight:700;"><strong><?=$info_sub->team_name?></strong></div></td>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff">&nbsp;</td>
		  <td bgcolor="#fff">&nbsp;</td>
		  </tr>
		
		
		
		<?
		

		
		 $sql="select  p.person_code, p.marketing_person_name from marketing_person p, sale_do_master s
		 where  p.person_code=s.marketing_person and p.team_code='".$info_sub->team_code."'  ".$con." group by s.marketing_person order by p.team_code,p.person_code";
		
		$res	 = db_query($sql);
		while($row=mysqli_fetch_object($res))
		{

		//if($sales_amt[$row->item_id]<>0 || $foc_amt[$row->item_id]<>0 ){}
		?>
		
		<tr>
		<td><?=$sl++;?></td>
		<td><?=$row->marketing_person_name?></td>
		<td><? if ($wo_qty[$row->person_code]>0) {?>
            <?=$wo_qty[$row->person_code]; $total_wo_qty +=$wo_qty[$row->person_code]; ?>
            <? }?></td>
		<td>$ &nbsp;&nbsp;&nbsp;
		    <? if ($wo_amt[$row->person_code]>0) {?>
		  <?=number_format($wo_amt[$row->person_code],2); $total_wo_amt +=$wo_amt[$row->person_code]; ?>
		  <? }?></td>
		<td><? if ($production_qty[$row->person_code]>0) {?>
            <?=$production_qty[$row->person_code]; $total_production_qty +=$production_qty[$row->person_code]; ?>
            <? }?></td>
		<td>$ &nbsp;&nbsp;&nbsp;
		    <? if ($production_amt[$row->person_code]>0) {?>
		  <?=number_format($production_amt[$row->person_code],2); $total_production_amt +=$production_amt[$row->person_code]; ?>
		  <? }?></td>
		<td><? if ($challan_qty[$row->person_code]>0) {?>
		  <?=$challan_qty[$row->person_code]; $total_challan_qty +=$challan_qty[$row->person_code]; ?>
		  <? }?></td>
		<td>$ &nbsp;&nbsp;&nbsp;<? if ($challan_amt[$row->person_code]>0) {?><?=number_format($challan_amt[$row->person_code],2); $total_challan_amt +=$challan_amt[$row->person_code]; ?><? }?></td>
		</tr>
<?  }?>
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td bgcolor="#FFFFFF"><div align="right"><strong>SUB TOTAL: </strong></div></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
            <?=$total_wo_qty; $total_total_wo_qty +=$total_wo_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7"> $ &nbsp;&nbsp;&nbsp;
		        <?=number_format($total_wo_amt,2); $total_total_wo_amt +=$total_wo_amt;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
            <?=$total_production_qty; $total_total_production_qty +=$total_production_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7"> $ &nbsp;&nbsp;&nbsp;
		        <?=number_format($total_production_amt,2); $total_total_production_amt +=$total_production_amt;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    <?=$total_challan_qty; $total_total_challan_qty +=$total_challan_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    $ &nbsp;&nbsp;&nbsp;<?=number_format($total_challan_amt,2); $total_total_challan_amt +=$total_challan_amt;?>
		  </span></td>
		  </tr>
		  
		  <? 
		  $total_wo_qty = 0;
		  $total_wo_amt = 0;
		  $total_production_qty = 0;
		  $total_production_amt = 0;
		  $total_challan_qty = 0;
		  $total_challan_amt = 0;
		   }?>
		
		
		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>
		  <td bgcolor="#FFFFFF">&nbsp;</td>
		  <td bgcolor="#FFFFFF"><div align="right"><strong>GRAND TOTAL:</strong></div></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
            <?=$total_total_wo_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7"> $ &nbsp;&nbsp;&nbsp;
		        <?=number_format($total_total_wo_amt,2);?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
            <?=$total_total_production_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7"> $ &nbsp;&nbsp;&nbsp;
		        <?=number_format($total_total_production_amt,2);?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    <?=$total_total_challan_qty;?>
          </span></td>
		  <td bgcolor="#FFFFFF"><span class="style7">
		    $ &nbsp;&nbsp;&nbsp;<?=number_format($total_total_challan_amt,2);?>
		  </span></td>
		  </tr>
		
		</tbody>
</table>
		<?
}










elseif($_POST['report']==210009)
{}









elseif($_POST['report']==210010)
{}








elseif($_POST['report']==210011)
{}





elseif($_POST['report']==210614001)
{}







elseif($_POST['report']==210012)
{}









elseif($_POST['report']==210013000000000000000)
{}







elseif($_POST['report']=='210013'){}








elseif($_POST['report']=='210014'){}













elseif($_REQUEST['report']==2001) 



{}



elseif($_REQUEST['report']==321) 

{}





elseif($_REQUEST['report']==1999) 



{}



elseif($_REQUEST['report']==1991) 



{}



elseif($_REQUEST['report']==191) 


{}



elseif($_REQUEST['report']==3) 



{}



elseif($_REQUEST['report']==701) 



{}



elseif($_REQUEST['report']==7011) 



{}



elseif($_REQUEST['report']==5) 



{}







elseif($_REQUEST['report']==501) 



{}







elseif($_REQUEST['report']==9) 



{}



elseif($_REQUEST['report']==14) 



{}



elseif($_REQUEST['report']==8) 



{}elseif($_REQUEST['report']==100) 



{}elseif($_REQUEST['report']==101) 



{}



elseif($_REQUEST['report']==102) 



{}







elseif($_REQUEST['report']==103) 



{}







elseif($_POST['report']==2002) 



{}







elseif($_POST['report']==2003) 



{}







elseif($_POST['report']==20031) 



{}







elseif($_REQUEST['report']==104) 



{}







elseif($_REQUEST['report']==105) 



{}







elseif($_REQUEST['report']==106) 



{}



elseif($_REQUEST['report']==107) 



{}



elseif($_REQUEST['report']==108) 



{}



elseif($_REQUEST['report']==109) 



{}



















elseif($_REQUEST['report']==110) 



{}



elseif($_REQUEST['report']==111) 



{}



elseif($_REQUEST['report']==112) 



{}







elseif($_REQUEST['report']==1130) 



{}



elseif($_REQUEST['report']==11301) 



{}



elseif($_REQUEST['report']==113) 



{}



elseif($_REQUEST['report']==116) 



{}



elseif($_REQUEST['report']==114) 



{}



elseif($_REQUEST['report']==115) 



{}



elseif($_REQUEST['report']==1992) 



{}



elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}



?>



</div>



</body>



</html>



