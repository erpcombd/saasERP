<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'rfq_evaluation_team';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];

$user_id = $_POST['user_id'];
$level = $_POST['level'];

$_POST['rfq_no'] = $rfq_no;

if($_SESSION['rfq_no']>0){
$_POST['user_id'] = $user_id;
$_POST['action'] = $level;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();

$_POST['field_name'] = 'event_team';
$_POST['field_value'] = $user_id;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
?>

<?php    
         ob_start();
		 $sql = 'select a.id,u.fname,a.action,a.is_master from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qry = db_query($sql);
		 while($data=mysqli_fetch_object($qry)){
		?>
		<a class="pl-3"><em class="fa-regular fa-user"></em><?=$data->fname?><span>(<?=$data->action?>)</span> </a><? if($data->is_master!='Yes'){?><button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_team_cancel(document.getElementById('new_rfq_no').value,<?=$data->id?>)">x</button><? } ?><br />
		<? }
		 $team_list = ob_get_clean();
		 
		 ob_start();
		 ?>
		 <input type="text" class="section_name" name="evaluator_user" list="eventMemberList" id="evaluator_user" value="">
                <datalist id="eventMemberList">
                <?php 
				$sqlss = 'select a.id,u.fname,u.user_id from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qryss = db_query($sqlss);
		 while($dataa=mysqli_fetch_object($qryss)){
				?>
                <option><?=$dataa->fname?>#<?=$dataa->user_id?></option>
                <? } ?>
                </datalist>
				<?
				$team_list_assign = ob_get_clean();
		 $all['teamList'] = $team_list;
		 $all['teamListAssign'] = $team_list_assign;
		 echo json_encode($all);
		 ?>