<?php
session_start();
ob_start();
require "../../config/inc.all.php";
$title='Inventory Home Page';

?>
<style type="text/css">
.oe_app .oe_app_icon{
display:block;
float: left;
height: 48px;
position: relative;
width: 48px;
}

.oe_app .oe_app_icon img{
display:block;
height: 100%;
width: 100%;
}

.oe_app .oe_app_descr{
font-family:"Open Sans";
margin-left: 64px;
font-weight: 300;
font-size: 17px;
text-decoration:none;
color:#959494;
}

.oe_app_descr{

font-family:"Open Sans";
}


.oe_app .oe_app_name {
    font-size: 18px;
    /*font-weight: 400;*/
	/*text-align:center;*/
    margin-left: 64px;
    margin-top: -4px;
	/*font-family:"Open Sans";*/
	color:#646464;
	
}
.home_table td {
    padding: 2px;
}
.home_table_title {
    color: #617a03;
    font-weight: bold;
}
.home_box1 {
    background: url("../images/h_box_01.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 249px;
}
.home_box2 {
    background: url("../images/h_box_02.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 266px;
}
.home_box3 {
    background: url("../images/h_box_03.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 241px;
}
.home_box4 {
    background: url("../images/h_box_04.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 249px;
}
.home_box5 {
    background: url("../images/h_box_05.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 266px;
}
.home_box6 {
    background: url("../images/h_box_06.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 212px;
    width: 241px;
}
.left_report {
    overflow: auto;
}
.style1 {font-size: 18px}
.oe_app {
    background: none repeat scroll 0 0 whitesmoke;
    border: 1px solid transparent;
    border-radius: 2px;
    box-shadow: 0 0 white;
    box-sizing: border-box;
    color: inherit !important;
    cursor: pointer;
    display: block;
    float: left;
    height: 76px;
    margin: 16px;
    overflow: hidden;
    padding: 16px;
    position: relative;
    text-align: left;
    top: 0;
    transition: all 150ms linear 0s;
    width: 276px;
}
.oe_app:hover {
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 4px #dddddd, 0 4px 4px rgba(0, 0, 0, 0.1);
    top: -4px;
}
</style>
<div class="oe_view_manager oe_view_manager_current">
        <table width="100%" class="oe_view_manager_header">
            <colgroup><col width="20%">
            <col width="35%">
            <col width="15%">
            <col width="30%">
            </colgroup><tbody><tr class="oe_header_row oe_header_row_top">
              <td colspan="2">
                
                
                <h2 class="oe_view_title">
                  <span class="oe_view_title_text oe_breadcrumb_title">
				  <span class="oe_breadcrumb_item">
				  <?=(isset($page_title))?$page_title:'';?>
				  </span>
				  </span>
                  </h2>
                
                
                </td>
              <td colspan="2"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
</table>

              </td>
            </tr>
            </tbody></table>

        <div class="oe_view_manager_body">
            
          <div  class="oe_view_manager_view_list">
		  
		  </div>
          <div class="oe_view_manager_view_form">
		<h1 style="color:#CC0033; text-align:center; margin-top:30px;">STAFF INFORMATION</h1>
		<h1 style="color:green; text-align:center">HUMAN RESOURCE MANAGEMENT SOLUTION</h1>
	
		</div>
		
		
		    <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons">
		<section class="oe_container">
        <h4 class="oe_slogan">&nbsp;</h4>
        <div class="oe_row oe_appstore" style="text-align:center">
	

<a class="oe_app ab_app_descr" title="BASIC INFO" href="employee_basic_information.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/action.png"/></div>
                </div>
                <div class="oe_app_name">Basic Information</div>
				<div class="oe_app_descr">
		 Basic information details 
		</div>
                </a>
			
<a class="oe_app ab_app_descr" title="ESSENTIAL INFO" href="employee_essential_information.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/bank.png"/></div>
				  
                </div>
                <div class="oe_app_name">Essential Information</div>
				<div class="oe_app_descr">
		 Essential information details 
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="EDUCATION" href="edcation.php" style="width:320px!important; height:106px; text-decoration:none">
                <div class="ab_app_descr">
                    <div class="oe_app_icon"><img src="../icon/complex.png"/></div>
                </div>
                <div class="oe_app_name">Education</div>
				<div class="oe_app_descr">
		 Education qualification details 
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="COURSE/DIPLOMA" href="course_diploma.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/crm.png"/></div>
                </div>
                <div class="oe_app_name">Course/Diploma</div>
				<div class="oe_app_descr">
		 Course and diploma information details 
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="EXPERIANCE" href="experience.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/designation.png"/></div>
                </div>
                <div class="oe_app_name">Experiance</div>
				<div class="oe_app_descr">
		 Experiance and skill details 
		</div>
                </a>
			
<a class="oe_app ab_app_descr" title="NOMINEE" href="nominee.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/ecommerce.png"/></div>
                </div>
                <div class="oe_app_name">Nominee Information</div>
				<div class="oe_app_descr">
		 Nominee information details 
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="GUARDIAN" href="guardian.php" style="width:320px!important; height:106px; text-decoration:none">
                <div class="ab_app_descr">
                    <div class="oe_app_icon"><img src="../icon/mrp.png"/></div>
                </div>
                <div class="oe_app_name">Guardian</div>
				<div class="oe_app_descr">
		 Gurdian information 
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="POSTING" href="posting_entey.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/payroll.png"/></div>
                </div>
                <div class="oe_app_name">Posting</div>
				<div class="oe_app_descr">
		 Job posting details 
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="TRAINING" href="training.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/pos.png"/></div>
                </div>
                <div class="oe_app_name">Training</div>
				<div class="oe_app_descr">
		 Types of training info 
		</div>
                </a>
			
<a class="oe_app ab_app_descr" title="TRANSFER" href="transfer.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/projects.png"/></div>
                </div>
                <div class="oe_app_name">Transfer</div>
				<div class="oe_app_descr">
		 Transfer record details 
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="PROMOTION" href="promotion.php" style="width:320px!important; height:106px; text-decoration:none">
                <div class="ab_app_descr">
                    <div class="oe_app_icon"><img src="../icon/reports.png"/></div>
                </div>
                <div class="oe_app_name">Promotion</div>
				<div class="oe_app_descr">
		 Promotion details 
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="DEMOTION" href="domotion.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/salary.png"/></div>
                </div>
                <div class="oe_app_name">Demotion</div>
				<div class="oe_app_descr">
		 Demotion information 
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="INCREMENT" href="increment_entry.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/sales.png"/></div>
                </div>
                <div class="oe_app_name">Increment</div>
				<div class="oe_app_descr">
		 Increment information details 
		</div>
                </a>
			
<a class="oe_app ab_app_descr" title="FAMILY & SPOUSE INFO" href="family.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/setup-folder-icon.png"/></div>
                </div>
                <div class="oe_app_name">Family & Spouse Info</div>
				<div class="oe_app_descr">
		 Personal information 
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="FAMILY & CHILD INFO" href="family_child.php" style="width:320px!important; height:106px; text-decoration:none">
                <div class="ab_app_descr">
                    <div class="oe_app_icon"><img src="../icon/staff-icon.png"/></div>
                </div>
                <div class="oe_app_name">Family & Child Info</div>
				<div class="oe_app_descr">
		Family & Child Info
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="FAMILY & BROTHER/SISTER" href="family_brother_syster.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/try_it_icon.png"/></div>
                </div>
                <div class="oe_app_name">Family & Brother/Sister</div>
				<div class="oe_app_descr">
		Family & Brother/Sister information
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="RELATIVE" href="relatives_in_tmss.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/user.png"/></div>
                </div>
                <div class="oe_app_name">Relative</div>
				<div class="oe_app_descr">
		 Relative information 
		</div>
                </a>
			
<a class="oe_app ab_app_descr" title="REF, PERSON" href="reference_person.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/warehouse.png"/></div>
                </div>
                <div class="oe_app_name">Ref, Person</div>
				<div class="oe_app_descr">
		 Ref, Person
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="LEAVE" href="leave.php" style="width:320px!important; height:106px; text-decoration:none">
                <div class="ab_app_descr">
                    <div class="oe_app_icon"><img src="../icon/website_builder.png"/></div>
                </div>
                <div class="oe_app_name">Leave</div>
				<div class="oe_app_descr">
		 Leave information 
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="VALUES" href="values.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/action.png"/></div>
                </div>
                <div class="oe_app_name">Values</div>
				<div class="oe_app_descr">
		 Values information 
		</div>
                </a> 

				<a class="oe_app ab_app_descr" title="ED ACTION" href="ed_action.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/bank.png"/></div>
                </div>
                <div class="oe_app_name">Ed Action</div>
				<div class="oe_app_descr">
		 Ed Action
		</div>
                </a>
			
<a class="oe_app ab_app_descr" title="DEPT. ACTION" href="departmental_action.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/complex.png"/></div>
                </div>
                <div class="oe_app_name">Dept. Action</div>
				<div class="oe_app_descr">
		Dept. Action
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="ADMIN ACTION" href="administration_action.php" style="width:320px!important; height:106px; text-decoration:none">
                <div class="ab_app_descr">
                    <div class="oe_app_icon"><img src="../icon/crm.png"/></div>
                </div>
                <div class="oe_app_name">Admin Action</div>
				<div class="oe_app_descr">
		Admin Action details
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="FIN. OBJECTION" href="financial_objection.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/designation.png"/></div>
                </div>
                <div class="oe_app_name">Fin. Objection</div>
				<div class="oe_app_descr">
		 Finance Objection
		</div>
                </a> 
				
				
				<a class="oe_app ab_app_descr" title="QUARTES/DOR" href="quarter_dormitory_hostal.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/ecommerce.png"/></div>
                </div>
                <div class="oe_app_name">Quartes/Dor</div>
				<div class="oe_app_descr">
		Quartes/Dor details 
		</div>
                </a>
			
<a class="oe_app ab_app_descr" title="MOTOR CYCLE" href="motor_cycle.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/mrp.png"/></div>
                </div>
                <div class="oe_app_name">Motor Cycle</div>
				<div class="oe_app_descr">
		Motor Cycle
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="PROJECT STAFF" href="project_staff_detail.php" style="width:320px!important; height:106px; text-decoration:none">
                <div class="ab_app_descr">
                    <div class="oe_app_icon"><img src="../icon/payroll.png"/></div>
                </div>
                <div class="oe_app_name">Project Staff</div>
				<div class="oe_app_descr">
		Project Staff information
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="PF CHECK LIST" href="pf_status.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/pos.png"/></div>
                </div>
                <div class="oe_app_name">Pf Check List</div>
				<div class="oe_app_descr">
		Pf Check List
		</div>
                </a> 
				
				
				<a class="oe_app ab_app_descr" title="NOT IN SERVICE STATUS" href="not_in_service_status.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/projects.png"/></div>
                </div>
                <div class="oe_app_name">Not In Service Status</div>
				<div class="oe_app_descr">
		Not In Service Status
		</div>
                </a>
			
<a class="oe_app ab_app_descr" title="ACTION MANAGEMENT" href="action_management.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/reports.png"/></div>
                </div>
                <div class="oe_app_name">Action Management</div>
				<div class="oe_app_descr">
	Action Management information
		</div>
                </a>
				
				
				
				
				</div>
		</section>
		
		</div>
        <div class="oe_form_sidebar">
		
		
		
		</div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"></div>
    </div>
	</div>
    </div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>