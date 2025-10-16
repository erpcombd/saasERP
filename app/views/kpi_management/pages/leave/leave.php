<?php
session_start();
ob_start();
require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Leave Input Management';			// Page Name and Page Title
$page="leave.php";		// PHP File Name
$input_page="leave_input.php";
$root='hrm';

$table='leave_detail';		// Database Table Name Mainly related to this page
$unique='LEAVE_D_ID';			// Primary Key of this Database table
$shown='LEAVE_YEAR';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

$crud      =new crud($table);

$$unique = $_GET[$unique];
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>
	<style type="text/css">
<!--
.style2 {
	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
    </style>
	

<form action="" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <? //include('../../common/report_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
            <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#666666">
              <tr>
                <td><div align="center" class="style2">Leave Report 2016 </div></td>
              </tr>
            </table>
<table class="oe_list_content"><thead>
  
  <tr class="oe_list_header_columns"><th colspan="4"><div align="center">Leave Entitlement </div></th><th colspan="4"><div align="center">Leave Taken </div></th><th colspan="4"><div align="center">Available Leave  </div></th>
  <th><div align="center">Leave Date </div></th>
  <th><div align="center">Leave Types </div></th>
  <th><div align="center">Reason For Leave</div></th></tr></thead><tfoot><tr><td colspan="4"></td><td colspan="4"></td><td colspan="4"></td>
      <td></td>
      <td></td>
      <td></td></tr></tfoot><tbody>
	  
	  <tr>
	    <td>CL</td>
	    <td>MED</td>
	    <td>ANU</td>
	    <td>MTR</td>
	    <td>CL</td>
	    <td>MED</td>
	    <td>ANU</td>
	    <td>MTR</td>
	    <td>CL</td>
	    <td>MED</td>
	    <td>ANU</td>
	    <td>MTR</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
		
	  <?
	  $due_leave = 20;
	  $res = "select o.s_date as start_date, o.e_date as end_date,o.total_days,type,reason from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID  and a.PBI_ID=o.PBI_ID and  a.PBI_ID='".$_SESSION['employee_selected']."' order by o.s_date asc";
	  $query = mysql_query($res);
	  while($data=mysql_fetch_object($query)){
	  $due_leave = $due_leave - $data->total_days;
	  ?>
	  
	  <tr>
          <td><div align="center"></div></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><div align="center"><? echo $data->total_days;?></div></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><div align="center"><? echo $due_leave;?></div></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><div align="center"><? echo $data->start_date;?></div></td><td><? echo $data->type;?></td>
          <td><? echo $data->reason;?></td>
	</tr>
		  <? }?>
		  </tbody></table>
          </div></div>
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
include ("../../template/main_layout.php");
?>