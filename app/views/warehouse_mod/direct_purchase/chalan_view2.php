<?php 
session_start();
require_once "../../../controllers/routing/print_view.top.php";

$or_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

// Barcode
$barcode_content = $or_no;
$barcodeText     = $barcode_content;
$barcodeType     = 'code128';
$barcodeDisplay  = 'horizontal';
$barcodeSize     = 40;
$printText       = '';

// Master Data
$datas  = find_all_field('warehouse_other_receive','s','or_no='.$or_no);
$sql111 = "select b.* from warehouse_other_receive b where b.or_no = '".$or_no."'";
$data111 = db_query($sql111);
$data   = mysqli_fetch_object($data111);

$rec_frm          = $data->vendor_name;
$requisition_from = $data->requisition_from;
$or_date          = $data->or_date;
$entry_by         = $datas->entry_by;

// Company Info
$group  = find_all_field('user_group','','id='.$datas->group_for);



// Details
$sql1  = "select b.* from warehouse_other_receive_detail b where b.or_no = '".$or_no."'";
$data1 = db_query($sql1);

$pi=0; $t_amount=0;
while($info = mysqli_fetch_object($data1)){ 
    $pi++;
    $order_no[]   = $info->order_no;
    $qc_by        = $info->qc_by;
    $item_id[]    = $info->item_id;
    $rate[]       = $info->rate;
    $amount[]     = $info->amount;
    $unit_qty[]   = $info->qty;
    $unit_name[]  = $info->unit_name;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Direct Purchase Receive</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>

<script type="text/javascript">
function hide(){
    var pr = document.getElementById("pr");
    if (pr) pr.style.display="none";
}
</script>

<style>
/* ===== IMPORTANT: Scope ALL custom styles to #printContent so main page width/layout is unaffected ===== */
#printContent .header .logo-img {max-height:60px;}
#printContent .header .titel {text-align:center;}
#printContent .Qrl_code {text-align:right;}
#printContent .qrl-text {font-size:12px; font-weight:bold;}

#printContent .footer1 table {width:100%; text-align:center; border-collapse:collapse;}
#printContent .footer1 td {padding-top:5px;}

#printContent .tabledesign th,
#printContent .tabledesign td {vertical-align:top;}

/* Print button styling (screen only) */
#pr { text-align:center; margin:10px 0; }
#pr input[type="button"] {
    width: 80px;
    height: 28px;
    background-color: #6cff36;
    color: #333;
    font-weight: bold;
    border-radius: 5px;
    border: 1px solid #333;
    cursor: pointer;
}

/* Keep your page margins in print, hide the button in print */
@media print {
    #pr { display:none !important; }
    @page { margin: 10mm; }
}
</style>
</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<div id="pr">
    <input type="button" onClick="hide();window.print();" value="Print"/>
</div>

