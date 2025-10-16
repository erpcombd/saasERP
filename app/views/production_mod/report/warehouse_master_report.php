<?



session_start();



require "../../../engine/tools/check.php";



require "../../../engine/configure/db_connect.php";



require "../../support/inc.all.php";



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



}



if($_POST['warehouse_id']>0) 				$warehouse_id=$_POST['warehouse_id'];



if($_POST['item_id']>0) 					$item_id=$_POST['item_id'];



if($_POST['receive_status']!='') 			$receive_status=$_POST['receive_status'];



if($_POST['issue_status']!='') 				$issue_status=$_POST['issue_status'];



if($_POST['item_sub_group']>0) 				$sub_group_id=$_POST['item_sub_group'];



if($_POST['item_brand']>0) 				    $item_brand=$_POST['item_brand'];



if($_POST['vendor_id']>0) 				    $vendor_id=$_POST['vendor_id'];



if($_POST['group_id']>0) 				    $group_id=$_POST['group_id'];



switch ($_POST['report']) {



case 100001:



$report="Warehouse Item Wise IN Report";



if(isset($warehouse_id)) 				{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($group_id)) 			{$group_con=' and g.group_id='.$group_id;} 



elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



if(isset($receive_status)){	



if($receive_status=='All_Purchase')



{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}



else



{$status_con=' and a.tr_from="'.$receive_status.'"';}



}



elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if($_SESSION['user']['level']==5 || $_SESSION['user']['level']==100001 || $_SESSION['user']['level']==100002){



echo $sql='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_price as rate,(a.item_in*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and



a.item_id=i.item_id '.$group_con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';



}elseif($_SESSION['user']['level']==4){



$sql='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';



}



else{



$sql='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';}



$sql;



break;



case 100002:



$report="Warehouse Item Wise Out Report";



if(isset($warehouse_id)) 				{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



if(isset($receive_status)){	



if($receive_status=='All_Purchase')



{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}



else



{$status_con=' and a.tr_from="'.$receive_status.'"';}



}



elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if($_SESSION['user']['level']==5 || $_SESSION['user']['level']==1){



$sql='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_ex as `OUT`,a.item_price as rate,(a.item_ex*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';



}elseif($_SESSION['user']['level']==4){



$sql='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_ex as `OUT`,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';



}



else{



$sql='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';}



$sql;



break;



case 100003:



$report="Warehouse Item Wise IN/OUT Report";



if(isset($warehouse_id)) 				{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



if(isset($receive_status)){	



if($receive_status=='All_Purchase')



{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}



else



{$status_con=' and a.tr_from="'.$receive_status.'"';}



}



elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if($_SESSION['user']['level']==5 || $_SESSION['user']['level']==1){



$sql='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';



}elseif($_SESSION['user']['level']==4){



$sql='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';



}



else{



$sql='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';}



$sql;



break;



case 1008:



$report="Warehouse Advance Purchase Report";



if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



$sql='select 



a.item_id,



i.item_name,



s.sub_group_name as Category,



i.unit_name as unit,



sum(a.item_in) as `total_qty`,



(sum(a.item_in*a.item_price)/sum(a.item_in)) as rate,



sum(a.item_in*a.item_price) as amount



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by a.item_id order by a.id';



break;



case 10088:



$report="Suplier Wise IN Report";



if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



elseif(isset($item_id)) 				{$item_con=' and i.item_id='.$item_id;} 



if($_POST['group_id']>0) 				{$group_con=' and s.group_id='.$_POST['group_id'];} 



if(isset($vendor_id)) 				{$vendor_con=' and r.vendor_id='.$vendor_id;}



//$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and r.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



$sql='select 



r.po_no,



r.pr_no as gr_no,



r.rec_date as GR_date,



i.finish_goods_code as code,



g.group_name,



s.sub_group_name,



i.item_name,



v.vendor_name,



r.ch_no as ch_no,



i.unit_name as unit,



r.qty as `total_qty`,



r.rate as rate,



r.amount as amount,



r.entry_at as entry_date,



c.fname as entry_by



from purchase_receive r, item_info i,item_sub_group s,item_group g,user_activity_management c, vendor v where r.vendor_id=v.vendor_id and c.user_id=r.entry_by 



and r.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.$item_group_con.$group_con.' order by r.pr_no';



break;



case 1010:



$report="Issue Report Person/Department wise";



if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($item_id)) 					{$item_con=' and c.item_id='.$item_id;} 



if($_POST['emp_id']!='') 					{$item_con.=' and p.PBI_ID='.$_POST['emp_id'];}



if($_POST['department']!='') 					{$item_con.=' and d.DEPT_ID='.$_POST['department'];}



$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and c.oi_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



$sql='select c.oi_no, c.oi_date, i.item_name, d.DEPT_DESC as requisition_from, p.PBI_NAME as issue_to_p, c.qty from warehouse_other_issue b, warehouse_other_issue_detail c, department d, item_info i, personnel_basic_info p where i.item_id=c.item_id and c.oi_no=b.oi_no and b.requisition_from= d.DEPT_ID and b.issued_to=p.PBI_ID'.$date_con.$item_con;



break;



case 2:



$report="Category Wise Stock Report";



if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($group_id)) 			{$group_con=' and g.group_id='.$group_id;} 



if(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';$date_cons=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



break;



case 22:



$report="Category Wise Stock Report";



if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($group_id)) 			{$group_con=' and g.group_id='.$group_id;} 



if(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';$date_cons=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



break;



case 200002:



$report="Warehouse Stock Position Report(Closing)";



if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($group_id)) 			{$group_con=' and g.group_id='.$group_id;} 



if(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';$date_cons=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



break;



case 200001:



$report="Warehouse Stock Position Report(Closing)";



if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}



break;



case 3:



$report="Warehouse Present Stock";



if(isset($warehouse_id)) 				{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



if(isset($receive_status)) 				{$status_con=' and a.tr_from="'.$receive_status.'"';} 



elseif(isset($issue_status)) 			{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.journal_item between \''.$fr_date.'\' and \''.$to_date.'\'';}



break;



case 4:



$report="Warehouse Present Stock (Finish Goods)";



if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($item_brand)) 				{$brand_con=' and i.item_brand='.$item_brand;} 



elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}



break;



case 5:



$report="Details Sales Report";



if(isset($warehouse_id)) 			{$warehouse_con=' and w.warehouse_id='.$warehouse_id;} 



if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}



//$sql='select 



//m.pi_no,



//a.ji_date,



//w.warehouse_name  as warehouse,



//i.item_brand as brand,



//a.sr_no,



//i.finish_goods_code as fg,



//i.item_name,



//



//i.unit_name as unit,



//a.item_in as qty,



//a.item_price as rate,



//(a.item_in*a.item_price) as amt



//from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where w.use_type="SD" and a.item_in>0 and a.relevant_warehouse='.$_SESSION['user']['depot'].' and 



//d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.id';



$sql='select 



m.pi_no,



a.ji_date,



w.warehouse_name  as warehouse,



i.item_brand as brand,



i.finish_goods_code as fg,



i.item_name,



i.pack_size,



i.unit_name as unit,



a.item_ex as qty,



i.f_price as Cost_Price,



(a.item_ex*i.f_price) as Cost_Amt,



i.d_price as DP_Price,



(a.item_ex*i.d_price) as DP_Amt



from journal_item a, item_info i, user_activity_management c, warehouse w, production_issue_master m, production_issue_detail d  where 



w.use_type!="PL" and a.item_ex>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 



d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and 



c.user_id=a.entry_by and a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.ji_date';



break;



case 6:



$report="Sales Report(Brief)";



if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;}  



if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}



$sql='select 



i.finish_goods_code as fg,



i.item_name,



i.unit_name as unit,



i.item_brand as brand,



sum(a.item_ex) as qty,



i.f_price as Cost_Price,



sum(a.item_ex*f_price) as cost_Amt,



i.d_price as DP_Price,



sum(a.item_ex*i.d_price) as DP_Amt



from journal_item a, item_info i, user_activity_management c,warehouse w  where w.use_type!="PL" and a.item_ex>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 



w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';



break;



case 7:



$report="Chalan Wise Sales Report";



if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}



$sql='select 



m.pi_no, m.pi_date,  w.warehouse_name as Depot, m.remarks as sl_no, m.carried_by,



sum(a.item_in*i.f_price) as cost_amt,sum(a.item_in*i.d_price) as DP_amt



from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where w.use_type="SD" and a.item_in>0 and a.relevant_warehouse='.$_SESSION['user']['depot'].' and 



d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.warehouse_id and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$con.' group by d.pi_no order by m.pi_date';



//$sql='select  	a.pi_no, a.pi_date,  b.warehouse_name as Depot, a.remarks as sl_no, a.carried_by,sum(total_amt) as total_amt from production_issue_master a,production_issue_detail c,warehouse b where   a.warehouse_from='.$_SESSION['user']['depot'].' and a.pi_no=c.pi_no and a.warehouse_to=b.warehouse_id and b.use_type!="PL" '.$con.' group by c.pi_no order by a.pi_no desc';



break;



case 8:



$report="Warehouse Item Transection Report(Entry Wise)";



if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



if(isset($receive_status)){	



if($receive_status=='All_Purchase')



{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}



else



{$status_con=' and a.tr_from="'.$receive_status.'"';}



}



elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.entry_at between \''.$fr_date.'\' and \''.date('Y-m-d',strtotime($_POST['t_date'])+24*60*60).'\'';}



$sql='select a.entry_at,ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,c.fname as User ," " as Line_Manager



from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by warehouse';



break;



case 1001:



$report="Chalan Wise Sales Report";



if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}



if(isset($t_date)) 



{$con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}



break;



case 10011:



$report="Chalan Wise Sales Report";



if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}



if(isset($t_date)) 



{$con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}



break;



case 501:



$report="Details Receive Report";



if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}



$sql='select 



m.pi_no,



a.ji_date,



w.warehouse_name  as warehouse,



i.item_brand as brand,



i.finish_goods_code as fg,



i.item_name,



i.unit_name as unit,



a.item_in as qty,



i.f_price as Cost_Price,



(a.item_in*i.f_price) as Cost_Amt,



i.d_price as DP_Price,



(a.item_in*i.d_price) as DP_Amt



from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 



d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.ji_date';



break;



case 502:



$report="Receive Report(Brief)";



if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}



$sql='select 



i.finish_goods_code as fg,



i.item_name,



i.unit_name as unit,



i.item_brand as brand,



sum(a.item_in) as qty,



i.f_price as Cost_Price,



sum(a.item_in*f_price) as cost_Amt,



i.d_price as DP_Price,



sum(a.item_in*i.d_price) as DP_Amt



from journal_item a, item_info i, user_activity_management c,warehouse w  where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 



w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by  a.item_id order by i.finish_goods_code';



break;



case 503:



$report="PR Wise Receive Report";



if(isset($warehouse_id)) 			{$con.=' and a.relevant_warehouse='.$warehouse_id;} 



if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}



$sql='select 



m.pi_no, m.pi_date,  w.warehouse_name as Depot, m.remarks as sl_no, m.carried_by,



sum(a.item_in*i.d_price) as amt



from journal_item a, item_info i, user_activity_management c,warehouse w,production_issue_master m,production_issue_detail d  where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 



d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") and c.user_id=a.entry_by and a.item_id=i.item_id'.$con.' group by d.pi_no order by m.pi_date';



//$sql='select  	a.pi_no, a.pi_date,  b.warehouse_name as Depot, a.remarks as sl_no, a.carried_by,sum(total_amt) as total_amt from production_issue_master a,production_issue_detail c,warehouse b where   a.warehouse_from='.$_SESSION['user']['depot'].' and a.pi_no=c.pi_no and a.warehouse_to=b.warehouse_id and b.use_type!="PL" '.$con.' group by c.pi_no order by a.pi_no desc';



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



</style>



</head>



<body>



<div align="center" id="pr">



<input name="button" type="button" onclick="window.print();" value="Print" />



</div>



<div class="main">



<?



$str 	.= '<div class="header">';



$str 	.= '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



$str 	.= '<h2>'.$report.'</h2>';



if(isset($to_date)) 



$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';



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



if($_POST['report']==21010)



{



$sql='';



$report="Purchase Requisition Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



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



<th width="5%">PR No</th>



<th width="5%">PR Date</th>



<th width="10%"><div align="center">Req For</div></th>



<th width="10%"><div align="center">Req By</div></th>



<th width="5%"><div align="center">Status</div></th>



<th width="38%">Item Name </th>



<th width="7%">Qty</th>



<th width="7%">Po No</th>



<th width="6%">PO Qty </th>



<th width="6%">Due Qty </th>



</tr>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.req_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



$res='select  a.req_no, a.req_date,b.warehouse_name req_for,u.fname as entry_by,a.status



from requisition_master a,warehouse b,user_activity_management u 



where u.user_id=a.entry_by  and  b.warehouse_id = a.req_for '.$con.' order by a.req_no ';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td valign="top"><?=$data->req_no;?></td>



<td valign="top"><?=$data->req_date;?></td>



<td valign="top"><div align="center">



<?=$data->req_for;?>



</div></td>



<td valign="top"><div align="center">



<?=$data->entry_by;?>



</div></td>



<td valign="top"><div align="center">



<?=$data->status;?>



</div></td>



<td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px; border:0;">



<? 



$sql1 = 'select a.*,b.item_name from requisition_order a,item_info b where a.item_id=b.item_id and a.req_no="'.$data->req_no.'"';



$sqlq = db_query($sql1);



while($info=mysqli_fetch_object($sqlq)){



?>



<tr>



<td width="60%"><?=$info->item_name.'('.$info->unit_name.')';?></td>



<td width="10%"><?=$info->qty?></td>



<td width="10%"><? 



$i = 0;



$t ="select po_no,qty from purchase_invoice i where i.req_id = '".$info->id."' and



i.item_id=".$info->item_id;



$total_qty=0;



$s = db_query($t);



while($q=mysqli_fetch_object($s)){ if($i>0) echo ','.$q->po_no; else echo $q->po_no; $i++; 



$total_qty=($total_qty+$q->qty);



}



if($i==0) echo '<span style=" color: red;">PENDING</span>';



?></td>



<td width="10%"><? echo $total_qty; ?></td>



<td width="10%"><? echo ($info->qty-$total_qty); ?></td>



</tr>



<? }?>



</table></td>



</tr>



<? }?>



</tbody></table>



<?



}



if($_POST['report']==700001)



{



$sql='';



//$tin += $data->IN;



//$tamt += $data->amount;



$report="Production Line Return Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="20" style="border:0px;">



<?



echo '<div class="header">';



//echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">In</th>



<th width="7%">Rate</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'].' ';};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'].' ';};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'].' ';};



$sl=0;



if(isset($receive_status)){	



if($receive_status=='All_Purchase')



{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}



else



{$status_con=' and a.tr_from="'.$receive_status.'"';}



}



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,sum(a.item_in) as `IN`,sum(a.item_price) as rate,sum((a.item_in*a.item_price)) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.sr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and



a.item_in>0 and a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'"  '.$group_con.$con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by i.item_id order by i.item_name asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->fg_code?></td>



<td><a href="master_report.php?report=100012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$data->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>" target="_blank"><?=$data->item_name?></a></td>



<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->IN, 3, '.','');$tin +=$data->IN;?></td>



<td><?=number_format($data->amount/$data->IN, 3 , '.', ''); ?></td>



<td><?=number_format($data->amount, 3 , '.', '');$tamt +=$data->amount;?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



}?>



<tr> 



<td colspan="5" align="right">&nbsp;<strong>Total:</strong></td>



<td >&nbsp;<strong><?=$tin?></strong></td>



<td >&nbsp;</td>



<td colspan="2" align="left">&nbsp;<strong><?=number_format($tamt,2)?></strong></td>



</tr>



</tbody></table>



<?



}



if($_POST['report']==100011)



{



$sql='';



//$tin += $data->IN;



//$tamt += $data->amount;



$report="Warehouse Item Wise IN Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="20" style="border:0px;">



<?



echo '<div class="header">';



//echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



if($_POST['receive_status']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> In Type : '.$_POST['receive_status'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">In</th>



<th width="7%">Rate</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'].' ';};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'].' ';};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'].' ';};



$sl=0;



if(isset($receive_status)){	



if($receive_status=='All_Purchase')



{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}



else



{$status_con=' and a.tr_from="'.$receive_status.'"';}



}



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,sum(a.item_in) as `IN`,sum(a.item_price) as rate,sum((a.item_in*a.item_price)) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.sr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and



a.item_in>0 and a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'"  '.$group_con.$con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by i.item_id order by i.item_name asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->fg_code?></td>



<td><a href="master_report.php?report=100012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$data->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['receive_status']?>" target="_blank"><?=$data->item_name?></a></td>



<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->IN, 3, '.','');$tin +=$data->IN;?></td>



<td><?=number_format($data->amount/$data->IN, 3 , '.', ''); ?></td>



<td><?=number_format($data->amount, 3 , '.', '');$tamt +=$data->amount;?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



}?>



<tr> 



<td colspan="5" align="right">&nbsp;<strong>Total:</strong></td>



<td >&nbsp;<strong><?=$tin?></strong></td>



<td >&nbsp;</td>



<td colspan="2" align="left">&nbsp;<strong><?=number_format($tamt,2)?></strong></td>



</tr>



</tbody></table>



<?



}

if($_POST['report']=="112233445566"){



$sql='';



//$tin += $data->IN;



//$tamt += $data->amount;



$report="Warehouse Item Wise IN Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="20" style="border:0px;">



<?



echo '<div class="header">';



//echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



if($_POST['receive_status']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> In Type : '.$_POST['receive_status'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>
<tbody>
<tr>
<th width="5%">S/L</th>
<th width="10%"><div align="center">Fg Code</div></th>
<th width="35%"><div align="center">Item Name</div></th>
<th width="14%"><div align="center">Category</div></th>
<th width="5%">Unit</th>
<th width="7%">Qty</th>
<th width="7%">Rate</th>
<th width="6%">Amount </th>
<th width="6%">Tr Type</th>
<th>Consumption</th>
</tr>

<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'].' ';};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'].' ';};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'].' ';};



$sl=0;



if(isset($receive_status)){	



if($receive_status=='All_Purchase')



{$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';}



else



{$status_con=' and a.tr_from="'.$receive_status.'"';}



}



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,sum(a.item_in) as `IN`,sum(a.item_price) as rate,sum((a.item_in*a.item_price)) as amount,a.tr_from as tr_type,a.sr_no



from journal_item a, item_info i,  item_sub_group s, item_group g where  s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and



a.item_in>0 and a.item_id=i.item_id and a.tr_from like "Production Receive"   '.$date_con.' group by a.sr_no order by i.item_name asc';

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>

<tr>
<td><?=++$sl;?></td>
<td><?=$data->fg_code?></td>
<td><a href="master_report.php?report=100012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$data->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['receive_status']?>" target="_blank"><?=$data->item_name?></a></td>

<td><?=$data->Category?></td>
<td><?=$data->unit?></td>
<td><?=number_format($data->IN, 3, '.','');$tin +=$data->IN;?></td>
<td><?=number_format($data->amount/$data->IN, 3 , '.', ''); ?></td>
<td><?=number_format($data->amount, 3 , '.', '');$tamt +=$data->amount;?></td>
<td><?=$data->tr_type?></td>
</tr>
<? }?>
<tr> 
<td colspan="5" align="right">&nbsp;<strong>Total:</strong></td>
<td >&nbsp;<strong><?=$tin?></strong></td>
<td >&nbsp;</td>
<td colspan="2" align="left">&nbsp;<strong><?=number_format($tamt,2)?></strong></td>
</tr>
</tbody></table>
<?
}


