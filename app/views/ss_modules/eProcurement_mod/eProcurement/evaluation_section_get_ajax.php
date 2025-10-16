<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

ob_start();
?>

<select class="section_name" name="evaluation_section" id="evaluation_section"><option></option><? foreign_relation('rfq_evaluation_section','id','section_name',$evaluation_section,'rfq_no="'.$_SESSION['rfq_no'].'"')?></select>
<?
$select = ob_get_clean();

ob_start();
$sql = 'select * from rfq_evaluation_section where rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
       <table class="w-100" border="0" cellspacing="5" cellpadding="5">
	   <tbody>
	  <tr>
	    <td style="font-weight:bold;">Section</td>
		<td style="font-weight:bold;">Weightage</td>
		<td style="font-weight:bold;">Total Weightage</td>
		</tr>
		
		 <tr>
	    <td><?=$doc->section_name?></td>
		<td><?=$doc->section_percent?>%</td>
		<td><span id="total_weight<?=$doc->id?>"><?=find_a_field('rfq_evaluation_section_child','sum(average_percent)','section_id="'.$doc->id.'" and rfq_no="'.$_SESSION['rfq_no'].'"');?></span>%</td>
		</tr>
		
		<tr>
	    <td><input type="text" class="section_name" name="section_child<?=$doc->id?>" id="section_child<?=$doc->id?>" value="" placeholder="Criteria"></td>
		<td><input type="text" class="section_name" name="section_child_percent<?=$doc->id?>" id="section_child_percent<?=$doc->id?>" value="" placeholder="Weightage..%"></td>
		<td><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn1 btn1-bg-update" onclick="add_evaluation_section_child(<?=$doc->id?>,document.getElementById('section_child'+<?=$doc->id?>).value,document.getElementById('section_child_percent'+<?=$doc->id?>).value); total_weight_sum(<?=$doc->id?>);">+</button>
				<? } ?></td>
		</tr>
		
		<tr>
	    <td colspan="3">
		 
             <table class="w-100" border="1" id="section_child_details_<?=$doc->id?>">
            <tbody>
			<?
		 $sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$_SESSION['rfq_no'].'" and section_id="'.$doc->id.'"';
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

			
<?
}
$body = ob_get_clean();
$all['msg'] = 'success';
$all['section_assign'] = $select;
$all['section_details'] = $body;
echo json_encode($all);