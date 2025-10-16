<?


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='New Service Order Create';




do_calander('#service_date');

do_calander('#delivery_date');

do_calander('#test_date');

create_combobox('vendor_id');

$table_master='service_master';

$table_details='service_details';

if($_REQUEST['service_no']>0){
$serial_no = find_a_field('service_details','serial_no','service_no="'.$_REQUEST['service_no'].'"');
}elseif($_REQUEST['serial_no']!=''){
$serial_no = $_REQUEST['serial_no'];
}

$serial_sql = 'select c.*,i.item_name,i.item_description,d.dealer_name_e,d.address_e,d.mobile_no from sale_do_chalan c,item_info i,dealer_info d where c.dealer_code=d.dealer_code and c.item_id=i.item_id and c.serial_no="'.$serial_no.'"';
$serial_qry = db_query($serial_sql);
$s_data = mysqli_fetch_object($serial_qry);

$unique='service_no';
if($_GET['service_no']){
$_SESSION[$unique]=$_GET['service_no'];
}
if($_GET['mhafuz']>0) { $_SESSION[$unique] = '' ;  }
 

$$unique=$_SESSION[$unique];


if($_GET['del']>0)

{}


if(isset($_POST['add'])&&($_POST[$unique]>0))

{
	
        //$delete_old = 'delete from service_details where service_no="'.$$unique.'" and serial_no="'.$_POST['serial_no'].'"';
		//db_query($delete_old);
		$crud   = new crud('service_feedback');
		
		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$crud->insert();
		
		$master_update = 'update service_master set status="'.$_POST['status'].'" where service_no="'.$$unique.'"';
		db_query($master_update);
		$master_update2 = 'update service_details set status="'.$_POST['status'].'" where service_no="'.$$unique.'"';
		db_query($master_update2);
		//$_SESSION['smsgs'] = '<a href="service_received_print_view.php?service_no='.$$unique.'" target="_blank" style="color:green; font-size:14px; font-weight:bold;">New Feedback Generated. Complain No. '.$$unique.'</a>';
		//unset($_SESSION[$unique]);
		//header('location:service_list.php');

}

if(isset($_POST['confirmm'])){
  $master_update = 'update service_master set status="DELIVERY UNCHECKED" where service_no="'.$$unique.'"';
		db_query($master_update);
  $_SESSION['smsgs'] = '<a href="service_delivery_print_view.php?service_no='.$$unique.'" target="_blank" style="color:green; font-size:14px; font-weight:bold;">Success. Complain No. '.$$unique.'</a>';
		unset($_SESSION[$unique]);
		header('location:service_complete_approval.php');

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
		 <? $field='service_no';?>
            <label for="service_no" >Service  NO: </label>
           <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>
  </div>
		  
		 <div class="col-md-3 form-group">
		 <? $field='service_date'; if($service_date=='') $service_date =date('Y-m-d');?>
        <div>
        <label for="<?=$field?>">Order Date:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=($$field!='')? $$field : date('Y-m-d');?>" readonly="readonly"  required/>
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
        <? $field='received_branch';?>
        <label for="<?=$field?>">Received Branch :</label>
	<select name="received_branch" id="received_branch" class="form-control">
	<option></option>
	<? foreign_relation('warehouse','warehouse_id','warehouse_name',$received_branch);?>
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
        <input class="form-control" name="note" type="text" id="note" value="<?=$note?>" />
        </div>
		
		<div class="col-md-3 form-group">
		<? $field='client_id'; $table='dealer_info'; $get_field='dealer_code'; $show_field='dealer_name_e'; ?>
        <label for="<?=$field?>">Customer:</label>
		<span id="vendor_space">
        <select class="form-control" id="client_id" name="client_id" required>
		<option value="<?=$s_data->dealer_code?>"><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$s_data->dealer_code);?></option>
        <? foreign_relation($table,$get_field,$show_field,$$field,"1 order by dealer_name_e");?>
       </select>
		</span> 
      </div>
	  
	   <div class="col-md-3 form-group">
	   <? $field='client_address';?>
          <label for="<?=$field?>">Customer Address :</label>
          <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$s_data->address_e?>"/>
