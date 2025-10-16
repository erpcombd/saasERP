<?php
require_once "../../../assets/template/layout.top.php";
require_once ('../../common/class.numbertoword.php');
$service_group_id=$_SESSION['user']['id'];
$user_id=$_SESSION['user']['id'];

$bill_no	= $_REQUEST['bill_no'];
$bill 		= find_all_field('hms_bill_payment','id',"id=".$bill_no);
$service_group=find_all_field('hms_service_group','service_group','id='.$service_group_id);

	$sql_new="SELECT proj_address FROM project_info limit 1";
	$sql1_new=mysql_query($sql_new);
	if($data_new=mysql_fetch_row($sql1_new))
	{
		$address	= $data_new[0];
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Service Bill :.</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="bottom" width="23%">
		<? $path='../../../scb_mod/logo/'.$_SESSION['proj_id'].'.jpg';
		if(is_file($path)) echo '<img src="'.$path.'" height="80" width="200" />';?></td>
          <td valign="bottom"></td>
          <td><div class="address">
              <p>
                <?=$address?>
              </p>
          </div></td>
        </tr>
        <tr>
          <td colspan="3" valign="bottom"><div class="header_title">Service BILL </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  <tr>
    <td><div class="line"></div></td>
  </tr>
  <tr>
    <td><div class="header2">
      <div class="header2_left">
	 Name of Guest:<?php echo $bill->name;?><br />
	  
	  Address:<?php echo $bill->address;?><br />
	  </div>
	  
      <div class="header2_right">
	  <p>Bill No: <?php echo $bill->id;?><br />
	  Bill Date: <?php echo $bill->bill_date;?></p>	  
	  </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="pr">
<div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="8%"><strong>SL/No</strong></td>
        <td width="54%"><div align="center"><strong>Description of Service/Item </strong></div></td>
        <td width="9%"><strong>Qty.</strong></td>
        <td width="15%"><strong>Unit Price </strong></td>
        <td width="14%"><strong>Total Price </strong></td>
      </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select a.*,b.service_name from hms_bill_payment_details a, hms_services b where a.service_id=b.id and a.bill_no=".$bill_no;
$data2=mysql_query($sql2);
//echo $sql2;
while($info=mysql_fetch_object($data2)){ 
$pi++;
$sl[]=$pi;
$item[]=$info->service_name;
$qty[]=$info->qty;
$rate[]=$info->unit_price-$info->discount_amt;

$amount[]=$info->qty*($info->unit_price-$info->discount_amt);
$total=$total+($info->qty*($info->unit_price-$info->discount_amt));
}?>
      <tr>
        <td height="350" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$sl[$i]?></p><? }?></td>
        <td align="left" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$item[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$qty[$i]?></p><? }?></td>
        <td align="right" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=number_format($rate[$i],2)?></p><? }?></td>
        <td align="right" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=number_format($amount[$i],2)?></p><? }?></td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td align="right">Total:</td>
        <td align="right"><strong><?php echo number_format($bill->total_amt,2);?></strong></td>
      </tr>
    </table>
      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
		<td>In Word: Taka <?=CLASS_Numbertoword::convert(((int)($bill->bill_amt)),'en')?> Only</td>
          <td align="right">Service Charge(
              <?=$service_group->service_charge?>
            %)(+):</td>
          <td align="right"><strong>
            <?=number_format(($bill->service_charge),2)?>
          </strong></td>
        </tr>
        <tr>
		<td align="right">&nbsp;</td>
          <td align="right">Tax/Vat(
              <?=$service_group->vat?>
            %)(+):</td>
          <td align="right"><strong>
            <?=number_format(($bill->vat_amt),2)?>
          </strong></td>
        </tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td align="right">Discount(-):</td>
		  <td align="right"><strong>
            <?=number_format(($bill->discount_amt),2)?>
          </strong></td>
		</tr>
		
        <tr>
		<td align="right">&nbsp;</td>
          <td align="right">Grand Total:</td>
          <td align="right"><strong><?=number_format($bill->bill_amt,2);?></strong></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br />
          Prepared By:
          <?
		  $sql="SELECT fname from `user_activity_management` WHERE user_id=".$user_id;
echo $item=find_a_field_sql($sql);
		  ?>
            <br />
          Print Time:
          <?=date('d-m-y h:m:i A')?>
        </td>
      </tr>
      <tr>
        <td><div class="line"></div></td>
      </tr>
      <tr height="15px">
        <td><div align="center">
          <p align="center">This is a computer generated report &amp; do not require a signature. </p>
        </div></td>
      </tr>
      <tr>
        <td><div class="footer_left">
            <p>Software Developed By:  Internet Services &amp; Communication Ltd.<br />
                <a href="http://www.accountstrack.com">www.accountstrack.com</a> Cell:  +8801673900380</p>
        </div>
            <div class="footer_right"><img width="211" height="29" src="bill_invoice_final_clip_image002.png" align="right" hspace="12" /></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
