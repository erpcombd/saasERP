<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$sql = "select distinct pr_no from purchase_receive";
$query = db_query($sql);
while($data=mysqli_fetch_object($query))
{
auto_insert_purchase_secoundary_update($data->pr_no);
}
echo 'Success';
?>