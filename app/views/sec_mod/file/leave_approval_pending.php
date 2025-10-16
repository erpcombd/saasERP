<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


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


$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('ss_user','user_id','user_id='.$u_id);
$PBI = find_all_field('ss_user','','user_id='.$PBI_ID);
$_SESSION['employee_selected'] = $PBI_ID;

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
var win = window.location.assign('leave_request_approve.php?id='+lk, '');
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
                  
				  
				  	 <div class="openerp openerp_webclient_container">
               
			
				  
				  
                  <div class="x_content">
				  
				  <div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary" align="center">
				<div class="panel-heading">
					<h3 class="panel-title">Leave</h3>
				</div>
				<div class="panel-body">

<div class="oe_view_manager oe_view_manager_current">
  <form action=""  method="post">

                                  <? 
				
				
								  
  $res = "select o.id,a.user_id as ID_NO , a.fname as name,

  

  (select leave_type_name from hrm_leave_type where id=o.type) as Type,
   DATE_FORMAT(o.leave_apply_date,'%d-%b-%Y') as Application_Date,
  DATE_FORMAT(o.s_date,'%d-%b-%Y') as Applied_From,DATE_FORMAT(o.e_date,'%d-%b-%Y') as Applied_To,
  o.Total_Days, o.reason
  
  
  from ss_user a,hrm_leave_info o where a.user_id=o.PBI_ID  and o.leave_status='Pending' order by o.s_date desc";
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




require_once SERVER_CORE."routing/layout.bottom.php";



?>