if($_POST['report']==190629)



{



$sql='';



$report="All  Damage Stock Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="20" style="border:0px;">



<?



echo '<div class="header">';



//echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



if($_POST['receive_status']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> In Type : '.$_POST['receive_status'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th><div align="center">Item Code</div></th>



<th width="7%">D R No</th>



<th ><div align="center">Item Name</div></th>



<th ><div align="center">Dealer Name</div></th>



<th width="7%">Unit</th>



<th width="7%">Rate</th>



<th width="7%">Ctn</th>



<th width="7%">Pcs</th>



<th width="7%">total Pcs</th>



<th width="7%">Total Amount</th>



</tr>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and d.or_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'].' ';};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'].' ';};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'].' ';};



$sl=0;



$res='select d.*,dd.*,i.item_name,i.pack_size



from sales_damage_receive_master d,  sales_damage_receive_detail dd,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=d.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and



i.item_id=dd.item_id and d.warehouse_id=dd.warehouse_id and d.status="UNCHECKED"  '.$group_con.$con.$date_con.$item_con.$status_con.$item_sub_con.' ';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



$pkt = intval($data->qty / $data->pack_size);



$pcs = $data->qty % $data->pack_size;



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->item_id;?></td>



<td><a href="../../../damage_mod/pages/damage_report/damage_view_print.php?v_no=<?=$data->or_no;?>"><?=$data->or_no;?></a></td>



<td><?=$data->item_name;?></td>



<td><?=$data->vendor_name;?></td>



<td><?=$data->unit_name;?></td>



<td><?=$data->rate;?></td>



<td><? echo $pkt; $tot_pkt = $tot_pkt + $pkt ;?></td>



<td><? echo $pcs; $tot_pcs = $tot_pcs + $pcs ; ?></td>



<td><?=$data->qty; $tot_all_pcs = $tot_all_pcs + $data->qty ; ?></td>



<td><?=number_format($data->amount, 3, '.','');$tin +=$data->amount;?></td>



</tr>



<?



}?>



<tr> 



<td colspan="7" align="right">&nbsp;<strong>Total:</strong></td>



<td >&nbsp;<strong><?=$tot_pkt;?></strong></td>



<td >&nbsp;<strong><?=$tot_pcs;?></strong></td>



<td >&nbsp;<strong><?=$tot_all_pcs;?></strong></td>



<td  align="left">&nbsp;<strong><?=number_format($tin,2)?></strong></td>



</tr>



</tbody></table>



<?



}



if($_POST['report']==190623)



{



$sql='';



//$tin += $data->IN;



//$tamt += $data->amount;



$report="All Opening Stock Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="20" style="border:0px;">



<?



echo '<div class="header">';



//echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



if($_POST['receive_status']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> In Type : '.$_POST['receive_status'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="15%"><div align="center">Warehouse Name</div></th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">FINAL STOCK</th>



<th width="7%">Rate</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['brand_category']!=''){$brand_con = ' and i.brand_category='.$_POST['brand_category'].' ';};



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'].' ';};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'].' ';};



if($_POST['warehouse_id']!=''){$warehouse_con = ' and a.warehouse_id="'.$_POST['warehouse_id'].'" ';};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'].' ';};



$sl=0;



if(isset($receive_status)){	



if($receive_status=='Opening')



{$status_con=' and a.tr_from = "Opening"';}



else



{$status_con=' and a.tr_from="'.$receive_status.'"';}



}



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,sum(a.item_in) as `IN`,sum(a.item_price) as rate,sum((a.item_in*a.item_price)) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.warehouse_id) as warehouse,a.sr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and  a.item_id=i.item_id  '.$group_con.$warehouse_con.$con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$brand_con.' group by i.item_id order by i.item_name asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->fg_code?></td>



<td><a href="warehouse_master_report.php?report=19623&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$data->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['receive_status']?>&warehouse_id=<?=$_POST['warehouse_id']?>" target="_blank"><?=$data->item_name?></a></td>



<td><?=$data->warehouse;?></td>



<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->IN, 3, '.','');$tin +=$data->IN;?></td>



<td><?=number_format($data->amount/$data->IN, 3 , '.', ''); ?></td>



<td><?=number_format($data->amount, 3 , '.', '');$tamt +=$data->amount;?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



}?>



<tr> 



<td colspan="6" align="right">&nbsp;<strong>Total:</strong></td>



<td >&nbsp;<strong><?=$tin?></strong></td>



<td >&nbsp;</td>



<td colspan="2" align="left">&nbsp;<strong><?=number_format($tamt,2)?></strong></td>



</tr>



</tbody></table>



<?



}



if($_REQUEST['report']==100012)



{



$sql='';



$report="Warehouse Item Wise IN Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='') 



echo '<h2>Date Interval : '.$_REQUEST['f_date'].' To '.$_REQUEST['t_date'].'</h2>';



if($_REQUEST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_REQUEST['group_id']).'</h2>';}



if($_REQUEST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_REQUEST['item_sub_group']).'</h2>';}



if($_REQUEST['item_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Item Name : '.find_a_field('item_info','item_name','item_id='.$_REQUEST['item_id']).'</h2>';}


if($_REQUEST['item_id']!=''){ echo '<h3 style="font-weight: bold; height: 10px;text-decoration: underline;"> FG CODE : '.find_a_field('item_info','finish_goods_code','item_id='.$_REQUEST['item_id']).'</h3>';}

if($_REQUEST['tr_type']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> In Type : '.$_REQUEST['tr_type'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%">Date</th>







<th width="5%">Transaction No</th>



<th width="8%">Remarks</th>



<th width="5%">Category</th>



<th width="5%">Unit</th>



<th width="7%">In</th>



<th width="7%">Rate</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='')



$date_con .= 'and a.ji_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'" ';



if($_REQUEST['item_id']!=''){ $item_con .=' and i.item_id='.$_REQUEST['item_id'].' '; }



if($_REQUEST['group_id']!=''){$group_con = ' and g.group_id='.$_REQUEST['group_id'].' ';};



if($_REQUEST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_REQUEST['item_sub_group'].' ';};



if($_REQUEST['tr_type']!=''){$tr_con = ' and a.tr_from="'.$_REQUEST['tr_type'].'" ';};



if($_REQUEST['warehouse_id']!=''){$warehouse_id_con = ' and a.warehouse_id="'.$_REQUEST['warehouse_id'].'" ';};



$sl=0;



//if($_GET['warehouse_id']>0)$warehouse_con =  ' and a.warehouse_id="'.$_GET['warehouse_id'].'"';	else



//$warehouse_con =  ' and a.warehouse_id="'.$_SESSION['user']['depot'].'"';



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,a.sr_no, i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_price as rate,(a.item_in*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.sr_no,a.entry_at,c.fname as User



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and a.item_in!="" and



a.item_id=i.item_id '.$group_con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$tr_con.$warehouse_id_con.' order by a.ji_date asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->ji_date?></td>







<?	 if($data->tr_type =="Production Receive"){?>



<td> <a href="../../../production_mod/pages/production_issue/production_issue_report.php?v_no= <?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></a></td>



<? } elseif ($data->tr_type =="Sales Return") {?>



<td><a href="../sr_report/damage_view_print.php?req_no= <?=$data->sr_no?>" target="_blank"><?=$data->sr_no?> </a></td>



<? } elseif ($data->tr_type =="Opening-2016" || $data->tr_type =="Opening" || $data->tr_type =="Opening Adjustment") {?>



<td>&nbsp;</td> 



<? } elseif ($data->tr_type =="Purchase") { ?>



<td><a href="../pr/chalan_view2.php?v_no= <?=$data->sr_no?>" target="_blank"> <?=$data->sr_no?> </a></td>



<? } elseif($data->tr_type == "Issue"){ ?>



<td><a href="../production_issue/production_issue_report.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no?> </a></td>



<? } elseif($data->tr_type == "Local Purchase"){?>



<td><a href="../pr_local/chalan_view2.php?v_no=<?=$data->sr_no?>" target="_blank"> <?=$data->sr_no?></a></td>



<? }  elseif ($data->tr_type == "Production Return") {?>



<td><a href="../production_return/production_receive_report.php?v_no=<?=$data->sr_no?>" target="_blank"> <?=$data->sr_no?></a></td>



<? } ?>






<td><? if($data->tr_type =="Production Receive"){ echo $remarks = find_a_field('production_floor_issue_master','remarks','pi_no='.$data->sr_no);}
elseif ($data->tr_type=="Issue") {echo $remarks =find_a_field('master_requisition_master','manual_req_no','req_no='.$data->sr_no);}
elseif ($data->tr_type =="Sales Return") {echo $remarks = find_a_field ('warehouse_damage_receive','or_subject','or_no='.$data->sr_no);}
elseif ($data->tr_type =="Purchase") { echo $remarks = find_a_field('purchase_receive','remarks','pr_no='.$data->sr_no);}
elseif ($data->tr_type =="Local Purchase") { echo $remark = find_a_field('purchase_receive_local','remarks','pr_no='.$data->sr_no);}
elseif ($data->tr_type =="Local Purchase") {  echo $remark = find_a_field('purchase_receive_local','remarks','pr_no='.$data->sr_no);}
else {
echo "&nbsp";
}

?></td>







<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->IN, 3, '.', '');?></td>



<td><?=number_format($data->rate, 3, '.', '');?></td>



<td><?=number_format($data->amount, 3, '.', '');?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



$tot_in = $tot_in+$data->IN;



//$tot_rate = $tot_rate+$data->rate;



$tot_amount = $tot_amount+$data->amount;



}?>



<tr>







<td>&nbsp;</td>



<td>&nbsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td><?=$tot_in?></td>



<td><?=$tot_rate?></td>



<td><?=$tot_amount?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



if($_POST['report']==190808)



{



$sql='';



$report="Warehouse Finished Goods Production Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_POST['f_date']!=''&& $_POST['t_date']!='') 



echo '<h2>Date Interval : '.$_POST['f_date'].' To '.$_POST['t_date'].'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



if($_POST['brand_category']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> FG SECTION : '.$_POST['brand_category'].'</h2>';}



if($_POST['item_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Item Name : '.find_a_field('item_info','item_name','item_id='.$_POST['item_id']).'</h2>';}



if($_POST['tr_type']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> In Type : '.$_POST['tr_type'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="2%">S/L</th>



<th width="5%">Date</th>



<th width="3%"><div align="center">Fg Code</div></th>



<th width="18%">Item Name</th>



<th width="5%">Transaction No</th>



<th width="8%">Remarks</th>



<th width="5%">Section</th>



<th width="4%">Unit</th>



<th width="5%">In</th>



<th width="7%">Rate</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_POST['f_date']!=''&& $_POST['t_date']!='')



$date_con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ';



if($_POST['item_id']!=''){ $item_con .=' and i.item_id='.$_POST['item_id'].' '; }



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'].' ';};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'].' ';};



if($_POST['brand_category']!=''){ $brand_con .=' and i.brand_category="'.$_POST['brand_category'].'" '; }



if($_POST['tr_type']!=''){$tr_con = ' and a.tr_from="'.$_POST['tr_type'].'" ';};



$sl=0;



if($_POST['warehouse_id']>0)$warehouse_con =  ' and a.warehouse_id="'.$_POST['warehouse_id'].'"';	else



$warehouse_con =  ' and a.warehouse_id="'.$_SESSION['user']['depot'].'"';



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,a.sr_no, i.item_name,i.brand_category,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_price as rate,(a.item_in*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.sr_no,a.entry_at,c.fname as User



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and a.item_in!="" and



a.item_id=i.item_id and a.tr_from="Production Receive" '.$group_con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$tr_con.$brand_con.' order by a.ji_date asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->ji_date?></td>



<td><?=$data->fg_code?></td>



<td><?=$data->item_name?></td>



<?	 if($data->tr_type =="Production Receive"){?>



<td> <a href="../../../production_mod/pages/production_issue/production_issue_report.php?v_no= <?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td>



<?php } ?>



<? if($data->tr_type =="Production Receive"){ 



$remarks = find_a_field('production_floor_issue_master','remarks','pi_no='.$data->sr_no);



?>



<td><?php echo $remarks;?></td>



<?php } ?>



<td><?=$data->brand_category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->IN, 3, '.', '');?></td>



<td><?=number_format($data->rate, 3, '.', '');?></td>



<td><?=number_format($data->amount, 3, '.', '');?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



$tot_in = $tot_in+$data->IN;



//$tot_rate = $tot_rate+$data->rate;



$tot_amount = $tot_amount+$data->amount;



}?>



<tr>



<td colspan="8" align="right" bordercolor="#FFFFFF" ><strong >Total</strong></td>



<td bordercolor="#FFFFFF"><strong><?=$tot_in?></strong></td>



<td bordercolor="#FFFFFF"><?=$tot_rate?></td>



<td bordercolor="#FFFFFF"><strong><?=$tot_amount?></strong></td>



<td bordercolor="#FFFFFF">&emsp;</td>



</tr>



</tbody></table>



<?



}



if($_REQUEST['report']==19629)



{



$sql='';



$report="All GOOD and BAD Stock Report in Detail";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='') 



echo '<h2>Date Interval : '.$_REQUEST['f_date'].' To '.$_REQUEST['t_date'].'</h2>';



if($_REQUEST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_REQUEST['group_id']).'</h2>';}



if($_REQUEST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_REQUEST['item_sub_group']).'</h2>';}



if($_REQUEST['tr_type']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> In Type : '.$_REQUEST['tr_type'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%">Date</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="5%">MR No</th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">In</th>



<th width="7%">Rate</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='')



$date_con .= 'and a.ji_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'" ';



if($_REQUEST['item_id']!=''){ $item_con .=' and i.item_id='.$_REQUEST['item_id'].' '; }



if($_REQUEST['group_id']!=''){$group_con = ' and g.group_id='.$_REQUEST['group_id'].' ';};



if($_REQUEST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_REQUEST['item_sub_group'].' ';};



if($_REQUEST['tr_type']!=''){$tr_con = ' and a.tr_from="'.$_REQUEST['tr_type'].'" ';};



$sl=0;



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,a.sr_no, i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_price as rate,(a.item_in*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.sr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and a.item_in!="" and



a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$group_con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$tr_con.' order by a.ji_date asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->ji_date?></td>



<td><?=$data->fg_code?></td>



<td><?=$data->item_name?></td>



<td><?=$data->sr_no?></td>



<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->IN, 3, '.', '');?></td>



<td><?=number_format($data->rate, 3, '.', '');?></td>



<td><?=number_format($data->amount, 3, '.', '');?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



$tot_in = $tot_in+$data->IN;



//$tot_rate = $tot_rate+$data->rate;



$tot_amount = $tot_amount+$data->amount;



}?>



<tr>



<td>&emsp;</td>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td><?=$tot_in?></td>



<td><?=$tot_rate?></td>



<td><?=$tot_amount?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



if($_REQUEST['report']==19623)



{



$sql='';



$report="Opening Report in Detail";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='') 



echo '<h2>Date Interval : '.$_REQUEST['f_date'].' To '.$_REQUEST['t_date'].'</h2>';



if($_REQUEST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_REQUEST['group_id']).'</h2>';}



if($_REQUEST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_REQUEST['item_sub_group']).'</h2>';}



if($_REQUEST['tr_type']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> In Type : '.$_REQUEST['tr_type'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%">Date</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="5%">MR No</th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">In</th>



<th width="7%">Rate</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='')



$date_con .= 'and a.ji_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'" ';



if($_REQUEST['item_id']!=''){ $item_con .=' and i.item_id='.$_REQUEST['item_id'].' '; }



if($_REQUEST['group_id']!=''){$group_con = ' and g.group_id='.$_REQUEST['group_id'].' ';};



if($_REQUEST['warehouse_id']!=''){$warehouse_con = ' and a.warehouse_id='.$_REQUEST['warehouse_id'].' ';};



if($_REQUEST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_REQUEST['item_sub_group'].' ';};



if($_REQUEST['tr_type']!=''){$tr_con = ' and a.tr_from="'.$_REQUEST['tr_type'].'" ';};



$sl=0;



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,a.sr_no, i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_price as rate,(a.item_in*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.sr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and a.item_in!="" and



a.item_id=i.item_id  '.$group_con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$tr_con.' order by a.ji_date asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->ji_date?></td>



<td><?=$data->fg_code?></td>



<td><?=$data->item_name?></td>



<td><?=$data->sr_no?></td>



<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->IN, 3, '.', '');?></td>



<td><?=number_format($data->rate, 3, '.', '');?></td>



<td><?=number_format($data->amount, 3, '.', '');?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



$tot_in = $tot_in+$data->IN;



//$tot_rate = $tot_rate+$data->rate;



$tot_amount = $tot_amount+$data->amount;



}?>



<tr>



<td>&emsp;</td>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td><?=$tot_in?></td>



<td><?=$tot_rate?></td>



<td><?=$tot_amount?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



if($_POST['report']==200011)



