<?
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
session_start();
ob_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
do_calander('#jv_date');

do_calander('#c_date');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1); 
//error_reporting(E_ALL);

$title = 'Receipt Voucher';

$proj_id = $_SESSION['proj_id'];

$user_id = $_SESSION['user']['id'];

$tr_from = 'Receipt';


if ($_GET['new'] > 0) {

	unset($_SESSION['jv_no']['Receipt']);

	unset($_SESSION['tr_no']['Receipt']);

}

if ($_GET['jv_no']['Receipt'] > 0) {

	$_SESSION['jv_no']['Receipt'] = $_GET['jv_no']['Receipt'];

}

if ($_GET['tr_no']['Receipt'] > 0) {

	$_SESSION['tr_no']['Receipt'] = $_GET['tr_no']['Receipt'];

}

//else

//{

//    $jv_no = $_SESSION['jv_no'] = next_journal_sec_voucher_id($tr_from);

//	$tr_no = $_SESSION['tr_no'] = next_tr_no($tr_from);

//

//}

$cash_and_bank_balance = find_a_field('ledger_group', 'group_id', "group_sub_class='1020' ");

///////////////////

if (isset($_POST['add']) && $_SESSION['csrf_token']===$_POST['csrf_token']) {

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	$v_date = $_SESSION['old_v_date'] = $_REQUEST["date"];

	$ledger_id = $_REQUEST["ledger_id"];

	$bank = $_REQUEST["bank"];

	$r_from = $_REQUEST['r_from'];

	$c_no = $_REQUEST['c_no'];



	$cheq_date = $_REQUEST['c_date'];

	$c_id = $_REQUEST['c_id'];

	$jv_date = $_REQUEST['jv_date'];

	$type = $_REQUEST['type'];

	$manual_voucher_no = $_REQUEST['manual_voucher_no'];

	$exchange_rate = $_REQUEST['exchange_rate'];
	$usd_amt = $_REQUEST['usd_amt'];

	//$bi_id		= explode('##>>',$_REQUEST['b_id']);

	//$b_id		= $bi_id[1];

	$b_id = $_REQUEST['b_id'];

	$t_amount = $_REQUEST['t_amount'];

	if ($type == 'CASH') {

		$receive_ledger = $c_id;

	} else {

		 $receive_ledger = $b_id;

	}

	$ledgers = explode('::', $receive_ledger);

	$search = array(":", " ", "[", "]", $separater);

	$ledger1 = str_replace($search, '', $ledgers[0]);

	$ledger2 = str_replace($search, '', $ledgers[1]);

	if (is_numeric($ledger1))

		$receive_ledger = $ledger1;
	else

		$receive_ledger = $ledger2;

	//////////////////////////

	$ledger_id = $_REQUEST['ledger_id'];

	$ledgers = explode('::', $ledger_id);

	$ledger_id = $ledgers[0];

	$detail_status = $_REQUEST['detail'];

	$cur_bal = $_REQUEST['cur_bal'];

	$detail = $_REQUEST['detail'];

	$amount = $_REQUEST['amount'];

	$cc_code = $_REQUEST['cc_code'];

	$remarks = $_REQUEST['remarks'];

	$reference_id = $_REQUEST['reference_id'];
	$sub_ledger = $_REQUEST['sub_ledger'];
    


	if ($bank == '')

		$dnarr = $detail;
	else

		//$dnarr=$detail.':: Cheq# '.$c_no.':: Date= '.$cheq_date;
		$dnarr = $detail . '  Cheq# ' . $c_no . ':: Date= ' . $cheq_date;

	$checked = 'UNFINISHED';



	if ($_SESSION['jv_no']['Receipt'] == 0) {

		$jv_no = $_SESSION['jv_no']['Receipt'] = next_journal_sec_voucher_id($tr_from, 'Receipt',$_SESSION['user']['group'],$_SESSION['user']['id']);

		$tr_no = $_SESSION['tr_no']['Receipt'] = next_tr_no($tr_from);

	} else {

		$jv_no = $_SESSION['jv_no']['Receipt'];

		$tr_no = $_SESSION['tr_no']['Receipt'];


	}




	$folder = 'ReceiptVoucher';
	$field = 'file_upload';
	$file_name = $field . $_SESSION['jv_no']['Receipt'];
	if ($_FILES['file_upload']['tmp_name'] != '') {
		$uploaded_file = upload_file($folder, $field, $file_name);
	}

	if ($receive_ledger > 0 && $ledger_id>0 && $jv_date!='' && $jv_date!='0000-00-00') {
		if ($jv_no > 0) {
			add_to_sec_journal($proj_id, $jv_no, $jv_date, $ledger_id, $dnarr, '0', $amount, $tr_from, $tr_no, $sub_ledger, '', $cc_code, '', $user_id, '', $r_from, $bank, $c_no, $cheq_date, $receive_ledger, $checked, $type, $employee, $remarks, $uploaded_file, $reference_id);

			$up = 'update secondary_journal set manual_voucher_no="' . $manual_voucher_no . '", exchange_rate="' . $exchange_rate . '", usd_amt="' . $usd_amt . '" where jv_no="' . $_SESSION['jv_no']['Receipt'] . '"';
			db_query($up);

		}
	} else {
		echo "<h1 style='text-align:center;color:red;font-weight:bold;'>Please select Cash or Bank head first</h1>";
	}
}

