<?php
@session_start();
date_default_timezone_set('Asia/Dhaka');



function location_save($user,$ip,$latitude,$longitude){
include "db.php";   
    
    $log_sql="INSERT IGNORE INTO ss_location_log(user_id,access_date,access_time,ip,latitude,longitude)
    VALUES('".$user."',NOW(),NOW(),'".$ip."','".$latitude."','".$longitude."')";
    db_query($conn, $log_sql);
}






function get_stock($item_id){
include "db.php";   
    $data = find1("select sum(item_in-item_ex) from journal_item where item_id='".$item_id."' ");
    return $data;
}


function get_price($item_id){
include "db.php";   
    $data = find1("select price from product where id='".$item_id."' ");
    return $data;
}


function get_cost_rate($item_id){
include "db.php";   
    $data = find1("select sum(amount)/sum(qty) from warehouse_other_receive_detail where receive_type='Local Purchase' and item_id='".$item_id."' ");
    return round($data,4);
}


function journal_item_input($item_id ,$warehouse_id,$ji_date,$item_in,$item_ex,$tr_from,$tr_no,$item_price='',$r_warehouse='',$sr_no){
include "db.php";    

$sql="INSERT INTO journal_item 
	(ji_date, item_id, warehouse_id, item_in, item_ex, item_price, tr_from, tr_no,
	entry_by, entry_at,relevant_warehouse,sr_no
	
	)VALUES (
	'".$ji_date."', '".$item_id."', '".$warehouse_id."', '".$item_in."', '".$item_ex."', '".$item_price."', '".$tr_from."', '".$tr_no."',
	'".$_SESSION['username']."', '".date('Y-m-d H:i:s')."', '".$r_warehouse."', '".$sr_no."')";
	
	db_query($conn, $sql);

}


function journal_item_ss($item_id ,$warehouse_id,$ji_date,$item_in,$item_ex,$tr_from,$tr_no,$item_price='',$r_warehouse='',$sr_no){
include "db.php";    

$sql="INSERT INTO ss_journal_item 
	(ji_date, item_id, warehouse_id, item_in, item_ex, item_price, tr_from, tr_no,
	entry_by, entry_at,relevant_warehouse,sr_no
	
	)VALUES (
	'".$ji_date."', '".$item_id."', '".$warehouse_id."', '".$item_in."', '".$item_ex."', '".$item_price."', '".$tr_from."', '".$tr_no."',
	'".$_SESSION['username']."', '".date('Y-m-d H:i:s')."', '".$r_warehouse."', '".$sr_no."')";
	
	db_query($conn, $sql);

}





function price_range($pid){
include "db.php";


$sql_price_range = "select product_id, min(price) as mprice, max(price) as xprice from product_attributes where product_id='".$pid."'";
$price_info = findall($sql_price_range);
$price_min = $price_info->mprice;
$price_max = $price_info->xprice;


    if($price_min == $price_max){
    $p = $price_min;
    }else{
    $p = $price_min.' - '.$price_max;
    }

return $p;
}


function redirect($link){
include "db.php";
?>
<script>window.location.href = "<?php echo $link;?>";</script>
<?php }

function redirect2($link){
include "db.php";
?>
<script>
setTimeout(function(){ window.location = "<?php echo $link;?>"; },1000);
</script>
<?php }


function validation($data) {
include "db.php";
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  $data = mysqli_real_escape_string($conn, $data);
	  return $data;
}






function db_fetch_array($table,$condition){
include "db.php";
	$res="select * from $table where $condition limit 1";
	$query=db_query($conn,$res);
	if(mysqli_num_rows($query)>0) return mysqli_fetch_array($query);
	else return NULL;
}














function find1($sql){
include "db.php";
	
		if ($res=db_query($conn,$sql)){
		  while ($row=mysqli_fetch_row($res))
			{
			return ($row[0]);
			} 
		} else return NULL;
	}
	




    
function findall($sql){
include "db.php";
	
		if ($res=db_query($conn,$sql)){
		  while ($data=mysqli_fetch_object($res))
			{
			return $data;
			}
		}
	}

function optionlist($sql){
include "db.php";

	$res=db_query($conn, $sql);
		while($data=mysqli_fetch_row($res))
		{ $value="";
			if($value==$data[0])
			echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
			else
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
			}
}









