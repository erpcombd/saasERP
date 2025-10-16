<?php

require_once "../../../assets/template/layout.top.php";



$title='Despatch Order Status';



do_calander('#fdate');

do_calander('#tdate');

do_datatable('grp');



$table = 'requisition_fg_master';

$unique = 'req_no';

$status = 'UNCHECKED';

$target_url = '../fr/mr_print_view.php';



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

      <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=$_POST['fdate']?>" />

    </strong></td>

    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=$_POST['tdate']?>" />

    </strong></td>

    <td rowspan="2" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="status" id="status" style="width:200px;">

<option><?=$_POST['status']?></option>

<option>UNCHECKED</option>

<option>CHECKED</option>

<option>ALL</option>

</select>

    </strong></td>

    </tr>

</table>



</form>

</div>



<table style="cursor:pointer" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<thead>
<tr>

<th class="text-center">Req No</th>
<th class="text-center">Req Date</th>
<th class="text-center">Despatch Depot</th>
<th class="text-center">Need By</th>
<th class="text-center">Transport</th>
<th class="text-center">Entry By</th>
<th class="text-center">Status</th>


 </tr>
 </thead>
 <tbody>

<? 

if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= 'and a.status="'.$_POST['status'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';





$res='select a.req_no, DATE_FORMAT(a.req_date, "%d-%m-%Y") as req_date,  b.warehouse_name as despatch_depot,   DATE_FORMAT(a.need_by, "%d-%m-%Y") as need_by,  a.req_note as Transport , c.fname as entry_by, a.status from requisition_fg_master a,warehouse b,user_activity_management c where a.warehouse_id='.$_SESSION['user']['depot'].' and a.sub_depot=b.warehouse_id and a.entry_by=c.user_id '.$con.' and a.status in ("UNCHECKED","CHECKED") order by a.req_no desc';


$query = mysql_query($res);
while($data = mysql_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=$data->req_no?></td>
<td class="text-center"><?=$data->req_date?></td>
<td class="text-center"><?=$data->despatch_depot?></td>
<td class="text-center"><?=$data->need_by?></td>
<td class="text-center"><?=$data->Transport?></td>
<td class="text-center"><?=$data->entry_by?></td>
<td class="text-center"><?=$data->status?></td>

</tr>
<?php } ?>

</tbody></table>
</div></td>
</tr>
</table>



<?

require_once "../../../assets/template/layout.bottom.php";

?>