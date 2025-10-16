<?

$module_id=find_module_id();
if($module_id>0)
$_SESSION['mod'] =  $module_id;
$mod_id = $module_id;
$mod_name = find_a_field('user_module_manage','module_name','id="'.$module_id.'"');






//$mod_id = $_SESSION['mod'];
//$mod_name = find_a_field('user_module_manage','module_name','id='.$_SESSION['mod']);

$user_level =  $_SESSION['user']['level'];
$user_id    =  $_SESSION['user']['id'];

load_menu($mod_id,$mod_name,$user_id);

?>











