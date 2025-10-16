<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Unfinished FG Issue List';





$table = 'fg_transfer_master';


$unique = 'st_no';


$status = 'MANUAL';


$target_url = '../fg_transfer/fg_issue.php';





if($_POST[$unique]>0)


{


$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);


}

?>




<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"><?=$title?>: </label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
				  <select name="<?=$unique?>" id="<?=$unique?>">
					<? foreign_relation($table,$unique,$unique,$$unique,'status="'.$status.'"');?>
				  </select>
              </div>
            </div>

          </div>

          <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
		        <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>


      
    </form>
  </div>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>