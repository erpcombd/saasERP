<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Approving Purchase Order';


 //$po_no=$_GET['po_no'];
do_calander('#po_date');

do_calander('#invoice_date');

do_calander('#quotation_date');



$table_master='purchase_master';

$table_details='purchase_invoice';

$unique='po_no';

if($_GET['po_no']){
$_SESSION[$unique]=$_GET['po_no'];
}



if(isset($_POST['new2']))

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

		$msg='Requisition No Created. (PO No :-'.$_SESSION[$unique].')';

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



if(isset($_POST['return']))

{
	
	$updates = 'update purchase_master set status="MANUAL", checked_at="'.date('Y-m-d h:i:s').'",checked_by="'.$_SESSION['user']['id'].'",return_remarks="'.$_POST['return_remarks'].'" where po_no="'.$_REQUEST['po_no'].'"';
	db_query($updates);
	$_SESSION['msgs'] = '<span style="color:red; font-weight:bold; font-size:16px;">Successfully Returned!</span>';
	unset($$unique);
    unset($_SESSION[$unique]);
	echo '<script>location.href="select_unapproved_po.php"</script>';
	
	}



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
		$_POST['checked_by']=$_SESSION['user']['id'];
		$_POST['checked_at']=date('Y-m-d h:s:i');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		//auto_insert_purchase_secoundary_update_packing($$unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded to Relevant Department.';

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

		unset($item_id);

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





auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','1 ','item_id');


?>

<script language="javascript">

function count()

{

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="row ">
	     <div class="col-md-3 form-group">
		 <? $field='po_no';?>
            <label for="po_no" >PO NO: </label>
           <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
          </div>
		  
		 <div class="col-md-3 form-group">
		 <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>
        <div>
        <label for="<?=$field?>">PO Date:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
       </div>
	   </div>
	   
	   <div class="col-md-3 form-group">
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
<!--        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>-->
      </div>
	  </div>
	  
     <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
      <div class="col-md-3 form-group">
        <label for="<?=$field?>">Warehouse:</label>
        <select class="form-control" id="<?=$field?>" name="<?=$field?>" required >
        <option></option>
        <? foreign_relation($table,$get_field,$show_field,$$field,'use_type!="PL"');?>
        </select>
      </div>
	   <div class="col-md-3 form-group">
      <p>
        <? $field='tax';?>
        <label for="<?=$field?>">Vat/Tax:</label>
    <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </p>
	  </div>
	  
	  <div class="col-md-3 form-group">
      <p>
        <? $field='payment_details';?>
        <label for="<?=$field?>">Payment:</label>
        <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </p></div>
	  
	    <div class="col-md-3 form-group">
        <label for="<?=$field?>">Note:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
        </div>
		
		<div class="col-md-3 form-group">
		<? $field='vendor_id'; $table='vendor'; $get_field='vendor_id'; $show_field='vendor_name'; ?>
        <label for="<?=$field?>">Vendor:</label>
		<span id="vendor_space">
        <select class="form-control" id="vendor_id" name="vendor_id" required>
        <? foreign_relation($table,$get_field,$show_field,$$field,"1 order by vendor_name");?>
       </select>
		</span> 
      </div>
	  
	   <div class="col-md-3 form-group">
	   <? $field='quotation_no';?>
          <label for="<?=$field?>">Quotation No:</label>
          <input class="form-control"  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
		
		<div class="col-md-3 form-group" style="width:248px;">
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
		  </div>

  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

    

    <tr>
      <td colspan="2"><div align="center">
        <input name="new2" type="submit" class="btn btn-success" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
      </div></td>
    </tr>
    <tr>

      <td colspan="2"><div class="buttonrow" style="margin-left:240px;">

        <div align="center"></div>
      </div></td>
    </tr>
  </table>

</form>





<? if($_SESSION[$unique]>0){?>

<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <tr>

    <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>

    </tr>

  <tr>

    <td align="right" bgcolor="#CCFF99">Created By:</td>

    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

    <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="po_print_view.php?po_no=<?=$po_no?>" target="_blank"><i class="fas fa-print" style="color:black;"></i><!--<img src="../../images/print.png" width="26" height="26" />--></a></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#CCFF99">Created On:</td>

    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=$entry_at?></td>

    </tr>

</table>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

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
  </span></div></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:98%;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:98%;" readonly required/></td>
      </tr>
    </table>

  <br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td>

<div class="tabledesign2">

<? 

$res='select a.id,b.finish_goods_code as Item_code, concat(b.item_id," - ",b.item_name) as item_description , a.qty as Quantity ,a.unit_name as Unit, a.rate as unit_price,a.amount,"x" from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;

echo link_report_add_del_auto($res,'',4,7);

?>

</div>

</td>

</tr>

</table>

</form>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">

        <input type="hidden" name="return_remarks" id="return_remarks">

      <input name="return"  type="submit" class="btn btn-danger" value="RETURN PO" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" onclick="return_function()" />



      </td>

      <td align="center">



      <input name="confirmm" type="submit" class="btn btn-info" value="CONFIRM AND FORWARD PO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" />



      </td>

    </tr>

  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>
<script>
function return_function() {
  var person = prompt("Why Return This PO", "");
  if (person != null) {
    document.getElementById("return_remarks").value =person;
  }
}
</script>


<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>