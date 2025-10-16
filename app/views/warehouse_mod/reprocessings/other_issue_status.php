<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Kit Pack Reprocessing Status';

do_calander('#fdate');
do_calander('#tdate');
$tr_type="Show";
$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../reprocessing/other_issue_report.php';

if($_REQUEST[$unique]>0)
{
$_SESSION[$unique] = $_REQUEST[$unique];
header('location:'.$target_url);
}
$tr_from="Warehouse";
?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>



<div class="form-container_large">
    
    <form action="" method="post" name="codz" id="codz">
           
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
               <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date: </label>
                     <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate" value="<?=date('Y-m-01')?>" />
                        </div>
                  </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                 <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate" value="<?=(isset($_POST['tdate']))?$_POST['tdate']:date('Y-m-d')?>" />

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
                    <input type="submit" name="submitit" id="submitit" class="btn1 btn1-submit-input" value="VIEW DETAIL" />
                </div>

            </div>
        </div>
        <div class="container-fluid pt-5 p-0 ">

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>OI No</th>
                        <th>OI Date</th>
                        <th>Serial</th>

                        <th>Issue To</th>
                        <th>Issue Type</th>
                        <th>Total</th>

                        <th>Entry At</th>
                        <th>Entry By</th>
                        <th>Status</th>
						 <th>Action</th>
                    </tr>
                    </thead>
							
                    <tbody class="tbody1">
					<? 
							if(isset($_POST['submitit'])){


$con .= 'and a.oi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

$res='select  a.oi_no,a.oi_no,a.oi_date,a.oi_subject as serial,a.issued_to as issue_to,a.issue_type,sum(amount) as Total,a.entry_at,c.fname as user,a.status 
from warehouse_other_issue a, warehouse_other_issue_detail b, user_activity_management c
where  a.issue_type = "Reprocess Issue" and a.status="UNCHECKED" and a.oi_no=b.oi_no and a.entry_by=c.user_id and a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' group by a.oi_no order by a.oi_no desc';

							$query=db_query($res);
							
							while($data=mysqli_fetch_object($query)){
							
							?>

                        <tr>
                            <td><?=$data->oi_no ?></td>
                            <td><?=$data->oi_date ?></td>
							<td><?=$data->serial ?></td>
							<td><?=$data->issue_to ?></td>
							<td><?=$data->issue_type ?></td>
							<td><?=$data->Total ?></td>
							<td><?=$data->entry_at ?></td>
							<td><?=$data->user ?></td>
							<td><?=$data->status?></td>
                            <td><button type="submit" onclick="custom(<?=$data->oi_no ?>)" class="btn1 btn1-bg-submit">VIEW</button></td>

                        </tr>
							<? } ?>
							
							
							<? } ?>
                    </tbody>
                </table>





        </div>
    </form>
</div>


<?php /*?><div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:100px;" value="<?=date('Y-m-01')?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:100px;" value="<?=(isset($_POST['tdate']))?$_POST['tdate']:date('Y-m-d')?>" />
        </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){


$con .= 'and a.oi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

$res='select  a.oi_no,a.oi_no,a.oi_date,a.oi_subject as serial,a.issued_to as issue_to,a.issue_type,sum(amount) as Total,a.entry_at,c.fname as user,a.status 
from warehouse_other_issue a, warehouse_other_issue_detail b, user_activity_management c
where  a.issue_type = "Reprocess Issue" and a.status="UNCHECKED" and a.oi_no=b.oi_no and a.entry_by=c.user_id and a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' group by a.oi_no order by a.oi_no desc';


echo link_report($res,'other_issue_report.php');

}
?>
</div></td>
</tr>
</table>
</div><?php */?>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>