<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$c_id = $_SESSION['proj_id'];
$title='Daily Floor Requisition Report';



do_calander('#fdate');

do_calander('#tdate');

$tr_type="Show";

$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../production_issue/production_issue_report.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}

$tr_from="Warehouse";

?>

<script language="javascript"> 
function custom(theUrl,c_id){
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
}
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
                          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=date('Y-m-01')?>" />
              </div>
            </div>


          </div>


          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-center align-items-center pr-1 bg-form-titel-text"> To Date : </label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                         <input type="text" name="tdate" id="tdate" style="width:80px; " value="<?=date('Y-m-d')?>" />

              </div>
            </div>

          </div>

        </div>



      </div>
	  
      <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
        <div class="form-group row m-0">
          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Section For :  </label>
          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
      	  	<select name="req_for" id="req_for">
			<option></option>
			<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],' use_type="PL"');?>
			</select>
          </div>
        </div>
      </div>

      


      <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center

">
	    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
      </div>

    </div>
  </div>
    </form>
	            
        <div class="container-fluid pt-2 p-0 tabledesign2">

<!--                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                    </tr>
                    </thead>

                    <tbody class="tbody1">		   
                    </tbody>
                </table>-->

					
					<? 
					if(isset($_POST['submitit'])){
					
					if($_POST['fdate']!=''&&$_POST['tdate']!='')
					
					$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
					
					if($_POST['req_for']>0)
					$con .= 'and a.req_for = "'.$_POST['req_for'].'"  ';
					
					//<!--select a.req_no,a.req_no,w.warehouse_name as req_for,a.manual_req_no , b.fname as entry_by ,a.entry_at,a.status from master_requisition_master a,user_activity_management b,warehouse w where a.status in ("UNCHECKED") and w.warehouse_id=a.req_for and b.user_id = a.entry_by-->
					
					
					
					$res='select a.req_no,a.req_no,a.manual_req_no,a.req_date,(select warehouse_name from warehouse where warehouse_id=a.req_for) as req_for,c.warehouse_name as issue_to, a.status,a.entry_at,u.fname as user from master_requisition_master a, master_requisition_details b, warehouse c, user_activity_management u where a.req_no=b.req_no and a.warehouse_id=c.warehouse_id and a.entry_by=u.user_id and c.warehouse_id = "'.$_SESSION['user']['depot'].'" and a.status in ("UNCHECKED","RECEIVE") '.$con.' group by a.req_no order by a.req_no desc';
					
					echo link_report2($res,'production_issue_report.php',$c_id);
					
					
					
					}
					
					?>


        </div>

</div>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>