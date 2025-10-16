<?php

@session_start();


ob_start();



require_once "../../config/inc.all.php";



require "../../template/main_layout.php";







do_calander('#s_date');



do_calander('#e_date');



$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';



auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');



// ::::: Edit This Section ::::: 



$title='Leave Information';			// Page Name and Page Title



$page="leave_entry.php";		// PHP File Name



$input_page="leave_entry_input.php";



$root='leave';







$table='hrm_leave_info';



$unique='id';



$shown='s_date';







$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);



 $rep_auth = find_a_field('hrm_leave_info','PBI_IN_CHARGE','PBI_ID='.$_SESSION['employee_selected']);



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



var win = window.location.assign('../pa/performance_appraisal.php?id='+lk, '');



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







<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->



          <div class="">



		  



		  



           



        <div class="clearfix"></div>







            <div class="row">



              <div class="col-md-12 col-sm-12 col-xs-12">



                <div class="x_panel">



                  <div class="x_title">



                    <h2>Plain Page</h2>



                    <ul class="nav navbar-right panel_toolbox">



                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>



                      </li>



                      <li class="dropdown">



                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>



                        <ul class="dropdown-menu" role="menu">



                          <li><a href="#">Settings 1</a>



                          </li>



                          <li><a href="#">Settings 2</a>



                          </li>



                        </ul>



                      </li>



                      <li><a class="close-link"><i class="fa fa-close"></i></a>



                      </li>



                    </ul>



                    <div class="clearfix"></div>



                  </div>



				  



				  	 <div class="openerp openerp_webclient_container">



               



			



				  



				  



                  <div class="x_content">



				  



				  <div class="row">



		<div class="col-md-12">



			<div class="panel panel-primary" align="center">



				<div class="panel-heading">



					<h3 class="panel-title">Performance Appraisal</h3>



				</div>



				<div class="panel-body">







<div class="oe_view_manager oe_view_manager_current">



  <form action=""  method="post">



   



                                  <? 



				



				



								  



  //$res = "select p.PBI_ID as Emp_id,p.PBI_NAME,desg.DESG_DESC,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project  from personnel_basic_info p, designation desg, essential_info e where p.PBI_DESIGNATION=desg.DESG_ID and p.PBI_ID=e.PBI_ID and p.PBI_JOB_STATUS='In Service' and e.ESSENTIAL_REPORTING=".$_SESSION['employee_selected'];

  

   $res = "select p.PBI_ID as Emp_id,p.PBI_NAME,desg.DESG_DESC,

  (select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,

  (select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project 

  from personnel_basic_info p, designation desg, hrm_pa_set e 
  where p.PBI_DESIGNATION=desg.DESG_ID and e.status='Active' and p.PBI_ID=e.PBI_ID and p.PBI_JOB_STATUS='In Service' and e.LINE_MANAGER=".$_SESSION['employee_selected'];



echo $crud->link_report($res,$link);         



 ?>



                         



  </form>



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



        <!-- /page content -->















<?



























include_once("../../template/footer.php");















?>







