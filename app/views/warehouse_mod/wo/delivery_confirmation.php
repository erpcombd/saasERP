<?php



session_start();

require_once "../../../controllers/routing/print_view.top.php";

//====================== EOF ===================



//var_dump($_SESSION);




 

 

//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";

// require_once ('../../../acc_mod/common/class.numbertoword.php');



//$chalan_no 		= url_decode(str_replace(' ', '+', $_REQUEST['v_no']));

$chalan_no =url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));




$destination_count= find_a_field('sale_do_chalan','COUNT(destination)','chalan_no="'.$chalan_no.'" and destination!=""');
$referance_count= find_a_field('sale_do_chalan','COUNT(referance)','chalan_no="'.$chalan_no.'" and referance!=""');
$sku_no_count= find_a_field('sale_do_chalan','COUNT(sku_no)','chalan_no="'.$chalan_no.'" and sku_no!=""');
$pack_type_count= find_a_field('sale_do_chalan','COUNT(pack_type)','chalan_no="'.$chalan_no.'" and pack_type!=""');
$color_count= find_a_field('sale_do_chalan','COUNT(color)','chalan_no="'.$chalan_no.'" and color!=""');
$size_count= find_a_field('sale_do_chalan','COUNT(size)','chalan_no="'.$chalan_no.'" and size!=""');

$do_no= find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);

$master= find_all_field('sale_do_master','','do_no='.$do_no);


$ch_data= find_all_field('sale_do_chalan','','chalan_no='.$chalan_no);

$group_data = find_all_field('user_group','group_name','id='.$master->group_for);


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


if(isset($_POST['confirm']) && $_POST['chalan_no']>0){

db_query('update sale_do_chalan set delivery_confirmation="Yes", delivery_confirmation_note="'.$_POST['delivery_note'].'",delivery_confirm_at="'.date('Y-m-d H:i:s').'",delivery_confirm_by="'.$_SESSION['user']['id'].'" where chalan_no="'.$_POST['chalan_no'].'"');
$_SESSION['cmsg'] = '<span style="color:green;">Delivery Confirmation Success!</span>';
header('Location:confirmation_pending.php');
}


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

@media print {
  .brack {page-break-after: always;}
}


#pr input[type="button"] {
	width: 70px;
	height: 25px;
	background-color: #6cff36;
	color: #333;
	font-weight: bolder;
	border-radius: 5px;
	border: 1px solid #333;
	cursor: pointer;
}


