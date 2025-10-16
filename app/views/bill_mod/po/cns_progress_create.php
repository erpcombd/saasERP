<?


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Progress Report Entry';




do_calander('#progress_date');

do_calander('#date');



$table_master='daily_progress_master';

$table_details='daily_progress_details';

$unique='d_id';
if($_GET['d_id']){
$_SESSION[$unique]=$_GET['d_id'];
}
if($_GET['mhafuz']>0) { $_SESSION[$unique] = '' ;  }
 
if(isset($_POST['new'])){ 

		$crud   = new crud($table_master);
		
		if($_SESSION[$unique] == '') { 
		

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$$unique=$_SESSION[$unique]=$crud->insert();
		
		
		}

		unset($$unique);

		$type=1;

		$msg='Purchase Order No Created. (PO No :-'.$_SESSION[$unique].')';
		
		header('Location:cns_progress_create.php');

		}else{ 

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);
		


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

$sql3='update requisition_order r, daily_progress_details p set r.req_status=0 where p.req_id=r.id and p.id='.$_GET['del'];
db_query($sql3);


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
        
		$_POST['status']='PENDING';
		

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded for Approval.';
		header('Location:cns_progress_create.php?new=2');

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





auto_complete_from_db('item_info i, item_brand b','concat(i.item_name,"#>",i.item_id,"#>",b.brand_name)','concat(item_name,"#>",item_id)','1 and i.item_brand=b.id','item_id');


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
		 <? $field='d_id';?>
            <label for="d_id" >ID: </label>
           <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>
  </div>
		  
		 <div class="col-md-3 form-group">
		 <? $field='progress_date'; if($progress_date=='') $progress_date =date('Y-m-d');?>
        <div>
        <label for="<?=$field?>"> Date:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=($$field!='')? $$field : date('Y-m-d');?>" readonly="readonly"  required/>
       </div>
	   </div>
	   
	   <div class="col-md-3 form-group">
      <p>
        <? $field='progress_for';?>
        <label for="<?=$field?>">Progress For: </label>
	<select name="progress_for" id="progress_for" class="form-control">
	 <? foreign_relation('daily_progress_setup','id','type',$$field,'tr_from ="progress for"');?>
	</select>
	

      </p>
	  </div>
	   
		
	</div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <form action="<?=$page?>" method="post" name="codz2" id="codz2" class="font-weight-bold">
  
  
         
		  </div>
    

  <tr>

    <td colspan="2"><div class="buttonrow text-center" ><span class="buttonrow" >

      <? if($_SESSION[$unique]>0) {?>

		  <button type="submit" name="new" id="new" class="btn btn-success">Update Information</button>
          <input name="flag2" id="flag2" type="hidden" value="1" />
          <? }else{?>

		  <button type="submit" name="new" id="new" class="btn btn-primary">Initiate Information</button>
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

if($progress_for=='1'){
?>

			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Section</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Action Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Target Amount</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Challenges</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Follow up</strong></td>

                          <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>
<input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" /></td>
    
    <td width="25%"><input name="address" type="text" class="input3" id="address" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="pet_type" type="text" class="input3" id="pet_type"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="delivery" type="text" class="input3" id="delivery" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="gap_analysis" type="text" class="input3" id="gap_analysis" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="collection" type="text" class="input3" id="collection" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="next_visit" type="text" class="input3" id="next_visit" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

 $res='select a.id, a.customer_name as name, a.address as section, a.pet_type as action_plan, a.delivery as target_amount, a.gap_analysis as challenges, a.collection as progress, a.next_visit as follow_up, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>
<? } elseif($progress_for=='2'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Particulars</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Customer Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Problem</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Requisition</strong></td>
                        <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div></td>
						 </tr>
                      <tr>
					<td align="center" bgcolor="#CCCCCC">
					
					<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
					<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"   />
					<select name="particular" id="particular" style="width:98%;" required>
						<? foreign_relation('daily_progress_setup','id','particulars',$particular,' tr_from ="particular scm" ');?>
					</select>
					</td>
	<td width="25%"><input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" /></td>
    <td><input name="amount" type="text" class="input3" id="amount" style="width:98%;" /></td>
    
	<td align="center" bgcolor="#CCCCCC"><input name="plan" type="text" class="input3" id="plan"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="progress" type="text" class="input3" id="progress" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="problem" type="text" class="input3" id="problem" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="requisition" type="text" class="input3" id="requisition" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

 $res='select a.id, d.particulars,a.customer_name,a.amount, a.plan, a.progress, a.problem,a.requisition,"x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id; 
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>





<? } elseif($progress_for=='53'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Project Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Component</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Target %</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Achieved %</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Problem encountered</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Corrective action</strong></td>

                          <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">
    
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>
<input name="day" type="text" class="input3" id="day" style="width:98%;"  />
</td>
    <td width="25%"><input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" /></td>
    <td width="25%"><input name="plan" type="text" class="input3" id="plan" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="man_power" type="text" class="input3" id="man_power"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="progress" type="text" class="input3" id="progress" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="requisition" type="text" class="input3" id="requisition" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

  $res='select a.id, a.day as project_name, a.customer_name as component, a.plan as target, a.man_power as achieved, a.progress as problem_encountered,a.requisition as corrective_action, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? }




 elseif($progress_for=='31'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
					  	<td width="11%" align="center" bgcolor="#0099FF"><strong>Project</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Section</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Action Plan</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Amount/Qty</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Challenges</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Departmental Step</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Recommendation</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Suggestion</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Time Line</strong></td>

                          <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

   
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>
<input name="address" type="text" class="input3" id="address" style="width:98%;" />
</td>
	
    <td width="25%"><input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" /></td>
    <td width="25%"><input name="plan" type="text" class="input3" id="plan" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="collection" type="text" class="input3" id="collection"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="man_power" type="text" class="input3" id="man_power"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="service_type" type="text" class="input3" id="service_type"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="progress" type="text" class="input3" id="progress" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="gap_analysis" type="text" class="input3" id="gap_analysis" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="findings" type="text" class="input3" id="findings" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="next_visit" type="text" class="input3" id="next_visit" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

  $res='select a.id, a.address as project, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step,a.collection as qty, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? } elseif($progress_for=='52'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Date</strong></td>
                        <td width="25%" align="center" bgcolor="#0099FF"><strong>Customer Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Lot No</strong></td>
                        <td width="16%" align="center" bgcolor="#0099FF"><strong>Product Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Unit Price</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Production Target</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Production Achieved</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Delivery Target</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Delivery Achieved</strong></td>

                          <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

	    
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>

<input  name="date" type="text" id="date" value="<?php if($_REQUEST['date'] != '') echo $_REQUEST['date']; else echo date('Y-m-d');?>" style="width:98%;"  /></td>
    <td align="center" bgcolor="#CCCCCC"><input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" /></td>
    <td align="center" bgcolor="#CCCCCC"><input name="man_power" type="text" class="input3" id="man_power" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="plan" type="text" class="input3" id="plan"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="collection" type="text" class="input3" id="collection" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="outstanding" type="text" class="input3" id="outstanding" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="category" type="text" class="input3" id="category" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="pet_type" type="text" class="input3" id="pet_type" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

  $res='select a.id, a.date, a.customer_name, a.man_power as lot_no, a.plan as product_name, a.amount as unit_price, a.collection as production_target, a.outstanding as production_achieved, a.category as delivery_target, a.pet_type as delivery_achieved, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>


<? } elseif($progress_for=='51'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
					  	<td width="11%" align="center" bgcolor="#0099FF"><strong>Project</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Section</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Action Plan</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Amount/Qty</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Challenges</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Departmental Step</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Recommendation</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Suggestion</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Time Line</strong></td>

                          <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

    
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>
<input name="address" type="text" class="input3" id="address" style="width:98%;" />
</td>
	
    <td width="25%"><input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" /></td>
    <td width="25%"><input name="plan" type="text" class="input3" id="plan" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="collection" type="text" class="input3" id="collection"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="man_power" type="text" class="input3" id="man_power"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="service_type" type="text" class="input3" id="service_type"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="progress" type="text" class="input3" id="progress" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="gap_analysis" type="text" class="input3" id="gap_analysis" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="findings" type="text" class="input3" id="findings" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="next_visit" type="text" class="input3" id="next_visit" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

  $res='select a.id, a.address as project, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step,a.collection as qty, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? } elseif($progress_for=='32'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Owner</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Address</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Pet Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Pet Type</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Patient Category</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Service type</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Mobile</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Email</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Next Visit</strong></td>
						  <td width="11%" align="center" bgcolor="#0099FF"><strong>Total</strong></td>
						  <td width="11%" align="center" bgcolor="#0099FF"><strong>Remarks</strong></td>

                          <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

    
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>

	   <input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" />
</td>
						  
						  
	<td width="25%"><input name="address" type="text" class="input3" id="address" style="width:98%;" /></td>
    <td width="25%"><input name="man_power" type="text" class="input3" id="man_power" style="width:98%;" /></td>
    <td width="25%"><input name="pet_type" type="text" class="input3" id="pet_type" style="width:98%;" /></td>
    <td width="25%"><input name="pet_category" type="text" class="input3" id="pet_category" style="width:98%;" /></td>
    <td width="25%"><input name="service_type" type="text" class="input3" id="service_type" style="width:98%;" /></td>
    <td width="25%"><input name="mobile" type="text" class="input3" id="mobile" style="width:98%;" /></td>
    <td width="25%"><input name="email" type="text" class="input3" id="email" style="width:98%;" /></td>
    <td width="25%"><input name="next_visit" type="text" class="input3" id="next_visit" style="width:98%;" /></td>
    <td width="25%"><input name="amount" type="text" class="input3" id="amount" style="width:98%;" /></td>
    <td width="25%"><input name="findings" type="text" class="input3" id="findings" style="width:98%;" /></td>
	
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

  $res='select a.id, a.customer_name as Owner,a.address,a.man_power as Pet_name,a.pet_type,a.pet_category,a.service_type,a.mobile,a.email,a.next_visit,a.amount,a.findings as remarks, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>


<? }elseif($progress_for=='3'){  ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Particulars</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Problem</strong></td>
                        <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div></td>
						 </tr>
                      <tr>
					<td align="center" bgcolor="#CCCCCC">
					
					<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
					<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"   />
					<select name="particular" id="particular" style="width:98%;" required>
						<? foreign_relation('daily_progress_setup','id','particulars',$particular,' tr_from ="particular acc" ');?>
					</select>
					</td>
	<td align="center" bgcolor="#CCCCCC"><input name="plan" type="text" class="input3" id="plan"  maxlength="100" style="width:98%;" /></td>				
    <td width="25%"><input name="amount" type="text" class="input3" id="amount" style="width:98%;" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="progress" type="text" class="input3" id="progress" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="problem" type="text" class="input3" id="problem" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

    $res='select a.id, d.particulars as particular,  a.plan, a.amount, a.progress, a.problem, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id; 
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>
<? } elseif($progress_for=='4'){ ?>
		<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Date</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Customer Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Problem</strong></td>
                        <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div></td>
						 </tr>
                      <tr>
					<td align="center" bgcolor="#CCCCCC">
					
					<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
					<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"   />
					<input name="date" type="text" class="input3" id="date" style="width:98%;" value="<?php if($_REQUEST['date'] != '') echo $_REQUEST['date']; else echo date('Y-m-d');?>" /></td>	
					
					 <td width="25%"><input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" /></td>
	<td width="25%"><input name="amount" type="text" class="input3" id="amount" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="problem" type="text" class="input3" id="problem" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

    $res='select a.id,a.date,a.customer_name, a.amount, a.problem, "x" 
  from daily_progress_details a where   a.d_id='.$d_id;  
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? } elseif($progress_for=='55'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Date</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Day</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Section</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Action Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Challenges</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Follow up</strong></td>

                          <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

 
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>

<input  name="date" type="text" id="date" value="<?php if($_REQUEST['date'] != '') echo $_REQUEST['date']; else echo date('Y-m-d');?>" style="width:98%;"  /></td>
	<td width="25%"><input name="day" type="day" class="input3" id="day" style="width:98%;" value="<?php echo date('l', strtotime(date('Y-m-d')));?>" /></td>
    <td width="25%"><input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" /></td>
    <td width="25%"><input name="plan" type="text" class="input3" id="plan" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="man_power" type="text" class="input3" id="man_power"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="collection" type="text" class="input3" id="collection"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="progress" type="text" class="input3" id="progress" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="gap_analysis" type="text" class="input3" id="gap_analysis" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php

  $res='select a.id, a.date, a.day, a.customer_name as section, a.plan as action_plan, a.man_power as challenges,a.collection as qty, a.progress, a.gap_analysis as follow_up,  "x" from daily_progress_details a where  a.d_id='.$d_id; 
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? } elseif($progress_for=='5'){?>
	<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Particulars</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Customers</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Project Name</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Man power</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Target</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Problem</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Requisition</strong></td>
                        <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div></td>
						 </tr>
                      <tr>
					<td align="center" bgcolor="#CCCCCC">
					
					<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
					<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"   />
					<select name="particular" id="particular" style="width:98%;" required>
						<? foreign_relation('daily_progress_setup','id','particulars',$particular,' tr_from ="production" ');?>
					</select>
					</td>
					 <td width="25%"><input name="customer_name" type="text" class="input3" id="customer_name" style="width:98%;" /></td>
					 <td width="25%"><input name="project_name" type="text" class="input3" id="project_name" style="width:98%;" /></td>
					 <td width="25%"><input name="man_power" type="text" class="input3" id="man_power" style="width:98%;" /></td>
					 <td width="25%"><input name="target" type="text" class="input3" id="target" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="plan" type="text" class="input3" id="plan"  maxlength="100" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="progress" type="text" class="input3" id="progress" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="problem" type="text" class="input3" id="problem" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="requisition" type="text" class="input3" id="requisition" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php
	
	$res='select a.id, d.particulars as particular,  a.customer_name, a.project_name, a.man_power,a.target, a.plan, a.progress, a.problem, a.requisition, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
  
    
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>

<? } elseif($progress_for=='35'){?>
	<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Particulars</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>H/O</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Showroom</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>LD Hospital</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Factory</strong></td>
                        <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div></td>
						 </tr>
                      <tr>
					<td align="center" bgcolor="#CCCCCC">
					
					<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
					<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"   />
					<select name="particular" id="particular" style="width:98%;" required>
						<? foreign_relation('daily_progress_setup','id','particulars',$particular,' tr_from ="particular hr" ');?>
					</select>
					</td>
					 <td width="25%"><input name="head_office" type="text" class="input3" id="head_office" style="width:98%;" /></td>
					 <td width="25%"><input name="showroom" type="text" class="input3" id="showroom" style="width:98%;" /></td>
					 <td width="25%"><input name="ld_hospital" type="text" class="input3" id="ld_hospital" style="width:98%;" /></td>
					 <td width="25%"><input name="factory" type="text" class="input3" id="factory" style="width:98%;" /></td>
      </tr>
    </table>

</form>

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">

<div class="tabledesign2">
<span id="codzList">
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
	
	<?php
	
	$res='select a.id, d.particulars as particular,  a.head_office, a.showroom, a.ld_hospital,a.factory, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
  
    
	echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>

<? }?>
	
	
	
	
	
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



      <input name="delete"  type="submit" class="btn btn-danger" value="DELETE" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" />



      </td>

      <td align="center">

<input type="hidden" name="req_no"  value="<?=$req_no?>"/>
  <? $d_d=find_a_field('daily_progress_details','count(d_id)','d_id='.$d_id);
   if($d_d>0){
  ?>
      <input name="confirmm" type="submit" class="btn btn-info" value="CONFIRM" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" />
  <? } ?>


      </td>

    </tr>

  </table>

</form>

<? }?>
</div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>