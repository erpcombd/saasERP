<?

require_once "../../../assets/template/layout.top.php";



$title='New Purchase Order Create';



do_calander('#po_date');

do_calander('#invoice_date');



$table_master='purchase_master';

$table_details='purchase_invoice';

$unique='po_no';


if($_GET['mhafuz']>0) { $_SESSION[$unique] = '' ;  }
 
if(isset($_POST['new'])){ 

		$crud   = new crud($table_master);
		
		if($_SESSION[$unique] == '') { 
		

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$$unique=$_SESSION[$unique]=$crud->insert();
		
		
		
			if($_POST['req_no']>0){
			 $sql5='select * from requisition_order where req_status=0 and req_no='.$_POST['req_no'];
			
			$query = mysql_query($sql5);
			while($row=mysql_fetch_object($query)){
			     $sql_nsert = 'insert into purchase_invoice (po_no, po_date, vendor_id, item_id, req_id, warehouse_id, qty, unit_name)
				values("'.$_POST[$unique].'", "'.$_POST['po_date'].'", "'.$_POST['vendor_id'].'",  "'.$row->item_id.'",  "'.$row->id.'", "'.$_POST['warehouse_id'].'", "'.$row->qty.'", "'.$row->unit_name.'" ) ';
				
				mysql_query($sql_nsert);
				
				
				$sql3='update requisition_order  set req_status=1 where id='.$row->id;
				mysql_query($sql3);
			}
			
			}

		unset($$unique);

		$type=1;

		$msg='Purchase Order No Created. (PO No :-'.$_SESSION[$unique].')';
		
		header('Location:po_create.php');

		}else{ 

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$crud->update($unique);
		
		if($_POST['req_no']>0){
			 $sql5='select * from requisition_order where req_status=0 and req_no='.$_POST['req_no'];
			
			$query = mysql_query($sql5);
			while($row=mysql_fetch_object($query)){
			     $sql_nsert = 'insert into purchase_invoice (po_no, po_date, vendor_id, item_id, req_id, warehouse_id, qty, unit_name)
				values("'.$_POST[$unique].'", "'.$_POST['po_date'].'", "'.$_POST['vendor_id'].'",  "'.$row->item_id.'",  "'.$row->id.'", "'.$_POST['warehouse_id'].'", "'.$row->qty.'", "'.$row->unit_name.'" ) ';
				
				mysql_query($sql_nsert);
				
				
				$sql3='update requisition_order  set req_status=1 where id='.$row->id;
				mysql_query($sql3);
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
mysql_query($sql3);


		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_POST['confirmm']))

{
if($_POST['req_no']>0){ 
$sql= 'update requisition_master set status="COMPLETE" where req_no="'.$_POST['req_no'].'"';
$query=mysql_query($sql);

}

        $sql = 'select * from purchase_invoice where po_no='.$$unique;
	   $qu = mysql_query($sql);
	   while($re = mysql_fetch_object($qu)){
	   		 $update_sql = 'update purchase_invoice set qty = "'.$_POST['qty'.$re->id].'", rate = "'.$_POST['unit_price'.$re->id].'", amount = "'.$_POST['amount'.$re->id].'" 
			where id='.$re->id;
			mysql_query($update_sql);
	   }

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='UNCHECKED';

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

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$crud->insert();

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','1','item_id');

?>

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

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <form action="<?=$page?>" method="post" name="codz2" id="codz2" class="font-weight-bold">
  
<div class="row ">
    
	
	     <div class="col-md-3 form-group">
            <label for="do_no" >PO No : </label>
            <input   name="do_no" type="text" class="form-control" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>
          </div>
		  
		  <div class="col-md-3 form-group">
            <label for="dealer_code">PO Date: </label>
            <select  id="dealer_code" class="form-control" name="dealer_code" readonly="readonly">
              <option value="<?=$dealer->dealer_code;?>">
              <?=$dealer->dealer_code.'-'.$dealer->dealer_name_e;?>
              </option>
            </select>
          </div>
		  
		  
		 <div class="col-md-3 form-group">
            <label for="wo_detail2">Warehouse : </label>
            <input   name="wo_detail2" class="form-control"  type="text" id="wo_detail2" value="<?=$dealer->area_name?>" readonly/>
          </div>
		  
		  
		   <div class="col-md-3 form-group">
            <label for="wo_detail">Invoice No : </label>
            <input   name="wo_detail" class="form-control"  type="text" id="wo_detail" value="<?=$dealer->zone_name?>" readonly/>
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
            <label for="wo_detail">VAT (%) : </label>
            <input  name="wo_detail" class="form-control"  type="text" id="wo_detail" value="<?=$dealer->region_name?>" readonly/>
          </div>
		  
		  
          <div class="col-md-3 form-group">
            <label for="depot_id">Invoice Date: </label>
            <select  id="depot_id" name="depot_id" class="form-control"  readonly="readonly">
              <option value="<?=$dealer->depot;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
            </select>
            <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="rcv_amt">Advance Payment: </label>
            <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
        <div class="col-md-3 form-group">
            <label for="remarks">Cheque No: </label>
            <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" class="form-control"  required/>
          </div>
		  
		  
		  
		  
		   <div class="col-md-3 form-group">
            <label for="do_date"> Of Bank: </label>
            <input   name="do_date" type="text" class="form-control"  id="do_date" value="<?=($do_date!='')?$do_date:date('Y-m-d')?>" />
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="wo_subject">MR No  : </label>
            <?
             ?>
            <input   name="wo_subject" type="text" class="form-control"  id="wo_subject" value="<? echo $av_amt=(find_a_field_sql('select sum(total_amt) from sale_do_details where   dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"')-find_a_field_sql('select sum(total_amt) from sale_do_chalan where    dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"'))?>" readonly/>
          </div>
		  
		    
		  
   </div> 
   
   <? if($dealer->canceled=='Yes'){?>
          <div class="row justify-content-center">
            <? if($$unique_master>0) {?>
            <input name="new" type="submit" class="btn btn-warning" value="Update Demand Order" >
            <input name="flag2" id="flag2" type="hidden" value="1" />
            <? }else{?>
            <input name="new" type="submit" class="btn btn-success" value="Initiate Demand Order"  tabindex="12" />
            <input name="flag2" id="flag2" type="hidden" value="0" />
            <? }?>
            </div>
          <? }elseif($dealer->canceled=='No'){?>
     <!-- <div class="alert alert-danger row justify-content-center" role="alert">DEALER IS BLOCKED</div>-->

          <? }else{?>
     <!-- <div class="alert alert-danger row justify-content-center" role="alert">DEALER NOT FOUND</div>-->
          <? }?>

 

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

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:98%;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value+'##'+document.getElementById('req_no').value);"/></td>

<td colspan="4" align="center" bgcolor="#CCCCCC">

  <div align="right"><span id="po">
    
    <table width="100%" border="1">
<tr>
<td width="25%"><input name="stk" type="text" class="input3" id="stk" style="width:98%;" readonly/></td>
   
    <td width="25%"><input name="unit" type="text" class="input3" id="unit" style="width:98%;" readonly/></td>
    
    <td width="25%"><input name="price" type="text" class="input3" id="price" style="width:98%;" readonly="readonly"/></td>
  <td width="25%"> <input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:98%;" onchange="count()" required/></td>
  </tr></table>
 </span></div>


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
				<th>Item Code</th>
				<th>Item Description</th>
				<th>Quantity</th>
				<th>Unit</th>
				<th>Unit Price</th>
				<th>Amount</th>
				<th>X</th>
			</tr>
	<?php

 $sql9='select a.id,b.finish_goods_code as Item_code, concat(b.item_id," - ",b.item_name) as item_description , a.qty as Quantity ,a.unit_name as Unit, a.rate as unit_price,a.amount
 from purchase_invoice a,item_info b
 
  where b.item_id=a.item_id and a.po_no='.$po_no;
$query=mysql_query($sql9);

 while($data=mysql_fetch_object($query)){
?>
		
			
			<tr>
				<td><?=++$i?></td>
				<td><?=$data->item_name ?></td>
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



      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL PO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />



      </td>

      <td align="center">

<input type="hidden" name="req_no"  value="<?=$req_no?>"/>

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD PO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />



      </td>

    </tr>

  </table>

</form>

<? }?>
</div>


<?

require_once "../../../assets/template/layout.bottom.php";

?>