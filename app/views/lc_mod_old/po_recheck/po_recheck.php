<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='New Purchase Order Create';



do_calander('#po_date');

do_calander('#invoice_date');

create_combobox('vendor_id');
create_combobox('group_for');
create_combobox('warehouse_id');

$table_master='purchase_sp_master';

$table_details='purchase_sp_invoice';

$unique='po_no';


if($_GET['mhafuz']==2)
unset($_SESSION['po_no']);


if(isset($_POST['new']))

{

		$crud   = new crud($table_master);
		
		



		if(!isset($_SESSION[$unique])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Purchase Order No Created. (PO No :-'.$_SESSION[$unique].')';

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}



$$unique=$_SESSION[$unique];



//if(isset($_POST['delete']))
//
//{
//
//		$crud   = new crud($table_master);
//
//		$condition=$unique."=".$$unique;		
//
//		$crud->delete($condition);
//
//		$crud   = new crud($table_details);
//
//		$condition=$unique."=".$$unique;		
//
//		$crud->delete_all($condition);
//
//		unset($$unique);
//
//		unset($_SESSION[$unique]);
//
//		$type=1;
//
//		$msg='Successfully Deleted.';
//
//}



if($_GET['del']>0)

{

		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

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

		$msg='Successfully Forwarded for Approval.';

}



if(isset($_POST['add'])&&($_POST[$unique]>0))

{

		$crud   = new crud($table_details);

		$iii=explode('-',$_POST['item_id']);

		$_POST['item_id']=$iii[0];

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

auto_complete_from_db('item_info','concat(item_name)','concat(item_id," - ",item_name)','1 and product_type="Spare Parts" order by item_name','item_id');



?>

<script language="javascript">

function count()

{

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}





function PIcalculation(id){

var wo_qty = document.getElementById('qty_'+id).value*1;
var wo_rate = document.getElementById('unit_price_'+id).value*1;
var amount = document.getElementById('amount_'+id).value= (wo_qty*wo_rate);

}




function update_edit(id)

{
var warehouse_id = (document.getElementById("warehouse_id_"+id).value);

var qty = (document.getElementById("qty_"+id).value);
var unit_price  = (document.getElementById("unit_price_"+id).value);
var amount = (document.getElementById("amount_"+id).value)*1;
var info = warehouse_id+"<@>"+qty+"<@>"+unit_price+"<@>"+amount;

getData2('po_edit_ajax.php', 'divi_'+id,id,info);
}




function submitButtonStyle(_this) {
  _this.style.backgroundColor = "red";
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

<style>

/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}
*/

div.form-container_large input {
    width: 220px;
    height: 38px;
    border-radius: 0px !important;
}




</style>

<div class="form-container_large">

<form action="?" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top"><fieldset>

    <? $field='po_no';?>

      <div>

        <label for="<?=$field?>">PO  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>
		
		<input  name="purchase_type" type="hidden" id="purchase_type" value="2" required/>

      </div>
       

    <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>

      <div>

        <label for="<?=$field?>">PO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>
	  
	  
	  <div>

        <label for="<?=$field?>">Company:</label>

        <select id="group_for" name="group_for" required  >
		


      <? foreign_relation('user_group','id','group_name',$group_for,'id=1');?>

        </select>

      </div>

    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

      <div>

        <label for="<?=$field?>">Warehouse:</label>

        <select id="<?=$field?>" name="<?=$field?>" required   >


        <? foreign_relation($table,$get_field,$show_field,$$field,'warehouse_id=33');?>

        </select>

      </div>
	  
	  
	  
        <? $field='remarks';?>

        <div>

          <label for="<?=$field?>">Remarks:</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

        </div>

      
	  
	  
	  
	       <div></div>

     

      






    </fieldset></td>

    <td>

			<fieldset>

			



	   
	  
	  
	  

 

      <div>
	  
	  
	  
	  <div>

        <label for="<?=$field?>">Vendor:</label>

		<select  name="vendor_id" id="vendor_id" required>
		<option></option>
		
      		<? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'1 order by vendor_name');?>
		 </select>

      </div>
	  
	  
	  <div>

        <label for="<?=$field?>">PO Type:</label>

		<select  name="purchase_payment_type" id="purchase_payment_type" required style="width:58%">
<option></option>
		
      <? foreign_relation('purchase_payment_type','id','purchase_payment_type',$purchase_payment_type,'1');?>
		 </select>

      </div>
	  
	  <div>

        <label for="<?=$field?>">Purchased By:</label>

		<select  name="purchase_manager" id="purchase_manager" required style="width:58%">
<option></option>
		
      <? foreign_relation('purchase_manager','id','purchase_manager',$purchase_manager,'1');?>
		 </select>

      </div>
	  
	  

       <div>



<? $field='tax';?>

<label for="<?=$field?>">VAT (%):</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />

</div>






		  
		  



		
	
	
		      

      </div>

			</fieldset>	</td>
			
			
			
			<td>

			<fieldset>

			



	   
	  
	  
	  

 

      <div>
	  
	  
	  
	 
	  <div>



<? $field='invoice_no';?>

<label for="<?=$field?>">Challan No:</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />

</div>
	  

       <div>



<? $field='transport_bill';?>

<label for="<?=$field?>">Transport Bill:</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />

</div>



<div>


<? $field='labor_bill';?>

<label for="<?=$field?>">Labor Bill:</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />

</div>


		  
		  



        <? $field='other_bill';?>

        <div>

          <label for="<?=$field?>">Other Bill:</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

        </div>
		
	<div>



<? $field='bill_adjustment';?>

<label for="<?=$field?>">Bill Adjustment:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />

</div>
	
		      

      </div>

			</fieldset>	</td>
			
			
			

  </tr>

  <tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:485px;">

      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />

    </div></td>

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

                        <td width="10%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>

                        <td width="9%" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>

                        <td width="12%" align="center" bgcolor="#0099FF"><strong>Price</strong></td>
                        <td width="12%" align="center" bgcolor="#0099FF"><strong>Quantity</strong></td>

                        <td width="15%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>

                          <td width="6%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
					    </div>				        </td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:400px;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>

<td align="center" bgcolor="#CCCCCC">

  <div align="right"><span id="po">

    <input name="unit" type="text" class="input3" id="unit" style="width:105px;float:left;" readonly/>
 
  </span></div></td>
						  					  
<td align="center" bgcolor="#CCCCCC"><input name="rate" type="text" class="input3" id="rate"  maxlength="100" style="width:100px;float:left;" onchange="count()" value=""  required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:100px;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:120px;" readonly required/></td>
      </tr>
    </table>

<? }?>				  

