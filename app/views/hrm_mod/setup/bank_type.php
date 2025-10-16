<?php



require_once "../../../controllers/routing/default_values.php";

require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 

$title='Bank Type Information';			// Page Name and Page Title

$page="bank_type.php";		// PHP File Name

$input_page="bank_type_input.php";

$root='setup';
$link="bank_type_input.php";



$table='bank';		// Database Table Name Mainly related to this page

$unique='BANK_CODE';			// Primary Key of this Database table

$shown='BANK_NAME';				// For a New or Edit Data a must have data field

do_datatable('grp');

// ::::: End Edit Section :::::





$crud      =new crud($table);



$$unique = $_GET[$unique];



?>

<script type="text/javascript"> function DoNav(lk){

	return GB_show('  ', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)

	}</script>











	<form  action="" method="post">

        <? include('../common/report_bar.php');?>

        <div class="container-fluid pt-5 p-0 ">

		

		

		<? 	 $res='select '.$unique.','.$unique.', '.$shown.' from '.$table;

											echo link_report1($res,$link);?>

		

		



            



        </div>







    </form>













<br/>

<br/>

<br/>

<br/>

<br/>









<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>