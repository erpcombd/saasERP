<?php

session_start();


//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";
//
//require_once SERVER_CORE."core/class.numbertoword.php";

require_once "../../../controllers/routing/print_view.top.php";


do_calander('#voucher_date');

$jv_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));


if(prevent_multi_submit()){

if($_POST['check']=='CHECK')

{



	$time_now = date('Y-m-d H:i:s');

	$voucher_date = $_POST['voucher_date'];

	$jv=next_journal_voucher_id();

	

	  $ssql='update secondary_journal set jv_date="'.$voucher_date.'",  checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'", checked="YES"  where jv_no="'.$jv_no.'"';

	db_query($ssql);

	

	sec_journal_journal($jv_no,$jv,'DirectPurchase');

}

}



$address=find_a_field('project_info','proj_address',"1");

$jv = find_all_field('secondary_journal','jv_date','jv_no='.$jv_no);

$ch = find_all_field('warehouse_other_receive_detail','or_no','or_no='.$jv->tr_no);


$do_commission=find_a_field('sale_do_master','cash_discount',"do_no=".$ch->do_no);



?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Voucher :.</title>

<link href="../../../../public/assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>



<link href="../../warehouse_mod/css/pagination.css" rel="stylesheet" type="text/css" />

<link href="../../warehouse_mod/css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />

<link href="../../warehouse_mod/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="../../warehouse_mod/js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/jquery-ui-1.8.2.custom.min.js"></script>



<script type="text/javascript" src="../../warehouse_mod/js/jquery.autocomplete.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/jquery.validate.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/paging.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/ddaccordion.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/js.js"></script>

<script type="text/javascript" src="../../warehouse_mod/js/jquery.ui.datepicker.js"></script>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>

<? //do_calander('#voucher_date');?>

<style type="text/css">

<!--

.style1 {

	color: #FFFFFF;

	font-weight: bold;

}


@media print {
  @page {
    margin: 10mm;
  }
  body, html {
    margin: 0 !important;
    padding: 0 !important;
  }
  #pr {
    display: none;
  }
  table {
    page-break-inside: auto;
  }
  tr, td {
    page-break-inside: avoid;
    page-break-after: auto;
  }
  .page-break {
    page-break-after: always;
  }
}

@page {
		@bottom-center {
		  content: "Page " counter(page) " of " counter(pages);
		}
  }


-->

</style>

</head>

<body>

<table width="820" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><div class="header">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="1%">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" style="width: 150px;" />		</td>

            <td width="83%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td align="center" class="title">



				<?

if($jv->group_for)

echo find_a_field('user_group','group_name','id='.$jv->group_for);

else

echo $_SESSION['proj_name'];

				?>                </td>

              </tr>

              <tr>

                <td align="center"><?=$address?></td>

              </tr>

              <tr>

                <td align="center"><table  class="debit_box" border="0" cellspacing="0" cellpadding="0">

                    <tr>

                      <td>&nbsp;</td>

                      <td width="325"><div align="center">JOURNAL VOUCHER</div></td>

                      <td>&nbsp;</td>

                    </tr>

                  </table></td>

              </tr>

            </table></td>
			<td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($jv_no); 
              $print_url = "https://saaserp.ezzy-erp.com/app/views/acc_mod/files/direct_purchase_print_view.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>

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

