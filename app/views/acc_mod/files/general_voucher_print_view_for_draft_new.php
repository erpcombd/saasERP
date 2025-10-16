<?php
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../common/class.numbertoword.php');


$jv_no=$_REQUEST['jv_no'];

$jv_all=find_all_field('secondary_journal','','jv_no='.$jv_no);


if($jv_all->tr_from=='Receipt'){$voucher_name='RECEIPT VOUCHER';$vtypes='Receipt';}

elseif($jv_all->tr_from=='Payment'){$voucher_name='PAYMENT VOUCHER';$vtypes='Payment';}

elseif($jv_all->tr_from=='Journal'){$voucher_name='JOURNAL VOUCHER';$vtypes='Journal';}

elseif($jv_all->tr_from=='Contra'){$voucher_name='CONTRA VOUCHER';$vtype='contra';$vtypes='Contra';}

elseif($jv_all->tr_from=='Sales'){$voucher_name='SALES secondary_journal';$vtypes='Sales';}

elseif($jv_all->tr_from=='Purchase'){$voucher_name='PURCHASE secondary_journal';$vtypes='Purchase';}


else{$vtype=='secondary_journal';$voucher_name='secondary_journal VOUCHER';$vtypes='secondary_journal';}



$bill_no=$_REQUEST['bill_no'];
$bill_date=$_REQUEST['bill_date'];

if($_POST['check']=='CHECK')
{
$time_now = date('Y-m-d H:i:s');
$voucher_date = $_POST['voucher_date'];
$cc_code = $_POST['cc_code'];


//$po_no = find_a_field('secondary_journal','tr_no','tr_from = "Purchase" and jv_no='.$jv_no);
//$po = find_all_field('purchase_master','po_no','po_no='.$po_no);

	//$ssql='update purchase_invoice set bill_no="'.$bill_no.'", bill_date="'.$bill_date.'" where po_no="'.$prold->po_no.'"';
	//db_query($ssql);
	
	
    //$narration = 'Sale#'.$po->sale_no.'/ PO#'.$po->po_no.' (Bill#'.$bill_no.'/ Dt:'.$bill_date.')';
	
	$ssql='update secondary_journal set  secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where tr_from = "'.$jv_all->tr_from.'" and jv_no="'.$jv_no.'"';
	db_query($ssql);

$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$jv_all->tr_from.'"');

if($jv_config=="Yes"){

sec_journal_journal($jv_no,$jv_no,$jv_all->tr_from);

$time_now = date('Y-m-d H:i:s');

$up2='update secondary_journal set checked="YES", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$jv_all->tr_from.'"';

db_query($up2);

$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$jv_all->tr_from.'"';
db_query($sa_up2);


}


}


if($_POST['check']=='RE-CHECK')
{
$time_now = date('Y-m-d H:i:s');
$voucher_date = strtotime($_POST['voucher_date']);
$cc_code = $_POST['cc_code'];


$jvold = find_a_field('secondary_journal','tr_id','tr_from = "Purchase" and jv_no='.$jv_no);
$prold = find_all_field('purchase_invoice','po_no','id='.$jvold);

	$ssql='update purchase_invoice set bill_no="'.$bill_no.'", bill_date="'.$bill_date.'" where po_no="'.$prold->po_no.'"';
	db_query($ssql);
	
	$narration = 'GR#'.$prold->id.'/'.$prold->po_no.'(PO#'.$prold->po_no.')(Bill#'.$bill_no.'/Dt:'.$bill_date.')';
	$ssql='update secondary_journal set narration="'.$narration.'",jv_date="'.$voucher_date.'", cc_code="'.
	$cc_code.'", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'", checked="YES" , 	final_jv_no="'.$jv.'" where tr_from = "Purchase" and jv_no="'.$jv_no.'"';
	db_query($ssql);
	$sssql = 'delete from secondary_journal where group_for="'.$_SESSION['user']['group'].'" and tr_from ="Purchase" and tr_no="'.$prold->po_no.'"';
	db_query($sssql);
	$jv=next_secondary_journal_voucher_id();
	sec_secondary_journal_secondary_journal($jv_no,$jv,'Purchase');
}

