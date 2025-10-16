<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Other Receive Approval';
do_calander('#fdate');
do_calander('#tdate');
$table_master='warehouse_other_receive';
$unique_master='or_no';

 $master_id = find_a_field('user_activity_management','master_user','user_id='.$_SESSION['user']['id']);
$tr_type="Show";
//create_combobox('pr_no');
create_combobox('vendor_id');

$table_detail='warehouse_other_receive_detail';
$unique_detail='id';
auto_insert_sales_return_secoundary("11");
//$table_chalan='purchase_return_details';
//$unique_chalan='id';

$$unique_master=$_POST[$unique_master];

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
		$tr_type="Delete";
}
if(isset($_POST['return_remarks']) && $_POST['return_remarks']!=""){
        
		
		$remarks = $_POST['return_remarks'];
        unset($_POST);

		$_POST[$unique_master]=$$unique_master;
        $_POST['status']='MANUAL';
		$_POST['checked_at'] = date('Y-m-d H:i:s');
		$_POST['checked_by'] = $_SESSION['user']['id'];
		$crud   = new crud($table_master);
		$crud->update($unique_master);

		
		
		$note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique_master.'","OtherIssue","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';
		db_query($note_sql);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;
        
        echo $msg='<span style="color:green;">Successfully Returned</span>';
}

if(isset($_POST['return']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['status']='MANUAL';
		$_POST['checked_at'] = date('Y-m-d H:i:s');
		$_POST['checked_by'] = $_SESSION['user']['id'];
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		echo $msg='<span style="color:red;">Successfully Returned</span>';
}

if(isset($_POST['confirm']))

{
$or_no = $_REQUEST['or_no'];
if($or_no>0){

$jv_date = date('Y-m-d');
$proj_id = 'clouderp';
//$group_for =  $_SESSION['user']['group'];
$cc_code = '1';
$tr_no = $or_no;
$tr_from = 'Other Receive';
$narration = 'Other Receive#'.$or_no;

$jv_no=next_journal_sec_voucher_id('',$tr_from,$group_for);
$issue_ledger = find_a_field('config_group_class','other_receive','group_for="'.$_SESSION['user']['group'].'"');

 
$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d h:i:s');


$do_master = find_all_field('purchase_return_master','pr_no','pr_no='.$or_no);



  $do_sql = "select w.id,w.item_id,w.warehouse_id,w.qty,w.rate,w.amount,w.or_no,w.or_date,s.item_ledger as ledger_id,w.receive_type,i.sub_ledger_id ,w.cr_ledger,w.cr_sub_ledger
 
 from warehouse_other_receive_detail w, item_info i, item_sub_group s 
 
 where w.item_id=i.item_id and i.sub_group_id=s.sub_group_id and w.or_no='".$or_no."' and w.receive_type='Other Receive'";

$do_query = db_query($do_sql);	
        
		while($do_data=mysqli_fetch_object($do_query))

		{ $tr_id = $do_data->id;
		
		//$avg_rate = find_a_field('journal_item', '(sum(item_in*final_price)-sum(item_ex*final_price))/(sum(item_in)-sum(item_ex))', 'item_id = "'.$do_data->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
	
	journal_item_control($do_data->item_id, $do_data->warehouse_id, date('Y-m-d'),$do_data->qty, 0,   $do_data->receive_type, $do_data->id, $do_data->rate, $do_data->warehouse_id, $do_data->or_no, '', '',$do_master->group_for, $avg_rate, '' );
	
	
add_to_sec_journal($proj_id, $jv_no, $jv_date, $do_data->ledger_id, $narration, $do_data->amount, '0', $do_data->receive_type, $tr_no,$do_data->sub_ledger_id,$tr_id,$cc_code,$do_master->group_for,'','','','','','','','YES');
  
add_to_sec_journal($proj_id, $jv_no, $jv_date, $do_data->cr_ledger, $narration,  '0',$do_data->amount, $do_data->receive_type, $tr_no,$do_data->cr_sub_ledger,$tr_id,$cc_code,$do_master->group_for,'','','','','','','','YES');
  

		}

		$sql2 = 'update warehouse_other_receive set status="CHECKED",or_date="'.date('Y-m-d').'" where or_no = '.$or_no;
		db_query($sql2);
		
		$sql3 = 'update warehouse_other_receive_detail set or_date="'.date('Y-m-d').'" where or_no = '.$or_no;
		db_query($sql3);
		
		$config_voucher = find_a_field('voucher_config','direct_journal','voucher_type="'.$return_type.'"');

 
		sec_journal_journal($jv_no,$jv_no,'Other Receive');
 



	//auto_insert_sales_return_secoundary($chalan_no);

header('location:unapproved_pr.php');

//echo '<span style="color:green;">Purchase Return Approved</span>';
}
}


$table='purchase_return_master';
$show='vendor_id';
$id='pr_no';
$text_field_id='pr_no';

$target_url = 'return_checking.php';

$tr_from="Warehouse";
?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?or_no='+theUrl+'','_self');
}
</script>


