<?php

session_start();



ob_start();




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Unfinished Daily Floor Requisition';

$tr_type="Show";

do_calander('#fdate');

do_calander('#tdate');

$table_master='production_issue_master';

$unique_master='pi_no';

$table_detail='production_issue_detail';

$unique_detail='id';

$$unique_master=$_POST[$unique_master];

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















if(isset($_POST['confirm']))















{







			$pi_no = $_GET['pi_no'];







			$req_no = $_GET['req_no'];























		$_POST[$unique_master]=$$unique_master;















		$_POST['entry_at']=date('Y-m-d H:i:s');















		$_POST['status']='COMPLETE';















		$crud   = new crud($table_master);







		$crud->update($unique_master);























$master= find_all_field('production_issue_master','d_price','pi_no='.$pi_no);















$sql3='select * from master_requisition_details where req_no='.$_GET['req_no'];















		$rs = db_query($sql3);







		while($row=mysqli_fetch_object($rs)){	







$issue_qty = $_POST['id'.$row->id];























db_query("UPDATE `production_issue_detail` SET `status` = 'COMPLETE',total_unit='".$issue_qty."' WHERE `req_id` = ".$row->id);







db_query("UPDATE `master_requisition_details` SET `status` = 'COMPLETE',qty='".$issue_qty."' WHERE `id` = ".$row->id);















		//journal_item_control($row->item_id ,$master->warehouse_from,$master->pi_date,0,$issue_qty,'Issue',$row->id,'',$master->warehouse_to,$req_no);







		//journal_item_control($row->item_id ,$master->warehouse_to  ,$master->pi_date,$issue_qty,'0','Issue',$row->id,'',$master->warehouse_from,$req_no);



		



		







		}







db_query("UPDATE `master_requisition_master` SET `status` = 'COMPLETE' WHERE `req_no` = ".$req_no);







		unset($$unique_master);







		unset($_POST[$unique_master]);







        unset($_SESSION[$unique_master]);







		$type=1;















		$msg='Successfully Send.';















}































auto_complete_start_from_db('warehouse','concat(warehouse_name,"-",use_type)','warehouse_id','use_type="PL"','line_id');









$tr_from="Warehouse";





?>















<script language="javascript">















window.onload = function() {document.getElementById("dealer").focus();}















</script>





















<div class="form-container_large">

   

    <form action="" method="post" name="codz" id="codz">

            

          <div class="container-fluid bg-form-titel">

    <div class="row">

	<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

        <div class="row">

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">

            <div class="form-group row m-0">

              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                		<input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" autocomplete="off" />

              </div>

            </div>





          </div>





          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">

            <div class="form-group row m-0">

              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-center align-items-center pr-1 bg-form-titel-text">To Date :</label>

              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

               <input type="text" name="tdate" id="tdate"  value="<?=$_POST['tdate']?>"  autocomplete="off" />



              </div>

            </div>



          </div>



        </div>







      </div>

	  

      <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">

        <div class="form-group row m-0">

          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Production Line :</label>

          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">

      <select name="req_for" id="req_for">

		  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],'use_type="SC"  order by warehouse_name');?>

		  <option value="" <?=($_POST['req_for']=='')?'Selected':'';?>>All</option>

	  </select>

          </div>

        </div>

      </div>



      





      <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center





">

	        <input type="submit" name="submitit" id="submitit" value="Create CMI" class="btn1 btn1-submit-input"/>

      </div>



    </div>

  </div>



            

        <div class="container-fluid pt-5 p-0 ">





<? 

if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['req_for']>0)

$con .= ' and a.req_for = "'.$_POST['req_for'].'"  ';



  $res='select p.pi_no,a.req_no,a.req_no,w.warehouse_name as req_for,a.manual_req_no,(Select b.fname from user_activity_management b where b.user_id=p.entry_by) as entry_by ,a.entry_at,p.status



from master_requisition_master a,warehouse w,production_issue_master p where  p.req_no=a.req_no and p.status = "MANUAL" and w.warehouse_id=a.req_for  '.$con.' group by p.pi_no order by a.req_no';

 //echo $res='select p.pi_no,a.req_no,a.req_no,w.warehouse_name as req_for,b.fname as entry_by ,a.entry_at,p.status

//from master_requisition_master a,user_activity_management b,warehouse w,production_issue_master p where p.req_no=a.req_no and p.`status` = "PENDING" and w.warehouse_id=a.req_for and b.user_id = a.entry_by';

?>



                <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info">

						<th>Req. No</th>

						<th>Req. For</th>

						 <th>Manual Req. For</th>

						<th>Entry By</th>

						<th>Entry At</th>

						<th>Status</th>

						<th>Show</th> 

                    </tr>

                    </thead>



                    <tbody class="tbody1">

					

						<? 

							$r=db_query($res);

							while($rs=mysqli_fetch_object($r)){

						?>

				

									<tr>

										<td><?=$rs->req_no?></td>

										<td><?=$rs->req_for?></td>

										<td><?=$rs->manual_req_no;?></td>

										<td><?=$rs->entry_by?></td>

										<td><?=$rs->entry_at?></td>

										<td><?=$rs->status?></td>

										<td><a href="../production_issue/production_issue_check.php?old_pi_no=<?=$rs->pi_no?>"><span class="btn1 btn1-bg-submit">Show</span></a></td>                    

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