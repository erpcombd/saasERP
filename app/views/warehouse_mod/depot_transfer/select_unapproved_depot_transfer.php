<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Unapproved Depot Transfer';
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
$table = 'production_issue_master';
$unique = 'pi_no';
$status = 'UNCHECKED';
$target_url = '../depot_transfer_tn/depot_transfer_checking.php';
$tr_type="Show";
$table_master='production_issue_master';
$unique_master='pi_no';

$table_detail='production_issue_detail';
$unique_detail='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='SEND';
		$pi = find_all_field('production_issue_master','pi_no','pi_no='.$$unique_master);
		
$sales_ledger = 1098000100000000;
$ledger = find_a_field('warehouse','fg_ledger_id','warehouse_id='.$pi->warehouse_to);	
$cc_code = find_a_field('warehouse','acc_code','warehouse_id='.$pi->warehouse_from);	
$narration = 'PI No-'.$pi_no.'|| SendDt:'.$pi->pi_date;
//auto_insert_depot_sales_issue($pi->pi_date,$ledger,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);


		$sql = 'select * from production_issue_detail where pi_no='.$$unique_master;
		
		$query = db_query ($sql);
		
		while($data=mysqli_fetch_object($query)){
		
journal_item_control($data->item_id ,$pi->warehouse_from,$data->pi_date ,0,$data->total_unit ,'Transit',$data->id,$data->unit_price,$pi->warehouse_to,$$unique_master);


}

		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
		unset($_SESSION[$unique_master]);
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

if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
//header('location:'.$target_url);
echo '<script>
window.location.href="../depot_transfer_tn/depot_transfer_checking.php"

</script>';
}
$tr_from="Warehouse";
?>


<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"><?=$title?>:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
						<select name="<?=$unique?>" id="<?=$unique?>"  style="width:200px;" >
                <? 
	$sql = "select b.pi_no, concat(w.warehouse_name,' - ',b.pi_no) from production_issue_master b,warehouse w 
where b.warehouse_to=w.warehouse_id and b.warehouse_from=".$_SESSION['user']['depot']." and b.status='UNSEND'";
		foreign_relation_sql($sql);?>
      </select>
						
                         
                        </div>
                    </div>

                </div>
               

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
					 <input type="submit" name="submitit" id="submitit" value="Depot Transfer" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>

        
    </form>
</div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>