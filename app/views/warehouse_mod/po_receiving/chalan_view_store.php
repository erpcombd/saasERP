<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/print_view.top.php";

$pr_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

$datas=find_all_field('purchase_receive','s','pr_no='.$pr_no);
$group_data = find_all_field('user_group','group_name','id='.$datas->group_for);


$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mfod"]);

$sql1="select b.* from purchase_receive b where b.pr_no = '".$pr_no."'";
$data1=db_query($sql1);

$pi=0;
$total=0;

while($info=mysqli_fetch_object($data1)){ 
    $pi++;
    $rec_date=$info->rec_date;
    $rec_no=$info->rec_no;
    $po_no=$info->po_no;
    $sale_no=$info->sale_no;
    $order_no[]=$info->order_no;
    $truck_no=$info->truck_no;
    $ch_no=$info->ch_no;
    $qc_by=$info->qc_by;
    $remarks=$info->remarks;
    $entry_at=$info->entry_at;
    $entry_by=$info->entry_by;
    $item_id[] = $info->item_id;
    $rate[] = $info->rate;
    $amount[] = $info->amount;
    $rec_no=$info->rec_no;
    $garden[]=find_a_field('tea_garden','garden_name','garden_id='.$info->garden_id);
    $shed[]=find_a_field('tea_warehouse','warehouse_nickname','warehouse_id='.$info->shed_id);
    $lot_no[]=$info->lot_no;
    $invoice_no[]=$info->invoice_no;
    $liquor_mark[]=$info->quality;
    $pkgs[]=$info->pkgs;
    $tpkgs+=$info->pkgs;
    $sam_pay[]=$info->sam_pay;
    $sam_qty[]=$info->sam_qty;
    $secondary_carton=find_a_field('item_info','carton_qty','item_id='.$info->item_id);
    if ($secondary_carton > 0) $ctnyy[]=$info->qty/$secondary_carton;
    $unit_qty[] = $info->qty;
    $tot_unit_qty+= $info->qty;
    $unit_name[] = $info->unit_name;
}

$ssql = 'select a.* from vendor a, purchase_master b where a.vendor_id=b.vendor_id and b.po_no='.$po_no;
$dealer = find_all_field_sql($ssql);

// ================== BARCODE VARIABLES ==================
$barcodeText    = $pr_no;         
$barcodeType    = "code128";      
$barcodeDisplay = "horizontal";   
$barcodeSize    = 40;             
$printText      = true;   
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>.: Cash Memo :.</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript">
    function hide(){
        document.getElementById("pr").style.display="none";
        document.getElementById("pr1").style.display="none";
    }
</script>

<style>

@media print {
  
  @page {
    size: A4;
    margin: 15mm !important; 
	width: 100% !important;
  }

  .container {
    padding: 0 !important;
	width: 100% !important;
  }

  /* Hide all buttons/inputs in print */
  input[type="button"],
  .btn,
  .no-print {
    display: none !important;
  }

  /* Force tables to show borders */
  table {
    border-collapse: collapse !important;
    width: 100%;
  }

  table th,
  table td {
    border: 1px solid #000 !important;
    padding: 4px !important;
    font-size: 12px !important;
  }

  /* Header always on top */
  .header, .header-one {
    page-break-after: avoid;
    page-break-before: avoid;
  }

  /* Footer always at bottom */
  .footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    font-size: 11px;
  }

  /* Page Number */
  @page {
    @bottom-center {
      content: "Page " counter(page) " of " counter(pages);
    }
  }

  .no-border td {
    border: none !important;
  }

.barcode {
    float: right !important;
	margin-left: 290px !important;
	
  }


.barcode-text{
  padding-right: 7px !important;
  margin-bottom: 70px !important;	
}
}
  
table.table-bordered > thead > tr > th{
  border:1px solid black;
  font-size:12px;
}
table.table-bordered > tbody > tr > td{
  border:1px solid black;
  font-size:12px;
}
* {
  margin: 0;
  padding: 0;
  font-size:13px;
}
p { margin: 0; padding: 0; }
h1,h2,h3,h4,h5,h6 { margin:0!important; padding:0!important; }
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


</style>
</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<div class="container">

    <!-- ======= HEADER ======= -->
    <div class="container-fluid mb-3">
        <div class="row align-items-center border-bottom pb-2">
            <!-- Logo -->
            <div class="col-2 text-start">
                <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" 
                     class="img-fluid" style="max-height:80px;">
            </div>
            <!-- Company Info -->
            <div class="col-8 text-center">
                <h2 style="font-size:20px; font-weight:bold; margin:0;">
                    <?=$group_data->group_name?>
                </h2>
                <p style="margin:0; font-size:13px;"><?=$group_data->address?></p>
                <p style="margin:0; font-size:13px;">
                    Cell: <?=$group_data->mobile?> | Email: <?=$group_data->email?><br>
                    <?=$group_data->vat_reg?>
                </p>
            </div>
            <!-- Barcode -->
            <?php /*?><div class="col-2 text-end">
    <?='<img class="barcode" alt="'.$barcodeText.'" 
        src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'" 
        style="max-height:70px;"/>' ?>
    <p class="barcode-text" style="font-size:11px; margin-top:5px;"><?php echo $pr_no;?></p>
</div><?php */?>


