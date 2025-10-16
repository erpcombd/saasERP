<?php





require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Department Asset Issue';

do_calander('#do_date');

do_calander('#date');

do_calander('#customer_po_date');

//create_combobox('dealer_code_combo');

$now = date('Y-m-d H:s:i');

$page = 'department.php';


$table_master = 'fixed_asset_issue_master';

$unique_master = 'id';

$table_detail = 'fixed_asset_issue_details';

$unique_detail = 'id';

if ($_REQUEST['old_do_no'] > 0)

$$unique_master = $_REQUEST['old_do_no'];

else

$$unique_master = $_REQUEST[$unique_master];

$mobile=find_a_field($table_master,'mobile','id='.$$unique_master);

$responsible_person=find_a_field($table_master,'responsible_person','id='.$$unique_master);

$department_id=find_a_field($table_master,'department_id','id='.$$unique_master);

$date=find_a_field($table_master,'date','id='.$$unique_master);





if ($_GET['del'] !='') {

$sl=find_a_field('fixed_asset_issue_details','serial_no','id='.$_GET['del']);

$asql='update asset_register set item_status="inStock" where sl_no="'.$sl.'"';

db_query($asql);



	 $sql='delete from fixed_asset_issue_details where id='.$_GET['del'].'';

	db_query($sql);

	}

	

if(isset($_POST['confirm'])){



 $sql='select * from fixed_asset_issue_details where m_id='.$$unique_master;



$query=db_query($sql);

while($data=mysqli_fetch_object($query)){



$journalAll=find_all_field('asset_register','','sl_no="'.$data->serial_no.'"');



$journal_item_sql = 'insert into journal_asset_item (`ji_date`,`item_id`,`warehouse_id`,`serial_no`,`item_ex`,`item_price`,`final_price`,`tr_from`,`tr_no`,`sr_no`,`entry_by`,`entry_at`,`primary_id`) value("'.$data->entry_at.'","'.$data->item_id.'","'.$_SESSION['user']['depot'].'","'.$data->serial_no.'",1,"'.$journalAll->price.'","'.$journalAll->price.'","Issue","'.$data->id.'","'.$data->m_id.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d h:i:s').'","'.$data->id.'")';

db_query($journal_item_sql);

db_query('update fixed_asset_issue_master set status="COMPLETED" where id='.$$unique_master);

echo "<script>window.top.location='department.php'</script>";



}



}	

	

