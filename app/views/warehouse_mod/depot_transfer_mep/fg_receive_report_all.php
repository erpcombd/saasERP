<?php





require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Transfer Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'requisition_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = '../depot_transfer/print_view.php';

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+ encodeURIComponent(theUrl));
}
</script>










<div class="form-container_large">

	<form action="" method="post" name="codz" id="codz">

        <div class="container-fluid bg-form-titel">
            <div class="row">
    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                         <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']=='') echo date('Y-m-01'); else echo $_POST['fdate'];?>" />
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">-To-</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="text" name="tdate" id="tdate" value="<? if($_POST['tdate']=='') echo date('Y-m-d'); else echo $_POST['tdate'];?>" />

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Transfer Status : </label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
        <select name="status" id="status" style="width:200px;">
		<option></option>
		<option <? if($_POST['status']=='IN TRANSIT') echo 'Selected';?>>IN TRANSIT</option>
		<!--<option <? if($_POST['status']=='TRANSFERED') echo 'Selected';?>>TRANSFERED</option>-->
		<!--<option <? if($_POST['status']=='ALL SEND')   echo 'Selected';?>>ALL SEND</option>-->
      </select>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Inventory:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <select name="depot" id="depot" style="width:200px;">
<option></option>

<? foreign_relation('warehouse w, warehouse_define d','w.warehouse_id','w.warehouse_name',$_POST['depot'],'1 and w.warehouse_id=d.warehouse_id and d.user_id="'.$_SESSION['user']['id'].'" order by w.warehouse_name');?>
</select>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
		<input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
    </div>
</div>
        </div>



<div class="container-fluid pt-5 p-0 ">
		
<? 

if($_POST['fdate']!='' && $_POST['tdate']!=''){ $con .= ' and a.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"'; 
if($_POST['status']=='IN TRANSIT') $con.=' and a.status="SEND"'; 

if($_POST['depot']!='' && $_POST['depot']!='ALL') {$con.=' and a.warehouse_from="'.$_POST['depot'].'"';

}else{

$wh_sql="SELECT GROUP_CONCAT(DISTINCT w.warehouse_id) as defined_wh FROM warehouse_define w where w.user_id='".$_SESSION['user']['id']."'  ";
	 
	 $wh_conn=db_query($wh_sql);
	 
	 $data=mysqli_fetch_object($wh_conn);
	 
	 if($data->defined_wh !=''){
	 	$con = ' and a.warehouse_to in ('.$data->defined_wh.','.$_SESSION['user']['depot'].') ';

}else{

$con = ' and a.warehouse_from in ('.$_SESSION['user']['depot'].') ';

}
}

 $res='select a.pi_no,a.pi_no, a.pi_date, a.remarks as sl_no, a.carried_by,a.entry_at,u.fname as entry_by, a.warehouse_to

from user_activity_management u, fg_issue_master a, fg_issue_detail d

where a.entry_by=u.user_id  and a.status not in("MANUAL") and d.pi_no=a.pi_no '.$con.' group by a.pi_no order by a.pi_no desc';

//echo link_report($res,'print_view.php');
$query = db_query($res);
?>
                
				<table class="table1 table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SL</th>
                        <th>Pi No</th>
                        <th>Pi Date</th>
                        <th>Depot To</th>
                        <th>Carried By</th>
                        <th>Entry At</th>

                        <th>Entry By</th>
                        <th>Action</th>
                    </tr>
                </thead>

                    <tbody class="tbody1">
					<?
					$i=1;
					while($row = mysqli_fetch_object($query)){
					?>


                        <tr>
                            <td><?=$i++?></td>
                            <td><?=$row->pi_no?></td>
                            <td><?=$row->pi_date?></td>
                            <td><?=find_a_field('warehouse','warehouse_name','  warehouse_id="'.$row->warehouse_to.'" ');?></td>
                            <td><?=$row->carried_by?></td>
                            <td><?=$row->entry_at?></td>

                            <td><?=$row->entry_by?></td>
							
                            <td>
								<input type="button" name="submitit" id="submitit" value="VIEW" class="btn1 btn1-submit-input" onclick="custom('<?=url_encode($row->pi_no);?>');" />
							</td>

                        </tr>
					<? }?>

                    </tbody>
                </table>


<? }?>


      </div>
    </form>
</div>


















<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>