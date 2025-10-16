<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title = 'Single User Issue';



$table_master='fixed_asset_issue_master';



$table_details='fixed_asset_issue_details';



$crud = new crud($table_master);

$dcrud= new crud($table_details);



$unique = 'id';



if(isset($_POST['submit'])){



$journalAll=find_all_field('asset_register','','sl_no="'.$_POST['sl_no'].'" and item_status="inStock"');

if ($_POST['sl_no'] == $journalAll->sl_no){

$_POST['entry_by']=$_SESSION['user']['id'];
$user = explode("#",$_POST['user_id']);
$item = explode("#",$_POST['asset_id']);
$_POST['user_id'] = $user[0];
//$_POST['type'] = 'Single';
$_POST['asset_id'] = $item[0];
$_POST['item_id'] = $item[2];
$_POST['department_name'] = $_POST['department_id'];
$_POST['status']='ISSUED';

if($_POST['type']=='User'){
$user = $_POST['user_id'];
}else{
$user = $_POST['department_id'];
}
$ids=$crud->insert();
if($ids>0){

$upAsset='update asset_register set item_status="inService" where asset_id="'.$item[0].'"';

db_query($upAsset);


journal_asset_item_control($item[2] ,$_SESSION['user']['depot'],date('Y-m-d'),0,1,$_POST['type'],$ids,$_POST['unit_price'],0,$ids,$_POST['unit_price'],0,0,$_POST['serial_no'],$item[0],$user);

echo '<div class="alert alert-success" role="alert">Asset Issued Successfully</div>';


}else{
echo '<div class="alert alert-danger" role="alert">Try again!</div>';
}

//$sql='insert into fixed_asset_issue_details(m_id,PBI_ID,item_id,serial_no,date,quality,note,entry_by,department_id) values ("'.$ids.'","'.$_POST['PBI_ID'].'","'.$journalAll->item_id.'","'.$_POST['sl_no'].'","'.$_POST['date'].'","'.$_POST['quality'].'","'.$_POST['note'].'","'.$_POST['entry_by'].'","'.$_POST['department_id'].'")';

//$query=db_query($sql);

$lastDetailsId=mysqli_insert_id($conn); 






//journal_asset_item_control($journalAll->item_id ,$_SESSION['user']['depot'],date('Y-m-d'),0,1,'Issue',$lastDetailsId,$journalAll->price,0,$ids,$journalAll->price,0,0,$_POST['sl_no']);



}else{



echo 'Item Not Avilable';

}

}



?>





<div class="row">

	<div class="col-5">



		<form action="" method="post" style="text-align:left" autocomplete="off">




            <div class="form-group">



				<label for="recipient-name" class="col-form-label">Type:</label>



				<select name="type" id="type" required >
								
								<option value="User" <?=($_POST['type']=='User')?'selected':''?>>User</option>
								<option value="Department" <?=($_POST['type']=='Department')?'selected':''?>>Department</option>
								
								</select>


				

			
			</div>


			<div class="form-group">



				<label for="recipient-name" class="col-form-label">Person Name:</label>



				<input list="names" type="text" class="form-control" name="user_id" id="user_id">

				

				<datalist id="names">

				<? foreign_relation('user_activity_management','concat(user_id,"#",fname)','""',$user_id,'status="In Service"')?>

				</datalist>



			</div>

			
			<div class="form-group">



				<label for="recipient-name" class="col-form-label">Department:</label>



				<select type="text" class="form-control" name="department_id" id="department_id" />
				
				<option></option>
				
				<? foreign_relation('department','DEPT_ID','DEPT_DESC',$department,'1');?>
				
				</select>



			</div>

			

			<div class="form-group">



				<label for="recipient-name" class="col-form-label">Product Name:</label>



				<input list="itms" type="text" class="form-control" name="asset_id" id="asset_id" onblur="getData2('get_serial_ajax.php','serialList',this.value,this.value);" required>



				<datalist id="itms">

<? foreign_relation('item_info i,asset_register r','concat(r.asset_id," # ",i.item_name," # ",i.item_id)','""',$asset_id,'r.item_id=i.item_id and r.item_status="inStock" group by asset_id')?>

				</datalist>



			</div>


<div class="form-group">



				<label for="recipient-name" class="col-form-label">Serial No.:</label>

               <span id="serialList">

				<input type="text" class="form-control" name="serial_no" id="serial_no" readonly="readonly">
               </span>




			</div>


			<div class="form-group">



				<label for="recipient-name" class="col-form-label">Product Quality:</label>



				<select name="quality" id="quality" class="custom-select custom-select-sm">

									<option value="Good">Good</option>

									<option value="Moderate">Moderate</option>

									<option value="Serviceable">Serviceable</option>

									<option value="Unserviceable">Unserviceable</option>

									<option value="Obsolete">Obsolete</option>



				</select>



			</div>



			<div class="form-group">



				<label for="message-text" class="col-form-label"> Note:</label>



				<textarea class="form-control" name="note"></textarea>



			</div>



			<div class="form-group">



				<label for="recipient-name" class="col-form-label"> Date:</label>



				<input type="date" class="form-control" name="date" value="date(" Y-m-d")" id="date-name" required>



			</div>

 

			<div class="form-group">

				<input type="submit" class="form-control btn btn-success" name="submit" value="Confirm">

			</div>



</form>



	</div>

	<div class="col-7">

		<center>

			<h4>Issue List</h4>

		</center>

		<table class="table table-bordered">

			<thead>

				<tr>

					

					<th>Id</th>

					<th>User Name</th>
					
					<th>Department</th>

					<th>Asset</th>

					<th>Serial No</th>

					<th>Date</th>

				</tr>

			</thead>

			<tbody>

				<?php

				$i=1;

				$sql = 'select a.*,p.fname,i.item_name,d.DEPT_DESC from '.$table_master.' a left join user_activity_management p on p.user_id=a.user_id left join department d on d.DEPT_ID=a.department_name,item_info i where a.item_id=i.item_id';

				$query = db_query($sql);

				while ($data = mysqli_fetch_object($query)) {

				?>

					<tr>

							<td><?=$i++?></td>

							<td><?= $data->fname ?></td>
							
							<td><?= $data->DEPT_DESC ?></td>

							<td><?=$data->asset_id.' - '.$data->item_name ?></td>

							<td><?= $data->serial_no ?></td>

							<td><?= $data->date;?></td>

			

					</tr>



				<? } ?>

			</tbody>

		</table>

	</div>

</div>







<?







require_once SERVER_CORE."routing/layout.bottom.php";









?>