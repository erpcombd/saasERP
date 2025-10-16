<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Asset Receive';

do_calander('#do_date');

do_calander('#date');

do_calander('#customer_po_date');

$now = date('Y-m-d H:s:i');


do_calander('#est_date');



$page = 'receive.php';

$table_master = 'fixed_asset_receive_master';

$unique_master = 'id';
	
if(isset($_POST['confirm'])){

$sql = 'select s.*,i.item_name from fixed_asset_issue_master s, item_info i where i.item_id=s.item_id and s.user_id="'.$_POST['user_id'].'" and s.status="ISSUED"';
$qry = db_query($sql);
while($data=mysqli_fetch_object($qry)){
if($_POST['receiveItem'.$data->id]=='checked'){

$user = '';
				 
$journalAll=find_all_field('asset_register','','asset_id="'.$data->asset_id.'" and item_id="'.$data->item_id.'"');
 
$rcv_update = 'insert into fixed_asset_receive_master set user_id="'.$_POST['user_id'].'", asset_id="'.$data->asset_id.'",item_id="'.$data->item_id.'",serial_no="'.$data->serial_no.'",department_name="'.$_POST['department_name'].'",mobile="'.$data->mobile.'",status="RECEIVED",type="'.$data->type.'",date="'.date('Y-m-d').'",entry_by="'.$_SESSION['user']['depot'].'",entry_at="'.date('Y-m-d H:i:s').'"';
db_query($rcv_update);
//$last_id = mysqli_insert_id();
journal_asset_item_control($data->item_id ,$_SESSION['user']['depot'],date('Y-m-d'),1,0,'InStock',$last_id,$journalAll->price,0,$last_id,$journalAll->price,0,0,$data->serial_no,$data->asset_id,$user);




db_query('update asset_register set item_status="inStock" where asset_id="'.$data->asset_id.'" and item_id="'.$data->item_id.'"');

db_query('update fixed_asset_issue_master set status="RECEIVED" where id='.$data->id);
$count++;
/*echo "<script>window.top.location='receive.php'</script>";*/
}
}
if($count>0){
echo '<div class="alert alert-success" role="alert">Successfully Received '.$count.' Item</div>';
}else{
echo '<div class="alert alert-danger" role="alert">Item Not Found!!</div>';
}

}	
	
?>



<script language="javascript">
	function count()

	{





		if (document.getElementById('unit_price').value != '') {



			var vat = ((document.getElementById('vat').value) * 1);



			var unit_price = ((document.getElementById('unit_price').value) * 1);



			var dist_unit = ((document.getElementById('dist_unit').value) * 1);



			var total_unit = (document.getElementById('total_unit').value) = dist_unit;







			var total_amt = (document.getElementById('total_amt').value) = total_unit * unit_price;





		}







	}
</script>


<style type="text/css">
	.onhover:focus {

		background-color: #66CBEA;



	}





	< !-- .style2 {

		color: #FFFFFF;

		font-weight: bold;

	}

	-->
</style>



<!--DO create 2 form with table-->

<div class="form-container_large">

<?=$type ?>

	<form action="<?= $page ?>" method="post" name="codz2" id="codz2">

		<!--        top form start hear-->

		<div class="container-fluid bg-form-titel">

			<div class="row">

				<!--left form-->

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="container n-form2">

						





<div class="form-group row m-0 pb-1">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Type</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

								<select name="type" id="type" onchange="getData2('get_info_ajax.php','typeList',this.value,this.value)" required >
								<option></option>
								<option value="User" <?=($_POST['type']=='User')?'selected':''?>>User</option>
								<option value="Department" <?=($_POST['type']=='Department')?'selected':''?>>Department</option>
								
								</select>

							</div>

						</div>

						



					</div>





				</div>



				<!--Right form-->

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="container n-form2">


						<div class="form-group row m-0 pb-1">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive From</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                    <span id="typeList">
									<? if($_POST['type'] == 'User'){?>
									<select id="user_id" name="user_id" class="form-control">
<option></option>
										<? foreign_relation('user_activity_management', 'user_id', 'fname', $_POST['user_id'], '1') ?>

									</select>
									<? }elseif($_POST['type'] == 'Department'){?>
									<select name="department_name" type="text" id="department_name" class="form-control" >
								<option></option>
								<? foreign_relation('fixed_asset_issue_master a, department d','d.DEPT_ID','d.DEPT_DESC',$_POST['department_name'],'a.department_name=d.DEPT_ID  and a.department_name!="" group by a.department_name');?>
								
								</select>
									<? } ?>
								</span>

							</div>

						</div>

					</div>
				</div>





			</div>



			<div class="n-form-btn-class">


					<input name="search" type="submit" class="btn1 btn1-bg-update" value="Search" tabindex="12" />

					
			</div>



		</div>








	<? if (isset($_POST['search'])) {?>

		
			<!--Table input one design-->

			<div class="container-fluid pt-5 p-0 ">





				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

						<tr class="bgc-info">

							<th>Action</th>
							<th>Asset ID</th>
							<th>Asset Name</th>
							<th>Serial No.</th>
							<th>Qty</th>
							<th>Issue Date</th>
						</tr>
					</thead>



					<tbody class="tbody1">


                        <?php
						$con = ' and s.user_id=9999999';
						 $user_id = $_POST['user_id'];
						 if($_POST['user_id']>0){
						  $con = ' and s.user_id="'.$_POST['user_id'].'"';
						 }
						 
						  if($_POST['department_name']!=''){
						  $con = ' and s.department_name="'.$_POST['department_name'].'"';
						 }
						 
						 $sql = 'select s.*,i.item_name from fixed_asset_issue_master s, item_info i where i.item_id=s.item_id '.$con.' and s.status="ISSUED"';
						 $qry = db_query($sql);
						 while($data=mysqli_fetch_object($qry)){
						?>
						<tr>
						  <td><input type="checkbox" name="receiveItem<?=$data->id?>" id="receiveItem<?=$data->id?>" value="checked" /></td>
						  <td><?=$data->asset_id?></td>
						  <td><?=$data->item_name?></td>
						  <td><?=$data->serial_no?></td>
						  <td><?=$data->qty?></td>
						  <td><?=$data->date?></td>
						</tr>
						<? } ?>
					</tbody>
				</table>


			</div>

			<div class="container-fluid p-0 ">



				<div class="n-form-btn-class">


					<input name="do_no" type="hidden" id="do_no" value="<?= $$unique_master ?>" />

					<input name="do_date" type="hidden" id="do_date" value="<?= $do_date ?>" />

					<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="RECEIVE NOW" />

				</div>



			</div>

		</form>



	<? } ?>

</div>

<script>

$('#type').change(function(){

if($('#type').val()=="Department"){
$("#depp").css({display: "block"});

}else{

$("#depp").css({display: "none"});
}
});

</script>


<!--<script>$("#cz").validate();$("#cloud").validate();</script>-->



<?



require_once SERVER_CORE."routing/layout.bottom.php";







?>