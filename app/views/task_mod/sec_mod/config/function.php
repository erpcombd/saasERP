<?php
@session_start();
date_default_timezone_set('Asia/Dhaka');



function prevent_multi_submit($type = "post", $excl = "validator") {
include "db.php";     
    $string = "";
    foreach ($_POST as $key => $val) {
        if ($key != $excl) {
            $string .= $val;
        }
    }
    if (isset($_SESSION['last'])) {
        if ($_SESSION['last'] === md5($string)) {
            return false;
        } else {
            $_SESSION['last'] = md5($string);
            return true;
        }
    } else {
        $_SESSION['last'] = md5($string);
        return true;
    }
}



function get_stock($item_id){
include "db.php";   
    $data = find1("select sum(item_in-item_ex) from journal_item where item_id='".$item_id."' ");
    return $data;
}





function db_last_insert_id($table,$field) {
include "db.php";
	$sql = "select MAX($field)+1 from $table";
	if($result = mysqli_query($conn,$sql)){
	$data = mysqli_fetch_row($result);
	if($data[0]<1)
	return 1;
	else
	return $data[0];
	}
	else return 1;
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


function get_safe_value($conn,$str){
include "db.php";
	if($str!=''){
		$str=trim($str);
		return mysqli_real_escape_string($conn,$str);
	}
}



function validation($data) {
include "db.php";
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  $data = mysqli_real_escape_string($conn, $data);
	  return $data;
}

function db_fetch_object($table,$condition){
include "db.php";
	$res="select * from $table where $condition limit 1";
	if($query=mysqli_query($conn,$res)){
	if(mysqli_num_rows($query)>0) return mysqli_fetch_object($query);
	else return NULL;}else return NULL;
}

function find($res){
include "db.php";

	$query=mysqli_query($conn,$res);
	if(mysqli_num_rows($query)>0) return 1;
	else return NULL;
}



function db_fetch_array($table,$condition){
include "db.php";
	$res="select * from $table where $condition limit 1";
	$query=mysqli_query($conn,$res);
	if(mysqli_num_rows($query)>0) return mysqli_fetch_array($query);
	else return NULL;
}

function get_vars ($fields) {
include "db.php";
	$vars = array();

	foreach($fields as $field_name) {
		if (isset($_POST[$field_name])) {
			$vars[$field_name] = $_POST[$field_name];
		}
	}
	return $vars;
}



function get_value ($fields) {
include "db.php";

	$vars = array();

	foreach($fields as $field_name) {
	var_dump($field_name);
	}
	return $vars;
}


function db_insert($table, $vars) {
include "db.php";

	foreach ($vars as $field => $value) {
		$fields[] = '`'.$field.'`';
		if ($value != 'NOW()') {
			$values[] = "'" . addslashes($value) . "'";
		} else {
			$values[] = $value;
		}
	}

	$fieldList = implode(", ", $fields);
	$valueList = implode(", ", $values);
	$sql="insert ignore into $table ($fieldList) values ($valueList)";
	if(mysqli_query($conn, $sql))
	return mysqli_insert_id($conn);
	else return false;
}

function db_update($table, $id, $vars, $tag='') {
include "db.php";

	foreach ($vars as $field => $value) {
		$sets[] = "$field = '" . addslashes($value) . "'";
	}

	$setList = implode(", ", $sets);

	if($tag=='')
		$sql = "update $table set $setList where id= $id";
	else
		$sql = "update $table set $setList where $tag= $id";
//echo $sql;
	//db_execute($conn,$sql);
	mysqli_query($conn, $sql);
}


function db_delete($table,$condition) {
include "db.php";
	
	$sql = "delete from $table where $condition limit 1";
	return mysqli_query($conn, $sql);
}

function db_delete_all($table,$condition) {
include "db.php";
	
	$sql = "delete from $table where $condition";
	return mysqli_query($conn, $sql);
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
	

function find_a_field($table,$field,$condition){
include "db.php";

    $sql="select $field from $table where $condition limit 1";
    $res=@mysqli_query($conn,$sql);
    $count=@mysqli_num_rows($res);
    if($count>0)
    {
    $data=@mysqli_fetch_row($res);
    return $data[0];
    }
    else
    return NULL;
    }

function find_all_field($table,$field,$condition){
include "db.php";    
    $sql="select * from $table where $condition limit 1";
    $res=@mysqli_query($conn,$sql);
    $count=@mysqli_num_rows($res);
    
    if($count>0)
        {
        $data=@mysqli_fetch_object($res);
        return $data;
        }
    else
        return NULL;
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



function foreign_relation($table,$id,$show,$value,$condition=''){
 include "db.php";   
    
        if($condition=='')
        $sql="select $id,$show from $table";
        else
        $sql="select $id,$show from $table where $condition";
        //echo $sql;
        $res=mysqli_query($conn,$sql);
        while($data=mysqli_fetch_row($res))
        {
        if($value==$data[0])
        echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
        else
        echo '<option value="'.$data[0].'">'.$data[1].'</option>';
        }
}










// -------------------------------------- Auto report ------------------
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
	$result=mysqli_query($conn, $query);
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
    //mysql_data_seek($result,0); //if we need to reset the mysql result pointer to 0
    return $table; 
}


// --------------- INSERT -------------
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
$query = "insert ignore into $table (" . implode(',', $keys) . ") 
          VALUES (" . implode(',', $values). ")";
mysqli_query($conn, $query);
//echo $query;
}
// --------------- EXAMPLE -----------
/*if(isset($_POST['record'])){	
@insert('admin');
echo "New data insert successfully";
}*/


function insert2($table){
include "db.php";

$result = mysqli_query($conn, "SHOW COLUMNS FROM $table") or   die(mysql_error());
$columns = array();
while ($row = mysqli_fetch_array($result)) {
			$columns[] = $row[0];
		}

$keys = array();
$values = array();
foreach ($columns as $column) {

    $value = trim($_POST[$column]);
    $value = validation($value);
    $keys[] = "`{$column}`";
    $values[] = "'{$value}'";
	}
$query = "insert ignore into $table (" . implode(',', $keys) . ") 
          VALUES (" . implode(',', $values). ")";
mysqli_query($conn, $query);
//echo $query;
}


// ------------------- UPDATE ------------------
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

@update('item_info','item_id="'.$_GET['edit_id'].'"');
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

function link_report($sql,$link=''){
include "db.php";

	if($sql==NULL) return NULL;

		$str.='
		<table class="table table-striped table-bordered table-sm" id="grp" cellspacing="0" cellpadding="0" width="100%">';
		$str .='<tr>';
		$res=mysqli_query($conn,$sql);
		$cols = mysqli_num_fields($res);
		for($i=1;$i<$cols;$i++)
			{
				$name = mysqli_fetch_field_direct($res,$i)->name;
				$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';
			}
		$str .='</tr>';
		$c=0;
		while($row=mysqli_fetch_array($res))
			{ if($link!='') $link= ' onclick="custom('.$row[0].');"';
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				
				$str .='<tr'.$class.$link.'>';
				for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}
				$str .='</tr>';
			}
	$str .='</table>';
	return $str;

}

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


