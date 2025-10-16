<?


session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';
//require_once '../assets/template/inc.header.php';

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







if($_REQUEST['item_id']!='') 		    $item_id=$_REQUEST['item_id'];







if($_REQUEST['dealer_code']>0) 	    $dealer_code=$_REQUEST['dealer_code'];







if($_REQUEST['item_mother_group']>0) 	$item_mother_group=$_REQUEST['item_mother_group'];







if($_REQUEST['item_group']>0) 		$item_group=$_REQUEST['item_group'];







if($_REQUEST['item_sub_group']>0) 	$item_sub_group=$_REQUEST['item_sub_group'];







if($_REQUEST['item_type']>0) 		$item_type=$_REQUEST['item_type'];







if($_REQUEST['sale_type']>0) 		$item_type=$_REQUEST['sale_type'];







if($_REQUEST['status']!='') 		$status=$_REQUEST['status'];







if($_REQUEST['do_no']!='') 		    $do_no=$_REQUEST['do_no'];







if($_REQUEST['area_id']!='') 		$area_id=$_REQUEST['area_id'];







if($_REQUEST['zone_id']!='') 		$zone_id=$_REQUEST['zone_id'];







if($_REQUEST['region_id']>0) 		$region_id=$_REQUEST['region_id'];







if($_REQUEST['depot_id']!='') 		$depot_id=$_REQUEST['depot_id'];







if($_REQUEST['group_for']>0) 		$group_for=$_REQUEST['group_for'];















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







if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dtype_con=' and d.dealer_type="Distributor"';} else {$dtype_con=' and d.dealer_type!="Distributor"';}}







if(isset($dealer_type)) 		{if($dealer_type=='Distributor') {$dealer_type_con=' and d.dealer_type="Distributor"';} else {$dealer_type_con=' and d.dealer_type!="Distributor"';}}















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















$sql = "select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e)  as dealer_name,d.product_group as grp,concat(i.finish_goods_code,'- ',item_name) as item_name,o.pkt_unit as crt,o.dist_unit as Kgs,o.total_amt,m.rcv_amt,m.payment_by as PB from







sale_do_master m,sale_do_details o, item_info i,dealer_info d







where m.do_no=o.do_no and i.item_id=o.item_id and m.dealer_code=d.dealer_code and m.status in ('CHECKED','COMPLETED') ".$date_con.$item_con.$depot_con.$dtype_con.$dealer_con.$item_brand_con;







	break;







	case 3:







$report="Delivered Do Report Dealer Wise";







if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







if(isset($dealer_code)) {$dealer_con=' and m.dealer_code='.$dealer_code;}







if(isset($item_id)){$item_con=' and i.item_id='.$item_id;}







if(isset($depot_id)) {$depot_con=' and d.depot="'.$depot_id.'"';}







	break;







	case 4:







	if($_REQUEST['do_no']>0)







header("Location:work_order_print.php?wo_id=".$_REQUEST['wo_id']);







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







		floor(sum(o.total_unit)/o.pkt_size) as Kgs,







		mod(sum(o.total_unit),o.pkt_size) as crt,







		sum(o.total_amt)as Dealer_price,







		sum(o.total_unit*o.t_price)as trade_price







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







sale_do_master m,dealer_info d







where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code ".$date_con.$pg_con." order by m.entry_at";







		break;















		case 11:







		$report="Daily Collection &amp; Order Summary";















$sql="select m.do_no, m.do_date, concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name, m.payment_by as payment_mode,m.remarks, m.rcv_amt as collection_amount,(select sum(total_amt) from sale_do_details where do_no=m.do_no) as DP_Total,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' from







sale_do_master m,dealer_info d







where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code ".$date_con.$pg_con." order by m.entry_at";







		break;







				case 13:







		$report="Daily Collection Summary(EXT)";