{



$sql='';



$report="Warehouse Item Wise Out Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="20" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



//echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



if($_POST['warehouse_to']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Issue To : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_to']).'</h2>';}



if($_POST['production_line']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Warehouse : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['production_line']).'</h2>';}



if($_POST['issue_status']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Out Type : '.$_POST['issue_status'].'</h2>';}



if($_POST['vendor_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Out Type : '.$_POST['vendor_id'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">Out In Pcs</th>



<th width="7%">Rate</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ';



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'].' ';};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'].' ';};



if($_POST['brand_category']!='') 			{$brand_connn=' and i.brand_category="'.$_POST['brand_category'].'"';} 



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'].' ';};



if($_POST['production_line']!=''){$relevant_warehouse_con = ' and a.relevant_warehouse="'.$_POST['production_line'].'" ';};



if($_POST['warehouse_id']!=''){$warehouse_id_con = ' and a.warehouse_id="'.$_POST['warehouse_id'].'" ';};



if($_POST['vendor_id']!=''){$warehouse_id_con = ' and a.warehouse_id="'.$_POST['vendor_id'].'" ';};







$sl=0;



if(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,i.brand_category,s.sub_group_name as Category,i.unit_name as unit,sum(a.item_ex) as `OUT`,sum(a.item_price) as rate,sum((a.item_ex*a.item_price)) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a,


item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and



a.item_ex > 0 and  a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$group_con.$con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$relevant_warehouse_con.$warehouse_id_con.$brand_connn.' group by i.item_id order by i.item_name asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->fg_code?></td>



<td><a href="master_report.php?report=200012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$data->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['issue_status']?>&relevant_warehouse_id=<?=$_POST['production_line']?>&warehouse_id=<?=$_POST['warehouse_id']?>" target="_blank"><?=$data->item_name?></a></td>



<td><?=$data->brand_category?></td>



<td><?=$data->unit?></td>



<td><? if(number_format($data->OUT, 3, '.', '') != 0.000) echo number_format($data->OUT, 3, '.', ''); else echo " ";  $tot_out += $data->OUT; ?></td>



<td><? if(number_format($data->rate, 3, '.', '') != 0.000) echo number_format($data->rate, 3, '.', ''); else echo " ";?></td>



<td><? if(number_format($data->amount, 3, '.', '') != 0.000) echo number_format($data->amount, 3, '.', ''); else echo " "; $tamt +=$data->amount; ?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



}?>



<tr>



<td colspan="4">&nbsp;</td>



<td colspan=""><strong>Total:</strong></td>



<td colspan="2"><strong><?=number_format($tot_out,3); ?></strong></td>



<td colspan="2"><strong><?=number_format($tamt,3); ?></strong></td>



</tr>



</tbody></table>



<?



}



// warehouse correction : 25/7/19 by rony || all warehouse report corrected



if($_POST['report']==190625)



{



$sql='';



$report="Warehouse Item Wise Consumption Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="20" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



//echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



if($_POST['warehouse_to']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Issue To : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_to']).'</h2>';}



if($_POST['warehouse_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Warehouse : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id']).'</h2>';}



if($_POST['issue_status']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Out Type : '.$_POST['issue_status'].'</h2>';}



if($_POST['vendor_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Out Type : '.$_POST['vendor_id'].'</h2>';}



if($_POST['production_line']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Warehouse : '.$_POST['warehouse_id'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">Out</th>



<th width="7%">Rate</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ';



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'].' ';};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'].' ';};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'].' ';};



if($_POST['production_line']!=''){$relevant_warehouse_con = ' and a.relevant_warehouse="'.$_POST['production_line'].'" ';};



if($_POST['warehouse_id']!=''){$warehouse_id_con = ' and a.warehouse_id="'.$_POST['warehouse_id'].'" ';};



if($_POST['vendor_id']!=''){$warehouse_id_con = ' and a.warehouse_id="'.$_POST['vendor_id'].'" ';};



$sl=0;



if(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,sum(a.item_ex) as `OUT`,sum(a.item_price) as rate,sum((a.item_ex*a.item_price)) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and



a.item_ex > 0 and  a.item_id=i.item_id   '.$group_con.$con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$relevant_warehouse_con.$warehouse_id_con.' group by i.item_id order by a.ji_date asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->fg_code?></td>



<td><a href="warehouse_master_report.php?report=19625&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$data->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['issue_status']?>&relevant_warehouse_id=<?=$_POST['production_line']?>&warehouse_id=<?=$_POST['warehouse_id']?>" target="_blank"><?=$data->item_name?></a></td>



<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->OUT, 3, '.', '');?></td>



<td><?=number_format($data->rate, 3, '.', '');?></td>



<td><?=number_format($data->amount, 3, '.', ''); $tamt +=$data->amount; ?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



}?>



<tr>



<td colspan="6">&nbsp;</td>



<td colspan=""><strong>Total:</strong></td>



<td colspan="2"><strong><?=number_format($tamt,3); ?></strong></td>



</tr>



</tbody></table>



<?



}



if($_REQUEST['report']==200012)



{



$sql='';



$report="Warehouse Item Wise Out Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



//echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='') 



echo '<h2>Date Interval : '.$_REQUEST['f_date'].' To '.$_REQUEST['t_date'].'</h2>';



if($_REQUEST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_REQUEST['group_id']).'</h2>';}



if($_REQUEST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_REQUEST['item_sub_group']).'</h2>';}



if($_REQUEST['item_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> ITEM NAME : '.find_a_field('item_info','item_name','item_id='.$_REQUEST['item_id']).'</h2>';}

if($_REQUEST['item_id']!=''){ echo '<h3 style="font-weight: bold; height: 10px;text-decoration: underline;"> FG CODE : '.find_a_field('item_info','finish_goods_code','item_id='.$_REQUEST['item_id']).'</h3>';}

//if($_REQUEST['warehouse_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Warehouse : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_REQUEST['warehouse_id']).'</h2>';}



if($_REQUEST['tr_type']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Out Type : '.$_REQUEST['tr_type'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%">Date</th>






<th width="10%"><div align="center">DO NO</div></th>



<th width="10%"><div align="center">Transaction No</div></th>



<th width="1%"><div align="center">Remarks</div></th>



<th width="5%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">Out</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='')



$date_con .= 'and a.ji_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'" ';



if($_REQUEST['tr_type']!='')



{ $issue_con =' and a.tr_from="'.$_REQUEST['tr_type'].'" '; }



if($_REQUEST['item_id']!='')



{ $item_con .=' and i.item_id='.$_REQUEST['item_id'].' '; }



if($_REQUEST['group_id']!=''){$group_con = ' and g.group_id='.$_REQUEST['group_id'].' ';};



if($_REQUEST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_REQUEST['item_sub_group'].' ';};



if($_REQUEST['relevant_warehouse_id']!=''){$relevant_warehouse_con = ' and a.relevant_warehouse="'.$_REQUEST['relevant_warehouse_id'].'" ';};



if($_REQUEST['warehouse_id']!=''){$warehouse_id_con = ' and a.warehouse_id="'.$_REQUEST['warehouse_id'].'" ';};



// if($_GET['warehouse_id']>0)



// $warehouse_con =  ' and a.warehouse_id="'.$_GET['warehouse_id'].'"';



//	else



// $warehouse_con =  ' and a.warehouse_id="'.$_SESSION['user']['depot'].'"';



$sl=0;



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_ex as `OUT`,a.item_price as rate,(a.item_ex*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,a.sr_no,c.fname as User 



from journal_item a, 



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and a.item_ex >0 and  



a.item_id=i.item_id  '.$issue_con.$group_con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$relevant_warehouse_con.$warehouse_id_con.' order by a.ji_date asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->ji_date?></td>







<? if($data->tr_type =="Sales"){ 	



$ch_re = find_a_field('sale_do_chalan','do_no','chalan_no='.$data->sr_no);



$do = find_a_field('sale_do_master','do_no','do_no='.$ch_re);



?>



<td><a href="../do/do_view.php?v_no=<?=$do?>" target="_blank"><?=$do?></td>



<? } elseif ($data->tr_type =="Consumption") {?>



<td></td>



<? } elseif($data->tr_type =="Issue") { ?>



<td></td>



<? } elseif($data->tr_type == "Other Issue") { ?>



<td></td>



<? }  elseif($data->tr_type == "Staff Sales") {



$ch_re = find_a_field('sale_other_chalan','do_no','chalan_no='.$data->sr_no);



$do = find_a_field('sale_other_master','do_no','do_no='.$ch_re);



 ?>





<td><a href="../ss/work_order_bill_corporate.php?v_no=<?=$do?>" target="_blank"><?=$do?></td>





<? }  elseif($data->tr_type == "Opening Adjustment") { ?><td></td>



<? } ?>



<? if($data->tr_type =="Sales"){

$gate = find_a_field('sale_do_chalan','gate_pass_type','chalan_no='.$data->sr_no);
$gate_no = find_a_field('sale_do_chalan','gate_pass_no','chalan_no='.$data->sr_no);

?>



<td> <a href="chalan_view.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no;?></a> <? echo ' '.$gate.'-'.$gate_no;?></td>



<? } elseif ($data->tr_type =="Consumption") {?>



<td><a href="production_issue_report.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td>



<? } elseif($data->tr_type =="Issue") { ?>



<td><a href="../production_issue/production_issue_report.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td>



<? } elseif($data->tr_type == "Other Issue") { ?>



<td><a href="../other_issue/other_issue_report.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td>



<? }  elseif($data->tr_type == "Staff Sales") { ?>



<td><a href="../ss_chalan/chalan_view.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td><? }  elseif($data->tr_type == "Opening Adjustment") { ?><td></td>



<? } ?>



<? 

?>



<td><? if($data->tr_type=="Issue"){ echo $remarks = find_a_field('master_requisition_master','manual_req_no','req_no='.$data->sr_no);}

elseif($data->tr_type =="Sales"){ $ch_re = find_a_field('sale_do_chalan','do_no','chalan_no='.$data->sr_no); echo $remarks = find_a_field('sale_do_master','pi_no','do_no='.$ch_re);

} elseif($data->tr_type=="Consumption"){ echo $remarks = find_a_field('production_floor_issue_master','remarks','pi_no='.$data->sr_no);}
elseif($data->tr_type=="Other Issue"){ echo $remarks = find_a_field('warehouse_other_issue','oi_subject','oi_no='.$data->sr_no);}

 else{ echo "&nbsp;";} ?>


</td>







<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->OUT, 3, '.', '');?></td>



<td><?=number_format($data->amount, 3, '.', '');?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



$tot_OUT = $tot_OUT+$data->OUT;



$tot_rate = $tot_rate+$data->rate;



$tot_amount = $tot_amount+$data->amount;



}?>



<tr>







<td>&nbsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td><?=$tot_OUT?></td>



<td><?=number_format($tot_amount,3);?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



if($_REQUEST['report']==19625)



{



$sql='';



$report="All Consumption Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



//echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='') 



echo '<h2>Date Interval : '.$_REQUEST['f_date'].' To '.$_REQUEST['t_date'].'</h2>';



if($_REQUEST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_REQUEST['group_id']).'</h2>';}



if($_REQUEST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_REQUEST['item_sub_group']).'</h2>';}



if($_REQUEST['warehouse_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Warehouse : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$_REQUEST['warehouse_id']).'</h2>';}



if($_REQUEST['tr_type']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Out Type : '.$_REQUEST['tr_type'].'</h2>';}



echo '</div>';



//if($_REQUEST['warehouse_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline; align:center;"> Warehouse : '.$_REQUEST['warehouse_id'].'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%">Date</th>



<th width="10%">Transaction No.</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">Out</th>



<th width="6%">Amount </th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='')



$date_con .= 'and a.ji_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'" ';



if($_REQUEST['tr_type']!='')



{ $issue_con =' and a.tr_from="'.$_REQUEST['tr_type'].'" '; }



if($_REQUEST['item_id']!='')



{ $item_con .=' and i.item_id='.$_REQUEST['item_id'].' '; }



if($_REQUEST['group_id']!=''){$group_con = ' and g.group_id='.$_REQUEST['group_id'].' ';};



if($_REQUEST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_REQUEST['item_sub_group'].' ';};



if($_REQUEST['relevant_warehouse_id']!=''){$relevant_warehouse_con = ' and a.relevant_warehouse="'.$_REQUEST['relevant_warehouse_id'].'" ';};



if($_REQUEST['warehouse_id']!=''){$warehouse_id_con = ' and a.warehouse_id="'.$_REQUEST['warehouse_id'].'" ';};



$sl=0;



//(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,



//and a.warehouse_id="'.$_REQUEST['warehouse_id'].'"



echo $res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_ex as `OUT`,a.item_price as rate,(a.item_ex*a.item_price) as amount,a.tr_from as tr_type,a.tr_no,a.sr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id  and a.item_ex >0 and



a.item_id=i.item_id  '.$issue_con.$group_con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$relevant_warehouse_con.$warehouse_id_con.' order by a.ji_date asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->ji_date?></td>



<? if($data->tr_type =="Sales"){?>



<td> <a href="chalan_view.php?v_no= <?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td>



<? } elseif ($data->tr_type =="Consumption") {?>



<td><a href="production_issue_report.php?v_no= <?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td>



<? } elseif($data->tr_type =="Issue") { ?>



<td><a href="../production_issue/production_issue_report.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td>



<? } elseif($data->tr_type == "Production Return") {?>



<td><a href="../production_return/production_receive_report.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td>



<? } elseif($data->tr_type == "Other Issue") { ?>



<td><a href="../other_issue/other_issue_report.php?v_no=<?=$data->sr_no?>" target="_blank"><?=$data->sr_no?></td>



<? } ?>



<td><?=$data->fg_code?></td>



<td><?=$data->item_name?></td>



<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->OUT, 3, '.', '');?></td>



<td><?=number_format($data->amount, 3, '.', '');?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



$tot_OUT = $tot_OUT+$data->OUT;



$tot_rate = $tot_rate+$data->rate;



$tot_amount = $tot_amount+$data->amount;



}?>



<tr>



<td>&emsp;</td>



<td>&nbsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&nbsp;</td>



<td><?=$tot_OUT?></td>



<td><?=number_format($tot_amount,3);?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



?>



<?



if($_POST['report']==300011)



{



$sql='';



$report="Warehouse Item Wise In/Out Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



//echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="10%">Date</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">In</th>



<th width="7%">Out</th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'" ';



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'].' ';};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'].' ';};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'].' ';};



if($_POST['issue_status']!=''){$issue_con = ' and a.tr_from="'.$_POST['issue_status'].'" ';};



$sl=0;



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,sum(a.item_in) as `IN`,sum(a.item_ex) as `OUT`,sum(a.item_price) as rate,sum((a.item_ex*a.item_price)) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.sr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and



a.item_id=i.item_id and  a.warehouse_id="'.$_SESSION['user']['depot'].'"  '.$issue_con.$group_con.$con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by i.item_id order by a.ji_date asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->ji_date?></td>



<td><?=$data->fg_code?></td>



<td><a href="master_report.php?report=300012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$data->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&issue_status=<?=$_POST['issue_status']?>" target="_blank"><?=$data->item_name?></a></td>



<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->IN, 3, '.', '');$tin +=$data->IN;?></td>



<td><?=number_format($data->OUT, 3, '.', '');$tout +=$data->OUT;?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



}?>



<tr class="footer"> 



<td colspan="6" align="right">&nbsp;Total:</strong></td>



<td align="left">&nbsp;<strong><?=$tin;?></strong></td>



<td align="left">&nbsp;<strong><?=$tout;?></strong></td>



<td>&nbsp;</td>



</tr>



</tbody></table>



<?



}



if($_REQUEST['report']==300012)



{



$sql='';



$report="Warehouse Item Wise Out Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='') 



echo '<h2>Date Interval : '.$_REQUEST['f_date'].' To '.$_REQUEST['t_date'].'</h2>';



if($_REQUEST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_REQUEST['group_id']).'</h2>';}



if($_REQUEST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_REQUEST['item_sub_group']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="5%">S/L</th>



<th width="5%">Ji Date</th>



<th width="10%"><div align="center">Fg Code</div></th>



<th width="35%"><div align="center">Item Name</div></th>



<th width="14%"><div align="center">Category</div></th>



<th width="5%">Unit</th>



<th width="7%">In</th>



<th width="7%">Out</th>



<th width="6%">Tr Type</th>



</tr>



<? 



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='')



$date_con .= 'and a.ji_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'"';



if($_REQUEST['item_id']!='')



{ $item_con .=' and i.item_id='.$_REQUEST['item_id']; }



if($_REQUEST['group_id']!=''){$group_con = ' and g.group_id='.$_REQUEST['group_id'];};



if($_REQUEST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_REQUEST['item_sub_group'];};



if($_REQUEST['issue_status']!=''){$issue_con = ' and a.tr_from="'.$_REQUEST['issue_status'].'"';};



$sl=0;



$res='select a.ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,(a.item_in*a.item_price) as amount,a.tr_from as tr_type,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



from journal_item a,



item_info i, user_activity_management c , item_sub_group s, item_group g where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and



a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$issue_con.$group_con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by a.ji_date asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->ji_date?></td>



<td><?=$data->fg_code?></td>



<td><?=$data->item_name?></td>



<td><?=$data->Category?></td>



<td><?=$data->unit?></td>



<td><?=number_format($data->IN, 3, '.', '');?></td>



<td><?=number_format($data->OUT, 3, '.', '');?></td>



<td><?=$data->tr_type?></td>



</tr>



<?



$tot_OUT = $tot_OUT+$data->OUT;



$tot_IN = $tot_IN+$data->IN;



}?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td><?=$tot_IN?></td>



<td><?=$tot_OUT?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



?>



<?



if($_POST['report']==400011)



{



$sql='';



$report="Suplier Wise IN Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="11" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_POST['f_date']!=''&& $_POST['t_date']!='') 



echo '<h2>Date Interval : '.$_POST['f_date'].' To '.$_POST['t_date'].'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="2%">S/L</th>



<th width="11%">Vendor Name</th>



<th width="4%">Unit</th>



<th width="5%">Total Qty</th>



<th width="7%">Rate</th>



<th width="5%">Amount</th>



</tr>



<? 



if($_POST['f_date']!=''&& $_POST['t_date']!='')



$date_con .= 'and r.rec_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!='')



{ $item_con .=' and i.item_id='.$_POST['item_id']; }



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'];};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'];};



if($_POST['vendor_id']!=''){$vendor_con = ' and v.vendor_id='.$_POST['vendor_id'];};



$sl=0;



$res='select 



r.po_no,



r.pr_no as gr_no,



r.rec_date as GR_date,



i.finish_goods_code as code,



g.group_name,



s.sub_group_name,



i.item_name,



i.item_id,



v.vendor_name,



r.ch_no as ch_no,



i.unit_name as unit,



sum(r.qty) as `total_qty`,



sum(r.rate) as rate,



sum(r.amount) as amount,



r.entry_at as entry_date,



c.fname as entry_by,



v.vendor_id



from purchase_receive r, item_info i,item_sub_group s,item_group g,user_activity_management c, vendor v where r.vendor_id=v.vendor_id and c.user_id=r.entry_by 



and r.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.$item_group_con.$group_con.' group by v.vendor_id order by v.vendor_name';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><a href="master_report.php?report=400012&vendor_id=<?=$data->vendor_id?>&item_sub_group=<?=$_POST['item_sub_group']?>&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$_POST['item_id']?>" target="_blank"><?=$data->vendor_name?></a></td>



<td><?=$data->unit?></td>



<td><?=$data->total_qty?></td>



<td><?=$data->amount/$data->total_qty;?></td>



<td><?=$data->amount?></td>



</tr>



<?



$tot_qty=$tot_qty+$data->total_qty;



$tot_rate=$tot_rate+$data->rate;



$tot_amount=$tot_amount+$data->amount;



}?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td style="text-align:left;"><strong><?=$tot_qty;?></strong></td>



<td style="text-align:left;">&emsp;<strong></strong></td>



<td style="text-align:left;"><strong><?=$tot_amount;?></strong></td>



</tr>



</tbody></table>



<?



}



?>



<?



if($_POST['report']==20190620)



{



$sql='';



$report="Salse Return Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="11" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_POST['f_date']!=''&& $_POST['t_date']!='') 



echo '<h2>Date Interval : '.$_POST['f_date'].' To '.$_POST['t_date'].'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="2%">S/L</th>



<th width="11%">Dealer name</th>



<th width="4%">Unit</th>



<th width="5%">Total Qty</th>



<th width="7%">Rate</th>



<th width="5%">Amount</th>



</tr>



<? 



if($_POST['f_date']!=''&& $_POST['t_date']!='')



$date_con .= 'and r.or_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!='')



{ $item_con .=' and i.item_id='.$_POST['item_id']; }



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'];};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'];};



if($_POST['dealer_code']!=''){$dealer_con = ' and d.dealer_code='.$_POST['dealer_code'];};



$sl=0;



$res='select m.or_no,r.or_date, i.finish_goods_code as code, g.group_name, s.sub_group_name, i.item_name, i.item_id, d.dealer_name_e,  i.unit_name as unit, sum(r.qty) as `total_qty`, sum(r.rate) as rate, sum(r.amount) as amount, m.entry_at as entry_date, c.fname as entry_by, d.dealer_code,m.vendor_name



