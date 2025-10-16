<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 

$group_id = intval($_POST['group_id']);
$sql = "SELECT * FROM item_sub_group WHERE group_for='".$_SESSION['user']['group']."' AND group_id='$group_id' ORDER BY sub_group_id";
$query = db_query($sql);

echo '<option value="">-- Select Sub Sub Group --</option>';
while($row = mysqli_fetch_assoc($query)){
    echo '<option value="'.$row['sub_group_id'].'">'.$row['sub_group_name'].'</option>';
}
?>