$sql="select m.do_no,m.do_date,m.entry_at,concat(d.dealer_code,'- ',d.dealer_name_e)  as party_name,(SELECT AREA_NAME FROM area where AREA_CODE=d.area_code) as area  ,d.product_group as grp, m.bank as bank_name,m.branch as branch_name,m.payment_by as payment_mode, m.rcv_amt as amount,m.remarks,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as Varification_Sign,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' as DO_Section_sign from







sale_do_master m,dealer_info d







where m.status in ('CHECKED','COMPLETED') and  m.dealer_code=d.dealer_code ".$date_con.$pg_con." order by m.entry_at";







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















		case 1007:







		$report="MONTH ON MONTH PRODUCT QTY WISE SALES REPORT";







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



















		case 1008:







		$report="MONTH ON MONTH PRODUCT VALUE WISE SALES REPORT";







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















		case 1009:







		$report="MONTH ON MONTH DISTRIBUTOR WISE SALES REPORT";







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







<title><?=$report?></title>







<link href="../../../assets/css/report.css" type="text/css" rel="stylesheet" />







<script language="javascript">














</script>







    <style type="text/css" media="print">







      div.page







      {







        page-break-after: always;







        page-break-inside: avoid;







      }







    </style>






<script language="javascript">
	function hide(){
		document.getElementById('pr').style.display='none';
	}
</script>




<style type="text/css" media="print">
	div.page{
		page-break-after: always;
		page-break-inside: avoid;
	}
	
</style>

</head>







<body>






<!---->
<!--<div align="center" id="pr">-->
<!---->
<!--<input type="button" value="Print" onclick="hide();window.print();"/>-->
<!---->
<!--</div>-->






<div class="main">

<?
	require_once  SERVER_CORE."core/inc.exporttable.php";
?>

<?

		$str 	.= '<div class="header">';

		if(isset($_SESSION['user']['group']))

		$str 	.= '<h1>'.find_a_field('user_group','group_name','id='.$_SESSION['user']['group']).'</h1>';

		if(isset($report))

		$str 	.= '<h2>'.$report.'</h2>';

		if(isset($dealer_code))

		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';

		//if(isset($depot_id))
		//$str 	.= '<h2>Warehouse: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id).'</h2>';


		if(isset($item_brand))


		$str 	.= '<h2>Item Brand : '.$item_brand.'</h2>';

		if(isset($item_info->item_id))

		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';


		//if(isset($to_date))

		//$str 	.= '<h2>Date Interval : '.date("d-m-Y",strtotime($fr_date)).' To '.date("d-m-Y",strtotime($to_date)).'</h2>';

		if(isset($product_group))
		$str 	.= '<h2>Product Group : '.$product_group.'</h2>';

		if(isset($region_id))
		$str 	.= '<h2>Region Name : '.find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$region_id).'</h2>';

		if(isset($zone_id))
		$str 	.= '<h2>Zone Name: '.find_a_field('zon','ZONE_NAME','ZONE_CODE='.$zone_id).'</h2>';


		if(isset($area_id))
		$str 	.= '<h2>Area Name: '.find_a_field('area','AREA_NAME','AREA_CODE='.$area_id).'</h2>';


		if(isset($dealer_type))
		$str 	.= '<h2>Dealer Type : '.$dealer_type.'</h2>';

		$str 	.= '</div>';
		$str 	.= '<div class="left" style="width:100%">';



