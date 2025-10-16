<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Quotation Convert to PO';

do_calander('#fdate');
do_calander('#tdate');

$table = 'quotation_master';
$unique = 'quotation_no';
$status = 'UNCHECKED';

if(isset($_POST['convert'])){
 $quotation_no = $_POST['quotaiton_no'];
 $sql = 'select * from quotation_master where quotation_no="'.$quotation_no.'"';
 $pdata = mysqli_fetch_object(db_query($sql));
  $insert = 'insert into purchase_master(`group_for`,`po_date`,`vendor_id`,`req_no`,`quotation_no`,`quotation_date`,`warehouse_id`,`entry_by`,`entry_at`) value("'.$_SESSION['user']['group'].'","'.date('Y-m-d').'","'.$pdata->vendor_id.'","'.$pdata->req_no.'","'.$pdata->quotation_no.'","'.$pdata->quotation_date.'","'.$pdata->warehouse_id.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
 $master_insert = db_query($insert);
 $po_no = db_insert_id();
 
  $sql2 = 'select * from quotation_detail where quotation_no="'.$quotation_no.'"';
  $qu=db_query($sql2);
 while($data=mysqli_fetch_object($qu)){
   $details_insert = 'insert into purchase_invoice(`po_no`,`po_date`,`req_no`,`quotation_no`,`quotation_id`,`vendor_id`,`item_id`,`warehouse_id`,`rate`,`qty`,`amount`,`entry_by`,`entry_at`) value("'.$po_no.'","'.date('Y-m-d').'","'.$data->req_no.'","'.$quotation_no.'","'.$data->id.'","'.$data->vendor_id.'","'.$data->item_id.'","'.$data->warehouse_id.'","'.$data->quotation_price.'","'.$data->qty.'","'.($data->quotation_price*$data->qty).'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
  db_query($details_insert);
  
 }
 
$update = db_query('update quotation_master set is_po=1 where quotation_no="'.$quotation_no.'"');
$_SESSION['po_no'] = $po_no;

 
 echo 'Converted';
}
$target_url = '../quotation/mr_checking.php';

@session_destroy($_SESSION['quotation_no']);

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl,false);
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
      <input type="text" name="fdate" id="fdate" style="width:107px;" value="<? if($_POST['fdate'] !=''){ echo $_POST['fdate'];} else{ echo date('Y-m-01');}?>" />
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?php if($_POST['tdate'] !=''){ echo $_POST['tdate'];} else{ echo date('Y-m-d');}?>" />
    </strong></td>
    <td rowspan="2" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Warehouse Name: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><select name="warehouse_id" id="warehouse_id">
      <option selected="selected"></option>
      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],' 1 and use_type="WH"');?>
    </select></td>
    </tr>
</table>
</form>

</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabledesign">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){
$con .= ' and a.status="CHECKED"';

if($_POST['fdate']!=''&&$_POST['tdate']!=''){
$con .= 'and a.quotation_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
}
if($_POST['warehouse_id']!=''){
$con .= 'and b.warehouse_id = "'.$_POST['warehouse_id'].'"';
}
 $res='select  	a.quotation_no,a.quotation_no as quotation_no, DATE_FORMAT(a.quotation_date, "%d-%m-%Y") as quotation_date,  v.vendor_name as vendor_name,  c.fname as entry_by, a.entry_at,a.status from quotation_master a,user_activity_management c, vendor v where a.vendor_id=v.vendor_id  and a.entry_by=c.user_id  '.$con.' and a.is_po!=1  order by a.quotation_no';

$qry = db_query($res);

}
?>
</div></td>
</tr>

<tr>
  <th>Sl</th>
  <th>Quotation No</th>
  <th>Quotation Date</th>
  <th>Vendor Name</th>
  <th>Action</th>
</tr>
<?
while($data=mysqli_fetch_object($qry)){
?>
<tr>
  <td><?=++$i?></td>
  <td><?=$data->quotation_no?></td>
  <td><?=$data->quotation_date?></td>
  <td><?=$data->vendor_name?></td>
  <td>
  <form action="" method="post">
	  <input type="hidden" name="quotaiton_no" value="<?=$data->quotation_no?>" />
	  <input type="submit" name="convert" id="convert" value="Convert to PO" class="btn btn-primary" />
  </form>		  
  </td>
</tr>
<? } ?>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>