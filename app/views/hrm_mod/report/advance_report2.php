<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title=" Mobile Number Update";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
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


<style>
    tr:nth-child(odd){
        background-color: #fafafa !important;

    tr:nth-child(even){
        background-color: #fafafa !important;
    }

</style>



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
<tr class="oe_list_header_columns" style="text-align:center">
  <th colspan="4" class="text-center bg-titel bold pt-2 pb-2"> Advance Reporting</th>
  </tr>
<tr class="oe_list_header_columns" style="text-align:center">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
  <tr>
    <td align="right" class="alt"><strong>Company :</strong></td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" class="form-control
	  ">
        <option value="2">Sajeeb Corporation</option>
		<? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
      </select>
    </span></td>
    <td  align="right" class="alt"><strong>Department :</strong></td>
    <td ><span class="oe_form_group_cell">
      <select name="department" style="width:160px;" id="department" class="form-control">
        <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$PBI_DEPARTMENT,' 1 order by DEPT_DESC');?>
      </select>
    </span></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Region :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="branch" style="width:160px;" id="branch" class="form-control">
        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH);?>
      </select>
    </span></td>
    <td align="right"><strong>Section:</strong></td>
    <td align="left"><strong>
      <select name="PBI_DOMAIN" class="form-control">
        <? foreign_relation('domai','DOMAIN_DESC','DOMAIN_DESC',$_POST['PBI_DOMAIN']);?>
      </select>
    </strong></td>
  </tr>
  <tr >
    <td align="right"><strong>Zone :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="zone" style="width:160px;" id="zone" class="form-control">
        <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE);?>
      </select>
    </span></td>
	    <td align="right" class="alt"><strong>Job Location:</strong></td>
    <td class="alt"><span class="oe_form_group_cell">
      <select name="JOB_LOCATION" id="JOB_LOCATION" class="form-control">
        <? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],'1');?>
      </select>
    </span></td>

  </tr>
  <tr >
    <td align="right"><strong>Area :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="area" style="width:160px;" id="area" class="form-control">
        <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA);?>
      </select>
    </span></td>
	    <td align="right"><strong>Job Status :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="job_status" style="width:160px;" class="form-control">
      
        <option>IN SERVICE</option>
        <option>NOT IN SERVICE</option><option value="">ALL</option>
      </select></span></td>
	  

  </tr>
  <tr >
    <td align="right"><strong>Group  :</strong></td>
    <td><span class="oe_form_group_cell"> 
      <select name="PBI_GROUP" style="width:160px;" id="PBI_GROUP" class="form-control">
        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>
      </select>
    </span></td>
	    <td align="right"><strong>PBI ID IN:</strong></td>
    <td><input name="pbi_id_in" type="text" id="pbi_id_in" / class="form-control"></td>

  </tr>
  <tr >
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
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
	      <tr  class="alt">
      <td width="4%" align="right"><input name="report" type="radio" checked="checked" class="radio" value="8" /></td>
      <td width="44%" align="left"><strong>Staff Mobile Information Update</strong></td>
      <td width="4%" align="center">&nbsp;</td>
      <td width="44%">&nbsp;</td>
    </tr>
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
  </tbody>
</table>
<input name="submit" type="submit" id="submit" value="SHOW" class="btn1 btn1-bg-submit" />
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