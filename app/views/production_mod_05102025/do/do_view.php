<?

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$do_no = $_GET['do_no'];

//$do_no = 27746;



$datas=find_all_field('production_requisition_master','s','req_no='.$do_no);

$company_name=find_a_field('project_info','proj_name','1');

$sqw = "select * from warehouse where use_type = 'PL' ";
$quw = db_query($sqw);
while($dtw=mysqli_fetch_object($quw)){

	$line_ids[] = $dtw->warehouse_id;

	$sql1="select b.*, i.pack_size, i.cost_price from production_line_fg pl, production_requisition_order b, item_info i where pl.line_id=".$dtw->warehouse_id." and pl.fg_item_id= b.item_id and b.req_no = '".$do_no."' and i.item_id=b.item_id";
	
	$data1=db_query($sql1);
	$pi=0;
	
	$total=0;
	
	while($info=mysqli_fetch_object($data1)){
	
	$pi++;
	$item_id[$dtw->warehouse_id][] = $info->item_id;
	$dp_price[$dtw->warehouse_id][] = $info->unit_price;
	$tp_price[$dtw->warehouse_id][] = $info->t_price;
	$cost_price[$dtw->warehouse_id][] = $info->cost_price;
	$pkt_size[$dtw->warehouse_id][] = $info->pack_size;
	$pkt_unit[$dtw->warehouse_id][] = (int)($info->qty/$info->pack_size);
	$dist_unit[$dtw->warehouse_id][] = fmod($info->qty,$info->pack_size);
	
	$total_unit[$dtw->warehouse_id][] = $info->total_unit;
	
	}

}




$ssql = 'select a.*,b.do_date,b.remarks from dealer_info a, production_requisition_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);



?>




<!--<script src="bootstrap/bootstrap.min.js"></script>
<script src="bootstrap/jquery.min.js"></script>-->

<link rel="stylesheet" href="style.css" media="all" />
<link rel="stylesheet" href="custom.css" media="all" />


<link href="bootstrap/font-awesome.min.css" rel="stylesheet">

<link href="bootstrap/bootstrap.min.css" rel="stylesheet"><div class="container bootstrap snippets bootdeys">



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>.: Challan Copy :.</title>

