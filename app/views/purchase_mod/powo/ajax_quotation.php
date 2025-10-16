<?php
session_start();
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);

  $vendor_id = $data[0];
?>

<div>
 
        <div>
          <label for="">Quotation No:</label>
           <select id="quotation_no" name="quotation_no" required >
       
      <? foreign_relation('quotation_master','quotation_no','quotation_no',$quotation_no,'vendor_id="'.$vendor_id.'" and status="CHECKED" order by quotation_no');?>
        </select>
        </div>
		</div>