$address=find_a_field('project_info','proj_address',"1");
$jv = find_all_field('secondary_journal','jv_date','jv_no='.$jv_no);

$cccode = $jv->cc_code;


	$req_bar_no = $jv->tr_no;
	$barcode_content = $req_bar_no;
	$barcodeText = $barcode_content;
    $barcodeType='code128';
	$barcodeDisplay='horizontal';
    $barcodeSize=40;
    $printText='';

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../../../assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>

<link href="../../css_js/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="../../css_js/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css_js/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../css_js/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../css_js/js/jquery-ui-1.8.2.custom.min.js"></script>

<script type="text/javascript" src="../../css_js/js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../css_js/js/jquery.validate.js"></script>
<script type="text/javascript" src="../../css_js/js/paging.js"></script>
<script type="text/javascript" src="../../css_js/js/ddaccordion.js"></script>
<script type="text/javascript" src="../../css_js/js/js.js"></script>
<script type="text/javascript" src="../../css_js/js/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
function hide()
{
    //document.getElementById("pr").style.display="none";
}
function DoNav(theUrl)
{
	var URL = 'unchecked_voucher_view_popup_purchase.php?'+theUrl;
	popUp(URL);
}

function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>

<!--<style>
.jvbutton {
    display: block;
	float:left;
    width: auto;
    height: 25px;
    background: #4E9CAF;
    padding: 5px 20px 5px 20px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    line-height: 25px;
	margin-right: 20px;
}

.jvbutton:hover {

    color: #000000;
    font-weight: bold;
}

#pr input[type="button"] {
    width: 70px;
    height: 25px;
    background-color: #6cff36;
    color: #333;
    font-weight: bolder;
    border-radius: 5px;
    border: 1px solid #333;
    cursor: pointer;
}
</style>-->
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php"); ?>

<style>

.header-one .row .right {
    width: 50%;
    float: right;
    padding-right: 0px;
    padding-left: 20%;
}

.header-one .row .left {
    width: 50%;
    float: left;
    padding-left: 0px;
    padding-right: 20%;
}

.left .left-text, .right .right-text {
    font-weight: bold;
     border: none !important; 
    margin: 0px;
    padding: 2px;
}
.hr {
    color: black;
    border: 1px solid black;
}

.font-b{
    font-weight: 500;
}

.new-color{
    background-color: #009d4d;
    color: #ffffff;
    font-weight: 500;
}
.new-color th{
	font-weight:500;
}
.new_text_color{
 	text-align: center; 
	color: #009d4d;
 }
 
 .att{
 color:#bb0909;
 }
</style>




<?php if($cid == 'golden' || $cid == 'demo-golden' || $cid == 'mamun'  ){?>
<style>
	.footer1{
		position: relative;
		width: 100%;
	}
	
	@media print {
		.footer1 {
			margin-top:50px;
/*			position: fixed;
			bottom: 0;
			width: 100%;*/
			page-break-after:avoid;
			position: relative;
			width: 100%;
		}
	}
	
</style>

 <? } else{?>
 
  <? } ?>


	

<? do_calander('#voucher_date');?>
<? do_calander('#bill_date');?>
</head>
<body>



<form action="" method="post">

<div class="body">
	<div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
<?php /*?>			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/><?php */?>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> 
						<?
							if($_SESSION['user']['group']>0)
							echo find_a_field('user_group','group_name',"id=".$jv->group_for);
							else
							echo $_SESSION['proj_name'];
						?>
				</h2>
				<p class="text"><?
					if($_SESSION['user']['group']>0)
							echo find_a_field('user_group','address',"id=".$jv->group_for);
							else  ;
				
				?></p>
<!--				<p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?></p>-->

		</td>
		
		
		<td class="Qrl_code">
