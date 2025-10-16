<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$user_id = $_SESSION['user']['id'];
$title = "Delivery Challan Print View";
$page = "delivery_chalan_print_view.php";

require_once '../assets/template/inc.header.php';



$chalan_no 		= $_REQUEST['v_no'];


$destination_count= find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$referance_count= find_a_field('sale_do_chalan','COUNT(referance)','chalan_no="'.$chalan_no.'" and referance!=""');
$sku_no_count= find_a_field('sale_do_chalan','COUNT(sku_no)','chalan_no="'.$chalan_no.'" and sku_no!=""');
$pack_type_count= find_a_field('sale_do_chalan','COUNT(pack_type)','chalan_no="'.$chalan_no.'" and pack_type!=""');
$color_count= find_a_field('sale_do_chalan','COUNT(color)','chalan_no="'.$chalan_no.'" and color!=""');
$size_count= find_a_field('sale_do_chalan','COUNT(size)','chalan_no="'.$chalan_no.'" and size!=""');

$do_no= find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);

$master= find_all_field('sale_do_master','','do_no='.$do_no);

$ssql = 'select * from dealer_info where dealer_code='.$master->dealer_code;
$dealer = find_all_field_sql($ssql);

$ch_data= find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);
$group_data  = find_all_field('user_group','group_name','id='.$ch_data->group_for);



  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}


$entry_time=$dealer->do_date;


$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;



$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 



$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$master->job_no;?> - CH<?=$chalan_no;?></title>
<link href="../assets/styles/invoice.css"  rel="stylesheet"/>



<script type="text/javascript">
function hide()
{
   document.getElementById("pr").style.display="none";
   
   setTimeout(function() {
        document.getElementById("pr").style.display = "block";
   }, 1000);
}
</script>



<style type="text/css">

@font-face {
  font-family: 'MYRIADPRO-REGULAR';
  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */

}

@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}


@font-face {
  font-family: 'Humaira demo';
  src: url('Humaira demo.otf'); /* IE9 Compat Modes */

}


	.btn-print {
		background-color: #0f3193;
		color: white;
		font-weight: bold;
		text-transform: uppercase;
		border: none;
		width: 15%;
	}

	.btn-print:hover {
		background-color: #1a237e;
	}
	.logo_img{
		width: 55% !important;
		}
		.bds th, .bds td{
		
			border: 1px solid black;	
		}
	
    /* Print Styles */
    @media print {
	/*.brack {page-break-after: always;}*/
	    @page {
		  size: A4; /* Set page size to A4 */
		  margin: 0.5cm; /* Set margins */
		}
		
			body{
			margin: 0px !important;
			padding: 0px !important;
			font-size: 14px !important;
			zoom: 55% !important;
			width: 100% !important;
		}
		table{
				font-size: 14px !important;
		}
		.rgn{
			margin: 0px !important;
			padding: 0px !important;	
			
			
		}
		.space{
		display: block !important;}
		
		.online-message,.offline-message,.back_button{
		display:none !important;
		}
        /* .container, */
        #print,
        .card,
        .content,
        .page-content,
        .card-header,
        .row {
            width: 100% !important;
            margin: 0px !important;
            padding: 0px !important;

        }
		

        #printButton {
            display: none;
        }
		
		

        #page,
        #footer,
        .opacity-30 {
            display: none !important;
        }
		.tttt{
		
		margin-right:23px !important;	
	}

/*        .footer div {
            width: 59% !important;
            float: right;
        }*/

        .footer div table {
            width: 100% !important;
        }
		/*.card{
		font-size: 18px !important;	
		zoom
	}*/

	.invoice-header {
			font-size: 32px !important;
			margin-left: -15px !important;
		}
    }

@media (max-width: 767px) {
	.card{
		zoom: 60% !important;
		 margin-top: 100px;
		 font-size: 14px;
			
	}
	

}
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 14px; margin-top: 45px;">

