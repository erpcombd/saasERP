<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$po_no = $_REQUEST['po_no'];
 $condition="po_no=".$po_no;
$data=find_all_field('lc_purchase_master','*',$condition);
$req_no_qr_data = urlencode(base64_encode($po_no));
$print_url = "https://erp.jamunapaper.com/2025/app/views/lc_mod/po/status_qr.php?c=7oKXlrqDK1N%2FpLMXEJWzTQ%3D%3D&v=" . $req_no_qr_data;
$qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);

//////currency all///
$csql='select * from currency_type where 1 group by id';
$cquery=db_query($csql);
while($crow=mysqli_fetch_object($cquery)){
	$currency_name[$crow->id]=$crow->currency_type;
	$currency_icon[$crow->id]=$crow->icon;
}
$vendor_all=find_all_field('vendor_foreign','*','vendor_id="'.$data->vendor_id.'"');
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Contract / Proforma Invoice - Full Replica</title>
  <style>
    body{font-family: Arial, Helvetica, sans-serif; margin:0; padding:24px; color:#000; background:#fff}
    .page{max-width:1000px; margin:0 auto; padding:24px; border:1px solid #ccc;}

    /* Header */
    .header{display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px}
    .logo{height:40px;}
    h1{font-size:18px; margin:0; text-transform:uppercase}
    .sub{font-size:13px; margin-top:4px}

    /* Parties */
    .parties{display:flex; justify-content:space-between; margin-top:20px}
    .party{width:48%; font-size:13px;}
    .party h3{margin:0 0 6px 0; font-size:14px;}

    /* Bank */
    .bank{padding:10px; margin:20px 0; font-size:13px;}
    .bank strong{display:block; margin-bottom:6px}

    /* Table */
    table{width:100%; border-collapse:collapse; margin-top:10px; font-size:13px}
    table, th, td{border:1px solid #000}
    th, td{padding:8px;}
    th{text-align:left; background:#f2f2f2}
    td.right{text-align:right}

    /* Remarks */
    .remarks{margin-top:20px; font-size:13px}
    .remarks strong{display:block; margin-bottom:6px}
    .remarks ol{margin:0; padding-left:18px}

    /* Signatures */
    .signatures{display:flex; justify-content:space-between; margin-top:40px}
    .sign{width:45%; text-align:left; font-size:13px}
    .sign .line{border-top:1px dashed #000; margin-top:40px; margin-bottom:6px; width:70%}
    .sign p{margin:2px 0}
    
    /* Footer */
    footer{margin-top:30px; font-size:12px; text-align:left; border-top:1px solid #000; padding-top:6px; color:#333}

    @media print{
      body{padding:0}
      .page{border:0; padding:12mm}
	  
	  .page {
    max-width: 1000px; /* or smaller */
    margin: 0 auto;
    padding: 10px; /* reduce if needed */
}
    }
  </style>
</head>
<body>
  <div class="page">
    <div class="header">
      <div>
        <h1>CONTRACT <?=$data->pi_no?> &amp; PROFORMA INVOICE(DRAFT)</h1>
        <div class="sub">Contract Date: 07 July 2025</div>
      </div>
      <div>
        <img src="<?=$qr_code?>" alt="QR Code">
      </div>
    </div>

    <div class="parties">
      <div class="party">
        <h3>Seller</h3>
        <p><?=$vendor_all->vendor_name;?></p>

        <h3>Seller's representative</h3>
        <p><?=find_a_field('agent_info','agent_name','agent_id="'.$data->supplier_agent.'"')?></p>

        <h3>Terms of Delivery</h3>
        <p><?=$data->port_of_shipment?></p>
      </div>

      <div class="party">
        <h3>Buyer</h3>
        <p><?=find_a_field('user_group','group_name','id="'.$data->group_for.'"')?></p>

        <h3>Time of Shipment</h3>
        <p><?=$data->date_of_shipment?></p>

        <h3>Terms of Payment</h3>
        <p><?=$data->trans_of_payment?></p>
      </div>
    </div>

    <div class="bank">
      <strong>OUR ADVISING BANK DETAILS:</strong>
     <?=$data->supplier_bank_details?>
    </div>

    <table>
      <tr>
        <th>Description of Goods</th>
        <th>Quantity (MT)</th>
        <th>Unit Price (<?php echo $currency_name[$data->currency];?>)</th>
        <th>Total (<?php echo $currency_name[$data->currency];?>)</th>
      </tr>
	  <?
$s=0;
 $res='select a.id, b.item_name, a.specification,  a.rate as unit_price,
 a.qty, a.unit_name, a.amount,  a.rate_usd, a.amount_usd, a.rate_ud, a.amount_ud,a.unit_name
 
  from lc_purchase_invoice a,item_info b where b.item_id=a.item_id  and a.po_no="'.$data->po_no.'" order by id asc';

$query=db_query($res);

while($datac=mysqli_fetch_object($query)){
?>
      <tr>
        <td><?=$datac->item_name;?></td>
        <td class="right"><?=$datac->qty;?></td>
        <td class="right"><?=$datac->rate_usd;?></td>
        <td class="right"><?=$datac->amount_usd; $tp+=$datac->amount_usd;?></td>
      </tr>
	  <?php 
	  $gr_tot_qty+=$datac->qty;
	  } ?>
      <tr>
        <td><strong>Total Quantity</strong></td>
        <td class="right"><?=number_format($gr_tot_qty,2) ;?></td>
        <td></td>
        <td class="right"> <?=number_format($tp,2) ;?></td>
      </tr>
    </table>

    <div class="remarks">
      <strong>Remarks:</strong>
      <ol>
        <li>960 MT (+/- 10%)</li>
        <li>COUNTRY OF ORIGIN: GREECE/FRANCE/ITALY/UK/PORTUGAL/IRELAND/SPAIN/ESTONIA/ALGERIA/MOROCCO</li>
        <li>10-14 DAYS FREE CONTAINER DETENTION AT FINAL DESTINATION</li>
        <li>LC TO BE ISSUED WITHIN 20 DAYS AFTER CONTRACT DATE</li>
        <li>PORT OF LOADING: ANY PORT OF GREECE/FRANCE/ITALY/UK/PORTUGAL/IRELAND/SPAIN/ESTONIA/ALGERIA/MOROCCO</li>
        <li>PORT OF DISCHARGE: CHITTAGONG/CHATTOGRAM, BANGLADESH</li>
        <li>HS CODE NO. 4707.30.00</li>
        <li>MOISTURE: NOT MORE THAN 12%</li>
        <li>TOLERANCE: +/- 10% TO BE ALLOWED QUANTITY AND AMOUNT</li>
      </ol>
    </div>

    <div class="signatures">
      <div class="sign">
        <div class="line"></div>
        <p>Seller</p>
        <p><strong><?=$vendor_all->vendor_name;?></strong></p>
        <p><?=find_a_field('agent_info','agent_name','agent_id="'.$data->supplier_agent.'"')?></p>
      </div>

      <div class="sign">
        <div class="line"></div>
        <p>Buyer</p>
        <p><strong><?=find_a_field('user_group','group_name','id="'.$data->group_for.'"')?>.</strong></p>
        <p>Authorized Managing Director</p>
      </div>
    </div>

    <footer>
      <?php  echo $vendor_all->vendor_name;?><br>
      COC:<?php  echo $vendor_all->contact_no;?> | Email: <?php  echo $vendor_all->email;?> 
    </footer>
  </div>
</body>
</html>
