<?php
session_start();
require_once "../../../assets/support/inc.all.php";

//$sql = 'delete from secondary_journal where tr_from ="Sales" and group_for = 2';
//$query = mysql_query($sql);

$sql = 'select distinct chalan_no from sale_do_chalan c where c.chalan_date > "2015-12-31" limit 10';
$query = mysql_query($sql);
while($data = mysql_fetch_object($query))
{
auto_insert_sales_chalan_secoundary($data->chalan_no);
$x++;}
echo 'Complete '.$x.' entries';
?>