<?php
require_once "../../../assets/template/layout.top.php";
$title='Sales Return List';

do_calander('#fdate');
do_calander('#tdate');
do_datatable('grp');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../salesReturn/item_return_report.php';

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
          <input type="text" name="fdate" id="fdate" style="width:110px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:110px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
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

<th class="text-center">SR No</th>
<th class="text-center">SR Date</th>
<th class="text-center">Customer Name</th>
<th class="text-center">Serial No</th>
<th class="text-center">Total</th>

 </tr>
 </thead>
 <tbody>

<? 
if($_POST['fdate']!='') {$con=' and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}else{$con=' and a.or_date between "'.date('Y-m-o1').'" 
and "'.date('Y-m-d').'"';}


$res='select  a.or_no,a.or_no as SR_no,a.or_date as SR_date,a.vendor_name as customer,a.or_subject as serial_no,sum(amount) as Total from warehouse_other_receive a,warehouse_other_receive_detail b where a.or_no=b.or_no and a.status="CHECKED" and a.warehouse_id = "'.$_SESSION['user']['depot'].'" and a.receive_type = "return" '.$con.' group by a.or_no order by a.or_no desc';


$query = mysql_query($res);
while($data = mysql_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=$data->or_no?></td>
<td class="text-center"><?=$data->or_date?></td>
<td class="text-center"><?=$data->customer?></td>
<td class="text-center"><?=$data->serial_no?></td>
<td class="text-center"><?=$data->Total?></td>

</tr>
<?php } ?>

</tbody></table>
</div></td>
</tr>
</table>


<?
require_once "../../../assets/template/layout.bottom.php";
?>