<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$group_id_cus = intval($_POST['group_id_cus']);
$sql = "SELECT * FROM item_group WHERE   group_id_cus='$group_id_cus' ORDER BY group_id";
$query = db_query($sql);

echo '<option value="">-- Select Sub Group --</option>';
while($row = mysqli_fetch_assoc($query)){
    echo '<option value="'.$row['group_id'].'">'.$row['group_name'].'</option>';
}
?>
