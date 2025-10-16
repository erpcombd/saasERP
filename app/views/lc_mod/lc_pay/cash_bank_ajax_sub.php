<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


   $str = $_POST['data'];


  $data=explode('##',$str);

 $payment_method=$data[1];
   $ledger_id=$data[0];
   
 $config_all = find_all_field('config_group_class','*','group_for="'.$_SESSION['user']['group'].'"'); 	
 
 
?>

 
					
					<? if ($payment_method=="CASH") { ?>
			
									<select name="cr_sub_ledger_id" id="cr_sub_ledger_id" required="required" style="width:220px;"  >
									  <option></option>
									  <? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$_POST['cr_sub_ledger_id'],'ledger_id in ("'.$ledger_id.'")  ');?>
									</select>	

  					<? }?>
					
					
					<? if ($payment_method=="BANK" || $payment_method=="CHEQUE") { ?>
			
									<select name="cr_sub_ledger_id" id="cr_sub_ledger_id" required="required" style="width:220px;">
									  <option></option>
									  <? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$_POST['cr_sub_ledger_id'],'ledger_id in ("'.$ledger_id.'")  ');?>
									</select>	

  					<? }?>
					
					
					