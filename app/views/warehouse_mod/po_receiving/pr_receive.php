<?php

ob_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
$title='GRN Confirmation';
do_calander('#rec_date');
$table_master='purchase_master';
$table_details='purchase_receive';

$pr=$_GET['pr_no'];
$rcv_all= find_all_field('purchase_receive','','pr_no='.$pr.'');
$pono=$rcv_all->po_no;
 $unique='pr_no';
$po_master= find_all_field('purchase_master','','po_no='.$rcv_all->po_no.'');
$po_no=$rcv_all->po_no;
if($_SESSION[$unique]>0)
$$unique=$_SESSION[$unique];
if($_REQUEST[$unique]>0){
$$unique=$_REQUEST[$unique];
$_SESSION[$unique]=$$unique;}
else
$$unique = $_SESSION[$unique];

if(isset($_POST['return'])){
$remarks = $_POST['return_remarks'];
unset($_POST);
$_POST[$unique]=$$unique;
$_POST['edit_by']=$_SESSION['user']['id'];
$_POST['edit_at']=date('Y-m-d h:s:i');
$_POST['status']='MANUAL';
$crud   = new crud($table_master);
$crud->update($unique);
$note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique.'","PR","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
db_query($note_sql);
unset($$unique);
unset($_SESSION[$unique]);
$type=1;
header('location:select_upcoming_po_QC_process.php');
}

if(prevent_multi_submit()){
if(isset($_POST['confirm'])){
$group_for = $_POST['group_for'];
$vendor_id = $_POST['vendor_id'];


$warehouse_id = $_POST['warehouse_id'];
$qc_by=$_POST['qc_by'];
$ch_no=$_POST['ch_no'];
$transport_charge=$_POST['transport_charge'];
$other_charge=$_POST['other_charge'];
$remarks=$_POST['remarks'];
$rec_date=$_POST['rec_date'];
$rec_no= find_a_field('purchase_receive','max(rec_no)','po_no="'.$po_no.'"')+1;
$now = date('Y-m-d H:s:i');
$pr_no = $pr; 
//next_transection_no('0',$rec_date,'purchase_receive','pr_no');
  $sql = 'select * from purchase_receive where pr_no = '.$pr;
$tot_po_qty=

$query = db_query($sql);
	
while($data=mysqli_fetch_object($query)){

if(($_POST['chalan_'.$data->id]>0)){
	$qty=$_POST['chalan_'.$data->id];
	$reel_qty=$_POST['reel_qty_'.$data->id];
	
	$rate=$_POST['rate_'.$data->id];
	$item_id =$_POST['item_id_'.$data->id];
	$unit_name =$data->unit_name;
	$amount = ($qty*$rate);
	$total = $total + $amount;

$group_for = $data->group_for;
$warehouse_id = $data->warehouse_id;


//if ($data->qty != $qty) {
//    $cqty = $data->qty - $qty;
//    $amounc = $cqty * $date->rate;
//     $qc = "INSERT INTO `purchase_qc_claim` (`pr_no`, `po_no`, `qty`, `rate`, `entry_by`) 
//           VALUES ('".$pr."', '".$data->po_no."', '".$cqty."', '".$rate."', '".$_SESSION['user']['id']."')";
//    db_query($qc);
//}


    $q = "UPDATE purchase_receive SET
      status='Received',
      other_charge='".$other_charge."',
      transport_charge='".$transport_charge."',
      rec_date='".$rec_date."',
      remarks='".$remarks."',
      qty='".$qty."',

      amount='".$amount."'
      WHERE `pr_no` ='".$pr."' and id='".$data->id."'";

db_query($q);
$xid = $data->id;
$narration="Purchase Receive From (Vendor:".$_POST['vendor_name']." ) (CH NO: ".$ch_no.")";
journal_item_control($item_id, $warehouse_id, $rec_date, $qty,0, 'Purchase', $xid, $data->rate, '', $pr_no, '', '',$group_for, $data->rate, '',$narration);
$tr_from="Purchase";
$tr_no=$pr_no;
$tr_id=$data->id;                                                                                        
$tr_type="Add";
}
}

auto_insert_purchase_secoundary_journal($pr_no);


//echo '<script>window.location.href = "select_upcoming_po_QC_proccess.php"; 
header("Location: po_receive_confirm.php");

}
}
else{
$type=0;
$msg='Data Re-Submit Warning!';
}


?>
<script>
function cal2(id) {
var grn_qty = ((document.getElementById('chalan_'+id).value)*1);
var unrec_qty = ((document.getElementById('unrec_qty_'+id).value)*1);
if(grn_qty>unrec_qty)
{
alert('Can not Receive More than Unreceive Qty.');
document.getElementById('chalan_'+id).value='';
document.getElementById('chalan_'+id).focus();
}
}
</script>
<!--Mr create 2 form with table-->
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}" enctype="multipart/form-data">

