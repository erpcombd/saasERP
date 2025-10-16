<?php

require_once "../../../assets/template/layout.top.php";



$title='New Direct Sales';



$page_for = 'Direct sales';

do_calander('#oi_date','-100','0');

do_calander('#quotation_date');

do_calander('#receive_date');





$table_master='warehouse_other_issue';

$table_details='warehouse_other_issue_detail';

$unique='oi_no';

if($_POST['oi_no']>0){
	$$unique = $_POST['oi_no'];
	}

$dealer = ($dealer_id>0)?$dealer_id:$dealer;

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

		}else{

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}


if($_POST['oi_no']>0){
	$$unique = $_POST['oi_no'];
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

		$msg='Successfully Forwarded.';

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

		journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],$_POST['qty'],0,'Sales Return',$xid,$_POST['rate'],'',$_POST[$unique]);

		

		$chalan_no=$_POST['oi_details'];



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

$dealer = ($dealer_id>0)?$dealer_id:$dealer;







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

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top"><fieldset>

    <? $field='oi_no';?>

      <div>

        <label for="<?=$field?>">ID: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      </div>

    <? $field='oi_date'; if($oi_date=='') $oi_date =date(''); ?>

      <div>

        <label for="<?=$field?>"> Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>



        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>

        <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>

    </fieldset></td>

    <td>

			<fieldset>

			

    <? $field='oi_subject';?>

      <div>

        <label for="<?=$field?>">Note:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>

      <div></div>

      <? $field='dealer_name'; 

	  

	  ?>

      <div>

        <label for="<?=$field?>">Party Name  :</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<? if($dealer_name=='') echo find_a_field('dealer_info','concat(dealer_name_e,"(",dealer_code,")")','dealer_code='.$dealer); else echo $dealer_name;?>" required="required"/>

        <input  name="dealer_id" type="hidden" id="dealer_id" value="<?=($dealer_id>0)?$dealer_id:$dealer;?>" required="required"/>

      </div>

      <div>

        <? $field='approved_by';?>

<div>

          <label for="<?=$field?>">Received By :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

        </div>

        

              <div>

        <? $field='manual_oi_no';?>

<div>

          <label for="<?=$field?>">SL No :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

        </div>

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

<input  name="dealer_id2" type="hidden" id="dealer_id2" value="<?=($dealer_id>0)?$dealer_id:$dealer;?>" required="required"/>

<input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="oi_date" type="hidden" id="oi_date" value="<?=$oi_date?>"/>

<input  name="oi_details" type="hidden" id="oi_details" value="<?=$oi_details?>"/>

<input  name="dealer_id" type="hidden" id="dealer_id" value="<?=$dealer_id?>"/>

<input  name="dealer_name" type="hidden" id="dealer_name" value="<?=$dealer_name?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('item_return_ajax.php', 'po',this.value+'#$#<?=$dealer_id?>',document.getElementById('warehouse_id').value);"/></td>

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

$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.oi_no='.$oi_no;

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

</form>

<form action="select_dealer_direct_sales.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

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