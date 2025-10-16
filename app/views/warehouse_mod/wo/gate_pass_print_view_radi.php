<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no 		= $_REQUEST['v_no'];

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);


$destination_count= find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$referance_count= find_a_field('sale_do_chalan','COUNT(referance)','chalan_no="'.$chalan_no.'" and referance!=""');
$sku_no_count= find_a_field('sale_do_chalan','COUNT(sku_no)','chalan_no="'.$chalan_no.'" and sku_no!=""');
$pack_type_count= find_a_field('sale_do_chalan','COUNT(pack_type)','chalan_no="'.$chalan_no.'" and pack_type!=""');
$color_count= find_a_field('sale_do_chalan','COUNT(color)','chalan_no="'.$chalan_no.'" and color!=""');
$size_count= find_a_field('sale_do_chalan','COUNT(size)','chalan_no="'.$chalan_no.'" and size!=""');

$do_no= find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);

$master= find_all_field('sale_do_master','','do_no='.$do_no);


$ch_data= find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);



  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.*,b.do_date, b.group_for, b.via_customer from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;



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
  <title>Invoice View</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$master->job_no;?> - CH<?=$chalan_no;?></title>
  <?php include("../../../../public/assets/css/theme_responsib_new_table_report1.php");?>
  <link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
  <style>
  
  
	body {
    width: 1186px;
    margin: 0 auto;
    font-size: 16px;
}
@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); 
}

@media print {
	body{
		width:  100% !important;
		font-size: 18px !important;
	 }
}
  </style>
</head>
<body style="font-family: Poppins, serif;">

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td width="20%" ><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/></td>
        <td width="60%" align="center">
				<p style="font-size:28px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"> <?=$group_data->group_name?> </p>			  
				<p class="text"><strong>Address: </strong><?=$group_data->address?></p>
				<p class="text"><strong>Cell:</strong> <?=$group_data->mobile?>. <strong>Email: </strong><i><?=$group_data->email?> </i><br><strong> <?=$group_data->vat_reg?> </strong></p>
		</td>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td ><h4 style="font-size:16px; margin-left:30px;">Customer Copy</h4></td>
					  </tr>
                      
					  
					  <tr>
					  
					  <td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  </tr>
					  
					  <tr>
					  
					  <td><span style="font-size:14px; padding: 3px 0 0 10px; letter-spacing:7px;"><?=$chalan_no?></span></td>
					  </tr>
					  </table>	
					  </td>
					  </tr>
					  </table>     
  </tr>
   <tr><td><hr class="hr mt-1 mb-1"/></td></tr>
  </thead>
  <tbody>
  <tr>
    <td>
	<table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td>
		<h5 class=" text-center font-weight-bold mt-0 ml-0 mb-2 ">GATE PASS</h5>
		
		</td>
      </tr>
      <tr>
        <td>
		<table width="100%" cellspacing="0" cellpadding="2" border="0" >
          <tr>
            <td width="30%">
				<table>
				<tr>
				<td width="40%">Customer Name </td>
			<td width="60%" > : <?= $customer= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');
				echo !empty($customer) ? $customer: 'N/A'; ?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td>:  <?= $address=find_a_field('dealer_info','address_e','dealer_code="'.$master->dealer_code.'"');
					echo !empty($address) ? $address : 'N/A'; ?></td>
				</tr>
				<tr>
					<td>Contact Person </td>
					<td> : <?= $contact=find_a_field('dealer_info','contact_person','dealer_code="'.$master->dealer_code.'"');
					echo !empty($contact) ? $contact: 'N/A';?></td>
				</tr>
				<tr>
					<td>Mobile No</td>
					<td>:  <?= $mobile=find_a_field('dealer_info','mobile_no','dealer_code="'.$master->dealer_code.'"');
					echo !empty($mobile) ? $mobile: 'N/A';?></td>
				</tr>
				<tr>
					<td>Delivery Point</td>
					<td>: <?php echo !empty ($ch_data->delivery_point) ? $ch_data->delivery_point: 'N/A' ;?></td>
				</tr>
				</table>
			</td>
				
			
            <td width="30%">
			<table width="100%" cellspacing="0" cellpadding="2" border="0">
			<tr>
					<td width="32%">Job No </td>
					<td width="68%"> : <?php echo!empty($ch_data->job_no) ? $ch_data->job_no: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Challan No</td>
					<td >: <?php echo !empty($ch_data->chalan_no) ? $ch_data->chalan_no: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Challan Date</td>
					<td >: <?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
				</tr>
				<tr>
					<td >Gate Pass</td>
					<td >:  <?php echo !empty($ch_data->chalan_no) ? $ch_data->chalan_no: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Vehicle No</td>
					<td >: <?php echo !empty($ch_data->vehicle_no) ? $ch_data->vehicle_no: 'N/A' ;?></td>
				</tr>
			</table>
			</td>
				
			
            <td width="30%" >

				<table width="100%" cellspacing="0" cellpadding="2" border="0">
				
				<tr>
					<td width="50%"> Driver Name </td>
					<td width="50%"> : <?php echo!empty($ch_data->driver_name) ? $ch_data->driver_name: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Driver Contact</td>
					<td >: <?php echo !empty($ch_data->driver_mobile) ? $ch_data->driver_mobile: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Delivery Man</td>
					<td>: <?php echo !empty($ch_data->delivery_man) ? $ch_data->delivery_man: 'N/A' ;?></td>
				</tr>
				<tr>
					<td>Delivery Man Mobile</td>
					<td>: <?php echo !empty($ch_data->delivery_man_mobile) ? $ch_data->delivery_man_mobile: 'N/A' ;?></td>
				</tr>
				<tr>
					<td>Receiver Name</td>
					<td>: <?php echo !empty($ch_data->rec_name) ? $ch_data->rec_name: 'N/A' ;?></td>
				</tr>
				<tr>
					<td>Receiver Mobile </td>
					<td>: <?php echo !empty($ch_data->rec_mob) ? $ch_data->rec_mob : 'N/A' ;?></td>
				</tr>
				<?php /*?><tr>
					<td><p class="text1 mb-0"><strong>Purchase Order No: </strong><?php echo $master->po_no;?></p>
			<p class="text1 mb-0">Purchase Order Date: <?php echo $master->po_date;?></p>
			<p class="text1">Purchase Requisition No:  <?php echo $master->req_no;?></p></td>
				</tr><?php */?>
				</table>
			</td>
          </tr>
        </table>
		</td>
      </tr>
      
      <tr>
        <td>
		<div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onClick="hide();window.print();" value="Print" />
          </p>	    
		  </div>
      </div>
		<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr>
				<th class="text-center">SL</th>
				<th class="w-15 text-center">Item Code</th>
				<th  class="w-35 ">Item Discription</th>
				<th class="text-center">Unit</th>
				<th class="text-center">Quantity</th>
				
			</tr>
			
           <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

   $res='select  s.sub_group_name,  b.item_name, b.unit_name, a.*
   from sale_do_chalan a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.chalan_no='.$chalan_no.' order by a.id asc';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td class="text-center"><?=$i++?></td>
