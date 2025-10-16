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
$journalAll=find_all_field('journal_item','','serial_no="'.$_POST['serial_no'].'"');

if($_POST['item_id']==$journalAll->item_id  && $_POST['serial_no']==$journalAll->serial_no ){

$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['type']='Single';

$_POST['status']='COMPLETED';

$ids=$crud->insert();

 $sql='insert into fixed_asset_issue_details(m_id,PBI_ID,item_id,serial_no,date,quality,note,entry_by) values

("'.$ids.'","'.$_POST['PBI_ID'].'","'.$_POST['item_id'].'","'.$_POST['serial_no'].'","'.$_POST['date'].'","'.$_POST['quality'].'","'.$_POST['note'].'","'.$_POST['entry_by'].'")';

db_query($sql);




$journal_item_sql = 'insert into journal_item (`ji_date`,`item_id`,`warehouse_id`,`serial_no`,`item_ex`,`item_price`,`final_price`,`tr_from`,`tr_no`,`sr_no`,`entry_by`,`entry_at`,`primary_id`) value("'.$_POST['date'].'","'.$_POST['item_id'].'","'.$_SESSION['user']['depot'].'","'.$_POST['serial_no'].'",1,"'.$journalAll->item_price.'","'.$journalAll->final_price.'","singleAssetIssue","'.$ids.'","'.$ids.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d h:i:s').'","'.$ids.'")';
db_query($journal_item_sql);

}else{

echo 'Check Item & Serial';
}
}

?>


<div class="row">
	<div class="col-5">

		<form action="" method="post" style="text-align:left">



			<div class="form-group">

				<label for="recipient-name" class="col-form-label">Person Name:</label>

				<input list="names" type="text" class="form-control" name="PBI_ID" id="PBI_ID">
				
				<datalist id="names">
				<? foreign_relation('personnel_basic_info','concat(PBI_ID,"#",PBI_NAME)','PBI_NAME',$userName,'1')?>
				</datalist>

			</div>
			<div class="form-group">

				<label for="recipient-name" class="col-form-label">Person Mobile:</label>

				<input type="text" class="form-control" name="mobile" id="mobile">

			</div>
			
			<div class="form-group">

				<label for="recipient-name" class="col-form-label">Product Name:</label>

				<select type="text" class="form-control" name="item_id" id="item_id">
				
<? foreign_relation('item_info i,item_sub_group s,item_group g','i.item_id','i.item_name',$pName,'i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_name like "%FIXED ASSET%"')?>
				</select>

			</div>
			
			<div class="form-group">

				<label for="recipient-name" class="col-form-label">Product Serial:</label>

				<input type="text" class="form-control" name="serial_no" id="serial_no">

			</div>
			
			
			<div class="form-group">

				<label for="recipient-name" class="col-form-label">Product Quality:</label>

	

				<select name="quality" id="quality" class="custom-select custom-select-sm">

					<option value="New">New</option>

					<option value="Used">Used</option>

				</select>

			</div>

			<div class="form-group">

				<label for="message-text" class="col-form-label"> Note:</label>

				<textarea class="form-control" name="note"></textarea>

			</div>

			<div class="form-group">

				<label for="recipient-name" class="col-form-label"> Date:</label>

				<input type="date" class="form-control" name="date" value="date(" Y-m-d")" id="date-name">

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
					<th>Name</th>
					<th>P Name</th>
					<th>Serial No</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				 $sql = 'select a.*,p.PBI_NAME,i.item_name from '.$table_details.' a,personnel_basic_info p,item_info i where a.PBI_ID=p.PBI_ID and a.item_id=i.item_id and a.type="Single"';
				$query = db_query($sql);
				while ($data = mysqli_fetch_object($query)) {
				?>
					<tr>
							<td><?=$i++?></td>
							<td><?= $data->PBI_NAME ?></td>
							<td><?= $data->item_name ?></td>
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