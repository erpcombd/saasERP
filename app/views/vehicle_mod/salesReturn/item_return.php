<?php

require_once "../../../assets/template/layout.top.php";



$title='New Item Return';



$page_for = 'Return';

do_calander('#or_date','-100','0');

do_calander('#quotation_date');

do_calander('#receive_date');





$table_master='sales_return_master';

$table_details='sales_return_details';

$unique='or_no';
if($_GET['or_no']>0)
{
$_SESSION[$unique] = $_GET['or_no'];
}


if($_POST['or_no']>0){
	$$unique = $_POST['or_no'];
	}
if($_POST['chalan_no']){
$chalan_no_get=find_a_field('sale_do_chalan','chalan_no','chalan_no_another="'.$_POST['chalan_no'].'"');
$_SESSION['ch_no']=$chalan_no_get;
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
$de_sql='delete from sales_return_details where or_no="'.$_SESSION[$unique].'"';
mysql_query($de_sql);

    foreach ($_POST['checkval'] as $k ) {
        
            $or_no= $_POST['or_no_' . $k]; 
			$item_id= $_POST['item_id_' . $k]; 
			$vendor_id= $_POST['vendor_id_' . $k]; 
			$or_date= $_POST['or_date_' . $k]; 
			$rate= $_POST['rate_' . $k]; 
			$unit_name= $_POST['unitname_' . $k]; 
				$unit= $_POST['unit_' . $k]; 
			$tot_amt= $_POST['totamt_' . $k]; 
			$warehouse_id=$_SESSION['user']['depot'];
		 $in_sql="insert into sales_return_details(or_no,item_id,vendor_id,receive_type,or_date,warehouse_id,rate,qty,unit_name,amount)values('$or_no','$item_id','$vendor_id','Return','$or_date','$warehouse_id','$rate','$unit','$unit_name','$tot_amt')";
		mysql_query($in_sql);
       
    }
$up_sql='update sales_return_master set status="UNCHECKED" where or_no="'.$_SESSION[$unique].'"';
mysql_query($up_sql);
header("Location:select_dealer_return.php");

//		unset($_POST);
//
//		$_POST[$unique]=$$unique;
//
//		$_POST['entry_by']=$_SESSION['user']['id'];
//
//		$_POST['entry_at']=date('Y-m-d h:s:i');
//
//		$_POST['status']='UNCHECKED';
//
//		$crud   = new crud($table_master);
//
//		$crud->update($unique);
//
//		unset($$unique);
//
//		unset($_SESSION[$unique]);
//
//		$type=1;
//
//		$msg='Successfully Forwarded.';

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

		$item = find_all_field('item_info','','item_id="'.$_POST['item_id'].'"');

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['or_date'],$_POST['qty'],0,'Sales Return',$xid,$_POST['rate'],'',$_POST[$unique]);

		

		$chalan_no=$_POST['or_details'];

$ssql = 'select m.do_no,m.do_date, d.* from sale_do_details d,sale_do_chalan c,sale_do_master m where d.id=c.order_no and d.gift_on_item = "'.$_POST['item_id'].'" and c.chalan_no="'.$_POST['or_details'].'" and c.do_no=m.do_no';

$order=find_all_field_sql($ssql);



if($order->gift_on_order>0)

	{

		$sss = "select * from sale_gift_offer where item_id='".$_POST['item_id']."' and start_date<='".$order->do_date."' and end_date>='".$order->do_date."' limit 1";

		$qqq = mysql_query($sss);

		$gift=mysql_fetch_object($qqq);

		

		if($gift->item_qty>0)

		{

			

			$gift_item = find_all_field('item_info','','item_id="'.$gift->gift_id.'"');

			

			$_POST['item_id'] = $gift->gift_id;

			if($gift->gift_id== 1096000100010239)

			{

			$qty = $_POST['qty'];

			$_POST['receive_type'] = 'Return';

			$_POST['rate'] = (-1)*($gift->gift_qty);

			$_POST['amount']  = (-1)*(int)(($qty*$gift->gift_qty)/$item->pack_size);

			$_POST['qty'] = (((int)($qty/($gift->item_qty))));

			

			$crud->insert();

			}

			

			else

			{

			

//			$_POST['receive_type'] = 'Return';

//			$_POST['rate'] = (int)(($_POST['qty']*$gift->gift_qty)/$item->pack_size);

//			$_POST['amount']  = (int)(($_POST['qty']*$gift->item_qty)/$item->pack_size);

//			$_POST['qty'] = (((int)($_POST['total_unit']/($gift->item_qty*$item->pack_size))));

//			$crud->insert();

			}

		unset($_POST['gift_on_order']);

		unset($_POST['gift_on_item']);

		}

	}

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







auto_complete_from_db('item_info','concat(item_name,"#>",item_id,"#",finish_goods_code)','concat(item_name,"#>",item_id,"#",finish_goods_code)','1','item_id');

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

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top"><fieldset>

    <? $field='or_no';?>

      <div>

        <label for="<?=$field?>">Sales Return  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      </div>

    <? $field='or_date'; if($or_date=='') $or_date =date(''); ?>

      <div>

        <label for="<?=$field?>">Sales Return Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" autocomplete="off" required/>

      </div>


<? $field='chalan_no';?>


      <div>

        <label for="<?=$field?>">Chalan No:</label>

		<input list="ch_list" name="<?=$field?>" id="<?=$field?>">

