<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);
$info = explode("|",$data[1]);
$unique='id';
$table_master = 'rfq_evaluation_section_child';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];

$_POST['rfq_no'] = $rfq_no;
$section_info = find_all_field('rfq_evaluation_section','','id="'.$data[0].'"');
if($_SESSION['rfq_no']>0){
$_POST['section_id'] = $data[0];
$_POST['child_name'] = $info[0];
$_POST['child_percent'] = $info[1];
$_POST['average_percent'] = (($info[1]/100)*($section_info->section_percent/100))*100;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();

$_POST['field_name'] = 'event_section_insert';
$_POST['field_value'] = $info[0];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}

?>
<table class="w-100"   border="1">

			<?
		 $sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$rfq_no.'" and section_id="'.$data[0].'"';
		 $qry2 = db_query($sql2);
		 while($doc2=mysqli_fetch_object($qry2)){
		?>

			<tr>
             <td><?=$doc2->child_name?></td>
             <td><?=$doc2->child_percent?>%</td>
             <td><?=$doc2->average_percent?>%</td>
             <td><button type="button" name="section" class="btn2 btn1-bg-cancel" onclick="remove_section_child(<?=$data[0]?>,<?=$doc2->id?>)">x</button></td>
           </tr>
			
			
			<? } ?>
            </table>