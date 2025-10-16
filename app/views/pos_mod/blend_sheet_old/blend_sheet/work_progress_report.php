<?php

session_start();

ob_start();

require_once "../../../assets/support/inc.all.php";

$title='Other Issue List';



do_calander('#fdate');

do_calander('#tdate');



$table = 'cons_daily_progress_master';

$unique = 'id';

$status = 'CHECKED';

$target_url = 'work_progress_report_view.php';



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



$res='select m.id,m.id, m.entry_date, p.project_details as project_name, l.location, s.name as supervisor_name from cons_daily_progress_master m, cons_supervisor s, cons_location l, cons_project p WHERE m.project_id=p.id and m.location=l.id and m.supervisor_id=s.id '.$con;


//echo $res;


echo link_report($res,'work_progress_report_view.php');



//}

?>

</div></td>

</tr>

</table>

</div>



<?

require_once "../../../assets/template/layout.bottom.php";

?>