if (isset($_POST['limmit']) && $_SESSION['csrf_token']===$_POST['csrf_token']) {
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	if ($_SESSION['tr_no']['Receipt'] > 0) {

		if ($_SESSION['jv_no']['Receipt'] > 0) {

			$j_data = find_all_field('secondary_journal', '', 'jv_no="' . $_SESSION['jv_no']['Receipt'] . '"');

			$detail = 'Received Through : ' . $j_data->received_from;

			$sub_led = find_all_field('general_sub_ledger', '', 'sub_ledger_id="' . $j_data->relavent_cash_head . '"');

            if($sub_led->ledger_id>0){
			add_to_sec_journal(
				$proj_id,
				$j_data->jv_no,
				$j_data->jv_date,
				$sub_led->ledger_id,
				$detail,
				$_POST['t_amount'],
				'0',
				$tr_from,
				$j_data->tr_no,
				$j_data->relavent_cash_head,
				'',
				'0',
				'',
				$j_data->user_id,
				'',
				$j_data->received_from,
				$j_data->bank,
				$j_data->cheq_no,
				$j_data->cheq_date,
				$j_data->relavent_cash_head,
				$checked,
				$j_data->type,
				$j_data->employee_id,
				$j_data->remarks,
				'0'
			);
			}

    $reconsilation_type = find_a_field('general_configuration','cash_bank_reconsilation','group_for="'.$_SESSION['user']['group'].'"');
	if($reconsilation_type == 'No'){
	$reconsilation_note = 'Reconsilation Pending';
	}else{
	$reconsilation_note = '';
	}
			$up = 'update secondary_journal set checked="NO",    manual_voucher_no="' . $j_data->manual_voucher_no . '", exchange_rate="' . $j_data->exchange_rate . '", usd_amt="' . $j_data->usd_amt . '",reconsilation_status="'.$reconsilation_type.'",reconsilation_note="'.$reconsilation_note.'" where jv_no="' . $_SESSION['jv_no']['Receipt']. '" and tr_from="'.$tr_from.'"';
			db_query($up);


			$_SESSION['jv_no']['Receipt'] = '';

			$_SESSION['receipt_no']['Receipt'] = '';
		}
	} else {

		$msg = '<span style="color:red">Data Re-Submit Not Allowed..!</span>';

		$_SESSION['receipt_no']['Receipt'] = '';


	}

	$sa_config = find_a_field('voucher_config', 'secondary_approval', 'voucher_type="' . $tr_from . '"');

	$time_now = date('Y-m-d H:i:s');

	if ($sa_config == "Yes") {

		$sa_up = 'update secondary_journal set secondary_approval="Yes", om_checked_at="' . $time_now . '", om_checked="' . $_SESSION['user']['id'] . '" where jv_no="' . $j_data->jv_no . '" and tr_from="' . $tr_from . '"';

		db_query($sa_up);

		$jv_config = find_a_field('voucher_config', 'direct_journal', 'voucher_type="' . $tr_from . '"');


		if ($jv_config == "Yes") {



			$time_now = date('Y-m-d H:i:s');

			$up2 = 'update secondary_journal set checked="YES",checked_at="' . $time_now . '", checked_by="' . $_SESSION['user']['id'] . '" where jv_no="' . $j_data->jv_no . '" and tr_from="' . $tr_from . '"';

			db_query($up2);

			//$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($sa_up2);

			sec_journal_journal($j_data->jv_no, $j_data->jv_no, $tr_from);
		}


	} else {

		$sa_up = 'update secondary_journal set secondary_approval="No" where jv_no="' . $j_data->jv_no . '" and tr_from="' . $tr_from . '"';

		db_query($sa_up);

	}


	//$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');
//
//if($jv_config=="Yes"){
//
//sec_journal_journal($j_data->jv_no,$j_data->jv_no,$tr_from);
//
//$time_now = date('Y-m-d H:i:s');
//
//$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$j_data->jv_no.'" and tr_from="'.$tr_from.'"';
//
//db_query($up2);
//
//}

unset($_SESSION['jv_no']['Receipt']);

	unset($_SESSION['tr_no']['Receipt']);
}



