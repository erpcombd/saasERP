<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no 		= $_REQUEST['v_no'];


$destination_count= find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$referance_count= find_a_field('sale_do_chalan','COUNT(referance)','chalan_no="'.$chalan_no.'" and referance!=""');
$sku_no_count= find_a_field('sale_do_chalan','COUNT(sku_no)','chalan_no="'.$chalan_no.'" and sku_no!=""');
$pack_type_count= find_a_field('sale_do_chalan','COUNT(pack_type)','chalan_no="'.$chalan_no.'" and pack_type!=""');
$color_count= find_a_field('sale_do_chalan','COUNT(color)','chalan_no="'.$chalan_no.'" and color!=""');
$shade_count= find_a_field('sale_do_chalan','COUNT(shade)','chalan_no="'.$chalan_no.'" and shade!=""');

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



$delivery_sql = 'select * from dealer_info where dealer_code='.$ch_data->delivery_place;
$deli_plc = find_all_field_sql($delivery_sql);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$master->job_no;?> - CH<?=$chalan_no;?></title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>
<style type="text/css">



<!--
.header table tr td table tr td table tr td table tr td {
	color: #000;
}



@font-face {
  font-family: 'Andina Demo';
  src: url('Andina Demo.otf'); /* IE9 Compat Modes */

}


/*@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   color: white;
   text-align: center;
}
}*/
-->


div.page_brack
{
    page-break-after:always;   
}



