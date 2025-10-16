<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';

$user           = $_SESSION['username'];
$company_id     = $_SESSION['company_id'];	



		
if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0){

		
	$f_date=$_REQUEST['f_date'];
	$t_date=$_REQUEST['t_date'];

	
	if($_POST['warehouse_id']>0) 				$warehouse_id=$_POST['warehouse_id'];
	if($_REQUEST['item_id']>0) 					$item_id=$_REQUEST['item_id'];
	
	
	if($_POST['order_type']!='') 				$order_type=$_POST['order_type'];
	
	if($_POST['issue_status']!='') 				$issue_status=$_POST['issue_status'];
	if($_POST['item_sub_group']>0) 				$sub_group_id=$_POST['item_sub_group'];
	if($_POST['item_brand']>0) 				    $item_brand=$_POST['item_brand'];



switch ($_POST['report']) {


case 501:
$report="All Order Status";
		
		
		if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; 
		$con.=' and order_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		
		if(isset($order_type)) {$con.=' and order_type="'.$order_type.'"';} 

$sql='SELECT do_no as order_no,order_date,user_id,sum(total_amt) as order_amount

FROM order_detail 
where 1
'.$con.'
group by do_no
order by do_no desc';		
	
break;


case 502:
		$report="Product Information";
		//if(isset($warehouse_id)) {$warehouse_con=' and a.relevant_warehouse='.$warehouse_id;}  
		
		//if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date; 
		//$date_con=' and a.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

$sql='SELECT id as item_id, name, price, type, item_group, brand, item_company
FROM product i
where 1 and categories_id=0 and sub_categories_id=0 and i.price>0
order by id desc';		
	
break;






}

}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Report</title>
<style>
/*table {*/
/*  font-family: arial, sans-serif;*/
/*  border-collapse: collapse;*/
/*  width: 100%;*/
/*}*/

/*td, th {*/
/*  border: 1px solid #dddddd;*/
/*  text-align: left;*/
/*  padding: 8px;*/
/*}*/

/*tr:nth-child(even) {*/
/*  background-color: #dddddd;*/
/*}*/
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
  
  </head>
<?php //include 'inc/header.php'; ?>


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">


<?php
		$str 	.= '<div class="header">';
// 		$str 	.= '<h1>'.find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']).'</h1>';
		
		if(isset($report)) 
		$str 	.= '<center><h3>'.$report.'</h3>';
		
		if(isset($to_date)) 
		$str 	.= '<h6>Date Interval: '.$fr_date.' To '.$to_date.'</h6>';
		
		
		if(isset($item_id)) { $item_name = find1("select name from product where id='".$item_id."'");
		$str 	.= '<p>Item Name: '.$item_id.'-'.$item_name.'</p>';
		}
		
		$str 	.= '</div><div align="right" class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';
		

		
if($_POST['report']==101) {
$report ='Visitor Log Details';
$report.='<br>Date Interval: '.$_POST['f_date'].' to '.$_POST['t_date'];

if($_POST['visitor_name']!=''){ 
    $visitor_name = $_POST['visitor_name'];
    $con.=" and v.visitor_name ='".$visitor_name."'";
}

if($_POST['department']!=''){ 
    $department = $_POST['department'];
    $con.=" and v.visitor_department ='".$department."'";
}


?>
<center>
<h3 class="card-title"><?=$report?></h3><div align="right">Reporting Time:<?=date("h:i A d-m-Y")?></div>
<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
      <th scope="col">LOG</th>
      <th scope="col">visitor_name</th>
	  <th scope="col">Image</th>
      <th scope="col">meet_person_name</th>

	  <th scope="col">reason_to_meet</th>
	  <th scope="col">visitor_intime</th>
	  <th scope="col">visitor_outtime</th>
	  <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
<?php 
$sql = "select v.* from visitor_table v where 1 and v.company_id='".$company_id."' and visitor_enter_date between '".$_POST['f_date']."' and '".$_POST['t_date']."'
".$con."
order by visitor_status,visitor_id desc ";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>
    <tr>
      <td class="align-middle"><a href="visitor_card.php?log=<?php echo $data->visitor_id;?>"><?php echo $data->visitor_id;?></a></th>
	  <td class="align-middle"><?php echo $data->visitor_name;?><br><?php echo $data->visitor_mobile_no;?><br><?php echo $data->visitor_email;?><br><?php echo $data->visitor_address;?>
	  <br>
<div class="alert alert-danger" role="alert">
<h2>Card No: <?php echo $data->visitor_card_no;?></h2>
</div>
	  
	  </td>
	  
	  
	  <td class="align-middle"><img src="visitor_image/<?php echo $data->visitor_in_image;?>"></td>
	  <td class="align-middle"><?php echo $data->visitor_meet_person_name;?><br><?php echo find1("select department_name from setup_department where department_id='".$data->visitor_department."'");?></td>
	  <td class="align-middle"><?php echo $data->visitor_reason_to_meet;?></td>
	  <td class="align-middle"><?php echo $data->visitor_enter_time;?></td>
	  <td class="align-middle"><?php echo $data->visitor_out_time;?></td>	  
        </tr>
        <?php } ?>
