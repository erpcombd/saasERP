<?php
require_once "../../../assets/template/layout.top.php";

$sql = "select distinct pr_no from purchase_receive";
$query = mysql_query($sql);
while($data=mysql_fetch_object($query))
{
auto_insert_purchase_secoundary_update($data->pr_no);
}
echo 'Success';
?>