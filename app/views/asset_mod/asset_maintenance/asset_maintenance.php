<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Asset Maintenance';

$table_master = 'asset_maintenance_info';
$table_detail = 'asset_maintenance_detail';
$unique = 'm_id';
$crud = new crud($table_master);

do_calander('#do_date');

do_calander('#date');

do_calander('#customer_po_date');

$now = date('Y-m-d H:s:i');
do_calander('#est_date');

if($_GET['m_id']>0){
$_SESSION[$unique] = $$unique = $_GET['m_id'];
}

$s = 0;
if(isset($_POST['new'])){
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_SESSION[$unique] = $$unique = $crud->insert();
if($$unique>0){
echo '<div class="alert alert-success" role="alert">New Entry Registered Successfully</div>';
}
}

if(isset($_POST['update'])){
$crud = new crud($table_master);
$_POST['edit_by'] = $_SESSION['user']['id'];
$_POST['edit_at'] = date('Y-m-d H:i:s');
$crud->update($unique);
echo '<div class="alert alert-success" role="alert">Date Updated!</div>';

}

if(isset($_POST['add_new']) && $_SESSION[$unique]>0){

$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['item_id'] = find_a_field('asset_register','item_id','asset_id="'.$_POST['asset_id'].'"');
$crud = new crud($table_detail);
$crud->insert();

}

if(isset($_POST['confirm'])){
$crud= new crud($table_master);
$_POST['status'] = 'UNCHECKED';
$crud->update($unique);
unset($_SESSION[$unique]);
echo '<div class="alert alert-success" role="alert">Successfully Forward to Next Level!</div>';
}

if(isset($_POST['cancel'])){
$crud= new crud($table_master);
$condition="m_id=".$_SESSION[$unique];
$crud->delete($condition);

$crud= new crud($table_detail);
$condition="m_id=".$_SESSION[$unique];
$crud->delete($condition);

unset($_SESSION[$unique]);
echo '<div class="alert alert-success" role="alert">Transaction Canceled!</div>';
}

if($_GET['delId']>0){
  
  $check_m_id = find_a_field('asset_maintenance_detail','m_id','id="'.$_GET['delId'].'"');
  if($check_m_id==$_SESSION[$unique]){
   $crud= new crud($table_detail);
   $condition="m_id=".$_SESSION[$unique];
   $crud->delete($condition);
  }else{
  echo '<div class="alert alert-danger" role="alert">Trying Invalid ID</div>';
  }
 
}


if($_SESSION[$unique]>0){
        $condition="m_id=".$_SESSION[$unique];

        $data=db_fetch_object($table_master,$condition);

        foreach($data as $key =>$value)

        { $$key=$value;}

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

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Maintenance ID</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
							    <input type="text" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" readonly="readonly" />
								
								

							</div>

						</div>
						
						<div class="form-group row m-0 pb-1">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Location</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

								<input type="text" name="warehouse_id2" id="warehouse_id2" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$_SESSION['user']['depot'].'"');?>" />
								<input type="hidden" name="warehouse_id" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>" />
								

							</div>

						</div>

						



					</div>





				</div>



				<!--Right form-->

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="container n-form2">


						<div class="form-group row m-0 pb-1">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Maintenance Date</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                    
									<input type="date" name="m_date" id="m_date" value="<?=$m_date?>" />
									
								</span>

							</div>

						</div>
						
						<div class="form-group row m-0 pb-1">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                    
									<input type="text" name="note" id="note" value="<?=$note?>" />
									
								</span>

							</div>

						</div>

					</div>
				</div>
				
				
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

					<div class="container n-form2">


						
						
						<div class="form-group row m-0 pb-1">

							

							<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 p-0 pr-2" align="center">
                                    
									<? if($_SESSION[$unique]>0){?>
									<input type="submit" name="update" id="update" value="Update" class="btn btn-primary" />
									<? }else{?>
									<input type="submit" name="new" id="new" value="Initiate" class="btn btn-primary" />
									<? } ?>
									
								</span>

							</div>

						</div>

					</div>
				</div>





			</div>



		</div>

		
			<!--Table input one design-->
 <? if($_SESSION[$unique]>0){ ?>
			<div class="container-fluid pt-5 p-0 ">




               
				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

						  <tr>

      <th scope="col">Asset ID</th>

      <th scope="col">Maintenance Type</th>

      <th scope="col">Technician/Engineer</th>
	  
	  <th scope="col">Cost</th>

      <th scope="col">Reason</th>
	  
	  <th scope="col">Action</th>

    </tr>
					</thead>



					<tbody class="tbody1">

						<tr>
     <td>
	  
	  <input type="text" name="asset_id" id="asset_id" list="assetList" value="" />
	     <datalist id="assetList">
		 <? foreign_relation('asset_register','asset_id','""',$asset_id,'item_status!="Disposed"')?>
		 </datalist>
	  </td>

      <td><select name="m_type" id="m_type"><option></option><option>preventive</option><option>corrective</option><option>routine</option></select></td>
	  
	  <td><select name="engineer" id="engineer"><option></option><? foreign_relation('user_activity_management','user_id','fname',$engineer,'1')?></select></td>

      <td><input type="text" name="m_cost" id="m_cost" value="" /></td>

	  <td><input type="text" name="reason" id="reason" value="" /></td>
	  
	  <td><input type="submit" name="add_new" id="add_new" value="ADD" class="btn btn-success" /></td>
	  
    </tr>
						
					</tbody>
				</table>
				<br />
				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

						  <tr>

      <th scope="col">Asset ID</th>

      <th scope="col">Maintenance Type</th>

      <th scope="col">Technician/Engineer</th>
	  
	  <th scope="col">Cost</th>

      <th scope="col">Reason</th>
	  
	  <th scope="col">Action</th>

    </tr>
					</thead>



					<tbody class="tbody1">
 <?
 $sql = 'select * from '.$table_detail.' where m_id="'.$_SESSION[$unique].'"';
 $qry = db_query($sql);
 while($data=mysqli_fetch_object($qry)){
 ?>
						<tr>
     <td><?=$data->asset_id?></td>

      <td><?=$data->m_type?></td>
	  
	  <td><?=$data->engineer?></td>

      <td><?=$data->m_cost?></td>

	  <td><?=$data->reason?></td>
	  
	  <td><a href="?delId=<?=$data->id?>">X</a></td>
	  
    </tr>
	<? } ?>
						
					</tbody>
				</table>
  

			</div>

			
<? } ?>
		</form>
		<form action="" method="post">
		<div class="container-fluid p-0 ">



				<div class="n-form-btn-class">


					<div class="n-form-btn-class">
                    <input name="<?=$unique?>" type="hidden" class="btn btn-warning" value="<?=$_SESSION[$unique]?>" style="float:left;" />
                    <input name="cancel" type="submit" class="btn btn-warning" value="CANCEL" style="float:left;" />
					<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM" style="float:right;" />

				</div>

				</div>

			</div>
			</form>
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