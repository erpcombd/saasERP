<?php
session_start();
//====================== EOF ===================
require "../../support/inc.all.php";
require_once ('../../common/class.numbertoword.php');
$service_group_id=2;

$reserve_no	= $_REQUEST['reserve_no'];
$bill 		= find_all_field('hms_bill_payment','id',"id=".$bill_no);
$service_group=find_all_field('hms_service_group','service_group','id='.$service_group_id);

	$sql_new="SELECT proj_address FROM project_info limit 1";
	$sql1_new=mysql_query($sql_new);
	if($data_new=mysql_fetch_row($sql1_new))
	{
		$address	= $data_new[0];
	}

$reserve_all = find_all_field('hms_reservation','id',"id='".$reserve_no."'");
?>
 <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select a.* from hms_bill_payment a where a.reserve_id=".$reserve_no." and bill_amt<>paid_amt";
$data2=mysql_query($sql2);

while($info=mysql_fetch_object($data2)){ 
$pi++;
$sl[]=$pi;

$sql="SELECT service_group from hms_service_group WHERE id=".$info->service_group_id;
$item[]=find_a_field_sql($sql);

$bill_no[]=$info->id;
$date[]=$info->bill_date;
$total_amt[]=$info->total_amt;
$service_charge[]=$info->service_charge;
$vat_amt[]=$info->vat_amt;

$discount_amt[]=$info->discount_amt;
$bill_amt[]=$info->bill_amt;
$paid_amt[]=$info->paid_amt;

$total_bill=$total_bill+$info->bill_amt;
$total_paid=$total_paid+$info->paid_amt;
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cash Memo :.</title>
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
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="bottom" width="23%"><? $path='../../../scb_mod/logo/'.$_SESSION['proj_id'].'.jpg';
			if(is_file($path)) echo '<img src="'.$path.'" height="80" width="200" />';?></td>
			<td valign="bottom"></td>
			<td>
			<div class="address">
			<p><?=$address?></p>
			</div> </td>
		  </tr>
		  <tr>
		    <td colspan="3" valign="bottom"><div class="header_title">BILL </div></td>
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
    <td><div class="header2">
      <div class="header2_left">      Client Name : <?php echo $reserve_all->client_name;?><br>
	  Client Address : <?php echo $reserve_all->Address;?>
	  </div>
	  
      <div class="header2_right">
	  <p>	  Bill No: <?=$bill_no[0]?><br />
	  Bill Date: <?=$date[0]?><br />
	  Reservation No: <?php echo $reserve_no;?><BR />
Check In Date:   <?php echo $reserve_all->check_in_date;?><BR>
	    Check Out Date: <?php echo $reserve_all->check_out_date;?></p>
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
        <td width="8%"><strong> No </strong></td>
        <td width="9%"><strong>Date</strong></td>
        <td width="40%"><div align="center"><strong>Service/Item </strong></div></td>
        <td width="9%"><strong>Amount</strong></td>
        <td width="9%"><strong>Service Charge</strong></td>
        <td width="9%"><strong>Vat</strong></td>
        <td width="9%"><strong>Discount</strong></td>
        <td width="12%"><strong>Total </strong></td>
        <td width="12%"><strong>Credit </strong></td>
      </tr>
	 
      <tr>
        <td height="350" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$i+1?></p><? }?></td>
        <td align="left" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$date[$i]?></p><? }?></td>
        <td align="left" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$item[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$total_amt[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$service_charge[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$vat_amt[$i]?></p><? }?></td>
        <td valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=$discount_amt[$i]?></p><? }?></td>
        <td align="right" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=number_format($bill_amt[$i],2)?></p><? }?></td>
        <td align="right" valign="top"><? for($i=0;$i<$pi;$i++){?><p><?=number_format($paid_amt[$i],2)?></p><? }?></td>
      </tr>
      <tr>
        <td colspan="7"><div align="right">Total:</div></td>
        <td align="right"><?php echo number_format($total_bill,2);?></td>
        <td align="right"><strong><?php echo number_format($total_paid,2);?></strong></td>
      </tr>
    </table>
      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:700px">
        <tr>
          <td>Total (Due) : <strong>
          <?=number_format(($total_bill-$total_paid),2)?>
          </strong></td>
        </tr>
        <tr>
		<td>In Word(Due): Taka <?=CLASS_Numbertoword::convert(((int)($total_bill-$total_paid)),'en')?> Only</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div class="footer_left">
              <p>Software Developed By:  Internet Services &amp; Communication Ltd.<br />
              <a href="http://www.accountstrack.com">www.accountstrack.com</a> Cell:  +8801673900380</p>
            </div>
          <div class="footer_right"><img width="211" height="29" src="bill_invoice_final_clip_image002.png" align="right" hspace="12" /></div></td>
        </tr>
              </table>
	    <div class="footer1"> </div></td></tr>
</table>
</body>
</html>
