<?php

//

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$title='DAILY CASH RECEIPTS &amp; PAYMENTS STATEMENTS';

$proj_id=$_SESSION['proj_id'];

$active='recpay';

do_calander('#fdate');
do_calander('#tdate');


$fdate=$_REQUEST['fdate'];
$tdate=$_REQUEST['tdate'];

$cash_ledger=1011000100010000;

$report_detail.='<br>Period: '.date('d-m-Y',strtotime($_REQUEST["fdate"])).' to '.date('d-m-Y',strtotime($_REQUEST["tdate"]));

?>

<style type="text/css">


.head_line_fixed {
/ Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}

</style>





<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="4"> <div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">

									<table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="22%" align="right">
		   				 Period : </td>

                                        <td width="32%"  align="left"><input name="fdate" type="text" id="fdate" size="12" style="max-width:250px;" value="<?=($_REQUEST['fdate']!='')?$_REQUEST['fdate']:date('Y-m-d')?>" />                                      </td>
                                           <td width="46%" align="left"> <input name="tdate" type="text" id="tdate" size="12" style="max-width:250px;" value="<?=($_REQUEST['tdate']!='')?$_REQUEST['tdate']:date('Y-m-d')?>"/></td>
                                      </tr>

                                      

                            

                                      <tr>

                                        <td colspan="3" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>

								    </form></div></td>
						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>

								  <tr>

									<td>

									
									<div id="reporting"><div id="grp">


<table width="100%" cellspacing="0" cellpadding="2" border="0" class="tabledesign" >

<thead>

  <?php /*?><tr style="text-transform:uppercase;">
    <th height="20" align="left"><div align="center">Received</div></th>
    <th align="left">&nbsp;</th>
    <th align="left">&nbsp;</th>
    <th height="20" align="left">&nbsp;</th>
    <th height="20" align="left">&nbsp;</th>
  </tr><?php */?>
  <tr style="text-transform:uppercase;">

    <th height="20" align="left">NAME of hEAD </th>
    <th width="14%" align="left">Voucher NO</th>
    <th width="8%" align="left">Source</th>
    <th width="34%" height="20" align="left">description</th>
    <th height="20" align="right"><div align="right">amount</div></th>
  </tr>
	</thead>
	
	<tr>

    <td width="34%" align="left">Opening Balance </td>

    <td align="left">&nbsp;</td>
    <td align="left">Opening</td>
    <td align="left">
	
	<?
	
	$sql_op="select sum(j.dr_amt-j.cr_amt) as total_opening_amt from 
accounts_ledger a, ledger_group l, journal j 
where a.ledger_group_id=l.group_id and a.ledger_id=j.ledger_id  and j.jv_date<'".$fdate."' and l.group_id in (1009,1010,1013) ";
$total_opening_amt = find_a_field_sql($sql_op);
	
	?>	</td>

    <td width="10%" align="right"><div align="right">
      <?=number_format($total_opening_amt,2);?>
    </div></td>
  </tr>
	

  

  <tr>

    <td colspan="4" align="left"></td>

    <td align="right"></td>
    </tr>
	
	
	<?
	
	
	 $tr_from_receive =" and a.tr_from in ('Receipt','Contra')";

	 $rsql		= "select a.jv_no from journal a where  a.jv_date between '$fdate' and '$tdate' and  a.ledger_id='$cash_ledger' ".$tr_from_receive." and a.dr_amt>0  order by a.jv_date,a.tr_no";

	$rquery		= db_query($rsql);
	
	$rcount     = mysqli_num_rows($rquery);

	if($rcount>0)

	{

	while($infor=mysqli_fetch_object($rquery)){

	++$cr;

	if($cr==1){$jvsr .= $infor->jv_no;}

	else{$jvsr .= ','.$infor->jv_no;}

	}

	}
	
	?>



<?
				 
  $sql2="select j.tr_no, j.jv_no, j.cr_amt as receive_amt, j.tr_from, j.narration, a.ledger_name from 
accounts_ledger a, ledger_group l, journal j 
where a.ledger_group_id=l.group_id and a.ledger_id=j.ledger_id  and j.jv_date between '".$fdate."' and '".$tdate."' and j.cr_amt>0  and j.jv_no in (".$jvsr.") and a.ledger_group_id!=1013 
order by j.tr_from, j.id";

$query2 = db_query($sql2);

$s=0;