if ($_GET['del'] > 0) {
	//$crud   = new crud($table_details);
	//$condition="id=".$_GET['del'];		
	//$crud->delete_all($condition);
	$del_jv = "delete from secondary_journal where tr_from='Receipt' and id = '" . $_GET['del'] . "'";
	db_query($del_jv);

	$type = 1;
	$msg = 'Successfully Deleted.';
}


//
//
//
//if(isset($_POST['cancel_jv'])){
//
//if($_SESSION['tr_no']>0){
//
//$j_data = find_all_field('secondary_journal','','jv_no="'.$_SESSION['jv_no'].'"');
//
//
//		$del_jv = "delete from secondary_journal where tr_from='Receipt' and tr_no = '".$_SESSION['tr_no']."'";
//		db_query($del_jv);
//
//
//$_SESSION['jv_no']     = '';
//
//$_SESSION['receipt_no'] = '';
//
//}else{
//
//$msg = '<span style="color:red">Data Re-Submit Not Allowed..!</span>';
//
//$_SESSION['receipt_no'] = '';
//
//
//}
//
//
//
//
//}






$jv = find_all_field('secondary_journal', '', 'jv_no="' . $_SESSION['jv_no']['Receipt'] . '"');

if ($_SESSION['jv_no']['Receipt'] == 0) {

	$jv_no = next_journal_sec_voucher_id($tr_from, 'Receipt',$_SESSION['user']['group'],$_SESSION['user']['id']);

	$tr_no = next_tr_no($tr_from);

} else {

	$jv_no = $_SESSION['jv_no']['Receipt'];

	$tr_no = $_SESSION['tr_no']['Receipt'];

}


if ($jv->tr_no == 0) {
	//create_combobox('bank_disable_id');
	create_combobox('cash_disable_id');
}
js_ledger_subledger_autocomplete_new('receipt', $proj_id, $voucher_type, $_SESSION['user']['group']);
//create_combobox('ledger_id');
?>

