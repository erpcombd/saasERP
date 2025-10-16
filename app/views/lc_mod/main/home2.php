<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$ssql = "select sum(total_amt) as tot_amt from sale_do_details where status = 'COMPLETED'";
$sq = db_query($ssql);
$result1 = mysqli_fetch_object($sq);
$sum_reg_sale = $result1->tot_amt;
$ssql2 = "select sum(total_amt) as tot_amt from sale_pos_details, sale_pos_master where sale_pos_master.pos_id = sale_pos_details.pos_id and sale_pos_master.status ='COMPLETED'";
$sq2 = db_query($ssql2);
$result2 = mysqli_fetch_object($sq2);
$sum_pos_sale = $result2->tot_amt;
$total_sale = ($sum_reg_sale+$sum_pos_sale);
$first_percentage = (100 / $total_sale)*$sum_reg_sale;
$second_percentage = (100/ $total_sale)*$sum_pos_sale;
//last 5 sales

$all_sql = "select sdm.do_no, sdm.do_date, d.dealer_name_e, sum(sdd.total_amt) as tot_amt, sdm.status from sale_do_master sdm, dealer_info d, sale_do_details sdd where sdm.dealer_code = d.dealer_code and sdd.do_no = sdm.do_no group by sdm.do_no order by do_no desc limit 0,5";

$all_query = db_query($all_sql);

while($datas = mysqli_fetch_assoc($all_query)){
	extract($datas);
	$dd['do_no'][] = $do_no;
	$dd['do_date'][] = $do_date;
	$dd['dealer_name'][]= $dealer_name_e;
	$dd['tot_amt'][] = $tot_amt;
	$dd['status'][] = $status;
	}

$all_sql2 = " select sale_pos_master.pos_id, sale_pos_master.pos_date, dealer_info.dealer_name_e, sum(sale_pos_details.total_amt) as tot_amt, sale_pos_master.status from sale_pos_master, sale_pos_details, dealer_info where sale_pos_master.pos_id = sale_pos_details.pos_id and sale_pos_master.dealer_id = dealer_info.dealer_code group by sale_pos_master.pos_id order by sale_pos_master.pos_id desc limit 0,5";

$all_query2 = db_query($all_sql2);

while($datas2 = mysqli_fetch_assoc($all_query2)){
	extract($datas2);
	$d['pos_id'][] = $pos_id;
	$d['pos_date'][] = $pos_date;
	$d['dealer_name'][]= $dealer_name_e;
	$d['tot_amt'][] = $tot_amt;
	$d['status'][] = $status;
	}


?>
<script>
window.onload = function () {

var options = {
	animationEnabled: false,
	data: [{
		type: "pie",
		startAngle: 40,
		toolTipContent: "<b>{label}</b>: {y}%",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 12,
		indexLabel: "{label} - {y}%",
		dataPoints: [
			{ y: <?=number_format($first_percentage, 2)?>, label: "Regular Sale" },
			{ y: <?=number_format($second_percentage, 2)?>, label: "POS Sale" },
		]
	}]
};
$("#chartContainer").CanvasJSChart(options);
$(".canvasjs-chart-credit").remove();
}
</script>

<div class="row">
 <div class="col-sm-4">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=number_format($sum_reg_sale, 2)?></h3>
                <p>Reular Sale</p>
              </div>
              <div class="icon1">
                
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
   <div class="col-sm-4">
           
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
          </div>
     <div class="col-sm-4">
            <!-- small card -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?=number_format($sum_pos_sale, 2)?></h3>
                <p>POS Sale</p>
              </div>
              <div class="icon1">
                
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          
</div>
<div class="row">
<div class="col-sm-6">
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Recet Sale (Last 5 Sales)</div>
  <!-- Table -->
  <table class="table table-primary table-hover" style="border-radius:7px;">
   <tr>
   <th>SL</th><th>Do No</th><th>Do Date</th><th>Dealer Name</th><th>Total Amount</th><th>Status</th>
   </tr>
   <?php
   $r= 0;
   foreach($dd['do_no'] as $key=>$do){
   $r++; 	  
   ?>
   <tr>
   <td><?=$r?></td><td><?=$do?></td><td><?=$dd['do_date'][$key]?></td><td><?=$dd['dealer_name'][$key]?></td><td><?=$dd['tot_amt'][$key]?></td><td><?=$dd['status'][$key]?></td>
   </tr>
   <?php
   }
   ?>
   </table>
</div>
</div>
<div class="col-sm-6">
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Recet POS Sale (Last 5 Sales)</div>
  <!-- Table -->
  <table class="table table-info table-hover" style="border-radius:7px;">
   <tr>
   <th>SL</th><th>POS ID</th><th>POS Date</th><th>Customer Name</th><th>Total Amount</th><th>Status</th>
   </tr>
   <?php
   $t = 0;
   foreach($d['pos_id'] as $key=>$pi){
   $t++  
   ?>
   <tr>
   <td><?=$t++?></td><td><?=$pi?></td><td><?=$d['pos_date'][$key]?></td><td><?=$d['dealer_name'][$key]?></td><td><?=$d['tot_amt'][$key]?></td><td><?=$d['status'][$key]?></td>
   </tr>
   <?php
   }
   ?>
   </table>
</div>
</div>
</div>
	

<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<?

//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>