<tr>
	<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($pr_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/po_receiving/chalan_view_store.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
	</tr>

        
	

    <!-- ======= END HEADER ======= -->


    <div class="text-center">
        <button class="btn btn-default outline border rounded-pill border border-dark text-black">
            <h4 style="font-size:15px;font-weight:bold; margin:0 auto;">GOODS RECEIVE NOTE</h4>
        </button>
    </div>
    <br />

    <div class="row">
        <div class="col-6">
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">GRN No:</span>
                <input type="text" class="form-control" readonly value="<?php echo $pr_no;?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">GRN Date</span>
                <input type="text" class="form-control" readonly value="<?=$rec_date?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">Requisition No:</span>
                <input type="text" disabled class="form-control" value=" <?php echo $req_all->req_no;?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">Supplier:</span>
                <input type="text" disabled class="form-control" value="  <?php echo $dealer->vendor_name;?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">Address:</span>
                <input type="text" disabled class="form-control" value="  <?php echo $dealer->address;?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">Truck No:</span>
                <input type="text" disabled class="form-control" value=" <?php echo $truck_no;?>">
            </div>
            <div id="pr">
                <input name="button" type="button" onClick="hide();window.print();" value="Print" />
            </div>
        </div>

        <div class="col-6">
            <?php 
                $po_all=find_all_field('purchase_master','','po_no="'.$po_no.'"');
                $req_all=find_all_field('requisition_master','','req_no="'.$po_all->req_no.'"');
            ?>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">PO No:</span>
                <input type="text" disabled class="form-control" value=" <?php echo $po_no;?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">PO Date</span>
                <input type="text" class="form-control" readonly value="<?=$po_all->po_date?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">Requisition Date</span>
                <input type="text" class="form-control" readonly value="<?=$req_all->req_date?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">Manual Rec No:</span>
                <input type="text" disabled class="form-control" value=" <?php echo $rec_no;?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">QC By:</span>
                <input type="text" disabled class="form-control" value="<?php echo $qc_by;?>">
            </div>
            <div class="input-group mb-2 input-group-sm">
                <span class="input-group-text fw-bold">Supplier Challan No:</span>
                <input type="text" disabled class="form-control" value="<?php echo $ch_no;?>">
            </div>

            <table id="pr1" cellpadding="3">
                <tr>
                    <td>Chalan View :</td>
                    <td>
                        <?php if ($datas->upload_chalan_1!=''){?>
                        <a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=mrr_chalan_1&&name=<?=$datas->upload_chalan_1;?>" target="_blank">Chalan 1</a><br>
                        <?php } ?>
                        <?php if ($datas->upload_chalan_2!=''){?>
                        <a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=mrr_chalan_2&&name=<?=$datas->upload_chalan_2;?>" target="_blank">Chalan 2</a><br>
                        <?php } ?>
                        <?php if ($datas->upload_chalan_3!=''){?>
                        <a href="../../../controllers/uploader/upload_view.php?proj_id=<?=$_SESSION['proj_id']?>&&folder=mrr_chalan_3&&name=<?=$datas->upload_chalan_3;?>" target="_blank">Chalan 3</a><br>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">Purchase Order: </td>
                    <td>
                       <?php /*?> <a href="../../../../app/views/purchase_mod/po/po_print_view_store.php?po_no='<?=url_encode($po_no);?>'" target="_blank"><?=$po_no;?></a><?php */?>
						
						 <a href="../../../../app/views/purchase_mod/po/po_print_view_store.php?c='<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($po_no));?>'" target="_blank"><?=$po_no;?></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Items Table -->
    <table class="table table-bordered table-condensed mt-3">
        <thead>
            <tr>
                <th>SL</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>UOM</th>
                <th>Received Qty</th>
            </tr>
        </thead>
        <tbody>
        <? for($i=0;$i<$pi;$i++){?>
            <tr style="text-align:center;">
                <td><?=$i+1?></td>
                <td><?=find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);?></td>
                <td><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
                <td><?=find_a_field('item_info','unit_name','item_id='.$item_id[$i]);?></td>
                <td><?php echo number_format($unit_qty[$i],2); ?></td>
            </tr>
        <? } ?>
        </tbody>
    </table>

    <table class="no-border" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per Terms</em></td>
        </tr>
    </table>

    <br /><br />
    <div style="display: flex !important; justify-content:center;" class="row">
        <div class="col-2 text-center" style="margin-top:50px;">
    <b><?php 
        $qc_all=find_a_field('qc_receive_purchase','qc_by','qc_no="'.$datas->qc_no.'"');
        echo find_a_field('user_activity_management','fname','user_id="'.$datas->entry_by.'"');
    ?></b>
    <br><p style="border-top:1px solid"> Received By </p>
</div>
<div class="col-1"></div>
<div class="col-2 text-center" style="margin-top:50px;">
    <b><?php echo find_a_field('user_activity_management','fname','user_id="'.$qc_all.'"');?></b>
    <br><p style="border-top:1px solid"> Quality Controller </p>
</div>
<div class="col-1"></div>
<div class="col-2 text-center" style="margin-top:50px;">
    <b><?php echo find_a_field('user_activity_management','fname','user_id="'.$datas->post_pur_verify.'"');?></b>
    <br><p style="border-top:1px solid"> Store Manager </p>
</div>
<div class="col-1"></div>
<div class="col-2 text-center" style="margin-top:50px;">
    <b>&nbsp;</b>
    <br><p style="border-top:1px solid"> Authorized By </p>
</div>

        <? $page_name="PO Print View";
        require_once SERVER_CORE."routing/layout.report.bottom.php"; ?>
    </div>
</div>

</body>
</html>
