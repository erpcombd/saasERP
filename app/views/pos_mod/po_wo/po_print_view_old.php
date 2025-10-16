<?php
session_start();
//====================== EOF ===================
require_once "../../../assets/support/inc.all.php";
require "../../../engine/tools/class.numbertoword.php";


$po_no		= $_REQUEST['po_no'];

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
$whouse=find_all_field('warehouse','','warehouse_id='.$data->warehouse_id);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Purchase Order :.</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style3 {font-size: 14}
.style4 {
	font-size: 12px;
	font-weight: bold;
}
-->
</style></head>
<body>
<form action="" method="post">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center"><strong style="font-size:24px"><?=$whouse->company_name?><br /></strong>
    Shezan point, 2 Indira Road, Farmgate, Dhaka-1215. Phone: 02-8150237-8, Fax: 02-8124839<br />
    <strong><font style="font-size:20px">Work/Purchase Order</font></strong></td>
  </tr>
  <tr>
    
	<td>	<div align="center"><span class="style4">VAT REG NO: 21081001312 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Area Code: 210204 </span><br />
	  </div></td>
  </tr>
  <tr>
    <td><div class="line">
      <div align="center">
      </div>
    </div></td>
  </tr>
  <tr>
    <td><p><span style="font-size:10px">
    	</span></p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top"><span style="font-size:10px"><span style="font-size:20px; font-style:italic"><strong>
            <?=$vendor->vendor_name;?>
          </strong></span><br />

<?=$vendor->address;?>
<br />
Attn:
<?=$vendor->contact_person_name;?>
<br />
<?=$vendor->contact_person_designation;?>, Contact No:<?=$vendor->contact_no;?>, Fax No:<?=$vendor->fax_no;?>, Email:<?=$vendor->email;?><br />
          </span></td>
          <td valign="top"><span style="font-size:10px">&nbsp;&nbsp;&nbsp;P O No.#
              <?=$_GET['po_no']?>
              <br />
              &nbsp;&nbsp;&nbsp;PO Date:
              <?=$data->po_date?>
              <br />
&nbsp;&nbsp;&nbsp;P. Requisition:
<?=$data->req_no?><br />
&nbsp;&nbsp;&nbsp;Note:
<?=$data->po_details?>
          </span></td>
        </tr>
      </table>   <br />
      Dear Sir/Madam,<br />
        In reference to your quotation ref no: <? if($data->quotation_no=='') echo 'NIL'; else echo $data->quotation_no;?> Dated at : <? if($data->quotation_date=='') echo 'NIL'; else echo $data->quotation_date;?>        , we are pleased to issue this work order for the following demanded items:<br />
