<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'rfq_evaluation_section';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];

$_POST['rfq_no'] = $rfq_no;

if($_SESSION['rfq_no']>0){
$_POST['section_name'] = $data[0];
$_POST['section_percent'] = $data[1];
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

			<div class="col-12 row">
	<div class="col-6 ">
			<fieldset class="scheduler-border">
    <legend class="scheduler-border" style="font-size: 16px !important;">&nbsp;<?=$doc->section_name.'-'.$doc->section_percent?>%</legend>
			
			<div class="pl-3 d-flex">
				<div style=" width: 50% !important;"><input type="text" class="section_name" name="section_child<?=$doc->id?>" id="section_child<?=$doc->id?>" value="" placeholder="Section Child"></div>
                <div style=" width: 20% !important;"><input type="text" class="section_name" name="section_child_percent<?=$doc->id?>" id="section_child_percent<?=$doc->id?>" value="" placeholder="%"></div>
				<div><button type="button" name="section" class="btn1 btn1-bg-update" onclick="add_evaluation_section_child(<?=$doc->id?>,document.getElementById('section_child'+<?=$doc->id?>).value,document.getElementById('section_child_percent'+<?=$doc->id?>).value)">+</button></div>
				<p class="p-0 m-0" ></p>
                
			</div>
            
            <div id="section_child_details_<?=$doc->id?>">
            <table class="w-100"    border="1">
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
             <td><button type="button" name="section" class="btn2 btn1-bg-cancel" onclick="remove_section_child(<?=$doc->id?>,<?=$doc2->id?>)">x</button></td>
           </tr>
           
			
			<? } ?>
			</tbody>
            </table>
			</div>
            <button type="button" onclick="remove_section(<?=$doc->id?>)" style="border:0px;">Remove Section</button>
			</fieldset>
            
			</div>
            
			</div>
			
			<? } ?>
	
			