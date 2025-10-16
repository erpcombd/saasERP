<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$pr_no 		= $_REQUEST['v_no'];

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

$datas=find_all_field('purchase_receive','s','pr_no='.$pr_no);

$po_ms=find_all_field('purchase_master','','po_no='.$datas->po_no);

$sql1="select b.* from purchase_receive b where b.pr_no = '".$pr_no."'";

$data1=db_query($sql1);

$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;

$rec_date=$info->rec_date;

$rec_no=$info->rec_no;

$po_no=$info->po_no;

$order_no[]=$info->order_no;

$ch_no=$info->ch_no;

$qc_by=$info->qc_by;

$entry_at=$info->entry_at;

$entry_by=$info->entry_by;

$item_id[] = $info->item_id;

$rate[] = $info->rate;

$amount[] = $info->amount;

$unit_qty[] = $info->qty;

$unit_name[] = $info->unit_name;

}
$ssql = 'select a.* from vendor a, purchase_master b where a.vendor_id=b.vendor_id and b.po_no='.$po_no;
$dealer = find_all_field_sql($ssql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cash Memo :.</title>
<link href="../../../css_js/css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">
	function hide()
	{
		document.getElementById("pr").style.display="none";
	}
</script>

<style type="text/css">
<!--
@font-face {
  font-family: 'MYRIADPRO-REGULAR';
  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */

}

@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}


@font-face {
  font-family: 'Humaira demo';
  src: url('Humaira demo.otf'); /* IE9 Compat Modes */

}

.style4 {
	font-size: 12px;
	font-weight: bold;
}

.style5 {font-weight: bold}

.style6 {font-weight: bold}

.style7 {font-weight: bold}

.style9 {font-weight: bold}

.style10 {font-weight: bold}
-->

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
</style>
</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<div id="pr">
	<h2 align="center">	<input name="button" type="button" onclick="hide();window.print();" value="Print"/></h2>
</div>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td>
		<div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">

		<tr>

	    <td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
			  <td>
				  <div class="header" style="margin-top:0;">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>

						  <td width="30%">
                       		<table  width="70%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png"  width="100%" />
									</td>
								</tr>
						  </table>

						  </td>

						  <td width="40%">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr align="center">
									  <td style="padding-bottom:3px;">
										  <h2 style="margin: 0px;"><?=$group_data->group_name?>. </h2>
									  </td>
									</tr>
							  
							  
									<tr>
										<td style="font-size:12px; line-height:20px; text-align: center;"><?=$group_data->address?></td>
									</tr>
									
									<tr>
										<td style="font-size:12px; line-height:20px; text-align: center;"><strong>Mobile No :</strong>  <?=$group_data->mobile?></td>
									</tr>
									<tr>
										<td style="font-size:12px; line-height:20px; text-align: center;"><strong>Email:</strong>  <?=$group_data->email?></td>
									</tr>

									<tr>
										<td style=" font-size:12px; line-height:20px; text-align: center;"><strong>BIN/VAT Reg. No :</strong>  <?=$group_data->vat_reg?></td>
							  		</tr>
						  </table>
						  </td>

						  <td width="30%"></td>

					  </tr>
                    </table>
				  </td>
                </tr>
              </table>
			</td>
          </tr>
        </table>
       </div></td>
          </tr>
        </table>
		</td>

	    </tr>
		
		
		
		<tr>
    <td colspan="0" align="center"><hr /></td>
  </tr>

	  

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td>

				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">

      <tr>

        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">GOODS RECEIVE NOTE </td>

      </tr>

    </table>

    <?php /*?><? 

	

	if($datas->duplicate>0){?>

				<table width="40%" border="0" align="center" cellpadding="5" cellspacing="0">

                  <tr>

                    <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">DUPLICATE COPY </td>

                  </tr>

                </table>

    <? }else{

	db_execute('update purchase_receive set duplicate=1 where pr_no='.$pr_no);

	?>

                <table width="40%" border="0" align="center" cellpadding="5" cellspacing="0">

                  <tr>

                    <td bgcolor="#999999" style="text-align:center; color:#99FF66; font-size:18px; font-weight:bold;">ORIGINAL COPY </td>

                  </tr>

                </table>

    <? }?><?php */?>

				</td>

              </tr>

            </table></td>

          </tr>



        </table></td>

	    </tr>

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

		  <tr>

		    <td width="50%">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

		        <tr>

		          <td width="33%" align="right" valign="middle"><strong>Vendor: </strong></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td  style="font-size:16px; font-weight:700"><?php echo $dealer->vendor_name;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>

		        <tr>

		          <td align="right" valign="top"><strong> Address:</strong></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td height="60" valign="top"><?php echo $dealer->address;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>
				  
				  
				  <tr>

		          <td align="right" valign="middle"><strong> Warehouse:</strong></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?= find_a_field('warehouse','warehouse_name','warehouse_id='.$datas->warehouse_id);?></td>

		              </tr>

		            </table></td>

		          </tr>

		        

		        <tr>

		          <td align="right" valign="middle"> <strong> PR Posting Time:</strong></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td> <strong>By:</strong> <?php echo find_a_field('user_activity_management','fname','user_id='.$entry_by);?>/ At: <?php echo $entry_at;?></td>

                    </tr>

                  </table></td>

		          </tr>

		        

		        </table>
			</td>

			<td width="20%"></td>

			<td width="30%">
				<table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			  <tr>

                <td align="right" valign="middle"> <strong> PR No: </strong></td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><strong><?php echo $pr_no;?></strong>&nbsp;</td>

                    </tr>

                </table></td>

			    </tr>

			  <tr>

                <td align="right" valign="middle"><strong> REC Date:</strong> </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?= date("d-m-Y",strtotime($rec_date));?>

                        &nbsp;</td>

                    </tr>

                </table></td>

			    </tr>

			  <tr>

			    <td align="right" valign="middle"><strong>PO No:</strong> </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><?php echo $po_no;?></td>

			        </tr>

			      </table></td>

			    </tr>

			  <tr>

                <td align="right" valign="middle"><strong>QC By:</strong></td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?php echo $qc_by;?>&nbsp;</td>

                    </tr>

                </table></td>

			    </tr>

			  <tr>

                <td align="right" valign="middle"><strong>Challan No:</strong></td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><strong><?php echo $ch_no;?></strong></td>

                    </tr>

                </table></td>

			    </tr>

			  </table>
			</td>

		  </tr>

		</table>
		</td>

	  </tr>

    </table>

    </div>
	</td>

  </tr>

  <tr>
	<td width="100%">	</td>
  </tr>


  <tr>

    <td>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5" style="font-size: 14px;">


       <tr bgcolor="aqua">
			<td align="center"><strong>SL</strong></td>
			<td align="center"><div align="center"><strong>Item Description</strong></div></td>
			<td align="center"><strong>Unit</strong></td>
			<td align="center"><strong>Rate</strong></td>
			<td align="center"><strong>Rec Qty</strong></td>
			<td align="center"><strong>Amount</strong></td>
        </tr>

       

