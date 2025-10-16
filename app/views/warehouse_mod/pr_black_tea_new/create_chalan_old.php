<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//$sql = 'delete from secondary_journal where tr_from ="Sales" and group_for = 2';
//$query = db_query($sql);

$sql = 'select distinct chalan_no from sale_do_chalan c where c.chalan_date > "2015-12-31" limit 10';
$query = db_query($sql);
while($data = mysqli_fetch_object($query))
{
auto_insert_sales_chalan_secoundary($data->chalan_no);
$x++;}
echo 'Complete '.$x.' entries';
?>