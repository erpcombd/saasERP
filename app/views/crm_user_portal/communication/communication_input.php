<?php
//

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Communication Process Entry';			// Page Name and Page Title
$page="communication.php";		// PHP File Name
$input_page="coomunication_input.php";
$root='communication';

$table='crm_comunication';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='c_reason';				// For a New or Edit Data a must have data field
// ::::: End Edit Section :::::



$crud      =new crud($table);
$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{


$$unique = $_POST[$unique];


if(isset($_POST['insert'])|| isset($_POST['insertn']))
{		




if($_FILES['comm_file']['tmp_name']!=''){



			$file_name= $_FILES['comm_file']['name'];



			$file_tmp= $_FILES['comm_file']['tmp_name'];



			$ext=end(explode('.',$file_name));



			$path='../../../../crm_com_file/';



			move_uploaded_file($file_tmp, $path.$$unique.'.pdf');



			}


$now		= time();


$_POST['entry_by'] = $_SESSION['employee_selected'];


$crud->insert();







$_POST['id'] = find_a_field('crm_comunication','max(id)','1');








$pbi_id = $_POST['PBI_ID'];
$tot_r_pbi =  count($_POST['PBI_ID']);

if($tot_r_pbi>0){

for($i=0;$i<$tot_r_pbi;$i++){
if($pbi_id[$i]>0){
$selects = 'select * from personnel_basic_info where PBI_ID="'.$pbi_id[$i].'" ';
$querys = db_query($selects);
$result = mysqli_fetch_object($querys);

$project_name = find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$result->PROJECT_ID.'"');


$insert = 'insert into crm_com_detail_emp set com_id="'.$_POST['id'].'", PROJECT_DESC="'.$project_name.'",project_desg="'.$result->project_desg.'",project_dept="'.$result->project_dept.'" ,  PBI_ID="'.$pbi_id[$i].'", entry_by="'.$_SESSION['employee_selected'].'"';
db_query($insert);
}

}
}






$unassign = $_POST['unassign'];
$tot_r_unass =  count($_POST['unassign']);

if($tot_r_unass>0){

for($i=0;$i<$tot_r_unass;$i++){
if($unassign[$i]>0){
$selects = 'select * from crm_customer_info where dealer_code="'.$unassign[$i].'" ';
$querys = db_query($selects);
$result = mysqli_fetch_object($querys);

$project_name = find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$result->PROJECT_ID.'"');


$insert = 'insert into crm_com_detail_unassign set com_id="'.$_POST['id'].'", PROJECT_DESC="'.$project_name.'",project_desg="'.$result->project_desg.'",project_dept="'.$result->project_dept.'" ,  dealer_code="'.$unassign[$i].'", entry_by="'.$_SESSION['employee_selected'].'"';
db_query($insert);
}

}
}










$dealer_code = $_POST['dealer_code'];
$tot_r_ar =  count($_POST['dealer_code']);

if($tot_r_ar>0){

for($i=0;$i<$tot_r_ar;$i++){
if($dealer_code[$i]>0){
$selects = 'select * from crm_customer_info where dealer_code="'.$dealer_code[$i].'" ';
$querys = db_query($selects);
$result = mysqli_fetch_object($querys);

$project_name = find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$result->PROJECT_ID.'"');


$insert = 'insert into crm_com_detail set com_id="'.$_POST['id'].'", PROJECT_DESC="'.$project_name.'",project_desg="'.$result->project_desg.'",project_dept="'.$result->project_dept.'" ,  dealer_code="'.$dealer_code[$i].'", entry_by="'.$_SESSION['employee_selected'].'"';
db_query($insert);
}

}
}


$type=1;
$msg='New Entry Successfully Inserted.';

if(isset($_POST['insert']))
{
echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
}
unset($_POST);
unset($$unique);


}


//for Modify..................................

