<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Foreign Purchased Status';



do_calander('#fdate');

do_calander('#tdate');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../po/po_print_view.php';



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

    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="status" id="status" style="width:200px;">

<option><?=$_POST['status']?></option>

<option>UNCHECKED</option>

<option>CHECKED</option>

<option>COMPLETED</option>

<option>ALL</option>

</select>

    </strong></td>

    </tr>

</table>



</form>

</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<? 

if(isset($_POST['status'])){

if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= 'and a.status="'.$_POST['status'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['group_for']!='')

$con .= 'and b.group_for = "'.$_POST['group_for'].'"';



if($_POST['warehouse_id']!='')

$con .= 'and b.warehouse_id = "'.$_POST['warehouse_id'].'"';



   $res='select  a.po_no,a.po_no, DATE_FORMAT(a.po_date, "%d-%m-%Y") as po_date,  a.invoice_no,  DATE_FORMAT(a.invoice_date, "%d-%m-%Y") as invoice_date, v.vendor_name as party_name, b.warehouse_name as warehouse, c.fname as entry_by, a.entry_at,a.status from purchase_master a,warehouse b,user_activity_management c, vendor v where  a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id and a.vendor_id=v.vendor_id and a.po_for like "Foreign"  '.$con.' order by a.po_no desc';

echo link_report($res,'po_print_view.php');



}

?>

</div></td>

</tr>

</table>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>