</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$master->group_for?>.png" width="50%" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Account's Copy</h4></td>
					  
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
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            
          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">
	   GATE PASS </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="9%" align="left" valign="middle">Customer Name </td>
		          <td width="2%">:</td>
	              <td width="36%"><?= find_a_field('dealer_group','dealer_group','id="'.$master->dealer_group.'"');?></td>
	              <td width="11%">Job No </td>
	              <td width="1%">:</td>
	              <td width="13%"><?=$master->job_no;?></td>
	              <td width="11%">Vehicle No </td>
	              <td width="1%">:</td>
	              <td width="16%">&nbsp;<?=$ch_data->vehicle_no;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Factory Name</td>
		          <td>:</td>
	              <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>WO No </td>
	              <td>:</td>
	              <td><?=$master->wo_no;?></td>
	              <td>Driver Name </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Place </td>
		          <td>:</td>
	              <td><?=$deli_plc->dealer_name_e;?></td>
	              <td>Challan No </td>
	              <td>:</td>
	              <td><?=$ch_data->chalan_no;?></td>
	              <td>Driver Contact </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Address</td>
		          <td>:</td>
	              <td><?=$deli_plc->address_e;?></td>
	              <td>Challan Date </td>
	              <td>:</td>
	              <td><?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>:</td>
	              <td>&nbsp;<?= $ch_data->delivery_man;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Merchandiser</td>
		          <td>:</td>
	              <td><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
	              <td>Gate Pass No </td>
	              <td>:</td>
	              <td><?=$ch_data->gate_pass;?></td>
	              <td>Mobile No </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->delivery_man_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Buyer</td>
		          <td>:</td>
		          <td><?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
				
				
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td colspan="8">&nbsp;</td>
		          </tr>
		        </table>		      </td>


			
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td><div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
          </p>
          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>	    </div>
      </div>
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:10px">
        
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Referance No</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO No </strong></td>
		  <? if ($destination_count>0) {?>
          <? }?>
		   <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Color</strong></td><? }?>
		    <? if ($shade_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Shade No </strong></td><? }?>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Count</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Lenght</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Qty </strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>CTN</strong></td>
        </tr>
        
        <?    $sqlc = 'select i.unit_name,  i.item_id, i.item_name, c.*
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' and c.total_unit>0  order by c.style_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:10px;">
          <td align="center" valign="top"><?=++$kk1;?></td>
          <td align="left" valign="top">
		  <?=$datac->referance;?></td>
          <td align="left" valign="top">
		  <? 
		  if ($datac->style_no!="") {
		  echo $datac->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
          <td align="left" valign="top">
		   <? 
		  if ($datac->po_no!="") {
		  echo $datac->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
		   <? if ($destination_count>0) {?>
          <? }?>
		  <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td align="left" valign="top"><?=$datac->color;?></td><? }?>
		  <? if ($shade_count>0) {?>
          <td align="left" valign="top"><? 
		  if ($datac->shade!="") {
		  echo $datac->shade;
		  } else {
		  echo 'N/A';
		  }
		  ?>	</td><? }?>
          <td align="center" valign="top"><?=$datac->count;?></td>
          <td align="center" valign="top"><?=$datac->length;?> <?=$datac->length_unit;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $grand_tot_unit1 +=$datac->total_unit; ?> <?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_ctn,0); $grand_total_ctn1 +=$datac->total_ctn; ?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:10px;">
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
		 <? if ($destination_count>0) {?>
        <? }?>
		<? if ($referance_count>0) {?>
        <? }?>
		<? if ($sku_no_count>0) {?>
        <? }?>
		<? if ($pack_type_count>0) {?>
        <? }?>
		 <? if ($color_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($shade_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit1,0) ;?> Cones</strong></td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_total_ctn1,0) ;?> CTN
        </strong></td>
        </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  

  
  
  <?php /*?><tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4" width="50%"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="4" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Challan Summary</strong></td>
          </tr>
        <tr>
          <td width="5%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="46%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="20%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Bundle </strong></td>
          <td width="29%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Pcs </strong></td>
          </tr>
        
        <?  $sqlc = 'select s.sub_group_name, c.delivery_date,  c.item_name as ch_item_name, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm,
		sum(c.bundle_1+c.bundle_2+c.bundle_3) as tot_bundle
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' group by c.item_id order by s.sub_group_id ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="center" valign="top"><?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
          <td align="center" valign="top"><?=number_format($datac->tot_bundle,2);  $tot_bundle_sum1 +=$datac->tot_bundle;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $tot_unit_sum1 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_bundle_sum1,2);?></strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum1,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">&nbsp;
		  	
		  </td>
        </tr>
		
		</table>
		
		</td>
</tr><?php */?>
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center" >Prepared By</td>
		  <td align="center">Checked By</td>
		  <td align="center">Authorized By</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td rowspan="5" align="center"><? if ($ch_data->authorized_by>0) {?>
            <p style="font-size:16px; color:#000000; margin:0; padding: 0; font-family: 'Andina Demo'; font-weight:400; ">
              <?= find_a_field('authorized_by','authorized_by','id="'.$ch_data->authorized_by.'"');?>
            </p>
            <p style="font-size:11px;  margin:-8px 0 0 -20px;  padding: 0 ; letter-spacing:.3px; color: #999999; ">Digitally signed in ERP system</p>
            <?php /*?><p  style="font-size:11px; float:left;   border-left:0; margin:0;  padding: 5px 0 0 50px; letter-spacing:1px; color:#999999; "><?=$master->digital_sign?></p><?php */?>
            <? }?></td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong><?= find_a_field('prepared_by','prepared_by','id='.$ch_data->prepared_by);?> </strong></td>
		    <td  align="center" width="25%"><strong>Security Guard</strong></td>
		    <td  align="center" width="25%"><strong>
		      <?= find_a_field('authorized_by','authorized_by','id='.$ch_data->authorized_by);?>
		    </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center"><?= find_a_field('prepared_by','designation','id='.$ch_data->prepared_by);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center"><?= find_a_field('authorized_by','designation','id='.$ch_data->authorized_by);?></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">This is an ERP generated report </td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="2" style="font-size:12px">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
			
				<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
	
	<?php /*?><tr>
            <td colspan="3">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr><?php */?>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>
</div>


