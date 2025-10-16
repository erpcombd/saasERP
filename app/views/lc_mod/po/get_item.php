<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$sub_group_id = intval($_POST['sub_group_id']);

if ($sub_group_id > 0) {
    // Filtered by subgroup
    $sql = "SELECT * 
            FROM item_info 
            WHERE group_for='" . $_SESSION['user']['group'] . "' 
              AND sub_group_id='$sub_group_id' 
            ORDER BY item_id";
} else {
    // Show all items
    $sql = "SELECT * 
            FROM item_info 
            WHERE group_for='" . $_SESSION['user']['group'] . "' 
            ORDER BY item_id";
}

$query = db_query($sql);

echo "<input list='item_list' id='item_id' name='item_id' placeholder='-- Select Item --' 
       onblur=\"getData2('mr_ajax.php', 'mr', this.value, document.getElementById('warehouse_id').value);\">";

echo "<datalist id='item_list'>";

while ($row = mysqli_fetch_assoc($query)) {
    echo "<option value='" 
        . htmlspecialchars($row['item_id'] ."-" . $row['item_name']) 
        . "'></option>";
}

echo "</datalist>";

?>

