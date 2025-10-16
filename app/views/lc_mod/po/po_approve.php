<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Soft Crab Receive';



//do_calander('#po_date');

//do_calander('#invoice_date');

//create_combobox('vendor_id');
//create_combobox('group_for');
//create_combobox('warehouse_id');



$table_master='purchase_master';

$table_details='purchase_invoice';

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

auto_complete_from_db('item_info','concat(item_id," - ",item_name)','concat(item_id," - ",item_name)','sub_group_id=100010000','item_id');



?>

<script language="javascript">

function count()

{

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}



function count_up()

{

var qty = document.getElementById('qty').value*1;
var amount = document.getElementById('amount').value*1;

var rate = document.getElementById('rate').value= (amount/qty);

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



window.onload = function() {  document.getElementById("item_id").focus();};


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
		
		
      </div>
       

    <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>

      <div>

        <label for="<?=$field?>">PO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly=""/>
		
		<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>" required readonly=""/>
		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required readonly=""/>
      </div>
	  
	  
	  <div>

        <label for="<?=$field?>">PO Type:</label>

		<select  name="purchase_type" id="purchase_type" required >

		
      <? foreign_relation('purchase_type','id','purchase_type',$purchase_type,'id="'.$purchase_type.'"');?>
		 </select>
      </div>
	  
	  
	  
	  
	       <div></div>

     

      






    </fieldset></td>

    <td>

			<fieldset>


      <div>
	  
	  
	  

	  <div>

        <label for="<?=$field?>">Supplier Name:</label>

		
		 
		  <input  name="vendor_id2" type="text" id="vendor_id2" value="<?=find_a_field('vendor_foreign','vendor_name','vendor_id="'.$vendor_id.'"')?>" readonly=""  />
		 <input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>" readonly=""  />
      </div>
	  
	  
<div>

        <label for="<?=$field?>">Supplier Area:</label>
		 
		  <input  name="vendor_area2" type="text" id="vendor_area2" value="<?=find_a_field('vendor_category','category_name','id="'.$vendor_area.'"')?>" readonly=""  />
		 <input  name="vendor_area" type="hidden" id="vendor_area" value="<?=$vendor_area;?>" readonly=""  />
		 
      </div>



<div>



<? $field='invoice_no';?>

<label for="<?=$field?>">Challan No:</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly=""  />
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

                        <td width="12%" align="center" bgcolor="#0099FF"><strong>Quantity</strong></td>

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

<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>"/>
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:400px;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>

<td align="center" bgcolor="#CCCCCC">
<span id="po"></span>

<input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:120px;" onkeyup="count()" required/>

<input name="amount" type="hidden" class="input3" id="amount" style="width:120px;" onkeyup="count_up()"   required/></td>
</tr>
    </table>

<? }?>				  

<br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">&nbsp;
      <tr>
	  <br />
   
        <td><div class="tabledesign2">
          <table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody>
            
			
            <tr>
			<th width="3%">SL</th>
			<th width="35%">Item Name</th>
			<th width="4%">Unit  </th>
			<th width="6%">Rate</th>
			<th width="6%">Quantity</th>
			<th width="6%">Amount</th>
			<th width="6%">Action</th>
			<th width="7%">Delete</th>
			</tr>
            
            

<?
$s=0;
 $res='select a.id,  concat(b.item_name) as item_name, a.rate as unit_price,
 a.qty ,a.unit_name,a.amount,"x" from purchase_invoice a,item_info b
where b.item_id=a.item_id and a.po_no="'.$po_no.'" order by a.id desc';

$query=db_query($res);

while($po_item=mysqli_fetch_object($query)){
?>
<tr>
<td style="text-align:center;"><?=++$s?></td>
<td>&nbsp;<?=$po_item->item_name?></td>
<td>&nbsp;<?=$po_item->unit_name?>  </td>
<td><input  type="text"  id="unit_price_<?=$po_item->id?>"  name="unit_price_<?=$po_item->id?>"  size="5" value="<?=$po_item->unit_price; ?>" style="width:100px; height:30px;" onkeyup="PIcalculation(<?=$po_item->id?>)"  tabindex="11"/></td>
<td>


<input  type="text"  id="qty_<?=$po_item->id?>"  name="qty_<?=$po_item->id?>"  size="5" value="<?=$po_item->qty; $total_qty +=$po_item->qty;?>" style="width:100px; height:30px;" onkeyup="PIcalculation(<?=$po_item->id?>)"  tabindex="11"/></td>

<td><input  type="text"  id="amount_<?=$po_item->id?>"  name="amount_<?=$po_item->id?>"  size="5" value="<?=$po_item->amount; $total_amount +=$po_item->amount;?>" style="width:100px; height:30px;" onkeyup="PIcalculation(<?=$po_item->id?>)"  tabindex="11"/></td>
<td><span id="divi_<?=$po_item->id?>">


	<input name="flag_<?=$po_item->id?>" id="flag_<?=$po_item->id?>" type="hidden"  value="0" />

	 <input type="button" name="Button" value="Edit"  onclick="update_edit(<?=$po_item->id?>)" 
	 style="width:70px; font-size:12px; font-weight:700; height:30px;background-color: #F25B3C;"/>
          </span></td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$po_item->id?>">&nbsp;X&nbsp;</a></td>
</tr>
<? }?>

<tr>
  <td style="text-align:center;"><span class="style6"></span></td>
  <td><span class="style6"></span></td>
  <td><span class="style6"></span></td>
  <td>&nbsp;</td>
  <td><span class="style6"><?=number_format($total_qty,2);?></span></td>
  <td><span class="style6">
    <?=number_format($total_amount,2);?>
  </span></td>
  <td>&nbsp;</td>
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