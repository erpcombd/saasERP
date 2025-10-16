<?php 
//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../controllers/routing/print_view.top.php";

$or_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

//$or_no = $_REQUEST['v_no'];

	$req_bar_no = $or_no;
	$barcode_content = $req_bar_no;
	$barcodeText = $barcode_content;
    $barcodeType='code128';
	$barcodeDisplay='horizontal';
    $barcodeSize=40;
    $printText='';

// Fetch main import record
$datas = find_all_field('warehouse_other_receive','s','or_no='.$or_no);

$sql1 = "SELECT b.* FROM warehouse_other_receive b WHERE b.or_no = '".$or_no."'";
$data1 = db_query($sql1);

$pi = 0;
$total = 0;

while($info = mysqli_fetch_object($data1)){ 
    $rec_frm = $info->vendor_name;
    $requisition_from = $info->requisition_from;
    $or_subject = $info->or_subject;
    $or_date = $info->or_date;
    $status = $info->status;
    $invoice_no = $info->invoice_no;
    $supplier = find_a_field('vendor','vendor_name','vendor_id="'.$info->vendor_id.'"');
}

// Fetch import item details
$sql2 = "SELECT * FROM warehouse_other_receive_detail WHERE or_no = '".$or_no."'";
$data2 = db_query($sql2);

$pi = 0;
$total = 0;

// Header group info
$group_data = find_all_field('user_group','group_name','id='.$datas->group_for);


$item_id = $rate = $amount = $lc_price = $actual_price = $total_pp = $freight_cost = $lc_cost = $cnf_cost = $unit_qty = $unit_name = $dollar_rate = $purchase_price_dollar = $lc_price_dollar = $bag_cost = [];

