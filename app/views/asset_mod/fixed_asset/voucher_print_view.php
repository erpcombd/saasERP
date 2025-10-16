<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$jv_no=$_REQUEST['jv_no'];

$jv_all=find_all_field('journal','','jv_no='.$jv_no);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Voucher :.</title>



<style>

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

</style>

</head>

<body><form action="" method="post">

<table width="820" border="0" cellspacing="0" cellpadding="0" align="center">

<tr>

<td><div class="header">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>


<td width="83%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td align="center" class="title">

<?

//if($_SESSION['user']['group']>0)

echo find_a_field('user_group','group_name',"id=".$jv_all->group_for);

//else

//echo $_SESSION['proj_name'];

?>                </td>

</tr>

<!--<tr>-->

<!--  <td align="center"><?=$address?></td>-->

<!--</tr>-->

<tr>

<td align="center"><table  class="debit_box" border="0" cellspacing="0" cellpadding="0">

<tr>

<td>&nbsp;</td>

<td width="325"><div align="center"><?=$voucher_name?></div></td>

<td>&nbsp;</td>

</tr>

</table></td>

</tr>

</table></td>

</tr>

</table></td>

</tr>

<tr>

<td>&nbsp;</td>

</tr>

</table>

</div></td>

</tr>

<tr>

<td>	</td>

</tr>

<tr>

<td><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td colspan="2" class="tabledesign_text">

<div id="pr">

<? //if($jv->checked!='YES'){?>
</td>

</tr>

<tr>

<td class="tabledesign_text">Voucher Date :

<?php echo date('d-m-Y',strtotime($jv_all->jv_date));?></td>

<td class="tabledesign_text">

TR From:

<?=$jv_all->tr_from;?></td>

</tr>

<tr>

<td class="tabledesign_text">Voucher No  :

<?=$jv_no?></td>

<td class="tabledesign_text">TR No  :

<?=$jv_all->tr_no;?></td>

</tr>

</table></td>

</tr>

<tr style="font-size:14px">

<td>&nbsp;</td>

</tr>

<tr style="font-size:14px">

<td><strong>Remarks: </strong><?=$jv_all->remarks?></td>

</tr>

<?php /*?><tr style="font-size:14px">

<td><? if($cccode>0){?>

<strong>CC CODE:</strong> <? echo find_a_field('cost_center','center_name',"id='$cccode'")?><? }?></td>

</tr><?php */?>

<tr>

<td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign">

<tr>

<td align="center" bgcolor="#82D8CF"><div align="center"><strong>SL</strong></div></td>

<td align="center" bgcolor="#82D8CF"><strong>GL Code </strong></td>

<td align="center" bgcolor="#82D8CF"><strong>GL Name </strong></td>

<td align="center" bgcolor="#82D8CF">Sub Ledger</td>

<td align="center" bgcolor="#82D8CF">Cost Center </td>

<td align="center" bgcolor="#82D8CF"><strong>Narration</strong></td>

<td bgcolor="#82D8CF"><strong>Debit</strong></td>

<td bgcolor="#82D8CF"><strong>Credit</strong></td>

</tr>

<?

 $sql2="SELECT a.ledger_id,a.ledger_name,b.sub_ledger,sum(dr_amt) as dr_amt,sum(cr_amt) as cr_amt, a.ledger_group_id, b.narration, b.reference_id, b.cc_code 

FROM  journal b 

left join accounts_ledger a

on a.ledger_id=b.ledger_id

where b.jv_no='$jv_no'  and jv_no=$jv_no group by b.id 

order by b.id";

$data2=db_query($sql2);

while($info=mysqli_fetch_object($data2)){

$sub_ledger = find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$info->sub_ledger.'"');	  

$cc_code=find_a_field('cost_center','center_name','id='.$info->cc_code);

?>

<tr>

<td align="left"><div align="center">

<?=++$s;

?>

</div></td>

<td align="left"><?=$info->ledger_id?>		</td>

<td align="left"><?=$info->ledger_name?></td>

<td align="left"><?=$info->sub_ledger.'-'.$sub_ledger?></td>

<td align="left"><?=$cc_code;?></td>

<td align="left"><?=$info->narration?></td>

<td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>

<td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>

</tr>

<?php }?>

<tr>

<td colspan="6" align="right"><strong>Total : </strong></td>

<td align="right"><strong>

<?=number_format($ttd,2)?>

</strong></td>

<td align="right"><strong>

<?=number_format($ttc,2)?>

</strong></td>

</tr>

</table></td>

</tr>

<tr>

<td>&nbsp;</td>

</tr>

<tr>

<td>Amount in Word : 

(<? echo convertNumberMhafuz($ttc)?>)	 </td>

</tr>

<tr>

<td>&nbsp;</td>

</tr>

<tr>

<td>&nbsp;</td>

</tr>

<tr>

<td>&nbsp;</td>

</tr>

<tr>

<td class="tabledesign_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td align="center" valign="bottom"><? if($jv_all->entry_by!='') echo find_a_field('user_activity_management','fname','user_id='.$jv_all->entry_by);
													else echo find_a_field('user_activity_management','fname','user_id='.$jv_all->user_id);
													
													echo '<br>';
													
													echo $jv_all->entry_at;
													
													?></td>
<? if($jv_all->checked_by>0){?>
<td align="center" valign="bottom"><?=find_a_field('user_activity_management','fname','user_id='.$jv_all->checked_by);?></br><?=find_a_field('user_activity_management','designation','user_id='.$jv_all->checked_by);

echo '<br>';
													
													echo $jv_all->checked_at;

?></td>
<? }else{?>
<td></td>
<? } ?>

<td align="center" valign="bottom">&nbsp;</td>

<td align="center" valign="bottom">&nbsp;</td>

</tr>

<tr>

<td align="center" valign="bottom">................................</td>

<td align="center" valign="bottom">................................</td>

<td align="center" valign="bottom">................................</td>

<td align="center" valign="bottom">................................</td>

</tr>

<tr>

<td width="33%"><div align="center">Prepared by </div></td>

<td width="33%"><div align="center">Checked by </div></td>

<td width="33%"><div align="center">Head of Accounts </div></td>

<td width="34%"><div align="center">Approved By </div></td>

</tr>

</table></td>

</tr>

<tr>

<td>&nbsp;</td>

</tr>

</table>

</form>

</body>

</html>



