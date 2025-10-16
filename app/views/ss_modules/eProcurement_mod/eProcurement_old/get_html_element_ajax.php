<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);
$i=1;
$type  = $data[0];
$action  = $data[1];
$php_file_name = find_a_field('form_elements','php_file_name','element="'.$type.'"');
if($action=='add'){
$_SESSION[$type] = $_SESSION[$type]+1;
}else{
	$_SESSION[$type] = $_SESSION[$type]-1;
	}


$sql = 'select * from form_elements where 1';
$qry = db_query($sql);
while($row=mysqli_fetch_object($qry)){
	  
	  for($i=1;$i<=$_SESSION[$row->element];$i++){
		  $unique_no = $row->field_name.'_'.$i;
		  $unique_count++;
      include_once($row->php_file_name);
}
	  echo '<input type="hidden" name="'.$row->field_name.'" value="'.$row->element.'#'.$unique_count.'">';
	   $unique_count = 0;
	}

	

?>