while($data2=mysqli_fetch_object($query2)){$s++;
				 
				 
 ?>

  <tr style="text-transform: capitalize;">

    <td width="34%" align="left"><?=$data2->ledger_name?></td>

    <td align="left"><a href="general_voucher_print_view_from_journal.php?jv_no=<?=$data2->jv_no;?>" target="_blank" title="<?=$data2->tr_no?>">
      <?=$data2->tr_no?>
    </a></td>
    <td align="left"><?=$data2->tr_from?></td>
    <td align="left"><?=$data2->narration?></td>

    <td width="10%" align="right"><?=number_format($data2->receive_amt,2); $total_receive_amt +=$data2->receive_amt;?></td>
  </tr>

<? }?>
    <tr>

    <th align="right">&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th align="right" style="font-size:16px;"><strong>
    <div align="right"> TOTAL CASH RECEIVE:</div> 
    </strong></th>
    <th align="right" style="font-size:16px;"><strong>
      <div align="right">
        <?=number_format($total_cash_received = $total_receive_amt+$total_opening_amt,2);?>
      </div>
    </strong></th>
    </tr>



  <?php /*?><tr style="text-transform:uppercase;">
    <th height="20" align="left"><div align="center">Payment</div></th>
    <th align="left">&nbsp;</th>
    <th align="left">&nbsp;</th>
    <th height="20" align="left">&nbsp;</th>
    <th height="20" align="left">&nbsp;</th>
  </tr><?php */?>
  <tr style="text-transform:uppercase;">

    <th height="20" align="left">NAME of hEAD </th>
    <th width="14%" align="left">Voucher NO</th>
    <th width="8%" align="left">Source</th>
    <th width="34%" height="20" align="left">description</th>
    <th height="20" align="right"><div align="right">amount</div></th>
  </tr>
	

  

  <tr>

    <td colspan="4" align="left"></td>

    <td align="right"></td>
    </tr>
	
	
	<?
	
	
	 $tr_from_payment =" and a.tr_from in ('Payment','Purchase','Contra')";

	 $psql		= "select a.jv_no from journal a where  a.jv_date between '$fdate' and '$tdate' and  a.ledger_id='$cash_ledger' ".$tr_from_payment." and a.cr_amt>0  order by a.jv_date,a.tr_no";

	$pquery		= db_query($psql);
	
	$pcount     = mysqli_num_rows($pquery);

	if($pcount>0)

	{

	while($info=mysqli_fetch_object($pquery)){

	++$c;

	if($c==1){$jvs .= $info->jv_no;}

	else{$jvs .= ','.$info->jv_no;}

	}

	}
	
	?>



<?
				 
  $sql3="select j.tr_no, j.jv_no, j.dr_amt as payment_amt, j.tr_from, j.narration, a.ledger_name from 
accounts_ledger a, ledger_group l, journal j 
where a.ledger_group_id=l.group_id and a.ledger_id=j.ledger_id  and j.jv_date between '".$fdate."' and '".$tdate."' and j.dr_amt>0  and j.jv_no in (".$jvs.") and a.ledger_group_id!=1013 
order by j.tr_from, j.id";

$query3 = db_query($sql3);

$s=0;


while($data3=mysqli_fetch_object($query3)){$s++;
				 
				 
 ?>

  <tr style="text-transform: capitalize;">

    <td width="34%" align="left"><?=$data3->ledger_name?></td>

    <td align="left"><a href="general_voucher_print_view_from_journal.php?jv_no=<?=$data3->jv_no;?>" target="_blank" title="<?=$data3->tr_no?>">
      <?=$data3->tr_no?>
    </a></td>
    <td align="left"><?=$data3->tr_from?></td>
    <td align="left"><?=$data3->narration?></td>

    <td width="10%" align="right"><?=number_format($data3->payment_amt,2); $total_payment_amt +=$data3->payment_amt;?></td>
  </tr>

<? }?>
    <tr>

    <th align="right">&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th align="right" style="font-size:16px;"><strong>
      <div align="right"> TOTAL EXPENDITURE:</div>
    </strong></th>
    <th align="right" style="font-size:16px;"><strong>
      <div align="right">
        <?=number_format($total_payment_amt,2);?>
      </div>
    </strong></th>
    </tr>
    <tr>
      <th align="right">&nbsp;</th>
      <th align="right">&nbsp;</th>
      <th align="right">&nbsp;</th>
      <th align="right"><strong>
        <div align="right" style="font-size:16px;"> CASH IN HAND:</div>
      </strong></th>
      <th align="right" style="font-size:16px;"><strong>
        <div align="right">
          <?=number_format($total_cash_in_hand = ($total_cash_received-$total_payment_amt),2);?>
        </div>
      </strong></th>
    </tr>
	
	
	
	
  <tr style="text-transform:uppercase;">

    <th height="20" align="left">Cash POSSITION</th>
    <th width="14%" align="left">&nbsp;</th>
    <th width="8%" align="left">Source</th>
    <th width="34%" height="20" align="left">description</th>
    <th height="20" align="right"><div align="right">amount</div></th>
  </tr>
	

  

  <tr>

    <td colspan="4" align="left"></td>

    <td align="right"></td>
    </tr>
	
	
					

