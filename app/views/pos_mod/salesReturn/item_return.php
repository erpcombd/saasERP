<?php

require_once "../../../assets/template/layout.top.php";

$title='New Item Return';
$page_for = 'PosReturn';

//do_calander('#or_date','-100','0');

do_calander('#quotation_date');

do_calander('#receive_date');

$table_master='warehouse_other_receive';

$table_details='warehouse_other_receive_detail';

$unique='or_no';
if($_GET['pos_id']>0){
$_SESSION['pos_id']=$_GET['pos_id'];
}
if($_POST['or_no']>0){
	$$unique = $_POST['or_no'];
	}

$dealer = ($vendor_id>0)?$vendor_id:$dealer;

if($_POST['dealer']>0) $dealer = $_POST['dealer'];

if(isset($_POST['new']))

{

		$crud   = new crud($table_master);



		if(!isset($_SESSION[$unique])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');
		
		$_POST['manual_or_no'] = $_SESSION['pos_id'];

		

		

		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;

		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}


if($_POST['or_no']>0){
	$$unique = $_POST['or_no'];
	$_SESSION[$unique] = $$unique;
	}else{

$$unique=$_SESSION[$unique];
	}



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

		

		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";

		mysql_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

		

}

if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='UNCHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';

}



if(isset($_POST['add'])&&($_POST[$unique]>0))

{


       
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[1];
		$item_type = find_a_field('item_info','product_type','item_id="'.$iii[1].'"');
		if($item_type=='Serialized'){
		$check_serial = find_a_field('journal_item','serial_no','serial_no="'.$_POST['serial_no'].'" and item_id="'.$iii[1].'"');
		}else{
		$check_serial = 'Non-serialized';
		}
        if($check_serial!=''){
		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$item = find_all_field('item_info','','item_id="'.$_POST['item_id'].'"');

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['or_date'],$_POST['qty'],0,'Return',$xid,$_POST['rate'],'',$_POST[$unique]);

		$chalan_no=$_POST['or_details'];

$ssql = 'select m.do_no,m.do_date, d.* from sale_do_details d,sale_do_chalan c,sale_do_master m where d.id=c.order_no and d.gift_on_item = "'.$_POST['item_id'].'" and c.chalan_no="'.$_POST['or_details'].'" and c.do_no=m.do_no';

$order=find_all_field_sql($ssql);




}else{
 $msg = '<span style="color:red; font-weight:bold;">Invalid Serial No. Please try again with correct information!</span>';
}
}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}



if($$unique>0) $btn_name='Update SR Information'; else $btn_name='Initiate SR Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

$dealer = ($vendor_id>0)?$vendor_id:$dealer;




$pos_info = find_all_field('sale_pos_master','','pos_id="'.$_SESSION['pos_id'].'"');


auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','1','item_id');

?>

<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}

window.onload = function() {

if(document.getElementById("warehouse_id").value>0)

  document.getElementById("item_id").focus();

  else

  document.getElementById("req_date").focus();

}

</script>

<script language="javascript">

function count()

{

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}
function quantity_check(id) {
 var price = ((document.getElementById('price'+id).value)*1);
  var ret_qty = ((document.getElementById('ret_qty'+id).value)*1);

  var qty = ((document.getElementById('qty'+id).value)*1);
  var num=price*qty;
  document.getElementById('amount'+id).value = num.toFixed(2);	
  if(qty>ret_qty)
  {
alert('Can not Return More than POS Order Quantity');
document.getElementById('qty'+id).value='';
document.getElementById('qty'+id).focus();
  }

}
</script>


<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
					    <? $field='or_no';?>
						     <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">

