<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);



$rfq_no  = $_SESSION['rfq_no'];
$section_id  = $data[0];
$child_id  = $data[1];



if($rfq_no>0 && $child_id>0){
$del = 'delete from rfq_evaluation_section_child where id="'.$child_id.'"';
db_query($del);

$_POST['rfq_no'] = $rfq_no;
$_POST['field_name'] = 'event_section_cancel';
$_POST['field_value'] = $child_id;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
$section_info = find_all_field('rfq_evaluation_section','','id="'.$section_id.'"');
?>

<table class="w-100" border="1">
            <tbody>
			<?
		 $sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$rfq_no.'" and section_id="'.$section_id.'"';
		 $qry2 = db_query($sql2);
		 while($doc2=mysqli_fetch_object($qry2)){
		?>

			<tr>
             <td><?=$doc2->child_name?></td>
             <td><?=$doc2->child_percent?>%</td>
             <td><?=$doc2->average_percent?>%</td>
             <td><button type="button" name="section" class="btn2 btn1-bg-cancel" onclick="remove_section_child(<?=$section_id?>,<?=$doc2->id?>)">x</button></td>
           </tr>
			
			
			<? } ?>
			</tbody>
            </table>