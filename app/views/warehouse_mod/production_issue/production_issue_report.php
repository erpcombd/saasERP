<?php
session_start();
//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";
require_once "../../../controllers/routing/print_view.top.php";

$req_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

//$req_no = $_GET['v_no'];

if($_GET['update']=='Update'){
    $req_status = $_GET['req_status'];
    $ssql='update master_requisition_details set status="'.$_GET['req_status'].'" where req_no="'.$req_no.'"';
    db_query($ssql);
}

$sql="select * from master_requisition_master where req_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);

$group_data = find_all_field('user_group','*','id='.$all->group_for);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Store Requisition</title>
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
<style>
    body {
       font-family: Tahoma, Geneva, sans-serif; 
       font-size: 13px; margin: 20px;
      
      }
    .body { 
      width: 100%;
      margin: 0 auto;
     }

    table {
      width: 100%; 
    }
    .header-one .row .left-text, .header-one .row .right-text {
        font-weight: bold; 
        margin: 0; 
        padding: 2px;
    }

    .footer1 table { 
      width: 100%; 
      text-align: center; 
    }

    .footer1 td {
       padding-top: 5px; 
      }
    th span { 
      font-size: 12px; 
      color: #333; 
    }

    /* === Print Button === */
    #pr { margin-top: 10px; }
    #printBtn {
        background-color: #d9f2f9;
        border: 1px solid #99d6ea;
        padding: 5px 15px;
        font-weight: bold;
        color: #000;
        border-radius: 5px;
        cursor: pointer;
    }
    #printBtn:hover { 
      background-color: #bde7f5; 
    }
    .logo-img { 
      max-height:60px; 
    }
    .qrl-text { 
      font-size:12px; 
      text-align:center; 
      margin-top:5px; 
      padding-left: 151px !important;
      }
	  
	  #productionTable{
	  	margin-top: 20px !important;
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
        <!-- ===== HEADER (same as FG Transfer) ===== -->
        <div class="header">
          <table class="table1" style="width:100%;">
            <tr>
              <td class="logo" width="20%">
                <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
              </td>
              <td class="titel" width="60%" style="text-align:center;">
                <h2 class="text-titel"><?=$group_data->group_name?></h2>			
                <p class="text"><?=$group_data->address?></p>
                <p class="text">Cell: <?=$group_data->mobile?>, Email: <?=$group_data->email?></p>
              </td>
              <?php /*?><td class="Qrl_code" width="20%" style="text-align:right;">
                <?php $barcodeText=$all->req_no; ?>
                <img class="barcode Qrl_code_barcode" 
                     src="barcode.php?text=<?=$barcodeText?>&codetype=code128&orientation=horizontal&size=40&print=false"/>
                <p class="qrl-text"><?=$all->req_no?></p>
              </td><?php */?>
			  
			  <td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($req_no); // Change variable as needed
              $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/production_issue/production_issue_report.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data);
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
          <h5 class="report-titel" style="text-align:center; text-decoration:underline;">STORE REQUISITION</h5>
          <br>

          <div class="row">
            <div class="col-md-6 left">
              <p class="left-text">Requisition No : <span><?=$all->req_no?></span></p>
              <p class="left-text">Auto Req No : <span><?=$all->manual_req_no?></span>
                <!-- Print Button -->
              </p>
              <div id="pr">
                <button id="printBtn" onClick="hideAndPrint()">Print</button>
              </div>
            </div>
            <div class="col-md-6 right">
              <p class="right-text">Requisition Date: <span><?=$all->req_date?></span></p>
              <p class="right-text"><span class="left-text">Section : <span>
                <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->req_for)?>
              </span></span></p>
            </div>
          </div>
        </div>
      </td></tr>

      <!-- ===== ITEM TABLE ===== -->
      <tr><td>
        <table id="productionTable" class="table1" border="1" cellspacing="0" cellpadding="2">
          <thead>
            <tr>
              <th>SL</th>
              <th>Product Name</th>
              <th>Item Description</th>
              <th>Req. Qty</th>
              <th>App. Qty</th>
              <th>Unit</th>
              <th>Delivery Date</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $pi=0;
          $sql2="select * from master_requisition_details where req_no='".$req_no."' and item_id!=''";
          $data2=db_query($sql2);
          while($info=mysqli_fetch_object($data2)){ 
              $pi++;
              $item=find_all_field('item_info','','item_id='.$info->item_id);
          ?>
            <tr>
              <td align="center"><?=$pi;?></td>
              <td><?=$item->item_name?></td>
              <td><?=$item->item_description?></td>
              <td align="right"><?=number_format($info->order_qty,2)?></td>
              <td align="right"><?=number_format($info->qty,2)?></td>
              <td align="center"><?=$item->unit_name?></td>
              <td align="center"><?=substr($info->exp_date,0,10)?></td>
              <td  align="center"><?=$info->remarks?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </td></tr>

      <!-- ===== FOOTER SIGNATURE ===== -->
<tr><td>
  <div class="footer1" style="margin-top:90px;">
    <table class="footer-table" style="width:100%; text-align:center;">
      <tr>
        <td style="padding-bottom:50px;">
          <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
          Prepared By
        </td>
        <td style="padding-bottom:50px;">
          <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
          Authorised By
        </td>
        <td style="padding-bottom:50px;">
          <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
          Checked By
        </td>
        <td style="padding-bottom:50px;">
          <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
          Delivered By
        </td>
        <td style="padding-bottom:50px;">
          <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
          Received By
        </td>
      </tr>
    </table>
  </div>
</td></tr>


      <tr><td>
        <br>
        <p>Printed By: <?=find_a_field('user_activity_management','fname',' user_id='.$_SESSION['user']['id'])?></p>
        <p>Printed At: <?=date('Y-m-d H:i:s')?></p>
      </td></tr>
    </tbody>
  </table>
</div>

</body>
</html>

<?php
$page_name="Store Requisition Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