Sales Return No:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

     					   <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" readonly="readonly"/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						    <? $field='or_date'; if($or_date=='') $or_date =date(''); ?>
							<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sales Return Date:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
       					 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<? if($$field=='') echo date('Y-m-d');else echo $$field?>" class="form-control" required/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						<? $field='receive_date'; if($receive_date=='') $receive_date =date(''); ?>
						     <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">POS Sales Date:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
							<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$pos_info->pos_date?>" class="form-control" readonly="readonly" />
							<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"   required class="form-control"/>
							<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"  class="form-control"/>

                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
						    <? $field='or_subject';?>
						    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

      							  <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" required/>

                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
							<? $field='vendor_name';?>
							<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field('dealer_pos','dealer_name','dealer_code='.$pos_info->dealer_id);?>" required="required" class="form-control" readonly="readonly"/>
        <input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$pos_info->dealer_id?>" class="form-control" required="required"/>

		                 </div>
                        </div>
						<div class="form-group row m-0 pb-1">
								<? $field='approved_by';?>
								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Received By :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field('user_activity_management','fname','user_id="'.$_SESSION['user']['id'].'"')?>" class="form-control" readonly="readonly" required/>

                            </div>
                        </div>


                    </div>



                </div>


            </div>

            <div class="n-form-btn-class">
			    <input name="new" type="submit" value="<?=$btn_name?>"  class="btn1 btn1-bg-submit"/>
            </div>
        </div>



</form>

<? if($_SESSION[$unique]>0){?>
		<div class="alert alert-success" role="alert" align="center">	  <?=$msg;?>	</div>
	<form action="select_pos_id.php" method="post" name="cloud" id="cloud">
        <!--Data multi Table design start-->
        <div class="container-fluid pt-5 p-0 ">

			<table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                   <th>Check</th>
                    <th>Item Name</th>
                    <th>Unit </th>

                    <th>Price</th>
                    <th>Qty</th>
					<th>Serial No</th>
                    <th>Amount</th>
                </tr>
                </thead>

                <tbody class="tbody1">
						<?
						  $sql = 'select p.*,i.item_name,i.unit_name  from sale_pos_details p, item_info i where i.item_id=p.item_id and p.pos_id="'.$_SESSION['pos_id'].'"';
						$qry = mysql_query($sql);
						while($data=mysql_fetch_object($qry)){
						if($data->product_type=='Serialized'){
						$old_qty = 1;
						}else{
						$old_qty = $data->qty; 
						}
						?>
						<tr>
						  <td align="center"><input type="checkbox" name="check<?=$data->id?>" id="check<?=$data->id?>" value="checked" style="width:20%;" /></td>
						
						<td align="center">
						
						<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
						
						<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
						
						<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
						
						<input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>
						
						<input  name="or_details" type="hidden" id="or_details" value="<?=$or_details?>"/>
						
						<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$pos_info->dealer_id?>"/>
						
						<input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>
						
						<input  name="item_id" type="hidden" id="item_id" value="<?=$data->item_id?>"/><?=$data->item_name?></td>
						
						<td><?=$data->unit_name?><input name="unit" type="hidden" class="input3" id="unit" style="width:100%;" value="<?=$data->unit_name?>" readonly/></td>
						<td><?=$data->rate?><input name="price<?=$data->id?>" type="hidden" class="input3" id="price<?=$data->id?>" style="width:100%;" value="<?=$data->rate?>"  readonly="readonly"/></td>
						<td align="center">
						<input name="ret_qty<?=$data->id?>" type="hidden" class="input3" id="ret_qty<?=$data->id?>"    maxlength="100" style="width:100%;" value="<?=$old_qty?>" <? if($data->product_type=='Serialized') echo 'readonly';?>    />
						<input name="qty<?=$data->id?>" type="text" class="input3" id="qty<?=$data->id?>"    maxlength="100" style="width:100%;" value="<?=$old_qty?>" <? if($data->product_type=='Serialized') echo 'readonly';?> onkeyup="quantity_check(<?=$data->id?>)" required/></td>
						
						<td align="center"><?=$data->serial_no?><input name="serial_no" type="hidden" class="input3" id="serial_no" value="<?=$data->serial_no?>"  maxlength="100" style="width:100%;" onchange="count()"/></td>
						
						<td align="center"><input name="amount<?=$data->id?>" type="text" class="input3" id="amount<?=$data->id?>" value="<?=$data->total_amt?>" style="width:100%;" readonly required/></td>
							  </tr>
							  <? } ?>
	
                </tbody>
            </table>

        </div>
    <!--button design start-->

        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
					  <? if(find($res)==0){?>
	  <input name="delete" id="delete"  type="submit" class="btn1 btn1-bg-cancel" value="CANCEL REMAINNING SR"/>
	  <? }?>

<input name="confirmm" id="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD SR"/><input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
				
            </div>

        </div>

	</form>


<? }?>

</div>







<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once "../../../assets/template/layout.bottom.php";

?>