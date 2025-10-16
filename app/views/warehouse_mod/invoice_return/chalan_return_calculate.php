<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Delivery Challan Confirmation';
do_calander('#so_date');
do_calander('#chalan_date');
$table_master='sale_do_master';
$table_details='sale_do_details';
$unique='do_no';
$chalan_no = $_GET['chalan_no'];
$$unique=$_SESSION['rcl_do_no'];
$chalan_all = find_all_field('sale_do_chalan','','chalan_no="'.$chalan_no.'"');
$_SESSION[$unique]=$$unique;
if(isset($_POST['confirmm']))
{
unset($_POST);
$_POST[$unique]=$$unique;
$_POST['edit_by']=$_SESSION['user']['id'];
$_POST['edit_at']=date('Y-m-d h:i:s');
$_POST['status']='PROCESSING';
$crud   = new crud($table_master);
$crud->update($unique);
unset($$unique);
unset($_SESSION[$unique]);
$type=1;
$msg='Successfully Completed All Purchase Order.';
echo '<script>window.location.replace("select_unfinished_do.php")</script>';
}
if(isset($_POST['return']))
{
$remarks = $_POST['return_remarks'];
unset($_POST);
$_POST[$unique]=$$unique;
$_POST['status']='MANUAL';
$_POST['checked_at'] = date('Y-m-d H:i:s');
$_POST['checked_by'] = $_SESSION['user']['id'];
$crud   = new crud($table_master);
$crud->update($unique);
$note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique.'","CHALAN","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
db_query($note_sql);
unset($$unique);
unset($_SESSION[$unique]);
$type=1;
echo $msg='<span style="color:green;">Successfully Returned</span>';
echo '<script>window.location.replace("select_wo_for_challan.php")</script>';
}
if(isset($_POST['delete']))
{
unset($_POST);
$_POST[$unique]=$$unique;
$_POST['edit_by']=$_SESSION['user']['id'];
$_POST['edit_at']=date('Y-m-d H:i:s');
$_POST['status']='CHECKED';
$crud   = new crud($table_master);
$crud->update($unique);
unset($$unique);
unset($_SESSION[$unique]);
$type=1;
$msg='Order Returned.';
}
if(prevent_multi_submit()){
			if(isset($_POST['confirm'])){
					$entry_by = $_SESSION['user']['id'];
					$entry_at = date('Y-m-d H:i:s');
					$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);
					$sql='select a.*,a.id,a.order_no,a.do_no, a.item_id,  a.unit_price, b.item_name,  b.unit_name,  a.total_unit as qty 
					from sale_do_chalan a,item_info b, item_sub_group s where b.item_id=a.item_id 
					and b.sub_group_id=s.sub_group_id and a.status in ("CHECKED","COMPLETED") and a.chalan_no='.$chalan_no;
					$query = db_query($sql);
					//$pr_no = next_pr_no($warehouse_id,$rec_date);
					while($data=mysqli_fetch_object($query))
					{
					if($_POST['chalan_'.$data->id]>0)
					{
					$qty='-'.$_POST['chalan_'.$data->id];
					$total_return_qty +=$_POST['chalan_'.$data->id];
					$rate=$_POST['rate_'.$data->id];
					$item_id =$_POST['item_id_'.$data->id];
					$amount = ($qty*$rate); 
					echo $cost_amt = ($qty*$data->cost_price); 
					 $so_invoice = 'INSERT INTO sale_do_chalan (year, ch_id, chalan_no, chalan_date, order_no, do_no, job_no, do_date, item_id, dealer_code, unit_price, pkt_size, pkt_unit, dist_unit, total_unit, total_amt, discount, depot_id, group_for, rec_name, rec_mob, vehicle_no, driver_name, driver_mobile, delivery_point, delivery_man, delivery_man_mobile, entry_by, entry_at, status, cost_price, cost_amt)
					VALUES("'.$data->year.'","'.$data->ch_id.'","'.$data->chalan_no.'","'.$data->chalan_date.'","'.$data->order_no.'","'.$data->do_no.'","'.$data->job_no.'","'.$data->do_date.'","'.$data->item_id.'","'.$data->dealer_code.'","'.$data->unit_price.'","'.$data->pkt_size.'","'.$data->pkt_unit.'","'.$qty.'","'.$qty.'","'.$amount.'","'.$data->discount.'","'.$data->depot_id.'","'.$data->group_for.'","'.$data->rec_name.'","'.$data->rec_mob.'","'.$data->vehicle_no.'","'.$data->driver_name.'","'.$data->driver_mobile.'","'.$data->delivery_point.'","'.$data->delivery_man.'","'.$data->delivery_man_mobile.'","'.$entry_by.'","'.$entry_at.'","CHECKED", "'.$data->cost_price.'", "'.$cost_amt.'")';
					db_query($so_invoice);
					journal_item_control($item_id, $data->depot_id, $data->chalan_date,  0, $qty, 'Sales', $data->id, $rate, '', $chalan_no, '', '',$ms_data->group_for, $rate->unit_price, '' );
					$d_qty = find_a_field('sale_do_details','sum(total_unit)','do_no="'.$data->do_no.'"');
					$c_qty = find_a_field('sale_do_chalan','sum(total_unit)','do_no="'.$data->do_no.'"');
					if($d_qty>$c_qty){
					$master_update = 'update sale_do_master set status="COMPLETED" where do_no="'.$data->do_no.'"';
					db_query($master_update);
					}
					}
					}
					if($total_return_qty>0 && $chalan_no>0){
					$delete = 'delete from secondary_journal where tr_no="'.$chalan_no.'" and tr_from in ("Sales","COGS")';
					db_query($delete);
					$delJournal='delete from journal where tr_no="'.$chalan_no.'" and tr_from in ("Sales","COGS")';
					db_query($delJournal);
					auto_insert_sales_chalan_secoundary($chalan_no);
					}
					$folder = 'chalan';
					$field_name = 'chalan_copy';
					$file_name = $chalan_no;
					$uploaded_file_name=upload_file($folder,$field_name,$file_name);
					$update = 'update sale_do_chalan set status="COMPLETED" where chalan_no="'.$chalan_no.'"';
					db_query($update);
					$_SESSION['cmsg'] = '<span style="color:green;">Chalan Confirmed Successfully</span>';
					
					header('location:chalan_return.php');
					
}
}
else
{
$type=0;
$msg='Data Re-Submit Warning!';
}
if($$unique>0)
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table_master,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}
//if($delivery_within>0)
//{
//	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);
//}
?>
<script>
function calculation(id){
var chalan=((document.getElementById('chalan_'+id).value)*1);
var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);
if(chalan>pending_qty)
{
alert('Can not issue more than pending quantity.');
document.getElementById('chalan_'+id).value='';
} 
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}" enctype="multipart/form-data">
<!--  top form start hear-->
<div class="d-flex justify-content-center pt-5 pb-2">
<div class="n-form1 fo-white pt-0 p-0">
<div class="container p-0">
<table class="table1  table-striped table-bordered table-hover table-sm">
<tr>
<td colspan="3" align="center"><strong>Entry Information</strong></td>
</tr>
<tr>
<td align="right" >Created By:</td>
<td align="left" >&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$chalan_all->entry_by);?></td>
<td rowspan="2" align="center" ><a title="WO Preview" target="_blank" href="delivery_challan_print_view.php?v_no=<?=$chalan_no?>" ><img src="../../../images/print.png" alt="" width="30" height="30" /></a></td>
</tr>
<tr>
<td align="right" >Created On:</td>
<td align="left">&nbsp;&nbsp;<?=$chalan_all->entry_at?></td>
</tr>
</table>
</div>
</div>
</div>
<div class="container-fluid bg-form-titel">
<div class="row">
<!--left form-->
<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
<div class="container n-form2">
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan Date </label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
<input name="chalan_date" type="text" id="chalan_date" required="required" value="<?=$chalan_all->chalan_date?>" readonly="readonly"/>
</div>
</div>
<div class="form-group row m-0 pb-1">
<label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vehicale No</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
<input name="vehicle_no" type="text" id="vehicle_no" value="<?=find_a_field('vehicle_info','vech_reg_no','vehicle_id="'.$chalan_all->vehicle_no.'"');?>" readonly="readonly" />
</div>
</div>
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Point</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
<input  name="delivery_point" type="text" id="delivery_point" value="<?=$chalan_all->delivery_point;?>" readonly="readonly" />
</div>
</div>
</div>
</div>
<!--Right form-->
<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
<div class="container n-form2">
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receiver Name</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
<input  name="rec_name" type="text" value="<?=$chalan_all->rec_name;?>" id="rec_name" readonly="readonly" />
</div>
</div>
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Driver Name</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
<input name="driver_name" type="text" id="driver_name" value="<?=$chalan_all->driver_name;?>" readonly="readonly"  />
</div>
</div>
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Man</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
<input  name="delivery_man" type="text" id="delivery_man" value="<?=$chalan_all->delivery_man;?>" readonly="readonly"  />
</div>
</div>
</div>
</div>
<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
<div class="container n-form2">
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receiver Mobile </label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
<input   name="rec_mob" value="<?=$chalan_all->rec_mob;?>"  type="text" id="rec_mob" readonly="readonly" />
</div>
</div>
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Driver Mobile</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
<input  name="driver_mobile"  type="text" id="driver_mobile" value="<?=$chalan_all->driver_mobile;?>" readonly="readonly" />
</div>
</div>
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delivery Man Mobile</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
<input  name="delivery_man_mobile" type="text" id="delivery_man_mobile" value="<?=$chalan_all->delivery_man_mobile;?>" readonly="readonly"  />
</div>
</div>
</div>
<div class="container n-form2">
<div class="form-group row m-0 pb-1" align="center">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Received Chalan Copy</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
<input  name="chalan_copy"  type="file" id="chalan_copy"/>
</div>
</div>
</div>
</div>
</div>
</div>
<!--return Table design start-->
<div class="container-fluid pt-5 p-0 ">
<?
$sql='select a.id,a.order_no,a.do_no,a.unit_price, a.item_id,  a.unit_price, b.item_name,  b.unit_name,  a.total_unit as qty 
from sale_do_chalan a,item_info b, item_sub_group s where b.item_id=a.item_id 
and b.sub_group_id=s.sub_group_id and a.status="CHECKED" and a.chalan_no='.$chalan_no;
$res=db_query($sql);
?>
<table class="table1  table-striped table-bordered table-hover table-sm">
<thead class="thead1">
<tr class="bgc-info">
<th>SL</th>
<th>Order No.</th>
<th>Item Name </th>
<th>UOM</th>
<th>Order Qty </th>
<th>Delivered</th>
<th>Return</th>

