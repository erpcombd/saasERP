<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='New Finished Goods Issue';

$page = "fg_issue.php";

$ajax_page = "fg_issue_ajax.php";

$page_for = 'fg_transfer';

do_calander('#st_date','-0','+0');

$table_master='fg_transfer_master';

$table_details='fg_transfer_details';

$unique='st_no';



if($_GET['res']==1){

unset($_SESSION[$unique]);

}



if(isset($_GET['st_no']) && $_GET['st_no']>0){

$_SESSION[$unique]=$_GET['st_no'];

}

if(isset($_POST['new']))

{

if($_POST['st_date']==date('Y-m-d')) {

$crud   = new crud($table_master);

if(!isset($_SESSION[$unique])) {

$_POST['Issue_type'] = $page_for;

$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d H:i:s');

//	$_POST['edit_by']=$_SESSION['user']['id'];

//$_POST['edit_at']=date('Y-m-d H:i:s');

$_POST['status']='MANUAL';

$$unique=$_SESSION[$unique]=$crud->insert();

unset($$unique);

$type=1;

$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';

}

else {

$_POST['edit_by']=$_SESSION['user']['id'];

$_POST['edit_at']=date('Y-m-d H:i:s');

$crud->update($unique);

$crud   = new crud($table_details);

$crud->update($unique);

$type=1;

$msg='Successfully Updated.';

}

}

else {

echo '<script>alert("Please Entry Current Date")</script>';

}

}

$$unique=$_SESSION[$unique];

if(isset($_POST['delete']))

{

$crud   = new crud($table_master);

$condition=$unique."=".$$unique;		

$crud->delete($condition);

$crud   = new crud($table_details);

$condition=$unique."=".$$unique;		

$crud->delete_all($condition);

unset($$unique);

unset($_SESSION[$unique]);

$type=1;

$msg='Successfully Deleted.';

}

if($_GET['del']>0)

{

$crud   = new crud($table_details);

$condition="id=".$_GET['del'];		

$crud->delete_all($condition);

//	$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";

//	db_query($sql);

$type=1;

$msg='Successfully Deleted.';

}

if(isset($_POST['confirmm']))

{

unset($_POST);

$_POST[$unique]=$$unique;



$sql='select d.id,d.st_no,d.item_id,d.rate,d.qty,d.amount,m.warehouse_from,m.warehouse_to,m.st_date from fg_transfer_master m, fg_transfer_details d where m.st_no=d.st_no and d.st_no='.$$unique;

$query=db_query($sql);

while($databy=mysqli_fetch_object($query)){

//journal_item_control($databy->item_id ,$databy->warehouse_from,$databy->st_date,0,$databy->qty,'fg_transfer',$databy->st_no,$databy->rate,0,$databy->id,'','',$_SESSION['user']['group'],'');



//journal_item_control($databy->item_id ,$databy->warehouse_to,$databy->st_date,$databy->qty,0,'fg_transfer',$databy->st_no,$databy->rate,0,$databy->id,'','',$_SESSION['user']['group'],'');



}





$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d H:i:s');

$_POST['status']='PENDING';

$crud   = new crud($table_master);

$crud->update($unique);

unset($$unique);

unset($_SESSION[$unique]);

$type=1;

$msg='Successfully Forwarded.';

/*echo '<script> window.location.assign("../fg_transfer/fg_issue.php"); </script>';*/

}

if(isset($_POST['add'])&&($_POST[$unique]>0) && $_SESSION['csrf_token']===$_POST['csrf_token'])

