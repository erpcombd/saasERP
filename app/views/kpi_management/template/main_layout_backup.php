<!DOCTYPE html>
<html style="height: 100%;">
<head>
<meta http-equiv = "Content-Type" content = "text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title>AKSID HRM ERP</title>
<script type = "text/javascript">var GB_ROOT_DIR = "../../GBox/";</script>
<script type = "text/javascript" src = "../../GBox/AJS.js"></script>
<script type = "text/javascript" src = "../../GBox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../GBox/gb_scripts.js"></script>
<link href = "../../GBox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/paging.js"></script>
<script type="text/javascript" src="../../js/ddaccordion.js"></script>
<script type="text/javascript" src="../../js/js.js"></script>
<script type="text/javascript" src="../../js/pg.js"></script>
<link href="../../css/css.css" type="text/css" rel="stylesheet"/>
<link href="../../css/menu.css" type="text/css" rel="stylesheet"/>
<link href="../../css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<?=$head?>
<script type="text/javascript">

  $(document).ready(function(){
    $("#codz").validate();
  });

</script>
<script type="text/javascript">
$(document).ready(function(){

$(function() {
$("#date_birth").datepicker({
changeMonth: true,
changeYear: true,
dateFormat: "yy-mm-dd"
});

});

});</script>
</head>
<body>
<!--[if lte IE 8]>
        <script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