while($info = mysqli_fetch_object($data2)){ 
    $pi++;
    $order_no[] = $info->order_no;
    $qc_by = $info->qc_by;
    $invoiceno = $info->invoice_no;

    $item_id[] = $info->item_id;
    $rate[] = $info->rate;
    $amount[] = $info->amount;

    $lc_price[] = $info->lc_price;
    $actual_price[] = $info->actual_price;
    $total_pp[] = $info->total_pp;
    $freight_cost[] = $info->freight_cost;
    $lc_cost[] = $info->lc_cost;
    $cnf_cost[] = $info->cnf_cost;
    $unit_qty[] = $info->qty;
    $unit_name[] = $info->unit_name;
    $dollar_rate[] = $info->dollar_rate;
    $purchase_price_dollar[] = $info->purchase_price_dollar;
    $lc_price_dollar[] = $info->lc_value_dollar;
    $bag_cost[] = $info->bag_cost;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Import Item Report</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php"); ?>

<style>
.left .left-text, .right .right-text {
    font-weight: bold;
    margin: 0px;
    padding: 2px;
    border: none !important;
}

.left .new-div, .right .new-div {
    border: 1px solid black;
    min-height: 130px;
    margin-top: 20px;
    padding: 5px;
}

.footer1 {
    page-break-inside: avoid; 
	margin-top: 30px !important;
}
.footer1 table {
    width: 100%;
    text-align: center;
    border-collapse: collapse;
}
.footer1 td {
    vertical-align: bottom;
    padding-top: 50px; 
}

th span {
    font-size: 12px;
    color: #333;
}

.table-item th, .table-item td {
    border: 1px solid #000;
    padding: 5px;
    font-size: 13px;
}

.table-item th {
    background-color: #f0f0f0;
    text-align: center;
}

.header-one hr.hr {
    border: 1px solid #333;
}

.p-text {
    margin: 10px 0;
}
</style>

</head>
<body>

<div class="body" id="printContent">

    <!-- Header Section -->
    <div class="header">
        <table class="table1">
            <tr>
                <td class="logo">
                    <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
                </td>
                <td class="titel">
                    <h2 class="text-titel"><?=$group_data->group_name?></h2>            
                    <p class="text"><?=$group_data->address?></p>
                    <p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?></p>
                </td>
               <?php /*?><td class="Qrl_code">
    <?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" 
    src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print=true"/>' ?>
    <p class="qrl-text"><?=$or_no?></p> 
</td><?php */?>

<td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($or_no); 
			  $tr_from = url_encode($tr_from); 
              $print_url = "https://saaserp.ezzy-erp.com/app/views/purchase_mod/import/import_report.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data). "&tr_from=" . rawurlencode($tr_from);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>


            </tr>
        </table>
    </div>

    <!-- Import Details -->
    <div class="header-one">
        <hr class="hr"/>
        <h5 class="report-titel"><u>IMPORT ITEM RECEIVE</u></h5>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 left">
                <p class="left-text">Import From: <span><?php if(!empty($rec_frm)) {echo "$rec_frm";} else{echo "N/A";}?></span></p>
                <p class="left-text">Requisition From: <span><?php if(!empty($requisition_from)) {echo "$requisition_from";} else{echo "N/A";}?></span></p>
                <p class="left-text">Date: <span><?=date("d M, Y", strtotime($or_date))?></span></p>
                <p class="left-text">Note: <span><?php if(!empty($or_subject)) {echo "$or_subject";} else{echo "N/A";}?></span></p>
                <p class="left-text">Supplier: <span><?=$supplier?></span></p>
                <p class="left-text">Status: <span><?=$status?></span></p>
            </div>
            
        </div>

        <p class="p-text">The Vendor has delivered the following items as per Import Order.</p>
    </div>

    <!-- Print Button -->
    <div id="pr">
        <div align="left" style="margin-bottom: 10px !important">
            <input name="button" type="button" onClick="hide();window.print();" value="Print" />
        </div>
    </div>

    <!-- Item Table -->
    <table class="table-item" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>SL</th>
                <th>Product Name</th>
                <th>Unit</th>
                <th>Dollar Rate</th>
                <th>LC Price $</th>
                <th>LC Price BDT</th>
                <th>Purchase Price $</th>
                <th>Actual Price BDT</th>
                <th>Total PP BDT</th>
                <th>Freight Cost BDT</th>
                <th>LC Cost BDT</th>
                <th>Bag Cost BDT</th>
                <th>C & F Cost BDT</th>
                <th>Final Rate BDT</th>
                <th>Qty</th>
                <th>Total Amount BDT</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $t_amount = 0;
            for($i=0; $i<$pi; $i++){ ?>
                <tr>
                    <td align="center"><?=$i+1?></td>
                    <td><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
                    <td align="center"><?=$unit_name[$i]?></td>
                    <td align="right"><?=$dollar_rate[$i]?></td>
                    <td align="right"><?=$lc_price_dollar[$i]?></td>
                    <td align="right"><?=$lc_price[$i]?></td>
                    <td align="right"><?=$purchase_price_dollar[$i]?></td>
                    <td align="right"><?=$actual_price[$i]?></td>
                    <td align="right"><?=$total_pp[$i]?></td>
                    <td align="right"><?=$freight_cost[$i]?></td>
                    <td align="right"><?=$lc_cost[$i]?></td>
                    <td align="right"><?=$bag_cost[$i]?></td>
                    <td align="right"><?=$cnf_cost[$i]?></td>
                    <td align="right"><?=$rate[$i]?></td>
                    <td align="right"><?=$unit_qty[$i]?></td>
                    <td align="right"><?=number_format($amount[$i],2); $t_amount += $amount[$i];?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="15" align="right"><strong>Total Amount BDT: </strong></td>
                <td align="right"><strong><?=number_format($t_amount,2)?></strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Footer Approval -->
    <div class="footer1">
        <table>
            <tr>
                <td align="center">------------------------<br/>Received By</td>
                <td align="center">------------------------<br/>Quality Controller</td>
                <td align="center">------------------------<br/>Store Incharge</td>
            </tr>
        </table>
    </div>

</div>

<script>
function hide() {
    document.getElementById("pr").style.display = "none";
}
</script>

</body>
</html>