<?
				 
 $sql4="select l.group_name, l.group_id, a.ledger_group_id, sum(j.dr_amt-j.cr_amt) as closing_amt from 
accounts_ledger a, ledger_group l, journal j where a.ledger_group_id=l.group_id and a.ledger_id=j.ledger_id  and j.jv_date<='".$tdate."' and l.group_id in (1009,1010,1013) group by  a.ledger_group_id order by l.manual_group_code";

$query4 = db_query($sql4);

$s=0;


while($data4=mysqli_fetch_object($query4)){$s++;
				 
				 
				 ?>


	
	
	

  <tr style="font-size:16px;">

    <td width="34%" align="left"><strong><? if($data4->group_id==1009) {?>Actual <?=$data4->group_name?><? } else {  ?> <?=$data4->group_name?><? }?></strong></td>

    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>

    <td width="10%" align="right"><? if($data4->group_id==1009) {?><strong><?=number_format($data4->closing_amt,2);?><? } else {  ?> <?=number_format($data4->closing_amt,2);?><? }?></strong></td>
  </tr>

<?
 $total_closing_amt +=$data4->closing_amt;
 }?>
    <tr >

    <th align="right">&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th align="right">&nbsp;</th>
    <th align="right"  style="font-size:16px;"><strong><div align="right">TOTAL CASH BALANCE:</div></strong></th>
    <th align="right"  style="font-size:16px;"><strong> <?=number_format($total_closing_amt,2);?> </strong></th>
    </tr>
	
  <tr>
  	<td colspan="5">&nbsp;
	
	</td>
</tr>
    

  <tr>
  	<td colspan="5">
		<table width="100%" cellspacing="0" cellpadding="2" border="0" class="tabledesign" style="font-size: 16px; font-weight:700;" >
			<tr>
				<td style="border: #FFFFFF; text-transform: capitalize;">Amount In words: <?=convertNumberMhafuz($total_closing_amt)?>.</td>
			</tr>
		</table>
	
	</td>
  </tr>
  
  
  
  
  
  <tr>
    <td colspan="5">
	
	<table width="100%" cellspacing="0" cellpadding="2" border="0" class="tabledesign" >
			<tr>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  </tr>
			  <tr>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  </tr>
			  <tr>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  </tr>
			  <tr>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  </tr>
			  <tr>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  </tr>
			  <tr>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  </tr>
			  <tr>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  </tr>
			  <tr>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  <td  width="25%" style="border: #FFFFFF;">&nbsp;</td>
			  </tr>
			  <tr>
			  <td  width="25%" style="border: #FFFFFF;"><div align="center"><strong>----------------------------</strong></div></td>
			  <td  width="25%" style="border: #FFFFFF;"><div align="center"><strong>----------------------------</strong></div></td>
			  <td  width="25%" style="border: #FFFFFF;"><div align="center"><strong>----------------------------</strong></div></td>
			  <td  width="25%" style="border: #FFFFFF;"><div align="center"><strong>----------------------------</strong></div></td>
			  </tr>
			<tr>
				<td width="25%" style="border: #FFFFFF;"><div align="center"><strong>Prepaired By</strong></div></td>
				<td width="25%" style="border: #FFFFFF;"><div align="center"><strong>Cash Incharge </strong></div></td>
				<td width="25%" style="border: #FFFFFF;"><div align="center"><strong>A/C Manager </strong></div></td>
				<td width="25%" style="border: #FFFFFF;"><div align="center"><strong>Director</strong></div></td>
			</tr>
	</table>
	
	</td>
  </tr>
  

  
  
</table>





</div>
</div>		</td>
		</tr>
		</table>

		</div></td>    
  </tr>
  
  
  
  
  
  
  
  
  
</table>

<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>