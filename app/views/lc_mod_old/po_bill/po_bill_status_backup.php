<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='PO Bill Status';



do_calander('#fdate');

do_calander('#tdate');



$table = 'po_bill_master';

$unique = 'bill_id';

$status = 'UNCHECKED';

$target_url = '../po_bill/po_bill_print_view.php';



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

    <td width="495">&nbsp;</td>

    <td colspan="3">&nbsp;</td>

    <td width="354">&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>

    <td width="130" bgcolor="#FF9966"><strong>

      <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" />

    </strong></td>

    <td width="82" align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="107" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" />

    </strong></td>

    <td rowspan="4" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966">Purchase Manager : </td>

    <td colspan="3" bgcolor="#FF9966"><strong>

      <select name="purchase_manager" id="purchase_manager" style="width:200px;">

        <option value=""></option>

		<? foreign_relation('purchase_manager','id','purchase_manager',$_POST['purchase_manager'],' 1 ');?>

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

if(isset($_POST['fdate'])){

if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= 'and a.status="'.$_POST['status'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.bill_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['group_for']!='')

$con .= 'and b.group_for = "'.$_POST['group_for'].'"';



if($_POST['purchase_manager']!='')

$con .= 'and a.purchase_manager = "'.$_POST['purchase_manager'].'"';



  $res='select  a.bill_id, a.bill_no, DATE_FORMAT(a.bill_date, "%d-%m-%Y") as bill_date,  d.purchase_manager,  c.fname as entry_by, a.status 
  from po_bill_master a, po_bill_details b, user_activity_management c, purchase_manager d
  where  a.bill_id=b.bill_id and a.entry_by=c.user_id and a.purchase_manager=d.id  '.$con.' group by a.bill_id order by a.bill_date, a.bill_id';

echo link_report($res,'po_print_view.php');



}

?>

</div></td>

</tr>

</table>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>