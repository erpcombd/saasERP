<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Daily Progress Report Status';



do_calander('#fdate');

do_calander('#tdate');



$table = 'daily_progress_master';

$unique = 'd_id';

$status = 'MANUAL';

$target_url = '../po/progress_print_view_cns.php';



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



  <tr>


	
	<tr>

    <td align="right" bgcolor="#FF9966"><strong>Progress For: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="progress_for" id="progress_for" class="form-control">
	<option></option>
	 <? foreign_relation('daily_progress_setup','id','type',$$field,'tr_from ="progress for"');?>
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

if(isset($_POST['submitit'])){

if($_POST['status']!=''&&$_POST['status']!='ALL'){
 $con .= 'and a.status="'.$_POST['status'].'"';
}




if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.progress_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['group_for']!='')

$con .= 'and b.group_for = "'.$_POST['group_for'].'"';




if($_POST['progress_for']>0){
$cons =" and a.progress_for='".$_POST['progress_for']."' ";
}


if($_POST['warehouse_id']>0){
$cons =" and a.warehouse_id='".$_POST['warehouse_id']."' ";
}



    $res='select  a.d_id,a.d_id, DATE_FORMAT(a.progress_date, "%d-%m-%Y") as progress_date, s.type, c.fname as entry_by, a.entry_at, a.status
	 from daily_progress_master a, daily_progress_setup s,user_activity_management c
	  where  a.progress_for=s.id and a.entry_by=c.user_id and a.status !="MANUAL"  '.$con.$cons.' and a.entry_by='.$_SESSION['user']['id'].' order by a.d_id desc';

echo link_report($res,'progress_print_view_cns.php');



}

?>

</div></td>

</tr>

</table>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>