<div class="page_brack" >
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$master->group_for?>.png" width="50%" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Account's Copy</h4></td>
					  
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
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            
          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">
	   GATE PASS </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="9%" align="left" valign="middle">Customer Name </td>
		          <td width="2%">:</td>
	              <td width="36%"><?= find_a_field('dealer_group','dealer_group','id="'.$master->dealer_group.'"');?></td>
	              <td width="11%">Job No </td>
	              <td width="1%">:</td>
	              <td width="13%"><?=$master->job_no;?></td>
	              <td width="11%">Vehicle No </td>
	              <td width="1%">:</td>
	              <td width="16%">&nbsp;<?=$ch_data->vehicle_no;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Factory Name</td>
		          <td>:</td>
	              <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>WO No </td>
	              <td>:</td>
	              <td><?=$master->wo_no;?></td>
	              <td>Driver Name </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Place </td>
		          <td>:</td>
	              <td><?=$deli_plc->dealer_name_e;?></td>
	              <td>Challan No </td>
	              <td>:</td>
	              <td><?=$ch_data->chalan_no;?></td>
	              <td>Driver Contact </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Address</td>
		          <td>:</td>
	              <td><?=$deli_plc->address_e;?></td>
	              <td>Challan Date </td>
	              <td>:</td>
	              <td><?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>:</td>
	              <td>&nbsp;<?= $ch_data->delivery_man;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Merchandiser</td>
		          <td>:</td>
	              <td><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
	              <td>Gate Pass No </td>
	              <td>:</td>
	              <td><?=$ch_data->gate_pass;?></td>
	              <td>Mobile No </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->delivery_man_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Buyer</td>
		          <td>:</td>
		          <td><?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
				
				
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td colspan="8">&nbsp;</td>
		          </tr>
		        </table>		      </td>


			
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td>
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:10px">
        
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Referance No</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO No </strong></td>
		  <? if ($destination_count>0) {?>
          <? }?>
		   <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Color</strong></td><? }?>
		    <? if ($shade_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Shade No </strong></td><? }?>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Count</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Lenght</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Qty </strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>CTN</strong></td>
        </tr>
        
        <?    $sqlc = 'select i.unit_name,  i.item_id, i.item_name, c.*
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' and c.total_unit>0  order by c.style_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:10px;">
          <td align="center" valign="top"><?=++$kk2;?></td>
          <td align="left" valign="top">
		  <?=$datac->referance;?></td>
          <td align="left" valign="top">
		  <? 
		  if ($datac->style_no!="") {
		  echo $datac->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
          <td align="left" valign="top">
		   <? 
		  if ($datac->po_no!="") {
		  echo $datac->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
		   <? if ($destination_count>0) {?>
          <? }?>
		  <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td align="left" valign="top"><?=$datac->color;?></td><? }?>
		  <? if ($shade_count>0) {?>
          <td align="left" valign="top"><? 
		  if ($datac->shade!="") {
		  echo $datac->shade;
		  } else {
		  echo 'N/A';
		  }
		  ?>	</td><? }?>
          <td align="center" valign="top"><?=$datac->count;?></td>
          <td align="center" valign="top"><?=$datac->length;?> <?=$datac->length_unit;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $grand_tot_unit2 +=$datac->total_unit; ?> <?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_ctn,0); $grand_total_ctn2 +=$datac->total_ctn; ?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:10px;">
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
		 <? if ($destination_count>0) {?>
        <? }?>
		<? if ($referance_count>0) {?>
        <? }?>
		<? if ($sku_no_count>0) {?>
        <? }?>
		<? if ($pack_type_count>0) {?>
        <? }?>
		 <? if ($color_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($shade_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit2,0) ;?> Cones</strong></td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_total_ctn2,0) ;?> CTN
        </strong></td>
        </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  

  
  
  <?php /*?><tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4" width="50%"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="4" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Challan Summary</strong></td>
          </tr>
        <tr>
          <td width="5%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="46%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="20%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Bundle </strong></td>
          <td width="29%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Pcs </strong></td>
          </tr>
        
        <?  $sqlc = 'select s.sub_group_name, c.delivery_date,  c.item_name as ch_item_name, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm,
		sum(c.bundle_1+c.bundle_2+c.bundle_3) as tot_bundle
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' group by c.item_id order by s.sub_group_id ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="center" valign="top"><?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
          <td align="center" valign="top"><?=number_format($datac->tot_bundle,2);  $tot_bundle_sum1 +=$datac->tot_bundle;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $tot_unit_sum1 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_bundle_sum1,2);?></strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum1,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">&nbsp;
		  	
		  </td>
        </tr>
		
		</table>
		
		</td>
</tr><?php */?>
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center" >Prepared By</td>
		  <td align="center">Checked By</td>
		  <td align="center">Authorized By</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td rowspan="5" align="center"><? if ($ch_data->authorized_by>0) {?>
            <p style="font-size:16px; color:#000000; margin:0; padding: 0; font-family: 'Andina Demo'; font-weight:400; ">
              <?= find_a_field('authorized_by','authorized_by','id="'.$ch_data->authorized_by.'"');?>
            </p>
            <p style="font-size:11px;  margin:-8px 0 0 -20px;  padding: 0 ; letter-spacing:.3px; color: #999999; ">Digitally signed in ERP system</p>
            <?php /*?><p  style="font-size:11px; float:left;   border-left:0; margin:0;  padding: 5px 0 0 50px; letter-spacing:1px; color:#999999; "><?=$master->digital_sign?></p><?php */?>
            <? }?></td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong><?= find_a_field('prepared_by','prepared_by','id='.$ch_data->prepared_by);?> </strong></td>
		    <td  align="center" width="25%"><strong>Security Guard</strong></td>
		    <td  align="center" width="25%"><strong>
		      <?= find_a_field('authorized_by','authorized_by','id='.$ch_data->authorized_by);?>
		    </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center"><?= find_a_field('prepared_by','designation','id='.$ch_data->prepared_by);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center"><?= find_a_field('authorized_by','designation','id='.$ch_data->authorized_by);?></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">This is an ERP generated report </td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="2" style="font-size:12px">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
			
				<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
	
	<?php /*?><tr>
            <td colspan="3">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr><?php */?>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>
