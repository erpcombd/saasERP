<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$title='Unfinished Depot Transfer';

$table = 'fg_issue_master';
$unique = 'pi_no';
$status = 'MANUAL';

$target_url = '../depot_transfer/depot_transfer_entry.php';
$target2_url = '../depot_transfer/depot_transfer_entry2.php';

$table_master='fg_issue_master';
$unique_master='pi_no';

$table_detail='fg_issue_detail';
$unique_detail='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='UNSEND';
		$pi = find_all_field('fg_issue_master','pi_no','pi_no='.$$unique_master);

		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
		
		$type=1;
		$msg='Successfully Send.';
}

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}


if(isset($_POST[submit_normal])){
    $_SESSION[$unique] = $_POST[$unique];
    //header('location:depot_transfer_entry.php?old_pi_no='.$_POST[$unique]);
	header("Location: depot_transfer_entry.php?old_pi_no='.$_POST[$unique]");
}

if(isset($_POST[submit_req])){
    $_SESSION[$unique] = $_POST[$unique];
    header('location:'.$target2_url);
}

?>












<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Unfinished Depot Transfer (Requisition):</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
						<select name="<?=$unique?>" id="<?=$unique?>">
<? 
$sql = "select b.pi_no, concat(w.warehouse_name,' :: ',b.pi_no,' Req:',b.req_no) 
from fg_issue_master b,warehouse w 
where b.warehouse_to=w.warehouse_id and req_no>0
and b.warehouse_from='".$_SESSION['user']['depot']."'
and b.status='MANUAL'";
		foreign_relation_sql($sql);?>
      </select>
						
                         
                        </div>
                    </div>

                </div>
               

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
					 <input type="submit" name="submit_req" id="submit_req" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>

        
    </form>
</div>








<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Unfinished Depot Transfer:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
<select name="pi_no" id="pi_no">
<? 
$sql = "select b.pi_no, concat(w.warehouse_name,' :: ',b.pi_no) 
from fg_issue_master b,warehouse w 

where b.warehouse_to=w.warehouse_id and req_no=0 
and b.warehouse_from='".$_SESSION['user']['depot']."'
and b.status='MANUAL'";

foreign_relation_sql($sql);

?>

</select>
						
                         
</div>
</div>
</div>


<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
<input type="submit" name="submit_normal" id="submit_normal" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
</div>
</div>
</div>
</form>
</div>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>