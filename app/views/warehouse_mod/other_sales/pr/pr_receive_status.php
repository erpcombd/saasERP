<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Upcoming Purchase Order List';

do_calander("#fdate");
do_calander("#tdate");
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';



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
        <td align="right" bgcolor="#FF9966"><strong>Item Name : </strong></td>
        <td colspan="3" bgcolor="#FF9966"><label>
          <input type="text" name="item" id="item" style="width:220px" value="<?=$_POST['item']?>" required />
        </label></td>
        <td rowspan="2" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
      </tr>
    </table>
  </form>
<div class="tabledesign2">
  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <th valign="top"><strong>MR Date </strong></th>
        <th valign="top"><strong>MR No </strong></th>
        <th valign="top"><strong>QOH</strong></th>
        <th><strong>QTY</strong></th>
      </tr>

  <? 
if(isset($_POST['submitit'])){
if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= ' and r.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
if($_REQUEST['item']!=''){$item = explode('#>',$_REQUEST['item']);
if($item[1]>0){			
$item_id=$item[1];
$con .= ' and r.item_id="'.$item_id.'"';
}}



$res='select  r.*
from 
requisition_order r, user_activity_management u where 
u.user_id=r.entry_by '.$con.' order by r.req_no asc';

$query = db_query($res);
while($data=mysqli_fetch_object($query))
{

?>

      <tr><td valign="top"><?=$data->req_date;?></td>
	    <td valign="top"><?=$data->req_no;?></td>
	    <td valign="top"><?=number_format($data->qoh,0);?></td>
	  <td><?=number_format($data->qty,0);?>	  </td>
	</tr>
<? $tqty = $tqty + $data->qty;}}?>
<tr>
	  <td colspan="3" valign="top"><div align="right"><strong>Total:</strong></div></td>
	  <td><strong>
	    <?=number_format($tqty,0);$tqty = 0;?>
	  </strong></td>
	  </tr>
	</tbody></table>
<br /><br />
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<tbody>

	<tr>
		<th>PO Date</th>
		<th>PO No</th>
		<th>MR No </th>
		<th>Vendor Name</th>
		<th>OQ</th>
		<th>RQ</th>
		<th>DQ</th>
	</tr>
<? 
if(isset($_POST['submitit'])){

$con ='';
if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= ' and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
if($_REQUEST['item']!=''){$item = explode('#>',$_REQUEST['item']);
if($item[1]>0){			
$item_id=$item[1];
$con .= ' and r.item_id="'.$item_id.'"';
}}



$res='select  distinct a.po_no, a.po_date, v.vendor_name,u.fname as entry_by,a.req_no
from 
purchase_master a, purchase_receive r, warehouse b, vendor v,user_activity_management u where u.user_id=a.entry_by and a.warehouse_id=b.warehouse_id and  a.vendor_id=v.vendor_id and a.po_no=r.po_no and a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' order by a.po_no asc';

$query = db_query($res);
while($data=mysqli_fetch_object($query))
{

?>
      <tr><td valign="top"><?=$data->po_date;?></td>
	    <td valign="top"><?=$data->po_no;?></td>
	    <td valign="top"><?=$data->req_no;?></td>
	    <td valign="top"><?=$data->vendor_name;?></td>
	  <td colspan="3">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:8px; border:0;">
<? 
$sql = 'select a.* from purchase_invoice a where   a.po_no="'.$data->po_no.'"';
$sqlq = db_query($sql);
while($info=mysqli_fetch_object($sqlq)){
?>
	<tr>
	  <td width="33%"><?=number_format($info->qty,0)?></td>
	  <td width="33%"><? $rq = find_a_field('purchase_receive','sum(qty)','order_no="'.$info->id.'"'); echo number_format($rq,0);?></td>
	  <td width="33%"><? $dq = $info->qty - $rq; if($dq>0) echo number_format($dq,0);?></td>
	</tr>
<? 
$tqty = $tqty + $info->qty;
$trq = $trq + $rq;
$tdq = $tdq + $dq;
}?>
</table>	  </td>
	</tr>
<? }}?>
<tr>
	  <td colspan="4" valign="top"><div align="right"><strong>Total:</strong></div></td>
	  <td><strong>
	    <?=number_format($tqty,0);?>
	  </strong></td>
	  <td><strong>
	    <?=number_format($trq,0);?>
	  </strong></td>
	  <td><strong>
	    <?=number_format($tdq,0);?>
	  </strong></td>
</tr>
	</tbody></table>
</div>
</td>
</tr>
</table>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>