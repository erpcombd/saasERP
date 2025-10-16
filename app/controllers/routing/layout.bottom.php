<?

$trans_end = microtime(true);
$execution_time = ($trans_end - $trans_start);
$address1 = explode('/',$_SERVER['REQUEST_URI']);
$address=preg_replace('/\\?.*/', '', $address1);
$s= count($address);
$module_id = find_a_field('user_module_manage','id','module_file="'.$address[$s-3].'"');
$page_all=find_all_field('user_page_manage','','page_link = "'.$address[$s-1].'" and folder_name="'.$address[$s-2].'"'); 



 $page_id=$page_all->id;
 $page_name=$page_all->page_name;



if($execution_time>5)
{
echo "<div style='background-color:red'>Error Load Time: ".$execution_time."</div>";
}

$trans_end = microtime(true);
$access_date = date('Y-m-d');
$execution_time = ($trans_end - $trans_start);

activity_log($module_id,$page_id,$page_name,$tr_from,$tr_no,$tr_id,$tr_type,$execution_time,$access_date);

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/inc.main_layout.php";