<?php /*?>					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?php echo $jv->tr_no?></p><?php */?>
		</td>
		
		</tr>
		 
		</table>
			
		<h5 class="new_text_color"><?=$jv_all->type;?> <span> <?=$voucher_name?></span></h5>
		<h5 class="new_text_color"><span> <?=$jv_all->manual_voucher_no?> <span> </span></h5>
			<hr class="hr">
	</div>
	
	
	
	<div class="header-one">
	
	<?php if($jv_all->type == CASH){ ?> 
	
	<table width="100%">
		<tr>
			<td width="10%"></td>
			<td width="35%"></td>
			<td width="25%"></td>
			<td width="25%"></td>
		</tr>
		
		<tr>
			<td class="font-b" width="10%">Voucher No</td>
			<td width="35%">: <?=$jv_no?> </td>
			<td width="25%"></td>
			<td width="25%"></td>
		</tr>
		
		<tr>
			<td class="font-b" width="10%">Voucher Date</td>
			<td width="35%">: <?php echo date('d-m-Y',strtotime($jv->jv_date));?></td>
			<td width="25%"></td>
			<td width="25%"></td>
		</tr>

		
		<tr>
			<td class="font-b" width="10%">Payee</td>
			<td width="35%">: <?= $jv_all->received_from?></td>
			<td width="25%"></td>
			<td width="25%"></td>
		</tr>
		
	</table>
	
	<? } elseif($jv_all->type == BANK){?>
	
	<table width="100%">
		<tr>
			<td width="10%"></td>
			<td width="20%"></td>
			<td width="40%"></td>
			<td width="10%"></td>
			<td width="20%"></td>
		</tr>
		
		<tr>
			<td class="font-b" >Voucher No</td>
			<td >: <?=$jv_no?> </td>
			<td></td>
			<td class="font-b" >Bank Name</td>
			<td>: <?=find_a_field('accounts_ledger','ledger_name','ledger_id='.$jv_all->relavent_cash_head);?></td>
		</tr>
		
		<tr>
			<td class="font-b">Voucher Date</td>
			<td>: <?php echo date('d-m-Y',strtotime($jv->jv_date));?></td>
			<td></td>
			<td class="font-b">Cheque No </td>
			<td>: <?= $jv_all->cheq_no?></td>
		</tr>

		
		<tr>
			<td class="font-b"></td>
			<td></td>
			<td></td>
			<td class="font-b">Cheque Date</td>
			<td>: <?= $jv_all->cheq_date?></td>
		</tr>
		
	</table>
	
	
	
	<? } else{ ?>
		<table width="100%">
		<tr>
			<td width="10%"></td>
			<td width="35%"></td>
			<td width="25%"></td>
			<td width="25%"></td>
		</tr>
		
		<tr>
			<td class="font-b" width="10%">Voucher No</td>
			<td width="35%">: <?=$jv_no?> </td>
			<td width="25%"></td>
			<td width="25%"></td>
		</tr>
		
		<tr>
			<td class="font-b" width="10%">Voucher Date</td>
			<td width="35%">: <?php echo date('d-m-Y',strtotime($jv->jv_date));?></td>
			<td width="25%"></td>
			<td width="25%"></td>
		</tr>

		
	</table>
	
	<? } ?>
</div>