if(isset($_POST['update']))
{

$pbi_id = $_POST['PBI_ID'];
$tot_r_pbi =  count($_POST['PBI_ID']);




if($_FILES['comm_file']['tmp_name']!=''){



			$file_name= $_FILES['comm_file']['name'];



			$file_tmp= $_FILES['comm_file']['tmp_name'];



			$ext=end(explode('.',$file_name));



			$path='../../../../crm_com_file/';



			move_uploaded_file($file_tmp, $path.$$unique.'.pdf');



			}





if($tot_r_pbi>0){

$delete = 'delete from crm_com_detail_emp where com_id="'.$_POST['id'].'"';
db_query($delete);

for($i=0;$i<$tot_r_pbi;$i++){
if($pbi_id[$i]>0){

$selects = 'select * from personnel_basic_info where PBI_ID="'.$pbi_id[$i].'" ';
$querys = db_query($selects);
$result = mysqli_fetch_object($querys);

$project_name = find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$result->PROJECT_ID.'"');


$insert = 'insert into crm_com_detail_emp set com_id="'.$_POST['id'].'", PROJECT_DESC="'.$project_name.'",project_desg="'.$result->project_desg.'",project_dept="'.$result->project_dept.'" ,  PBI_ID="'.$pbi_id[$i].'", entry_by="'.$_SESSION['employee_selected'].'"';
db_query($insert);
}

}
}



$unassign = $_POST['unassign'];
$tot_r_unass =  count($_POST['unassign']);

if($tot_r_unass>0){

$delete = 'delete from crm_com_detail_unassign where com_id="'.$_POST['id'].'"';
db_query($delete);

for($i=0;$i<$tot_r_unass;$i++){
if($unassign[$i]>0){

$selects = 'select * from crm_customer_info where dealer_code="'.$unassign[$i].'" ';
$querys = db_query($selects);
$result = mysqli_fetch_object($querys);

$project_name = find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$result->PROJECT_ID.'"');


 $insert = 'insert into crm_com_detail_unassign set com_id="'.$_POST['id'].'", PROJECT_DESC="'.$project_name.'",project_desg="'.$result->project_desg.'",project_dept="'.$result->project_dept.'" ,  dealer_code="'.$unassign[$i].'", entry_by="'.$_SESSION['employee_selected'].'"';
db_query($insert);
}

}
}




$dealer_code = $_POST['dealer_code'];
$tot_r_ar =  count($_POST['dealer_code']);

if($tot_r_ar>0){

$delete = 'delete from crm_com_detail where com_id="'.$_POST['id'].'"';
db_query($delete);

for($i=0;$i<$tot_r_ar;$i++){
if($dealer_code[$i]>0){

$selects = 'select * from crm_customer_info where dealer_code="'.$dealer_code[$i].'" ';
$querys = db_query($selects);
$result = mysqli_fetch_object($querys);

$project_name = find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$result->PROJECT_ID.'"');


$insert = 'insert into crm_com_detail set com_id="'.$_POST['id'].'", PROJECT_DESC="'.$project_name.'",project_desg="'.$result->project_desg.'",project_dept="'.$result->project_dept.'" ,  dealer_code="'.$dealer_code[$i].'", entry_by="'.$_SESSION['employee_selected'].'"';
db_query($insert);
}

}
}

$_POST['update_by'] = $_SESSION['employee_selected'];
$_POST['update_at'] = date('Y-m-d H:i:s');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
				echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}
//if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        
        <link href="../../../assets/css/css.css" rel="stylesheet">
		<link rel="stylesheet" href="bootstrap-select.min.css">
		<link rel="stylesheet" href="bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		
		<style>
		.openerp .oe_form .oe_form_group {
		margin-top: 0px !important;
}
.openerp td{
padding: 5px;
}

