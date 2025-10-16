<?php






 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";











$title='Approving Material Requisition';











do_calander('#req_date');





do_calander('#need_by');











$table_master='requisition_master';





$table_details='requisition_order';





$unique='req_no';

















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





		$msg='Requisition No Created. (Req No :-'.$_SESSION[$unique].')';





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

$_POST['req_date']=date('Y-m-d');


		$crud   = new crud($table_master);





		$crud->update($unique);





		unset($$unique);





		unset($_SESSION[$unique]);





		$type=1;





		$msg='Successfully Forwarded to Relevant Department.';





}











if(isset($_POST['add'])&&($_POST[$unique]>0))





{





		$crud   = new crud($table_details);





		$iii=explode('#>',$_POST['item_id']);





		$_POST['item_id']=$iii[2];





		$_POST['entry_by']=$_SESSION['user']['id'];





		$_POST['entry_at']=date('Y-m-d h:s:i');





		$_POST['edit_by']=$_SESSION['user']['id'];





		$_POST['edit_at']=date('Y-m-d h:s:i');





		$crud->insert();





}





if(isset($_POST[$unique])){

$esql="select * from requisition_order where req_no=".$_POST[$unique];

$equery=db_query($esql);

while($edata=mysqli_fetch_object($equery)){

		if(isset($_POST['edit_'.$edata->id])){

		$qty=$_POST['qty_'.$edata->id];

		$usql="update requisition_order set qty='".$qty."' where id=".$edata->id;

		db_query($usql);



		}

	}

}









if(isset($_GET['detlid']) && $_GET['detlid']>0)



{



		$crud   = new crud('requisition_order');



		$condition="id=".$_GET['detlid'];		



		$crud->delete_all($condition);

		

		unlink('../workorder_pic/'.$_GET['detlid'].'.jpg');



		$type=1;



		$msg='Successfully Deleted.';



}









if($$unique>0)





{





		$condition=$unique."=".$$unique;





		$data=db_fetch_object($table_master,$condition);





		foreach ($data as $key => $value)





		{ $$key=$value;}





		





}





if($$unique>0) $btn_name='Update Requsition Information'; else $btn_name='Initiate Requsition Information';





if($_SESSION[$unique]<1)





$$unique=db_last_insert_id($table_master,$unique);











auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)','product_nature!="Salable"','item_id');





?>

<script language="javascript">

function update_edit(id)

{



var exp_date   = (document.getElementById("exp_date#"+id).value);

var remarks = (document.getElementById("remarks#"+id).value);

var qty = (document.getElementById("qty#"+id).value)*1;



var info = exp_date+"<@>"+remarks+"<@>"+qty;



getData2('do_order_edit_ajax.php', 'update_edit',id,info);



}









</script>



<div class="form-container_large">

  <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

    <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

      <tr>

        <td><fieldset>

          <? $field='req_no';?>

          <div>

            <label for="<?=$field?>">Requisition No: </label>

            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

          </div>

          <? $field='req_date';?>

          <div>

            <label for="<?=$field?>">Requisition Date:</label>

            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=date('Y-m-d')?>" required/>

          </div>

          <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

          <div>

            <label for="<?=$field?>">Warehouse:</label>

            <select id="<?=$field?>" name="<?=$field?>" required>

              <option></option>

              <? foreign_relation($table,$get_field,$show_field,$$field);?>

            </select>

          </div>

          </fieldset></td>

        <td><fieldset>

          <? $field='req_for';?>

          <div>

            <label for="<?=$field?>">Requisition For:</label>

            <input  name="<?=$field?>" type="hidden" id="<?=$field?>" value="<?=$$field?>" />

			

            <select name="<?=$field?>" id="<?=$field?>" >

            <? foreign_relation('warehouse', 'warehouse_id', 'warehouse_name', $$field , '1 order by warehouse_name asc');?>

            </select>

           

          </div>

          <? $field='need_by';?>

          <div>

            <label for="<?=$field?>">Need By(Date):</label>

            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

          </div>

          <? $field='req_note';?>

          <div>

            <label for="<?=$field?>">Additional Note:</label>

            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

          </div>

          </fieldset></td>

      </tr>

      <tr>

        <td colspan="2"><div class="buttonrow" style="margin-left:240px;">

            <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />

          </div></td>

      </tr>

    </table>



  <? if($_SESSION[$unique]>0){?>

  <table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

    <tr>

      <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>

    </tr>

    <tr>

      <td align="right" bgcolor="#CCFF99">Created By:</td>

      <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

        <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

      <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="mr_print_view.php?req_no=<?=$req_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>

    </tr>

    <tr>

      <td align="right" bgcolor="#CCFF99">Created On:</td>

      <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

        <?=$entry_at?></td>

    </tr>

  </table>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

      <td><div class="tabledesign2">



<table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><th>SL/NO</th><th>Item Name</th><th>Stock Qty</th><th>Exp Date</th><th>Remarks</th><th>Qty</th>

  <th>Edit</th>

  <th>Delete</th>

</tr>



<?
$s=0;
 $res='select a.id,concat(b.item_name," :: ",b.item_description) as item_name,a.qoh as stock_qty,a.exp_date,a.remarks,a.qty,"x" from requisition_order a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;

$query=db_query($res);

while($wo_item=mysqli_fetch_object($query)){

do_calander('exp_date#'.$wo_item->id);

?>

<tr>

<td style="text-align:center;"><?=++$s?></td>

<td>&nbsp;<?=$wo_item->item_name?></td><td>&nbsp;<?=$wo_item->stock_qty?></td>

<td><input type="text" name="<?='exp_date#'.$wo_item->id?>" id="<?='exp_date#'.$wo_item->id?>" value="<?=$wo_item->exp_date?>" style="width:80px"/></td>

<td><input type="text" name="<?='remarks#'.$wo_item->id?>" id="<?='remarks#'.$wo_item->id?>" value="<?=$wo_item->remarks?>" style="width:100px"/></td>

<td><input type="text" name="<?='qty#'.$wo_item->id?>" id="<?='qty#'.$wo_item->id?>" value="<?=$wo_item->qty?>" style="width:50px"/></td>



<td><span id="update_edit"><input name="<?='edit#'.$wo_item->id?>" type="button" id="Edit" value="Edit" style="width:40px; height:20px; " onclick="update_edit(<?=$wo_item->id?>);" /></span></td>

<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$wo_item->id?>">&nbsp;X&nbsp;</a></td>



</tr>

<? }?>

	</tbody></table>

      </div></td>

    </tr>

    <tr>

     <td>

 </td>

    </tr>

  </table>

  <? }?>

    </form>

  <? if($_SESSION[$unique]>0){?>

  <form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

    <table width="100%" border="0">

      <tr>

        <td align="center">

        </td>

        <td align="center"><input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD REQUSITION" style="float:right; width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

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