</div>




<div class="page_brack" >
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$master->group_for?>.png" width="50%" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Store Copy</h4></td>
					  
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
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            
          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">
	   GATE PASS </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="9%" align="left" valign="middle">Customer Name </td>
		          <td width="2%">:</td>
	              <td width="36%"><?= find_a_field('dealer_group','dealer_group','id="'.$master->dealer_group.'"');?></td>
	              <td width="11%">Job No </td>
	              <td width="1%">:</td>
	              <td width="13%"><?=$master->job_no;?></td>
	              <td width="11%">Vehicle No </td>
	              <td width="1%">:</td>
	              <td width="16%">&nbsp;<?=$ch_data->vehicle_no;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Factory Name</td>
		          <td>:</td>
	              <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>WO No </td>
	              <td>:</td>
	              <td><?=$master->wo_no;?></td>
	              <td>Driver Name </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Place </td>
		          <td>:</td>
	              <td><?=$deli_plc->dealer_name_e;?></td>
	              <td>Challan No </td>
	              <td>:</td>
	              <td><?=$ch_data->chalan_no;?></td>
	              <td>Driver Contact </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Address</td>
		          <td>:</td>
	              <td><?=$deli_plc->address_e;?></td>
	              <td>Challan Date </td>
	              <td>:</td>
	              <td><?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>:</td>
	              <td>&nbsp;<?= $ch_data->delivery_man;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Merchandiser</td>
		          <td>:</td>
	              <td><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
	              <td>Gate Pass No </td>
	              <td>:</td>
	              <td><?=$ch_data->gate_pass;?></td>
	              <td>Mobile No </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->delivery_man_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Buyer</td>
		          <td>:</td>
		          <td><?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
				
				
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td colspan="8">&nbsp;</td>
		          </tr>
		        </table>		      </td>


			
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td>
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:10px">
        
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Referance No</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO No </strong></td>
		  <? if ($destination_count>0) {?>
          <? }?>
		   <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Color</strong></td><? }?>
		    <? if ($shade_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Shade No </strong></td><? }?>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Count</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Lenght</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Qty </strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>CTN</strong></td>
        </tr>
        
        <?    $sqlc = 'select i.unit_name,  i.item_id, i.item_name, c.*
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' and c.total_unit>0  order by c.style_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:10px;">
          <td align="center" valign="top"><?=++$kk3;?></td>
          <td align="left" valign="top">
		  <?=$datac->referance;?></td>
          <td align="left" valign="top">
		  <? 
		  if ($datac->style_no!="") {
		  echo $datac->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
          <td align="left" valign="top">
		   <? 
		  if ($datac->po_no!="") {
		  echo $datac->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
		   <? if ($destination_count>0) {?>
          <? }?>
		  <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td align="left" valign="top"><?=$datac->color;?></td><? }?>
		  <? if ($shade_count>0) {?>
          <td align="left" valign="top"><? 
		  if ($datac->shade!="") {
		  echo $datac->shade;
		  } else {
		  echo 'N/A';
		  }
		  ?>	</td><? }?>
          <td align="center" valign="top"><?=$datac->count;?></td>
          <td align="center" valign="top"><?=$datac->length;?> <?=$datac->length_unit;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $grand_tot_unit3 +=$datac->total_unit; ?> <?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_ctn,0); $grand_total_ctn3 +=$datac->total_ctn; ?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:10px;">
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
		 <? if ($destination_count>0) {?>
        <? }?>
		<? if ($referance_count>0) {?>
        <? }?>
		<? if ($sku_no_count>0) {?>
        <? }?>
		<? if ($pack_type_count>0) {?>
        <? }?>
		 <? if ($color_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($shade_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit3,0) ;?> Cones</strong></td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_total_ctn3,0) ;?> CTN
        </strong></td>
        </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  

  
  
  <?php /*?><tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4" width="50%"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="4" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Challan Summary</strong></td>
          </tr>
        <tr>
          <td width="5%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="46%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="20%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Bundle </strong></td>
          <td width="29%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Pcs </strong></td>
          </tr>
        
        <?  $sqlc = 'select s.sub_group_name, c.delivery_date,  c.item_name as ch_item_name, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm,
		sum(c.bundle_1+c.bundle_2+c.bundle_3) as tot_bundle
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' group by c.item_id order by s.sub_group_id ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="center" valign="top"><?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
          <td align="center" valign="top"><?=number_format($datac->tot_bundle,2);  $tot_bundle_sum1 +=$datac->tot_bundle;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $tot_unit_sum1 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_bundle_sum1,2);?></strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum1,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">&nbsp;
		  	
		  </td>
        </tr>
		
		</table>
		
		</td>
</tr><?php */?>
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center" >Prepared By</td>
		  <td align="center">Checked By</td>
		  <td align="center">Authorized By</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td rowspan="5" align="center"><? if ($ch_data->authorized_by>0) {?>
            <p style="font-size:16px; color:#000000; margin:0; padding: 0; font-family: 'Andina Demo'; font-weight:400; ">
              <?= find_a_field('authorized_by','authorized_by','id="'.$ch_data->authorized_by.'"');?>
            </p>
            <p style="font-size:11px;  margin:-8px 0 0 -20px;  padding: 0 ; letter-spacing:.3px; color: #999999; ">Digitally signed in ERP system</p>
            <?php /*?><p  style="font-size:11px; float:left;   border-left:0; margin:0;  padding: 5px 0 0 50px; letter-spacing:1px; color:#999999; "><?=$master->digital_sign?></p><?php */?>
            <? }?></td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong><?= find_a_field('prepared_by','prepared_by','id='.$ch_data->prepared_by);?> </strong></td>
		    <td  align="center" width="25%"><strong>Security Guard</strong></td>
		    <td  align="center" width="25%"><strong>
		      <?= find_a_field('authorized_by','authorized_by','id='.$ch_data->authorized_by);?>
		    </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center"><?= find_a_field('prepared_by','designation','id='.$ch_data->prepared_by);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center"><?= find_a_field('authorized_by','designation','id='.$ch_data->authorized_by);?></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">This is an ERP generated report </td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="2" style="font-size:12px">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
			
				<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
	
	<?php /*?><tr>
            <td colspan="3">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr><?php */?>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>
