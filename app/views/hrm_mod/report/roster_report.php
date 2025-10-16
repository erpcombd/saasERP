<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#start_date');
do_calander('#end_date');

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
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Advance Reporting</span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
  <tr>
    <td align="right" class="alt"><strong>Company :</strong></td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
        <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
      </select></span></td>
    <td width="40%" align="right" class="alt"><strong>Department :</strong></td>
    <td width="10%"><span class="oe_form_group_cell">
      <select name="department" style="width:160px;" id="department">
        <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$PBI_DEPARTMENT,' 1 order by DEPT_DESC');?>
      </select></span></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Designation :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="designation" style="width:160px;" id="designation">
        <? foreign_relation('designation','DESG_SHORT_NAME','DESG_DESC',$designation,' 1 order by DESG_DESC');?>
      </select>
    </span></td>
    <td align="right"><strong>Job Location:</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="JOB_LOCATION" id="JOB_LOCATION">
        <? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],'1');?>
      </select>
    </span></td>
  </tr>
  
  <tr >
    <td align="right"><strong>Section:</strong></td>
    <td align="left"><strong>
      <select name="PBI_DOMAIN">
        <? foreign_relation('domai','DOMAIN_DESC','DOMAIN_DESC',$_POST['PBI_DOMAIN']);?>
      </select>
    </strong></td>
    <td align="right"><strong>Group  :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="PBI_GROUP" style="width:160px;" id="PBI_GROUP">
        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>
      </select></span></td>
  </tr>
  <tr >
    <td align="right"><strong>Start Date  :</strong></td>
    <td align="left"><input name="start_date" type="text" id="start_date" size="30" style="width:160px;" /></td>
    <td align="right"><strong>End Date  :</strong></td>
    <td><input name="end_date" type="text" id="end_date" size="30" style="width:160px;" /></td>
  </tr>
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Report</span></th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    
<!--    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="5" /></td>
      <td class="alt"><strong>Salary Payroll Report (Detail)</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr >
      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="6" /></td>
      <td class="alt"><strong>Salary Payroll Report (Summary)</strong><strong></strong></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>-->
    
	<tr >
	  <td width="4%" align="center" class="alt">&nbsp;</td>
	  <td width="44%" class="alt">&nbsp;</td>
	  <td width="4%" align="center">&nbsp;</td>
	  <td width="44%">&nbsp;</td>
	  </tr>
	<tr >
	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="22222" /></td>
	  <td colspan="3" class="alt">Roster Routine </td>
	  </tr>
	<tr >
	  <td align="center" class="alt">&nbsp;</td>
	  <td class="alt">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>
  </tbody>
</table>
<input name="submit" type="submit" id="submit" value="SHOW" />
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>