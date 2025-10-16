<?



session_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







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



	if($_POST['issued_to']>0) 					$issued_to=$_POST['issued_to'];



	



	if($_POST['receive_status']!='') 			$receive_status=$_POST['receive_status'];



	if($_POST['issue_status']!='') 				$issue_status=$_POST['issue_status'];



	if($_POST['item_sub_group']>0) 				$sub_group_id=$_POST['item_sub_group'];



	if($_POST['item_brand']>0) 				    $item_brand=$_POST['item_brand'];

	

	if($_POST['item_id']!='') 				    $item_con=$_POST['item_id'];

	

	if($_POST['entry_by']!='') 				    $enty_con=$_POST['entry_by'];

	

	

	



switch ($_POST['report']) {







case 1:



		$report="Warehouse Item Transection Report";



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 

		

		if(isset($enty_con)) 				{$con=' and a.entry_by='.$enty_con;} 



		if(isset($item_con)) 				{$item_con=' and a.item_id='.$item_con;} 



		



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



and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.$con.' 



order by a.id, a.ji_date';



	break;

case 14223:

$report="Item Information in detail";

if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 

		

		if(isset($enty_con)) 				{$con=' and a.entry_by='.$enty_con;} 



		if(isset($item_con)) 				{$item_con=' and a.item_id='.$item_con;} 

  $sql="select 



i.item_id as item_code, 

i.item_name,

(select sum(j.item_in-j.item_ex)  from journal_item j where j.item_id=i.item_id) Current_stock,

i.item_brand,

s.sub_group_name,

i.item_location,

i.unit_name,

i.moving_status

from 

item_info i,item_sub_group s

where s.sub_group_id=i.sub_group_id  ".$item_sub_con.$con.$item_con;
	break;
	

	

case 141122:



		$report="Item Opening Report";



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 

		

		if(isset($enty_con)) 				{$con=' and a.entry_by='.$enty_con;} 



		if(isset($item_con)) 				{$item_con=' and a.item_id='.$item_con;} 



		



		if(isset($receive_status)){	$opening_con=' and a.tr_from="Opening"';}



		

		//elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		



  $sql='select ji_date,i.item_id as item_code,i.item_name,s.sub_group_name as Category,i.pack_size,i.unit_name as unit,a.item_in as `opening`,a.item_price as rate,a.tr_from as tr_type,



(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



		   



from journal_item a, item_info i, user_activity_management c , item_sub_group s 



where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id 



and a.warehouse_id="'.$_SESSION['user']['depot'].'" and a.tr_from="Opening" '.$item_con.$item_sub_con.$con.' 



order by i.item_name,i.item_id, a.ji_date ';



	break;



	



case 304:



		$report="Requisition Details Report";







		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and o.item_id='.$item_id;} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and o.req_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		



$sql='SELECT  m.req_no,m.req_date,m.need_by,s.section_name as department_name,m.req_note as requisition_from,



(select sub_group_name from item_sub_group where sub_group_id = i.sub_group_id) as category,



i.item_name,i.item_description,o.qty,o.remarks,



(select fname from user_activity_management where user_id = o.entry_by) as etnry_by,o.entry_at







FROM  requisition_order o, requisition_master m, item_info i, warehouse_section s



where o.req_no = m.req_no and i.item_id = o.item_id and s.id=m.req_for



and m.warehouse_id="'.$_SESSION['user']['depot'].'" 



'.$date_con.$item_con.$item_sub_con.' 



order by o.req_date



';



break;	



	



	



case 1020:



		$report="Warehouse Item Transection Report";



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



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		



$sql='select ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.pack_size,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,sr_no,



(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,a.entry_at,c.fname as User 



		   



from journal_item_old a, item_info i, user_activity_management c , item_sub_group s 



where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and a.item_id=i.item_id 



and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' 



order by a.id';



	break;	



	



	



case 201:



		$report="Warehouse Adjust Report";







if(isset($t_date)){$to_date=$t_date; $fr_date=$f_date; 



$date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($warehouse_id)) {$warehouse_id = $_POST['warehouse_id'];}else{$warehouse_id = $_SESSION['user']['depot'];}



		



$sql="select j.ji_date as date,concat('C-',i.item_id)as item_id,s.sub_group_name as category,i.finish_goods_code as fg_code,i.item_name,j.warehouse_id,i.f_price as cost_price,



j.item_in,(i.f_price*j.item_in) as in_total,



j.item_ex as item_out,(i.f_price*j.item_ex) as out_total,



(i.f_price*(j.item_ex-j.item_in)) as total_amount







FROM  journal_item j, item_info i, item_sub_group s



WHERE j.item_id=i.item_id and i.sub_group_id = s.sub_group_id



AND j.warehouse_id = '".$warehouse_id."' 



".$date_con."



AND j.tr_from LIKE  '%Adj%'



order by i.sub_group_id,i.item_id



";







break;	



	



	



case 601: // user wise entry status report



		$report="User wise entry status report";



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



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.entry_at between \''.$fr_date.'\' and \''.$to_date.' 23:59:59\'';}







		



$sql='



select 



c.fname as User,a.tr_from as type,count(id) as total_entry



from journal_item a, user_activity_management c



where 



c.user_id=a.entry_by 



and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.' 



group by User,type



';







break;	



	







case 302: // Purchase Receive with Vendor



		$report="Purchase Receive Details Report";



		//if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and i.item_id='.$item_id;} 



		



	



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and pr.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		



$sql='SELECT 



v.vendor_name,pr.po_no,pr.pr_no,pr.rec_date,i.item_name,s.sub_group_name as Category,i.unit_name as unit,



pr.qty,pr.rate,pr.amount



FROM  purchase_receive pr,vendor v,item_info i,item_sub_group s



WHERE  



pr.vendor_id=v.vendor_id



and pr.item_id=i.item_id 



and s.sub_group_id=i.sub_group_id



and pr.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$item_con.$item_sub_con.'



order by pr.po_no';







break;











	



	



	case 1199:



		$report="Import Item Receive Report";



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and i.item_id='.$item_id;} 



		



		$status_con=' and a.receive_type="Import"';



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.or_date between \''.$fr_date.'\' and \''.$to_date.'\'';}











$sql='select b.id,a.or_no,a.or_date,a.origin,a.lc_no,s.sub_group_name as Category,concat("C-",i.item_id) as item_id,i.item_name,i.unit_name as unit,b.qty as `IN`, b.rate as rate,((b.qty)*b.rate) as amount,a.receive_type as tr_type,a.entry_at,c.fname as User 



		   



from warehouse_other_receive a, warehouse_other_receive_detail b, item_info i, user_activity_management c , item_sub_group s 



where c.user_id=a.entry_by and a.or_no=b.or_no and s.sub_group_id=i.sub_group_id and



b.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" 



'.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' 



order by a.or_no';



	



break;





case 101022:



		$report="Purchase Requisition in Details";

		break;

		

		case 11022:



		$report="Purchase Requisition Summary";

		break;

		

		 case 51122: 



		$report="Monthly Item OUT Summary Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='')			{$item_con=' and i.item_id='.$_POST['item_id'];} 

		if($_POST['trans_name']!='')			{$trans_con=' and o.use_for like "%'.$_POST['trans_name'].'%"';} 



		if(isset($receive_status)) 			{$status_con=' and j.tr_from="'.$receive_status.'"';} 



		elseif(isset($issue_status)) 		{$status_con=' and j.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and j.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}



		







	break;
	
	 case 9423: 



		$report="Monthly Automobile wise Issue Summary Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='')			{$item_con=' and i.item_id='.$_POST['item_id'];} 

		if($_POST['trans_name']!='')			{$trans_con=' and o.use_for like "%'.$_POST['trans_name'].'%"';} 



		//if(isset($receive_status)) 			{$status_con=' and j.tr_from="'.$receive_status.'"';} 



		//elseif(isset($issue_status)) 		{$status_con=' and j.tr_from="'.$issue_status.'"';} 


		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and o.oi_date between "'.$fr_date.'" and "'.$to_date.'"';}




	break;


	

	 case 61122: 



		$report="Monthly Item IN Summary Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='')			{$item_con=' and i.item_id='.$_POST['item_id'];} 



		if(isset($receive_status)) 			{$status_con=' and j.tr_from="'.$receive_status.'"';} 



		elseif(isset($issue_status)) 		{$status_con=' and j.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and j.ji_date <="'.$to_date.'"';}



		







	break;

	 case 10423: 



		$report="Monthly Automobile Wise Receive Summary Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='')			{$item_con=' and i.item_id='.$_POST['item_id'];} 



		if(isset($receive_status)) 			{$status_con=' and j.tr_from="'.$receive_status.'"';} 



		elseif(isset($issue_status)) 		{$status_con=' and j.tr_from="'.$issue_status.'"';} 


		if($_POST['trans_name']!='')			{$trans_con=' and o.use_for like "%'.$_POST['trans_name'].'%"';} 
		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and j.ji_date <="'.$to_date.'"';}



		







	break;
	
	 case 24523: 



		$report="Monthly Payloader Wise Issue Summary Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='')			{$item_con=' and i.item_id='.$_POST['item_id'];} 

		if($_POST['trans_name']!='')			{$trans_con=' and o.use_for like "%'.$_POST['trans_name'].'%"';} 



		//if(isset($receive_status)) 			{$status_con=' and j.tr_from="'.$receive_status.'"';} 



		//elseif(isset($issue_status)) 		{$status_con=' and j.tr_from="'.$issue_status.'"';} 


		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and o.oi_date between "'.$fr_date.'" and "'.$to_date.'"';}


		







	break;
	 case 25523: 



		$report="Monthly Packer Wise Issue Summary Report";

if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='')			{$item_con=' and i.item_id='.$_POST['item_id'];} 

		if($_POST['trans_name']!='')			{$trans_con=' and o.use_for like "%'.$_POST['trans_name'].'%"';} 



		//if(isset($receive_status)) 			{$status_con=' and j.tr_from="'.$receive_status.'"';} 



		//elseif(isset($issue_status)) 		{$status_con=' and j.tr_from="'.$issue_status.'"';} 


		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and o.oi_date between "'.$fr_date.'" and "'.$to_date.'"';}



	break;
	 case 250523:



		$report="Monthly E-Crane Wise Issue Summary Report";

if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='')			{$item_con=' and i.item_id='.$_POST['item_id'];} 

		if($_POST['trans_name']!='')			{$trans_con=' and o.use_for like "%'.$_POST['trans_name'].'%"';} 



		//if(isset($receive_status)) 			{$status_con=' and j.tr_from="'.$receive_status.'"';} 



		//elseif(isset($issue_status)) 		{$status_con=' and j.tr_from="'.$issue_status.'"';} 


		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and o.oi_date between "'.$fr_date.'" and "'.$to_date.'"';}


	break;
	
	
	 case 23523: 
	 
	 $issue_type=$_POST['trans_name'];
	 
	 $keyword1="Payloader"; $keyword2="Packer"; $keyword3="E-Crane"; $keyword4="Mechanical"; $keyword10="Workshop";$keyword5="Electrical";$keyword6="Truck";$keyword7="Dinajpur";
	 $keyword8="Vacuum";$keyword9="Compressor";
	 
	if (stripos($issue_type, $keyword1) !== false){
	  $issue_type="Payloader";
	 }elseif (stripos($issue_type, $keyword2) !== false){
	 
	   $issue_type="Packer";
	 }elseif (stripos($issue_type, $keyword3) !== false){
	 
	   $issue_type="E-Crane";
	 }elseif (stripos($issue_type, $keyword4) !== false){
	 
	   $issue_type="Mechanical";
	 }elseif (stripos($issue_type, $keyword5) !== false){
	 
	   $issue_type="Electrical";
	 }elseif (stripos($issue_type, $keyword6) !== false){
	 
	   $issue_type="All Truck";
	 }elseif (stripos($issue_type, $keyword7) !== false){
	 
	   $issue_type="Dinajpur";
	 }elseif (stripos($issue_type, $keyword8) !== false){
	 
	   $issue_type="Vacuum";
	 }elseif (stripos($issue_type, $keyword9) !== false){
	 
	   $issue_type="Compressor";
	 }elseif (stripos($issue_type, $keyword10) !== false){
	 
	   $issue_type="Mechanical Workshop";
	 }


		$report="Monthly ".$issue_type."  Issue Summary Report";

if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='')			{$item_con=' and i.item_id='.$_POST['item_id'];} 

		if($_POST['trans_name']!='')			{$trans_con=' and o.use_for like "%'.$_POST['trans_name'].'%"';} 



		//if(isset($receive_status)) 			{$status_con=' and j.tr_from="'.$receive_status.'"';} 



		//elseif(isset($issue_status)) 		{$status_con=' and j.tr_from="'.$issue_status.'"';} 


		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and o.oi_date between "'.$fr_date.'" and "'.$to_date.'"';}


	break;


	

	 case 110123: 



		$report="Monthly Workshop Services Expenses Report";



		



		if($_POST['item_id']!='')			{$item_con=' and w.item_id='.$_POST['item_id'];} 

		

		if($_POST['trans_name']!='')			{$trans_con=' and m.transport_name like "%'.$_POST['trans_name'].'%"';}



		

		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and d.ws_date between "'.$fr_date.'" and "'.$to_date.'"';}



		







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



	 concat("C-",a.item_id) as item_id,



	 i.item_name,



	 s.sub_group_name as Category,



	 i.unit_name as unit,



	 sum(a.item_in) as total_qty,



	 (sum(a.item_in*a.item_price)/sum(a.item_in)) as rate,



	 sum(a.item_in*a.item_price) as amount



		   



		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



		    a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by a.item_id order by a.id';



break;











case 1019:



		$report="Warehouse Advance Purchase Report";



		



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 







		$status_con=' and a.tr_from in ("Purchase","Local Purchase","Import")';



if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		



$sql='select 



	 concat("C-",a.item_id) as item_id,



	 i.item_name,



	 s.sub_group_name as Category,



	 i.unit_name as unit,



	 sum(a.item_in) as total_qty,



	 (sum(a.item_in*a.item_price)/sum(a.item_in)) as rate,



	 sum(a.item_in*a.item_price) as amount



		   



		   from journal_item_old a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



		    a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by a.item_id order by a.id';



break;











	



case 301: // Production Receive Brief



		$report="Production Delivery Brief Report";



		



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



		







		$status_con=' and a.tr_from in ("Receive")';







		



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		



$sql='select i.finish_goods_code as code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,



sum(a.item_in) as total_pcs,



(sum(a.item_in) DIV i.pack_size) as CTN,



(sum(a.item_in) MOD i.pack_size) as Pcs











from journal_item a, item_info i, user_activity_management c , item_sub_group s 



where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



a.item_id=i.item_id 



and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' 



group by a.item_id order by a.id';



				



break;



	



case 1011:



		$report="Purchase Report(Without Import Item)";



		



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 







		$status_con=' and a.tr_from in ("Purchase","Local Purchase")';







		



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







		



		 $sql='select 



	 concat("C-",a.item_id) as item_id,



	 i.item_name,



	 s.sub_group_name as Category,



	 i.unit_name as unit,



	 sum(a.item_in) as `total_qty`,



	 (sum(a.item_in*a.item_price)/sum(a.item_in)) as rate,



	 sum(a.item_in*a.item_price) as amount



		   



		   from journal_item a, item_info i, user_activity_management c , item_sub_group s where c.user_id=a.entry_by and s.sub_group_id=i.sub_group_id and



		    a.item_id=i.item_id and a.warehouse_id="'.$_SESSION['user']['depot'].'" '.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' group by a.item_id order by a.id';



	break;



	











case 1010:



		$report="Other Issue Summery Report";



		



		//if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and s.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!="") 				{$item_issue=' and i.item_id='.$_POST['item_id'];} 

		if($_POST['trans_name']!="") 				{$trans_issue=' and w.use_for LIKE "%'.$_POST['trans_name'].'%"';} 



		



		//$status_con=' and a.tr_from in ("Other Issue")';



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}











  $sql='SELECT w.oi_date as issue_date, w.oi_no as issue_no, w.use_for as transport_name,w.item_id,i.item_name,i.unit_name,s.sub_group_name as category,w.qty as qty,



(SELECT rate FROM  purchase_receive WHERE item_id =w.item_id order by rec_date desc limit 1)as rate,







(SELECT rate FROM  purchase_receive WHERE item_id =w.item_id order by rec_date desc limit 1) * w.qty as amount







FROM  



warehouse_other_issue_detail w, warehouse_other_issue m , item_info i,item_sub_group s



WHERE



w.item_id = i.item_id  and w.oi_no=m.oi_no



AND i.sub_group_id=s.sub_group_id



AND  w.oi_date BETWEEN "'.$f_date.'" and "'.$t_date.'"



AND w.issue_type = "Other Issue"



AND  w.warehouse_id = "'.$_SESSION['user']['depot'].'"



'.$item_issue.$item_sub_con.$trans_issue.'



GROUP BY w.id ORDER BY w.oi_date



';



break;

case 13723:



		$report="Gift Issue Summery Report";



		



		//if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and s.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!="") 				{$item_issue=' and i.item_id='.$_POST['item_id'];} 

		if($_POST['trans_name']!="") 				{$trans_issue=' and w.use_for LIKE "%'.$_POST['trans_name'].'%"';} 



		



		//$status_con=' and a.tr_from in ("Other Issue")';



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}











   $sql='SELECT w.oi_date as issue_date, w.oi_no as issue_no, m.oi_subject as issue_to,m.issued_to as gifted_to,w.item_id,i.item_name,i.unit_name,s.sub_group_name as category,w.qty as qty,



(SELECT rate FROM  purchase_receive WHERE item_id =w.item_id order by rec_date desc limit 1)as rate,







(SELECT rate FROM  purchase_receive WHERE item_id =w.item_id order by rec_date desc limit 1) * w.qty as amount







FROM  



warehouse_other_issue_detail w, warehouse_other_issue m , item_info i,item_sub_group s



WHERE



w.item_id = i.item_id  and w.oi_no=m.oi_no



AND i.sub_group_id=s.sub_group_id



AND  w.oi_date BETWEEN "'.$f_date.'" and "'.$t_date.'"



AND w.issue_type = "Gift Issue"



AND  w.warehouse_id = "'.$_SESSION['user']['depot'].'"



'.$item_issue.$item_sub_con.$trans_issue.'



GROUP BY w.id ORDER BY w.oi_date



';



break;




case 90123:



		$report="Workshop Services Expense Report";



		

		if($_POST['trans_name']!="") 				{$trans_issue=' and m.transport_name LIKE "%'.$_POST['trans_name'].'%"';} 



		



		//$status_con=' and a.tr_from in ("Other Issue")';



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and d.ws_date between \''.$fr_date.'\' and \''.$to_date.'\'';}











  $sql='SELECT m.ws_date, d.ws_no, v.vendor_name,m.transport_name,i.ws_name,i.unit_name,d.qty as qty,d.rate as rate,d.amount











FROM  



workshop_expense_detail d, workshop_expense_master m , workshop_services i,workshop_services_vendor v



WHERE



d.item_id = i.id  and d.ws_no=m.ws_no



AND v.vendor_id=m.vendor_id



AND  m.ws_date BETWEEN "'.$f_date.'" and "'.$t_date.'"





'.$item_issue.$item_sub_con.$trans_issue.$date_con.'



GROUP BY d.id ORDER BY d.ws_date



';



break;



case 291022:



		$report="Other Receive Summery Report";



$target_url = '../other_receive/or_receive_report.php';







if($_REQUEST[$unique]>0)



{



$_SESSION[$unique] = $_REQUEST[$unique];



header('location:'.$target_url);



}

		



		//if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and s.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!="") 				{$item_con=' and i.item_id='.$_POST['item_id'];} 



		



		//$status_con=' and a.tr_from in ("Other Issue")';



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}











 $sql='



SELECT m.or_no,w.or_date as receive_date,m.or_subject as mrr_no,



w.item_id,



i.item_name,i.unit_name,



s.sub_group_name as category,



sum(w.qty) as qty,



w.rate, w.labour_bill,w.transport_bill,



(w.rate* w.qty) as amount,w.remarks,



u.fname as entry_by,



m.vendor_name as received_from



FROM  



warehouse_other_receive_detail w, item_info i,item_sub_group s, user_activity_management u,warehouse_other_receive m



WHERE



w.item_id = i.item_id 



AND i.sub_group_id=s.sub_group_id



AND  w.or_date BETWEEN "'.$f_date.'" and "'.$t_date.'"



AND w.receive_type = "Other Receive"



AND  w.warehouse_id = "'.$_SESSION['user']['depot'].'" and m.entry_by=u.user_id and m.or_no=w.or_no



'.$item_con.$item_sub_con.'



GROUP BY w.item_id ORDER BY s.sub_group_name';



//echo link_report($sqlor,'../other_receive/or_receive_report.php');



break;









case 1018:







		$report="Sample Issue Details Report";



		 



		if(isset($sub_group_id)) 				{$item_sub_con=' and s.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and i.item_id='.$item_id;} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







$sql='



SELECT w.oi_no as no,w.oi_date,i.finish_goods_code as code,i.item_name,w.issued_to,w.issue_type,w.qty



FROM  warehouse_other_issue_detail w,item_info i



WHERE  



i.item_id=w.item_id



and issue_type ="Sample Issue"



AND  w.warehouse_id = "'.$_SESSION['user']['depot'].'"



and i.finish_goods_code>0



AND  w.oi_date BETWEEN "'.$f_date.'" and "'.$t_date.'"



'.$item_con.'



order by w.oi_date



';







break;











case 1013:







$report="Export Issue Summery Report";



		



		//if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and s.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and i.item_id='.$item_id;} 



		



		//$status_con=' and a.tr_from in ("Other Issue")';



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}











$sql='



SELECT 



w.item_id,



i.finish_goods_code as code,



i.item_name,i.unit_name,







		(sum(w.qty) DIV i.pack_size) as CTN,



		(sum(w.qty) MOD i.pack_size) as Pcs,



		sum(w.qty) as Total_qty







FROM warehouse_other_issue_detail w, item_info i



WHERE



w.item_id = i.item_id



AND  w.oi_date BETWEEN "'.$f_date.'" and "'.$t_date.'"



AND w.issue_type = "Export"



AND  w.warehouse_id = "'.$_SESSION['user']['depot'].'"



'.$item_con.$item_sub_con.'







GROUP BY w.item_id 



ORDER BY code



';



break;







case 1014:







$report="Export Issue Details Report";



		



		//if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and s.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and i.item_id='.$item_id;} 



		



		//$status_con=' and a.tr_from in ("Other Issue")';



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}











$sql='



SELECT 



w.oi_date as date,w.oi_no as issue_no,



i.finish_goods_code as code,



i.item_name,w.id as bin_tr_no,



i.unit_name,







		(w.qty DIV i.pack_size) as CTN,



		(w.qty MOD i.pack_size) as Pcs,



		w.qty as Total_qty







FROM warehouse_other_issue_detail w, item_info i



WHERE



w.item_id = i.item_id



AND  w.oi_date BETWEEN "'.$f_date.'" and "'.$t_date.'"



AND w.issue_type = "Export"



AND  w.warehouse_id = "'.$_SESSION['user']['depot'].'"



'.$item_con.$item_sub_con.'



ORDER BY issue_no



';



break;











case 1021:







$report="Direct Sales Report";



		



		//if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and s.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and i.item_id='.$item_id;} 



		if(isset($issued_to)) 					{$issued_to_con=' and d.dealer_code='.$issued_to;}



		



		//$status_con=' and a.tr_from in ("Other Issue")';



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}











$sql='SELECT 



w.oi_date as date,w.oi_no as issue_no,w.issued_to as dealer_code,d.dealer_name_e as party,



i.finish_goods_code as code,



i.item_name,w.id as bin_tr_no,



i.unit_name,



(w.qty DIV i.pack_size) as CTN,



(w.qty MOD i.pack_size) as Pcs,



w.qty as Total_qty,w.rate,w.amount







FROM warehouse_other_issue_detail w, item_info i, dealer_info d



WHERE w.item_id = i.item_id



AND d.dealer_code = w.issued_to



AND  w.oi_date BETWEEN "'.$f_date.'" and "'.$t_date.'"



AND w.issue_type = "Direct Sales"



AND  w.warehouse_id = "'.$_SESSION['user']['depot'].'"



'.$item_con.$item_sub_con.$issued_to_con.'



ORDER BY w.issued_to,issue_no



';



break;







	



    case 2:



		$report="Current Stock Report(Closing)";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='')			{$item_con=' and i.item_id='.$_POST['item_id'];} 



		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}



		







	break;

	

	

	 case 71122:



		$report="Date Wise Stock Report(Closing)";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		if($_POST['item_id']!='') 			{$item_con=' and i.item_id='.$_POST['item_id'];} 



		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}



		







	break;



	    case 9:



		$report="Sajeeb Lebour Bill";







		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}



		







	break;



	    



		



		



    case 3:



		$report="Warehouse and PL Closing Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}



		







	break;



	



    case 225:



		$report="Cold Storage Closing Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}



		







	break;	



	



    case 111:



		$report="Warehouse and PL Closing Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 			{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 			{$item_con=' and i.item_id='.$item_id;} 



		if(isset($receive_status)) 			{$status_con=' and a.tr_from="'.$receive_status.'"';} 



		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date <="'.$to_date.'"';}



		







	break;	



	



    	case 4:



		$report="Warehouse Stock Position Report(Closing)(Finish Goods)";



				if(isset($warehouse_id)) 			{$warehouse_con=' and a.warehouse_id='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



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







		



$sql='select 



		m.pi_no,



		a.ji_date,



		w.warehouse_name  as warehouse,



		i.item_brand as brand,



		a.sr_no,



		i.finish_goods_code as fg,



		i.item_name,



		i.pack_size,



		i.unit_name as unit,



		a.item_ex as qty,



		d.unit_price ,



		(a.item_ex*d.unit_price) as Amount



		from journal_item a, item_info i, user_activity_management c, warehouse w, production_issue_master m, production_issue_detail d  where 







		w.use_type!="PL" and a.item_ex>0 and a.warehouse_id='.$_SESSION['user']['depot'].' and 



		d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse and (a.tr_from="Issue" OR a.tr_from="Transfered" OR a.tr_from="Transit") and 



		c.user_id=a.entry_by and a.item_id=i.item_id '.$date_con.$warehouse_con.$item_con.$item_brand_con.' group by d.id order by a.ji_date';



		



		break;



		



		



		



case 51:



		$report="Damage Sales Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and w.warehouse_id='.$warehouse_id;} 



		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 



		if(isset($t_date)) 		{$to_date=$t_date; $fr_date=$f_date; 



		$date_con=' and d.oi_date between "'.$fr_date.'" and "'.$to_date.'"';}



		



$sql='SELECT 



w.warehouse_name,m.issued_to as party,d.oi_date,d.oi_no,i.item_name,i.pack_unit,d.qty,d.rate,d.amount



FROM  



warehouse_other_issue_detail d,warehouse_other_issue m, warehouse w, item_info i



where



d.oi_no = m.oi_no



and d.item_id = i.item_id



and m.warehouse_id = w.warehouse_id



'.$date_con.$warehouse_con.$item_con.'



and m.issue_type = "Damage Sales"';	



break;











case 52:



		$report="Damage Sales Report (Brief)";



		if(isset($warehouse_id)) 			{$warehouse_con=' and w.warehouse_id='.$warehouse_id;} 



		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 



		if(isset($t_date)) 		{$to_date=$t_date; $fr_date=$f_date; 



		$date_con=' and d.oi_date between "'.$fr_date.'" and "'.$to_date.'"';}



		



$sql='SELECT i.item_name,i.pack_unit,sum(d.qty) as total_qty,(sum(d.amount)/sum(d.qty)) as avg_rate,sum(d.amount) as amount



FROM  



warehouse_other_issue_detail d,warehouse_other_issue m, warehouse w, item_info i



where



d.oi_no = m.oi_no



and d.item_id = i.item_id



and m.warehouse_id = w.warehouse_id



'.$date_con.$warehouse_con.$item_con.'



and m.issue_type = "Damage Sales"



group by i.item_name



';	



break;











case 53:



		$report="Chalan wise Damage Sales Report";



		if(isset($warehouse_id)) 			{$warehouse_con=' and w.warehouse_id='.$warehouse_id;} 



		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 



		if(isset($t_date)) 		{$to_date=$t_date; $fr_date=$f_date; 



		$date_con=' and d.oi_date between "'.$fr_date.'" and "'.$to_date.'"';}



		



$sql='SELECT 



d.oi_date,d.oi_no,w.warehouse_name,m.issued_to as party,sum(d.amount) as amount



FROM  



warehouse_other_issue_detail d,warehouse_other_issue m, warehouse w, item_info i



where



d.oi_no = m.oi_no



and d.item_id = i.item_id



and m.warehouse_id = w.warehouse_id



'.$date_con.$warehouse_con.$item_con.'



and m.issue_type = "Damage Sales"



group by m.oi_no



';



		



break;



		



case 6:



		$report="Issue Report(Brief)";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;}  



		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 







		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}







		



