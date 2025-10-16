<?
function activity_log($module_id,$page_id,$page_name,$tr_from,$tr_no,$tr_id,$tr_type,$execution_time,$access_date)
{
$ipaddress = get_client_ip();
$link = explode('/',$_SERVER['REQUEST_URI']);
$c = count($link);
$page_link = $link[$c-4].'/'.$link[$c-3].'/'.$link[$c-2].'/'.$link[$c-1];


$sql = "INSERT INTO `user_action_log` 

( `access_id`,`user_id`,`user_fname`, `user_level`, `mod_id`, `page_id`, `page_name`, `page_link`, `session_id`, 
`ip_address`, `tr_from`, `tr_no`, `tr_id`, `tr_type`,`execution_time`,`access_date`) VALUES 

('".$_SESSION['user']['access_id']."','".$_SESSION['user']['id']."', '".$_SESSION['user']['fname']."','".$_SESSION['user']['level']."', '".(int)$module_id."', '".(int)$page_id."', '".$page_name."', '".$page_link."', '".session_id()."', 
'".$ipaddress."',  '".$tr_from."' , '".(int)$tr_no."' ,'".(int)$tr_id++."' ,'".$tr_type."',  '".$execution_time."',  '".$access_date."')";

db_query($sql);
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        {$ipaddress = getenv('HTTP_CLIENT_IP');}
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        {$ipaddress = getenv('HTTP_X_FORWARDED_FOR');}
    else if(getenv('HTTP_X_FORWARDED'))
        {$ipaddress = getenv('HTTP_X_FORWARDED');}
    else if(getenv('HTTP_FORWARDED_FOR'))
        {$ipaddress = getenv('HTTP_FORWARDED_FOR');}
    else if(getenv('HTTP_FORWARDED'))
       {$ipaddress = getenv('HTTP_FORWARDED');}
    else if(getenv('REMOTE_ADDR'))
        {$ipaddress = getenv('REMOTE_ADDR');}
    else{
        $ipaddress = 'UNKNOWN';}
    return $ipaddress;
}

function insert_invalid_access_record($company_id,$username,$password,$mod_id)
{
$c_name  = "ERPCOMBD";
$access_date = date('Y-m-d');
$session_id = session_id();
$ip_address = $_SERVER['REMOTE_ADDR'];
$cookie_log = $_COOKIE[$c_name];


$sql = "INSERT INTO `user_access_login_fail` (`username`, `password`, `company_id`, `session_id`, `ip_address`, `mod_id`, `access_date`,`cookie_log`) 
VALUES ( '".$username."', '".$password."', '".$company_id."', '".$session_id."', '".$ip_address."', '".$mod_id."', '".$access_date."', '".$cookie_log."')";
db_query($sql);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
$c_value = "Fail Log at:".time()." CI:".$company_id." UN:".$username." SI:".session_id();
setcookie($c_name, $c_value, time() + (86400 * 1000), "/", "", true,true);
}

}

function insert_valid_access_record($company_id,$username,$mod_id)
{
$c_name  = $company_id;
$access_date = date('Y-m-d');
$session_id = session_id();
$ip_address = $_SERVER['REMOTE_ADDR'];

$_SESSION['access']['ip']	= $ip_address;
$_SESSION['access']['mod']	= $mod_id;
$_SESSION['access']['si']	= $session_id;

$cookie_log = $_COOKIE[$c_name];


$sql = "INSERT INTO `user_access_login_success` (`username`, `company_id`, `session_id`, `ip_address`, `mod_id`, `access_date`,`cookie_log`) 
VALUES ( '".$username."', '".$company_id."', '".$session_id."', '".$ip_address."', '".$mod_id."', '".$access_date."', '".$cookie_log."')";
db_query($sql);

$_SESSION['mhafuz']				= 'Active';

$depot = find_all_field('warehouse','','warehouse_id='.$_SESSION['user']['depot']);
$proj_sql="select * from project_info limit 1";
$proj=@mysqli_fetch_object(db_query($proj_sql));
$_SESSION['user']['acc_depot']	= $depot->acc_code;
$_SESSION['user']['group_name']	= $depot->warehouse_name;



$_SESSION['company_name']=$_SESSION['proj_name']=$proj->proj_name;
$_SESSION['company_address']=$proj->proj_address;
$_SESSION['company_logo']='../images/'.$_SESSION['proj_id'].'.jpg';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
$c_value = "Success Log at:".time()." CI:".$company_id." UN:".$username." SI:".session_id();
setcookie($c_name, $c_value, time() + (86400 * 1000), "/", "", true,true);
}

}


