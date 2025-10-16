<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$do_no 		= $_REQUEST['v_no'];

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);


$master= find_all_field('sale_do_master','','do_no='.$do_no);



  		  $barcode_content = $do_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$entry_time=$dealer->do_date;


$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;

$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 



$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$master->job_no;?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
	<style>

    table{
        border-collapse: collapse;
		width:100%;
    }
    #heading{
		height:50px;
        text-align: center;
        font-size: 20px;
    }
	
	@media print {
	  body {
		zoom: 80%;
	  }
	}

</style>
</head>


<body>
<div class="body">
	<div class="header">
		
	<div id="pr" style="padding-top:10px;">
        <div align="center">
         	 <p> <input name="button" type="button" onClick="hide();window.print();" value="Print"> </p>    
		</div>
    </div>
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/>
		</td>
		
		<td class="titel">
				<h2 class="text-titel"> <?=$group_data->group_name?> </h2>			
				<p class="text"><?=$group_data->address?></p>
				<p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?></p>
		</td>
		
		
		<td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?php echo $master->do_no;?></p>
		</td>
		
		</tr>
		 
		</table>
	</div>
	
	<table>		
		<tr >
            <td colspan="10" ><div align="center" style="margin-bottom:15px;">Sales Order</div></td>
        </tr>
		
		
		
		<tr>
            <td width="30%">
			 <table width="54%" border="1">
               <tr>
                 <th width="39%" scope="col"><div align="left"><strong>DO Number:</strong></div></th>
                 <th width="61%" scope="col">&nbsp;</th>
               </tr>
               <tr>
                 <td><div align="left"><strong>Buyer Details:</strong></div></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td><div align="left"><strong>Buyer Name:</strong></div></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td><div align="left"><strong>Address:</strong></div></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td><div align="left"><strong>Contact Person:</strong></div></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td><div align="left"><strong>Contact No:</strong></div></td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td><div align="left"><strong>Email:</strong></div></td>
                 <td>&nbsp;</td>
               </tr>
             </table>			</td>
			 
		    <td width="5%">&nbsp;</td>
			 
			<td width="30%">
			 <table width="88%" border="1">
               <tr>
                 <th width="28%" scope="col"><div align="left">DO Date:</div></th>
                 <th width="72%" scope="col"><div align="left">1/1/2024</div></th>
               </tr>
               <tr>
                 <td height="32">Delivery Address:</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>Name:</td>
                 <td>Nazia Carpet, Khulna-Non Woven Carpet</td>
               </tr>
               <tr>
                 <td>Address:</td>
                 <td>Khulna</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>01941-055472</td>
               </tr>
               <tr>
                 <td>&nbsp;</td>
                 <td>Mob- 01925-515941</td>
               </tr>
             </table>		  </td>
			
			<td width="5%">&nbsp;</td>
			
			
			 <td width="30%">
			 <table width="200" border="1">
               <tr>
                 <th width="38%" scope="col"><div align="left">Order Types</div></th>
                 <th width="62%" scope="col">&nbsp;</th>
               </tr>
               <tr>
                 <td>Cash</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td>Payment Date:</td>
                 <td>&nbsp;</td>
               </tr>
       		   </table>		  </td>
		</tr>
		
		
		<tr>
            <td colspan="5">
			  <table border="1" style="margin-top:15px;">
                  <tr>
                    <th width="3%" rowspan="2" scope="col">SL</th>
                    <th colspan="3" scope="col">Description of Goods</th>
                    <th colspan="7" scope="col">Quantity</th>
                    <th width="9%" rowspan="2" scope="col">Due On </th>
                    <th width="7%" rowspan="2" scope="col">Quantity Total </th>
                    <th width="4%" rowspan="2" scope="col">Rate</th>
                    <th width="4%" rowspan="2" scope="col">Per</th>
                    <th width="7%" rowspan="2" scope="col">Amount</th>
                  </tr>
                  <tr>
                    <td width="9%"><strong>Items Name</strong></td>
                    <td width="8%"><strong>Model No.</strong></td>
                    <td width="8%"><strong>Colour</strong></td>
                    <td width="5%"><strong>Length</strong></td>
                    <td width="5%"><strong>Wedth</strong></td>
                    <td width="7%"><strong>Roll / Pcs</strong></td>
                    <td width="7%"><strong>SQ Mtr.</strong></td>
                    <td width="8%"><strong>KG/GSM</strong></td>
                    <td width="5%"><strong>SQ Ft</strong></td>
                    <td width="4%"><strong>Yard</strong></td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>1-Jan-2024</td>
                    <td>1312.34</td>
                    <td>25</td>
                    <td>Sq.ft.</td>
                    <td>32808.5</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>1-Jan-2024</td>
                    <td>1312.34</td>
                    <td>25</td>
                    <td>Sq.ft.</td>
                    <td>32808.5</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>1-Jan-2024</td>
                    <td>1312.34</td>
                    <td>25</td>
                    <td>Sq.ft.</td>
                    <td>32808.5</td>
                  </tr>
                  <tr>
                    <td colspan="12"><div align="right">Total:</div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>			</td>
        </tr>
		
		
		
		<tr>
            <td colspan="16">
			  <table width="100%" style="margin-top:5px;">
			  	<tr>
                    <td>Amount (in words): Taka Eighty Five Thousand Three Hundred Two Only </td>
                </tr>
		      </table>			</td>
        </tr>
		
		
		<tr>
		  <td>
	  		<table width="200" border="1" style="margin-top:15px;">
                  <tr>
                    <th width="66%" scope="row"><div align="left"><strong>Party Balance Details / Smmmery</strong></div></th>
                    <td width="34%">&nbsp;</td>
                  </tr>
                  <tr>
                    <th scope="row"><div align="left"><strong>Previous Balance:</strong></div></th>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <th scope="row"><div align="left"><strong>Order Balance:</strong></div></th>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <th height="23" scope="row"><div align="left"><strong>Current Balance:</strong></div></th>
                    <td>&nbsp;</td>
                  </tr>
                </table>		  </td>
		</tr>
		
		
		<tr>
            <td colspan="16">
			  <table width="100%">
			  	<tr>
                    <td>Note: Sales order no 2216/23.Deposit in IBBL-1208 Tk</td>
                </tr>
		      </table>			</td>
        </tr>
		
		
	
    </table>
	








