<?php





require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Import Receive';



$page_for = 'Import';


do_calander('#or_date');

do_calander('#quotation_date');
do_calander('#mfg_date');
do_calander('#expire_date');

if($_REQUEST['clear']>0){
unset($_SESSION['or_no3']);

header('location:import_raw.php');
}
if($_GET['or_no']>0){
$_SESSION['or_no3'] = $_GET['or_no'];
}


$table_master='warehouse_other_receive';

$table_details='warehouse_other_receive_detail';

$unique='or_no';

if(isset($_POST['new']))

{

		$crud   = new crud($table_master);



		if(!isset($_SESSION['or_no3'])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$$unique=$_SESSION['or_no3']=$crud->insert();

		unset($$unique);

		$type=1;

		$msg=$title.'  No Created. (No :-'.$_SESSION['or_no3'].')';

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}



$$unique=$_SESSION['or_no3'];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		$crud   = new crud($table_details);

		$condition=$unique."=".$$unique;		

		$crud->delete_all($condition);

		unset($$unique);

		unset($_SESSION['or_no3']);

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

		$_POST['status']='CHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);
		

		
		$jv_no=next_journal_sec_voucher_id();
		$jv_date = strtotime($_POST['or_date']);
		$entry_by = $_SESSION['user']['id'];
		$entry_at = date('Y-m-d h:i:s');
		$labour_ledger = '2063001900000000';
		$transport_ledger = '2066018100000000';
		$cc_code = '134';
		$tr_no = $$unique;
		$narration = 'Import Receive. IR No#'.$$unique;
		$tr_from = 'ImportReceive';
		$vendor_ledger = find_a_field('warehouse_other_receive','vendor_ledger','or_no="'.$$unique.'"');
	    $jsql = 'select d.*,m.vendor_ledger from warehouse_other_receive_detail d,warehouse_other_receive m where d.or_no=m.or_no and m.or_no="'.$$unique.'"';
		$jquery = db_query($jsql);
		while($jdata = mysqli_fetch_object($jquery)){
		$vendor_amount += $jdata->material_price;
		$labour_cost += $jdata->labour_cost;
		$transport_cost += $jdata->transport_cost;
		
		$item_ledger = find_a_field('item_info','acc_ledger','item_id="'.$jdata->item_id.'"');
		
		 }
		 
		
		 
		unset($$unique);

		unset($_SESSION['or_no3']);

		$type=1;

		$msg='Successfully Forwarded.';

}



if(isset($_POST['add'])&&($_POST[$unique]>0))

{

		$crud   = new crud($table_details);

		$iii	=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[1];
		
		$lot_no = $_POST['or_no'];

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$xid = $crud->insert();

		
		 

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

				foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0){ $btn_name='Update IR Information';} else{ $btn_name='Initiate IR Information';}

if($_SESSION['or_no3']<1){
$$unique=db_last_insert_id($table_master,$unique);
}





auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item_id');

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
var dollar_rate = ((document.getElementById('dollar_rate').value)*1);
var lc_price_dollar = ((document.getElementById('lc_value_dollar').value)*1);
var lc_price_bdt = lc_price_dollar*dollar_rate;
document.getElementById('lc_price').value = lc_price_bdt.toFixed(2);	

var lc_price = ((document.getElementById('lc_price').value)*1);
var purchase_price_dollar = ((document.getElementById('purchase_price_dollar').value)*1);

var actual_price = ((document.getElementById('actual_price').value)*1);
var total_pp = ((document.getElementById('total_pp').value)*1);
var freight_cost = ((document.getElementById('freight_cost').value)*1);
var lc_cost = ((document.getElementById('lc_cost').value)*1);
var bag_cost = ((document.getElementById('bag_cost').value)*1);
var cnf_cost = ((document.getElementById('cnf_cost').value)*1);
var rate = ((document.getElementById('rate').value)*1);
var qty = ((document.getElementById('qty').value)*1);
var total_cost = +total_pp+freight_cost+lc_cost+cnf_cost+bag_cost;
var total_purchase_price = +lc_price+actual_price;


var total_price = qty*rate;
document.getElementById('rate').value = total_cost.toFixed(2);	
document.getElementById('amount').value = total_price.toFixed(2);
document.getElementById('total_pp').value = total_purchase_price.toFixed(2);


}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<div class="row">
		<div class="col-sm-10">
			<div class="row ">

    <? $field='or_no';?>

      <div class="col-md-3 form-group">

        <label for="<?=$field?>">Import Rcv  No: </label>

        <input  name="<?=$field?>" class="form-control" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>

      </div>
	  

<? $field='or_date';  ?>

      <div class="col-md-3 form-group">

        <label for="<?=$field?>">Import Rcv Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" class="form-control" value="<?=$$field?>" required/>

      </div>

    <? $field='or_subject';?>

      <div class="col-md-3 form-group">

        <label for="<?=$field?>">Note:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control"/>

      </div>

	   <? $field='vendor_id';?>

      <div class="col-md-3 form-group">

        <label for="<?=$field?>">Supplier:</label>

        <select  name="<?=$field?>" id="<?=$field?>" class="form-control" required>
		<option></option>
		<? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'1');?>
		
		
		</select>

      </div>



        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>

