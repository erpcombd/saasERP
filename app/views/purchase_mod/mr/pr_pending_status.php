<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$c_id = $_SESSION['proj_id'];

$tr_type="Show";
$title='PR Pending';

do_calander('#fdate');

do_calander('#tdate');

$table = 'requisition_master';

$unique = 'req_no';

$status = 'UNCHECKED';

$target_url = '../mr/mr_print_view.php';


if($_GET['vStatus']>0){

$status=find_a_field('requisition_master','status','req_no='.$_GET['vStatus']);

if($status=="CHECKED" && $_GET['status']=="CHECKED"){ db_query('update requisition_master set status="COMPLETED" where req_no='.$_GET['vStatus'].'');}



echo "<script>window.top.location='pr_pending_status.php'</script>";
}

$tr_from="Purchase";
?>

<script language="javascript">

function custom(theUrl,c_id)
{
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
}

</script>

<div class="form-container_large">

    

    <form action="" method="post" name="codz" id="codz">

            <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> From Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
             <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req Status :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
                            <select name="status" id="status">

								<option></option>

								<option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option>

								<option <?=($_POST['status']=='COMPLETED')?'selected':''?>>COMPLETED</option>

							</select>
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 pt-1 pb-1">
                    <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            					  
					  	
                            <select name="warehouse_id" id="warehouse_id">

								<option></option>
								<? user_warehouse_access($depot_id);?>

							</select>

                        </div>
                    </div>
                </div>
				
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 pt-1 pb-1">
                    <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req No :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            					  
					  		<input type="text" list="req" name="req_no" id="req_no"  />
                            <datalist id="req">

								<option></option>
								<? foreign_relation('requisition_master','req_no','req_no',$_POST['req_no'],'status="CHECKED"');?>

							</datalist>

                        </div>
                    </div>
                </div>

            </div>
			    <div align="center">
                     <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
                </div>
        </div>
		
        <div class="container-fluid pt-5 p-0 ">



                <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info">

                        <th>Req No</th>

                        <th width="10%">Req Date</th>

                        <th>Req For</th>



                        <th>Warehouse </th>

                        <th>Note</th>

                        <th>Need By</th>



                        <th>Entry At</th>

						<th>Entry By</th>

						<th>Status</th>

						<th>View</th>
						
						<th>Status Update</th>

                        

                    </tr>

                    </thead>



                    <tbody class="tbody1">

						<? 

								if(isset($_POST['submitit']))
								{

								if($_POST['status']!='')
								{

							$con .= ' and a.status="'.$_POST['status'].'"';

								}

						if($_POST['fdate']!=''&& $_POST['tdate']!='')
						{

				$con2 .= ' and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
				
				}
				
				if($_POST['warehouse_id']!='')
								$con .= 'and a.warehouse_id = "'.$_POST['warehouse_id'].'"';

				if($_POST['req_no']!='')
								$con .= 'and a.req_no = "'.$_POST['req_no'].'"';


  $res='select  a.req_no,a.req_no, a.req_date, a.req_for, b.warehouse_name as warehouse, a.req_note as note, a.need_by,a.vendor_status, a.entry_at,a.status,a.entry_by
 
 from requisition_master a,warehouse b
 
 where  a.warehouse_id=b.warehouse_id  and  a.status in ("CHECKED","COMPLETED")  '.$con.$con2.'  order by a.req_no desc';

								

								$query=db_query($res);

								

								While($row=mysqli_fetch_object($query)){

								?>

                        <tr>

                            <td><?=$row->req_no?></td>

                            <td><?=$row->req_date?></td>

                            <td><?=$row->req_for?></td>



                            <td><?=$row->warehouse?></td>

                            <td><?=$row->note?></td>

                            <td><?=$row->need_by?></td>

							<td><?=$row->entry_at?></td>

							<td><?=find_a_field('user_activity_management','username','user_id='.$row->entry_by);?></td>

							<td><?=$row->status?></td>


                            <?php /*?><td><button type="button" onclick="custom('<?=url_encode($row->req_no);?>')" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td><?php */?>
							
	<td>
  <button type="button" onclick="custom('<?=url_encode($row->req_no);?>', '<?=url_encode($c_id);?>')" class="btn2 btn1-bg-submit">
    <i class="fa-solid fa-eye"></i>
  </button>
</td>

							
							
<td><a href="?vStatus=<?=$row->req_no?>&&status=<?=$row->status?>"

<?=($row->status)=='CHECKED'? 'data-toggle="tooltip" data-placement="bottom" title="Make Expired"':''?> 

class="<?=($row->status)=='CHECKED'?'btn btn-sm btn-warning':(($row->status)=='CHECKED'?'btn btn-sm btn-success':'disabled')?>" >COMPLETED</a></td>



                        </tr>

							<? 

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