</div>





<div class="page_brack" >
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$master->group_for?>.png" width="50%" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Store Copy</h4></td>
					  
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
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            
          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">
	   GATE PASS </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="9%" align="left" valign="middle">Customer Name </td>
		          <td width="2%">:</td>
	              <td width="36%"><?= find_a_field('dealer_group','dealer_group','id="'.$master->dealer_group.'"');?></td>
	              <td width="11%">Job No </td>
	              <td width="1%">:</td>
	              <td width="13%"><?=$master->job_no;?></td>
	              <td width="11%">Vehicle No </td>
	              <td width="1%">:</td>
	              <td width="16%">&nbsp;<?=$ch_data->vehicle_no;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Factory Name</td>
		          <td>:</td>
	              <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>WO No </td>
	              <td>:</td>
	              <td><?=$master->wo_no;?></td>
	              <td>Driver Name </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Place </td>
		          <td>:</td>
	              <td><?=$deli_plc->dealer_name_e;?></td>
	              <td>Challan No </td>
	              <td>:</td>
	              <td><?=$ch_data->chalan_no;?></td>
	              <td>Driver Contact </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Address</td>
		          <td>:</td>
	              <td><?=$deli_plc->address_e;?></td>
	              <td>Challan Date </td>
	              <td>:</td>
	              <td><?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>:</td>
	              <td>&nbsp;<?= $ch_data->delivery_man;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Merchandiser</td>
		          <td>:</td>
	              <td><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
	              <td>Gate Pass No </td>
	              <td>:</td>
	              <td><?=$ch_data->gate_pass;?></td>
	              <td>Mobile No </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->delivery_man_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Buyer</td>
		          <td>:</td>
		          <td><?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
				
				
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td colspan="8">&nbsp;</td>
		          </tr>
		        </table>		      </td>


			
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td>
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:10px">
        
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Referance No</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO No </strong></td>
		  <? if ($destination_count>0) {?>
          <? }?>
		   <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Color</strong></td><? }?>
		    <? if ($shade_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Shade No </strong></td><? }?>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Count</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Lenght</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Qty </strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>CTN</strong></td>
        </tr>
        
        <?    $sqlc = 'select i.unit_name,  i.item_id, i.item_name, c.*
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' and c.total_unit>0  order by c.style_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:10px;">
          <td align="center" valign="top"><?=++$kk4;?></td>
          <td align="left" valign="top">
		  <?=$datac->referance;?></td>
          <td align="left" valign="top">
		  <? 
		  if ($datac->style_no!="") {
		  echo $datac->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
          <td align="left" valign="top">
		   <? 
		  if ($datac->po_no!="") {
		  echo $datac->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
		   <? if ($destination_count>0) {?>
          <? }?>
		  <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td align="left" valign="top"><?=$datac->color;?></td><? }?>
		  <? if ($shade_count>0) {?>
          <td align="left" valign="top"><? 
		  if ($datac->shade!="") {
		  echo $datac->shade;
		  } else {
		  echo 'N/A';
		  }
		  ?>	</td><? }?>
          <td align="center" valign="top"><?=$datac->count;?></td>
          <td align="center" valign="top"><?=$datac->length;?> <?=$datac->length_unit;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $grand_tot_unit4 +=$datac->total_unit; ?> <?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_ctn,0); $grand_total_ctn4 +=$datac->total_ctn; ?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:10px;">
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
		 <? if ($destination_count>0) {?>
        <? }?>
		<? if ($referance_count>0) {?>
        <? }?>
		<? if ($sku_no_count>0) {?>
        <? }?>
		<? if ($pack_type_count>0) {?>
        <? }?>
		 <? if ($color_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($shade_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit4,0) ;?> Cones</strong></td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_total_ctn4,0) ;?> CTN
        </strong></td>
        </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  

  
  
  <?php /*?><tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4" width="50%"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="4" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Challan Summary</strong></td>
          </tr>
        <tr>
          <td width="5%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="46%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="20%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Bundle </strong></td>
          <td width="29%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Pcs </strong></td>
          </tr>
        
        <?  $sqlc = 'select s.sub_group_name, c.delivery_date,  c.item_name as ch_item_name, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm,
		sum(c.bundle_1+c.bundle_2+c.bundle_3) as tot_bundle
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' group by c.item_id order by s.sub_group_id ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="center" valign="top"><?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
          <td align="center" valign="top"><?=number_format($datac->tot_bundle,2);  $tot_bundle_sum1 +=$datac->tot_bundle;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $tot_unit_sum1 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_bundle_sum1,2);?></strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum1,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">&nbsp;
		  	
		  </td>
        </tr>
		
		</table>
		
		</td>
</tr><?php */?>
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center" >Prepared By</td>
		  <td align="center">Checked By</td>
		  <td align="center">Authorized By</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td rowspan="5" align="center"><? if ($ch_data->authorized_by>0) {?>
            <p style="font-size:16px; color:#000000; margin:0; padding: 0; font-family: 'Andina Demo'; font-weight:400; ">
              <?= find_a_field('authorized_by','authorized_by','id="'.$ch_data->authorized_by.'"');?>
            </p>
            <p style="font-size:11px;  margin:-8px 0 0 -20px;  padding: 0 ; letter-spacing:.3px; color: #999999; ">Digitally signed in ERP system</p>
            <?php /*?><p  style="font-size:11px; float:left;   border-left:0; margin:0;  padding: 5px 0 0 50px; letter-spacing:1px; color:#999999; "><?=$master->digital_sign?></p><?php */?>
            <? }?></td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong><?= find_a_field('prepared_by','prepared_by','id='.$ch_data->prepared_by);?> </strong></td>
		    <td  align="center" width="25%"><strong>Security Guard</strong></td>
		    <td  align="center" width="25%"><strong>
		      <?= find_a_field('authorized_by','authorized_by','id='.$ch_data->authorized_by);?>
		    </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center"><?= find_a_field('prepared_by','designation','id='.$ch_data->prepared_by);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center"><?= find_a_field('authorized_by','designation','id='.$ch_data->authorized_by);?></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">This is an ERP generated report </td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="2" style="font-size:12px">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
			
				<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
	
	<?php /*?><tr>
            <td colspan="3">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr><?php */?>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>
