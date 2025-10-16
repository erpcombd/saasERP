<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Projects";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

/*if($_SESSION['employee_selected']==0 || $_SESSION['employee_selected']==''){

header('location:../../../crm_mod/pages/home/index.php');

}*/

 $today = date('Y-m-d');

 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));

 $cur = '&#x9f3;';

?>









<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>