<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Roster Report';
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#roster_date');
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
label{
font-weight:bold;
}
</style>

<form action="master_report_roster.php" target="_blank" method="post">
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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F"> Roster Reporting</span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>


 <div class="row ">
	         <div class="col-md-4 form-group">
            <label for="rcv_amt">Company: </label>
            <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
		  <div class="col-md-4 form-group">
            <label for="dealer_code">Job Location: </label>
           <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
		   
          </div  class="row">
		  
		  <div class="col-md-4 form-group">
            <label for="dealer_code">Start Date: </label>
           <input name="rcv_amt" type="date" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  <div class="col-md-4 form-group">
            <label for="dealer_code">Start Month: </label>
           <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
		  <div class="col-md-4 form-group">
            <label for="dealer_code">Department: </label>
           <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  <div class="col-md-4 form-group">
            <label for="dealer_code">Section: </label>
           <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  </div>
		  
  

  
  
  
  
  
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
    <tr>
      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
      <td width="44%"><strong>Roster Schedule Report (1) </strong></td>
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