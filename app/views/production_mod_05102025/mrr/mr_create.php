<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='New Material Requisition Create';

do_calander('#exp_date');
do_calander('#req_date');

$table_master='master_requisition_master';
$table_details='master_requisition_details';
$unique='req_no';
if($_GET['mhafuz']>0)
	unset($_SESSION[$unique]);
	
$sub_group=$_GET['sub_group'];
if($sub_group!=''){
	$_SESSION['session_sub_group']=$sub_group;
}



if(isset($_POST['new'])){
	$crud   = new crud($table_master);
	if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['req_date']=date('Y-m-d');
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Requisition No Created. (Req No :-'.$_SESSION[$unique].')';
	}else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
	}
}

$$unique=$_SESSION[$unique];
if(isset($_POST['delete'])){
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

if($_GET['del']>0){

		$crud   = new crud($table_details);


		$condition="id=".$_GET['del'];		


		$crud->delete_all($condition);


		$type=1;


		$msg='Successfully Deleted.';


}


if(isset($_POST['confirmm'])){
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




$req =$_POST['req_for'];
if(isset($_POST['add'])&&($_POST[$unique]>0)){
	$crud   = new crud($table_details);
	$_POST['req_for'] = $req;
	$iii=explode('#>',$_POST['item_id']);
	$_POST['item_id']=$iii[2];
	$_POST['remarks'];
	$_POST['entry_by']=$_SESSION['user']['id'];
	$_POST['entry_at']=date('Y-m-d h:s:i');
	$_POST['edit_by']=$_SESSION['user']['id'];
	$_POST['edit_at']=date('Y-m-d h:s:i');
	$crud->insert();
}

if($$unique>0){
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
	}


if($$unique>0) $btn_name='Update Requisition Information'; else $btn_name='Initiate Requisition Information';


if($_SESSION[$unique]<1)


$$unique=db_last_insert_id($table_master,$unique);





//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

if($_SESSION['session_sub_group']=='all'){
	$get_data = '';
}else{
	$get_data =$_SESSION['session_sub_group'];
}
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','product_nature = "Purchasable" and sub_group_id like "%'.$get_data.'%"','item_id');


?>


<script language="javascript">


function focuson(id) {


  if(document.getElementById('item_id').value=='')


  document.getElementById('item_id').focus();


  else


  document.getElementById(id).focus();


}

function sub_group_function(id){
	document.getElementById('sub_group_id').value=id;
	window.location.href = "../mr/mr_create.php?sub_group=" + id;
}

window.onload = function() {


if(document.getElementById("warehouse_id").value>0)


  document.getElementById("item_id").focus();


  else


  document.getElementById("req_date").focus();


}


</script>


<div class="form-container_large">


<form action="mr_create.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">


<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">


  <tr>


    <td><fieldset>


    <? $field='req_no';?>


      <div>


        <label for="<?=$field?>">Requisition No: </label>


        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>


      </div>


    <? $field='req_date'; if($req_date=='') $req_date =date('Y-m-d');?>


      <div>


        <label for="<?=$field?>">Requisition Date:</label>


        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style=""/>


      </div>


    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>


      <div>


        <label for="<?=$field?>">Warehouse:</label>


		<input name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>" />


		<input name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" readonly />


      </div>


    </fieldset></td>


    <td>


			<fieldset>


			


    <? $field='req_for';?>


      <div>

		<? $field = 'req_for' ?>
        <label for="<?=$field?>">Requisition For:</label>


        <select id="<?=$field?>" name="<?=$field?>" required  >

              <option></option>

              <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],' use_type="PL"');?>

       </select>


      </div>





    <? $field='req_note';?>


      <div>


        <label for="<?=$field?>">Additional Note:</label>


        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>


      </div>

 <div>


        <label for="do_number">Do Number :</label>


        <input  name="do_number" type="text" id="do_number" value=""/>


      </div>
	      


			</fieldset>	</td>


  </tr>


  <tr>


    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">


      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />


    </div></td>


    </tr>