<div class="main-content pt-3">
	
	
	<div id="pr">
        <div align="left">
         	 <p> <input name="button" type="button" onclick="hide();window.print();" value="Print"> </p>    
		</div>
		
			<?php /*?>
			<? if($jv->secondary_approval!='Yes'){?>
			<div align="left">
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
			  <tr>
				<td width="45"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
				<td width="162" align="right">
				<? if($jv->tr_from=='Sales'){?>
				<a target="_blank" href="../../../sales_mod/pages/direct_sales/sales_invoice_new.php?v_no=<?=$jv->tr_no;?>">Invoice# <?=$jv->tr_no;?> </a>	
				<? }?>
				</td>
				<td width="160" align="right">Voucher Date :</td>
				<td width="342">
			
			<input name="jv_no" type="hidden" value="<?=$jv_no?>" />
			<input name="voucher_date" type="text" id="voucher_date" value="<?=$jv->jv_date;?>" />
			<!--<input type="button" name="Submit" value="EDIT VOUCHER"  onclick="DoNav('<?php echo '&v_no='.$jv_no.'&view=Show' ?>');" />--></td>
				<td width="111"><input name="check" type="submit" id="check" value="CHECK" />
					<input type="hidden" name="req_no" id="req_no" value="<?=$jv->jv_on?>" /></td>
			  </tr>
			</table>
			
			<a target="_blank" href="chalan_view2.php?v_no=<?=$pr->po_no?>"></a></div><? }else{?><?php */?>
			
			<div align="left">
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#00CC00">
			  <tr>
				<td width="51" bgcolor="#82D8CF">
			<!--        <input name="button" type="button" onclick="hide();window.print();" value="Print" />-->
				</td>
				<td width="670" align="right" bgcolor="#82D8CF">
					</td>
				<td width="22" bgcolor="#82D8CF">
			
			<input name="jv_no" type="hidden" value="<?=$jv_no?>" />
			<input name="voucher_date" type="hidden" id="voucher_date" value="<?=$jv->jv_date;?>" />
			<!--<input type="button" name="Submit" value="EDIT VOUCHER"  onclick="DoNav('<?php echo '&v_no='.$jv_no.'&view=Show' ?>');" />--></td>
				<td width="85" bgcolor="#82D8CF"><input name="check" type="hidden" id="check" value="RE-CHECK" />
					<input type="hidden" name="req_no" id="req_no" value="<?=$jv->jv_on?>" /></td>
			  </tr>
			</table>
			
			<a target="_blank" href="chalan_view2.php?v_no=<?=$pr->po_no?>"></a></div><?php /*?><?}?><?php */?>
	</div>
	  
	    <?php /*?><tr style="font-size:14px">
    <td><? if($cccode>0){?>
      <strong>CC CODE:</strong> <? echo find_a_field('cost_center','center_name',"id='$cccode'")?><? }?></td>
  </tr><?php */?>
	  
	<table class="table1">
		<thead>
			<tr >
				<th>SL #</th>
				<!--<th>GL Code</th>-->
				<th> Ledger Name</th>
	<!--			<th>Cost Center</th>-->
				<th>Narration</th>
				<th>Debit (TK)</th>
				<th>Credit (TK)</th>
			</tr>
		</thead>
       
		<tbody>
      
	  <?
 $sql2="SELECT a.ledger_id,a.ledger_name,sum(dr_amt) as dr_amt, a.ledger_group_id, b.narration, b.bank,b.branch,b.remarks, b.reference_id, b.cc_code FROM accounts_ledger a, secondary_journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no=$jv_no and dr_amt>0 group by b.id order by dr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){		  
	  ?>
      <tr>
        <td align="center"><?=++$s;?></td>
        <?php /*?><td align="left"><?=$info->ledger_id?></td><?php */?>
        <td align="left"><?=$info->ledger_name?></td>
<?php /*?>        <td align="left"><?=find_a_field('cost_center','center_name','id='.$info->cc_code);?></td><?php */?>

        <?php if ($jv_all->tr_from=='Payment' && $jv_all->type=='BANK') {?>
        	<td align="left"><?=$info->narration;?>, Bank Name :<?=$info->bank;?>, Branch Name :<?=$info->branch;?>, :<?=$info->remarks;?></td>
		<? }  
		elseif ($jv_all->tr_from=='Receipt' && $jv_all->type=='BANK') {?>
		<td align="left"><?=$info->narration;?></td>
		<? }
		elseif ($jv_all->tr_from=='Receipt' && $jv_all->type=='CASH') {?>
		<td align="left"><?=$info->narration;?></td>
		<? }
		else {?>
		<td align="left"><?=$info->narration;?> : <?=$info->remarks;?></td>
		<? } ?>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>
