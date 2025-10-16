<?
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();
require_once "../../../assets/support/inc.all.php";
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



	$report="Sales Order Summary (Item Wise)";



	break;

	

	case 2001:



	$report="Sales Commission Report";



	break;



    case 1999:



	$report="SO Report for Scratch Card";



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



	$query2 = mysql_query($sql2);



	while($data2 = mysql_fetch_object($query2))



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



	



	$query2 = mysql_query($sql2);



	while($data2 = mysql_fetch_object($query2))



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



	$query2 = mysql_query($sql2);



	while($data2 = mysql_fetch_object($query2))



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



	$query2 = mysql_query($sql2);



	while($data2 = mysql_fetch_object($query2))



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



	$query2 = mysql_query($sql2);



	while($data2 = mysql_fetch_object($query2))



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



	$query2 = mysql_query($sql2);



	while($data2 = mysql_fetch_object($query2))



	{



	$last_year_sale_amt[$data2->BRANCH_ID] = $data2->sale_price;



	$last_year_sale_qty[$data2->BRANCH_ID] = $data2->qty;



	$last_year_sale_pkt[$data2->BRANCH_ID] = $data2->pkt;



	}



	break;



    case 1991:







$report="Sales Order Report (Without VAT & Transport)";



	break;



case 191:



$report="Sales Order  Report (Item Wise)";



break;


case 546465:



$report="Sales Order Report (Customer Wise In Amount)";



break;



	



    case 2:



		$report="Undelivered SO Details Report";



 $sql = "select m.do_no as SO_NO,m.do_date as SO_Date,d.dealer_code as Customer_Code,d.dealer_name_e as Customer_Name,w.warehouse_name,i.finish_goods_code as Item_Code, i.item_name as Item_Description,o.pkt_unit as crt,o.dist_unit as Qty,o.total_amt,m.rcv_amt,m.payment_by as PB from 



sale_do_master m,sale_do_details o, item_info i,dealer_info d , warehouse w



where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') and w.warehouse_id=d.depot ".$date_con.$item_con.$depot_con.$dtype_con.$dealer_con.$item_brand_con;



	break;



	case 3:



$report="Undelivered SO Report Customer Wise";



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



$report="Sales Order Brief Report (Region Wise)";



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



		$report="Item wise Undelivered SO Report(With Gift)";



		break;



		



		case 7011:



		$report="Item wise Undelivered SO Report(Without Gift)";



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



		



 $sql="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  , m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 



sale_do_master m,dealer_info d  , warehouse w



where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";



		break;



		



		case 11:



		$report="Daily Collection &amp; Order Summary";



		



$sql="select m.do_no, m.do_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  , m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from 



sale_do_master m,dealer_info d  , warehouse w 



where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code and w.warehouse_id=d.depot".$date_con.$pg_con." order by m.entry_at";



		break;
		
		
		case 1010:



		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and  m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



		$report="Daily Sales Report";



		break;



				case 13:



		$report="Daily Collection Summary(EXT)";



		



$sql="select m.do_no,m.do_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area , m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from 



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



<link href="../../../assets/css/report.css" type="text/css" rel="stylesheet" />



<script language="javascript">



function hide()



{



document.getElementById('pr').style.display='none';



}



</script>

<?
		require_once "../../../assets/support/inc.exporttable.php";
?>


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



-->



    </style>



</head>



<body>



<div align="center" id="pr">



  <input type="button" style="text-align:center" value="Print" onclick="hide();window.print();"/>



</div>



<div class="main">



<?



		$str 	.= '<div class="header" style="">';



		if(isset($_SESSION['company_name'])) 



		$str 	.= '<h1>'.find_a_field('project_info','proj_name','1').'</h1>';



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



		$str 	.= '<h3 style="font-weight:bold;">From  '.date("d-m-Y",strtotime($fr_date)).'  To '.date("d-m-Y",strtotime($to_date)).'</h3>';



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









if($_REQUEST['report']==1) 

{

echo 'bimol';

?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="9"><?=$str?>



        <div class="left"></div>



        <div class="right"></div>



        <div class="date">Reporting Time:



          <?=date("h:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th rowspan="2">S/L</th>



      <th rowspan="2">Fg</th>



      <th rowspan="2">Item Name</th>



      <th rowspan="2">Unit</th>



      <th rowspan="2">Brand</th>



      <th rowspan="2">Pack Size</th>



      <th rowspan="2">GRP</th>



      <th colspan="3" bgcolor="#FFCCFF"><div align="center">Last Year </div></th>



      <th colspan="3" bgcolor="#FFFF99"><div align="center">This Year </div></th>



      <th>Growth</th>



    </tr>



    <tr>



      <th>Sale Pkt</th>



      <th>Sale Qty </th>



      <th>Sale Amt </th>



      <th>Sale Pkt </th>



      <th>Sale Qty </th>



      <th>Sale Amt </th>



      <th>in % </th>



    </tr>



  </thead>



  <tbody>





  </tbody>



</table>



<?



}



elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}



?>



</div>



</body>



</html>



