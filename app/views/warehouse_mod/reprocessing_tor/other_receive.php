<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='New Reprocess Receive';

$page_for = 'Reprocess Receive';
$tr_type="Show";


/*if($_SESSION['user']['depot']=='51'){ 

do_calander('#or_date','-90','0'); 

} else {

do_calander('#or_date','-10','0');

}

do_calander('#quotation_date');*/





$din = find_a_field('menu_warehouse','reprocess_receive','id="'.$_SESSION['user']['group'].'"');

if($din>0){$din=$din;}else{$din=60;}

//do_calander('#or_date','-"'.$din.'"','0');

do_calander('#or_date','-365','0');



$table_master='warehouse_other_receive';

$table_details='warehouse_other_receive_detail';

$unique='or_no';





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
		$tr_type="Initiate";

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';
		$tr_type="Add";
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
		$tr_type="Complete";

}



if($_GET['del']>0)

{

		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		

		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";

		db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';
		$tr_type="Remove";
		

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

		

		$cc_code = find_a_field_sql('select w.cc_code from  warehouse w where  w.warehouse_id='.$_SESSION['user']['depot']);

		

		$sql = "select * from warehouse_other_receive_detail where or_no =".$$unique;

		$query = db_query($sql);

		while($data = mysqli_fetch_object($query))

		{

		journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->or_date,$data->qty,0,$page_for,$data->id,$data->rate,'',$$unique);

		$amount = $amount + ($data->qty*$data->rate);
		
		$itemSub=find_a_field('item_info','sub_group_id','item_id="'.$data->item_id.'"');
		
		$iledger_id=find_a_field('item_sub_group','ledger_id_2','sub_group_id="'.$itemSub.'"');

		}

		$oi = find_all_field('warehouse_other_receive','issued_to','or_no='.$$unique);

		$config = find_all_field('config_group_class','issued_to','group_for='.$_SESSION['user']['group']);



		$issued_to = $oi->vendor_name;

		$val = 'rp_'.$issued_to;

		$vendor_ledger = $config->{$val};

		

		//if($oi->vendor_name=='' || $oi->vendor_name==0){ 

			//$vendor_ledger= find_a_field('warehouse','reprocess_id','warehouse_id="'.$_SESSION['user']['depot'].'"');

		//}

		

		$jv=next_journal_sec_voucher_id('','Reprocess Receive');

		//$sales_ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);

		$vendor_ledger = find_a_field('config_group_class','re_process','group_for="'.$_SESSION['user']['group'].'"');


		$sales_ledger1 = $iledger_id;

		

		auto_insert_process_receive_secoundary($jv,date("Y-m-d"),$vendor_ledger,$sales_ledger1,$$unique,$amount,$$unique,$oi->requisition_from,$cc_code);
		

$tr_from="Reprocess Receive";

$tr_no=$$unique;

$tr_id=$data->id;

$tr_type="Add";			

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

		$xid = $crud->insert();
		$tr_type="Add";

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



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

$depot_type = find_a_field('warehouse','use_type','warehouse_id="'.$_SESSION['user']['depot'].'"');



//auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','product_nature in ("Salable","Both")','item_id');

auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','product_nature in ("Salable","Both") and item_id>0','item_id');

$tr_from="Warehouse";
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
		div.form-container_large form fieldset {
			margin: 0px !important;
			padding: 0px !important;
			border: none !important;
			margin-bottom: 0px !important;
			padding-bottom: 0px !important;
		}
	</style>




	<div class="form-container_large">
		<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
			<div class="container-fluid bg-form-titel">
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">

							<fieldset>

								<? $field='or_no';?>

								<div class="form-group row m-0 pb-1">
									<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">RR  No : </label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
										<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

									</div>
								</div>


								<? $field='or_date'; if($or_date=='') $or_date =date(''); ?>


								<div class="form-group row m-0 pb-1">
									<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">RR Date :</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
										<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required autocomplete="off"/>
									</div>
								</div>


								<? $field='requisition_from';?>

								<div class="form-group row m-0 pb-1">
									<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Serial No :</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
										<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

									</div>
								</div>


								<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>
								<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>

							</fieldset>


						</div>



					</div>


					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
						<div class="container n-form2">
							<fieldset>

								<? $field='or_subject';?>


								<div class="form-group row m-0 pb-1">
									<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note :</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
										<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

									</div>
								</div>


								<? $field='vendor_name'; ?>

								<div class="form-group row m-0 pb-1">
									<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive From :</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
										<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
									</div>
								</div>



								<? $field='approved_by';?>

								<div class="form-group row m-0 pb-1">
									<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Approved By : </label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
										<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

									</div>
								</div>

							</fieldset>

						</div>

					</div>

				</div>

				<div class="n-form-btn-class">
					<input name="new" type="submit" class="btn1 btn1-bg-submit" value="<?=$btn_name?>"/>
				</div>
			</div>

			<!--return Table design start-->