</div>




<div class="page_brack" >
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$master->group_for?>.png" width="50%" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Security Copy</h4></td>
					  
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
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            
          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">
	   GATE PASS </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">


		        <tr>
		          <td width="9%" align="left" valign="middle">Customer Name </td>
		          <td width="2%">:</td>
	              <td width="36%"><?= find_a_field('dealer_group','dealer_group','id="'.$master->dealer_group.'"');?></td>
	              <td width="11%">Job No </td>
	              <td width="1%">:</td>
	              <td width="13%"><?=$master->job_no;?></td>
	              <td width="11%">Vehicle No </td>
	              <td width="1%">:</td>
	              <td width="16%">&nbsp;<?=$ch_data->vehicle_no;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Factory Name</td>
		          <td>:</td>
	              <td><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>WO No </td>
	              <td>:</td>
	              <td><?=$master->wo_no;?></td>
	              <td>Driver Name </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Place </td>
		          <td>:</td>
	              <td><?=$deli_plc->dealer_name_e;?></td>
	              <td>Challan No </td>
	              <td>:</td>
	              <td><?=$ch_data->chalan_no;?></td>
	              <td>Driver Contact </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->driver_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Address</td>
		          <td>:</td>
	              <td><?=$deli_plc->address_e;?></td>
	              <td>Challan Date </td>
	              <td>:</td>
	              <td><?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>:</td>
	              <td>&nbsp;<?= $ch_data->delivery_man;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Merchandiser</td>
		          <td>:</td>
	              <td><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code="'.$master->merchandizer_code.'"');?></td>
	              <td>Gate Pass No </td>
	              <td>:</td>
	              <td><?=$ch_data->gate_pass;?></td>
	              <td>Mobile No </td>
	              <td>:</td>
	              <td>&nbsp;<?=$ch_data->delivery_man_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Buyer</td>
		          <td>:</td>
		          <td><?= find_a_field('buyer_info','buyer_name','buyer_code="'.$master->buyer_code.'"');?></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          </tr>
				
				
		        <tr>
		          <td align="right" valign="center">&nbsp;</td>
		          <td colspan="8">&nbsp;</td>
		          </tr>
		        </table>		      </td>


			
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td>
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:10px">
        
        <tr>
          <td width="4%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="18%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Referance No</strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Style No </strong></td>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>PO No </strong></td>
		  <? if ($destination_count>0) {?>
          <? }?>
		   <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Color</strong></td><? }?>
		    <? if ($shade_count>0) {?>
          <td width="10%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Shade No </strong></td><? }?>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Count</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Lenght</strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Delivery Qty </strong></td>
          <td width="9%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>CTN</strong></td>
        </tr>
        
        <?    $sqlc = 'select i.unit_name,  i.item_id, i.item_name, c.*
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' and c.total_unit>0  order by c.style_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:10px;">
          <td align="center" valign="top"><?=++$kk5;?></td>
          <td align="left" valign="top">
		  <?=$datac->referance;?></td>
          <td align="left" valign="top">
		  <? 
		  if ($datac->style_no!="") {
		  echo $datac->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
          <td align="left" valign="top">
		   <? 
		  if ($datac->po_no!="") {
		  echo $datac->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>		  </td>
		   <? if ($destination_count>0) {?>
          <? }?>
		  <? if ($referance_count>0) {?>
          <? }?>
		  <? if ($sku_no_count>0) {?>
          <? }?>
		  <? if ($pack_type_count>0) {?>
          <? }?>
		  <? if ($color_count>0) {?>
          <td align="left" valign="top"><?=$datac->color;?></td><? }?>
		  <? if ($shade_count>0) {?>
          <td align="left" valign="top"><? 
		  if ($datac->shade!="") {
		  echo $datac->shade;
		  } else {
		  echo 'N/A';
		  }
		  ?>	</td><? }?>
          <td align="center" valign="top"><?=$datac->count;?></td>
          <td align="center" valign="top"><?=$datac->length;?> <?=$datac->length_unit;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,0); $grand_tot_unit5 +=$datac->total_unit; ?> <?=$datac->unit_name;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_ctn,0); $grand_total_ctn5 +=$datac->total_ctn; ?></td>
        </tr>
        
        <? }
		
		?>
        <tr style="font-size:10px;">
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
		 <? if ($destination_count>0) {?>
        <? }?>
		<? if ($referance_count>0) {?>
        <? }?>
		<? if ($sku_no_count>0) {?>
        <? }?>
		<? if ($pack_type_count>0) {?>
        <? }?>
		 <? if ($color_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
		<? if ($shade_count>0) {?>
        <td align="right" valign="middle">&nbsp;</td><? }?>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><strong><?=number_format($grand_tot_unit5,0) ;?> Cones</strong></td>
        <td align="center" valign="middle"><strong>
          <?=number_format($grand_total_ctn5,0) ;?> CTN
        </strong></td>
        </tr>
      </table>
        
	 
	  
	  
      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  
  </tr>
  

  
  
  <?php /*?><tr>
  	<td colspan="2">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4" width="50%"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="4" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Challan Summary</strong></td>
          </tr>
        <tr>
          <td width="5%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="46%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Item Name </strong></td>
          <td width="20%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Bundle </strong></td>
          <td width="29%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Qty in Pcs </strong></td>
          </tr>
        
        <?  $sqlc = 'select s.sub_group_name, c.delivery_date,  c.item_name as ch_item_name, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, sum(c.total_unit) as total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.style_no, c.po_no,  c.paper_combination, c.L_cm, c.W_cm, c.H_cm,
		sum(c.bundle_1+c.bundle_2+c.bundle_3) as tot_bundle
		 from sale_do_chalan c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.chalan_no='.$chalan_no.' group by c.item_id order by s.sub_group_id ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="center" valign="top"><?
		  if ($datac->ch_item_name=="") {
		   echo $datac->item_name;
		  } else {
		   echo $datac->ch_item_name;
		  }
		  ?></td>
          <td align="center" valign="top"><?=number_format($datac->tot_bundle,2);  $tot_bundle_sum1 +=$datac->tot_bundle;?></td>
          <td align="center" valign="top"><?=number_format($datac->total_unit,2); $tot_unit_sum1 +=$datac->total_unit; ?></td>
          </tr>
        
        <? }
		
		?>
        <tr style="font-size:12px;">
        <td colspan="2" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_bundle_sum1,2);?></strong></td>
        <td align="center" valign="middle"><strong><?=number_format($tot_unit_sum1,2) ;?></strong></td>
        </tr>
		
		
		
		
		
		
		
		
		 
        
        
        <?  $sqlc = 'select c.delivery_date, c.delivery_place,c.printing_info,c.additional_info, c.measurement_unit, c.total_unit, c.unit_price, i.unit_name, c.total_amt, i.item_id, i.item_name, c.ply, c.paper_combination, c.L_cm, c.W_cm, c.H_cm from sale_do_details c, item_info i,  item_sub_group s, item_group g where i.item_id=c.item_id and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and c.do_no='.$do_no.' group by c.id order by c.id asc';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			
			
			
			?>
        
        
        <? }
		
		?>
        
      </table></td>
		  <td colspan="3" width="10%">&nbsp;</td>
		  
		  <td colspan="3" width="40%">&nbsp;
		  	
		  </td>
        </tr>
		
		</table>
		
		</td>
</tr><?php */?>
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="3">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center" >Prepared By</td>
		  <td align="center">Checked By</td>
		  <td align="center">Authorized By</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td rowspan="5" align="center"><? if ($ch_data->authorized_by>0) {?>
            <p style="font-size:16px; color:#000000; margin:0; padding: 0; font-family: 'Andina Demo'; font-weight:400; ">
              <?= find_a_field('authorized_by','authorized_by','id="'.$ch_data->authorized_by.'"');?>
            </p>
            <p style="font-size:11px;  margin:-8px 0 0 -20px;  padding: 0 ; letter-spacing:.3px; color: #999999; ">Digitally signed in ERP system</p>
            <?php /*?><p  style="font-size:11px; float:left;   border-left:0; margin:0;  padding: 5px 0 0 50px; letter-spacing:1px; color:#999999; "><?=$master->digital_sign?></p><?php */?>
            <? }?></td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		</tr>
		<tr>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  <td align="center">------------------------------------------------------------------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong><?= find_a_field('prepared_by','prepared_by','id='.$ch_data->prepared_by);?> </strong></td>
		    <td  align="center" width="25%"><strong>Security Guard</strong></td>
		    <td  align="center" width="25%"><strong>
		      <?= find_a_field('authorized_by','authorized_by','id='.$ch_data->authorized_by);?>
		    </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center"><?= find_a_field('prepared_by','designation','id='.$ch_data->prepared_by);?></td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center"><?= find_a_field('authorized_by','designation','id='.$ch_data->authorized_by);?></td>
		  </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">This is an ERP generated report </td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="2" style="font-size:12px">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
			
				<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
	
	<?php /*?><tr>
            <td colspan="3">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >Nassa Group</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: 238, Tejgaon Industrial Area, Gulshan Link Road, Dhaka -1208.</td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: 
			  88-02- 8878543-49. Cell :- +88 01401140030</td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: 
			 www.nassagroup.org</td>
          </tr><?php */?>
	</table>
	  </div>
	</td>
  </tr>
  
  </tbody>
</table>
</div>




</body>
</html>
