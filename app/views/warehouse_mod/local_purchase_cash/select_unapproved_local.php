<?php


session_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Unapproved Local Purchase';

do_calander('#fdate');
do_calander('#tdate');

$table = 'warehouse_other_receive';
$unique = 'or_no';
$status = 'UNCHECKED';
$target_url = 'local_purchase_approval.php';


$tr_type="Show";
?>
<script language="javascript">
function custom(theUrl)
{
  
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl+'','_self');
	//window.open('<?=$target_url?>');
}
</script>


<div class="form-container_large">
    
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />
    </strong></td>
                        </div>
                    </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />
                        </div>
                    </div>

                </div>
  

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
					<input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input" />
                    
                </div>

            </div>
        </div>






            
        <div class="container-fluid pt-5 p-0 ">

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>OR No</th>
                        <th width="9%">OR Date</th>
                       

                        <th>Requisition Number </th>
                        <th>Created By</th>
                        <th>Entry At</th>
						<th>Status</th>

                        <th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
						<? 

						
							
							if($_POST['fdate']!=''&&$_POST['tdate']!='')
							$con .= 'and p.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
							
							 $res='select p.or_no,p.or_date,p.req_no,w.warehouse_name,u.fname as created_by,p.entry_at,p.status 
						from  warehouse_other_receive p, user_activity_management u, warehouse w 
						where p.warehouse_id=w.warehouse_id  and u.user_id=p.entry_by and p.receive_type="Local Purchase" and
						p.status="UNCHECKED" '.$con. ' order by p.or_no desc';
								
								$query=db_query($res);
								
								While($row=mysqli_fetch_object($query)){
								
								
								?>
                        <tr>
                            <td><?=$row->or_no?></td>
                            <td><?=$row->or_date?></td>
                           

                            <td style="text-align:left"><?=$row->req_no?></td>
                            <td><?=$row->created_by?></td>
                            <td><?=$row->entry_at?></td>
							<td><?=$row->status?></td>

                            
                            <td><button type="button" onclick="custom(<?=$row->or_no?>)" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>

                        </tr>
							<? 
							}
							?>
                    </tbody>
                </table>





        </div>
    </form>
</div>





<?
$tr_from="Purchase";
require_once SERVER_CORE."routing/layout.bottom.php";
?>