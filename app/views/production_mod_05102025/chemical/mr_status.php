<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Chemical Coding';

do_calander('#fdate');

do_calander('#tdate');



$table = 'master_requisition_master';

$unique = 'req_no';

$status = 'UNCHECKED';



$target_url = '../mr/mr_print_view.php';



?>



<script language="javascript">



function custom(theUrl){

	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);

}

</script>









<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">
		  <div class="row m-0 p-0">
		  
           <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date:</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
               <input type="text" name="fdate" id="fdate" style="width:100px;" value="<?=$_POST['fdate']?>"  autocomplete="off"/>
              </div>
            </div>
          </div>
		  
		  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                 <input type="text" name="tdate" id="tdate" style="width:100px;" value="<?=$_POST['tdate']?>"  autocomplete="off"/>
              </div>
            </div>
          </div>
		  
</div>
          </div>
          <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Section:</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
		<select name="req_for" id="req_for">
			<option></option>
				<option>Chemical Coding</option>
		</select>


              </div>
            </div>
          </div>


          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
		  <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>
</form>

      

  </div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>