<?


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='New Purchase Order Create';

do_calander('#po_date');

do_calander('#invoice_date');

create_combobox('vendor_id');

$table_master='purchase_master';

$table_details='purchase_invoice';

$unique='po_no';
if($_GET['po_no']){
$_SESSION[$unique]=$_GET['po_no'];
}
if($_GET['mhafuz']>0) { $_SESSION[$unique] = '' ;  }
 
if(isset($_POST['new'])){ 

		$crud   = new crud($table_master);
		
		if($_SESSION[$unique] == '') { 
		

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');
		
		$_POST['po_for']="Foreign";

		$$unique=$_SESSION[$unique]=$crud->insert();
		
		
		
			if($_POST['req_no']>0){
			 $sql5='select * from requisition_order where req_status=0 and req_no='.$_POST['req_no'];
			
			$query = db_query($sql5);
			while($row=mysqli_fetch_object($query)){
			     $sql_nsert = 'insert into purchase_invoice (po_no, po_date, vendor_id, item_id, req_id, warehouse_id, qty, unit_name)
				values("'.$_POST[$unique].'", "'.$_POST['po_date'].'", "'.$_POST['vendor_id'].'",  "'.$row->item_id.'",  "'.$row->id.'", "'.$_SESSION['user']['depot'].'", "'.$row->qty.'", "'.$row->unit_name.'" ) ';
				
				db_query($sql_nsert);
				
				
				$sql3='update requisition_order  set req_status=1 where id='.$row->id;
				db_query($sql3);
			}
			
			}

		unset($$unique);

		$type=1;

		$msg='Purchase Order No Created. (PO No :-'.$_SESSION[$unique].')';
		
		header('Location:po_create.php');

		}else{ 

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);
		
		if($_POST['req_no']>0){
			 $sql5='select * from requisition_order where req_status=0 and req_no='.$_POST['req_no'];
			
			$query = db_query($sql5);
			while($row=mysqli_fetch_object($query)){
			     $sql_nsert = 'insert into purchase_invoice (po_no, po_date, vendor_id, item_id, req_id, warehouse_id, qty, unit_name)
				values("'.$_POST[$unique].'", "'.$_POST['po_date'].'", "'.$_POST['vendor_id'].'",  "'.$row->item_id.'",  "'.$row->id.'", "'.$_POST['warehouse_id'].'", "'.$row->qty.'", "'.$row->unit_name.'" ) ';
				
				db_query($sql_nsert);
				
				
				$sql3='update requisition_order  set req_status=1 where id='.$row->id;
				db_query($sql3);
			}
			
			}

		$type=1;

		$msg='Successfully Updated.';

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

$sql3='update requisition_order r, purchase_invoice p set r.req_status=0 where p.req_id=r.id and p.id='.$_GET['del'];
db_query($sql3);


		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_POST['confirmm']))

{


        $sql = 'select * from purchase_invoice where po_no='.$$unique;
	   $qu = db_query($sql);
	   while($re = mysqli_fetch_object($qu)){
	   		 $update_sql = 'update purchase_invoice set qty = "'.$_POST['qty'.$re->id].'", rate = "'.$_POST['unit_price'.$re->id].'", amount = "'.$_POST['amount'.$re->id].'" 
			where id='.$re->id;
			db_query($update_sql);
	   }

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');
        if($_SESSION['user']['depot']==1){
		$_POST['status']='UNCHECKED';
		}else{
		$_POST['status']='BRANCH_PO';
		}

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded for Approval.';

}



if(isset($_POST['add'])&&($_POST[$unique]>0))

