<?php






 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";











$title='New Material Requisition Create';

















do_calander('#exp_date');

do_calander('#req_date','+0','+0');











$table_master='requisition_master';





$table_details='requisition_order';





$unique='req_no';





$sub_group=$_GET['sub_group'];

if($sub_group!=''){

	$_SESSION['session_sub_group']=$sub_group;

}





if($_GET['mhafuz']>0)





unset($_SESSION[$unique]);











if(isset($_POST['new']))





{

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





		}





		else {





		$_POST['edit_by']=$_SESSION['user']['id'];





		$_POST['edit_at']=date('Y-m-d H:i:s');





		$crud->update($unique);





		$type=1;





		$msg='Successfully Updated.';





		}





}











$$unique=$_SESSION[$unique];











//if(isset($_POST['delete']))
//
//
//
//
//
//{
//
//
//
//
//
//		$crud   = new crud($table_master);
//
//
//
//
//
//		$condition=$unique."=".$$unique;		
//
//
//
//
//
//		$crud->delete($condition);
//
//
//
//
//
//		$crud   = new crud($table_details);
//
//
//
//
//
//		$condition=$unique."=".$$unique;		
//
//
//
//
//
//		$crud->delete_all($condition);
//
//
//
//
//
//		unset($$unique);
//
//
//
//
//
//		unset($_SESSION[$unique]);
//
//
//
//
//
//		$type=1;
//
//
//
//
//
//		$msg='Successfully Deleted.';
//
//
//
//
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



		





		$_POST[$unique]=$$unique;





		$_POST['entry_by']=$_SESSION['user']['id'];





		$_POST['entry_at']=date('Y-m-d h:s:i');
		
		if($_POST['reqtype']!='Engineering'){$_POST['status']='UNCHECKED';}else{$_POST['status']='ENG_UNCHECKED';}



		$crud   = new crud($table_master);





		$crud->update($unique);





		unset($$unique);





		unset($_SESSION[$unique]);


unset($_POST);


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

	$_POST['entry_at']=date('Y-m-d h:i:s');

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




if($req_type=='Engineering'){ $con .= ' and s.sub_group_id in(2400020000,2400010000,1100140000,2400060000,1100100000,1100110000,2400030000,1100120000,2400040000,2400050000,1100080000,1400160000,1500030000,1100050000,1300010000,1400150000,1500020000,1100010000,1400120000,1400140000,2300010000,1100060000)';}

if($req_type=='General'){ $con .= ' and s.sub_group_id not in(2400020000,2400010000,1100140000,2400060000,1100100000,1100110000,2400030000,1100120000,2400040000,2400050000,1100080000,1400160000,1500030000,1100050000,1300010000,1400150000,1500020000,1100010000,1400120000,1400140000,2300010000,1100060000)';}



auto_complete_from_db('item_info i,item_sub_group s','i.item_name','concat(item_name,"#>#>",item_id,"#>",finish_goods_code)',' i.sub_group_id like "%'.$get_data.'%" and i.sub_group_id=s.sub_group_id  '.$con.' ','item_id');




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

	window.location.href = "../pr_req/mr_create.php?sub_group=" + id;

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

<?

$select = "select req_no , req_for from requisition_master where 1 order by req_no";

 $query=db_query($select);

 while($sr=mysqli_fetch_object($query)){
 $select2 = "select count(req_no) as co from requisition_master where req_no<".$sr->req_no." and req_for=".$sr->req_for;
$query2 =db_query($select2);
$c = mysqli_fetch_object($query2);
$req_count= $c->co;
 $select3 = "update requisition_master set temp_id='".($req_count+1)."' where req_no=".$sr->req_no." and req_for=".$sr->req_for;
$query3 =db_query($select3);

}


 ?>

		<? $field = 'req_for' ?>

        <label for="<?=$field?>">Requisition For:</label>


<select id="<?=$field?>" name="<?=$field?>" required onchange="getData2('manual_req_no_ajax.php', 'manual_req_no', this.value, document.getElementById('req_no').value);" >

<? 
if($_POST['req_for']>0)
foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],' use_type="PL"');
elseif($req_for>0)
foreign_relation('warehouse','warehouse_id','warehouse_name',$req_for,' use_type="PL"');
else{
echo '<option></option>';
foreign_relation('warehouse','warehouse_id','warehouse_name',$req_for,' use_type="PL"');
}
?>
</select>





      </div>


<? $field='manual_req_no';?>
 <div>





        <label for="<?=$field?>">Line Req No:</label>



<span id="manual_req_no">
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
</span>


      </div>


