<?php

//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$page="home";
?>



<html lang="en">

<head>
<title>Chalan View</title>


<script type="text/javascript">
function hide()
{
   document.getElementById("pr").style.display="none";
   
   setTimeout(function() {
        document.getElementById("pr").style.display = "block";
   }, 1000);
}
</script>


<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

	.btn-print {
		background-color: #0f3193;
		color: white;
		font-weight: bold;
		text-transform: uppercase;
		border: none;
	}

	.btn-print:hover {
		background-color: #1a237e;
	}
	  .online-message, .offline-message{
		display:none !important;
}

	@media print {
  .brack {page-break-after: always;}
  
  .back_button{
  		display: none !important;
  }
  
  .online-message, .offline-message{
		display:none !important;
}

</style>
</head>

<body>



<?
if($_GET['v']>0){

$chalan_no = $_GET['v'];
$chalan_info    = findall("select * from ss_do_chalan where chalan_no='".$chalan_no."' limit 1"); 
$dealer_code    = $chalan_info->dealer_code;
$dealer         = findall("select * from ss_shop where dealer_code='".$dealer_code."'");

$chalan_amount = find1("select sum(total_amt) from ss_do_chalan where chalan_no='".$chalan_no."'");

$master_dealer  = $dealer->master_dealer_code;
$mdealer = findall("select * from dealer_info where dealer_code='".$master_dealer."'");

}

?>


<a href="report_list.php" class="back_button"><button class="btn btn-print" style="background-color:#00BCD4 !important; margin-bottom: 10px; padding: 8px 15px; text-transform: uppercase;  color: white; border: none; border-radius: 5px; cursor: pointer;">Back </button></a>

<div id="pr"><input name="button" type="button" onClick="hide(); window.print();" value="Print"  style="margin-bottom: 10px; padding: 8px 15px; text-transform: uppercase; background-color: #0f3193; color: white; border: none; border-radius: 5px; cursor: pointer;" />
	</div>
	        <!-- main page content -->
        <div class="main-container container">
            <!-- Biling -->
<center>
<!--<img src="assets/img/mep_logo.jpeg" width="150px"/>-->
<div>
<h4><?=$mdealer->dealer_name_e?></h4>
<h6><?=$mdealer->address_e?></h6>
<span><?=$mdealer->mobile_no?></span><br>
<span class="">Authorized Distributor of MEP Group</span>

</div>
</center>
<br>
<?


?>
            <div class="row mb-3">
                <div class="col align-self-center">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <div class="row">
                                <center><span style="font-size:20px;">Invoice</span></center>
                                
                                <div class="col-auto">
                                    <h6 class="mb-1">Chalan No #<?php echo $chalan_no?></h6>
                                    <p>Order NO #<?php echo $chalan_info->do_no;?></p>
                                </div>
                                <div class="col text-end">
                                    <h6 class="mb-1"><i class="bi bi-check-circle"></i> Chalan Date</h6>
                                    <p><b><?php echo $chalan_info->chalan_date;?></b></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!--<div class="col-12 col-md-6 mb-4">-->
                                <!--    <p class="mb-2">Sold By:</p>-->
                                <!--    <p class="text-secondary">Z,-->
                                <!--        <br>full address,<br>Dhaka -1000-->
                                <!--    </p>-->
                                <!--</div>-->
                                <div class="col-12 col-md-6">
                                    <!--<p class="mb-2"></p>-->
                                    <p class="text-secondary">Code: <?php echo $dealer->dealer_code;?> - <?php echo $dealer->shop_name;?></p>
                                    <p class="text-secondary"><?php echo $dealer->shop_address;?></p>
                                    <p class="text-secondary">Mobile: <?php echo $dealer->mobile;?></p>
                                    
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>

           
           
           
           
           
           
           
<!-- products -->
<div class="row mb-2">
                
<div class="container">           
  <table class="table">
    <thead>
      <tr>
			<th>SL</th>
			<th class="text-left">Product Code</th>
			<th class="text-left">Product</th>
			<th class="text-left">TP</th>
			<th class="text-left">Offer%</th>
			<th class="text-left">NSP</th>
			<th class="text-left">Qty</th>
			<th class="text-left">TP TOTAL</th>
			<th class="text-left">NSP TOTAL</th>
      </tr>
    </thead>
    <tbody>
<?php 
$sql="select c.*,i.*,c.nsp_per as nsp,c.t_price as tp 
from ss_do_chalan c,item_info i 
where i.item_id=c.item_id and c.chalan_no='".$chalan_no."'   ";
$query=db_query($sql);
$sl=1;
while($row=mysqli_fetch_object($query)){
?>			 
	<tr>
		<td class="no"><?php echo $sl++?></td>
		<td class="text-left"><?php echo $row->finish_goods_code?></td>
		<td class="text-left"><?php echo $row->item_name?></td>
		<td class="unit"><?php echo number_format($row->tp,2)?></td>
		<td class="unit"><?php echo number_format($row->nsp,2)?></td>
		<td class="unit"><?php echo number_format($row->unit_price,2)?></td>
		<td class="qty"><?php echo $row->total_unit; $gqty+=$row->total_unit;?></td>
		<td class="total"><?php $tptotal = $row->total_tp; echo $tptotal; $final_tpamount +=$tptotal;?></td>
		<td class="total"><?php $total = ($row->unit_price*$row->total_unit); echo $total; $final_amount +=$total;?></td>
	</tr>
<?php } ?>
	<tr>
	  
	  <td class="no">&nbsp;</td>
	  <td class="no">&nbsp;</td>
	  <td class="no">&nbsp;</td>
	  <td class="text-left">&nbsp;</td>
	  <td class="unit">&nbsp;</td>
	  <td class="qty">Total</td>
	  <td class="total"><strong><?php echo $gqty?></strong></td>
	  <td class="total"><strong><?php echo $final_tpamount?></strong></td>
	  <td class="total"><strong><?php echo $final_amount?></strong></td>
	  </tr>
    </tbody>
  </table>


</div>               
                
          
</div>


<!--<p><br><br><p>-->
<!--<div class="row"> -->
<!--    <div class="col-4">FO Signature</div>-->
<!--    <div class="col-4">Customer Signature</div>-->
<!--    <div class="col-4">Distributor Signature</div>-->
<!--</div> -->



<p>



</div>
<!-- main page content ends -->
  
  

</main>
<!-- Page ends-->

<!-- Footer -->


</body>

</html>

<?php 
 require_once '../assets/template/inc.footer.php';
 ?>