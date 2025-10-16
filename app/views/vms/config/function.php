<?php
date_default_timezone_set('Asia/Dhaka');


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


function validation($data) {
include "db.php";
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  $data = mysqli_real_escape_string($conn, $data);
	  return $data;
}

function find1($sql){
include "db.php";
	
		if ($res=mysqli_query($conn,$sql)){
		  while ($row=mysqli_fetch_row($res))
			{
			return ($row[0]);
			} 
		} else return NULL;
	}
	
	
function findall($sql){
include "db.php";
	
		if ($res=mysqli_query($conn,$sql)){
		  while ($data=mysqli_fetch_object($res))
			{
			return $data;
			}
		}
	}

function optionlist($sql){
include "db.php";

	$res=mysqli_query($conn, $sql);
		while($data=mysqli_fetch_row($res))
		{ $value="";
			if($value==$data[0])
			echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
			else
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
			}
}

// -------------------------------------- Auto report
function autoreport1($query) {
include "db.php";

	$result=mysqli_query($conn, $query);
    $table = '<table class="table table-striped"><tr>';
    for ($x=0;$x<mysqli_num_fields($result);$x++) $table .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($result,$x)->name)).'</th>';
    $table .= '</tr>';
    while ($rows = mysqli_fetch_assoc($result)) {
    $table .= '<tr>';
    foreach ($rows as $row) $table .= '<td>'.$row.'</td>';
    $table .= '</tr>';
    }
    $table .= '<table>';
    //mysql_data_seek($result,0); //if we need to reset the mysql result pointer to 0
    return $table; 
}









function autoreport2($query) {
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
	$result=mysqli_query($conn, $query);
    $table = '<table><tr>';
    for ($x=0;$x<mysqli_num_fields($result);$x++) $table .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($result,$x)->name)).'</th>';
    $table .= '</tr>';
    while ($rows = mysqli_fetch_assoc($result)) {
    $table .= '<tr>';
    foreach ($rows as $row) $table .= '<td>'.$row.'</td>';
    $table .= '</tr>';
    }
    $table .= '<table>';
    //mysql_data_seek($result,0); //if we need to reset the mysql result pointer to 0
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
	$result=mysqli_query($conn, $query);
	$table = '<center><h2>'.$report_name.'<h2></center>';
    $table = '<table><tr>';
    for ($x=0;$x<mysqli_num_fields($result);$x++) $table .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($result,$x)->name)).'</th>';
    
	$table .= '<th>Modify</th>';
	$table .= '</tr>';
    while ($rows = mysqli_fetch_assoc($result)) {
    $table .= '<tr>';
    foreach ($rows as $row) $table .= '<td>'.$row.'</td>'; $table .= '<td>Edit || Delete'.$row.'</td>';

	$table .= '</tr>';
    }

    $table .= '<table>';
    //mysql_data_seek($result,0); //if we need to reset the mysql result pointer to 0
    return $table; 
}


// --------------- INSERT
function insert($table){
include "db.php";

$result = mysqli_query($conn, "SHOW COLUMNS FROM $table") or   die(mysql_error());
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
$query = "INSERT ignore INTO $table (" . implode(',', $keys) . ") 
          VALUES (" . implode(',', $values). ")";
mysqli_query($conn, $query);
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
mysqli_query($conn, $query);
//echo $query;
	}
}
//--example
/*if(isset($_POST['update'])){	
@update('TableName');
echo "Update successfully";
}*/