<td class="text-center"><?=$data->item_id?></td>
<td><?=$data->item_name?></td>
<td class="text-center"><?=$data->unit_name?></td>
<td class="text-center"><?=$data->total_unit?></td>
</tr>
        
        <?
		
$total_quantity_2 = $total_quantity_2 + $data->total_unit;
$total_bag_size = $total_bag_size + $data->bag_size;

$total_bag_unit = $total_bag_unit + $data->bag_unit;

		 }
		
		?>
        <tr>

<td colspan="4"><div align="right"><strong>  Total:</strong></div></td>


<td class="text-center"><strong>
  <?=number_format($total_quantity_2,0);?>
</strong></td>
</tr>
			  
        
        </table></td>
      </tr>
     
      <tr>
        <td >
		<table width="100%" cellspacing="0" cellpadding="7" border="1" class="mb-1 mt-4">
			<tr>
				<td><p class=" mb-1 ml-1 mt-1"><strong>Note: </strong>No claims for shortage will be entertained after five days from the delivered date.</p>
				

			</tr>
		</table></td>
      </tr>
     
				</table>		  
			</td>
	   </tr>

    </table></td>
  </tr>
  <tr>
  <td><p class="p-text mt-2 mb-5">	Thanking You, </p></td>
  </tr>
 <tr>
		<table width="100%" cellspacing="0" cellpadding="0"  >
		
		   <tr>
		 	  <td align="center" ><?php
		  
		 $ucid=find_a_field('sale_do_master','entry_by','do_no="'.$do_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$ucid.'"')?></td>
		     <td align="center">
		  <?php
		  
		 $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  </td>
		  <td align="center"><?php
		  
		 $uid=find_a_field('sale_do_chalan','checked_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  </td>
		
		  <td align="center">
		  <?php
		  
		 $uid=find_a_field('secondary_journal','checked_by','tr_from="Sales" and tr_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?></td>
		   
		  
		  </tr>
		<tr>
		  <td align="center" >---------------</td>
		   <td align="center" >---------------</td>
		    <td align="center" >---------------</td>
		    <td align="center" >---------------</td>
		   
		  </tr>
		
		<tr style="font-size:12px">
             <td align="center" width="25%"><strong>Billing Officer </strong></td>
		    <td  align="center" width="25%"><strong>Accounts Manager</strong></td>
		    <td  align="center" width="25%"><strong>Store Officer </strong></td>
		    <td  align="center" width="25%"><strong>Security Incharge </strong></td>
		    </tr>
		
		
		
		
			
	
			
	
	</table>
	
    </table></td>
  </tr>
 </tbody>
   <tfoot>

  
	

		
			
		
  </tr>
 
  
  
    </tfoot>
	<?php include("../../../controllers/routing/report_print_buttom_content1.php");?>
</table>
<br><br><br>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td width="20%" ><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/></td>
        <td width="60%" align="center">
				<p style="font-size:28px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"> <?=$group_data->group_name?> </p>			  
				<p class="text"><strong>Address: </strong><?=$group_data->address?></p>
				<p class="text"><strong>Cell:</strong> <?=$group_data->mobile?>. <strong>Email: </strong><i><?=$group_data->email?> </i><br><strong> <?=$group_data->vat_reg?> </strong></p>
		</td>
		<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td ><h4 style="font-size:16px; margin-left:30px;">Office Copy</h4></td>
					  </tr>
                      
					  
					  <tr>
					  
					  <td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  </tr>
					  
					  <tr>
					  
					  <td><span style="font-size:14px; padding: 3px 0 0 10px; letter-spacing:7px;"><?=$chalan_no?></span></td>
					  </tr>
					  </table>	
					  </td>
					  </tr>
					  </table>     
  </tr>
   <tr><td><hr class="hr mt-1 mb-1"/></td></tr>
  </thead>
  <tbody>
  <tr>
    <td>
	<table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td>
		<h5 class=" text-center font-weight-bold mt-0 ml-0 mb-2 ">GATE PASS</h5>
		
		</td>
      </tr>
      <tr>
        <td>
		<table width="100%" cellspacing="0" cellpadding="2" border="0" >
          <tr>
            <td width="30%">
				<table>
				<tr>
				<td width="40%">Customer Name </td>
			<td width="60%" > : <?= $customer= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');
				echo !empty($customer) ? $customer: 'N/A'; ?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td>:  <?= $address=find_a_field('dealer_info','address_e','dealer_code="'.$master->dealer_code.'"');
					echo !empty($address) ? $address : 'N/A'; ?></td>
				</tr>
				<tr>
					<td>Contact Person </td>
					<td> : <?= $contact=find_a_field('dealer_info','contact_person','dealer_code="'.$master->dealer_code.'"');
					echo !empty($contact) ? $contact: 'N/A';?></td>
				</tr>
				<tr>
					<td>Mobile No</td>
					<td>:  <?= $mobile=find_a_field('dealer_info','mobile_no','dealer_code="'.$master->dealer_code.'"');
					echo !empty($mobile) ? $mobile: 'N/A';?></td>
				</tr>
				<tr>
					<td>Delivery Point</td>
					<td>: <?php echo !empty ($ch_data->delivery_point) ? $ch_data->delivery_point: 'N/A' ;?></td>
				</tr>
				</table>
			</td>
				
			
            <td width="30%">
			<table width="100%" cellspacing="0" cellpadding="2" border="0">
			<tr>
					<td width="32%">Job No </td>
					<td width="68%"> : <?php echo!empty($ch_data->job_no) ? $ch_data->job_no: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Challan No</td>
					<td >: <?php echo !empty($ch_data->chalan_no) ? $ch_data->chalan_no: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Challan Date</td>
					<td >: <?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
				</tr>
				<tr>
					<td >Gate Pass</td>
					<td >:  <?php echo !empty($ch_data->chalan_no) ? $ch_data->chalan_no: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Vehicle No</td>
					<td >: <?php echo !empty($ch_data->vehicle_no) ? $ch_data->vehicle_no: 'N/A' ;?></td>
				</tr>
			</table>
			</td>
				
			
            <td width="30%" >

				<table width="100%" cellspacing="0" cellpadding="2" border="0">
				
				<tr>
					<td width="50%"> Driver Name </td>
					<td width="50%"> : <?php echo!empty($ch_data->driver_name) ? $ch_data->driver_name: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Driver Contact</td>
					<td >: <?php echo !empty($ch_data->driver_mobile) ? $ch_data->driver_mobile: 'N/A' ;?></td>
				</tr>
				<tr>
					<td >Delivery Man</td>
					<td>: <?php echo !empty($ch_data->delivery_man) ? $ch_data->delivery_man: 'N/A' ;?></td>
				</tr>
				<tr>
					<td>Delivery Man Mobile</td>
					<td>: <?php echo !empty($ch_data->delivery_man_mobile) ? $ch_data->delivery_man_mobile: 'N/A' ;?></td>
				</tr>
				<tr>
					<td>Receiver Name</td>
					<td>: <?php echo !empty($ch_data->rec_name) ? $ch_data->rec_name: 'N/A' ;?></td>
				</tr>
				<tr>
					<td>Receiver Mobile </td>
					<td>: <?php echo !empty($ch_data->rec_mob) ? $ch_data->rec_mob : 'N/A' ;?></td>
				</tr>
				<?php /*?><tr>
					<td><p class="text1 mb-0"><strong>Purchase Order No: </strong><?php echo $master->po_no;?></p>
			<p class="text1 mb-0">Purchase Order Date: <?php echo $master->po_date;?></p>
			<p class="text1">Purchase Requisition No:  <?php echo $master->req_no;?></p></td>
				</tr><?php */?>
				</table>
			</td>
          </tr>
        </table>
		</td>
      </tr>
      
      <tr>
        <td>
		<div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onClick="hide();window.print();" value="Print" />
          </p>	    
		  </div>
      </div>
		<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr>
				<th class="text-center">SL</th>
				<th class="w-15 text-center">Item Code</th>
				<th  class="w-35 ">Item Discription</th>
				<th class="text-center">Unit</th>
				<th class="text-center">Quantity</th>
				
			</tr>
			
           <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

   $res='select  s.sub_group_name,  b.item_name, b.unit_name, a.*
   from sale_do_chalan a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.chalan_no='.$chalan_no.' order by a.id asc';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td class="text-center"><?=$i++?></td>
<td class="text-center"><?=$data->item_id?></td>
<td><?=$data->item_name?></td>
<td class="text-center"><?=$data->unit_name?></td>
<td class="text-center"><?=$data->total_unit?></td>
</tr>
        
        <?
		
$total_quantity_2 = $total_quantity_2 + $data->total_unit;
$total_bag_size = $total_bag_size + $data->bag_size;

$total_bag_unit = $total_bag_unit + $data->bag_unit;

		 }
		
		?>
        <tr>

<td colspan="4"><div align="right"><strong>  Total:</strong></div></td>


<td class="text-center"><strong>
  <?=number_format($total_quantity_2,0);?>
</strong></td>
</tr>
			  
        
        </table></td>
      </tr>
     
      <tr>
        <td >
		<table width="100%" cellspacing="0" cellpadding="7" border="1" class="mb-1 mt-4">
			<tr>
				<td><p class=" mb-1 ml-1 mt-1"><strong>Note: </strong>No claims for shortage will be entertained after five days from the delivered date.</p>
				

			</tr>
		</table></td>
      </tr>
     
				</table>		  
			</td>
	   </tr>

    </table></td>
  </tr>
  <tr>
  <td><p class="p-text mt-2 mb-5">	Thanking You, </p></td>
  </tr>
 <tr>
		<table width="100%" cellspacing="0" cellpadding="0"  >
		
		   <tr>
		 	  <td align="center" ><?php
		  
		 $ucid=find_a_field('sale_do_master','entry_by','do_no="'.$do_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$ucid.'"')?></td>
		     <td align="center">
		  <?php
		  
		 $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  </td>
		  <td align="center"><?php
		  
		 $uid=find_a_field('sale_do_chalan','checked_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  </td>
		
		  <td align="center">
		  <?php
		  
		 $uid=find_a_field('secondary_journal','checked_by','tr_from="Sales" and tr_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?></td>
		   
		  
		  </tr>
		<tr>
		  <td align="center" >---------------</td>
		   <td align="center" >---------------</td>
		    <td align="center" >---------------</td>
		    <td align="center" >---------------</td>
		   
		  </tr>
		
		<tr style="font-size:12px">
             <td align="center" width="25%"><strong>Billing Officer </strong></td>
		    <td  align="center" width="25%"><strong>Accounts Manager</strong></td>
		    <td  align="center" width="25%"><strong>Store Officer </strong></td>
		    <td  align="center" width="25%"><strong>Security Incharge </strong></td>
		    </tr>
		
		
		
		
			
	
			
	
	</table>
	
    </table></td>
  </tr>
 </tbody>
   <tfoot>

  
	

		
			
		
  </tr>
 
  
  
    </tfoot>
	<?php include("../../../controllers/routing/report_print_buttom_content.php");?>
</table>
    <script>
        // JavaScript for page number counting
        function updatePageNumber() {
            var pageNumberElement = document.getElementById('footer');
            var totalPages = document.querySelectorAll('.pagedjs_page').length;

            pageNumberElement.textContent = 'Page ' + window.pagedConfig.pageCount + ' of ' + totalPages;
        }

        // Call the updatePageNumber function when the page is loaded and after printing
        window.onload = updatePageNumber;
        window.onafterprint = updatePageNumber;
    </script>
</body>
</html>