$sql='select 



		



		i.finish_goods_code as fg,



		i.item_name,i.sales_item_type as grp,



		i.pack_size,



		i.unit_name as unit,



		i.item_brand as brand,



		(sum(a.item_ex) DIV i.pack_size) as CTN,



		(sum(a.item_ex) MOD i.pack_size) as Pcs,



		sum(a.item_ex) as Total_qty,



		



		sum(a.item_ex*a.item_price) as Amt



		



		from journal_item a, item_info i,warehouse w  



		



		where w.use_type!="PL" 



		and a.item_id=i.item_id



		and a.item_ex>0



		and a.warehouse_id='.$_SESSION['user']['depot'].'



		and w.warehouse_id=a.warehouse_id 



		and (a.tr_from="Transfered" OR a.tr_from="Transit")



		



		'.$date_con.$warehouse_con.$item_con.$item_brand_con.' 



		



		group by  a.item_id 



		order by i.finish_goods_code';







/*		i.f_price as Cost_Price,



		sum(a.item_ex*i.f_price) as cost_Amt,



		i.d_price as DP_Price,



		*/



		



break;







case 10:



		$report="Sales Report-2017(Brief)";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;}  



		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 







		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}







		



$sql='select 



		



		i.finish_goods_code as fg,



		i.item_name,i.sales_item_type as grp,



		i.pack_size,



		i.unit_name as unit,



		i.item_brand as brand,



		(sum(a.item_ex) DIV i.pack_size) as CTN,



		(sum(a.item_ex) MOD i.pack_size) as Pcs,



		sum(a.item_ex) as Total_qty,



		



		sum(a.item_ex*a.item_price) as Amt



		



		from journal_item_old a, item_info i,warehouse w  



		



		where w.use_type!="PL" 



		and a.item_id=i.item_id



		and a.item_ex>0



		and a.warehouse_id='.$_SESSION['user']['depot'].'



		and w.warehouse_id=a.warehouse_id 



		and (a.tr_from="Transfered" OR a.tr_from="Transit")



		



		'.$date_con.$warehouse_con.$item_con.$item_brand_con.' 



		



		group by  a.item_id 



		order by i.finish_goods_code';







/*		i.f_price as Cost_Price,



		sum(a.item_ex*i.f_price) as cost_Amt,



		i.d_price as DP_Price,



		*/



		



break;



		



// HFL Labout Bill report



case 8:



		$report="HFL Labour Bill(Loading)";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;}  



		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}







$sql='select 



		i.finish_goods_code as fg,i.item_name,i.item_brand as brand,i.pack_size,i.unit_name as unit,



		(sum(a.item_ex) DIV i.pack_size) as CTN,



		i.hfl_labour_rate as rate,



		((sum(a.item_ex) DIV i.pack_size)*i.hfl_labour_rate) as total_bill







from journal_item a, item_info i, user_activity_management c,warehouse w  



		



where w.use_type!="PL" and a.item_ex>0 and a.warehouse_id='.$_SESSION['user']['depot'].' 



and w.warehouse_id=a.warehouse_id 



and (a.tr_from="Transfered" OR a.tr_from="Transit") and c.user_id=a.entry_by 



and a.item_id=i.item_id'.$date_con.$warehouse_con.$item_con.$item_brand_con.' 



group by a.item_id order by i.finish_goods_code';



		







break;



		



		



		case 7:



		$report="Chalan Wise Sales Report";



		if(isset($warehouse_id)) 			{$con.=' and m.warehouse_to='.$warehouse_id;}







		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $con.=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}







		$sql='select 



m.pi_no, m.pi_date,  w.warehouse_name as Depot, m.remarks as sl_no, m.carried_by,



		sum(a.item_in*d.unit_price) as amt,sum(a.item_in*i.d_price) as present_DP_amt



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



		







		



		 $sql='select a.entry_at,ji_date,i.item_id,i.finish_goods_code as fg_code,i.item_name,s.sub_group_name as Category,i.unit_name as unit,a.item_in as `IN`,a.item_ex as `OUT`,a.item_price as rate,((a.item_in+a.item_ex)*a.item_price) as amount,a.tr_from as tr_type,sr_no,(select warehouse_name from warehouse where warehouse_id=a.relevant_warehouse) as warehouse,a.tr_no,c.fname as User ," " as Line_Manager



		   



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



//{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.pi_date between "'.$fr_date.'" and "'.$to_date.'"';}



		



		$sql='select 



		m.pi_no,



		a.ji_date,



		w.warehouse_name  as warehouse,



		i.item_brand as brand,



		a.sr_no,



		i.finish_goods_code as fg,



		i.item_name,



		i.unit_name as unit,



		



		(sum(a.item_in) DIV i.pack_size) as CTN,



		(sum(a.item_in) MOD i.pack_size) as Pcs,



		



		d.unit_price as unit_price,



		(a.item_in*d.unit_price) as total_amt



from journal_item a, item_info i,warehouse w,production_issue_master m,production_issue_detail d  







where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' 



and d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse 



and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") 



and a.item_id=i.item_id



'.$date_con.$warehouse_con.$item_con.$item_brand_con.' 



group by d.id order by a.ji_date';



		



		break;



		



		case 502:



		$report="Receive Report(Brief)";



		if(isset($warehouse_id)) 			{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($item_brand)) 				{$item_brand_con=' and i.item_brand='.$item_brand;} 



		if(isset($item_id)) 			    {$item_con=' and a.item_id='.$item_id;} 







		



		if(isset($t_date)) 



{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}







$sql='select 



		i.item_brand as brand,



		i.finish_goods_code as fg,



		i.item_name,



		i.unit_name as unit,



		(sum(a.item_in) DIV i.pack_size) as CTN,



		(sum(a.item_in) MOD i.pack_size) as Pcs,



		avg(d.unit_price) as avg_price,



		(sum(a.item_in*d.unit_price)) as total_amt







from journal_item a, item_info i,production_issue_master m,production_issue_detail d  where a.item_in>0 



and a.warehouse_id='.$_SESSION['user']['depot'].' and d.id=a.tr_no and d.pi_no=m.pi_no 



and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") 



and a.item_id=i.item_id 



'.$warehouse_con.$date_con.$item_con.$item_brand_con.' 



group by i.item_id order by a.ji_date';







break;



		



		



case 503:



		$report="PR Wise Receive Report";



		if(isset($warehouse_id)) 			{$con.=' and a.relevant_warehouse='.$warehouse_id;} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between "'.$fr_date.'" and "'.$to_date.'"';}







$sql='select 



m.pi_no,m.rec_sl_no, m.pi_date,  w.warehouse_name as Depot, m.remarks as sl_no, m.carried_by,



sum(a.item_in*d.unit_price) as amt



from journal_item a, item_info i,warehouse w,production_issue_master m,production_issue_detail d  







where a.item_in>0 and a.warehouse_id='.$_SESSION['user']['depot'].' 



and d.id=a.tr_no and d.pi_no=m.pi_no and w.warehouse_id=a.relevant_warehouse 



and (a.tr_from="Issue" or a.tr_from="Transfered" or a.tr_from="Transit") 



and a.item_id=i.item_id



'.$con.$date_con.' 



group by d.pi_no order by m.pi_date';



				







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



.style1 {color: #FF0000}



</style>



<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



function custom(theUrl)



{



	window.open('<?=$target_url?>?v_no='+theUrl);



}











</script>





</head>



<body>



<div align="center" id="pr">



  <input type="button" value="Print" onclick="hide();window.print();"/>



</div>



<div class="main">



<?



		$str 	.= '<div class="header">';

		

		$str 	.= '<img src="<?=SERVER_ROOT?>public/uploads/logo/OCL_HEADER2.png" style="height:100px; width:800px;" />';



		//$str 	.= '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



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



		$str 	.= '<p>Item Name: '.$client_name.'</p>';



		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';



		



		



if($_POST['report']==2) 



{

$current_date=date("Y-m-d");



  $sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,a.item_price,sum(a.item_in) as received, sum(a.item_ex) as issued,



sum(a.item_in-a.item_ex) as final_stock,sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price







from item_info i, item_sub_group s,journal_item a 



where a.warehouse_id="'.$_SESSION['user']['depot'].'" and  



i.item_id = a.item_id and i.sub_group_id=s.sub_group_id and a.ji_date<="'.$current_date.'" 



'.$item_sub_con.$item_con.' 



group by i.item_id 



order by i.finish_goods_code,s.sub_group_name,i.item_name';



		   



$query =db_query($sql3);   



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="11"><div class="header">



          <h1>Olympic Cement Limited</h1>



          <h2>



            <?=$report?>



          </h2>



          <h2>Closing Stock of Date-



            <?=$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>



     



      <th>Item Code</th>



      <th>Item Group</th>



     



      <th>Item Name</th>

	  <th>Item Location</th>



      <th>Unit</th>



      <th>Received</th>

	  

	  <th>Issued</th>

	  

	  <th>Final Stock</th>



      <th>Rate</th>



      <th>Stock Price</th>



    </tr>



  </thead>



  <tbody>



    <?



while($data=mysqli_fetch_object($query)){







$j++;



$amt = $data->final_stock*$data->item_price;



$total_amt = $total_amt + $amt;



		   ?>



    <tr>



      <td><?=$j?></td>



      



      <td><?=$data->item_id?></td>



      <td><?=$data->sub_group_name?></td>



     



      <td><?=$data->item_name?></td>

	  

	  <td><?=$data->item_location;?></td>



      <td><?=$data->unit_name?></td>

	  

	   <td style="text-align:right"><? if($data->received>0) echo number_format($data->received,0); else echo '-'; $treceive+=$data->received;?></td>

	   <td style="text-align:right"><? if($data->issued>0) echo number_format($data->issued,0); else echo '-'; $tissued+=$data->issued;?></td>



      <td style="text-align:right"><? if($data->final_stock>0) echo number_format($data->final_stock,0); else echo '-'; $closing+=$data->final_stock;?></td>



      <td style="text-align:right"><?=@number_format($data->item_price,2)?></td>



      <td style="text-align:right"><?=number_format(($amt),2)?></td>



    </tr>



    <?



}



		



?>



    <tr>



      



      <td colspan="6"><strong>Total: </strong></td>

	   <td style="text-align:right"><strong><?=number_format(($treceive),0)?></strong></td>

	    <td style="text-align:right"><strong><?=number_format(($tissued),0)?></strong></td>

		 <td style="text-align:right"><strong><?=number_format(($closing),0)?></strong></td>

		  <td style="text-align:right">&nbsp;</td>



      <td style="text-align:right"><strong><?=number_format(($total_amt),2)?></strong></td>



    </tr>



  </tbody>



</table>



<?







}







if($_POST['report']==71122) 



{

$current_date=date("Y-m-d");



   $sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,a.item_price,sum(a.item_in) as received, sum(a.item_ex) as issued,



sum(a.item_in-a.item_ex)as final_stock,sum((a.item_in-a.item_ex)*(a.item_price)) as Stock_price







from item_info i, item_sub_group s,journal_item a 



where a.warehouse_id="'.$_SESSION['user']['depot'].'" and  



i.item_id = a.item_id and i.sub_group_id=s.sub_group_id



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id 



order by i.finish_goods_code,s.sub_group_name,i.item_name';



		   



$query =db_query($sql3);   



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="12"><div class="header">



          <h1>OLYMPIC CEMENT LIMITED</h1>



          <h2>



            <?=$report?>



          </h2>



          <h2>Closing Stock of Date-



            <?=$fr_date." TO ".$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>



     



      <th>Item Code</th>



      <th>Item Group</th>



     



      <th>Item Name</th>

	  

	    <th>Item Location</th>



      <th>Unit</th>

	  

	  <th>Opening</th>



      <th>IN</th>

	  

	  <th>OUT</th>

	  

	  <th>Final Stock</th>



      <th>Rate</th>



      <th>Stock Price</th>



    </tr>



  </thead>



  <tbody>



    <?



while($data=mysqli_fetch_object($query)){







$j++;



$amt = $data->final_stock*$data->item_price;



$total_amt = $total_amt + $amt;



echo $opening=find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'" and ji_date<"'.$fr_date.'"');





		   ?>



    <tr>



      <td><?=$j?></td>



      



      <td><?=$data->item_id?></td>



      <td><?=$data->sub_group_name?></td>



     



      <td><?=$data->item_name?></td>

	  

	   <td><?=$data->item_location;?></td>



      <td><?=$data->unit_name?></td>

	  

	    <td style="text-align:right"><? if($opening>0) echo number_format($opening,2); else echo '-'; $topening+=$opening;?></td>

	  

	   <td style="text-align:right"><? if($data->received>0) echo number_format($data->received,2); else echo '-'; $treceive+=$data->received;?></td>

	   <td style="text-align:right"><? if($data->issued>0) echo number_format($data->issued,2); else echo '-'; $tissued+=$data->issued;?></td>



      <td style="text-align:right"><? if($data->final_stock>0) echo number_format($data->final_stock,2); else echo '-'; $closing+=$data->final_stock;?></td>



      <td style="text-align:right"><?=@number_format($data->item_price,2)?></td>



      <td style="text-align:right"><?=number_format(($amt),2)?></td>



    </tr>



    <?



}



		



?>



    <tr>



      



      <td colspan="6"><strong>Total: </strong></td>

	  

	   <td style="text-align:right"><strong><?=number_format(($topening),2)?></strong></td>

	   <td style="text-align:right"><strong><?=number_format(($treceive),2)?></strong></td>

	    <td style="text-align:right"><strong><?=number_format(($tissued),2)?></strong></td>

		 <td style="text-align:right"><strong><?=number_format(($closing),2)?></strong></td>

		  

            <td>&nbsp;</td>

      <td style="text-align:right"><strong><?=number_format(($total_amt),2)?></strong></td>



    </tr>



  </tbody>



</table>



<?







}













// warehouse and pl closing report



elseif($_POST['report']==3) {







// mail stock



$sql1='select i.item_id as code,



sum(a.item_in-a.item_ex) as hfl_final_stock,



a.item_price as stock_price



from item_info i, item_sub_group s,journal_item a 







where a.warehouse_id="'.$_SESSION['user']['depot'].'" 



and i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id';



		   



$res = db_query($sql1);



	while($row=mysqli_fetch_object($res))



	{



		$hfl_stock[$row->code] 	= $row->hfl_final_stock;



		$rate[$row->code] 		= $row->stock_price;



	}  



	



// production line stock



$sql2='select i.item_id as code,sum(a.item_in-a.item_ex) as pl_final_stock



from item_info i, item_sub_group s,journal_item a , warehouse w







where a.warehouse_id = w.warehouse_id



and i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



and w.use_type = "PL" 



and a.warehouse_id != "'.$_SESSION['user']['depot'].'" 



and w.group_for="'.$_SESSION['user']['group'].'"



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id ';



		   



$res = db_query($sql2);



	while($row=mysqli_fetch_object($res))



	{



		$pl_stock[$row->code] = $row->pl_final_stock;



	} 







$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="9"><div class="header">



          <h1><?=$warehouse_name?></h1>



          <h2><?=$report?></h2>



          <h2>Closing Stock of Date-<?=$to_date?></h2></div>



		  <div class="left"></div><div class="right"></div><div class="date">Reporting Time:<?=date("h:i A d-m-Y")?></div></td>



    </tr> 



    <tr>



      <th>S/L</th>



      <th>Item Code</th>



      <th>Item Group</th>



      <th>Item Name</th>



      <th>Unit</th>



      <th>Main Stock</th>



	  <th>PL Stock</th>



	  <th>Total Stock</th>



      <th>Rate</th>



      <th>Amount</th>



    </tr>



  </thead>



  <tbody>







<?php



$sql3='select i.item_id as code,i.unit_name,i.item_name,s.sub_group_name



from item_info i, item_sub_group s, journal_item a, warehouse w



where 



i.sub_group_id=s.sub_group_id



and i.item_id = a.item_id



and a.warehouse_id = w.warehouse_id



and w.group_for="'.$_SESSION['user']['group'].'"



'.$item_sub_con.$item_con.' 



group by i.item_id 



order by s.sub_group_name,i.item_name';







$query = db_query($sql3);



while($data= mysqli_fetch_object($query)){ 



$j++;



?>



    <tr>



      <td><?=$j?></td>



      <td><?=$data->code?></td>



      <td><?=$data->sub_group_name?></td>



      <td><?=$data->item_name?></td>



      <td><?=$data->unit_name?></td>



      <td><?=$hfl_stock[$data->code]?></td>



	  <td><?=$pl_stock[$data->code]?></td>



	  <td><?php $total_qty=($hfl_stock[$data->code] + $pl_stock[$data->code]); echo $total_qty;?></td>



      <td><?=number_format($rate[$data->code],2);?></td>



      <td><?php $amount=($rate[$data->code]* $total_qty); echo number_format($amount,2); $gamount += $amount;?></td>



    </tr>



<? } ?>



    <tr>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td>Total: </td>



      <td><strong><?=number_format(($gamount),2)?></strong></td>



    </tr>



  </tbody>



</table>



<?







}



// end 3











// Cold storage report



elseif($_POST['report']==225) {







// item list



$sql3='select i.item_id as code,i.unit_name,i.item_name,s.sub_group_name



from item_info i, item_sub_group s, journal_item a, warehouse w



where 



i.sub_group_id=s.sub_group_id



and i.item_id = a.item_id



and a.warehouse_id = w.warehouse_id



and w.group_for="'.$_SESSION['user']['group'].'"



and w.warehouse_id in (108,109,110)



'.$item_sub_con.$item_con.' 



group by i.item_id



order by s.sub_group_name,i.item_name';







// find out item list	



$sql_item='select i.item_id



from item_info i, journal_item a, warehouse w



where i.item_id = a.item_id



and a.warehouse_id = w.warehouse_id



and w.warehouse_id in (108,109,110)



group by i.item_id';



	$qquery = db_query($sql_item);



	while($sec = mysqli_fetch_object($qquery))



	{



	if($item_list == '') $item_list .= $sec->item_id;



	else $item_list .= ','.$sec->item_id;



	}







// main stock



$sql1='select i.item_id as code,sum(a.item_in-a.item_ex) as hfl_final_stock,a.item_price as stock_price



from item_info i,journal_item a 



where a.warehouse_id="'.$_SESSION['user']['depot'].'" 



and i.item_id = a.item_id 



and i.item_id in ('.$item_list.')



'.$date_con.$item_con.' 



group by i.item_id';



		   



$res = db_query($sql1);



	while($row=mysqli_fetch_object($res))



	{



		$hfl_stock[$row->code] 	= $row->hfl_final_stock;



		$rate[$row->code] 		= $row->stock_price;



	} 



	



// production line stock



/*$sql2='select i.item_id as code,sum(a.item_in-a.item_ex) as pl_final_stock



from item_info i, item_sub_group s,journal_item a , warehouse w







where a.warehouse_id = w.warehouse_id



and i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



and w.use_type = "PL" 



and a.warehouse_id != "'.$_SESSION['user']['depot'].'" 



and w.group_for="'.$_SESSION['user']['group'].'"



and w.warehouse_id not in (108,109,110)



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id ';



		   



$res = db_query($sql2);



	while($row=mysqli_fetch_object($res))



	{



		$pl_stock[$row->code] = $row->pl_final_stock;



	}*/ 



	



// Haque Siddirganj



$sql2='select i.item_id as code,sum(a.item_in-a.item_ex) as pl_final_stock



from item_info i, item_sub_group s,journal_item a , warehouse w



where a.warehouse_id = w.warehouse_id



and i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



and a.warehouse_id != "'.$_SESSION['user']['depot'].'" 



and w.group_for="'.$_SESSION['user']['group'].'"



and w.warehouse_id in (108)



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id ';



		   



$res = db_query($sql2);



	while($row=mysqli_fetch_object($res))



	{



		$cold_haque_siddirganj[$row->code] = $row->pl_final_stock;



	} 



	



// Haque Kutubpur



$sql4='select i.item_id as code,sum(a.item_in-a.item_ex) as pl_final_stock



from item_info i, item_sub_group s,journal_item a , warehouse w



where a.warehouse_id = w.warehouse_id



and i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



and a.warehouse_id != "'.$_SESSION['user']['depot'].'" 



and w.group_for="'.$_SESSION['user']['group'].'"



and w.warehouse_id in (109)



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id ';



		   



$res = db_query($sql4);



	while($row=mysqli_fetch_object($res))



	{



		$cold_haque_kutubpur[$row->code] = $row->pl_final_stock;



	}	



	



// start multipurpose



$sql5='select i.item_id as code,sum(a.item_in-a.item_ex) as pl_final_stock



from item_info i, item_sub_group s,journal_item a , warehouse w



where a.warehouse_id = w.warehouse_id



and i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



and a.warehouse_id != "'.$_SESSION['user']['depot'].'" 



and w.group_for="'.$_SESSION['user']['group'].'"



and w.warehouse_id in (110)



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id ';



		   



$res = db_query($sql5);



	while($row=mysqli_fetch_object($res))



	{



		$cold_star[$row->code] = $row->pl_final_stock;



	}	



	



		







$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="11"><div class="header">



          <h1><?=$warehouse_name?></h1>



          <h2><?=$report?></h2>



          <h2>Closing Stock of Date-<?=$to_date?></h2></div>



		  <div class="left"></div><div class="right"></div><div class="date">Reporting Time:<?=date("h:i A d-m-Y")?></div></td>



    </tr> 



    <tr>



      <th>S/L</th>



      <th>Item Code</th>



      <th>Item Group</th>



      <th>Item Name</th>



      <th>Unit</th>



      <th>Store</th>



      <th>Siddirganj</th>



      <th>Kutubpur</th>



	  <th>Star</th>



	  <th>Total Stock</th>



    </tr>



  </thead>



  <tbody>







<?php 



$query = db_query($sql3);



while($data= mysqli_fetch_object($query)){ 



$j++;



?>



    <tr>



      <td><?=$j?></td>



      <td><?=$data->code?></td>



      <td><?=$data->sub_group_name?></td>



      <td><?=$data->item_name?></td>



      <td><?=$data->unit_name?></td>



      <td><?=(int)$hfl_stock[$data->code]?></td>



      <td><?=(int)$cold_haque_siddirganj[$data->code]?></td>



      <td><?=(int)$cold_haque_kutubpur[$data->code]?></td>



	  <td><?=(int)$cold_star[$data->code]?></td>



	  <td><?php $total_qty=($hfl_stock[$data->code]+ $cold_haque_siddirganj[$data->code] + $cold_haque_kutubpur[$data->code]+ $cold_star[$data->code]); 



	  echo $total_qty;?></td>



    </tr>



<? } ?>



<!--    <tr>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



      <td></td>



    </tr>-->



  </tbody>



</table>



<?







}



// end 225











// warehouse and pl wise closing report



