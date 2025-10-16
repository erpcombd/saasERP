<?php
session_start();

ob_start();
require "../../config/inc.all.php";
if(!empty($_POST["keyword"])) {
   $check = find_a_field('hrm_kpi_set','PBI_ID','DEPT_HEAD="'.$_SESSION['employee_selected'].'"');
   if($_SESSION['employee_selected']=='101656' || $_SESSION['employee_selected']==31502 || $_SESSION['employee_selected']==31501){
  $query ="SELECT * FROM personnel_basic_info WHERE  PBI_ID like '%" . $_POST["keyword"] . "%' and PBI_JOB_STATUS='In Service' and PBI_ID not in ('".$_SESSION['employee_selected']."') ORDER BY PBI_NAME LIMIT 0,6";
 }elseif($check>0){
 $query ="SELECT p.* FROM personnel_basic_info p, hrm_kpi_set e WHERE p.PBI_JOB_STATUS='In Service' and p.PBI_ID=e.PBI_ID and e.DEPT_HEAD='".$_SESSION['employee_selected']."' and p.PBI_ID like '%" . $_POST["keyword"] . "%' ORDER BY p.PBI_NAME LIMIT 0,6";
 }else{
  $query ="SELECT p.* FROM personnel_basic_info p, hrm_kpi_set e WHERE p.PBI_JOB_STATUS='In Service' and p.PBI_ID=e.PBI_ID and e.LINE_MANAGER='".$_SESSION['employee_selected']."' and p.PBI_ID like '%" . $_POST["keyword"] . "%' ORDER BY p.PBI_NAME LIMIT 0,6";
 }
$result = mysql_query($query);

if(!empty($result)) {
?>
<ul id="country-list">
<?php
while($d = mysql_fetch_object($result)){
?>
<li onClick="selectCountry('<?php echo $d->PBI_ID; ?>');"><?php echo $d->PBI_NAME; ?></li>
<?php } ?>

<li onClick="selectCountry('<?php echo $_SESSION['employee_selected']; ?>');"><?php echo find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_SESSION['employee_selected'].'"'); ?></li>

</ul>
<?php } } ?>