<div class="card  card-style pt-2  p-3" style=" width:97%; ">
<a href="report_list.php" class="back_button"><button class="btn btn-print" style="margin-bottom: 10px; padding: 9px 10px; text-transform: uppercase;  width: 70px !important; background-color: #00BCD4; color: white; border: none; border-radius: 5px; cursor: pointer;">Back </button></a>
							<!--<button id="printButton" onClick="hide();window.print()" class="btn btn-print">Print</button>-->
							
							
							
							<div id="pr"><input name="button" type="button" onclick="hide(); window.print();" value="Print"  style="margin-bottom: 10px; padding: 9px 10px; text-transform: uppercase;  width: 70px !important; background-color: #0f3193; color: white; border: none; border-radius: 5px; cursor: pointer;" />
	</div>
							
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header1">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20%">
					<!--	<img src="../assets/images/logo/LogoMEP.png" alt="Logo" class="logo" style=" width:100%">-->
                        <img src="../assets/images/logo/LogoMEP.png" class="logo_img" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:18px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=$group_data->address?></p>
								<p style="font-size:12px; font-weight:300; color:#000000; margin:0; padding:0;">Phon No. : <?=$group_data->mobile?>,  Email : <?=$group_data->email?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Customer's Copy</h4></td>
					  </tr>
                      
					  <tr>
					  <td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  </tr>
					  
					  
					  </table>
					  </td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>          </tr>
        </table>
      </div></td>
  </tr>

  <tr> <td><hr /></td></tr>

  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:none">DELIVERY CHALLAN </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
<tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
<td width="100%" valign="top">


<table class="rgn" width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">



				
				
		        <tr>
		          <td width="24%"><strong>Distributor Code </strong></td>
		          <td td width="4%"><strong>:&nbsp;
                  <?=$dealer->dealer_code2;?>
		          </strong></td>
		          <td width="18%"><strong>Order No </strong></td>
	              <td width="19%"><strong>:&nbsp;
                  <?=$master->do_no?>
	              </strong></td>
	              <td width="23%"><strong>Driver Name </strong></td>
	              <td width="16%">: &nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle" ><strong>Distributor Name</strong></td>
		          <td><strong>:&nbsp;
		              <?=$dealer->dealer_name_e;?></strong></td>
		          <td width=""><strong>Order Date </strong></td>
	              <td width=""><strong>:&nbsp;<?=$master->do_date;?></strong></td>
	              <td><strong>Driver Contact </strong></td>
	              <td><strong>: &nbsp;<?=$ch_data->driver_mobile;?></strong></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Party Type</strong></td>
		          <td><strong>:&nbsp;<?=find1("select dealer_type from dealer_type where id='".$master->sales_type."' ");?> </strong></td>
		          <td><strong>Challan No </strong></td>
		          <td><strong>:&nbsp;
                  <?=$ch_data->chalan_no;?>
		          </strong></td>
		          <td><strong>Delivery Man </strong></td>
	              <td><strong>: &nbsp;<?=$ch_data->delivery_man;?></strong></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Delivery Address</strong></td>
		          <td><strong>:&nbsp;
		              <?=$dealer->address_e;?></strong></td>
		          <td><strong>Challan Date </strong></td>
		          <td><strong>: &nbsp;<?php echo $ch_data->chalan_date;?></strong></td>
		          <td><strong>Delivery Man Mobile </strong></td>
	              <td><strong>:&nbsp;<?=$ch_data->delivery_man_mobile;?></strong></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Contact Person</strong></td>
		          <td>:	&nbsp;
                      <?=$dealer->contact_person_name;?></td>
		          <td>Vehicle No </td>
		          <td>: <strong>&nbsp;
                      <?=$ch_data->vehicle_no;?></strong></td>
		          <td><strong>Receiver Name </strong></td>
	              <td><strong>: &nbsp;<?=$ch_data->rec_name;?></strong></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Mobile No </strong></td>
		          <td><strong>:	&nbsp;
                      <?=$dealer->mobile_no;?></strong></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td><strong>Receiver Mobile </strong></td>
		          <td><strong>: &nbsp;
		              <?=$ch_data->rec_mob;?></strong></td>
  </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>BIN</strong></td>
		          <td><strong>:	&nbsp;
                      <?=$dealer->bin;?></strong></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
  				</tr>
						        <tr>
						          <td align="left" valign="middle"><strong>Trade Licence </strong></td>
						          <td><strong>:	&nbsp;
                                      <?=$dealer->trade_licence;?></strong></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
  				</tr>
		        </table>





		
		        
		        
		        </td>
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td><div id="pr">
        <div align="left">
         <!-- <p>
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
          </p>-->
          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>	    </div>
      </div>
