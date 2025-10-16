<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Finish Goods Receive Status';

do_calander('#fdate');
do_calander('#tdate');
$tr_type="Show";
$table = 'requisition_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = '../SCS/print_view_receive.php';
$tr_from="Warehouse";
?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
}
</script>










<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
          <div class="container-fluid bg-form-titel">
        <div class="row">
		<div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 row">
			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Form Date:</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
					 <input type="text" name="fdate" id="fdate" style="width:80px;" value="<? if($_POST['fdate']=='') echo date('Y-m-01'); else echo $_POST['fdate'];?>" />
				  </div>
				</div>
	
			  </div>
			 
			 <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Transfer Status :</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
				  <select name="status" id="status" style="width:200px;">
		<option <? if($_POST['status']==''||$_POST['status']=='IN TRANSIT') echo 'Selected';?>>IN TRANSIT</option>
		<option <? if($_POST['status']=='TRANSFERED') echo 'Selected';?>>TRANSFERED</option>
		<option <? if($_POST['status']=='ALL SEND') echo 'Selected';?>>ALL SEND</option>
      </select>
				  </div>
				</div>
	
			  </div>
			  
			  
			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> To Date :</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
					 <input type="text" name="tdate" id="tdate" style="width:80px;" value="<? if($_POST['tdate']=='') echo date('Y-m-d'); else echo $_POST['tdate'];?>" />	
				  </div>
				</div>
			  </div>
			  

			  
			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sending Inventory :</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						<select name="depot" id="depot" style="width:200px;">
						<option></option>
						<option value="5">HFL</option>
						<? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'1 and use_type="SD" order by warehouse_name');?>
						</select>			
							
				  </div>
				</div>
			  </div>
			  
		</div>
		
          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
		  <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL"  class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>

            
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
					if($_POST['depot']!=''&&$_POST['depot']!='ALL')
					$con .= 'and a.warehouse_from="'.$_POST['depot'].'"';
					
					if($_POST['fdate']!=''&&$_POST['tdate']!='')
					$con .= 'and a.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
					
					if($_POST['status']==''||$_POST['status']=='IN TRANSIT')
					$con .=  'and a.status="SEND"';
					elseif($_POST['status']==''||$_POST['status']=='TRANSFERED')
					$con .=  'and a.status!="SEND"';
					else
					{$do = 'nothing';}
					
					
					
					$res='select  	a.pi_no,a.pi_no, a.pi_date,  b.warehouse_name as Depot_from, a.remarks as sl_no, a.carried_by,a.entry_at,u.fname as entry_by 
					from user_activity_management u, production_issue_master a,warehouse b , production_issue_detail d
					where a.pi_no=d.pi_no and a.warehouse_to='.$_SESSION['user']['depot'].' and a.entry_by=u.user_id 
					and a.warehouse_from=b.warehouse_id 
					and a.warehouse_to="'.$_SESSION['user']['depot'].'" 
					and b.use_type!="PL" '.$con.' 
					group by a.pi_no order by a.pi_no desc';
					
					echo link_report($res,'print_view.php');
					?>


        </div>
    </form>
</div>








<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>