<div class="footer"  id="footer">
	<!---Discount detaisl -->
	<? 
		$discSql = 'select * from sale_do_discount where 1 and do_no='.$do_no;
		$discQuery = db_query($discSql);
		if(mysqli_num_rows($discQuery)>0){
	?>
	<table class="table1  table-striped table-bordered table-hover table-sm ">
                <thead class="thead1">
                <tr class="bgc-info">
						<th>ID</th>
						<th>Offer Name</th>
						<th>Product Type</th>
						<th>Item Name</th>
						<th>Bill amount over</th>
						
						<th>Bill Period</th>
						<th>Period Days</th>
						<th>Start Date</th>
						<th>End Date</th>
						
						<th>Condition check</th>
						<th>Discount on</th>
						<th>Discount Level</th>
						<th>Base Discount</th>
						
						<th>Additional Discount Rate</th>
						<th>Additional Discount amount (BDT)</th>
						<th>Addional Discount Apply from</th>
						<th>Addional Discount Apply from amount</th>
						
						<th>Start Date</th>
						<th>End Date</th>
						<th>Party Type</th>
						<th>Party Name</th>
                </tr>
                </thead>

                <tbody class="tbody1">
				
				<?  
					while($discData=mysqli_fetch_object($discQuery)){
						$discIdIn[]=$discData->discount_id;
					}
					$discIdIn=implode(',',$discIdIn);
					$sql='select s.* from sale_gift_offer_slab s where s.id in ('.$discIdIn.')';

					$query = db_query($sql);
					while($data=mysqli_fetch_object($query)){
				?>

               <tr>
					<td><?=$data->id?></td>
					<td style="text-align:left"><?=$data->offer_name?></td>
					<td><?=$data->sub_group_id?></td>
					<td style="text-align:left"><?=$data->item_id?></td>
					<td><?=$data->bill_amount_over?></td>
					<td><?=$data->bill_period?></td>
					
					
					<td><?=$data->period_days?></td>
					<td style="text-align:left"><?=$data->p_start_date?></td>
					<td><?=$data->p_end_date?></td>
					<td><?=$data->condition_check?></td>
					
					<td><?=$data->discount_on?></td>
					<td><?=$data->discount_level?></td>
					<td><?=$data->base_discount?></td>
					<td><?=$data->additional_discount?></td>
					
					<td><?=$data->additional_discount_amt?></td>
					<td><?=$data->additional_discount_from?></td>
					
					<td><?=$data->additional_discount_apply_from_amt?></td>
					<td><?=$data->start_date?></td>
					<td><?=$data->end_date?></td>
					<td><?=$data->dealer_type?></td>
					<td><?=$data->dealer_code?></td>
					
				</tr>
					<? }?>
                </tbody>
            </table>				
       <? } ?>

	<table class="footer-table">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>

        <tr class="text-center w-25"> &nbsp;</td>
          <td class="text-center w-25">&nbsp;</td>
		  <td class="text-center w-25">&nbsp;</td>
          <td class="text-center w-25">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
		  <td align="center">-------------------------------</td>
        </tr>
        <tr>
          <td align="center"><strong>Prepared By</strong></td>
          <td align="center"><strong>Checked By</strong></td>
          <td align="center"><strong>Approved By</strong></td>
		  <td align="center"><strong>Authorized By</strong></td>
        </tr>
	
	
	
		<tr>
		<tr>
			<td colspan="4"><?php include("../../../assets/template/report_print_buttom_content.php");?></td>
		</tr>
		  <!--<td colspan="4">  	
				<hr style="color:black;border:1px solid black;" />
				<table width="100%" cellspacing="0" cellpadding="0">
						<tr style=" font-size: 12px; font-weight: 500;">
							<td class="text-left w-33">Printed by: <?=find_a_field('user_activity_management','user_id','user_id='.$_SESSION['user']['id'])?></td>
							<td class="text-center w-33"><?=date("h:i A")?></td>
							<td class="text-right w-33"><?=date("d-m-Y")?></td>
						</tr>
						
						
						<tr>
						<td colspan="4" style="text-align: center;font-size: 11px;color: #444;"> This is an ERP generated report. That is Powered By www.erp.com.bd</td>
						</tr>
				</table>
		  </td>-->
		  </tr>
	</table>

	  </div>
</div>

</body>
</html>