// function next_chalan_no($depot_id,$chalan_date){
// include "db.php";  

// 	$sdate = mysqli_format2stamp($chalan_date);
// 	$e_ch = date('y',$sdate).date('m',$sdate).date('d',$sdate).sprintf('%02s', $depot_id).'999';
// 	$s_ch = date('y',$sdate).date('m',$sdate).date('d',$sdate).sprintf('%02s', $depot_id).'000';
// 	$unit = 1;
	
// 	$sql = 'select max(chalan_no) from ss_do_chalan where chalan_no between "'.$s_ch.'" and "'.$e_ch.'" ';
// 	$query = db_query($conn, $sql);
	
// 	$data=mysqli_fetch_row($query);
// if($data[0]<$s_ch)
// $ch_no = $s_ch+$unit;
// else
// $ch_no = $data[0]+$unit;
// return $ch_no;
// }




// -------------------------------------- Auto report
function autoreport1($query) {
include "db.php";

	$result=db_query($conn, $query);
    $table = '<table class="table table-striped"><tr>';
    for ($x=0;$x<mysqli_num_fields($result);$x++) $table .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($result,$x)->name)).'</th>';
    $table .= '</tr>';
    while ($rows = mysqli_fetch_assoc($result)) {
    $table .= '<tr>';
    foreach ($rows as $row) $table .= '<td>'.$row.'</td>';
    $table .= '</tr>';
    }
    $table .= '<table>';
    //mysqli_data_seek($result,0); //if we need to reset the mysql result pointer to 0
    return $table; 
}









function autoreport2($query,$report_name='') {
include "db.php";

echo '<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>';
	$result=db_query($conn, $query);
    $table=$report_name;
	$table.= '<table><tr>';
    for ($x=0;$x<mysqli_num_fields($result);$x++) $table .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($result,$x)->name)).'</th>';
    $table .= '</tr>';
    while ($rows = mysqli_fetch_assoc($result)) {
    $table .= '<tr>';
    foreach ($rows as $row) $table .= '<td>'.$row.'</td>';
    $table .= '</tr>';
    }
    $table .= '</table>';
    //mysqli_data_seek($result,0); //if we need to reset the mysql result pointer to 0
    return $table; 
}









function autoreport_crud($query,$report_name) {
include "db.php";

echo '<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>';
	$result=db_query($conn, $query);
	$table='<center><h2>'.$report_name.'<h2></center>';
    $table.= '<table><tr>';
    for ($x=0;$x<mysqli_num_fields($result);$x++) $table .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($result,$x)->name)).'</th>';
    
	$table .= '<th>Modify</th>';
	$table .= '</tr>';
    while ($rows = mysqli_fetch_assoc($result)) {
    $table .= '<tr>';
    foreach ($rows as $row) $table .= '<td>'.$row.'</td>'; $table .= '<td>Edit || Delete'.$row.'</td>';

	$table .= '</tr>';
    }

    $table .= '<table>';
    //mysqli_data_seek($result,0); //if we need to reset the mysql result pointer to 0
    return $table; 
}


// --------------- INSERT
function insert($table){
include "db.php";

$result = db_query($conn, "SHOW COLUMNS FROM $table") or   die(mysqli_error());
$columns = array();
while ($row = mysqli_fetch_array($result)) {
			$columns[] = $row[0];
		}

$keys = array();
$values = array();
unset($columns[0]);
foreach ($columns as $column) {

    $value = trim($_POST[$column]);
    $value = validation($value);
    $keys[] = "`{$column}`";
    $values[] = "'{$value}'";
	}
$query = "INSERT INTO $table (" . implode(',', $keys) . ") 
          VALUES (" . implode(',', $values). ")";
db_query($conn, $query);
$insert_id = $conn->insert_id;
return $insert_id;
//echo $query;
}
// --------------- EXAMPLE
/*if(isset($_POST['record'])){	
@insert('admin');
echo "New data insert successfully";
}*/


