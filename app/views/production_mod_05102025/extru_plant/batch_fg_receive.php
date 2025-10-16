<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Production Receive';

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

              <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Plant Name : </label>

              <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

				  <select name="fg_item_id" id="fg_item_id">

					<option></option>
					<option>Extrusion Plant 01</option>
					<option>Extrusion Plant 02</option>
					<option>Extrusion Plant 03</option>
					<option>Extrusion Plant 04</option>
					<option>Extrusion Plant 05</option>

				  </select>

              </div>

            </div>

          </div>



		

		  



          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

		            <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>

          </div>



        </div>

      </div>





      

    </form>

  </div>

  



<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>