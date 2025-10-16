<?

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$do_no 		= $_GET['do_no'];

//$do_no = 27746;



$datas=find_all_field('sale_do_master','s','do_no='.$do_no);

$company_name=find_a_field('project_info','proj_name','1');

$sql1="select b.* from 

sale_do_details b

where b.do_no = '".$do_no."'";

$data1=db_query($sql1);





$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;



$item_id[] = $info->item_id;

$dp_price[] = $info->unit_price;

$tp_price[] = $info->t_price;



$pkt_size[] = $info->pkt_size;

$pkt_unit[] = $info->pkt_unit;

$dist_unit[] = $info->dist_unit;

$total_unit[] = $info->total_unit;

}

$ssql = 'select a.*,b.do_date from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);



?>




<!--<script src="bootstrap/bootstrap.min.js"></script>
<script src="bootstrap/jquery.min.js"></script>-->

<link rel="stylesheet" href="style.css" media="all" />
<link rel="stylesheet" href="custom.css" media="all" />


<link href="bootstrap/font-awesome.min.css" rel="stylesheet">

<link href="bootstrap/bootstrap.min.css" rel="stylesheet">

<div class="container bootstrap snippets bootdeys">



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>.: Challan Copy :.</title>

</head>
<body>
<div class="wrapper">
  <!-- Main content -->
 
  <section class="invoice">
    

	
	<!-- title row -->
    <div class="row">
	
	<div class="col-md-4 invoice-col" align="justify">
	  
	   
					 <strong><?=$company_name;?></strong>
					 </div>
					 
					 <div class="col-md-4 invoice-col" align="center">
	  
	    <? if($_SESSION['user']['depot']>0)

					  echo find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);?>
					  
					 </div>
      
	
			<div class="col-md-4" align="right">
						<h3 class="marginright"><b>Delivery Invoice</b></h3>
						
						
			    </div>
		
		
      <!-- /.col -->
    </div>
	
	<hr style="border: 3px solid black; border-radius: 5px;">
    <!-- info row -->
    <div class="row">
      <div class="col-md-8 invoice-col" align="justify">

      <address>
          Dealer Name: <strong>[<?php echo $dealer->dealer_name_e.'-'.$dealer->dealer_code.'('.$dealer->team_name.')';?>]</strong><br>
         Address: <strong>[<?php echo $dealer->address_e.' Mobile: '.$dealer->mobile_no;?>]</strong><br>
		 Buyer Name: <strong> [<?php echo $dealer->propritor_name_e;?>]</strong><br>
        </address>
      </div>
  
      <!-- /.col -->
      <div class="col-md-4 invoice-col" align="right">
	  
	    <small><b>DO No: </b>[<?php echo $do_no;?>]</small><br>
         <b>DO Date: </b>[<?php echo $dealer->do_date;?>]<br>
		 <b>Received Amt: </b>[<?php echo $datas->received_amt;?>]
      </div>
      <!-- /.col -->
    </div>

	
 	

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
          <tr class="table-primary">
            <th>Sl</th>
			<th>Code</th>
            <th>Product Name</th>
            <th>Crt</th>
			<th>Pcs</th>
            <th>DP</th>
            <th>TP</th>
          </tr>
          </thead>
          <tbody>
		  
		 <? for($i=0;$i<$pi;$i++){$fgc = find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);if($fgc!=2000){?>
		  

          <tr>
            <td><?=++$kk?></td>
            <td><?=$fgc;?></td>
            <td><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
            <td><?=$pkt_unit[$i];?></td>
            <td><?=$dist_unit[$i];?></td>
			<td><? echo number_format($dp_price[$i],2);?></td>
			<td><? echo number_format($tp_price[$i],2);?></td>
          </tr>
		  
<? 

$t_pkt = $t_pkt + $pkt_unit[$i];

$t_pcs = $t_pcs + $dist_unit[$i];



$t_tp = $t_tp + $tp_price[$i];

$t_dp = $t_dp + $dp_price[$i];

}}?>
	  
		   <tr>
		   
        <td colspan="3" style="border-left:0 ; border-bottom:0"><div align="right"><strong>SUB TOTAL  : </strong></div></td>
		<td><?=$t_pkt?></td>
				<td><?=$t_pcs?></td>	
						<td><?=$t_dp?></td>	
								<td><?=$t_tp?></td>	
									
		
      
      </tr>
	  
          
		  
		  
          
          
          </tbody>
		  
        </table>
		
		<!--<p class="lead">Amount Due 2/22/2014</p>-->
		
		
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
	
	</br>
	
	
	
	<div class="row">
      <!-- accepted payments column -->
      <div class="col-12">
  <div class="card-body">

<!--    <p class="card-text">1. All Goods are received in a good condition as per work order & LC Terms</p>
    <p class="card-text">2. Claims for short receive, damage not approved quality goods delivery must be advised in writing with in three (3) days after delivery</p>-->
  </div>
</div>

</div>



</div>



        <tr>

          <td colspan="3" align="left" style="font-size:12px" >

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top">

                  <p><br />

                    <br />--------------------<br />

                    Authorized Person&nbsp;</p></td>

                <td><em><strong>Prepared By </strong>: <?=find_a_field('user_activity_management','fname','user_id='.$datas->entry_by);?></em></td>

              </tr>

            </table></td>

        </tr>

        

        <tr>

          <td colspan="3" align="left">&nbsp;</td>

        </tr>

      </table></td>

  </tr>



</table>

<!--<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>-->
</body>
</html>
