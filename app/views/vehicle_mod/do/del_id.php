<?php
require_once "../../../assets/template/layout.top.php";
$id= $_GET['do_no'];

 $del_id= $_GET['del_id'];
$dsql="delete from sale_do_details where id='".$del_id."'";
mysql_query($dsql);

header('location:do_check.php?do_no='.$id.'');


?>