</table>


</form>


<? if($_SESSION[$unique]>0){?>


<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">


<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">


                      <tr>

						<td width="14%" align="center" bgcolor="#0099FF"><strong>Sub Group</strong></td>
                        <td width="33%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                        <td width="13%" align="center" bgcolor="#0099FF"><strong>Delivery Date</strong></td>
						
                        <td width="7%" align="center" bgcolor="#0099FF"><strong>Stk Qty</strong></td>
                        <td width="9%" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td width="6%" align="center" bgcolor="#0099FF"><strong>Req Qty</strong></td>


                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Remark</strong></td>


                        <td width="7%"  rowspan="2" align="center" bgcolor="#FF0000">


						  <div class="button">


						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>


                      <tr>

						<td align="center" bgcolor="#CCCCCC">
                        	<select name="sub_group" id="sub_group" style="width:100px;" onChange="sub_group_function(this.value)">
                            
                            	<option></option>
								<?php
								if($_SESSION['session_sub_group']=='all'){
									echo '<option value="all" selected>All</option>';
								}else{
									echo '<option value="all">All</option>';
								}
                                $a2="select sub_group_id, sub_group_name from item_sub_group";
                                //echo $a2;
                                $a1=db_query($a2);
                                
                                while($a=mysqli_fetch_row($a1)){
                                if($a[0]==$_SESSION['session_sub_group'])
                                	echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";
                                else
                                	echo "<option value=\"".$a[0]."\">".$a[1]."</option>";
                                }
							?></select>
                        </td>
                        <td align="center" bgcolor="#CCCCCC"><input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
                            <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
                            <input  name="sub_group_id" type="hidden" id="sub_group_id" value="<?=$sub_group_id?>"/>
                            <input  name="req_for" type="hidden" id="req_for" value="<?=$req_for?>"/>
                            <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:170px;" required="required" onBlur="getData2('mr_ajax.php', 'mr', this.value, document.getElementById('warehouse_id').value);"/>                         </td>
						<td align="center" bgcolor="#CCCCCC">	
                        	<? $field="exp_date"; ?>
                        	<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:70px;" required/>                        </td>
						
						
						 <? $field='req_date'; if($req_date=='') $req_date =date('Y-m-d');?>
						 
						 <td colspan="2" align="center" bgcolor="#CCCCCC"><span id="mr">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input name="qoh" type="text" class="input3" id="qoh" style="width:60px;" onFocus="focuson('qty')" readonly/></td>
    <td><input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:30px;" onFocus="focuson('qty')" readonly/></td>
  </tr>
</table>






</span></td>

                         <td align="center" bgcolor="#CCCCCC"><input name="order_qty" type="text" class="input3" id="order_qty"  maxlength="100" style="width:40px;" required/></td>
                         <td align="center" bgcolor="#CCCCCC"><label>
                           <input name="remarks" type="text" id="remarks" style="width:100px;">
                         </label></td>
      </tr>
    </table>


<br /><br /><br /><br />


<? 
$res='select a.id,concat(b.item_name," :: ",b.item_description) as item_name,a.qoh as stock_qty,a.exp_date,a.remarks,a.order_qty,"x" from master_requisition_details a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">





    <tr>


      <td><div class="tabledesign2">


        <? 


//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';


echo link_report_del($res);


		?>





      </div></td>


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





      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL REQUISITION" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />





      </td>


      <td align="center">





      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD REQUISITION" style="width:auto; font-weight:bold; font-size:12px; height:30px; color:#090" />





      </td>


    </tr>


  </table>


</form>


<? }?>


</div>


<script>$("#codz").validate();$("#cloud").validate();</script>


<?


$main_content=ob_get_contents();


ob_end_clean();


require_once SERVER_CORE."routing/layout.bottom.php";


?>