<script type="text/javascript">

	function DoNav(theUrl) {

		var URL = 'voucher_view_popup.php?' + theUrl;

		popUp(URL);

	}

	function cb_set(va) {

		if (va = 'BANK') {

			$("#c_id").val("0");

			$('#c_id').attr('disabled', 'disabled');

			$('#b_id').removeAttr('disabled');

		}

		if (va = 'CASH') {

			$("#b_id").val("0");

			$('#b_id').attr('disabled', 'disabled');

			$('#c_id').removeAttr('disabled');

		}

	}

	function Do_Nav() {

		var URL = 'pop_invoice_paid.php';

		popUp(URL);

	}

	function popUp(URL) {

		day = new Date();

		id = day.getTime();

		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

	}

</script>

<script type="text/javascript" src="../../common/js/check_balance.js"></script>

<script type="text/javascript" src="../../common/receipt_check.js"></script>

<script language="javascript" type="text/javascript">

	function goto_tab() {

		document.getElementById('ledger_id').focus()

	}

	function check_status(values) {

		if (values == "BANK") {

			document.getElementById("cash_disable_id").disabled = true;

			document.getElementById("bank_disable_id").disabled = false;

		} else if (values == "CASH") {

			document.getElementById("bank_disable_id").disabled = true;

			document.getElementById("cash_disable_id").disabled = false;

		}

	}

	function check_type() {

		var check_type = document.getElementById('type').value;

		if (check_type == 'CASH') {

			document.getElementById('bank_check').style.display = 'none';
			document.getElementById('check_no_check').style.display = 'none';
			document.getElementById('check_date_check').style.display = 'none';
			document.getElementById('of_bank_check').style.display = 'none';
		} else {

			document.getElementById('bank_check').style.display = '';
			document.getElementById('check_no_check').style.display = '';
			document.getElementById('check_date_check').style.display = '';
			document.getElementById('of_bank_check').style.display = '';
		}

		if (check_type == 'BANK') {

			document.getElementById('cash_check').style.display = 'none';

		} else {

			document.getElementById('cash_check').style.display = '';

		}

	}

	window.onload = check_type;


</script>


<style type="text/css">

</style>






