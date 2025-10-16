<?php

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_REQUEST['a'];

$unit_price=find_a_field('hms_services','amount','id='.$str);
?>
<input name="unit_price" type="text" class="input3" id="unit_price"  maxlength="100" style="width:95px; text-align:right;" onchange="billamt()" value="<?=$unit_price?>"/>