<div class="table-responsive" style="zoom: 100%;height: auto; overflow-x: auto; overflow-y: auto;border: 1px solid #ddd; ">
<table class="table  text-center table-scroll table_new_border bds">
<thead style=" position: sticky; top: 0; ">
<tr class="bg-night-light1" style="white-space: nowrap;">
<th width="6%" bgcolor="#CCCCCC">SL</th>
<th width="15%" bgcolor="#CCCCCC">Item Code </th>
<th  width="42%" bgcolor="#CCCCCC">Item Description </th>
<th width="10%" bgcolor="#CCCCCC">Pack Size</th>
<th width="10%" bgcolor="#CCCCCC">Unit</th>
<th width="10%" bgcolor="#CCCCCC">Ctn Qty</th>
<th width="10%" bgcolor="#CCCCCC">Pcs</th>
<th width="22%" bgcolor="#CCCCCC">Total Qty</th>
</tr>
</thead>
<tbody>
<? 
$i=1;
 $res='select  c.item_id,i.pack_size,c.unit_price, sum(c.total_unit) as total_unit,sum(c.total_amt) as total_amt,i.finish_goods_code as fg_code,i.pack_size
from sale_do_chalan c, item_info i 
WHERE c.item_id=i.item_id and c.chalan_no='.$chalan_no.' group by c.id order by c.id';
$query = db_query($res);
while($data=mysqli_fetch_object($query)){
?>
<tr>
<td><?=$i++?></td>
<td><?=$data->fg_code?></td>
<td align="left">
    <? if($data->unit_price==0){ ?><strong><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"')?> (Free)</strong> <?}else{ ?>
        <?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"')?>
        
    <? } ?>
</td>
<td><?=$data->pack_size;?></td>
<td><?=find_a_field('item_info','unit_name','item_id="'.$data->item_id.'"')?></td>

<td><div align="right"><?=floor($data->total_unit/$data->pack_size); $gctn+=floor($data->total_unit/$data->pack_size);?></div></td>
<td><div align="right"><?=$data->total_unit % $data->pack_size; $gpcs+=$data->total_unit % $data->pack_size;?></div></td>
<td><div align="right"><?=$data->total_unit?></div></td>

</tr>
<?
		
$total_quantity = $total_quantity + $data->total_unit;
$total_bag_size = $total_bag_size + $data->bag_size;
$total_bag_unit = $total_bag_unit + $data->bag_unit;

}
?>
<tr>

<td colspan="4"><div align="right">&nbsp;</div></td>

<td><div align="right"><strong>  Total:</strong></div></td>
<td><div align="right"><strong><?=$gctn;?></strong></div></td>
<td><div align="right"><strong><?=$gpcs;?></strong></div></td>
<td><div align="right"><strong><?=$total_quantity;?></strong></div></td>
</tr>
</tbody>
</table>      
</div>



</td>
</tr>
  


  
  
  
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		
		
		<tr>
		  <td colspan="4">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
