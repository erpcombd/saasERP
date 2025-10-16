<?php

require_once "../../../assets/template/layout.top.php";

//ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1); 
// error_reporting(E_ALL); 

$title='New Local Purchase';



$page_for = 'Local Purchase';



do_calander('#or_date');

do_calander('#quotation_date');



$table_master='warehouse_other_receive';

$table_details='warehouse_other_receive_detail';

$unique='or_no';





if(isset($_POST['new']))

{

		$crud   = new crud($table_master);



		if(!isset($_SESSION['or_no2'])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$$unique=$_SESSION['or_no2']=$crud->insert();

		unset($$unique);

		$type=1;

		$msg=$title.'  No Created. (No :-'.$_SESSION['or_no2'].')';

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}



$$unique=$_SESSION['or_no2'];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		$crud   = new crud($table_details);

		$condition=$unique."=".$$unique;		

		$crud->delete_all($condition);

		unset($$unique);

		unset($_SESSION['or_no2']);

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

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='CHECKED';

	    $crud   = new crud($table_master);

		$crud->update($unique);
		
	auto_insert_purchase_secoundary_local_purchase($$unique);

		unset($$unique);

		unset($_SESSION['or_no2']);

		$type=1;

		$msg='Successfully Forwarded.';

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

		$xid = $crud->insert();

		journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['or_date'],$_POST['qty'],0,$page_for,$xid,$_POST['rate']);

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}

if($$unique>0) {
$btn_name='Update PO Information';
$btn_class="btn btn-success";
 }
else{ $btn_name='Initiate PO Information';
$btn_class="btn btn-primary";
}

if($_SESSION['or_no2']<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
///auto_complete_from_db('vendor','concat(vendor_name,"#>",vendor_id)','concat(vendor_name,"#>",vendor_id)','1','vendor_name');
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

</script>
<style>
label{
	color:black;
}
</style>
<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="row ">
    
	
	     <div class="col-md-3 form-group">
		  <? $field='or_no';?>
            <label for="do_no" >LP No: </label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
          </div>
		  
		  <div class="col-md-3 form-group">
		  <? $field='or_date';  ?>
            <label for="dealer_code">LP Date: </label>
           <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" autocomplete="off" />
          </div>
		  
		  
		 <div class="col-md-3 form-group">
		 <? $field='requisition_from';?>
            <label for="wo_detail2"> Requisition From : </label>
             <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
          </div>
		  
		  
		   <div class="col-md-3 form-group">
		   <? $field='qc_by';?>
            <label for="wo_detail">QC By: </label>
           <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
		    <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>



        <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
			<? $field='or_subject';?>
            <label for="wo_detail">Note: </label>
           <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
          </div>
		  
		  
          <div class="col-md-3 form-group">
		   <? $field='vendor_name'; ?>
            <label for="depot_id">Purchase From : </label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" autocomplete="off" />
            <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
          </div>
		  
          <div class="col-md-3 form-group">
		   <? $field='approved_by';?>
            <label for="rcv_amt"> Approved By: </label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
          </div>
		  
		  <div class="col-md-3 form-group">
		    <? $field='chalan_no';?>
            <label for="rcv_amt"> Chalan No: </label>
              <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" />
			
          </div>
	  
   </div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  

  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input name="new" type="submit" class="<?=$btn_class?>" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
  </tr>
  <tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">

      <div align="center"></div>
    </div></td>
    </tr>
</table>

</form>

<? if($_SESSION['or_no2']>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF" style="width:106px;"><strong>Stock</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF" style="width:82px;"><strong>Unit</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF" style="width:100px;"><strong>Price</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Qty</strong></td>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>

                          <td width="11%" rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       

						  </div>				        </td>

      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

  <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>

  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>

<input  name="vendor_name" type="hidden" id="vendor_name1" value="<?=$vendor_name?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:98%;" required onblur="getData2('local_purchase_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>

<td colspan="3" align="center" bgcolor="#CCCCCC">

<span id="po">
<table width="100%" border="1">
<tr>

<td width="33%"><input name="stk" type="text" class="input3" id="stk" style="98%" readonly="readonly"/></td>

<td width="33%"><input name="unit" type="text" class="input3" id="unit" style="98%" readonly="readonly"/></td>

<td width="33%"><input name="price" type="text" class="input3" id="price" style="98%" readonly="readonly"/></td>
</tr></table>
</span></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:98%;background-color:white;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:98%;background-color:white;" readonly="readonly" required/></td>

      </tr>

    </table>

					  <br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_receive_detail a,item_info b where b.item_id=a.item_id and a.or_no='.$or_no;

echo link_report_add_del_auto($res,'',6);

?>

</div>

</td>

    </tr>

	    	

	



				

    <tr>

     <td>



 </td>

    </tr>

  </table>

</form>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">
	  
	  <input name="delete" type="submit" class="btn btn-danger" value="DELETE ENTRY" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" /></td>

      <td align="center">



      <input name="confirmm" type="submit" class="btn btn-info" value="CONFIRM AND FORWARD LP" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" />



      </td>

    </tr>

  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once "../../../assets/template/layout.bottom.php";

?>