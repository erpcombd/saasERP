<?php
@session_start();
date_default_timezone_set('Asia/Dhaka');



function location_save($user,$ip,$latitude,$longitude){
include "db.php";   
    
    $log_sql="INSERT IGNORE INTO ss_location_log(user_id,access_date,access_time,ip,latitude,longitude)
    VALUES('".$user."',NOW(),NOW(),'".$ip."','".$latitude."','".$longitude."')";
    db_query($conn, $log_sql);
}



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


function db_last_insert_id($table,$field) {
include "db.php";
	$sql = "select MAX($field)+1 from $table";
	if($result = db_query($conn,$sql)){
	$data = mysqli_fetch_row($result);
	if($data[0]<1)
	return 1;
	else
	return $data[0];
	}
	else return 1;
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

function db_fetch_object($table,$condition){
include "db.php";
	$res="select * from $table where $condition limit 1";
	if($query=db_query($conn,$res)){
	if(mysqli_num_rows($query)>0) return mysqli_fetch_object($query);
	else return NULL;}else return NULL;
}

function find($res){
include "db.php";

	$query=db_query($conn,$res);
	if(mysqli_num_rows($query)>0) return 1;
	else return NULL;
}



function db_fetch_array($table,$condition){
include "db.php";
	$res="select * from $table where $condition limit 1";
	$query=db_query($conn,$res);
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
$sql="insert into $table ($fieldList) values ($valueList)";
	if(db_query($conn, $sql))
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
	db_query($conn, $sql);
}


function db_delete($table,$condition) {
include "db.php";
	
	$sql = "delete from $table where $condition limit 1";
	return db_query($conn, $sql);
}

function db_delete_all($table,$condition) {
include "db.php";
	
	$sql = "delete from $table where $condition";
	return db_query($conn, $sql);
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
	

function find_a_field($table,$field,$condition){
include "db.php";

    $sql="select $field from $table where $condition limit 1";
    $res=@db_query($conn,$sql);
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
    $res=@db_query($conn,$sql);
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



function foreign_relation($table,$id,$show,$value,$condition=''){
 include "db.php";   
    
        if($condition=='')
        $sql="select $id,$show from $table";
        else
        $sql="select $id,$show from $table where $condition";
        //echo $sql;
        $res=db_query($conn,$sql);
        while($data=mysqli_fetch_row($res))
        {
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

function auto_complete_from_db($table,$show,$id,$conn,$text_field_id){
include "db.php";

if($con!='') $condition = " where ".$con;
$query="Select ".$id.", ".$show." from ".$table.$condition;

$led=db_query($conn, $query);
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

$led=db_query($conn, $query);
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
		$res=db_query($conn,$sql);
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
		
		$res=db_query($conn, $sql);
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
		
		$res=db_query($conn, $sql);
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
		$res=db_query($conn,$sql);
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
		
		$res=db_query($conn, $sql);
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


function next_tr_no($tr_from){
	include "db.php";
	
			$start=date('y').sprintf("%02d",$_SESSION['company_id']).'0'.'00001';
			$end=date('y').sprintf("%02d",($_SESSION['company_id'])).'1'.'00000';
			$sql="select max(tr_no) from journal_sec where tr_from='".$tr_from."' and tr_no between '$start' and '$end'";
			$query=@mysqli_fetch_row(@db_query($conn,$sql));
			$value=$query[0]+1;
			if($query[0] == 0)
			$value=$start;
			return $value;
	}
	


function sec_journal_journal($sec_jv_no,$jv_no,$tr_froms){
    include "db.php";

    $sql = 'select * from journal_sec where jv_no = "'.$sec_jv_no.'" and tr_from = "'.$tr_froms.'"';
    $query = db_query($conn, $sql);
    while($data = mysqli_fetch_object($query)){
        
$journal="INSERT INTO journal (jv_no ,tr_date ,ledger_id ,narration ,dr,cr,tr_from ,tr_no,entry_by,entry_at,group_for,cc_code
    	)VALUES(
    '$data->jv_no', '$data->jv_date', '$data->ledger_id', '$data->narration', 
    '$data->dr_amt', '$data->cr_amt', '$data->tr_from', '$data->tr_no','".$_SESSION['username']."','".date('Y-m-d H:i:s')."', '$data->group_for', ".$data->cc_code.")";
    
    db_query($conn, $journal);
    }

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
	


function father_ledger_name($ledger_id){
    include "db.php";
    
	if (strpos($ledger_id,'00000000') == false) 
	{
		if (strpos(substr($ledger_id, -4),'0000') >0) 
		$f = substr($ledger_id, 0,12).'0000'; 		// S S L
		else
		$f = substr($ledger_id, 0,8).'00000000'; 	//   S L
		
		
		$father_ledger_name=find_a_field('accounts_ledger','ledger_name','ledger_id='.$f);
		return ' >>> '.$father_ledger_name;
	}
}


function next_invoice($field,$table,$tr_from=''){
    include "db.php";
    
			$start=date('y').sprintf("%02d",$_SESSION['user']['group']).'0'.'00001';
			$end=date('y').sprintf("%02d",($_SESSION['user']['group'])).'1'.'00000';
			
			if($tr_from=='')
			$sql="select max(".$field.") from ".$table." where ".$field." between '$start' and '$end'";
			else
			$sql="select max(".$field.") from ".$table." where tr_from='".$tr_from."' and ".$field." between '$start' and '$end'";
			$query=mysqli_fetch_row(db_query($conn,$sql));
			$value=$query[0]+1;
			if($query[0] == 0)
			$value=$start;
			return $value;
	}
	
	
function add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $narration, $dr_amt, $cr_amt, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$cc_code='',$group='',$entry_by='',$entry_at='',
$received_from='', $bank='', $cheq_no='',$cheq_date='',$relavent_cash_head='',$checked='',$type='',$employee='')
{
   include "db.php";
    
	if($group>0) $group_id = $group; else $group_id = $_SESSION['company_id'];
	if($entry_at=='') $entry_at = date('Y-m-d H:i:s');
	if($entry_by=='') $entry_by = $_SESSION['username']; 
 $journal="INSERT INTO `journal_sec` (
	proj_id ,
	jv_no,
	jv_date ,
	ledger_id ,
	narration ,
	dr_amt ,
	cr_amt ,
	tr_from ,
	received_from,
	tr_no ,
	sub_ledger,
	entry_by,
	entry_at,
	group_for,
	tr_id,
	cc_code,
	bank,
	cheq_no,
	cheq_date,
	relavent_cash_head,
	checked,
	type,
	employee_id
	
	)VALUES ('$proj_id', '$jv_no', '$jv_date', '$ledger_id', '$narration', '$dr_amt', '$cr_amt', '$tr_from', '$received_from', '$tr_no','$sub_ledger','$entry_by','$entry_at','$group_id','$tr_id','$cc_code'
	,'$bank','$cheq_no','$cheq_date','$relavent_cash_head','$checked','$type','$employee')";
	$query_journal=db_query($conn, $journal);
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

