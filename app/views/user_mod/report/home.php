<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
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
		<h1 style="color:#CC0033; text-align:center; margin-top:30px;">REPORTS</h1>
		<h1 style="color:green; text-align:center">HUMAN RESOURCE PAYROLL SOLUTION</h1>
	
		</div>
		
		
		    <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons">
		<section class="oe_container">
        <h4 class="oe_slogan">&nbsp;</h4>
        <div class="oe_row oe_appstore" style="text-align:center">
	

<a class="oe_app ab_app_descr" title="SHOW ALL USER" href="show_user.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/user.png"/></div>
                </div>
                <div class="oe_app_name">Show All User</div>
				<div class="oe_app_descr">
		Search a user using company name
		</div>
                </a>
			
<a class="oe_app ab_app_descr" title="DETAIL STAFF INFORMATION" href="delail_report_selection.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/staff-icon.png"/></div>
                </div>
                <div class="oe_app_name" style="text-transform:capitalize!important;">Staff Information</div>
				<div class="oe_app_descr">
		Staff Information Details
		</div>
                </a>
				
				<a class="oe_app ab_app_descr" title="PAYROLL ADVANCED REPORT" href="payroll-advance_report.php" style="width:320px!important; height:106px; text-decoration:none">
                <div class="ab_app_descr">
                    <div class="oe_app_icon"><img src="../icon/payroll.png"/></div>
                </div>
                <div class="oe_app_name">Payroll Reports</div>
				<div class="oe_app_descr">
		Payroll Report Details
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="ADVANCED REPORTS" href="advance_report.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/reports.png"/></div>
                </div>
                <div class="oe_app_name">Advanced Reports</div>
				<div class="oe_app_descr">
		Advanced Reports for HRM
		</div>
                </a> 
				
				<a class="oe_app ab_app_descr" title="COMPLEX REPORTS" href="complex_report.php" style="width:320px!important; height:106px; text-decoration:none">
<div class="ab_app_descr">
                  <div class="oe_app_icon"><img src="../icon/complex.png"/></div>
                </div>
                <div class="oe_app_name">Complex Reports</div>
				<div class="oe_app_descr">
		Complex Report of HRM Solution
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>