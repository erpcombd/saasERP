<?php

require_once "../../../assets/template/layout.top.php";



// ::::: Edit This Section ::::: 

$input_page="dealer_info_input.php"; $add_button_bar = 'Mhafuz';

$title='Add New Customer Information';			// Page Name and Page Title

$page="dealer_info_input.php"; 		// PHP File Name



$table='dealer_pos';		// Database Table Name Mainly related to this page

$unique='dealer_code';			// Primary Key of this Database table

$shown='dealer_name';				// For a New or Edit Data a must have data field


$crud      =new crud($table);

?>

<script type="text/javascript"> function DoNav(lk){
	window.open('../../pages/do_pos/<?=$input_page?>?<?=$unique?>='+lk,'_self');
	}</script>



        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div class="tabledesign" style="height:787px;">
                <? 	$res='select '.$unique.','.$unique.' as customer_code,'.$shown.' as customer_name, contact_no from '.$table;

											echo $crud->link_report($res,$link);?>
              </div>
               </td>
          </tr>
        </table>
 
 
<?

require_once "../../../assets/template/layout.bottom.php";

?>