@page {
		@bottom-center {
		  content: "Page " counter(page) " of " counter(pages);
		}
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
                        <td width="20%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" style=" width:100%" />
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
					  
					<td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($chalan_no); // Change variable as needed
              $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/wo/delivery_confirmation.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>
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
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">DELIVERY CHALAN </span> </td>
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
		          <td width="13%" align="left" valign="middle" style="font-size:12px; font-weight:700;">Customer Name</td>
		          <td width="30%" style="font-size:12px; font-weight:700;">:	&nbsp;
		            <?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td width="10%">Job No </td>
	              <td width="18%">: &nbsp;<?=$ch_data->job_no; if (!empty($ch_data->job_no)) {echo $ch_data->job_no;} else {echo 'N/A';}?></td>
	              <td width="16%">Driver Name </td>
	              <td width="13%">: &nbsp;
	                <?=$ch_data->driver_name; if (!empty($ch_data->driver_name)) {echo $ch_data->driver_name;} else {echo 'N/A';}?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Address</td>
		          <td>:	&nbsp;
		            <?= find_a_field('dealer_info','address_e','dealer_code="'.$master->dealer_code.'"'); if (!empty($address)) {echo $address;} else {echo 'N/A';}?>					</td>
	              <td>Challan No </td>
	              <td>: 
	                &nbsp;<?=$ch_data->chalan_no;?></td>
	              <td>Driver Contact </td>
	              <td>: &nbsp;<?=$ch_data->driver_mobile;  if (!empty($ch_data->driver_mobile)) {echo $ch_data->driver_mobile;} else {echo 'N/A';}?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Contact Person</td>
		          <td>:	&nbsp;
		            <?= find_a_field('dealer_info','contact_person_name','dealer_code="'.$master->dealer_code.'"'); if (!empty($contact_person)) {echo $contact_person;} else {echo 'N/A';}?></td>
	              <td>Challan Date </td>
	              <td>: &nbsp;<?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>: &nbsp;<?=$ch_data->delivery_man; if (!empty($ch_data->delivery_man)) {echo $ch_data->delivery_man;} else {echo 'N/A';}?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Mobile No </td>
		          <td>:	&nbsp;
	              <?= find_a_field('dealer_info','contact_no','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>Gate Pass </td>
	              <td>: &nbsp;<?php echo $ch_data->chalan_no;?></td>
	              <td>Delivery Man Mobile </td>
	              <td>: &nbsp;<?=$ch_data->delivery_man_mobile; if (!empty($ch_data->delivery_man_mobile)) {echo $ch_data->delivery_man_mobile;} else {echo 'N/A';}?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Point</td>
		           <td>: &nbsp;
	                <?=$ch_data->delivery_point; if (!empty($ch_data->delivery_point)) {echo $ch_data->delivery_point;} else { echo 'N/A';}?></td>
	              <td>Vehicle No </td>
	              <td>: &nbsp;
	                <?=$ch_data->vehicle_no; if (!empty($ch_data->vehicle_no)) {echo $ch_data->vehicle_no;} else {echo 'N/A';}?></td>
	              <td>Receiver Name </td>
	              <td>: &nbsp;<?=$ch_data->rec_name; if (!empty($ch_data->rec_name)) {echo $ch_data->rec_name;} else {echo 'N/A';}?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>Receiver Mobile </td>
		          <td>: &nbsp;<?=$ch_data->rec_mob; if (!empty($ch_data->rec_mob)) {echo $ch_data->rec_mob;} else {echo 'N/A';}?></td>
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
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
       
       
<tr>

<th width="6%" bgcolor="#CCCCCC">SL</th>
<th width="15%" bgcolor="#CCCCCC">Item Code </th>
<th width="42%" bgcolor="#CCCCCC">Item Description </th>
<th width="15%" bgcolor="#CCCCCC">Unit</th>
<th width="22%" bgcolor="#CCCCCC">Quantity</th>
</tr>

        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

$res='select  item_id,unit_price, sum(total_unit) as total_unit,sum(total_amt) as total_amt

 from sale_do_chalan 
 
 WHERE chalan_no='.$chalan_no.' group by id';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>
<td><?=$data->item_id?></td>
<td><?=find_a_field('item_info','item_name','item_id="'.$data->item_id.'"')?></td>
<td style="text-align: center;"><?=find_a_field('item_info','unit_name','item_id="'.$data->item_id.'"')?></td>
<td style="text-align:right;"><?= number_format($data->total_unit, 2) ?></td>

</tr>
        
        <?
		
$total_quantity = $total_quantity + $data->total_unit;
$total_bag_size = $total_bag_size + $data->bag_size;

$total_bag_unit = $total_bag_unit + $data->bag_unit;

		 }
		
		?>
        <tr>

<td colspan="3"><div align="right">&nbsp;</div></td>

<td style="text-align: right;"><strong>  Total:</strong></td>
<td style="text-align: right;"><strong>
  <?= number_format($total_quantity, 2); ?>

</strong></td>
</tr>
      </table>      </td>
  </tr>
  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
  </tr>
  

  
  
  
	
	
	

	<tr>
		<td>
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	<form method="post" name="cz" action="" id="">
	<table width="100%" cellspacing="0" cellpadding="0"  >
	<tr>
            <td colspan="4">
			<input type="hidden" name="chalan_no" id="chalan_no" value="<?=$chalan_no?>" />
			<textarea name="delivery_note" id="delivery_note" cols="140" rows="5" placeholder="Delivery Confirmation Note.." required></textarea></td>
		</tr>
		<tr>
		 <td colspan="4" align="center" style="padding:10px;"><input type="submit" name="confirm" id="confirm" value="Delivery Confirm" style="height:30px; padding:5px; background:#ccc" /></td>
		</tr>
	
	
	</table>
	</form>
	  </div>	</td>
  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
  </tbody>
</table>


</div>
<div class="brack">&nbsp;</div>




</body>
</html>