<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


<?php /*?>div.form-container_large input {
    width: 90%;
    height: 38px;
    border-radius: 0px !important;
}<?php */?>



</style>



<div class="form-container_large">
   
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            

<div class="row">
    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> From Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="text" name="fdate" id="fdate"  value="<?=$_POST['fdate'] ? $_POST['fdate'] : date('Y-m-01') ?>" autocomplete="off"/>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate'] ? $_POST['tdate'] : date('Y-m-t') ?>" autocomplete="off" />

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
					<select name="group_for" id="group_for" style="width:280px;">			
							<? user_company_access($group_for); ?>
					</select>
		
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <? if($master_id==1){?>	
                      <select name="warehouse_id" id="warehouse_id" >
					  
					 

				 	<? user_warehouse_access($warehouse_id);?> 
 
                      </select>
					  
				<? }?>
					  
					  <? if($master_id==0){?>	
			
					  <select name="warehouse_id" id="warehouse_id" >
				

				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
 
                      </select>
					
				 <? }?>	 

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
        
        <input type="submit" name="submitit" id="submitit" value="VIEW PRODUCT" class="btn1 btn1-submit-input"/ >
    </div>
</div>


        </div>






            
        <div class="container-fluid pt-5 p-0 ">


                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                     <tr class="bgc-info">
            <th>Receive No</th>
            <th>Receive Date</th>
            <th>Receive To</th>
			<th>Approved By</th>
			<th>Action</th>
          </tr>
                    </thead>

                    <tbody class="tbody1">

                       <? 

							if(isset($_POST['submitit'])){
							
							 if($_POST['fdate']!='') {
								$con=' and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}else{$con=' and a.or_date between "'.date('Y-m-01').'"
and "'.date('Y-m-d').'"';}


							if($_POST['group_for']>0) {
								$con.=' and a.group_for="'.$_POST['group_for'].'"';}	
							if($_POST['warehouse_id']>0) {
								$con.=' and a.warehouse_id="'.$_POST['warehouse_id'].'"';}	
							
							 $res ='select a.or_no,a.or_date,a.entry_by,a.vendor_name,a.approved_by,a.or_date,u.fname,a.receive_type,a.warehouse_id

  from warehouse_other_receive a, user_activity_management u

  where a.entry_by=u.user_id and a.receive_type="Other Receive" and  a.status="UNCHECKED" '.$con.' order by a.or_no desc';
							$query = db_query($res);
							
							//$two_weeks = time() - 14*24*60*60;
							while($data = mysqli_fetch_object($query))
							{
							
							?>
							<tr>
							<td <?=$data->or_no;?>;" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->or_no;?></td>
							<td <?=$data->or_no;?>;" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?php echo date('d-m-Y',strtotime($data->or_date));?></td>
							<td <?=$data->or_no;?>;" <?=(++$z%2)?'':'class="alt"';?> style="text-align:center">&nbsp;<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$data->warehouse_id);?></td>
							<td <?=$data->or_no;?>;" <?=(++$z%2)?'':'class="alt"';?> style="text-align:center"><?=$data->approved_by;?></td>
							<td>
							
								<button  type="button" name="submitit" class="btn2 btn1-bg-submit" onClick="custom(<?=$data->or_no;?>);" <?=(++$z%2)?'':'class="alt"';?> >
									<i class="fa-solid fa-eye"></i>
								</button>
   
							  </td>
							</tr>
							
							<?
							$total_send_amt = $total_send_amt + $data->SEND_AMT;
							$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
							}
							}
							?>

                    </tbody>
                </table>





        </div>
    </form>
</div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>