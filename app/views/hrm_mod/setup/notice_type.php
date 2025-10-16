<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 
$title='Notice Information';			// Page Name and Page Title
$page="notice_type.php";		// PHP File Name
$input_page="notice_type_input.php";
$root='setup';
$link="notice_type_input.php";

$table='notice';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='notice_title';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
do_datatable('grp');

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>







    <form  action="" method="post" enctype="multipart/form-data">
       <? include('../common/report_bar.php');?>
        <div class="container-fluid  p-0 ">
				<?  $res='select s.id, s.notice_title,
		  
    s.notice_description,s.notice_date,s.notice_expaire_date,s.department,u.group_name 
	
	from notice s, user_group u  where u.id=s.organization';
											echo link_report1($res,$link);?>
            

        </div>

    </form>







<?


require_once SERVER_CORE."routing/layout.bottom.php";

?>
