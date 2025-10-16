<?php
session_start();
ob_start();
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../../assets/css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title = 'Customer Report';
do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#ppjda');
if($_POST['mon']!=''){
$mon=$_POST['mon'];}
else{
$mon=date('n');
}

if($_POST['year']!=''){
$year=$_POST['year'];}
else{
$year=date('Y');
}
?>

<form action="../report/master_report.php" target="_blank" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
<table width="100%" border="0" class="oe_list_content"><thead>
</thead><tfoot>
</tfoot><tbody>
  <tr>
    <td width="17%" align="right"><strong>Contact Person :</strong></td>
    <td width="34%"><span class="oe_form_group_cell">
      
      <select name="PBI_ID" id="PBI_ID"   class="form-control">
        
        <? if($_SESSION['employee_selected']==5){ foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$PBI_ID,'1');}else{
		foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$PBI_ID,'1 and PBI_ID="'.$_SESSION['employee_selected'].'"');
		}?>
      </select>
    </span></td>
    <td width="6%" align="right" >&nbsp;</td>
    <td width="10%" align="right" >&nbsp;</td>
    <td width="33%">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5" style="border-bottom:2px solid #000;"></td>
  </tr>
  

 
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4">
  <!--<table align="center">
  <tr><td>Date</td><td><input type="date" name="f_date" id="f_date" /></td><td>TO</td><td><input type="date" name="t_date" id="t_date" /></td></tr>
  </table>-->  </th>
</tr>

  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    
	      <tr  >
	        <td align="center"><input name="report" type="radio" class="radio" checked="checked" value="22" /></td>
	        <td align="left"><strong>Customer  Information Report </strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	    
<!--    <tr >
      <td align="center" ><input name="report" type="radio" class="radio" value="5" /></td>
      <td ><strong>Salary Payroll Report (Detail)</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" ><input name="report" type="radio" class="radio" value="6" /></td>
      <td ><strong>Salary Payroll Report (Summary)</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>-->
  </tbody>
</table>
<br /><br />
<input name="submit" type="submit" id="submit" value="&emsp;SHOW&emsp;" class="btn btn-info" />
          </div></div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
  </div>
</form>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>