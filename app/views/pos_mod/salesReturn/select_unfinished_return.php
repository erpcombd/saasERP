<?php

require_once "../../../assets/template/layout.top.php";

$title='Select Dealer for Demand Order';



$table_master='sale_do_master';

$unique_master='do_no';



$table_detail='sale_do_details';

$unique_detail='id';



$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_SESSION[$unique_master];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		$crud   = new crud($table_chalan);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='PROCESSING';

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





$table='sale_do_master';

$show='dealer_code';

$id='do_no';

$con='status="MANUAL"';



?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

}

</script>

<div class="form-container_large">
    
<form action="item_return.php" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Unfinished DO List:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							  <select name="or_no" id="or_no">
								<?
								 foreign_relation('warehouse_other_receive','or_no','or_no',$or_no,'    warehouse_id="'.$_SESSION['user']['depot'].'" and status="MANUAL"');
								  ?>
							  </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <input type="submit" name="submitit" id="submitit" value="Complete DO" class="btn1 btn1-submit-input">
                </div>

            </div>
        </div>

        
</form>
</div>






<?
require_once "../../../assets/template/layout.bottom.php";
?>