<tr>
	<td align="center" ><?php
		 $ucid=find_a_field('sale_do_master','entry_by','do_no="'.$do_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$ucid.'"')?>
	</td>
	
	
	<td align="center">
		  <?php
		 $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  
	</td>
	
	
	<td align="center"><?php
		 $uid=find_a_field('sale_do_chalan','checked_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  
	</td>
	
	<td></td>
	<td></td>
	<td></td>
		   

</tr>
		<tr>
		  <td align="center" >--------------------</td>
		   <td align="center" >--------------------</td>
		    <td align="center" >--------------------</td>
		    <td align="center" >--------------------</td>
		    <td align="center" >--------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="20%"><strong>Sales Order By</strong></td>
			<td  align="center" width="20%"><strong>Billing Officer</strong></td>
		    <td  align="center" width="20%"><strong>Check By</strong></td>
		    <td  align="center" width="20%"><strong>Depot In-Charge</strong></td>
		    <td  align="center" width="20%"><strong>Received By</strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
			
	
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
			
				<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
	
	
	</table>
	
	
	  </div>	</td>
  </tr>
	
  </tbody>
</table>


</div>



<!--<div class="brack">&nbsp;</div>-->

<div class="card card-style p-3" style=" width:97%; ">
    
    
    
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
  <tr>
    <td><div class="header1">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20%">
                        <img src="../assets/images/logo/LogoMEP.png"  class="logo_img"/>
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:18px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=$group_data->address?></p>
								<p style="font-size:12px; font-weight:300; color:#000000; margin:0; padding:0;">Phon No. : <?=$group_data->mobile?>,  Email : <?=$group_data->email?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
					  
					  <td align="center"><h4 style="font-size:16px;">Office Copy</h4></td>
					  </tr>
                      
					  
					  <tr>
					  
					  <td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  </tr>
					  
					  <tr>
					  
					  <td><span style="font-size:14px; padding: 3px 0 0 10px; letter-spacing:7px;"><?=$chalan_no?></span></td>
					  </tr>
					  </table>						</td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>          </tr>
        </table>
      </div></td>
  </tr>
  

 
 
 
 
 
 

 
  <tr> <td><hr /></td></tr>
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;">DELIVERY CHALLAN  </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td>&nbsp;</td></tr>
  
  
  
 <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="100%" valign="top">


<table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">



				
				
		        <tr>
		          <td width="24%"><strong>Distributor Code </strong></td>
		          <td td width="4%"><strong>:&nbsp;
                  <?=$dealer->dealer_code2;?>
		          </strong></td>
		          <td width="18%"><strong>Order No </strong></td>
	              <td width="19%"><strong>:&nbsp;
                  <?=$master->do_no?>
	              </strong></td>
	              <td width="23%"><strong>Driver Name </strong></td>
	              <td width="16%">: &nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle" ><strong>Distributor Name</strong></td>
		          <td><strong>:&nbsp;
		              <?=$dealer->dealer_name_e;?></strong></td>
		          <td width=""><strong>Order Date </strong></td>
	              <td width=""><strong>:&nbsp;<?=$master->do_date;?></strong></td>
	              <td><strong>Driver Contact </strong></td>
	              <td><strong>: &nbsp;<?=$ch_data->driver_mobile;?></strong></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Party Type</strong></td>
		          <td><strong>:&nbsp;<?=find1("select dealer_type from dealer_type where id='".$master->sales_type."' ");?> </strong></td>
		          <td><strong>Challan No </strong></td>
		          <td><strong>:&nbsp;
                  <?=$ch_data->chalan_no;?>
		          </strong></td>
		          <td><strong>Delivery Man </strong></td>
	              <td><strong>: &nbsp;<?=$ch_data->delivery_man;?></strong></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Delivery Address</strong></td>
		          <td><strong>:&nbsp;
		              <?=$dealer->address_e;?></strong></td>
		          <td><strong>Challan Date </strong></td>
		          <td><strong>: &nbsp;<?php echo $ch_data->chalan_date;?></strong></td>
		          <td><strong>Delivery Man Mobile </strong></td>
	              <td><strong>:&nbsp;<?=$ch_data->delivery_man_mobile;?></strong></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Contact Person</strong></td>
		          <td>:	&nbsp;
                      <?=$dealer->contact_person_name;?></td>
		          <td>Vehicle No </td>
		          <td>: <strong>&nbsp;
                      <?=$ch_data->vehicle_no;?></strong></td>
		          <td><strong>Receiver Name </strong></td>
	              <td><strong>: &nbsp;<?=$ch_data->rec_name;?></strong></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Mobile No </strong></td>
		          <td><strong>:	&nbsp;
                      <?=$dealer->mobile_no;?></strong></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td><strong>Receiver Mobile </strong></td>
		          <td><strong>: &nbsp;
		              <?=$ch_data->rec_mob;?></strong></td>
  </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>BIN</strong></td>
		          <td><strong>:	&nbsp;
                      <?=$dealer->bin;?></strong></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
  				</tr>
						        <tr>
						          <td align="left" valign="middle"><strong>Trade Licence </strong></td>
						          <td><strong>:	&nbsp;
                                      <?=$dealer->trade_licence;?></strong></td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
  				</tr>
		        </table>


	
		        
		        
		        </td>
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td>
      
<div class="table-responsive" style="zoom: 100%;height: auto; overflow-x: auto; overflow-y: auto;border: 1px solid #ddd; ">
					<table class="table table-borderless text-center table-scroll table_new_border bds">
						<thead style=" position: sticky; top: 0; ">
							<tr class="bg-night-light1" style="white-space: nowrap;">
<th width="6%" bgcolor="#CCCCCC">SL</th>
<th width="15%" bgcolor="#CCCCCC">Item Code </th>
<th width="42%" bgcolor="#CCCCCC">Item Description </th>
<th width="10%" bgcolor="#CCCCCC">Pack Size</th>
<th width="10%" bgcolor="#CCCCCC">Unit</th>
<th width="10%" bgcolor="#CCCCCC">Ctn Qty</th>
<th width="10%" bgcolor="#CCCCCC">Pcs</th>
<th width="22%" bgcolor="#CCCCCC">Total Qty</th>
</tr>
</thead>
<tbody>
        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, b.pack_size,b.unit_name, a.*,b.finish_goods_code as fg_code
   from sale_do_chalan a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.chalan_no='.$chalan_no.' order by a.id';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
<tr>

<td><?=$i++?></td>
<td><?=$data->fg_code?></td>
<td align="left">
    <? if($data->unit_price==0){ ?><strong><?=$data->item_name;?> (Free)</strong> <?}else{ ?>
        <?=$data->item_name;?>
    <? } ?>
</td>
<td><?=$data->pack_size?></td>
<td><?=$data->unit_name?></td>
<td><div align="right"><?=floor($data->total_unit/$data->pack_size); $gctn2+=floor($data->total_unit/$data->pack_size);?></div></td>
<td><div align="right"><?=$data->total_unit % $data->pack_size; $gpcs2+=$data->total_unit % $data->pack_size;?></div></td>
<td><div align="right"><?=$data->total_unit?></div></td>
</tr>
        
        <?
		
$total_quantity_2 = $total_quantity_2 + $data->total_unit;
$total_bag_size = $total_bag_size + $data->bag_size;

$total_bag_unit = $total_bag_unit + $data->bag_unit;

		 }
		
		?>
        <tr>


