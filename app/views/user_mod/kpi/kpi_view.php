<?php
@session_start();
ob_start();
require_once "../../../assets/support/inc.all.php";


do_calander('#s_date');

do_calander('#e_date');



$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

// ::::: Edit This Section ::::: 

$title='Key Performance Indicator';			// Page Name and Page Title

$page="leave_entry.php";		// PHP File Name

$input_page="leave_entry_input.php";

$root='leave';



$table='hrm_leave_info';

$unique='id';

$shown='s_date';


$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);


$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);
$rep_auth = find_a_field('hrm_leave_info','PBI_IN_CHARGE','PBI_ID='.$PBI_ID);

// ::::: End Edit Section :::::



$crud      =new crud($table);

if(prevent_multi_submit()){

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];

$crud->insert();

}

}











?>

<script type="text/javascript"> function DoNav(lk){

var win = window.location.assign('../kpi/select_week.php?id='+lk, '');

  win.focus();

}</script>

<script type="text/javascript">

$(document).ready(function(){



  $("#e_date").change(function (){

     var from_leave = $("#s_date").datepicker('getDate');

     var to_leave = $("#e_date").datepicker('getDate');

    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;



	if(days>0&&days<100){

	$("#total_days").val(days);}

  });

      $("#s_date").change(function (){

     var from_leave = $("#s_date").datepicker('getDate');

     var to_leave = $("#e_date").datepicker('getDate');

    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;

	if(days>0&&days<100){

	$("#total_days").val(days);}

  });

    

  

});

 

</script>

<style type="text/css">

<!--

.style1 {font-size: 24px}

.style2 {

	color: #FFFFFF;

	font-size: 24px;

	font-weight: bold;

}

-->

</style>



				  

                  <div class="x_content">

				  

				  <div class="row">

		<div class="col-md-12">

			<div class="panel panel-primary" align="center">

				<div class="panel-heading">

					<h3 class="panel-title">KEY PERFORMANCE INDICATOR</h3>

				</div>

				<div class="panel-body">



<div class="oe_view_manager oe_view_manager_current">

  <form action=""  method="post">

   

                                  <? 

				

				

								  

    $res = "select p.PBI_ID as Emp_id,p.PBI_NAME,desg.DESG_DESC,
  (select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,
  (select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project 
  from personnel_basic_info p, 
  designation desg, 
  hrm_kpi_set e 
  where p.DESG_ID=desg.DESG_ID and p.PBI_ID=e.PBI_ID and p.PBI_JOB_STATUS='In Service' and e.LINE_MANAGER=".$PBI_ID;

echo $crud->link_report($res,$link);         

 ?>

                         

  </form>

</div>

                </div>

              </div>

            </div>

          </div>

        </div>

		

		

		


        <!-- /page content -->





<?



$main_content=ob_get_contents();



ob_end_clean();



include ("../../template/main_layout.php");







?>
