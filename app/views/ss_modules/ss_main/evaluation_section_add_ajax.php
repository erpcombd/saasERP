<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$info = explode("|",$data[1]);

$unique='id';
$table_master = 'rfq_evaluation_section';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];

$_POST['rfq_no'] = $rfq_no;

if($_SESSION['rfq_no']>0){
$_POST['section_name'] = $data[0];
$_POST['section_percent'] = $info[0];
$_POST['evaluation_method'] = $info[1];
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
			<?
		 $sql = 'select * from rfq_evaluation_section where rfq_no="'.$rfq_no.'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
       <table class="w-100" border="1" cellspacing="5" cellpadding="5">
	   <tbody>
	  <tr>
	    <td style="font-weight:bold;">Section</td>
		<td colspan="2" style="font-weight:bold;">Weightage</td>
		</tr>
		
		 <tr>
	    <td><?=$doc->section_name?></td>
		<td colspan="2"><?=$doc->section_percent?>%</td>
		</tr>
		
		<tr>
	    <td><input type="text" class="section_name" name="section_child<?=$doc->id?>" id="section_child<?=$doc->id?>" value="" placeholder="Criteria"></td>
		<td><input type="text" class="section_name" name="section_child_percent<?=$doc->id?>" id="section_child_percent<?=$doc->id?>" value="" placeholder="Weightage..%"></td>
		<td><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn1 btn1-bg-update" onclick="add_evaluation_section_child(<?=$doc->id?>,document.getElementById('section_child'+<?=$doc->id?>).value,document.getElementById('section_child_percent'+<?=$doc->id?>).value)">+</button>
				<? } ?></td>
		</tr>
		
		<tr>
	    <td colspan="3">
		 
             <table class="w-100" border="1" id="section_child_details_<?=$doc->id?>">
            <tbody>
			<?
		 $sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$rfq_no.'" and section_id="'.$doc->id.'"';
		 $qry2 = db_query($sql2);
		 while($doc2=mysqli_fetch_object($qry2)){
		?>
           
           <tr>
             <td><?=$doc2->child_name?></td>
             <td><?=$doc2->child_percent?>%</td>
             <td><?=$doc2->average_percent?>%</td>
             <td><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn2 btn1-bg-cancel" onclick="remove_section_child(<?=$doc->id?>,<?=$doc2->id?>)">x</button><? } ?></td>
           </tr>
			
			
			<? } ?>
			</tbody>
            </table>

		</td>
		</tr>
		<tr>
		 <td colspan="3"><button type="button" onclick="remove_section(<?=$doc->id?>)" style="border:0px;">Remove Section</button></td>
		</tr>
		</tbody>
		</table><br />

			<? } ?>
			
			