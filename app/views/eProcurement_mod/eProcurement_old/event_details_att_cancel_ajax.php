<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'rfq_doc_details';
$Crud   = new Crud($table_master);

$rfq_no  = $data[0];
$id = $data[1];


if($rfq_no>0 && $id>0){
$del = 'delete from rfq_doc_details where id="'.$id.'"';
db_query($del);

$_POST['rfq_no'] = $rfq_no;
$_POST['field_name'] = 'event_att_details';
$_POST['field_value'] = $id;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}


$sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$rfq_no.'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
		<div class="row m-0 p-0 pt-4">
			<div class="col-6 ">
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> <?=$doc->section_name?> </p>
			<? $att_sql = 'select * from rfq_documents_information where section_id="'.$doc->id.'" and rfq_no="'.$rfq_no.'"';
			 $att_qry = db_query($att_sql);
			 while($att_data=mysqli_fetch_object($att_qry)){
			?>
			
				<p class="p-0 m-0" ><a href="">
				<a href="../../../../../assets/support/api_upload_attachment_show.php?name=<?=$att_data->new_name?>&&folder=doc_section" target="_blank" rel="noopener">
												<em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> 
												<span><?=$att_data->original_name?></span>
											</a></p>
			
			<? } ?>
			</div>
			<div class="pl-3 pt-3">
				 <div  ><button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_details_att_cancel(document.getElementById('new_rfq_no').value,<?=$doc->id?>)">Delete</button></div>
			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0" >
				<?=$doc->terms?>
				</p>
				
				  <input type="checkbox" id="att_response2" name="att_response2" <?php if($doc->att_response>0) {echo 'checked';} else {echo '';}?> >
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required2" name="is_required2" <?php if($doc->is_required>0) {echo 'checked';} else {echo '';}?>  >
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		<? } ?>