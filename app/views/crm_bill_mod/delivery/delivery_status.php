<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Service Delivery Status';



do_calander('#fdate');

do_calander('#tdate');



$table = 'service_master';

$unique = 'service_no';

$status = 'CHECKED';

$target_url = '../delivery/service_delivery_print_view.php';



?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);

}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td colspan="3">&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" />

    </strong></td>

    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" />

    </strong></td>

    <td rowspan="4" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

  <!--<tr>

    <td align="right" bgcolor="#FF9966">Receiving Warehouse Name : </td>

    <td colspan="3" bgcolor="#FF9966"><strong>

      <select name="warehouse_id" id="warehouse_id" style="width:200px;">

        <option value="">ALL</option>

		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],' use_type in ("WH","SD") ');?>

      </select>

    </strong></td>

  </tr>-->

  <tr>

   <!-- <td align="right" bgcolor="#FF9966">Company Name : </td>

    <td colspan="3" bgcolor="#FF9966"><strong>

      <select name="group_for" id="group_for" style="width:200px;">

        <option value="">ALL</option>

        <option value="2">Sajeeb Corporation</option>

        <option value="3">HFL</option>

      </select>

    </strong></td>-->

  </tr>
  
   <tr>

    <td align="right" bgcolor="#FF9966"><strong>Serial No: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<input type="text" name="serial_no" id="serial_no" style="width:200px;" value="<?=$_POST['serial_no']?>">
    </strong></td>

    </tr>
	
	<tr>

    <td align="right" bgcolor="#FF9966"><strong>Complain No: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<input type="text" name="service_no" id="service_no" style="width:200px;" value="<?=$_POST['service_no']?>">
    </strong></td>

    </tr>

  
</table>



</form>

</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<? 

if(isset($_POST['fdate'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.service_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['serial_no']!=''){
 $con .= 'and s.serial_no="'.$_POST['serial_no'].'"';

}

if($_POST['service_no']!=''){
 $con .= 'and a.service_no="'.$_POST['service_no'].'"';

}



    $res='select  a.service_no,a.service_no as complain_no, DATE_FORMAT(a.service_date, "%d-%m-%Y") as complain_date,  a.invoice_no,  d.dealer_name_e as party_name, c.fname as entry_by, a.entry_at,a.status from service_master a, service_details s,user_activity_management c, dealer_info d where a.service_no=s.service_no and a.entry_by=c.user_id and a.client_id=d.dealer_code and a.status="DELIVERED" '.$con.$cons.' group by s.service_no order by a.service_no desc';

echo link_report($res,'service_received_print_view.php');



}

?>

</div></td>

</tr>

</table>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>