<div class="form-container_large">
	<form id="form1" name="form1" method="post" action="?" enctype="multipart/form-data" onsubmit="return checking()">
		<!--        top form start hear-->
		<div class="container-fluid bg-form-titel">
			<div class="row">
				<!--left form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">

						<div class="row pb-1">
							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">
								<div class="form-group row m-0 pb-1">
									<label
										class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12">Voucher
										No:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

										<?

										$receiptno = next_invoice('tr_no', 'secondary_journal');

										if ($v_d > 10000)

											$v_d = date("d-m-y", $v_d);

										if ($_GET['action'] == 'edit') {
											$v_no_show = 'value="' . $v_no . '" readonly';
										} elseif ($old_voucher_mode == 1) {
											$v_no_show = 'value="' . $receiptno . '" readonly';
										} else
											$v_no_show = '';

										$_SESSION['jv_no']['Receipt'];

										?>

										<input name="receipt_no" type="text" id="receipt_no" class="form-control"
											tabindex="1" size="15" value="<?= $tr_no ?>" <? if ($jv->tr_no > 0)
												echo 'disabled' ?> />

											<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_manual"
												value="0" <?php if ($old_voucher_mode == 0) { ?>checked="checked" <? } ?>
											onclick="voucher_no(this.value)" />

										<input type="hidden" name="voucher_mode" class="radio" id="voucher_mode_auto"
											value="1" <?php if ($old_voucher_mode == 1) { ?>checked="checked" <? } ?>
											onclick="voucher_no(this.value)" />


									</div>
								</div>
							</div>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pl-0">
								<div class="form-group row m-0 pb-1">
									<label
										class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12">Voucher
										Date:</label>
									<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0 pr-2 ">

										<?
										//  $previous="SELECT a.* FROM secondary_journal a WHERE  a.entry_by='".$_SESSION['user']['id']."' and a.checked='Yes' and a.tr_from='Receipt' order by id desc limit 1";
										//$previous_data = find_all_field_sql($previous);
										
										?>

										<input name="jv_date" type="text" id="jv_date" tabindex="2" value="<?php if ($jv->jv_date == "") {
											echo $today = date('Y-m-d');
										} else {
											echo $jv->jv_date;
										} ?>" size="10" <?php /*?><? if($jv->tr_no>0) echo 'disabled'?><?php */ ?> tabindex="1" required
											class="form-control" />


									</div>
								</div>
							</div>
						</div>


						<div class="row pb-1">

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">
								<div class="form-group row m-0 pb-1">
									<label
										class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text font-size12 req-input">Received
										From:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input name="r_from" type="text" id="r_from"
											value="<?php echo $jv->received_from ?>" class="form-control" tabindex="3" <? if ($jv->tr_no > 0)
												  echo 'readonly' ?> />

										</div>
									</div>
								</div>


								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pl-0">
									<div class="form-group row m-0 pb-1">
										<label
											class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input font-size12">Receive
											Mode:</label>
										<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0 pr-2 ">

										<? if ($jv->tr_no > 0) { ?><input type="text" name="type" id="type"
												value="<?= $jv->type ?>" readonly="readonly" tabindex="4"
												class="form-control" /><? } else { ?><select name="type" id="type" required
												onChange="check_type()" tabindex="4" class="form-control">

												<!--<option value="0"></option>-->
												<option></option>

												<option value="CASH" <?= ($jv->type == 'CASH') ? 'Selected' : ''; ?>>CASH</option>

												<option value="BANK" <?= ($jv->type == 'BANK') ? 'Selected' : ''; ?>>BANK</option>

											</select><? } ?>

									</div>
								</div>
							</div>




						</div>
						<?php
						$proj_all = find_all_field('project_info', '*', '1');
						$gr_all = find_all_field('config_group_class', '*', 'group_for=' . $_SESSION['user']['group']); //update_by jobaraj date :02/11/2023 
							$cash_ledg_group_id = $gr_all->cash_group;
							$bank_ledg_group_id = $gr_all->bank_group;
						
						?>


						<div id="cash_check" class="form-group row m-0 pb-1">
							<label
								class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cash
								A/C: </label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2 ">



								<? if ($jv->tr_no > 0) { ?>
									<input type="text" name="c_id_name" tabindex="5" id="cash_disable_id" readonly
										value="<?= find_a_field('general_sub_ledger', 'sub_ledger_name', 'sub_ledger_id="' . $jv->relavent_cash_head . '"'); ?>"
										style="float:left" class="form-control" />
									<input type="hidden" name="c_id" value="<?= $jv->relavent_cash_head ?>" />
								<? } else { ?>
									<select name="c_id" id="cash_disable_id" style="float:left" tabindex="5"
										class="form-control">

										<option value="0"></option>

										<?

										//foreign_relation('accounts_ledger','ledger_id','ledger_name',$c_id,'ledger_group_id="'.$cash_ledg_group_id.'"  order by ledger_name asc');
										foreign_relation('general_sub_ledger', 'sub_ledger_id', 'sub_ledger_name', $c_id, "ledger_id=" . $gr_all->cash_ledger . " order by ledger_id");


										?>

									</select>
								<? } ?>

							</div>
						</div>


						<div id="bank_check" class="form-group row m-0 pb-1">

							<label
								class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text req-input">Bank
								A/C Debit:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<? if ($jv->tr_no > 0) { ?>
									<input type="text" name="b_id_name" id="bank_disable_id" style="float:left" tabindex="6"
										value="<?= find_a_field('general_sub_ledger', 'sub_ledger_name', 'sub_ledger_id="' . $jv->relavent_cash_head . '"'); ?>"
										readonly="readonly" class="form-control" />
									<input type="hidden" name="b_id" value="<?= $jv->relavent_cash_head ?>" /><? } else { ?>
									<select name="b_id" id="bank_disable_id" style="float:left" tabindex="6" <? if ($jv->tr_no > 0)
										echo 'readonly' ?> class="form-control">

											<option value="0"></option>

										<?

									foreign_relation('general_sub_ledger', 'sub_ledger_id', 'sub_ledger_name', $b_id, "ledger_id=" . $gr_all->bank_ledger . " order by ledger_id");

									?>

									</select>
								<? } ?>


							</div>
						</div>





						<div id="check_no_check" class="form-group row m-0 pb-1">
							<label
								class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cheque
								No:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<input name="c_no" type="text" id="c_no" value="<?php echo $jv->cheq_no ?>"
									class="form-control" size="20" maxlength="25" tabindex="7" <? if ($jv->tr_no > 0)
										echo 'readonly' ?> />
								</div>
							</div>

							<div id="check_date_check" class="form-group row m-0 pb-1">
								<label
									class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Cheque
									Date:</label>
								<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
									<input name="c_date" type="text" id="c_date" value="<?= $jv->cheq_date ?>"
									class="form-control" size="12" maxlength="15" tabindex="8" <? if ($jv->tr_no > 0)
										echo 'disabled' ?> autocomplete="off" />
								</div>
							</div>

							<div id="of_bank_check" class="form-group row m-0 pb-1">
								<label
									class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">of
									Bank:</label>
								<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
									<input name="bank" list="banks" type="text" id="bank" value="<?php echo $jv->bank ?>"
									class="form-control" tabindex="9" <? if ($jv->tr_no > 0)
										echo 'readonly' ?> />
									<datalist id="banks">
									<? foreign_relation('drawee_bank', 'bank_name', 'bank_name', $jv->bank, '1 order by bank_name asc'); ?>
								</datalist>


							</div>
						</div>



						<div class="form-group row m-0 pb-1">
							<label
								class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">Remarks:</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<input name="remarks" type="text" id="remarks" value="<?php echo $jv->remarks ?>"
									tabindex="10" class="form-control" <? if ($jv->tr_no > 0)
										echo 'readonly' ?> />
								</div>
							</div>
							<!--<div class="form-group row m-0 pb-1">
								<label
									class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">File
									Attached:</label>
								<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
									<input name="file_upload" type="file" id="file_upload" value="<?php echo $jv->remarks ?>"
									tabindex="10" class="form-control" <? if ($jv->tr_no > 0) ?> />
								<?php $file_name = find_a_field('secondary_journal', 'file_upload', 'jv_no="' . $_SESSION['jv_no']['Receipt'] . '" and file_upload!=""');
								if ($file_name != '') { ?>
									<a href="<?= SERVER_CORE ?>core/upload_view.php?name=<?= $file_name ?>&folder=ReceiptVoucher&proj_id=<?= $_SESSION['proj_id'] ?>"
										target="_blank">View Attachment</a>
								<?php } ?>
							</div>
						</div>-->




					</div>


				</div>

				<!--Right form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="container n-form2">
						<table class="table1  table-striped table-bordered table-hover table-sm" border="0"
							cellspacing="0" cellpadding="0">

							<thead class="thead1">
								<tr class="bgc-info">
									<th>Vou No</th>
									<th>Amount</th>
									<th>Date</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>

							<tbody class="tbody1">

								<?

								$sql2 = "select a.tr_no, a.dr_amt, a.narration,a.jv_date , a.jv_no,a.checked