</head>
<body>
<div class="wrapper" >
  <!-- Main content -->
 
  <section class="invoice">
    

	
	<!-- title row -->
    <div class="row" style="margin-top:10%">
	
	<div class="col-md-4 invoice-col" align="" >
	  
	   
					 <strong><?=$company_name;?></strong>
					 </div>
					 
					 <div class="col-md-4 invoice-col" align="center">
	  
	    <? if($_SESSION['user']['depot']>0)

					  echo find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);?>
					  
					 </div>
      
	
			<div class="col-md-4" align="right">
						<h3 class="marginright"><strong>Production Requisition </strong></h3>
						
						
      </div>
		
		
      <!-- /.col -->
    </div>
	
	<hr style="border: 3px solid black; border-radius: 5px;">
    <!-- info row -->
    <div class="row">
      <div class="col-md-4 invoice-col" align="left">
	  
	    <small><b>Req No: </b>[<?php echo $do_no;?>]</small><br>
         <b>Req Date: </b>[<?php echo $datas->req_date;?>]<br>
      </div>
   
    </div>

	
 	

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
          
          </thead>
          <tbody>
		  
		 <?
		 foreach($line_ids as $line){
		 
		 ?>
		 <tr class="table-primary">
		 	<th></th>
			<th colspan="7"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line);?></th>
		 </tr>
		 <?
		 
		  $kl=0; for($i=0;$i<$pi;$i++){$fgc = find_a_field('item_info','finish_goods_code','item_id='.$item_id[$line][$i]);if($fgc!=2000){
		  if($item_id[$line][$i] > 0){
		  ?>
		  
			<tr class="table-primary">
            <th>SL</th>
			<th>Code</th>
            <th>Product Name</th>
            <th>Crt</th>
			<th>Pcs</th>
            <th>Cost Price</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
            </tr>
			
			
          <tr>
            <td><?=++$kk?></td>
            <td><?=$fgc;?></td>
            <td><?=find_a_field('item_info','item_name','item_id='.$item_id[$line][$i]);?></td>
            <td><?=number_format($pkt_unit[$line][$i],2);?></td>
            <td><?=number_format($dist_unit[$line][$i],2);?></td>
			<td><?=$cost_price[$i]?></td>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		  </tr>
		  
		  
		  
		 <tr>
			<td style="text-align:center" colspan="8"> <strong>Raw Items</strong></td>
		</tr>
		
		<tr class="">
			<th>SL</th>
			<th>Code</th>
			<th>Item Name</th>
			<th>Unit</th>
			<th>Stock</th>
			<th>Required</th>
			<th>Rate</th>
			<th>Total Amt</th>
		</tr>
		
<? 
 $sql = 'select i.*,r.*,s.sub_group_name,m.quantity from item_info i, bom_raw_material r,bom_master m, item_sub_group s where i.sub_group_id=s.sub_group_id and i.item_id =r.item_id and r.fg_item_id="'.$item_id[$line][$i].'" and m.bom_no=r.bom_no  order by s.sub_group_name,i.item_name';
$query = db_query($sql);
$raw_stock =0;
$kl=0;
 $ttoal =0;
while($data = mysqli_fetch_object($query)){

 
$formula_qty = ($data->total_unit/$data->quantity); 
$fg_pcs = $pkt_size[$line][$i];
$total_fg_batch_qty = (($fg_pcs*$pkt_unit[$line][$i])+$dist_unit[$line][$i]);

 if($total_fg_batch_qty*$formula_qty>0){
?>

		<tr>
            <td><?=++$kl;?></td>
			<td><?=$data->item_id;?></td>
            <td><?=$data->item_name?></td>
            <td><?=$data->unit_name?></td>
            <td><?=number_format($stock = find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$data->item_id.'" '),2); ?></td>
            <td><? $raw_qqty_u = $total_fg_batch_qty*$formula_qty;
			 if($data->ratio>0){ $req_qty = $raw_qqty_u/$data->ratio;  }else{ $req_qty = $raw_qqty_u; }
			 if($data->unit_name=='Pcs') echo $test = number_format(ceil($req_qty),2); else echo $test = number_format(($req_qty),2); ?></td>
			 <td><?=number_format($final_price=find_a_field('journal_item','final_price',' 1 and final_price > 0 and   tr_from in ("Purchase","Local Purchase","Production Receive","Opening") and item_id="'.$data->item_id.'" order by id desc'),2); ?></td>
			 <td><?=number_format($total=$final_price*$test,2); $ttoal = $ttoal+$total; ?></td>
		</tr>
		
<? } } ?>	  
		<tr>
			<td colspan="7" style="text-align:right"><strong>Total Amount :</strong></td>
			<td><strong><?=number_format($ttoal,2)?></strong></td>
		</tr>
		<tr>
			<td colspan="7" style="text-align:right"><strong>Price/CRT :</strong></td>
			<td><strong><?=number_format(($ttoal/$pkt_unit[$line][$i]),2)?></strong></td>
		</tr>
<tr>
	<td colspan="7">&nbsp;</td>
	<td></td>
</tr>
		  
<? 

$t_pkt = $t_pkt + $pkt_unit[$line][$i];

$t_pcs = $t_pcs + $dist_unit[$i];



$t_tp = $t_tp + $tp_price[$line][$i];

$t_dp = $t_dp + $dp_price[$line][$i];

}

}

}
}?>


	   <!--<tr>
        <td colspan="3" style="border-left:0 ; border-bottom:0"><div align="right"><strong>SUB TOTAL  : </strong></div></td>
		<td><?=$t_pkt?></td>
		<td><?=$t_pcs?></td>	
		<td><?=$t_dp?></td>	
		<td><?=$t_tp?></td>	
      </tr>-->
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

                    <!--<br />--------------------<br />

                    Authorized Person&nbsp;</p></td>-->

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
