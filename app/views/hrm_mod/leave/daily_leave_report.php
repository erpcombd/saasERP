<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title=" Letter";
$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


?>








<!--<link rel="stylesheet" href="assets/css/bootstrap.min.css">-->



<!--<link rel="stylesheet" href="assets/css/line-awesome.min.css">
<link rel="stylesheet" href="assets/css/material.css">

<link rel="stylesheet" href="assets/css/select2.min.css">-->

<!--<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">-->

<!--<link rel="stylesheet" href="assets/css/style.css">-->
</head>
<body>

<div class="main-wrapper">










<div class="page-wrapper">

<div class="content container-fluid">




<div class="row filter-row mb-4">
<div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus">
<input class="form-control floating" type="text">
<label class="focus-label">Employee</label>
</div>
</div>
<div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus select-focus">
<select class="select floating">
<option>Select Department</option>
<option>Designing</option>
<option>Development</option>
<option>Finance</option>
<option>Hr & Finance</option>
</select>
<label class="focus-label">Department</label>
</div>
</div>
<div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus">
<div class="cal-icon">
<input class="form-control floating datetimepicker" type="text">
</div>
<label class="focus-label">From</label>
</div>
</div>
<div class="col-sm-6 col-md-3">
<div class="input-block mb-3 form-focus">
<div class="cal-icon">
<input class="form-control floating datetimepicker" type="text">
</div>
<label class="focus-label">To</label>
</div>
</div>
<div class="col-sm-6 col-md-3">
<a href="#" class="btn btn-success w-100"> Search </a>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="table-responsive">
<table class="table table-striped custom-table mb-0 datatable">
<thead>
<tr>
<th>Emp Code</th>
<th>Employee Name</th>
<th>DOJ</th>
<th>Department</th>
<th>Designation</th>
<th>Employee Status</th>



</tr>
</thead>
<tbody>



<?



echo $sqld = 'select a.*
from 
personnel_basic_info a 
where 1'.$salaryConn.' order by a.PBI_ID';


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
$deduction_amt  =$data->gross_salary/$data->mtd;
$deduction_amttotal=$deduction_days*$deduction_amt;
?>

<tr>
<td><?=$data->PBI_CODE;?></td>

<td>
<h2 class="table-avatar">
<!--<a href="profile.html" class="avatar"><img src="assets/img/profiles/avatar-06.jpg" alt="User Image"></a>-->
<a href="profile.html"><?=$data->PBI_NAME;?></span></a></h2></td>
<td><?=$data->PBI_DOJ;?></td>

<td class="text-center"><button class="btn btn-outline-info btn-sm"><?=find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');?></button></td>
<td class="text-center"><button class="btn btn-outline-info btn-sm"><?=find_a_field('designation','DESG_DESC','DESG_ID="'.$data->DESG_ID.'"');?></button></td>
<td class="text-center"><span class="btn btn-warning btn-sm"><b><?=$data->PBI_JOB_STATUS;?></b></span></td>


</tr>


<? } ?>

</tbody>
</table>
</div>
</div>
</div>
</div>

</div>

</div>




<!--<script src="assets/js/jquery-3.7.0.min.js"></script>-->

<script src="assets/js/bootstrap.bundle.min.js"></script>

<!--<script src="assets/js/jquery.slimscroll.min.js"></script>

<script src="assets/js/select2.min.js"></script>

<script src="assets/js/moment.min.js"></script>-->
<!--<script src="assets/js/bootstrap-datetimepicker.min.js"></script>-->

<!--<script src="assets/js/layout.js"></script>
<script src="assets/js/theme-settings.js"></script>
<script src="assets/js/greedynav.js"></script>-->

<!--<script src="assets/js/app.js"></script>-->
</body>
</html>





<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>