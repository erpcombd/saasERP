<?php
/////////////////////////////////////////////////////////////////
///////////////////// DATABASE FUNCTIONS ////////////////////////
/////////////////////////////////////////////////////////////////
function connectDB()
{
$GLOBALS['DB'] = mysqli_connect(DB_SERVER, DB_USER, DB_PASS) or die();
$np_db = mysqli_select_db(DB_NAME) or die("<p class=error>There is a problem selecting the database.</p>");
}

function auto_complete_start_from_db($table,$show,$id,$con,$text_field_id)
{
if($con!='') $condition = " where ".$con;
$query="Select ".$id.", ".$show." from ".$table.$condition;

$led=db_query($query);
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
		matchContains: false,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.id + " [" + row.name + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
  });
</script>';
}

function auto_complete_from_db($table,$show,$id,$con,$text_field_id)
{
if($con!='') $condition = " where ".$con;
$query="Select ".$id.", ".$show." from ".$table.$condition;

$led=db_query($query);
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
function auto_complete_from_db_sql($query,$text_field_id)
{


$led=db_query($query);
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
function closeDB()
{
mysqli_close(DB_NAME);
}

function db_execute($sql) 
{
return db_query($sql);
}

function db_fetch_object($table,$condition)
{
	$res="select * from $table where $condition limit 1";
	if($query=db_query($res)){
	if(mysqli_num_rows($query)>0) return mysqli_fetch_object($query);
	else return NULL;}else return NULL;
}
function find($res)
{
	$query=db_query($res);
	if(mysqli_num_rows($query)>0) return 1;
	else return NULL;
}

function search_flat_cost_status($proj_code,$build_code,$flat_no)
{
	$res="select 1 from tbl_flat_cost_installment where proj_code='$proj_code' and build_code='$build_code' and flat_no='$flat_no'";
	$query=db_query($res);
	if(mysqli_num_rows($query)>0) return 1;
	else return NULL;
}
function db_fetch_array($table,$condition)
{
	$res="select * from $table where $condition limit 1";
	$query=db_query($res);
	if(mysqli_num_rows($query)>0) return mysqli_fetch_array($query);
	else return NULL;
}

function get_vars ($fields) 
{
	$vars = array();

	foreach($fields as $field_name) {
		if (isset($_REQUEST[$field_name])) {
			$vars[$field_name] = $_REQUEST[$field_name];
		}
	}
	return $vars;
}

function get_value ($fields) 
{
	$vars = array();

	foreach($fields as $field_name) {
	var_dump($field_name);
	}
	return $vars;
}

function reduncancy_check($table,$field,$value)
{
	$sql="select 1 from $table where $field='$value' limit 1";
	$query=db_query($sql);
	return mysqli_num_rows($query);
}
function reduncancy_check2($table,$con)
{
	$sql="select 1 from $table $con limit 1";
	$query=db_query($sql);
	return mysqli_num_rows($query);
}
function db_insert($table, $vars) 
{
	foreach ($vars as $field => $value) {
		$fields[] = $field;
		if ($value != 'NOW()') {
			$values[] = "'" . addslashes($value) . "'";
		} else {
			$values[] = $value;
		}
	}

	$fieldList = implode(", ", $fields);
	$valueList = implode(", ", $values);
	$sql="insert into $table ($fieldList) values ($valueList)";
	$id=db_query($sql);
	return $id;
}

function db_update($table, $id, $vars, $tag='') 
{
	foreach ($vars as $field => $value) {
		$sets[] = "$field = '" . addslashes($value) . "'";
	}

	$setList = implode(", ", $sets);

	if($tag=='')
		$sql = "update $table set $setList where id= $id";
	else
		$sql = "update $table set $setList where $tag= $id";

	db_execute($sql);
}

function db_delete($table,$condition) 
{	
	$sql = "delete from $table where $condition limit 1";
	return db_query($sql);
}

function paging($per_pg)
{
	echo '<div id="pageNavPosition"></div><script type="text/javascript"><!--
		var pager = new Pager("grp",'.$per_pg.');
		pager.init();
		pager.showPageNav("pager", "pageNavPosition");
		pager.showPage(1);
	//--></script>
	<script type="text/javascript">
		document.onkeypress=function(e){
		var e=window.event || e
		var keyunicode=e.charCode || e.keyCode
		if (keyunicode==13)
		{
			return false;
		}
	}
	</script>';
}

function db_last_insert_id($table,$field) {
	$sql = "select MAX($field)+1 from $table";
	if($result = db_query($sql)){
	$data = mysqli_fetch_row($result);
	if($data[0]<1)
	return 1;
	else
	return $data[0];
	}
	else return 1;
}

	function find_a_field($table,$field,$condition)
	{
	$sql="select $field from $table where $condition limit 1";
	$res=db_query($sql);
	if(@mysqli_num_rows($res)>0)
	{
	$data=mysqli_fetch_row($res);
	return $data[0];
	}
	else
	return NULL;
	}
		function find_all_field($table,$field,$condition)
	{
	$sql="select * from $table where $condition limit 1";
	$res=db_query($sql);
	if(@mysqli_num_rows($res)>0)
	{
	$data=mysqli_fetch_object($res);
	return $data;
	}
	else
	return NULL;
	}
	function find_all_field_malti($table,$condition)
	{
	$sql="select * from $table where $condition";
	$res=db_query($sql);
	return $res;
	}

function foreign_relation($table,$id,$show,$value,$condition=''){
if($condition=='')
$sql="select $id,$show from $table";
else
$sql="select $id,$show from $table where $condition";

//echo $sql;
$res=db_query($sql);
echo '<option></option>';
while($data=mysqli_fetch_row($res))
{
if($value==$data[0])
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
else
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}
}

function join_relation($sql,$value=''){
$res=db_query($sql);
echo '<option></option>';
while($data=mysqli_fetch_row($res))
{
if($value==$data[0])
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
else
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}
}


function link_report($sql,$link=''){

	if($sql==NULL) return NULL;

		$str.='
		<table id="grp" cellspacing="0" cellpadding="0" width="100%">';
		$str .='<tr>';
		$res=db_query($sql);
		$cols = mysqli_num_fields($res);
		for($i=1;$i<$cols;$i++)
			{
				$name = mysqli_field_name($res,$i);
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
function ajax_report($sql,$url,$div){

	if($sql==NULL) return NULL;

		$str.='
		<table id="grp" cellspacing="0" cellpadding="0" width="100%">';
		$str .='<tr>';
		$res=db_query($sql);
		$cols = mysqli_num_fields($res);
		for($i=1;$i<$cols;$i++)
			{
				$name = mysqli_field_name($res,$i);
				$str .='<th>'.ucwords(str_replace('_', ' ',$name)).'</th>';
			}
		$str .='</tr>';
		$c=0;
		while($row=mysqli_fetch_array($res))
			{
				$c++;
				if($c%2==0)	$class=' class="alt"'; else $class=''; 
				
				$str .='<tr'.$class.' onclick="getData(\''.$url.'\',\''.$div.'\','.$row[0].');">';
				for($i=1;$i<$cols;$i++) {$str .='<td>'.$row[$i]."</td>";}
				$str .='</tr>';
			}
	$str .='</table>';
	return $str;

}
function do_calander($field)
{
echo '<script type="text/javascript">
$(document).ready(function(){
	
	$(function() {
		$("'.$field.'").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});

	});

});</script>';
}
function add_user_activity_log($user_id,$module_id,$menu_id,$page_name,$detail,$user_level)
{
$time=date('Y-m-d H:i:s');
$sql="INSERT INTO `user_activity_log` ( `user_id`, `access_time`, `module_id`, `menu_id`, `page_name`, `access_detail`, `access_type`) VALUES ($user_id, '$time', $module_id, $menu_id,'$page_name','$detail',$user_level)";
db_query($sql);
return 1;
}


?>