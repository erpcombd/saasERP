<?php
session_start();
ob_start();

//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../controllers/routing/print_view.top.php";

$oi_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

//$oi_no = $_REQUEST['v_no'];


$datas = find_all_field('fg_transfer_master','*','st_no='.$oi_no);
$all=find_all_field('user_group','*','id='.$datas->group_for);
$sql1 = "select b.* from fg_transfer_master b where b.st_no = '".$oi_no."'";
$data1 = db_query($sql1);
while($info = mysqli_fetch_object($data1)){  
    $issued_to=$info->warehouse_to;
    $oi_details=$info->st_details;
    $approved_by=$info->approved_by;
    $entry_by=$info->entry_by;
    $entry_at=$info->entry_at;
    $received_by=$info->received_by;
    $received_at=$info->received_at;
    $issue_type=$info->Issue_type;
    $oi_date=$info->st_date;
    $requisition_from=$info->warehouse_from;
}

$sql1="select b.* from fg_transfer_details b where b.st_no = '".$oi_no."'";
$data1=db_query($sql1);
$pi=0; $total=0;
while($info=mysqli_fetch_object($data1)){  
    $pi++;
    $item_id[] = $info->item_id;
    $ctn[]=$info->ctn;
    $pcs[]=$info->pcs;
    $unit_qty[] = $info->qty;
    $remarks[]=$info->remarks;
    $unit_name[] = $info->unit_name;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>FG Transfer Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
  <style>
    body { font-family: Tahoma, Geneva, sans-serif; font-size: 13px; margin: 20px; }
    .body { width: 100%; margin: 0 auto; }
    table { width: 100%; }
    .header-one .row .left-text, .header-one .row .right-text {
        font-weight: bold; margin: 0; padding: 2px;
    }
    .footer1 table { width: 100%; text-align: center; }
    .footer1 td { padding-top: 5px; }
    th span { font-size: 12px; color: #333; }

    /* === Print Button Style (PO Report er moto) === */
    #pr { margin-top: 10px; }
    #printBtn {
        background-color: #d9f2f9;   /* light blue */
        border: 1px solid #99d6ea; /* blue border */
        padding: 5px 15px;
        font-weight: bold;
        color: #000;
        border-radius: 5px;
        cursor: pointer;
    }
    #printBtn:hover {
        background-color: #bde7f5;  /* hover effect */
    }
	
	#fg_transfer{
	margin-top: 20px !important;
	}
	
	.footer1{
		margin-top: 60px !important;
	}
  </style>
  <script>
    function hideAndPrint(){
      document.getElementById("pr").style.display="none";
      window.print();
    }
  </script>
