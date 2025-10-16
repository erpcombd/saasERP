<?php
session_start();
ob_start();
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../../assets/css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title = 'Task Report';
do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#ppjda');
create_combobox('PBI_ID');
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

<form action="crm_master_report.php" target="_blank" method="post">
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
    <td width="20%"><strong>Employee : </strong></td>
    <td align="left" width="30%">
      <select name="PBI_ID"  id="PBI_ID"  class="form-control" style="width:30%;" required>
        
		<option value="<?=$_SESSION['employee_selected']?>"><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_SESSION['employee_selected'].'"');?></option>
      <?
	   
	   if($_SESSION['employee_selected']==2 || $_SESSION['employee_selected']==61 || $_SESSION['employee_selected']==130 || $_SESSION['employee_selected']==116){
	   echo '<option></option>';
	   foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID']);
	   }else{
	   foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_SESSION['employee_selected'],'incharge_id="'.$_SESSION['employee_selected'].'"');
	   }
	   ?>
      </select>
    </td>
    <td align="right" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
	
  </tr>
  
  <tr>
    <td width="20%"><strong>Date From : </strong></td>
	<td align="left"><input type="date" name="f_date" id="f_date" class="form-control" style="width:50%;" /></td>
    <td align="left" width="40%">&nbsp;</td>
  </tr>
   
   <tr>
    <td colspan="3">&nbsp;</td>
	
  </tr>
  
  <tr>
    <td width="20%"><strong>Date To : </strong></td>
	<td align="left" ><input type="date" name="t_date" id="t_date" class="form-control" style="width:50%;" /></td>
    <td align="left" width="40%">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="3" style="border-bottom:2px solid #000;">&nbsp;</td>
	
  </tr>

  
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>


  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    
	      <tr>
	        <td align="left"><input name="report" type="radio" class="radio" checked="checked" value="203" /></td>
	        <td align="left"><strong>Task Report</strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
			
			<tr>
	        <td align="left"><input name="report" type="radio" class="radio" checked="checked" value="205" /></td>
	        <td align="left"><strong>Conveyance Report</strong></td>
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