<div class="openerp openerp_webclient_container">
  <table class="oe_webclient">
    <tbody>
      <tr>
        <td class="oe_topbar" colspan="2"><ul style="height: auto;" class="oe_menu">
            <li style="display: block;"> <a class="oe_menu_toggler" data-action-id="" data-action-model="" data-menu="121" href="#menu_id=121&amp;action="> <span class="oe_menu_text"> Security </span> </a> </li>
            <li style="display: block;"> <a class="oe_menu_toggler" data-action-id="" data-action-model="" data-menu="75" href="#menu_id=75&amp;action="> <span class="oe_menu_text"> Payment Gateway </span> </a> </li>
            <li style="display: block;"> <a class="oe_menu_toggler" data-action-id="" data-action-model="" data-menu="212" href="#menu_id=212&amp;action="> <span class="oe_menu_text"> Accounts </span> </a> </li>
            <li style="display: block;"> <a class="oe_menu_toggler oe_active" data-action-id="" data-action-model="" data-menu="224" href="#menu_id=224&amp;action="> <span class="oe_menu_text"> HR </span> </a> </li>
            <li style="display: block;"> <a class="oe_menu_toggler" data-action-id="" data-action-model="" data-menu="467" href="#menu_id=467&amp;action="> <span class="oe_menu_text"> Payroll </span> </a> </li>
            <li style="display: block;"></li>
            <li style="display: block;"> <a class="oe_menu_toggler" data-action-id="" data-action-model="" data-menu="502" href="#menu_id=502&amp;action="> <span class="oe_menu_text"> Inventory </span> </a> </li>
            <li style="display: block;"> <a class="oe_menu_toggler" data-action-id="" data-action-model="" data-menu="160" href="#menu_id=160&amp;action="> <span class="oe_menu_text"> Purchase </span> </a> </li>
            <li style="display: block;"> <a class="oe_menu_toggler" data-action-id="" data-action-model="" data-menu="98" href="#menu_id=98&amp;action="> <span class="oe_menu_text"> Manufacturing </span> </a> </li>
            <li style="display: block;"> <a class="oe_menu_toggler" data-action-id="" data-action-model="" data-menu="141" href="#menu_id=141&amp;action="> <span class="oe_menu_text"> Medical </span> </a> </li>
          </ul>
          <div class="oe_systray">
            <div  original-title="" class="oe_attendance_status oe_attendance_nosigned" data-tipsy="true">
              <div class="oe_attendance_signin"></div>
              <div class="oe_attendance_signout"></div>
            </div>
            <div class="oe_topbar_item oe_topbar_compose_full_email" title="Compose new Message"> Welcome... AKSID HRM ERP <a href="../main/logout.php"><img src="../../img/LogOut.png" height="20" alt="log Out"></a></div>
          </div></td>
      </tr>
      <tr>
        <td style="display: table-cell;" class="oe_leftbar" valign="top"><a class="oe_logo" href="#"> <img src="../../../logo/title.png" width="200px"> </a>
          <div class="oe_secondary_menus_container">
            <div class="menu_bg">
              <table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td><div class="smartmenu">
                      <div class="silverheader"><a href="#">Admin Panel</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../admin/user_manage.php"> Create User </a></td>
                          </tr>
                          <tr>
                            <td><a href="#">Change Password</a></td>
                          </tr>
                        </table>
                      </div>
                      <div class="silverheader"><a href="#" >HR Management</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../hrm/employee_basic_information.php">Basic Info</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/employee_essential_information.php">Job Status</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/edcation.php">Education</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/course_diploma.php">Course/Diploma</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/experience.php">Experience</a></td>
                          </tr>
                          <!--<tr>
                            <td><a href="../hrm/posting_entey.php">Posting</a></td>
                          </tr>-->
                          <tr>
                            <td><a href="../hrm/training.php">Training</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/transfer.php">Transfer</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/promotion.php">Promotion</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/demotion.php">Demotion</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/increment_entry.php">Increment</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/employee_requisition.php">Employee Requisition</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/administration_action.php">HR Action</a></td>
                          </tr>
                          <tr>
                            <td><a href="../hrm/pf_status.php">Personal File Check List</a></td>
                          </tr>
                        </table>
                      </div>
                      <div class="silverheader"><a href="#" >Compansation Management</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../payroll/salary_information.php">Salary & Allowance</a></td>
                          </tr>
                          <tr>
                            <td><a href="../payroll/advance_payment.php">Advance Salary</a></td>
                          </tr>
                          <tr>
                            <td><a href="../payroll/other_deductions.php">Other Deductions</a></td>
                          </tr>
                          <tr>
                            <td><a href="../payroll/monthly_attendence.php">Monthly Attendence (Dept)</a></td>
                          </tr>
						  <tr>
                            <td><a href="../payroll/mobile_food_other_deduction.php">Monthly Mobile and Food Deduction</a></td>
                          </tr>
						  <tr>
                            <td><a href="../admin/salary_bonus.php">Bonus Calculation</a></td>
                          </tr>
						  <!--<tr>
                            <td><a href="../admin/salary_bonus_manual.php">Manual Bonus Calcalution</a></td>
                          </tr>-->
                        </table>
                      </div>
                      <div class="silverheader"><a href="#" >Leave Management</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../leave/leave_entry.php">Leave Entry</a></td>
                          </tr>
                          <tr>
                            <td><a href="../leave/leave_entry_half.php">Short Leave Entry</a></td>
                          </tr>
                          <tr>
                            <td><a href="../leave/tour_entry.php">Official Tour Entry</a></td>
                          </tr>
                          <tr>
                            <td><a href="../leave/leave_report.php">Leave Report</a></td>
                          </tr>
                        </table>
                      </div>
                      <div class="silverheader"><a href="#" >APR and Promotion</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../hrm/apr.php">APR</a></td>
                          </tr>
                        </table>
                      </div>
                      <!--<div class="silverheader"><a href="#" >Project Setup</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../setup/project_type.php">Project Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/location_type.php">Location Type</a></td>
                          </tr>
                        </table>
                      </div>-->
                      <div class="silverheader"><a href="#" >Setup</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../setup/action_type.php">Action Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/bank_type.php">Bank Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/leave_type.php">Leave Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/department_type.php">Department Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/designation_type.php">Designation Type</a></td>
                          </tr>
                          <!--<tr>
                            <td><a href="../setup/domain_type.php">Section Name</a></td>
                          </tr>-->
                          <tr>
                            <td><a href="../setup/edu_subject_type.php">Education Subject Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/edu_qua_type.php">Education Qualification Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/edu_exam_type.php">Education Exam Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/project_type.php">Project Type</a></td>
                          </tr>
                          <!--<tr>
                            <td><a href="../setup/relation_type.php">Relation Type</a></td>
                          </tr>-->
                          <tr>
                            <td><a href="../setup/university_type.php">University Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/demotion_reason.php">Demotion Reason</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/profession_type.php">Profession Type</a></td>
                          </tr>
                          <!--<tr>
                            <td><a href="../setup/team_type.php">Team Name</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/branch_type.php">Region Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/sub_region.php">Sub Region Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/zone_type.php">Zone Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/area_type.php">Area Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/base_market.php">Base Market</a></td>
                          </tr>-->
                          <tr>
                            <td><a href="../setup/district.php">District Info</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/thana.php">Thana Info</a></td>
                          </tr>
                          <!--<tr>
                            <td><a href="../setup/institute_type.php">Institute Type(Location)</a></td>
                          </tr>-->
                          <tr>
                            <td><a href="../setup/holy_day.php">Holiday</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/leave_type.php">Leave Type</a></td>
                          </tr>
                          <tr>
                            <td><a href="../setup/leave_type.php">Leave Rull</a></td>
                          </tr>
                          <!--<tr>
                            <td><a href="../setup/cooperative_rate.php">Co-Operative Installment</a></td>
                          </tr>-->
                        </table>
                      </div>
                      <div class="silverheader"><a href="#">HRM Report</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../report/delail_report_selection.php">Detail Staff Information</a></td>
                          </tr>
                          <tr>
                            <td><a href="../report/advance_report_apr.php">APR Reports</a></td>
                          </tr>
                          <tr>
                            <td><a href="../report/advance_report.php">Advance Reports</a></td>
                          </tr>
                          <!--<tr>
                            <td><a href="../report2/advance_report.php">Other Reports</a></td>
                          </tr>-->
                        </table>
                      </div>
                      <br>
                      <br>
                      <!--<div class="silverheader"><a href="#" >Customer Information</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../dealer/dealer_info.php">Customer Information</a></td>
                          </tr>
                        </table>
                      </div>
                      <div class="silverheader"><a href="#">Customer Info Report</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../report/dealer_report.php">Customer Information</a></td>
                          </tr>
                        </table>
                      </div>
                      <div class="silverheader"><a href="#" >Other Information</a></div>
                      <div class="submenu">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><a href="../dealer/modem_user.php">Internet Modem User</a></td>
                          </tr>
                        </table>
                      </div>-->
                    </div></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="oe_footer"> Powered by <a href="http://erp.com.bd/web/" target="_blank"><span>erp.com.bd</span></a> </div></td>
        <td class="oe_application"><div>
            <?=$main_content;?>
          </div></td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>