</tr>
</thead>
<tbody class="tbody1">
<? while($row=mysqli_fetch_object($res)){$bg++?>
<tr>
<td><?=++$ss;?></td>
<td><?=$row->do_no?>
<td align="left"><?=$row->item_name?>
<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>
<td align="center"><?=$row->unit_name?>                </td>
<td align="center"><?=find_a_field('sale_do_details','sum(total_unit)','id="'.$row->order_no.'" and item_id="'.$row->item_id.'" and do_no="'.$row->do_no.'"');?></td>
<td align="center"><?=number_format($row->qty,2);?></td>
<td align="center"><input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value=""   onKeyUp="calculation(<?=$row->id?>)" /></td>

</tr>
<? }?>
</tbody>
</table>
</div>
<!--button design start-->
<div class="container-fluid p-0 ">
<div class="n-form-btn-class">
<? 
if($chalan_all->status=="COMPLETED"){
$vars['status']='COMPLETED';
db_update($table_master, $do_no, $vars, 'do_no');
?>
<div class="alert alert-success p-2" role="alert">
THIS  SALES ORDER IS COMPLETE
</div>
<? }else{
$chalaned = find_a_field('sale_do_chalan','sum(dist_unit)','do_no="'.$do_no.'"');
if($chalaned>0){
?>
<input name="confirm" type="submit" class="btn1 btn1-submit-input" value="CONFIRM CHALLAN" /></td>
<? } else{?>
<input name="return" type="submit" class="btn1 btn1-bg-cancel" value="RETURN" onclick="return_function()" />
<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/><input type="hidden" name="return_remarks" id="return_remarks"></td>
<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM CHALLAN"  />
<? } }?>
</div>
</div>
</form>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<script>
function return_function() {
var notes = prompt("Why Return This?","");
if (notes!=null) {
document.getElementById("return_remarks").value =notes;
document.getElementById("cz").submit();
}
return false;
}
</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";


?>