elseif($_POST['report']==111) {







// mail stock



$sql1='select i.item_id as code,



sum(a.item_in-a.item_ex) as hfl_final_stock,



a.item_price as stock_price



from item_info i, item_sub_group s,journal_item a 







where a.warehouse_id="'.$_SESSION['user']['depot'].'" 



and i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id';



		   



$res = db_query($sql1);



	while($row=mysqli_fetch_object($res))



	{



		$hfl_stock[$row->code] 	= $row->hfl_final_stock;



		$rate[$row->code] 		= $row->stock_price;



	}  



	



// Floor Stock



$sql2='select i.item_id as code,sum(a.item_in-a.item_ex) as pl_final_stock



from item_info i, item_sub_group s,journal_item a







where i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



and a.warehouse_id = 81 



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id ';



		   



$res = db_query($sql2);



	while($row=mysqli_fetch_object($res))



	{



		$pl_stock[$row->code] = $row->pl_final_stock;



	} 



	



// SILO 1



$sql3='select i.item_id as code,sum(a.item_in-a.item_ex) as pl_final_stock



from item_info i, item_sub_group s,journal_item a







where i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



and a.warehouse_id = 105 



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id ';



		   



$res = db_query($sql3);



	while($row=mysqli_fetch_object($res))



	{



		$silo1_stock[$row->code] = $row->pl_final_stock;



	}	



	



// SILO 2



$sql3='select i.item_id as code,sum(a.item_in-a.item_ex) as pl_final_stock



from item_info i, item_sub_group s,journal_item a







where i.item_id = a.item_id 



and i.sub_group_id=s.sub_group_id



and a.warehouse_id = 106



'.$item_sub_con.$date_con.$item_con.' 



group by i.item_id ';



		   



$res = db_query($sql3);



	while($row=mysqli_fetch_object($res))



	{



		$silo2_stock[$row->code] = $row->pl_final_stock;



	}	







$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="9"><div class="header">



          <h1><?=$warehouse_name?></h1>



          <h2><?=$report?></h2>



          <h2>Closing Stock of Date-<?=$to_date?></h2></div>



		  <div class="left"></div><div class="right"></div><div class="date">Reporting Time:<?=date("h:i A d-m-Y")?></div></td>



    </tr> 



    <tr>



      <th>S/L</th>



      <th>Item Code</th>



      <th>Item Group</th>



      <th>Item Name</th>



      <th>Unit</th>



      <th>Warehouse</th>



	  <th>Floor Stock</th>



	  <th>SILO 1</th>



	  <th>SILO 2</th>



	  <th>Total Stock</th>







    </tr>



  </thead>



  <tbody>







<?php



$sql4='select i.item_id as code,i.unit_name,i.item_name,s.sub_group_name



from item_info i, item_sub_group s, journal_item a, warehouse w



where 



i.sub_group_id=s.sub_group_id



and i.item_id = a.item_id



and a.warehouse_id = w.warehouse_id



and w.group_for="'.$_SESSION['user']['group'].'"



'.$item_sub_con.$item_con.' 



group by i.item_id 



order by s.sub_group_name,i.item_name';







$query = db_query($sql4);



while($data= mysqli_fetch_object($query)){ 



$j++;



?>



    <tr>



      <td><?=$j?></td>



      <td><?=$data->code?></td>



      <td><?=$data->sub_group_name?></td>



      <td><?=$data->item_name?></td>



      <td><?=$data->unit_name?></td>



      <td><?=(int)$hfl_stock[$data->code]?></td>



	  <td><?=(int)$pl_stock[$data->code]?></td>



	  <td><?=(int)$silo1_stock[$data->code]?></td>



	  <td><?=(int)$silo2_stock[$data->code]?></td>



	  



	  <td><?php $total_qty=($hfl_stock[$data->code] + $pl_stock[$data->code] + $silo1_stock[$data->code] + $silo2_stock[$data->code]); echo $total_qty;?></td>







    </tr>



<? } ?>







  </tbody>



</table>



<?







}



// end 111







if($_POST['report']==8001)  // last purchase report



{







		$report="Last Item Purchase Rate";



		



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and r.item_id='.$item_id;} 







if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and r.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







$asql='



SELECT r.pr_no as gr_no,r.item_id as code,i.item_name,s.sub_group_name as category,MAX(r.rec_date) as gr_date



FROM  purchase_receive r,item_info i, item_sub_group s



where



r.item_id=i.item_id



and s.sub_group_id=i.sub_group_id



and r.warehouse_id="'.$_SESSION['user']['depot'].'"



and r.item_id='.$item_id.'



'.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.'



group by r.item_id



order by i.item_name';



		   



$query =db_query($asql);   







?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="8"><div class="header">



        <h1>Olympic Cement Limited</h1>



        <h2>



          <?=$report?>



        </h2>



        <div class="left"></div>



        <div class="right"></div>



        <div class="date">Reporting Time:



          <?=date("h:i A d-m-Y")?>



        </div></td>



    </tr>



    <tr>



      <th>S/L</th>



      <th>Code</th>



      <th>Item Name</th>



      <th>Category</th>



      <th>Date</th>



      <th>gr_no</th>



	   <th>Qty</th>



      <th>Rate</th>



      <th>Amount</th>



    </tr>



  </thead>



  <tbody>



<?



while($data=mysqli_fetch_object($query)){



$j++;



?>



    <tr>



      <td><?=$j?></td>



      <td><?=$data->code?></td>



      <td><?=$data->item_name?></td>



      <td><?=$data->category?></td>



      <td><?=$data->gr_date?></td>



      <td><?php



$fgr = find_a_field_sql("select pr_no from purchase_receive where item_id='$data->code' and rec_date='$data->gr_date'"); echo $fgr; 



	   ?></td>



           



		 <td><?php



$fqty = find_a_field_sql("select qty from purchase_receive where pr_no='$fgr'"); echo $fqty; 



	   ?></td>



		 <td><?php



$frate= find_a_field_sql("select rate from purchase_receive where pr_no='$fgr'"); echo $frate; 



	   ?></td>



      <td><?php $tamount=($fqty*$frate); echo $tamount; $gTotAmount +=$tamount; ?></td>



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



      <td></td>



      <td><?=$gTotAmount?></td>



    </tr>



  </tbody>



</table>



<?







}











// 303



if($_POST['report']==303)  // requisition status details report



{







if($_POST['req_no']>0){ 	







$requisition=$_POST['req_no'];







$report="Requisition NO: ".$requisition;



$asql='SELECT * FROM  requisition_order WHERE  req_no ="'.$requisition.'"';







$req_master = find_all_field_sql('select * from requisition_master where req_no ="'.$requisition.'"');



		   



$query =db_query($asql);   







?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="8"><div class="header">



        <h1><? $warehouse = find_a_field_sql("select w.warehouse_name from warehouse w,requisition_master r 



		where w.warehouse_id=r.warehouse_id and r.req_no='".$requisition."'"); echo $warehouse;  ?></h1>



		<h2>Requisition Status Report</h2>







<center>



<table>



  <tr>



    <td>Requisition No</td>



    <td>Date</td>



    <td>Req For</td>



    <td>Note</td>



    <td>Need By</td>



    <td>Entry_by</td>



    <td>Entry_time</td>



    <td>Status</td>



  </tr>



  <tr>



    <td><?=$req_master->req_no;?></td>



    <td><?=$req_master->req_date;?></td>



    <td><?=$req_master->req_for;?></td>



    <td><?=$req_master->req_note;?></td>



    <td><?=$req_master->need_by;?></td>



    <td><?=$req_master->entry_by;?></td>



    <td><?=$req_master->entry_at;?></td>



    <td><?=$req_master->status;?></td>



  </tr>



</table>



  <p>      



		<h3>Item Details</h3>



        <div class="left"></div>



        <div class="right"></div>



        <div class="date">Reporting Time:  <?=date("h:i A d-m-Y")?> </div></td>



    </tr>



    <tr>



      <th>S/L</th>



      <th>Code</th>



      <th>Item Name</th>



	  <th>Item Unit</th>



      <th>Req Qty</th>



      <th>PO NO </th>



      <th>PO Date </th>



	   <th>PO Qty </th>



       <th>GR Qty </th>



       <th>Due Qty </th>



    </tr>



  </thead>



  <tbody>



<?



while($data=mysqli_fetch_object($query)){



$j++;



?>



    <tr>



      <td><?=$j?></td>



      <td><?=$data->item_id?></td>



      <td><?php $item_name=find_a_field_sql("select item_name from item_info where item_id='$data->item_id'"); echo $item_name; ?></td>



	  <td><?php $item_unit=find_a_field_sql("select unit_name from item_info where item_id='$data->item_id'"); echo $item_unit; ?></td>



      <td><?=$data->qty?></td>



      <td><?php $po_no=find_a_field_sql("select po_no from purchase_invoice where req_id='$data->id'"); echo $po_no; ?></td>



      <td><?php $po_date=find_a_field_sql("select po_date from purchase_invoice where req_id='$data->id'"); echo $po_date; ?></td>



	  <td><?php $po_qty=find_a_field_sql("select qty from purchase_invoice where req_id='$data->id'"); echo $po_qty; ?></td>



	  <td><?php $gr_qty=find_a_field_sql("select qty from purchase_receive where po_no='".$po_no."' and item_id='".$data->item_id."'"); echo $gr_qty; ?></td>



	  <td><?php echo $po_qty-$gr_qty; ?></td>



    </tr>



<? } ?>



</tbody>



</table>







<?



} else {echo "Please Put Requisition NO";}



} // end 303











if($_POST['report']==1012) 



{



		$report="Claim Product Summery Report";



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







$sqlg="SELECT i.finish_goods_code as code,i.item_name,sum(w.qty) as issue,







(select sum(qty) from  warehouse_other_receive_detail where item_id=w.item_id and or_date BETWEEN  '".$_POST['f_date']."' AND '".$_POST['t_date']."' and vendor_name = 3 and receive_type='Claim Item Receive') as received,



 



i.d_price as rate



  



FROM  warehouse_other_issue_detail w, item_info i



WHERE 



w.item_id=i.item_id



AND w.issue_type LIKE  'Claim Item Issue'



AND w.oi_date BETWEEN  '".$_POST['f_date']."' AND '".$_POST['t_date']."'



AND w.warehouse_id = '".$_SESSION['user']['depot']."'







GROUP BY code";



		   



$query =db_query($sqlg);   







?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="8"><div class="header">



        <h1>Olympic Cement Limited</h1>



        <h2><?=$report?></h2>



		<?php echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>'; ?>



        <div class="left"></div>



        <div class="right"></div>



        <div class="date">Reporting Time:<?=date("h:i A d-m-Y")?></div></td>



    </tr>



    <tr>



      <th>S/L</th>



      <th>Code</th>



      <th>Item Name</th>



      <th>Issue</th>



      <th>Received</th>



      <th>Pending</th>



      <th>DP Rate</th>



      <th>Amount</th>



    </tr>



  </thead>



  <tbody>



<?



while($data=mysqli_fetch_object($query)){



$j++;



?>



    <tr>



      <td><?=$j?></td>



      <td><?=$data->code?></td>



      <td><?=$data->item_name?></td>



      <td><?=$data->issue?></td>



      <td><?=$data->received?></td>



      <td><? $pending = $data->issue-$data->received; echo $pending; ?></td>



      <td><?=$data->rate?></td>



      <td><? $totAmount =$data->rate*$pending; echo $totAmount; $gTotAmount +=$totAmount; ?></td>



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



      <td><div align="right"><strong>Total</strong></div></td>



      <td><strong>



        <?=$gTotAmount?>



      </strong></td>



    </tr>



  </tbody>



</table>



<?







}







if($_POST['report']==1016) // report making date 5 jan 2018



{



		$report="Reprocess Product Summery Report";



		if(isset($warehouse_id)) 				{$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;} 



		if(isset($sub_group_id)) 				{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



		elseif(isset($item_id)) 				{$item_con=' and a.item_id='.$item_id;} 



		elseif(isset($issue_status)) 		{$status_con=' and a.tr_from="'.$issue_status.'"';} 



		



		if(isset($t_date)) 



		{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}







$sqlg="SELECT i.finish_goods_code as code,i.item_name,sum(w.qty) as issue,



(select sum(qty) from  warehouse_other_receive_detail where item_id=w.item_id 



and or_date BETWEEN  '".$_POST['f_date']."' AND '".$_POST['t_date']."' 



and warehouse_id = '".$_SESSION['user']['depot']."' 



and receive_type = 'Reprocess Receive') as received,i.d_price as rate



  



FROM  warehouse_other_issue_detail w, item_info i



WHERE 



w.item_id=i.item_id



AND w.issue_type =  'Reprocess Issue'



AND w.oi_date BETWEEN  '".$_POST['f_date']."' AND '".$_POST['t_date']."'



AND w.warehouse_id = '".$_SESSION['user']['depot']."'



GROUP BY code";



		   



$query =db_query($sqlg);   







?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="8"><div class="header">



        <h1>Olympic Cement Limited</h1>



        <h2><?=$report?></h2>



		<?php echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>'; ?>



        <div class="left"></div>



        <div class="right"></div>



        <div class="date">Reporting Time:<?=date("h:i A d-m-Y")?></div></td>



    </tr>



    <tr>



      <th>S/L</th>



      <th>Code</th>



      <th>Item Name</th>



      <th>Issue</th>



      <th>Received</th>



      <th>Pending</th>



      <th>DP Rate</th>



      <th>Amount</th>



    </tr>



  </thead>



  <tbody>



<?



while($data=mysqli_fetch_object($query)){



$j++;



?>



    <tr>



      <td><?=$j?></td>



      <td><?=$data->code?></td>



      <td><?=$data->item_name?></td>



      <td><?=$data->issue?></td>



      <td><?=$data->received?></td>



      <td><? $pending = $data->issue-$data->received; echo $pending; ?></td>



      <td><?=$data->rate?></td>



      <td><? $totAmount =$data->rate*$pending; echo $totAmount; $gTotAmount +=$totAmount; ?></td>



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



      <td><div align="right"><strong>Total</strong></div></td>



      <td><strong>



        <?=$gTotAmount?>



      </strong></td>



    </tr>



  </tbody>



</table>



<?



}







if($_POST['report']==9) // Sajeeb Warehouse Labour Bill



{



$report="Warehouse Labour Bill";	



$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);







$sql = "SELECT `tr_from`,`item_id`,sum(`item_ex`) exx ,sum(`item_in`) inx  



FROM `journal_item` 



WHERE  ji_date between '".$f_date."' and '".$t_date."' and `warehouse_id` = ".$_SESSION['user']['depot']." 



group by `tr_from`,`item_id`";







$query = db_query($sql);



while($data = mysqli_fetch_object($query)){



$item_ex[$data->item_id][$data->tr_from] = $data->exx;



$item_in[$data->item_id][$data->tr_from] = $data->inx;



}







$sql="SELECT  distinct i.item_id, i.finish_goods_code as code, i.item_name, i.unit_name, i.pack_size, w.rate



from item_info i, warehouse_labour_rate w, journal_item j



where



i.item_id=w.item_id



and j.item_id=w.item_id



and j.item_id=i.item_id



and j.ji_date between '".$f_date."' and '".$t_date."'



and i.finish_goods_code>0



and w.warehouse_id = ".$_SESSION['user']['depot']."







";







$query =db_query($sql); 



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="9"><div class="header">



        <h1><?=$warehouse_name?></h1>



        <h2><?=$report?></h2>



		<?php echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>'; ?>



        <div class="left"></div>



        <div class="right"></div>



        <div class="date">Reporting Time:<?=date("h:i A d-m-Y")?></div></td>



    </tr>



    <tr>



      <th>S/L</th>



      <th>Code</th>



      <th>Item Name</th>



      <th>Unit</th>



      <th>Pack Size</th>



      <th>Sales (Out)</th>



      <th>Issue (Out)</th>



      <th>Total Out</th>



      <th>Return (in)</th>



	  <th>Receive (in)</th>



	  <th>Total In</th>



	  <th>Total</th>



	  <th>Rate</th>



	  <th>Total Bill</th>



    </tr>



  </thead>



  <tbody>



<?



while($data=mysqli_fetch_object($query)){



$j++;



$sales_out = ($item_ex[$data->item_id]['Sales']+$item_ex[$data->item_id]['BulkSales']+$item_ex[$data->item_id]['Other Sales']+$item_ex[$data->item_id]['Staff Sales']);



$issue_out = ($item_ex[$data->item_id]['issue']+$item_ex[$data->item_id]['Transfered']);



$total_out = $sales_out + $issue_out;







$return_in= ($item_in[$data->item_id]['Return']+$item_in[$data->item_id]['SalesReturn']);



$receive_in=($item_in[$data->item_id]['Receive']+$item_in[$data->item_id]['Transfered']+$item_in[$data->item_id]['Purchase']+$item_in[$data->item_id]['Import']);







$total_in = $return_in + $receive_in;



$total_in_out = $total_out + $total_in;



$total_of_total_in_out = $total_of_total_in_out + (int)($total_in_out/$data->pack_size);



$total_in_out_bill = ((int)($total_in_out/$data->pack_size))*$data->rate;



if($total_in_out_bill>0){



?>



    <tr>



<td><?=$j?></td>



<td><?=$data->code?></td>



<td><?=$data->item_name?></td>



<td><?=$data->unit_name?></td>



<td><?=$data->pack_size?></td>



<td><?=(int)($sales_out/$data->pack_size)?></td>



<td><?=(int)($issue_out/$data->pack_size)?></td>



<td><?=(int)($total_out/$data->pack_size)?></td>



<td><?=(int)($return_in/$data->pack_size)?></td>



<td><?=(int)($receive_in/$data->pack_size)?></td>



<td><?=(int)($total_in/$data->pack_size)?></td>



<td><?=(int)($total_in_out/$data->pack_size)?></td>



<td><?=$data->rate?></td>



<td><?php echo $total_in_out_bill; $gTotAmount +=$total_in_out_bill;?></td>



</tr>



<?



}		}



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



      <td>Total</td>



      <td><strong><?=$total_of_total_in_out?></strong></td>



      <td></td>



      <td><strong><?=round($gTotAmount);?></strong></td>



    </tr>



  </tbody>



</table>



<?



}







elseif($_POST['report']==4) 



{



if(isset($item_id)) 				{$item_cons=' and i.item_id='.$item_id;}



if($_SESSION['user']['depot']==5)



$sql='select distinct i.item_id,i.unit_name,i.sales_item_type as product_group,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.p_price as item_price,i.d_price as d_price



		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.' and 



		   i.sub_group_id=s.sub_group_id and i.finish_goods_code > 1 order by i.finish_goods_code,s.sub_group_name,i.item_name';



else



$sql='select distinct i.item_id,i.sales_item_type as product_group,i.unit_name,i.item_name,s.sub_group_name,i.finish_goods_code,i.pack_size,i.f_price as item_price,i.d_price as d_price



		   from item_info i, item_sub_group s where i.product_nature = "Salable" '.$item_cons.' and 



		   i.sub_group_id=s.sub_group_id and i.finish_goods_code > 1 order by i.finish_goods_code,s.sub_group_name,i.item_name';



$query =db_query($sql);   







$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



		



$s='select sum(a.item_in-a.item_ex) as final_stock , i.item_id



from journal_item a, item_info i 



where i.product_nature = "Salable" and a.item_id=i.item_id  '.$date_con.$item_con.$status_con.' 



and a.warehouse_id="'.$_SESSION['user']['depot'].'" and i.finish_goods_code > 1 group by i.item_id';



$q = db_query($s);



while($i=mysqli_fetch_object($q))



{



$final_stock[$i->item_id] = $i->final_stock;



}



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>



  <tr>



    <td style="border:0px;" colspan="11"><div class="header">



        <h1>Olympic Cement Limited</h1>



        <h2>



          <?=$report?>



        </h2>



        <h2>Closing Stock of Date-<?=$to_date?>



        </h2>



      </div>



      <div class="left"></div>



      <div class="right"></div>



      <div class="date">Reporting Time:



        <?=date("h:i A d-m-Y")?>



    </div></td>



  </tr>



  <tr>



    <th rowspan="2">S/L</th>



    <th rowspan="2">Warehouse Name</th>



    <th rowspan="2">Item Code</th>



	<th rowspan="2">Group</th>



    <th rowspan="2">FG</th>



    <th rowspan="2">Item Name</th>



    <th rowspan="2">Pack Size</th>



    <th rowspan="2">Unit</th>



    <th colspan="2">Final Stock</th>



    <th rowspan="2">Total Pcs</th>



    <th rowspan="2">F Rate</th>



    <th rowspan="2">Stock Total</th>



    <th rowspan="2">DP Rate</th>



    <th rowspan="2">DP Total</th>



  </tr>



  <tr>



    <th bgcolor="#CCFFFF">ctr</th>



    <th bgcolor="#FFCCFF">pcs</th>



  </tr>



</thead>



<tbody>



<?



while($data=mysqli_fetch_object($query)){



$j++;



?>



  <tr>



    <td><?=$j?></td>



    <td><?=$warehouse_name?></td>



    <td><?=$data->item_id?></td>



	<td><?=$data->product_group?></td>



    <td><?=$data->finish_goods_code?></td>



    <td><?=$data->item_name?></td>



    <td><?=$data->pack_size?></td>



    <td><?=$data->unit_name?></td>



    <td style="text-align:right; background-color:#CCFFFF;"><?=(int)($final_stock[$data->item_id]/$data->pack_size)?></td>



    <td style="text-align:right;background-color:#FFCCFF;"><?=($final_stock[$data->item_id]%$data->pack_size)?></td>



    <td style="text-align:right"><?=(int)$final_stock[$data->item_id];?></td>



    <td style="text-align:right"><?=@number_format(($data->item_price),2)?></td>



    <td style="text-align:right"><? $sum =$data->item_price*$final_stock[$data->item_id]; echo number_format(($data->item_price*$final_stock[$data->item_id]),2);?></td>



    <td style="text-align:right"><?=@number_format(($data->d_price),2)?></td>



    <td style="text-align:right"><? $dsum =$data->d_price*$final_stock[$data->item_id]; echo number_format(($data->d_price*$final_stock[$data->item_id]),2);?></td>



  </tr>



<?



$dt_sum = $dt_sum + $dsum;



$t_sum = $t_sum + $sum;



}



?>



  <tr>



    <td></td><td></td><td></td>



    <td></td>



    <td></td>



    <td></td>



    <td></td>



    <td></td>



    <td style="text-align:right; background-color:#CCFFFF;"></td>



    <td style="text-align:right;background-color:#FFCCFF;"></td>



    <td style="text-align:right"></td>



    <td style="text-align:right"></td>



    <td style="text-align:right"><strong><?=number_format($t_sum,2)?></strong></td>



    <td style="text-align:right"></td>



    <td style="text-align:right"><strong><?=number_format($dt_sum,2)?></strong></td>



  </tr>



  <?



}







elseif($_POST['report']==71) 



{



		$sql='select i.item_id,i.unit_name,i.item_name,i.sales_item_type,i.finish_goods_code,i.item_brand,i.pack_unit,i.pack_size,i.sales_item_type from item_info i where 



		   i.product_nature = "Salable"  order by i.finish_goods_code,i.item_name';



		   



		$query =db_query($sql);  



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



<thead>



  <tr>



    <td style="border:0px;" colspan="12"><div class="header">



        <h1>Olympic Cement Limited</h1>



        <h2>Warehouse Present Stock</h2>



      </div>



      <div class="left"></div>



      <div class="right"></div>



      <div class="date">Reporting Time:



        <?=date("h:i A d-m-Y")?>



    </div></td>



  </tr>



  <tr>



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



</thead>



<tbody>



  <?



while($data=mysqli_fetch_object($query)){



$s='select a.final_stock,a.final_price as rate,(a.final_stock*a.final_price) as Stock_price from journal_item a where  a.item_id="'.$data->item_id.'"  and a.warehouse_id='.$_SESSION['user']['depot'].' order by a.id desc limit 1';



$q = db_query($s);



$i=mysqli_fetch_object($q);$j++;



		   ?>



  <tr>



    <td><?=$j?></td>



    <td><?=$data->finish_goods_code?></td>



    <td><?=$data->item_brand?></td>



    <td><?=$data->sales_item_type?></td>



    <td><?=$data->item_name?></td>



    <td><?=$data->pack_size?></td>



    <td><?=$data->unit_name?></td>



    <td bgcolor="#FFCCFF" style="text-align:right"><?=(int)($i->final_stock/$data->pack_size)?></td>



    <td bgcolor="#CCCCFF" style="text-align:right"><?=(int)($i->final_stock%$data->pack_size)?></td>



    <td style="text-align:right"><?=$i->rate?></td>



    <td style="text-align:right"><?=$i->Stock_price?></td>



  </tr>



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



    <tr>



      <td colspan="17" style="border:0px;"><?



		echo '<div class="header">';



		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



		if(isset($report)) 



		echo '<h2>'.$report.'</h2>';



		



?>



        <h2>



          <? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?>



        </h2>



        <?



if(isset($warehouse_id))



		echo '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';



if(isset($t_date)) 



		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



		echo '</div>';







		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



		?>



      </td>



    </tr>



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



  </thead>



  <tbody>



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



    </tr>



    <? }}?>



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



    <tr>



      <td colspan="17" style="border:0px;"><?



		echo '<div class="header">';



		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



		if(isset($report)) 



		echo '<h2>'.$report.'</h2>';



		



?>



        <h2>



          <? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?>



        </h2>



        <?



if(isset($warehouse_id))



		echo '<p>PL/WH Name: '.find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id).'</p>';



if(isset($t_date)) 



		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



		echo '</div>';







		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



		?>



      </td>



    </tr>



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



  </thead>



  <tbody>



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



    </tr>



    <? }}?>



  </tbody>



</table>



<?



}



elseif($_POST['report']==1001&&$sub_group_id>0) 