if($_REQUEST['report']==20241029) {
$report="OD & TADA Details Report";
?>


<table width="100%">
	<tr>
	<td width="25%" align="center" style="border:0px; border-color:white;">
	<img src="../../../../public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:50%"> 
	</td>
	
	<td  width="50%" style="border:0px; border-color:white;">
	<table width="100%">
	
	<tr align="center" >
	
	<td style="font-size:18px; border:0px; border-color:white;"><strong><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?></strong></td>
	
	</tr>
	
	<tr align="center" >
	
	<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>
	
	</tr>
	
	<tr>
	
	<td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Employee : &nbsp;<?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_POST['PBI_ID'].'"')?>-<?=$_POST['PBI_ID']?></td>
	
	</tr>
	
	<tr>
	
	<td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Date of: <?php echo date('d-M-Y',strtotime($_REQUEST['f_date']));?> and <?php echo date('d-M-Y',strtotime($_REQUEST['t_date']));?></td>
	
	</tr>
	
	</table>
	
	</td>
	
	<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;</td>
	
	</tr>
	
	</table>

	<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">
	
	<thead>
	
	<tr height="30">
		<th bgcolor="#FFFACD">SL</th>
		<th bgcolor="#FFFACD">EMPLOYEE CODE</th>
		<th bgcolor="#FFFACD">EMPLOYEE NAME</th>
		<th bgcolor="#FFFACD">PROJECT NAME</th>
		<th bgcolor="#FFFACD">OD DATE</th>
		<th bgcolor="#FFFACD">START TIME</th>
		<th bgcolor="#FFFACD">END TIME</th>
		<th bgcolor="#FFFACD">CONVINCE BILL</th>
		<th bgcolor="#FFFACD">TOTAL AMOUNT</th>
	</tr>
	
	</thead>
	<tbody>
	<?php 
		if($_POST['f_date']!=''){
		$date_con = ' o.s_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';
		}
		
		if($_POST['PBI_ID']!=''){
		$emp_con = ' and  o.PBI_ID = '.$_POST['PBI_ID'].'';
		}
		
		//echo $sql_data1 = 'SELECT * FROM hrm_od_info WHERE  1 '.$date_con.' ';
			$sql_data1 = 'SELECT o.id as od_id, o.*, u.PBI_NAME, p.name as project_name FROM hrm_od_info o, personnel_basic_info u, crm_project_org p WHERE '.$date_con.$emp_con.' AND o.project_id=p.id AND o.PBI_ID=u.PBI_ID';
			$query = db_query($sql_data1);
		$sl=1;
		while($info=mysqli_fetch_object($query)){
	?>
		<tr>
			<td><?=$sl++;?></td>
			<td><?=$info->PBI_ID;?></td>
			<td><?=$info->PBI_NAME;?></td>
			<td><?=$info->project_name;?></td>
			<td><?=$info->s_date;?></td>
			<td><?=$info->s_time;?></td>
			<td><?=$info->e_time;?></td>
			<td>
				<?php
					// SQL query to get the row from the bills table
					$sql_bill = "SELECT * FROM bills WHERE od_id ='" . $info->od_id . "'";
					$query3 = db_query($sql_bill);
					// Fetch the row containing conveyance types and amounts
					$row = mysqli_fetch_assoc($query3);
				
					// Split conveyance_type and amount if they are comma-separated
					$conveyance_types = explode(',', $row['conveyance_type']); 
					$amounts = explode(',', $row['amount']); 
					
					$total_amount = 0;
				
					// Loop through each conveyance type and display with corresponding amount
					foreach ($conveyance_types as $index => $type) {
						$amount = isset($amounts[$index]) ? $amounts[$index] : 0;  
						echo '<p class="'.strtolower($type).'" style=" font-size: 12px; ">'.ucfirst($type).': <span>'.$amount.'</span></p>';
						$total_amount += (float)$amount;  // Convert to float in case it's a string
					}
				?>
			</td>
			<td align="right"><strong><?=number_format($total_amount,2); $all_total +=$total_amount; ?></strong></td>
		</tr>
	<? } ?>
		
		<tr>
			<td colspan="8" align="right"> Total </td>
			<td align="right"><strong><?=number_format($all_total,2);?></strong></td>
		</tr>
	</tbody>
	</table>





