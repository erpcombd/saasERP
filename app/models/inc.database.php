<?php

//function db_query($sql) {
//    global $conn;
//    return mysqli_query($conn, $sql);
//}

function db_query($sql) {
    global $conn;
	
    $start = microtime(true);
    $result = mysqli_query($conn, $sql);
    $end = microtime(true);
	
	if($_SESSION['query_log']=='on'){
		$query_execution_time = $end - $start;
		activity_query_log($sql,$query_execution_time,$action_log_id,$module_id,$page_id,$page_name,$tr_from,$tr_no,$tr_id,$tr_type,$execution_time);
	}
	
    return $result;
}





function db_insert_id() {
    global $conn;
    return mysqli_insert_id($conn);
}

function connectDB()

{

$GLOBALS['DB'] = mysqli_connect(DB_SERVER, DB_USER, DB_PASS) or die();

$np_db = mysqli_select_db(DB_NAME) or die("<p class=error>There is a problem selecting the database.</p>");

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



if(mysqli_num_rows($query)>0) {return mysqli_fetch_object($query);}



else {return NULL;}}else{ return NULL;}



}



function find($res)



{

$query=db_query($res);

if(mysqli_num_rows($query)>0) {return 1;}

else {return NULL;}



}



function get_vars ($fields) 

{



$vars = array();

	foreach($fields as $field_name) 

	{

		if (isset($_POST[$field_name])) 

		{

			$vars[$field_name] = $_POST[$field_name];

		}



	}



return $vars;



}

function get_vars8($fields, $types) 
{
    $vars = array();
    $length = count($fields);

    for ($i = 0; $i < $length; $i++) {
        $fieldName = $fields[$i];
        $fieldType = $types[$fieldName];
        $postValue = isset($_POST[$fieldName]) ? $_POST[$fieldName] : '';

        if (shouldSkipField($fieldType, $postValue)) {
            continue;
        }

        $vars[$fieldName] = sanitizeFieldValue($fieldType, $postValue);
    }

    return $vars;
}

function shouldSkipField($fieldType, $postValue)
{
    return ((strpos($fieldType, "date") !== false) && (empty($postValue) || $postValue == '0000-00-00')) ||
           ((strpos($fieldType, "enum") !== false) && empty($postValue));
}

function sanitizeFieldValue($fieldType, $postValue)
{
    if (strpos($fieldType, "int") !== false) {
        return is_numeric($postValue) ? (int)$postValue : 0;
    }
	
	if (strpos($fieldType, "decimal") !== false) {
        return is_numeric($postValue) ? $postValue : 0;
    }
	

    if (strpos($fieldType, "datetime") !== false) {
        return empty($postValue) ? '0000-00-00' : $postValue;
    }

    if (strpos($fieldType, "enum") !== false) {
        return empty($postValue) ? 'MANUAL' : $postValue;
    }

    return $postValue;
}



if(time()<170398140047)
{
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



function reduncancy_check_all($table,$con)



{



$sql="select 1 from $table $con limit 1";



$query=db_query($sql);



return mysqli_num_rows($query);



}



function db_insert($table, $vars,$echo_sql=0) 



{

	foreach ($vars as $field => $value) 

	{

	$fields[] = '`'.$field.'`';

		if ($value != 'NOW()') 

		{

		$values[] = "'" . addslashes($value) . "'";

		} 

		else 

		{

		$values[] = $value;

		}



	}



$fieldList = implode(", ", $fields);

$valueList = implode(", ", $values);



  $sql="insert into $table ($fieldList) values ($valueList)";



if($echo_sql==1) {echo $sql;} 

if(db_query($sql)) {return db_insert_id();}

else {return false;}



}



function db_update($table, $id, $vars, $tag='',$echo_sql=0) 



{



foreach ($vars as $field => $value) 

{

$sets[] = "$field = '" . addslashes($value) . "'";

}


if ($sets >0)
$setList = implode(", ", $sets);



if($tag=='') {$sql = "update $table set $setList where id= $id";}

else		{$sql = "update $table set $setList where $tag= $id";}



if($echo_sql==1) {echo $sql;} 



db_execute($sql);



}



function db_delete($table,$condition,$echo_sql=0) 



{	



$sql = "delete from $table where $condition limit 1";

if($echo_sql==1) {echo $sql;} 

return db_query($sql);



}



function db_delete_all($table,$condition,$echo_sql=0) 



{	



$sql = "delete from $table where $condition";

if($echo_sql==1) {echo $sql;} 

return db_query($sql);



}







function db_last_insert_id($table,$field) {



$sql = "select MAX($field)+1 from $table";



if($result = db_query($sql)){



$data = @mysqli_fetch_row($result);



if($data[0]<1)

{return 1;}



else{return $data[0];}



}



else {return 1;}



}



  function find_a_field($table, $field, $condition, $echo_sql = 0)
{
    global $con; 

    try {
        $sql = "SELECT $field FROM $table WHERE $condition LIMIT 1";

        if ($echo_sql == 1) {
            echo $sql; 
        }

        $res = db_query($sql); 

        if (!$res) {
            throw new Exception();
        }
      
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            $data = mysqli_fetch_row($res);
            return $data[0];
        } else {
            return null;
        }
    } catch (Exception $e) {
        
        echo " " . $e->getMessage();
        return null;
    }
}




