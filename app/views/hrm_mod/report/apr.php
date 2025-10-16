<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='APR Entry Management';			// Page Name and Page Title
$page="apr.php";		// PHP File Name
$input_page="apr_input.php";
$root='hrm';

$table='apr_detail';		// Database Table Name Mainly related to this page
$unique='APR_D_ID';			// Primary Key of this Database table
$shown='APR_YEAR';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
$crud      =new crud($table);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?><?=$unique?>='+lk,600,940)
	}</script>

<form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <? include('../common/report_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
<table width="100%" class="oe_list_content"><thead><tr class="oe_list_header_columns">
  <th colspan="5">Staff Detail Information Selection</th>
  </tr>
</thead><tfoot><tr><td></td><td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
</tfoot><tbody><tr onclick="DoNav(200)"><td>200</td><td>How to Ope. Imp. &amp; Exp. Business Successfully</td>
    <td>&nbsp;</td>
    <td>200</td>
    <td>How to Ope. Imp. &amp; Exp. Business Successfully</td>
    </tr>
  <tr onclick="DoNav(201)" class="alt"><td>201</td><td>Export Documentation</td>
    <td>&nbsp;</td>
    <td>201</td>
    <td>Export Documentation</td>
    </tr>
  <tr onclick="DoNav(202)"><td>202</td><td>QMS Internal Auditor Training Course</td>
    <td>&nbsp;</td>
    <td>202</td>
    <td>QMS Internal Auditor Training Course</td>
    </tr>
</tbody></table><div style="text-align:center"><input name="submit" type="submit" id="submit" value="SHOW" />
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