{



$sql='select i.item_id,i.unit_name,i.item_name  from item_info i where i.sub_group_id='.$sub_group_id.' order by i.finish_goods_code,i.item_name';



		   



		$query =db_query($sql);  



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="31"><div class="header">



          <h1>Olympic Cement Limited</h1>



          <h2>Stock Valuation Report<br />



            <? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?>



          </h2>



          <? if(isset($t_date)) 



	echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';?>



        </div>



        <div class="left"></div>



        <div class="right"></div>



        <div class="date">Reporting Time:



          <?=date("h:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th rowspan="2">S/L</th>



      <th rowspan="2">Item Name </th>



      <th rowspan="2">Unit</th>



      <th colspan="3" bgcolor="#CC99FF"><div align="center">Opening </div></th>



      <th colspan="3" bgcolor="#99FFFF"><div align="center">Purchase</div></th>



      <th colspan="3" bgcolor="#FFCCFF"><div align="center">Other Receive </div></th>



      <th colspan="3" bgcolor="#FFCC66"><div align="center">Total Receive </div></th>



      <th colspan="3"><div align="center">Sales</div></th>



      <th colspan="3"><div align="center">Consumption</div></th>



      <th colspan="3"><div align="center">Other Issue </div></th>



      <th colspan="3"><div align="center">Total Issue </div></th>



      <th colspan="3"><div align="center">Closing</div></th>



    </tr>



    <tr>



      <th bgcolor="#CC99FF">Qty</th>



      <th bgcolor="#CC99FF">AVR</th>



      <th bgcolor="#CC99FF">Amt </th>



      <th bgcolor="#99FFFF">Qty</th>



      <th bgcolor="#99FFFF">AVR</th>



      <th bgcolor="#99FFFF">Amt </th>



      <th bgcolor="#FFCCFF">Qty</th>



      <th bgcolor="#FFCCFF">AVR</th>



      <th bgcolor="#FFCCFF">Amt </th>



      <th bgcolor="#FFCC66">Qty</th>



      <th bgcolor="#FFCC66">AVR</th>



      <th bgcolor="#FFCC66">Amt </th>



      <th>Qty</th>



      <th>AVR</th>



      <th>Amt </th>



      <th>Qty</th>



      <th>AVR</th>



      <th>Amt </th>



      <th>Qty</th>



      <th>AVR</th>



      <th>Amt </th>



      <th>Qty</th>



      <th>AVR</th>



      <th>Amt </th>



      <th>Qty</th>



      <th>AVR</th>



      <th>Amt </th>



    </tr>



  </thead>



  <tbody>



    <?



while($row=mysqli_fetch_object($query)){



$pre_stock = $pre_price = $pre_amt   = $in_stock = $in_price = $in_amt   = $pur_stock = $pur_price = $pur_amt   = $or_stock = $or_amt   = $or_price = $out_stock = $out_price = $out_amt   = $sale_stock = $sale_price = $sale_amt   = $pro_stock = $pro_price = $pro_amt   = $oi_stock = $oi_amt   = $oi_price = $final_stock = $final_amt   = $final_price = 0;







$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock,sum((item_in-item_ex)*item_price) as pre_amt from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id);



		$pre_stock = (int)$pre->pre_stock;



		$pre_price = @($pre->pre_amt/$pre->pre_stock);



		$pre_amt   = $pre->pre_amt;







		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);



		$in_stock = (int)$in->pre_stock;



		$in_price = @($in->pre_amt/$in->pre_stock);



		$in_amt   = $in->pre_amt;



		



		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Purchase" and item_id='.$row->item_id);



		$pur_stock = (int)$pur->pre_stock;



		$pur_price = @($pur->pre_amt/$pur->pre_stock);



		$pur_amt   = $pur->pre_amt;



		



		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Purchase" and item_id='.$row->item_id);



		$or_stock = (int)$or->pre_stock;



		$or_amt   = @($or->pre_amt/$or->pre_stock);



		$or_price = $or->pre_amt;



		



		



		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);



		$out_stock = (int)$out->pre_stock;



		$out_price = @($out->pre_amt/$out->pre_stock);



		$out_amt   = $out->pre_amt;



		



		$sale = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Sales" and item_id='.$row->item_id);



		$sale_stock = (int)$sale->pre_stock;



		$sale_price = @($sale->pre_amt/$sale->pre_stock);



		$sale_amt   = $sale->pre_amt;



		



		$pro = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Issue" and item_id='.$row->item_id);



		$pro_stock = (int)$pro->pre_stock;



		$pro_price = @($pro->pre_amt/$pro->pre_stock);



		$pro_amt   = $pro->pre_amt;



		







		



		



		$oi = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Sales" and tr_from!="Issue" and item_id='.$row->item_id);



		$oi_stock = (int)$oi->pre_stock;



		$oi_amt   = @($oi->pre_amt/$oi->pre_stock);



		$oi_price = $oi->pre_amt;



		



		$final_stock = $pre_stock+($in_stock-$out_stock);



		$final_amt   = @($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price);



		$final_price = @(($final_amt)/$final_stock);



		



		



		?>



    <tr>



      <td><?=++$j?></td>



      <td><?=$row->item_name?></td>



      <td><nobr>



        <?=$row->unit_name?>



      </nobr></td>



      <td bgcolor="#CC99FF"><div align="right">



          <?=$pre_stock?>



        </div></td>



      <td bgcolor="#CC99FF"><div align="right">



          <?=number_format($pre_price,2)?>



        </div></td>



      <td bgcolor="#CC99FF"><div align="right">



          <?=number_format($pre_amt,2)?>



        </div></td>



      <td bgcolor="#99FFFF"><div align="right">



          <?=$pur_stock?>



        </div></td>



      <td bgcolor="#99FFFF"><div align="right">



          <?=number_format($pur_price,2)?>



        </div></td>



      <td bgcolor="#99FFFF"><div align="right">



          <?=number_format($pur_amt,2)?>



        </div></td>



      <td bgcolor="#FFCCFF"><div align="right">



          <?=$or_stock?>



        </div></td>



      <td bgcolor="#FFCCFF"><div align="right">



          <?=number_format($or_price,2)?>



        </div></td>



      <td bgcolor="#FFCCFF"><div align="right">



          <?=number_format($or_amt,2)?>



        </div></td>



      <td bgcolor="#FFCC66"><div align="right">



          <?=$in_stock?>



        </div></td>



      <td bgcolor="#FFCC66"><div align="right">



          <?=number_format($in_price,2)?>



        </div></td>



      <td bgcolor="#FFCC66"><div align="right">



          <?=number_format($in_amt,2)?>



        </div></td>



      <td><div align="right">



          <?=$sale_stock?>



        </div></td>



      <td><div align="right">



          <?=number_format($sale_price,2)?>



        </div></td>



      <td><div align="right">



          <?=number_format($sale_amt,2)?>



        </div></td>



      <td><div align="right">



          <?=$pro_stock?>



        </div></td>



      <td><div align="right">



          <?=number_format($pro_price,2)?>



        </div></td>



      <td><div align="right">



          <?=number_format($pro_amt,2)?>



        </div></td>



      <td><div align="right">



          <?=$oi_stock?>



        </div></td>



      <td><div align="right">



          <?=number_format($oi_price,2)?>



        </div></td>



      <td><div align="right">



          <?=number_format($oi_amt,2)?>



        </div></td>



      <td><div align="right">



          <?=$out_stock?>



        </div></td>



      <td><div align="right">



          <?=number_format($out_price,2)?>



        </div></td>



      <td><div align="right">



          <?=number_format($out_amt,2)?>



        </div></td>



      <td><div align="right">



          <?=$final_stock?>



        </div></td>



      <td><div align="right">



          <?=number_format($final_price,2)?>



        </div></td>



      <td><div align="right">



          <?=number_format($final_amt,2)?>



        </div></td>



    </tr>



    <?



}



?>



  </tbody>



</table>



<?



}



elseif($_POST['report']==10011) 