.openerp .oe_form input[type="text"], .openerp .oe_form input[type="password"], .openerp .oe_form input[type="file"], .openerp .oe_form select, .openerp .oe_form textarea{
padding: 3px;
}
		
		
		.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){
		width: 100%;
		
		}
		.btn{
		padding: 3px;
		}
		
		.bootstrap-select .dropdown-toggle .filter-option-inner-inner{
		width: 330px;
		}
		.open>.dropdown-menu{
		width: 200px;
		}
		</style>
		
		
		
<script src="bootstrap.min.js"></script>
<script src="jquery-1.11.1.min.js"></script>
		<script type="text/javascript">
		
$(document).ready(function(){
    $('#lead_no').on('change',function(){
	var links = '';
	
	var uniques = "<?=$_GET['id']?>";
	
	if(uniques!=''){
	var sr_link = "communication_input.php?lead_no=" + $(this).val()+ " & id=" + uniques;
window.location = sr_link;
	}else{
	var sr_link = "communication_input.php?lead_no=" + $(this).val();
window.location = sr_link;
}
    });
});
</script>




		</head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post" enctype="multipart/form-data"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none;  position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
          <? include('../../common/title_bar_popup.php');?>
      <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="">
                      <? include('../../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell">
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
	
			
			
			
			
			
			
			
			
			
			
			
			
			<table width="100%" height="231" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
			
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">Communication ID </td>
                  <td class="oe_form_group_cell oe_form_group_cell_label"> <input type="text" readonly="" value="<?=$$unique?>" style="background: white;"> </td>
                  <td height="33" colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Lead No </td>
                  <td height="33" colspan="3" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				  
				  <select name="lead_no" id="lead_no"  class="selectpicker"   data-live-search="true" required>
				  <option value="<? if($lead_no){echo $lead_no;}elseif($_GET['lead_no']){echo $_GET['lead_no'];}?>"><?
				  if($lead_no) {$main_lead_data =  $lead_no;}elseif($_GET['lead_no']){ $main_lead_data =  $_GET['lead_no'];}
				  $selectss = 'select l.*,p.PROJECT_DESC from crm_lead_master l, crm_project p where 1 and l.project_id=p.PROJECT_ID and l.lead_no= "'.$main_lead_data.'" ';
					$queryss = db_query($selectss);
					$rowss = mysqli_fetch_object($queryss);
				  ?>
				  
				  <?=$rowss->lead_no?> | <?=$rowss->lead_title?> | <?=$rowss->PROJECT_DESC?> 
				  </option><? 
				  	$selects = 'select l.*,p.PROJECT_DESC from crm_lead_master l, crm_project p where 1 and l.project_id=p.PROJECT_ID order by l.lead_no';
					$querys = db_query($selects);
					while($row = mysqli_fetch_object($querys)){
				  ?>
				  
				  
        <option value="<?=$row->lead_no?>"><?=$row->lead_no?> | <?=$row->lead_title?> | <?=$row->PROJECT_DESC?></option>
		
		<? } ?>
				  </select>				  </td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Customer Name </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				 
				  <select name="PROJECT_ID" id="PROJECT_ID" style="width:205px"  class="form-control"   >
				  
				  
				  
				  <option value="<? $get_project_id = find_a_field('crm_lead_master','project_id','lead_no="'.$_GET['lead_no'].'"'); if($PROJECT_ID){echo $output_project =  $PROJECT_ID; } elseif($get_project_id){echo $output_project = $get_project_id ; }?>"><? echo find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$output_project.'"'); ?></option>
				  </select>				  </td>
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Select Service </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				  
				  
				  <select name="service_id" id="service_id"  class="form-control" style="width: 205px;" >
				  <option value="<? $get_service_id = find_a_field('crm_lead_master','service_id','lead_no="'.$_GET['lead_no'].'"'); if($service_id){echo $output_service_id =  $service_id; } elseif($get_project_id){echo $output_service_id = $get_service_id;}?>"><? echo find_a_field('crm_service','service_name','service_id="'.$output_service_id.'"'); ?></option>
				  </select>				 </td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Contact Person </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				  
				  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
				  
				  
				  <select name="EMP_ID" id="EMP_ID"  style="width:205px;"  class="form-control" >
				  
				  
				  <option value="<? $get_contact_prson_id = find_a_field('crm_lead_master','PBI_ID','lead_no="'.$_GET['lead_no'].'"'); if($EMP_ID){echo $output_contact_person =  $EMP_ID; } elseif($get_contact_prson_id){echo $output_contact_person = $get_contact_prson_id ; }?>"><? echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$output_contact_person.'"'); ?></option>
                  </select>				  </td>
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Attachment</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				  <input type="file" name="comm_file" id="comm_file" class="form-control">				  </td>
                </tr>
                
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Communication Subject : </td>
                  <td colspan="3" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"> <input type="text" name="c_reason" id="c_reason" value="<?=$c_reason?>" class="form-control" style="width: 650px;"> </td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Communication Details : </td>
                  <td colspan="3" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><textarea name="c_detail" id="c_detail" style="width: 650px; height: 80px" ><?=$c_detail?></textarea></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Communication Time </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="time" name="c_time" id="c_time" value="<?=$c_time?>"  style="width:150px;" ></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Communication Date </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="date" name="c_date" id="c_date"  value="<?=$c_date?>"  width="150px" required></td>
                </tr>
                <!--<tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr><tr class="oe_form_group_row">
                  <td height="33" colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  </tr>-->
				  <tr><td colspan="4">&emsp;</td></tr>
				  <tr><td colspan="4">&emsp;</td></tr>
				  
				  <tr>
				  
				  <td colspan="2"  width="500">
				  
				  <table class="table " width="100%" cellpadding="5" align="center">
				<thead>
					<tr >
					
    					<th class="text-center"  style="text-align: center; padding: 5px; background:#FFCCCC;">
							Select Customer Person						</th>
					</tr>
				</thead>
				<tbody>
				<?
				 $selectt = 'select * from crm_com_detail where com_id="'.$$unique.'"';
				$queryy = db_query($selectt);
				while($rows = mysqli_fetch_object($queryy)){
				
				 ?>
				
				<tr  >
						
    					<td data-name="se" style="background: #1ABB9C;">
						

						    <select name="dealer_code[]"  class="selectpicker" data-live-search="true" style="border-color: 1px solid green;width:100%">
							<? 
							
							$all_customer = find_all_field('crm_customer_info','*','dealer_code="'.$rows->dealer_code.'"');
							
							?>
							
        				        <option value="<?=$rows->dealer_code?>"><?=$all_customer->dealer_name_e?> | <?=$all_customer->project_dept?> | <?=$all_customer->project_desg?> | <?=find_a_field('crm_customer_info a, crm_project b','b.PROJECT_DESC','a.PROJECT_ID=b.PROJECT_ID and a.dealer_code="'.$rows->dealer_code.'"')?></option>
								<option value="">&emsp;</option>
								<?
					 
					 $sql = "select * from crm_customer_info where 1 and PROJECT_ID!=''";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->project_dept?> | <?=$row->project_desg?> | <?=find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$row->PROJECT_ID.'"')?></option>
					 
					 
					 <?
					 
					 }
					 ?>
						    </select>						</td>
					</tr>
				<? } ?>
				<tr>
				<td>
					
    				 <select name="dealer_code[]" onChange="sr_customer_change(this.value)" style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
					 
					 	//if($output_project!=''){
