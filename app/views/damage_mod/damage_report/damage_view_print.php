<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require "../../support/inc.all.php";



if($_REQUEST['req_no']>0)

$or_no 		= $_REQUEST['req_no'];



elseif($_REQUEST['v_no']>0)

$or_no 		= $_REQUEST['v_no'];



$datas=find_all_field('sales_damage_receive_master','s','or_no='.$or_no);

$dealer = find_all_field('dealer_info','s','dealer_code='.$datas->vendor_id);

$sql1="select b.* from sales_damage_receive_master b where b.or_no = '".$or_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$rec_frm=$info->vendor_name;

$vendor_name=$info->vendor_name;

$vendor_id=$info->vendor_id;

$or_subject=$info->or_subject;
$manual_or_no=$info->manual_or_no;
$or_date=$info->or_date;
$approved_by=$info->approved_by;
}



$sql1="select b.* from sales_damage_receive_detail b where b.or_no = '".$or_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;



$order_no[]=$info->order_no;

$qc_by=$info->qc_by;

$receive_type[]=$info->receive_type;

$item_id[] = $info->item_id;

$rate[] = $info->rate;

$amount[] = $info->amount;









$unit_qty[] = $info->qty;

$unit_name[] = $info->unit_name;

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Sales Return  Report :.</title>

<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>

<style type="text/css">

<!--

.style1 {font-weight: bold}

-->

</style>

</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><div class="header">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td>

				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">

      <tr>

        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">Sales Damage Return </td>

      </tr>

    </table></td>

              </tr>

            </table></td>

          </tr>



        </table></td>

	    </tr>

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

		        <tr>

		          <td width="40%" align="right" valign="middle">Dealer Name : </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?php echo $dealer->dealer_name_e;?> - &nbsp;<?php echo $dealer->manual_code;?>(<?=$dealer->product_group?>)</td>

		              </tr>

		            </table></td>

		          </tr>

		        

		        

		        <tr>

                  <td align="right" valign="middle"> Address :</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                      <tr>

                        <td><?=$dealer->address_e.'<br>Mobile: '.$dealer->mobile_no?>&nbsp;</td>

                      </tr>

                  </table></td>

		          </tr>
				<?php /*?><tr>

		          <td align="right" valign="middle"> DRN :</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?php echo $manual_or_no;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr><?php */?>
		        <tr>

		          <td align="right" valign="middle"> Note :</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?php echo $or_subject;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>

		        </table>		      </td>

			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			  <tr>

                <td width="38%" align="right" valign="middle">SDR No :</td>

			    <td width="62%"><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><strong><?php echo $or_no;?></strong>&nbsp;</td>

                    </tr>

                </table></td>

			    </tr>

			  <tr>

                <td align="right" valign="middle"> SDR Date :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?=date("d M, Y",strtotime($or_date))?>

                        &nbsp;</td>

                    </tr>

                </table></td>

			    </tr>

				<tr>

                  <td align="right" valign="middle"> Received By :</td>

				  <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                      <tr>

                        <td><?php echo $approved_by;?></td>

                      </tr>

                  </table></td>

				  </tr>

				<tr>

                <td align="right" valign="middle">DRN:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?php echo $datas->manual_or_no;?>&nbsp;</td>

                    </tr>

                </table></td>

			    </tr>



			  </table></td>

		  </tr>

		</table>		</td>

	  </tr>

    </table>

    </div></td>

  </tr>

  <tr>

    

	<td>	</td>

  </tr>

  

  <tr>

    <td>

      <div id="pr">

  <div align="left">

<input name="button" type="button" onclick="hide();window.print();" value="Print" />

  </div>

</div>

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">

       <tr style="font-size:13px;">

        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Payable</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>FG Type</strong></td>

        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>



        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong> Qty</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Payable Amt</strong></td>

        </tr>

       

<? for($i=0;$i<$pi;$i++){

$item_info = find_all_field('item_info','item_name','item_id='.$item_id[$i]);

$damage_cause = find_all_field('damage_cause','damage_cause','id='.$receive_type[$i]);

?>

      

      <tr style="font-size:12px;">

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="left" valign="top"><?=$damage_cause->payable;?></td>

        <td align="left" valign="top"><?=$damage_cause->damage_cause;?></td>

        <td align="left" valign="top"><?=$item_info->item_name.'('.$item_info->finish_goods_code.')';?></td>

        <td align="right" valign="top"><?=$unit_name[$i]?></td>

        <td align="right" valign="top"><?=$rate[$i]?></td>

        <td align="right" valign="top"><?=$unit_qty[$i]?></td>

        <td align="right" valign="top"><? if($damage_cause->payable=='Yes'){echo $amount[$i]; $t_amount = $t_amount + $amount[$i];} else echo '0.00';?></td>

        </tr>

<? }?>

  <tr style="font-size:14px;"><td colspan="7" align="center" valign="top"><div align="right"><strong>Total Amount: </strong></div></td>

        <td align="right" valign="top"><span class="style1">

          <?=number_format($t_amount,2)?>

        </span></td></tr>

    </table></td>

  </tr>

  <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2" style="font-size:12px"><em>All goods are checked and confirmed as per Terms.</em></td>

    </tr>

  <tr>

    <td width="50%">&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td colspan="2" align="center"><strong><br />

      </strong>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
			<td><div align="center">Prepared By</div></td>

          <td><div align="center">Received By </div></td>

          <td><div align="center">Checked By</div></td>

          <td><div align="center">Approved By </div></td>

          </tr>

      </table></td>

    </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

    </table>

    <div class="footer1"> </div>

    </td>

  </tr>

</table>

</body>

</html>