{
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
if($_POST['rate']>0){

$crud   = new crud($table_details);

$iii_from=explode('#>',$_POST['item_id']);

//$iii_to=explode('#>',$_POST['item_id_to']);

//	$rate_from =explode('##>',$_POST['item_id']);

//$rate_to =explode('##>',$_POST['item_id_to']);

$_POST['item_id']=$iii_from[1];

//$_POST['item_id_to']=$iii_to[1];

$_POST['qty'] =( $_POST['pkt_size'] * $_POST['ctn'] ) + $_POST['pcs'];;

//$_POST['rate'] =$rate_from[1];

//	$_POST['rate_to'] =$rate_to[1];

//$_POST['amount'] =( $_POST['qty'] * );

//	$_POST['amount_to'] =( $_POST['qty'] * $rate_to[1] );

$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d H:i:s');

$_POST['edit_by']=$_SESSION['user']['id'];

$_POST['edit_at']=date('Y-m-d H:i:s');

$xid = $crud->insert();

//	journal_item_control($_POST['item_id'] ,$_POST['warehouse_from'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);

}

else {

echo '<script>alert("Rate Not Found.Please Entry Production Report.")</script>';

}

}

if($$unique>0)

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table_master,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

if($$unique>0) $btn_name='Update OI Information'; else $btn_name='Initiate OI Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);

$short_code = find_a_field('warehouse','short_code','warehouse_id='.$warehouse_from);

//if($short_code=='BK'){

//	$con = '  and  brand_category="Bakeries"';

//}

//else if($short_code=='DR' || $short_code=='ED'){

//	$con = '  and  brand_category="Drinks & Juice"';

//}

//else if($short_code=='OL'){

//	$con = '  and  brand_category="Oil"';

//}

//else if($short_code=='PK'){

//	$con = '  and  brand_category="Pickle"';

//}

//else if($short_code=='BK'){

//	$con = '  and  brand_category="Protik Food"';

//}

//else if($short_code=='RI'){

//	$con = '  and  brand_category="Rice"';

//}

//else if($short_code=='SH'){

//	$con = '  and  brand_category="Shemai"';

//}

//else if($short_code=='SN'){

//	$con = '  and  brand_category="Snacks"';

//}

//else if($short_code=='SP'){

//	$con = '  and  brand_category="Spices"';

//}

//else if($short_code=='BK'){

//	$con = '  and  brand_category="Tasty Food"';

//}

//else {

//	$con = '';

//}

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id,"#>",finish_goods_code)','','item_id');

//auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id,"#>",finish_goods_code,"##>",cost_price)','','item_id_to');

?>

<script language="javascript">

function focuson(id) {

if(document.getElementById('item_id').value=='')

document.getElementById('item_id').focus();

else

document.getElementById(id).focus();

}

window.onload = function() {

if(document.getElementById("warehouse_from").value>0)

document.getElementById("item_id").focus();

else

document.getElementById("req_date").focus();

}

</script>

<script language="javascript">

function count(){

var pkt_size =((document.getElementById('pkt_size').value)*1);

var pcs=((document.getElementById('pcs').value)*1);

var ctn = ((document.getElementById('ctn').value)*1);

var qty = (ctn * pkt_size)+ pcs;

var rate = ((document.getElementById('rate').value)*1); 

var amt = qty * rate;

document.getElementById('amount').value = amt.toFixed(2);	

}

function sub_group_function(id){

document.getElementById('sub_group_id').value=id;

window.location.href = "../stock_transfer/st_issue.php?sub_group=" + id;

}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<div class="container-fluid bg-form-titel">

<div class="row n-form2 m-0">

<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

<div class="form-group  row  p-2 m-0">

<? $field='st_no';?>

<label  for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">S T  No: </label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

</div>

</div>

</div>

<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

<div class="form-group row p-2 m-0">

<? $field='st_date'; if($st_date=='') $st_date =date('Y-m-d'); ?>

<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">ST Date: </label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly/>

</div>

</div>

</div>

<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

<div class="form-group row p-2 m-0">

<? $field='warehouse_from'; if($warehouse_from=='') $warehouse_from =''; ?>

<label  for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse From: </label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">    

<select  name="<?=$field?>" id="<?=$field?>"   onchange="getData2('manual_req_no_ajax.php', 'manual_req_no', this.value, document.getElementById('st_no').value);" required >

<option></option>

<? foreign_relation('warehouse','warehouse_id','warehouse_name',$$field,'1 and use_type="SC" order by warehouse_name asc');?>

</select>

</div>

</div>

</div>

<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

<div class="form-group row p-2 m-0">