<?
 $sql2="SELECT a.ledger_id,a.ledger_name,sum(cr_amt) as cr_amt, a.ledger_group_id, b.narration, b.bank, b.branch,b.remarks, b.reference_id, b.cc_code FROM accounts_ledger a, secondary_journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and jv_no=$jv_no and cr_amt>0 group by b.id order by cr_amt desc";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){		  
	  ?>
      <tr>
        <td align="center"><?=++$s;?></td>
 <?php /*?>       <td align="left"><?=$info->ledger_id?></td><?php */?>
        <td align="left"><?=$info->ledger_name?></td>
<?php /*?>        <td align="left"><?=find_a_field('cost_center','center_name','id='.$info->cc_code);?></td><?php */?>
        <?php if ($jv_all->tr_from=='Receipt' && $jv_all->type=='BANK') {?>
        	<td align="left"><?=$info->narration;?>, Bank Name :<?=$info->bank;?>, Branch Name :<?=$info->branch;?>, :<?=$info->remarks;?></td>
		<? } 
		elseif ($jv_all->tr_from=='Payment' && $jv_all->type=='BANK') {?>
		<td align="left"><?=$info->narration;?></td>
		<? } 
		elseif ($jv_all->tr_from=='Receipt' && $jv_all->type=='CASH') {?>
		<td align="left"><?=$info->narration;?>: <?=$info->remarks;?></td>
		<? }
		else {?>
		<td align="left"><?=$info->narration;?></td>
		<? } ?>
        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>
        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>
<?php }?>



      

			  <tr>
				<td align="right" colspan="3" class="font-b">Total Amount(Tk):</td>
				<td align="right"  class="font-b att"><?=number_format($ttd,2)?></td>
				<td align="right" class="font-b att"><?=number_format($ttc,2)?></td>
			  </tr>
			  
		
			</tbody>
		
    </table>
	

	<p class="p bold">In Words (BDT): <span> <? echo convertNumberMhafuz($ttc)?>.</span>	
	
	
	
	
		
<?php /*?>		<? $scs =  $ttc;
					$credit_amt = explode('.',$scs);
		 if($credit_amt[0]>0){
		  echo convertNumberToWordsForIndia($credit_amt[0]);}
			 if($credit_amt[1]>0){
			 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
			 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';
								 }
		  echo ' Only.';
		?> <?php */?>
		
		</p>
		<br />
		<p class="p bold">Narration: <span> <?= $jv->remarks?>.</span></p>
		<br /><br />

</div>





<div class="footer footer1"  id="footer">
	<table class="footer-table">
        <tr>
          <td colspan="6">&nbsp;</td>
        </tr>
		
		 <tr>
          <td class="text-center"><strong>Prepared By</strong><br />
		  --------------------------</td>
          <td class="text-center"><strong>Receipt By</strong><br />
		  ------------------------</td>
          <td class="text-center"><strong>Checked By</strong><br />
		  -------------------------</td>
          <td class="text-center"><strong> Approved By</strong><br />
		  -------------------------</td>
          <td class="text-center"><strong>Authorized By</strong><br />
		  ------------------------</td>
        </tr>

        <tr>
		
          <td class="text-center">
		  <?php /*?><p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$jv->entry_by);?> </p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$jv->entry_by);?>) <br/> <?=$jv->entry_at?></p><?php */?>		  </td>
          <td class="text-center">&nbsp;</td>
          <td class="text-center">
		  <?php /*?><p style="font-weight:600; margin: 0;"> <?=find_a_field('user_activity_management','fname','user_id='.$jv->om_checked);?></p>
		  <p style="font-size:11px; margin: 0;">(<?=find_a_field('user_activity_management','designation','user_id='.$jv->om_checked);?>) <br/> <?=$jv->om_checked_at?></p><?php */?>		  </td>
          <td class="text-center">&nbsp;</td>
          <td class="text-center">&nbsp;</td>
        </tr>
	</table>
	<br />
			<?php include("../../../assets/template/report_print_buttom_content_new_mamun.php");?>

    </div>
	  
	  
	  
</div>
</form>

</body>
</html>
