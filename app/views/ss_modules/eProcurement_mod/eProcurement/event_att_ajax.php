<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');



''

$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'rfq_doc_details';
$Crud   = new Crud($table_master);

$rfq_no  = $_SESSION['rfq_no'];

$bimol = 'not found';
$k = 1;
if($rfq_no>0){
$bimol = 'found';
$_POST['section_name'] = $info[0];
$_POST['terms'] = $info[1];
$_POST['att_response'] = $info[2];
$_POST['is_required'] = $info[3];

$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();



    $r_file_name = $_FILES['details_doc']['name'];
	$r_file_size = $_FILES['details_doc']['size'];
	$r_file_temp = $_FILES['details_doc']['tmp_name'];
	if($r_file_size>0){
	$bimol = 'att_found';
	for($r=0; $r<count($r_file_name);$r++){

	$r_div[$r] = explode('.', $r_file_name[$r]);
	$r_file_ext = strtolower(end($r_div[$r]));
	$orginal_file_name = $r_div[$r][0];
	$allowed = array('jpg','jpeg','png','pdf', 'docx', 'eml', 'xlsx', 'xls', 'msg');
	if(in_array($r_file_ext,$allowed)){
	$r_unique_image = uniqid().'.'.$r_file_ext;
	$r_uploaded_image = "../../../../media_NEWERP/material_req_general/".$r_unique_image;
	

	
	$new_pp = db_query($ii_query);		
	$k++;
	}
	else{
	$type= 0;
	$msg='Invalid Attached Document Format';	    
	}
	}
	}
	

$_POST['field_name'] = 'event_att_details';
$_POST['field_value'] = $data[1];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');

}
$all['msgg'] = $bimol.$k;
$all['count'] = $k;
$sql = 'select * from rfq_doc_details where 1 and rfq_no="'.$rfq_no.'"';
$qry = db_query($sql);
while($doc=mysqli_fetch_object($qry)){
		?>
		<div class="row m-0 p-0 pt-4">
			<div class="col-6 ">
			<h1 class="h1 m-0 p-0 pl-3">Attachments-<?=++$i;?></h1>
			
			<div class="pl-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment Name </p>
				<p class="p-0 m-0" ><?=$doc->section_name?></p>
			</div>
			
			<div class="pl-3 pt-3">
				<p class="p-0 m-0" style="font-weight:bold"> Attachment</p>
				<p class="p-0 m-0" ><? if($event_info_file!=''){?>
				<a href="../../../assets/support/upload_view.php?mod=eProcurement_mod&name=<?=$doc->att_file?>&folder=rfq&proj_id=1" target="_blank" rel="noopener">View Document</a><? } ?></p>
				 <div  ><button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_details_att_cancel(document.getElementById('new_rfq_no').value,<?=$doc->id?>)">Delete</button></div>
			</div>
			
				
			</div>	
			<div class="col-6">
				<p class="p-0 m-0 bold">Instructions to Supplier</p>
				<p class="p-0 m-0" >
				<?=$doc->terms?>
				</p>
				
				  <input type="checkbox" id="att_response2" name="att_response2" <?php if($doc->att_response>0) {echo 'checked';} else{ echo '';}?> >
					<label for="sa2">Allow Supplier to response with attachment</label><br>
					
					<input type="checkbox" id="is_required2" name="is_required2" <?php if($doc->is_required>0) {echo 'checked';} else {echo '';}?>  >
					<label for="sa3">Make response required</label><br>
				
				
			</div>
		</div>
		<hr />
		<? } 
		echo json_encode($all);
		?>
		