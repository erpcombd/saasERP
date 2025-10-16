<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Bill Status';

do_calander('#fdate');
do_calander('#tdate');
$tr_type="Show";
$table = 'warehouse_other_issue';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = 'invoice_print_view.php';
  $user_all=find_all_field('user_activity_management','*','user_id="'.$_SESSION['user']['id'].'"');
 if($_SESSION['user']['id']!=10001){
 $cus_con='and customer="'.$user_all->organization.'"';
 }
if($_REQUEST[$unique]>0)
{
$_SESSION[$unique] = $_REQUEST[$unique];
header('location:'.$target_url);
}
$tr_from="Sales";
?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?bill_no='+theUrl);
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
                <input type="text" name="fdate" id="fdate" value="<?=date('Y-m-01')?>" />
              </div>
            </div>

          </div>
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date: </label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input type="text" name="tdate" id="tdate" value="<?=date('Y-m-d')?>" />

              </div>
            </div>
          </div>

          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <input type="submit" name="submitit" id="submitit" value="View" class="btn1 btn1-submit-input"/ >
          </div>

        </div>
      </div>




      <div class="container-fluid pt-5 p-0 ">
        <?
        if(isset($_POST['submitit'])){


          if($_POST['fdate']!=''&&$_POST['tdate']!='')
            $con .= 'and bill_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

           $res='select  * from crm_bill_info where status in("BILL SUBMITTED","BILL RECEIVED") '.$con.$cus_con.'';
          //echo link_report($res,'po_print_view.php');
          $query = db_query($res);
          ?>
          <table class="table1  table-striped table-bordered table-hover table-sm">
            <thead class="thead1">
            <tr class="bgc-info">
              <th>Bill No</th>
              <th>Bill Date</th>
              <th>Bill Type</th>

              <th>Amount</th>
           
 
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>

            <tbody class="tbody1">
            <?
            while($row = mysqli_fetch_object($query)){
              ?>
              <tr>
                <td><?=$row->manual_bill_no?></td>
                <td><?=$row->bill_date?></td>
                <td style="text-align:left"><?=$row->service_type?></td>
                <td><?=$row->net_receivable_amt?></td>
         
 
                <td><?php if($row->status=="BILL SUBMITTED"){echo "<span style='color:red;font-weight:bold;'>Bill Pending</span>";} else {echo "<span style='color:green;font-weight:bold;'>Bill Paid</span>";}?></td>
         

                <td><button onclick="custom(<?=$row->bill_no?>);" type="button" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>

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