<datalist id="ch_list">
<?php 
$ch_sql='select * from sale_do_chalan where dealer_code="'.$dealer.'" group by chalan_no';
$ch_query=mysql_query($ch_sql);
while($row3=mysql_fetch_object($ch_query)){
?>
  <option value="<?php echo $row3->chalan_no_another;?>">
<?php } ?>
</datalist>

      </div>



<? $field='receive_date'; if($receive_date=='') $receive_date =date(''); ?>


      <div>

        <label for="<?=$field?>">Chalan Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>

        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>

        <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>

    </fieldset></td>

    <td>

			<fieldset>

			

    <? $field='or_subject';?>

      <div>

        <label for="<?=$field?>">Note:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>

      <div></div>

      <? $field='vendor_name'; 

	  

	  ?>

      <div>

        <label for="<?=$field?>">Customer Name  :</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<? if($vendor_name=='') echo find_a_field('dealer_info','concat(dealer_name_e,"(",dealer_code,")")','dealer_code='.$dealer); else echo $vendor_name;?>" required="required"/>

        <input  name="vendor_id" type="hidden" id="vendor_id" value="<?=($vendor_id>0)?$vendor_id:$dealer;?>" required="required"/>

      </div>

      <div>

        <? $field='approved_by';?>

<div>

          <label for="<?=$field?>">Received By :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

        </div>

        

              <div>

        <? $field='manual_or_no';?>

<div>

          <label for="<?=$field?>">Receive SR No :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

        </div>

      </div>

			</fieldset>	</td>

  </tr>

  <tr>

    <td colspan="2"><div class="buttonrow text-center" ><span class="buttonrow" >

      <? if($_SESSION[$unique]>0) {?>
         <!-- <input name="new" type="submit" class="btn1" value="Update Sales Return" style="width:200px; font-weight:bold; font-size:12px; tabindex="12>-->
		  <button type="submit" name="new" id="new" class="btn btn-success">Update SR information</button>
          <input name="flag2" id="flag2" type="hidden" value="1" />
          <? }else{?>
          <!--<input name="new" type="submit" class="btn1" value="Initiate Sales Return" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />-->
		  <button type="submit" name="new" id="new" class="btn btn-primary">Initiate SR Information</button>
          <input name="flag2" id="flag2" type="hidden" value="0" />
          <? }?>
        </span></div>
		
		</td>

    </tr>

</table>

</form>

<? if($_SESSION[$unique]>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<!--<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

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

    </table>-->

					  <br /><br /><br /><br />





<table style="cursor:pointer" width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>



</td>

    </tr>

	    	

	



				

    <tr>

     <td>



 </td>

    </tr>

  </table>

</form>

<!--<form action="select_dealer_return.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="tabledesign2">

<table id="grp" cellpadding="0" cellspacing="0" width="100%">
	<thead>
		<tr>
		<th>Select Item  <img src="checkbox.png" style="width:22px;" /></th>
			<th>Item Code</th>
			<th>Item Name</th>
			<th>Unit Price</th>
			<th>Quantity</th>
			<th>Unit Name</th>
			<th>Amount</th>
		</tr>
	</thead>
	
	<tbody>
	<?php
		$sql='select * from sale_do_chalan where chalan_no="'.$_SESSION['ch_no'].'"';
		$query=mysql_query($sql);
		while($row=mysql_fetch_object($query)){
		$item_all=find_all_field('item_info','','item_id='.$row->item_id);
		$mas_or_all=find_all_field('sales_return_master','','or_no="'.$_SESSION[$unique].'"');
	 ?>
	<tr>
	<td><input type="checkbox" id="checkval[]" name="checkval[]" value="<?=$row->id?>"></td>
		<td><?=find_a_field('item_info','finish_goods_code','item_id='.$row->item_id);?></td>
		<td><?=$item_all->item_name?></td>
		<td><?=$row->unit_price?></td>
		<input type="hidden" name="or_no_<?=$row->id?>" id="or_no_<?=$row->id?>" value="<?=$mas_or_all->or_no?>" />
		<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />
		<input type="hidden" name="vendor_id_<?=$row->id?>" id="vendor_id_<?=$row->id?>" value="<?=$mas_or_all->vendor_id?>" />
		<input type="hidden" name="or_date_<?=$row->id?>" id="or_date_<?=$row->id?>" value="<?=$mas_or_all->or_date?>" />
		<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$mas_or_all->unit_price?>" />
			<input type="hidden" name="unitname_<?=$row->id?>" id="unitname_<?=$row->id?>" value="<?=$item_all->unit_name?>" />
		<td><input type="text" name="unit_<?=$row->id?>" id="unit_<?=$row->id?>" value="<?=$row->total_unit?>" /></td>
		<td><?=$item_all->unit_name?></td>
		<td><input type="text" name="totamt_<?=$row->id?>" id="totamt_<?=$row->id?>" value="<?=$row->total_amt?>" /></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>




</div>
  <table width="100%" border="0">

    <tr>

      <td align="center">

	  <? if(find($res)==0){?>

	  <input name="delete" id="delete"  type="submit" class="btn1" value="CANCEL REMAINNING SR" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

	  <? }?>

	  </td>

      <td align="center">

<input name="confirmm" id="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD SR" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" /><input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/></td>

    </tr>

  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once "../../../assets/template/layout.bottom.php";

?>