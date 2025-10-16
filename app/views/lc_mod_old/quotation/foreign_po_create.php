<?php




 
 
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$title='New PO Create';

$tr_type="Show";

do_calander('#po_date');
 



$table_master='import_purchase_master';

$table_details='import_purchase_details';

$unique='po_no';

$checked_values = isset($_POST['myChec']) ? $_POST['myChec'] : [];

    if (!empty($checked_values)) {
         $quotation_ids=implode(",", array_map('htmlspecialchars', $checked_values));
    }
$quotation_no = 	isset($_POST['quotation_no']) ? $_POST['quotation_no'] : '' ;



 $vendor_get=find_a_field('import_quotation_details','vendor_id','id in('.$quotation_ids.') group by vendor_id');
 
if($_GET['mhafuz']>0){

unset($_SESSION[$unique]);
}



if(isset($_POST['new']))

{

 
		$crud   = new crud($table_master);



		if(!isset($_SESSION[$unique])) {

		$_POST['status']='MANUAL';

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='PO No Created. (PO No : '.$_SESSION[$unique].')';
		$tr_type="Initiate";

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';
		$tr_type="Initiate";

		}
header("Location: foreign_po_create.php?po_no=".$_SESSION[$unique]);
}


if($_GET['po_no']>0){
  $$unique=$_SESSION[$unique]=$_GET['po_no'];
}
else{
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
		$tr_type="Delete";

}



if($_GET['del']>0)

{

		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';
		$tr_type="Delete";

}

if(isset($_POST['confirmm']))