<!-- MAIN WRAPPER LIKE THE FIRST CODE (no fixed width; uses tables with width=100%) -->
<div class="body" id="printContent">
  <table border="0" cellpadding="2" cellspacing="0" width="100%">
    <tr>
      <td>
        <!-- Header (mirrors first code structure) -->
        <div class="header">
          <table class="table1" width="100%">
            <tr>
              <td class="logo" width="20%">
                <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
              </td>
              <td class="titel" width="60%" style="font-size:11px;">
                <h2 class="text-titel"><?=$group->group_name?></h2>
                <p style="font-size: 13px !important;" class="text"><?=$group->address?></p>
                <p style="font-size: 13px !important;" class="text">Cell: <?=$group->mobile?>, Email: <?=$group->email?></p>
                <p style="font-size: 13px !important;" class="text"><?=$group->vat_reg?></p>
              </td>
			  
              <?php /*?><td class="Qrl_code" width="20%">
                <?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
                <p class="qrl-text"><?=$or_no?></p>
              </td><?php */?>
			  
			  
		<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($or_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/direct_purchase/chalan_view2.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
			  
            </tr>
          </table>
        </div>
        <hr />
      </td>
    </tr>

    <!-- Title -->
    <tr>
      <td align="center" style="font-size:16px; font-weight:bold; background:#666; color:#fff; padding:5px;">
        DIRECT PURCHASE RECEIVE
      </td>
    </tr>

    <!-- Info Section -->
    <tr>
      <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size:13px;">
          <tr>
            <td width="50%" valign="top">
              <table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td width="40%" align="left"><strong>Purchase From :</strong></td>
                  <td><?php if (!empty($rec_frm)) {echo $rec_frm;} else {echo 'N/A';}?></td>
                </tr>
                <tr>
                  <td align="left"><strong>Requisition From :</strong></td>
                  <td><?=$requisition_from?></td>
                </tr>
                <tr>
                  <td align="left"><strong>LP Posting Information :</strong></td>
                  <td>By: <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?> / At: <?=$data->entry_at?></td>
                </tr>
                <tr>
                  <td align="left"><strong>DP Note :</strong></td>
                  <td><?=$data->or_subject?></td>
                </tr>
              </table>
            </td>
            <td width="50%" valign="top" style="padding-left: 280px !important;">
              <table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td align="left"><strong>DP No:</strong></td>
                  <td style="padding-right: 65px !important;"><?=$or_no?></td>
                </tr>
                <tr>
                  <td align="left"><strong>DP Date:</strong></td>
                  <td><?=date("d M, Y",strtotime($or_date))?></td>
                </tr>
                <tr>
                  <td align="left"><strong>QC By:</strong></td>
                  <td><?=$data->qc_by?></td>
                </tr>
                <tr>
                  <td align="left"><strong>Chalan No:</strong></td>
                  <td><?=$data->chalan_no?></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Items Table -->
    <tr>
      <td>
        <table class="table1 tabledesign" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:13px; border-collapse:collapse;">
          <tr bgcolor="#60ef76">
            <th>SL</th>
            <th style="text-align:center;">Code</th>
            <th style="text-align:center;">Product Name</th>
            <th style="text-align:center;">Unit</th>
            <th style="text-align:center;">Rate</th>
            <th style="text-align:center;">Rec Qty</th>
            <th style="text-align:center;">Amount</th>
          </tr>
          <?php for($i=0;$i<$pi;$i++){ ?>
          <tr>
            <td align="center"><?=$i+1?></td>
            <td><?=$item_id[$i]?></td>
            <td><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
            <td align="center"><?=$unit_name[$i]?></td>
            <td align="right"><?=number_format($rate[$i],2)?></td>
            <td align="right"><?=number_format($unit_qty[$i],2)?></td>
            <td align="right"><?=number_format($amount[$i],2); $t_amount += $amount[$i];?></td>
          </tr>
          <?php } ?>
          <tr bgcolor="yellow">
            <td colspan="6" align="right"><strong>Total Amount:</strong></td>
            <td align="right"><strong><?=number_format($t_amount,2)?></strong></td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Footer Signature -->
    <tr>
      <td><p style="font-size:12px; text-align:left; margin:15px 0;"><em>All goods are received in a good condition as per Terms</em></p>
	  <tr>
   <td>&nbsp; </td>
   <td>&nbsp; </td>
   <td>&nbsp; </td>
   <td>&nbsp; </td>
   <td>&nbsp; </td>
   <td>&nbsp; </td>
   <td>&nbsp; </td>
   <td>&nbsp; </td>
   <td>&nbsp; </td>
</tr>
	  
	  
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33%" align="center"><?=find_a_field('user_activity_management','fname','user_id="'.$entry_by.'"');?></td>
            <td width="33%" align="center"><?=$datas->qc_by?></td>
            <td width="33%" align="center"><?=$datas->approved_by?></td>
          </tr>
          <tr>
            <td align="center">--------------------</td>
            <td align="center">--------------------</td>
            <td align="center">--------------------</td>
          </tr>
          <tr>
            <td align="center">Prepared By</td>
            <td align="center">QC By</td>
            <td align="center">Store Incharge</td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td>
        <?php
        $page_name="PO Print View";
        require_once SERVER_CORE."routing/layout.report.bottom.php";
        ?>
      </td>
    </tr>
  </table>
</div> <!-- /#printContent -->
</body>
</html>
