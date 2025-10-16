<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";


$service_group_id=2;

$user_id=$_SESSION['user']['id'];



$reserve_no	= $_REQUEST['reserve_no'];

$bill 		= find_all_field('hms_bill_payment','id',"id=".$bill_no);

$service_group=find_all_field('hms_service_group','service_group','id='.$service_group_id);



	$sql_new="SELECT proj_address FROM project_info limit 1";

	$sql1_new=db_query($sql_new);

	if($data_new=mysqli_fetch_row($sql1_new))

	{

		$address	= $data_new[0];

	}



$reserve_all = find_all_field('hms_reservation','id',"id='".$reserve_no."'");

?>
<?php

$final_amt=(int)$data1[0];

$pi=0;

$total=0;

$sql2="select a.* from hms_bill_payment a where a.reserve_id=".$reserve_no." and bill_amt<>paid_amt and bill_amt>0";

$data2=db_query($sql2);



$sql="SELECT sum(paid_amt)  from hms_bill_payment a where a.reserve_id=".$reserve_no." and bill_amt<>paid_amt and service_group_id=4";

$advanced=find_a_field_sql($sql);



$sql="SELECT sum(paid_amt)  from hms_bill_payment a where a.reserve_id=".$reserve_no." and bill_amt<>paid_amt and service_group_id=5";

$less=find_a_field_sql($sql);