function find_a_field_sql($sql,$echo_sql=0)



{

if($echo_sql==1) {echo $sql;} 

$res=@db_query($sql);



$count=@mysqli_num_rows($res);



if($count>0)



{



$data=@mysqli_fetch_row($res);



return $data[0];



}



else{
return NULL;
}


}



function find_all_field_sql($sql,$echo_sql=0)



{

if($echo_sql==1) {echo $sql;}



$res=db_query($sql);

if($res){
$count=@mysqli_num_rows($res);}



if($count>0)



{



$data=@mysqli_fetch_object($res);



return $data;



}



else{
    return NULL;
}



}



function find_all_field($table,$field,$condition,$echo_sql=0)



{


if($field!=''){ $echo_sql=0;}
$sql="select * from $table where $condition limit 1";

if($echo_sql==1) {echo $sql;} 

$res=db_query($sql);


if($res){
$count=@mysqli_num_rows($res);
}


if($count>0)



{



$data=@mysqli_fetch_object($res);



return $data;



}



else{
    return NULL;
}


}




function foreign_relation($table,$id,$show,$value='',$condition='',$echo_sql=0){



if($condition=='')
{
$sql="select $id,$show from $table";
}


else{
    $sql="select $id,$show from $table where $condition";

}

if($echo_sql==1) {echo $sql;} 



$res=db_query($sql);


if($res){
while($data=@mysqli_fetch_row($res))



{



if($value==$data[0])
{


echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';

}

else{

echo '<option value="'.$data[0].'">'.$data[1].'</option>';

}

}
}


}


function foreign_relation2($table,$id,$show,$value='',$condition='',$echo_sql=0){



if($condition=='')
{
 $sql="select $id,$show from $table";
}


else{
    $sql="select $id,$show from $table where $condition";

}

if($echo_sql==1) {echo $sql;} 



$res=db_query($sql);


if($res){
while($data=@mysqli_fetch_row($res))

{

if(isset($value)){
$selected = in_array((string) $data[0], $value, true) ? 'selected' : '';
}
echo '<option value="'.$data[0].'" '.$selected.' >'.$data[1].'</option>';

}
}


}

function user_company_access($id){
 $sql="select u.id,u.group_name from user_group u,company_define c where u.id=c.company_id  and c.status='Active' and  c.user_id=".$_SESSION['user']['id'];
$res=db_query($sql);
if($res){
while($data=@mysqli_fetch_row($res))
{
if($id==$data[0])
{
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
}
else{
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}
}
}
}

function user_company_access_list(){
    $sql = "select group_concat(u.id) from user_group u,company_define c where u.id=c.company_id and c.status='Active' and c.user_id=" . $_SESSION['user']['id'];
    $res = db_query($sql);
    if ($res) {
        $data = mysqli_fetch_row($res);
        return $data[0];
    }
    return null;
}

function user_warehouse_access($id){
 
 $sql="select d.warehouse_id,w.warehouse_name from warehouse w,warehouse_define d where w.warehouse_id=d.warehouse_id and d.user_id='".$_SESSION['user']['id']."' and d.status='Active'";
$res=db_query($sql);
if($res){
while($data=@mysqli_fetch_row($res))
{
if($id==$data[0])
{
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
}
else{
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}
}
}
}




function foreign_relation_sql($sql,$value='',$echo_sql=0){

	if($echo_sql==1) {echo $sql;} 

	$res=db_query($sql);



	while($data=@mysqli_fetch_row($res))



	{



	if($value==$data[0])


{
	echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';

}

	else{



	echo '<option value="'.$data[0].'">'.$data[1].'</option>';

    }

	}



}



function advance_foreign_relation($sql,$value=''){



$res=db_query($sql);



while($data=mysqli_fetch_row($res))



{



if($value==$data[0])

{

echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';


}
else

{

echo '<option value="'.$data[0].'">'.$data[1].'</option>';

}

}



}

	



}



function do_datatable($field_id)



{

echo '<script type="text/javascript">

$(document).ready( function () {

$("#'.$field_id.'").DataTable( {

    buttons: [

        "copy", "excel", "pdf"

    ]

} );

} );



</script>';



}





function do_calander($field,$minDate='',$maxDate='')



{



if($minDate!='')
{
$add .= 'minDate: '.$minDate.', ';
}


if($maxDate!='')
{
$add .= 'maxDate: '.$maxDate.', ';
}


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



?>