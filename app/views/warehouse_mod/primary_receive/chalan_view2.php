<?php
require_once "../../../controllers/routing/print_view.top.php";

//$pmr_no = $_REQUEST['pmr_no'];

$pmr_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));


$datas = find_all_field('primary_receive_purchase','','pmr_no='.$pmr_no);

$sql1 = "select b.* from primary_receive_purchase b where b.pmr_no = '".$pmr_no."'";
$data1 = db_query($sql1);




$pi=0;
$total=0;

while($info=mysqli_fetch_object($data1)){ 
    $pi++;
    $rec_date=$info->rec_date;
    $rec_no=$info->rec_no;
    $po_no=$info->po_no;
    $po_date= find_a_field('purchase_master','po_date','po_no='.$po_no);
    $order_no[]=$info->order_no;
    $ch_no=$info->ch_no;
    $warehouse_id=$info->warehouse_id;
    $qc_by=$info->qc_by;
    $qc_by_name= find_a_field('user_activity_management','fname','user_id='.$qc_by);
    $mobile=  find_a_field('user_activity_management','mobile','user_id='.$qc_by);
    $entry_at=$info->entry_at;
    $entry_by=$info->entry_by;
    $item_id[] = $info->item_id;
    $rate[] = $info->rate;
    $amount[] = $info->amount;
    $unit_qty[] = $info->qty;
    $damage_qty[] = $info->damage_qty;
    $short_qty[] = $info->short_qty;
    $quarentine[] = $info->quarentine;
    $unit_name[] = $info->unit_name;
}

$ssql = 'select a.* from vendor a, purchase_master b where a.vendor_id=b.vendor_id and b.po_no='.$po_no;
$dealer = find_all_field_sql($ssql);

// Prepare barcode data for PMR

    
        $barcode_content = $pmr_no;   // PMR number
        $barcodeText     = $barcode_content;
        $barcodeType     = 'code128';
        $barcodeDisplay  = 'horizontal';
        $barcodeSize     = 40;
        $printText       = '';
$sql2 = "SELECT * FROM purchase_master WHERE po_no = '" . $po_no . "'";
$data2 = db_query($sql2);
$all = mysqli_fetch_object($data2);
    $group_data = find_all_field('user_group','group_name','id='.$all->group_for);
  
    ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Purchased Materials Primary Receive Note</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
</head>

<body>
<div class="body">

    <!-- ? Header -->
    <div class="header">
        <table class="table1" width="100%">
            <tr>
                <td class="logo" width="20%">
                    <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
                </td>
                <td class="titel" width="60%">
                    <h2 class="text-titel"><?=$group_data->group_name?></h2>            
                    <p class="text"><?=$group_data->address?></p>
                    <p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?></p>
                </td>
                <?php /*?><td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?php echo $pmr_no;?></p>
		</td><?php */?>
		
		
		<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($pmr_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/primary_receive/chalan_view2.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
            </tr>
        </table>
    </div>

    <div class="header-one">
        <hr class="hr">
        <h5 class="report-titel">Purchased Materials Primary Receive Note</h5>
        <?php if($datas->duplicate>0){ ?>
            <h5 class="report-titel">DUPLICATE COPY</h5>
        <?php } else { 
            db_execute('update primary_receive_purchase set duplicate=1 where pmr_no='.$pmr_no);
        ?>
            <h5 class="report-titel">ORIGINAL COPY</h5>
        <?php } ?>
    </div>


    <!-- Spacer -->
    <td style="width:20%;">&nbsp;</td>


	<div class="row">

		<div class="col-md-6 col-sm-6 col-lg-6 left">
			
			<p class="left-text mt-1 mb-1">Supplier Company: <span> <?php echo $dealer->vendor_name;?></span></p>
			<p class="left-text mt-1 mb-1">Address: <span><?php if(!empty($dealer->address)) {echo $dealer->address;} else {echo "N/A";}?></span></p>

			<p class="left-text mt-1 mb-1">PR Posting By: <span> <?php echo find_a_field('user_activity_management','fname','user_id='.$entry_by);?></span></p>
			<p class="left-text mt-1 mb-1">PR Posting Time: <span> <?php echo $entry_at;?></span></p>
			<p class="left-text mt-1 mb-1">Primary Receive No:<span> <?php echo $rec_no;?> </span></p>
			<p class="left-text mt-1 mb-1">Mobile:<span><?php if(!empty($dealer->contact_no)) {echo $dealer->contact_no;} else {echo "N/A";}?></span></p>

			
		</div>

		<div class="col-md-6 col-sm-6 col-lg-6 right">

			<p class="right-text mt-1 mb-1">PMR No: <span> <?php echo $pmr_no;?></span></p>
			<p class="right-text mt-1 mb-1">REC Date: <span> <?=$rec_date?> </span></p>
			<p class="right-text mt-1 mb-1">PO No: <span> <?php echo $po_no;?>  </span></p>
			<p class="right-text mt-1 mb-1">PO Date: <span> <?php echo $po_date;?>  </span></p>
			<p class="right-text mt-1 mb-1">Receive By: <span> <?php if(!empty($qc_by_name)) {echo $qc_by_name;} else {echo "N/A";}?></span></p>

			<p class="right-text mt-1 mb-1">Warehouse: <span> <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);?>  </span></p>
		</div>
	</div>

	<br />
	
<!-- ? Print button -->
<div class="main-content">
	
	
	<div id="pr">
        <div align="left">
         	 <p> <input name="button" type="button" onclick="hide();window.print();" value="Print"> </p>    
		</div>
     </div>
	 
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Item Code</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Item Name</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>UOM</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Rec Qty</strong></td>
  </tr>
<? for($i=0;$i<$pi;$i++){?>
  <tr>
    <td align="center" valign="top"><?=$i+1?></td>
    <td align="center" valign="top"><?=find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);?></td>
    <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
    <td align="right" valign="top"><?=$unit_name[$i]?></td>
    <td align="right" valign="top"><?= number_format($unit_qty[$i], 2) ?></td>
  </tr>
<? }?>
</table>

<!-- ? Footer -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:13px"><em>All goods are received in a good condition as per Terms.</em></td>
  </tr>
  <tr><td width="50%">&nbsp;</td><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
  <tr>
    <td colspan="2" align="center">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="23%"><div align="center"><b><?php echo find_a_field('user_activity_management','fname','user_id="'.$datas->qc_by.'"');?></b></div></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <br  />

	
		         <tr>
          <td class="text-center">------------------</td>

        </tr>
        <tr>
          <td class="text-center"><strong>Store Officer</strong></td>
        </tr>

      </table>
    </td>
  </tr>
</table>

<div class="footer1"></div>

</div>
</body>
</html>
