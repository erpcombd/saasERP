<?php
require_once "../../../assets/template/layout.top.php";

$title='Select Depot for Transfer';



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
		$_POST['status']='UNSEND';
		$pi = find_all_field('production_issue_master','pi_no','pi_no='.$$unique_master);

		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
		
		$type=1;
		$msg='Successfully Send.';
}
/*if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d H:s:i');

		$_POST['status']='MENUAL';

		$pi = find_all_field('production_issue_master','pi_no','pi_no='.$$unique_master);

		if($_SESSION['user']['depot']==5)

		{

		$ledger = 3002000100020000;

		$sales_ledger = 1079000400010001;

		auto_insert_sale_hfl($pi->pi_date,$ledger,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no);
		
		
		$sql = 'select * from production_issue_detail where pi_no='.$$unique_master;
		
		$query = mysql_query ($sql);
		
		while($data=mysql_fetch_object($query)){
		
		journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->pi_date ,0,$data->total_unit ,'Transit',$data->id,$data->unit_price,$pi->warehouse_to,$$unique_master);

}



//		$sales_ledger = 1070000100020000;

//		$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$pi->warehouse_to);

//		$ledger = find_a_field('config_group_class','purchase_ledger','group_for=2');	

//		$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;

//		auto_insert_sale_sc($pi->pi_date,$ledger,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);



		}

		else

		{

		$ledger = 1078000200010000;

		$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$_SESSION['user']['depot']);

		$sales_ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);	

		$narration = 'PI No-'.$pi_no.'||SendDt:'.$pi->pi_date;

		auto_insert_store_transfer_issue($pi->pi_date,$ledger,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);

		}

		

		$crud   = new crud($table_master);

		$crud->update($unique_master);

		$crud   = new crud($table_detail);

		$crud->update($unique_master);

		

		unset($$unique_master);

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Send.';

}*/



if(isset($_POST['delete']))

{

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
	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1');?>



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



















<?php /*?><div class="form-container_large">

<form action="depot_transfer_entry.php" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Select Depot: </strong></td>

    <td bgcolor="#FF9966"><strong>
<?php 
unset($_SESSION['pi_no']);
?>
      	  <select name="line_id" id="line_id" class="form-control" required>

		  <option></option>
<?

require_once "../../../assets/template/layout.bottom.php";

?>
	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1');?>



	  </select>

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Depot Transfer" class="btn1 btn1-submit-input"/>

    </strong></td>

  </tr>

</table>

</form>

</div><?php */?>