// ------------------- UPDATE
function update($table,$condition){
include "db.php";

if($condition!=''){
//array_pop($_POST);
foreach($_POST as $field_name => $field_value) {
	$field_name = validation($field_name);
	$field_value = validation($field_value);
	$sql_str[] = "$field_name = '$field_value'";
	}
	
$query = "UPDATE $table SET ".implode(',', $sql_str)." WHERE $condition";
db_query($conn, $query);
//echo $query;

}
}
//--example
/*if(isset($_POST['update'])){	
@update('TableName');
echo "Update successfully";
}*/














 



function add_log($tr_date,$sr_no, $module_name, $access_detail, $user_id='', $access_date='' ,$access_time=''){
include "db.php";

	if($access_date=='') $access_date = date('Y-m-d');
	if($access_time=='') $access_time = date('Y-m-d H:s:i');
	if($user_id=='') $user_id = $_SESSION['client_mobile']; 
	
$journal="INSERT INTO user_mis_support ( user_id, access_date, access_time, module_name,tr_date,sr_no, access_detail
)VALUES(
'$user_id', '$access_date', '$access_time', '$module_name', '$tr_date', '$sr_no', '$access_detail'
)";
	
	$query_journal=db_query($conn, $journal);
}



function sms_bulksmsbd($number, $text) {

include "db.php";
$sms_info = findall("select mobile_no,password from setup_sms_api where id=1");

$url = "http://66.45.237.70/api.php";
//$number="88017,88018,88019";
$data= array(
'username'=>$sms_info->mobile_no,
'password'=>$sms_info->password,
'number'=>"$number",
'message'=>"$text"
);

$ch = curl_init(); // Initialize cURL
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$smsresult = curl_exec($ch);
$p = explode("|",$smsresult);
$sendstatus = $p[0];
//echo 'status = '.$smsresult;
// echo '<br>'.$number;
// echo '<br>'.$text;
}






// -------------- ecom code


function pr($arr){
	echo '<pre>';
	print_r($arr);
}

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($conn,$str){
	if($str!=''){
		$str=trim($str);
		return mysqli_real_escape_string($conn,$str);
	}
}


// -------------------- Accounts Function 


function next_jv_no($date='',$tr_from = '',$depot_id=''){

include "db.php";
	
	if($tr_from 	== 'Receipt')           $tr = '01';
	elseif($tr_from == 'Payment')           $tr = '02';
	elseif($tr_from == 'Ledger')            $tr = '03';
	elseif($tr_from == 'Journal_info')      $tr = '04';
	elseif($tr_from == 'Sales')             $tr = '05';
	elseif($tr_from == 'Purchase')          $tr = '06';
	elseif($tr_from == 'Closing')           $tr = '07';
	elseif($tr_from == 'Opening')           $tr = '08';
	elseif($tr_from == 'Contra')            $tr = '09';
	elseif($tr_from == 'Collection')        $tr = '10';
	elseif($tr_from == 'DamageReturn')      $tr = '11';
	elseif($tr_from == 'SalesReturn')       $tr = '12';
	elseif($tr_from == 'InterPurchase')     $tr = '13';
	elseif($tr_from == 'StoreIssued')       $tr = '14';
	elseif($tr_from == 'StoreReceived')     $tr = '15';
	elseif($tr_from == 'InterPurchaseIN')   $tr = '16';
	elseif($tr_from == 'InterPurchaseOUT')  $tr = '17';
	elseif($tr_from == 'Purchase Return')   $tr = '18';
	elseif($tr_from == 'Reprocess Issue')   $tr = '19';
	elseif($tr_from == 'Reprocess Receive') $tr = '20';
	elseif($tr_from == 'Cash Sales')        $tr = '21';
	elseif($tr_from == 'Local Purchase')    $tr = '22';
	else $tr = '00';
	
	$depot_id = sprintf('%02d', $depot_id);

	$min = date("ymd").$tr.$depot_id."0000";$max = $min+10000;
	
	$s ="select MAX(jv_no) jv_no from journal where jv_no between '".$min."' and '".$max."'";
				$jv_no=@mysqli_fetch_row(db_query($conn, $s));
	
				if($jv_no[0]>$min)
				$jv=$jv_no[0]+1;
				else
				$jv=$min+1;
				
	return $jv;
}