from warehouse_damage_receive_detail r,warehouse_damage_receive m, item_info i,item_sub_group s,item_group g,user_activity_management c, dealer_info d 



where r.vendor_id=d.dealer_code and c.user_id=m.entry_by and r.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and m.or_no=r.or_no '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$dealer_con.$item_group_con.$group_con.' group by d.dealer_code order by d.dealer_name_e';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><a href="master_report.php?report=2019620&dealer_code=<?=$data->dealer_code;?>&item_sub_group=<?=$_POST['item_sub_group']?>&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$_POST['item_id']?>" target="_blank"><?=$data->vendor_name;?></a></td>



<td><?=$data->unit?></td>



<td><?=$data->total_qty?></td>



<td><?=$data->amount/$data->total_qty;?></td>



<td><?=$data->amount?></td>



</tr>



<?



$tot_qty=$tot_qty+$data->total_qty;



$tot_rate=$tot_rate+$data->rate;



$tot_amount=$tot_amount+$data->amount;



}?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td style="text-align:left;"><strong><?=$tot_qty;?></strong></td>



<td style="text-align:left;">&emsp;<strong></strong></td>



<td style="text-align:left;"><strong><?=$tot_amount;?></strong></td>



</tr>



</tbody></table>



<?



}



?>



<?



if($_REQUEST['report']==400012)



{



$sql='';



$report="Suplier Wise IN Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='') 



echo '<h2>Date Interval : '.$_REQUEST['f_date'].' To '.$_REQUEST['t_date'].'</h2>';



if($_REQUEST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_REQUEST['group_id']).'</h2>';}



if($_REQUEST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_REQUEST['item_sub_group']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="2%">S/L</th>



<th width="2%">PO No</th>



<th width="4%"><div align="center">MR No</div></th>



<th width="8%"><div align="center">MR Date</div></th>



<th width="5%"><div align="center">Code</div></th>



<th width="7%">Group Name</th>



<th width="6%">Sub Group Name</th>



<th width="20%">Item Name</th>



<th width="11%">Vendor Name</th>



<th width="2%">Ch No</th>



<th width="4%">Unit</th>



<th width="5%">Total Qty</th>



<th width="7%">Rate</th>



<th width="5%">Amount</th>



<th width="7%">Entry Date</th>



<th width="5%">Entry By</th>



</tr>



<? 



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='')



$date_con .= 'and r.rec_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'"';



if($_REQUEST['item_id']!='')



{ $item_con .=' and i.item_id='.$_REQUEST['item_id']; }



if($_REQUEST['group_id']!=''){$group_con = ' and g.group_id='.$_REQUEST['group_id'];};



if($_REQUEST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_REQUEST['item_sub_group'];};



if($_REQUEST['vendor_id']!=''){$vendor_con = ' and v.vendor_id='.$_REQUEST['vendor_id'];};



$sl=0;



$res='select 



r.po_no,



r.pr_no as gr_no,



r.rec_date as GR_date,



i.finish_goods_code as code,



g.group_name,



s.sub_group_name,



i.item_name,



v.vendor_name,



r.ch_no as ch_no,



i.unit_name as unit,



r.qty as `total_qty`,



r.rate as rate,



r.amount as amount,



r.entry_at as entry_date,



c.fname as entry_by



from purchase_receive r, item_info i,item_sub_group s,item_group g,user_activity_management c, vendor v where r.vendor_id=v.vendor_id and c.user_id=r.entry_by 



and r.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.$item_group_con.$group_con.' order by r.pr_no';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->po_no?></td>



<td><?=$data->gr_no?></td>



<td><?=$data->GR_date?></td>



<td><?=$data->code?></td>



<td><?=$data->group_name?></td>



<td><?=$data->sub_group_name?></td>



<td><?=$data->item_name?></td>



<td><?=$data->vendor_name?></td>



<td width="3%"><?=$data->ch_no?></td>



<td><?=$data->unit?></td>



<td><?=$data->total_qty?></td>



<td><?=$data->rate?></td>



<td><?=$data->amount?></td>



<td><?=$data->entry_date?></td>



<td><?=$data->entry_by?></td>



</tr>



<?



$tot_qty=$tot_qty+$data->total_qty;



$tot_rate=$tot_rate+$data->rate;



$tot_amount=$tot_amount+$data->amount;



}?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;<strong><?=$tot_qty?></strong></td>



<td>&emsp;<strong></strong></td>



<td>&emsp;<strong><?=$tot_amount?></strong></td>



<td>&emsp;</td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



?>



<?



if($_POST['report']==201906200)



{



$sql='';



$report="Supplier wise Reject Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="11" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_POST['f_date']!=''&& $_POST['t_date']!='') 



echo '<h2>Date Interval : '.$_POST['f_date'].' To '.$_POST['t_date'].'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="2%">S/L</th>



<th width="11%">Vendor name</th>



<th width="4%">Unit</th>



<th width="5%">Total Qty</th>



<th width="7%">Rate</th>



<th width="5%">Amount</th>



</tr>



<? 



if($_POST['f_date']!=''&& $_POST['t_date']!='')



$date_con .= 'and r.oi_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!='')



{ $item_con .=' and i.item_id='.$_POST['item_id']; }



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'];};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'];};



if($_POST['vendor_id']!=''){$dealer_con = ' and d.vendor_id='.$_POST['vendor_id'];};



$sl=0;



$res='select m.oi_no,r.oi_date, i.finish_goods_code as code, g.group_name, s.sub_group_name, i.item_name, i.item_id, d.vendor_name,  i.unit_name as unit, sum(r.qty) as `total_qty`, sum(r.rate) as rate, sum(r.amount) as amount, m.entry_at as entry_date, c.fname as entry_by, d.vendor_id,m.vendor_id



from purchase_item_return_details r,purchase_item_return_master m, item_info i,item_sub_group s,item_group g,user_activity_management c, vendor d 



where r.vendor_id=d.vendor_id and c.user_id=m.entry_by and r.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and m.oi_no=r.oi_no '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$dealer_con.$item_group_con.$group_con.' group by d.vendor_id order by d.vendor_name';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><a href="warehouse_master_report.php?report=2019062000&vendor_id=<?=$data->vendor_id;?>&item_sub_group=<?=$_POST['item_sub_group']?>&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$_POST['item_id']?>" target="_blank"><?=$data->vendor_name;?></a></td>



<td><?=$data->unit?></td>



<td><?=$data->total_qty?></td>



<td><?=$data->amount/$data->total_qty;?></td>



<td><?=$data->amount?></td>



</tr>



<?



$tot_qty=$tot_qty+$data->total_qty;



$tot_rate=$tot_rate+$data->rate;



$tot_amount=$tot_amount+$data->amount;



}?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td style="text-align:left;"><strong><?=$tot_qty;?></strong></td>



<td style="text-align:left;">&emsp;<strong></strong></td>



<td style="text-align:left;"><strong><?=$tot_amount;?></strong></td>



</tr>



</tbody></table>



<?



}



if($_REQUEST['report']==2019062000)



{



$sql='';



$report="Suplier Wise Reject Report in Details";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="21" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='') 



echo '<h2>Date Interval : '.$_REQUEST['f_date'].' To '.$_REQUEST['t_date'].'</h2>';



if($_REQUEST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_REQUEST['group_id']).'</h2>';}



if($_REQUEST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_REQUEST['item_sub_group']).'</h2>';}



if($_REQUEST['vendor_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Vendor Name : '.find_a_field('vendor','vendor_name','vendor_id='.$_REQUEST['vendor_id']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="2%">S/L</th>



<th width="2%">Purchase Return No</th>



<th width="8%"><div align="center">Return Date</div></th>



<th width="5%"><div align="center">Code</div></th>



<th width="7%">Group Name</th>



<th width="6%">Sub Group Name</th>



<th width="20%">Item Name</th>



<th width="11%">Vendor Name</th>



<th width="4%">Unit</th>



<th width="5%">Total Qty</th>



<th width="7%">Rate</th>



<th width="5%">Amount</th>



</tr>



<? 



if($_REQUEST['f_date']!=''&& $_REQUEST['t_date']!='')



$date_con .= 'and r.oi_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'"';



if($_REQUEST['item_id']!='')



{ $item_con .=' and i.item_id='.$_REQUEST['item_id']; }



if($_REQUEST['group_id']!=''){$group_con = ' and g.group_id='.$_REQUEST['group_id'];};



if($_REQUEST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_REQUEST['item_sub_group'];};



if($_REQUEST['vendor_id']!=''){$vendor_con = ' and v.vendor_id='.$_REQUEST['vendor_id'];};



$sl=0;



$res='select 



r.oi_no as return_no,



r.oi_date as GR_date,



i.finish_goods_code as code,



g.group_name,



s.sub_group_name,



i.item_name,



v.vendor_name,



i.unit_name as unit,



r.qty as `total_qty`,



r.rate as rate,



r.amount as amount



from purchase_item_return_details r, item_info i,item_sub_group s,item_group g, vendor v where r.vendor_id=v.vendor_id and r.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$vendor_con.$item_group_con.$group_con.' order by r.oi_no';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td><?=++$sl;?></td>



<td><?=$data->return_no?></td>



<td><?=$data->GR_date?></td>



<td><?=$data->code?></td>



<td><?=$data->group_name?></td>



<td><?=$data->sub_group_name?></td>



<td><?=$data->item_name?></td>



<td><?=$data->vendor_name?></td>



<td><?=$data->unit?></td>



<td><?=$data->total_qty?></td>



<td><?=$data->rate?></td>



<td><?=$data->amount?></td>



</tr>



<?



$tot_qty=$tot_qty+$data->total_qty;



$tot_rate=$tot_rate+$data->rate;



$tot_amount=$tot_amount+$data->amount;



}?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;<strong><?=number_format($tot_qty,4)?></strong></td>



<td>&emsp;<strong></strong></td>



<td>&emsp;<strong><?=number_format($tot_amount,4)?></strong></td>



</tr>



</tbody></table>



<?



}



?>



<?



if($_POST['report']==400000)



{



$sql='';



$report="All Product List";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="18" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 	echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<tr>



<th width="6%">S/L</th>



<th width="11%"><div align="center">Item Code</div></th>



<th width="8%"><div align="center">FG Code</div></th>



<th width="34%"><div align="center">Item Name</div></th>



<th width="27%">Description </th>



<th width="5%"><div align="center">Unit</div></th>





<!--<th width="5%"><div align="center">Entry By</div></th>



<th width="5%"><div align="center">Entry At</div></th>-->





<th width="8%"  style="text-align:center;">Sub Group</th>



<th width="9%"  style="text-align:center;">Group</th>



</tr>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'];};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'];};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'];};



$sl=0;



 $res='select i.item_id,i.item_name, i.finish_goods_code as fg_code,i.unit_name,i.pack_unit,s.sub_group_name,g.group_name,i.item_description,i.status,i.entry_at,i.entry_by,u.username



from item_info i, item_sub_group s, item_group g ,user_activity_management u



where u.user_id= i.entry_by and  s.sub_group_id=i.sub_group_id and s.group_id=g.group_id '.$group_con.$con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.'  order by i.item_name asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td style="text-align:center;"><?=++$sl;?></td>



<td style="text-align:center;"><?=$data->item_id?></td>



<td style="text-align:center;"><?=$data->fg_code?></td>



<td><?=$data->item_name?></td>



<td><?=$data->item_description?></td>



<td style="text-align:center;"><?=$data->unit_name?></td>





<?php /*?><td style="text-align:center;"><?=$data->username?></td>



<td style="text-align:center;"><?=gmdate("Y-m-d\TH:i:s\Z", $data->entry_at);?></td><?php */?>







<td style="text-align:center;"><?=$data->sub_group_name?></td>



<td style="text-align:center;"><?=$data->group_name?></td>



</tr>



<?



}?>



</tbody></table>



<?



}



?>



<?



if($_POST['report']==440000)



{



$sql='';



$report="All Finish Good Product List";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="18" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 	echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tbody>



<? 



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.ji_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!=''){$item_con = ' and i.item_id='.$_POST['item_id'];};



if($_POST['group_id']!=''){$group_con = ' and g.group_id='.$_POST['group_id'];};



if($_POST['item_sub_group']!=''){$item_sub_con = ' and s.sub_group_id='.$_POST['item_sub_group'];};



if($_POST['brand_category']!=''){$b_con = ' and i.brand_category="'.$_POST['brand_category'].'"';};



$r='select i.brand_category, i.item_id,i.item_name,i.unit_name,i.pack_unit,s.sub_group_name,g.group_name,i.item_description,i.status



from item_info i, item_sub_group s, item_group g 



where s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and g.group_id=500000000 '.$b_con.$group_con.$con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by i.brand_category  order by i.item_name asc';



$q = db_query($r);



while($d=mysqli_fetch_object($q)){



?>



<tr>



<th width="6%">S/L</th>



<th width="11%"><div align="center">Item Code</div></th>



<th width="6%"><div align="center">FG Code</div></th>



<th width="28%"><div align="center">Item Name</div></th>



<th width="18%">Description </th>



<th width="9%"><div align="center">Unit</div></th>



<th width="11%"  style="text-align:center;">Sub Group</th>



<th width="11%"  style="text-align:center;">Group</th>



</tr>



<tr style="background:#B8B8B8; height: 25px;">



<th colspan="8" style="font-size: 15px; text-align:center;"><< <?=$d->brand_category?> >></th>



</tr>



<tr>



<? 



$sl=0;



$res='select i.item_id,i.finish_goods_code as fg_code,i.item_name,i.unit_name,i.pack_unit,s.sub_group_name,g.group_name,i.item_description,i.status



from item_info i, item_sub_group s, item_group g 



where s.sub_group_id=i.sub_group_id and s.group_id=g.group_id and g.group_id=500000000 and i.brand_category="'.$d->brand_category.'" '.$group_con.$con.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' order by i.item_name asc';



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td style="text-align:center;"><?=++$sl;?></td>



<td style="text-align:center;"><?=$data->item_id?></td>



<td style="text-align:center;"><?=$data->fg_code?></td>



<td><?=$data->item_name?></td>



<td><?=$data->item_description?></td>



<td style="text-align:center;"><?=$data->unit_name?></td>



<td style="text-align:center;"><?=$data->sub_group_name?></td>



<td style="text-align:center;"><?=$data->group_name?></td>



</tr>



<? }} ?>



</tbody></table>



<? } ?>



<?



if($_POST['report']==300001)



{



$sql='';



$report="Floor Requisition Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="16" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



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



<th width="5%">SL/NO</th>



<th width="5%">PR No</th>



<th width="5%">PR Date</th>



<th width="10%"><div align="center">Item Name</div></th>



<th width="10%"><div align="center">Warehouse</div></th>



<th width="10%"><div align="center">Group Name</div></th>



<th width="10%"><div align="center">Req qty</div></th>



<th width="5%"><div align="center">User</div></th>



</tr>



<?



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.pi_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



$r='select a.pi_no,a.pi_no,a.pi_date,b.req_qty,i.item_name,g.group_name, b.total_unit,a.remarks as sr_no,c.warehouse_name as section,u.fname as user from item_info i ,item_sub_group s, item_group g,production_issue_master a, production_issue_detail b, warehouse c, user_activity_management u  where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and b.item_id=i.item_id and a.pi_no=b.pi_no and a.warehouse_to=c.warehouse_id and a.entry_by=u.user_id and a.warehouse_from = "'.$_SESSION['user']['depot'].'"'.$con.' group by g.group_name  order by a.pi_no asc';



$q = db_query($r);



while($r = mysqli_fetch_object($q)){



?>



<tr>



<th colspan="9" style="background:#E8E8E8; height:20px; font-size:15px;"><div align="center"><< <?=$r->group_name; ?> >> </div></th>



</tr>



<?



$res='select a.pi_no,a.pi_no,a.pi_date,b.req_qty,i.item_name,g.group_name, b.total_unit,a.remarks as sr_no,c.warehouse_name as section,u.fname as user from item_info i ,item_sub_group s, item_group g,production_issue_master a, production_issue_detail b, warehouse c, user_activity_management u  where g.group_name="'.$r->group_name.'" and  i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and b.item_id=i.item_id and a.pi_no=b.pi_no and a.warehouse_to=c.warehouse_id and a.entry_by=u.user_id and a.warehouse_from = "'.$_SESSION['user']['depot'].'"'.$con.'  order by a.pi_no desc';



$sl=0;



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td valign="top"><?=++$sl?></td>



<td valign="top"><?=$data->pi_no;?></td>



<td valign="top"><?=$data->pi_date;?></td>



<td valign="top"><?=$data->item_name;?></td>



<td valign="top">



<div align="center">



<?=$data->section;?>



</div>		</td>



<td valign="top">



<div align="center">



<?=$data->group_name;?>



</div>		</td>



<td valign="top">



<div align="center">



<?=$data->req_qty;?>



</div>		</td>



<td valign="top">



<div align="center">



<?=$data->user;?>



</div>		</td>



</tr>



<? 



$toot = $toot+$data->req_qty;



$r->group_name=$r->group_name+$data->req_qty;



?>



<? } ?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>Sub Total : </td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$r->group_name?></td>



<td>&emsp;</td>



</tr>



<? } ?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>Grand Total :</td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$grand_tot = $grand_tot+$toot?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



if($_POST['report']==400001)



{



$sql='';



$report="Floor Stock Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="16" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



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



<th width="5%">SL/NO</th>



<th width="10%"><div align="center">Item Name</div></th>



<th width="10%"><div align="center">Unit</div></th>



<th width="10%"><div align="center">Item Group</div></th>



<th width="10%"><div align="center">Item Sub Group</div></th>



<th width="5%"><div align="center">Item In</div></th>



<th width="5%"><div align="center">Item Out</div></th>



<th width="5%"><div align="center">Stock</div></th>



<th width="5%"><div align="center">Tr From</div></th>



</tr>



<?



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and j.entry_at between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



if($_POST['item_id']!='')



$con .= ' and i.item_id="'.$_POST['item_id'].'" ';



if($_POST['group_id']!='')



$con .= ' and g.group_id="'.$_POST['group_id'].'" ';



if($_POST['item_sub_group']!='')



$con .= ' and g.sub_group_id="'.$_POST['item_sub_group'].'" ';



$res='select i.item_name,i.item_id,i.unit_name,g.group_name,s.sub_group_name,sum(j.item_in) as `in`, j.tr_from from production_issue_master m, production_issue_detail d, journal_item j, item_info i, item_sub_group s, item_group g where m.pi_no=d.pi_no and d.id=j.tr_no and j.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and j.tr_from="Issue" and j.warehouse_id="'.$_POST['production_line'].'" '. $con .'  group by i.item_id';



$sl=0;



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td valign="top"><?=++$sl?></td>



<td valign="top"><?=$data->item_name;?></td>



<td valign="top"><?=$data->unit_name;?></td>



<td valign="top"><div align="center"><?=$data->group_name;?></div></td>



<td valign="top"><div align="center"><?=$data->sub_group_name;?></div></td>



<td valign="top"><div align="center"><?=$in=$data->in;?></div></td>



<td valign="top"><div align="center"><?=$out = find_a_field('journal_item j','sum(j.item_ex)','j.tr_from="Consumption" and j.warehouse_id="24" and j.item_id="'.$data->item_id.'"'.$con.' group by j.item_id ');?></div></td>



<td valign="top"><div align="center"><?=$stock=($in-$out);?></div></td>



<td valign="top"><div align="center"><?=$data->tr_from;?></div></td>



</tr>



<? 



$toot_in = $toot_in+$in;



$toot_out = $toot_out+$out;



$toot_stock = $toot_stock+$stock;



} 



