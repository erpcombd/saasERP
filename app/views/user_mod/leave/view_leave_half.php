<?php



//



//




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







do_calander('#s_date');



do_calander('#e_date');



$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';



auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');



// ::::: Edit This Section ::::: 



$title='Short Leave Approval (SHL) Status';			// Page Name and Page Title



$page="leave_entry.php";		// PHP File Name



$input_page="leave_entry_input.php";



$root='leave';







$table='hrm_leave_info';



$unique='id';



$shown='s_date';




$u_id=$_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);


$_SESSION['employee_selected'] = $PBI_ID;


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



var win = window.location.assign('../leave/half_leave_request_input.php?id='+lk, '');



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



                    <h2></h2>



                    <ul class="nav navbar-right panel_toolbox">



                      <!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>-->



                      </li>



                      <li class="dropdown">



                        <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>-->



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



					<!--<h3 class="panel-title">Short Leave Approval (SHL) Status</h3>
-->


				</div>



				<div class="panel-body">











<div class="oe_view_manager oe_view_manager_current">



        <form action=""  method="post">







        



<? 



$g_s_date=date('Y-01-01');



$g_e_date=date('Y-12-31');







if($PBI_ID>0)



  $res = "select o.id,a.PBI_NAME as name,(select PBI_NAME from personnel_basic_info where PBI_ID=o.leave_responsibility_name) as duties_carried_by,DATE_FORMAT(o.leave_apply_date,'%d-%b-%Y')  as submission_date,DATE_FORMAT(o.half_leave_date,'%d-%b-%Y') as leave_date,TIME_FORMAT(o.s_time, '%h:%i') as start_time,TIME_FORMAT(o.e_time, '%h:%i') as end_time ,o.total_hrs,o.incharge_status as reporting_authority, o.leave_status as hr_approval,o.reporting_note from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.DESG_ID=c.DESG_ID and a.DEPT_ID=d.DEPT_ID  and a.PBI_ID=o.PBI_ID and  a.PBI_ID='".$_SESSION['employee_selected']."' and o.entry_at>='".$g_s_date."' and o.entry_at<='".$g_e_date."' and o.type='Short Leave (SHL)'    order by o.id desc";



else



$res = "select o.id,a.PBI_ID,a.EMP_ID,a.PBI_NAME,c.DESG_DESC,d.DEPT_DESC,o.s_date as start_date, o.e_date as end_date,o.total_days from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID  and a.PBI_ID=o.PBI_ID  order by o.id desc";



echo $crud->link_report($res,$link);         



 ?>







 </form>    </div>



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



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>  