</span>
        <span class="debit_box">
        </div>
    </span></td>
  </tr>
  <tr>
    <td><div id="pr">
      <div align="left">
        
          <table width="60%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
          <td><span class="style3">Special Cash Discount: </span></td>
          <td><label>
            <input name="cash_discount" type="text" id="cash_discount" value="<?=$cash_discount?>" />
            </label>
            <input type="hidden" name="po_no" id="po_no" value="<?=$po_no?>" /></td>
          <td><label>
            <input type="submit" name="Update" value="Update" />
          </label></td>
        </tr>
      </table>
        
      </div>
    </div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="8%"><strong>SL/No</strong></td>
        <td width="54%"><div align="center"><strong>Description of the Goods </strong></div></td>
        <td width="9%"><strong>Qty.</strong></td>
        <td width="15%"><strong>Unit Price </strong></td>
        <td width="14%"><strong>Total Price </strong></td>
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
$item=find_a_field('item_info','concat(item_name," : ",	item_description,"-",item_origin)','item_id='.$info->item_id);
$qty=$info->qty;
$unit_name=$info->unit_name;
$rate=$info->rate;
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
        <td align="right">Total:</td>
        <td align="right"><strong><?php echo number_format($total,2);?></strong></td>
      </tr>
    </table>
      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
		<td>In Word: Taka <?
		$tax_total=(($total*$data->tax)/100);
		$scs =  $aatotal = ($total+$tax_total+$data->transport_bill+$data->labor_bill-$data->cash_discount);
			 $credit_amt = explode('.',$scs);
	 if($credit_amt[0]>0){
	 
	 echo convertNumberToWordsForIndia($credit_amt[0]);}
	 if($credit_amt[1]>0){
	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}
	 echo ' Only';
		?></td>
          <td align="right">Discount:</td>
          <td align="right"><strong><? if($data->cash_discount>0) echo number_format($data->cash_discount,2); else echo '0.00';?></strong></td>
        </tr>
        <tr>
		<td align="right">&nbsp;</td>
          <td align="right">Tax/Vat(<?=$data->tax?>%):</td>
          <td align="right"><strong><?  echo number_format($tax_total,2);?></strong></td>
        </tr>
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
            <? echo number_format(($total+$data->transport_bill+$tax_total+$data->labor_bill-$data->cash_discount),2);?>
          </strong></td>
        </tr>
        <tr>
          <td colspan="3" align="left"><strong>Terms &amp; Conditions: </strong><br>
            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:9px">
              <tr>
                <td width="20%" align="left" valign="top">
                  <li>Delivery</li>                </td>
                <td width="3%" align="right" valign="top">: </td>
                <td align="left" valign="top"> Within <? if($data->delivery_within>0) echo $data->delivery_within.' ('.CLASS_Numbertoword::convert(((int)$data->delivery_within),'en').') '; else echo ' 90 (Ninty)'?>  Days from the date of Work-Order<strong> (Delivery Period is strictly defined)</strong></td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  <li>Delivery Spot</li>                </td>
                <td align="right" valign="top">:</td>
                <td align="left" valign="top"> <strong><?=$whouse->address?></strong></td>
              </tr>
			  <? if($data->payment_terms!=''){?>
              <tr>
                <td align="left" valign="top">
                  <li>Payment</li>                </td>
                <td align="right" valign="top">:</td>
                <td align="left" valign="top"><?=$data->payment_terms?></td>
              </tr>
			  <? }?>
              <tr>
                <td align="left" valign="top">
                  <li>Bill Submit</li>                </td>
                <td align="right" valign="top">:</td>
                <td align="left" valign="top">Shezan Point(5th Floor) 2, Indira Road Farmgate, Dhaka-1215.<strong>(Copy of Work-Order must be attached with original bill)</strong></td>
              </tr>
              
              <tr>
                <td align="left" valign="top"><li>Delievery  Instruction</li> </td>
                <td align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">Our Store will be closed from 8PM to 8AM </td>
              </tr>
              <tr>
                <td align="left" valign="top">
                  <li>Contact Person</li>                </td>
                <td align="right" valign="top">:</td>
                <td align="left" valign="top"><strong><?=$whouse->warehouse_company?>. Mobile No: <?=$whouse->contact_no?></strong></td>
              </tr>
            </table>
            <p><strong></strong></p></td>
        </tr>
        <tr>
          <td colspan="3" align="left" style="font-size:10px" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25%" valign="top"><p>Thanking You,<br />
                </p>
                  <p><br />
                      <br />
                    -----------------------<br />
                Executive Director&nbsp;</p></td>
                <td width="25%" valign="top"><p><br />
                </p>
                  <p><br />
                      <br />
                      -----------------------<br />
                DMD/Director &nbsp;</p></td>
                <td width="25%" valign="top"><p><br />
                </p>
                  <p><br />
                    <br />
                    -----------------------<br />
                  Head of SCM</p></td>
                <td width="25%" valign="top"><p><br />
                </p>
                  <p><br />
                    <br />
                    -----------------------<br />
                  Manager (SCM) </p></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="3" align="left" style="font-size:10px"><p>* Supplied goods will be same as approved sample, otherwise the goods must be replaced &amp; you will bare all expenses.<br />
            * The Copy of Work Order must be shown at the factory premises during the delivery.<br />
            * Company protects the right to reconsider or cancel the Work-Order every nowby any administrational dictation.<br />
            * Any inefficiency in maintanence must be informed(Officially) before the execution to avoid the compensation.
            <br />
            * Supplied goods will be same as approved sample, otherwise the goods must be replaced & you will bare all expenses. <br />
            * Regarding Packing Material and Labels: Rejected items should not be returned and to be destroyed infront of vendors. <br />
            -This Work order prepared by <em>
              <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?>
            </em></p>
            </td>
        </tr>
        <tr>
          <td colspan="3" align="left">&nbsp;</td>
        </tr>
      </table></td>
  </tr>

</table>
</form>
</body>
</html>
