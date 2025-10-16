<?php

require_once "../../../assets/template/layout.top.php";



$title='New Damage Issue';

$page = "damage_issue.php";

$ajax_page = "damage_issue_ajax.php";

$page_for = 'Damage Issue';

//do_calander('#oi_date','-10','0');

do_calander('#oi_date');

$table_master='warehouse_other_issue';

$table_details='warehouse_other_issue_detail';

$unique='oi_no';





if(isset($_POST['new']))

{

		$crud   = new crud($table_master);



		if(!isset($_SESSION[$unique])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;

		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';

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

		$_POST['entry_at']=date('Y-m-d H:i:s');

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

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$xid = $crud->insert();

		journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update DI Information'; else $btn_name='Initiate DI Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

$depot_type = find_a_field('warehouse','use_type','warehouse_id="'.$_SESSION['user']['depot'].'"');

//if($depot_type =='SD')

auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','product_nature="Salable"','item_id');

//else

//auto_complete_from_db('item_info','finish_goods_code','concat(item_name,"#>",item_id)','1','item_id');

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

  <div class="row ">
    
	
	     <div class="col-md-3 form-group">
            <label for="do_no" >Issue No: </label>
            <input   name="do_no" type="text" class="form-control" id="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.         $unique_master.')','1')+1);?>" readonly/>
          </div>
		  
		  <div class="col-md-3 form-group">
            <label for="dealer_code">Issue Date: </label>
            <select  id="dealer_code" class="form-control" name="dealer_code" readonly="readonly">
              <option value="<?=$dealer->dealer_code;?>">
              <?=$dealer->dealer_code.'-'.$dealer->dealer_name_e;?>
              </option>
            </select>
          </div>
		  
		  
		 <div class="col-md-3 form-group">
            <label for="wo_detail2"> Requisition From : </label>
            <input   name="wo_detail2" class="form-control"  type="text" id="wo_detail2" value="<?=$dealer->area_name?>" readonly/>
          </div>
		  
		  
		   <div class="col-md-3 form-group">
            <label for="wo_detail">Note: </label>
            <input   name="wo_detail" class="form-control"  type="text" id="wo_detail" value="<?=$dealer->zone_name?>" readonly/>
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
            <label for="wo_detail">Issue  To: </label>
            <input  name="wo_detail" class="form-control"  type="text" id="wo_detail" value="<?=$dealer->region_name?>" readonly/>
          </div>
		  
		  
          <div class="col-md-3 form-group">
            <label for="depot_id">Approved by : </label>
            <select  id="depot_id" name="depot_id" class="form-control"  readonly="readonly">
              <option value="<?=$dealer->depot;?>">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
              </option>
            </select>
            <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
          </div>
		
	  
   </div>

  <tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:40%;">

      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />

    </div></td>

    </tr>

</table>

</form>

<? if($_SESSION[$unique]>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td align="center" width="30%" bgcolor="#0099FF"><strong>Item Name</strong></td>

                        <td align="center" width="11%" bgcolor="#0099FF"><strong>Stock</strong></td>

                        <td align="center" width="11%" bgcolor="#0099FF"><strong>Unit</strong></td>

                        <td align="center" width="11%" bgcolor="#0099FF"><strong>Price</strong></td>

                        <td align="center" width="11%" bgcolor="#0099FF"><strong>Qty</strong></td>

                        <td align="center" width="11%" bgcolor="#0099FF"><strong>Amount</strong></td>

                          <td  rowspan="2" width="11%" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       

						  </div>				        </td>

      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

  <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>

  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="oi_date" type="hidden" id="oi_date" value="<?=$oi_date?>"/>

<input  name="issued_to" type="hidden" id="issued_to" value="<?=$issued_to?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:98%;" required onblur="getData2('<?=$ajax_page?>', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>

<td colspan="3" align="center" bgcolor="#CCCCCC">

<span id="po">

<table style="width:100%;" border="1">
	 <tr>
<td width="33%"><input name="stk" type="text" class="input3" id="stk" style="width:98%;" readonly="readonly"/></td>

<td width="33%"><input name="unit" type="text" class="input3" id="unit" style="width:98%;" readonly="readonly"/></td>

<td width="33%"><input name="price" type="text" class="input3" id="price" style="width:98%;"  readonly="readonly"/></td>
</tr></table>

</span></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:98%;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:98%;" readonly="readonly" required/></td>

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

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">&nbsp;</td>
	  
	  
	  

      <td align="center">



      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD DI" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#090" />



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