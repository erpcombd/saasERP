<?php
require_once "../../../assets/template/layout.top.php";

$title='Select Depot for Transfer';

$table_master='fg_issue_master';
$unique_master='pi_no';


$table_detail='fg_issue_detail';
$unique_detail='id';


$$unique_master=$_POST[$unique_master];
$req_no     = $_POST['req_no'];
$pi_date    = $_POST['pi_date'];



if(prevent_multi_submit()){

if(isset($_POST['confirm'])){
		

$page_for = 'Transit';

$sql='select a.id,a.*,b.finish_goods_code as fg_code,b.item_name,b.unit_name
from requisition_fg_order a, item_info b 
where b.item_id=a.item_id and a.req_no='.$req_no.' order by a.id';
$query = mysql_query($sql);

while($data=mysql_fetch_object($query)){
    
    if($_POST['total_unit_'.$data->id]>0){
				
				$qty        = $_POST['total_unit_'.$data->id];
                $rate       = find1("select cost_price from item_info where item_id='".$data->item_id."'");
				$amount     = $qty*$rate; 
 
                $sql = 'INSERT INTO fg_issue_detail (pi_no, pi_date, item_id, warehouse_from,warehouse_to,total_unit, unit_price, total_amt,req_no,req_id)
                
                VALUES("'.$$unique_master.'","'.$_POST['pi_date'].'","'.$data->item_id.'","'.$data->warehouse_to.'","'.$data->warehouse_id.'","'.$qty.'"
                ,"'.$rate.'","'.$amount.'","'.$data->req_no.'","'.$data->id.'")';
                
                mysql_query($sql);
        
        journal_item_control($data->item_id ,$data->warehouse_to,$pi_date,0,$qty,$page_for,$tr_id,$unit_price,$data->warehouse_id,$$unique_master);

    }

}

		
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='SEND';
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

}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}





if(isset($_POST['delete'])){

		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

}




?>

<script language="javascript">

window.onload = function() {document.getElementById("dealer").focus();}

</script>







<div class="form-container_large">

    <form action="depot_transfer_entry.php" method="post" name="codz" id="codz">
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Select Depot</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
						<?php 
unset($_SESSION['pi_no']);
?>
      	  <select name="line_id" id="line_id" class="form-control" required>

		  <option></option>
<?

require_once "../../../assets/template/layout.bottom.php";

?>
	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1 and warehouse_id not in("'.$_SESSION['user']['depot'].'") and use_type="WH"');?>



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











