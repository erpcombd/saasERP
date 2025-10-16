<?php




 
 
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$title='Compettive Sourcing';

$tr_type="Show";

do_calander('#quotation_date');
 



$table_master='import_quotation_master';

$table_details='import_quotation_details';

$unique='quotation_no';

   $quotation_no = url_decode(str_replace(' ', '+', $_GET['quotation_no']));

if($_GET['mhafuz']>0){

unset($_SESSION[$unique]);
}


 


if($quotation_no>0){
  $$unique=$quotation_no;
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


 


if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update Requsition Information'; else $btn_name='Initiate Requsition Information';

if($quotation_no<1)

$$unique=db_last_insert_id($table_master,$unique);

 





$tr_from="Warehouse";

?>

 








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



				

			</div>



			<!--return Table design start-->

			 



		</form>


<script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }
	
 

	function update_value(order_no)

	{

var order_no=order_no; // Rent

var item_id=(document.getElementById('item_id_'+order_no).value);

 

var strURL="quotation_approval_ajax.php?order_no="+order_no+"&item_id="+item_id;

		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+order_no).style.display='inline';

						document.getElementById('divi_'+order_no).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}










</script>






		<? if($quotation_no>0){?>



		<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

			<!--Table input one design-->
 









			<!--Data multi Table design start-->

			<div class="container-fluid pt-5 p-0 ">

				<?

				$res='select a.*,i.unit_name,i.item_id,i.item_name
				
				from  import_quotation_details a,item_info i 
				
				where a.item_id=i.item_id and a.quotation_no='.$quotation_no;

				?>



				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

					<tr class="bgc-info">

						<th  >SL</th>

						<th  >Item Name</th>
						
						 <th  >Unit Name</th>


						<th  >Req Qty</th>

						<th  >Vendor</th>

						<th >Price</th>
						<th  >Remarks</th>

				 <th  >Approve</th>

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
							
									//////Same Item count in quotation/////////
				 
							$vsql='select count(id) as tot_count,item_id,quotation_no from  import_quotation_details where quotation_no="'.$quotation_no.'" group by item_id';
							$vquery=db_query($vsql);
							while($vrow=mysqli_fetch_object($vquery)){ 
							$same_item_count[$vrow->item_id]=$vrow->tot_count;
							}
						

			 

						 $res = 'SELECT a.*, b.item_name AS item_name, b.unit_name, "x" 
        FROM import_quotation_details a, item_info b 
        WHERE b.item_id = a.item_id AND a.quotation_no = ' . $quotation_no;

$qry = db_query($res);

// Store all data into array
$data_arr = [];
while ($row = mysqli_fetch_object($qry)) {
    $data_arr[] = $row;
}

$sum_qty = 0;
$gr_tot_qty = 0;
$cus_item_id = null;
$s = 0;
$total_rows = count($data_arr);

foreach ($data_arr as $i => $data) {
?>
    <tr>
        <td><?= ++$s ?></td>

        <?php if ($data->item_id != $cus_item_id): ?>
            <td rowspan="<?= $same_item_count[$data->item_id] ?>">
                <?= $data->item_name ?>
            </td>
        <?php endif; ?>

        <td><?= $data->unit_name ?></td>
        <td><?= $data->req_qty ?></td>
        <td><?= $vendor_name_get[$data->vendor_id]; ?></td>
        <td><?= $data->rate; ?></td>
        <td><?= $data->remarks ?></td>
		<input type="hidden" name="item_id_<?=$data->id?>" id="item_id_<?=$data->id?>" value="<?=$data->item_id?>" />
		<td >
	<? if($data->app_status=='APPROVED') {?>
	<center><b>Approved!</b></center>
	<? }else {?>
	<span id="divi_<?=$data->id?>">
	<input name="flag_<?=$data->id?>" type="hidden" id="flag_<?=$data->id?>" value="1" />

	<input type="button" name="Button" value="APPROVE"  onclick="update_value(<?=$data->id?>)" style="width:75px; font-size:10px; height:26px; background-color:#2ecc71; font-weight:700;"/>
    </span><? }?>	</td>
    </tr>

    <?php
    // Check if the next row has a different item_id
    $next_item_id = ($i + 1 < $total_rows) ? $data_arr[$i + 1]->item_id : null;

    if ($data->item_id != $next_item_id) {
    ?>
        <tr style="background-color:lightgreen!important; height:5px;">
            <td colspan="8">&nbsp;</td>
        </tr>
    <?php
    }

    $gr_tot_qty += $data->req_qty;
    $cus_item_id = $data->item_id;

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