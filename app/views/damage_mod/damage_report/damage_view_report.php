<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Finish Goods Chalan Status';



do_calander('#fdate');

do_calander('#tdate');



$table = 'sales_damage_receive_master';

$unique = 'v_no';

$status = 'UNCHECKED';

$target_url = '../damage_report/damage_view_print.php';



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

      <input type="text" name="fdate" id="fdate" style="width:100px;" value="<? if($_POST['fdate']=='') echo date('Y-m-01'); else echo $_POST['fdate'];?>" />

    </strong></td>

    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" style="width:100px;" value="<? if($_POST['tdate']=='') echo date('Y-m-d'); else echo $_POST['tdate'];?>" />

    </strong></td>

    <td rowspan="2" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Under Depot : </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="depot" id="depot" style="width:200px;">

<option></option>

<? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'1 and use_type="SD" order by warehouse_name');?>

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

if($_POST['depot']!=''&&$_POST['depot']!='ALL')

$con .= 'and b.warehouse_id="'.$_POST['depot'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



$res='select  	a.or_no,a.or_no as id,a.or_date as issue_date, a.manual_or_no as serial_no,  a.entry_at,u.fname as entry_by 
from user_activity_management u,sales_damage_receive_master a,warehouse b 
where  a.status="UNCHECKED" and a.entry_by=u.user_id and b.use_type!="PL"  and b.warehouse_id=a.warehouse_id order by a.or_no asc';





echo link_report($res,'print_view.php');}

?>

</div></td>

</tr>

</table>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>