function auto_complete_from_db($table,$show,$id,$conn,$text_field_id){
include "db.php";

if($con!='') $condition = " where ".$con;
$query="Select ".$id.", ".$show." from ".$table.$condition;

$led=mysqli_query($conn, $query);
	if(mysqli_num_rows($led) > 0)
	{
		$ledger = '[';
		while($ledg = mysqli_fetch_row($led)){
		  $ledger .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
		}
		$ledger = substr($ledger, 0, -1);
		$ledger .= ']';
	}
	else
	{
		$ledger = '[{ name: "empty", id: "" }]';
	}

echo '<script type="text/javascript">
$(document).ready(function(){
    var data = '.$ledger.';
    $("#'.$text_field_id.'").autocomplete(data, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
  });
</script>';
}

function auto_complete_from_db_sql($query,$text_field_id){
include "db.php";

$led=mysqli_query($conn, $query);
	if(mysqli_num_rows($led) > 0)
	{
		$ledger = '[';
		while($ledg = mysqli_fetch_row($led)){
		  $ledger .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
		}
		$ledger = substr($ledger, 0, -1);
		$ledger .= ']';
	}
	else
	{
		$ledger = '[{ name: "empty", id: "" }]';
	}

echo '<script type="text/javascript">
$(document).ready(function(){
    var data = '.$ledger.';
    $("#'.$text_field_id.'").autocomplete(data, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
  });
</script>';
}


function do_calander($field,$minDate='',$maxDate=''){
include "db.php";
$add ='';
if($minDate!='')
$add .= 'minDate: '.$minDate.', ';
if($maxDate!='')
$add .= 'maxDate: '.$maxDate.', ';
echo '<script type="text/javascript">
$(document).ready(function(){
	
	$(function() {
		$("'.$field.'").datepicker({
			changeMonth: true,
			changeYear: true,
			'.$add.'
			dateFormat: "yy-mm-dd"
		});

	});

});</script>';
}


//---------------------------- mhafuz vai crud


// nov-13 testing done , now need to link del id with php file.

function link_report_del($sql,$link=''){
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
$str='';
	if($sql==NULL) return NULL;
		
		$res=mysqli_query($conn, $sql);
		$str = '<table><tr>';
    for ($x=0;$x<mysqli_num_fields($res);$x++) $str .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($res,$x)->name)).'</th>';
	
	$str .= '<th>Modify</th>';
	$str .= '</tr>';

		$c=0;
		while($row=mysqli_fetch_array($res))
			{ 
			if($link!='') $link= ' onclick="custom('.$row[0].');"';
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				$str .='<tr'.$class.$link.'>';
				for($i=0;$i<($x);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }
				$str .='<td><a onClick="if(!confirm(\'Are You Sure Execute this?\')){return false;}" href="?del='.$row[0].'">&nbsp;X&nbsp;</a></td>';
				$str .='</tr>';
			}
	$str .='</table>';
	return $str;

}


function link_report_single($sql,$link=''){
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
$str=''; $total=''; $total_qty='';
	if($sql==NULL) return NULL;
		
		$res=mysqli_query($conn, $sql);
		$str = '<table><tr>';
    for ($x=0;$x<mysqli_num_fields($res);$x++) $str .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($res,$x)->name)).'</th>';

	$str .= '</tr>';
		$c=0;
		while($row=mysqli_fetch_array($res))
			{ 
			$total=$total+$row[5];
			$total_qty=$total_qty+$row[4];
			if($link!='') $link= ' onclick="custom('.$row[0].');"';
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				$str .='<tr'.$class.$link.'>';
				for($i=0;$i<$x;$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }
				$str .='</tr>';
			}
	$str .='<tr'.$class.$link.'>';
	$str .="<td colspan='".($x-2)."'><span style='text-align:right;'> Total: </span></td>";
	$str .="<td>".$total_qty."</td>";
	$str .="<td>".$total."</td>";
	$str .='</tr>';
	$str .='</table>';
	return $str;
}


function link_report_add_del($sql,$link=''){
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
$str=''; $total=''; $total_qty='';
	if($sql==NULL) return NULL;
		
		$res=mysqli_query($conn, $sql);
		$str = '<table><tr>';
    for ($x=0;$x<mysqli_num_fields($res);$x++) $str .= '<th>'.ucfirst(str_replace('_',' ',mysqli_fetch_field_direct($res,$x)->name)).'</th>';
	
	$str .= '<th>Modify</th>';
	$str .= '</tr>';

		$c=0;
		while($row=mysqli_fetch_array($res))
			{ 
			$total=$total+$row[5];
			$total_qty=$total_qty+$row[4];
			if($link!='') $link= ' onclick="custom('.$row[0].');"';
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				$str .='<tr'.$class.$link.'>';
				for($i=0;$i<($x);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }
				$str .='<td><a href="?del='.$row[0].'">&nbsp;X&nbsp;</a></td>';
				$str .='</tr>';
			}
	$str .='<tr'.$class.$link.'>';
	$str .="<td colspan='".($x-1)."'><span style='text-align:right;'> Total: </span></td>";
	$str .="<td>".$total_qty."</td>";
	$str .="<td>".$total."</td>";
	$str .='</tr>';
	$str .='</table>';
	return $str;
}



function sms($number, $text) {	
$url = "http://66.45.237.70/api.php";
//$number="88017,88018,88019";
$data= array(
'username'=>"01611111884",
'password'=>"123455",
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
/*echo 'status = '.$smsresult;
echo '<br>'.$number;
echo '<br>'.$text;*/
}




function add_log($tr_date,$sr_no, $module_name, $access_detail, $user_id='', $access_date='' ,$access_time=''){
include "db.php";

	if($access_date=='') $access_date = date('Y-m-d');
	if($access_time=='') $access_time = date('Y-m-d H:s:i');
	if($user_id=='') $user_id = $_SESSION['client_mobile']; 
	
$journal="INSERT ignore INTO user_mis_support ( user_id, access_date, access_time, module_name,tr_date,sr_no, access_detail
)VALUES(
'$user_id', '$access_date', '$access_time', '$module_name', '$tr_date', '$sr_no', '$access_detail'
)";
	
	$query_journal=mysqli_query($conn, $journal);
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