{



if($item_id>0) 		{$item_con = ' and i.item_id='.$item_id;}



if($sub_group_id>0) {$sub_item_con = ' and i.sub_group_id='.$sub_group_id;}







$sql='select i.item_id,i.unit_name,i.item_name  from item_info i where 1 '.$sub_item_con.$item_con.'  order by i.finish_goods_code,i.item_name';



$query =db_query($sql);



?>



<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="35"><div class="header">



          <h1>Olympic Cement Limited</h1>



          <h2>Stock Valuation Report(HFL)<br />



            <? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?>



          </h2>



          <? if(isset($t_date)) 



	echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';?>



        </div>



        <div class="left"></div>



        <div class="right"></div>



        <div class="date">Reporting Time:



          <?=date("h:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th rowspan="2">S/L</th>



      <th rowspan="2">Item Name </th>



      <th rowspan="2">Unit</th>



      <th colspan="5" bgcolor="#CC99FF"><div align="center">Opening </div></th>



      <th colspan="3" bgcolor="#99FFFF"><div align="center">Purchase</div></th>



      <th colspan="3" bgcolor="#FFCCFF"><div align="center">Other Receive </div></th>



      <th colspan="3" bgcolor="#FFFF00"><div align="center">Total IN </div></th>



      <th colspan="3" bgcolor="#99FFFF"><div align="center">Material Sales</div></th>



      <th colspan="3" bgcolor="#FFCCFF"><div align="center">Consumption </div></th>



      <th colspan="3" bgcolor="#FFCC66"><div align="center">Other Issue </div></th>



      <th colspan="3" bgcolor="#FF3366"><div align="center">Total OUT </div></th>



      <th colspan="5" bgcolor="#CC99FF"><div align="center">Closing</div></th>



    </tr>



    <tr>



      <th bgcolor="#CC99FF">WHQty</th>



      <th bgcolor="#CC99FF">PLQty</th>



      <th bgcolor="#CC99FF">TQty</th>



      <th bgcolor="#CC99FF">AVR</th>



      <th bgcolor="#CC99FF">Amt </th>



      <th bgcolor="#99FFFF">Qty</th>



      <th bgcolor="#99FFFF">AVR</th>



      <th bgcolor="#99FFFF">Amt </th>



      <th bgcolor="#FFCCFF">Qty</th>



      <th bgcolor="#FFCCFF">AVR</th>



      <th bgcolor="#FFCCFF">Amt </th>



      <th bgcolor="#FFFF00">Qty</th>



      <th bgcolor="#FFFF00">AVR</th>



      <th bgcolor="#FFFF00">Amt </th>



      <th bgcolor="#99FFFF">Qty</th>



      <th bgcolor="#99FFFF">AVR</th>



      <th bgcolor="#99FFFF">Amt </th>



      <th bgcolor="#FFCCFF">Qty</th>



      <th bgcolor="#FFCCFF">AVR</th>



      <th bgcolor="#FFCCFF">Amt </th>



      <th bgcolor="#FFCC66">Qty</th>



      <th bgcolor="#FFCC66">AVR</th>



      <th bgcolor="#FFCC66">Amt </th>



      <th bgcolor="#FF3366">Qty</th>



      <th bgcolor="#FF3366">AVR</th>



      <th bgcolor="#FF3366">Amt </th>



      <th bgcolor="#CC99FF">WHQty</th>



      <th bgcolor="#CC99FF">PLQty</th>



      <th bgcolor="#CC99FF">TQty</th>



      <th bgcolor="#CC99FF">AVR</th>



      <th bgcolor="#CC99FF">Amt </th>



    </tr>



  </thead>



  <tbody>



    <?



while($row=mysqli_fetch_object($query)){



$pre_stock = $pre_price = $pre_amt   = $in_stock = $in_price = $in_amt   = $pur_stock = $pur_price = $pur_amt   = $or_stock = $or_amt   = $or_price = $out_stock = $out_price = $out_amt   = $sale_stock = $sale_price = $sale_amt   = $pro_stock = $pro_price = $pro_amt   = $oi_stock = $oi_amt   = $oi_price = $final_stock = $final_amt   = $final_price = 0;











		$pr = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date < "'.$f_date.'" and (tr_from="Purchase" or tr_from="Local Purchase" or tr_from="Import") and item_id='.$row->item_id);



		$pr_price = @($pr->pre_amt/$pr->pre_stock);



		



		$pr_end = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date <= "'.$t_date.'" and (tr_from="Purchase" or tr_from="Local Purchase" or tr_from="Import") and item_id='.$row->item_id);



		$pr_end_price = @($pr->pre_amt/$pr->pre_stock);







		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and (tr_from="Purchase" or tr_from="Local Purchase" or tr_from="Import") and item_id='.$row->item_id);



		$pur_stock = (int)$pur->pre_stock;



		$pur_price = @($pur->pre_amt/$pur->pre_stock);



		$pur_amt   = $pur->pre_amt;















$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock from journal_item j,warehouse w where w.warehouse_id=j.warehouse_id and (w.master_warehouse_id = "'.$_SESSION['user']['depot'].'" or  w.warehouse_id = "'.$_SESSION['user']['depot'].'") and j.ji_date<"'.$f_date.'" and j.item_id='.$row->item_id);



		$pret_stock = (int)$pre->pre_stock;



		$pret_price = $pr_price;



		$pret_amt   = $pre->pre_stock*$pr_price;







//echo 'select sum(item_in-item_ex) as pre_stock from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id;



		$pre = find_all_field_sql('select sum(item_in-item_ex) as pre_stock from journal_item where warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date<"'.$f_date.'" and item_id='.$row->item_id);



		$pre_stock = (int)$pre->pre_stock;



		$lpre_stock = $pret_stock - $pre_stock;



		



		



		$in = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and item_id='.$row->item_id);



		$in_stock = (int)$in->pre_stock;



		$in_price = @($in->pre_amt/$in->pre_stock);



		$in_amt   = $in->pre_amt;



		







		$pur = find_all_field_sql('select sum(item_in) as pre_stock, sum(item_in*item_price) as pre_amt from journal_item where item_in>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Purchase" and tr_from!="Local Purchase" and tr_from!="Import" and item_id='.$row->item_id);



		$or_stock = (int)$or->pre_stock;



		$or_amt   = @($or->pre_amt/$or->pre_stock);



		$or_price = $or->pre_amt;



		



		



		$sale = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Other Sales" and item_id='.$row->item_id);



		$sale_stock = (int)$sale->pre_stock;



		$sale_price = $pr_price;



		$sale_amt   = $sale_stock*$pr_price;



		



		



		$pro = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from="Consumption" and item_id='.$row->item_id);



		$pro_stock = (int)$pro->pre_stock;



		$pro_price = $pr_price;



		$pro_amt   = $pr_price*$pro_stock;



		



		$out = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="issue" and item_id='.$row->item_id);



		$out_stock = (int)($out->pre_stock + $pro_stock);



		$out_price = $pr_price;



		$out_amt   = $pr_price*$out_stock;



		



		$oi = find_all_field_sql('select sum(item_ex) as pre_stock, sum(item_ex*item_price) as pre_amt from journal_item where item_ex>0 and warehouse_id = "'.$_SESSION['user']['depot'].'" and ji_date between "'.$f_date.'" and "'.$t_date.'" and tr_from!="Other Sales" and tr_from!="Issue" and item_id='.$row->item_id);



		$oi_stock = (int)$oi->pre_stock;



		$oi_amt   = @($oi->pre_amt/$oi->pre_stock);



		$oi_price = $oi->pre_amt;



		



		$final_stock = $pre_stock+($in_stock-$out_stock);



		$final_amt   = @($pre_stock*$pre_price)+($in_stock*$in_price)-($out_stock*$out_price);



		$final_price = @(($final_amt)/$final_stock);







$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock,sum((j.item_in-j.item_ex)*j.item_price) as pre_amt from journal_item j,warehouse w where w.warehouse_id=j.warehouse_id and (w.master_warehouse_id = "'.$_SESSION['user']['depot'].'" or  w.warehouse_id = "'.$_SESSION['user']['depot'].'") and j.ji_date<="'.$t_date.'" and j.item_id='.$row->item_id);



		$final_stock = (int)$pre->pre_stock;



		$final_amt = $pr_end_price;



		$final_price   = $pre->pre_stock*$pr_end_price;







$pre = find_all_field_sql('select sum(j.item_in-j.item_ex) as pre_stock from journal_item j,warehouse w where w.warehouse_id=j.warehouse_id and w.master_warehouse_id = "'.$_SESSION['user']['depot'].'" and j.ji_date<="'.$t_date.'" and j.item_id='.$row->item_id);



		$lfinal_stock = (int)$pre->pre_stock;



		$prefinal_stock = (int)($final_stock -$pre->pre_stock);



		?>



    <tr>



      <td><?=++$j?></td>



      <td><?=$row->item_name?></td>



      <td><nobr>



        <?=$row->unit_name?>



      </nobr></td>



      <td bgcolor="#CC99FF"><?=$pre_stock?></td>



      <td bgcolor="#CC99FF"><?=$lpre_stock?></td>



      <td bgcolor="#CC99FF"><div align="right">



          <?=$pret_stock?>



        </div></td>



      <td bgcolor="#CC99FF"><div align="right">



          <?=number_format($pr_price,2)?>



        </div></td>



      <td bgcolor="#CC99FF"><div align="right">



          <?=number_format(($pr_price*$pret_stock),2)?>



        </div></td>



      <td bgcolor="#99FFFF"><div align="right">



          <?=$pur_stock?>



        </div></td>



      <td bgcolor="#99FFFF"><div align="right">



          <?=number_format($pur_price,2)?>



        </div></td>



      <td bgcolor="#99FFFF"><div align="right">



          <?=number_format($pur_amt,2)?>



        </div></td>



      <td bgcolor="#FFCCFF"><div align="right">



          <?=$or_stock?>



        </div></td>



      <td bgcolor="#FFCCFF"><div align="right">



          <?=number_format($or_price,2)?>



        </div></td>



      <td bgcolor="#FFCCFF"><div align="right">



          <?=number_format($or_amt,2)?>



        </div></td>



      <td bgcolor="#FFFF00"><div align="right">



          <?=$in_stock?>



        </div></td>



      <td bgcolor="#FFFF00"><div align="right">



          <?=number_format($in_price,2)?>



        </div></td>



      <td bgcolor="#FFFF00"><div align="right">



          <?=number_format($in_amt,2)?>



        </div></td>



      <td bgcolor="#99FFFF"><div align="right">



          <?=$sale_stock?>



        </div></td>



      <td bgcolor="#99FFFF"><div align="right">



          <?=number_format($sale_price,2)?>



        </div></td>



      <td bgcolor="#99FFFF"><div align="right">



          <?=number_format($sale_amt,2)?>



        </div></td>



      <td bgcolor="#FFCCFF"><div align="right">



          <?=$pro_stock?>



        </div></td>



      <td bgcolor="#FFCCFF"><div align="right">



          <?=number_format($pro_price,2)?>



        </div></td>



      <td bgcolor="#FFCCFF"><div align="right">



          <?=number_format($pro_amt,2)?>



        </div></td>



      <td bgcolor="#FFCC66"><div align="right">



          <?=$oi_stock?>



        </div></td>



      <td bgcolor="#FFCC66"><div align="right">



          <?=number_format($oi_price,2)?>



        </div></td>



      <td bgcolor="#FFCC66"><div align="right">



          <?=number_format($oi_amt,2)?>



        </div></td>



      <td bgcolor="#FF3366"><div align="right">



          <?=$out_stock?>



        </div></td>



      <td bgcolor="#FF3366"><div align="right">



          <?=number_format($out_price,2)?>



        </div></td>



      <td bgcolor="#FF3366"><div align="right">



          <?=number_format($out_amt,2)?>



        </div></td>



      <td bgcolor="#CC99FF"><?=$prefinal_stock?></td>



      <td bgcolor="#CC99FF"><?=$lfinal_stock?></td>



      <td bgcolor="#CC99FF"><div align="right">



          <?=$final_stock?>



        </div></td>



      <td bgcolor="#CC99FF"><div align="right">



          <?=number_format($final_price,2)?>



        </div></td>



      <td bgcolor="#CC99FF"><div align="right">



          <?=number_format($final_amt,2)?>



        </div></td>



    </tr>



    <?



}



?>



  </tbody>



</table>



<?



}

// Monthly Out Report, Modify on 6th Dec,2022; By M A HASAN

if($_POST['report']==51122) 



{

$current_date=date("Y-m-d");



$sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,j.item_price,sum(j.item_ex) as issued



from item_info i, item_sub_group s,journal_item j,warehouse_other_issue_detail o 



where j.warehouse_id="'.$_SESSION['user']['depot'].'" and i.item_id = j.item_id and i.sub_group_id=s.sub_group_id and o.item_id=j.item_id



'.$item_sub_con.$item_con.$date_con.$trans_con.' 



group by i.item_id 



order by i.item_name'; 





$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>





   <?

	



  //// find year and month from date range



  $fr_year = date('Y',strtotime($fr_date));

  $to_year = date('Y',strtotime($to_date));



  $fr_month = date('m',strtotime($fr_date));

  $to_month = date('m',strtotime($to_date));



  $yy = array();

  $mm = array();



  for($y=$fr_year;$y<=$to_year; $y++) {

    $yy[] = $y;

    if($y==$fr_year) {

      $start_month = $fr_month;

    } else {

      $start_month = 1;

    }

    if($y==$to_year) {

      $end_month = $to_month;

    } else {

      $end_month = 12;

    }

    for($m=$start_month;$m<=$end_month; $m++) {

      $mm['m'][] = $m;

      $mm['y'][] = $y;

    }

  }

 



  $t_rec = array();



	$query =db_query($sql3);   

	

	$rows = mysqli_num_rows($query);

	$j=0;



while($data=mysqli_fetch_object($query)){







$item_id[$j]=$data->item_id;



$sub_group_name[$j]=$data->sub_group_name;



$item_name[$j]=$data->item_name;



$item_location[$j]=$data->item_location;



$unit_name[$j]=$data->unit_name;



//$use_for[$j]=$data->use_for;



$treceive = 0;

foreach($mm['m'] as $k=>$m) {

  $receive[$m][$data->item_id][$k] = number_format($receives = find_a_field('journal_item','sum(item_ex)','item_id="'.$data->item_id.'" and month(ji_date)="'.$m.'"  and year(ji_date)="'.$mm['y'][$k].'" '),0);

  $treceive+=$receives;  

  $t_rec[$m] = $t_rec[$m]+$receives;

  $colspan+=1;

  

}







// for($y=(int)date('m',strtotime($fr_date));$y<=date('m',strtotime($to_date)); $y++) {

// 	  $receive[$y][$data->item_id][] = $receives = number_format(find_a_field('journal_item','sum(item_ex)','item_id="'.$data->item_id.'" and month(ji_date)="'.$y.'"  and year(ji_date)="'.date('Y',strtotime($fr_date)).'" '),0);

// 	 $yy[] = $y;

// 	$treceive+=$receives;  //$trec[$y]+=$receive;

// 	$colspan+=1;

// }

///



$j++;



}

 ?>





<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="<?=6+$colspan;?>"><div class="header">



          <br /><h1>Olympic Cement Limited</h1>



          <h2><br />



            <?=$report?>



          </h2>



          <h2>Closing Stock of Date-



            <?=$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>

      <th>Item Code</th>

      <th>Item Group</th>

      <th>Item Name</th>

	  <th>Item Location</th>

	  

	  <?php /*?> <th>Use For</th><?php */?>



      <th>Unit</th>

	  <? 

        foreach($mm['m'] as $k=>$m) {

    ?>



      <th colspan=""><?=date('F,Y',strtotime($mm['y'][$k].'-'.$m.'-01'));?></th>

	  <? }?>

	



    </tr>



  </thead>



  <tbody>

 



<? for($x=0;$x<$rows;$x++){?>

    <tr>



      <td><?=++$sl;?></td>

      <td><?=$item_id[$x];?></td>

      <td><?=$sub_group_name[$x];?></td>

      <td><?=$item_name[$x];?></td>

	  <td><?=$item_location[$x];?></td>

	    <?php /*?><td><? //=$use_for[$x];?></td><?php */?>



      <td><?=$unit_name[$x]?></td>

	   <?

        foreach($mm['m'] as $k=>$m) {

    ?>

	   <td style="text-align:right"> <? if ($receive[$m][$item_id[$x]][$k]>0) echo $receive[$m][$item_id[$x]][$k];?></td>

     

	   <? } ?>

	   
    </tr>



    <? } ?>



    <tr>

      <td colspan="<?=6;?>"><strong>Total: </strong></td>

	   <?

      foreach($t_rec as $rec){ ?>

	   <td style="text-align:right"><strong><?=number_format(($rec),0)?></strong></td>

	   <? }?>

	  



    </tr>



  </tbody>





</table>



<?







}


// Monthly Transport wise Out Report, Modify on 9th April,2023; By M A HASAN

if($_POST['report']==9423) 



{

$current_date=date("Y-m-d");



  $sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,j.item_price,sum(j.item_ex) as issued, o.use_for



from item_info i, item_sub_group s,journal_item j,warehouse_other_issue_detail o 



where j.warehouse_id="'.$_SESSION['user']['depot'].'" and i.item_id = j.item_id and i.sub_group_id=s.sub_group_id and o.item_id=j.item_id and o.oi_no=j.sr_no and o.id=j.tr_no



'.$item_sub_con.$item_con.$date_con.$trans_con.' 



group by i.item_id 



order by i.item_name'; 





$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>





   <?

	



  //// find year and month from date range



  $fr_year = date('Y',strtotime($fr_date));

  $to_year = date('Y',strtotime($to_date));



  $fr_month = date('m',strtotime($fr_date));

  $to_month = date('m',strtotime($to_date));



  $yy = array();

  $mm = array();



  for($y=$fr_year;$y<=$to_year; $y++) {

    $yy[] = $y;

    if($y==$fr_year) {

      $start_month = $fr_month;

    } else {

      $start_month = 1;

    }

    if($y==$to_year) {

      $end_month = $to_month;

    } else {

      $end_month = 12;

    }

    for($m=$start_month;$m<=$end_month; $m++) {

      $mm['m'][] = $m;

      $mm['y'][] = $y;

    }

  }

 



  $t_rec = array();



	$query =db_query($sql3);   

	

	$rows = mysqli_num_rows($query);

	$j=0;



while($data=mysqli_fetch_object($query)){







$item_id[$j]=$data->item_id;



$sub_group_name[$j]=$data->sub_group_name;



$item_name[$j]=$data->item_name;



$item_location[$j]=$data->item_location;



$unit_name[$j]=$data->unit_name;



$use_for[$j]=$data->use_for;



$treceive = 0;

foreach($mm['m'] as $k=>$m) {

  $receive[$m][$data->item_id][$k] = number_format($receives = find_a_field('warehouse_other_issue_detail ','sum(qty)','item_id="'.$data->item_id.'" and month(oi_date)="'.$m.'"  and year(oi_date)="'.$mm['y'][$k].'" and use_for="'.$data->use_for.'" '),0);

  $treceive+=$receives;  

  $t_rec[$m] = $t_rec[$m]+$receives;

  $colspan+=1;

  

}







// for($y=(int)date('m',strtotime($fr_date));$y<=date('m',strtotime($to_date)); $y++) {

// 	  $receive[$y][$data->item_id][] = $receives = number_format(find_a_field('journal_item','sum(item_ex)','item_id="'.$data->item_id.'" and month(ji_date)="'.$y.'"  and year(ji_date)="'.date('Y',strtotime($fr_date)).'" '),0);

// 	 $yy[] = $y;

// 	$treceive+=$receives;  //$trec[$y]+=$receive;

// 	$colspan+=1;

// }

///



$j++;



}

 ?>





<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="<?=7+$colspan;?>"><div class="header">



          <br /><h1>OLYMPIC CEMENT LIMITED</h1><br />



          <h2>



           <strong> <?=$report?></strong>



          </h2>



          <h2>Closing Stock of Date-



            <?=$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>

      <th>Item Code</th>

      <th>Item Group</th>

      <th>Item Name</th>

	  <th>Item Location</th>

	  

	   <th>Use For</th>



      <th>Unit</th>

	  <? 

        foreach($mm['m'] as $k=>$m) {

    ?>



      <th colspan=""><?=date('F,Y',strtotime($mm['y'][$k].'-'.$m.'-01'));?></th>

	  <? }?>

	



    </tr>



  </thead>



  <tbody>

 



<? for($x=0;$x<$rows;$x++){?>

    <tr>



      <td><?=++$sl;?></td>

      <td><?=$item_id[$x];?></td>

      <td><?=$sub_group_name[$x];?></td>

      <td><?=$item_name[$x];?></td>

	  <td><?=$item_location[$x];?></td>

	    <td><?=$use_for[$x];?></td>



      <td><?=$unit_name[$x]?></td>

	   <?

        foreach($mm['m'] as $k=>$m) {

    ?>

	   <td style="text-align:right"> <? if ($receive[$m][$item_id[$x]][$k]>0) echo $receive[$m][$item_id[$x]][$k];?></td>

     

	   <? } ?>

	   
    </tr>



    <? } ?>



    <?php /*?><tr>

      <td colspan="<?=7;?>"><strong>Total: </strong></td>

	   <?

      foreach($t_rec as $rec){ ?>

	   <td style="text-align:right"><strong><?=number_format(($rec),0)?></strong></td>

	   <? }?>

	  



    </tr><?php */?>



  </tbody>





</table>



<?







}




// Monthly IN Report, Modify on 6th Dec,2022; By M A HASAN



if($_POST['report']==61122) 




{

$current_date=date("Y-m-d");



$sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,j.item_price,sum(j.item_in) as issued



from item_info i, item_sub_group s,journal_item j,warehouse_other_receive_detail o 



where j.warehouse_id="'.$_SESSION['user']['depot'].'" and i.item_id = j.item_id and i.sub_group_id=s.sub_group_id and o.item_id=j.item_id



'.$item_sub_con.$item_con.$date_con.$trans_con.' 



group by i.item_id 



order by i.item_name'; 





$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>





   <?

	



  //// find year and month from date range



  $fr_year = date('Y',strtotime($fr_date));

  $to_year = date('Y',strtotime($to_date));



  $fr_month = date('m',strtotime($fr_date));

  $to_month = date('m',strtotime($to_date));



  $yy = array();

  $mm = array();



  for($y=$fr_year;$y<=$to_year; $y++) {

    $yy[] = $y;

    if($y==$fr_year) {

      $start_month = $fr_month;

    } else {

      $start_month = 1;

    }

    if($y==$to_year) {

      $end_month = $to_month;

    } else {

      $end_month = 12;

    }

    for($m=$start_month;$m<=$end_month; $m++) {

      $mm['m'][] = $m;

      $mm['y'][] = $y;

    }

  }

 



  $t_rec = array();



	$query =db_query($sql3);   

	

	$rows = mysqli_num_rows($query);

	$j=0;



while($data=mysqli_fetch_object($query)){







$item_id[$j]=$data->item_id;



$sub_group_name[$j]=$data->sub_group_name;



$item_name[$j]=$data->item_name;



$item_location[$j]=$data->item_location;



$unit_name[$j]=$data->unit_name;



//$use_for[$j]=$data->use_for;



$treceive = 0;

foreach($mm['m'] as $k=>$m) {

  $receive[$m][$data->item_id][$k] = number_format($receives = find_a_field('journal_item','sum(item_in)','item_id="'.$data->item_id.'" and month(ji_date)="'.$m.'"  and year(ji_date)="'.$mm['y'][$k].'" '),0);

  $treceive+=$receives;  

  $t_rec[$m] = $t_rec[$m]+$receives;

  $colspan+=1;

  

}







$j++;



}

 ?>





<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="<?=6+$colspan;?>"><div class="header">



          <h1>Olympic Cement Limited</h1>



          <h2>



            <?=$report?>



          </h2>



          <h2>Closing Stock of Date-



            <?=$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>

      <th>Item Code</th>

      <th>Item Group</th>

      <th>Item Name</th>

	  <th>Item Location</th>

	  

	  <?php /*?> <th>Use For</th><?php */?>



      <th>Unit</th>

	  <? 

        foreach($mm['m'] as $k=>$m) {

    ?>



      <th colspan=""><?=date('F,Y',strtotime($mm['y'][$k].'-'.$m.'-01'));?></th>

	  <? }?>

	



    </tr>



  </thead>



  <tbody>

 



<? for($x=0;$x<$rows;$x++){?>

    <tr>



      <td><?=++$sl;?></td>

      <td><?=$item_id[$x];?></td>

      <td><?=$sub_group_name[$x];?></td>

      <td><?=$item_name[$x];?></td>

	  <td><?=$item_location[$x];?></td>

	    <?php /*?><td><? //=$use_for[$x];?></td><?php */?>



      <td><?=$unit_name[$x]?></td>

	   <?

        foreach($mm['m'] as $k=>$m) {

    ?>

	   <td style="text-align:right"> <? if ($receive[$m][$item_id[$x]][$k]>0) echo $receive[$m][$item_id[$x]][$k];?></td>

     

	   <? } ?>

	   
    </tr>



    <? } ?>



   <?php /*?> <tr>

      <td colspan="<?=6;?>"><strong>Total: </strong></td>

	   <?

      foreach($t_rec as $rec){ ?>

	   <td style="text-align:right"><strong><?=number_format(($rec),0)?></strong></td>

	   <? }?>

	  



    </tr>
<?php */?>


  </tbody>





</table>



<?







}

//Monthly Transport wise receive Report, Modify on 10th April,2023; By M A HASAN

if($_POST['report']==10423) 




{

$current_date=date("Y-m-d");



 $sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,j.item_price,sum(j.item_in) as issued,m.requisition_from



from item_info i, item_sub_group s,journal_item j,warehouse_other_receive_detail o,warehouse_other_receive m 



where j.warehouse_id="'.$_SESSION['user']['depot'].'" and i.item_id = j.item_id and i.sub_group_id=s.sub_group_id and o.item_id=j.item_id and m.or_no=o.or_no and m.requisition_from="Automobile"



'.$item_sub_con.$item_con.$date_con.$trans_con.' 



group by i.item_id 



order by i.item_name'; 





$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>





   <?

	



  //// find year and month from date range



  $fr_year = date('Y',strtotime($fr_date));

  $to_year = date('Y',strtotime($to_date));



  $fr_month = date('m',strtotime($fr_date));

  $to_month = date('m',strtotime($to_date));



  $yy = array();

  $mm = array();



  for($y=$fr_year;$y<=$to_year; $y++) {

    $yy[] = $y;

    if($y==$fr_year) {

      $start_month = $fr_month;

    } else {

      $start_month = 1;

    }

    if($y==$to_year) {

      $end_month = $to_month;

    } else {

      $end_month = 12;

    }

    for($m=$start_month;$m<=$end_month; $m++) {

      $mm['m'][] = $m;

      $mm['y'][] = $y;

    }

  }

 



  $t_rec = array();



	$query =db_query($sql3);   

	

	$rows = mysqli_num_rows($query);

	$j=0;



while($data=mysqli_fetch_object($query)){







$item_id[$j]=$data->item_id;



$sub_group_name[$j]=$data->sub_group_name;



$item_name[$j]=$data->item_name;



$item_location[$j]=$data->item_location;



$unit_name[$j]=$data->unit_name;



$use_for[$j]=$data->requisition_from;



$treceive = 0;

foreach($mm['m'] as $k=>$m) {

  $receive[$m][$data->item_id][$k] = number_format($receives = find_a_field('journal_item','sum(item_in)','item_id="'.$data->item_id.'" and month(ji_date)="'.$m.'"  and year(ji_date)="'.$mm['y'][$k].'" '),0);

  $treceive+=$receives;  

  $t_rec[$m] = $t_rec[$m]+$receives;

  $colspan+=1;

  

}







$j++;



}

 ?>





<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="<?=7+$colspan;?>"><div class="header">



          <br /><h1>Olympic Cement Limited</h1><br />



          <h2>



           <strong> <?=$report?></strong>



          </h2>



          <h2>Closing Stock of Date-



            <?=$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>

      <th>Item Code</th>

      <th>Item Group</th>

      <th>Item Name</th>

	  <th>Item Location</th>

	  

	   <th>Use For</th>



      <th>Unit</th>

	  <? 

        foreach($mm['m'] as $k=>$m) {

    ?>



      <th colspan=""><?=date('F,Y',strtotime($mm['y'][$k].'-'.$m.'-01'));?></th>

	  <? }?>

	



    </tr>



  </thead>



  <tbody>

 



<? for($x=0;$x<$rows;$x++){?>

    <tr>



      <td><?=++$sl;?></td>

      <td><?=$item_id[$x];?></td>

      <td><?=$sub_group_name[$x];?></td>

      <td><?=$item_name[$x];?></td>

	  <td><?=$item_location[$x];?></td>

	    <td><?=$use_for[$x];?></td>



      <td><?=$unit_name[$x]?></td>

	   <?

        foreach($mm['m'] as $k=>$m) {

    ?>

	   <td style="text-align:right"> <? if ($receive[$m][$item_id[$x]][$k]>0) echo $receive[$m][$item_id[$x]][$k];?></td>

     

	   <? } ?>

	   
    </tr>



    <? } ?>



   <?php /*?> <tr>

      <td colspan="<?=7;?>"><strong>Total: </strong></td>

	   <?

      foreach($t_rec as $rec){ ?>

	   <td style="text-align:right"><strong><?=number_format(($rec),0)?></strong></td>

	   <? }?>

	  



    </tr><?php */?>



  </tbody>





</table>



<?







}


//Monthly Payloader wise Issue Report, Modify on 25th May,2023; By M A HASAN




if($_POST['report']==24523) 



{

$current_date=date("Y-m-d");



  $sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,j.item_price,sum(j.item_ex) as issued, o.use_for



from item_info i, item_sub_group s,journal_item j,warehouse_other_issue_detail o 



where j.warehouse_id="'.$_SESSION['user']['depot'].'" and i.item_id = j.item_id and i.sub_group_id=s.sub_group_id and o.item_id=j.item_id and o.oi_no=j.sr_no and o.id=j.tr_no and o.use_for like "%'."Payloader".'%"



'.$item_sub_con.$item_con.$date_con.$trans_con.' 



group by i.item_id 



order by i.item_name'; 





$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>





   <?

	



  //// find year and month from date range



  $fr_year = date('Y',strtotime($fr_date));

  $to_year = date('Y',strtotime($to_date));



  $fr_month = date('m',strtotime($fr_date));

  $to_month = date('m',strtotime($to_date));



  $yy = array();

  $mm = array();



  for($y=$fr_year;$y<=$to_year; $y++) {

    $yy[] = $y;

    if($y==$fr_year) {

      $start_month = $fr_month;

    } else {

      $start_month = 1;

    }

    if($y==$to_year) {

      $end_month = $to_month;

    } else {

      $end_month = 12;

    }

    for($m=$start_month;$m<=$end_month; $m++) {

      $mm['m'][] = $m;

      $mm['y'][] = $y;

    }

  }

 



  $t_rec = array();



	$query =db_query($sql3);   

	

	$rows = mysqli_num_rows($query);

	$j=0;



while($data=mysqli_fetch_object($query)){







$item_id[$j]=$data->item_id;



$sub_group_name[$j]=$data->sub_group_name;



$item_name[$j]=$data->item_name;



$item_location[$j]=$data->item_location;



$unit_name[$j]=$data->unit_name;



$use_for[$j]=$data->use_for;



$treceive = 0;

foreach($mm['m'] as $k=>$m) {

  $receive[$m][$data->item_id][$k] = number_format($receives = find_a_field('warehouse_other_issue_detail ','sum(qty)','item_id="'.$data->item_id.'" and month(oi_date)="'.$m.'"  and year(oi_date)="'.$mm['y'][$k].'" and use_for="'.$data->use_for.'" '),0);

  $treceive+=$receives;  

  $t_rec[$m] = $t_rec[$m]+$receives;

  $colspan+=1;

  

}







// for($y=(int)date('m',strtotime($fr_date));$y<=date('m',strtotime($to_date)); $y++) {

// 	  $receive[$y][$data->item_id][] = $receives = number_format(find_a_field('journal_item','sum(item_ex)','item_id="'.$data->item_id.'" and month(ji_date)="'.$y.'"  and year(ji_date)="'.date('Y',strtotime($fr_date)).'" '),0);

// 	 $yy[] = $y;

// 	$treceive+=$receives;  //$trec[$y]+=$receive;

// 	$colspan+=1;

// }

///



$j++;



}

 ?>





<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="<?=7+$colspan;?>"><div class="header">



          <br /><h1>OLYMPIC CEMENT LIMITED</h1><br />



          <h2>



           <strong> <?=$report?></strong>



          </h2>



          <h2>Closing Stock of Date-



            <?=$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>

      <th>Item Code</th>

      <th>Item Group</th>

      <th>Item Name</th>

	  <th>Item Location</th>

	  

	   <th>Use For</th>



      <th>Unit</th>

	  <? 

        foreach($mm['m'] as $k=>$m) {

    ?>



      <th colspan=""><?=date('F,Y',strtotime($mm['y'][$k].'-'.$m.'-01'));?></th>

	  <? }?>

	



    </tr>



  </thead>



  <tbody>

 



<? for($x=0;$x<$rows;$x++){?>

    <tr>



      <td><?=++$sl;?></td>

      <td><?=$item_id[$x];?></td>

      <td><?=$sub_group_name[$x];?></td>

      <td><?=$item_name[$x];?></td>

	  <td><?=$item_location[$x];?></td>

	    <td><?=$use_for[$x];?></td>



      <td><?=$unit_name[$x]?></td>

	   <?

        foreach($mm['m'] as $k=>$m) {

    ?>

	   <td style="text-align:right"> <? if ($receive[$m][$item_id[$x]][$k]>0) echo $receive[$m][$item_id[$x]][$k];?></td>

     

	   <? } ?>

	   
    </tr>



    <? } ?>



    <?php /*?><tr>

      <td colspan="<?=7;?>"><strong>Total: </strong></td>

	   <?

      foreach($t_rec as $rec){ ?>

	   <td style="text-align:right"><strong><?=number_format(($rec),0)?></strong></td>

	   <? }?>

	  



    </tr><?php */?>



  </tbody>





</table>



<?







}



//Monthly Packer wise Issue Report, Modify on 25th May,2023; By M A HASAN

if($_POST['report']==25523) 




{

$current_date=date("Y-m-d");



  $sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,j.item_price,sum(j.item_ex) as issued, o.use_for



from item_info i, item_sub_group s,journal_item j,warehouse_other_issue_detail o 



where j.warehouse_id="'.$_SESSION['user']['depot'].'" and i.item_id = j.item_id and i.sub_group_id=s.sub_group_id and o.item_id=j.item_id and o.oi_no=j.sr_no and o.id=j.tr_no

and o.use_for like "%'."Packer".'%"

'.$item_sub_con.$item_con.$date_con.$trans_con.' 



group by i.item_id 



order by i.item_name'; 





$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>





   <?

	



  //// find year and month from date range



  $fr_year = date('Y',strtotime($fr_date));

  $to_year = date('Y',strtotime($to_date));



  $fr_month = date('m',strtotime($fr_date));

  $to_month = date('m',strtotime($to_date));



  $yy = array();

  $mm = array();



  for($y=$fr_year;$y<=$to_year; $y++) {

    $yy[] = $y;

    if($y==$fr_year) {

      $start_month = $fr_month;

    } else {

      $start_month = 1;

    }

    if($y==$to_year) {

      $end_month = $to_month;

    } else {

      $end_month = 12;

    }

    for($m=$start_month;$m<=$end_month; $m++) {

      $mm['m'][] = $m;

      $mm['y'][] = $y;

    }

  }

 



  $t_rec = array();



	$query =db_query($sql3);   

	

	$rows = mysqli_num_rows($query);

	$j=0;



while($data=mysqli_fetch_object($query)){







$item_id[$j]=$data->item_id;



$sub_group_name[$j]=$data->sub_group_name;



$item_name[$j]=$data->item_name;



$item_location[$j]=$data->item_location;



$unit_name[$j]=$data->unit_name;



$use_for[$j]=$data->use_for;



$treceive = 0;

foreach($mm['m'] as $k=>$m) {

  $receive[$m][$data->item_id][$k] = number_format($receives = find_a_field('warehouse_other_issue_detail ','sum(qty)','item_id="'.$data->item_id.'" and month(oi_date)="'.$m.'"  and year(oi_date)="'.$mm['y'][$k].'" and use_for="'.$data->use_for.'" '),0);

  $treceive+=$receives;  

  $t_rec[$m] = $t_rec[$m]+$receives;

  $colspan+=1;

  

}







// for($y=(int)date('m',strtotime($fr_date));$y<=date('m',strtotime($to_date)); $y++) {

// 	  $receive[$y][$data->item_id][] = $receives = number_format(find_a_field('journal_item','sum(item_ex)','item_id="'.$data->item_id.'" and month(ji_date)="'.$y.'"  and year(ji_date)="'.date('Y',strtotime($fr_date)).'" '),0);

// 	 $yy[] = $y;

// 	$treceive+=$receives;  //$trec[$y]+=$receive;

// 	$colspan+=1;

// }

///



$j++;



}

 ?>





<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="<?=7+$colspan;?>"><div class="header">



          <br /><h1>OLYMPIC CEMENT LIMITED</h1><br />



          <h2>



           <strong> <?=$report?></strong>



          </h2>



          <h2>Closing Stock of Date-



            <?=$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>

      <th>Item Code</th>

      <th>Item Group</th>

      <th>Item Name</th>

	  <th>Item Location</th>

	  

	   <th>Use For</th>



      <th>Unit</th>

	  <? 

        foreach($mm['m'] as $k=>$m) {

    ?>



      <th colspan=""><?=date('F,Y',strtotime($mm['y'][$k].'-'.$m.'-01'));?></th>

	  <? }?>

	



    </tr>



  </thead>



  <tbody>

 



<? for($x=0;$x<$rows;$x++){?>

    <tr>



      <td><?=++$sl;?></td>

      <td><?=$item_id[$x];?></td>

      <td><?=$sub_group_name[$x];?></td>

      <td><?=$item_name[$x];?></td>

	  <td><?=$item_location[$x];?></td>

	    <td><?=$use_for[$x];?></td>



      <td><?=$unit_name[$x]?></td>

	   <?

        foreach($mm['m'] as $k=>$m) {

    ?>

	   <td style="text-align:right"> <? if ($receive[$m][$item_id[$x]][$k]>0) echo $receive[$m][$item_id[$x]][$k];?></td>

     

	   <? } ?>

	   
    </tr>



    <? } ?>



    <?php /*?><tr>

      <td colspan="<?=7;?>"><strong>Total: </strong></td>

	   <?

      foreach($t_rec as $rec){ ?>

	   <td style="text-align:right"><strong><?=number_format(($rec),0)?></strong></td>

	   <? }?>

	  



    </tr><?php */?>



  </tbody>





</table>



<?







}


//Monthly E-Crane wise Issue Report, Modify on 25th May,2023; By M A HASAN

if($_POST['report']==250523) 



{

$current_date=date("Y-m-d");



   $sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,j.item_price,sum(j.item_ex) as issued, o.use_for



from item_info i, item_sub_group s,journal_item j,warehouse_other_issue_detail o 



where j.warehouse_id="'.$_SESSION['user']['depot'].'" and i.item_id = j.item_id and i.sub_group_id=s.sub_group_id and o.item_id=j.item_id and o.oi_no=j.sr_no and o.id=j.tr_no

and o.use_for like "%'."E-Crane".'%"

'.$item_sub_con.$item_con.$date_con.$trans_con.' 



group by i.item_id 



order by i.item_name'; 





$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>





   <?

	



  //// find year and month from date range



  $fr_year = date('Y',strtotime($fr_date));

  $to_year = date('Y',strtotime($to_date));



  $fr_month = date('m',strtotime($fr_date));

  $to_month = date('m',strtotime($to_date));



  $yy = array();

  $mm = array();



  for($y=$fr_year;$y<=$to_year; $y++) {

    $yy[] = $y;

    if($y==$fr_year) {

      $start_month = $fr_month;

    } else {

      $start_month = 1;

    }

    if($y==$to_year) {

      $end_month = $to_month;

    } else {

      $end_month = 12;

    }

    for($m=$start_month;$m<=$end_month; $m++) {

      $mm['m'][] = $m;

      $mm['y'][] = $y;

    }

  }

 



  $t_rec = array();



	$query =db_query($sql3);   

	

	$rows = mysqli_num_rows($query);

	$j=0;



while($data=mysqli_fetch_object($query)){







$item_id[$j]=$data->item_id;



$sub_group_name[$j]=$data->sub_group_name;



$item_name[$j]=$data->item_name;



$item_location[$j]=$data->item_location;



$unit_name[$j]=$data->unit_name;



$use_for[$j]=$data->use_for;



$treceive = 0;

foreach($mm['m'] as $k=>$m) {

  $receive[$m][$data->item_id][$k] = number_format($receives = find_a_field('warehouse_other_issue_detail ','sum(qty)','item_id="'.$data->item_id.'" and month(oi_date)="'.$m.'"  and year(oi_date)="'.$mm['y'][$k].'" and use_for="'.$data->use_for.'" '),0);

  $treceive+=$receives;  

  $t_rec[$m] = $t_rec[$m]+$receives;

  $colspan+=1;

  

}







// for($y=(int)date('m',strtotime($fr_date));$y<=date('m',strtotime($to_date)); $y++) {

// 	  $receive[$y][$data->item_id][] = $receives = number_format(find_a_field('journal_item','sum(item_ex)','item_id="'.$data->item_id.'" and month(ji_date)="'.$y.'"  and year(ji_date)="'.date('Y',strtotime($fr_date)).'" '),0);

// 	 $yy[] = $y;

// 	$treceive+=$receives;  //$trec[$y]+=$receive;

// 	$colspan+=1;

// }

///



$j++;



}

 ?>





<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="<?=7+$colspan;?>"><div class="header">



          <br /><h1>OLYMPIC CEMENT LIMITED</h1><br />



          <h2>



           <strong> <?=$report?></strong>



          </h2>



          <h2>Closing Stock of Date-



            <?=$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>

      <th>Item Code</th>

      <th>Item Group</th>

      <th>Item Name</th>

	  <th>Item Location</th>

	  

	   <th>Use For</th>



      <th>Unit</th>

	  <? 

        foreach($mm['m'] as $k=>$m) {

    ?>



      <th colspan=""><?=date('F,Y',strtotime($mm['y'][$k].'-'.$m.'-01'));?></th>

	  <? }?>

	



    </tr>



  </thead>



  <tbody>

 



<? for($x=0;$x<$rows;$x++){?>

    <tr>



      <td><?=++$sl;?></td>

      <td><?=$item_id[$x];?></td>

      <td><?=$sub_group_name[$x];?></td>

      <td><?=$item_name[$x];?></td>

	  <td><?=$item_location[$x];?></td>

	    <td><?=$use_for[$x];?></td>



      <td><?=$unit_name[$x]?></td>

	   <?

        foreach($mm['m'] as $k=>$m) {

    ?>

	   <td style="text-align:right"> <? if ($receive[$m][$item_id[$x]][$k]>0) echo $receive[$m][$item_id[$x]][$k];?></td>

     

	   <? } ?>

	   
    </tr>



    <? } ?>



    <?php /*?><tr>

      <td colspan="<?=7;?>"><strong>Total: </strong></td>

	   <?

      foreach($t_rec as $rec){ ?>

	   <td style="text-align:right"><strong><?=number_format(($rec),0)?></strong></td>

	   <? }?>

	  



    </tr><?php */?>



  </tbody>





</table>



<?







}


//Monthly Issue Type wise Issue Report, Modify on 25th May,2023; By M A HASAN

if($_POST['report']==23523) 



{

$current_date=date("Y-m-d");



   $sql3='select i.item_id,i.unit_name,i.item_name,i.item_location,s.sub_group_name,i.finish_goods_code,i.d_price,j.item_price,sum(j.item_ex) as issued, o.use_for



from item_info i, item_sub_group s,journal_item j,warehouse_other_issue_detail o 



where j.warehouse_id="'.$_SESSION['user']['depot'].'" and i.item_id = j.item_id and i.sub_group_id=s.sub_group_id and o.item_id=j.item_id and o.oi_no=j.sr_no and o.id=j.tr_no



'.$item_sub_con.$item_con.$date_con.$trans_con.' 



group by i.item_id 



order by i.item_name'; 





$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);



?>





   <?

	



  //// find year and month from date range



  $fr_year = date('Y',strtotime($fr_date));

  $to_year = date('Y',strtotime($to_date));



  $fr_month = date('m',strtotime($fr_date));

  $to_month = date('m',strtotime($to_date));



  $yy = array();

  $mm = array();



  for($y=$fr_year;$y<=$to_year; $y++) {

    $yy[] = $y;

    if($y==$fr_year) {

      $start_month = $fr_month;

    } else {

      $start_month = 1;

    }

    if($y==$to_year) {

      $end_month = $to_month;

    } else {

      $end_month = 12;

    }

    for($m=$start_month;$m<=$end_month; $m++) {

      $mm['m'][] = $m;

      $mm['y'][] = $y;

    }

  }

 



  $t_rec = array();



	$query =db_query($sql3);   

	

	$rows = mysqli_num_rows($query);

	$j=0;



while($data=mysqli_fetch_object($query)){







$item_id[$j]=$data->item_id;



$sub_group_name[$j]=$data->sub_group_name;



$item_name[$j]=$data->item_name;



$item_location[$j]=$data->item_location;



$unit_name[$j]=$data->unit_name;



$use_for[$j]=$data->use_for;



$treceive = 0;

foreach($mm['m'] as $k=>$m) {

  $receive[$m][$data->item_id][$k] = number_format($receives = find_a_field('warehouse_other_issue_detail ','sum(qty)','item_id="'.$data->item_id.'" and month(oi_date)="'.$m.'"  and year(oi_date)="'.$mm['y'][$k].'" and use_for="'.$data->use_for.'" '),0);

  $treceive+=$receives;  

  $t_rec[$m] = $t_rec[$m]+$receives;

  $colspan+=1;

  

}







// for($y=(int)date('m',strtotime($fr_date));$y<=date('m',strtotime($to_date)); $y++) {

// 	  $receive[$y][$data->item_id][] = $receives = number_format(find_a_field('journal_item','sum(item_ex)','item_id="'.$data->item_id.'" and month(ji_date)="'.$y.'"  and year(ji_date)="'.date('Y',strtotime($fr_date)).'" '),0);

// 	 $yy[] = $y;

// 	$treceive+=$receives;  //$trec[$y]+=$receive;

// 	$colspan+=1;

// }

///



$j++;



}

 ?>





<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="<?=7+$colspan;?>"><div class="header">



          <br /><h1>OLYMPIC CEMENT LIMITED</h1><br />



          <h2>



           <strong> <?=$report?></strong>



          </h2>



          <h2>Closing Stock of Date-



            <?=$to_date?>



          </h2>



        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Item Sub Group: <?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$_REQUEST['item_sub_group'].'"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th>S/L</th>

      <th>Item Code</th>

      <th>Item Group</th>

      <th>Item Name</th>

	  <th>Item Location</th>

	  

	   <th>Use For</th>



      <th>Unit</th>

	  <? 

        foreach($mm['m'] as $k=>$m) {

    ?>



      <th colspan=""><?=date('F,Y',strtotime($mm['y'][$k].'-'.$m.'-01'));?></th>

	  <? }?>

	



    </tr>



  </thead>



  <tbody>

 



<? for($x=0;$x<$rows;$x++){?>

    <tr>



      <td><?=++$sl;?></td>

      <td><?=$item_id[$x];?></td>

      <td><?=$sub_group_name[$x];?></td>

      <td><?=$item_name[$x];?></td>

	  <td><?=$item_location[$x];?></td>

	    <td><?=$use_for[$x];?></td>



      <td><?=$unit_name[$x]?></td>

	   <?

        foreach($mm['m'] as $k=>$m) {

    ?>

	   <td style="text-align:right"> <? if ($receive[$m][$item_id[$x]][$k]>0) echo $receive[$m][$item_id[$x]][$k];?></td>

     

	   <? } ?>

	   
    </tr>



    <? } ?>



    <?php /*?><tr>

      <td colspan="<?=7;?>"><strong>Total: </strong></td>

	   <?

      foreach($t_rec as $rec){ ?>

	   <td style="text-align:right"><strong><?=number_format(($rec),0)?></strong></td>

	   <? }?>

	  



    </tr><?php */?>



  </tbody>

<tfoot>
<tr style="border:none">
<td colspan="<?=7+$colspan;?>" style="border:none">
<div style="width:100%"><br /><br />
<div style="width:33%; float:left; overflow:hidden; text-align:center"><strong><br />............................<br />Prepared By</strong></div>
<div style="width:33%; float: left; overflow:hidden; text-align:center"><strong><br />............................<br />Checked By</strong></div>
<div style="width:30%; float:right; overflow:hidden; text-align:center"><strong><br />............................<br />Confirmed By</strong></div>
</div>
</td>

</tr>
</tfoot>



</table>



<?







}





