<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$details_id = $_REQUEST['details_id'];
$qty = $_REQUEST['i_qty'];
$price = $_REQUEST['i_price'];
$disc = $_REQUEST['i_disc'];
$total_amt  = $_REQUEST['i_tot_amt'];
$usql = "update sale_pos_details set qty = '$qty', rate = '$price',discount='$disc', total_amt = '$total_amt' where id = '$details_id' ";
mysql_query($usql);
echo json_encode("ok");
?>