<? if($jv->checked!='YES'){?>

<div align="left">

<form action="" method="post">

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">

  <tr>

    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

    <td width="180" align="right"><a target="_blank" href="../../warehouse_mod/direct_purchase/chalan_view2.php?v_no=<?=rawurlencode(url_encode($ch->or_no));?>">DP-

        <?=$ch->or_no?>
    </a></td>

    <td width="120" align="right">Voucher Date :</td>

    <td width="0">



<input name="jv_no" type="hidden" value="<?=$jv_no?>" />

<input name="voucher_date" type="date" id="voucher_date" value="<?=$jv->jv_date;?>" />    </td>

    <td><? if($jv->checked=='NO' || $jv->checked==''){?><input name="check" type="submit" id="check" value="CHECK" style="font-size:12px; color:#990000" /><? }?>

        <input type="hidden" name="req_no" id="req_no" value="<?=$jv->jv_no?>" /></td>
  </tr>
</table>

</form>

<a target="_blank" href="../../warehouse_mod/pages/depot_transfer/print_view_acc.php?v_no=<?=$ch->or_no?>"></a></div><? }else{?>

<div align="left">

<form action="" method="post">

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#339900">

  <tr>

    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

    <td width="200" align="right"><a target="_blank" href="../../../warehouse_mod/pages/direct_purchase/chalan_view2.php?v_no=<?=$ch->or_no?>">DP-

        <?=$ch->or_no?>

    </a></td>

    <td width="150" align="right">&nbsp;</td>

    <td width="0"><div align="center"><span class="style1">CHECKED</span></div></td>

    <td width="120">&nbsp;</td>

    <td width="1">&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

</table>

</form>

<a target="_blank" href="../../warehouse_mod/pages/pr/chalan_view2.php?v_no=<?=$ch->or_no?>"></a></div><? }?>

</div></td>

        </tr>

      <tr>

        <td width="50%" class="tabledesign_text">Voucher Date :

          <?=find_a_field('secondary_journal','jv_date','jv_no='.$jv->jv_no);?></td>

        <td class="tabledesign_text">

          Purchase Date :

          <?=date('d-m-Y',strtotime($ch->or_date));  ?></td>

      </tr>

      <tr>

        <td class="tabledesign_text"> Voucher No  : <?=$jv_no?></td>

        <td class="tabledesign_text">Checked By :

          <? if($jv->checked=='YES') echo find_a_field('user_activity_management','fname','user_id='.$jv->checked_by); else echo 'Not Checked';?></td>

      </tr>

    </table></td>

  </tr>

  

  <tr>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td><? if($cccode>0){?>CC CODE/PROJECT NAME: <? echo find_a_field('cost_center','center_name',"id='$cccode'")?><? }?></td>

  </tr>

  <tr>

    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign" style="font-size:12px">

      <tr>

        <td align="center"><div align="center">SL</div></td>

        <td align="center">Accounts Head </td>

        <td align="center">Sub Ledger</td>
        <td align="center">Particulars</td>

        <td>Debit</td>

        <td>Credit</td>
      </tr>

      

	  <?
$ssql='select * from general_sub_ledger where 1 group by sub_ledger_id';
	  $squery=db_query($ssql);
	  while($srow=mysqli_fetch_object($squery)){
	  $sub_ledger_name_get[$srow->sub_ledger_id]=$srow->sub_ledger_name;
	  }
$sql2="SELECT a.ledger_id,a.ledger_name,sub_ledger,cr_amt,dr_amt,b.narration FROM accounts_ledger a, secondary_journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id";

$data2=db_query($sql2);

while($info=mysqli_fetch_object($data2)){		  

	  ?>

      <tr>

        <td align="left"><div align="center">

          <?=++$s;?>

        </div></td>

        <td align="left"><?=$info->ledger_id?>-<?=$info->ledger_name?> <?php if($info->ledger_id=="4014000300000000"){echo " - [ ".$do_commission."% ]";}?></td>

        <td align="left"><?=$sub_ledger_name_get[$info->sub_ledger]?></td>
        <td align="left"><?=$info->narration?></td>

        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>

        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>
        </tr>

<?php }?>

      <tr>

        <td colspan="4" align="right">Total Taka: </td>

        <td align="right"><?=number_format($ttd,2)?></td>

        <td align="right"><?=number_format($ttc,2)?></td>
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

        <td align="center" valign="bottom">................................</td>

        <td align="center" valign="bottom">................................</td>

        <td align="center" valign="bottom">................................</td>

        <td align="center" valign="bottom">................................</td>

      </tr>

      <tr>

        <td width="33%"><div align="center">Received by </div></td>

        <td width="33%"><div align="center">Prepared by </div></td>

        <td width="33%"><div align="center">Head of Accounts </div></td>

        <td width="34%"><div align="center">Approved By </div></td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

  </tr>

</table>

</body>

</html>

