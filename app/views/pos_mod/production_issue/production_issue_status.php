<?php

session_start();

ob_start();

require_once "../../../assets/support/inc.all.php";

$title='Production Issue Line';



do_calander('#fdate');

do_calander('#tdate');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../production_issue/production_issue_report.php';



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

          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=date('Y-m-01')?>" />

        </strong></td>

        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=date('Y-m-d')?>" />

        </strong></td>

        <td bgcolor="#FF9966" rowspan="2"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

        </strong></td>

      </tr>
	  
	  <tr>
    <td align="right" bgcolor="#FF9966"><strong> Section For : </strong></td>
    <td colspan="3" bgcolor="#FF9966">
	<select name="req_for" id="req_for">
	<option></option>
	<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],' use_type="PL"');?>
	</select>
	</td>
  </tr>

    </table>

  </form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['req_for']>0)
$con .= 'and a.req_for = "'.$_POST['req_for'].'"  ';

//<!--select a.req_no,a.req_no,w.warehouse_name as req_for,a.manual_req_no , b.fname as entry_by ,a.entry_at,a.status from master_requisition_master a,user_activity_management b,warehouse w where a.status in ("UNCHECKED") and w.warehouse_id=a.req_for and b.user_id = a.entry_by-->



$res='select a.req_no,a.req_no,a.manual_req_no,a.req_date,(select warehouse_name from warehouse where warehouse_id=a.req_for) as req_for,c.warehouse_name as issue_to, a.status,a.entry_at,u.fname as user from master_requisition_master a, master_requisition_details b, warehouse c, user_activity_management u where a.req_no=b.req_no and a.warehouse_id=c.warehouse_id and a.entry_by=u.user_id and c.warehouse_id = "'.$_SESSION['user']['depot'].'" and a.status="UNCHECKED" '.$con.' group by a.req_no order by a.req_no desc';

echo link_report($res,'production_issue_report.php');



}

?>

</div></td>

</tr>

</table>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>