</tbody>
</table>	
</div>
<?php
}


if($_POST['report']==202) {
$report ='Item Short List';

// Present stock
$sql1='select i.id, sum(j.item_in-j.item_ex) as stock FROM product i, journal_item j
where i.id=j.item_id 
group by i.id
order by i.name';

$query1= mysqli_query($conn, $sql1);
while($row =mysqli_fetch_object($query1)){
$item_stock[$row->id] = (int)$row->stock;
}
?>
<center>
<h3 class="card-title"><?=$report?></h3><div align="right">Reporting Time:<?=date("h:i A d-m-Y")?></div>
<div class="table-responsive">
<table class="table">
<thead>
    <tr>
      <th>S/L</th>
      <th>Code </th>
      <th>Name </th>
      <th>Price</th>
      <th>Minimum Stock Qty</th>
      <th>Present Stock </th>
      <th>Short Stock</th>
      <th>Short Stock Amount</th>
    </tr>
  </thead>
  <tbody>
<?php
$sql2='select * from product i where i.status="1" and categories_id=0 and sub_categories_id=0
and id not in(10619,10620) and i.price>0 and i.qty_alert>0 order by i.name';
$query= mysqli_query($conn, $sql2);

while($data=mysqli_fetch_object($query)){
if($item_stock[$data->id]<=$data->qty_alert){

$j++;
?>
    <tr>
      <td><?=$j?></td>
      <td><?=$data->id?></td>
      <td><?=$data->name?></td><td><?=$data->price?></td>
      <td><?=$data->qty_alert?></td>
      <td><?=$item_stock[$data->id]?></td>
      <td span style="color:red"><strong><?php echo $short_stock = ($data->qty_alert- $item_stock[$data->id]);?></strong></td>
      <td><?php echo number_format($short_stock*$data->price,0); $g_total +=$short_stock*$data->price;?></td>
    </tr>
<?php
} //end if
} // end while
		
?>
    <tr>
      <td></td>
      <td></td>
      <td></td><td></td>
      <td></td><td></td>
      <td>Total:</td>
      <td><?php echo number_format($g_total,0);?></td>
    </tr>
  </tbody>
</table></div>
<?php
}




elseif($_POST['report']==201) {
$report ='Item Stock Report';

?>
<center>
<h3 class="card-title"><?=$report?></h3><div align="right">Reporting Time:<?=date("h:i A d-m-Y")?></div>
<div class="table-responsive">
<table class="table table-striped table-bordered" id="table_report">
<thead>
    <tr>
      <th>S/L</th>
      <th>Item Company </th>
      <th>Code </th>
      <th>Name</th>
      <th>Stock Qty</th>
    </tr>
  </thead>
  <tbody>
<?php
$sql2='select i.item_company,i.id as code, i.name,sum(j.item_in-j.item_ex) as stock
FROM product i, journal_item j
where i.id=j.item_id
group by i.id
order by i.name';
$query= mysqli_query($conn, $sql2);
while($data=mysqli_fetch_object($query)){
$j++;
?>
    <tr>
      <td><?=$j?></td>
      <td><?=$data->item_company?></td>
      <td><?=$data->code?></td><td><?=$data->name?></td>
      <td><?php echo (int)$data->stock?></td>
      
    </tr>
<?php
} // end while
		
?>
    <tr>
      <td></td>
      <td></td>
      <td></td><td></td>
      <td></td>
    </tr>
  </tbody>
</table></div>

<?php
}