<div class="container-fluid bg-form-titel">
<div class="row">
<!--left form-->
<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
<div class="container n-form2">
<div class="form-group row m-0 pb-1">
<label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">MRR No.</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
<input  name="pr_no" type="text" id="pr_no" value="<?=$rcv_all->pr_no?>" readonly=""/>
</div>
</div>
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Rec Date </label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
<input name="rec_date" type="text" id="rec_date" value="<?=$rcv_all->rec_date?>"  required="required"  readonly=""/>
</div>
</div>


</div>
</div>
<!--Right form-->
<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
<div class="container n-form2">
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">QC By </label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
<input  name="qc_by" type="text" id="qc_by" value="<?=$rcv_all->qc_by?>" />
</div>
</div>
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor Name</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
<input  name="vendor_name" type="text" id="vendor_name" value="<?php echo find_a_field('vendor','vendor_name','vendor_id="'.$rcv_all->vendor_id.'"');?>" readonly="" />
</div>
</div>

</div>
</div>
<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
<div class="container n-form2">
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan No </label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
<input  name="ch_no" type="text" id="ch_no" value="<?=$rcv_all->ch_no?>" readonly="" />
</div>
</div>
<div class="form-group row m-0 pb-1">
<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>
<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
<input  name="remarks" type="text" id="remarks" value="<?=$rcv_all->remarks?>" readonly=""/>
</div>
</div>

</div>
</div>
</div>
</div>
<!--return Table design start-->
<div class="container-fluid pt-5 p-0 ">
<? if($unique>0){
$sqlinvo='select a.id,a.item_id,a.qty,a.rate from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$rcv_all->po_no.'';
$resinvo=db_query($sqlinvo);
while($rowinvo=mysqli_fetch_object($resinvo)){
$qtyinvo[$rowinvo->item_id]=$rowinvo->qty;
}
   $sql='select a.id,a.item_id,b.item_name,a.status,b.unit_name,a.qty,a.rate,a.is_complete from purchase_receive a,item_info b where b.item_id=a.item_id and a.pr_no='.$rcv_all->pr_no.'';
$res=db_query($sql);
$s=1;
?>
<table class="table1  table-striped table-bordered table-hover table-sm">
<thead class="thead1">
<tr class="bgc-info">
<th>SL</th>
<th>Item Code</th>
<th>Item Name</th>
<th>Unit</th>
<th>Ordered</th>
<th>Recd</th>
<th>UnRecd</th>
<th>Stock Unit</th>
<th>Approved</th>
</tr>
</thead>
<tbody class="tbody1">
<? while($row=mysqli_fetch_object($res))

{?>
<tr>
<td><?=++$ss;?></td>
<td><?=$row->item_id?>
<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>
<td align="left"><?=$row->item_name?> 
<input  type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" style="width:90px; float:none" /></td>
<td align="center"><?=$row->reel_unit?>
<input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>
<td align="center">  <?=$qtyinvo[$row->item_id];?></td>
<td align="center"><? echo $row->qty;?></td>
<td align="center"><? echo $unrec_qty= $qtyinvo[$row->item_id]-$row->reel_qty;
//echo $unrec_qty_reel= $qtyinvo[$row->item_id]-$row->reel_qty;
?>

<input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$row->qty?>" /></td>
<td align="left"><?=$row->unit_name?> </td>
<td align="center" class="text-center"><? if($row->status =="Pending"){ ?>
<input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>"  class="text-center" value="<?=$row->qty;?>" onkeyup="cal2(<?=$row->id?>)" style="width:50%" />
<? }  else echo 'Done';?></td>
</tr>
<? }  $status=$row->status;?>
</tbody>
</table>
</div>
<!--button design start-->

<? }  ?>

<div class="container-fluid p-0">
<div class="n-form-btn-class">
<? 
$check=find_a_field('purchase_receive','status','pr_no='.$pr.'');

 if ($check=="Received"){?>
<div class="alert alert-success p-2" role="alert">
THIS MRR IS NOT IN THIS LAYER
</div>
<? }else{?>
<input  name="po_no" type="hidden" id="po_no" value="<?=$po_no?>"/><input type="hidden" name="return_remarks" id="return_remarks">
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/>
<input name="confirm" type="submit" class="btn btn-primary" value="Confirm"  />
<? }?>
</div>
</div>

</form>
</div>
<br /><br />

<script>$("#codz").validate();$("#cloud").validate();</script>
<script>
function return_function() {
var notes = prompt("Why Return This PO?","");
if (notes!=null) {
document.getElementById("return_remarks").value =notes;
document.getElementById("codz").submit();
}
return false;
}
</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>