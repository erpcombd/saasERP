<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'rfq_evaluation_team';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];
$id = $data[0];

if($rfq_no>0 && $id>0){
$del = 'delete from rfq_section_evaluation_team where id="'.$id.'" and rfq_no="'.$rfq_no.'"';
db_query($del);

$_POST['rfq_no'] = $rfq_no;
$_POST['field_name'] = 'event_team_cancel';
$_POST['field_value'] = $id;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
?>

<? 
						$sql = 'select DISTINCT u.user_id,a.id,u.fname,a.action from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and a.action in ("Owner","Evaluator")';
		 $qry = db_query($sql);
		 while($data=mysqli_fetch_object($qry)){
			 
		?>
		<tr>
							<td><?=$data->fname?></td>
                            <td><?=$data->action?></td>
							<td>Pending</td>
							<td><? 
						$sql2 = 'select a.id,u.fname,u.user_id,a.action from rfq_section_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and u.user_id="'.$data->user_id.'"';
		 $qry2 = db_query($sql2);
		 while($data2=mysqli_fetch_object($qry2)){
			 echo $data2->action;
			 echo ', ';
			 
		?>
        <span><button type="button" name="section" class="btn2 btn1-bg-cancel" onclick="remove_evaluator(<?=$data2->id?>)">x</button></span>
        <br>
        <? } ?>
        </td>
							<td></td>
                        </tr>
		<? } ?>