// Monthly Workshop Services Expenses Report, Modify on 11th January,2023; By M A HASAN

if($_POST['report']==110123) 



{


	//INSERT INTO `workshop_expense_detail` (`id`, `ws_no`, `item_id`, `vendor_id`, `issue_type`, `ws_date`, `warehouse_id`, `rate`, `qty`, `unit_name`, `discount`, `amount`, `use_for`, `entry_by`, `entry_at`, `edit_by`, `edit_at`) 

	

	//INSERT INTO `workshop_expense_master` (`ws_no`, `vendor_id`, `issued_to`, `oi_subject`, `bill_no`, `transport_name`, `discount`, `warehouse_id`, `ws_date`, `status`, `issue_type`, `approved_by`, `requisition_from`, `entry_at`, `entry_by`, `edit_at`, `edit_by`, `checked_at`, `checked_by`)

	

	//workshop_services_vendor;workshop_services

	

	

	$current_date=date("Y-m-d");



  $sqlws='select m.`ws_no`, d.`item_id`,  d.`ws_date`,   sum(d.`qty`) tqty, s.`unit_name`, sum(m.`discount`) tdiscount, sum(d.`amount`) tamount, v.vendor_name,m.transport_name,s.ws_name



from workshop_services s, workshop_expense_master m,workshop_expense_detail d,workshop_services_vendor v



where   



d.item_id = s.id and m.ws_no=d.ws_no and v.vendor_id=d.vendor_id



'.$trans_con.$item_con.$date_con.' 





group by d.item_id

order by s.ws_name';



	





?>





   <?

	



  //// find year and month from date range



  $fr_year = date('Y',strtotime($fr_date));

  $to_year = date('Y',strtotime($to_date));



  $fr_month = date('m',strtotime($fr_date));

  $to_month = date('m',strtotime($to_date));



  $yy = array();

  $mm = array();



  for($y=$fr_year;$y<=$to_year; $y++) {

    $yy[] = $y;

    if($y==$fr_year) {

      $start_month = $fr_month;

    } else {

      $start_month = 1;

    }

    if($y==$to_year) {

      $end_month = $to_month;

    } else {

      $end_month = 12;

    }

    for($m=$start_month;$m<=$end_month; $m++) {

      $mm['m'][] = $m;

      $mm['y'][] = $y;

    }

  }

 



  $t_rec = array();
  
   $t_amt = array();




	$query =db_query($sqlws);   

	

	$rows = mysqli_num_rows($query);

	$j=0;



while($data=mysqli_fetch_object($query)){





$item_id[$j]=$data->item_id;



$transport_name[$j]=$data->transport_name;



$item_name[$j]=$data->ws_name;



$vendor_name[$j]=$data->vendor_name;



$unit_name[$j]=$data->unit_name;



$qty[$j]=$data->tqty;



$rate[$j]=$data->rate;



$amount[$j]=$data->tamount;








$treceive = 0;

$t_amount = 0;

//$t_discount = 0;

//$t_expense=0;

foreach($mm['m'] as $k=>$m) {

  $receive[$m][$data->item_id][$k] = number_format($receives = find_a_field('workshop_expense_detail d,workshop_expense_master m','sum(d.qty)','d.item_id="'.$data->item_id.'" and month(d.ws_date)="'.$m.'"  and year(d.ws_date)="'.$mm['y'][$k].'" and m.ws_no=d.ws_no and m.transport_name="'.$data->transport_name.'" '),0);
  
   $total_amt[$m][$data->item_id][$k] = number_format($tamt = find_a_field('workshop_expense_detail d,workshop_expense_master m','sum(d.amount)','d.item_id="'.$data->item_id.'" and month(d.ws_date)="'.$m.'"  and year(d.ws_date)="'.$mm['y'][$k].'" and m.ws_no=d.ws_no and m.transport_name="'.$data->transport_name.'" '),0);
   
  

  $treceive+=$receives;   
  $t_amount+=$tamt;  
 // $t_discount+=$tdiscount; 
  

  $t_rec[$m] = $t_rec[$m]+$receives;  
  $t_amt[$m] = $t_amt[$m]+$tamt; 
 // $t_dis[$m] = $t_dis[$m]+$tdiscount;
 // $t_expense+=($t_amt[$m]-$t_dis[$m]);
 // $t_exp[$m]=$t_exp[$m]+$t_expense;

  $colspan+=1;

  

}







$j++;



}

 ?>







 

<table width="100%" cellspacing="0" cellpadding="2" border="0">



  <thead>



    <tr>



      <td style="border:0px;" colspan="<?=5+($colspan*2);?>"><div class="header">



          <br /><h1>OLYMPIC CEMENT LIMITED</h1><br />



          <h2>



           <strong> <?=$report?></strong>



          </h2>





        </div>



        <div class="left"></div>



        <div class="" align="center"><strong>Transport name: <?=find_a_field('workshop_expense_master','transport_name','transport_name like "%'.$_REQUEST['trans_name'].'%"');?></strong></div>



        <div class="date">Reporting Time:



          <?=date("H:i A d-m-Y")?>



      </div></td>



    </tr>



    <tr>



      <th rowspan="2">S/L</th>



  

	  <th rowspan="2">Vendor_name</th>



      <th rowspan="2">Transport name</th>



     

 	<th rowspan="2">Services Name</th>

	  

	  <th rowspan="2">Unit Name</th>

      
 <? 

        foreach($mm['m'] as $k=>$m) {

    ?>



      <th colspan="2"><?=date('F,Y',strtotime($mm['y'][$k].'-'.$m.'-01'));?></th>

	  <? }?>
	  

	  <?php /*?><? for($a=date('Y-m',strtotime($fr_date));$a<=date('Y-m',strtotime($to_date)); $a++) {?>



      <th colspan="2" rowspan=""><?=date('F,Y',strtotime($a));?></th>

	  <? }?>
<?php */?>
	  



    </tr>

	<tr>

	 <? 

        foreach($mm['m'] as $k=>$m) {

    ?>

	<th align="center">Qty</th>

	<th align="center">Amount</th>

	  <? }?>

	</tr>



  </thead>



  <tbody>




		   

		   <? for($x=0;$x<$rows;$x++){?>



    <tr>



      <td><?=++$sl;?></td>



      <td><?=$vendor_name[$x]?></td>



    

      <td><?=$transport_name[$x]; $trans_name=$transport_name[$x];?></td>

	  

	  <td><?=$item_name[$x];?></td>



      <td><?=$unit_name[$x]?></td>
	  
	   <?

        foreach($mm['m'] as $k=>$m) {

    ?>

	   <td style="text-align:right"> <? if ($receive[$m][$item_id[$x]][$k]>0) echo $receive[$m][$item_id[$x]][$k]; ?></td>
	   
	   <td style="text-align:right"> <? if ($total_amt[$m][$item_id[$x]][$k]>0) echo $total_amt[$m][$item_id[$x]][$k]; $tttamt+=$total_amt[$m][$item_id[$x]][$k];?></td>

     

	   <? } ?>


	  <?php /*?> <? 

        foreach($mm['m'] as $k=>$m) {

    ?>
	   <td style="text-align:right"><?=$qty=number_format(find_a_field('workshop_expense_detail','sum(qty)','item_id="'.$item_id[$x].'" and month(ws_date)="'.$y.'"  and year(ws_date)="'.date('Y',strtotime($fr_date)).'" '),0);$treceive+=$qty;?></td>

	   

	    <td style="text-align:right"><?=$amount=find_a_field('workshop_expense_detail','sum(amount)','item_id="'.$item_id[$x].'" and month(ws_date)="'.$y.'"  and year(ws_date)="'.date('Y',strtotime($fr_date)).'" ');$tamnt+=$amount;?></td>

	   <? }

	 // $tamnt=$treceive;

	   ?><?php */?>

	   



    </tr>



    <?



}



		



?>



    <tr>

      <td colspan="<?=5;?>"><strong>Total: </strong></td>

	   <?

      foreach($t_amt as $tamtt){ ?>

	   <td style="text-align:right" colspan="2"><strong><?=$totalamt=number_format(($tamtt),0)?></strong></td>

	   <? }?>

	  



    </tr>
	
	<tr>

      <td colspan="<?=5;?>"><strong>Total Discount: </strong></td>

	   <?

       foreach($mm['m'] as $k=>$m) { 
	   
	  
	   
	   ?>
	   
	  

	   <td style="text-align:right" colspan="2"><strong><? echo $total_discount= number_format($tdiscount[] = find_a_field('workshop_expense_master m','sum(m.discount)','month(m.ws_date)="'.$m.'"  and year(m.ws_date)="'.$mm['y'][$k].'" '.$trans_con.' '),0); ?></strong></td>

	   <? }?>

	  



    </tr>
	
	<tr>

      <td colspan="<?=5;?>"><strong>Net Expense: </strong></td>

	   <?
//echo $tdisss=$total_discount;
		
		$d=0;

      foreach($t_amt as $tamtt){ 
	  
	  
	  ?>

	   <td style="text-align:right" colspan="2"><strong><?=number_format(($tamtt-$tdiscount[$d]),0)?></strong></td>

	   <? ++$d; }?>

	  



    </tr>



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



    <tr>



      <td colspan="17" style="border:0px;"><?



		echo '<div class="header">';



		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



		if(isset($report)) 



		echo '<h2>'.$report.'</h2>';



		



?>



        <h2>



          <? if($sub_group_id>0) echo 'Sub Group: '.find_a_field('item_sub_group','sub_group_name','sub_group_id='.$sub_group_id)?>



        </h2>



        <?



if(isset($t_date)) 



		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



		echo '</div>';







		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



		?>



      </td>



    </tr>



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



  </thead>



  <tbody>



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



      <td><a target="_blank" href="../ws/product_transection_report_master.php?item_id=<?=$row->item_id?>&f_date=<?=$f_date?>&t_date=<?=$t_date?>&submit=3&report=3">



        <?=$row->item_id?>



      </a></td>



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



    </tr>



    <? }?>



  </tbody>



</table>



<?



}



elseif($_POST['report']==1009)



