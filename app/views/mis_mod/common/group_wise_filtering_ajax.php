<?php
session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');


$group_for = $_POST['group_for'] ?? '';
$type      = $_POST['type'] ?? '';

if($type == "BOM" && !empty($group_for)){

    $sql = "SELECT item_id, item_name 
            FROM item_info 
            WHERE product_nature IN ('Both','Salable') 
            AND group_for IN ($group_for)
            ORDER BY item_name ASC";

    $query = db_query($sql);

    echo '<option value="">Select Product</option>';
    while($row = mysqli_fetch_assoc($query)){
        echo '<option value="'.$row['item_id'].'">'.$row['item_name'].'</option>';
    }

}else if($type == "Issue_WH" && !empty($group_for)){

    $sql = "SELECT warehouse_id, warehouse_name 
            FROM warehouse 
            WHERE use_type IN ('WH') 
            AND group_for IN ($group_for)
            ORDER BY warehouse_id ASC";

    $query = db_query($sql);

    echo '<option value="">Select WH</option>';
    while($row = mysqli_fetch_assoc($query)){
        echo '<option value="'.$row['warehouse_id'].'">'.$row['warehouse_name'].'</option>';
    }

} else {
    echo '<option value="">No Data Found</option>';
}

?>