</head>
<body>
<div class="body" id="printContent">

  <table border="0" cellpadding="2" cellspacing="0">
    <thead>
      <tr><td>
        <!-- ===== HEADER ===== -->
        <div class="header">
          <table class="table1" style="width:100%;">
            <tr>
              <td class="logo" width="20%">
                <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
              </td>
              <td class="titel" width="60%" style="text-align:center;">
                <h2 class="text-titel"><?=$all->group_name; //=find_a_field('user_group','group_name','id='.$datas->group_for)?></h2>			
                <p class="text"><?=$all->address?></p>
                <p class="text">Cell: <?=$all->mobile?>, 
                   Email: <?=$all->email?></p>
              </td>
              <?php /*?><td class="Qrl_code" width="20%" style="text-align:right;">
                <?php $barcodeText=$oi_no; ?>
                <img class="barcode Qrl_code_barcode" 
                     src="barcode.php?text=<?=$barcodeText?>&codetype=code128&orientation=horizontal&size=40&print=false"/>
                <p class="qrl-text"><?=$oi_no?></p>
              </td><?php */?>
			  
			 <td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($oi_no); 
			  $tr_from = url_encode($tr_from); 
              $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/recipe/fg_transfer_report.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data). "&tr_from=" . rawurlencode($tr_from);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>

            </tr>
          </table>
        </div>
      </td></tr>
    </thead>
    <tbody>
      <tr><td>
        <!-- ===== TITLE ===== -->
        <div class="header-one">
          <hr class="hr"/>
          <h5 class="report-titel" style="text-align:center;">FG TRANSFER REPORT</h5>
          <br>

          <div class="row">
            <div class="col-md-6 left">
              <p class="left-text">Issue No: <span><?=$oi_no?></span></p>
              <p class="left-text">Issue Date: <span><?=date("d M, Y",strtotime($oi_date))?></span></p>
              <p class="left-text">From Warehouse: <span><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$requisition_from)?></span></p>
              <p class="left-text">To Warehouse: <span><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$issued_to)?></span>
                <!-- ==== PRINT BUTTON (Note er niche) ==== -->
              </p>
              <div id="pr">
                <button id="printBtn" onClick="hideAndPrint()">Print</button>
              </div>
              <!-- ============================== -->

            </div>
            <div class="col-md-6 right">
              <p class="right-text">Entry By: <span><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?> (<?=$entry_at?>)</span></p>
              <p class="right-text">Received By: <span><?=find_a_field('user_activity_management','fname','user_id='.$received_by)?> (<?=$received_at?>)</span></p>
              <p class="right-text">Approved By: <span><?=$approved_by?></span></p>
              <p class="right-text"><span class="left-text">Note: <span>
                <?php if(!empty($oi_details)){echo $oi_details;} else {echo "N/A";}?>
              </span></span></p>
            </div>
          </div>
        </div>
      </td></tr>

      <tr><td>
        <!-- ===== ITEM TABLE ===== -->
        <table id="fg_transfer" class="table1" style="width:100%;">
          <thead>
            <tr>
              <th>SL</th>
              <th>Code</th>
              <th>Item Name</th>
              <th>Unit</th>
              <th>Ctn</th>
              <th>Pcs</th>
              <th>Total Unit</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
          <?php for($i=0;$i<$pi;$i++){ ?>
            <tr>
              <td style="text-align:center"><?=$i+1?></td>
              <td style="text-align:left"><?=$item_id[$i]?></td>
              <td><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
              <td style="text-align:center"><?=$unit_name[$i]?></td>
              <td style="text-align:right"><?=$ctn[$i]; $tot_ctn+=$ctn[$i];?></td>
              <td style="text-align:right"><?=$pcs[$i]; $tot_pcs+=$pcs[$i];?></td>
              <td style="text-align:right"><?=$unit_qty[$i]; $tot_unit+=$unit_qty[$i];?></td>
              <td><?=$remarks[$i]?></td>
            </tr>
          <?php } ?>
            <tr>
              <td colspan="4" style="text-align:right"><b>Total</b></td>
              <td style="text-align:right"><b><?=number_format($tot_ctn,2)?></b></td>
              <td style="text-align:right"><b><?=number_format($tot_pcs,2)?></b></td>
              <td style="text-align:right"><b><?=number_format($tot_unit,2)?></b></td>
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </td></tr>

      <tr><td>
        <p class="p-text"><em>All goods are received in a good condition as per Terms.</em></p>
      </td></tr>

      <tr><td>
        <!-- ===== SIGNATURE ===== -->
        <div class="footer1">
  <table class="footer-table">
    <tr>
      <td class="text-center">
        <?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?><br/>
        --------------------<br/>
        Issued By
      </td>
      <td class="text-center">
        <?=find_a_field('user_activity_management','fname','user_id='.$received_by)?><br/>
        --------------------<br/>
        Received By
      </td>
      <td class="text-center">
        <!-- If you want a name here later, keep it dynamic -->
        --------------------<br/>
        Checked By
      </td>
      <td class="text-center">
        --------------------<br/>
        Approved By
      </td>
    </tr>
  </table>
</div>


      </td></tr>
    </tbody>
  </table>
</div>
