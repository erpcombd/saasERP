<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
 $data_id=$data[0];
 
if($data[2]=='yearAjax'){
   $dt = find_all_field('grade_settings','year_no','grade="'.$data_id.'"  and year_no = "'.$data[1].'"');
   
  
?>
							
							
							<div class="col-sm-4">
						    <label for="fname">Basic:</label>
							<input name="basic_salary" type="text" id="basic_salary" value="<? echo $dt->final_basic; echo $dt->basic?>" onkeyup="pf_cal()" class="form-control"  />
							</div>
							<div class="col-sm-4">
							<label for="fname">House Rent:</label>
							<input name="house_rent" type="text" id="house_rent" onclick="pf_cal()" class="form-control"  value="<?=$dt->house?>" />
							
							</div>
							
							<div class="col-sm-4">
							<label for="fname">Medical Allowance:</label>
							<input name="medical_allowance" type="text" id="medical_allowance" onclick="pf_cal()"  value="<?=$dt->medical?>" class="form-control" />
							</div>
							<div class="col-sm-4">
							<label for="fname">Conveyance Allowance:</label>
							<input name="convenience" type="text" id="convenience" onclick="pf_cal()"  value="<?=$dt->conveyance?>" class="form-control" />
							</div>
							
							<div class="col-sm-4">
							<label for="fname">Entertainment Allowance:</label>
							<input name="entertainment" type="text" id="entertainment" onclick="pf_cal()"  value="<?=$dt->entertainment?>" class="form-control" />
							</div>
							
							

<?
}
?>


<?php /*?>
<select name="ledger_sub_group_id" required id="ledger_sub_group_id"  tabindex="2" style="width:220px;">
<option></option>
<? foreign_relation('ledger_sub_group','sub_group_id','CONCAT(sub_group_id, ": ", sub_group_name)',$ledger_sub_group_id,'group_id="'.$data_id.'"');?>
</select><?php */?>