function load_menu($mod_id,$mod_name,$user_id){ 
    ?>
    
<h1 id="title_text" style="background: #0270b9; width: 100%; color: white; text-align:center; font-size:18px; margin:0px; margin-bottom:1px; padding: 10px 0px;"><?=$mod_name?></h1>
<div class="menu_bg">
<?

    $subsql="select p.* from user_roll_activity r, user_page_manage p where r.access>0 and p.id=r.page_id and p.status='Yes'  and r.user_id=".$user_id." order by p.ordering,p.feature_id,p.id";
    $subquery=db_query($subsql);
    while($submenu=mysqli_fetch_object($subquery))
    {
        
    if($sb_count[$submenu->feature_id]==0){ $sb_count[$submenu->feature_id] = 1;}
    else {$sb_count[$submenu->feature_id] = $sb_count[$submenu->feature_id] + 1;}
   
    $sb_id[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->id;     
    $sb_folder[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->folder_name;
    $sb_link[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->page_link;
    $sb_name[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->page_name;
    $sb_title[$submenu->feature_id][$sb_count[$submenu->feature_id]] = $submenu->page_title;
    }
    
    
    
    $sql="select distinct f.id, f.feature_name, f.icon
    from user_feature_manage f, user_roll_activity r, user_page_manage p 
    where r.access>0 and p.id=r.page_id and p.feature_id=f.id and r.user_id=".$user_id." and f.module_id=".$mod_id."  order by f.ordering,f.id";
    $query=db_query($sql);
    $count = mysqli_num_rows($query);
    if($count>0)
    {
        $m = 1;
        while($menu = mysqli_fetch_object($query))
        { if($m==4) {$m=1;} 
        else {$m++;}
            
            echo '<div class="silverheader mhafuz'.$m.'"><a href="#"><em class="'; echo ($menu->icon!='')?$menu->icon:'fa fa-cubes'; echo '" aria-hidden="true"></em> '.$menu->feature_name.'<span ></span></a></div>';
            echo '<ul class="submenu mhafuz'.$m.'">';
            
                for($x=1;$x<$sb_count[$menu->id]+1;$x++)
                {
                    echo '<li><a href="../'.$sb_folder[$menu->id][$x].'/'.$sb_link[$menu->id][$x].'"><span>'.$sb_name[$menu->id][$x].'</span>';
                    if($_SESSION['notify'][$sb_id[$menu->id][$x]]>0){
                	echo '<span class="badge badge-pill badge-danger float-right" style="padding:4px 6px!important;border-radius:0px;font-size:80%;">'.$_SESSION['notify'][$sb_id[$menu->id][$x]].'</span>' ;}
                    echo '</a></li>';
                }
        echo '</ul>';
        }
            
    }
?>
<div style="background:#1b2733;">
<?

$user_id=$_SESSION['user']['id'];
$module_sql='select m.module_name,m.id,m.module_link,d.module_id,d.user_id from user_module_define d,user_module_manage m where d.module_id=m.id and d.user_id="'.$user_id.'" and m.id!=12 and m.id!='.$mod_id;
$module_query=db_query($module_sql);

while($module_data=mysqli_fetch_object($module_query))
{
?>
<h6 style="background-color:#4f64a5;color:white;padding:10px;text-align:center;"><a href="../../../<?=$module_data->module_link;?>"  style="color:white!important;" target="_blank" rel="noopener"><?=$module_data->module_name; ?></a></h6>
<?
}
?>

</div>

</div>
    <?
    
}
?>