<? $field='req_type';?>





      <div>





        <label for="<?=$field?>">Req Type:</label>





       
		<select name="<?=$field?>" id="<?=$field?>" >
			<option value="General" <? if($$field=='General') echo "selected";  ?> >General</option>
			<option value="Engineering" <? if($$field=='Engineering') echo "selected";   ?>   >Engineering</option>
		</select>




      </div>




    <? $field='req_note';?>





      <div>





        <label for="<?=$field?>">Additional Note:</label>





        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>





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



						<td width="100" align="center" bgcolor="#0099FF"><strong>Sub Group</strong></td>

                        <td width="175" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>

                        <td width="70" align="center" bgcolor="#0099FF"><strong>Delivery Date</strong></td>
                        <td  align="center" bgcolor="#0099FF" style="width: 70px;"><strong>Floor</strong></td>

						

                        <td align="center" bgcolor="#0099FF"  style="width: 70px;"><strong>Pending Qty </strong></td>
                        <td  align="center" bgcolor="#0099FF"  style="width: 90px;"><strong>C.W.H</strong></td>

                        <td  align="center" bgcolor="#0099FF"  style="width: 50px;"><strong>Unit</strong></td>

                        <td  align="center" bgcolor="#0099FF"><strong>Req Qty</strong></td>





                        <td width="183" align="center" bgcolor="#0099FF"><strong>Remark</strong></td>





                        <td width="44"  rowspan="2" align="center" bgcolor="#FF0000">





						  <div class="button">
						    <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update" required/>
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

                               echo  $a2="select sub_group_id, sub_group_name from item_sub_group where  group_id!=500000000";

                                //echo $a2;

                                $a1=db_query($a2);

                                

                                while($a=mysqli_fetch_row($a1)){

                                if($a[0]==$_SESSION['session_sub_group'])

                                	echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

                                else

                                	echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

                                }

							?></select>                        </td>

                        <td align="center" bgcolor="#CCCCCC">
						<input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

                            <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

                            <input  name="sub_group_id" type="hidden" id="sub_group_id" value="<?=$sub_group_id?>"/>

                            <input  name="req_for" type="hidden" id="req_for" value="<?=$req_for?>"/>

								<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:170px;" required="required" onBlur="getData2('mr_ajax.php', 'mr', this.value, document.getElementById('warehouse_id').value+'#-#'+document.getElementById('req_for').value);"/>                         </td>

						<td align="center" bgcolor="#CCCCCC"><? $field="exp_date"; ?>
						  <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:70px;" required="required"/></td>
						  
						<td colspan="4" align="center" bgcolor="#CCCCCC"><span id="mr">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td><input  name="floor" type="text" id="floor" style="width:55px;" required=""/></td>

    <td><input name="pqty" type="text" class="input3" id="pqty" style="width:60px;" onFocus="focuson('qty')" readonly/></td>
    <td><input name="qoh" type="text" class="input3" id="qoh" style="width:60px;" onFocus="focuson('qty')" readonly/></td>

    <td><input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:40px;" onFocus="focuson('qty')" readonly/></td>
  </tr>
</table>













                        </span></td>

						

						

						 <? $field='req_date'; if($req_date=='') $req_date =date('Y-m-d');?>

						 

						 <td align="center" bgcolor="#CCCCCC"><input name="qty" type="number" step="any" class="input3" id="qty"  maxlength="100" style="width:50px;" required/></td>

                         <td align="center" bgcolor="#CCCCCC"><label>

                           <input name="remarks" type="text" id="remarks" style="width:100px;">

                         </label></td>
      </tr>
    </table>





<br /><br /><br /><br />





<? 





 $res='select a.id,concat(b.item_name," :: ",b.item_description) as item_name,a.qoh as stock_qty,a.exp_date,a.remarks,a.qty,"x" from requisition_order a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;





?>





<table width="100%" border="0" cellspacing="0" cellpadding="0">











    <tr>





      <td><div class="tabledesign2">





        <? 

$req_count = find_a_field('requisition_order','count(1)','req_no="'.$$unique.'"');

if($req_count>0){
echo link_report_del($res);

}



		?>











      </div></td>





    </tr>





	    	





	











				





    <tr>





     <td>











 </td>





    </tr>





  </table>





</form>
<?
if($req_count>0){
?>
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">





  <table width="100%" border="0">





    <tr>





      <td align="center">











      <input name="delete"  type="hidden" class="btn1" value="DELETE AND CANCEL REQUISITION" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />











      </td>





      <td align="center">









		<input name="reqtype" type="text" value="<?=$req_type?>"/>

        
          <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD REQUISITION" style="float:right;width:auto; font-weight:bold; font-size:12px; height:30px; color:#090" required />
          
          
          
          
          
          
          
          
          
          
          
        </td>





    </tr>





  </table>





</form>





<? }}?>





</div>





<script>$("#codz").validate();$("#cloud").validate();</script>





<?





$main_content=ob_get_contents();





ob_end_clean();





require_once SERVER_CORE."routing/layout.bottom.php";





?>