<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);

 $payment_method=$data[0];
   $config_all = find_all_field('config_group_class','*','group_for="'.$_SESSION['user']['group'].'"'); 	


?>

 
					
					<? if ($payment_method=="CASH") { ?>
			
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;" onchange="getData2('cash_bank_ajax_sub.php', 'cash_bank_sub_filter', this.value,  document.getElementById('payment_method').value);">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in ("'.$config_all->cash_group.'")  ');?>
									</select>	

  					<? }?>
					
					
					<? if ($payment_method=="BANK" || $payment_method=="CHEQUE") { ?>
			
									<select name="cr_ledger_id" id="cr_ledger_id" required="required" style="width:220px;" onchange="getData2('cash_bank_ajax_sub.php', 'cash_bank_sub_filter', this.value,  document.getElementById('payment_method').value);">
									  <option></option>
									  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['cr_ledger_id'],'ledger_group_id in ("'.$config_all->bank_group.'")  ');?>
									</select>	

  					<? }?>
					
					
					