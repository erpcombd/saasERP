<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";







// ::::: Edit This Section ::::: 

$title='Leave Rule Setup';			// Page Name and Page Title

$page="leave_policy_setup.php";		// PHP File Name

$input_page="leave_policy_input.php";

$root='leave';
$link="leave_policy_input.php";



$table='hrm_leave_rull_manage';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='rule_name';				// For a New or Edit Data a must have data field



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

				<?   $res='select a.id,a.rule_name as Policy_Type,a.CL as Casual_Leave,a.MED as Sick_Leave,a.ANU as Annual_Leave, a.MTR as Maternity_Leave,
				a.ML as Marriage_Leave,a.PL as Paternity_Leave,a.HL as Hajj_Leave
				
				from hrm_leave_rull_manage a, user_group u  where u.id=a.organization';
                    echo link_report1($res,$link);?>

            



        </div>



    </form>






<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>