{



		$report="Daily Stock Issue Report";



		?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



  <thead>



    <tr>



      <td colspan="9" style="border:0px;"><?



		echo '<div class="header">';



		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



		if(isset($report)) 



		echo '<h2>'.$report.'-'.$_POST['sales_item_type'].'</h2>';







if(isset($t_date)) 



		echo '<h2>Reporting Date : '.$t_date.'</h2>';



		echo '</div>';







		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



		



		







		if($_POST['sales_item_type']!='')



		$dg = ' and i.sales_item_type like "%'.$_POST['sales_item_type'].'%"';



		$sql="select distinct i.item_id,i.item_name,i.sales_item_type,i.pack_size,i.finish_goods_code,i.sales_item_type from item_info i, journal_item c where  i.finish_goods_code>0 and c.item_ex>0 and c.item_id=i.item_id and c.ji_date='".$_POST['t_date']."' and i.finish_goods_code!=2000 and i.finish_goods_code!=2001 ".$dg." and c.warehouse_id='".$_SESSION['user']['depot']."' order by i.item_id";



		$res	 = db_query($sql);



		$rows = mysqli_num_rows($res);



		while($row=mysqli_fetch_object($res))



		{



		$item_code[] = $row->item_id;



		$item_name[] = $row->item_name;



		$sales_item_type[] = $row->sales_item_type;



		$pack_size[] = $row->pack_size;



		$finish_goods_code[] = $row->finish_goods_code;



		}



		



		$sql="select distinct c.chalan_no,c.driver_name from item_info i,sale_do_chalan c where c.chalan_type='Delivery' and i.item_id=c.item_id  and c.chalan_date='".$_POST['t_date']."' and c.depot_id='".$_SESSION['user']['depot']."'  ".$dg." order by c.chalan_no ";



		$res	 = db_query($sql);



		$chalan = mysqli_num_rows($res);



		while($row=mysqli_fetch_object($res))



		{$rsr_no[] = $row->chalan_no; $dsr_no[] = $row->driver_name;}



		



		$sql="select distinct c.sr_no from item_info i,journal_item c where i.item_id=c.item_id  and c.ji_date='".$_POST['t_date']."' and c.warehouse_id='".$_SESSION['user']['depot']."'  ".$dg." and (c.tr_from = 'Reprocess Issue'||c.tr_from = 'Issue'||c.tr_from = 'Transit'||c.tr_from = 'Transfered') and c.item_ex>0 order by c.sr_no ";



		$res	 = db_query($sql);



		$store = mysqli_num_rows($res);



		while($row=mysqli_fetch_object($res))



		{$srsr_no[] = $row->sr_no; $sdsr_no[] = $row->sr_no;}



		



		$sql="select distinct c.sr_no,ch.driver_name from item_info i,journal_item c, sale_other_chalan ch where ch.chalan_no=c.sr_no and i.item_id=c.item_id  and c.ji_date='".$_POST['t_date']."' and c.warehouse_id='".$_SESSION['user']['depot']."'  ".$dg." and (c.tr_from = 'Other Sales'||c.tr_from = 'Staff Sales') and c.item_ex>0 order by c.sr_no ";



		$res	 = db_query($sql);



		$os = mysqli_num_rows($res);



		while($row=mysqli_fetch_object($res))



		{$ossr_no[] = $row->sr_no; $osdsr_no[] = $row->driver_name;}



		



		$sql="select distinct c.sr_no,ch.driver_name from item_info i,journal_item c, sale_other_chalan ch where ch.chalan_no=c.sr_no and i.item_id=c.item_id  and c.ji_date='".$_POST['t_date']."' and c.warehouse_id='".$_SESSION['user']['depot']."'  ".$dg." and (c.tr_from = 'Entertainment Issue'||c.tr_from = 'Sample Issue'||c.tr_from = 'Gift Issue') and c.item_ex>0 order by c.sr_no ";



		$res	 = db_query($sql);



		$other = mysqli_num_rows($res);



		while($row=mysqli_fetch_object($res))



		{$orsr_no[] = $row->sr_no; $odsr_no[] = $row->driver_name;}



		



		$sql="select sum(item_ex-item_in) as item_ex,item_id,tr_no,sr_no,tr_from from journal_item where ji_date='".$_POST['t_date']."' and warehouse_id='".$_SESSION['user']['depot']."' group by item_id,sr_no,tr_from";



		$res	 = db_query($sql);



		while($row=mysqli_fetch_object($res))



		{



			if($row->tr_from=='Sales'||$row->tr_from=='SalesReturn')



			$citem_ex[$row->sr_no][$row->item_id] = $citem_ex[$row->sr_no][$row->item_id] + $row->item_ex;



			



			elseif(($row->tr_from=='Reprocess Issue')||($row->tr_from=='Issue')||($row->tr_from=='Transfered')||($row->tr_from=='Transit'))



			$sitem_ex[$row->sr_no][$row->item_id] = $row->item_ex;



			



			elseif(($row->tr_from=='Staff Sales')||($row->tr_from=='Other Sales'))



			$ositem_ex[$row->sr_no][$row->item_id] = $row->item_ex;



			else



			$oitem_ex[$row->sr_no][$row->item_id] = $row->item_ex;



		}



		?>



      </td>



    </tr>



    <tr>



      <th rowspan="2">S/L</th>



      <th rowspan="2">Item Name </th>



      <? if($chalan>0){?>



      <th colspan="<?=$chalan?>"><div align="center">Party Chalan</div></th>



      <? }?>



      <? if($os>0){?>



      <th colspan="<?=$os?>" style="text-align:center">Other Sales</th>



      <? }?>



      <th bgcolor="#99CC99" style="text-align:center">Total</th>



      <? if($store>0){?>



      <th colspan="<?=$store?>"><div align="center">Store Chalan</div></th>



      <? }?>



      <th bgcolor="#99CC99" style="text-align:center">Total</th>



      <? if($other>0){?>



      <th colspan="<?=$other?>"><div align="center">Other Issue</div></th>



      <? }?>



      <th bgcolor="#99CC99" style="text-align:center">Total</th>



      <th bgcolor="#99CC99" style="text-align:center">ALL-TOTAL</th>



    </tr>



    <tr>



      <? for($j=0;$j<$chalan;$j++){?>



      <th height="100" bgcolor="#339999" style="width:5px;"><font class="vertical-text">



        <?=$dsr_no[$j]?>



        </font></th>



      <? }?>



      <? for($j=0;$j<$os;$j++){?>



      <th height="100" bgcolor="#339999" style="width:5px;"><font class="vertical-text">



        <?=$osdsr_no[$j]?>



        </font></th>



      <? }?>



      <th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>



      <? for($j=0;$j<$store;$j++){?>



      <th height="100" bgcolor="#339999" style="width:5px;"><p><font class="vertical-text">



          <?=$sdsr_no[$j]?>



      </font></p></th>



      <? }?>



      <th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>



      <? for($j=0;$j<$other;$j++){?>



      <th height="100" bgcolor="#339999" style="width:5px;"><p><font class="vertical-text">



          <?=$odsr_no[$j]?>



        </font></p></th>



      <? }?>



      <th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>



      <th bgcolor="#339999" style="font-size:10px; font-weight:normal; padding:1px;">Ctn-Pcs</th>



    </tr>



  </thead>



  <tbody>



    <? for($x=0;$x<$rows;$x++){?>



    <tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



      <td><?=++$sl;?></td>



      <td><?=$item_name[$x]?>



        (



        <?=$finish_goods_code[$x]?>



        )</td>



      <!--1-->



      <? for($j=0;$j<$chalan;$j++){?>



      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><? if($citem_ex[$rsr_no[$j]][$item_code[$x]]>0)



					{



						$total[$item_code[$x]] = $total[$item_code[$x]] + $citem_ex[$rsr_no[$j]][$item_code[$x]];



						$ctotal[$item_code[$x]] = $ctotal[$item_code[$x]] + $citem_ex[$rsr_no[$j]][$item_code[$x]];



						echo (int)(($citem_ex[$rsr_no[$j]][$item_code[$x]])/$pack_size[$x]); 



						if((($citem_ex[$rsr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 



						echo '-'.(($citem_ex[$rsr_no[$j]][$item_code[$x]])%$pack_size[$x]);



					}?>



      </td>



      <? }?>



      <? for($j=0;$j<$os;$j++){?>



      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><? if($ositem_ex[$ossr_no[$j]][$item_code[$x]]>0)



					{



						$total[$item_code[$x]] = $total[$item_code[$x]] + $ositem_ex[$ossr_no[$j]][$item_code[$x]];



						$stotal[$item_code[$x]] = $stotal[$item_code[$x]] + $ositem_ex[$ossr_no[$j]][$item_code[$x]];



						echo (int)(($ositem_ex[$ossr_no[$j]][$item_code[$x]])/$pack_size[$x]); 



						if((($ositem_ex[$ossr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 



						echo '-'.(($ositem_ex[$ossr_no[$j]][$item_code[$x]])%$pack_size[$x]);



					}?>



      </td>



      <? }?>



      <td><?



					if($total[$item_code[$x]]>0)



					{



						echo (int)(($total[$item_code[$x]])/$pack_size[$x]); 



						if((($total[$item_code[$x]])%$pack_size[$x])>0) 



						echo '-'.(($total[$item_code[$x]])%$pack_size[$x]);



					}



					?>



      </td>



      <!--2-->



      <? for($j=0;$j<$store;$j++){?>



      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><? if($sitem_ex[$srsr_no[$j]][$item_code[$x]]>0)



					{



						$total[$item_code[$x]] = $total[$item_code[$x]] + $sitem_ex[$srsr_no[$j]][$item_code[$x]];



						$stotal[$item_code[$x]] = $stotal[$item_code[$x]] + $sitem_ex[$srsr_no[$j]][$item_code[$x]];



						echo (int)(($sitem_ex[$srsr_no[$j]][$item_code[$x]])/$pack_size[$x]); 



						if((($sitem_ex[$srsr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 



						echo '-'.(($sitem_ex[$srsr_no[$j]][$item_code[$x]])%$pack_size[$x]);



					}?>



      </td>



      <? }?>



      <td><?



					if($total[$item_code[$x]]>0)



					{



						echo (int)(($stotal[$item_code[$x]])/$pack_size[$x]); 



						if((($stotal[$item_code[$x]])%$pack_size[$x])>0) 



						echo '-'.(($stotal[$item_code[$x]])%$pack_size[$x]);



					}



					?>



      </td>



      <!--3-->



      <? for($j=0;$j<$other;$j++){?>



      <td style="font-family:Arial, Helvetica, sans-serif;size:11px; padding:0px;"><? if($oitem_ex[$orsr_no[$j]][$item_code[$x]]>0)



					{



						$total[$item_code[$x]] = $total[$item_code[$x]] + $oitem_ex[$orsr_no[$j]][$item_code[$x]];



						$ototal[$item_code[$x]] = $ototal[$item_code[$x]] + $oitem_ex[$orsr_no[$j]][$item_code[$x]];



						echo (int)(($oitem_ex[$orsr_no[$j]][$item_code[$x]])/$pack_size[$x]); 



						if((($oitem_ex[$orsr_no[$j]][$item_code[$x]])%$pack_size[$x])>0) 



						echo '-'.(($oitem_ex[$orsr_no[$j]][$item_code[$x]])%$pack_size[$x]);



					}?>



      </td>



      <? }?>



      <td><?



					if($total[$item_code[$x]]>0)



					{



						echo (int)(($ototal[$item_code[$x]])/$pack_size[$x]); 



						if((($ototal[$item_code[$x]])%$pack_size[$x])>0) 



						echo '-'.(($ototal[$item_code[$x]])%$pack_size[$x]);



					}



					?>



      </td>



      <td><?



					if($total[$item_code[$x]]>0)



					{



						echo (int)(($total[$item_code[$x]])/$pack_size[$x]); 



						if((($total[$item_code[$x]])%$pack_size[$x])>0) 



						echo '-'.(($total[$item_code[$x]])%$pack_size[$x]);



					}



					?>



      </td>



    </tr>



    <? }?>



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



    <tr>



      <td colspan="36" style="border:0px;"><?



		echo '<div class="header">';



		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



		if(isset($report)) 



		echo '<h2>'.$report.'</h2>';







if(isset($t_date)) 



		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



		echo '</div>';







		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



		?>



      </td>



    </tr>



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



      <th colspan="3" bgcolor="#339999" style="text-align:center">Other Receive </th>



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



  </thead>



  <tbody>



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



    </tr>



    <? }?>



  </tbody>



</table>



<?



}



// Requisition Summery report; modify on 10th October, 2022 by M A HASAN



if($_REQUEST['report']==101022)



{



$sql='';







?>







	<table width="100%" border="0" cellpadding="2" cellspacing="0">



		<thead>



		<tr><td colspan="17" style="border:0px;">



		<?



		echo '<div class="header">';



echo '<h1 style="text-align: center; font-weight: bold; text-shadow: 1px 1px 1px gray; height: 10px; font-size: 25px;">OLYMPIC CEMENT LTD.</h1>';



		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



		if(isset($report)) 



		echo '<h2>'.$report.'</h2>';



if($_REQUEST['group_id']!=''){echo '<h1 style="text-align: center; font-size: 15px; height: 10px; font-weight: bold;"> Group :'.find_a_field('item_group','group_name','1 and group_id='.$_REQUEST['group_id'],$group_name).'</h1>';};



		if($_REQUEST['warehouse_id']!=''){echo '<h1 style="text-align: center; font-size: 15px;  font-weight: bold;">Section : '.find_a_field('warehouse','warehouse_name','1 and warehouse_id='.$_REQUEST['warehouse_id'],$warehouse_name).'</h1>';};







if(isset($t_date)) 



		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



		echo '</div>';



		echo '<div class="date" style=" text-align:right; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



		



		



		











if($_POST['t_date']!='' || $_POST['f_date']!=''){ $date_con .=  'and a.req_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';}



if($_POST['item_id']!='') 				{$item_con=' and b.item_id='.$_POST['item_id'].' ';}



if($_POST['group_id']!='') 				{$g_con=' and g.group_id='.$_POST['group_id'];}



if($_POST['warehouse_id']!='') 				{$w_con=' and a.req_for='.$_POST['warehouse_id'];}

//if($_GET['status']!='') 				{$status_con=' and a.status='.$_GET['status'];}



		



		?>



		</td></tr>



		



		</thead>



		



		



<tbody>



	<tr>



	<td valign="top">



	<table  border="0" cellpadding="2" cellspacing="0">



	



	<thead>



	



<tr style="background: #B8B8B8; text-align:center; font-size: 16px; border: 1px solid black;" ><td colspan="9"><strong>Purchase Requisition</strong></td></tr>



	<tr valign="top">



<th width="14%">SL/NO</th>



		<th width="11%">Req No </th>



		<th width="11%">Req For </th>

		

		<th width="15%">PR Date</th>



      <th width="17%"><div align="center">Item Name</div></th>



	  <th width="14%"><div align="center">Group Name</div></th>



	  <th width="11%"><div align="center">Req qty</div></th>



      <th width="18%"><div align="center">Remarks</div></th>



	  </tr>



	  </thead>



	  <tbody>



	  



	  



	  



	  <?







  $res = 'select a.req_no,a.req_date,a.status,i.item_name,w.warehouse_name,g.group_name,b.qty,b.remarks from   requisition_master a, requisition_order b, item_info i, item_sub_group s, item_group g, warehouse w where a.status not in ("MANUAL") and w.warehouse_id=a.req_for and a.req_no=b.req_no and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and b.item_id=i.item_id '.$item_con.$date_con.$con.$g_con.$w_con.' ';



 



$sl=0;



$query = db_query($res);



while($data=mysqli_fetch_object($query)){ ?>



	  



	  



	  



	  <tr>



	<td valign="top"><div align="center"><?=++$sl?></div></td>



      	<td valign="top"><?=$data->req_no;?></td>



      	<td valign="top"><?=$data->warehouse_name;?></td>

		

		

      	<td valign="top"><?=$data->req_date;?></td>



	  	<td valign="top"><?=$data->item_name;?></td>



	  	<td valign="top">&nbsp;<?=$data->group_name;?></td>



	  	<td valign="top"><?=$data->qty;?></td>



		<td valign="top">



		<div align="center">



	  	  <?=$data->remaeks;?>



  	    </div>		



		</td>



  	</tr>



	<? 



	$tot = $tot+$data->qty;



	



	} 



	?>



	  <tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&nbsp;</td>



<td>&emsp;</td>

<td>&emsp;</td>



<td>Total : </td>



<td>&emsp;<b><? if($tot!=''){ echo $tot;}else{ echo $tot=0; };?></b></td>



<td>&emsp;</td>



</tr>



	  </tbody>



	  </table>



	  </td>



	  



	  



	  <td valign="top">



	  <table  border="0" cellpadding="2" cellspacing="0" >



	  



	  <thead>



	  <tr style="background: #B8B8B8; text-align:center; font-size: 16px; border: 1px solid black;" ><td colspan="9"><strong>Purchase Recieve</strong></td></tr>



	  <tr>



        <th width="13%">SL/NO</th>



		<th width="10%">Req No</th>



	    <th width="14%">Rec Date </th>



      <th width="18%"><div align="center">Item Name</div></th>



	  <th width="13%"><div align="center">Group Name</div></th>



	  <th width="15%"><div align="center">Receive qty</div></th>



      <th width="17%"><div align="center">Remarks</div></th>



	  </tr>



	  </thead>



	  <tbody>



	  <?



	  



	  



	  if($_POST['t_date']!='' || $_POST['f_date']!=''){ $date_con .=  'and c.rec_date between "'.$_POST['f_date'].'" and "'.$_POST['t_date'].'"';}



if($_POST['item_id']!='') 				{$item_con=' and b.item_id='.$_POST['item_id'].' ';}



if($_POST['group_id']!='') 				{$g_con=' and g.group_id='.$_POST['group_id'];}



if($_POST['warehouse_id']!='') 				{$w_con=' and a.req_for='.$_POST['warehouse_id'];}



	  



	  



	   $res = 'select a.req_no, a.po_no,a.po_date,c.rec_date,i.item_name,g.group_name,c.qty,c.remarks from   purchase_master a, purchase_invoice b, purchase_receive c, item_info i, item_sub_group s, item_group g where a.po_no=b.po_no and b.id=c.order_no and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and b.item_id=i.item_id '.$item_con.$date_con.$g_con.$w_con.' ';



 



$sl=0;



$query = db_query($res);



while($data=mysqli_fetch_object($query)){ ?>



	  



	  



	  



	  <tr valign="top">



	<td valign="top" width="13%"><div align="center"><?=++$sl?></div></td>



      	<td valign="top" width="10%"><?=$data->req_no;?></td>



	  	<td valign="top" width="14%">&nbsp;<?=$data->rec_date?></td>



	  	<td valign="top" width="18%"><?=$data->item_name;?></td>



		<td valign="top" width="13%">



		<div align="center">



	  	  <?=$data->group_name;?>



  	    </div>		



		</td>



		<td valign="top" width="15%">



		<div align="center">



	  	  <?=$data->qty;?>



  	    </div>		</td>



		<td valign="top" width="17%">



		<div align="center">



		  <?=$data->remarks;?>



	    </div>		</td>



  	</tr>



	  



	  <? 



	  $tott = $tott+$data->qty;



	  } ?>



	  



	  <tr>



<td>&emsp;</td>



<td>&emsp;</td>



<td>&nbsp;</td>



<td>&emsp;</td>



<td>Total : </td>



<td style="text-align:right; font-weight:bold;"><div align="center"> <? if($tott!=''){ echo $tott;}else{ echo $tott=0; };?></div></td>



<td>&emsp;</td>



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



        <td colspan="3"><div align="center"><strong>Grand Total</strong></div></td>



      </tr>



      <tr align="right">



          



        <td><div align="center">Purchase Requisition : <b>



          <?=$tot?>



          </b></div></td><td><div align="center">Purchase Receive : <b>



          <?=$tott?>



          </b></div></td><td> <div align="center">Pending QTY: <b>



          <?=$g_tot=$tot-$tott?>



          </b></div></td>



      </tr>



    </table>



    <?



}



// Requisition Summery report; modify on 10th October, 2022 by M A HASAN;

if($_REQUEST['report']==11022)







{







$sql='';















?>









	<table width="100%" border="0" cellpadding="2" cellspacing="0">







		<thead>





		<tr><td colspan="17" style="border:0px;">







		<?







		echo '<div class="header">';





echo '<h1 style="text-align: center; font-weight: bold; text-shadow: 1px 1px 1px gray; height: 10px; font-size: 25px;">OLYMPIC CEMENT LTD.</h1>';





		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';







		if(isset($report)) 



		echo '<h2>'.$report.'</h2>';







if($_REQUEST['group_id']!=''){echo '<h1 style="text-align: center; font-size: 15px; height: 10px; font-weight: bold;"> Group :'.find_a_field('item_group','group_name','1 and group_id='.$_REQUEST['group_id'],$group_name).'</h1>';};







		if($_REQUEST['warehouse_id']!=''){echo '<h1 style="text-align: center; font-size: 15px;  font-weight: bold;">Section : '.find_a_field('warehouse','warehouse_name','1 and warehouse_id='.$_REQUEST['warehouse_id'],$warehouse_name).'</h1>';};







		









if(isset($t_date)) 







		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';









		echo '</div>';











		echo '<div class="date" style=" text-align:right; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';











		?>













		</td></tr>















<tbody>











	<tr>















<th width="4%">SL/NO</th>















		<th width="3%">Req Id </th>















		<th width="3%">PR No</th>















		<th width="5%">PR Date</th>







	    <th width="5%">Rec Date </th>















      <th width="19%"><div align="center">Item Name</div></th>















	  <th width="8%"><div align="center">Warehouse</div></th>















	  <th width="8%"><div align="center">Group Name</div></th>















	  <th width="5%"><div align="center">Req qty</div></th>







	  <th width="6%"><div align="center">Receive qty</div></th>









	  <th width="5%"><div align="center">Due qty</div></th>





	  <th width="6%"><div align="center">Total Unit</div></th>











      <th width="15%"><div align="center">Remarks</div></th>











      <th width="8%"><div align="center">User</div></th>















	</tr>











<?









if($_REQUEST['t_date']!='' || $_REQUEST['f_date']!=''){ $con .=  'and a.req_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'"';}













if($_REQUEST['item_id']!='') 				{$item_con=' and b.item_id='.$_REQUEST['item_id'].' ';}







if($_REQUEST['group_id']!='') 				{$g_con=' and g.group_id='.$_REQUEST['group_id'];}







if($_REQUEST['warehouse_id']!='') 				{$w_con=' and a.req_for='.$_REQUEST['warehouse_id'];}







 $res='select b.id,a.req_no,a.req_no,a.req_date, b.qty,b.purchase_qty,b.status,b.remarks, b.item_id,w.warehouse_name, i.item_name,b.unit_name, u.fname, g.group_name from  requisition_master a, requisition_order b, item_info i, item_sub_group s, item_group g, warehouse w, user_activity_management u where a.entry_by=u.user_id and w.warehouse_id=a.req_for and  a.req_no=b.req_no and b.item_id=i.item_id '.$item_con.$con.$g_con.$w_con.' and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id group by b.id order by a.req_no asc';















$sl=0;















$query = db_query($res);































while($data=mysqli_fetch_object($query)){























//echo $rrr = 'select sum(p.qty),p.rec_date from purchase_invoice i, purchase_receive p where p.order_no=i.id and i.req_id="'.$data->id.'"';







$rec_qty=find_a_field('purchase_invoice i, purchase_receive p','sum(p.qty)',' p.order_no=i.id and i.req_id="'.$data->id.'"');











 $rec_date=find_a_field('purchase_invoice i, purchase_receive p','p.rec_date',' p.order_no=i.id and i.req_id="'.$data->id.'"');















  ?>















  <tr>















	<td valign="top"><div align="center"><?=++$sl?></div></td>















	















      	<td valign="top"><?=$data->id;?></td>















      	<td valign="top"><?=$data->req_no;?></td>















		















	  	<td valign="top"><?=$data->req_date;?></td>















		















	  	<td valign="top">&nbsp;<?=$rec_date?></td>















	  	<td valign="top"><?=$data->item_name;?></td>















		















		<td valign="top">















		<div align="center">















	  	  <?=$data->warehouse_name;?>















  	    </div>		</td>















		<td valign="top">















		<div align="center">















	  	  <?=$data->group_name;?>















  	    </div>		</td>















		















		<td valign="top">















		<div align="center">















		  <?=$data->qty;?>















	    </div>		</td>















		















		<td valign="top">















		<div align="center">















		  <?=$rec_qty;?>















	    </div>		</td>















		<td valign="top">















		<div align="center">















		  <?=$due_qty=$data->qty-$rec_qty;?>















	    </div>		</td>















		<td valign="top">















		<div align="center">















		  <?=$data->unit_name;?>















	    </div>		</td>















		















		<td valign="top">















		<div align="center">















		  <?=$data->remarks;?>















	    </div>		</td>















		<td valign="top" width="8%">















		<div align="center">















          <?=$data->fname;?>















      </div>		</td>















  	</tr>















  <? $toot = $toot+$data->qty; $tot_p_qty=$tot_p_qty+$rec_qty;$tot_due_qty=$tot_due_qty+$due_qty; ?>















  <? } ?>















































<tr>































<td>&emsp;</td>















<td>&nbsp;</td>















<td>&emsp;</td>















<td>&emsp;</td>















<td>&nbsp;</td>















<td>&emsp;</td>















<td>&emsp;</td>















<td>Total : </td>















<td style="text-align:right; font-weight:bold;"><div align="center"> <?=$toot?></div></td>































<td style="text-align:right; font-weight:bold;"><div align="center"> <?=$tot_p_qty?></div></td>































<td style="text-align:right; font-weight:bold;"><div align="center"> <?=$tot_due_qty?></div></td>















<td>&emsp;</td>















<td>&emsp;</td>















<td>&emsp;</td>















</tr>















</tbody></table>































<?































}





// HFL FG STATEMENT REPORT NOV-2017







elseif($_POST['report']==1015)



{



$f_date = $_REQUEST['f_date'];



$t_date = $_REQUEST['t_date'];







if(isset($dealer_code)) {$dealer_con=' and d.dealer_code='.$dealer_code;} 



$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';







// opening



$sql="select j.item_id,i.finish_goods_code as code,i.pack_size,sum(j.item_in - j.item_ex) balance,



(sum(j.item_in - j.item_ex) DIV i.pack_size) as ctn,



(sum(j.item_in - j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i 



where j.item_id=i.item_id and i.finish_goods_code > 160 and ji_date < '".$f_date."' and warehouse_id = '".$_SESSION['user']['depot']."' group by item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$opening[$row->code] = $row->balance;



		$opening_ctn[$row->code] = $row->ctn;



		$opening_pcs[$row->code] = $row->pcs;



	}



// production	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse in(select warehouse_id from warehouse where use_type ='PL' and group_for='".$_SESSION['user']['group']."')



AND  j.tr_from = 'receive'



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$pro[$row->code] = $row->balance;



		$pro_ctn[$row->code] = $row->ctn;



		$pro_pcs[$row->code] = $row->pcs;



	}







// other receive	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



AND  j.tr_from not in('receive')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$o_in[$row->code] = $row->balance;



		$o_in_ctn[$row->code] = $row->ctn;



		$o_in_pcs[$row->code] = $row->pcs;



	}	



	



// dhaka store



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse =3



AND  j.tr_from in ('issue','Transfered','Transit')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$dhaka[$row->code] = $row->balance;



		$dhaka_ctn[$row->code] = $row->ctn;



		$dhaka_pcs[$row->code] = $row->pcs;



	}



// ctg store



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse =6



AND  j.tr_from in ('issue','Transfered','Transit')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$ctg[$row->code] = $row->balance;



		$ctg_ctn[$row->code] = $row->ctn;



		$ctg_pcs[$row->code] = $row->pcs;



	}



// comilla store



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse =90



AND  j.tr_from in ('issue','Transfered','Transit')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$comilla[$row->code] = $row->balance;



		$comilla_ctn[$row->code] = $row->ctn;



		$comilla_pcs[$row->code] = $row->pcs;



	}



// sylhet store



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse =9



AND  j.tr_from in ('issue','Transfered','Transit')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$sylhet[$row->code] = $row->balance;



		$sylhet_ctn[$row->code] = $row->ctn;



		$sylhet_pcs[$row->code] = $row->pcs;



	}



// jessore store



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse =10



AND  j.tr_from in ('issue','Transfered','Transit')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$jessore[$row->code] = $row->balance;



		$jessore_ctn[$row->code] = $row->ctn;



		$jessore_pcs[$row->code] = $row->pcs;



	}



// bogra store



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse =7



AND  j.tr_from in ('issue','Transfered','Transit')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$bogra[$row->code] = $row->balance;



		$bogra_ctn[$row->code] = $row->ctn;



		$bogra_pcs[$row->code] = $row->pcs;



	}



// barisal store



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse =8



AND  j.tr_from in ('issue','Transfered','Transit')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$barisal[$row->code] = $row->balance;



		$barisal_ctn[$row->code] = $row->ctn;



		$barisal_pcs[$row->code] = $row->pcs;



	}



// rangpur store



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse =89



AND  j.tr_from in ('issue','Transfered','Transit')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$rangpur[$row->code] = $row->balance;



		$rangpur_ctn[$row->code] = $row->ctn;



		$rangpur_pcs[$row->code] = $row->pcs;



	}



// gazipur store



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



and j.relevant_warehouse =54



AND  j.tr_from in ('issue','Transfered','Transit')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$gazipur[$row->code] = $row->balance;



		$gazipur_ctn[$row->code] = $row->ctn;



		$gazipur_pcs[$row->code] = $row->pcs;



	}



// export



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



AND  j.tr_from = 'Export'



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$export[$row->code] = $row->balance;



		$export_ctn[$row->code] = $row->ctn;



		$export_pcs[$row->code] = $row->pcs;



	}



// other issue	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_SESSION['user']['depot']."'



AND  j.tr_from not in('issue','Transfered','Transit','Export')



and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$o_ex[$row->code] = $row->balance;



		$o_ex_ctn[$row->code] = $row->ctn;



		$o_ex_pcs[$row->code] = $row->pcs;



	}











?>



<center>



<h1>Hashem Foods Ltd</h1>



<h2>FG Statemennt Report</h2>



<h3>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h3>



<table width="100%" border="0" cellspacing="0" cellpadding="2">



<thead>



<tr>



	<th>S/L</th>



  <th>Code</th>



  <th>Item Name</th>



  <th>Size</th>



  <th colspan="2" bgcolor="#009999">Opening</th>



  <th colspan="2" bgcolor="#009999">Production</th>



  <th colspan="2" bgcolor="#009999">Other</th>



  <th colspan="2" bgcolor="#009999">Total</th>



  <th colspan="2" bgcolor="#FF6699">Dhaka</th>



  <th colspan="2" bgcolor="#FF6699">Ctg</th>



  <th colspan="2" bgcolor="#FF6699">Comilla</th>



  <th colspan="2" bgcolor="#FF6699">Sylhet</th>



  <th colspan="2" bgcolor="#FF6699">Jessore</th>



  <th colspan="2" bgcolor="#FF6699">Bogra</th>



  <th colspan="2" bgcolor="#FF6699">Barisal</th>



  <th colspan="2" bgcolor="#FF6699">Rangpur</th>



  <th colspan="2" bgcolor="#FF6699">Gazipur</th>



  <th colspan="2" bgcolor="#FF6699">Export</th>



  <th colspan="2" bgcolor="#FF6699">Other</th>



  <th colspan="2" bgcolor="#FF6699">Total</th>



  <th colspan="2">Closing</th>



  <th>Remarks </th>



  </tr>



</thead>



<tbody>



<?







$sql="SELECT item_id,finish_goods_code as code,item_name,pack_size



FROM  item_info 



where finish_goods_code >160 



and finish_goods_code not between 4999 and 8999



and finish_goods_code not between 2000 and 2005



order by code";







/*$sql="SELECT item_id,finish_goods_code as code,item_name,pack_size



FROM  item_info 



where



finish_goods_code in (1219)



order by code";*/







?>



<tr>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>&nbsp;</td>



</tr>



<?php



$query = db_query($sql);



while($data= mysqli_fetch_object($query)){ ?>



<tr><td><?=++$op;?></td>



  <td><?=$data->code?></td>



  <td><?=$data->item_name?></td>



  <td><?=$data->pack_size?></td>



  <td><?=$opening_ctn[$data->code]?></td>



  <td><?=(int)$opening_pcs[$data->code]?></td>



  <td><?=$pro_ctn[$data->code]?></td>



  <td><?=(int)$pro_pcs[$data->code]?></td>



  <td><?=$o_in_ctn[$data->code]?></td>



  <td><?=(int)$o_in_pcs[$data->code]?></td>



<?php $in_total[$data->code] = $opening[$data->code] + $pro[$data->code] + $o_in[$data->code]; 



$in_pcs = fmod($in_total[$data->code],$data->pack_size);?>



  <td><?=(int)($in_total[$data->code]/$data->pack_size)?></td>



  <td><?=$in_pcs?></td>



  <td><?=$dhaka_ctn[$data->code]?></td>



  <td><?=(int)$dhaka_pcs[$data->code]?></td>



  <td><?=$ctg_ctn[$data->code]?></td>



  <td><?=(int)$ctg_pcs[$data->code]?></td>



  <td><?=$comilla_ctn[$data->code]?></td>



  <td><?=(int)$comilla_pcs[$data->code]?></td>



  <td><?=$sylhet_ctn[$data->code]?></td>



  <td><?=(int)$sylhet_pcs[$data->code]?></td>



  <td><?=$jessore_ctn[$data->code]?></td>



  <td><?=(int)$jessore_pcs[$data->code]?></td>



  <td><?=$bogra_ctn[$data->code]?></td>



  <td><?=(int)$bogra_pcs[$data->code]?></td>



  <td><?=$barisal_ctn[$data->code]?></td>



  <td><?=(int)$barisal_pcs[$data->code]?></td>



  <td><?=$rangpur_ctn[$data->code]?></td>



  <td><?=(int)$rangpur_pcs[$data->code]?></td>



  <td><?=$gazipur_ctn[$data->code]?></td>



  <td><?=(int)$gazipur_pcs[$data->code]?></td>



  <td><?=$export_ctn[$data->code]?></td>



  <td><?=(int)$export_pcs[$data->code]?></td>



  <td><?=$o_ex_ctn[$data->code]?></td>



  <td><?=(int)$o_ex_pcs[$data->code]?></td>



<?php $out_total[$data->code] = $dhaka[$data->code] + $ctg[$data->code] + $comilla[$data->code] + 



$sylhet[$data->code] + $jessore[$data->code] + $bogra[$data->code] + $barisal[$data->code] + 



$rangpur[$data->code] + $gazipur[$data->code] + $export[$data->code] + $o_ex[$data->code]; 







$out_pcs = fmod($out_total[$data->code],$data->pack_size);?>



  <td><?=(int)($out_total[$data->code]/$data->pack_size)?></td>



  <td><?=$out_pcs?></td>



<?php $closing_total[$data->code] = $in_total[$data->code] - $out_total[$data->code]; 



$closing_pcs = fmod($closing_total[$data->code],$data->pack_size);?>  



  <td><?=(int)($closing_total[$data->code]/$data->pack_size)?></td>



  <td><?=$closing_pcs?></td>



  <td>&nbsp;</td>



</tr>



<?



}



?>



</tbody></table>



<br>



<table width="100%" border="0">



  <tr>



    <td style="border:0px;" width="21%"><div align="center">______________</div></td>



    <td style="border:0px;" width="19%"><div align="center">_________</div></td>



    <td style="border:0px;"width="19%"><div align="center">________</div></td>



    <td style="border:0px;"width="15%"><div align="center">__________</div></td>



    <td style="border:0px;"width="12%"><div align="center">______</div></td>



    <td style="border:0px;"width="14%"><div align="center">_________</div></td>



  </tr>



  <tr>



    <td style="border:0px;"><div align="center">Dy. Manager(A/C) </div></td>



    <td style="border:0px;"><div align="center">DGM(A/C)</div></td>



    <td style="border:0px;"><div align="center">GM(Audit)</div></td>



    <td style="border:0px;"><div align="center">ED/Director</div></td>



    <td style="border:0px;"><div align="center">DMD</div></td>



    <td style="border:0px;"><div align="center">Chairman</div></td>



  </tr>



</table>







<?



}



// end HFL fg statement report















// -------------------------------------------    Stock Movement Report







elseif($_POST['report']==222)



{



$f_date = $_REQUEST['f_date'];



$t_date = $_REQUEST['t_date'];







 



if($_POST['item_sub_group']>0) 	$sub_group_id=$_POST['item_sub_group'];



if($_POST['item_id']>0) $item_id=$_POST['item_id'];







$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';



if(isset($sub_group_id)) 	{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($item_id)) 		{$item_con=' and i.item_id='.$item_id;} 







// opening



$sql="select j.item_id as code,i.unit_name,sum(j.item_in - j.item_ex) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and i.sub_group_id='".$sub_group_id."' 



and ji_date < '".$f_date."' and warehouse_id = '".$_SESSION['user']['depot']."' ".$item_con." group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$opening[$row->code] = $row->balance;



	}







// ALL purchase	



$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and i.sub_group_id='".$sub_group_id."' 



and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$_SESSION['user']['depot']."' ".$item_con." 



AND  j.tr_from IN ('Purchase','Import','Local Purchase') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$purchase[$row->code] = $row->balance;



	}







// production	



$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and i.sub_group_id='".$sub_group_id."' 



and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$_SESSION['user']['depot']."' ".$item_con." 



AND  j.tr_from IN ('receive') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$production[$row->code] = $row->balance;



	}







// ------------------ Other receive	



$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and i.sub_group_id='".$sub_group_id."' 



and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$_SESSION['user']['depot']."' ".$item_con." 



AND  j.tr_from NOT IN ('Purchase','Import','Local Purchase','receive') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$other_receive[$row->code] = $row->balance;



	}	







// -------------------------------- Line issue	



$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and i.sub_group_id='".$sub_group_id."' 



and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$_SESSION['user']['depot']."' ".$item_con." 



AND  j.tr_from IN ('Issue') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$line_issue[$row->code] = $row->balance;



	}



	



// Local Sales	



$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and i.sub_group_id='".$sub_group_id."' 



and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$_SESSION['user']['depot']."' ".$item_con." 



AND  j.tr_from IN ('Direct Sales','Other Sales') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$local_sales[$row->code] = $row->balance;



	}







// Export Sales	



$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and i.sub_group_id='".$sub_group_id."' 



and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$_SESSION['user']['depot']."' ".$item_con." 



AND  j.tr_from IN ('Export') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$local_sales[$row->code] = $row->balance;



	}	







// --------------------------------- Others issue	



$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and i.sub_group_id='".$sub_group_id."' 



and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$_SESSION['user']['depot']."' ".$item_con." 



AND  j.tr_from NOT IN ('Issue','Direct Sales','Other Sales','Export') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$other_issue[$row->code] = $row->balance;



	}		



		











?>



<center>



<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"'); ?></h1>



<h2>Stock Movement Report</h2> (<?=find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$sub_group_id.'"'); ?>)



<h3>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h3>



<table width="100%" border="0" cellspacing="0" cellpadding="2">



<thead>



<tr>



  <th>S/L</th>



  <th>Code</th>



  <th>Item Name</th>



  <th>Unit</th>



  <th bgcolor="#009999">Opening</th>



  <th bgcolor="#009999">Purchase</th>



  <th bgcolor="#009999">Production</th>



  <th bgcolor="#009999">Other</th>



  <th bgcolor="#009999">Total</th>



  <th bgcolor="#FF6699">Line Issue </th>



  <th bgcolor="#FF6699">Local Sales </th>



  <th bgcolor="#FF6699">Export</th>



  <th bgcolor="#FF6699">Other</th>



  <th bgcolor="#FF6699">Total</th>



  <th>Closing</th>



  <th>Remarks </th>



  </tr>



</thead>



<tbody>



<?







$sql="SELECT item_id as code,i.sub_group_id,i.item_name,i.unit_name



FROM  item_info i, item_sub_group s



where i.sub_group_id=s.sub_group_id



and i.sub_group_id='".$sub_group_id."' ".$item_con."



order by i.item_name";











?>







<?php



$query = db_query($sql);



while($data= mysqli_fetch_object($query)){ 



$in_total = $opening[$data->code] + $purchase[$data->code] + $production[$data->code] + $other_receive[$data->code];



$out_total = $line_issue[$data->code] + $local_sales[$data->code] + $export_sales[$data->code] + $other_issue[$data->code];



if((int)$in_total<>0||(int)$out_total<>0){



?>



<tr><td><?=++$op;?></td>



  <td>C-<?=$data->code?></td>



  <td><?=$data->item_name?></td>



  <td><?=$data->unit_name?></td>



  <td><?=(int)$opening[$data->code]?></td>



  <td><?=(int)$purchase[$data->code]?></td>



  <td><?=(int)$production[$data->code]?></td>



  <td><?=(int)$other_receive[$data->code]?></td>



  



  <td><?=(int)$in_total?></td>



  <td><?=(int)$line_issue[$data->code]?></td>



  <td><?=(int)$local_sales[$data->code]?></td>



  <td><?=(int)$export_sales[$data->code]?></td>



  <td><?=(int)$other_issue[$data->code]?></td>



  



  <td><?=(int)$out_total?></td>



<?php $closing = $in_total - $out_total; ?>  



  <td><?=(int)$closing?></td>



  <td>&nbsp;</td>



</tr>



<?



}



 } ?>



</tbody></table>



<br>