<? for($i=0;$i<$pi;$i++){?>

      

      <tr>

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>

        <td align="right" valign="top"><?=find_a_field('item_info','unit_name','item_id='.$item_id[$i]);?></td>

        <td align="right" valign="top"><?=$rate[$i]?></td>

        <td align="right" valign="top"><?=$unit_qty[$i]?></td>

        <td align="right" valign="top"><?=number_format($amount[$i],2); $t_amount = $t_amount + $amount[$i];?></td>
        </tr>

<? }?>
<tr>
  <td colspan="5" align="right" valign="top">Sub Total: </td>

        <td align="right" valign="top">
          <?=number_format($t_amount,2);?>
		</td>
</tr>
		
		
		
	  <? if($po_ms->tax>0) {?>
      <tr  align="right">
        <td colspan="5">VAT (<?=number_format($po_ms->tax,2)?>%):</td>
        <td align="right">          <?  echo number_format($tax_total=(($t_amount*$po_ms->tax)/100),2);?>        </td>
      </tr>
	  <? }?>
	  
	  <? if($po_ms->ait>0) {?>
      <tr  align="right">
        <td colspan="5">AIT (<?=number_format($po_ms->ait,0)?>%):</td>
        <td align="right">          <?  echo number_format($ait_total=(($t_amount*$po_ms->ait)/100),2);?>        </td>
      </tr>
	  <? }?>
	  
	   <? if($datas->transport_charge>0) {?>
      <tr  align="right">
        <td colspan="5">Transport Charge:</td>
        <td align="right">          <?  echo number_format($transport_charge=$datas->transport_charge,2);?>        </td>
      </tr>
	  <? }?>
	  
	   <? if($datas->other_charge>0) {?>
      <tr  align="right">
        <td colspan="5">Other Charge:</td>
        <td align="right">          <?  echo number_format($other_charge=$datas->other_charge,2);?>        </td>
      </tr>
	  <? }?>

      <tr bgcolor="yellow">
        <td align="right" colspan="5"><strong>Net Amount: </strong></td>
        <td align="right"><strong><? echo number_format($payable_amount=($t_amount+$tax_total+$ait_total+$transport_charge+$other_charge),2);?></strong></td>
      </tr>

    </table>
	</td>

  </tr>

  <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td colspan="2" style="font-size:12px">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:14px">
	
	In Word: <?

		

		$scs =  $payable_amount;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa. ';}

	 echo ' Only';

		?>.	
	</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:12px">&nbsp;</td>
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
    <td>&nbsp;</td>
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

    <td>&nbsp;</td>

    <td>&nbsp;</td>
  </tr>

  <tr>

    <td colspan="2" align="center"><strong><br />

      </strong>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>

          <td width="23%"><div align="center"><?=find_a_field('user_activity_management','fname','user_id="'.$entry_by.'"');?></td>

		  <td width="23%"><div align="center"></div></td>

          <td width="25%"><div align="center"></div></td>

          <td width="29%"><div align="center"></div></td>
          </tr>
		  
		  <tr>

          <td width="23%"><div align="center">_________________</div></td>

		  <td width="23%"><div align="center">_________________</div></td>

          <td width="25%"><div align="center">_________________</div></td>

          <td width="29%"><div align="center">_________________</div></td>
          </tr>
		  <tr>

          <td width="23%"><div align="center">Received By </div></td>

		  <td width="23%"><div align="center">Quality Controller </div></td>

          <td width="25%"><div align="center">Store Manager </div></td>

          <td width="29%"><div align="center">Authorized By </div></td>
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

