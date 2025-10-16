<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Upcoming Import Receive';



do_calander('#fdate');

do_calander('#tdate');



$table = 'warehouse_other_receive';

$unique = 'or_no';

$status = 'CHECKED';

$target_url = '../import/import_receive_serialized.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}



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

        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="fdate" id="fdate" style="width:107px !important;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />

        </strong></td>

        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="tdate" id="tdate" style="width:107px !important;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />

        </strong></td>

        <td bgcolor="#FF9966"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

        </strong></td>

      </tr>

    </table>

  </form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and o.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



$res='select o.or_no,o.or_no as import_no,o.or_date as import_date,(select vendor_name from vendor where vendor_id=o.vendor_id) as vendor_name,o.status,u.fname as entry_by,o.entry_at from warehouse_other_receive o,user_activity_management u where u.user_id=o.entry_by and o.status="CHECKED" and o.receive_type="Import" order by o.or_no desc';

echo link_report($res,'po_print_view.php');



}

?>

</div></td>

</tr>

</table>

</div>



<?
$tr_from="Purchase";
require_once SERVER_CORE."routing/layout.bottom.php";

?>