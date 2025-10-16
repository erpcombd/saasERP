<?php


session_start();


//require "../../support/inc.all.php";

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');





 $str = $_POST['data'];


$data=explode('#>',$str);

$data=explode('##',$data[2]);

 $pl_id=$data[1];
 $item_id=$data[0];
$stockk = find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$pl_id.'"');
			

?>
<td align="center" bgcolor="#CCCCCC">
<input  name="stock1" type="text" id="stock1" value="<?=$stockk?>"   />
</td>

