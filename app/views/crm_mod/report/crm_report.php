<?php
session_start();
ob_start();
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../../assets/css/report_selection.css" type="text/css" rel="stylesheet"/>';
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
<tr class="oe_list_header_columns">
  <th colspan="5"><div align="center"><span>Advance Reporting</span></div></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="5"><div align="center"><span>Select Options</span></div></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
  <tr>
    <td width="17%" align="right"><strong>Contact Person :</strong></td>
    <td width="34%"><span class="oe_form_group_cell">
      <?
	
  $select = 'select p.*,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT ,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION from personnel_basic_info p where 1';
	?>
      <select name="PBI_ID" id="PBI_ID"   class="selectpicker form-control" data-live-search="true">
        <option></option>
        <?
	  $query = db_query($select);
	  
	  while($row = mysqli_fetch_object($query)){
	  ?>
        <option value="<?=$row->PBI_ID?>">
          <?=$row->PBI_CODE?>
          |
          <?=$row->PBI_NAME?>
          |
          <?=$row->PBI_DEPARTMENT?>
          |
          <?=$row->PBI_DESIGNATION?>
          </option>
        <? } ?>
        <? //foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$PBI_ID,'1');?>
      </select>
    </span></td>
    <td align="right" >&nbsp;</td>
    <td width="10%" align="right" ><strong>Service</strong></td>
    <td width="33%"><span class="oe_form_group_cell">
      <select name="service_id"  id="service_id"  class="selectpicker form-control" data-live-search="true">
        <option></option>
        <? foreign_relation('crm_service','service_id','service_name',$service_id,' 1');?>
      </select>
    </span></td>
  </tr>
  <tr>
    <td align="right"><strong>People : </strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="dealer_code"  id="dealer_code"  class="selectpicker form-control" data-live-search="true">
        <option></option>
        <?
	  $select = 'select * from crm_customer_info where 1';
	  $query = db_query($select);
	  
	  while($row = mysqli_fetch_object($query)){
	  ?>
        <option value="<?=$row->dealer_code?>">
          <?=$row->dealer_code?>
          |
          <?=$row->dealer_name_e?>
          |
          <?=find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$row->PROJECT_ID.'"')?>
          |
          <?=$row->project_dept?>
          |
          <?=$row->project_desg?>
        </option>
        <? } ?>
        <? //foreign_relation('crm_customer_info','dealer_code','dealer_name_e',$dealer_code,' 1');?>
      </select>
    </span></td>
    <td width="6%" align="right" >&nbsp;</td>
    <td align="right" ><strong>Customer  :</strong></td>
    <td align="left" ><span class="oe_form_group_cell">
      <select name="project_id"  id="project_id"  class="selectpicker form-control" data-live-search="true">
        <option></option>
        <? foreign_relation('crm_project','project_id','project_desc',$project_id);?>
      </select>
    </span></td>
  </tr>

  <tr  >
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4">
  <table align="center">
  <tr><td>Date</td><td><input type="date" name="f_date" id="f_date" /></td><td>TO</td><td><input type="date" name="t_date" id="t_date" /></td></tr>
  </table>  </th>
</tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><div align="center"><span>Select Report</span></div></th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    <tr>
      <td width="4%" align="center">&nbsp;</td>
      <td width="44%">&nbsp;</td>
      <td width="4%" align="center">&nbsp;</td>
      <td width="44%">&nbsp;</td>
      </tr>
	      <tr  >
	        <td align="center"><input name="report" type="radio" class="radio" checked="checked" value="22" /></td>
	        <td><strong>Customer  Information Report </strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  >
	        <td align="center"><input name="report" type="radio" class="radio" checked="checked" value="23" /></td>
	        <td><strong>Service/Product Information Report </strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  >
	        <td align="center"><input name="report" type="radio" class="radio" checked="checked" value="201" /></td>
	        <td><strong>Peoples  Information Report </strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  >
	        <td align="center"><input name="report" type="radio" class="radio" checked="checked" value="483164" /></td>
	        <td><strong>Individual Peoples Information <span style="font-size: 10px;">(Please select peoples from top panel)</span> </strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  >
	        <td align="center"><input name="report" type="radio" class="radio" checked="checked" value="202" /></td>
	        <td><strong>Lead Information Report  </strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  >
	        <td align="center"><input name="report" type="radio" class="radio" checked="checked" value="203" /></td>
	        <td><strong>Communication  Report </strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  >
	        <td align="center"><input name="report" type="radio" class="radio" checked="checked" value="204" /></td>
	        <td><strong> Communication Report (Customer Wise) </strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  >
	        <td align="center"><input name="report" type="radio" class="radio" checked="checked" value="20444" /></td>
	        <td><strong> Export All Peoples </strong></td>
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
	      <tr  >
	        <td align="center">&nbsp;</td>
	        <td>&nbsp;</td>
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