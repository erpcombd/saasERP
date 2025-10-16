<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";

// Get POST data
$item = explode("#", $_POST['item_id']);
$item_id = $item[1];
$group_for = $_POST['group_for'];

// Query to fetch the data from the database
$sql = 'SELECT CONCAT(i.item_name, "#", i.item_id) AS show_name 
        FROM item_info i
        JOIN item_group g ON i.item_group = g.group_id
        JOIN general_sub_ledger j ON j.sub_ledger_id = i.item_sub_ledger
        WHERE g.ptype = "asset" AND i.group_for = "' . $group_for . '" 
        GROUP BY i.item_id';

$qry = db_query($sql);

// Generate options for datalist
$options = [];
while ($info = mysqli_fetch_object($qry)) {
    $options[] = $info->show_name;
}

// Return the options as a response
echo implode("\n", $options);
?>
