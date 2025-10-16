<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);
//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../controllers/routing/print_view.top.php";

// require_once ('../../../acc_mod/common/class.numbertoword.php');

$chalan_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
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
  .brack {page-break-after: avoid;}
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
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px; ">

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
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" style=" width:100%;" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:18px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=find_a_field('user_group','group_name','id='.$master->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$master->group_for)?></p>
								<p style="font-size:12px;  color:#000000; margin:0; padding:0;"><strong>Phone No: <?=$group_data->mobile?></strong>,  <strong>Email : </strong><?=$group_data->email?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                        <td width="20%"> 
						
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					
                      
					  
					  <?php /*?><tr>
					  
					  <td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
					  </tr><?php */?>
					  
					  <td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($chalan_no); // Change variable as needed
              $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/wo/transection_print_view.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>
					  
					  <tr>
					  
					  
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
  	  <td width="50%"  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; ">TRANSACTION: <b>DELIVERY CHALAN</b> </td>
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
	              <td width="18%">: &nbsp;<?=$ch_data->job_no;?></td>
	              <td width="16%">Driver Name </td>
	              <td width="13%">: &nbsp;<?=$ch_data->driver_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Address</td>
		          <td>:	&nbsp;
		            <?= find_a_field('dealer_info','address_e','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>Challan No </td>
	              <td>: 
	                &nbsp;<?=$ch_data->chalan_no;?></td>
	              <td>Driver Contact </td>
	              <td>: &nbsp;<?=$ch_data->driver_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Contact Person</td>
		          <td>:	&nbsp;
                    <?= find_a_field('dealer_info','contact_person','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>Challan Date </td>
	              <td>: &nbsp;<?php echo date('d-m-Y',strtotime($ch_data->chalan_date));?></td>
	              <td>Delivery Man </td>
	              <td>: &nbsp;<?=$ch_data->delivery_man;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Mobile No </td>
		          <td>:	&nbsp;
	              <?= find_a_field('dealer_info','mobile_no','dealer_code="'.$master->dealer_code.'"');?></td>
	              <td>Gate Pass </td>
	              <td>: &nbsp;<?php echo $ch_data->chalan_no;?></td>
	              <td>Delivery Man Mobile </td>
	              <td>: &nbsp;<?=$ch_data->delivery_man_mobile;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">Delivery Point</td>
		           <td>: &nbsp;
	                <?=$ch_data->delivery_point;?></td>
	              <td>Vehicle No </td>
	              <td>: &nbsp;<?=$ch_data->vehicle_no;?></td>
	              <td>Receiver Name </td>
	              <td>: &nbsp;<?=$ch_data->rec_name;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="middle">&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>Receiver Mobile </td>
		          <td>: &nbsp;<?=$ch_data->rec_mob;?></td>
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
	  
	  <h2 style="text-align:center">Challan Details</h2>
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
		<thead>
			<tr bgcolor="#CCCCCC">
				<th>SL</th>
				<th class="w-8">Item Code</th>
				<th>Item Name</th>
				<th>Unit</th>
				<th>Unit Price</th>
				<th>Quantity</th>
				<th>MRP</th>
				<th>Discount % </th>
				<th>Discount</th>
				<th>Net Amt</th>
			</tr>
		</thead>
       
		<tbody>
        
   <? 

//, (a.init_pkt_unit*a.unit_price) as Total,(a.init_pkt_unit-a.inStock_ctn) as Shortage

  $res='select  s.sub_group_name,  b.item_name, a.*,b.m_price
   from sale_do_details a, item_info b, item_sub_group s 
   where b.item_id=a.item_id  and b.sub_group_id=s.sub_group_id and a.do_no='.$do_no.' order by a.id ';
   
   
   $i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>

<td><?=$data->item_id?></td>
<td><?=$data->item_name?>

		<?

		   $gsql = 'select g.offer_name,d.* from sale_gift_offer g, sale_do_details d where g.id=d.gift_id and d.item_id="'.$data->item_id.'" and d.do_no="'.$data->do_no.'"';
		$gquery = db_query($gsql);
		while($qdata=mysqli_fetch_object($gquery)){
		echo '<span style="color:green;"><b>[Offer-'.$qdata->offer_name.']</b></span>';
		}
		?>
</td>
<td  align="center"><?=$data->unit_name?></td>
<td align="right"><?=$data->unit_price?></td>
<td  align="right"><?=$data->total_unit?></td>
<td align="right"><?=($data->total_unit*$data->m_price)?></td>
<td align="right"><?=(int)find_a_field('sale_do_details','discount_per','id='.$data->id);?> %</td>
<td align="right"><?=find_a_field('sale_do_details','discount_amt','id='.$data->id);?></td>
<td  align="right"><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></td>
</tr>
        
        <?  } ?>
        <tr>
			<td colspan="9"  align="right" style="text-align:right;"><strong>  Sub Total</strong></td>
			<td  align="right" style="text-align:right;"><strong> <?=number_format($tot_total_amt,2);?></strong></td>
		</tr>

<tr >
          <td colspan="9"  align="right" style="text-align:right;"><strong> Discount (<?=$master->discount;?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  
		  <strong>
 <?
 $disc_check = find_a_field('sale_do_discount','discount_amt','tr_type = "slab" and do_no='.$do_no);
 if($disc_check >0){
	echo number_format($discount_amt=$disc_check,2);
 }else{
	echo number_format($discount_amt= ($tot_total_amt*$master->discount)/100,2);
 }
  ?>
 
 <? $tot_amt_after_discount = $tot_total_amt-$discount_amt;
    $vat_amt= ($tot_total_amt*$master->vat)/100;
	$ait_amt= ($tot_total_amt*$master->ait)/100;
  ?>
</strong>		  </td>
        </tr>

        <tr>
          <td colspan="9"  align="right" style="text-align:right;"><strong> VAT (<?=$master->vat?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  	<strong>
			 <?=number_format($vat_amt,2); ?>
			</strong>		  </td>
        </tr>
		
		<tr>
          <td colspan="9"  align="right" style="text-align:right;"><strong> AIT (<?=$master->ait?>%)</strong></td>
          <td  align="right" style="text-align:right;">
		  	<strong>
			 <?=number_format($ait_amt,2); ?>
			</strong>		  </td>
        </tr>

        <tr bgcolor="#CCCCCC">
          <td colspan="9"  align="right" style="text-align:right;"><strong> Invoice Amount </strong></td>
          <td  align="right" style="text-align:right;">
		  <strong>
 <?=number_format($invoice_amt= ($tot_amt_after_discount+$vat_amt+$ait_amt),2); ?>
</strong>		  </td>
        </tr>
			</tbody>
    </table>
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
	
		<tr>
		  <td colspan="4">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
		  </tr>
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
	
	</table>
	
	<h2 style="text-align:center">Journal Details</h2>
	
	<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
      <tr bgcolor="#CCCCCC">

        <td align="center"><div align="center">SL</div></td>

        <td align="center">Accounts Head </td>
		<td align="center">Sub Ledger </td>

        <td align="center">Particulars</td>

        <td>Debit</td>

        <td>Credit</td>

      </tr>

      

	  <?

  $sql2="SELECT a.ledger_id,a.ledger_name,cr_amt,dr_amt,b.narration,b.sub_ledger FROM accounts_ledger a, secondary_journal b where b.tr_no='$chalan_no' and a.ledger_id=b.ledger_id and b.tr_from in ('Sales')";

$data2=db_query($sql2);

while($info=mysqli_fetch_object($data2)){		  
$sub_ledger = find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$info->sub_ledger.'"');
	  ?>

      <tr>

        <td align="left"><div align="center">

          <?=++$s;?>

        </div></td>

        <td align="left"><?=$info->ledger_id?>-<?=$info->ledger_name?> <?php if($info->ledger_id=="4014000300000000"){echo " - [ ".$do_commission."% ]";}?></td>

        <td align="left"><?=$sub_ledger?></td>
		   <td align="left"><?=$info->narration?></td>


        <td align="right"><? echo number_format($info->dr_amt,2); $ttd = $ttd + $info->dr_amt;?></td>

        <td align="right"><? echo number_format($info->cr_amt,2); $ttc = $ttc + $info->cr_amt;?></td>

        </tr>

<?php }?>

      <tr bgcolor="#CCCCCC">

        <td colspan="4" align="right">Total Taka: </td>

        <td align="right"><?=number_format($ttd,2)?></td>

        <td align="right"><?=number_format($ttc,2)?></td>

        </tr>

      

    </table></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>Amount in Word : 



	 (<? echo convertNumberMhafuz($ttc)?>)	 </td>

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

    <td>
	
	<h2 style="text-align:center">COGS Details</h2>
	<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">

      <tr bgcolor="#CCCCCC">

        <td align="center"><div align="center">SL</div></td>

        <td align="center">Accounts Head </td>
<td align="center">Sub Ledger </td>
        <td align="center">Particulars</td>

        <td>Debit</td>

        <td>Credit</td>

      </tr>

      

	  <?
$cogs_jv_no = find_a_field('secondary_journal','jv_no','tr_no="'.$jv->tr_no.'" and tr_from="COGS"');
   //$sql2="SELECT a.ledger_id,a.ledger_name,cr_amt,dr_amt,b.narration FROM accounts_ledger a, secondary_journal b where b.jv_no='$jv_no' and a.ledger_id=b.ledger_id and b.tr_from='COGS'";
   
 $sql2="SELECT a.ledger_id,a.ledger_name,cr_amt,dr_amt,b.narration,b.sub_ledger FROM accounts_ledger a, secondary_journal b where b.tr_no='$chalan_no' and a.ledger_id=b.ledger_id and b.tr_from='COGS'";
$data2=db_query($sql2);

while($info=mysqli_fetch_object($data2)){		  
$sub_ledger = find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id="'.$info->sub_ledger.'"');
	  ?>

      <tr>

        <td align="left"><div align="center">

          <?=++$s;?>

        </div></td>

        <td align="left"><?=$info->ledger_id?>-<?=$info->ledger_name?> <?php if($info->ledger_id=="4014000300000000"){echo " - [ ".$do_commission."% ]";}?></td>
 <td align="left"><?=$sub_ledger?></td>
        <td align="left"><?=$info->narration?></td>

        <td align="right"><? echo number_format($info->dr_amt,2); $ttdd = $ttdd + $info->dr_amt;?></td>

        <td align="right"><? echo number_format($info->cr_amt,2); $ttcc = $ttcc + $info->cr_amt;?></td>

        </tr>

<?php }?>

      <tr bgcolor="#CCCCCC">

        <td colspan="4" align="right">Total Taka: </td>

        <td align="right"><?=number_format($ttdd,2)?></td>

        <td align="right"><?=number_format($ttcc,2)?></td>

        </tr>

      

    </table>
	
	
	
	
	
	
	      </td>
  </tr>
  
  
  
  
  
  
  
  
  <tr>

    <td>
	
	<h2 style="text-align:center">Stock Details</h2>
	<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">

      <tr>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >S/L</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >Date</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >Item Name</th>
		<th rowspan="2" bgcolor="#a7d6ff" style="text-align:center" >SR No</th>
		<th colspan="1" bgcolor="#99CC99" style="text-align:center">OPENING BALANCE</th>
		<th colspan="2" bgcolor="#339999" style="text-align:center">PRODUCT RECEIVED</th>
		<th colspan="2" bgcolor="#FFCC66" style="text-align:center">PRODUCT ISSUED</th>
		<th colspan="1" bgcolor="#FFFF99" style="text-align:center">CLOSING BALANCE</th>>
		</tr>
		<tr>
		<th bgcolor="#99CC99" style="text-align:center">Qty</th>

		<th bgcolor="#339999" style="text-align:center">Tr Type</th>
		<th bgcolor="#339999" style="text-align:center">Qty</th>
		<th bgcolor="#FFCC66" style="text-align:center">Tr Type</th>
		<th bgcolor="#FFCC66" style="text-align:center">Qty</th>
		<th bgcolor="#FFFF99" style="text-align:center">Qty</th>
		</tr>
      

	  <?

$op_sql = 'select item_id,sum(item_in-item_ex) as opening from journal_item where ji_date<="'.$ch_data->chalan_date.'" and entry_at<"'.$ch_data->entry_at.'" and warehouse_id="'.$ch_data->depot_id.'" group by item_id';
$op_qry = db_query($op_sql);
while($data=mysqli_fetch_object($op_qry)){
$op_stock[$data->item_id] = $data->opening;
}
$sql2="SELECT sum(c.total_unit) as qty,c.chalan_no,i.item_name,i.item_id,c.chalan_date from sale_do_chalan c, item_info i where c.item_id=i.item_id and c.chalan_no=".$chalan_no." group by c.item_id";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){
$opening = $op_stock[$info->item_id];	  
$stock = $opening - $info->qty;
	  ?>

      <tr>

        <td align="left"><div align="center">

          <?=++$s;?>

        </div></td>

        <td align="left"><?=$info->chalan_date?></td>
 <td align="left"><?=$info->item_name?></td>
        <td align="left"><?=$info->chalan_no?></td>

        <td align="right"><? echo number_format($opening,2); $ttdd = $ttdd + $opening;?></td>

        <td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"><? echo number_format($info->qty,2); $ttcc = $ttcc + $info->qty;?></td>
		<td align="right"><? echo number_format($stock,2); $ttcc = $ttcc + $stock ;?></td>

        </tr>

<?php }?>

     

      

    </table>
	
	
	
	
	
	
	      </td>
  </tr>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  <tr>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>Amount in Word : 



	 (<? echo convertNumberMhafuz($ttcc)?>)	 </td>

  </tr>

  
  
  
  
  <tr>
  
  	<td>&nbsp;</td>
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
		  <td colspan="4">&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
		  </tr>
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
		  
		 $uid=find_a_field('sale_do_chalan','checked_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?></td>
		  <td align="center">
		  <?php
		  
		 $uid=find_a_field('secondary_journal','checked_by','tr_from="Sales" and tr_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>		  </td>
		  <td align="center"><?php
		  
		 $uid=find_a_field('sale_do_chalan','entry_by','chalan_no="'.$chalan_no.'"');
		   echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?></td>
		  <td align="center"></td>
		  </tr>
		<tr>
		  <td align="center" >---------------------------------</td>
		  <td align="center">---------------------------------</td>
		  <td align="center">---------------------------------</td>
		  <td align="center">---------------------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong>Billing Officer </strong></td>
		    <td  align="center" width="25%"><strong>Accounts Manager</strong></td>
		    <td  align="center" width="25%"><strong>Store Officer </strong></td>
		    <td  align="center" width="25%"><strong>Security Incharge </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		<tr>
            <td colspan="3" style="font-size:12px">
                Note: No claims for shortage will be entertained after five days from the delivered date.  </td>
		    <td>This is an ERP generated report </td>
		    </tr>
			
	
			<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
			
				<tr>
            <td colspan="4">&nbsp;  </td>
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

<div class="page_brack" >

</div>


</body>
</html>
