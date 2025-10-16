<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Item Receive';
$page="item_receive.php";		// PHP File Name
$input_page="item_receive_input.php";
if($_GET['cat_id']>0)
{		// Page Name and Page Title
$cat_id=$_GET['cat_id'];
$title=find_a_field('inv_item_category','category_name','id='.$cat_id).' Item Receive';
$page="item_receive.php?cat_id=".$cat_id;		// PHP File Name
$input_page="item_receive_input.php?cat_id=".$cat_id;
}

$root='inventory';

$table='inv_item_receive';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='item_id';				// For a New or Edit Data a must have data field

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
$crud      =new crud($table);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>

<form action="" method="post">
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
    <? include('../../common/report_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	
		  
		  $res='select a.id,a.id,a.po_no,b.item_name,a.catton_no,a.colour_no,a.quantity,delivery_date as date from inv_item_receive a, inv_item b where a.item_id=b.id';
											echo $crud->link_report($res,$link);?>
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>