<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required/>

   
   
      

      <? $field='vendor_name'; ?>

     <!-- <div class="col-md-3 form-group">

        <label for="<?=$field?>">Received From :</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control"/>

      </div>-->

      <!--<div class="col-md-3 form-group">

        <? $field='approved_by';?>

<div>

          <label for="<?=$field?>">Approved By :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control"/>

        </div>

      </div>-->

			</fieldset>	</td>

  </tr>

  <tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">

      <input name="new" type="submit" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" class="form-control" />

    </div>
	

</form>

<? if($_SESSION['or_no3']>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<table   border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5; width:1250px;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>

                      <!--  <td align="center" bgcolor="#0099FF"><strong>Stock</strong></td>-->

                        <td align="center" bgcolor="#0099FF"><strong>Dollar Rate</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>LC Value($)</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>LC Price(BDT)</strong></td>
						
						<td align="center" bgcolor="#0099FF"><strong>Purchase Price($)</strong></td>
						
						<td align="center" bgcolor="#0099FF"><strong>Actual Price(BDT)</strong></td>
						
						<td align="center" bgcolor="#0099FF"><strong>Total PP(BDT)</strong></td>
						
						<td align="center" bgcolor="#0099FF"><strong>Freight Cost(BDT)</strong></td>
						
						<td align="center" bgcolor="#0099FF"><strong>LC Cost(BDT)</strong></td>
						
						<td align="center" bgcolor="#0099FF"><strong>Bag Cost(BDT)</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>C & F Cost(BDT)</strong></td>
						
						<td align="center" bgcolor="#0099FF"><strong>In total(BDT)</strong></td>
						
						<td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
						
						<td align="center" bgcolor="#0099FF"><strong>Total(BDT)</strong></td>

                          <td  rowspan="2" align="center" bgcolor="#FF0000">

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

<input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>

<input  name="vendor_ledger" type="hidden" id="vendor_ledger" value="<?=$vendor_ledger?>"/>

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:200px;" required onblur="getData2('import_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>

<!--<td colspan="3" align="center" bgcolor="#CCCCCC">

<span id="po">
<table width="100%" border="1">
<tr>
<td width="33%"><input name="stk" type="text" class="input3" id="stk" style="width:98%;" readonly="readonly"/></td>

<td width="33%"><input name="unit" type="text" class="input3" id="unit" style="width:98%;" readonly="readonly"/></td>

<td width="33%"><input name="price" type="text" class="input3" id="price" style="width:98%;"  readonly="readonly"/></td>
</tr>

</table></span></td>-->
<td align="center" bgcolor="#CCCCCC"><input name="dollar_rate" type="text" class="input3" id="dollar_rate"  maxlength="100" style="width:60px;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="lc_value_dollar" type="text" class="input3" id="lc_value_dollar"  maxlength="100" style="width:70px;" onchange="count()" required/></td>


<td align="center" bgcolor="#CCCCCC"><input name="lc_price" type="text" class="input3" id="lc_price"  maxlength="100" style="width:80px;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="purchase_price_dollar" type="text" class="input3" id="purchase_price_dollar"  maxlength="100" style="width:70px;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="actual_price" type="text" class="input3" id="actual_price"  maxlength="100" style="width:80px;" onchange="count()"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="total_pp" type="text" class="input3" id="total_pp" onchange="count()"  maxlength="100" style="width:100px;" readonly="readonly"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="freight_cost" type="text" class="input3" id="freight_cost"  maxlength="100" style="width:95%;" onchange="count()" /></td>

<td align="center" bgcolor="#CCCCCC"><input name="lc_cost" type="text" class="input3" id="lc_cost"  maxlength="100" style="width:95%;" onchange="count()"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="bag_cost" type="text" class="input3" id="bag_cost"  maxlength="100" style="width:95%;" onchange="count()"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="cnf_cost" type="text" class="input3" id="cnf_cost" style="width:95%;" onchange="count()"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="rate" type="text" class="input3" id="rate" style="width:100px;" onchange="count()" readonly="readonly" /></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty" style="width:80px;" onchange="count()"  /></td>

<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:100px;" readonly="readonly" /></td>

      </tr>

    </table>

					  <br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

$res='select a.id,b.item_name,a.qty ,a.unit_name,a.dollar_rate,a.lc_value_dollar as lc_value_$,a.lc_price as lc_price_bdt,a.purchase_price_dollar as purchase_price_$,a.actual_price,a.total_pp,a.freight_cost,a.lc_cost,a.bag_cost,a.cnf_cost,a.rate as unit_price,a.amount,"x" from warehouse_other_receive_detail a,item_info b where b.item_id=a.item_id and a.or_no='.$or_no;

echo link_report($res,'',4,6);

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



      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD IR" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />



      </td>

    </tr>

  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?
$tr_from="Purchase";
require_once SERVER_CORE."routing/layout.bottom.php";

?>