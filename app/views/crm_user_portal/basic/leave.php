<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

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
                <td><div align="center" class="style2">&#2459;&#2497;&#2463;&#2495; &#2536;&#2534;&#2535;&#2539; </div></td>
              </tr>
            </table>
<table class="oe_list_content"><thead>
  
  <tr class="oe_list_header_columns"><th><div align="center">&#2478;&#2507;&#2463; &#2437;&#2480;&#2509;&#2460;&#2495;&#2468; &#2459;&#2497;&#2463;&#2495;</div></th><th><div align="center">&#2476;&#2509;&#2479;&#2476;&#2489;&#2499;&#2468; &#2459;&#2497;&#2463;&#2495; </div></th><th><div align="center">&#2437;&#2476;&#2509;&#2479;&#2476;&#2489;&#2499;&#2468; &#2459;&#2497;&#2463;&#2495; </div></th>
  <th><div align="center">&#2438;&#2476;&#2503;&#2470;&#2472;&#2453;&#2499;&#2468; &#2459;&#2497;&#2463;&#2495;&#2480; &#2468;&#2494;&#2480;&#2495;&#2454;</div></th>
  <th><div align="center">&#2459;&#2497;&#2463;&#2495;&#2480; &#2471;&#2480;&#2472; </div></th>
  <th><div align="center">&#2459;&#2497;&#2463;&#2495; &#2455;&#2509;&#2480;&#2489;&#2472;&#2503;&#2480; &#2453;&#2494;&#2480;&#2472;</div></th></tr></thead><tfoot><tr><td></td><td></td><td></td>
      <td></td>
      <td></td>
      <td></td></tr></tfoot><tbody>
	  <?
	  $due_leave = 20;
	  $res = "select o.s_date as start_date, o.e_date as end_date,o.total_days,type,reason from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID  and a.PBI_ID=o.PBI_ID and  a.PBI_ID='".$_SESSION['employee_selected']."' order by o.s_date asc";
	  $query = db_query($res);
	  while($data=mysqli_fetch_object($query)){
	  $due_leave = $due_leave - $data->total_days;
	  ?>
	<tr>
          <td><div align="center">20</div></td><td><div align="center"><? echo $data->total_days;?></div></td><td><div align="center"><? echo $due_leave;?></div></td><td><div align="center"><? echo $data->start_date;?></div></td><td><? echo $data->type;?></td>
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>