<? }




 if($_POST['report']==42122){ ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

    <title>Organization Report</title>
		<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>


	<?
	//require_once "../../../controllers/core/inc.exporttable.php";
	?>
	
  </head>
  <body>

<?=$title?>

<center class="mb-4"><h3 style="font-size: 20px; font-weight: 800;">Meeting Report</h3></center>
 <h6 style="text-align:center;line-height: 14px;font-family: tahoma;font-size: 14px;">
 Date: <?=$_POST['f_date']?> To <?=$_POST['t_date']?></h6>

 	<?

	



if(isset($t_date)) 

		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';

		echo '</div>';



		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';

		?>
 
  	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px !important">
  <thead>
    <tr>
      <th scope="col">S/L</th>
      <th scope="col">Meeting Subject</th>
      <th scope="col">Company Name</th>
      <th scope="col">Meeting Details</th>
	  <th scope="col">Note</th>
      <th scope="col">Assign Person</th>
      <th scope="col">Entry At</th>
      <th scope="col">Entry By</th>
      <th scope="col">Task Date</th>
      <th scope="col">Deadline Date</th>
      <th scope="col">Status</th>
      <th scope="col">Feedback</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
  
   if (isset($_POST['PBI_ID']) && is_array($_POST['PBI_ID'])) {
                                 $person_ids = $_POST['PBI_ID'];
								 $ffffff = implode(",", $person_ids);
									} 
									
 								
  
 


  if($_POST['f_date']>0) $dateConn = " and date between '".$_POST['f_date']."' and '".$_POST['t_date']."'";
    
	/*$sql='select l.*,o.name from crm_project_lead l,crm_project_org o 
	where l.organization=o.id   '.$con.$con_assign.$con_lead.'';
    $query=db_query($sql);*/
	
	 $sql3 = 'SELECT * FROM crm_lead_activity a 
	WHERE activity_type="Meeting" and  mode ="postsale" and a.entry_by="'.$_POST['PBI_ID'].'" '.$dateConn.'
	ORDER BY `date` DESC;';
	$query3=db_query($sql3);
	
	
  $i=1;
  while($row3=mysqli_fetch_object($query3)){
  ?>
    <tr>
      <th scope="row"><?=$i++?></th>
      <td><?=$row3->subject;?></td>
      <td><?=find_a_field('crm_project_org', 'name', 'id = "'.$row3->project_id.'"')?></td>
      <td> <?=$row3->details;?></td>
	   <td> <? //=$row->note;?>
	   	<?php
	$text_meeting_note = $row3->note;
	// Insert line breaks before any number (using regex)
	$text_with_meeting_note = preg_replace('/(\d+)/', '<br>$1', $text_meeting_note);
	
	// Output the result
	echo $text_with_meeting_note;
	?>
	   </td>
	  
	    
		  
		  <td>
  <?php
  $ids = explode(',', $row3->assign_person);
  foreach ($ids as $id) { ?>
    <span class="badge bg-blue-dark color-white font-10 mt-2">
      <?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $id . '"') ?>
    </span><br> <!-- Adding a line break after each badge -->
  <?php } ?>
</td>
        <td> <?=$row3->entry_at;?></td>
         <td><?=find_a_field('user_activity_management', 'fname', 'username = "'.$row3->entry_by.'"')?></td>

		  
    <td><?=$row3->date;?></td>
    <td><?=$row3->deadline;?></td>
    <td>
          <? if($row3->status =='2'){ ?>
          <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
          <? }elseif($row3->status =='1'){ ?>
          <span class="badge bg-highlight color-white font-10 mt-2">PENDING</span>
          <? }else{ ?>
          <span class="badge bg-blue-dark color-white font-10 mt-2">CANCELLED</span>
          <?  } ?>
		  
		  </td>
   <td>
  <!-- Feedback Section -->
  <?php  
    // Fetch feedback for the current activity
    $activity_id = $row3->activity_id;
    $sqlFeedback = "SELECT * FROM crm_lead_activity_feedback WHERE activity_id = $activity_id ORDER BY id DESC";
    $resultFeedback = db_query($sqlFeedback);
    
    while ($feedbackRow = mysqli_fetch_object($resultFeedback)) { ?>
    
    <div style="margin-bottom: 10px; display: flex;">
      <div style="width: 100%;">
        <!-- Username display with bold font and color -->
        <span style="font-size: 11px; padding-left: 5px; font-weight: bold; color: #007bff;">
          <?= find_a_field('user_activity_management', 'fname', 'user_id="'.$feedbackRow->entry_by.'"'); ?>
        </span>
        
        <!-- Feedback content container with padding, border, and light background -->
        <div style="background-color: #f8f9fa; padding: 10px; border-radius: 8px; border: 1px solid #ccc; margin-top: 5px;">
          <p style="line-height: 1.5; margin: 0; color: #333;">
            <?= nl2br($feedbackRow->feedback); ?>  <!-- Keeps original line breaks -->
          </p>
        </div>
      </div>
    </div>
    
  <?php } ?>
  <!-- End of Feedback Display -->
</td>


    

    </tr>
<? }?>
  </tbody>