//					 $project_conn = " and  PROJECT_ID='".$output_project."'" ;
//					 
//					 }
					 
					 $sql = "select * from crm_customer_info where 1 ".$project_conn. " ";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->project_dept?> | <?=$row->project_desg?> | <?=find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$row->PROJECT_ID.'"')?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>					</td>
					</tr>
						<tr>
				<td>
					
    				  <select name="dealer_code[]" onChange="sr_customer_change(this.value)" style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
					 
					 //	if($output_project!=''){
//					 $project_conn = " and  PROJECT_ID='".$output_project."'" ;
//					 
//					 }
					 
					  $sql = "select * from crm_customer_info where 1 ".$project_conn. " ";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->project_dept?> | <?=$row->project_desg?> | <?=find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$row->PROJECT_ID.'"')?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>					</td>
					</tr>
					<tr>
				<td>
					
    				  <select name="dealer_code[]" onChange="sr_customer_change(this.value)" style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
						//if($output_project!=''){
//					 $project_conn = " and  PROJECT_ID='".$output_project."'" ;
//					 
//					 }
					 
					  $sql = "select * from crm_customer_info where 1  ".$project_conn. " ";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->project_dept?> | <?=$row->project_desg?> | <?=find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$row->PROJECT_ID.'"')?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>				</td>
					</tr>
					<tr>
				<td>
					
    				  <select name="dealer_code[]" onChange="sr_customer_change(this.value)" style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
					 	//if($output_project!=''){
