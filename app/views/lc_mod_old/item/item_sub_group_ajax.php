<?php


//



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $product_group=$data[0];




?>



<?php



$a2="select sub_group_id, sub_group_name from item_sub_group where group_id='".$product_group."' order by sub_group_sl ";

//echo $a2;

$a1=db_query($a2);

echo "<select name=\"src_sub_group_id\" id=\"src_sub_group_id\"\"  style=\"width:250px; float:left\">";
	echo "<option></option>";
while($a=mysqli_fetch_row($a1))

{



if($a[0]==$sub_group_id)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?>