<!--<table width="100%" border="0">



  <tr>



    <td style="border:0px;" width="21%"><div align="center">______________</div></td>



    <td style="border:0px;" width="19%"><div align="center">_________</div></td>



    <td style="border:0px;"width="19%"><div align="center">________</div></td>



    <td style="border:0px;"width="15%"><div align="center">__________</div></td>



    <td style="border:0px;"width="12%"><div align="center">______</div></td>



    <td style="border:0px;"width="14%"><div align="center">_________</div></td>



  </tr>



  <tr>



    <td style="border:0px;"><div align="center">Dy. Manager(A/C) </div></td>



    <td style="border:0px;"><div align="center">DGM(A/C)</div></td>



    <td style="border:0px;"><div align="center">GM(Audit)</div></td>



    <td style="border:0px;"><div align="center">ED/Director</div></td>



    <td style="border:0px;"><div align="center">DMD</div></td>



    <td style="border:0px;"><div align="center">Chairman</div></td>



  </tr>



</table>-->







<?



}



// end stock movement report











// -------------------------------------------    Production Line Stock Movement Report







elseif($_POST['report']==224)



{



$f_date = $_REQUEST['f_date'];



$t_date = $_REQUEST['t_date'];







 



if($_POST['item_sub_group']>0) 	$sub_group_id=$_POST['item_sub_group'];



if($_POST['item_id']>0) $item_id=$_POST['item_id'];







$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';



if(isset($sub_group_id)) 	{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($item_id)) 		{$item_con=' and i.item_id='.$item_id;} 







if(isset($warehouse_id)) {$warehouse_id = $_POST['warehouse_id'];











// opening



$sql="select j.item_id as code,i.unit_name,sum(j.item_in - j.item_ex) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and ji_date < '".$f_date."' and warehouse_id = '".$warehouse_id."' ".$item_con." group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$opening[$row->code] = $row->balance;



	}







// Store SR Posting	



$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$warehouse_id."' ".$item_con." 



AND  j.tr_from IN ('Issue') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$store_sr[$row->code] = $row->balance;



	}







// Production	



$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$warehouse_id."' ".$item_con." 



AND  j.tr_from IN ('Production') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$production[$row->code] = $row->balance;



	}







// ------------------ Other receive	



$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$warehouse_id."' ".$item_con." 



AND  j.tr_from NOT IN ('Issue','Production') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$other_receive[$row->code] = $row->balance;



	}	







// -------------------------------- Store Return	



$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$warehouse_id."' ".$item_con." 



AND  j.tr_from IN ('Receive') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$store_return[$row->code] = $row->balance;



	}



	



// Consumption	



$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$warehouse_id."' ".$item_con." 



AND  j.tr_from IN ('Consumption') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$consumption[$row->code] = $row->balance;



	}











// --------------------------------- Others issue	



$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance



from journal_item j, item_info i 



where j.item_id=i.item_id and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '".$warehouse_id."' ".$item_con." 



AND  j.tr_from NOT IN ('Receive','Consumption') group by i.item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$other_issue[$row->code] = $row->balance;



	}		







?>



<center>



<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"'); ?></h1>



<h2>Production Line Movement Report-<?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$warehouse_id.'"'); ?></h2>



<h3>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h3>



<table width="100%" border="0" cellspacing="0" cellpadding="2">



<thead>



<tr>



  <th>S/L</th>



  <th>Category</th>



  <th>Code</th>



  <th>Item Name</th>



  <th>Unit</th>



  <th bgcolor="#009999">Opening</th>



  <th bgcolor="#009999">Store SR </th>



  <th bgcolor="#009999">Production</th>



  <th bgcolor="#009999">Other</th>



  <th bgcolor="#009999">Total</th>



  <th bgcolor="#FF6699">Store Delivery  </th>



  <th bgcolor="#FF6699">Consumption</th>



  <th bgcolor="#FF6699">Other</th>



  <th bgcolor="#FF6699">Total</th>



  <th>Closing</th>



  <th>Remarks </th>



  </tr>



</thead>



<tbody>



<?



$sql="SELECT i.item_id as code,s.sub_group_name,i.item_name,i.unit_name



FROM  item_info i, journal_item j, item_sub_group s



where i.item_id=j.item_id and i.sub_group_id = s.sub_group_id



".$item_con."



and j.warehouse_id = '".$warehouse_id."'



group by i.item_id



order by i.sub_group_id,i.item_name";







?>







<?php



$query = db_query($sql);



while($data= mysqli_fetch_object($query)){ ?>



<tr><td><?=++$op;?></td>



  <td><?=$data->sub_group_name?></td>



  <td>C-<?=$data->code?></td>



  <td><?=$data->item_name?></td>



  <td><?=$data->unit_name?></td>



  <td><?=(int)$opening[$data->code]?></td>



  <td><?=(int)$store_sr[$data->code]?></td>



  <td><?=(int)$production[$data->code]?></td>



  <td><?=(int)$other_receive[$data->code]?></td>



<?php $in_total = $opening[$data->code] + $store_sr[$data->code] + $production[$data->code] + $other_receive[$data->code]; ?>



  <td><?=$in_total?></td>



  <td><?=(int)$store_return[$data->code]?></td>



  <td><?=(int)$consumption[$data->code]?></td>



  <td><?=(int)$other_issue[$data->code]?></td>



<?php $out_total = $store_return[$data->code] + $consumption[$data->code] + $other_issue[$data->code]; ?>



  <td><?=$out_total?></td>



<?php $closing = $in_total - $out_total; ?>  



  <td><?=$closing?></td>



  <td>&nbsp;</td>



</tr>



<? } ?>



</tbody></table>



<br>



<!--<table width="100%" border="0">



  <tr>



    <td style="border:0px;" width="21%"><div align="center">______________</div></td>



    <td style="border:0px;" width="19%"><div align="center">_________</div></td>



    <td style="border:0px;"width="19%"><div align="center">________</div></td>



    <td style="border:0px;"width="15%"><div align="center">__________</div></td>



    <td style="border:0px;"width="12%"><div align="center">______</div></td>



    <td style="border:0px;"width="14%"><div align="center">_________</div></td>



  </tr>



  <tr>



    <td style="border:0px;"><div align="center">Dy. Manager(A/C) </div></td>



    <td style="border:0px;"><div align="center">DGM(A/C)</div></td>



    <td style="border:0px;"><div align="center">GM(Audit)</div></td>



    <td style="border:0px;"><div align="center">ED/Director</div></td>



    <td style="border:0px;"><div align="center">DMD</div></td>



    <td style="border:0px;"><div align="center">Chairman</div></td>



  </tr>



</table>-->







<?



} // end if warehouse id 



else {echo "Select Productin Line";}



}



// end Line stock movement report











// -------------------------------------------    production vs delivery checking report







elseif($_POST['report']==223)



{



$f_date = $_REQUEST['f_date'];



$t_date = $_REQUEST['t_date'];











if($_POST['item_sub_group']>0) 	$sub_group_id=$_POST['item_sub_group'];



if($_POST['item_id']>0) $item_id=$_POST['item_id'];



if($_POST['warehouse_id']>0) $warehouse_id=$_POST['warehouse_id'];







$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';



$pr_date_con = ' and p.pr_date between "'.$f_date.'" and "'.$t_date.'" ';







if(isset($sub_group_id)) 	{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 



if(isset($item_id)) 		{$item_con=' and i.item_id='.$item_id;} 



if(isset($warehouse_id))  	{



$warehouse_con=' and j.relevant_warehouse='.$warehouse_id;



$p_line_con=' and p.warehouse_to='.$warehouse_id;







} 











// Production	



$sql="SELECT  i.item_id,i.finish_goods_code as code,i.item_name,sum(p.total_unit) as balance



FROM  production_floor_receive_detail p, warehouse w,item_info i



where



p.warehouse_to=w.warehouse_id and p.item_id = i.item_id



and w.group_for = '".$_SESSION['user']['group']."'



and i.sub_group_id = '1096000100010000'



and p.pr_date between '".$f_date."' and '".$t_date."'



group by i.item_id order by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$production[$row->code] = $row->balance;



	}











// FG Delivery



$sql='select i.item_id,i.finish_goods_code as code,i.item_name, sum(j.item_in) as balance



from journal_item j, item_info i



where



j.item_id=i.item_id 



and j.tr_from in ("Receive") and j.warehouse_id="'.$_SESSION['user']['depot'].'" 



'.$date_con.$warehouse_con.$item_con.$status_con.$item_sub_con.' and i.sub_group_id = "1096000100010000"



group by i.finish_goods_code 



order by i.finish_goods_code';



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$delivery[$row->code] = $row->balance;



	}











?>



<center>



<h1><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"'); ?></h1>



<h2>Production Vs Delivery Checking Report-<?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$warehouse_id.'"'); ?></h2>



<h3>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h3>



<table width="100%" border="0" cellspacing="0" cellpadding="2">



<thead>



<tr>



  <th>S/L</th>



  <th>Code</th><th>Code</th>



  <th>Item Name</th>



  <th>Unit</th>



  <th bgcolor="#009999">Production</th>



  <th bgcolor="#009999">Delivery</th>



  <th>Diff</th>



  <th>Remarks </th>



  </tr>



</thead>



<tbody>



<?







$sql="SELECT i.item_id,i.finish_goods_code as code,i.sub_group_id,i.item_name,i.unit_name



FROM  item_info i, production_floor_receive_detail p



where 1 and p.item_id = i.item_id



and i.finish_goods_code > 0



".$item_con.$p_line_con."



group by i.item_id



order by i.finish_goods_code";







?>







<?php



$query = db_query($sql);



while($data= mysqli_fetch_object($query)){ ?>



<tr>



  <td><?=++$op;?></td>



  <td>C-<?=$data->item_id?></td><td><?=$data->code?></td>



  <td><?=$data->item_name?></td>



  <td><?=$data->unit_name?></td>



  <td><?=(int)$production[$data->code]?></td>



  <td><?=(int)$delivery[$data->code]?></td>



  <?php $diff = $production[$data->code] - $delivery[$data->code]; ?>  



  <td><span class="style1">    <?=$diff?></span></td>



  <td></td>



</tr>



<? } ?>



</tbody></table>











<?



}



// end production vs delivery checking report















elseif($_POST['report']==1007)



{		if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 



		$report="Product Movement Summary Report (Depot)";



		?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



  <thead>



    <tr>



      <td colspan="17" style="border:0px;"><?



		echo '<div class="header">';



		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



		if(isset($report)) 



		echo '<h2>'.$report.'</h2>';







if(isset($t_date)) 



		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



		echo '</div>';







		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



		?>



      </td>



    </tr>



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



  </thead>



  <tbody>



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



    </tr>



    <? }?>



  </tbody>



</table>



<?



}



elseif($_POST['report']==10091)



{		if($item_id>0) 				{$item_con=' and i.item_id='.$item_id;} 



		$report="Daily HFL Sales Report";



		?>



<table width="100%" border="0" cellpadding="2" cellspacing="0">



  <thead>



    <tr>



      <td colspan="4" style="border:0px;"><?



		echo '<div class="header">';



		echo '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';



		if(isset($report)) 



		echo '<h2>Daily HFL Sales Report to Sajeeb Corporation</h2>';







if(isset($t_date)) 



		echo '<h2>Date Interval : '.$f_date.' To '.$t_date.'</h2>';



		echo '</div>';







		echo '<div class="date" style=" text-align:left; float:right;">Reporting Time: '.date("h:i A d-m-Y").'</div>';



		?>



      </td>



    </tr>



    <tr>



      <th>Date</th>



      <th>Sales Value</th>



    </tr>



  </thead>



  <tbody>



    <? 



		$sql = 'select ji.item_ex*i.f_price from  journal_item ji, item_info i where ji.warehouse_id and ji.ji_date = "'.$f_date.'" and ji.item_id=i.item_id';



		$sales_amount = find_a_field_sql($sql);







$t_date2 = date('Y-m-d',strtotime($t_date . ' +1 day'));



$begin = new DateTime($f_date);



$end = new DateTime($t_date2);







$interval = DateInterval::createFromDateString('1 day');



$period = new DatePeriod($begin, $interval, $end);







foreach ( $period as $dt ){



$present_date = $dt->format("Y-m-d");



$sales_amount = 0;



$sql = 'select sum(ji.item_ex*i.f_price) from  journal_item ji, item_info i where ji.warehouse_id=5 and ji.ji_date = "'.$present_date.'" and ji.item_id=i.item_id';



$sales_amount = find_a_field_sql($sql);



$total_amount = $total_amount + $sales_amount;



		?>



    <tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



      <td><?=$present_date;?></td>



      <td><?=number_format($sales_amount,2)?></td>



    </tr>



    <? }?>



    <tr <?=($xx%2==0)?' bgcolor="#CCCCCC"':'';$xx++;?>>



      <td>Total: </td>



      <td><?=number_format($total_amount,2)?></td>



    </tr>



  </tbody>



</table>



<?



}







elseif($_POST['report']==100911)



{



$report="Stock Statemennt Report";



$_REQUEST['warehouse_id'] = $_SESSION['user']['depot'];



if($_REQUEST['warehouse_id']>0){



$f_date = $_REQUEST['f_date'];



$t_date = $_REQUEST['t_date'];







if(isset($dealer_code)) {$dealer_con=' and d.dealer_code='.$dealer_code;} 



$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';











$sql="select j.item_id,i.finish_goods_code as code,i.pack_size,sum(j.item_in - j.item_ex) balance,



(sum(j.item_in - j.item_ex) DIV i.pack_size) as ctn, (sum(j.item_in - j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i 



where j.item_id=i.item_id and i.finish_goods_code > 0 and ji_date < '".$f_date."' and warehouse_id = '".$_REQUEST['warehouse_id']."' 



group by item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$opening[$row->code] = $row->balance;



		$opening_ctn[$row->code] = $row->ctn;



		$opening_pcs[$row->code] = $row->pcs;



	}



	



// closing



$sql="select j.item_id,i.finish_goods_code as code,i.pack_size,sum(j.item_in - j.item_ex) balance,



(sum(j.item_in - j.item_ex) DIV i.pack_size) as ctn, (sum(j.item_in - j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i 



where j.item_id=i.item_id and i.finish_goods_code > 0 and ji_date <= '".$t_date."' and warehouse_id = '".$_REQUEST['warehouse_id']."' 



group by item_id";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$binclosing[$row->code] = $row->balance;



		$binclosing_ctn[$row->code] = $row->ctn;



		$binclosing_pcs[$row->code] = $row->pcs;



	}







// FG Purchase	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['warehouse_id']."'



AND (j.tr_from in('Purchase','Transfered','Transit','Import') OR j.relevant_warehouse in (5,15,17,68))



and j.relevant_warehouse not in(3,6,7,8,9,10,11,51,54,89,90)



AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$purchase[$row->code] = $row->balance;



		$purchase_ctn[$row->code] = $row->ctn;



		$purchase_pcs[$row->code] = $row->pcs;



	}







//SalesReturn



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['warehouse_id']."'



AND  j.tr_from in('Return','BulkReturn') and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$sreturn[$row->code] = $row->balance;



		$sreturn_ctn[$row->code] = $row->ctn;



		$sreturn_pcs[$row->code] = $row->pcs;



	}















// store in	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['warehouse_id']."'



AND j.tr_from in('Transfered','Transit') and j.relevant_warehouse in(3,6,7,8,9,10,11,51,54,89,90)



AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$storein[$row->code] = $row->balance;



		$storein_ctn[$row->code] = $row->ctn;



		$storein_pcs[$row->code] = $row->pcs;



	}







// other receive	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_in) balance,(sum(j.item_in) DIV i.pack_size) as ctn,(sum(j.item_in) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['warehouse_id']."'



AND j.tr_from in('Reprocess Receive','Adjust','Claim Item Receive','Other Receive') AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$o_in[$row->code] = $row->balance;



		$o_in_ctn[$row->code] = $row->ctn;



		$o_in_pcs[$row->code] = $row->pcs;



	}



	











// sales = sales + bulk sales + staff sales	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex-j.item_in) balance,



(sum(j.item_ex-j.item_in) DIV i.pack_size) as ctn,(sum(j.item_ex-j.item_in) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['warehouse_id']."'



AND j.tr_from in('Sales','Bulk Sales','SalesReturn','Staff Sales')



AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$sales[$row->code] = $row->balance;



		$sales_ctn[$row->code] = $row->ctn;



		$sales_pcs[$row->code] = $row->pcs;



	}







// store out	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['warehouse_id']."'



AND j.tr_from in('Transfered','Transit') and j.relevant_warehouse in(3,6,7,8,9,10,11,51,54,89,90) 



AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$storeout[$row->code] = $row->balance;



		$storeout_ctn[$row->code] = $row->ctn;



		$storeout_pcs[$row->code] = $row->pcs;



	}







// purchase return	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['warehouse_id']."'



AND j.tr_from in('Transfered','Transit') and j.relevant_warehouse in(5,15,17,68) 



AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$preturn[$row->code] = $row->balance;



		$preturn_ctn[$row->code] = $row->ctn;



		$preturn_pcs[$row->code] = $row->pcs;



	}







// other issue	



$sql="SELECT i.finish_goods_code as code,i.pack_size,sum(j.item_ex) balance,(sum(j.item_ex) DIV i.pack_size) as ctn,(sum(j.item_ex) MOD i.pack_size) as pcs



from journal_item j, item_info i WHERE  j.item_id=i.item_id and j.warehouse_id ='".$_REQUEST['warehouse_id']."'



AND  j.tr_from  in('Gift Issue','Other Sales','Reprocess Issue','Sample Issue','Adjust','Consumption','Claim Item Issue','Entertainment Issue','Other Issue') 



AND i.finish_goods_code > 0 and j.ji_date between '".$f_date."' and '".$t_date."'



group by code";



	



$res = db_query($sql);



	while($row=mysqli_fetch_object($res))



	{



		$o_ex[$row->code] = $row->balance;



		$o_ex_ctn[$row->code] = $row->ctn;



		$o_ex_pcs[$row->code] = $row->pcs;



	}











?>



<center>



<h1><?=$warehouse_name = find_a_field('warehouse','warehouse_name','warehouse_id='.$_REQUEST['warehouse_id']);?></h1>



<h2>Stock Statement Report</h2>



<h3>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h3>



<table width="100%" border="0" cellspacing="0" cellpadding="2">



<thead>



<tr>



	<th>S/L</th>



  <th>Code</th>



  <th>Item Name</th>



  <th>Size</th>



  <th colspan="2" bgcolor="#6666CC">Opening</th>



  <th colspan="2" bgcolor="#009999">Purchase</th>



  <th colspan="2" bgcolor="#009999">Sales Return</th>



  <th colspan="2" bgcolor="#009999">Store In  </th>



  <th colspan="2" bgcolor="#009999">Other </th>



  <th colspan="2" bgcolor="#009999">Total</th>



  <th colspan="2" bgcolor="#FF6699">Sales</th>



  <th colspan="2" bgcolor="#FF6699">Purchase Return</th>



  <th colspan="2" bgcolor="#FF6699">Store Out  </th>



  <th colspan="2" bgcolor="#FF6699">Other</th>



  <th colspan="2" bgcolor="#FF6699">Total</th>



  <th colspan="2" bgcolor="#6666CC">Closing</th>



  <th colspan="2" bgcolor="#6666CC">Bin Closing </th>



  <th colspan="2">Diff</th>



  <th>Remarks </th>



  </tr>



</thead>



<tbody>



<?











$sql="SELECT item_id,finish_goods_code as code,item_name,pack_size



FROM  item_info 



where finish_goods_code>0



and finish_goods_code not between 2000 and 2005



order by code";



// finish_goods_code in(278,814)



?>



<tr>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>Ctn</td>



  <td>Pcs</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



  <td>&nbsp;</td>



</tr>



<?php



$query = db_query($sql);



while($data= mysqli_fetch_object($query)){ ?>



<tr><td><?=++$op;?></td>



  <td><?=$data->code?></td>



  <td><?=$data->item_name?></td>



  <td><?=$data->pack_size?></td>



  <td><?=$opening_ctn[$data->code]?><? $total_opening_ctn = $total_opening_ctn + $opening_ctn[$data->code];?></td>



  <td><?=(int)$opening_pcs[$data->code]?><? $total_opening_pcs = $total_opening_pcs + $opening_pcs[$data->code];?></td>



  <td><?=$purchase_ctn[$data->code]?><? $total_purchase_ctn = $total_purchase_ctn + $purchase_ctn[$data->code];?></td>



  <td><?=(int)$purchase_pcs[$data->code]?><? $total_purchase_pcs = $total_purchase_pcs + $purchase_pcs[$data->code];?></td>



  <td><?=$sreturn_ctn[$data->code]?><? $total_sreturn_ctn = $total_sreturn_ctn + $sreturn_ctn[$data->code];?></td>



  <td><?=(int)$sreturn_pcs[$data->code]?><? $total_sreturn_pcs = $total_sreturn_pcs + $sreturn_pcs[$data->code];?></td>



  <td><?=$storein_ctn[$data->code]?><? $total_storein_ctn = $total_storein_ctn + $storein_ctn[$data->code];?></td>



  <td><?=(int)$storein_pcs[$data->code]?><? $total_storein_pcs = $total_storein_pcs + $storein_pcs[$data->code];?></td>



  <td><?=$o_in_ctn[$data->code]?><? $total_o_in_ctn = $total_o_in_ctn + $o_in_ctn[$data->code];?></td>



  <td><?=(int)$o_in_pcs[$data->code]?><? $total_o_in_pcs = $total_o_in_pcs + $o_in_pcs[$data->code];?></td>







<?php $in_total[$data->code] = $opening[$data->code] + $purchase[$data->code] + $sreturn[$data->code] + $storein[$data->code] + $o_in[$data->code]; 



$in_pcs = fmod($in_total[$data->code],$data->pack_size);?>



  <td><?=(int)($in_total[$data->code]/$data->pack_size)?><? $total_in_total = $total_in_total + ($in_total[$data->code]/$data->pack_size);?></td>



  <td><?=$in_pcs?><? $total_in_pcs = $total_in_pcs + $in_pcs;?></td>



  <td><?=$sales_ctn[$data->code]?><? $total_sales_ctn = $total_sales_ctn + $sales_ctn[$data->code];?></td>



  <td><?=(int)$sales_pcs[$data->code]?><? $total_sales_pcs = $total_sales_pcs + $sales_pcs[$data->code];?></td>



  <td><?=$preturn_ctn[$data->code]?><? $total_preturn_ctn = $total_preturn_ctn + $preturn_ctn[$data->code];?></td>



  <td><?=(int)$preturn_pcs[$data->code]?><? $total_preturn_pcs = $total_preturn_pcs + $preturn_pcs[$data->code];?></td>



  <td><?=$storeout_ctn[$data->code]?><? $total_storeout_ctn = $total_storeout_ctn + $storeout_ctn[$data->code];?></td>



  <td><?=(int)$storeout_pcs[$data->code]?><? $total_storeout_pcs = $total_storeout_pcs + $storeout_pcs[$data->code];?></td>



  <td><?=$o_ex_ctn[$data->code]?><? $total_o_ex_ctn = $total_o_ex_ctn + $o_ex_ctn[$data->code];?></td>



  <td><?=(int)$o_ex_pcs[$data->code]?><? $total_o_ex_pcs = $total_o_ex_pcs + $o_ex_pcs[$data->code];?></td>







<?php $out_total[$data->code] = $sales[$data->code] + $preturn[$data->code] + $storeout[$data->code] + $o_ex[$data->code]; 



$out_pcs = fmod($out_total[$data->code],$data->pack_size);?>



  



  <td><?=(int)($out_total[$data->code]/$data->pack_size)?><? $total_out_total = $total_out_total + $out_total[$data->code];?></td>



  <td><?=$out_pcs?><? $total_out_pcs = $total_out_pcs + $out_pcs;?></td>







<?php $closing_total[$data->code] = $in_total[$data->code] - $out_total[$data->code]; 



$closing_pcs = fmod($closing_total[$data->code],$data->pack_size);?>  



  <td><?=(int)($closing_total[$data->code]/$data->pack_size)?><? $tclose +=($closing_total[$data->code]/$data->pack_size); ?></td>



  <td><?=$closing_pcs?></td>



    



  



  <td><?=$binclosing_ctn[$data->code]?></td>



  <td><?=(int)$binclosing_pcs[$data->code]?></td>



  <td><?=(int)(($closing_total[$data->code]/$data->pack_size)-$binclosing_ctn[$data->code]);?></td>



  <td><?=(int)($closing_pcs-$binclosing_pcs[$data->code]);?></td>



  <td>&nbsp;</td>



</tr>



<?



}



?>



<tr>



  <td></td>



  <td></td>



  <td></td>



  <td></td>



  <td><?=$total_opening_ctn;?></td>



  <td><?=$total_opening_pcs;?></td>



  <td><?=$total_purchase_ctn;?></td>



  <td><?=$total_purchase_pcs;?></td>



  <td><?=$total_sreturn_ctn;?></td>



  <td><?=$total_sreturn_pcs;?></td>



  <td><?=$total_storein_ctn;?></td>



  <td><?=$total_storein_pcs;?></td>



  <td><?=$total_o_in_ctn;?></td>



  <td><?=$total_o_in_pcs;?></td>



  <td><?=number_format($total_in_total,2);?></td>



  <td><?=$total_in_pcs;?></td>



  <td><?=$total_sales_ctn;?></td>



  <td><?=$total_sales_pcs;?></td>



  <td><?=$total_preturn_ctn;?></td>



  <td><?=$total_preturn_pcs;?></td>



  <td><?=$total_storeout_ctn;?></td>



  <td><?=$total_storeout_pcs;?></td>



  <td><?=$total_o_ex_ctn;?></td>



  <td><?=$total_o_ex_pcs;?></td>



  <td><?=$total_out_total;?></td>



  <td><?=$total_out_pcs;?></td>



  <td><? echo (int)($tclose); ?></td>



  <td></td>



  <td></td>



  <td></td>



  <td></td>



  <td></td>



  <td></td>



</tr>



</tbody></table>



<br>



<table width="100%" border="0">



  <tr>



    <td style="border:0px;" width="21%"><div align="center">______________</div></td>



    <td style="border:0px;" width="19%"><div align="center">_________</div></td>



    <td style="border:0px;"width="19%"><div align="center">________</div></td>



    <td style="border:0px;"width="15%"><div align="center">__________</div></td>



    <td style="border:0px;"width="12%"><div align="center">______</div></td>



    <td style="border:0px;"width="14%"><div align="center">_________</div></td>



  </tr>



  <tr>



    <td style="border:0px;"><div align="center">Dy. Manager(A/C) </div></td>



    <td style="border:0px;"><div align="center">DGM(A/C)</div></td>



    <td style="border:0px;"><div align="center">GM(Audit)</div></td>



    <td style="border:0px;"><div align="center">ED/Director</div></td>



    <td style="border:0px;"><div align="center">DMD</div></td>



    <td style="border:0px;"><div align="center">Chairman</div></td>



  </tr>



</table>







<?



}else{echo "Please Select Warehouse";}}



elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);



?>



</div>



</body>



</html>