</table>

  </body>
</html>





<?php

}



if($_REQUEST['report']==210980001)



{


		$report="Monthly Attendance Report";



		if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}

		?>


		<table width="100%" id="ExportTable">

	   	<tr>

		<td width="25%" align="center" style="border:0px; border-color:white;">

		
		<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:50%"> 



		</td>



		<td  width="50%" style="border:0px; border-color:white;">



			<table width="100%" id="ExportTable" >



				<tr align="center" >



					<td style="font-size:18px; border:0px; border-color:white;"><strong><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group'])?></strong></td>



				</tr>

				<tr align="center" >



					<td style="font-size:14px; border:0px; border-color:white;"><strong><?=$report;?></strong></td>



				</tr>




 <tr>



          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">Employee : &nbsp;<?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_POST['PBI_ID'].'"')?>-<?=$_POST['PBI_ID']?></td>



         </tr>


		 <tr>



          <td colspan="15" align="center" style="font-size:14px;border:0px; border-color:white;">For the Date of: <?php echo date('d-M-Y',strtotime($_REQUEST['start_date']));?> To <?php echo date('d-M-Y',strtotime($_REQUEST['end_date']));?></td>



         </tr>



			</table>


		</td>







		<td  width="25%" align="center" style="border:0px; border-color:white;">&nbsp;</td>



		</tr>



		<tr>



			<td colspan="15" style="font-size:14px;border:0px; border-color:white;">&nbsp;</td>



		</tr>


       </table>


     
		<style>
        .late { background-color: #F0E445; } /* Light pink */
        .absent { background-color: #E73F6B; } /* Light salmon */
        .present { background-color: #64CD8A; } /* Pale green */
        .leave { background-color: #A7D4DF; } /* Pale green */
        .iom { background-color: #59B6AD; } /* Pale green */
        .holyday { background-color: #94D970; } /* Pale green */
        .offday { background-color: #C5C9DD; } /* Pale green */
        
       </style>


		<table width="100%" border="0" cellpadding="2" cellspacing="0" id="ExportTable">







		<thead>


		<tr height="30">



		<th width="2%" bgcolor="#FFFACD">SL</th>



		<th width="9%" bgcolor="#FFFACD">EMPLOYEE CODE</th>



		<th width="20%" bgcolor="#FFFACD">EMPLOYEE NAME</th>
        <th width="10%" bgcolor="#FFFACD">DEPARTMENT</th>
		

		<th width="20%" bgcolor="#FFFACD">DESIGNATION</th>



		<th width="15%" bgcolor="#FFFACD">DATE</th>



		<th width="10%" bgcolor="#FFFACD">IN TIME</th>



		<th width="10%" bgcolor="#FFFACD">OUT TIME</th>
		
		<th width="20%" bgcolor="#FFFACD">STATUS</th>
		
		

		



		</tr>



		</thead><tbody>



		<? $sl=1;

             if($_POST['start_date']!=''){
			  $date_con = ' and h.xdate between "'.$_POST['start_date'].'" and "'.$_POST['end_date'].'"';

			  $s_date_con = ' and att_date between "'.$_POST['start_date'].'" and "'.$_POST['end_date'].'"';
			 }


 			$sql = "select h.xenrollid,h.xdate,  min(h.xtime) as min_time from hrm_attdump h where 1 ".$date_con." group by h.xdate,h.xenrollid order by h.xdate";



		 $query = db_query($sql);



		 while($info=mysqli_fetch_object($query)){



  		 $min_time[$info->xenrollid][$info->xdate]=$info->min_time;



		}



		  $sql = "select h.xenrollid,h.xdate,  max(h.xtime) as max_time  from hrm_attdump h where 1 ".$date_con." group by h.xdate,h.xenrollid order by h.xdate";



		 $query = db_query($sql);



		 while($info=mysqli_fetch_object($query)){

         
  		 $max_time[$info->xenrollid][$info->xdate]=$info->max_time;
		 $xenrollid[$info->xenrollid][$info->xdate]=$info->xenrollid;



		}





if($_POST['PBI_ID']!='')
$pbi_id_con .= ' and p.PBI_ID = "'.$_POST['PBI_ID'].'" ';

$f_date = $_POST['start_date'];
$t_date = $_POST['end_date'];


 $sql = "select p.* from personnel_basic_info p where 1 ".$pbi_id_con."";
 $res	 = db_query($sql);
 while($row=mysqli_fetch_object($res))
{
    $absent = 0;
	$late = 0;
	$early = 0;
	$present = 0;
	$friday = 0;
	$leave = 0;
 
	

		
       for($i=$f_date;$i<=$t_date;$i = date('Y-m-d', strtotime( $i . " +1 days"))){


         $sql = "select *  from hrm_att_summary where emp_id=".$row->PBI_ID." and att_date = '".$i."' and leave_id>0";
         $query = db_query($sql);
         while($info=mysqli_fetch_object($query)){
         $lv[$info->emp_id] = $info->emp_id;
           }


         $sqliom = "select *  from hrm_att_summary where emp_id=".$row->PBI_ID." and att_date = '".$i."' and iom_id>0";
         $queryiom = db_query($sqliom);
         while($infoiom=mysqli_fetch_object($queryiom)){

          $iom[$infoiom->att_date] = $infoiom->att_date;
     
           }
           
           
         $sql = "select *  from hrm_att_summary where emp_id=".$row->PBI_ID." and att_date = '".$i."' and  sch_off_day>0 ";
         $query = db_query($sql);
         while($info =mysqli_fetch_object($query)){

          $offday[$info->att_date] = $info->att_date;
           }
           
           
           
        $sql2 = "select holy_day from salary_holy_day where holy_day = '".$i."'";
        $queryho = db_query($sql2);
        while($infoholi=mysqli_fetch_object($queryho)){
            
           $holidata[$infoholi->holy_day] = $infoholi->holy_day;

         }
		 
		 
		 
		 
		
		 



       




           
	
           $new_min_time=date("h:i:s a",strtotime($min_time[$row->PBI_ID][$i]));
           $max_min_time=date("h:i:s a",strtotime($max_time[$row->PBI_ID][$i]));
		   
		   $office_in_time = strtotime($i.' 10:05:00');
		   $office_out_time = strtotime($i.' 18:00:00');

		   $in = strtotime($min_time[$row->PBI_ID][$i]);
		   $out = strtotime($max_time[$row->PBI_ID][$i]);


         $in_latitute =  $in_latitutee[$row->PBI_ID]; 
         $in_longitude = $in_longitudee[$row->PBI_ID];


         

		 if($in>0 || $out>0 && $holi[$row->PBI_ID]=0 ){

          $status = 'Present';
         }else{
           $status = 'Absent';
           $new_min_time = '';
		   $max_min_time = '';
		   
         }
         
         
         if( $holidata[$i] >0){
             $status = 'Holiday';
		     $new_min_time = '';
		     $max_min_time = '';
         }

        


		   if($in>$office_in_time && $iom[$i]==0  && $lv[$row->PBI_ID]==0){
		    $status = 'Late';
			$late++;
		   }




		

		 if($lv[$i]>0){
		     
		     $status = 'Leave';
		     $new_min_time = '';
		     $max_min_time = '';
		     $leave++;
		 }
		 
		 
		 
		 if($offday[$i]>0){
		     
		     $status = 'Offday';
		
		     $offday[$i]++;
		 }


	


		  if($iom[$i]>0 && $lv[$row->PBI_ID]==0 && $holidata[$i]==0 && $offday[$i]==0){
		     
		     $status = 'IOM';
		     $iommmm++;
	
		  
		 }


		    // for warning by color
		        $class = '';
               switch ($status) {

                case 'Late':
                    $class = 'late';
                    break;

                 case 'Holiday':
                    $class = 'holyday';
                    break;

                case 'Absent':
                    $class = 'absent';
                    break;
                    
                case 'Present':
                    $class = 'present';
                    break;

                 case 'Leave':
                    $class = 'leave';
                    break;

                 case 'IOM':
                    $class = 'iom';
                    break;
                    
                 case 'Offday':
                    $class = 'offday';
                    break;
            }



           
           


		?>



		<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



		<td><?=$sl++;?></td>



		<td><?=$row->PBI_ID?></td>



		<td><?=$row->PBI_NAME?></td>



		<td><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$row->DEPT_ID);?></td>
		

   <td><?=find_a_field('designation','DESG_DESC','DESG_ID='.$row->DESG_ID);?></td>
   
   <td><?php echo date('d-M-Y',strtotime($i));?></td>
  
  <td><?=$new_min_time;$new_min_time=''?></td>

  <td><?=$max_min_time;$max_min_time='';?></td>
  
 <td class="<?=$class?>"><?=$status;$status='';?></td>

	

	</td>




		</tr>



<?  } } ?>

 <tr>
   <td colspan="8"><strong>Total</strong></td>
  <?php /*?> <td><strong>Present : <?=$present+$friday+$leave; $present=0;$friday=0;$leave=0;?></strong></td>
   <td><strong>Absent : <?=$absent; $absent=0;?></strong></td>
   <td><strong>Leave : <?=$leave;$leave=0;?></strong></td><?php */?>
   <td><strong>Late : <?=$late; $late=0;?></strong></td>
 </tr>




		</tbody>



		</table>



		<?

     }





elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}







?>











<table width="100%" border="0" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" id="ExportTable" style="border:0px;border-color:#FFF;" >



<tr>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



</tr>



<tr>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



</tr>



<tr>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



</tr>



<tr>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



</tr>



<tr>



<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>HR Manager </u></strong></td>







<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Asst. Manager </u></strong></td>







<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>General Manager </u></strong></td>







<td width="25%" align="center" style="border:0px;border-color:#FFF;"><strong><u>Authorized By</u></strong></td>



</tr>



<tr>



  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td align="center" style="border:0px;border-color:#FFF;">&nbsp;</td>



</tr>



</table>











<?php /*?><table width="100%" cellspacing="0" cellpadding="0"  style="border:1px solid #000; color: #000;" >











          <tr>



            <td colspan="2" style="border:0px;border-color:#FFF; color: #000; font-size:18px; font-weight:700;" align="center" ><?=$_SESSION['company_name']?> </td>



		</tr>



		  <tr>



			 <td colspan="2" style="border:0px;border-color:#FFF; color: #000;  font-size:14px; " align="center" ><?=$_SESSION['company_address']?></td>



		</tr>



		  <tr>



			 <td colspan="2" style="border:0px;border-color:#FFF; color: #000; font-size:14px; " align="center" >Teliphone:



			  <?=find_a_field('project_info','proj_phone','company_name="'.$_SESSION['company_name'].'"');?></td>



          </tr>



		  <tr>



			 <td colspan="2" style="border:0px;border-color:#FFF; color: #000; font-size:14px; " align="center" >E-mail:



			  <?=find_a_field('project_info','proj_email','company_name="'.$_SESSION['company_name'].'"');?></td>



          </tr>



</table><?php */?>











<table width="100%" border="0" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" id="ExportTable" style="border:0px;border-color:#FFF;" >



<tr>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



  <td style="border:0px;border-color:#FFF;">&nbsp;</td>



</tr>



</table>







</div>






<?

 require_once '../assets/template/inc.footer.php';

?>