//					 $project_conn = " and PROJECT_ID='".$output_project."'" ;
//					 
//					 }
					 
					  $sql = "select * from crm_customer_info where 1  ".$project_conn. " ";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->project_dept?> | <?=$row->project_desg?> | <?=find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$row->PROJECT_ID.'"')?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>					</td>
					</tr>
					<tr>
				<td>
					
    				 <select name="dealer_code[]" onChange="sr_customer_change(this.value)" style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
					 //	if($output_project!=''){
//					 $project_conn = " and PROJECT_ID='".$output_project."'" ;
//					 
//					 }
					 
					  $sql = "select * from crm_customer_info where 1  ".$project_conn. " ";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->project_dept?> | <?=$row->project_desg?> | <?=find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$row->PROJECT_ID.'"')?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>					</td>
					</tr>
				</tbody>
			</table>				  </td>
				  <td colspan="2">
				  
				  <table class="table " width="100%" cellpadding="5" align="center">
				<thead>
					<tr >
					
    					<th class="text-center"  style="text-align: center; padding: 5px; background:#FFCCCC;">
							Select Contact Person						</th>
					</tr>
				</thead>
				<tbody>
				<?
				
				  $select = 'select e.*,p.PBI_NAME,p.PBI_CODE, (select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION from crm_com_detail_emp e, personnel_basic_info p where e.PBI_ID=p.PBI_ID and e.com_id="'.$$unique.'"';
				$query = db_query($select);
				while($row = mysqli_fetch_object($query)){
				
				 ?>
				
				<tr>
						
    					<td data-name="se" style="background: #1ABB9C;">
						

						    <select name="PBI_ID[]"  style="width:100%"  class="selectpicker" data-live-search="true">
							
        				        <option value="<?=$row->PBI_ID?>"><?=$row->PBI_NAME?> | <?=$row->PBI_CODE?> | <?=$row->PBI_DEPARTMENT?> | <?=$row->PBI_DESIGNATION?> | </option>
								<option value="">&emsp;</option>
								
								<?
								 $selectt = 'select p.PBI_ID,p.PBI_CODE,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION from personnel_basic_info p where 1';
								
								$queryt = db_query($selectt);
								
								while($rowt = mysqli_fetch_object($queryt)){
								
								?>
								<option value="<?=$rowt->PBI_ID?>"><?=$rowt->PBI_NAME?> | <?=$rowt->PBI_DESIGNATION?> | <?=$rowt->PBI_DEPARTMENT?> | <?=$rowt->PBI_CODE?></option>
								
								<?
								}
								?>
								
								<? //foreign_relation('personnel_basic_info p','p.PBI_ID','p.PBI_NAME,p.PBI_DESIGNATION',$PBI_ID,'1  ')?>
						    </select>						</td>
					</tr>
				<? } ?>
				
				
				<tr>
				<td>
					
    				 <select name="PBI_ID[]"  style="width:100%"  class="selectpicker" data-live-search="true">
					 <option value="">&emsp;</option>
					 <?
								 $select = 'select p.PBI_ID,p.PBI_CODE,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION from personnel_basic_info p where 1 and p.PBI_JOB_STATUS="In Service"';
								
								$query = db_query($select);
								
								while($row = mysqli_fetch_object($query)){
								
								?>
								<option value="<?=$row->PBI_ID?>"><?=$row->PBI_NAME?> | <?=$row->PBI_DESIGNATION?> | <?=$row->PBI_DEPARTMENT?> | <?=$row->PBI_CODE?></option>
								
								<?
								}
								?>
					 </select>					</td>
					</tr>
						<tr>
				<td>
					
    				 <select name="PBI_ID[]" style="width:100%"  class="selectpicker" data-live-search="true">
					 <option value="">&emsp;</option>
					 <?
								 $select = 'select p.PBI_ID,p.PBI_CODE,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION from personnel_basic_info p where 1 and p.PBI_JOB_STATUS="In Service"';
								
								$query = db_query($select);
								
								while($row = mysqli_fetch_object($query)){
								
								?>
								<option value="<?=$row->PBI_ID?>"><?=$row->PBI_NAME?> | <?=$row->PBI_DESIGNATION?> | <?=$row->PBI_DEPARTMENT?> | <?=$row->PBI_CODE?></option>
								
								<?
								}
								?>
					 </select>					</td>
					</tr>
					<tr>
				<td>
					
    				 <select name="PBI_ID[]" style="width:100%"  class="selectpicker" data-live-search="true">
					 <option value="">&emsp;</option>
					 <?
								 $select = 'select p.PBI_ID,p.PBI_CODE,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION from personnel_basic_info p where 1 and p.PBI_JOB_STATUS="In Service"';
								
								$query = db_query($select);
								
								while($row = mysqli_fetch_object($query)){
								
								?>
								<option value="<?=$row->PBI_ID?>"><?=$row->PBI_NAME?> | <?=$row->PBI_DESIGNATION?> | <?=$row->PBI_DEPARTMENT?> | <?=$row->PBI_CODE?></option>
								
								<?
								}
								?>
					 </select>					</td>
					</tr>
					<tr>
				<td>
					
    				 <select name="PBI_ID[]" style="width:100%"  class="selectpicker" data-live-search="true">
					 <option value="">&emsp;</option>
					<?
								 $select = 'select p.PBI_ID,p.PBI_CODE,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION from personnel_basic_info p where 1 and p.PBI_JOB_STATUS="In Service"';
								
								$query = db_query($select);
								
								while($row = mysqli_fetch_object($query)){
								
								?>
								<option value="<?=$row->PBI_ID?>"><?=$row->PBI_NAME?> | <?=$row->PBI_DESIGNATION?> | <?=$row->PBI_DEPARTMENT?> | <?=$row->PBI_CODE?></option>
								
								<?
								}
								?>
					 </select>					</td>
					</tr>
					<tr>
				<td>
					
    				 <select name="PBI_ID[]" style="width:100%"  class="selectpicker" data-live-search="true">
					 <option value="">&emsp;</option>
					 <?
								 $select = 'select p.PBI_ID,p.PBI_CODE,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION from personnel_basic_info p where 1 and p.PBI_JOB_STATUS="In Service"';
								
								$query = db_query($select);
								
								while($row = mysqli_fetch_object($query)){
								
								?>
								<option value="<?=$row->PBI_ID?>"><?=$row->PBI_NAME?> | <?=$row->PBI_DESIGNATION?> | <?=$row->PBI_DEPARTMENT?> | <?=$row->PBI_CODE?></option>
								
								<?
								}
								?>
					 </select>					</td>
					</tr>
				</tbody>
			</table>				  </td>
				  </tr>
				  
				  <tr>
				  <td></td>
				  <td colspan="2">
				  
				  <table class="table " width="100%" cellpadding="5" align="center">
				<thead>
					<tr >
					
    					<th class="text-center"  style="text-align: center; padding: 5px;background:#FFCCCC;">
							Select Unassign Person						</th>
					</tr>
				</thead>
				<tbody>
				<?
				
				  $selectt = 'select * from crm_com_detail_unassign where com_id="'.$$unique.'"';
				$queryy = db_query($selectt);
				while($rows = mysqli_fetch_object($queryy)){
				
				 ?>
				
				<tr  >
						
    					<td data-name="se" style="background: #1ABB9C;">
						

						    <select name="unassign[]"  style="width:100%"  class="selectpicker" data-live-search="true">
							
							<?
							
							$find_unassign_info =  find_all_field('crm_customer_info',' * ','dealer_code="'.$rows->dealer_code.'"');
							?>
							
							
        				        <option value="<?=$rows->dealer_code?>"><?=$find_unassign_info->dealer_name_e?> | <?=$find_unassign_info->mobile_no?></option>
								<option value="">&emsp;</option>
								<?
					 
					 $sql = "select * from crm_customer_info where 1 and PROJECT_ID=''";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->mobile_no?></option>
					 
					 
					 <?
					 
					 }
					 ?>
						    </select>						</td>
					</tr>
				<? } ?>
				<tr>
				<td>
					
    				 <select name="unassign[]"  style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
					 
					 $sql = "select * from crm_customer_info where 1  and PROJECT_ID=''";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->mobile_no?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>					</td>
					</tr>
						<tr>
				<td>
					
    				 <select name="unassign[]"  style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
					 
					 $sql = "select * from crm_customer_info where 1  and PROJECT_ID=''";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->mobile_no?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>					</td>
					</tr>
					<tr>
				<td>
					
    				 <select name="unassign[]"  style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
					 
					 $sql = "select * from crm_customer_info where 1  and PROJECT_ID=''";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->mobile_no?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>					</td>
					</tr>
					<tr>
				<td>
					
    				 <select name="unassign[]"  style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
					 
					 $sql = "select * from crm_customer_info where 1  and PROJECT_ID=''";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->mobile_no?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>					</td>
					</tr>
					<tr>
				<td>
					
    				 <select name="unassign[]"  style="width:100%"  class="selectpicker" data-live-search="true">
					 
					 <option value="">&emsp;</option>
					 <?
					 
					 $sql = "select * from crm_customer_info where 1  and PROJECT_ID=''";
					 $query = db_query($sql);
					 
					 while($row = mysqli_fetch_object($query)){
					 
					 ?>
					 <option value="<?=$row->dealer_code?>"><?=$row->dealer_name_e?> | <?=$row->mobile_no?></option>
					 
					 
					 <?
					 
					 }
					 ?>
					 </select>					</td>
					</tr>
				</tbody>
			</table>				  </td>
				  <td></td>
				  </tr>
                </tbody></table>
				
				
						
			<div class="row clearfix">
    	<div class="col-md-12 table-responsive">



			
			
			<table width="100%">
			
			<tr>
			
			<td>
			
			
			</td>
			<td>
			
			
			
			</td>
			
			</tr>
			
			<tr>
			
			<td colspan="2">
			
			
			</td>
			
			
			</tr>
			</table>
			
			
			
			
		</div>
	</div>
			
			
			
				
				
<br><br><br><br><br><br><br><br><br></td>
            </tr></tbody></table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="ui-resizable-handle ui-resizable-n" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-e" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-s" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-w" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 1000;"></div>
          <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">

          </div>
        </div>
</form>
</body>
<script src="jquery.min.js"></script>
<script src="bootstraps.min.js"></script>
<script src="bootstrap-select.min.js"></script>




</html>