?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>Grand Total :</td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$toot_in?></td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$toot_out?></td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$toot_stock?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



if($_POST['report']==400002)



{



$sql='';



$report="Floor Stock Report details";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="16" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



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



<th width="5%">SL/NO</th>



<th width="10%"><div align="center">Item Name</div></th>



<th width="10%"><div align="center">Unit</div></th>



<th width="10%"><div align="center">Item Group</div></th>



<th width="10%"><div align="center">Item Sub Group</div></th>



<th width="5%"><div align="center">Item In</div></th>



<th width="5%"><div align="center">Item Out</div></th>



<th width="5%"><div align="center">Stock</div></th>



<th width="5%"><div align="center">Tr From</div></th>



</tr>



<?



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and j.entry_at between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



$res='select i.item_name,i.item_id,i.unit_name,g.group_name,s.sub_group_name,sum(j.item_in) as `in`, j.tr_from from production_issue_master m, production_issue_detail d, journal_item j, item_info i, item_sub_group s, item_group g where m.pi_no=d.pi_no and d.id=j.tr_no and j.item_id=i.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and j.tr_from="Issue" and j.warehouse_id="24" '. $con .'  group by i.item_id';



$sl=0;



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td valign="top"><?=++$sl?></td>



<td valign="top"><?=$data->item_name;?></td>



<td valign="top"><?=$data->unit_name;?></td>



<td valign="top"><div align="center"><?=$data->group_name;?></div></td>



<td valign="top"><div align="center"><?=$data->sub_group_name;?></div></td>



<td valign="top"><div align="center"><?=$in=$data->in;?></div></td>



<td valign="top"><div align="center"><?=$out = find_a_field('journal_item j','sum(j.item_ex)','j.tr_from="Consumption" and j.warehouse_id="24" and j.item_id="'.$data->item_id.'"'.$con.' group by j.item_id ');?></div></td>



<td valign="top"><div align="center"><?=$stock=($in-$out);?></div></td>



<td valign="top"><div align="center"><?=$data->tr_from;?></div></td>



</tr>



<? 



$toot_in = $toot_in+$in;



$toot_out = $toot_out+$out;



$toot_stock = $toot_stock+$stock;



} 



?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>Grand Total :</td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$toot_in?></td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$toot_out?></td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$toot_stock?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



if($_POST['report']==300002)



{



$sql='';



$report="Floor Requisition Report";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="16" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



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



<th width="5%">SL/NO</th>



<th width="5%">PR No</th>



<th width="5%">PR Date</th>



<th width="10%"><div align="center">Item Name</div></th>



<th width="10%"><div align="center">Warehouse</div></th>



<th width="10%"><div align="center">Group Name</div></th>



<th width="10%"><div align="center">Req qty</div></th>



<th width="5%"><div align="center">User</div></th>



</tr>



<?



if($_POST['f_date']!=''&&$_POST['t_date']!='')



$con .= 'and a.pi_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';



$r='select a.pi_no,a.pi_no,a.pi_date,b.req_qty,i.item_name,g.group_name, b.total_unit,a.remarks as sr_no,c.warehouse_name as section,u.fname as user from item_info i ,item_sub_group s, item_group g,production_issue_master a, production_issue_detail b, warehouse c, user_activity_management u  where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and b.item_id=i.item_id and a.pi_no=b.pi_no and a.warehouse_to=c.warehouse_id and a.entry_by=u.user_id and a.warehouse_from = "'.$_SESSION['user']['depot'].'"'.$con.' group by g.group_name  order by a.pi_no asc';



$q = db_query($r);



while($r = mysqli_fetch_object($q)){



?>



<tr>



<th colspan="9" style="background:#E8E8E8; height:20px; font-size:15px;"><div align="center"><< <?=$r->group_name; ?> >> </div></th>



</tr>



<?



$res='select a.pi_no,a.pi_no,a.pi_date,b.req_qty,i.item_name,g.group_name, b.total_unit,a.remarks as sr_no,c.warehouse_name as section,u.fname as user from item_info i ,item_sub_group s, item_group g,production_issue_master a, production_issue_detail b, warehouse c, user_activity_management u  where g.group_name="'.$r->group_name.'" and  i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and b.item_id=i.item_id and a.pi_no=b.pi_no and a.warehouse_to=c.warehouse_id and a.entry_by=u.user_id and a.warehouse_from = "'.$_SESSION['user']['depot'].'"'.$con.'  order by a.pi_no desc';



$sl=0;



$query = db_query($res);



while($data=mysqli_fetch_object($query)){



?>



<tr>



<td valign="top"><?=++$sl?></td>



<td valign="top"><?=$data->pi_no;?></td>



<td valign="top"><?=$data->pi_date;?></td>



<td valign="top"><?=$data->item_name;?></td>



<td valign="top">



<div align="center">



<?=$data->section;?>



</div>		</td>



<td valign="top">



<div align="center">



<?=$data->group_name;?>



</div>		</td>



<td valign="top">



<div align="center">



<?=$data->req_qty;?>



</div>		</td>



<td valign="top">



<div align="center">



<?=$data->user;?>



</div>		</td>



</tr>



<? 



$toot = $toot+$data->req_qty;



$r->group_name=$r->group_name+$data->req_qty;



?>



<? } ?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>Sub Total : </td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$r->group_name?></td>



<td>&emsp;</td>



</tr>



<? } ?>



<tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&emsp;</td>



<td>Grand Total :</td>



<td style="text-align:right; font-weight:bold;">&emsp; <?=$grand_tot = $grand_tot+$toot?></td>



<td>&emsp;</td>



</tr>



</tbody></table>



<?



}



elseif($_POST['report']==2) 



