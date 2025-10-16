<?php

session_start();

ob_start();

require_once "../../../assets/support/inc.all.php";

$title='Black Tea Transection Status';



do_calander('#fdate');

do_calander('#tdate');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../blend_sheet/black_tea_transection_sheet.php';



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

        <td align="right" bgcolor="#FF9966"><strong>Blend Type : </strong></td>

        <td colspan="3" bgcolor="#FF9966"><strong>

          <select name="blend_type" id="blend_type" style="width:220px;" required="required">

		  

		  <option></option>

           

            <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['blend_type'],'use_type="PL" and  warehouse_id!=4 order by warehouse_id');?>
          </select>

        </strong></td>

        <td rowspan="2" bgcolor="#FF9966"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

        </strong></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />

        </strong></td>

        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />

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

$con .= ' and a.issue_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['blend_type']!='')

$con .= ' and a.blend_type = "'.$_POST['blend_type'].'" ';







   $res='select  a.issue_no, a.issue_no as TR_NO,a.issue_date as Issue_Date, c.warehouse_name as Blend_Type,  u.fname as entry_by, a.entry_at

from black_tea_consumption a, warehouse c, user_activity_management u

where a.blend_type=c.warehouse_id and a.entry_by=u.user_id '.$con.' group by a.issue_no order by a.issue_date asc';





echo link_report($res,'sales_view_acc.php');



}

?>

</div></td>

</tr>

</table>

</div>



<?

require_once "../../../assets/template/layout.bottom.php";

?>