function next_sec_jv_no($date='',$tr_from = '',$depot_id=''){
include "db.php";
	
	if($tr_from 	== 'Receipt')           $tr = '01';
	elseif($tr_from == 'Payment')           $tr = '02';
	elseif($tr_from == 'Ledger')            $tr = '03';
	elseif($tr_from == 'Journal_info')      $tr = '04';
	elseif($tr_from == 'Sales')             $tr = '05';
	elseif($tr_from == 'Purchase')          $tr = '06';
	elseif($tr_from == 'Closing')           $tr = '07';
	elseif($tr_from == 'Opening')           $tr = '08';
	elseif($tr_from == 'Contra')            $tr = '09';
	elseif($tr_from == 'Collection')        $tr = '10';
	elseif($tr_from == 'DamageReturn')      $tr = '11';
	elseif($tr_from == 'SalesReturn')       $tr = '12';
	elseif($tr_from == 'InterPurchase')     $tr = '13';
	elseif($tr_from == 'StoreIssued')       $tr = '14';
	elseif($tr_from == 'StoreReceived')     $tr = '15';
	elseif($tr_from == 'InterPurchaseIN')   $tr = '16';
	elseif($tr_from == 'InterPurchaseOUT')  $tr = '17';
	elseif($tr_from == 'Purchase Return')   $tr = '18';
	elseif($tr_from == 'Reprocess Issue')   $tr = '19';
	elseif($tr_from == 'Reprocess Receive') $tr = '20';
	elseif($tr_from == 'Cash Sales')        $tr = '21';
	elseif($tr_from == 'Local Purchase')    $tr = '22';
	elseif($tr_from == 'Online Sales')      $tr = '23';
	else $tr = '00';
	
	$depot_id = sprintf('%02d', $depot_id);

	$min = date("ymd").$tr.$depot_id."0000";$max = $min+10000;
	
	$s ="select MAX(jv_no) jv_no from journal_sec where jv_no between '".$min."' and '".$max."'";
				$jv_no=@mysqli_fetch_row(db_query($conn, $s));
	
				if($jv_no[0]>$min)
				$jv=$jv_no[0]+1;
				else
				$jv=$min+1;
				
	return $jv;
}









function autocomplete_new($sql,$id){
include "db.php";

    $under_ledger = '[';
		
    		$a1	=	db_query($conn,$sql);
    	  	while($a = mysqli_fetch_row($a1)){

        	 	$under_ledger .= '{ value: "'.$a[0].'>>>'.$a[1].'",  label: "'.$a[0].'>>>'.$a[1].'"},';
    	  	}
            $under_ledger  = substr($under_ledger, 0, -1);
    	    $under_ledger .= ']';	

echo '<script type="text/javascript">

var data = '.$under_ledger.';

$(function() {
$("#'.$id.'").autocomplete({
		source:data, 
		matchContains: false,
		minChars: 0,
		minLength:0,
		scroll: true,
		scrollHeight: 40
	}).bind("focus", function(){ $(this).autocomplete("search"); });

});

</script>';
}	
	





	
	
	
	
	
	
	
	
	
	

function journal_hit($jv_no, $tr_date, $ledger_id, $dr, $cr, $tr_from, $tr_no, $narration, $cheq_no='',$cheq_date='',$group_for='', $cc_code='',$entry_by='',$entry_at=''){

include "db.php";
    
	if($group_for=='') $group_for = $_SESSION['company_id'];
	if($entry_at=='') $entry_at = date('Y-m-d H:i:s');
	if($entry_by=='') $entry_by = $_SESSION['username']; 
	
 
$journal="INSERT INTO journal (jv_no, tr_date, ledger_id, dr, cr, tr_from,tr_no, narration, cheq_no,cheq_date,group_for,cc_code,entry_by,entry_at
	)VALUES (
'$jv_no', '$tr_date', '$ledger_id', '$dr', '$cr', '$tr_from','$tr_no','$narration', '$cheq_no','$cheq_date','$group_for','$cc_code','$entry_by','$entry_at')";
	
$query_journal=db_query($conn, $journal);
}