while($info=mysqli_fetch_object($data2)){ 

$pi++;

$sl[]=$pi;



$sql="SELECT service_group from hms_service_group WHERE id=".$info->service_group_id;

$item[]=find_a_field_sql($sql);





if($info->service_group_id==2){

$sql="SELECT a.room_no FROM `hms_hotel_room` a,`hms_room_type` b,hms_bill_payment_details c WHERE b.id=a.room_type_id and c.service_id=a.id and  c.bill_no=".$info->id;

$room=find_a_field_sql($sql);}







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
<title>.: Final Bill :.</title>
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
    <td colspan="3"><div class="header">
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
                  <td colspan="3" align="center" valign="bottom" style="text-align:center"><div style="width:700px; text-align:center; float:left">
                    <div style="float:left"><span style="widows:20%"></span><br />
                      <span style=" float:left;width:150px; text-align:left">No: <?php echo $reserve_all->id;?><br />Room No:
                      <?
                      $sss="select GROUP_CONCAT(distinct r.room_no SEPARATOR ', ') Room_No  from 
	hms_hotel_room_status s,
	hms_hotel_room r where s.room_id=r.id and s.reserve_id=".$reserve_all->id;
					  echo find_a_field_sql($sss)?>
                      </span></div>
                    <div style="float:right; width:150px;">Date:
                      <?=date('Y-m-d')?>
                      <br />
                      Time:
                      <?=date('h:i:s A')?>
                    </div>
                    <div style="float:none"><img src="../../../../public/uploads/logo/cloudmvc.png" height="95" /><br />
                      
                    </div>
                  </div></td>
                </tr>
                <tr>
                  <td align="center" style="widows:20%">&nbsp;</td>
<td align="center" style="line-height:15px;"><nobr>336 Station Road, Chittagong-4000,Bangladesh, Phone: +880 31 611004-8,</nobr><br>Eamil: goldeninnctg@gmail.com, Web: www.goldeninnbd.com</td>
				  <?
				  
$sss = "select GROUP_CONCAT(distinct r.room_no SEPARATOR ', ') Room_No from hms_hotel_room_status s, hms_hotel_room r, hms_reservation h where s.room_id=r.id and h.id=s.reserve_id group by s.reserve_id";
				  ?>
                  <td align="center" style="widows:20%">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="center"><span style="font-size:35px; font:Tahoma">BILL</span><br>
                  (Payable Upon Presentation)</td>
                </tr>
            </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td>Guest Name: <?=$reserve_all->client_name;?></td>
    <td colspan="2">Address: <?=$reserve_all->client_address;?></td>
  </tr>
  <tr>
    <td>Arrival Date: <?=$reserve_all->check_in_date;?></td>
    <td>Departure Date: <?=$reserve_all->check_out_date;?></td>
    <td>Staying days: <?=$age = date_diff(date_create($reserve_all->check_in_date), date_create($reserve_all->check_out_date))->d; ?> Days</td>
  </tr>
  <tr>
    <td colspan="3"><div id="pr">
        <div align="left">
          <input name="button" type="button" onclick="hide();window.print();" value="Print" />
        </div>
      </div>
      <table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
        <tr>
          <td><center><table width="90%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="4%"><strong>Service Name </strong></td>
                <td width="5%">&nbsp;</td>
                <td width="9%"><strong>Amount</strong></td>
                </tr>
              <tr>
                <td>Total Room Charge </td>
                <td align="right">TK:</td>
                <td ><?=$room_chrg=find_a_field('hms_bill_payment','sum(total_amt)','service_group_id=2 and reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              
              <tr>
                <td>Food</td>
                <td align="right">TK:</td>
                <td ><?=$food_bill=find_a_field('hms_bill_payment','sum(bill_amt)','service_group_id=1 and reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              <tr>
                <td>Mini Bar </td>
                <td align="right">TK:</td>
                <td ><?=$mini_bar=find_a_field('hms_bill_payment','sum(bill_amt)','service_group_id=13 and reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              <tr>
                <td>Rent a Car </td>
                <td align="right">TK:</td>
                <td ><?=$rent_a_car=find_a_field('hms_bill_payment','sum(bill_amt)','service_group_id=7 and reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              <tr>
                <td>Laundry</td>
                <td align="right">TK:</td>
                <td ><?=$laundry=find_a_field('hms_bill_payment','sum(bill_amt)','service_group_id=6 and reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              <tr>
                <td>Conferance Hall</td>
                <td align="right">TK:</td>
                <td ><?=$conferance=find_a_field('hms_bill_payment','sum(bill_amt)','service_group_id=10 and reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              <tr>
                <td>Extra Bed</td>
                <td align="right">TK:</td>
                <td ><?=$extra_bed=find_a_field('hms_bill_payment','sum(bill_amt)','service_group_id=12 and reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              <tr>
                <td>Vat</td>
                <td align="right">TK:</td>
                <td ><?=$vat_chrg=find_a_field('hms_bill_payment','sum(vat_amt)','reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              <tr>
                <td>Others</td>
                <td align="right">TK:</td>
                <td ><?=$others=find_a_field('hms_bill_payment','sum(bill_amt)','service_group_id=14 and reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              <tr>
                <td>Service Charge </td>
                <td align="right">TK:</td>
                <td ><?=$other_chrg=find_a_field('hms_bill_payment','sum(service_charge)','reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
              <tr>
                <td>Total Amount </td>
                <td align="right">TK:</td>
                <td ><?=$total_amt=($room_chrg+$food_bill+$vat_chrg+$other_chrg+$conferance+$extra_bed+$mini_bar+$rent_a_car+$laundry+$others)?></td>
              </tr>
              <tr>
                <td>Discount</td>
                <td align="right">TK:</td>
                <td ><?=$disc_bill=find_a_field('hms_bill_payment','sum(paid_amt)','service_group_id=5 and reserve_id='.$_GET['reserve_no'])?></td>
              </tr>
			  <? $other_adv=find_a_field('hms_bill_payment','sum(paid_amt)','service_group_id!=5 and service_group_id!=8 and reserve_id='.$_GET['reserve_no'])?>

              <tr>
                <td>Advance</td>
                <td align="right">TK:</td>
                <td ><?=$other_adv?></td>
              </tr>
              <tr>
                <td>Net Payable Amount </td>
                <td align="right">TK:</td>
                <td ><?=$net_payable=($total_amt-$other_adv-$disc_bill)?></td>
              </tr>
              <tr>
                <td colspan="3">In Word(Due): Taka
                  <?=CLASS_Numbertoword::convert(((int)($net_payable)),'en')?>
Only</td>
                </tr>
              
            </table>
          </center></td>
        </tr>
      </table>      </td>
  </tr>
  <tr>
    <td colspan="3" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><?

$sql="SELECT * from `user_activity_management` WHERE user_id=".$user_id;

$u=find_all_field_sql($sql);

?>
            <br />
            Prepared By<strong>:
            <?=$u->fname?>
            <br />
            </strong>Designation<strong>:
            <?=$u->designation?>
            </strong>|| Mobile No<strong>:
            <?=$u->mobile?>
            <br />
            </strong>Print Time<strong>:
            <?=date('d-m-y h:m:i A')?>
            </strong></td>
        </tr>
        <tr>
          <td align="center">This is a computer generated report &amp; do not require a signature.
            <div class="line"> </div></td>
        </tr>
        <tr height="15px">
          <td align="center" valign="middle"><div align="center"> <strong>www.goldeninnbd.com </strong></div></td>
        </tr>
        <tr>
          <td><div >Software Developed By: ERP.COM.BD (www.erp.com.bd)<br />
          </div></td>
        </tr>
      </table>
      <div class="footer1"> </div></td>
  </tr>
</table>
</body>
</html>

