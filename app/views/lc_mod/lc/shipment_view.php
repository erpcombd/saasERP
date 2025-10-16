<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$pay_id=$_GET['pay_id'];
$payment_no=$_GET['payment_no'];
  $pay_data = find_all_field('lc_bank_entry','','id='.$pay_id); 
    $shipment_all = find_all_field('lc_bank_payment','','payment_no='.$payment_no); 
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print View</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    /* Hide buttons when printing */
    @media print {
      .no-print {
        display: none;
      }
    }

    body {
      font-size: 14px;
    }

    .table th, .table td {
      vertical-align: middle;
    }

    .header, .footer {
      text-align: center;
      margin-bottom: 20px;
    }

    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="container my-4">
    <!-- Header -->
    <div class="header">
      <h2>Jamuna Paper Mills Ltd</h2>
    
      <h4>Shipment Entry Information</h4>
    </div>

    <!-- Buttons -->
    <div class="mb-3 no-print text-end">
      <button class="btn btn-primary" onclick="window.print()">Print</button>
      <button class="btn btn-secondary" onclick="window.history.back()">Back</button>
    </div>

    <!-- Information Section -->
    <div class="row mb-4">
      <div class="col-md-6">
        <strong>L/C NO:</strong> <?=$pay_data->lc_number;?><br>
        <strong>PI NO:</strong> <?=$pay_data->pi_no?><br>
		   <strong>L/C TYPE::</strong>  <?php echo find_a_field('lc_type','lc_type','id="'.$pay_data->lc_type.'"'); ?><br>
        <strong>BANK L/C NO:</strong> <?=$pay_data->bank_lc_no?><br>
		   <strong>L/C VALUE (USD$):</strong> <?=$pay_data->lc_value?><br>
        <strong>Bill Of Loading:</strong> <?php echo $shipment_all->bill_of_loading;?><br>
		<strong>  Container Wise No.Of PKGS:</strong> <?php echo $shipment_all->container_wise_no_of_pkgs;?><br>
		<strong>Gross Weight:</strong> <?php echo $shipment_all->gross_weight;?><br>
      </div>
      <div class="col-md-6 text-start">
        <strong>Booking No:</strong> <?php echo $shipment_all->booking_no;?><br>
        <strong>Shipping Line:</strong> <?php echo $shipment_all->shipping_line;?><br>
		   <strong>Shipped On Board Date:</strong> <?php echo $shipment_all->shipped_on_board_date;?><br>
        <strong>Container No:</strong> <?php echo $shipment_all->container_no;?><br>
		   <strong>Vessel Name:</strong> <?php echo $shipment_all->vessel_name;?><br>
        <strong>Container Type:</strong> <?php echo $shipment_all->container_type;?><br>
		<strong>Net Weight:</strong> <?php echo $shipment_all->net_weight;?><br>
		<strong>Measurement:</strong> <?php echo $shipment_all->measurement;?><br>
      </div>
    </div>

 
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