function journal_cash_sales($oi_no){
 include "db.php";

$jv_no = next_jv_no('','Cash Sales','1'); 
$ss= "select * from warehouse_other_issue where oi_no='".$oi_no."'  ";
 $info = findall($ss);
 $amount = find1("select sum(amount) from warehouse_other_issue_detail where oi_no='".$oi_no."'  ");
 
 $narration="Cash Sales ".$oi_no.",Party: ".$info->vendor_name.",Date: ".$info->oi_date;
 $tr_date = $info->oi_date;
 $ledger_id_dr = $info->vendor_id;
 $ledger_id_cr = '1016'; // local sales

 
 journal_hit($jv_no,$tr_date, $ledger_id_dr, $amount, '', 'Cash Sales', $oi_no, $narration);
 journal_hit($jv_no,$tr_date, $ledger_id_cr, '', $amount, 'Cash Sales', $oi_no, $narration);
 
} // end function


function journal_online_sales($oi_no){
 include "db.php";

$jv_no = next_jv_no('','Online Sales','1'); 

$info = findall("select * from order_master where do_no='".$oi_no."'  ");
$client = findall("select * from ledger_head where ledger_group=3 and code='".$info->user_id."'"); 
$amount = find1("select sum(total_amt) from order_detail where do_no='".$oi_no."'  ");
 
 
 $narration="Online Sales ".$oi_no.",Party: ".$client->name.",Date:".$info->order_date;
 $tr_date = $info->order_date;
 $ledger_id_dr = $client->id;
 $ledger_id_cr = '1037'; // Online sales

 
 journal_hit($jv_no,$tr_date, $ledger_id_dr, $amount, '', 'Online Sales', $oi_no, $narration);
 journal_hit($jv_no,$tr_date, $ledger_id_cr, '', $amount, 'Online Sales', $oi_no, $narration);
 
} // end function


function journal_sales_return($or_no){
 include "db.php";

    $jv_no = next_jv_no('','Sales Return','1'); 
    $ss= "select * from warehouse_other_receive where or_no='".$or_no."'  ";
     $info = findall($ss);
     $amount = find1("select sum(amount) from warehouse_other_receive_detail where or_no='".$or_no."'  ");
     
     $narration="Sales Return:".$or_no.",Supplier:".$info->vendor_name.",Date: ".$info->or_date;
     $tr_date = $info->or_date;
     
     $ledger_id_dr = '1016'; // Local Sales
     $ledger_id_cr = $info->vendor_id;
     
     journal_hit($jv_no,$tr_date, $ledger_id_dr, $amount, '', 'Sales Return', $or_no, $narration);
     journal_hit($jv_no,$tr_date, $ledger_id_cr, '', $amount, 'Sales Return', $or_no, $narration);
 
} // end function


function journal_purchase($or_no){
 include "db.php";

$jv_no = next_jv_no('','Local Purchase','1'); 
$ss= "select * from warehouse_other_receive where or_no='".$or_no."'  ";
 $info = findall($ss);
 $amount = find1("select sum(amount) from warehouse_other_receive_detail where or_no='".$or_no."'  ");
 
 $narration="Local Purchase:".$or_no.",Supplier:".$info->vendor_name.",Date: ".$info->or_date;
 $tr_date = $info->or_date;
 
 $ledger_id_dr = '1022'; // Finish Goods
 $ledger_id_cr = $info->vendor_id;
 
 
 journal_hit($jv_no,$tr_date, $ledger_id_dr, $amount, '', 'Local Purchase', $or_no, $narration);
 journal_hit($jv_no,$tr_date, $ledger_id_cr, '', $amount, 'Local Purchase', $or_no, $narration);
 
 
} // end function


function journal_purchase_return($oi_no){
 include "db.php";

$jv_no = next_jv_no('','Purchase Return','1'); 
$ss= "select * from warehouse_other_issue where oi_no='".$oi_no."'  ";
 $info = findall($ss);
 $amount = find1("select sum(amount) from warehouse_other_issue_detail where oi_no='".$oi_no."'  ");
 
 $narration="Purchase Return:".$oi_no.",Supplier:".$info->vendor_name.",Date: ".$info->oi_date;
 $tr_date = $info->oi_date;
 
 
 $ledger_id_dr = $info->vendor_id;
 $ledger_id_cr = '1022'; // Finish Goods
 
 
 journal_hit($jv_no,$tr_date, $ledger_id_dr, $amount, '', 'Purchase Return', $oi_no, $narration);
 journal_hit($jv_no,$tr_date, $ledger_id_cr, '', $amount, 'Purchase Return', $oi_no, $narration);
 
} // end function

