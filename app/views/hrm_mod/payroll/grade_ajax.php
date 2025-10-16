<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
 $data_id=$data[0];
 
if($data[2]=='yearAjax'){
   $dt = find_all_field('grade_settings','year_no','grade="'.$data_id.'"  and year = "'.$data[1].'"');
?>
<input name="basic_salary" type="text" id="basic_salary" value="<?=$dt->final_basic?>" onclick="pf_cal()" class="form-control"  />

<?
}else{
?>


<select name="year_no" required id="year_no"  onchange="getData2('grade2_ajax.php', 'grade_year_val', document.getElementById('grade').value,  document.getElementById('year_no').value+'##yearAjax')" tabindex="2" style="width:220px;">
<option></option>
<? 
 foreign_relation('grade_settings','year_no','year_no',$year_no,'grade="'.$data_id.'"');?>
</select>

<? } ?>
<?php /*?>
<select name="ledger_sub_group_id" required id="ledger_sub_group_id"  tabindex="2" style="width:220px;">
<option></option>
<? foreign_relation('ledger_sub_group','sub_group_id','CONCAT(sub_group_id, ": ", sub_group_name)',$ledger_sub_group_id,'group_id="'.$data_id.'"');?>
</select><?php */?>

