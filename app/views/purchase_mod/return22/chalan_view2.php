<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require "../../support/inc.all.php";
require_once ('../../../acc_mod/pages/class.numbertoword.php');


$or_no 		= $_REQUEST['v_no'];





$datas=find_all_field('warehouse_other_receive','s','or_no='.$or_no);



$sql111="select b.*, v.vendor_name  from warehouse_other_receive b, vendor v where v.vendor_id=b.vendor_name and b.or_no = '".$or_no."'";

$data111=db_query($sql111);



$data=mysqli_fetch_object($data111);

$rec_frm=$data->vendor_name;

$requisition_from=$data->requisition_from;

$or_date=$data->or_date;





$sql1="select b.* from warehouse_other_receive_detail b where b.or_no = '".$or_no."'";

$data1=db_query($sql1);


$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;



$order_no[]=$info->order_no;

$qc_by=$info->qc_by;



$item_id[] = $info->item_id;

$rate[] = $info->rate;

$amount[] = $info->amount;
$narration[]=$info->narration;








$unit_qty[] = $info->qty;

$unit_name[] = $info->unit_name;

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Cash Memo :.</title>

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

                <td><? if($_SESSION['user']['depot']!=5){?><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">

                  <tr>

                    <td bgcolor="#FFFFCC" style="text-align:center; color:#000000; font-size:14px; font-weight:bold;"><span class="style4">	<?
//if($_SESSION['user']['group']>1)
//echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);
//else
echo $_SESSION['proj_name'];
				?>
<br />

                          <span class="style6"><?php echo $address=find_a_field('project_info','proj_address',"1");?></span></td>

                  </tr>

                  

                </table><? }else{?><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">

                  <tr>

                    <td bgcolor="#FFFFCC" style="text-align:center; color:#333333; font-size:14px; font-weight:bold;"><span class="style4">Hashem Foods Ltd. <br />

                          <span class="style6">Bhulta, Rupgonj, Narayanganj</span></span></td>

                  </tr>

                  

                </table><? }?></td>

              </tr>

              

              <tr>

                <td height="19">&nbsp;</td>

              </tr>

            </table></td>

          </tr>



        </table></td>

	    </tr>

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td>

				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">

      <tr>

        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">LOCAL PURCHASE RECEIVE </td>

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

		          <td width="40%" align="right" valign="middle">Purchase From  : </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?php echo $rec_frm;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>

		        <tr>

		          <td align="right" valign="top"> Requisition From :</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?php echo $requisition_from;?>&nbsp;</td>

                    </tr>

                  </table></td>

		        </tr>

		        

		        <tr>

                  <td align="right" valign="middle">LP Posting Information  :</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                      <tr>

                        <td>By: <?php echo find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?>/ At: <?php echo $data->entry_at;?></td>

                      </tr>

                  </table></td>

		          </tr>

		        <tr>

                  <td align="right" valign="middle">Narration   :</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                      <tr>

                        <td><?php echo $data->or_subject;?></td>

                      </tr>

                  </table></td>

		          </tr>
				  <tr>

			    <td align="right" valign="middle">Labor Bill :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                  <tr>

                    <td><strong><?php echo $data->labor_bill;?></strong></td>

                  </tr>

                </table></td>

			    </tr>

		        </table>		      </td>

			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			  <tr>

                <td align="right" valign="middle">LP No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><strong><?php echo $or_no;?></strong>&nbsp;</td>

                    </tr>

                </table></td>

			    </tr>

			  <tr>

                <td align="right" valign="middle"> LP Date</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?=date("d M, Y",strtotime($or_date))?>

                        &nbsp;</td>

                    </tr>

                </table></td>

			    </tr>

			  <tr>

			    <td align="right" valign="middle">QC By :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                  <tr>

                    <td><strong><?php echo $data->qc_by;?></strong></td>

                  </tr>

                </table></td>

			    </tr>
				<tr>

			    <td align="right" valign="middle">Chalan No :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                  <tr>

                    <td><strong><?php echo $data->chalan_no;?></strong></td>

                  </tr>

                </table></td>

			    </tr>

			  <!--<tr>

			    <td align="right" valign="middle">Chalan No  :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                  <tr>

                    <td><strong><?php echo $data->chalan_no;?></strong></td>

                  </tr>

                </table></td>

			    </tr>-->

			  

			  

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

       <tr>

        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>

        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>



        <td align="center" bgcolor="#CCCCCC"><strong>Narration</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Rec Qty</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Amount</strong></td>
        </tr>

       

<? for($i=0;$i<$pi;$i++){?>

      

      <tr>

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="left" valign="top"><?=$item_id[$i]?></td>

        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>

        <td align="left" valign="top"><?=$narration[$i]?></td>
        <td align="right" valign="top"><?=$unit_name[$i]?></td>

        <td align="right" valign="top"><?=$rate[$i]?></td>

        <td align="right" valign="top"><?=$unit_qty[$i]?></td>

        <td align="right" valign="top"><?=number_format($amount[$i],2); $t_amount = $t_amount + $amount[$i];?></td>
        </tr>

<? }?>

  <td colspan="7" align="center" valign="top"><div align="right"><strong>Total Amount: </strong></div></td>

        <td align="right" valign="top"><span class="style1">

          <?=number_format($t_amount,2);?>

        </span></td>

    </table></td>

  </tr>
  
    <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	
	
	<? if($data->tax>0){?>

        <tr>

          <td align="right">&nbsp;</td>

          <td align="right">VAT/TAX (<?=$data->tax?>%): </td>

          <td align="right"><strong>

            <? echo number_format($vat_paid=($t_amount*$data->tax)/100,2);?>

          </strong></td>

        </tr>

<? }?>
	
	
	
	<? if($data->transport_bill>0){?>

        <tr>

          <td align="right">&nbsp;</td>

          <td align="right">Transport Bill: </td>

          <td align="right"><strong>

            <? echo number_format(($data->transport_bill),2);?>

          </strong></td>

        </tr>

<? }?>

<? if($data->labor_bill>0){?>

        <tr>

          <td align="right">&nbsp;</td>

          <td align="right">Labor Bill: </td>

          <td align="right"><strong>

           <? echo number_format(($data->labor_bill),2);?>

          </strong></td>

        </tr>

<? }?>

        <tr>

          <td align="right">&nbsp;</td>

          <td align="right">Grand Total:</td>

          <td align="right"><strong>

            <? echo number_format($grand_tot_amt=($t_amount+$data->transport_bill+$tax_total+$data->labor_bill-$data->cash_discount+$vat_paid),2);?>

          </strong></td>
	
	
	
	</table>
	
	</td>
	
	</tr>
  
  
  
  
  

  <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per Terms</em></td>
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
    <td colspan="2"><span style="font-size:14px">Amount in Word : (
                <?=convertNumberMhafuz($grand_tot_amt);?>
) </span></td>
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

          <td><div align="center">Received By </div></td>

          <td><div align="center">Quality Controller </div></td>

          <td><div align="center">Store Incharge </div></td>
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