{	if($_SESSION['user']['depot']>0) 			{$warehouse_con=' and a.warehouse_id='.$_SESSION['user']['depot']; $warehouse_connn=' and warehouse_id='.$_SESSION['user']['depot'];}



if($_SESSION['user']['depot']==11){



$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.d_price,g.group_name



from item_info i, item_sub_group s, item_group g where



(select sum(item_in-item_ex) from journal_item where item_id=i.item_id '.$warehouse_connn.')>0 and  



i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id in (600000000) '.$group_con.$item_sub_con.$item_con.' order by s.sub_group_name';}



else{



$sql='select distinct 



i.item_id,



i.unit_name,



i.item_name,



s.sub_group_name,



i.finish_goods_code,



j.item_in,g.group_name,



avg(j.item_price) as d_price



from item_info i,



item_sub_group s,



item_group g,



journal_item j where 



(select sum(item_in-item_ex) from journal_item where item_id=i.item_id '.$warehouse_connn.')>0 and i.item_id=j.item_id and



i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id not in (600000000,700000000) '.$date_con.$group_con.$item_sub_con.$item_con.' group by j.item_id order by s.sub_group_name';



}



$query =db_query($sql);



if($_SESSION['user']['level']==5){  



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);



}else{



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



}



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="8"><div class="header">



<h1><?=$_SESSION['company_name']?></h1><h2><?=$report?></h2>



<h2>Closing Stock of Date-<?=$to_date=date("d-m-Y")?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>



<th>S/L2</th>



<th>Group Name</th>



<th>Opening</th>



<th> IN </th>



<th>OUT</th>



<th>Closing</th>



<th>Unit</th>



<th>Rate (DP)</th>



<th>Stock Value</th>



</tr>



</thead><tbody>



<?



while($data=mysqli_fetch_object($query)){



$s='select pre_stock,sum(a.item_in) item_in,sum(a.item_ex) item_ex ,sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price  



from journal_item a where a.item_id="'.$data->item_id.'" '.$date_cons.$status_con.$warehouse_con.' order by a.id desc limit 1';



$q = db_query($s);



$i=mysqli_fetch_object($q);$j++;



$amt = ($i->item_in -$i->item_ex) *$data->d_price;



$total_amt = $total_amt + $amt;



$tot_pre_stock = $tot_pre_stock+$i->pre_stock;



$tot_item_in=$tot_item_in+$i->item_in;



?>



<tr>



<td><?=$j?></td>



<td><a href="master_report.php?report=22&group_name=<?=$data->group_name?>" target="_blank"><?=$data->group_name?></a></td>



<td style="text-align:right"><?=$tot_pre_stock?></td>



<td style="text-align:right"><?=$tot_item_in?></td>



<td style="text-align:right"><?=$i->item_ex?></td>



<td style="text-align:right"><?=(($i->pre_stock)+($i->item_in-$i->item_ex))?></td>



<td><?=$data->unit_name?></td>



<td style="text-align:right"><?=@number_format($data->d_price,2)?></td>



<td style="text-align:right"><?=number_format($amt,2)?></td>



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



<td></td>



<td></td>



<td>Total: </td>



<td style="text-align:right"><?=number_format(($total_amt),2)?></td>



</tr>



</tbody></table>



<?



}



if($_POST['report']==22) 



{



if($_SESSION['user']['depot']>0) 			{$warehouse_con=' and a.warehouse_id='.$_SESSION['user']['depot']; $warehouse_connn=' and warehouse_id='.$_SESSION['user']['depot'];}



if($_REQUEST['group_name']!=''){$group_con = ' and g.group_name="'.$_REQUEST['group_name'].'"';}



if($_SESSION['user']['depot']==11){



$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.d_price,g.group_name



from item_info i, item_sub_group s, item_group g where



(select sum(item_in-item_ex) from journal_item where item_id=i.item_id '.$warehouse_connn.')>0 and  



i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id in (600000000) '.$group_con.$item_sub_con.$item_con.' order by s.sub_group_name';}



else{



$sql='select distinct 



i.item_id,



i.unit_name,



i.item_name,



s.sub_group_name,



i.finish_goods_code,



j.item_in,g.group_name,



avg(j.item_price) as d_price



from item_info i,



item_sub_group s,



item_group g,



journal_item j where 



(select sum(item_in-item_ex) from journal_item where item_id=i.item_id '.$warehouse_connn.')>0 and i.item_id=j.item_id and



i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id not in (600000000,700000000) '.$date_con.$group_con.$item_sub_con.$item_con.' group by j.item_id order by i.item_name asc';



}



$query =db_query($sql);



if($_SESSION['user']['level']==5){  



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);



}else{



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



}



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="12"><div class="header">



<? 



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2 style="font-weight: bold;">Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



if($_POST['brand_category']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Section :'.$_POST['brand_category'].'</h2>';}



echo '</div>';



?>



<!--<h2>Closing Stock of Date-<?=$to_date=date("d-m-Y")?></h2>--></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>



</td></tr><tr>



<th>S/L2 lll</th>



<th>Group Name</th>



<th>Item Code</th>



<th>Item Group</th>



<th>FG</th>



<th>Item Name</th>



<th>Opening</th>



<th> IN </th>



<th>OUT</th>



<th>Closing</th>



<th>Unit</th>



<th>Rate (DP)</th>



<th>Stock Value</th>



</tr>



</thead><tbody>



<?



while($data=mysqli_fetch_object($query)){



$s='select pre_stock, sum(a.item_in) item_in,sum(a.item_ex) item_ex ,sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price  



from journal_item a where a.item_id="'.$data->item_id.'" '.$date_cons.$status_con.$warehouse_con.' order by a.id desc limit 1';



$q = db_query($s);



$i=mysqli_fetch_object($q);$j++;



$close=(($i->pre_stock)+($i->item_in-$i->item_ex));



$amt = $close *$data->d_price;



//$total_amt = $total_amt + $amt;



?>



<tr>



<td><?=$j?></td>



<td><?=$data->group_name?></td>



<td><?=$data->item_id?></td>



<td><?=$data->sub_group_name?></td>



<td><?=$data->finish_goods_code?></td>



<td><?=$data->item_name?></td>



<td style="text-align:right"><?=$i->pre_stock?></td>



<td style="text-align:right"><?=$i->item_in?></td>



<td style="text-align:right"><?=$i->item_ex?></td>



<td style="text-align:right"><?=$close?></td>



<td><?=$data->unit_name?></td>



<td style="text-align:right"><?=number_format($data->d_price ,2);?></td>



<td style="text-align:right"><?=number_format($amt,2)?></td>



</tr>



<?



$tot_pre_stock = $tot_pre_stock+$i->pre_stock;



$tot_item_in = $tot_item_in+$i->item_in;



$tot_item_ex = $tot_item_ex+$i->item_ex;



$tot_close = $tot_close+$close;



$tot_amt = $tot_amt+$amt;



}



?>



<tr>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td>Total: </td>



<td><div align="right"><strong>



<?=number_format(($tot_pre_stock),2)?>



</strong></div></td>



<td><div align="right">



<strong>



<?=number_format(($tot_item_in),2)?>



</strong></div></td>



<td><div align="right">



<strong>



<?=number_format(($tot_item_ex),2)?>



</strong></div></td>



<td><div align="right">



<strong>



<?=number_format(($tot_close),2)?>



</strong></div></td>



<td></td>



<td><div align="right"><strong>



</strong></div></td>



<td style="text-align:right"><div align="right">



<strong>



<?=number_format(($tot_amt),2)?>



</strong></div></td>



</tr>



</tbody></table>



<?



}



elseif($_POST['report']==200002) 



{



if($_SESSION['user']['depot']>0) 			{$warehouse_con=' and a.warehouse_id='.$_SESSION['user']['depot']; $warehouse_connn=' and warehouse_id='.$_SESSION['user']['depot'];}



if($_REQUEST['group_name']!=''){$group_con = ' and g.group_name="'.$_REQUEST['group_name'].'"';}



if($_REQUEST['brand_category']!=''){$brand_con = ' and i.brand_category="'.$_REQUEST['brand_category'].'"';}



if($_SESSION['user']['depot']==11){



$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.d_price,g.group_name



from item_info i, item_sub_group s, item_group g where



(select sum(item_in-item_ex) from journal_item where item_id=i.item_id '.$warehouse_connn.')>0 and  



i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id in (600000000) '.$group_con.$item_sub_con.$item_con.' order by s.sub_group_name';}



else{



echo $sql='select distinct 



i.item_id,



i.unit_name,



i.item_name,



s.sub_group_name,



i.finish_goods_code,



j.item_in,g.group_name,



avg(j.item_price) as d_price



from item_info i,



item_sub_group s,



item_group g,



journal_item j where 



(select sum(item_in-item_ex) from journal_item where item_id=i.item_id '.$warehouse_connn.')>0 and i.item_id=j.item_id and



i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id not in (600000000,700000000) '.$date_con.$group_con.$item_sub_con.$item_con.$brand_con.' group by j.item_id order by i.item_name asc';



}



$query =db_query($sql);



if($_SESSION['user']['level']==5){  



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);



}else{



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



}



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="12"><div class="header">



<? 



echo '<div class="header">';



echo '<h1 style="text-shadow: 1px 1px 1px gray; height: 15px; font-weight: bold">'.$_SESSION['company_name'].'</h1>';



//echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2 style="font-weight: bold;">Date Interval : '.$f_date.' To '.$t_date.'</h2>';



if($_POST['group_id']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Group : '.find_a_field('item_group','group_name','group_id='.$_POST['group_id']).'</h2>';}



if($_POST['item_sub_group']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Sub Group : '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['item_sub_group']).'</h2>';}



if($_POST['brand_category']!=''){ echo '<h2 style="font-weight: bold; height: 10px;text-decoration: underline;"> Section :'.$_POST['brand_category'].'</h2>';}



echo '</div>';



?>



</div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>



<th>S/L2</th>



<th>Group Name</th>



<th>Item Code</th>



<th>Sub Group</th>



<th>FG</th>



<th>Item Name</th>



<th>Unit</th>



<th>Closing</th>



<th>Rate (DP)</th>



<th>Stock Value</th>



</tr>



</thead><tbody>



<?



while($data=mysqli_fetch_object($query)){



$s='select pre_stock,sum(a.item_in) item_in,sum(a.item_ex) item_ex ,sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price  



from journal_item a where a.item_id="'.$data->item_id.'" '.$date_cons.$status_con.$warehouse_con.' order by a.id desc limit 1';



$q = db_query($s);



$i=mysqli_fetch_object($q);$j++;



$amt = ($i->item_in -$i->item_ex) *$data->d_price;



$total_amt = $total_amt + $amt;



?>



<tr>



<td><?=$j?></td>



<td><?=$data->group_name?></td>



<td><?=$data->item_id?></td>



<td><? if($data->group_name!='Finished Goods'){echo $data->sub_group_name;} else{ echo $_POST['brand_category'];} ?></td>



<td><?=$data->finish_goods_code?></td>



<td><?=$data->item_name?></td>



<td><?=$data->unit_name?></td>



<td style="text-align:right"><?=$close=(($i->pre_stock)+($i->item_in-$i->item_ex))?></td>



<td style="text-align:right"><?=@number_format($data->d_price,2)?></td>



<td style="text-align:right"><?=number_format($amt,2)?></td>



</tr>



<?



$tot_close = $tot_close+$close;



$tot_d_price = $tot_d_price+$data->d_price;



$tot_amt = $tot_amt+$amt;



}



?>



<tr>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td><div align="right"><strong>Total: </strong></div></td>



<td><div align="right">



<strong>



<?=number_format(($tot_close),2)?>



</strong></div></td>



<td><div align="right">



<strong>



<?=number_format(($tot_d_price),2)?>



</strong></div></td>



<td style="text-align:right"><div align="right">



<strong>



<?=number_format(($tot_amt),2)?>



</strong></div></td>



</tr>



</tbody></table>



<?



}



elseif($_POST['report']==200001) 



{	if($_SESSION['user']['depot']>0) 			{$warehouse_con=' and a.warehouse_id='.$_SESSION['user']['depot']; $warehouse_connn=' and warehouse_id='.$_SESSION['user']['depot'];}



$sql='select distinct 



i.item_id,



i.unit_name,



i.item_name,



s.sub_group_name,



i.finish_goods_code,



j.item_in,



avg(j.item_price) as d_price



,r.reorder_qty 



from item_info i,



item_sub_group s,



item_group g,



journal_item j,



item_reorder_position r



where 



i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id not in (600000000,700000000) '.$item_sub_con.$item_con.' 



and i.item_id=r.item_id and r.warehouse_id=j.warehouse_id and j.item_id=i.item_id group by j.item_id order by s.sub_group_name';



$query =db_query($sql);



if($_SESSION['user']['level']==5){  



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);



}else{



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



}



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead><tr><td style="border:0px;" colspan="15"><div class="header">



<h1><?=$_SESSION['company_name']?></h1><h2><?=$report?></h2>



<h2>Closing Stock of Date-<?=$to_date=date("d-m-Y")?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>



<th>S/L2</th>



<th>Warehouse Name</th>



<th>Item Code</th>



<th>Item Group</th>



<th>FG</th>



<th>Item Name</th>



<th>Opening</th>



<th> IN </th>



<th>OUT</th>



<th>Closing</th>



<th>Reorder Level</th>



<th>Level Position </th>



<th>Unit</th>



<th>Available Stock</th>



<th>Rate (DP)</th>



<th>Stock Value</th>



</tr>



</thead><tbody>



<?



while($data=mysqli_fetch_object($query)){



$s='select pre_stock,sum(a.item_in) item_in,sum(a.item_ex) item_ex ,sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price  



from journal_item a where a.item_id="'.$data->item_id.'" '.$date_con.$status_con.$warehouse_con.' order by a.id desc limit 1';



$q = db_query($s);



$i=mysqli_fetch_object($q);$j++;



$amt = ($i->item_in - $i->item_ex) * ($data->d_price);



$total_amt = $total_amt + $amt;



if($data->reorder_qty){



?>



<tr>



<td><?=$j?></td>



<td><?=$warehouse_name?></td>



<td><?=$data->item_id?></td>



<td><?=$data->sub_group_name?></td>



<td><?=$data->finish_goods_code?></td>



<td><?=$data->item_name?></td>



<td style="text-align:right"><?=$i->pre_stock?></td>



<td style="text-align:right"><?=$i->item_in?></td>



<td style="text-align:right"><?=$i->item_ex?></td>



<td style="text-align:right"><?=(($i->pre_stock)+($i->item_in-$i->item_ex))?></td>



<td><span style="text-align:right">



<?=$data->reorder_qty; ?>



</span></td>



<td>



<? 



if($data->reorder_qty > ($i->item_in - $i->item_ex)){



echo "<button style='background: red; font-weight: bold; color: white; padding: 5px; font-size: 12px; border: none; width: 100px;'>DANGER</button>";



}else if($data->reorder_qty < ($i->item_in - $i->item_ex)){



echo "<button style='background: green; font-weight: bold; color: white; padding: 5px; font-size: 12px; border: none; width: 100px;'>NORMAL</button>";



}else if($data->reorder_qty = ($i->item_in - $i->item_ex)){



echo "<button style='background: blue; font-weight: bold; color: white; padding: 5px; font-size: 12px; border: none; width: 100px;'>BALANCE</button>";



}



?>



</td>



<td><?=$data->unit_name?></td>



<td style="text-align:right"><?=$i->final_stock?></td>



<td style="text-align:right"><?=@number_format($data->d_price,2)?></td>



<td style="text-align:right"><?=number_format($amt,2)?></td>



</tr>



<?



}



}



?>



<tr>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td></td>



<td>Total: </td>



<td style="text-align:right"><?=number_format(($total_amt),2)?></td>



</tr>



</tbody></table>



<?



}



elseif($_POST['report']==4){ 



if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;}



if($_POST['brand_category']!='') 			{$brand_con=' and i.brand_category='.'"'.$_POST['brand_category'].'"';} 



if($_POST['batch_type']!='') 			{$batch_con=' and p.batch_type='.'"'.$_POST['batch_type'].'"';}



if(isset($item_id)) 				{$item_cons=' and i.item_id='.$item_id;}



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if($_SESSION['user']['depot']==12)



if($_POST['batch_type']!=''){



$sql="select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.p_price as item_price,p.batch_type as fg_for



from item_info i, item_sub_group s, production_floor_issue_master p, journal_item j,item_group g 



where i.item_id=j.item_id and g.group_id=s.group_id and s.sub_group_id=i.sub_group_id and p.pi_no=j.sr_no and j.warehouse_id='".$_SESSION['user']['depot']."' ".$item_sub_con.$group_con.$item_cons.$brand_con.$brand_connn.$batch_con." group by i.item_id order by i.item_id,i.item_name";



}else{



$sql='select distinct i.item_id,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.p_price as item_price



from item_info i, item_sub_group s, journal_item j where i.product_nature="Saleable" '.$item_cons.$brand_con.' and 



i.sub_group_id=s.sub_group_id  and j.item_id=i.item_id and j.warehouse_id=12 group by i.item_id order by i.item_id,s.sub_group_name,i.item_name';



}



else



$sql='select distinct i.unit_name,i.finish_goods_code,i.pack_size,i.item_name,s.sub_group_name,i.finish_goods_code,sum(j.item_in-j.item_ex) as stock,i.pack_size,i.d_price as item_price,p.batch_type as fg_for



from item_info i, item_sub_group s, journal_item j, production_floor_issue_master p where j.item_id=i.item_id  and  j.sr_no=p.pi_no and p.item_id=i.item_id and



i.sub_group_id=s.sub_group_id  and i.product_nature="Saleable" '.$brand_con.$item_cons.' group by j.item_id order by i.finish_goods_code,s.sub_group_name,i.item_name';



$query =db_query($sql); 



if($_SESSION['user']['level']==4 or $_SESSION['user']['level']==5 or $_SESSION['user']['level']==1){  



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);



}else{



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



}



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="13"><div class="header"><h1>Alin Food Products Ltd</h1>



<h2><?=$report?></h2>



<h2><? echo $_POST['brand_category'];?></h2>



<h2><? echo $_POST['batch_type'];?></h2>



<h2>Closing Stock of Date-<? echo $to_date=$_POST['f_date'] .' To '. $_POST['t_date'] ?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>



</td></tr><tr>



<th>S/L</th>



<th>Item Code</th>



<th>FG</th>



<th>Item Name</th>



<th>Pack Size</th>



<th>Unit</th>



<th>Opening</th><th>IN</th><th>OUT</th><th style="text-align:center">Final Stock in PCS </th><th style="text-align:center">Total CTN</th>



<th>Rate</th>



<th>Stock Price</th>



<th>FG FOR</th>



</tr>



</thead><tbody>



<?



while($data=mysqli_fetch_object($query)){



if($_SESSION['user']['level']==4 or $_SESSION['user']['level']==5 or $_SESSION['user']['level']==1){



if($_POST['batch_type']!=''){



 $s='select sum(a.item_in-a.item_ex) as final_stock,sum(a.item_in) as fgin,sum(a.item_ex) as fgex



from journal_item a, production_floor_issue_master p where  a.warehouse_id=12 and a.item_id="'.$data->item_id.'" '.$date_con.$status_con.$batch_con.' order by a.id desc limit 1';



$pre=find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock from journal_item j where  j.ji_date<"'.$_POST['f_date'].'" and  j.warehouse_id="'.$_SESSION['user']['depot'].'" '.$batch_con.'  and j.item_id='.$data->item_id); 



}else{



 $s='select sum(a.item_in-a.item_ex) as final_stock,sum(a.item_in) as fgin,sum(a.item_ex) as fgex



from journal_item a where   a.item_id="'.$data->item_id.'" and a.warehouse_id=12 and  a.item_id="'.$data->item_id.'" '.$date_con.$status_con.' order by a.id desc limit 1';



$pre=find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock from journal_item j where  j.ji_date<"'.$_POST['f_date'].'" and  j.warehouse_id="'.$_SESSION['user']['depot'].'" '.$batch_con.'  and j.item_id='.$data->item_id);



}



}else{



 $s='select sum(a.item_in-a.item_ex) as final_stock



from journal_item a, production_floor_issue_master p where a.item_id="'.$data->item_id.'" '.$date_con.$status_con.$batch_con.' and a.warehouse_id="'.$_SESSION['user']['depot'].'" order by a.id desc limit 1';



}



//echo $s;



$q = db_query($s);



$i=mysqli_fetch_object($q);$j++;



?>



<tr>



<td><?=$j?></td>



<td><?=$data->item_id?></td>



<td><?=$data->finish_goods_code?></td>



<td><?=$data->item_name?></a></td>



<td><?=$data->pack_size?></td>



<td><?=$data->unit_name?></td>



<td><?=(int)($pre->pre_stock);?></td><td><a href="warehouse_master_report.php?report=100012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$data->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['issue_status']?>&relevant_warehouse_id=<?=$_POST['production_line']?>&warehouse_id=<?=$_POST['warehouse_id']?>" target="_blank"><?=(int)($i->fgin)?></a></td><td><a href="warehouse_master_report.php?report=200012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$data->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['issue_status']?>&relevant_warehouse_id=<?=$_POST['production_line']?>&warehouse_id=<?=$_SESSION['user']['depot']?>" target="_blank"><?=(int)($i->fgex)?></a></td><?php  /*?> <td style="text-align:center;background-color:#FFCCFF;"><?=number_format(($i->final_stock/$data->pack_size),2); $tot_crt +=($i->final_stock/$data->pack_size);?></td><?php */ ?><td style="text-align:center;background-color:#FFCCFF;"><?=(int)($t_pcs=$pre->pre_stock+$i->fgin-$i->fgex); ?></td><td style="text-align:center; background-color:#CCFFFF;"><? echo $tot_crt=(int)($t_pcs/$data->pack_size); $tott_crt=$tott_crt+($t_pcs/$data->pack_size);?></td>



<td style="text-align:right"><span style="text-align:right; background-color:#CCFFFF;">



</span></td>



<td style="text-align:right"></td>



<td style="text-align:right"><?=$data->fg_for;?></td>



</tr>



<?



$tt_pcs=$t_pcs+$tt_pcs;



$t_sum = $t_sum + $sum;



}



?>



<tr>



<td></td>



<td>Total :</td>



<td></td>



<td></td>



<td></td>



<td>&nbsp;</td>



<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>



<td style="text-align:center"><strong><?= $tt_pcs;?></strong></td>



<td style="text-align:center"><strong><?=(int)$tott_crt;?></strong></td>



<td style="text-align:right"></td>



<td style="text-align:right"><?=number_format($t_sum,2)?></td>



<td style="text-align:right"></td>



</tr></tbody></table>



<?



}



// Master Warehouse Stock Report in Detail



//Modification Date: 2019-08-18



//Edited By Rony



elseif($_POST['report']==18082019) 



{



if(isset($item_id)) 				{$item_cons=' and i.item_id='.$item_id;}



if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; $date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



?>



<table width="100%" cellspacing="0" cellpadding="0" border="0"><thead><tr><td style="border:0px;" colspan="13"><div class="header"><h1>Alin Food Products Ltd</h1>



<h2><?=$report?></h2>



<h2>FG_SECTION:<? echo $_POST['brand_category'];?></h2>



<?php echo '<h2> Item Name : '.find_a_field('item_info','item_name','item_id='.$item_id).'</h2>'; ?>



<h2>Closing Stock of Date-<? echo $to_date=$_POST['f_date'] .' To '. $_POST['t_date'] ?></h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div>



</td></tr><tr>



<th>S/L</th>



<th colspan="5">Date</th>



</tr>



</thead><tbody>



<?



$rony ='SELECT ji_date, sum(j.item_in -j.item_ex) as stock 



FROM journal_item j,item_info i 



WHERE   j.item_id=i.item_id '.$item_cons.$date_con.'  GROUP BY ji_date';



$query = db_query($rony);



while($data=mysqli_fetch_object($query)){



$j++;



if( ($data->stock) !='' ){



?>



<tr> 



<td><?php echo $j;?></td>



<td><?php echo $data->ji_date;?></td>



<td colspan="6" style="padding:0px">



<table  width="100%" cellspacing="0" cellpadding="0" border="0">



<tr bgcolor="#0099FF">



<th>Warehouse</th>



<th>Opening</th>



<th>IN</th>



<th>OUT</th>



<th style="text-align:center">Final Stock in PCS </th>



</tr>		



<?php 



$sqlm= 'SELECT w.warehouse_name,w.warehouse_id FROM 



warehouse w WHERE 



1 ';



$qm=db_query($sqlm);



$tot_open = 0;



$tot_in = 0;



$tot_out = 0;



$tot_closing=0;



while($dataw=mysqli_fetch_object($qm)){



$sql= 'SELECT i.item_name, j.ji_date, w.warehouse_name,j.warehouse_id, SUM(j.item_in) as Inward,SUM(j.item_ex) as Outward FROM 



journal_item j,warehouse w, item_info i  WHERE 



j.ji_date= "'.$data->ji_date.'"  and   i.item_id=j.item_id AND w.warehouse_id=j.warehouse_id AND w.warehouse_id='.$dataw->warehouse_id.' '.$item_cons.' 



GROUP BY  j.warehouse_id,j.item_id';



$q=db_query($sql);



$data2=mysqli_fetch_object($q);



$sql2='SELECT i.item_name, j.ji_date, w.warehouse_name,j.warehouse_id, SUM(j.item_in-j.item_ex) as open 



FROM journal_item j,warehouse w, item_info i 



WHERE 



j.ji_date <"'.$data->ji_date.'" and  i.item_id=j.item_id AND w.warehouse_id=j.warehouse_id '.$item_cons.' and 



j.warehouse_id='.$dataw->warehouse_id.' group by warehouse_id';



$q2=db_query($sql2);



$data3=mysqli_fetch_object($q2);



$open_stock = $data3->open;



$tot_open +=  $open_stock;



$open_stock ;



if($open_stock != 0|| $data2->Inward > 0 || $data2->Outward >0){



?>



<tr>



<td width="40%"><?php echo $dataw->warehouse_name ; ?></td>



<td width="15%"><?php echo $open_stock ;?></td>



<td width="15%"><?php echo $data2->Inward;  $tot_in += $data2->Inward; ?></td>



<td width="15%"><?php echo $data2->Outward;  $tot_out += $data2->Outward;?></td>



<td width="15%">



<?php   $sql2= 'SELECT i.item_name, j.ji_date, w.warehouse_name,j.warehouse_id, SUM(j.item_in-j.item_ex) as inn,SUM(j.item_ex) as Outward FROM journal_item 							j,warehouse w, item_info i WHERE  j.ji_date ="'.$data->ji_date.'" and  i.item_id=j.item_id AND w.warehouse_id=j.warehouse_id '.$item_cons.' and j.warehouse_id="'.$data2->warehouse_id.'"';



$q2=db_query($sql2);



$data3=mysqli_fetch_object($q2);



$closing_stock =($open_stock + $data3->inn) - $dataw->Outward;



$tot_closing += $closing_stock;



echo $closing_stock;



?>		



</td>



</tr>



<?php   } }?>



<tr bgcolor="#99CCFF">



<td> Total :</td>



<td> <?php echo $tot_open; ?></td>



<td>  <?php echo $tot_in;?></td>



<td>  <?php echo $tot_out;?></td>



<td>  <?php echo $tot_closing;?></td>



</tr>



</table>



</td>



</tr>



<?



$grand_open += $tot_open;



$grand_in += $tot_in;



$grand_out += $tot_out;



$grand_closing += $tot_closing;



}



}



?>



<tr>



<td>&nbsp;</td>



<td colspan="2">Grand Total:</td>



<td align="center"></td>



<td><?php echo $grand_in; ?></td>



<td><?php echo $grand_out; ?></td>



<td></td>



</tr>



</tbody>



</table>



<?



}



elseif($_POST['report']==71) 



{



$sql='select i.item_id,i.unit_name,i.item_name,i.sales_item_type,i.finish_goods_code,i.item_brand,i.pack_unit,i.pack_size,i.sales_item_type from item_info i where 



i.product_nature = "Salable"  order by i.finish_goods_code,i.item_name';



$query =db_query($sql);  



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="12"><div class="header"><h1>Alin Food Products Ltd</h1>



<h2>Warehouse Present Stock</h2></div><div class="left"></div><div class="right"></div><div class="date">Reporting Time: <?=date("h:i A d-m-Y")?></div></td></tr><tr>



<th>S/L</th>



<th>FG Code </th>



<th>Brand</th>



<th>Group</th>



<th>Item Name </th>



<th>Pack Size </th>



<th>Pcs Unit</th>



<th bgcolor="#FFCCFF">CRT</th>



<th bgcolor="#CCCCFF">PCS</th>



<th>Rate</th>



<th>Stock Price</th>



</tr>



</thead><tbody>



<?



while($data=mysqli_fetch_object($query)){



$s='select a.final_stock,a.final_price as rate,(a.final_stock*a.final_price) as Stock_price from journal_item a where  a.item_id="'.$data->item_id.'"  and a.warehouse_id='.$_SESSION['user']['depot'].' order by a.id desc limit 1';



$q = db_query($s);



$i=mysqli_fetch_object($q);$j++;



?>



<tr><td><?=$j?></td>



<td><?=$data->finish_goods_code?></td>



<td><?=$data->item_brand?></td>



<td><?=$data->sales_item_type?></td>



<td><?=$data->item_name?></td>



<td><?=$data->pack_size?></td>



<td><?=$data->unit_name?></td>



<td bgcolor="#FFCCFF" style="text-align:right"><?=(int)($i->final_stock/$data->pack_size)?></td>



<td bgcolor="#CCCCFF" style="text-align:right"><?=(int)($i->final_stock%$data->pack_size)?></td>



<td style="text-align:right"><?=$i->rate?></td><td style="text-align:right"><?=$i->Stock_price?></td></tr>



<?



}



}



elseif($_POST['report']==1004)



{



$report="RM Consumtion Report";



if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}



if(isset($sub_group_id)){$s_con.=' and i.sub_group_id="'.$sub_group_id.'"';} 



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="17" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



?>



<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>



<?



if(isset($warehouse_id))



echo '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th rowspan="2">S/L</th>



<th rowspan="2">Item Code </th>



<th rowspan="2">Item Name </th>



<th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>



<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>



<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>



<th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>



</tr>



<tr>



<th bgcolor="#99CC99">Qty</th>



<th bgcolor="#99CC99">Rate</th>		



<th bgcolor="#99CC99">Taka</th>



<th bgcolor="#339999">Qty</th>



<th bgcolor="#339999">Rate</th>		



<th bgcolor="#339999">Taka</th>



<th bgcolor="#FFCC66">Qty</th>



<th bgcolor="#FFCC66">Rate</th>



<th bgcolor="#FFCC66">Taka</th>



<th bgcolor="#FFFF99">Qty</th>



<th bgcolor="#FFFF99">Rate</th>



<th bgcolor="#FFFF99">Taka</th>



</tr>



</thead><tbody>



<? $sl=1;



$sql="select distinct j.item_id,i.item_name from item_info i,journal_item j where i.item_id=j.item_id and product_nature='Salable' ".$con." order by i.product_nature,i.item_name";



$res	 = db_query($sql);



while($row=mysqli_fetch_object($res))



{



$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date<"'.$f_date.'" and item_id='.$row->item_id.$con);



$pre_stock = (int)$pre->pre_stock;



$pre_price = @($pre->pre_amt/$pre->pre_stock);



$pre_amt   = $pre->pre_amt;



$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);



$in_stock = (int)$in->pre_stock;



$in_price = @($in->pre_amt/$in->pre_stock);



$in_amt   = $pre->pre_amt;



$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);



$out_stock = (int)$out->pre_stock;



$out_price = @($out->pre_amt/$out->pre_stock);



$out_amt   = $pre->pre_amt;



$final_stock = $pre_stock+($in_stock-$out_stock);



$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);



if($pre_stock>0||$in_stock>0||$out_stock>0||$out_stock>0){



?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><?=$row->item_id?></td>



<td><?=$row->item_name?></td>



<td><?=$pre_stock?></td>



<td><?=number_format($pre_price,2)?></td>



<td><?=number_format(($pre_stock*$pre_price),2)?></td>



<td><?=$in_stock?></td>



<td><?=number_format($in_price,2)?></td>



<td><?=number_format(($in_price*$in_stock),2)?></td>



<td><?=$out_stock?></td>



<td><?=number_format($out_price,2)?></td>



<td><?=number_format(($out_price*$out_stock),2)?></td>



<td><?=$final_stock?></td>



<td><?=number_format($final_price,2)?></td>



<td><?=number_format(($final_stock*$final_price),2)?></td>



</tr><? }}?>



