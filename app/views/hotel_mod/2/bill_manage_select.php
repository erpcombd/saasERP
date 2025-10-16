<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Advance Bill Information';
do_calander('#generate_date');
$table='hms_bill_payment';
$unique='id';
$time=time();
$now=($time-60*60*12);
$today=date("Y-m-d",$now);
$this_time=date("Y-m-d H:i:s",$time);
?>
<div class="form-container_large">
<form action="bill_manage_advance.php" method="post" name="form2" id="form2">
<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
			<fieldset>
			<legend>Select Service Group </legend>
			<div>
			<label>Group Name: </label>
			<select name="service_group_id">
			<?
			advance_foreign_relation("select id, service_group from hms_service_group where id not in (4,5)",$service_group_id);
			?>
			</select>
			</div>
			<div>
			  <label>
			  <input style="float:right"  type="submit" name="Submit" value="Submit" />
			  </label>
			</div>
			</fieldset>	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>
<?
$sql="SELECT count(1) FROM `hms_rent_bill_generate` WHERE 
			bill_date='".$today."'";
$due = find_a_field_sql($sql);
	?><?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>