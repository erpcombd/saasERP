<?php

session_start();

ob_start();

require_once "../../../assets/support/inc.all.php";

$title='View Blend Sheet';



do_calander('#fdate');

do_calander('#tdate');



$table = 'blend_sheet_master';

$unique = 'budg_id';

//$status = 'CHECKED';

$target_url = 'budget_report_view.php';



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

//if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and m.date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



$res='select b.budg_id  as Blend_id,b.budg_id  as Blend_id, w.warehouse_name as Blend_name, b.budg_date as Blend_date from blend_sheet_master b , warehouse w WHERE b.line_id=w.warehouse_id '.$con;


//echo $res;


echo link_report($res,'budget_report_view.php');



//}

?>

</div></td>

</tr>

</table>

</div>



<?

require_once "../../../assets/template/layout.bottom.php";

?>