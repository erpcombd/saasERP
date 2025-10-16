<?php

require_once "../../../assets/template/layout.top.php";


 
$title='New Item Return';



$page_for = 'Return';

do_calander('#or_date','-100','0');

do_calander('#quotation_date');

do_calander('#receive_date');





$table_master='warehouse_other_receive';

$table_details='warehouse_other_receive_detail';

$unique='or_no';

if($_POST['or_no']>0){
	$$unique = $_POST['or_no'];
	}

$dealer = ($vendor_id>0)?$vendor_id:$dealer;

if($_POST['dealer']>0) $dealer = $_POST['dealer'];

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

		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}



if($_POST['or_no']>0){
	$$unique = $_POST['or_no'];
	$_SESSION[$unique] = $$unique;
	}else{

$$unique=$_SESSION[$unique];
	}




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
		header('location:select_uncheck_return.php');

}




if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='CHECKED';
		$_POST['or_date']=$_POST['or_date'];
		$crud   = new crud($table_master);
		$crud->update($unique);
		
		if($$unique>0){
		$sql = 'select w.*,i.product_type from warehouse_other_receive_detail w,item_info i where i.item_id=w.item_id and or_no="'.$$unique.'" and w.receive_type="PosReturn"';
		$qry = mysql_query($sql);
		
		while($data = mysql_fetch_object($qry)){
		if($data->product_type=='Serialized'){
	    $avg_rate = find_a_field('journal_item','item_price','tr_from in ("Purchase","Import","SalesReturn","PosReturn") and item_id="'.$data->item_id.'" and serial_no="'.$data->serial_no.'" and item_in>0');
	    }elseif($data->product_type=='Non-serialized'){
		$total_item_price = find_a_field('journal_item','sum(item_in*final_price)','item_id="'.$data->item_id.'"');
		$total_in = find_a_field('journal_item','sum(item_in)','item_id="'.$data->item_id.'"');
		$avg_rate = $total_item_price/$total_in;
		}
		$ex_info = find_all_field('journal_item','','item_id="'.$data->item_id.'" and serial_no="'.$data->serial_no.'" and item_in>0');
		$journal_item_sql = 'insert into journal_item (`ji_date`,`item_id`,`warehouse_id`,`lot_no`,`serial_no`,`item_in`,`item_price`,`final_price`,`tr_from`,`tr_no`,`sr_no`,`entry_by`,`entry_at`) value("'.$_REQUEST['or_date'].'","'.$data->item_id.'","'.$_SESSION['user']['depot'].'","'.$ex_info->lot_no.'","'.$data->serial_no.'","'.$data->qty.'","'.$avg_rate.'","'.$avg_rate.'","PosReturn","'.$data->id.'","'.$$unique.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d h:i:s').'")';
mysql_query($journal_item_sql);
		}
		
		//Journal
$time_now = date('Y-m-d H:s:i');		
//auto_insert_pos_return_secoundary($$unique);	
$sec_jv = find_a_field('secondary_journal','jv_no','tr_no="'.$$unique.'" and tr_from="PosReturn"');	
if($sec_jv>0){
$time_now = date('Y-m-d H:s:i');
$jv=next_journal_voucher_id(); 
//sec_journal_journal($sec_jv,$jv,'PosReturn');
}

		}
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded.';
		header('location:select_uncheck_return.php');
}




if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}



if($$unique>0) $btn_name='Update SR Information'; else $btn_name='Initiate SR Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

$dealer = ($vendor_id>0)?$vendor_id:$dealer;







auto_complete_from_db('item_info','item_id','concat(item_name,"#>",item_id)','1','item_id');

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

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top"><fieldset>

    <? $field='or_no';?>

      <div>

        <label for="<?=$field?>">Sales Return  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" style="width:60%;"/>

      </div>

    <? $field='or_date'; if($or_date=='') $or_date =date(''); ?>

      <div>

        <label for="<?=$field?>">Sales Return Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required class="form-control" style="width:60%;"/>

      </div>

