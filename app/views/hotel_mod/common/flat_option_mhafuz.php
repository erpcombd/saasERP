<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];

$unit_price=find_a_field('hms_services','unit_price','id='.$str);
?>
<input name="unit_price" type="text" class="input3" id="unit_price" value="<?=$unit_price?>"  maxlength="100" style="width:70px;"/>