<br /><br />

<? 

  $res='select a.id,b.item_id as Item_code, concat(b.item_name) as item_description , a.unit_name as Unit,a.qty as Quantity , a.rate as unit_price,a.amount,"x" from purchase_sp_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;
?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">&nbsp;
      <tr>
	  <br />
   
        <td><div class="tabledesign2">
          <table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody>
            
			
            <tr>
			<th width="3%" rowspan="2">SL</th>
			<th width="35%" rowspan="2">Item Name</th>
			<th width="25%" rowspan="2">Warehouse Name</th>
			<th width="4%" rowspan="2">Unit  </th>
			<th width="6%" rowspan="2">Quantity</th>
			<th colspan="2" ><center>
			  Price in BDT 
			</center> </th>
			<th width="4%" rowspan="2">Action</th>
      		<th width="7%" rowspan="2">Delete</th>
			</tr>
            <tr>
              <th width="5%"> Price</th>
              <th width="6%">Amount</th>
              </tr>
            

<?
$s=0;
 $res='select a.id,  b.finish_goods_code as item_code, concat(b.item_name) as item_name, w.warehouse_name, a.warehouse_id, a.rate as unit_price,
a.pkt_size, a.pkt_unit, a.qty ,a.unit_name,a.amount,"x" from purchase_sp_invoice a,item_info b, warehouse w where b.item_id=a.item_id and a.warehouse_id=w.warehouse_id and a.po_no='.$po_no;

$query=db_query($res);

while($po_item=mysqli_fetch_object($query)){
?>
<tr>
<td style="text-align:center;"><?=++$s?></td>
<td>&nbsp;<?=$po_item->item_name?></td>
<td>

	  
<select id="warehouse_id_<?=$po_item->id?>"  name="warehouse_id_<?=$po_item->id?>" style="width:220px;"  tabindex="3" required>

   <? foreign_relation('warehouse','warehouse_id','warehouse_name',$po_item->warehouse_id,'warehouse_id=33  and use_type = "WH"');?>
</select>
	  
	  
	  </td>
<td>&nbsp;<?=$po_item->unit_name?>
  </td>
<td>


<input  type="text"  id="qty_<?=$po_item->id?>"  name="qty_<?=$po_item->id?>"  size="5" value="<?=$po_item->qty?>" style="width:100px; height:30px;" onkeyup="PIcalculation(<?=$po_item->id?>)"  tabindex="11"/>

</td>

<td>
<input  type="text"  id="unit_price_<?=$po_item->id?>"  name="unit_price_<?=$po_item->id?>"  size="5" value="<?=$po_item->unit_price?>" style="width:80px; height:30px;" onkeyup="PIcalculation(<?=$po_item->id?>)"  tabindex="11"/>

</td>
<td>

<input  type="text"  id="amount_<?=$po_item->id?>"  name="amount_<?=$po_item->id?>"  size="5" value="<?=$po_item->amount; $total_amount +=$po_item->amount;?>" style="width:100px; height:30px;" readonly="" tabindex="11"/>

</td>

<td>
<span id="divi_<?=$po_item->id?>">


	<input name="flag_<?=$po_item->id?>" id="flag_<?=$po_item->id?>" type="hidden"  value="0" />

	 <input type="button" name="Button" value="Edit"  onclick="update_edit(<?=$po_item->id?>)" 
	 style="width:70px; font-size:12px; font-weight:700; height:30px;background-color: #F25B3C;"/>
          </span>
		  </td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$po_item->id?>">&nbsp;X&nbsp;</a></td>
</tr>
<? }?>

<tr>
  <td style="text-align:center;"><span class="style6"></span></td>
  <td><span class="style6"></span></td>
  <td align="right"><div align="right" class="style7">Total</div></td>
  <td><span class="style6"></span></td>
  <td><span class="style6"></span></td>
  <td><span class="style6"></span></td>
  <td><span class="style7">
    <?=number_format($total_amount,2);?>
  </span></td>
  <td><span class="style6"></span></td>
  <td><span class="style6"></span></td>
</tr>








</table>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>

</form>

<br /><br />

<form action="purchase_order_checked.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">



      <input type="submit" name="delete"  class="btn1" value="DELETE ENTRY" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />



      </td>

      <td align="center">
	  
	  
	   <input  name="po_no" type="hidden" id="po_no" value="<?=$$unique?>"/>



      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND SEND" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />



      </td>

    </tr>

  </table>

</form>

<? }?>

</div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>