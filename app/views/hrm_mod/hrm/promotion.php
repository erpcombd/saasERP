<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Promotion Entry Management';			// Page Name and Page Title
$page="promotion.php";		// PHP File Name
$input_page="promotion_input.php";
$root='hrm';
$link="promotion_input.php";

$table='promotion_detail';		// Database Table Name Mainly related to this page
$unique='PROMOTION_D_ID';			// Primary Key of this Database table
$shown='PROMOTION_TYPE';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];

do_datatable('grp');

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show(' ', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>








    <form  action="" method="post" enctype="multipart/form-data">
        <? include('../common/title_bar.php');?>
        <? include('../common/report_bar.php');?>
        <div class="container-fluid pt-5 p-0 ">



			<? 	
 $res='select '.$unique.',PROMOTION_D_ID as id, PROMOTION_DATE as Date, PROMOTION_TYPE as Promotion_Type, 
(select DESG_DESC from designation where DESG_ID=PROMOTION_PAST_DESG) as Past_Desg, 
(select DESG_DESC from designation where DESG_ID=PROMOTION_PRESENT_DESG) as Present_Desg, report_to 
from '.$table.' 
where PBI_ID='.$_SESSION['employee_selected'].'
order by PROMOTION_D_ID desc
';

echo link_report1($res,$link);?>
            

        </div>

    </form>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>