from  secondary_journal a where a.tr_from='Receipt'  and SUBSTRING(a.tr_no,5,1)='0' and  a.dr_amt>0 and a.group_for=" . $_SESSION['user']['group'] . " group by a.tr_no order by a.id desc limit 5";

								$data2 = db_query($sql2);

								if (mysqli_num_rows($data2) > 0) {

									while ($dataa = mysqli_fetch_row($data2)) {
										$dataa[2] = substr($dataa[2], 0, 20) . '...';

										?>

										<tr>

											<td><?= $dataa[0] ?></td>

											<td><?= $dataa[1] ?></td>

											<td><?= date('d-m-Y', strtotime($dataa[3])); ?></td>

											<td><?= $dataa[5] ?></td>




											<? if ($cid == 'mamun') { ?>
												<td style="padding:1px;"><a
														href="general_voucher_print_view_for_draft_new.php?jv_no=<?php echo rawurlencode(url_encode($dataa[4])); ?>"
														target="_blank"><img src="../images/print.png" width="16" height="16"
															border="0"></a></td>
											<? } else { ?>
												<td style="padding:1px;"><a
														href="general_voucher_print_view_for_draft.php?jv_no=<?php echo rawurlencode(url_encode($dataa[4])); ?>"
														target="_blank"><img src="../images/print.png" width="16" height="16"
															border="0"></a></td>
											<? } ?>



										</tr>

									<? }
								} ?>

							</tbody>

						</table>


					</div>



				</div>


			</div>


		</div>





		<!--Table input one design-->
		<div class="container-fluid pt-4 p-0 ">



			<table class="table1  table-striped table-bordered table-hover table-sm">


				<?

				//$jv_details="SELECT a.*, b.ledger_name FROM secondary_journal a, accounts_ledger b WHERE  a.ledger_id=b.ledger_id and a.jv_no='".$_SESSION['jv_no']."' order by id desc limit 1";
				//$jv_data = find_all_field_sql($jv_details);
				
				?>

				<thead class="thead1">
					<tr class="bgc-info">
						<th>GL Code</th>
						<th>GL Name</th>
						<th>Sub Ledger </th>
						<th>Cost Center</th>
						<th>Narration</th>
						<td>Amount</td>
						<td></td>
					</tr>
				</thead>
				<tbody class="tbody1">
					<tr>

						<td>
							<input type="text" id="ledger_id" name="ledger_id" onblur="getData2('acc_reference_ajax.php', 'acc_reference', this.value,
								document.getElementById('ledger_id').value);" tabindex="11" value="<?= $jv_data->ledger_id ?>" />
								<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
							<!--<select name="ledger_idww" id="ledger_idww" onchange = "getBalance('../../common/cur_bal.php', 'cur', this.value);">
								<option></option>
								<?
								//foreign_relation('accounts_ledger','concat(ledger_id,"::",ledger_name,">>>",ledger_name)','concat(ledger_id,"::",ledger_name,">>>",ledger_name)',''," parent=0 and group_for='".$_SESSION['user']['group']."' and  balance_type IN ('Credit','Both') and parent=0 and ledger_id not like '".$cash_and_bank_balance."%' order by ledger_id"); ?>
								</select>-->
						</td>

						<td>

							<span id="acc_reference">
								<table border="1" align="center" cellpadding="2" cellspacing="2">
									<tr>
										<td class="p-0">
											<input type="text" class="form-control" id="ledger_name" name="ledger_id"
												tabindex="12" value="<?= $jv_data->ledger_name ?>" />
											<input type="hidden" class="form-control" id="reference_id"
												name="reference_id" value="<?= $jv_data->reference_id ?>" />

											<?php /*?><select name="reference_id" id="reference_id"  tabindex="2"  style="width:120px;">
															<option></option>
															<? foreign_relation('acc_reference','id','reference_name',$jv_data->reference_id,"ledger_id='".$jv_data->ledger_id."'");?>
														  </select><?php */ ?>
										</td>
									</tr>
								</table>
							</span>
						</td>


						<td align="center">
							<input list="sub_ledgers" name="sub_ledger" id="sub_ledger" value="<?= $sub_ledger ?>"
								autocomplete="off" class="form-control"/>
							<datalist id="sub_ledgers">
								<option></option>
								<? foreign_relation('general_sub_ledger', 'sub_ledger_id', 'sub_ledger_name', $sub_ledger, "1"); ?>
							</datalist>
						</td>
						<td>
							<select name="cc_code" id="cc_code" tabindex="13">
								<option></option>
								<? foreign_relation('cost_center', 'id', 'center_name', $jv_data->cc_code, "group_for='" . $_SESSION['user']['group'] . "'"); ?>
							</select>
						</td>

						<td>
							<input name="detail" type="text" id="detail" tabindex="14" />
						</td>
						<td align="center">
							<input name="amount" type="text" id="amount" size="5" tabindex="15" />
						</td>


						<td>
							<input name="add_new" class="btn1 btn1-bg-submit" type="submit" id="add_new" value="Add New"
								tabindex="16" />
							<input name="add" type="hidden" />
						</td>
					</tr>
				</tbody>
			</table>

		</div>
		<script>
			function usdToBDT() {
				var exc = document.getElementById("exchange_rate").value * 1;
				var usd = document.getElementById('usd_amt').value * 1;
				document.getElementById('amount').value = (exc * usd);
			}
		</script>

		<!--Data multi Table design start-->
		<div class="container-fluid pt-4 p-0 ">

			<table class="table1  table-striped table-bordered table-hover table-sm" width="100%" align="center"
				border="1">

				<thead class="thead1">
					<tr class="bgc-info">
						<th>GL Code</th>
						<th>GL Name</th>
						<th>Sub Ledger</th>
						<th>Cost Center</th>
						<th><strong>Narration</strong></th>
						<th><strong>Amount</strong></th>
						<td><strong>Action</strong></td>
					</tr>

				</thead>


				<tbody class="tbody1">
					<?

					$sql2 = "select a.id, a.ledger_id, a.tr_no,l.ledger_name, a.cr_amt, a.narration,a.jv_date , a.jv_no, a.cc_code, a.reference_id,a.sub_ledger

