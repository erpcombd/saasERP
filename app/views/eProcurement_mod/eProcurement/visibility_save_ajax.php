<?php

session_start();
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
$Crud   = new Crud('rfq_master');
$content_group = $_POST['content_group'];
$_POST['rfq_no'] = $_SESSION['rfq_no'];
$_POST['content_group'] = $content_group;

$Crud->update('rfq_no');

if($content_group !='' && $content_group !='All'){
$del = 'delete from rfq_evaluation_team where rfq_no="'.$_SESSION['rfq_no'].'" and is_group="Yes"';
db_query($del);
$csql = 'select * from event_visibility_team_member where group_id="'.$content_group.'"';
$cqry = db_query($csql);
$Crud   = new Crud('rfq_evaluation_team');
while($cdata=mysqli_fetch_object($cqry)){
$_POST['user_id'] = $cdata->team_member;
$_POST['action'] = 'Watcher';
$_POST['is_group'] = 'Yes';
$Crud->insert();
}
	}elseif($content_group=='All'){
	
		$del = 'delete from rfq_evaluation_team where rfq_no="'.$_SESSION['rfq_no'].'" and is_master != "Yes" ';
		db_query($del);
		
		$csql = 'select * from user_activity_management where level = 5 ';
		$cqry = db_query($csql);
		
		$Crud   = new Crud('rfq_evaluation_team');
		while($cdata=mysqli_fetch_object($cqry)){
		$_POST['user_id'] = $cdata->user_id;
		$_POST['action'] = 'Watcher';
		$_POST['is_group'] = 'Yes';
		$Crud->insert();
		
	}
	
	}

$all['msg'] = $content_group;

        $team = '';
		 $sql = 'select a.id,u.fname,a.action,a.is_master from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qry = db_query($sql);
		 while($data=mysqli_fetch_object($qry)){
		        $did = 'new_rfq_no';
				$team .='<a class="pl-3"><em class="fa-regular fa-user"></em>&nbsp;'.$data->fname.'<span>('.$data->action.')</span> </a>';
				 if($_SESSION['master_status']=='MANUAL' && $data->is_master!='Yes'){
				  $team .= "<button type='button' name='add_event_team' 
		class='btn2 btn1-bg-cancel' onclick='event_team_cancel(".$_SESSION['rfq_no'].",".$data->id.")'>x</button>"; } 
		$team .= '<br />';
		}
	$all['team'] = 	$team;

echo json_encode($all);





?>

