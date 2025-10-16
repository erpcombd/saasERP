<?php

require_once "../../../assets/template/layout.top.php";

$title='All Issue Report';



do_calander('#fdate');

do_calander('#tdate');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../other_issue/other_issue_report.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}



?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?v_no='+theUrl);

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

          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=date('Y-m-01')?>" />

        </strong></td>

        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=(isset($_POST['tdate']))?$_POST['tdate']:date('Y-m-d')?>" />

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





$con .= 'and a.oi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



$res='select  a.oi_no,a.oi_no,a.oi_date,a.oi_subject as serial,a.issued_to as issue_to,a.issue_type,sum(amount) as Total,a.entry_at,c.fname as user 

from warehouse_other_issue a, warehouse_other_issue_detail b, user_activity_management c

where (a.issue_type = "Sample Issue" or a.issue_type = "Other Issue" or a.issue_type = "Gift Issue" or a.issue_type = "Entertainment Issue") and a.oi_no=b.oi_no and a.entry_by=c.user_id and a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' group by a.oi_no order by a.oi_no desc';





echo link_report($res,'other_issue_report.php');



}

?>

</div></td>

</tr>

</table>

</div>



<?

require_once "../../../assets/template/layout.bottom.php";

?>