from  secondary_journal a, accounts_ledger l where a.ledger_id=l.ledger_id and a.jv_no='" . $_SESSION['jv_no']['Receipt'] . "' and a.cr_amt>0 and tr_from='Receipt'";

					$qr = db_query($sql2);

					while ($data = mysqli_fetch_object($qr)){
					
						$total_amt = $total_amt + $data->cr_amt;
						
						?>

						<tr align="center" style="padding:5px;">

							<td><?= $data->ledger_id ?></td>

							<td align="left"><?= $data->ledger_name ?></td>
							<td><?= find_a_field('general_sub_ledger', 'sub_ledger_name', 'sub_ledger_id=' . $data->sub_ledger); ?>
							</td>
							<td><?= find_a_field('cost_center', 'center_name', 'id=' . $data->cc_code); ?></td>
							<td><?= $data->narration ?></td>
							<td><?= $data->cr_amt ?></td>

							<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}"
									href="?del=<?= $data->id ?>">&nbsp;<img src="del.png" width="25"
										height="auto" />&nbsp;</a></td>
						</tr>

					<? } ?>

	</form>
	<form method="post">
		<tr>
			<td colspan="4">
				<input name="receipt_varify" class="btn1 btn1-bg-submit" type="button" id="receipt_varify"
					value="Receipt Verified" onclick="this.form.submit()" />
				<input name="limmit" type="hidden" value="" />
				
				<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>

			</td>

			<td colspan="2">
				<div class="form-group row m-0 pb-1">
					<label
						class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text">
						Total Amount:</label>
					<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
						<input name="t_amount" type="text" id="t_amount" size="15" readonly
							value="<?php echo $total_amt; ?>" />

					</div>
				</div>
				<input name="count" id="count" type="hidden" value="" />

			</td>

		</tr>
	</form>


	</tbody>

	</table>

</div>


</div>


<script>
	$(document).keypress(
		function (event) {
			if (event.which == '13') {
				event.preventDefault();
			}
		});

	function bankData(data) {

		var ledgerId = data;

		$.ajax({
			url: "bankAjax.php",
			type: "post",
			dataType: 'json',
			data: { ledgerId: ledgerId },
			success: function (data) {
				console.log(data);
				$("#r_from").val(data[0]);
			},
		});


	}
</script>

<?



require_once SERVER_CORE . "routing/layout.bottom.php";



?>