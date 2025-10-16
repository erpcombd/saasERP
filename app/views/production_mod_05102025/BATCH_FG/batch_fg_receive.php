<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Batch Wise Production Receive';

do_calander('#fdate');

do_calander('#tdate');

$table_master='sale_do_master';

$unique='do_no';












$table_details='sale_do_details';





$$unique=$_POST[$unique];



//if(isset($_POST['delete']))

//{


//}

if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d h:s:i');



		$_POST['status']='COMPLETED';

		$crud   = new crud($table_master);

		$crud->update($unique_master);

		$crud   = new crud($table_detail);

		$crud->update($unique_master);

		$crud   = new crud($table_chalan);

		$crud->update($unique_master);

		

		

		

		

		

		

		

		unset($$unique_master);

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Instructed to Depot.';

}





$table='lc_number_setup';

$lc_no='id';

$text_field_id='id';



$target_url = 'invoice_entry.php';





?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

}

</script>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?batch_no='+theUrl);

}

</script>

























<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">

      <div class="container-fluid bg-form-titel">

        <div class="row ">

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">

		  <div class="row m-0 p-0">

			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">

				<div class="form-group row m-0">

				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date:</label>

				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

					<input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>"  autocomplete="off"/>

				  </div>

				</div>

			  </div>

		  

            

			

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">

					<div class="form-group row m-0">

					  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>

					  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

					   <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" autocomplete="off"/>

		

		

					  </div>

					</div>

				  </div>

			

			</div>

          </div>

		  

		 <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

            <div class="form-group row m-0">

              <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Product Name : </label>

              <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

				  <select name="fg_item_id" id="fg_item_id">

					<option value=""></option>

					<? foreign_relation('item_info','item_id','item_name',$_POST['fg_item_id'],'1');?>

				  </select>

              </div>

            </div>

          </div>



		<?php /*?>

		<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

            <div class="form-group row m-0">

              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Challan No:</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

				<input type="text" name="invoice_no" id="invoice_no" value="<?=$_POST['invoice_no']?>"/>	

              </div>

            </div>

          </div>

		  <?php */?>

		  



          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

		            <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>

          </div>



        </div>

      </div>





      <div class="container-fluid pt-5 p-0">

        <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">

          <thead class="thead1">

          <tr class="bgc-info">

            <th>Batch No</th>

            <th>Batch Date</th>

            <th>Product Name</th>

            <th>Entry By</th>

          </tr>

          </thead>

          <tbody class="tbody1">

           



			<? 

			

			if(isset($_POST['submitit'])){

			

			

			

			

			

			if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $con .= ' and m.batch_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

			



			if($_POST['fg_item_id']!=''){

			$fg_item_con=" and m.fg_item_id='".$_POST['fg_item_id']."'";
}

			

				 $res="select  m.* from  batch_master m, batch_raw_material d where m.batch_no=d.batch_no and  m.status='CHECKED'  ".$con.$fg_item_con." group by m.batch_no order by m.batch_date, m.batch_no";

			

			

			$query = db_query($res);

			while($data = mysqli_fetch_object($query))

			{

			?>

			



			

			<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>

			<td onClick="custom(<?=$data->batch_no;?>);" <?=(++$z%2)?'':'';?>><?=$data->inv_type;?><?=$data->batch_no;?></td>

			<td onClick="custom(<?=$data->batch_no;?>);" <?=(++$z%2)?'':'';?>>&nbsp;<?= date("d-m-Y",strtotime($data->batch_date));?></td>

			<td onClick="custom(<?=$data->batch_no;?>);" <?=(++$z%2)?'':'';?>><?= find_a_field('item_info','item_name','item_id="'.$data->fg_item_id.'"');?></td>

			<td onClick="custom(<?=$data->batch_no;?>);" <?=(++$z%2)?'':'';?>><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>

			</tr>

			

			

			<? } } ?>







          </tbody>

        </table>

      </div>

    </form>

  </div>

  



<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>