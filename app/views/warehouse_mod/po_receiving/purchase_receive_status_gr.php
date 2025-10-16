<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Upcoming Purchase Order List';



do_calander('#fdate');

do_calander('#tdate');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../pr/chalan_view2.php';



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

<style type="text/css">

<!--

.style1 {

	color: #FF0000;

	font-weight: bold;

	font-size: 10px;

}

-->

</style>



<div class="form-container_large">

  <form action="" method="post" name="codz" id="codz">

    <table width="80%" border="0" align="center">

      <tr>

        <td>&nbsp;</td>

        <td colspan="3">&nbsp;</td>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td align="right" bgcolor="#FF9966"><strong>Party Name : </strong></td>

        <td colspan="3" bgcolor="#FF9966"><label>

          <select name="vendor_id" id="vendor_id">

		  <option></option>

          <? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],' group_for="'.$_SESSION['user']['group'].'" order by vendor_name');?>

          </select>

        </label></td>

        <td rowspan="2" bgcolor="#FF9966"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

        </strong></td>

      </tr>

      <tr>

        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />

        </strong></td>

        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

        <td width="1" bgcolor="#FF9966"><strong>

          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />

        </strong></td>

      </tr>

    </table>

  </form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td>

<div class="tabledesign2">



<table width="100%" cellspacing="0" cellpadding="0" id="grp">

<tbody>



	<tr>

		<th width="13%">Po No</th>

		<th width="16%">Po Date</th>

		<th width="7%">Sale No </th>
		<th width="27%">Party Name</th>

		<th width="16%">GR No </th>

		<th width="21%">GR Date </th>
		</tr>

<? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['vendor_id']>0)

$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';



$res='select  a.po_no, a.po_date, a.sale_no, v.vendor_name,u.fname as entry_by

from 

purchase_master a,warehouse b, vendor v,user_activity_management u where u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id and  a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' order by a.po_no desc';



$query = db_query($res);

while($data=mysqli_fetch_object($query))

{



?>

	<tr>

      <td valign="top"><?=$data->po_no;?></td>

	  <td valign="top"><?=$data->po_date;?></td>

	  <td valign="top"><?=$data->sale_no;?></td>
	  <td valign="top"><?=$data->vendor_name;?></td>

	  <td colspan="2">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:8px; border:0;">

<? 

$sql = 'select a.rec_date,a.pr_no from purchase_receive a where a.po_no="'.$data->po_no.'" group by  a.pr_no';

$sqlq = db_query($sql);

$cc = mysqli_num_rows($sqlq);

if($cc>0){

while($info=mysqli_fetch_object($sqlq)){

?>

<tr onclick="custom(<?=$info->pr_no?>);">

	<td width="50%"><?=$info->pr_no?></td>

	<td width="50%"><?=$info->rec_date;?></td>
</tr>

<? }}

else

{

?>

<tr>

	<td colspan="2"><div align="center" class="style1">NO GOODS RECEIVED </div></td>
	</tr>

<?

}?>
</table>	  </td>
	</tr>

<? }}?>
</tbody></table>

</div>

</td>

</tr>

</table>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>