</tbody>



</table>



<?



}



elseif($_POST['report']=='admin_1')



{		$dDate=explode('-',$_POST['f_date']);



$year = $dDate[0];



$month = $dDate[1];



$day = $dDate[2];



if($month==1){



$prevMonth = 12;



}else{



$prevMonth = ($dDate[1]-1);



}



if($month==1){



$prevYear = ($dDate[0]-1);



}else{



$prevYear = $dDate[0];



}



$pTotDays = date('t',mktime(0,0,0,$prevMonth,1,$prevYear));



$p_f_date=$prevYear.'-'.$prevMonth.'-01'; 



$p_t_date=$prevYear.'-'.$prevMonth.'-'.$pTotDays;



$report="Adminstrative Budget Report";



if($_POST['sub_group']!='')



$conn = ' and i.sub_group_id='.$_POST['sub_group'];



if($_POST['item_id']!='')



$conn .= ' and i.item_id='.$_POST['item_id'];



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="16" style="border:0px;">



<?



echo '<div class="header">';



//echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h1>'.$report.'</h1>';



?>



<h2><? if($_POST['sub_group']>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$_POST['sub_group'])?></h2>



<?



if(isset($warehouse_id))



echo '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';



if(isset($_POST['t_date'])) 



//echo '<h2>Date Interval : '.$_POST['f_date'].' To '.$_POST['t_date'].'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th rowspan="2">S/L 11</th>



<th rowspan="2">Item Code </th>



<th rowspan="2">Item Name </th>



<th rowspan="2">Unit Name </th>



<th colspan="3" bgcolor="#B3D9B3" style="text-align:center">Budget <?=date('F` y',strtotime($p_f_date))?></th>



<th colspan="3" bgcolor="#83D6D6" style="text-align:center">Consumption <?=date('F` y',strtotime($p_f_date))?></th>



<th rowspan="2" bgcolor="#CCFFCC" style="text-align:center">Varience</th>



<th colspan="3" bgcolor="#FFD9FF" style="text-align:center">Budget 



<?=date('F` y',strtotime($_POST['f_date']))?></th>



</tr>



<tr>



<th bgcolor="#B3D9B3">Qty</th>



<th bgcolor="#B3D9B3">Rate</th>		



<th bgcolor="#B3D9B3">Taka</th>



<th bgcolor="#83D6D6">Qty</th>



<th bgcolor="#83D6D6">Rate</th>		



<th bgcolor="#83D6D6">Taka</th>



<th bgcolor="#FFD9FF" style="text-align:center">Qty</th>



<th bgcolor="#FFD9FF" style="text-align:center">Rate</th>



<th bgcolor="#FFD9FF" style="text-align:center">Taka</th>



</tr>



</thead><tbody>



<? $sl=1;



$sql="select a.item_id, a.budget_qty, a.budget_rate, i.item_name, i.unit_name from item_info i, adminstration_monthly_budget a where i.item_id=a.item_id and  a.budget_date between '".$_POST['f_date']."' and '".$_POST['t_date']."' ".$conn." order by i.item_name";



$res	 = db_query($sql);



while($row=mysqli_fetch_object($res))



{



$prevBudget = find_a_field('adminstration_monthly_budget','budget_qty','item_id="'.$row->item_id.'" and budget_date between "'.$p_f_date.'" and "'.$p_t_date.'"');



$prevRate = find_a_field('adminstration_monthly_budget','budget_rate','item_id="'.$row->item_id.'" and budget_date between "'.$p_f_date.'" and "'.$p_t_date.'"');



$prevConsumption = find_a_field('journal_item','sum(item_ex)','item_id="'.$row->item_id.'" and tr_from="Office Issue" and ji_date between "'.$p_f_date.'" and "'.$p_t_date.'"');



?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><?=$row->item_id?></td>



<td><?=$row->item_name?></td>



<td><?=$row->unit_name?></td>



<td><?=$prevBudget?></td>



<td><?=$prevRate?></td>



<td><? $totalBudget = ($prevBudget*$prevRate); echo number_format($totalBudget,2)?></td>



<td><?=number_format($prevConsumption,0)?></td>



<td><?=$prevRate?></td>



<td><? $totalConsump = ($prevConsumption*$prevRate); echo number_format($totalConsump,2)?></td>



<td><?=$totalBudget-$totalConsump?></td>



<td><?=$row->budget_qty?></td>



<td><?=$row->budget_rate?></td>



<td><?=$row->budget_qty*$row->budget_rate?></td>



</tr><? }?>



</tbody>



</table>



<?



}



elseif($_POST['report']==1005)



{



$report="FG Production Report";		



if(isset($warehouse_id)){$con.=' and j.warehouse_id="'.$warehouse_id.'"';}



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="17" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



?>



<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>



<?



if(isset($warehouse_id))



echo '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th rowspan="2">S/L</th>



<th rowspan="2">Item Code </th>



<th rowspan="2">Item Name </th>



<th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>



<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>



<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>



<th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>



</tr>



<tr>



<th bgcolor="#99CC99">Qty</th>



<th bgcolor="#99CC99">Rate</th>		



<th bgcolor="#99CC99">Taka</th>



<th bgcolor="#339999">Qty</th>



<th bgcolor="#339999">Rate</th>		



<th bgcolor="#339999">Taka</th>



<th bgcolor="#FFCC66">Qty</th>



<th bgcolor="#FFCC66">Rate</th>



<th bgcolor="#FFCC66">Taka</th>



<th bgcolor="#FFFF99">Qty</th>



<th bgcolor="#FFFF99">Rate</th>



<th bgcolor="#FFFF99">Taka</th>



</tr>



</thead><tbody>



<? $sl=1;



$sql="select distinct j.item_id,i.item_name from item_info i,journal_item j where i.item_id=j.item_id and product_nature='Salable' ".$con." order by i.product_nature,i.item_name";



$res	 = db_query($sql);



while($row=mysqli_fetch_object($res))



{



$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date<"'.$f_date.'" and item_id='.$row->item_id.$con);



$pre_stock = (int)$pre->pre_stock;



$pre_price = @($pre->pre_amt/$pre->pre_stock);



$pre_amt   = $pre->pre_amt;



$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);



$in_stock = (int)$in->pre_stock;



$in_price = @($in->pre_amt/$in->pre_stock);



$in_amt   = $pre->pre_amt;



$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id.$con);



$out_stock = (int)$out->pre_stock;



$out_price = @($out->pre_amt/$out->pre_stock);



$out_amt   = $pre->pre_amt;



$final_stock = $pre_stock+($in_stock-$out_stock);



$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);



if($pre_stock>0||$in_stock>0||$out_stock>0||$out_stock>0){



?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><?=$row->item_id?></td>



<td><?=$row->item_name?></td>



<td><?=$pre_stock?></td>



<td><?=number_format($pre_price,2)?></td>



<td><?=number_format(($pre_stock*$pre_price),2)?></td>



<td><?=$in_stock?></td>



<td><?=number_format($in_price,2)?></td>



<td><?=number_format(($in_price*$in_stock),2)?></td>



<td><?=$out_stock?></td>



<td><?=number_format($out_price,2)?></td>



<td><?=number_format(($out_price*$out_stock),2)?></td>



<td><?=$final_stock?></td>



<td><?=number_format($final_price,2)?></td>



<td><?=number_format(($final_stock*$final_price),2)?></td>



</tr><? }}?>



</tbody>



</table>



<?



}



elseif($_POST['report']==1003)



{



$report="Material Consumption  Report";



if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="17" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



?>



<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>



<?



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th rowspan="2">S/L</th>



<th rowspan="2">Item Code </th>



<th rowspan="2">Item Name </th>



<th colspan="3" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>



<th colspan="3" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>



<th colspan="3" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>



<th colspan="3" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>



</tr>



<tr>



<th bgcolor="#99CC99">Qty</th>



<th bgcolor="#99CC99">Rate</th>		



<th bgcolor="#99CC99">Taka</th>



<th bgcolor="#339999">Qty</th>



<th bgcolor="#339999">Rate</th>		



<th bgcolor="#339999">Taka</th>



<th bgcolor="#FFCC66">Qty</th>



<th bgcolor="#FFCC66">Rate</th>



<th bgcolor="#FFCC66">Taka</th>



<th bgcolor="#FFFF99">Qty</th>



<th bgcolor="#FFFF99">Rate</th>



<th bgcolor="#FFFF99">Taka</th>



</tr>



</thead><tbody>



<? $sl=1;



$sql="select i.item_id,i.item_name from item_info i where i.sub_group_id='".$sub_group_id."'	order by i.product_nature,i.item_name";



$res	 = db_query($sql);



while($row=mysqli_fetch_object($res))



{



$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id);



$pre_stock = (int)$pre->pre_stock;



$pre_price = @($pre->pre_amt/$pre->pre_stock);



$pre_amt   = $pre->pre_amt;



$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);



$in_stock = (int)$in->pre_stock;



$in_price = @($in->pre_amt/$in->pre_stock);



$in_amt   = $pre->pre_amt;



$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);



$out_stock = (int)$out->pre_stock;



$out_price = @($out->pre_amt/$out->pre_stock);



$out_amt   = $pre->pre_amt;



$final_stock = $pre_stock+($in_stock-$out_stock);



$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);



?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><a target="_blank" href="../ws/product_transection_report_master.php?item_id=<?=$row->item_id?>&f_date=<?=$f_date?>&t_date=<?=$t_date?>&submit=3&report=3"><?=$row->item_id?></a></td>



<td><?=$row->item_name?></td>



<td><?=$pre_stock?></td>



<td><?=number_format($pre_price,2)?></td>



<td><?=number_format(($pre_stock*$pre_price),2)?></td>



<td><?=$in_stock?></td>



<td><?=number_format($in_price,2)?></td>



<td><?=number_format(($in_price*$in_stock),2)?></td>



<td><?=$out_stock?></td>



<td><?=number_format($out_price,2)?></td>



<td><?=number_format(($out_price*$out_stock),2)?></td>



<td><?=$final_stock?></td>



<td><?=number_format($final_price,2)?></td>



<td><?=number_format(($final_stock*$final_price),2)?></td>



</tr><? }?>



</tbody>



</table>



<?



}



elseif($_POST['report']==1006)



{



$report="Product Movement Detail Report (Depot)";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="36" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th rowspan="3">S/L</th>



<th rowspan="3">FG</th>



<th rowspan="3">Item Name </th>



<th rowspan="3">Grp</th>



<th colspan="3" rowspan="2"><div align="center">Opening</div></th>



<th colspan="12" bgcolor="#339999" style="text-align:center">Item Out </th>



<th colspan="12" bgcolor="#99CC99" style="text-align:center">Item In </th>



<th colspan="3" rowspan="2"><div align="center">Closing</div></th>



</tr>



<tr>



<th colspan="3" bgcolor="#339999" style="text-align:center">Party Chalan </th>



<th colspan="3" bgcolor="#339999" style="text-align:center">Store Chalan </th>



<th colspan="3" bgcolor="#339999" style="text-align:center">Other Issue </th>



<th colspan="3" bgcolor="#339999" style="text-align:center">Total Issue </th>



<th colspan="3" bgcolor="#339999" style="text-align:center">Sales Return </th>



<th colspan="3" bgcolor="#339999" style="text-align:center">Store Chalan </th>



<th colspan="3" bgcolor="#339999" style="text-align:center">Transfer Receive </th>



<th colspan="3" bgcolor="#339999" style="text-align:center">Total Receive </th>



</tr>



<tr>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



</tr>



</thead><tbody>



<? $sl=1;



if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 



$sql="select i.item_id,i.item_name,i.sales_item_type,i.pack_size,i.finish_goods_code,i.sales_item_type from item_info i where i.finish_goods_code>0  ".$item_con." order by i.item_id";



$table = 'journal_item';



$show_in = 'sum(item_in-item_ex)';



$show_ex = 'sum(item_ex-item_in)';



$res	 = db_query($sql);



while($row=mysqli_fetch_object($res))



{



echo '';



$pre_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date < "'.$f_date.'"';



$pro_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date <= "'.$t_date.'"';



$con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date between "'.$f_date.'" and "'.$t_date.'"';



$open = find_a_field($table,$show_in,$pre_con);



$issue_in = find_a_field($table,'sum(item_in)',$con.' and tr_from = "Issue"');



$return = find_a_field($table,'sum(item_in)',$con.' and tr_from = "Return"');



$total_in = find_a_field($table,'sum(item_in)',$con);



$otr_in = $total_in - ($issue_in + $return);



$sales = find_a_field($table,'sum(item_ex)',$con.' and tr_from = "Sales"');



$issue_ex = find_a_field($table,'sum(item_ex)',$con.' and tr_from = "Issue"');



$total_ex = find_a_field($table,'sum(item_ex)',$con);



$otr_ex = $total_ex - ($issue_ex + $sales);



$closing = find_a_field($table,$show_in,$pro_con);



?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><?=$row->finish_goods_code?></td>



<td><?=$row->item_name?></td>



<td><?=$row->sales_item_type?></td>



<? ssd($open,$row->pack_size);?>



<? ssd($sales,$row->pack_size);?>



<? ssd($issue_ex,$row->pack_size);?>



<? ssd($otr_ex,$row->pack_size);?>



<? ssd($total_ex,$row->pack_size);?>



<? ssd($return,$row->pack_size);?>



<? ssd($issue_in,$row->pack_size);?>



<? ssd($otr_in,$row->pack_size);?>



<? ssd($total_in,$row->pack_size);?>



<? ssd($closing,$row->pack_size);?>



</tr><? }?>



</tbody>



</table>



<?



}



elseif($_POST['report']==1007)



{		if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 



$report="Product Movement Summary Report (Depot)";



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="17" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th rowspan="2">S/L</th>



<th rowspan="2">Item Name </th>



<th rowspan="2">Grp</th>



<th colspan="3"><div align="center">Opening</div></th>



<th colspan="3" bgcolor="#339999" style="text-align:center">Item Out/Total Issue </th>



<th colspan="3" bgcolor="#99CC99" style="text-align:center">Item In/Total Receive </th>



<th colspan="3"><div align="center">Closing</div></th>



</tr>



<tr>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



<th bgcolor="#339999">Crt</th>



<th bgcolor="#339999">Pcs</th>



<th bgcolor="#339999">TPcs</th>



</tr>



</thead><tbody>



<? $sl=1;



if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 



$sql="select i.item_id,i.item_name,i.sales_item_type,i.pack_size,i.finish_goods_code,i.sales_item_type from item_info i where i.finish_goods_code>0 ".$item_con." order by i.item_id";



$table = 'journal_item';



$show_in = 'sum(item_in-item_ex)';



$show_ex = 'sum(item_ex-item_in)';



$res	 = db_query($sql);



while($row=mysqli_fetch_object($res))



{



echo '';



$pre_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date < "'.$f_date.'"';



$pro_con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date <= "'.$t_date.'"';



$con = 'warehouse_id="'.$_SESSION['user']['depot'].'" and item_id="'.$row->item_id.'" and ji_date between "'.$f_date.'" and "'.$t_date.'"';



$open = find_a_field($table,$show_in,$pre_con);



$total_in = find_a_field($table,'sum(item_in)',$con);



$total_ex = find_a_field($table,'sum(item_ex)',$con);



$closing = find_a_field($table,$show_in,$pro_con);



?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><?=$row->item_name?></td>



<td><?=$row->sales_item_type?></td>



<? ssd($open,$row->pack_size);?>



<? ssd($total_ex,$row->pack_size,'#99FFFF');?>



<? ssd($total_in,$row->pack_size,'#FFCCFF');?>



<? ssd($closing,$row->pack_size);?>



</tr><? }?>



</tbody>



</table>



<?



}



elseif($_POST['report']==2006)



{



$report="Category Wise Stock Report";	



if(isset($warehouse_id)){$warehouse_con.=' and j.warehouse_id="'.$warehouse_id.'"';}



if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($group_id)) 			{$group_con=' and g.group_id='.$group_id;} 



if(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



if(isset($item_brand)) 			{$brand_con=' and i.item_brand="'.$item_brand.'"';} 



if($_POST['brand_category']!='') 			{$brand_connn=' and i.brand_category="'.$_POST['brand_category'].'"';} 



if($_POST['batch_type']!='') 			{$batch_con=' and p.batch_type='.'"'.$_POST['batch_type'].'"';}



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="14" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



?>



<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>



<?



if(isset($warehouse_id))



echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



echo '<h2> '.$_POST['batch_type'].'</h2>';



echo '<h2> '.$_POST['brand_category'].'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th>S/L</th>



<th>Item Group </th>



<th>FG BRAND</th>



<th>Item Code </th>



<th>FG Code </th>



<th>Item Name </th>



<th  style="text-align:center">OPENING </th>



<th style="text-align:center">IN</th>



<th  style="text-align:center">OUT</th>



<th  style="text-align:center">CLOSING</th>



<th style="text-align:center">Unit</th>



<th  style="text-align:center">Stock Value </th>



</tr>



</thead><tbody>



<? $sl=1;



if($_POST['batch_type']!=''){



$sql="select distinct g.group_name, s.sub_group_name,i.brand_category, j.item_id,i.item_name, i.unit_name, i.d_price as d_price,j.sr_no 



from item_info i,journal_item j, item_group g, item_sub_group s, production_floor_issue_master p



where i.item_id=j.item_id and g.group_id=s.group_id and s.sub_group_id=i.sub_group_id and p.pi_no=j.sr_no  ".$item_sub_con.$group_con.$item_con.$brand_con.$brand_connn.$batch_con.$warehouse_con." group by i.item_id order by i.brand_category,i.item_name,i.item_id";



} else{



$sql="select distinct g.group_name, s.sub_group_name,i.brand_category, j.item_id,i.item_name,i.finish_goods_code as fg_code, i.unit_name, i.d_price as d_price,j.sr_no 



from item_info i,journal_item j, item_group g, item_sub_group s 



where i.item_id=j.item_id and g.group_id=s.group_id and s.sub_group_id=i.sub_group_id  ".$item_sub_con.$group_con.$item_con.$brand_con.$brand_connn.$warehouse_con." group by i.item_id order by  i.brand_category,i.item_name,i.item_id";



}



$res	 = db_query($sql);



while($row=mysqli_fetch_object($res))



{



if($_POST['batch_type']!=''){



$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock,sum((j.item_in-j.item_ex)*item_price) as pre_amt



from journal_item j, production_floor_issue_master p



where j.ji_date<"'.$f_date.'" '.$batch_con.$warehouse_con.' and p.pi_no=j.sr_no and j.item_id='.$row->item_id);



}else{



$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date !="0000-00-00" and ji_date<"'.$f_date.'"    and item_id='.$row->item_id);



}



$pre_stock = $pre->pre_stock;



$pre_price = @($pre->pre_amt/$pre->pre_stock);



$pre_amt   = $pre->pre_amt;



if($_POST['batch_type']!=''){



$in = find_all_field_sql('select sum(j.item_in) as pre_stock, sum(j.item_in*j.item_price) as pre_amt 



from journal_item j, production_floor_issue_master p



where item_in>0 and j.ji_date between "'.$f_date.'" and "'.$t_date.'" '.$batch_con.$warehouse_con.' and p.pi_no=j.sr_no and j.item_id='.$row->item_id);



}else{



$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'"  '.$warehouse_con.'  and item_id='.$row->item_id);



}



$in_stock = $in->pre_stock;



$in_price = @($in->pre_amt/$in->pre_stock);



$in_amt   = $pre->pre_amt;



$sql='select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt 



from journal_item j



where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" '.$warehouse_con.'  and item_id='.$row->item_id.'';



if($_POST['batch_type']!=''){



$out = find_all_field_sql('select sum(j.item_ex) as pre_stock, sum(j.item_ex*j.item_price) as pre_amt 



from journal_item j, production_floor_issue_master p



where j.item_ex>0 and j.ji_date between "'.$f_date.'" and "'.$t_date.'"  '.$batch_con.$warehouse_con.' and p.pi_no=j.sr_no and j.item_id='.$row->item_id);



}else{



$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'"'.$warehouse_con.' and item_id='.$row->item_id);



}



$out_stock = $out->pre_stock;



$out_price = @($out->pre_amt/$out->pre_stock);



$out_amt   = $pre->pre_amt;



$final_stock = $pre_stock+($in_stock-$out_stock);



$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);



$final_amt = $final_stock*$final_price;







?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><?=$row->group_name?></td>



<td><?=$row->brand_category;?></td>



<td><?=$row->item_id?></td>



<td><?=$row->fg_code?></td>



<td><?=$row->item_name?></td>



<td><?=number_format($pre_stock,2); $t_pre_stock +=$pre_stock;?></td>



<td><a href="warehouse_master_report.php?report=100012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$row->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&warehouse_id=<?=$warehouse_id?>" target="_blank"><?=number_format($in_stock,2); $t_in_stock+=$in_stock;?></a></td>



<td><a href="warehouse_master_report.php?report=200012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$row->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['issue_status']?>&warehouse_id=<?=$_POST['warehouse_id']?>" target="_blank"><?=number_format($out_stock,2); $t_out_stock+=$out_stock;?></a></td>



<td><?=number_format($final_stock,2); $t_final_stock+=$final_stock;?></td>



<td><?=$row->unit_name?></td>



<td><?=number_format($final_amt,2);$tfinal_amt+=$final_amt;?></td>



</tr>



<? }  ?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td><div align="right"><strong>Total=</strong></div></td>



