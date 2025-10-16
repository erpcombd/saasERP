<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='WIP Issue';

unset($_SESSION['req_no']); 

$table_master='production_issue_master';



$unique_master='pi_no';



$table_detail='production_issue_detail';



$unique_detail='id';



$$unique_master=$_POST[$unique_master];


function next_journal_journal_voucher_id($date=''){

if($date==''){
$min = date("Ymd")."0000";
$max = $min+10000;
}else{
	$min = date("Ymd",strtotime($date))."0000";
	$max = $min+10000;
}

$s ="select MAX(jv_no) jv_no from journal where jv_no between '".$min."' and '".$max."'";
			$jv_no=@mysqli_fetch_row(db_query($s));
			if($jv_no[0]>$min)
				$jv=$jv_no[0]+1;
			else
				$jv=$min+1;
			return $jv;
}
	
	

if(isset($_POST['delete']))



{



$crud   = new crud($table_master);



$condition=$unique_master."=".$$unique_master;		



$crud->delete($condition);



$crud   = new crud($table_detail);



$crud->delete_all($condition);



$sql = "update master_requisition_master set status ='ISSUE RETURN' where req_no ='".$_GET['req_no']."'";



db_query($sql);



$sql2 = "DELETE FROM `production_issue_master` WHERE req_no=".$_GET['req_no']."";



db_query($sql2);



$sql3 = "DELETE FROM `production_issue_detail` WHERE req_no=".$_GET['req_no']."";



db_query($sql3);





unset($$unique_master);



unset($_POST[$unique_master]);

unset($_POST);





$type=1;



$msg='Successfully Deleted.';



}