elseif($_REQUEST['report']==204) {
$report ='Item Transection Report';

if(isset($_REQUEST['item_id'])){ 
    $item_id = $_REQUEST['item_id'];


if(isset($t_date)) {$to_date=$t_date; $fr_date=$f_date;  
$date_con=' and j.ji_date between \''.$fr_date.'\' and \''.$to_date.'\'';
    
}


?>
<center>
<h2>Medicine House BD</h2>
<h3>Item Transection Report</h3>
<h5>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h5>
<h6>Item Name: <?php echo $item_id?>-<?php echo find1("select name from product where id='".$item_id."'");?></h6>
<div align="right">Reporting Time:<?=date("h:i A d-m-Y")?></div>
<div class="table-responsive">
<table class="table table-striped table-bordered">
<thead>
    <tr>
      <th>S/L</th>
      <th>Date</th>
      <th>Code </th>
      <th>Name</th><th>IN</th><th>OUT</th>
      <th>Entry At</th>
    </tr>
  </thead>
  <tbody>

<?php
$sql='SELECT j.ji_date,i.id,i.name,j.item_in as item_in,j.item_ex as item_out,j.entry_at
FROM journal_item j, product i
where j.item_id=i.id and i.id="'.$item_id.'"
'.$date_con.'
order by j.ji_date';
$query= mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
$j++;
?>
    <tr>
      <td><?=$j?></td>
      <td><?=$data->ji_date?></td>
      <td><?=$data->id?></td><td><?=$data->name?></td><td><?=(int)$data->item_in?></td><td><?=(int)$data->item_out?></td>
      <td><?=$data->entry_at?></td>
      
    </tr>
<?php
$g_in += $data->item_in;
$g_out += $data->item_out;
} // end while
?>
    <tr>
      <td></td>
      <td></td>
      <td></td><td><b>Total</b></td>
      <td><b><?=(int)$g_in?></b></td><td><b><?=(int)$g_out?></b></td>
      <td></td>
    </tr>
  </tbody>
</table></div>

<?php
}else{ die('Please select item for this report. Thanks');}
}



elseif($_POST['report']==203){

$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

 
if($_POST['item_sub_group']>0) 	$sub_group_id   =$_POST['item_sub_group'];
if($_POST['item_id']>0)         $item_id        =$_POST['item_id'];

$date_con = ' and j.ji_date between "'.$f_date.'" and "'.$t_date.'" ';
if(isset($sub_group_id)) 	{$item_sub_con=' and i.sub_group_id='.$sub_group_id;} 
if(isset($item_id)) 		{$item_con=' and i.id='.$item_id;} 


// opening
$sql="select j.item_id as code,sum(j.item_in - j.item_ex) balance
from journal_item j, product i 
where j.item_id=i.id
and ji_date < '".$f_date."' and warehouse_id = '1' 
".$item_con.$item_sub_con." group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$opening[$row->code] = (int)$row->balance;
	}
	
// Closing
$sql="select j.item_id as code,sum(j.item_in - j.item_ex) balance
from journal_item j, product i 
where j.item_id=i.id
and ji_date <= '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con." group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$bin_closing[$row->code] = (int)$row->balance;
	}	



// ----------- ALL purchase	
$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance
from journal_item j, product i 
where j.item_id=i.id 
and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con." 
AND  j.tr_from IN ('Local Purchase') group by i.id";
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$purchase[$row->code] = (int)$row->balance;
	}



// ------------------ Other receive	
$sql="select j.item_id as code,i.unit_name,sum(j.item_in) balance
from journal_item j, product i 
where j.item_id=i.id 
and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con." 
AND  j.tr_from NOT IN ('Local Purchase') group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$other_receive[$row->code] = (int)$row->balance;
	}	

// ----------------- Delivery	
$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance
from journal_item j, product i 
where j.item_id=i.id 
and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con." 
AND  j.tr_from IN ('Other Issue') group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$delivery[$row->code] = (int)$row->balance;
	}



// ----------------- Others issue	
$sql="select j.item_id as code,i.unit_name,sum(j.item_ex) balance
from journal_item j, product i 
where j.item_id=i.id 
and j.ji_date between '".$f_date."' and '".$t_date."' and warehouse_id = '1' ".$item_con.$item_sub_con." 
AND  j.tr_from NOT IN ('Other Issue') group by i.id";
	
