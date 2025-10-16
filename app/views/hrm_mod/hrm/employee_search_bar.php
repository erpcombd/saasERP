<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="Employee Basic Information";
$head = '<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';


?>


<form action="" method="post" enctype="multipart/form-data">
  <div class="oe_view_manager oe_view_manager_current">
    <? //include('../common/title_bar.php');?>
    <? include('../common/title_bar_new.php');?>
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
          <div class="oe_view_manager_view_form">
          <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
          <div class="oe_form">
              
              

<div class="main-wrapper">
<div class="page-wrapper">






<div class="row">
<div class="col-md-12">
<div class="table-responsive">
    
    
<table class="table table-bordered table-sm"> 
<thead class="bg-light">
<tr align="center" class="table-info">
<th>ID No</th>
<th>Emp Code</th>
<th>Employee Name</th>
<th>Designation</th>
<th>Department</th>
<th>DOJ</th>
<th>DOL</th>
<th>Grade</th>

<th>Section </th>  
<th>Work Station</th> 



<th>View</th>
</tr>
</thead>
<tbody>



<?

if(isset($_POST['button'])){

if($_POST['old_id']>0) $oldConn = " and a.old_id ='".$_POST['old_id']."'";

if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
if($_POST['PBI_ID']>0) $idConn = " and a.PBI_ID='".$_POST['PBI_ID']."'";
if($_POST['PBI_NAME']!="") $NameConn = " and a.PBI_NAME='".$_POST['PBI_NAME']."'";
if($_POST['DESG_ID']>0) $desgConn = " and a.DESG_ID='".$_POST['DESG_ID']."'";
if($_POST['DEPT_ID']>0) $depConn = " and a.DEPT_ID='".$_POST['DEPT_ID']."'";
if($_POST['PBI_SEX']!="") $genderConn = " and a.PBI_SEX='".$_POST['PBI_SEX']."'";
if($_POST['grade']>0) $gradeConn = " and a.grade='".$_POST['grade']."'";  
if($_POST['work_station']>0) $work_station = " and a.PBI_WORK_STATION='".$_POST['work_station']."'";  



if($_POST['PBI_RELIGION']!="") $ReligionConn = " and a.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
if($_POST['PBI_ORG']>0) $OrgConn = " and a.PBI_ORG='".$_POST['PBI_ORG']."'";
if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and a.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";

if($_POST['section']>0) $secConn = " and a.section='".$_POST['section']."'";
if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
if($_POST['cost_center']>0) $CostConn = " and a.cost_center='".$_POST['cost_center']."'";
//if($_POST['level']>0) $levelConn = " and a.level='".$_POST['level']."'";

if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
if($_POST['line']>0) $lineConn = " and a.line='".$_POST['line']."'";
if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
if($_POST['DOJ']>0) $DOJConn = " and a.PBI_DOJ='".$_POST['DOJ']."'";

 $user_id  =  $_SESSION['user']['id'];



if($user_id == 10073 || $user_id == 10074 || $user_id == 10108) $JOB_LOC_ID_BLOCK = " and a.JOB_LOC_ID !=3";



$sqld = 'select a.* from  personnel_basic_info a 
where 1 '.$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$oldConn.$CostConn.$levelConn.$job_statusConn.$JOB_LOC_ID_BLOCK.' order by a.PBI_ID';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){



$m_s_date = $_POST['year'].'-'.$_POST['mon'].'-'.'01';
$m_e_date = $_POST['year'].'-'.$_POST['mon'].'-'.'31';
$entry_by=$data->entry_by;
$tot_ded = $data->other_deduction+$data->other_deductions;
$join_date_org = date('Y-m-d', strtotime($data->PBI_DOJ));
$join_date_diff = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($data->PBI_DOJ) ) ));
$joindate = date_parse_from_format("Y-m-d", $data->PBI_DOJ);
$joining_month =  $joindate["month"];
$joining_year =  $joindate["year"];
$deduction_days =$data->mtd-$data->pay;
//$deduction_amt  =$data->gross_salary/$data->mtd;
if ($data->mtd != 0) {
  $deduction_amt = $data->gross_salary / $data->mtd;
} else {
 
}
$deduction_amttotal=$deduction_days*$deduction_amt;
?>

<tr>
<td><?=$data->PBI_CODE;?></td>
<td><?=$data->PBI_ID;?></td>
<td><h2 class="table-avatar"><a href="#" onclick="submitForm('<?=$data->PBI_CODE?>')"><?=$data->PBI_NAME;?></span></a></h2></td>
<td class="text-center"><?=find_a_field('designation','DESG_DESC','DESG_ID="'.$data->DESG_ID.'"');?></td>
<td class="text-center"><?=find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');?></td>
<td> <?=date('d-M-Y',strtotime($data->PBI_DOJ))?> </td>
<td class="text-center"><? if($data->resign_date=='0000-00-00') {echo "";}else { echo date("d-M-Y", strtotime($data->resign_date));}?></td>
<td class="text-center"><?=find_a_field('hrm_grade','grade_name','id="'.$data->grade.'"');?></td>
<td class="text-center"><?=find_a_field('PBI_Section','sec_name','sec_id="'.$data->section.'"');?></td>
<td class="text-center"><?=find_a_field('hrm_workstation','work_station_name','station_id="'.$data->PBI_WORK_STATION.'"');?></td>

<td class="text-center"><span class="btn btn-warning btn-sm"><a href="#" onclick="submitForm('<?=$data->PBI_CODE?>')"><b>Open</b></a></span></td>
</tr>


<? } }?>
</tbody>
</table>
</div>
</div>
</div>


</div>

</div>


       </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</form>

<script>
    function submitForm(code) {
        // Create a form dynamically
        var form = document.createElement('form');
        form.action = 'employee_basic_information_nal.php';
        form.method = 'post';

        // Create an input field
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'employee_selected';
        input.value = code;

        // Append the input field to the form
        form.appendChild(input);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>