{
	

		$crud   = new crud($table_details);

		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[1];

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->insert();

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

auto_complete_from_db('item_info i, item_brand b','concat(i.item_name,"#>",i.item_id,"#>",b.brand_name)','concat(item_name,"#>",item_id)','1 and i.item_brand=b.id','item_id');
//auto_complete_start_from_db('item_info i, item_brand b','concat(i.finish_goods_code,"#>",i.item_name,"#>",b.brand_name)','i.finish_goods_code','1 and i.item_brand=b.id','item');

?>

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>


<script language="javascript">


function count()

{

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}

function count_1(id)

{

var num_1=((document.getElementById('qty'+id).value)*1)*((document.getElementById('unit_price'+id).value)*1);

document.getElementById('amount'+id).value = num_1.toFixed(2);	

}

</script>

<script>

/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////

function insert_item(){
var item1 = $("#item_id");
var dist_unit = $("#qty");


if(item1.val()=="" || dist_unit.val()==""){
	 alert('Please check Item ID,Qty');
	  return false;
	}


	
$.ajax({
url:"po_input_ajax.php",
method:"POST",
dataType:"JSON",

data:$("#codz").serialize(),

success: function(result, msg){
var res = result;

$("#codzList").html(res[0]);	
$("#t_amount").val(res[1]);


$("#item_id").val('');
$("#qty").val('');
$("#remarks").val('');
$("#qoh").val('');

}
});	

//}else{ alert('Please Enter Debit Ledger'); }
//}else{ alert('Please check Ledger,amount and Date'); }

  }
/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////


</script>

<script>

/////-=============-------========-------------Ajax  update Entry---------------===================-------/////////

function update_item(id){
var qty = $("#qty"+id).val();
var rate = $("#unit_price"+id).val();
var amount = $("#amount"+id).val();

if(qty>0 && rate>0 && amount>0){

	
$.ajax({
url:"po_update_ajax.php",
method:"POST",
dataType:"JSON",

data: {qty:qty, rate:rate, amount:amount,id:id} ,

success: function(result, msg){
var res = result;




}
});	
}

  }
/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////


</script>

<div class="form-container_large">

<form action="" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="row ">
	     <div class="col-md-3 form-group">
		 <? $field='po_no';?>
            <label for="po_no" >PO NO: </label>
           <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>
          </div>
		  
		 <div class="col-md-3 form-group">
		 <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>
        <div>
        <label for="<?=$field?>">PO Date:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  required/>
       </div>
	   </div>
	   
	   <!--<div class="col-md-3 form-group">
	   <? $field='req_no';?>
      <div>
        <label for="<?=$field?>">Req No:</label>
		<select name="<?=$field?>" id="<?=$field?>" class="form-control" >
			<option value="<?=$$field?>"><?=$$field?></option>
			<?php 
			$re_sql='select * from requisition_master where status="CHECKED"';
			$re_query=db_query($re_sql);
			while($row2=mysqli_fetch_object($re_query)){
			?>
			<option value="<?=$row2->req_no?>">Req No-<?=$row2->req_no?></option>
			
			<?php } ?>
		</select>
       <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
	  </div>-->
	  
     <? //$field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
      <!--<div class="col-md-3 form-group">
        <label for="<?=$field?>">Warehouse:</label>
        <select class="form-control" id="<?=$field?>" name="<?=$field?>" required >
      
        <? foreign_relation($table,$get_field,$show_field,$$field,'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
        </select>
      </div>-->
	   <div class="col-md-3 form-group">
      <p>
        <? $field='tax';?>
        <label for="<?=$field?>">Vat/Tax:</label>
    <input class="form-control" name="<?=$field?>" type="hidden" id="<?=$field?>" value="<?=$$field?>"/>
	<select name="tax_type" id="tax_type" class="form-control">
	<option></option>
	<option <?=($tax_type=='Excluded')? 'selected':''?>>Excluded</option>
	<option <?=($tax_type=='Included')? 'selected':''?>>Included</option>
	</select>
	
	</select>
      </p>
	  </div>
	  
	  <!--<div class="col-md-3 form-group">
      <p>
        <? $field='payment_details';?>
        <label for="<?=$field?>">Payment:</label>
        <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </p></div>-->
	  
	    <div class="col-md-3 form-group">
        <label for="<?=$field?>">Note:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
		<input class="form-control" name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>" />
        </div>
		
		<div class="col-md-3 form-group">
		<? $field='vendor_id'; $table='vendor'; $get_field='vendor_id'; $show_field='vendor_name'; ?>
        <label for="<?=$field?>">Vendor:</label>
		<span id="vendor_space">
        <select class="form-control" id="vendor_id" name="vendor_id" required>
		<option value="<?=$vendor_id?>"><?=find_a_field('vendor','vendor_name','vendor_id='.$vendor_id);?></option>
        <? foreign_relation($table,$get_field,$show_field,$$field,"vendor_category=2 order by vendor_name");?>
       </select>
		</span> 
      </div>
	  
	   <div class="col-md-3 form-group">
	   <? $field='quotation_no';?>
          <label for="<?=$field?>">Quotation No:</label>
          <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
		
		<div class="col-md-3 form-group" >
		<? $field='quotation_date';?>
          <label for="<?=$field?>">Quotation Date:</label>
          <input class="form-control"  name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
		
		 <div class="col-md-3 form-group">
		 <? $field='delivery_within';?>
          <label for="<?=$field?>">Delivery Within:</label>
          <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
		
	    <div class="col-md-3 form-group">
		<? $field='payment_terms'?>
        <label for="<?=$field?>">Payment Terms:</label>
        <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
        </div>
		
		<div class="col-md-9 form-group">
		<? $field='terms_condition'?>
        <label for="<?=$field?>"> Terms & Conditions:</label>
        <textarea class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" /> </textarea>
        </div>
	</div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <form action="<?=$page?>" method="post" name="codz2" id="codz2" class="font-weight-bold">
  
  
         
		  </div>
    

  <tr>

    <td colspan="2"><div class="buttonrow text-center" ><span class="buttonrow" >

      <? if($_SESSION[$unique]>0) {?>
         <!-- <input name="new" type="submit" class="btn1" value="Update Sales Return" style="width:200px; font-weight:bold; font-size:12px; tabindex="12>-->
		  <button type="submit" name="new" id="new" class="btn btn-success">Update  PO Information</button>
          <input name="flag2" id="flag2" type="hidden" value="1" />
          <? }else{?>
          <!--<input name="new" type="submit" class="btn1" value="Initiate Sales Return" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />-->
		  <button type="submit" name="new" id="new" class="btn btn-primary">Initiate PO Information</button>
          <input name="flag2" id="flag2" type="hidden" value="0" />
          <? }?>
        </span></div>
		
		</td>

    </tr>
    <? if($return_remarks!=''){?>
    
    <tr>

    <td colspan="2"><div class="buttonrow text-center" ><span class="buttonrow" >
      <table border="1" cellpadding="0" cellspacing="0" width="70%">
        <thead>
        <tr>
          <th>Return By</th>
          <th>Return At</th>
          <th>Return Reason</th>
          </tr>
          </thead>
          <tbody>
          <tr>
          <td><?=find_a_field('user_activity_management','fname','user_id="'.$checked_by.'"');?></td>
          <td><?=$checked_at?></td>
          <td><?=$return_remarks?></td>
          </tr>
         </tbody>
      </table>
    </div></td>

    </tr>
    <? } ?>

</table>

</form>

<? if($_SESSION[$unique]>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="codz" id="codz">



<? 

$group_for = find_a_field('warehouse','group_for','warehouse_id='.$warehouse_id.' ');

if(($vendor->ledger_id==0)&&($group_for==3||$group_for==3)){ ?>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">

<tr><td bgcolor="#FF3333"><div align="center" class="style1">VENDOR IS BLOCKED. NO ACCOUNT CODE FOUND</div></td></tr>

</table>



<? }else{?>

			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Stock</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Price</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Qty</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>

                          <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <!--<input name="add" type="button" onclick="insert_item()" id="add" value="ADD" tabindex="12" class="update"/>  -->    
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"/>

<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:98%;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>

<td colspan="3" align="center" bgcolor="#CCCCCC">

  <div align="right"><span id="po">
    
    <table width="100%" border="1">
<tr>
<td width="25%"><input name="stk" type="text" class="input3" id="stk" style="width:98%;" readonly/></td>
   
    <td width="25%"><input name="unit" type="text" class="input3" id="unit" style="width:98%;" readonly/></td>
    
    <td width="25%"><input name="price" type="text" class="input3" id="price" style="width:98%;" readonly/></td>
<!--  <td width="25%"> <input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:98%;" onchange="count()" required/></td>-->
  </tr></table>
  </span>
</div>

<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:98%;" onchange="count()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:98%;" readonly required/></td>
      </tr>
    </table>

<? }?>				  
</form>

<br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	<table id="grp" cellspacing="0" cellpadding="0" width="100%">
		<tbody>
			<tr>
				<th>S/L</th>
				
				<th>Item Description</th>
				<th>Quantity</th>
				<th>Unit</th>
				<th>Unit Price</th>
				<th>Amount</th>
				<th>X</th>
			</tr>
	<?php

  $sql9='select a.id,concat(b.item_id," - ",b.item_name) as item_description , a.qty as Quantity ,a.unit_name as Unit, a.rate as unit_price,a.amount
 from purchase_invoice a,item_info b
 
  where b.item_id=a.item_id and a.po_no='.$po_no;
$query=db_query($sql9);

 while($data=mysqli_fetch_object($query)){
?>
		
			
			<tr>
				<td><?=++$i?></td>
				
				<td><?=$data->item_description ?></td>
				<td><input type="text" onkeyup="count_1(<?=$data->id?>)" onblur="update_item(<?=$data->id?>)" name="qty<?=$data->id?>" id="qty<?=$data->id?>" value="<?=$data->Quantity?>"/></td>
				<td><?=$data->Unit ?></td>
				<td>
				<input type="hidden" required name="details_id<?=$data->id?>"  value="<?  echo $data->id; ?>" />
				
				<input type="text" onkeyup="count_1(<?=$data->id?>)" onblur="update_item(<?=$data->id?>)" required name="unit_price<?=$data->id?>" id="unit_price<?=$data->id?>" value="<? if($data->unit_price>0) echo $data->unit_price; ?>" />
				</td>
				<td><input type="text" readonly required name="amount<?=$data->id?>" id="amount<?=$data->id?>" value="<? if($data->amount>0) echo $data->amount; ?>" /></td>
				<td><a href="?del=<?=$data->id;?>">X</a></td>
				
				
			</tr>
			<?php } ?>
		</tbody>
	</table>
</span>
</div>

</td>

    </tr>

    <tr>

     <td>



 </td>

    </tr>

  </table>




  <table width="100%" border="0">

    <tr>

      <td align="center">



      <input name="delete"  type="submit" class="btn btn-danger" value="DELETE AND CANCEL PO" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" />



      </td>

      <td align="center">

<input type="hidden" name="req_no"  value="<?=$req_no?>"/>
  <? $d_d=find_a_field('purchase_invoice','count(po_no)','po_no='.$po_no);
   if($d_d>0){
  ?>
      <input name="confirmm" type="submit" class="btn btn-info" value="CONFIRM AND FORWARD PO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" />
  <? } ?>


      </td>

    </tr>

  </table>

</form>

<? }?>
</div>
<script>
    CKEDITOR.replace( 'terms_condition' );
</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>