<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$item_sub_group = find_all_field('item_sub_group','','sub_group_id="'.$_POST['sub_group_id'].'"');

$all['depreciation_type'] = $item_sub_group->depreciation_type;
$all['depreciation_rate'] = $item_sub_group->depreciation_rate;
$all['depreciation_cycle'] = $item_sub_group->depreciation_cycle;
//$all['validity'] = $item_sub_group->validity;

echo json_encode($all);

?>



