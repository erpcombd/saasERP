<?php



session_start();

ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Vendor Statement';

$proj_id=$_SESSION['proj_id'];

$fromdate=$_POST['fdate'];
$todate=$_POST['tdate'];


?>



<form id="form1" name="form1" method="post" action="">
								            
	<div class="container-fluid bg-form-titel">
        <div class="row">
				<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 pt-1 pb-1 row m-0">
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
							<div class="form-group row m-0">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-center align-items-center pr-1 bg-form-titel-text">From Date : </label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								 
                                        <input name="fdate" type="date" id="fdate" class="form-control"  value="<?php echo $_REQUEST['fdate'];?>" required /> 
      
								</div>
							</div>
	
						</div>
	
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
							<div class="form-group row m-0">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-center align-items-center pl-1 bg-form-titel-text">To Date : </label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
	                                   
	                                    <input name="tdate" type="date" id="tdate" class="form-control" value="<?php echo $_REQUEST['tdate'];?>" required />
								</div>
							</div>
						</div>
					</div>
					
                    <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                        <div class="form-group row m-0">
                            <label class="col-sm-3 col-md-3 col-lg-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor Name :</label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 pr-3">
                              <div>  										
                            	 				<?php
                             				 $sql33="SELECT vendor_id,vendor_name from vendor";
                             
                            					$query23=db_query($sql33);
                            
                             		?>
                             				<select name="customer_name" id="customer_name" class="customer_name" value="<?=$_POST['customer_name'];?>"> </td>

                            				<option></option>
                             	 <?php 
                              
                             				 while($datarow=mysqli_fetch_object($query23)){
                              
                              
                             	 ?>
                            
                                          
                            		 		<option><?=$datarow->vendor_name?>--<?=$datarow->vendor_id?></option> 
                            			   
                             <?php }?>
							 </select>
                            		
		                     </div>

                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="n-form-btn-class">
                    
                    <input class="btn1 btn1-bg-submit" name="show" type="submit" id="show" value="Show" />
                    
                </div>

    </div>

</form>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report">
								        
								        <form id="form1" name="form1" method="post" action="">

									

								    </form></div></td>

						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td> <div id="reporting">
									<?php 
									
									
  if(isset($_POST['show']))

  {

 $fdate=$_POST['fdate'];
 $tdate=$_POST['tdate'];

$customer_name=explode("--",$_POST["customer_name"]);
$customer_id=$customer_name[1];
//$cus_ledger=find_a_field('vendor','dealer_code','dealer_code='.$customer_name);
$cc_code = (int) $_POST['cc_code'];

	if($_POST['customer_name']!==''){
	$con.= 'and vendor_id = "'.$customer_id.'"';
	}
	







									
									?>

							<table class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0" id="grp">

							 <tr>

								<th width="10%" height="20" align="center">S/N</th>

								<th width="30%" align="center">Vendor Name</th>
								<th width="20%" height="20" align="center">Opening</th>

								<th width="20%" height="20" align="center">Debit</th>

								<th width="20%" align="center">Credit</th>

								<th width="20%" align="center">Balance</th>

							

							  </tr>

  <?php



$sql= "select vendor_id,vendor_name,ledger_id, sub_ledger_id from vendor where 1 ".$con." ";
	
$query=db_query($sql);
while($row=mysqli_fetch_object($query)){

$opening=find_a_field('journal','SUM(dr_amt-cr_amt)','sub_ledger="'.$row->sub_ledger_id.'"  and jv_date<"'.$fdate.'"');
 $total_debit=find_a_field('journal','SUM(dr_amt)','sub_ledger="'.$row->sub_ledger_id.'"  and jv_date between "'.$fdate.'" and "'.$tdate.'"');
  
   $test='select * from journal where sub_ledger="'.$row->sub_ledger_id.'"  and jv_date between "'.$fdate.'" and "'.$tdate.'"';
$total_credit=find_a_field('journal','SUM(cr_amt)','sub_ledger="'.$row->sub_ledger_id.'"  and jv_date between "'.$fdate.'" and "'.$tdate.'"');
	$balance=round(($opening+$total_debit)-$total_credit,2);

if($balance>0){
  $status1="Dr";
}
else{
 $status1="Cr";
}

  ?>
                <? if($balance!=0) { ?>
				<tr >

				<td align="center"><?= ++$i;?></td>

				<td align="center"><?=$row->vendor_name;?> </td>
				<td align="center"><?=$opening;?> </td>
                
				<td align="center"> <a href="vendor_dr_details.php?sub_ledger=<?=$row->sub_ledger_id; ?>&fdate=<?=$fromdate ?>&tdate=<?=$todate?>&led_id=<?=$row->sub_ledger_id?>" target="blank"><?php echo $total_debit;?></a> </td>
                
                
               
				<td align="left"><a href="vendor_cr_details.php?sub_ledger=<?=$row->sub_ledger_id; ?>&fdate=<?=$fromdate ?>&tdate=<?=$todate?>&led_id=<?=$row->sub_ledger_id?>" target="blank"><?= $total_credit;?></a></td>
              
				<td align="center"><?= $balance."  (".$status1." )";?></td>
				</tr>
                <? } ?>
				<?php 
			  
$debit_sum= $debit_sum+$total_debit;
$credit_sum= $credit_sum+$total_credit;
$balance_sum=$balance_sum+$balance;

} ?>
				
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				</tr>
				
				
				<tr style="font-weight:bold;">

				<td align="center"></td>
				<td align="center"></td>

				<td align="center">Total </td>

				<td align="center"><?=$debit_sum;?></td>

				<td align="left"><?=$credit_sum;?></td>
<?php 
if($debit_sum>$credit_sum){
  $status="Dr";
}
else{
 $status="Cr";
}
?>
				<td align="center"><?=$balance_sum." ( ".$status.")";?></td>

				</tr>




</table><?php } ?> </div>

			<div id="pageNavPosition"></div>

			</td>

			</tr>

		</table>

		</div></td>

    

  </tr>

</table>




<?
selected_two("#customer_name");
require_once SERVER_CORE."routing/layout.bottom.php";
?>