</div>
		
		<div class="col-md-3 form-group" >
		<? $field='mobile_no';?>
          <label for="<?=$field?>">Customer Mobile :</label>
          <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$s_data->mobile_no?>"/>
        </div>
		
		 <div class="col-md-3 form-group">
		 <? $field='warranty_status';?>
          <label for="<?=$field?>">Warranty Status:</label>
          <select name="warranty_status" id="warranty_status" class="form-control">
	<option></option>
	<option <?=($tax_type=='YES')? 'selected':''?>>YES</option>
	<option <?=($tax_type=='NO')? 'selected':''?>>NO</option>
	</select>
</div>
		
	    <div class="col-md-3 form-group">
		<? $field='complain_media'?>
        <label for="<?=$field?>">Complain Media :</label>
        <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
        </div>
		
		<div class="col-md-3 form-group">
		<? $field='delivery_date'?>
        <label for="<?=$field?>">Delivery Date :</label>
        <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
        </div>
		
		
	</div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <form action="<?=$page?>" method="post" name="codz2" id="codz2" class="font-weight-bold">
  
  
         
		  </div>
    

  <tr>

    <td colspan="2">
		
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

<form action="" method="post" name="codz" id="codz">



<? 

$group_for = find_a_field('warehouse','group_for','warehouse_id='.$warehouse_id.' ');

if(($vendor->ledger_id==0)&&($group_for==3||$group_for==3)){ ?>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">

<tr><td bgcolor="#FF3333"><div align="center" class="style1">VENDOR IS BLOCKED. NO ACCOUNT CODE FOUND</div></td></tr>

</table>



<? }else{?>

			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Test Name</strong></td>

                      
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Date</strong></td>

                       

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Test Result</strong></td>
						
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Final Status</strong></td>
						
						<td width="11%" rowspan="2">
						<input type="submit" name="add" id="add" value="ADD" style="background:#ccc; height:67px;" />
						</td>

                          
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">
<?
 $service_info = find_all_field('service_details','','service_no="'.$$unique.'"');
?>
<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"/>

<input  name="service_date" type="hidden" id="service_date" value="<?=$service_date?>"/>

<input  name="client_id" type="hidden" id="client_id" value="<?=$client_id?>"/>


<input  name="test_name" type="text" id="test_name" value="" style="width:98%;"/>
</td>

<td align="center" bgcolor="#CCCCCC"><input  name="test_date" type="text" id="test_date" value=""/></td>
<td align="center" bgcolor="#CCCCCC"><input  name="test_result" type="text" id="test_result" value=""/></td>
<td align="center" bgcolor="#CCCCCC"><select name="status" id="status"><option>PROCESSING</option><option>READY</option></select></td>

      </tr>
    </table>

<? }?>				  


<br /><br /><br /><br />

<table id="grp" cellspacing="0" cellpadding="0" width="100%" border="1" style="padding:5px;">
		<tbody>
			<tr style="background:#ccc;">
				<th>S/L</th>
				
				<th>Test Name</th>
				<th>Test Date</th>
				<th>Test Result</th>
				<th>Status</th>
				<!--<th>X</th>-->
			</tr>
	<?php

  $sql9='select * from service_feedback where service_no="'.$$unique.'"';
  $qryy = db_query($sql9);

 while($data=mysqli_fetch_object($qryy)){
?>
		
			
			<tr>
				<td><?=++$i?></td>
				
				<td><?=$data->test_name ?></td>
				<td><?=$data->test_date ?></td>
				<td><?=$data->test_result ?></td>
				<td><?=$data->status ?></td>
				<!--<td><a href="?del=<?=$data->id;?>">X</a></td>-->
				
				
			</tr>
			<?php } ?>
			
		</tbody>
	</table>

  <table width="100%" border="0">

    <tr>

      <td align="center">



      <input name="delete"  type="submit" class="btn btn-danger" value="DELETE AND CANCEL ORDER" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" />



      </td>

      <td align="center">
       <input name="confirmm" type="submit" class="btn btn-info" value="CONFIRM AND FORWARD" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" />
      </td>

    </tr>

  </table>

</form>

<? }?>
</div>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>