<td><span class="style4">



<?=number_format($t_pre_stock,2);?>



</span></td>



<td><span class="style5">



<?=number_format($t_in_stock,2);?>



</span></td>



<td><span class="style6">



<?=number_format($t_out_stock,2);?>



</span></td>



<td colspan="2"><span class="style7">



<?=number_format($t_final_stock,2);?>



</span></td>



<td><span class="style6">



<?=number_format($tfinal_amt,2);?>



</span></td>



</tr>



</tbody>



</table>



<?



}





elseif($_POST['report']==76)



{



$report="Category Wise Stock Report Excluding Nill Balance";	



if(isset($warehouse_id)){$warehouse_con.=' and j.warehouse_id="'.$warehouse_id.'"';}



if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($group_id)) 			{$group_con=' and g.group_id='.$group_id;} 



if(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



if(isset($item_brand)) 			{$brand_con=' and i.item_brand="'.$item_brand.'"';} 



if($_POST['brand_category']!='') 			{$brand_connn=' and i.brand_category="'.$_POST['brand_category'].'"';} 



if($_POST['batch_type']!='') 			{$batch_con=' and p.batch_type='.'"'.$_POST['batch_type'].'"';}



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="14" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



?>



<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>



<?



if(isset($warehouse_id))



echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



echo '<h2> '.$_POST['batch_type'].'</h2>';



echo '<h2> '.$_POST['brand_category'].'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th>S/L</th>



<th>Item Group </th>



<th>FG BRAND</th>



<th>Item Code </th>



<th>FG Code </th>



<th>Item Name </th>



<th  style="text-align:center">OPENING </th>



<th style="text-align:center">IN</th>



<th  style="text-align:center">OUT</th>



<th  style="text-align:center">CLOSING</th>



<th style="text-align:center">Unit</th>



<th  style="text-align:center">Stock Value </th>



</tr>



</thead><tbody>



<? $sl=1;





 

 $sql="select distinct g.group_name, s.sub_group_name,i.brand_category, j.item_id,i.item_name,i.finish_goods_code as fg_code, i.unit_name, i.d_price as d_price,j.sr_no 



from item_info i,journal_item j, item_group g, item_sub_group s 



where i.item_id=j.item_id and g.group_id=s.group_id and s.sub_group_id=i.sub_group_id  ".$item_sub_con.$group_con.$item_con.$brand_con.$brand_connn.$warehouse_con." group by i.item_id order by  i.brand_category,i.item_name,i.item_id";





$res	 = db_query($sql);



while($row=mysqli_fetch_object($res))



{



if($_POST['batch_type']!=''){



$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock,sum((j.item_in-j.item_ex)*item_price) as pre_amt



from journal_item j, production_floor_issue_master p



where j.ji_date<"'.$f_date.'" '.$batch_con.$warehouse_con.' and p.pi_no=j.sr_no and j.item_id='.$row->item_id);



}else{



$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date !="0000-00-00" and ji_date<"'.$f_date.'"    and item_id='.$row->item_id);



}



$pre_stock = $pre->pre_stock;



$pre_price = @($pre->pre_amt/$pre->pre_stock);



$pre_amt   = $pre->pre_amt;



if($_POST['batch_type']!=''){



$in = find_all_field_sql('select sum(j.item_in) as pre_stock, sum(j.item_in*j.item_price) as pre_amt 



from journal_item j, production_floor_issue_master p



where item_in>0 and j.ji_date between "'.$f_date.'" and "'.$t_date.'" '.$batch_con.$warehouse_con.' and p.pi_no=j.sr_no and j.item_id='.$row->item_id);



}else{



$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'"  '.$warehouse_con.'  and item_id='.$row->item_id);



}



$in_stock = $in->pre_stock;



$in_price = @($in->pre_amt/$in->pre_stock);



$in_amt   = $pre->pre_amt;



$sql='select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt 



from journal_item j



where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" '.$warehouse_con.'  and item_id='.$row->item_id.'';



if($_POST['batch_type']!=''){



$out = find_all_field_sql('select sum(j.item_ex) as pre_stock, sum(j.item_ex*j.item_price) as pre_amt 



from journal_item j, production_floor_issue_master p



where j.item_ex>0 and j.ji_date between "'.$f_date.'" and "'.$t_date.'"  '.$batch_con.$warehouse_con.' and p.pi_no=j.sr_no and j.item_id='.$row->item_id);



}else{



$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'"'.$warehouse_con.' and item_id='.$row->item_id);



}



$out_stock = $out->pre_stock;



$out_price = @($out->pre_amt/$out->pre_stock);



$out_amt   = $pre->pre_amt;



$final_stock = $pre_stock+($in_stock-$out_stock);



$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);



$final_amt = $final_stock*$final_price;





if($pre_stock !=0 || $in_stock !=0 || $out_stock !=0 || $final_stock !=0 ) {

?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><?=$row->group_name?></td>



<td><?=$row->brand_category;?></td>



<td><?=$row->item_id?></td>



<td><?=$row->fg_code?></td>



<td><?=$row->item_name?></td>



<td><?=number_format($pre_stock,2); $t_pre_stock +=$pre_stock;?></td>



<td><a href="warehouse_master_report.php?report=100012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$row->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&warehouse_id=<?=$warehouse_id?>" target="_blank"><?=number_format($in_stock,2); $t_in_stock+=$in_stock;?></a></td>



<td><a href="warehouse_master_report.php?report=200012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$row->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['issue_status']?>&warehouse_id=<?=$_POST['warehouse_id']?>" target="_blank"><?=number_format($out_stock,2); $t_out_stock+=$out_stock;?></a></td>



<td><?=number_format($final_stock,2); $t_final_stock+=$final_stock;?></td>



<td><?=$row->unit_name?></td>



<td><?=number_format($final_amt,2);$tfinal_amt+=$final_amt;?></td>



</tr>



<? } }  ?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td>&nbsp;</td>



<td><div align="right"><strong>Total=</strong></div></td>



<td><span class="style4">



<?=number_format($t_pre_stock,2);?>



</span></td>



<td><span class="style5">



<?=number_format($t_in_stock,2);?>



</span></td>



<td><span class="style6">



<?=number_format($t_out_stock,2);?>



</span></td>



<td colspan="2"><span class="style7">



<?=number_format($t_final_stock,2);?>



</span></td>



<td><span class="style6">



<?=number_format($tfinal_amt,2);?>



</span></td>



</tr>



</tbody>



</table>



<?



}









elseif($_POST['report']==20190821)



{



$report="Warehouse Wise Stock Report";	



if(isset($warehouse_id)){$warehouse_con.=' and j.warehouse_id="'.$warehouse_id.'"';}



if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($group_id)) 			{$group_con=' and g.group_id='.$group_id;} 



if(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



if(isset($item_brand)) 			{$brand_con=' and i.item_brand="'.$item_brand.'"';} 



if($_POST['brand_category']!='') 			{$brand_connn=' and i.brand_category="'.$_POST['brand_category'].'"';} 



if($_POST['batch_type']!='') 			{$batch_con=' and p.batch_type='.'"'.$_POST['batch_type'].'"';}



?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



<thead>



<tr><td colspan="14" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



?>



<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>



<?



if(isset($warehouse_id))



echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



echo '<h2> Item Name : '.find_a_field('item_info','item_name','item_id='.$item_id).'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th>S/L</th>



<th>Warehouse Name </th>



<th  style="text-align:center">OPENING </th>



<th style="text-align:center">IN</th>



<th  style="text-align:center">OUT</th>



<th  style="text-align:center">CLOSING</th>



<th style="text-align:center">Unit</th>



<th style="text-align:center">Rate</th>



<th  style="text-align:center">Stock Value </th>



</tr>



</thead><tbody>



<? $sl=1;



$sql="select distinct w.warehouse_name, w.warehouse_id , j.item_id,i.unit_name



from item_info i, journal_item j, warehouse w



where i.item_id=j.item_id  ".$item_con.$warehouse_con." group by w.warehouse_id order by w.warehouse_name";



$res	 = db_query($sql);



while($row=mysqli_fetch_object($res))



{



$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date !="0000-00-00" and ji_date<"'.$f_date.'"  



and j.warehouse_id="'.$row->warehouse_id.'" and item_id='.$row->item_id);



$pre_stock = $pre->pre_stock;



$pre_price = @($pre->pre_amt/$pre->pre_stock);



$pre_amt   = $pre->pre_amt;



$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" 



and j.warehouse_id="'.$row->warehouse_id.'" and item_id='.$row->item_id);



$in_stock = $in->pre_stock;



$in_price = @($in->pre_amt/$in->pre_stock);



$in_amt   = $pre->pre_amt;



$sql='select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt 



from journal_item j



where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and j.warehouse_id="'.$row->warehouse_id.'"   and item_id='.$row->item_id.'';



$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and j.warehouse_id="'.$row->warehouse_id.'"   and item_id='.$row->item_id);



$out_stock = $out->pre_stock;



$out_price = @($out->pre_amt/$out->pre_stock);



$out_amt   = $pre->pre_amt;



$final_stock = $pre_stock+($in_stock-$out_stock);



$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);



$final_amt = $final_stock*$final_price;



if($pre_stock !=0||$in_stock !=0||$out_stock !=0){



?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><?=$row->warehouse_name?></td>



<td><?=number_format($pre_stock,2); $t_pre_stock +=$pre_stock;?></td>



<?php if($in_stock != 0) { ?>



<td><a href="warehouse_master_report.php?report=100012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$row->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&warehouse_id=<?=$row->warehouse_id?>" target="_blank"><?=number_format($in_stock,2); $t_in_stock+=$in_stock;?></a></td>



<? } else {  ?>



<td>&nbsp;</td>



<? } ?>



<?php if($out_stock != 0) { ?>



<td><a href="warehouse_master_report.php?report=200012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$row->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['issue_status']?>&warehouse_id=<?=$row->warehouse_id?>" target="_blank"><?=number_format($out_stock,2); $t_out_stock+=$out_stock;?></a></td>



<? } else {  ?>



<td>&nbsp;</td>



<? } ?>



<td><?=number_format($final_stock,2); $t_final_stock+=$final_stock;?></td>



<td><?=$row->unit_name?></td>



<td><?=number_format($final_price,2);?></td>



<td><?=number_format($final_amt,2);$tfinal_amt+=$final_amt;?></td>



</tr>



<? }  }?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td>&nbsp;</td>



<td><div align="right"><strong>Total=</strong></div></td>



<td><span class="style4">



<?=number_format($t_pre_stock,2);?>



</span></td>



<td><span class="style5">



<?=number_format($t_in_stock,2);?>



</span></td>



<td><span class="style6">



<?=number_format($t_out_stock,2);?>



</span></td>



<td colspan="2"><span class="style7">



<?=number_format($t_final_stock,2);?>



</span></td>



<td>&nbsp;</td>



<td><span class="style6">



<?=number_format($tfinal_amt,2);?>



</span></td>



</tr>



</tbody>



</table>



<?



}



elseif($_POST['report']==30092019)



{



$report="Group & Warehouse Wise Stock Report";	



if(isset($warehouse_id)){$warehouse_con.=' and j.warehouse_id="'.$warehouse_id.'"';}



if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($group_id)) 			{$group_con=' and g.group_id='.$group_id;} 



if(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



if(isset($item_brand)) 			{$brand_con=' and i.item_brand="'.$item_brand.'"';} 



if($_POST['brand_category']!='') 			{$brand_connn=' and i.brand_category="'.$_POST['brand_category'].'"';} 



if($_POST['batch_type']!='') 			{$batch_con=' and p.batch_type='.'"'.$_POST['batch_type'].'"';}



?>



<table width="100%" border="0" cellpadding="0" cellspacing="0">



<thead>



<tr>



<td colspan="14" style="border:0px;">



<?



echo '<div class="header">';



echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



if(isset($report)) 



echo '<h2>'.$report.'</h2>';



?>



<h2><? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?></h2>



<?



if(isset($warehouse_id))



echo '<p>WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';



if(isset($t_date)) 



echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



echo '<h2> Item Name : '.find_a_field('item_info','item_name','item_id='.$item_id).'</h2>';



echo '</div>';



echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



?>



</td></tr>



<tr>



<th>S/L</th>



<th>Item name</th>



<th ></th>



</tr>



</thead>





<? $sl=1;



$sql="select distinct i.item_name, i.item_id ,i.sub_group_id



from item_info i, item_sub_group g



where i.sub_group_id=g.sub_group_id and g.sub_group_id=".$sub_group_id." order by i.item_name ";



$ress	 = db_query($sql);

























while($roww=mysqli_fetch_object($ress))



{



?>



<tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



<td><?=$sl++;?></td>



<td><?=$roww->item_name ?></td>



<td colspan="8">



<table  width="100%" border="0" cellpadding="0" cellspacing="0">



<tr>



<th>Warehouse Name </th>



<th width="10%" style="text-align:center">OPENING </th>



<th width="7%" style="text-align:center">IN</th>



<th width="7%"  style="text-align:center">OUT</th>



<th width="7%" style="text-align:center">CLOSING</th>



<th width="10%" style="text-align:center">Unit</th>



<th width="10%" style="text-align:center">Rate</th>



<th width="10%" style="text-align:center">Stock Value </th>



</tr>



<?



$sql2="select distinct w.warehouse_name, w.warehouse_id , j.item_id,i.unit_name



from item_info i, journal_item j, warehouse w



where i.item_id=j.item_id and j.item_id=".$roww->item_id."   group by w.warehouse_id order by w.warehouse_name";



$res	 = db_query($sql2);







$t_pre_stock=0;

$t_in_stock=0;

$t_out_stock=0;

$t_final_stock=0;

$tfinal_amt=0;





while($row=mysqli_fetch_object($res))



{



$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item j where ji_date !="0000-00-00" and ji_date<"'.$f_date.'"  



and j.warehouse_id="'.$row->warehouse_id.'" and item_id='.$roww->item_id);



$pre_stock = $pre->pre_stock;



$pre_price = @($pre->pre_amt/$pre->pre_stock);



$pre_amt   = $pre->pre_amt;



$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item j where item_in>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" 



and j.warehouse_id="'.$row->warehouse_id.'" and item_id='.$roww->item_id);



$in_stock = $in->pre_stock;



$in_price = @($in->pre_amt/$in->pre_stock);



$in_amt   = $pre->pre_amt;



$sql='select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt 



from journal_item j



where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and j.warehouse_id="'.$row->warehouse_id.'"   and item_id='.$roww->item_id.'';



$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item j where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and j.warehouse_id="'.$row->warehouse_id.'"   and item_id='.$roww->item_id);



$out_stock = $out->pre_stock;



$out_price = @($out->pre_amt/$out->pre_stock);



$out_amt   = $pre->pre_amt;



$final_stock = $pre_stock+($in_stock-$out_stock);



$final_price = @((($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price))/$final_stock);



$final_amt = $final_stock*$final_price;



if($pre_stock !=0|| $in_stock !=0 || $out_stock !=0){



?>



<tr>



<td><?=$row->warehouse_name?></td>



<td><?=number_format($pre_stock,2); $t_pre_stock +=$pre_stock;?></td>







<td><?php if($in_stock != 0) { ?><a href="warehouse_master_report.php?report=100012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$row->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&warehouse_id=<?=$row->warehouse_id?>" target="_blank"><?=number_format($in_stock,2); $t_in_stock+=$in_stock;?></a><? } ?></td>











<td><?php if($out_stock != 0) { ?><a href="warehouse_master_report.php?report=200012&f_date=<?=$_POST['f_date']?>&t_date=<?=$_POST['t_date']?>&item_id=<?=$row->item_id?>&group_id=<?=$_POST['group_id']?>&item_sub_id=<?=$_POST['item_sub_group']?>&tr_type=<?=$_POST['issue_status']?>&warehouse_id=<?=$row->warehouse_id?>" target="_blank"><?=number_format($out_stock,2); $t_out_stock+=$out_stock;?></a><? } ?></td>







<td><?=number_format($final_stock,2); $t_final_stock+=$final_stock;?></td>



<td><?=$row->unit_name?></td>



<td><?=number_format($final_price,2);?></td>



<td><?=number_format($final_amt,2);$tfinal_amt+=$final_amt;?></td>



</tr>

<? }?>





<?  }  ?>



<tr class="footer" >

	<td><b>Total</b></td>

	<td><b><?=number_format($t_pre_stock,2);?></b></td>

	<td><b><?=number_format($t_in_stock,2);?></b></b></td>

	<td><b><?=number_format($t_out_stock,2);?></b></b></td>

	<td><b><?=number_format($t_final_stock,2);?></b></td>

	<td><b></b></td>

	<td></td>

	<td><b><?=number_format($tfinal_amt,2);?></b></td> 

</tr>



</table>



<?

}

}



elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);



?>



</div>



</body>



</html>