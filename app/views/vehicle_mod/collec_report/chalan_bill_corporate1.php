<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require_once "../../../assets/support/inc.all.php";



$chalan_no 		= $_REQUEST['v_no'];
$ch_all=find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);
$do_all=find_all_field('sale_do_master','','do_no='.$ch_all->do_no);
$dealer=find_all_field('dealer_info','','dealer_code='.$do_all->dealer_code);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>.: Delivery Chalan Bill Report :.</title>
	<script>
function print_cus(){
document.getElementById('pr').style.display='none';
window.print();
}
</script>
    <style>
	 .mb-3{
margin-bottom:4px!important;
}
.input-group-text{
font-size:12px;
}
      * {
    margin: 0;
    padding: 0;
	font-size:13px;
  }
  p {
    margin: 0;
    padding: 0;
  }
  h1,
  h2,
  h3,
  h4,
  h5,
  h6
   {
    margin: 0 !important;
    padding: 0 !important;
  }
  
  th,tr,th,td{
  border:1px solid;
  }
label{

}

    </style>
  </head>
 
  <body>

    <section >
      <div class="container">
	  
	  <div class="row">
	
		<div class="col-2 text-center">
			<img style="width:60px;height:55px" src="../report/habib.png">
		</div>
		
		<div class="col-8 text-center">
			<h1><?php echo find_a_field('project_info','proj_name','1')?></h1>
			<span><h5 style="letter-spacing:1px;">Quality product at affordable cost</h5></span>
			<?php echo find_a_field('project_info','warehouse_address','1')?><br>
			Cell: <?php echo find_a_field('project_info','warehouse_phone','1')?>. Email: <?php echo find_a_field('project_info','proj_email','1')?>  <br> www.habibindustries.net
		</div>
		<div class="col-2"></div>
	</div>
	  <br>
	  
<!--        <div class="row justify-content-center">
          <div class="col-12">
             <div class="company-title">
              <div class="d-flex justify-content-around">
                <div class="d-flex align-items-center">
                 <h4><img style="width:60px;height:55px" src="habib.png"></h4>
                </div>
                <div class="company-header">
				
                  <h1 class="text-uppercase text-center" style="font-size:38px;"><?php echo find_a_field('project_info','proj_name','1')?></h1>
                  <h5 style="letter-spacing: 2px;" class=" text-black text-capitalize text-center p-1">Quality product at affordable cost</h5>
                  <p class="text-center"><?php echo find_a_field('project_info','warehouse_address','1')?></p>
  <p class="text-center">Cell: <?php echo find_a_field('project_info','warehouse_phone','1')?>. Email: <?php echo find_a_field('project_info','proj_email','1')?>  <br> www.habibindustries.net</p>
                </div>
                <div class="d-flex align-items-center">
                  
                </div>
              </div>
            </div><br>-->
            <div class="text-center">
              <button class="btn btn-default outline border rounded-pill border border-dark  text-black"><h4>Delivery Challan</h4></button>
            </div>
			<div class="row">
			     <div class="col-6"><button type="button" class="btn btn-success" id="pr"  onClick="print_cus()">Print</button></div>
				 <div class="col-6"><p style="float:right">Reporting Time: <?=date("h:i A d-m-Y")?></p></div>
				 </div>
            <br><div class="row">
      <div class="col-6">
		    
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Challan No</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php echo $chalan_no;?>">
			</div>
			
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">SO No</span>
			  </div>
			   <input type="text" disabled class="form-control" id="no" value=" <?=$ch_all->do_no?>">
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO No</span>
			  </div>
			   <input type="text" disabled class="form-control" id="no" value=" <?=$do_all->po_no?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Customer ID</span>
			  </div>
			     <input type="text" disabled class="form-control" id="name" value="<?=$dealer->dealer_code?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Customer Name</span>
			  </div>
			     <input type="text" disabled class="form-control" id="name" value="<?php echo $dealer->dealer_name_e;?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Customer Mobile No</span>
			  </div>
			     <input type="text" disabled class="form-control" id="cell-tell" value="<?php echo $dealer->mobile_no;?>">
			</div>
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Delivery Address</span>
			  </div>
			  <textarea class="form-control"><?php echo $do_all->delivery_address;?></textarea>
			 
			</div>
			
			<!--<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Manual No</span>
			  </div>
			      <input type="text" disabled class="form-control" id="cell-tell" value="<?php echo $ch_all->mnumber;?>">
			</div>-->
			
		  </div>
		  <div class="col-6">
		    
		<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Challan Date</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php  
			echo  $newDate = date("d-m-Y", strtotime($ch_all->chalan_date));
			 ?>">
			</div>
			
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">SO Date</span>
			  </div>
			  <input type="text" disabled class="form-control" id="no" value=" <?php 
			echo date("d-m-Y", strtotime($ch_all->do_date))  ;
			
			  
			  
			  ?>">
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">PO Date</span>
			  </div>
			  <input type="text" disabled class="form-control" id="no" value=" <?php 
		
			  echo date("d-m-Y", strtotime($do_all->po_date));
			  ?>">
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Driver Name</span>
			  </div>
			      <input type="text" disabled class="form-control" id="cell-tell" value="<?php echo $ch_all->driver_name_real;?>">
			</div>
			
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Vehicle No</span>
			  </div>
			     <input type="text" disabled class="form-control" id="cell-tell" value="<?php echo $ch_all->vehicle_no;?>">
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Driver Mobile</span>
			  </div>
			     <input type="text" disabled class="form-control" id="cell-tell" value="<?php echo $ch_all->mobile;?>">
			</div>
			
			
			
			
			
		  </div>
              
            </div> <br><br>

            <div class="data-table">
              <table class="table table-bordered border-primary  text-center">
                <thead>
                  <tr>
                    <th >SL</th>
					<th >Item Code</th>
                    <th>Item Description</th>
                    <th> Delivery Quantity</th>
					<th>UOM</th>
					<th>Sec Qty</th>
					<th>UOM2</th>
					
					<th>Remarks</th>
                  
                  </tr>
                </thead>
                <tbody class=" text-center table-striped">
				
