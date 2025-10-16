<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='New Daily Floor Requisition ';



do_calander('#fdate');

do_calander('#tdate');



$table_master='production_issue_master';



$unique_master='pi_no';

$table_detail='production_issue_detail';



$unique_detail='id';

$tr_type="Show";



$$unique_master=$_POST[$unique_master];



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



if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='PENDING';

		$crud   = new crud($table_master);

		$crud->update($unique_master);

		$pi_no = $_GET['pi_no'];

		$req_no = $_GET['req_no'];

		$master= find_all_field('production_issue_master','d_price','pi_no='.$pi_no);

		 $sql3='select * from master_requisition_details where req_no='.$_GET['req_no'];

		$rs = db_query($sql3);

		while($row=mysqli_fetch_object($rs)){





		    $issue_qty = $_POST['id'.$row->id];
			
			if($issue_qty>0){


  $r = "INSERT INTO `production_issue_detail` (`pi_no`, `req_no`, `req_id`, `pi_date`, `item_id`, `warehouse_from`, `warehouse_to`, `req_qty`,`total_unit`, `unit_price`, `total_amt`, `old_production_date`, `status`) VALUES 


('".$pi_no."', '".$req_no."', '".$row->id."', '".$master->pi_date."', '".$row->item_id."', '".$master->warehouse_from."', '".$master->warehouse_to."', '".$row->order_qty."','".$issue_qty."', '".$row->rate."', '0', '', 'PENDING')";

db_query($r);

}






$xid= db_insert_id();



journal_item_control($row->item_id ,$master->warehouse_from,$master->pi_date,0,$issue_qty,'Issue',$xid,'',$master->warehouse_to,$_POST['remarks']);

//journal_item_control($row->item_id ,$master->warehouse_to,$master->pi_date,$issue_qty,'0','Issue',$xid,'',$master->warehouse_from,$_POST['remarks']);







db_query("UPDATE `master_requisition_details` SET `status` = 'PENDING',qty='".$issue_qty."' WHERE `id` = ".$row->id);







		}







db_query("UPDATE `master_requisition_master` SET `status` = 'PENDING' WHERE `req_no` = ".$req_no);







		unset($$unique_master);







		unset($_POST[$unique_master]);







        unset($_SESSION[$unique_master]);







		$type=1;







		$msg='Successfully Send.';







}



}





if(isset($_POST['return']))







{



		$pi_no = $_GET['pi_no'];

		$req_no = $_GET['req_no'];









db_query("UPDATE `master_requisition_master` SET `status` = 'MANUAL' WHERE `req_no` = ".$req_no);







		$type=1;



		$msg='Successfully Send.';



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















$tr_from="Warehouse";



?>







<script language="javascript">







window.onload = function() {document.getElementById("dealer").focus();}







</script>



























<div class="form-container_large">

   

    <form  action="" method="post" name="codz" id="codz">

            

          <div class="container-fluid bg-form-titel">

    <div class="row">

	<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

        <div class="row">

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">

            <div class="form-group row m-0">

              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                	<input type="text" name="fdate" id="fdate" autocomplete="off" value="<?=$_POST['fdate']?>" />

              </div>

            </div>





          </div>





          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">

            <div class="form-group row m-0">

              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-center align-items-center pr-1 bg-form-titel-text">To Date:</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8  p-0">

               <input type="text" name="tdate" id="tdate"  autocomplete="off"value="<?=$_POST['tdate']?>" />



              </div>

            </div>



          </div>



        </div>



      </div>

	  

      <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

        <div class="form-group row m-0">

          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Production Line :</label>

          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

      	  <select name="req_for" id="req_for" >

			  <option value="">All</option>

			  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],'use_type="PL"');?>

		  </select>

          </div>

        </div>

      </div>



      





      <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">

      		<input type="submit" name="submitit" id="submitit" value="SHOW" class="btn1 btn1-submit-input"/>

      </div>



    </div>

  </div>



            

        <div class="container-fluid pt-5 p-0 ">



<? 

if($_POST['fdate']!=''&&$_POST['tdate']!='')



$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['req_for']>0)

$con .= 'and a.req_for = "'.$_POST['req_for'].'"  ';



$res='select a.req_no,a.req_no,a.req_for,w.warehouse_name as req_for,a.manual_req_no , b.fname as entry_by ,a.entry_at,a.status 



from master_requisition_master a,user_activity_management b,warehouse w 



where a.status  in ("UNCHECKED") '.$con.'  and w.warehouse_id=a.req_for and b.user_id = a.entry_by ';



?>





                <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info">

						<th>S/L</th>

						<th>Req. No</th>

						<th>Auto Req No</th>

						<th>Req. For</th>

						<th>Entry By</th>

						<th>Entry At</th>

						<th>Status</th>

						<th>Show</th>          

                    </tr>

                    </thead>



                    <tbody class="tbody1">

					

							 <? 

								$r=db_query($res);

								$sl=1;

								while($rs=mysqli_fetch_object($r)){

							?>

					

										<tr>

											<td><?=$sl++?></td>

											<td><?=$rs->req_no?></td>

											<td><?=$rs->manual_req_no?></td>

											<td><?=$rs->req_for?></td>

											<td><?=$rs->entry_by?></td>

											<td><?=$rs->entry_at?></td>

											<td><?=$rs->status?></td>

											<td>

												<?

												if($rs->status=="COMPLETE"){

												?>

												<a target="_blank" href="../production_issue/production_issue_report.php?v_no=<?=$rs->req_no?>&req_status=<?=$rs->status?>"><span><strong>Complete</strong></span></a>

												<?

												}else{

												?>

												<a href="../production_issue/production_issue.php?req=<?=$rs->req_no?>"><span class="btn1 btn1-submit-input">Show</span></a>

												<?

												}

												?>

					

											</td>

										</tr>

					

					

					

							<? } ?>

			   

                    </tbody>

                </table>



        </div>

    </form>

</div>









<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>