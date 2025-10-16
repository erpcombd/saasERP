<?php

require_once "../../../assets/template/layout.top.php";

require_once ('../../common/class.numbertoword.php');

$service_group_id=$_SESSION['user']['id'];

$user_id=$_SESSION['user']['id'];



$bill_no	= $_REQUEST['bill_no'];

	    if(isset($_POST['delete']))
	{
		db_delete('hms_bill_payment','id='.$bill_no);
		db_delete('hms_bill_payment_details','bill_no='.$bill_no);
		echo 'This Bill is Canceled.';
		die();
	}
		if(isset($_POST['bill_paid']))
	{
		$sql = "UPDATE `hms_bill_payment` SET   `paid_amt` = '".$_POST['paid_amt']."', paid_in = '".$_POST['paid_in']."' WHERE `hms_bill_payment`.`id` = '".$bill_no."'";
		mysql_query($sql);
	}
	

$bill 		= find_all_field('hms_bill_payment','id',"id=".$bill_no);

$service_group = find_all_field('hms_service_group','service_group','id='.$service_group_id);
$room_no = find_a_field('hms_hotel_room','room_no','id='.$bill->room_id);
$staff_name = find_a_field('hms_service_staff','staff_name','id='.$bill->service_staff_id);


	$sql_new="SELECT proj_address FROM project_info limit 1";
	$sql1_new=mysql_query($sql_new);

if($data_new=mysql_fetch_row($sql1_new))
$address	= $data_new[0];



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
<style type="text/css">
<!--
body {
	font-size: 12px;
}
-->
</style>
</head>

<body>

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">


        <tr>

          <td colspan="3" valign="bottom"><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><span class="style1"><img src="golden_inn_service.png" height="40" /><br>BILL</span></td>
  </tr>
</table></td>
        </tr>






        <tr>
          <td colspan="3"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td>No: <?php echo $bill->id;?></td>
              <td>Date: <?php echo $bill->bill_date;?></td>
            </tr>
            <tr>
              <td colspan="2">Guest Name: <?php echo $bill->name;?></td>
            </tr>
            <tr>
              <td>Room No : <?=$room_no?></td>
              <td>Waiter : <?=$staff_name?></td>
            </tr>
          </table></td>
        </tr>
  
  


  <tr>

    <td colspan="3"><div id="pr">

<div align="left">
<form action="" id="mhafuz" method="post">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />

<input type="submit" name="delete" id="delete" value="Cancel" />
<input name="bill_no" type="hidden" value="<?=$bill_no?>" />
<strong>
<select name="paid_in" id="paid_in">
  <option value="Cash">Cash</option>
  <option value="Credit Card">Credit Card</option>
  <option value="Complementary">Complementary</option>
</select>
</strong>
<input name="paid_amt" type="text" id="paid_amt"  tabindex="10" class="input3" style="width:100px;text-align:right;" />
<input type="submit" name="bill_paid" id="bill_paid" value="Paid/Adjust" />
</form>
</div>

</div>
       <tr>

        <td width="10%"><div align="center"><strong>SL</strong></div></td>

        <td width="70%"><div align="center"><strong>Particular</strong></div></td>

        <td width="20%"><div align="center"><strong>Amount</strong></div></td>
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
<? for($i=0;$i<$pi;$i++){?>
      <tr>
        <td valign="top" style="border-bottom-color:#FFFFFF; border-top-color:#FFFFFF;"><?=$sl[$i]?></td>
        <td align="left" valign="top"style="border-bottom-color:#FFFFFF;border-top-color:#FFFFFF;"><?=$item[$i]?></td>
        <td align="right" valign="top"style="border-bottom-color:#FFFFFF;border-top-color:#FFFFFF;"><?=number_format($amount[$i],2)?></td>
      </tr>
<? }?>
      

      <tr>

        <td colspan="2"><div align="right">Net Total: </div></td>

        <td align="right"><strong><?php echo number_format($bill->total_amt,2);?></strong></td>
      </tr>


        <tr>

		<td colspan="2"><div align="right">Service Charge(

            <?=$service_group->service_charge?>

          %)(+):</div></td>

          <td align="right"><strong>

            <?=number_format(($bill->service_charge),2)?>

          </strong></td>
        </tr>

        <tr>

		<td colspan="2" align="right">Tax/Vat(

            <?=$service_group->vat?>

          %)(+):</td>

          <td align="right"><strong>

            <?=number_format(($bill->vat_amt),2)?>

          </strong></td>
        </tr>

		<tr>

		  <td colspan="2" align="right">Discount(-):</td>

		  <td align="right"><strong>

            <?=number_format(($bill->discount_amt),2)?>

          </strong></td>
		</tr>

		

        <tr>
          <td colspan="2" align="right">Grand Total:</td>
          <td align="right"><strong>
            <?=number_format($bill->bill_amt,2);?>
          </strong></td>
        </tr>
        <tr>
          <td colspan="2" align="right">Paid Amount:</td>
          <td align="right"><?=number_format($bill->paid_amt,2);?></td>
        </tr>
        <tr>

		<td colspan="2" align="right">Due:</td>

          <td align="right"><strong><?=number_format(($bill->bill_amt - $bill->paid_amt),2);?></strong></td>
        </tr>
</table>

</body>

</html>
<?
$main_content=ob_get_contents();
ob_end_clean();

//echo $main_content;
//echo '<br>';echo '<br>';echo '<br>';echo '<br>';
//echo $main_content;
?>

<table style="width:100%">
   <tr>
       <td style="width:49%;"><?=$main_content?></td>
	   <td style=" width:2%"></td>
	   <td style="width:49%;"><?=$main_content?></td>
   </tr>
</table>