<?php 
 $sql='select * from sale_do_chalan where chalan_no="'.$chalan_no.'"';
$query=mysql_query($sql);
while($row=mysql_fetch_object($query)){
$item_all=find_all_field('item_info','','item_id="'.$row->item_id.'"');
$entry_by=find_a_field('user_activity_management','fname','user_id="'. $row->entry_by.'"'); 
$approve_by=find_a_field('user_activity_management','fname','user_id="'. $row->approve_by.'"'); 

?>
                  <tr>
                   <td style="text-align:left;"><?=++$i?></td>
				    <td style="text-align:left;"><?=$item_all->finish_goods_code?></td>
					 <td style="text-align:left"><?=$item_all->item_name?></td>
					  <td style="text-align:right;"><?=number_format($row->total_unit)?></td>
					  <td><?=$item_all->unit_name?></td>
					   <td style="text-align:right;">
						<?php echo  number_format($unit_qty=((1*$row->total_unit)/$item_all->carton_qty),2); ?>
						 </td>
					    <td ><?=$item_all->pack_unit?></td>
						
					   <td></td>
                  </tr> 
				  <?php
				  $tot_qty+=$row->total_unit;
				   } ?>
			
				   
					  <tr>
					 <td colspan="3" style="text-align:right;font-weight:bold;">Total Quantity </td>
					 <td style="text-align:right;"><b><?php echo number_format($tot_qty,0); ?></b></td>
					 <td></td>
					 <td></td>
					<td></td>
					 <td></td>
					</tr> 
                </tbody>
				
              </table>
			  <span ><ul style="margin-top: -16px;"><li><i >All items are received in good quality</i></li></ul></span>
			  

</span>
             
            </div>
			<br><br>
            <div class="row">
			  <div class="col-1"></div>
              <div class="col-2 text-center">
               
                <br>
               <p style="border-top:1px solid">  Received By  </p>
                
              </div>
			   <div class="col-1"></div>
              <div class="col-2 text-center">
               <b></b>
                <br>
               <p style="border-top:1px solid"> Security On Duty  </p>
                
              </div>
		  <div class="col-1"></div>
              <div class="col-2 text-center">
               <b><?php echo $entry_by; ?></b>
                <br>
               <p style="border-top:1px solid"> Prepared By  </p>
                
              </div>
		  <div class="col-1"></div>
              <div class="col-2 text-center">
                <b><?php echo $approve_by; ?></b>
                <br>
                 <p style="border-top:1px solid">Approved By  </p>
                
              </div>
			  <br><br><br>
			      <span>
	<b> Terms & Condition:</b>
	 <ul><li><i>No Return After 07 Days</i></li></ul>
	 </span>
			  
            </div>
          </div> 
        </div>
      </div>
    </section>
 

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>