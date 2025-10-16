<?php

session_start();

//====================== EOF ===================

require_once "../../../assets/support/inc.all.php";

require "../../../engine/tools/class.numbertoword.php";





$po_no = $_REQUEST['po_no'];


if(isset($_POST['cash_discount']))

{

	$po_no = $_POST['po_no'];

	$cash_discount = $_POST['cash_discount'];

	$ssql='update purchase_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';

	mysql_query($ssql);

}



$sql1="select * from purchase_master where po_no='$po_no'";

$data=mysql_fetch_object(mysql_query($sql1));

$vendor=find_all_field('vendor','','vendor_id='.$data->vendor_id );

$concern=find_all_field('user_group','','id='.$data->group_for);

$sql_proj = "select * from project_info where 1";

$datasks = mysql_fetch_object(mysql_query($sql_proj));

//$proj_info = find_all_field('project_info','proj_name','proj_id='.$data->proj_id);
$bd_style=$data->po_date;

$wo_del_date=$data->wo_del_date;




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Work Order :.</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>
<style type="text/css">
<!--
.style4 {
	font-size: 12px;
	font-weight: bold;
}
.tabledesign {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
.tabledesign {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>
<body>
<form action="" method="post">
  <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
		<td width="20%"><p><strong><img src="../../../logo/title.png" width="100%" /></strong></p></td>
      <td align="center"><strong style="font-size:24px">
        <?=$concern->group_name?>
        <br />
        </strong><?=$concern->address?><br />
		
		<div class="header_title">
				  <div> Work Order</div>
				</div>
        </td>
      
      <td width="15%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div class="line">
          <div align="center"> </div>
      </div></td>
    </tr>
    
    <tr>
      <td colspan="3" align="left"><p class="style4" style="font-size:20px;text-align:center;"><strong><ins></ins></strong></p>
        <table width="100%" cellpadding="0">
          <tr>
            <td width="61%" valign="top"><span style="font-size:10px"><span style="font-size:20px; font-style:italic"><strong>
              <?=$vendor->vendor_name;?>
              </strong></span><br />
              <?=$vendor->address;?>
              <br />
              Attn:
              <?=$vendor->contact_person_name;?>
              <br />
              <?=$vendor->contact_person_designation;?>
              Contact No:
              <?=$vendor->contact_no;?>
              <!--, Fax No:
              <?=$vendor->
              fax_no;?>-->
              , Email:
              <?=$vendor->email;?>
              <br />
              </span></td>
            <td width="39%" valign="top"><span style="font-size:12px">&nbsp;&nbsp;<strong>&nbsp;WO No.#
              <?=$_GET['po_no']?>
              </strong> <br />
              &nbsp;&nbsp;&nbsp;WO Date:
              <?=$bd_style = date("d-m-Y")?>
              <br />
			  
			  &nbsp;&nbsp;&nbsp;Delivery Date:
              <?=$wo_del_date = date("d-m-Y")?>
              <br />
			  
			  <? if($data->quotation_no>0) {?>
              &nbsp;&nbsp;&nbsp;Quotation No:
              <?=$data->quotation_no?>
			  <br />
             <? }?>
            &nbsp;&nbsp;&nbsp;</span></td>
          </tr>
        </table>
      <br />
        </span></td>
    </tr>
    <tr>
      <td colspan="3"><div id="pr">
          <div align="left">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3"><span style="font-size:14px; font-weight:700; ">Sub:
                  <?=$data->po_subject?>
                </span></td>
              </tr>
              <tr>
                <td width="17%">&nbsp;</td>
                <td width="6%">&nbsp;</td>
                <td width="77%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
                <?php /*?><td><span class="style3">Special Cash Discount: </span></td>
                <td><label>
                  <input name="cash_discount" type="text" id="cash_discount" value="<?=$cash_discount?>" />
                  </label>
                  <input type="hidden" name="po_no" id="po_no" value="<?=$po_no?>" /></td>
                <td><label>
                  <input type="submit" name="Update" value="Update" />
                  </label></td><?php */?>
                <td>&nbsp;</td>
				<? if($data->quotation_no>0) {?>
                <td><a target="_blank" href="../../po_documents/qoutationDoc/<?=$po_no?>.pdf" style="display:inline-block; font-size:14px; font-weight:700;"> Qoutation Doc</a> </td>
				<? }?>
              </tr>
            </table>
          </div>
        </div>
        <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:800px;">
          <tr style="font-size:14px;">
            <td bgcolor="#CCCCCC" ><strong>S/L</strong></td>
            <td nowrap="nowrap" bgcolor="#CCCCCC" style="min-width:30%;"><div align="center"><strong>Description of the Goods </strong></div></td>
            <td bgcolor="#CCCCCC"><strong>Quantity</strong></td>
            <td bgcolor="#CCCCCC"><strong>Rate</strong></td>
            <td bgcolor="#CCCCCC"><strong>Amount
              
            </strong></td>
          </tr>
          <?php

$final_amt=0;

$pi=0;

$total=0;

$sql2="select * from purchase_invoice where po_no='$po_no'";

$data2=mysql_query($sql2);

//echo $sql2;

while($info=mysql_fetch_object($data2)){ 

$pi++;

$amount=$info->qty*$info->rate;

$total=$total+($info->qty*$info->rate);

$sl=$pi;

$item=find_a_field('item_info','concat(item_name,item_description)','item_id='.$info->item_id);

$fg_code = find_a_field('item_info','finish_goods_code','item_id='.$info->item_id);
$qty=$info->qty;

$unit_name=$info->unit_name;

$rate=$info->rate;
$item_del_date=$info->item_del_date;
$disc=$info->disc;

?>
          <tr>
            <td valign="top"><?=$sl?></td>
            <td align="left" valign="top"><?=$item?></td>
            <td valign="top"><?=$qty.' '.$unit_name?></td>
            <td align="right" valign="top"><?=number_format($rate,2)?></td>
            <td align="right" valign="top"><?=number_format($amount,2)?></td>
          </tr>
          <? }?>
          <tr>
            <td colspan="3"></td>
            <td align="right"><strong>Total:</strong></td>
            <td align="right"><strong><?php echo number_format($total,2);?></strong></td>
          </tr>
        </table>
        <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:800px">
		<? if($data->cash_discount>0){?>
          <tr>
            <td width="44">&nbsp;</td>
            <td colspan="2" align="right">Discount:</td>
            <td width="149" align="right"><strong>
              <? if($data->cash_discount>0) echo number_format($data->cash_discount,2); else echo '0.00';?>
              </strong></td>
          </tr>
		  <? }?>
          <? if($data->tax>0){?>
          <tr>
            <td align="right">&nbsp;</td>
            <td colspan="2" align="right">Vat(
              <?=$data->tax?>
              %):</td>
            <td align="right"><strong>
              <?  echo number_format((($total*$data->tax)/100),2);?>
              </strong></td>
          </tr>
          <? }?>
          <? if($data->tax_ait>0){?>
          <tr>
            <td align="right">&nbsp;</td>
            <td colspan="2" align="right">AIT (<?=$data->tax_ait?>%): </td>
            <td align="right"><strong> <? echo number_format((($total*$data->tax_ait)/100),2);?> </strong></td>
          </tr>
          <? }?>
          <? if($data->transport_bill>0){?>
          <tr>
            <td align="right">&nbsp;</td>
            <td colspan="2" align="right">Transport Bill: </td>
            <td align="right"><strong> <? echo number_format(($data->transport_bill),2);?> </strong></td>
          </tr>
          <? }?>
          <? if($data->labor_bill>0){?>
          <tr>
            <td align="right">&nbsp;</td>
            <td colspan="2" align="right">Labor Bill: </td>
            <td align="right"><strong> <? echo number_format(($data->labor_bill),2);?> </strong></td>
          </tr>
          <? }?>
          <tr>
            <td colspan="2" align="left">In Word: Taka
              <?

		$tax_total=(($total*$data->tax)/100);
		
		$tax_ait_total=(($total*$data->tax_ait)/100);

		$scs =  $aatotal = ($total+$tax_total+$data->transport_bill+$data->labor_bill+$tax_ait_total-$data->cash_discount);

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}

	 echo ' Only';

		?></td>
            <td width="150" align="right">Grand Total:</td>
            <td align="right"><strong> <? echo number_format(($total+$data->transport_bill+$tax_total+$data->labor_bill-$data->cash_discount),2);?> </strong></td>
          </tr>
          <tr>
            <td colspan="4" align="left"><p><strong>Terms &amp; Conditions: </strong></p>
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:10px">
                <tr>
                  <td width="20%" align="left" valign="top"><li>Buyer</li></td>
                  <td width="3%" align="right" valign="top">:</td>
                  <td align="left" valign="top"><strong>
                    <?= $datasks->proj_name;?></strong></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><li>Address</li></td>
                  <td align="right" valign="top">:</td>
                  <td align="left" valign="top"><strong>
                    <?= $datasks->proj_address;?>
                  </strong></td>
                </tr>
				<tr>
				  <td align="left" valign="top"><li>Payment Terms</li></td>
				  <td align="right" valign="top">:</td>
				  <td align="left" valign="top"><strong><?= find_a_field('payment_terms','payment_terms','terms_id='.$data->payment_terms);?></strong></td>
			    </tr>
				<tr>
                  <td align="left" valign="top"><li>Remarks</li></td>
                  <td align="right" valign="top">:</td>
                  <td align="left" valign="top"><strong>
                    <?= $data->po_details;?>
                  </strong></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="4" align="left" style="font-size:10px" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="25%" valign="top">&nbsp;</td>
                  <td width="25%" valign='top'>&nbsp;</td>
                  <td width="25%" valign='top'>&nbsp;</td>
                  <td width="25%" valign='top'>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                </tr>
				
				<tr>
                  <td align="center" valign="top"> <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" valign="top">-------------------------------</td>
                  <td valign='top' align="center">-------------------------------</td>
                  <td valign='top' align="center">-------------------------------</td>
                  <td valign='top' align="center">-------------------------------</td>
                </tr>
                <tr>
                  <td align="center" valign="top">Prepared By</td>
                  <td valign='top' align="center">Accepted By Buyer </td>
                  <td valign='top' align="center">General Manager </td>
                  <td valign='top' align="center">Approved by</td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                  <td valign='top'>&nbsp;</td>
                </tr>
				
              </table></td>
          </tr>
          <tr>
            <td colspan="4" style="border:1px solid #000; color: #000;" align="center" ><p>
				<? $data=mysql_fetch_object(mysql_query("select * from project_info limit 1"));	?>	
				<?php echo $data->proj_name ?>
				<br />
                <?php echo $data->proj_address;?>
                <br />
				Tel: <?php echo $data->proj_phone; ?>
            </td>
          </tr>
        </table></td>
    </tr>
	
	 
	
	
  </table>
</form>
</body>
</html>
