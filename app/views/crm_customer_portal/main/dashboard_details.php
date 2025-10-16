<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
<?php 
$fr_date=date('Y-01-01');
$to_date=date('Y-12-31');
  $user_all=find_all_field('user_activity_management','*','user_id="'.$_SESSION['user']['id'].'"');
 if($_SESSION['user']['id']!=10001){
 $cus_con='and customer="'.$user_all->organization.'"';
 }
 
      $con .= 'and bill_date between "'.$fr_date.'" and "'.$to_date.'"';
if($_GET['unid']==10111){
            $res='select  * from crm_bill_info where status in("BILL SUBMITTED") and bill_date between "'.$fr_date.'" and "'.$to_date.'" '.$con.$cus_con.'';
		   }
		   else{
		    $res='select  * from crm_bill_info where status in("BILL RECEIVED") and bill_date between "'.$fr_date.'" and "'.$to_date.'" '.$con.$cus_con.'';
		   }
          //echo link_report($res,'po_print_view.php');
          $query = db_query($res);
?>
<table class="table  table-striped table-bordered table-hover table-sm">
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
                <td style="text-align:left"><?=find_a_field('crm_acc_bill_type','type','id="'.$row->service_type.'"');?></td>
                <td><?=$row->net_receivable_amt?></td>
         
 
                <td><?php if($row->status=="BILL SUBMITTED"){echo "<span style='color:red;font-weight:bold;'>Bill Pending</span>";} else {echo "<span style='color:green;font-weight:bold;'>Bill Paid</span>";}?></td>
         

                <td><a href="../bill/invoice_print_view.php?bill_no=<?=$row->bill_no?>"><button   type="button" class="btn btn-success"><i class="fa-solid fa-eye">View</i></button></a></td>

              </tr>
            <? } ?>


            </tbody>
          </table>
</div>
</body>
</html>
