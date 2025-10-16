<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$c_id = $_SESSION['proj_id'];

$title='All Issue Report';



do_calander('#fdate');

do_calander('#tdate');

$tr_type="Show";

$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../other_issue/other_issue_report.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}


$tr_from="Warehouse";
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
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<?=date('Y-m-01')?>" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=date('Y-m-d')?>" />
                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
                    <input type="submit" name="submitit" id="submitit" value="VIEW PRODUCT" class="btn1 btn1-submit-input"/ >
                </div>

            </div>
        </div>

      <!--Table start-->
      <div class="container-fluid pt-5 p-0 ">

          <?

          if(isset($_POST['submitit'])){





              $con .= 'and a.oi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



              $res='select  a.oi_no,a.oi_no,a.oi_date, a.status,a.oi_subject as serial,a.issued_to as issue_to,a.issue_type,sum(amount) as Total,a.entry_at,c.fname as user

from warehouse_other_issue a, warehouse_other_issue_detail b, user_activity_management c

where (a.issue_type = "Sample Issue" or a.issue_type = "Other Issue" or a.issue_type = "Gift Issue" or a.issue_type = "Entertainment Issue") and a.oi_no=b.oi_no and a.entry_by=c.user_id and a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' group by a.oi_no order by a.oi_no desc';


//echo link_report($res,'other_issue_report.php');

              $query = db_query($res);

              ?>

              <table class="table1  table-striped table-bordered table-hover table-sm">
                  <thead class="thead1">
                  <tr class="bgc-info">
                      <th>Oi No</th>
                      <th>Oi Date</th>
                      <th>Status</th>
                      <th>Issue To</th>

                      <th>Issue Type</th>
                      <th>Total </th>
                      <th>Entry At </th>
                      <th>User </th>
                      <th>Action </th>
                  </tr>
                  </thead>

                  <tbody class="tbody1">

                  <?
                  while($row = mysqli_fetch_object($query)){
                      ?>
                      <tr>
                          <td><?=$row->oi_no?></td>
                          <td><?=$row->oi_date?></td>
                          <td><?=$row->status?></td>
                          <td><?=$row->issue_to ?></td>

                          <td><?=$row->issue_type ?></td>
                          <td><?=$row->Total?></td>
                          <td><?=$row->entry_at?></td>
                          <td><?=$row->user?></td>
                          <td><input type="submit" name="submitit2" id="submitit2" value="VIEW" class="btn1 btn1-submit-input" onclick="custom('<?=url_encode($row->oi_no);?>','<?=url_encode($c_id);?>');" /></td>
                      </tr>

                  <? } ?>
                  </tbody>
              </table>

          <? } ?>

      </div>

  </form>


</div>








<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>