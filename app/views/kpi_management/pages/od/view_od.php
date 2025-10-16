<?php
session_start();
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
var win = window.location.assign('../od/od_request_input.php?id='+lk, '');
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

                    <h2>&nbsp;</h2>

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

					<h3 class="panel-title">My OD Status</h3>

				</div>

				<div class="panel-body">


<div class="oe_view_manager oe_view_manager_current"> 
  <form action=""  method="post">
    <div class="oe_view_manager_body">

   
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
       
             
                 
                     
             
                       <div style="text-align:center">
                       
                              <div class="oe_view_manager_view_list">
                                <div class="oe_list oe_view">
                                  <? 
$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

if($_SESSION['employee_selected']>0)
   $res = "select o.id,a.PBI_NAME as name,t.type_name as OD_type,DATE_FORMAT(o.od_date,'%d-%b-%Y') as submission_date,DATE_FORMAT(o.s_date,'%d-%b-%Y') as start_date,DATE_FORMAT(o.e_date,'%d-%b-%Y') as end_date,CONCAT_WS('', o.s_time , o.s_time_format) as start_time,CONCAT_WS('', o.e_time , o.e_time_format)  as end_time,o.total_hrs,o.total_days,o.incharge_status as reporting_authority, o.od_status as HR_approval from personnel_basic_info a,designation c, department d,hrm_od_info o,od_type t where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID  and o.type=t.id and a.PBI_ID=o.PBI_ID and  a.PBI_ID='".$_SESSION['employee_selected']."' and o.od_date between '".$g_s_date."' and '".$g_e_date."' order by o.id desc";
else
$res = "select o.id,a.PBI_ID,a.EMP_ID,a.PBI_NAME,c.DESG_DESC,d.DEPT_DESC,o.s_date as start_date, o.e_date as end_date,o.total_days from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID  and a.PBI_ID=o.PBI_ID  order by o.id desc";
echo $crud->link_report($res,$link);         
 ?>
                                </div>
                              </div>
                            </div>
                       
                   
                </div>
                <div class="oe_chatter">
                  <div class="oe_followers oe_form_invisible">
                    <div class="oe_follower_list"></div>
                  </div>
                </div>
              </div>
            </div>
			
          </div>
        </div>
      </div>
    </div>
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
        <!-- /page content -->



<?






include_once("../../template/footer.php");



?>
