<?php




 
 
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$title='New Quotation Create';

$tr_type="Show";

do_calander('#quotation_date');
 



$table_master='import_quotation_master';

$table_details='import_quotation_details';

$unique='quotation_no';

$checked_values = isset($_POST['myChec']) ? $_POST['myChec'] : [];

    if (!empty($checked_values)) {
         $req_ids=implode(",", array_map('htmlspecialchars', $checked_values));
    }
$req_no = 	isset($_POST['req_no']) ? $_POST['req_no'] : '' ;



 $req_status=find_a_field('import_quotation_master','status','req_no="'.$_SESSION[$unique].'" and status!=""');

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

		$msg='Requisition No Created. (Quotation No : '.$_SESSION[$unique].')';
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
header("Location: quotation_create.php?quotation_no=".$_SESSION[$unique]);
}


if($_GET['quotation_no']>0){
  $$unique=$_SESSION[$unique]=$_GET['quotation_no'];
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



		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');
		$tr_type="Complete";


 

$_POST['status']='CHECKED'; 
 

  $up_sql='update requisition_order set addi_status="QUOTATION_CREATED" WHERE id in('.$_POST['req_ids'].')';
db_query($up_sql);





		$crud   = new crud($table_master);

		$crud->update($unique);
		unset($_POST);
		unset($$unique);

		unset($_SESSION[$unique]);
		unset($req_status);

		$type=1;

		$msg='Successfully Forwarded for Approval.';
		
		header("Location: new_quo_entry.php");

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

		<form action="quotation_create.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

			<div class="container-fluid bg-form-titel">

				<div class="row">

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="container n-form2">
						<?php 
						if($_GET['quotation_no']>0){
						?>

							<div class="form-group row m-0 pb-1"  >

								<? $field='quotation_no';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quotation No :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<? echo $$field;?>" readonly="readonly"/>

								</div>

							</div>
<?php } ?>


							<div class="form-group row m-0 pb-1">

								<? $field='quotation_date'; if($quotation_date=='') $quotation_date =date('Y-m-d');?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Quotation Date :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

									<input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

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

								<? $field='req_no';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req No :</label>

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

								<? $field='quotation_note';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Additional Note :</label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

									<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>



								</div>

							</div>
							
							
							<div class="form-group row m-0 pb-1">

								<? $field='req_ids';?>

								<label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req Id :</label>

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

			<div class="container-fluid pt-5 p-0 ">







				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

					<tr class="bgc-info">

						

						<th>Item Name</th>
						
				 

						

						<th>Req Qty</th>

			

						<th>Unit</th>

	<th>Vendor</th>

						<th>Rate</th>

						<th>Remraks</th>

						<th>Action</th>

					</tr>

					</thead>



					<tbody class="tbody1">





					<tr>

						

						



						<td>

							<input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

							<input  name="warehouse_id_get" type="hidden" id="warehouse_id_get" value="<?php echo $warehouse_id."/#/".$req_ids; ?>"/>
							<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?php echo $warehouse_id; ?>"/>
							
							<input  name="currency_type" type="hidden" id="currency_type" value="<?php echo $currency_type; ?>"/>
							<input  name="req_ids" type="hidden" id="req_ids" value="<?=$req_ids?>"/>
								<input  name="req_no" type="hidden" id="req_no" value="<?=$req_no?>"/>

							<input  name="quotation_date" type="hidden" id="quotation_date" value="<?=$quotation_date?>"/>
 
							<select name="item_id" id="item_id" onchange="getData2('mr_ajax.php', 'mr', this.value, document.getElementById('warehouse_id_get').value);">
								<option value=""></option>
							<?php 
							$sql='select i.item_id,i.item_name,i.item_description,r.item_id,sum(r.qty) as tot_req_qty from requisition_order r,item_info i where r.id in('.$req_ids.') and r.item_id=i.item_id group by r.item_id';
							$query=db_query($sql);
							while($row=mysqli_fetch_object($query)){
							?>	
								<option value="<?php echo $row->item_name,"#>".$row->item_description."#>".$row->item_id;?>"><?php echo $row->item_name;?></option>
								<?php } ?>
								
							</select>
 
						</td>
					 

						<td colspan="2">

							<div align="right">

								  <span id="mr">

						<table style="width:100%;" border="1">

							<tr>



								<td width="33%"><input name="req_qty" type="text"  id="req_qty" class="form-control" onfocus="focuson('req_qty')" /></td>



								



								<td width="23%"><input name="unit_name" type="text" id="unit_name"  maxlength="100" class="form-control" onfocus="focuson('qty')" /></td>

							</tr>

						</table>

						</span>

							</div>

						</td>

<td> 
			<select name="vendor_id" id="vendor_id"  >
								<option value=""></option>
							<?php 
							$sql='select * from  vendor_foreign where 1';
							$query=db_query($sql);
							while($row=mysqli_fetch_object($query)){
							?>	
								<option value="<?php echo $row->vendor_id;?>"><?php echo $row->vendor_name;?></option>
								<?php } ?>
								
							</select>

</td>

						<td><input name="rate" type="text" class="input3" id="rate" required /></td>



						<td>

							<input name="remarks" id="remarks" type="text" />

						</td>

						<td><input name="add" type="submit" id="add" class="btn1 btn1-bg-submit" value="ADD" /></td>



					</tr>













					</tbody>

				</table>











			</div>









			<!--Data multi Table design start-->

			<div class="container-fluid pt-5 p-0 ">

				<?

				$res='select a.id,b.item_name as item_name,a.specification,a.qoh as stock_qty,a.last_p_qty as last_pur_qty,a.last_p_date as last_pur_date,a.qty,"x" 
				
				from requisition_order a,item_info b 
				
				where b.item_id=a.item_id and a.req_no='.$req_no;

				?>



				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

					<tr class="bgc-info">

						<th width="5%">SL</th>

						<th width="15%">Item Name</th>
						
						 <th width="15%">Unit Name</th>


						<th width="15%">Req Qty</th>

						<th width="10%">Vendor</th>

						<th width="10%">Price</th>
						<th width="10%">Remarks</th>

						<th width="5%">Action</th>

					</tr>

					</thead>



					<tbody class="tbody1">

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
						
						where b.item_id=a.item_id and a.quotation_no='.$quotation_no;

                        $qry = db_query($res);
						$sum_qty = 0;
						while($data=mysqli_fetch_object($qry)){

						?>



					<tr>

						<td width="5%"><?=++$s?></td>

						<td style="text-align:left" width="15%"><?=$data->item_name?></td>
					 

			 	<td width="10%"><?=$data->unit_name?></td>

 



						<td width="15%"><?=$data->req_qty?></td>

					

						<td width="10%"><?=$vendor_name_get[$data->vendor_id]; ?></td>
								<td width="10%"><?=$data->rate; ?></td>
						<td width="10%"><?=$data->remarks?></td>

						<td width="5%"><a href="?del=<?=$data->id?>"> <button type="button" class="btn2 btn1-bg-cancel"><i class="fa-solid fa-trash"></i></button> </a></td>



					</tr>

                    <? 
					$gr_tot_qty+=$data->req_qty;
					} ?>

					</tbody>

				</table>



			</div>

		</form>







		<!--button design start-->

		<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

			<div class="container-fluid p-0 ">



				<div class="n-form-btn-class">

					<input name="delete" type="submit" class="btn1 btn1-bg-cancel" value="DELETE AND CANCEL REQUSITION" />
					<? if($gr_tot_qty>0){ ?>
						<input  name="req_ids" type="hidden" id="req_ids" value="<?=$req_ids?>"/>
						<input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD REQUSITION" />
					<? } ?>
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