<!--			<div class="container-fluid pt-5 p-0 ">-->
<!---->
<!--			</div>-->

		</form>




		<? if($_SESSION[$unique]>0){?>

		<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
			<!--Table input one design-->
			<div class="container-fluid pt-5 p-0">
				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>Item Name</th>
						<th>Unit</th>
						<th>Price</th>
						<th>Qty</th>
						<th>Amount</th>
						<th>Action</th>
					</tr>

					</thead>

					<tbody class="tbody1">

					<tr>

						<td align="center">
							<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
							<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
							<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
							<input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>
							<input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>
							<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" required onblur="getData2('other_receive_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/>

						</td>
						<td colspan="2" align="center">
								<span id="po">
									<input name="unit" type="text" class="input3" id="unit" readonly="readonly"/>
									<input name="price" type="text" class="input3" id="price" readonly="readonly"/>
								</span>
						</td>
						<td align="center"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" onchange="count()" required/></td>
						<td align="center"><input name="amount" type="text" class="input3" id="amount" readonly="readonly" required/></td>
						<td><input name="add" type="submit" id="add" class="btn1 btn1-bg-submit" value="ADD"></td>

					</tr>


					</tbody>
				</table>





			</div>




			<!--Data multi Table design start-->
			<div class="container-fluid pt-5 p-0 ">


				<div class="tabledesign2 border-0">

					<?

					$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_receive_detail a,item_info b where b.item_id=a.item_id and a.or_no='.$or_no;

					echo link_report_add_del_auto($res,'',6);

					?>

				</div>

			</div>
		</form>



		<!--button design start-->
		<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
			<div class="container-fluid p-0 ">
				<div class="n-form-btn-class">
					<input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD OR">
				</div>

			</div>
		</form>
		<? }?>
	</div>










<?/*>

	<br>
<br>
<br>
<br>
<br>
<br>
<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top">
		<fieldset>

    <? $field='or_no';?>

      <div>

        <label for="<?=$field?>">RR  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      </div>

    <? $field='or_date'; if($or_date=='') $or_date =date(''); ?>

      <div>

        <label for="<?=$field?>">RR Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required autocomplete="off"/>

      </div>

    <? $field='requisition_from';?>

      <div>

        <label for="<?=$field?>">Serial No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>



        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>



        <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>

    </fieldset>

	</td>

    <td>

			<fieldset>

			

    <? $field='or_subject';?>

      <div>

        <label for="<?=$field?>">Note :</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>

      <div></div>

      <? $field='vendor_name'; ?>

      <div>
	   <? $field='vendor_name';?>

        <label for="<?=$field?>">Receive From :</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>

      <div>

        <? $field='approved_by';?>

<div>

          <label for="<?=$field?>">Approved By :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

        </div>

      </div>

			</fieldset>
	</td>

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

                        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Price</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Amount</strong></td>

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

<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('other_receive_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>

<td colspan="2" align="center" bgcolor="#CCCCCC">

<span id="po">



<input name="unit" type="text" class="input3" id="unit" style="width:50px;" readonly="readonly"/>

<input name="price" type="text" class="input3" id="price" style="width:50px;"  readonly="readonly"/>

</span></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:60px;" onchange="count()" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:90px;" readonly="readonly" required/></td>

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

      <td align="center">&nbsp;</td>

      <td align="center">



      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD OR" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />



      </td>

    </tr>

  </table>

</form>

<? }?>

</div>
	<*/?>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>