$res = mysqli_query($conn, $sql);
	while($row=mysqli_fetch_object($res))
	{
		$other_issue[$row->code] = (int)$row->balance;
	}		
		

?>
<center>
<h1>Medicine House BD</h1>
<h2>Stock Movement Report</h2>
<h3>Date Interval: <?=$_REQUEST['f_date'];?> to <?=$_REQUEST['t_date'];?></h3>
<table class="table table-striped table-bordered">
<thead>
<tr>
  <th>S/L</th>
  <th>Code</th>
  <th>Item Name</th>
  <th bgcolor="#009999">Opening</th>
  <th bgcolor="#009999">Purchase</th>

  <th bgcolor="#009999">Other Receive</th>
  <th bgcolor="#009999">Total</th>

  <th bgcolor="#FF6699">Delivery</th>
  <th bgcolor="#FF6699">Other Issue</th>
  <th bgcolor="#FF6699">Total</th>
  <th>Closing</th>
  </tr>
</thead>
<tbody>

<?php
$sql="SELECT i.id as code,i.name,i.type
FROM  product i
where 1 and status=1 and categories_id=0 and sub_categories_id=0 and i.price>0
".$item_con.$item_sub_con."
order by i.name";

$query = mysqli_query($conn, $sql);
while($data= mysqli_fetch_object($query)){ 
    
$in_total   = $opening[$data->code] + $purchase[$data->code] + $other_receive[$data->code];
$out_total  = $delivery[$data->code] + $other_issue[$data->code];
if($in_total<>0||$out_total<>0||$opening[$data->code]<>0){
?>

<tr>
  <td><?=++$op;?></td>
  <td><a href="master_report.php?report=204&submit=1&item_id=<?php echo $data->code;?>&f_date=<?php echo $f_date;?>&t_date=<?php echo $t_date;?>" target="_blank"><?=$data->code?></a></td>
  <td><?=$data->name?></td>
  <td><?=$opening[$data->code]?></td>
  <td><?=$purchase[$data->code]?></td>

  <td><?=$other_receive[$data->code]?></td>
  <td><?=$in_total?></td>

  <td><?=$delivery[$data->code]?></td>
  <td><?=$other_issue[$data->code]?></td>
  
  <td><?=$out_total?></td>
  
  <?php $closing = $in_total - $out_total; ?>  
  <td><?=$closing?></td>
  </tr>
<? 
$total_opening += $opening[$data->code];
$total_purchase += $purchase[$data->code];
$total_other_receive += $other_receive[$data->code];
$total_in_total += $in_total;

$total_delivery += $delivery[$data->code];
$total_other_issue += $other_issue[$data->code];
$total_out_total += $out_total[$data->code];
$total_closing += $closing;

}
} 
?>
<tr>
  <td bgcolor="#99CC99">&nbsp;</td>
  <td bgcolor="#99CC99">&nbsp;</td>
  <td bgcolor="#99CC99"><strong>Total</strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_opening;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_purchase;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_other_receive;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_in_total;?></strong></td>
  

  <td bgcolor="#99CC99"><strong><?=$total_delivery;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_other_issue;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_out_total;?></strong></td>
  <td bgcolor="#99CC99"><strong><?=$total_closing;?></strong></td>
  </tr>
</tbody></table>

<?php
}
// end stock movement report






elseif(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
?>




                            </div>
                        </div>
                    </div>	
                </div>




    <!-- jQuery -->
    <!--<script src="../vendors/jquery/dist/jquery.min.js"></script>-->
    <!-- Bootstrap -->
    <!--<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>-->
    <!-- FastClick -->
    <!--<script src="../vendors/fastclick/lib/fastclick.js"></script>-->
    <!-- NProgress -->
    <!--<script src="../vendors/nprogress/nprogress.js"></script>-->
    
    <!-- Custom Theme Scripts -->
    <!--<script src="build/js/custom.min.js"></script>-->
    
    
<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    
 <script>
    $(document).ready(function() {
    $('#table_report').DataTable({
        aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
        'iDisplayLength': 1000
    });
} );
</script>   
    
    
  </body>
</html>