{



 $quotation_ids=$_POST['quotation_ids'];
 $po_no=$_POST['po_no'];
 $po_date=$_POST['po_date'];
 $quotation_no=$_POST['quotation_no'];
 $vendor_id=$_POST['vendor_id'];
  $warehouse_id=$_POST['warehouse_id'];
   $currency_type=$_POST['currency_type'];
     $entry_by=$_SESSION['user']['id'];
	   $entry_at=date('Y-m-d h:i:sa');
 
	   $res='select  a.*,b.item_name as item_name,b.unit_name 
						
						from import_quotation_details a,item_info b 
						
						where b.item_id=a.item_id and a.id in('.$quotation_ids.')';

                        $qry = db_query($res);
						$sum_qty = 0;
						while($data=mysqli_fetch_object($qry)){
						if($_POST['qty_'.$data->id]>0){
						
						$qty=$_POST['qty_'.$data->id];
						$rate=$_POST['rate_'.$data->id];
						$amount=$_POST['amount_'.$data->id];
						$item_id=$_POST['item_id_'.$data->id];
						$unit_name=$_POST['unit_name_'.$data->id];
						
						$inssql='insert into import_purchase_details(po_no,po_date,quotation_no,vendor_id,item_id,unit_name,rate,qty,amount,warehouse_id,currency_type,quotation_ids,entry_by,entry_at)values("'.$po_no.'","'.$po_date.'","'.$quotation_no.'","'.$vendor_id.'","'.$item_id.'","'.$unit_name.'","'.$rate.'","'.$qty.'","'.$amount.'","'.$warehouse_id.'","'.$currency_type.'","'.$data->id.'","'.$entry_by.'","'.$entry_at.'")';
					db_query($inssql);	
					header("Location: qou_to_po.php");
						}
						
						}



		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');
		$tr_type="Complete";


 

$_POST['status']='CHECKED'; 
 

  $up_sql='update import_quotation_details set addi_status="PO_CREATED" WHERE id in('.$_POST['quotation_ids'].')';
db_query($up_sql);





		$crud   = new crud($table_master);

		$crud->update($unique);
		unset($_POST);
		unset($$unique);

		unset($_SESSION[$unique]);
		unset($req_status);

		$type=1;

		$msg='Successfully Forwarded for Approval.';
		
		header("Location: qou_to_po.php");

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
/*$exist_item=find_a_field('requisition_order','item_id','req_no="'.$_POST[$unique].'" and item_id="'.$_POST['item_id'].'"');
 if($exist_item==''){		}*/ //requarement was given after done. they change its also done AMI (NIbir)
		$crud->insert();

		$tr_type="Added Successfully";

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



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

// auto_complete_from_db('item_info','item_name','item_id','1','item_id');



//auto_complete_from_db('item_info','concat(item_name,"#>",item_description,"#>",item_id)','concat(item_name,"#>",item_description,"#>",item_id)', '1 and item_group!=100000000 order by item_id asc', 'item_id');







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









	<div class="form-container_large">

		<form action="foreign_po_create.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

			<div class="container-fluid bg-form-titel">

				<div class="row">

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="container n-form2">
						<?php 
						if($_GET['po_no']>0){
						?>

							<div class="form-group row m-0 pb-1"  >

								<? $field='po_no';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO No :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<? echo $$field;?>" readonly="readonly"/>

								</div>

							</div>
<?php } ?>


							<div class="form-group row m-0 pb-1">

								<? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO Date :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

									<input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

								</div>

							</div>
							

							
							<div class="form-group row m-0 pb-1">

								<? $field='vendor_id';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

							
									<select name="<?=$field?>" id="<?=$field?>">
										<option value="<?php if($vendor_id>0){echo $vendor_id;} else { echo $vendor_get;}?>">
										<?php if($vendor_id>0){echo find_a_field('vendor_foreign','vendor_name','vendor_id="'.$vendor_id.'"');} else { echo find_a_field('vendor_foreign','vendor_name','vendor_id="'.$vendor_get.'"');}?>
										</option>
									</select>



								</div>

							</div>
							
							
							
							
							
							 
							<div class="form-group row m-0 pb-1">

								<? $field='quotation_no';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quotation No :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>



								</div>

							</div>
							
							
							
							
							
							
							
						</div>







					</div>


<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="container n-form2">
						
						<div class="form-group row m-0 pb-1">

								<? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

	
									
									
								<select name="warehouse_id"  id="warehouse_id"  tabindex="7" required="required">

								<option></option>

							  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1 and group_for='.$_SESSION['user']['group'].'') ;?>

					   </select>


								</div>

							</div>
							<div class="form-group row m-0 pb-1">

								<? $field='currency_type'; $table='currency_type';$get_field='id';$show_field='currency_type';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Currency Type :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								<select name="currency_type"  id="currency_type"  tabindex="7" required="required">
								<option></option>
							  <? foreign_relation('currency_type','id','currency_type',$currency_type,'1') ;?>
					   			</select>
								</div>
							</div>
							
							<div class="form-group row m-0 pb-1">

								<? $field='po_note';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Additional Note :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>



								</div>

							</div>
							
							
							<div class="form-group row m-0 pb-1">

								<? $field='quotation_ids';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quotation Id :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>



								</div>

							</div>
							
							
							
						
						</div>
						</div>


					 



				</div>



				<div class="n-form-btn-class">

					<input name="new" type="submit" class="btn1 btn1-bg-submit" value="<?=$btn_name?>" />

				</div>

			</div>



			<!--return Table design start-->

			<div class="container-fluid pt-5 p-0 ">

				<?

				$sql = 'select a.*,u.fname from approver_notes a, user_activity_management u where a.entry_by=u.user_id and master_id="'.$$unique.'" and type="MR"';

				$row_check = mysqli_num_rows(db_query($sql));

				if($row_check>0){

					?>

				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

					<tr class="bgc-info">

						<th>Returned By</th>

						<th>Returned At</th>

						<th>Remarks</th>

					</tr>

					</thead>



					<tbody class="tbody1">

					<?

					$qry = db_query($sql);

					while($return_note=mysqli_fetch_object($qry)){

					?>



					<tr>

						<td><?=$return_note->fname?></td>

						<td><?=$return_note->entry_at?></td>

						<td><?=$return_note->note?></td>



					</tr>

					<? } ?>

					</tbody>

				</table>

				<? } ?>



			</div>



		</form>









		<? if($_SESSION[$unique]>0){?>



		<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

			<!--Table input one design-->

 


			<!--Data multi Table design start-->

			<div class="container-fluid pt-5 p-0 ">
 



				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

					<tr class="bgc-info">

						<th width="5%">SL</th>

						<th width="15%">Item Name</th>
						
						 <th width="15%">Unit Name</th>


						<th width="15%">Req Qty</th>

					

						<th width="10%">Price</th>
							<th width="10%">PO Qty</th>
						<th width="10%">Amount</th>
 

					</tr>

					</thead>



					<tbody class="tbody1">
									<input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

							<input  name="warehouse_id_get" type="hidden" id="warehouse_id_get" value="<?php echo $warehouse_id."/#/".$quotation_ids; ?>"/>
							<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?php echo $warehouse_id; ?>"/>
							
							<input  name="currency_type" type="hidden" id="currency_type" value="<?php echo $currency_type; ?>"/>
							<input  name="quotation_ids" type="hidden" id="quotation_ids" value="<?=$quotation_ids?>"/>
								<input  name="quotation_no" type="hidden" id="quotation_no" value="<?=$quotation_no?>"/>
 
							<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
						<?
						
						//////vendor id/////////
				 
							$vsql='select * from  vendor_foreign where 1';
							$vquery=db_query($vsql);
							while($vrow=mysqli_fetch_object($vquery)){ 
							$vendor_name_get[$vrow->vendor_id]=$vrow->vendor_name;
							}
							
						

						$s=0;

						   $res='select  a.*,b.item_name as item_name,b.unit_name,"x" 
						
						from import_quotation_details a,item_info b 
						
						where b.item_id=a.item_id and a.id in('.$quotation_ids.')';

                        $qry = db_query($res);
						$sum_qty = 0;
						while($data=mysqli_fetch_object($qry)){

						?>



					<tr>

						<td width="5%"><?=++$s?></td>

						<td style="text-align:left" width="15%"><?=$data->item_name?></td>
					 

			 	<td width="10%"><?=$data->unit_name?></td>

 

<script>
	function count(id){
	var qty=document.getElementById('qty_'+id).value;
	var rate=document.getElementById('rate_'+id).value;
	document.getElementById('amount_'+id).value=(qty*rate);
	}
</script>

						<td width="15%"><?=$data->req_qty?></td>

					

				 
								<td width="10%"><input type="text" name="rate_<?php echo $data->id;?>" id="rate_<?php echo $data->id;?>" value="<?=$data->rate; ?>" > </td>
									<td width="10%"><input type="text" name="qty_<?php echo $data->id;?>" id="qty_<?php echo $data->id;?>" onkeyup="count(<?php echo $data->id;?>)" value="<?=$data->qty; ?>" /></td>
									<input type="hidden" name="item_id_<?php echo $data->id;?>" id="item_id_<?php echo $data->id;?>" value="<?=$data->item_id; ?>" />
									<input type="hidden" name="unit_name_<?php echo $data->id;?>" id="unit_name_<?php echo $data->id;?>" value="<?=$data->unit_name; ?>" />
						<td width="10%"><input type="text" name="amount_<?php echo $data->id;?>" id="amount_<?php echo $data->id;?>" value="<?=$data->amount; ?>" /> </td>

				 



					</tr>

                    <? 
				 
					} ?>

					</tbody>

				</table>



			</div>

 

			<div class="container-fluid p-0 ">



				<div class="n-form-btn-class">

					<input name="delete" type="submit" class="btn1 btn1-bg-cancel" value="DELETE AND CANCEL PO" />
				 
						<input  name="quotation_ids" type="hidden" id="quotation_ids" value="<?=$quotation_ids?>"/>
						<input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD PO" />
			 
				</div>



			</div>

		</form>



		<? }?>

	</div>

	<script>$("#codz").validate();$("#cloud").validate();</script>

















<br>

<br>

<br>

<br>









 




<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>