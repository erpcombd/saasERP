<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'rfq_section_evaluation_team';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];

$user_id = end(explode("#",$data[0]));
$level = $data[1];
$_POST['rfq_no'] = $rfq_no;
$role = find_a_field('rfq_evaluation_section','section_name','id="'.$level.'"');
if($_SESSION['rfq_no']>0){
$_POST['user_id'] = $user_id;
$_POST['action'] = $role;
$_POST['section'] = $level;
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

<? 
						$sql = 'select a.id,u.fname,u.user_id,a.action from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" group by u.user_id';
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