if (prevent_multi_submit()) {











	if (isset($_POST['new'])) {



		if ($_POST['dealer_code_combo'] > 0) {



			$_POST['dealer_code'] = $_POST['dealer_code_combo'];

		}







		$job_date = $_POST['do_date'];



		$YR = date('Y', strtotime($job_date));



		$yer = date('y', strtotime($job_date));



		$month = date('m', strtotime($job_date));



		$job_cy_id = find_a_field('fixed_asset_issue_master', 'max(job_id)', 'year="' . $YR . '"') + 1;



		$cy_id = sprintf("%06d", $job_cy_id);



		$job_no_generate = 'SO' . $yer . '' . $month . '' . $cy_id;



		$_POST['job_no'] = $job_no_generate;



		$_POST['job_id'] = $job_cy_id;



		$_POST['year'] = $YR;



		$crud   = new crud($table_master);



		$_POST['type'] = "Department";





		$_POST['entry_at'] = date('Y-m-d H:i:s');



		$_POST['entry_by'] = $_SESSION['user']['id'];







		//$merchandizer_exp=explode('->',$_POST['merchandizer']);







		//$_POST['merchandizer_code']=$merchandizer_exp[0];



		if ($_POST['flag'] < 1) {



			$_POST['do_no'] = find_a_field($table_master, 'max(do_no)', '1') + 1;



			$$unique_master = $crud->insert();



			$type = 1;





			$msg = 'Sales Return Initialized. (Sales Return No-' . $$unique_master . ')';

		} else {



			unset($_POST['job_no']);



			unset($_POST['job_id']);



			unset($_POST['year']);



			$crud->update($unique_master);



			$type = 1;



			$msg = 'Successfully Updated.';

		}

	}





	if (isset($_POST['add'])) {



$journalAll=find_all_field('asset_register','','sl_no="'.$_POST['serial_no'].'" and item_status="inStock"');



 $sql='insert into fixed_asset_issue_details(m_id,item_id,serial_no,date,quality,note,entry_by,type,PBI_ID,department_id) values



("'.$_POST['ids'].'","'.$journalAll->item_id.'","'.$_POST['serial_no'].'","'.date("Y-m-d").'","'.$_POST['quality'].'","'.$_POST['note'].'","'.$_SESSION['user']['id'].'","Department","'.$_POST['PBI_ID'].'","'.$_POST['department_id'].'")';



db_query($sql);



$vs='update asset_register set item_status="inService" where sl_no="'.$_POST['serial_no'].'"';

db_query($vs);







echo "<script>window.top.location='department.php?old_do_no=".$_POST['ids']."'</script>";





	}







	





	if ($$unique_master > 0) {







		$condition = $unique_master . "=" . $$unique_master;







		$data = db_fetch_object($table_master, $condition);







		foreach($data as $key => $value) {

			$$key = $value;

		}

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



	<form action="<?= $page ?>" method="post" name="codz2" id="codz2">



		<!--        top form start hear-->



		<div class="container-fluid bg-form-titel">



			<div class="row">



				<!--left form-->



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



					<div class="container n-form2">



						<div class="form-group row m-0 pb-1">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Issue No</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">







								<input name="id" type="text" id="id" value="<? if ($$unique_master > 0) echo $$unique_master;

																			else echo (find_a_field($table_master, 'max(' . $unique_master . ')', '1') + 1); ?>" readonly />







								<input name="group_for" type="hidden" id="group_for" required readonly="" value="<?= $_SESSION['user']['group'] ?>" tabindex="105" />







							</div>



						</div>







						<? if ($date == "") { ?>



							<div class="form-group row m-0 pb-1">







								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date</label>



								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">



									<input name="date" type="text" id="date" value="<?= ($date != '') ? $date : date('Y-m-d') ?>" required />



								</div>



							</div>



						<? } ?>











						<? if ($date != "") { ?>



							<div class="form-group row m-0 pb-1">







								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date</label>



								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">



									<input name="date" type="text" id="date" value="<?= $date; ?>" required />







								</div>



							</div>



						<? } ?>



























						<?php /*?><div class="form-group row m-0 pb-1">



<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department Name</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

								<select name="department_id" type="text" id="department_id" required>
								
								<option></option>
								
									<? foreign_relation('asset_department','id','department_name',$department_id,'1');?>
								
								</select>

							</div>
						</div><?php */?>
					</div>











				</div>







				<!--Right form-->



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



					<div class="container n-form2">



<div class="form-group row m-0 pb-1">



<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department Name</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

								<select name="department_id" type="text" id="department_id" required>
								
								<option></option>
								
									<? foreign_relation('department','DEPT_ID','DEPT_DESC',$department_id,'1');?>
								
								</select>

							</div>
						</div>

						<?php /*?><div class="form-group row m-0 pb-1">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Responsible Person</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">



									<select id="responsible_person" name="responsible_person" class="form-control" required>



										<? foreign_relation('personnel_basic_info', 'PBI_ID', 'PBI_NAME', $responsible_person, '1') ?>



									</select>



							</div>



						</div><?php */?>







						<?php /*?><div class="form-group row m-0 pb-1">







							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Mobile</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">



								<input name="mobile" type="text" id="mobile" value="<?= $mobile; ?>" required />



							</div>



						</div><?php */?>





					</div>


				</div>

			</div>

			<div class="n-form-btn-class">

				<? if ($$unique_master > 0) { ?>



					<input name="new" type="submit" class="btn1 btn1-bg-update" value="Issue" tabindex="12" />



					<input name="flag" id="flag" type="hidden" value="1" />



				<? } else { ?>


					<input name="new" type="submit" class="btn1 btn1-bg-submit" value="Issue" tabindex="12" />



					<input name="flag" id="flag" type="hidden" value="0" />


				<? } ?>


			</div>

		</div>

	</form>



	<? if ($$unique_master > 0) { ?>



		<form action="" method="post" name="codz2" id="codz2">



			<!--Table input one design-->



			<div class="container-fluid pt-5 p-0 ">

				<table class="table1  table-striped table-bordered table-hover table-sm">



					<thead class="thead1">



						<tr class="bgc-info">



							<th>Item Name</th>

							<th>Quality</th>
							
							<th>Person</th>

							<th>Note</th>

							<th>Action</th>
						</tr>

					</thead>

					<tbody class="tbody1">

						<tr>
							<td>

								<input list="itms" name="serial_no" type="text" value="" id="serial_no" autocomplete="off">

					<datalist id="itms">

<? foreign_relation('item_info i,asset_register r','r.sl_no','i.item_name',$pName,'r.item_id=i.item_id and r.item_status="inStock" group by sl_no')?>

				</datalist>

							

							</td>



					

							

							<input name="ids" value="<?=$$unique_master?>" type="hidden"/>

							

							<input type="hidden" name="PBI_ID" value="<?=$responsible_person?>" />


							<td><select name="quality" id="quality" class="custom-select custom-select-sm">



									<option value="Good">Good</option>

									<option value="Moderate">Moderate</option>

									<option value="Serviceable">Serviceable</option>

									<option value="Unserviceable">Unserviceable</option>

									<option value="Obsolete">Obsolete</option>


								</select></td>
								
								<td><select name="PBI_ID" id="PBI_ID" required>
								<option></option>
							<? foreign_relation('personnel_basic_info','concat(PBI_ID,"#",PBI_NAME)','PBI_NAME',$PBI_ID,'1')?>
								</select></td>



							<td><input name="note" type="text" class="input3" id="note" /></td>
							
							<input type="hidden" name="department_id" id="$department_id" value="<?=$department_id?>"/>



							<td><input name="add" type="submit" id="add" value="ADD" class="btn1 btn1-bg-submit" /></td>







						</tr>







					</tbody>



				</table>





			</div>



		</form>



		<? if($$unique_master>0){?>

			<!--Data multi Table design start-->

			<div class="container-fluid pt-5 p-0 ">

			<?

			  $res='select d.*,i.item_name from fixed_asset_issue_details d,item_info i where d.item_id=i.item_id and d.m_id="'.$$unique_master.'"';

			?>



				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

					<tr class="bgc-info">

						<th>SL</th>

						<th>Item Name</th>

						<th>Serial No</th>

						<th>Quality</th>
						
						<th>Person</th>

						<th>Note</th>

						<th>Action</th>

					</tr>

					</thead>



					<tbody class="tbody1">



					<?



					$i=1;



					$query = db_query($res);



					while($data=mysqli_fetch_object($query)){ ?>



					<tr>



						<td><?=$i++?></td>

						<td><?=$data->item_name?></td>

						<td><?=$data->serial_no?></td>

						<td><?=$data->quality?></td>
						
						<td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$data->PBI_ID);?></td>

						<td><?=$data->note?></td>

						

						<td><a href="?old_do_no=<?=$data->m_id?>&&del=<?=$data->id?>">X</a></td>

					</tr>



					<? } ?>





					</tbody>

				</table>



			</div>

		<? }?>







		<!--button design start-->



		<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">



			<div class="container-fluid p-0 ">







				<div class="n-form-btn-class">



					<input name="delete" type="submit" class="btn1 btn1-bg-cancel" value="DELETE SO" />



					<input name="do_no" type="hidden" id="do_no" value="<?= $$unique_master ?>" />



					<input name="do_date" type="hidden" id="do_date" value="<?= $do_date ?>" />



					<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM SO" />



				</div>







			</div>



		</form>







	<? } ?>



</div>









<!--<script>$("#cz").validate();$("#cloud").validate();</script>-->







<?







require_once SERVER_CORE."routing/layout.bottom.php";















?>