if(prevent_multi_submit()){

if(isset($_POST['confirm']))



{



$pi_no = $_GET['pi_no'];



$req_no = $_GET['req_no'];



$_POST[$unique_master]=$$unique_master;



$_POST['entry_at']=date('Y-m-d H:s:i');



$_POST['status']='RECEIVE';



$crud   = new crud($table_master);



$crud->update($unique_master);



//$sql = "update master_requisition_master set status ='COMPLETE' where req_no ='".$_GET['req_no']."'";



//db_query($sql);



 $sqlrb='select * from master_requisition_master where req_no='.$req_no;

     $rsrb = db_query($sqlrb);

	 $rowrb=mysqli_fetch_object($rsrb);

	 

$master= find_all_field('production_issue_master','d_price','pi_no='.$pi_no);



$sql3='select * from master_requisition_details where journal=0 and req_no='.$req_no;



$rs = db_query($sql3);



//while($row=mysqli_fetch_object($rs)){
//
//
//
////////////////-------------journal corntrol for OThers production receive-----------------------/////////////////
//
//$status= find_a_field('master_requisition_details','journal','id='.$row->id);
//
//
//
//if( $status==0){	   
//
//if($rowrb->req_type=='Others'){	
//
//		
//if($row->qty >0){
//          journal_item_control($row->item_id ,$master->warehouse_from,$master->pi_date,0,$row->qty,'Issue',$row->id,$row->rate,$master->warehouse_to,$req_no);
//
//}
//
//
//
////////////////-------------journal for DSTR production receive-----------------------/////////////////
//
//}
//
//else{
//
//
//if($row->qty >0){
//	journal_item_control($row->item_id ,$master->warehouse_from,$master->pi_date,0,$row->qty,'Issue',$row->id,$row->rate,$master->warehouse_to,$req_no);
//	journal_item_control($row->item_id ,$master->warehouse_to,$master->pi_date,$row->qty,'0','Issue',$row->id,$row->rate,$master->warehouse_from,$req_no);
//}
//
//}
//
//
//
//db_query("UPDATE `production_issue_detail` SET `status` = 'RECEIVE',total_unit='".$row->qty."' WHERE `req_id` = ".$row->id);
//
//
//
//db_query("UPDATE `master_requisition_details` SET `status` = 'RECEIVE',qty='".$row->qty."',journal=1 WHERE `id` = ".$row->id);
//
//}
//
//}



//$jv=next_journal_voucher_id('','Issue');
//
//
//$wip_ledger = find_a_field('config_group_class','wip_ledger','1 and group_for='.$_SESSION['user']['group']);
//
//
//
//$sql4 ='SELECT r.item_id ,i.item_name,s.sub_group_name,s.item_ledger,rr.req_type,r.qty,rr.req_date
//
//FROM master_requisition_details r,master_requisition_master rr,item_info i,item_sub_group s 
//
//WHERE r.req_no="'.$req_no.'" and  rr.req_no=r.req_no and i.item_id=r.item_id and i.sub_group_id=s.sub_group_id ';
//
//
//
//$result = db_query($sql4);


//
//while($roww=mysqli_fetch_object($result)){
//
//
//
//if($roww->req_type=='Others'){
//                //////////////-------------journal for Others production receive-----------------------/////////////////
//				
//$final_price=find_a_field('journal_item','final_price',' 1 and final_price>0 and item_id="'.$roww->item_id.'" order by id desc');
//
//
//
//$final_amt = $final_price * $roww->qty;
//
//
//
//$req_date = strtotime($roww->req_date);
//
//
//if($final_amt>0){
//$test="INSERT INTO `secondary_journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `user_id`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL, 'Alinfoods', '".$jv."', '".strtotime($master->pi_date)."', '".$roww->purpose."', 'REQ#".$req_no."(PI#".$pi_no.") item id-".$roww->item_id."', '".$final_amt."', '0.00', 'Issue', '".$req_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')";
////db_query($test);
//
//
//
////db_query("INSERT INTO `secondary_journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `user_id`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL, 'Alinfoods', '".$jv."', '".strtotime($master->pi_date)."', '".$roww->ledger_id."', 'REQ#".$req_no."(PI#".$pi_no.") item id-".$roww->item_id."', '0.00','".$final_amt."',  'Issue', '".$req_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')");
//
//
//
//$final_amt =0;				
//
//}
//
//
//
//
//
//}
//
//elseif($roww->req_type=='DSTR'){
//
//
//
//
//
////////////////-------------journal for DSTR production receive-----------------------/////////////////
//
//
//$final_price=find_a_field('journal_item','final_price',' 1 and final_price>0 and item_id="'.$roww->item_id.'" order by id desc');
//
//
//
//$final_amt = $final_price * $roww->qty;
//
//
//
//$req_date = strtotime($roww->req_date);
//
//if($final_amt>0){
//
//$test="INSERT INTO `secondary_journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `entry_by`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL,'".$_SESSION['proj_id']."', '".$jv."', '".$master->pi_date."', '".$wip_ledger."', 'REQ#".$req_no."(PI#".$pi_no.") item id-".$roww->item_id."', '".$final_amt."', '0.00', 'Issue', '".$req_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')";
//
//
//
//db_query($test);
//
//
//
//db_query("INSERT INTO `secondary_journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `entry_by`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL,'".$_SESSION['proj_id']."', '".$jv."', '".$master->pi_date."', '".$roww->item_ledger."', 'REQ#".$req_no."(PI#".$pi_no.") item id-".$roww->item_id."', '0.00','".$final_amt."',  'Issue', '".$req_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')");
//
//
//
//
//
//
//    $tr_froms = "Issue";
//	sec_journal_journal($jv,$jv,$tr_froms);
//
//
//
//$final_amt =0;
//
//
//}
//
//
//
//
//}
//
//
//                    //////////////-------------journal for other production receive-----------------------/////////////////
//
//else{
//
//	
//
//	$msg='No Journal Created';
//
//}
//
//}



 //$sqUp = "UPDATE `master_requisition_master` SET `status` = 'RECEIVE' WHERE `req_no` = ".$req_no;
//db_query($sqUp);
//
//db_query("UPDATE `production_issue_master` SET `status` = 'RECEIVED'  WHERE `pi_no` = ".$pi_no);


unset($$unique_master);



unset($_POST[$unique_master]);



unset($_SESSION[$unique_master]);



$type=1;



$msg='Successfully Send.';



}

}

auto_complete_start_from_db('warehouse','concat(warehouse_name,"-",use_type)','warehouse_id','use_type="PL"','line_id');



?>



<script language="javascript">



window.onload = function() {document.getElementById("dealer").focus();}



</script>



	<div class="form-container_large">

		<form action="mr_create.php" method="post" name="codz" id="codz">

			<div class="container-fluid bg-form-titel">
				<div class="row">

					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
						<div class="form-group row m-0">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Select From Warehouse:	</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">


								<select name="from_warehouse_id" id="from_warehouse_id" required>
								<option></option>
									<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouseId'],'1 and use_type="SC" order by warehouse_name');?>

								</select>




							</div>
						</div>
					</div>

					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						<input type="submit" name="submitit" id="submitit" value="Create" class="btn1 btn1-submit-input"/>

					</div>

				</div>
			</div>


		</form>



</div>



<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>