function link_report_add_del_auto($sql,$link='',$sum_of1='',$sum_of2='',$sl=''){
include "db.php";

	if($sql==NULL) return NULL;
		$str.='<table class="table table-striped" id="grp" cellspacing="0" cellpadding="0" width="100%">';
		$str .='<tr>';
		$res=mysqli_query($conn,$sql);
		$cols = mysqli_num_fields($res);
		$str .='<th>S/L</th>';
		for($i=1;$i<$cols;$i++)
			{
				$name = mysqli_fetch_field_direct($res,$i)->name;
				$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';
			}
		$str .='</tr>';
		$c=0;
		while($row=mysqli_fetch_array($res))
			{ 
			$total_qty=$total_qty+$row[$sum_of1-1];
			$total=$total+$row[$sum_of2-1];
			
			if($link!='') $link= ' onclick="custom('.$row[0].');"';
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				$str .='<tr'.$class.$link.'>';
				$str .='<td>'.$c.'</td>';
				for($i=1;$i<($cols-1);$i++) {$str .='<td>&nbsp;'.$row[$i]."</td>"; }
				$str .='<td><a href="?del='.$row[0].'">&nbsp;X&nbsp;</a></td>';
				$str .='</tr>';
			}
	$str .='<tr'.$class.$link.'>';
	if($sum_of1>0)
	$str .="<td colspan='".($sum_of1-1)."'><span style='text-align:right;'> Total: </span></td>";
	if($sum_of2>0)
	{
	$str .="<td colspan='".($sum_of2-$sum_of1)."'>".number_format($total_qty,3)."</td>";
	$str .="<td colspan='".($cols-$sum_of1)."'>".number_format($total,3)."</td>";
	}
	else
	$str .="<td colspan='".($cols-$sum_of1)."'>".number_format($total_qty,3)."</td>";
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




function add_log($tr_date,$sr_no, $module_name, $access_detail, $user_id='', $access_date='' ,$access_time=''){
include "db.php";

	if($access_date=='') $access_date = date('Y-m-d');
	if($access_time=='') $access_time = date('Y-m-d H:s:i');
	if($user_id=='') $user_id = $_SESSION['client_mobile']; 
	
$journal="insert ignore into user_mis_support ( user_id, access_date, access_time, module_name,tr_date,sr_no, access_detail
)VALUES(
'$user_id', '$access_date', '$access_time', '$module_name', '$tr_date', '$sr_no', '$access_detail'
)";
	
	$query_journal=mysqli_query($conn, $journal);
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


// $_POST['item_id']=number_format(next_value('item_id','item_info','1',$min,$min,$max), 0, '.', '');
function next_value($field,$table,$diff=1,$initiate=100001,$btw1='',$btw2=''){
include "db.php";

			if($btw1>0)
			$sql="select max(".$field.") from ".$table." where ".$field." between '".$btw1."' and '".$btw2."'";
			else
			$sql="select max(".$field.") from ".$table;
			
			$query=mysqli_fetch_row(mysqli_query($conn,$sql));
			$value=$query[0]+$diff;
			if($query[0] == 0)
			{
				$value=$initiate;
			}
			return $value;
	}