<? $field='receive_date'; if($receive_date=='') $receive_date =date(''); ?>

      <div>

        <label for="<?=$field?>">Chalan Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required class="form-control" style="width:60%;"/>

      </div>

        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>" class="form-control" style="width:60%;"  required/>

        <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required" class="form-control" style="width:60%;"/>

    </fieldset></td>

    <td>

			<fieldset>

			

    <? $field='or_subject';?>

      <div>

        <label for="<?=$field?>">Note:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required class="form-control" style="width:60%;"/>

      </div>

      <div></div>

      <? $field='vendor_name'; 

	  

	  ?>

      <div>

        <label for="<?=$field?>">Vendor Name  :</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<? if($vendor_name=='') echo find_a_field('dealer_info','concat(dealer_name_e,"(",dealer_code,")")','dealer_code='.$dealer); else echo $vendor_name;?>" required="required" class="form-control" style="width:60%;"/>

        <input  name="vendor_id" type="hidden" id="vendor_id" value="<?=($vendor_id>0)?$vendor_id:$dealer;?>" required="required" class="form-control" style="width:60%;"/>

      </div>

      <div>

        <? $field='approved_by';?>

<div>

          <label for="<?=$field?>">Received By :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" style="width:60%;" required/>

        </div>

        

              <div>

        <? $field='manual_or_no';?>

<div>

          <label for="<?=$field?>">POS No :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" style="width:60%;" readonly="readonly" required/>

        </div>

      </div>

			</fieldset>	</td>

  </tr>

  <!--<tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">

      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />

    </div></td>

    </tr>-->

</table>

</form>

<? if($_SESSION[$unique]>0){?>

<!--<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td align="center" bgcolor="#0099FF" width="30%"><strong>Item Name</strong></td>

                        <td align="center" bgcolor="#0099FF" width="15%"><strong>Unit</strong></td>

                        <td align="center" bgcolor="#0099FF" width="15%"><strong>Price</strong></td>

                        <td align="center" bgcolor="#0099FF" width="15%"><strong>Pcs</strong></td>

                        <td align="center" bgcolor="#0099FF" width="15%"><strong>Amount</strong></td>

                          <td  rowspan="2" align="center" bgcolor="#FF0000" width="10%">

						  <div class="button">

						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       

						  </div>				        </td>

      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="vendor_id2" type="hidden" id="vendor_id2" value="<?=($vendor_id>0)?$vendor_id:$dealer;?>" required="required"/>

<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>

<input  name="or_details" type="hidden" id="or_details" value="<?=$or_details?>"/>

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>

<input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('item_return_ajax.php', 'po',this.value+'#$#<?=$vendor_id?>',document.getElementById('warehouse_id').value);"/></td>

<td colspan="2" align="center" bgcolor="#CCCCCC">

<span id="po">
   <table width="100%" cellpadding="0" cellspacing="0" border="1">
   <tr>
     <td width="50%">
<input name="unit" type="text" class="input3" id="unit" style="width:100%;" readonly/>
</td>
<td width="50%">

<input name="price" type="text" class="input3" id="price" style="width:100%;"  readonly="readonly"/>
</td>
</tr>
</table>
</span></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:100%;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:100%;" readonly required/></td>

      </tr>

    </table>

					  <br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

echo $res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_receive_detail a,item_info b where b.item_id=a.item_id and a.or_no='.$or_no;

echo link_report_add_del_auto($res,'',4,6);

?>

</div>

</td>

    </tr>

    <tr>

     <td>



 </td>

    </tr>

  </table>

</form>-->


<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

  $res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.serial_no,a.unit_name,a.amount,"x" from warehouse_other_receive_detail a,item_info b where b.item_id=a.item_id and a.or_no='.$or_no;

echo link_report_add_del_auto($res,'',4,7);

?>

</div>

</td>

    </tr>

    <tr>

     <td>



 </td>

    </tr>

  </table>


<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">

	  

	  <input name="delete" id="delete"  type="submit" class="btn1" value="CANCEL RETURN" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

	 

	  </td>

      <td align="center">

<input name="confirmm" id="confirmm" type="submit" class="btn1" value="CONFIRM RETURN" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" /><input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/><input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/></td>

    </tr>

  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once "../../../assets/template/layout.bottom.php";

?>