<? $field='warehouse_to';?>

<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse To: </label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

<!--<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>-->

<select required name="<?=$field?>" id="<?=$field?>">

<option></option>

<? foreign_relation('warehouse','warehouse_id','warehouse_name',$$field,'1 and use_type!="PL" order by warehouse_name asc');?>

</select>

<?php /*?>    <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>

<?php */?>

</div>

</div>

</div>

<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

<div class="form-group row p-2 m-0">

<? $field='st_details';?>

<label  for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note :</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

</div>

</div>

</div>

<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

<div class="form-group row  p-2 m-0">

<? $field='manual_req_no';?>

<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Line ST No :</label>

<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

<span id="manual_req_no">

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

</span>

</div>

</div>

</div>

</div>

</div>

<div class="n-form-btn-class">

<input name="new" type="submit" value="<?=$btn_name?>" class="btn1 btn1-bg-submit"/>

</div>

</form>

<? if($_SESSION[$unique]>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<div class="container-fluid pt-5 p-0">

<table class="table1  table-striped table-bordered table-hover table-sm">

<thead class="thead1">

<tr class="bgc-info">

<td width="15%" rowspan="2" align="center"><strong>Transfer Item  </strong></td>

<td width="4%" rowspan="2" align="center"><strong>Stock</strong></td>

<td width="5%" rowspan="2" align="center"><strong>Unit</strong></td>

<td width="5%" rowspan="2" align="center" >Rate</td>

<td colspan="2" align="center">Qty</td>

<td align="center" width="5%" rowspan="2">Remarks</td>

<td align="center" width="5%" rowspan="2">Amount</td>

<td width="10%"  rowspan="3" align="center"> Action</td>

</tr>

<tr class="bgc-info">

<td width="5%" align="center">Ctn</td>

<td width="5%" align="center"><strong>PCS/KG</strong></td>

</tr>

</thead>

<tbody class="tbody1">

<tr>

<td align="center">

<input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>

<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>

<input  name="st_date" type="hidden" id="st_date" value="<?=$rp_date?>"/>

<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:180px;" required  onblur="getData2('<?=$ajax_page?>', 'po',this.value,document.getElementById('warehouse_from').value);" />

</td>

<td colspan="3" align="center" bgcolor="#CCCCCC">

<span id="po" style="display:flex;">

<input name="stk" type="text" class="input3" id="stk" style="width:50px;" readonly="readonly"/>

<input name="rate" type="text" class="input3" id="rate"  style="width:50px;"  value="<?=$issue_price;?>" onchange="count()"  readonly="readonly">

<input name="unit" type="text" class="input3" id="unit" style="width:50px;" readonly="readonly"/>

<input name="pkt_size" type="hidden" class="input3" id="pkt_size" style="width:50px;" readonly="readonly" required="required" value="<?=$item_all->pack_size?>" onfocus="focuson('qty')"/>

</span>

</td>

<td align="center" bgcolor="#CCCCCC"><input name="ctn" type="text" class="input3" id="ctn"  maxlength="100" style="width:60px;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="pcs" type="text" class="input3" id="pcs"  maxlength="100" style="width:60px;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="remarks" type="text" class="input3" id="remarks"   style="width:60px;"/></td>

<td align="center" ><input name="amount" type="text" class="input3" id="amount"  maxlength="100" style="width:60px;" onchange="count()" readonly="readonly"/></td>

<td><input name="add" type="submit" id="add" value="ADD" tabindex="12" class="btn1 btn1-bg-submit p-2"/></td>

</tr>

</tbody>

</table>

</div>

<div class="container-fluid tabledesign2 pt-5 p-0">

<? 


$res='select a.id,(SELECT item_name from item_info where item_id = a.item_id)as Item_From,a.unit_name,a.qty,a.rate,a.amount,remarks,"x" from fg_transfer_details a,item_info b where b.item_id=a.item_id and a.st_no='.$st_no;

echo link_report_add_del_auto($res );

?>

</div>

</form>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<div class="n-form-btn-class">

<input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD RD" />

</div>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>