<td colspan="5"><div align="right"><strong>  Total:</strong></div></td>
<td><div align="right"><strong><?=$gctn2;?></strong></div></td>
<td><div align="right"><strong><?=$gpcs2;?></strong></div></td>
<td><div align="right"><strong><?=$total_quantity_2;?></strong></div></td>
</tr>
</tbody>
      </table>   
	  </div>
      
      
      </td>
  </tr>
  
  
  
  
<!--  <tr>
  	<td>&nbsp;</td>
  </tr>
  

  -->
  
  
  
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
<table width="100%" cellspacing="0" cellpadding="0" >
	
	
		
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
		
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
<tr>
	<td align="center" ><?php
		 $ucid=find_a_field('sale_do_master','entry_by','do_no="'.$do_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$ucid.'"')?>
	</td>
	
	
	<td align="center">
		  <?php
		 $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  
	</td>
	
	
	<td align="center"><?php
		 $uid=find_a_field('sale_do_chalan','checked_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  
	</td>
	
	<td></td>
	<td></td>
	<td></td>
		   

</tr>
		<tr>
		  <td align="center" >--------------------</td>
	 	 <td align="center" >--------------------</td>
		  <td align="center" >--------------------</td>
		  <td align="center" >--------------------</td>
		  <td align="center" >--------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="20%"><strong>Sales Order By</strong></td>
			<td  align="center" width="20%"><strong>Billing Officer</strong></td>
		    <td  align="center" width="20%"><strong>Check By</strong></td>
		    <td  align="center" width="20%"><strong>Depot In-Charge</strong></td>
		    <td  align="center" width="20%"><strong>Received By</strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
			
	
		<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
			
				<tr>
            <td colspan="3">&nbsp;  </td>
		</tr>
	
	
	</table>
	  </div>	</td>
  </tr>

	
  </tbody>
</table>
</div>


</body>
</html>
<?php
require_once '../assets/template/inc.footer.php';
?>